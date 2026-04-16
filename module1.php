<?php // module1.php — BloodLink Module 1: Donor Matching Engine & Donor Profile ?>

<!-- ██ MODULE 1 — PAGE: MATCHING ENGINE ██ -->
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
    <input type="text" id="loc-filter" placeholder="Filter by location…">
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

<!-- ██ MODULE 1 — PAGE: DONOR PROFILE ██ -->
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
