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

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {

    // ── GET all donors (with optional filters) ──────────────
    case 'get_donors':
        getDonors();
        break;

    // ── GET single donor by id ───────────────────────────────
    case 'get_donor':
        getDonor();
        break;

    // ── GET care schedule for a donor ───────────────────────
    case 'get_care':
        getCare();
        break;

    // ── POST save / upsert care schedule ────────────────────
    case 'save_care':
        saveCare();
        break;

    // ── POST register a new donor ────────────────────────────
    case 'register_donor':
        registerDonor();
        break;

    // ── GET active blood requests (sidebar) ─────────────────
    case 'get_requests':
        getRequests();
        break;

    // ── GET dashboard stats ──────────────────────────────────
    case 'get_stats':
        getStats();
        break;

    // ── POST toggle availability_today ──────────────────────
    case 'toggle_availability':
        toggleAvailability();
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unknown action: ' . htmlspecialchars($action)]);
}

// ============================================================
//  HANDLERS
// ============================================================

function getDonors(): void {
    $db  = getDB();
    $bf  = $_GET['blood_group'] ?? '';   // blood group filter
    $lf  = $_GET['location']   ?? '';   // location keyword
    $avl = $_GET['available']  ?? '';   // '1' = available only

    $sql    = 'SELECT * FROM donors WHERE 1=1';
    $params = [];

    if ($bf !== '') {
        // Compatible blood groups (who can donate to the requested group)
        $compat = compatDonors($bf);
        if ($compat) {
            $placeholders = implode(',', array_fill(0, count($compat), '?'));
            $sql    .= " AND blood_group IN ($placeholders)";
            $params  = array_merge($params, $compat);
        } else {
            $sql    .= ' AND blood_group = ?';
            $params[] = $bf;
        }
    }

    if ($lf !== '') {
        $sql    .= ' AND location LIKE ?';
        $params[] = '%' . $lf . '%';
    }

    if ($avl === '1') {
        $sql .= ' AND availability_today = 1';
    }

    $sql .= ' ORDER BY availability_today DESC, last_donation ASC';

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $donors = $stmt->fetchAll();

    // Add computed fields
    foreach ($donors as &$d) {
        $d['days_since_donation'] = $d['last_donation']
            ? (int) floor((time() - strtotime($d['last_donation'])) / 86400)
            : null;
        $d['eligible'] = $d['days_since_donation'] !== null
            && $d['days_since_donation'] >= (int) $d['min_wait'];
        $d['availability_today'] = (bool) $d['availability_today'];
        $d['lat'] = (float) $d['lat'];
        $d['lng'] = (float) $d['lng'];
        if ($bf !== '') {
            $d['compat_pct'] = calcCompatPct($d['blood_group'], $bf);
        }
    }
    unset($d);

    echo json_encode(['donors' => $donors]);
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
    $d['eligible'] = $d['days_since_donation'] !== null
        && $d['days_since_donation'] >= (int) $d['min_wait'];
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

    $fields = ['hydration_start','hydration_end','rest_start','rest_end','nutrition_start','nutrition_end'];
    $data   = [];
    foreach ($fields as $f) {
        $val = $raw[$f] ?? null;
        if (!$val || !preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $val)) {
            http_response_code(400);
            echo json_encode(['error' => "Invalid value for $f"]);
            return;
        }
        $data[$f] = substr($val, 0, 5); // store HH:MM
    }

    $db = getDB();

    // Check if row exists
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

    $validBlood = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
    if (!in_array($raw['blood_group'], $validBlood, true)) {
        http_response_code(400); echo json_encode(['error' => 'Invalid blood group']); return;
    }

    // Auto-generate initials from name
    $parts    = explode(' ', trim($raw['name']));
    $initials = strtoupper(implode('', array_map(fn($p) => $p[0], array_slice($parts, 0, 2))));

    $db  = getDB();
    $sql = 'INSERT INTO donors (name, initials, blood_group, location, lat, lng, phone, email, last_donation, min_wait, availability_today)
            VALUES (?,?,?,?,?,?,?,?,?,90,1)';

    $db->prepare($sql)->execute([
        trim($raw['name']),
        $initials,
        $raw['blood_group'],
        trim($raw['location']),
        (float) $raw['lat'],
        (float) $raw['lng'],
        trim($raw['phone']),
        trim($raw['email'] ?? ''),
        !empty($raw['last_donation']) ? $raw['last_donation'] : null
    ]);

    echo json_encode(['success' => true, 'id' => (int) $db->lastInsertId()]);
}

function getRequests(): void {
    $db   = getDB();
    $stmt = $db->query('SELECT * FROM blood_requests ORDER BY FIELD(urgency,"critical","high","low"), created_at DESC');
    echo json_encode(['requests' => $stmt->fetchAll()]);
}

function getStats(): void {
    $db = getDB();

    $total   = $db->query('SELECT COUNT(*) FROM donors')->fetchColumn();
    $avail   = $db->query('SELECT COUNT(*) FROM donors WHERE availability_today=1')->fetchColumn();
    $urgent  = $db->query("SELECT COUNT(*) FROM blood_requests WHERE urgency IN ('critical','high')")->fetchColumn();
    $eligible= $db->query("SELECT COUNT(*) FROM donors WHERE last_donation IS NOT NULL AND DATEDIFF(CURDATE(), last_donation) >= min_wait")->fetchColumn();

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

    $cur = $db->prepare('SELECT availability_today FROM donors WHERE id = ?');
    $cur->execute([$id]);
    echo json_encode(['success' => true, 'availability_today' => (bool) $cur->fetchColumn()]);
}

// ============================================================
//  BLOOD COMPATIBILITY HELPERS
// ============================================================

/**
 * Returns array of blood groups that can donate to $requestedGroup
 */
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

/**
 * Returns compatibility % of a donor blood group for a requested group
 */
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
