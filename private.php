<?php
// index.php — BloodLink front-end served by PHP
// All data is loaded via fetch() calls to api/api.php
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
<style>
:root{
  --bg:#0c0c0f;--bg2:#131318;--bg3:#1a1a22;--bg4:#21212c;
  --border:#252530;--border-hi:#383848;
  --red:#c41230;--red-hi:#e01535;--red-glow:rgba(196,18,48,.18);--red-text:#ff3355;
  --amber:#d4830a;--amber-hi:#f09a1a;
  --green:#15a86a;--green-hi:#1dd480;--blue:#1a7dc4;
  --text:#e8e8f0;--text2:#8888a8;--text3:#44445a;
  --sidebar:220px;--header:52px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;background:var(--bg);color:var(--text);font-family:'Barlow',sans-serif;overflow:hidden}
::-webkit-scrollbar{width:3px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:var(--border-hi);border-radius:2px}
.shell{display:grid;grid-template-rows:var(--header) 1fr;height:100vh}
header{display:flex;align-items:center;padding:0 20px;gap:14px;background:var(--bg2);border-bottom:1px solid var(--border);z-index:200}
.logo-mark{width:28px;height:28px;background:var(--red);border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:16px}
.logo-text{font-family:'Barlow Condensed',sans-serif;font-size:19px;font-weight:800;letter-spacing:.5px}
.logo-text span{color:var(--red-text)}
.h-live{display:flex;align-items:center;gap:5px;font-family:'IBM Plex Mono',monospace;font-size:10px;color:var(--text3);margin-left:14px}
.h-dot{width:5px;height:5px;border-radius:50%;background:var(--green-hi);animation:blink 2s ease-in-out infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}
.h-urgent{margin-left:16px;display:flex;align-items:center;gap:8px;background:rgba(196,18,48,.08);border:1px solid rgba(196,18,48,.25);padding:4px 12px;border-radius:4px}
.h-urgent-badge{font-size:9px;font-weight:800;letter-spacing:1px;color:var(--red-text);font-family:'Barlow Condensed',sans-serif}
.h-urgent-text{font-size:11px;color:var(--text2)}
.h-urgent-text b{color:var(--text)}
.h-right{margin-left:auto;display:flex;align-items:center;gap:8px}
.hbtn{padding:6px 14px;border-radius:5px;font-family:'Barlow',sans-serif;font-size:12px;font-weight:600;cursor:pointer;border:none;transition:all .15s}
.hbtn-ghost{background:transparent;border:1px solid var(--border);color:var(--text2)}
.hbtn-ghost:hover{border-color:var(--border-hi);color:var(--text)}
.hbtn-red{background:var(--red);color:#fff}
.hbtn-red:hover{background:var(--red-hi)}
.body{display:grid;grid-template-columns:var(--sidebar) 1fr;height:100%;overflow:hidden}
aside{background:var(--bg2);border-right:1px solid var(--border);display:flex;flex-direction:column;overflow-y:auto}
.s-section{padding:14px 12px 4px;font-size:9px;font-weight:700;letter-spacing:1.8px;color:var(--text3);text-transform:uppercase;font-family:'IBM Plex Mono',monospace}
.s-item{display:flex;align-items:center;gap:9px;padding:9px 14px;font-size:13px;font-weight:600;color:var(--text2);cursor:pointer;transition:all .12s;position:relative;border-left:3px solid transparent}
.s-item:hover{background:var(--bg3);color:var(--text)}
.s-item.active{background:rgba(196,18,48,.1);color:var(--red-text);border-left-color:var(--red)}
.s-icon{font-size:14px;width:18px;text-align:center;flex-shrink:0}
.s-badge{margin-left:auto;padding:1px 7px;border-radius:10px;font-size:9px;font-weight:700;font-family:'IBM Plex Mono',monospace}
.s-badge-red{background:var(--red);color:#fff}
.s-badge-green{background:var(--green);color:#fff}
.s-request{margin:3px 10px;padding:9px 10px;border-radius:6px;border:1px solid var(--border);background:var(--bg3);cursor:pointer;transition:all .15s}
.s-request:hover{border-color:var(--border-hi)}
.s-req-head{display:flex;align-items:center;gap:6px;margin-bottom:3px}
.s-req-blood{font-family:'Barlow Condensed',sans-serif;font-size:15px;font-weight:800;color:var(--red-text)}
.s-req-urg{font-size:9px;font-weight:700;padding:1px 6px;border-radius:3px;font-family:'IBM Plex Mono',monospace}
.urg-crit{background:var(--red);color:#fff}
.urg-high{background:var(--amber);color:#fff}
.s-req-hosp{font-size:11px;color:var(--text2)}
.s-req-units{font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace;margin-top:2px}
.s-footer{margin-top:auto;padding:12px 14px;border-top:1px solid var(--border)}
.s-footer-text{font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace;line-height:1.6}
.content{overflow-y:auto;position:relative}
.page{display:none;padding:24px 28px;min-height:100%}
.page.active{display:block}
.pg-title{font-family:'Barlow Condensed',sans-serif;font-size:26px;font-weight:800;letter-spacing:.3px}
.pg-sub{font-size:12px;color:var(--text2);font-family:'IBM Plex Mono',monospace;margin-top:2px;margin-bottom:20px}
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
.stat{background:var(--bg2);border:1px solid var(--border);border-radius:8px;padding:14px 16px}
.stat-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;color:var(--text3);text-transform:uppercase;font-family:'IBM Plex Mono',monospace;margin-bottom:7px}
.stat-num{font-family:'Barlow Condensed',sans-serif;font-size:34px;font-weight:800;line-height:1}
.stat-num.red{color:var(--red-text)}.stat-num.amber{color:var(--amber-hi)}.stat-num.green{color:var(--green-hi)}
.stat-hint{font-size:11px;color:var(--text3);margin-top:4px;font-family:'IBM Plex Mono',monospace}
.toolbar{display:flex;align-items:center;gap:10px;margin-bottom:14px;flex-wrap:wrap}
.tb-label{font-size:11px;color:var(--text3);font-family:'IBM Plex Mono',monospace}
select,input[type=text],input[type=time],input[type=date],input[type=email],input[type=tel]{background:var(--bg2);border:1px solid var(--border);border-radius:5px;color:var(--text);font-family:'IBM Plex Mono',monospace;font-size:11px;padding:7px 10px;outline:none;transition:border-color .15s}
select:focus,input:focus{border-color:var(--red)}
select option{background:var(--bg3)}
.btn{padding:7px 16px;border-radius:5px;border:none;cursor:pointer;font-family:'Barlow',sans-serif;font-weight:700;font-size:12px;transition:all .15s}
.btn-red{background:var(--red);color:#fff}
.btn-red:hover{background:var(--red-hi)}
.btn-ghost{background:transparent;border:1px solid var(--border);color:var(--text2)}
.btn-ghost:hover{border-color:var(--border-hi);color:var(--text)}
.tb-count{margin-left:auto;font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--text3)}
.tbl-wrap{background:var(--bg2);border:1px solid var(--border);border-radius:8px;overflow:hidden}
table{width:100%;border-collapse:collapse}
thead tr{background:var(--bg3)}
th{padding:10px 14px;text-align:left;font-size:9px;font-weight:700;letter-spacing:1.4px;color:var(--text3);text-transform:uppercase;border-bottom:1px solid var(--border);font-family:'IBM Plex Mono',monospace}
td{padding:11px 14px;font-size:13px;border-bottom:1px solid var(--border);vertical-align:middle}
tbody tr:last-child td{border-bottom:none}
tbody tr{cursor:pointer;transition:background .1s}
tbody tr:hover td{background:var(--bg3)}
.no-cell{font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--text3)}
.name-cell{font-weight:600}
.name-cell small{display:block;font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace;margin-top:1px}
.blood-tag{display:inline-flex;align-items:center;justify-content:center;padding:3px 10px;border-radius:4px;font-family:'Barlow Condensed',sans-serif;font-size:14px;font-weight:800;background:rgba(196,18,48,.15);color:var(--red-text);border:1px solid rgba(196,18,48,.28)}
.blood-tag.universal{background:rgba(196,18,48,.25);border-color:rgba(196,18,48,.5)}
.days-chip{display:inline-block;padding:2px 8px;border-radius:12px;font-family:'IBM Plex Mono',monospace;font-size:10px}
.days-ok{background:rgba(21,168,106,.15);color:var(--green-hi);border:1px solid rgba(21,168,106,.25)}
.days-warn{background:rgba(212,131,10,.15);color:var(--amber-hi);border:1px solid rgba(212,131,10,.25)}
.days-bad{background:rgba(196,18,48,.15);color:var(--red-text);border:1px solid rgba(196,18,48,.25)}
.compat-cell{display:flex;align-items:center;gap:7px}
.compat-bar-bg{width:70px;height:5px;background:var(--bg4);border-radius:3px;overflow:hidden}
.compat-bar-fill{height:100%;border-radius:3px;background:linear-gradient(90deg,var(--red),var(--red-hi))}
.compat-pct{font-family:'IBM Plex Mono',monospace;font-size:10px;color:var(--text2)}
.avail{display:flex;align-items:center;gap:5px;font-size:12px}
.avail-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
.avail-yes .avail-dot{background:var(--green-hi);box-shadow:0 0 6px rgba(29,212,128,.5)}
.avail-no .avail-dot{background:var(--text3)}
.avail-yes{color:var(--green-hi)}.avail-no{color:var(--text3)}
.loading-cell{padding:32px;text-align:center;color:var(--text3);font-family:'IBM Plex Mono',monospace;font-size:12px}
.back-btn{display:inline-flex;align-items:center;gap:5px;margin-bottom:18px;background:transparent;border:none;color:var(--text2);font-family:'Barlow',sans-serif;font-size:12px;font-weight:600;cursor:pointer;transition:color .15s;padding:0}
.back-btn:hover{color:var(--text)}
.profile-layout{display:grid;grid-template-columns:300px 1fr;gap:18px}
.profile-left{display:flex;flex-direction:column;gap:14px}
.profile-card{background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:20px}
.donor-avatar{width:60px;height:60px;border-radius:10px;background:linear-gradient(135deg,#3d0010 0%,#8a0020 100%);display:flex;align-items:center;justify-content:center;font-family:'Barlow Condensed',sans-serif;font-size:22px;font-weight:800;color:var(--red-text);margin-bottom:14px;border:1px solid rgba(196,18,48,.3)}
.donor-name{font-family:'Barlow Condensed',sans-serif;font-size:22px;font-weight:800;letter-spacing:.3px}
.donor-type{font-size:12px;color:var(--text2);margin-top:2px}
.donor-blood-big{margin-top:12px;display:inline-flex;align-items:center;gap:8px;background:rgba(196,18,48,.12);border:1px solid rgba(196,18,48,.3);padding:6px 14px;border-radius:6px}
.bg-letter{font-family:'Barlow Condensed',sans-serif;font-size:28px;font-weight:800;color:var(--red-text);line-height:1}
.bg-label{font-size:10px;color:var(--text2);line-height:1.5}
.profile-divider{height:1px;background:var(--border);margin:14px 0}
.pf-row{display:flex;flex-direction:column;gap:2px;margin-bottom:11px}
.pf-row:last-child{margin-bottom:0}
.pf-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;color:var(--text3);text-transform:uppercase;font-family:'IBM Plex Mono',monospace}
.pf-val{font-size:13px;font-family:'IBM Plex Mono',monospace;color:var(--text)}
.compat-showcase{display:flex;align-items:center;gap:14px;background:var(--bg3);border-radius:8px;padding:12px;margin-top:12px}
.compat-circle{position:relative;width:64px;height:64px;flex-shrink:0}
.compat-circle svg{transform:rotate(-90deg);width:64px;height:64px}
.compat-circle-num{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:800;color:var(--red-text)}
.compat-detail{flex:1}
.compat-detail-title{font-size:13px;font-weight:700;margin-bottom:3px}
.compat-detail-sub{font-size:11px;color:var(--text2);font-family:'IBM Plex Mono',monospace}
.contact-btn{width:100%;padding:11px;border-radius:7px;border:none;background:var(--red);color:#fff;font-family:'Barlow Condensed',sans-serif;font-size:16px;font-weight:800;letter-spacing:.5px;cursor:pointer;transition:all .15s;display:flex;align-items:center;justify-content:center;gap:8px}
.contact-btn:hover{background:var(--red-hi);transform:translateY(-1px)}
.profile-right{display:flex;flex-direction:column;gap:14px}
.map-card{background:var(--bg2);border:1px solid var(--border);border-radius:10px;overflow:hidden;position:relative;min-height:380px}
.map-overlay-label{position:absolute;top:12px;left:12px;z-index:1000;background:rgba(13,13,18,.9);border:1px solid var(--border);padding:7px 12px;border-radius:6px;font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--text2);pointer-events:none;backdrop-filter:blur(4px)}
.map-overlay-label strong{color:var(--text);display:block;font-size:12px;margin-bottom:1px}
#donor-map{height:100%;width:100%;min-height:380px}
.stats-mini{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.stat-mini{background:var(--bg2);border:1px solid var(--border);border-radius:8px;padding:12px;text-align:center}
.stat-mini-num{font-family:'Barlow Condensed',sans-serif;font-size:26px;font-weight:800;line-height:1}
.stat-mini-lbl{font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace;margin-top:3px}
.leaflet-container{background:#0c0c14 !important}
.leaflet-tile{filter:brightness(.5) saturate(.4) hue-rotate(175deg) contrast(1.15)}
.leaflet-popup-content-wrapper{background:var(--bg2);border:1px solid var(--border);border-radius:8px;box-shadow:0 8px 32px rgba(0,0,0,.7);color:var(--text)}
.leaflet-popup-content{margin:12px 14px;font-family:'Barlow',sans-serif;color:var(--text)}
.leaflet-popup-tip{background:var(--bg2)}
.leaflet-popup-close-button{color:var(--text2) !important}
.popup-name{font-family:'Barlow Condensed',sans-serif;font-size:16px;font-weight:800;color:var(--text)}
.popup-blood{display:inline-block;padding:2px 9px;border-radius:4px;font-family:'Barlow Condensed',sans-serif;font-size:14px;font-weight:800;background:rgba(196,18,48,.2);color:var(--red-text);border:1px solid rgba(196,18,48,.3);margin:4px 0 6px}
.popup-detail{font-size:11px;color:var(--text2);font-family:'IBM Plex Mono',monospace;line-height:1.8}
.popup-avail-yes{font-size:11px;margin-top:5px;font-weight:700;color:var(--green-hi)}
.popup-avail-no{font-size:11px;margin-top:5px;font-weight:700;color:var(--red-text)}
.care-layout{display:grid;grid-template-columns:200px 1fr;gap:16px}
.care-donor-panel{background:var(--bg2);border:1px solid var(--border);border-radius:8px;overflow:hidden}
.cdp-head{padding:12px 14px;border-bottom:1px solid var(--border);font-size:9px;font-weight:700;letter-spacing:1.5px;color:var(--text3);text-transform:uppercase;font-family:'IBM Plex Mono',monospace}
.cdp-item{display:flex;align-items:center;gap:9px;padding:10px 14px;border-bottom:1px solid var(--border);cursor:pointer;transition:background .1s}
.cdp-item:last-child{border-bottom:none}
.cdp-item:hover{background:var(--bg3)}
.cdp-item.active{background:rgba(196,18,48,.1)}
.cdp-item.active .cdp-name{color:var(--red-text)}
.cdp-av{width:30px;height:30px;border-radius:6px;background:linear-gradient(135deg,#3d0010,#8a0020);display:flex;align-items:center;justify-content:center;font-family:'Barlow Condensed',sans-serif;font-size:13px;font-weight:800;color:var(--red-text);flex-shrink:0}
.cdp-name{font-size:12px;font-weight:600}
.cdp-blood{font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace}
.care-cards{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.care-card{background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:18px;transition:border-color .2s}
.care-card:hover{border-color:var(--border-hi)}
.cc-head{display:flex;align-items:center;gap:10px;margin-bottom:10px}
.cc-icon{font-size:20px}
.cc-title{font-family:'Barlow Condensed',sans-serif;font-size:17px;font-weight:800;letter-spacing:.3px}
.cc-clock{margin-left:auto;font-family:'IBM Plex Mono',monospace;font-size:11px;color:var(--green-hi);background:rgba(21,168,106,.1);padding:3px 8px;border-radius:4px;border:1px solid rgba(21,168,106,.2)}
.cc-desc{font-size:12px;color:var(--text2);line-height:1.5;margin-bottom:12px}
.time-row{display:flex;align-items:center;gap:8px;margin-bottom:10px}
.time-row input{flex:1}
.time-sep{font-size:11px;color:var(--text3)}
.ring-area{display:flex;align-items:center;gap:12px;margin-bottom:10px}
.ring-svg-wrap{position:relative;width:52px;height:52px;flex-shrink:0}
.ring-svg-wrap svg{transform:rotate(-90deg)}
.ring-num{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-family:'IBM Plex Mono',monospace;font-size:10px;font-weight:500}
.ring-info{font-size:11px;color:var(--text2)}
.ring-info strong{display:block;font-size:12px;color:var(--text);margin-bottom:2px}
.cc-actions{display:flex;gap:6px}
.cc-btn{padding:6px 14px;border-radius:5px;font-family:'Barlow',sans-serif;font-weight:700;font-size:11px;cursor:pointer;border:none;transition:all .12s}
.cc-btn-red{background:var(--red);color:#fff}
.cc-btn-red:hover{background:var(--red-hi)}
.cc-btn-ghost{background:transparent;border:1px solid var(--border);color:var(--text2)}
.cc-btn-ghost:hover{border-color:var(--border-hi);color:var(--text)}
.status-bar{padding:10px 14px;border-radius:6px;margin-bottom:14px;font-size:12px;display:none}
.status-ok{background:rgba(21,168,106,.1);border:1px solid rgba(21,168,106,.25);color:var(--green-hi);display:block}
.status-err{background:rgba(196,18,48,.1);border:1px solid rgba(196,18,48,.25);color:var(--red-text);display:block}

/* ── MODAL ── */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:1000;align-items:center;justify-content:center}
.modal-overlay.open{display:flex}
.modal{background:var(--bg2);border:1px solid var(--border-hi);border-radius:12px;padding:28px;width:460px;max-height:90vh;overflow-y:auto}
.modal-title{font-family:'Barlow Condensed',sans-serif;font-size:22px;font-weight:800;margin-bottom:4px}
.modal-sub{font-size:11px;color:var(--text2);font-family:'IBM Plex Mono',monospace;margin-bottom:20px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px}
.form-group{display:flex;flex-direction:column;gap:5px;margin-bottom:12px}
.form-group.full{grid-column:1/-1}
.form-label{font-size:9px;font-weight:700;letter-spacing:1.5px;color:var(--text3);text-transform:uppercase;font-family:'IBM Plex Mono',monospace}
.form-group input,.form-group select{width:100%;padding:9px 10px}
.modal-actions{display:flex;gap:10px;margin-top:18px}
.modal-actions .btn{flex:1;padding:11px}
</style>
</head>
<body>
<div class="shell">

<!-- ═══ HEADER ═══ -->
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

<!-- ═══ SIDEBAR ═══ -->
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

<!-- ═══ CONTENT ═══ -->
<div class="content">

<!-- ██ TV-1: MATCHING ENGINE ██ -->
<div class="page active" id="page-matching">
  <div class="pg-title">Donor Matching Engine</div>
  <div class="pg-sub" id="match-sub">Loading donors…</div>

  <div class="stats-row">
    <div class="stat"><div class="stat-lbl">Total Donors</div><div class="stat-num red" id="stat-total">…</div><div class="stat-hint">registered</div></div>
    <div class="stat"><div class="stat-lbl">Available Today</div><div class="stat-num green" id="stat-avail">…</div><div class="stat-hint" id="stat-avail-pct">—</div></div>
    <div class="stat"><div class="stat-lbl">Urgent Requests</div><div class="stat-num amber" id="stat-urgent">…</div><div class="stat-hint">critical + high</div></div>
    <div class="stat"><div class="stat-lbl">Eligible Donors</div><div class="stat-num red" id="stat-eligible">…</div><div class="stat-hint">passed 90-day wait</div></div>
  </div>

  <div class="toolbar">
    <span class="tb-label">BLOOD GROUP</span>
    <select id="blood-filter" onchange="renderTable()">
      <option value="">All Groups</option>
      <option value="A+">A+</option><option value="A-">A−</option>
      <option value="B+">B+</option><option value="B-">B−</option>
      <option value="AB+">AB+</option><option value="AB-">AB−</option>
      <option value="O+">O+</option><option value="O-">O−</option>
    </select>
    <span class="tb-label">LOCATION</span>
    <input type="text" id="loc-filter" placeholder="Filter by location…" oninput="renderTable()">
    <button class="btn btn-red" onclick="renderTable()">Search</button>
    <button class="btn btn-ghost" onclick="resetFilters()">Reset</button>
    <span class="tb-count" id="result-count"></span>
  </div>

  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th><th>Donor</th><th>Blood</th><th>Location</th>
          <th>Last Donation</th><th>Eligibility</th><th>Compatibility</th>
          <th>Distance</th><th>Available</th>
        </tr>
      </thead>
      <tbody id="donors-tbody">
        <tr><td colspan="9" class="loading-cell">Loading donors from database…</td></tr>
      </tbody>
    </table>
  </div>
</div>

<!-- ██ TV-2: DONOR PROFILE ██ -->
<div class="page" id="page-profile">
  <button class="back-btn" onclick="showPage('matching')">← Back to Donor List</button>
  <div class="pg-title">Donor Profile</div>
  <div class="pg-sub" style="margin-bottom:16px">Full details · compatibility analysis · live location map</div>

  <div class="profile-layout">
    <div class="profile-left">
      <div class="profile-card">
        <div class="donor-avatar" id="pf-avatar">?</div>
        <div class="donor-name" id="pf-name">—</div>
        <div class="donor-type" id="pf-type">—</div>
        <div class="donor-blood-big">
          <div class="bg-letter" id="pf-blood-big">—</div>
          <div class="bg-label" id="pf-blood-label">Blood Group<br><span style="color:var(--text)">—</span></div>
        </div>
        <div class="profile-divider"></div>
        <div class="pf-row"><div class="pf-lbl">Location</div><div class="pf-val" id="pf-location">—</div></div>
        <div class="pf-row"><div class="pf-lbl">Phone</div><div class="pf-val" id="pf-phone">—</div></div>
        <div class="pf-row"><div class="pf-lbl">Email</div><div class="pf-val" id="pf-email">—</div></div>
        <div class="pf-row"><div class="pf-lbl">Last Donation</div><div class="pf-val" id="pf-lastdon">—</div></div>
        <div class="pf-row"><div class="pf-lbl">Min. Wait Period</div><div class="pf-val" id="pf-wait">90 days</div></div>
        <div class="pf-row"><div class="pf-lbl">Eligibility Status</div><div class="pf-val" id="pf-eligible">—</div></div>
        <div class="pf-row"><div class="pf-lbl">GPS Coordinates</div><div class="pf-val" id="pf-coords" style="font-size:11px">—</div></div>
        <div class="profile-divider"></div>
        <div class="compat-showcase">
          <div class="compat-circle">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" width="64" height="64">
              <circle cx="32" cy="32" r="26" fill="none" stroke="var(--bg4)" stroke-width="5"/>
              <circle id="pf-ring-arc" cx="32" cy="32" r="26" fill="none" stroke="var(--red)" stroke-width="5"
                stroke-dasharray="163.36" stroke-dashoffset="163.36" style="transition:stroke-dashoffset .9s ease"/>
            </svg>
            <div class="compat-circle-num" id="pf-compat-pct">—%</div>
          </div>
          <div class="compat-detail">
            <div class="compat-detail-title" id="pf-compat-title">Compatibility</div>
            <div class="compat-detail-sub" id="pf-compat-sub">Set blood filter for exact match</div>
          </div>
        </div>
      </div>
      <button class="contact-btn" id="pf-contact-btn">📞 Contact Donor</button>
    </div>

    <div class="profile-right">
      <div class="map-card">
        <div class="map-overlay-label">
          <strong id="map-label-name">Donor Location</strong>
          <span id="map-label-coords">Dhaka, Bangladesh</span>
        </div>
        <div id="donor-map"></div>
      </div>
      <div class="stats-mini">
        <div class="stat-mini"><div class="stat-mini-num" id="pf-days-since">—</div><div class="stat-mini-lbl">Days Since<br>Last Donation</div></div>
        <div class="stat-mini"><div class="stat-mini-num green" id="pf-avail-stat">—</div><div class="stat-mini-lbl">Available<br>Today</div></div>
        <div class="stat-mini"><div class="stat-mini-num" id="pf-dist-stat" style="color:var(--amber-hi)">—</div><div class="stat-mini-lbl">km from<br>Dhaka Medical</div></div>
      </div>
    </div>
  </div>
</div>

<!-- ██ TV-3: POST-DONATION CARE ██ -->
<div class="page" id="page-care">
  <div class="pg-title">Post-Donation Care Panel</div>
  <div class="pg-sub">Notification schedules · hydration · rest · nutrition · recovery tracking</div>
  <div id="care-status" class="status-bar"></div>
  <div class="care-layout">
    <div class="care-donor-panel">
      <div class="cdp-head">Select Donor</div>
      <div id="care-donor-list"><div class="loading-cell">Loading…</div></div>
    </div>
    <div class="care-cards">
      <!-- Hydration -->
      <div class="care-card">
        <div class="cc-head"><div class="cc-icon">💧</div><div class="cc-title">Hydration Clock</div><div class="cc-clock" id="hyd-clock">--:--:--</div></div>
        <p class="cc-desc">Drink 8–10 glasses of water. Restores blood volume. Avoid alcohol for 24 hours post-donation.</p>
        <div class="time-row"><input type="time" id="hyd-start" value="08:00"><span class="time-sep">→</span><input type="time" id="hyd-end" value="20:00"></div>
        <div class="ring-area">
          <div class="ring-svg-wrap">
            <svg width="52" height="52" viewBox="0 0 52 52">
              <circle cx="26" cy="26" r="21" fill="none" stroke="var(--bg4)" stroke-width="5"/>
              <circle id="hyd-ring" cx="26" cy="26" r="21" fill="none" stroke="#1a9fd4" stroke-width="5" stroke-dasharray="131.95" stroke-dashoffset="131.95" style="transition:stroke-dashoffset .8s"/>
            </svg>
            <div class="ring-num" style="color:#1a9fd4" id="hyd-pct">0%</div>
          </div>
          <div class="ring-info"><strong>Day progress</strong>Based on current time vs window</div>
        </div>
        <div class="cc-actions">
          <button class="cc-btn cc-btn-red" onclick="saveCare()">Set Schedule</button>
          <button class="cc-btn cc-btn-ghost" onclick="resetCareCard('hyd','08:00','20:00')">Reset</button>
        </div>
      </div>
      <!-- Rest -->
      <div class="care-card">
        <div class="cc-head"><div class="cc-icon">🛌</div><div class="cc-title">Rest Reminder</div><div class="cc-clock" id="rest-clock">--:--:--</div></div>
        <p class="cc-desc">Avoid strenuous activity and heavy lifting for 24 hours. Resume light activity gradually after rest period.</p>
        <div class="time-row"><input type="time" id="rest-start" value="09:00"><span class="time-sep">→</span><input type="time" id="rest-end" value="17:00"></div>
        <div class="ring-area">
          <div class="ring-svg-wrap">
            <svg width="52" height="52" viewBox="0 0 52 52">
              <circle cx="26" cy="26" r="21" fill="none" stroke="var(--bg4)" stroke-width="5"/>
              <circle id="rest-ring" cx="26" cy="26" r="21" fill="none" stroke="#d4830a" stroke-width="5" stroke-dasharray="131.95" stroke-dashoffset="131.95" style="transition:stroke-dashoffset .8s"/>
            </svg>
            <div class="ring-num" style="color:#d4830a" id="rest-pct">0%</div>
          </div>
          <div class="ring-info"><strong>Day progress</strong>Rest window completion</div>
        </div>
        <div class="cc-actions">
          <button class="cc-btn cc-btn-red" onclick="saveCare()">Set Schedule</button>
          <button class="cc-btn cc-btn-ghost" onclick="resetCareCard('rest','09:00','17:00')">Reset</button>
        </div>
      </div>
      <!-- Nutrition -->
      <div class="care-card">
        <div class="cc-head"><div class="cc-icon">🥩</div><div class="cc-title">Nutrition Boost</div><div class="cc-clock" id="nut-clock">--:--:--</div></div>
        <p class="cc-desc">Iron-rich foods: red meat, spinach, lentils. Vitamin C boosts absorption. Avoid caffeine 1h after eating.</p>
        <div class="time-row"><input type="time" id="nut-start" value="07:00"><span class="time-sep">→</span><input type="time" id="nut-end" value="21:00"></div>
        <div class="ring-area">
          <div class="ring-svg-wrap">
            <svg width="52" height="52" viewBox="0 0 52 52">
              <circle cx="26" cy="26" r="21" fill="none" stroke="var(--bg4)" stroke-width="5"/>
              <circle id="nut-ring" cx="26" cy="26" r="21" fill="none" stroke="#15a86a" stroke-width="5" stroke-dasharray="131.95" stroke-dashoffset="131.95" style="transition:stroke-dashoffset .8s"/>
            </svg>
            <div class="ring-num" style="color:#15a86a" id="nut-pct">0%</div>
          </div>
          <div class="ring-info"><strong>Day progress</strong>Nutrition window completion</div>
        </div>
        <div class="cc-actions">
          <button class="cc-btn cc-btn-red" onclick="saveCare()">Set Schedule</button>
          <button class="cc-btn cc-btn-ghost" onclick="resetCareCard('nut','07:00','21:00')">Reset</button>
        </div>
      </div>
      <!-- Recovery -->
      <div class="care-card">
        <div class="cc-head"><div class="cc-icon">⏱</div><div class="cc-title">Recovery Clock</div><div class="cc-clock" id="rec-clock">--:--:--</div></div>
        <p class="cc-desc">Blood volume: 24–48h. Platelets: 72h. Red blood cells fully replenished in 4–6 weeks.</p>
        <div style="margin-bottom:10px">
          <div style="display:flex;justify-content:space-between;font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace;margin-bottom:5px">
            <span>Recovery progress</span><span id="rec-label">Select a donor</span>
          </div>
          <div style="height:5px;background:var(--bg4);border-radius:3px;overflow:hidden">
            <div id="rec-bar" style="height:100%;border-radius:3px;background:linear-gradient(90deg,var(--red),var(--red-hi));width:0;transition:width 1.2s"></div>
          </div>
        </div>
        <div class="ring-area">
          <div class="ring-svg-wrap">
            <svg width="52" height="52" viewBox="0 0 52 52">
              <circle cx="26" cy="26" r="21" fill="none" stroke="var(--bg4)" stroke-width="5"/>
              <circle id="rec-ring" cx="26" cy="26" r="21" fill="none" stroke="var(--red)" stroke-width="5" stroke-dasharray="131.95" stroke-dashoffset="131.95" style="transition:stroke-dashoffset .8s"/>
            </svg>
            <div class="ring-num" style="color:var(--red-text)" id="rec-pct">0%</div>
          </div>
          <div class="ring-info"><strong id="rec-donor-name">Select a donor</strong><span id="rec-since">—</span></div>
        </div>
      </div>
    </div>
  </div>
</div>

</div><!-- /content -->
</div><!-- /body -->
</div><!-- /shell -->

<!-- ═══ REGISTER DONOR MODAL ═══ -->
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

<script>
// ── CONFIG ──────────────────────────────────────────────────
const API = 'api/api.php';
const HOSP = {lat:23.7223, lng:90.3978, name:'Dhaka Medical College'};

// ── STATE ──
let DONORS = [];
let currentFilter = '';
let selectedCareId = null;
let donorMap = null;

// ── FALLBACK SEED DATA (used when DB/API is unreachable) ─────
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

// ── SAFE FETCH: returns null on any network/parse error ──────
async function safeFetch(url, options) {
  try {
    const res = await fetch(url, options);
    if (!res.ok) return null;
    const data = await res.json();
    // If PHP returned an error object, treat as failure
    if (data && data.error) return null;
    return data;
  } catch (e) {
    return null;
  }
}

// ── BLOOD COMPAT ────────────────────────────────────────────
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

// ── PAGE NAV ────────────────────────────────────────────────
function showPage(name) {
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.s-item[id^="snav-"]').forEach(s=>s.classList.remove('active'));
  document.getElementById('page-'+name).classList.add('active');
  const sn = document.getElementById('snav-'+name);
  if (sn) sn.classList.add('active');
  if (name === 'care') renderCareDonorList();
}

// ── LOAD STATS ───────────────────────────────────────────────
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

// ── LOAD REQUESTS (sidebar) ──────────────────────────────────
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

// ── TABLE ───────────────────────────────────────────────────
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
    // API success — use live data
    DONORS = data.donors || [];
  } else {
    // API unavailable — fall back to seed data with client-side filtering
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

// ── PROFILE ─────────────────────────────────────────────────
async function openProfile(id) {
  showPage('profile');

  let d = DONORS.find(x => x.id === id) || null;

  // Try live API first; fall back to cached DONORS or seed
  const apiData = await safeFetch(`${API}?action=get_donor&id=${id}`);
  if (apiData && apiData.donor) {
    d = apiData.donor;
  } else if (!d) {
    d = SEED_DONORS.find(x => x.id === id) || null;
  }
  if (!d) return;

  // Update DONORS cache so map works
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

  // Other donors (small icons)
  const smallIcon = d => L.divIcon({html:`<div style="width:28px;height:28px;border-radius:50%;background:#21212c;border:2px solid #383848;display:flex;align-items:center;justify-content:center;font-family:'Barlow Condensed',sans-serif;font-size:10px;font-weight:700;color:#8888a8">${d.blood_group.replace('+','').replace('-','')}</div>`,iconSize:[28,28],iconAnchor:[14,14],className:''});
  DONORS.filter(od=>od.id!==donor.id).forEach(od=>{
    L.marker([od.lat,od.lng],{icon:smallIcon(od),opacity:0.75}).addTo(donorMap)
      .bindPopup(`<div class="popup-name">${od.name}</div><div class="popup-blood">${od.blood_group.replace('-','−')}</div><div class="popup-detail">📍 ${od.location}<br>📞 ${od.phone}</div>`,{maxWidth:200});
  });

  const allPoints = DONORS.map(d=>[d.lat,d.lng]).concat([[HOSP.lat,HOSP.lng]]);
  donorMap.fitBounds(allPoints, {padding:[40,40]});
}

// ── CARE PANEL ───────────────────────────────────────────────
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
    // Save locally in seed cache so UI still works
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
function updateRings(){
  const now=new Date(); const nowM=now.getHours()*60+now.getMinutes(); const C=131.95;
  [['hyd-start','hyd-end','hyd-ring','hyd-pct'],
   ['rest-start','rest-end','rest-ring','rest-pct'],
   ['nut-start','nut-end','nut-ring','nut-pct']].forEach(([sId,eId,rId,pId])=>{
    const s=timeMins(document.getElementById(sId).value);
    const e=timeMins(document.getElementById(eId).value);
    const total=e-s; const elapsed=Math.max(0,Math.min(nowM-s,total));
    const pct=total>0?Math.round((elapsed/total)*100):0;
    document.getElementById(rId).style.strokeDashoffset=C-(pct/100)*C;
    document.getElementById(pId).textContent=pct+'%';
  });
}
function updateClocks(){
  const ts=new Date().toLocaleTimeString('en-GB');
  ['hyd-clock','rest-clock','nut-clock','rec-clock'].forEach(id=>{const el=document.getElementById(id);if(el)el.textContent=ts;});
  updateRings();
}

// ── REGISTER MODAL ──────────────────────────────────────────
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
    // DB not reachable — add to local seed so UI refreshes
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

// ── INIT ─────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
  await Promise.all([loadStats(), loadRequests()]);
  await renderTable();
  setInterval(updateClocks, 1000);
  updateClocks();
});
</script>
</body>
</html>
