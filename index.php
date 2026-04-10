<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BloodLink — Donor Matching System</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=IBM+Plex+Mono:wght@300;400;500&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<?php include 'style.php'; ?>
</head>
<body>
<div class="shell">

<!-- HEADER -->
<header>
  <div class="logo-mark">🩸</div>
  <div class="logo-text">Blood<span>Link</span></div>
  <div class="h-live"><div class="h-dot"></div>LIVE SYSTEM</div>
  <div class="h-urgent" id="header-urgent">
    <div class="h-urgent-badge">⚠ CRITICAL</div>
    <div class="h-urgent-text"><b>O− needed</b> · Square Hospital · 1 unit</div>
  </div>
  <div class="h-right">
    <button class="hbtn hbtn-ghost" onclick="showPage('matching')">Dashboard</button>
    <button class="hbtn hbtn-ghost" onclick="showPage('care')">Care Panel</button>
    <button class="hbtn hbtn-red" onclick="openRegisterModal()">+ Register Donor</button>
  </div>
</header>

<div class="body">

<!-- SIDEBAR -->
<aside>
  <div class="s-section">Main</div>
  <div class="s-item active" id="snav-matching" onclick="showPage('matching')">
    <span class="s-icon">🔍</span> Match Engine <span class="s-badge s-badge-green" id="badge-total">…</span>
  </div>
  <div class="s-item" id="snav-care" onclick="showPage('care')">
    <span class="s-icon">💊</span> Post-Donation Care <span class="s-badge s-badge-red">2</span>
  </div>

  <div class="s-section" style="margin-top:10px">Active Requests</div>
  <div id="sidebar-requests"><div class="loading-cell" style="padding:14px">Loading…</div></div>

  <div class="s-section" style="margin-top:10px">Quick Filter</div>
  <div class="s-item" onclick="quickFilter('O-')"><span class="s-icon">🩸</span> O− Universal Donor</div>
  <div class="s-item" onclick="quickFilter('O+')"><span class="s-icon">🩸</span> O+ Most Common</div>
  <div class="s-item" onclick="quickFilter('AB+')"><span class="s-icon">🩸</span> AB+ Universal Recipient</div>
  <div class="s-item" onclick="quickFilter('')"><span class="s-icon">👁</span> Show All</div>

  <div class="s-footer">
    <div class="s-footer-text">BloodLink v2.0<br>MySQL · PHP 8.1<br>Dhaka Region</div>
  </div>
</aside>

<!-- CONTENT -->
<div class="content">

<?php include 'module1.php'; ?>
<?php include 'module2.php'; ?>

</div>
</div>
</div>

<!-- REGISTER DONOR MODAL -->
<div class="modal-overlay" id="register-modal">
  <div class="modal">
    <div class="modal-title">Register New Donor</div>
    <div class="modal-sub">All fields marked * are required. Data saved to MySQL.</div>
    <div id="register-status" class="status-bar"></div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Full Name *</label>
        <input type="text" id="reg-name" placeholder="e.g. Arif Hossain">
      </div>
      <div class="form-group">
        <label class="form-label">Blood Group *</label>
        <select id="reg-blood">
          <option value="">Select…</option>
          <option>A+</option><option>A-</option>
          <option>B+</option><option>B-</option>
          <option>AB+</option><option>AB-</option>
          <option>O+</option><option>O-</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Location / Address *</label>
      <input type="text" id="reg-location" placeholder="e.g. 124/ABC Road, Dhaka">
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Latitude *</label>
        <input type="text" id="reg-lat" placeholder="e.g. 23.8103">
      </div>
      <div class="form-group">
        <label class="form-label">Longitude *</label>
        <input type="text" id="reg-lng" placeholder="e.g. 90.4125">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Phone *</label>
        <input type="tel" id="reg-phone" placeholder="01711-XXXXXX">
      </div>
      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" id="reg-email" placeholder="optional">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Last Donation Date</label>
      <input type="date" id="reg-last-donation">
    </div>

    <div class="modal-actions">
      <button class="btn btn-ghost" onclick="closeRegisterModal()">Cancel</button>
      <button class="btn btn-red" onclick="submitRegister()">Register Donor</button>
    </div>
  </div>
</div>

<!-- CARE NOTIFICATION POPUP -->
<div id="notif-overlay" style="
  display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);
  z-index:2000;align-items:center;justify-content:center;">
  <div style="
    background:#131318;border:1px solid #383848;border-radius:14px;
    padding:32px 36px;width:380px;text-align:center;position:relative;
    box-shadow:0 0 60px rgba(196,18,48,.25);">

 
    <div id="notif-icon" style="font-size:52px;margin-bottom:12px;animation:notif-pulse 1s ease-in-out infinite">💧</div>

    <div id="notif-title" style="
      font-family:'Barlow Condensed',sans-serif;font-size:26px;font-weight:800;
      color:#ff3355;letter-spacing:.4px;margin-bottom:8px">Notification</div>


    <div id="notif-msg" style="
      font-size:13px;color:#8888a8;font-family:'IBM Plex Mono',monospace;
      line-height:1.7;margin-bottom:24px"></div>

    
    <div id="notif-donor" style="
      display:inline-block;padding:4px 14px;border-radius:20px;
      background:rgba(196,18,48,.12);border:1px solid rgba(196,18,48,.3);
      color:#ff3355;font-size:11px;font-family:'IBM Plex Mono',monospace;
      margin-bottom:24px;font-weight:700"></div>


    <div id="notif-time" style="
      font-size:10px;color:#44445a;font-family:'IBM Plex Mono',monospace;
      margin-bottom:20px"></div>


    <button onclick="closeNotifPopup()" style="
      width:100%;padding:12px;border-radius:8px;border:none;
      background:#c41230;color:#fff;font-family:'Barlow Condensed',sans-serif;
      font-size:17px;font-weight:800;letter-spacing:.5px;cursor:pointer;
      transition:background .15s"
      onmouseover="this.style.background='#e01535'"
      onmouseout="this.style.background='#c41230'">
      ✓ Dismiss
    </button>
  </div>
</div>

<style>
@keyframes notif-pulse {
  0%,100% { transform: scale(1); }
  50%      { transform: scale(1.18); }
}
</style>

<script>
// ── CONFIG ─
const API = 'api/api.php';
const HOSP = {lat:23.7223, lng:90.3978, name:'Dhaka Medical College'};

// ── STATE ──
let DONORS = [];
let currentFilter = '';
let selectedCareId = null;
let donorMap = null;

// ── FALLBACK SEED DATA 
function makeDateStr(daysAgo) {
  const d = new Date(); d.setDate(d.getDate() - daysAgo);
  return d.toISOString().slice(0, 10);
}
const SEED_DONORS = [
  {id:1,name:'Arif Hossain',  initials:'AH',blood_group:'A-', location:'124/ABC Road, Dhaka',        lat:23.8103,lng:90.4125,phone:'01711-000001',email:'arif@gmail.com',   last_donation:makeDateStr(98), min_wait:90,availability_today:true,  days_since_donation:98, eligible:true },
  {id:2,name:'Bashir Ahmed',  initials:'BA',blood_group:'AB+',location:'44/ABC Lane, Old Dhaka',      lat:23.7500,lng:90.3750,phone:'01711-000002',email:'bashir@gmail.com', last_donation:makeDateStr(120),min_wait:90,availability_today:true,  days_since_donation:120,eligible:true },
  {id:3,name:'Chandra Mitra', initials:'CM',blood_group:'O-', location:'65/ABC Street, Wari, Dhaka',  lat:23.8200,lng:90.4000,phone:'01711-000003',email:'chandra@gmail.com',last_donation:makeDateStr(60), min_wait:90,availability_today:false, days_since_donation:60, eligible:false},
  {id:4,name:'Delwar Islam',  initials:'DI',blood_group:'B+', location:'12/XYZ Colony, Dhaka',        lat:23.7800,lng:90.4200,phone:'01711-000004',email:'delwar@gmail.com', last_donation:makeDateStr(200),min_wait:90,availability_today:true,  days_since_donation:200,eligible:true },
  {id:5,name:'Ema Sultana',   initials:'ES',blood_group:'O+', location:'88/Mirpur Road, Dhaka',       lat:23.8000,lng:90.3600,phone:'01711-000005',email:'ema@gmail.com',    last_donation:makeDateStr(150),min_wait:90,availability_today:true,  days_since_donation:150,eligible:true },
  {id:6,name:'Farhan Rahman', initials:'FR',blood_group:'A+', location:'Gulshan Avenue, Dhaka',       lat:23.7936,lng:90.4148,phone:'01712-345678',email:'farhan@email.com', last_donation:makeDateStr(45), min_wait:90,availability_today:false, days_since_donation:45, eligible:false},
  {id:7,name:'Rida Khanom',   initials:'RK',blood_group:'B-', location:'Dhanmondi Road 27, Dhaka',    lat:23.7461,lng:90.3742,phone:'01719-876543',email:'rida@email.com',   last_donation:makeDateStr(97), min_wait:90,availability_today:true,  days_since_donation:97, eligible:true },
];
const SEED_STATS = {total_donors:7, available_today:5, urgent_requests:2, eligible_donors:5};
const SEED_REQUESTS = [
  {blood_group:'A-',  hospital:'Dhaka Medical College', units:2, urgency:'high'},
  {blood_group:'O-',  hospital:'Square Hospital',       units:1, urgency:'critical'},
  {blood_group:'AB+', hospital:'BIRDEM General Hospital',units:1,urgency:'high'},
];
const SEED_CARE = {
  1:{hydration_start:'08:00',hydration_end:'20:00',rest_start:'09:00',rest_end:'17:00',nutrition_start:'07:00',nutrition_end:'21:00'},
  2:{hydration_start:'07:00',hydration_end:'19:00',rest_start:'08:00',rest_end:'18:00',nutrition_start:'06:00',nutrition_end:'20:00'},
};

// ── SAFE FETCH
async function safeFetch(url, options) {
  try {
    const res = await fetch(url, options);
    if (!res.ok) return null;
    const data = await res.json();
    if (data && data.error) return null;
    return data;
  } catch (e) {
    return null;
  }
}

// ── BLOOD COMPAT 
const COMPAT_PCT = {
  'O-' : {'O-':100,'A-':92,'B-':92,'AB-':85,'O+':88,'A+':82,'B+':82,'AB+':78},
  'O+' : {'O-':90,'O+':100,'A-':75,'A+':82,'B-':75,'B+':82,'AB-':68,'AB+':78},
  'A-' : {'A-':100,'O-':95,'AB-':75,'AB+':68},
  'A+' : {'A+':100,'A-':95,'O+':88,'O-':92,'AB+':72},
  'B-' : {'B-':100,'O-':95,'AB-':75,'AB+':68},
  'B+' : {'B+':100,'B-':95,'O+':88,'O-':92,'AB+':72},
  'AB-': {'AB-':100,'A-':90,'B-':90,'O-':95},
  'AB+': {'AB+':100,'AB-':95,'A+':90,'A-':90,'B+':90,'B-':90,'O+':85,'O-':90},
};
function calcCompat(donorBlood, reqBlood) {
  if (!reqBlood) return null;
  return (COMPAT_PCT[reqBlood]||{})[donorBlood] || 0;
}
function calcDist(lat1,lng1,lat2,lng2){
  const R=6371,dLat=(lat2-lat1)*Math.PI/180,dLng=(lng2-lng1)*Math.PI/180;
  const a=Math.sin(dLat/2)**2+Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLng/2)**2;
  return(R*2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a))).toFixed(1);
}

// ── PAGE NAV 
function showPage(name) {
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.s-item[id^="snav-"]').forEach(s=>s.classList.remove('active'));
  document.getElementById('page-'+name).classList.add('active');
  const sn = document.getElementById('snav-'+name);
  if (sn) sn.classList.add('active');
  if (name === 'care') renderCareDonorList();
}

// ── LOAD STATS 
async function loadStats() {
  const data = (await safeFetch(`${API}?action=get_stats`)) || SEED_STATS;
  document.getElementById('stat-total').textContent    = data.total_donors;
  document.getElementById('stat-avail').textContent    = data.available_today;
  document.getElementById('stat-urgent').textContent   = data.urgent_requests;
  document.getElementById('stat-eligible').textContent = data.eligible_donors;
  document.getElementById('badge-total').textContent   = data.total_donors;
  const pct = data.total_donors ? Math.round((data.available_today/data.total_donors)*100) : 0;
  document.getElementById('stat-avail-pct').textContent = pct + '% rate';
  document.getElementById('match-sub').textContent =
    `${data.total_donors} donors registered · Dhaka region · real-time compatibility analysis`;
}

// ── LOAD REQUESTS 
async function loadRequests() {
  const data = (await safeFetch(`${API}?action=get_requests`)) || {requests: SEED_REQUESTS};
  const container = document.getElementById('sidebar-requests');
  if (!data.requests || !data.requests.length) { container.innerHTML = '<div class="loading-cell" style="padding:14px">No active requests</div>'; return; }
  container.innerHTML = data.requests.map(r => `
    <div class="s-request" onclick="quickFilter('${r.blood_group}')">
      <div class="s-req-head">
        <div class="s-req-blood">${r.blood_group.replace('-','−')}</div>
        <div class="s-req-urg ${r.urgency==='critical'?'urg-crit':'urg-high'}">${r.urgency.toUpperCase()}</div>
      </div>
      <div class="s-req-hosp">${r.hospital}</div>
      <div class="s-req-units">${r.units} unit${r.units>1?'s':''} needed</div>
    </div>
  `).join('');
}

// ── TABLE 
async function renderTable() {
  const bf = document.getElementById('blood-filter').value;
  const lf = document.getElementById('loc-filter').value;
  currentFilter = bf;

  document.getElementById('donors-tbody').innerHTML = '<tr><td colspan="9" class="loading-cell">Fetching from database…</td></tr>';

  const params = new URLSearchParams({action:'get_donors'});
  if (bf) params.set('blood_group', bf);
  if (lf) params.set('location', lf);

  const data = await safeFetch(`${API}?${params}`);

  if (data) {
    DONORS = data.donors || [];
  } else {
    const COMPAT_DONORS = {
      'O-':['O-'],'O+':['O-','O+'],'A-':['A-','O-'],'A+':['A+','A-','O+','O-'],
      'B-':['B-','O-'],'B+':['B+','B-','O+','O-'],'AB-':['AB-','A-','B-','O-'],
      'AB+':['AB+','AB-','A+','A-','B+','B-','O+','O-'],
    };
    DONORS = SEED_DONORS.filter(d => {
      const bm = !bf || (COMPAT_DONORS[bf]||[bf]).includes(d.blood_group);
      const lm = !lf || d.location.toLowerCase().includes(lf.toLowerCase());
      return bm && lm;
    });
    if (bf) DONORS = DONORS.map(d => ({...d, compat_pct: calcCompat(d.blood_group, bf)}));
  }

  document.getElementById('result-count').textContent = `${DONORS.length} donor${DONORS.length!==1?'s':''} found`;

  const tbody = document.getElementById('donors-tbody');
  if (!DONORS.length) { tbody.innerHTML = '<tr><td colspan="9" class="loading-cell">No donors match this filter.</td></tr>'; return; }

  tbody.innerHTML = DONORS.map((d, i) => {
    const ds   = d.days_since_donation;
    const compat = bf ? (d.compat_pct !== undefined ? d.compat_pct : calcCompat(d.blood_group, bf)) : null;
    const dist = calcDist(HOSP.lat, HOSP.lng, d.lat, d.lng);

    let chip = '';
    if (ds === null) chip = `<span class="days-chip days-warn">Unknown</span>`;
    else if (!d.eligible) chip = `<span class="days-chip days-bad">${ds}d — wait ${d.min_wait - ds}d</span>`;
    else chip = `<span class="days-chip days-ok">${ds} days ago</span>`;

    const bar = compat !== null
      ? `<div class="compat-cell"><div class="compat-bar-bg"><div class="compat-bar-fill" style="width:${compat}%"></div></div><span class="compat-pct">${compat}%</span></div>`
      : `<span style="color:var(--text3);font-size:11px;font-family:'IBM Plex Mono',monospace">Click to filter</span>`;

    const isUniv = d.blood_group === 'O-';
    return `<tr onclick="openProfile(${d.id})">
      <td class="no-cell">${String(i+1).padStart(2,'0')}</td>
      <td class="name-cell">${d.name}<small>${d.email||''}</small></td>
      <td><span class="blood-tag${isUniv?' universal':''}">${d.blood_group.replace('-','−')}</span></td>
      <td style="font-size:12px;color:var(--text2)">${d.location}</td>
      <td>${chip}</td>
      <td style="font-size:12px">${d.eligible
        ?`<span style="color:var(--green-hi)">✓ Eligible</span>`
        :`<span style="color:var(--red-text)">✗ Not eligible</span>`}</td>
      <td>${bar}</td>
      <td style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:var(--text3)">${dist} km</td>
      <td><div class="avail ${d.availability_today?'avail-yes':'avail-no'}"><div class="avail-dot"></div>${d.availability_today?'Yes':'No'}</div></td>
    </tr>`;
  }).join('');
}

function quickFilter(blood) {
  document.getElementById('blood-filter').value = blood;
  document.getElementById('loc-filter').value   = '';
  showPage('matching');
  renderTable();
}
function resetFilters() {
  document.getElementById('blood-filter').value = '';
  document.getElementById('loc-filter').value   = '';
  renderTable();
}

// ── PROFILE 
async function openProfile(id) {
  showPage('profile');

  let d = DONORS.find(x => x.id === id) || null;

  const apiData = await safeFetch(`${API}?action=get_donor&id=${id}`);
  if (apiData && apiData.donor) {
    d = apiData.donor;
  } else if (!d) {
    d = SEED_DONORS.find(x => x.id === id) || null;
  }
  if (!d) return;

  if (!DONORS.find(x=>x.id===id)) DONORS.push(d);

  document.getElementById('pf-avatar').textContent  = d.initials;
  document.getElementById('pf-name').textContent    = d.name;
  const isUniv = d.blood_group === 'O-', isRecip = d.blood_group === 'AB+';
  document.getElementById('pf-type').textContent    = isUniv ? 'Universal Donor' : isRecip ? 'Universal Recipient' : 'Standard Donor';
  document.getElementById('pf-blood-big').textContent = d.blood_group.replace('-','−');
  document.getElementById('pf-blood-label').innerHTML = `Blood Group<br><span style="color:var(--text);font-weight:700">${isUniv?'Donates to ALL types':isRecip?'Receives from ALL types':'Type-specific matching'}</span>`;
  document.getElementById('pf-location').textContent = d.location;
  document.getElementById('pf-phone').textContent    = d.phone;
  document.getElementById('pf-email').textContent    = d.email || '—';
  const ds = d.days_since_donation;
  document.getElementById('pf-lastdon').textContent  = (d.last_donation||'Unknown') + (ds!==null ? ` (${ds} days ago)` : '');
  document.getElementById('pf-wait').textContent     = `${d.min_wait} days`;
  document.getElementById('pf-eligible').innerHTML   = d.eligible
    ? `<span style="color:var(--green-hi)">✓ Eligible to donate now</span>`
    : `<span style="color:var(--red-text)">✗ Must wait ${(d.min_wait-(ds||0))} more days</span>`;
  document.getElementById('pf-coords').textContent   = `LAT ${d.lat}° / LNG ${d.lng}°`;

  const pct = currentFilter ? (calcCompat(d.blood_group, currentFilter) || (isUniv?100:60)) : (isUniv?100:isRecip?95:70);
  const circ = 163.36;
  document.getElementById('pf-ring-arc').style.strokeDashoffset = circ - (pct/100)*circ;
  document.getElementById('pf-compat-pct').textContent  = pct + '%';
  document.getElementById('pf-compat-title').textContent = currentFilter ? 'Match Compatibility' : 'Est. Compatibility';
  document.getElementById('pf-compat-sub').textContent   = currentFilter ? `vs ${currentFilter} blood request` : 'Set blood filter for exact match';

  document.getElementById('pf-contact-btn').textContent = `📞 Contact — ${d.phone}`;

  const dEl = document.getElementById('pf-days-since');
  dEl.textContent = ds !== null ? ds : 'N/A';
  dEl.style.color = ds===null?'var(--text3)':d.eligible?'var(--green-hi)':'var(--red-text)';
  const aEl = document.getElementById('pf-avail-stat');
  aEl.textContent = d.availability_today ? 'YES' : 'NO';
  aEl.style.color = d.availability_today ? 'var(--green-hi)' : 'var(--red-text)';
  document.getElementById('pf-dist-stat').textContent = calcDist(HOSP.lat,HOSP.lng,d.lat,d.lng) + ' km';

  document.getElementById('map-label-name').textContent   = d.name + ' — ' + d.blood_group;
  document.getElementById('map-label-coords').textContent = `${d.lat}°N, ${d.lng}°E`;

  setTimeout(() => initMap(d), 80);
}

function initMap(donor) {
  if (donorMap) { donorMap.remove(); donorMap = null; }
  donorMap = L.map('donor-map',{zoomControl:true}).setView([donor.lat, donor.lng], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap',maxZoom:19}).addTo(donorMap);

  const donorIcon = L.divIcon({html:`<div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#c41230,#ff3355);border:3px solid #fff;display:flex;align-items:center;justify-content:center;font-family:'Barlow Condensed',sans-serif;font-size:14px;font-weight:800;color:#fff;box-shadow:0 4px 20px rgba(196,18,48,.7)">${donor.initials}</div>`,iconSize:[44,44],iconAnchor:[22,22],className:''});
  const hospIcon  = L.divIcon({html:`<div style="width:38px;height:38px;border-radius:7px;background:#1a4dc4;border:2px solid #fff;display:flex;align-items:center;justify-content:center;font-size:20px;box-shadow:0 4px 14px rgba(26,77,196,.6)">🏥</div>`,iconSize:[38,38],iconAnchor:[19,19],className:''});

  L.marker([donor.lat,donor.lng],{icon:donorIcon}).addTo(donorMap)
    .bindPopup(`<div class="popup-name">${donor.name}</div><div class="popup-blood">${donor.blood_group.replace('-','−')}</div><div class="popup-detail">📍 ${donor.location}<br>📞 ${donor.phone}</div><div class="${donor.availability_today?'popup-avail-yes':'popup-avail-no'}">${donor.availability_today?'✓ Available today':'✗ Not available'}</div>`,{maxWidth:240}).openPopup();

  L.marker([HOSP.lat,HOSP.lng],{icon:hospIcon}).addTo(donorMap)
    .bindPopup(`<div class="popup-name">🏥 Dhaka Medical College</div><div class="popup-detail">Active blood request venue</div>`);

  L.polyline([[donor.lat,donor.lng],[HOSP.lat,HOSP.lng]],{color:'rgba(196,18,48,.45)',weight:2,dashArray:'8,6'}).addTo(donorMap);

  const smallIcon = d => L.divIcon({html:`<div style="width:28px;height:28px;border-radius:50%;background:#21212c;border:2px solid #383848;display:flex;align-items:center;justify-content:center;font-family:'Barlow Condensed',sans-serif;font-size:10px;font-weight:700;color:#8888a8">${d.blood_group.replace('+','').replace('-','')}</div>`,iconSize:[28,28],iconAnchor:[14,14],className:''});
  DONORS.filter(od=>od.id!==donor.id).forEach(od=>{
    L.marker([od.lat,od.lng],{icon:smallIcon(od),opacity:0.75}).addTo(donorMap)
      .bindPopup(`<div class="popup-name">${od.name}</div><div class="popup-blood">${od.blood_group.replace('-','−')}</div><div class="popup-detail">📍 ${od.location}<br>📞 ${od.phone}</div>`,{maxWidth:200});
  });

  const allPoints = DONORS.map(d=>[d.lat,d.lng]).concat([[HOSP.lat,HOSP.lng]]);
  donorMap.fitBounds(allPoints, {padding:[40,40]});
}

// ── CARE PANEL 
function renderCareDonorList() {
  const list = document.getElementById('care-donor-list');
  if (!DONORS.length) { list.innerHTML = '<div class="loading-cell">Load donors first</div>'; return; }
  list.innerHTML = DONORS.map(d => `
    <div class="cdp-item ${selectedCareId===d.id?'active':''}" onclick="selectCareDonor(${d.id})">
      <div class="cdp-av">${d.initials}</div>
      <div><div class="cdp-name">${d.name}</div><div class="cdp-blood">${d.blood_group}</div></div>
    </div>
  `).join('');
}

async function selectCareDonor(id) {
  selectedCareId = id;
  renderCareDonorList();

  const careData = await safeFetch(`${API}?action=get_care&donor_id=${id}`);
  const care = (careData && careData.care) ? careData.care : (SEED_CARE[id] || null);
  if (care) {
    document.getElementById('hyd-start').value  = care.hydration_start || '08:00';
    document.getElementById('hyd-end').value    = care.hydration_end   || '20:00';
    document.getElementById('rest-start').value = care.rest_start      || '09:00';
    document.getElementById('rest-end').value   = care.rest_end        || '17:00';
    document.getElementById('nut-start').value  = care.nutrition_start || '07:00';
    document.getElementById('nut-end').value    = care.nutrition_end   || '21:00';
  }

  const donor = DONORS.find(d=>d.id===id);
  const ds = donor?.days_since_donation;
  document.getElementById('rec-donor-name').textContent = donor?.name || '—';
  document.getElementById('rec-since').textContent = ds!==null ? `${ds} days since donation` : 'Donation date unknown';
  const recPct = Math.min(100, Math.round(((ds||0)/42)*100));
  document.getElementById('rec-bar').style.width  = recPct + '%';
  document.getElementById('rec-pct').textContent  = recPct + '%';
  document.getElementById('rec-ring').style.strokeDashoffset = 131.95 - (recPct/100)*131.95;
  document.getElementById('rec-label').textContent = recPct>=100 ? 'Fully recovered' : `${recPct}% recovered (6-week cycle)`;
  updateRings();
}

async function saveCare() {
  if (!selectedCareId) { showCareStatus('Please select a donor first.','err'); return; }
  const payload = {
    donor_id: selectedCareId,
    hydration_start: document.getElementById('hyd-start').value,
    hydration_end:   document.getElementById('hyd-end').value,
    rest_start:      document.getElementById('rest-start').value,
    rest_end:        document.getElementById('rest-end').value,
    nutrition_start: document.getElementById('nut-start').value,
    nutrition_end:   document.getElementById('nut-end').value,
  };
  const data = await safeFetch(`${API}?action=save_care`, {method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
  const name = DONORS.find(d=>d.id===selectedCareId)?.name || SEED_DONORS.find(d=>d.id===selectedCareId)?.name || 'Donor';
  if (data && data.success) {
    showCareStatus(`✓ Care schedule saved for ${name} to database.`, 'ok');
  } else {
    SEED_CARE[selectedCareId] = {
      hydration_start: payload.hydration_start, hydration_end: payload.hydration_end,
      rest_start: payload.rest_start, rest_end: payload.rest_end,
      nutrition_start: payload.nutrition_start, nutrition_end: payload.nutrition_end,
    };
    showCareStatus(`✓ Care schedule saved for ${name} (offline mode — DB not connected).`, 'ok');
  }
}

function showCareStatus(msg, type) {
  const el = document.getElementById('care-status');
  el.textContent = msg; el.className = 'status-bar ' + (type==='ok'?'status-ok':'status-err');
  setTimeout(() => { el.className = 'status-bar'; }, 3500);
}
function resetCareCard(p,s,e){ document.getElementById(p+'-start').value=s; document.getElementById(p+'-end').value=e; }
function resetAllCare(){ resetCareCard('hyd','08:00','20:00'); resetCareCard('rest','09:00','17:00'); resetCareCard('nut','07:00','21:00'); }

function timeMins(t){const[h,m]=(t||'00:00').split(':').map(Number);return h*60+m;}

// ── NOTIFICATION POPUP + SOUND ───────────────────────────────
const _notifFired = { hyd: false, rest: false, nut: false };

function playAlertSound() {
  const ctx = new (window.AudioContext || window.webkitAudioContext)();

  function beep(freq, start, dur, vol = 0.4) {
    const osc  = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.connect(gain);
    gain.connect(ctx.destination);
    osc.type = 'sine';
    osc.frequency.setValueAtTime(freq, ctx.currentTime + start);
    gain.gain.setValueAtTime(vol, ctx.currentTime + start);
    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + start + dur);
    osc.start(ctx.currentTime + start);
    osc.stop(ctx.currentTime + start + dur + 0.05);
  }


  beep(520, 0.0,  0.18);
  beep(660, 0.22, 0.18);
  beep(800, 0.44, 0.35);
}

function openNotifPopup(icon, title, msg) {
  const donorName = document.querySelector('.cdp-item.active .cdp-name')?.textContent || 'Selected Donor';
  document.getElementById('notif-icon').textContent  = icon;
  document.getElementById('notif-title').textContent = title;
  document.getElementById('notif-msg').textContent   = msg;
  document.getElementById('notif-donor').textContent = '👤 ' + donorName;
  document.getElementById('notif-time').textContent  = 'Triggered at ' + new Date().toLocaleTimeString('en-GB');
  document.getElementById('notif-overlay').style.display = 'flex';
  playAlertSound();
}

function closeNotifPopup() {
  document.getElementById('notif-overlay').style.display = 'none';
}

// ── RINGS 
function timeMins(t){ const [h,m] = (t||'00:00').split(':').map(Number); return h*60+m; }

function updateRings() {
  const now  = new Date();
  const nowM = now.getHours() * 60 + now.getMinutes();
  const C    = 131.95;

  const rings = [
    { sId:'hyd-start',  eId:'hyd-end',  rId:'hyd-ring',  pId:'hyd-pct',  key:'hyd',
      icon:'💧', title:'Hydration Complete!',
      msg:'Great job staying hydrated today.\nAvoid alcohol for the next 24 hours post-donation.' },
    { sId:'rest-start', eId:'rest-end', rId:'rest-ring', pId:'rest-pct', key:'rest',
      icon:'🛌', title:'Rest Period Done!',
      msg:'Your rest window has ended.\nYou can now gradually resume light activity.' },
    { sId:'nut-start',  eId:'nut-end',  rId:'nut-ring',  pId:'nut-pct',  key:'nut',
      icon:'🥗', title:'Nutrition Window Closed!',
      msg:'Well done! Your iron and nutrients are replenishing.\nKeep eating iron-rich foods today.' },
  ];

  rings.forEach(({ sId, eId, rId, pId, key, icon, title, msg }) => {
    const s     = timeMins(document.getElementById(sId).value);
    const e     = timeMins(document.getElementById(eId).value);
    const total = e - s;
    const elapsed = Math.max(0, Math.min(nowM - s, total));
    const pct   = total > 0 ? Math.round((elapsed / total) * 100) : 0;

    document.getElementById(rId).style.strokeDashoffset = C - (pct / 100) * C;
    document.getElementById(pId).textContent = pct + '%';

    if (pct >= 100 && !_notifFired[key]) {
      _notifFired[key] = true;
      openNotifPopup(icon, title, msg);
    }
    if (pct < 100) {
      _notifFired[key] = false; 
    }
  });
}

function updateClocks() {
  const ts = new Date().toLocaleTimeString('en-GB');
  ['hyd-clock','rest-clock','nut-clock','rec-clock'].forEach(id => {
    const el = document.getElementById(id); if (el) el.textContent = ts;
  });
  updateRings();
}

// ── REGISTER MODAL 
function openRegisterModal()  { document.getElementById('register-modal').classList.add('open'); }
function closeRegisterModal() { document.getElementById('register-modal').classList.remove('open'); }

async function submitRegister() {
  const payload = {
    name:          document.getElementById('reg-name').value.trim(),
    blood_group:   document.getElementById('reg-blood').value,
    location:      document.getElementById('reg-location').value.trim(),
    lat:           document.getElementById('reg-lat').value.trim(),
    lng:           document.getElementById('reg-lng').value.trim(),
    phone:         document.getElementById('reg-phone').value.trim(),
    email:         document.getElementById('reg-email').value.trim(),
    last_donation: document.getElementById('reg-last-donation').value,
  };
  if (!payload.name || !payload.blood_group || !payload.location || !payload.lat || !payload.lng || !payload.phone) {
    document.getElementById('register-status').textContent = 'Please fill all required fields.';
    document.getElementById('register-status').className   = 'status-bar status-err';
    return;
  }
  const data = await safeFetch(`${API}?action=register_donor`, {method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
  if (data && data.success) {
    document.getElementById('register-status').textContent = `✓ Donor registered! ID #${data.id}`;
    document.getElementById('register-status').className   = 'status-bar status-ok';
    setTimeout(() => { closeRegisterModal(); renderTable(); loadStats(); }, 1500);
  } else if (data && data.error) {
    document.getElementById('register-status').textContent = 'Error: ' + data.error;
    document.getElementById('register-status').className   = 'status-bar status-err';
  } else {
    const newId = Math.max(...SEED_DONORS.map(d=>d.id)) + 1;
    const parts = payload.name.trim().split(' ');
    const initials = parts.slice(0,2).map(p=>p[0]).join('').toUpperCase();
    SEED_DONORS.push({
      id: newId, name: payload.name, initials, blood_group: payload.blood_group,
      location: payload.location, lat: parseFloat(payload.lat), lng: parseFloat(payload.lng),
      phone: payload.phone, email: payload.email, last_donation: payload.last_donation||null,
      min_wait: 90, availability_today: true,
      days_since_donation: payload.last_donation ? Math.floor((Date.now()-new Date(payload.last_donation))/86400000) : null,
      eligible: payload.last_donation ? Math.floor((Date.now()-new Date(payload.last_donation))/86400000) >= 90 : false,
    });
    document.getElementById('register-status').textContent = `✓ Donor added (offline mode — DB not connected). ID #${newId}`;
    document.getElementById('register-status').className   = 'status-bar status-ok';
    setTimeout(() => { closeRegisterModal(); renderTable(); loadStats(); }, 1500);
  }
}

// ── INIT 
document.addEventListener('DOMContentLoaded', async () => {
  await Promise.all([loadStats(), loadRequests()]);
  await renderTable();
  setInterval(updateClocks, 1000);
  updateClocks();
});
</script>
</body>
</html>
