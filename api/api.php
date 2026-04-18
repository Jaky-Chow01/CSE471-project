<?php
// ============================================================
//  BloodLink — Main API  (api/api.php)
//  All AJAX calls from index.html hit this file.
//  Usage: api.php?action=<action_name>
// ============================================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

require_once __DIR__ . '/../config/db.php';

// ── Rate Limiting (simple per-IP, per-minute) ────────────────
function checkRateLimit(): void {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $file = sys_get_temp_dir() . '/bloodlink_rate_' . md5($ip);
    $limit = 120;
    $window = 60;

    $data = ['count' => 0, 'start' => time()];
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true) ?: $data;
    }

    if (time() - $data['start'] > $window) {
        $data = ['count' => 0, 'start' => time()];
    }

    $data['count']++;
    file_put_contents($file, json_encode($data));

    if ($data['count'] > $limit) {
        http_response_code(429);
        echo json_encode(['error' => 'Rate limit exceeded. Try again later.']);
        exit;
    }
}
checkRateLimit();

$action = $_GET['action'] ?? $_POST['action'] ?? '';

$validActions = [
    'get_donors', 'get_donor', 'get_care', 'save_care',
    'register_donor', 'get_requests', 'get_confirmations',
    'get_stats', 'toggle_availability', 'add_request',
    'update_request_status', 'get_analytics'
];

if (!in_array($action, $validActions, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Unknown action']);
    exit;
}

switch ($action) {
    case 'get_donors':          getDonors();          break;
    case 'get_donor':           getDonor();           break;
    case 'get_care':            getCare();            break;
    case 'save_care':           saveCare();           break;
    case 'register_donor':      registerDonor();      break;
    case 'get_requests':        getRequests();        break;
    case 'get_confirmations':   getConfirmations();   break;
    case 'get_stats':           getStats();           break;
    case 'toggle_availability': toggleAvailability(); break;
    case 'add_request':         addRequest();         break;
    case 'update_request_status': updateRequestStatus(); break;
    case 'get_analytics':       getAnalytics();       break;
}

// ============================================================
//  HANDLERS
// ============================================================

function getDonors(): void {
    $db  = getDB();
    $bf  = $_GET['blood_group'] ?? '';
    $lf  = $_GET['location']   ?? '';
    $avl = $_GET['available']  ?? '';
    $page  = max(1, (int)($_GET['page'] ?? 1));
    $limit = min(100, max(1, (int)($_GET['limit'] ?? 50)));
    $offset = ($page - 1) * $limit;

    $sql    = 'SELECT * FROM donors WHERE 1=1';
    $countSql = 'SELECT COUNT(*) FROM donors WHERE 1=1';
    $params = [];

    if ($bf !== '') {
        $compat = compatDonors($bf);
        if ($compat) {
            $placeholders = implode(',', array_fill(0, count($compat), '?'));
            $sql      .= " AND blood_group IN ($placeholders)";
            $countSql .= " AND blood_group IN ($placeholders)";
            $params    = array_merge($params, $compat);
        } else {
            $sql      .= ' AND blood_group = ?';
            $countSql .= ' AND blood_group = ?';
            $params[]  = $bf;
        }
    }

    if ($lf !== '') {
        $sql      .= ' AND location LIKE ?';
        $countSql .= ' AND location LIKE ?';
        $params[]  = '%' . $lf . '%';
    }

    if ($avl === '1') {
        $sql      .= ' AND availability_today = 1';
        $countSql .= ' AND availability_today = 1';
    }

    $countStmt = $db->prepare($countSql);
    $countStmt->execute($params);
    $totalCount = (int) $countStmt->fetchColumn();

    $sql .= ' ORDER BY availability_today DESC, last_donation ASC';
    $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $donors = $stmt->fetchAll();

    foreach ($donors as &$d) {
        $d['days_since_donation'] = $d['last_donation']
            ? (int) floor((time() - strtotime($d['last_donation'])) / 86400)
            : null;
        $d['eligible'] = $d['days_since_donation'] === null
            || $d['days_since_donation'] >= (int) $d['min_wait'];
        $d['availability_today'] = (bool) $d['availability_today'];
        $d['lat'] = (float) $d['lat'];
        $d['lng'] = (float) $d['lng'];
        if ($bf !== '') {
            $d['compat_pct'] = calcCompatPct($d['blood_group'], $bf);
        }
    }
    unset($d);

    echo json_encode([
        'donors' => $donors,
        'pagination' => [
            'page'  => $page,
            'limit' => $limit,
            'total' => $totalCount,
            'pages' => (int) ceil($totalCount / $limit),
        ]
    ]);
}

function getDonor(): void {
    $id = (int) ($_GET['id'] ?? 0);
    if (!$id) { http_response_code(400); echo json_encode(['error' => 'id required']); return; }

    $db   = getDB();
    $stmt = $db->prepare('SELECT * FROM donors WHERE id = ?');
    $stmt->execute([$id]);
    $d = $stmt->fetch();

    if (!$d) { http_response_code(404); echo json_encode(['error' => 'Donor not found']); return; }

    $d['days_since_donation'] = $d['last_donation']
        ? (int) floor((time() - strtotime($d['last_donation'])) / 86400)
        : null;
    $d['eligible'] = $d['days_since_donation'] === null
        || $d['days_since_donation'] >= (int) $d['min_wait'];
    $d['availability_today'] = (bool) $d['availability_today'];
    $d['lat'] = (float) $d['lat'];
    $d['lng'] = (float) $d['lng'];

    echo json_encode(['donor' => $d]);
}

function getCare(): void {
    $id = (int) ($_GET['donor_id'] ?? 0);
    if (!$id) { http_response_code(400); echo json_encode(['error' => 'donor_id required']); return; }

    $db   = getDB();
    $stmt = $db->prepare('SELECT * FROM donor_care WHERE donor_id = ?');
    $stmt->execute([$id]);
    $care = $stmt->fetch();

    echo json_encode(['care' => $care ?: null]);
}

function saveCare(): void {
    $raw = json_decode(file_get_contents('php://input'), true) ?? $_POST;

    $donor_id = (int) ($raw['donor_id'] ?? 0);
    if (!$donor_id) { http_response_code(400); echo json_encode(['error' => 'donor_id required']); return; }

    $db = getDB();
    $chkDonor = $db->prepare('SELECT id FROM donors WHERE id = ?');
    $chkDonor->execute([$donor_id]);
    if (!$chkDonor->fetchColumn()) {
        http_response_code(404);
        echo json_encode(['error' => 'Donor not found']);
        return;
    }

    $fields = ['hydration_start','hydration_end','rest_start','rest_end','nutrition_start','nutrition_end'];
    $data   = [];
    foreach ($fields as $f) {
        $val = $raw[$f] ?? null;
        if (!$val || !preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $val)) {
            http_response_code(400);
            echo json_encode(['error' => "Invalid value for $f"]);
            return;
        }
        $data[$f] = substr($val, 0, 5);
    }

    $chk = $db->prepare('SELECT id FROM donor_care WHERE donor_id = ?');
    $chk->execute([$donor_id]);
    $exists = $chk->fetchColumn();

    if ($exists) {
        $sql = 'UPDATE donor_care SET
                    hydration_start=?, hydration_end=?,
                    rest_start=?, rest_end=?,
                    nutrition_start=?, nutrition_end=?
                WHERE donor_id=?';
        $db->prepare($sql)->execute([
            $data['hydration_start'], $data['hydration_end'],
            $data['rest_start'],      $data['rest_end'],
            $data['nutrition_start'], $data['nutrition_end'],
            $donor_id
        ]);
    } else {
        $sql = 'INSERT INTO donor_care
                    (donor_id, hydration_start, hydration_end, rest_start, rest_end, nutrition_start, nutrition_end)
                VALUES (?,?,?,?,?,?,?)';
        $db->prepare($sql)->execute([
            $donor_id,
            $data['hydration_start'], $data['hydration_end'],
            $data['rest_start'],      $data['rest_end'],
            $data['nutrition_start'], $data['nutrition_end']
        ]);
    }

    echo json_encode(['success' => true, 'donor_id' => $donor_id]);
}

function registerDonor(): void {
    $raw = json_decode(file_get_contents('php://input'), true) ?? $_POST;

    $required = ['name','blood_group','location','lat','lng','phone'];
    foreach ($required as $r) {
        if (empty($raw[$r])) {
            http_response_code(400);
            echo json_encode(['error' => "$r is required"]);
            return;
        }
    }

    $name = trim($raw['name']);
    if (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
        http_response_code(400); echo json_encode(['error' => 'Name must be 2-100 characters']); return;
    }

    $validBlood = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
    if (!in_array($raw['blood_group'], $validBlood, true)) {
        http_response_code(400); echo json_encode(['error' => 'Invalid blood group']); return;
    }

    $lat = (float) $raw['lat'];
    $lng = (float) $raw['lng'];
    if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
        http_response_code(400); echo json_encode(['error' => 'Invalid coordinates']); return;
    }

    $phone = trim($raw['phone']);
    if (strlen($phone) < 5 || strlen($phone) > 20) {
        http_response_code(400); echo json_encode(['error' => 'Invalid phone number']); return;
    }

    $email = trim($raw['email'] ?? '');
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); echo json_encode(['error' => 'Invalid email address']); return;
    }

    $lastDonation = null;
    if (!empty($raw['last_donation'])) {
        $d = DateTime::createFromFormat('Y-m-d', $raw['last_donation']);
        if (!$d || $d->format('Y-m-d') !== $raw['last_donation']) {
            http_response_code(400); echo json_encode(['error' => 'Invalid date format for last_donation']); return;
        }
        if ($d > new DateTime()) {
            http_response_code(400); echo json_encode(['error' => 'Last donation date cannot be in the future']); return;
        }
        $lastDonation = $raw['last_donation'];
    }

    $parts    = array_filter(explode(' ', $name));
    $initials = strtoupper(implode('', array_map(fn($p) => mb_substr($p, 0, 1), array_slice($parts, 0, 2))));
    if (strlen($initials) < 1) $initials = strtoupper(mb_substr($name, 0, 2));

    $db  = getDB();
    $sql = 'INSERT INTO donors (name, initials, blood_group, location, lat, lng, phone, email, last_donation, min_wait, availability_today)
            VALUES (?,?,?,?,?,?,?,?,?,90,1)';

    $db->prepare($sql)->execute([
        $name,
        $initials,
        $raw['blood_group'],
        trim($raw['location']),
        $lat,
        $lng,
        $phone,
        $email,
        $lastDonation
    ]);

    echo json_encode(['success' => true, 'id' => (int) $db->lastInsertId()]);
}

function getConfirmations(): void {
    $db       = getDB();
    $hospital = $_GET['hospital'] ?? '';

    // Always return every donor in the donors table.
    // The hospital filter is kept for future use but does NOT restrict donors —
    // the confirmation queue shows everyone so staff can confirm any donor.
    $sql = "SELECT
                d.id          AS donor_id,
                d.name        AS donor,
                d.initials,
                d.blood_group AS blood,
                d.phone,
                d.location,
                d.availability_today,
                CASE
                    WHEN d.last_donation IS NULL THEN NULL
                    ELSE DATEDIFF(CURDATE(), d.last_donation)
                END AS days_since_donation,
                CASE
                    WHEN d.last_donation IS NULL THEN 1
                    WHEN DATEDIFF(CURDATE(), d.last_donation) >= d.min_wait THEN 1
                    ELSE 0
                END AS eligible,
                COALESCE((
                    SELECT br.hospital
                    FROM blood_requests br
                    WHERE br.blood_group = d.blood_group
                      AND br.status IN ('open','matched')
                    ORDER BY FIELD(br.urgency,'critical','high','low')
                    LIMIT 1
                ), '') AS matched_hospital,
                COALESCE((
                    SELECT br.urgency
                    FROM blood_requests br
                    WHERE br.blood_group = d.blood_group
                      AND br.status IN ('open','matched')
                    ORDER BY FIELD(br.urgency,'critical','high','low')
                    LIMIT 1
                ), '') AS urgency,
                'pending' AS status
            FROM donors d
            ORDER BY
                d.availability_today DESC,
                eligible DESC,
                d.name ASC";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    // Cast numeric/bool fields
    foreach ($rows as &$r) {
        $r['availability_today'] = (bool) $r['availability_today'];
        $r['eligible']          = (bool) $r['eligible'];
        $r['days_since_donation'] = $r['days_since_donation'] !== null ? (int) $r['days_since_donation'] : null;
    }
    unset($r);

    echo json_encode(['confirmations' => $rows]);
}

function getRequests(): void {
    $db       = getDB();
    $hospital = $_GET['hospital'] ?? '';

    $sql    = 'SELECT * FROM blood_requests WHERE 1=1';
    $params = [];

    if ($hospital !== '') {
        $sql    .= ' AND hospital = ?';
        $params[] = $hospital;
    }

    $sql .= ' ORDER BY FIELD(urgency,"critical","high","low"), created_at DESC';

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    echo json_encode(['requests' => $stmt->fetchAll()]);
}

function getStats(): void {
    $db = getDB();

    $total   = $db->query('SELECT COUNT(*) FROM donors')->fetchColumn();
    $avail   = $db->query('SELECT COUNT(*) FROM donors WHERE availability_today=1')->fetchColumn();
    $urgent  = $db->query("SELECT COUNT(*) FROM blood_requests WHERE urgency IN ('critical','high')")->fetchColumn();
    $eligible= $db->query("SELECT COUNT(*) FROM donors WHERE last_donation IS NULL OR DATEDIFF(CURDATE(), last_donation) >= min_wait")->fetchColumn();

    echo json_encode([
        'total_donors'    => (int) $total,
        'available_today' => (int) $avail,
        'urgent_requests' => (int) $urgent,
        'eligible_donors' => (int) $eligible,
    ]);
}

function toggleAvailability(): void {
    $raw = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $id  = (int) ($raw['id'] ?? 0);
    if (!$id) { http_response_code(400); echo json_encode(['error' => 'id required']); return; }

    $db   = getDB();
    $stmt = $db->prepare('UPDATE donors SET availability_today = NOT availability_today WHERE id = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404); echo json_encode(['error' => 'Donor not found']); return;
    }

    $cur = $db->prepare('SELECT availability_today FROM donors WHERE id = ?');
    $cur->execute([$id]);
    echo json_encode(['success' => true, 'availability_today' => (bool) $cur->fetchColumn()]);
}

// ============================================================
//  BLOOD COMPATIBILITY HELPERS
// ============================================================

function compatDonors(string $requested): array {
    $map = [
        'O-'  => ['O-'],
        'O+'  => ['O-','O+'],
        'A-'  => ['A-','O-'],
        'A+'  => ['A+','A-','O+','O-'],
        'B-'  => ['B-','O-'],
        'B+'  => ['B+','B-','O+','O-'],
        'AB-' => ['AB-','A-','B-','O-'],
        'AB+' => ['AB+','AB-','A+','A-','B+','B-','O+','O-'],
    ];
    return $map[$requested] ?? [];
}

function calcCompatPct(string $donorGroup, string $requestedGroup): int {
    $pct = [
        'O-'  => ['O-'=>100,'A-'=>92,'B-'=>92,'AB-'=>85,'O+'=>88,'A+'=>82,'B+'=>82,'AB+'=>78],
        'O+'  => ['O-'=>90,'O+'=>100,'A-'=>75,'A+'=>82,'B-'=>75,'B+'=>82,'AB-'=>68,'AB+'=>78],
        'A-'  => ['A-'=>100,'O-'=>95,'AB-'=>75,'AB+'=>68],
        'A+'  => ['A+'=>100,'A-'=>95,'O+'=>88,'O-'=>92,'AB+'=>72],
        'B-'  => ['B-'=>100,'O-'=>95,'AB-'=>75,'AB+'=>68],
        'B+'  => ['B+'=>100,'B-'=>95,'O+'=>88,'O-'=>92,'AB+'=>72],
        'AB-' => ['AB-'=>100,'A-'=>90,'B-'=>90,'O-'=>95],
        'AB+' => ['AB+'=>100,'AB-'=>95,'A+'=>90,'A-'=>90,'B+'=>90,'B-'=>90,'O+'=>85,'O-'=>90],
    ];
    return $pct[$requestedGroup][$donorGroup] ?? 0;
}

function addRequest(): void {
    $raw = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $required = ['blood_group','hospital','units','urgency'];
    foreach ($required as $r) {
        if (empty($raw[$r])) { http_response_code(400); echo json_encode(['error'=>"$r is required"]); return; }
    }
    $validBlood = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
    if (!in_array($raw['blood_group'], $validBlood, true)) {
        http_response_code(400); echo json_encode(['error'=>'Invalid blood group']); return;
    }
    $validUrgency = ['low','high','critical'];
    if (!in_array($raw['urgency'], $validUrgency, true)) {
        http_response_code(400); echo json_encode(['error'=>'Invalid urgency level']); return;
    }
    $units = (int)$raw['units'];
    if ($units < 1 || $units > 50) {
        http_response_code(400); echo json_encode(['error'=>'Units must be between 1 and 50']); return;
    }
    $hospital = trim($raw['hospital']);
    if (mb_strlen($hospital) < 2 || mb_strlen($hospital) > 150) {
        http_response_code(400); echo json_encode(['error'=>'Invalid hospital name']); return;
    }

    $db = getDB();
    $db->prepare('INSERT INTO blood_requests (blood_group,hospital,units,urgency) VALUES (?,?,?,?)')
       ->execute([$raw['blood_group'], $hospital, $units, $raw['urgency']]);
    echo json_encode(['success'=>true,'id'=>(int)$db->lastInsertId()]);
}

function updateRequestStatus(): void {
    $raw = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $id     = (int)($raw['id'] ?? 0);
    $status = $raw['status'] ?? '';
    $valid  = ['open','matched','fulfilled'];
    if (!$id || !in_array($status, $valid, true)) {
        http_response_code(400); echo json_encode(['error'=>'id and valid status required']); return;
    }
    $db = getDB();
    $stmt = $db->prepare('UPDATE blood_requests SET status=? WHERE id=?');
    $stmt->execute([$status, $id]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404); echo json_encode(['error'=>'Request not found']); return;
    }

    echo json_encode(['success'=>true]);
}

function getAnalytics(): void {
    $db = getDB();
    $demandStmt = $db->query('SELECT blood_group, SUM(units) as total_units, COUNT(*) as total_requests FROM blood_requests GROUP BY blood_group ORDER BY total_units DESC');
    $demand = $demandStmt->fetchAll();
    $total    = (int)$db->query('SELECT COUNT(*) FROM donors')->fetchColumn();
    $avail    = (int)$db->query('SELECT COUNT(*) FROM donors WHERE availability_today=1')->fetchColumn();
    $eligible = (int)$db->query("SELECT COUNT(*) FROM donors WHERE last_donation IS NULL OR DATEDIFF(CURDATE(),last_donation)>=min_wait")->fetchColumn();
    $shortage = $db->query("SELECT DISTINCT br.blood_group FROM blood_requests br WHERE br.urgency='critical' AND NOT EXISTS (SELECT 1 FROM donors d WHERE d.blood_group=br.blood_group AND d.availability_today=1)")->fetchAll(PDO::FETCH_COLUMN);

    $totalReq     = (int)$db->query("SELECT COUNT(*) FROM blood_requests")->fetchColumn();
    $fulfilledReq = (int)$db->query("SELECT COUNT(*) FROM blood_requests WHERE status='fulfilled'")->fetchColumn();
    $fulfilRate   = $totalReq > 0 ? round(($fulfilledReq / $totalReq) * 100) : 0;

    echo json_encode([
        'demand'        => $demand,
        'pool'          => ['total'=>$total,'available'=>$avail,'eligible'=>$eligible,'not_eligible'=>$total-$eligible,'not_available'=>$total-$avail],
        'shortages'     => $shortage,
        'fulfil_rate'   => $fulfilRate . '%',
        'response_time' => 14,
    ]);
}
