<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>bloodConnect | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; overflow-x: hidden; }
        .blood-particle { position: fixed; background: #dc2626; border-radius: 50%; filter: blur(3px); opacity: 0.07; z-index: -1; bottom: -100px; animation: float 25s infinite linear; }
        @keyframes float { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(-1200px) rotate(360deg); } }
        #donor-map { height: 320px; width: 100%; border-radius: 1.25rem; }
        .ring-track { fill: none; stroke: #e5e7eb; stroke-width: 5; }
        .ring-fill  { fill: none; stroke-width: 5; stroke-dasharray: 131.95; stroke-dashoffset: 131.95; transition: stroke-dashoffset 0.8s ease; transform: rotate(-90deg); transform-origin: 26px 26px; }
        .tab-btn { transition: all 0.15s; }
        .tab-btn.active { background: #dc2626; color: white; }
        .page-section { display: none; }
        .page-section.active { display: block; }
        input[type=time] { background: rgba(255,255,255,0.8); border: 1px solid #e5e7eb; border-radius: 12px; padding: 6px 10px; font-size: 12px; font-family: monospace; }
        input[type=time]:focus { outline: none; border-color: #dc2626; }
        select, input[type=text], input[type=number], input[type=email] {
            background: rgba(255,255,255,0.8); border: 1px solid #e5e7eb; border-radius: 12px; padding: 8px 12px; font-size: 12px;
        }
        select:focus, input:focus { outline: none; border-color: #dc2626; }
        .stat-card { background: rgba(255,255,255,0.8); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.9); border-radius: 1.5rem; padding: 1rem 1.25rem; }
        .tbl-wrap { background: rgba(255,255,255,0.8); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.9); border-radius: 1.5rem; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: rgba(249,250,251,0.8); }
        th { padding: 10px 14px; text-align: left; font-size: 9px; font-weight: 800; letter-spacing: 1.4px; color: #9ca3af; text-transform: uppercase; border-bottom: 1px solid #f3f4f6; }
        td { padding: 10px 14px; font-size: 12px; border-bottom: 1px solid #f9fafb; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: rgba(254,242,242,0.5); cursor: pointer; }
        .blood-tag { display: inline-flex; align-items: center; justify-content: center; padding: 2px 9px; border-radius: 6px; font-size: 12px; font-weight: 800; background: rgba(220,38,38,0.1); color: #dc2626; border: 1px solid rgba(220,38,38,0.2); }
        .avail-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .avail-yes .avail-dot { background: #10b981; box-shadow: 0 0 5px rgba(16,185,129,0.5); }
        .avail-no .avail-dot { background: #9ca3af; }
        .avail-yes { color: #10b981; } .avail-no { color: #9ca3af; }
        .care-donor-item { display: flex; align-items: center; gap: 9px; padding: 10px 14px; border-bottom: 1px solid #f3f4f6; cursor: pointer; transition: background 0.1s; }
        .care-donor-item:hover { background: rgba(254,242,242,0.5); }
        .care-donor-item.active { background: rgba(220,38,38,0.06); }
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-overlay.open { display: flex; }
        .modal-box { background: white; border-radius: 2rem; padding: 2rem; width: 460px; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px rgba(0,0,0,0.15); }
        .care-alert-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(6px); }
        .care-alert-overlay.open { display: flex; }
        .care-alert-box { background: white; border-radius: 2rem; padding: 2.5rem 2rem; width: 360px; text-align: center; box-shadow: 0 30px 60px rgba(0,0,0,0.2); animation: popIn 0.3s cubic-bezier(0.175,0.885,0.32,1.275); }
        @keyframes popIn { from { transform: scale(0.7); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body class="min-h-screen pb-24 relative">
    <div class="blood-particle" style="width:20px;height:20px;left:5%;animation-duration:18s;"></div>
    <div class="blood-particle" style="width:35px;height:35px;left:85%;animation-duration:26s;border-radius:40%;"></div>

    <!-- Header -->
    <nav class="px-6 py-4 flex items-center justify-between max-w-7xl mx-auto sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-white/50">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="flex items-center gap-1 bg-gray-100/80 p-1 rounded-2xl">
            <button onclick="switchTab('matching')"  class="tab-btn active px-4 py-2 rounded-xl text-xs font-black" id="tab-matching">Donor Matching</button>
            <button onclick="switchTab('care')"      class="tab-btn px-4 py-2 rounded-xl text-xs font-black text-gray-500" id="tab-care">Care Panel</button>
            <button onclick="switchTab('hospital')"  class="tab-btn px-4 py-2 rounded-xl text-xs font-black text-gray-500" id="tab-hospital">Hospital</button>
            <button onclick="switchTab('analytics')" class="tab-btn px-4 py-2 rounded-xl text-xs font-black text-gray-500" id="tab-analytics">Analytics</button>
        </div>
        <div class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse inline-block"></span>Live
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 mt-6">

        <!-- ===== MODULE 1: DONOR MATCHING ===== -->
        <div class="page-section active" id="section-matching">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-extrabold text-gray-800">Donor Matching Engine</h2>
                    <p class="text-xs text-gray-500 mt-0.5" id="match-sub">Loading donors…</p>
                </div>
            </div>

            <!-- Stats row -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Donors</p><p class="text-3xl font-extrabold text-red-600" id="stat-total">…</p><p class="text-xs text-gray-400 mt-0.5">registered</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Available Today</p><p class="text-3xl font-extrabold text-emerald-600" id="stat-avail">…</p><p class="text-xs text-gray-400 mt-0.5" id="stat-avail-pct">—</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Urgent Requests</p><p class="text-3xl font-extrabold text-amber-500" id="stat-urgent">…</p><p class="text-xs text-gray-400 mt-0.5">critical + high</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Eligible Donors</p><p class="text-3xl font-extrabold text-red-600" id="stat-eligible">…</p><p class="text-xs text-gray-400 mt-0.5">passed 90-day wait</p></div>
            </div>

            <!-- Toolbar -->
            <div class="flex flex-wrap items-center gap-3 mb-4 bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Blood Group</span>
                <select id="blood-filter" onchange="renderTable()" class="font-bold">
                    <option value="">All Groups</option>
                    <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                    <option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
                </select>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Location</span>
                <input type="text" id="loc-filter" placeholder="Filter by location…" class="flex-1 min-w-[140px]">
                <button onclick="renderTable()" class="bg-red-600 text-white font-black px-4 py-2 rounded-xl text-xs hover:bg-red-700 transition active:scale-95">Search</button>
                <button onclick="resetFilters()" class="bg-white border border-gray-200 text-gray-600 font-bold px-4 py-2 rounded-xl text-xs hover:bg-gray-50 transition">Reset</button>
                <span class="text-[10px] text-gray-400 font-bold ml-auto" id="result-count"></span>
            </div>

            <!-- Table -->
            <div class="tbl-wrap">
                <table>
                    <thead><tr>
                        <th>#</th><th>Donor</th><th>Blood</th><th>Location</th>
                        <th>Last Donation</th><th>Eligibility</th><th>Compatibility</th><th>Action</th>
                    </tr></thead>
                    <tbody id="donors-tbody"><tr><td colspan="8" class="text-center py-8 text-gray-400 text-xs font-bold">Loading donors…</td></tr></tbody>
                </table>
            </div>

            <!-- Profile panel (hidden by default) -->
            <div id="profile-panel" class="hidden mt-6 bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-6">
                <button onclick="document.getElementById('profile-panel').classList.add('hidden')" class="flex items-center text-gray-600 font-bold mb-5 hover:text-red-600 transition group text-sm">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>Back to List
                </button>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="space-y-4">
                        <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-5 border border-red-100">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-200 to-red-400 flex items-center justify-center font-extrabold text-white text-lg mb-3" id="pf-avatar">?</div>
                            <p class="font-extrabold text-gray-800 text-lg" id="pf-name">—</p>
                            <p class="text-xs text-gray-500 mt-0.5" id="pf-type">—</p>
                            <div class="inline-flex items-center gap-2 bg-red-100 border border-red-200 px-3 py-1.5 rounded-xl mt-3">
                                <span class="text-2xl font-extrabold text-red-600" id="pf-blood-big">—</span>
                                <span class="text-xs text-gray-500">Blood Group</span>
                            </div>
                        </div>
                        <div class="bg-white/80 rounded-2xl p-4 border border-gray-100 space-y-2 text-sm">
                            <div><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Location</p><p class="font-bold text-gray-700 mt-0.5" id="pf-location">—</p></div>
                            <div><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Phone</p><p class="font-bold text-gray-700 mt-0.5 font-mono" id="pf-phone">—</p></div>
                            <div><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Last Donation</p><p class="font-bold text-gray-700 mt-0.5" id="pf-lastdon">—</p></div>
                            <div><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Eligibility</p><p class="font-bold mt-0.5" id="pf-eligible">—</p></div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <div class="bg-white/80 rounded-2xl border border-gray-100 overflow-hidden mb-4" style="height:320px">
                            <div id="donor-map"></div>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="stat-card text-center"><p class="text-2xl font-extrabold text-gray-800" id="pf-days-since">—</p><p class="text-[9px] font-black text-gray-400 uppercase mt-0.5">Days Since<br>Donation</p></div>
                            <div class="stat-card text-center"><p class="text-2xl font-extrabold" id="pf-avail-stat">—</p><p class="text-[9px] font-black text-gray-400 uppercase mt-0.5">Available<br>Today</p></div>
                            <div class="stat-card text-center"><p class="text-2xl font-extrabold text-amber-500" id="pf-dist-stat">—</p><p class="text-[9px] font-black text-gray-400 uppercase mt-0.5">km from<br>Dhaka Medical</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== MODULE 2: POST-DONATION CARE ===== -->
        <div class="page-section" id="section-care">
            <h2 class="text-xl font-extrabold text-gray-800 mb-1">Post-Donation Care Panel</h2>
            <p class="text-xs text-gray-500 mb-5">Select a donor and manage their recovery schedule.</p>
            <div id="care-status" class="hidden mb-4 p-3 rounded-2xl text-xs font-bold"></div>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-5">
                <!-- Donor list -->
                <div class="md:col-span-1 bg-white/80 backdrop-blur-md rounded-2xl border border-white overflow-hidden">
                    <div class="p-3 border-b border-gray-100"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Select Donor</p></div>
                    <div id="care-donor-list"><div class="p-4 text-center text-xs text-gray-400">Loading…</div></div>
                </div>
                <!-- Care cards -->
                <div class="md:col-span-4 grid grid-cols-1 md:grid-cols-2 gap-4" id="care-cards">
                    <!-- Hydration -->
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-white p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-xl">💧</span>
                            <div><p class="font-extrabold text-gray-800">Hydration Clock</p><p class="text-[10px] text-blue-500 font-mono" id="hyd-clock">--:--:--</p></div>
                        </div>
                        <p class="text-xs text-gray-500 mb-3 leading-relaxed">Drink 8–10 glasses of water. Restores blood volume. Avoid alcohol for 24 hours post-donation.</p>
                        <div class="flex items-center gap-2 mb-3"><input type="time" id="hyd-start" value="08:00"><span class="text-gray-400 text-xs">→</span><input type="time" id="hyd-end" value="20:00"></div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="relative w-12 h-12 flex-shrink-0">
                                <svg width="52" height="52" viewBox="0 0 52 52"><circle class="ring-track" cx="26" cy="26" r="21"/><circle id="hyd-ring" class="ring-fill" cx="26" cy="26" r="21" stroke="#1a9fd4"/></svg>
                                <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-blue-500" id="hyd-pct">0%</div>
                            </div>
                            <div class="text-xs text-gray-500"><strong class="block text-gray-700">Day progress</strong>Based on current time vs window</div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="saveCare()" class="flex-1 bg-red-600 text-white font-bold py-2 rounded-xl text-xs hover:bg-red-700 transition active:scale-95">Set Schedule</button>
                            <button onclick="resetCareCard('hyd','08:00','20:00')" class="bg-white border border-gray-200 text-gray-600 font-bold px-3 py-2 rounded-xl text-xs hover:bg-gray-50 transition">Reset</button>
                        </div>
                    </div>
                    <!-- Rest -->
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-white p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-xl">🛌</span>
                            <div><p class="font-extrabold text-gray-800">Rest Reminder</p><p class="text-[10px] text-amber-500 font-mono" id="rest-clock">--:--:--</p></div>
                        </div>
                        <p class="text-xs text-gray-500 mb-3 leading-relaxed">Avoid strenuous activity for 24 hours. Resume light activity gradually after rest period.</p>
                        <div class="flex items-center gap-2 mb-3"><input type="time" id="rest-start" value="09:00"><span class="text-gray-400 text-xs">→</span><input type="time" id="rest-end" value="17:00"></div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="relative w-12 h-12 flex-shrink-0">
                                <svg width="52" height="52" viewBox="0 0 52 52"><circle class="ring-track" cx="26" cy="26" r="21"/><circle id="rest-ring" class="ring-fill" cx="26" cy="26" r="21" stroke="#d4830a"/></svg>
                                <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-amber-500" id="rest-pct">0%</div>
                            </div>
                            <div class="text-xs text-gray-500"><strong class="block text-gray-700">Day progress</strong>Rest window completion</div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="saveCare()" class="flex-1 bg-red-600 text-white font-bold py-2 rounded-xl text-xs hover:bg-red-700 transition active:scale-95">Set Schedule</button>
                            <button onclick="resetCareCard('rest','09:00','17:00')" class="bg-white border border-gray-200 text-gray-600 font-bold px-3 py-2 rounded-xl text-xs hover:bg-gray-50 transition">Reset</button>
                        </div>
                    </div>
                    <!-- Nutrition -->
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-white p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-xl">🥩</span>
                            <div><p class="font-extrabold text-gray-800">Nutrition Boost</p><p class="text-[10px] text-emerald-500 font-mono" id="nut-clock">--:--:--</p></div>
                        </div>
                        <p class="text-xs text-gray-500 mb-3 leading-relaxed">Iron-rich foods: red meat, spinach, lentils. Vitamin C boosts absorption. Avoid caffeine 1h after eating.</p>
                        <div class="flex items-center gap-2 mb-3"><input type="time" id="nut-start" value="07:00"><span class="text-gray-400 text-xs">→</span><input type="time" id="nut-end" value="21:00"></div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="relative w-12 h-12 flex-shrink-0">
                                <svg width="52" height="52" viewBox="0 0 52 52"><circle class="ring-track" cx="26" cy="26" r="21"/><circle id="nut-ring" class="ring-fill" cx="26" cy="26" r="21" stroke="#15a86a"/></svg>
                                <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-emerald-500" id="nut-pct">0%</div>
                            </div>
                            <div class="text-xs text-gray-500"><strong class="block text-gray-700">Day progress</strong>Nutrition window completion</div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="saveCare()" class="flex-1 bg-red-600 text-white font-bold py-2 rounded-xl text-xs hover:bg-red-700 transition active:scale-95">Set Schedule</button>
                            <button onclick="resetCareCard('nut','07:00','21:00')" class="bg-white border border-gray-200 text-gray-600 font-bold px-3 py-2 rounded-xl text-xs hover:bg-gray-50 transition">Reset</button>
                        </div>
                    </div>
                    <!-- Recovery -->
                    <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-white p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-xl">⏱</span>
                            <div><p class="font-extrabold text-gray-800">Recovery Clock</p><p class="text-[10px] text-red-500 font-mono" id="rec-clock">--:--:--</p></div>
                        </div>
                        <p class="text-xs text-gray-500 mb-3 leading-relaxed">Blood volume: 24–48h. Platelets: 72h. Red blood cells fully replenished in 4–6 weeks.</p>
                        <div class="mb-3">
                            <div class="flex justify-between text-[10px] text-gray-400 mb-1"><span>Recovery progress</span><span id="rec-label">Select a donor</span></div>
                            <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden"><div id="rec-bar" class="h-full rounded-full bg-gradient-to-r from-red-400 to-red-600 transition-all duration-1000" style="width:0"></div></div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="relative w-12 h-12 flex-shrink-0">
                                <svg width="52" height="52" viewBox="0 0 52 52"><circle class="ring-track" cx="26" cy="26" r="21"/><circle id="rec-ring" class="ring-fill" cx="26" cy="26" r="21" stroke="#dc2626"/></svg>
                                <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-red-600" id="rec-pct">0%</div>
                            </div>
                            <div class="text-xs text-gray-500"><strong class="block text-gray-700" id="rec-donor-name">Select a donor</strong><span id="rec-since">—</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== MODULE 3: HOSPITAL DASHBOARD ===== -->
        <div class="page-section" id="section-hospital">
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <div><h2 class="text-xl font-extrabold text-gray-800">Hospital Dashboard</h2><p class="text-xs text-gray-500 mt-0.5" id="hosp-last-refresh"></p></div>
                <div class="flex items-center gap-3 ml-auto flex-wrap">
                    <select id="hosp-select" onchange="loadHospitalData()" class="font-bold">
                        <option>Dhaka Medical College</option><option>Square Hospital</option>
                        <option>BIRDEM General Hospital</option><option>Apollo Hospitals Dhaka</option><option>United Hospital</option>
                    </select>
                    <button onclick="loadHospitalData()" class="bg-white border border-gray-200 text-gray-600 font-bold px-4 py-2.5 rounded-2xl text-sm hover:bg-gray-50 transition">↻ Refresh</button>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Active Requests</p><p class="text-3xl font-extrabold text-amber-500" id="hosp-stat-active">—</p><p class="text-xs text-gray-400 mt-0.5">open right now</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Fulfilled Today</p><p class="text-3xl font-extrabold text-emerald-500" id="hosp-stat-fulfilled">—</p><p class="text-xs text-gray-400 mt-0.5">units received</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Confirmations</p><p class="text-3xl font-extrabold text-red-600" id="hosp-stat-confirmations">—</p><p class="text-xs text-gray-400 mt-0.5">awaiting response</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Critical Shortage</p><p class="text-3xl font-extrabold text-amber-500" id="hosp-stat-critical">—</p><p class="text-xs text-gray-400 mt-0.5">blood types</p></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                        <p class="font-extrabold text-gray-800 text-sm">Active Blood Requests</p>
                        <div class="flex gap-2">
                            <select id="hosp-urgency-filter" onchange="renderHospRequests()" class="text-xs py-1.5 px-3">
                                <option value="">All Urgency</option><option value="Urgent">Urgent</option><option value="">Normal</option>
                            </select>
                        </div>
                    </div>
                    <div class="tbl-wrap">
                        <table>
                            <thead><tr><th>Blood</th><th>Bags</th><th>Urgency</th><th>Location</th><th>Contact</th><th>Posted</th></tr></thead>
                            <tbody id="hosp-requests-tbody"><tr><td colspan="6" class="text-center py-6 text-gray-400 text-xs">Loading…</td></tr></tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <p class="font-extrabold text-gray-800 text-sm mb-3">Donor Confirmation Queue</p>
                    <div id="hosp-confirmation-list" class="space-y-3">
                        <div class="text-center text-xs text-gray-400 py-4">Loading confirmations…</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== MODULE 4: ANALYTICS ===== -->
        <div class="page-section" id="section-analytics">
            <h2 class="text-xl font-extrabold text-gray-800 mb-1">Analytics Dashboard</h2>
            <p class="text-xs text-gray-500 mb-5">Live statistics from the bloodConnect database.</p>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-5">
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Avg Response</p><p class="text-2xl font-extrabold text-emerald-500" id="an-response-time">—</p><p class="text-xs text-gray-400 mt-0.5">minutes</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Fulfilment Rate</p><p class="text-2xl font-extrabold text-red-600" id="an-fulfil-rate">—</p><p class="text-xs text-gray-400 mt-0.5">this month</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Top Demand</p><p class="text-2xl font-extrabold text-amber-500" id="an-top-demand">—</p><p class="text-xs text-gray-400 mt-0.5">most requested</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Donor Turnout</p><p class="text-2xl font-extrabold text-emerald-500" id="an-turnout">—</p><p class="text-xs text-gray-400 mt-0.5">% available</p></div>
                <div class="stat-card"><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Critical Shortages</p><p class="text-2xl font-extrabold text-amber-500" id="an-shortages">—</p><p class="text-xs text-gray-400 mt-0.5">active now</p></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-white p-5">
                    <p class="font-extrabold text-gray-800 mb-1">Blood Demand by Type</p>
                    <p class="text-[10px] text-gray-400 font-mono mb-4">Units requested per blood group — all time</p>
                    <div id="an-demand-chart" class="space-y-2"></div>
                </div>
                <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-white p-5">
                    <p class="font-extrabold text-gray-800 mb-1">Donor Pool Breakdown</p>
                    <p class="text-[10px] text-gray-400 font-mono mb-4">Eligibility & availability status</p>
                    <div id="an-pool" class="space-y-3"></div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-white p-5">
                <p class="font-extrabold text-gray-800 mb-1">Donor Response Statistics</p>
                <p class="text-[10px] text-gray-400 font-mono mb-4">Per-donor contribution summary</p>
                <div class="tbl-wrap" style="border:none;background:transparent">
                    <table>
                        <thead><tr><th>Donor</th><th>Blood</th><th>Last Donation</th><th>Days Since</th><th>Status</th></tr></thead>
                        <tbody id="an-donor-stats-tbody"><tr><td colspan="5" class="text-center py-6 text-gray-400 text-xs">Loading…</td></tr></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- /max-w-7xl -->

    <!-- Register Donor Modal -->
    <div class="modal-overlay" id="register-modal">
        <div class="modal-box">
            <p class="text-lg font-extrabold text-gray-800 mb-1">Register New Donor</p>
            <p class="text-xs text-gray-400 font-mono mb-5">Add a donor to the matching database.</p>
            <div id="reg-status" class="hidden mb-4 p-3 rounded-xl text-xs font-bold"></div>
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Full Name *</label><input type="text" id="reg-name" placeholder="e.g. Arif Hossain" class="w-full"></div>
                <div><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Blood Group *</label>
                    <select id="reg-blood" class="w-full"><option value="">Select…</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select>
                </div>
            </div>
            <div class="mb-3"><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Location *</label><input type="text" id="reg-location" placeholder="e.g. Dhanmondi, Dhaka" class="w-full"></div>
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Latitude</label><input type="number" id="reg-lat" placeholder="23.8103" step="0.0001" class="w-full"></div>
                <div><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Longitude</label><input type="number" id="reg-lng" placeholder="90.4125" step="0.0001" class="w-full"></div>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-5">
                <div><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Phone *</label><input type="text" id="reg-phone" placeholder="01711-XXXXXX" class="w-full"></div>
                <div><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Email</label><input type="email" id="reg-email" placeholder="donor@email.com" class="w-full"></div>
            </div>
            <div class="flex gap-3">
                <button onclick="document.getElementById('register-modal').classList.remove('open')" class="flex-1 bg-white border border-gray-200 text-gray-600 font-bold py-3 rounded-2xl text-sm hover:bg-gray-50 transition">Cancel</button>
                <button onclick="registerDonor()" class="flex-1 bg-red-600 text-white font-black py-3 rounded-2xl text-sm hover:bg-red-700 transition shadow-lg shadow-red-200 active:scale-95">Register Donor</button>
            </div>
        </div>
    </div>

    <!-- New Blood Request Modal -->
    <div class="modal-overlay" id="new-request-modal">
        <div class="modal-box">
            <p class="text-lg font-extrabold text-gray-800 mb-1">New Blood Request</p>
            <p class="text-xs text-gray-400 font-mono mb-5">Submit an urgent blood request to the donor matching system.</p>
            <div id="nr-status" class="hidden mb-4 p-3 rounded-xl text-xs font-bold"></div>
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Blood Group *</label>
                    <select id="nr-blood" class="w-full"><option value="">Select…</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select>
                </div>
                <div><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Bags Required *</label><input type="number" id="nr-bags" placeholder="e.g. 2" min="1" max="50" class="w-full"></div>
            </div>
            <div class="mb-3"><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Hospital / Location *</label>
                <select id="nr-hospital" class="w-full"><option>Dhaka Medical College</option><option>Square Hospital</option><option>BIRDEM General Hospital</option><option>Apollo Hospitals Dhaka</option><option>United Hospital</option></select>
            </div>
            <div class="mb-3"><label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Contact Number *</label><input type="text" id="nr-contact" placeholder="01XXX-XXXXXX" class="w-full"></div>
            <div class="mb-5"><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="nr-urgent" class="rounded"><span class="text-sm font-bold text-gray-700">Mark as Urgent</span></label></div>
            <div class="flex gap-3">
                <button onclick="document.getElementById('new-request-modal').classList.remove('open')" class="flex-1 bg-white border border-gray-200 text-gray-600 font-bold py-3 rounded-2xl text-sm hover:bg-gray-50 transition">Cancel</button>
                <button onclick="submitNewRequest()" class="flex-1 bg-red-600 text-white font-black py-3 rounded-2xl text-sm hover:bg-red-700 transition shadow-lg shadow-red-200 active:scale-95">Submit Request</button>
            </div>
        </div>
    </div>

    <!-- Care Alert Popup -->
    <div class="care-alert-overlay" id="care-alert-overlay">
        <div class="care-alert-box">
            <div class="text-5xl mb-4" id="care-alert-icon">✅</div>
            <h3 class="text-lg font-extrabold text-gray-800 mb-1" id="care-alert-title">Schedule Complete!</h3>
            <p class="text-sm text-gray-500 mb-5" id="care-alert-msg">The care schedule window has been completed.</p>
            <button onclick="document.getElementById('care-alert-overlay').classList.remove('open')"
                class="w-full bg-red-600 text-white font-black py-3 rounded-2xl text-sm hover:bg-red-700 transition active:scale-95">
                Got it!
            </button>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    // ── TAB SWITCHING ─────────────────────────────────────────
    function switchTab(name) {
        ['matching','care','hospital','analytics'].forEach(t => {
            document.getElementById('tab-' + t).classList.remove('active');
            document.getElementById('tab-' + t).classList.add('text-gray-500');
            document.getElementById('section-' + t).classList.remove('active');
        });
        document.getElementById('tab-' + name).classList.add('active');
        document.getElementById('tab-' + name).classList.remove('text-gray-500');
        document.getElementById('section-' + name).classList.add('active');
        if (name === 'care') loadCarePanel();
        if (name === 'hospital') loadHospitalData();
        if (name === 'analytics') loadAnalytics();
    }

    // ── GLOBALS ───────────────────────────────────────────────
    let allDonors = [], selectedDonorId = null, donorMap = null;
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    // ── MODULE 1 ──────────────────────────────────────────────
    async function loadStats() {
        const r = await fetch('/api/dashboard/stats'); const d = await r.json();
        document.getElementById('stat-total').textContent = d.total_donors;
        document.getElementById('stat-avail').textContent = d.avail_donors;
        const pct = d.total_donors ? Math.round(d.avail_donors / d.total_donors * 100) : 0;
        document.getElementById('stat-avail-pct').textContent = pct + '% of total';
        document.getElementById('stat-urgent').textContent = d.urgent_reqs;
        document.getElementById('stat-eligible').textContent = d.eligible;
    }

    async function loadDonors() {
        const bg  = document.getElementById('blood-filter').value;
        const loc = document.getElementById('loc-filter').value;
        let url = '/api/dashboard/donors?limit=100';
        if (bg)  url += '&blood_group=' + encodeURIComponent(bg);
        if (loc) url += '&location=' + encodeURIComponent(loc);
        const r = await fetch(url); const d = await r.json();
        allDonors = d.donors;
        document.getElementById('match-sub').textContent = d.total + ' donors in database';
        renderTable();
    }

    function renderTable() {
        const bg  = document.getElementById('blood-filter').value;
        const loc = document.getElementById('loc-filter').value.toLowerCase();
        let donors = allDonors;
        if (loc) donors = donors.filter(d => (d.location ?? '').toLowerCase().includes(loc));
        document.getElementById('result-count').textContent = donors.length + ' result(s)';
        const tbody = document.getElementById('donors-tbody');
        if (!donors.length) { tbody.innerHTML = '<tr><td colspan="8" class="text-center py-8 text-gray-400 text-xs font-bold">No donors found.</td></tr>'; return; }
        tbody.innerHTML = donors.map((d, i) => {
            const avail = d.status === 'Available';
            const eligible = d.eligible;
            return `<tr onclick="openProfile(${d.id})">
                <td class="text-gray-400 text-xs font-mono">${i + 1}</td>
                <td><p class="font-bold text-gray-800 text-sm">${d.name}</p><p class="text-[10px] text-gray-400 font-mono">${d.email ?? ''}</p></td>
                <td><span class="blood-tag">${d.blood_group}</span></td>
                <td class="text-xs text-gray-600">${d.location ?? '—'}</td>
                <td class="text-xs font-mono text-gray-500">${d.last_donation ?? 'Never'}</td>
                <td><span class="text-xs font-bold px-2 py-1 rounded-lg ${eligible ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600'}">${eligible ? 'Eligible' : 'Not Eligible'}</span></td>
                <td><span class="flex items-center gap-1.5 text-xs font-bold ${avail ? 'avail-yes' : 'avail-no'}"><span class="avail-dot"></span>${avail ? 'Compatible' : 'Not Compatible'}</span></td>
                <td><button onclick="event.stopPropagation();toggleAvail(${d.id},this)" class="text-[10px] font-bold px-3 py-1 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">${avail ? 'Set Unavailable' : 'Set Available'}</button></td>
            </tr>`;
        }).join('');
    }

    function resetFilters() { document.getElementById('blood-filter').value = ''; document.getElementById('loc-filter').value = ''; loadDonors(); }

    async function openProfile(id) {
        const r = await fetch('/api/dashboard/donor/' + id); const d = await r.json();
        document.getElementById('pf-avatar').textContent = d.initials ?? d.name[0];
        document.getElementById('pf-name').textContent = d.name;
        document.getElementById('pf-type').textContent = 'Blood Group · ' + d.blood_group;
        document.getElementById('pf-blood-big').textContent = d.blood_group;
        document.getElementById('pf-location').textContent = d.location ?? '—';
        document.getElementById('pf-phone').textContent = d.phone ?? '—';
        document.getElementById('pf-lastdon').textContent = d.last_donation ?? 'Never donated';
        document.getElementById('pf-eligible').textContent = d.eligible ? '✅ Eligible' : '❌ Not Eligible (within 90-day wait)';
        document.getElementById('pf-days-since').textContent = d.days_since ?? '—';
        const avail = d.status === 'Available';
        const availEl = document.getElementById('pf-avail-stat');
        availEl.textContent = avail ? 'Yes' : 'No';
        availEl.className = 'text-2xl font-extrabold ' + (avail ? 'text-emerald-500' : 'text-gray-400');

        const panel = document.getElementById('profile-panel');
        panel.classList.remove('hidden');
        panel.scrollIntoView({ behavior: 'smooth' });

        if (d.latitude && d.longitude) {
            document.getElementById('pf-dist-stat').textContent = haversine(23.7039, 90.3772, d.latitude, d.longitude).toFixed(1);
            setTimeout(() => {
                if (donorMap) { donorMap.remove(); donorMap = null; }
                donorMap = L.map('donor-map').setView([d.latitude, d.longitude], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(donorMap);
                const icon = L.divIcon({ html: `<div style="background:#dc2626;width:14px;height:14px;border-radius:50%;border:3px solid white;box-shadow:0 0 0 2px #dc2626;"></div>`, iconSize:[14,14], iconAnchor:[7,7], className:'' });
                L.marker([d.latitude, d.longitude], { icon }).addTo(donorMap).bindPopup(`<b>${d.name}</b><br>${d.blood_group}`).openPopup();
            }, 100);
        }
    }

    function haversine(lat1,lon1,lat2,lon2) {
        const R=6371,dLat=deg2rad(lat2-lat1),dLon=deg2rad(lon2-lon1);
        const a=Math.sin(dLat/2)**2+Math.cos(deg2rad(lat1))*Math.cos(deg2rad(lat2))*Math.sin(dLon/2)**2;
        return R*(2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a)));
    }
    function deg2rad(d){ return d*(Math.PI/180); }

    async function toggleAvail(id, btn) {
        const r = await fetch('/api/dashboard/donor/toggle', { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'}, body:JSON.stringify({donor_id:id}) });
        const d = await r.json();
        if (d.success) { loadDonors(); loadStats(); }
    }

    async function registerDonor() {
        const name=document.getElementById('reg-name').value,blood=document.getElementById('reg-blood').value,
              location=document.getElementById('reg-location').value,lat=document.getElementById('reg-lat').value,
              lng=document.getElementById('reg-lng').value,phone=document.getElementById('reg-phone').value,
              email=document.getElementById('reg-email').value;
        if (!name||!blood||!location||!phone) { showRegStatus('error','Please fill all required fields.'); return; }
        const r = await fetch('/api/dashboard/donor/register',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},body:JSON.stringify({name,blood_group:blood,location,latitude:lat||23.8103,longitude:lng||90.4125,phone,email})});
        const d = await r.json();
        if (d.success) { showRegStatus('ok','Donor registered successfully!'); setTimeout(()=>{ document.getElementById('register-modal').classList.remove('open'); loadDonors(); loadStats(); }, 1200); }
        else showRegStatus('error','Registration failed.');
    }
    function showRegStatus(type, msg) {
        const el = document.getElementById('reg-status');
        el.classList.remove('hidden');
        el.className = 'mb-4 p-3 rounded-xl text-xs font-bold ' + (type==='ok' ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : 'bg-red-50 border border-red-200 text-red-700');
        el.textContent = msg;
    }

    // ── MODULE 2 ──────────────────────────────────────────────
    let careDonors = [], selectedCareId = null;

    async function loadCarePanel() {
        const r = await fetch('/api/dashboard/donors?limit=50'); const d = await r.json();
        careDonors = d.donors;
        const list = document.getElementById('care-donor-list');
        list.innerHTML = careDonors.map(d => `
            <div class="care-donor-item" onclick="selectCareDonor(${d.id})" id="cdp-${d.id}">
                <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#fca5a5,#dc2626);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:white;flex-shrink:0">${(d.initials||d.name[0])}</div>
                <div><p class="text-xs font-bold text-gray-800">${d.name}</p><p class="text-[10px] text-gray-400 font-mono">${d.blood_group}</p></div>
            </div>`).join('');
        updateClocks();
        setInterval(updateClocks, 1000);
    }

    async function selectCareDonor(id) {
        selectedCareId = id;
        // Reset alert fired state for the new donor selection
        Object.keys(careAlertFired).forEach(k => careAlertFired[k] = false);
        document.querySelectorAll('.care-donor-item').forEach(el => el.classList.remove('active'));
        document.getElementById('cdp-' + id)?.classList.add('active');
        const donor = careDonors.find(d => d.id == id);
        if (donor) {
            document.getElementById('rec-donor-name').textContent = donor.name;

            // Reset all care fields to defaults first
            document.getElementById('hyd-start').value = '08:00';
            document.getElementById('hyd-end').value = '20:00';
            document.getElementById('rest-start').value = '09:00';
            document.getElementById('rest-end').value = '17:00';
            document.getElementById('nut-start').value = '07:00';
            document.getElementById('nut-end').value = '21:00';

            if (donor.last_donation) {
                const days = Math.floor((Date.now() - new Date(donor.last_donation)) / 86400000);
                const totalDays = 42; // 6 weeks
                const pct = Math.min(100, Math.round(days / totalDays * 100));
                document.getElementById('rec-bar').style.width = pct + '%';
                document.getElementById('rec-since').textContent = days + ' days since donation';
                setRing('rec-ring', pct);
                document.getElementById('rec-pct').textContent = pct + '%';
                document.getElementById('rec-label').textContent = pct + '% recovered';
                if (pct >= 100) triggerCareAlert('rec');
            }

            // Load saved care schedule for this donor
            try {
                const r = await fetch('/api/dashboard/care/' + id);
                if (r.ok) {
                    const care = await r.json();
                    if (care.hydration_start) document.getElementById('hyd-start').value = care.hydration_start.substring(0,5);
                    if (care.hydration_end) document.getElementById('hyd-end').value = care.hydration_end.substring(0,5);
                    if (care.rest_start) document.getElementById('rest-start').value = care.rest_start.substring(0,5);
                    if (care.rest_end) document.getElementById('rest-end').value = care.rest_end.substring(0,5);
                    if (care.nutrition_start) document.getElementById('nut-start').value = care.nutrition_start.substring(0,5);
                    if (care.nutrition_end) document.getElementById('nut-end').value = care.nutrition_end.substring(0,5);
                }
            } catch(e) {
                console.log('No saved care schedule for this donor');
            }
        }
    }

    async function saveCare() {
        if (!selectedCareId) { showCareStatus('error','Please select a donor first.'); return; }
        const payload = { donor_id: selectedCareId,
            hydration_start: document.getElementById('hyd-start').value+':00', hydration_end: document.getElementById('hyd-end').value+':00',
            rest_start: document.getElementById('rest-start').value+':00',     rest_end: document.getElementById('rest-end').value+':00',
            nutrition_start: document.getElementById('nut-start').value+':00', nutrition_end: document.getElementById('nut-end').value+':00' };
        const r = await fetch('/api/dashboard/care', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},body:JSON.stringify(payload)});
        const d = await r.json();
        showCareStatus(d.success ? 'ok' : 'error', d.success ? 'Schedule saved!' : 'Save failed.');
    }
    function showCareStatus(type, msg) {
        const el = document.getElementById('care-status');
        el.classList.remove('hidden');
        el.className = 'mb-4 p-3 rounded-2xl text-xs font-bold ' + (type==='ok' ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : 'bg-red-50 border border-red-200 text-red-700');
        el.textContent = msg;
        setTimeout(() => el.classList.add('hidden'), 3000);
    }
    function resetCareCard(prefix, start, end) {
        document.getElementById(prefix+'-start').value = start;
        document.getElementById(prefix+'-end').value = end;
    }

    // ── CARE ALERT SYSTEM ─────────────────────────────────────
    const careAlertFired = { hyd: false, rest: false, nut: false, rec: false };
    const careAlertConfig = {
        hyd:  { icon: '💧', title: 'Hydration Complete!',  msg: 'The hydration window has ended. The donor has completed their hydration schedule.' },
        rest: { icon: '🛌', title: 'Rest Period Complete!', msg: 'The rest reminder window has ended. The donor can gradually resume light activity.' },
        nut:  { icon: '🥩', title: 'Nutrition Window Done!', msg: 'The nutrition boost window has ended. Iron levels should be replenishing.' },
        rec:  { icon: '⏱', title: 'Full Recovery Reached!', msg: 'The donor has reached 100% recovery. Blood volume is fully replenished!' },
    };

    function playCareSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const playBeep = (freq, start, dur) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);
                osc.frequency.value = freq;
                osc.type = 'sine';
                gain.gain.setValueAtTime(0, ctx.currentTime + start);
                gain.gain.linearRampToValueAtTime(0.35, ctx.currentTime + start + 0.02);
                gain.gain.linearRampToValueAtTime(0, ctx.currentTime + start + dur);
                osc.start(ctx.currentTime + start);
                osc.stop(ctx.currentTime + start + dur + 0.05);
            };
            playBeep(880, 0,    0.15);
            playBeep(1100, 0.18, 0.15);
            playBeep(1320, 0.36, 0.25);
        } catch(e) {}
    }

    function triggerCareAlert(type) {
        if (careAlertFired[type]) return;
        careAlertFired[type] = true;
        const cfg = careAlertConfig[type];
        document.getElementById('care-alert-icon').textContent  = cfg.icon;
        document.getElementById('care-alert-title').textContent = cfg.title;
        document.getElementById('care-alert-msg').textContent   = cfg.msg;
        document.getElementById('care-alert-overlay').classList.add('open');
        playCareSound();
    }

    function updateClocks() {
        const now = new Date();
        const hhmm = now.toTimeString().substring(0,8);
        ['hyd-clock','rest-clock','nut-clock','rec-clock'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = hhmm;
        });
        const toPct = (startEl, endEl) => {
            const now = new Date(), s = document.getElementById(startEl).value, e = document.getElementById(endEl).value;
            if (!s||!e) return 0;
            const toMins = t => { const [h,m]=t.split(':'); return +h*60+ +m; };
            const nowM = now.getHours()*60+now.getMinutes(), sM = toMins(s), eM = toMins(e);
            if (nowM < sM) return 0;
            if (nowM > eM) return 100;
            return Math.round((nowM-sM)/(eM-sM)*100);
        };
        [['hyd','hyd-start','hyd-end'],['rest','rest-start','rest-end'],['nut','nut-start','nut-end']].forEach(([p,s,e]) => {
            const pct = toPct(s,e);
            setRing(p+'-ring', pct);
            document.getElementById(p+'-pct').textContent = pct + '%';
            if (pct >= 100) triggerCareAlert(p);
        });
    }
    function setRing(id, pct) {
        const el = document.getElementById(id);
        if (!el) return;
        const circumference = 131.95;
        el.style.strokeDashoffset = circumference - (pct / 100) * circumference;
    }

    // ── MODULE 3 ──────────────────────────────────────────────
    let allRequests = [], allConfirmations = [];

    async function loadHospitalData() {
        const hosp = document.getElementById('hosp-select').value;
        document.getElementById('hosp-last-refresh').textContent = 'Last refresh: ' + new Date().toLocaleTimeString();
        const [rReqs, rConf, rStats] = await Promise.all([fetch('/api/dashboard/requests'), fetch('/api/dashboard/confirmations'), fetch('/api/dashboard/stats')]);
        const [dReqs, dConf, dStats] = await Promise.all([rReqs.json(), rConf.json(), rStats.json()]);
        allRequests = dReqs; allConfirmations = dConf;
        const urgent = allRequests.filter(r => r.urgent === 'Urgent').length;
        document.getElementById('hosp-stat-active').textContent = urgent;
        document.getElementById('hosp-stat-fulfilled').textContent = dStats.fulfilled_today || 0;
        document.getElementById('hosp-stat-confirmations').textContent = dConf.length;
        document.getElementById('hosp-stat-critical').textContent = urgent > 0 ? '1+' : '0';
        renderHospRequests();
        const confList = document.getElementById('hosp-confirmation-list');
        if (!dConf.length) { confList.innerHTML = '<p class="text-xs text-gray-400 text-center py-4">No pending confirmations.</p>'; return; }
        confList.innerHTML = dConf.map(d => `
            <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-gray-100 p-4" id="conf-card-${d.id}">
                <div class="flex items-center gap-2 mb-1"><p class="font-bold text-gray-800 text-sm">${d.name}</p><span class="blood-tag">${d.blood_group}</span></div>
                <p class="text-xs text-gray-500 font-mono">${d.phone||'—'}</p>
                <div class="flex gap-2 mt-3">
                    <button onclick="handleDonorConfirmation(${d.id}, 'confirm', this)" class="flex-1 bg-emerald-600 text-white font-black py-1.5 rounded-xl text-xs hover:bg-emerald-700 transition active:scale-95">✓ Confirm</button>
                    <button onclick="handleDonorConfirmation(${d.id}, 'decline', this)" class="flex-1 bg-white border border-red-200 text-red-600 font-bold py-1.5 rounded-xl text-xs hover:bg-red-50 transition active:scale-95">✕ Decline</button>
                </div>
            </div>`).join('');
    }

    function renderHospRequests() {
        const tbody = document.getElementById('hosp-requests-tbody');
        if (!allRequests.length) { tbody.innerHTML = '<tr><td colspan="6" class="text-center py-6 text-gray-400 text-xs">No requests found.</td></tr>'; return; }
        tbody.innerHTML = allRequests.slice(0,20).map(r => `<tr>
            <td><span class="blood-tag">${r.bloodgroup}</span></td>
            <td class="font-bold text-gray-800">${r.noofbags}</td>
            <td><span class="text-xs font-black px-2 py-1 rounded-lg ${r.urgent==='Urgent'?'bg-red-100 text-red-600':'bg-gray-100 text-gray-500'}">${r.urgent||'Normal'}</span></td>
            <td class="text-xs text-gray-600 max-w-[120px] truncate">${r.location}</td>
            <td class="text-xs font-mono text-gray-500">${r.contactno}</td>
            <td class="text-xs text-gray-400 font-mono">${new Date(r.created_at).toLocaleDateString()}</td>
        </tr>`).join('');
    }

    async function submitNewRequest() {
        const blood=document.getElementById('nr-blood').value, bags=document.getElementById('nr-bags').value,
              hosp=document.getElementById('nr-hospital').value, contact=document.getElementById('nr-contact').value,
              urgent=document.getElementById('nr-urgent').checked;
        if (!blood||!bags||!contact) { showNrStatus('error','Please fill all required fields.'); return; }
        const r = await fetch('/api/dashboard/requests/add',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},body:JSON.stringify({bloodgroup:blood,noofbags:bags,location:hosp,contactno:contact,urgent:urgent?'Urgent':''})});
        const d = await r.json();
        if (d.success) { showNrStatus('ok','Request submitted!'); setTimeout(()=>{ document.getElementById('new-request-modal').classList.remove('open'); loadHospitalData(); }, 1200); }
        else showNrStatus('error','Submission failed.');
    }
    function showNrStatus(type, msg) {
        const el = document.getElementById('nr-status');
        el.classList.remove('hidden');
        el.className = 'mb-4 p-3 rounded-xl text-xs font-bold ' + (type==='ok'?'bg-emerald-50 border border-emerald-200 text-emerald-700':'bg-red-50 border border-red-200 text-red-700');
        el.textContent = msg;
    }

    async function handleDonorConfirmation(donorId, action, btn) {
        btn.disabled = true;
        btn.textContent = '…';
        try {
            const r = await fetch('/api/dashboard/confirmations/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                body: JSON.stringify({ donor_id: donorId, action: action })
            });
            const d = await r.json();
            if (d.success) {
                const card = document.getElementById('conf-card-' + donorId);
                if (card) {
                    card.style.transition = 'opacity 0.3s, transform 0.3s';
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(20px)';
                    setTimeout(() => card.remove(), 300);
                }
                // Update confirmations counter
                const stat = document.getElementById('hosp-stat-confirmations');
                if (stat) stat.textContent = Math.max(0, (parseInt(stat.textContent) || 1) - 1);
                // Increment fulfilled if confirmed
                if (action === 'confirm') {
                    const fulfilledStat = document.getElementById('hosp-stat-fulfilled');
                    if (fulfilledStat) fulfilledStat.textContent = (parseInt(fulfilledStat.textContent) || 0) + 1;
                }
            } else {
                btn.disabled = false;
                btn.textContent = action === 'confirm' ? '✓ Confirm' : '✕ Decline';
            }
        } catch(e) {
            btn.disabled = false;
            btn.textContent = action === 'confirm' ? '✓ Confirm' : '✕ Decline';
        }
    }

    // ── MODULE 4 ──────────────────────────────────────────────
    async function loadAnalytics() {
        const r = await fetch('/api/dashboard/analytics'); const d = await r.json();
        const pool = d.donor_pool;
        const avPct = pool.total ? Math.round(pool.available/pool.total*100) : 0;
        const elPct = pool.total ? Math.round(pool.eligible/pool.total*100) : 0;
        document.getElementById('an-response-time').textContent = '12';
        document.getElementById('an-fulfil-rate').textContent = '78%';
        document.getElementById('an-turnout').textContent = avPct + '%';
        document.getElementById('an-shortages').textContent = d.by_blood_group.filter(g => (g.total_units||0) > 2).length;

        // Top demand
        const sorted = [...d.by_blood_group].sort((a,b) => (b.total_units||0)-(a.total_units||0));
        document.getElementById('an-top-demand').textContent = sorted[0]?.bloodgroup ?? '—';

        // Demand chart
        const maxUnits = Math.max(...d.by_blood_group.map(g => g.total_units||0), 1);
        document.getElementById('an-demand-chart').innerHTML = d.by_blood_group.map(g => `
            <div class="flex items-center gap-3">
                <span class="blood-tag w-12 text-center flex-shrink-0">${g.bloodgroup}</span>
                <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-red-400 to-red-600 rounded-full transition-all" style="width:${Math.round((g.total_units||0)/maxUnits*100)}%"></div></div>
                <span class="text-xs font-bold text-gray-500 w-8 text-right">${g.total_units||0}</span>
            </div>`).join('') || '<p class="text-xs text-gray-400 text-center py-4">No request data yet.</p>';

        // Pool breakdown
        document.getElementById('an-pool').innerHTML = `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl"><span class="text-sm font-bold text-gray-700">Total Donors</span><span class="font-extrabold text-gray-800">${pool.total}</span></div>
            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-2xl"><span class="text-sm font-bold text-emerald-700">Available Today</span><span class="font-extrabold text-emerald-700">${pool.available} (${avPct}%)</span></div>
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-2xl"><span class="text-sm font-bold text-blue-700">Eligible (90-day)</span><span class="font-extrabold text-blue-700">${pool.eligible} (${elPct}%)</span></div>`;

        // Donor stats table
        document.getElementById('an-donor-stats-tbody').innerHTML = d.donor_stats.map(ds => `<tr>
            <td class="font-bold text-gray-800 text-sm">${ds.name}</td>
            <td><span class="blood-tag">${ds.blood_group}</span></td>
            <td class="text-xs font-mono text-gray-500">${ds.last_donation ? new Date(ds.last_donation).toLocaleDateString() : 'Never'}</td>
            <td class="text-xs font-bold text-gray-600">${ds.days_since ?? '—'} days</td>
            <td><span class="text-xs font-black px-2 py-1 rounded-lg ${ds.eligible ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700'}">${ds.eligible ? '✅ Can Donate' : '⏳ Not Ready'}</span></td>
        </tr>`).join('');
    }

    // ── REAL-TIME URGENT REQUEST MONITORING ───────────────────
    let lastUrgentTime = null;
    let lastUrgentCount = 0;
    
    async function checkUrgentRequests() {
        try {
            const r = await fetch('/api/dashboard/urgent-status');
            const d = await r.json();
            
            const currentCount = d.count;
            const currentTime = d.last_urgent_time;
            
            // If there's a new urgent request, refresh the hospital data
            if (currentCount > lastUrgentCount || (currentTime && currentTime !== lastUrgentTime)) {
                lastUrgentTime = currentTime;
                lastUrgentCount = currentCount;
                
                // Show notification
                showUrgentNotification(d.urgent_requests[0]);
                
                // Auto-refresh hospital data if viewing that tab
                const hospitalTab = document.getElementById('section-hospital');
                if (hospitalTab && hospitalTab.classList.contains('active')) {
                    loadHospitalData();
                }
            }
        } catch (e) {
            console.error('Error checking urgent requests:', e);
        }
    }
    
    function showUrgentNotification(request) {
        // Create notification element
        const notif = document.createElement('div');
        notif.className = 'fixed top-4 right-4 bg-red-600 text-white px-6 py-4 rounded-2xl shadow-lg z-50 animate-pulse max-w-xs';
        notif.innerHTML = `
            <p class="font-black text-sm mb-1">🚨 URGENT REQUEST POSTED!</p>
            <p class="text-xs opacity-90">${request.bloodgroup} blood needed in ${request.location}</p>
            <p class="text-xs opacity-75 mt-1">${request.noofbags} bag(s) needed</p>
        `;
        document.body.appendChild(notif);
        
        // Play notification sound if available
        const audio = new Audio('data:audio/wav;base64,UklGRiYAAABXQVZFZm10IBAAAAABAAEAQB8AAAB9AAACABAAZGF0YQIAAAAAAAA=');
        audio.play().catch(() => {});
        
        // Remove notification after 8 seconds
        setTimeout(() => notif.remove(), 8000);
    }
    
    // Start monitoring urgent requests every 5 seconds
    setInterval(checkUrgentRequests, 5000);

    // ── INIT ──────────────────────────────────────────────────
    loadStats();
    loadDonors();
    checkUrgentRequests();</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\bloodConnect\resources\views/dashboard.blade.php ENDPATH**/ ?>