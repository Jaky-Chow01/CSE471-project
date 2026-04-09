<?php // module2.php — BloodLink Module 2: Post-Donation Care Panel ?>

<!-- ██ MODULE 2 — PAGE: POST-DONATION CARE ██ -->
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
