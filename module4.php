<?php // module4.php — BloodLink Module 4: Analytics Dashboard ?>

<!-- ██ MODULE 4 — PAGE: ANALYTICS DASHBOARD ██ -->
<div class="page" id="page-analytics">
  <div class="pg-title">Analytics Dashboard</div>
  <div class="pg-sub"></div>

  <div class="stats-row" style="grid-template-columns:repeat(5,1fr);margin-bottom:20px">
    <div class="stat">
      <div class="stat-lbl">Avg Response Time</div>
      <div class="stat-num green" id="an-response-time">—</div>
      <div class="stat-hint">minutes</div>
    </div>
    <div class="stat">
      <div class="stat-lbl">Fulfilment Rate</div>
      <div class="stat-num red" id="an-fulfil-rate">—</div>
      <div class="stat-hint">this month</div>
    </div>
    <div class="stat">
      <div class="stat-lbl">Top Demand</div>
      <div class="stat-num amber" id="an-top-demand">—</div>
      <div class="stat-hint">most requested</div>
    </div>
    <div class="stat">
      <div class="stat-lbl">Donor Turnout</div>
      <div class="stat-num green" id="an-turnout">—</div>
      <div class="stat-hint">% responded</div>
    </div>
    <div class="stat">
      <div class="stat-lbl">Critical Shortages</div>
      <div class="stat-num amber" id="an-shortages">—</div>
      <div class="stat-hint">active now</div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">

    <div style="background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:20px">
      <div style="font-family:'Barlow Condensed',sans-serif;font-size:16px;font-weight:800;margin-bottom:4px">Blood Demand by Type</div>
      <div style="font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace;margin-bottom:16px">Units requested per blood group — all time</div>
      <div id="an-demand-chart" style="display:flex;flex-direction:column;gap:9px"></div>
    </div>

    <div style="background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:20px">
      <div style="font-family:'Barlow Condensed',sans-serif;font-size:16px;font-weight:800;margin-bottom:4px">Donor Pool Breakdown</div>
      <div style="font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace;margin-bottom:16px">Eligibility & availability status</div>
      <div style="display:flex;align-items:center;gap:28px">
        <svg id="an-donut-svg" width="130" height="130" viewBox="0 0 130 130"></svg>
        <div id="an-donut-legend" style="display:flex;flex-direction:column;gap:10px;flex:1"></div>
      </div>
    </div>

  </div>

  <div style="background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:20px;margin-bottom:16px">
    <div style="font-family:'Barlow Condensed',sans-serif;font-size:16px;font-weight:800;margin-bottom:4px">Shortage Heatmap</div>
    <div style="font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace;margin-bottom:16px">Supply vs demand by blood group</div>
    <div id="an-heatmap" style="display:grid;grid-template-columns:repeat(8,1fr);gap:8px"></div>
  </div>

  <div style="background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:20px">
    <div style="font-family:'Barlow Condensed',sans-serif;font-size:16px;font-weight:800;margin-bottom:4px">Donor Response Statistics</div>
    <div style="font-size:10px;color:var(--text3);font-family:'IBM Plex Mono',monospace;margin-bottom:16px">Per-donor contribution summary from database</div>
    <div class="tbl-wrap" style="border:none">
      <table>
        <thead>
          <tr>
            <th>Donor</th><th>Blood</th><th>Total Donations</th>
            <th>Last Donation</th>
            <th>Response Rate</th><th>Status</th>
          </tr>
        </thead>
        <tbody id="an-donor-stats-tbody">
          <tr><td colspan="6" class="loading-cell">Loading donor stats…</td></tr>
        </tbody>
      </table>
    </div>
  </div>

</div>