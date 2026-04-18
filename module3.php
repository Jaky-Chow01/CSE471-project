<?php // module3.php — BloodLink Module 3: Hospital Dashboard ?>

<!-- ██ MODULE 3 — PAGE: HOSPITAL DASHBOARD ██ -->
<div class="page" id="page-hospital">
  <div class="pg-title">Hospital Dashboard</div>
  <div class="pg-sub"></div>

  <div class="toolbar" style="margin-bottom:18px">
    <span class="tb-label">HOSPITAL</span>
    <select id="hosp-select" onchange="loadHospitalData()">
      <option value="Dhaka Medical College">Dhaka Medical College</option>
      <option value="Square Hospital">Square Hospital</option>
      <option value="BIRDEM General Hospital">BIRDEM General Hospital</option>
      <option value="Apollo Hospitals Dhaka">Apollo Hospitals Dhaka</option>
      <option value="United Hospital">United Hospital</option>
    </select>
    <button class="btn btn-red" onclick="openNewRequestModal()">+ New Request</button>
    <button class="btn btn-ghost" onclick="loadHospitalData()">↻ Refresh</button>
    <span class="tb-count" id="hosp-last-refresh"></span>
  </div>

  <div class="stats-row" style="grid-template-columns:repeat(4,1fr);margin-bottom:20px">
    <div class="stat">
      <div class="stat-lbl">Active Requests</div>
      <div class="stat-num amber" id="hosp-stat-active">—</div>
      <div class="stat-hint">open right now</div>
    </div>
    <div class="stat">
      <div class="stat-lbl">Fulfilled Today</div>
      <div class="stat-num green" id="hosp-stat-fulfilled">—</div>
      <div class="stat-hint">units received</div>
    </div>
    <div class="stat">
      <div class="stat-lbl">Donor Confirmations</div>
      <div class="stat-num red" id="hosp-stat-confirmations">—</div>
      <div class="stat-hint">awaiting response</div>
    </div>
    <div class="stat">
      <div class="stat-lbl">Critical Shortage</div>
      <div class="stat-num amber" id="hosp-stat-critical">—</div>
      <div class="stat-hint">blood types</div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 340px;gap:16px">

    <div>
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
        <div style="font-family:'Barlow Condensed',sans-serif;font-size:16px;font-weight:800;letter-spacing:.3px">Active Blood Requests</div>
        <div style="display:flex;gap:8px">
          <select id="hosp-urgency-filter" onchange="renderHospRequests()" style="font-size:11px;padding:5px 8px">
            <option value="">All Urgency</option>
            <option value="critical">Critical</option>
            <option value="high">High</option>
            <option value="low">Low</option>
          </select>
          <select id="hosp-status-filter" onchange="renderHospRequests()" style="font-size:11px;padding:5px 8px">
            <option value="">All Status</option>
            <option value="open">Open</option>
            <option value="matched">Matched</option>
            <option value="fulfilled">Fulfilled</option>
          </select>
        </div>
      </div>
      <div class="tbl-wrap">
        <table>
          <thead>
            <tr>
              <th>Blood</th><th>Units</th><th>Urgency</th>
              <th>Status</th><th>Matched Donors</th><th>Posted</th><th>Actions</th>
            </tr>
          </thead>
          <tbody id="hosp-requests-tbody">
            <tr><td colspan="7" class="loading-cell">Loading requests…</td></tr>
          </tbody>
        </table>
      </div>
    </div>

    <div>
      <div style="font-family:'Barlow Condensed',sans-serif;font-size:16px;font-weight:800;letter-spacing:.3px;margin-bottom:10px">Donor Confirmation Queue</div>
      <div id="hosp-confirmation-list" style="display:flex;flex-direction:column;gap:8px">
        <div class="loading-cell">Loading confirmations…</div>
      </div>
    </div>

  </div>


</div>

<!-- New Request Modal -->
<div class="modal-overlay" id="new-request-modal">
  <div class="modal">
    <div class="modal-title">New Blood Request</div>
    <div class="modal-sub">Submit an urgent blood request to the donor matching system.</div>
    <div id="new-request-status" class="status-bar"></div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Blood Group *</label>
        <select id="nr-blood">
          <option value="">Select…</option>
          <option>A+</option><option>A-</option>
          <option>B+</option><option>B-</option>
          <option>AB+</option><option>AB-</option>
          <option>O+</option><option>O-</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Units Required *</label>
        <input type="number" id="nr-units" placeholder="e.g. 2" min="1" max="50">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Hospital *</label>
      <select id="nr-hospital">
        <option>Dhaka Medical College</option>
        <option>Square Hospital</option>
        <option>BIRDEM General Hospital</option>
        <option>Apollo Hospitals Dhaka</option>
        <option>United Hospital</option>
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Urgency *</label>
      <select id="nr-urgency">
        <option value="high">High</option>
        <option value="critical">Critical</option>
        <option value="low">Low</option>
      </select>
    </div>
    <div class="modal-actions">
      <button class="btn btn-ghost" onclick="closeNewRequestModal()">Cancel</button>
      <button class="btn btn-red" onclick="submitNewRequest()">Submit Request</button>
    </div>
  </div>
</div>
