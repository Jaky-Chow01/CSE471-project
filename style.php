<?php?>
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
