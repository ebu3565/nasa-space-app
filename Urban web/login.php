<?php
// Get the current page name for active state
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sustainable Planet — Urban Planner Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <style>
    :root{
      --bg:#0b1220; --panel:#11192b; --muted:#94a3b8; --text:#e2e8f0; --brand:#22d3ee; --accent:#60a5fa; --ok:#34d399; --warn:#fbbf24; --bad:#ef4444;
      --card:#0f172a; --chip:#1f2937;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{margin:0;font-family:Inter,system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:radial-gradient(1200px 800px at 80% -10%,rgba(96,165,250,.15),transparent),linear-gradient(180deg,#0b1220,#0b1220);color:var(--text)}
    a{color:var(--brand);text-decoration:none}
    .glass{backdrop-filter: blur(10px); background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.06)}

    /* Layout */
    .shell{display:grid; grid-template-columns: 280px 1fr; height:100vh}
    .sidebar{padding:20px; border-right:1px solid rgba(255,255,255,.06); background:linear-gradient(180deg, rgba(17,25,43,.9), rgba(17,25,43,.6));}
    .main{display:flex; flex-direction:column; height:100vh}
    .topbar{display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid rgba(255,255,255,.06);}
    .content{padding:20px; overflow:auto}

    /* Cards & UI */
    .logo{display:flex;align-items:center;gap:10px;font-weight:800;letter-spacing:.5px}
    .logo .dot{width:10px;height:10px;border-radius:50%;background:conic-gradient(from 0deg, var(--brand), var(--accent));box-shadow:0 0 10px var(--brand)}
    .nav{display:flex;flex-direction:column;gap:6px;margin-top:16px}
    .nav button{all:unset;display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;cursor:pointer;color:var(--muted)}
    .nav button.active{background:var(--chip);color:var(--text)}
    .metric-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
    .metric{background:var(--card);border:1px solid rgba(255,255,255,.06);padding:16px;border-radius:16px}
    .metric .k{font-size:28px;font-weight:700}
    .metric small{color:var(--muted)}
    .panel{background:var(--card);border:1px solid rgba(255,255,255,.06);border-radius:16px;padding:16px}
    .panel h3{margin:0 0 10px 0}
    .grid-2{display:grid;grid-template-columns:1.4fr 1fr;gap:16px}
    .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
    .chips{display:flex;gap:8px;flex-wrap:wrap}
    .chip{background:var(--chip);border:1px solid rgba(255,255,255,.06);padding:6px 10px;border-radius:999px;color:var(--muted);font-size:12px}

    /* Map & charts */
    #map-waste,#map-floods,#map-air,#map-ndvi{height:400px;border-radius:12px}
    canvas{background:transparent}

    /* Login */
    .login-wrap{display:grid;place-items:center;height:100vh;padding:24px}
    .login{width:min(440px,100%);padding:24px;border-radius:16px}
    .login h1{margin:0 0 8px 0}
    .field{display:flex;flex-direction:column;gap:6px;margin:10px 0}
    .field input{padding:12px;border-radius:12px;border:1px solid rgba(255,255,255,.1);background:#0b1020;color:var(--text)}
    .btn{all:unset;display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--brand),var(--accent));color:#0b1220;padding:10px 14px;border-radius:12px;font-weight:700;cursor:pointer;box-shadow:0 10px 22px rgba(34,211,238,.25)}
    .btn.secondary{background:transparent;color:var(--text);border:1px solid rgba(255,255,255,.2);box-shadow:none}

    @media (max-width: 1100px){.metric-grid{grid-template-columns:repeat(2,1fr)}.grid-2{grid-template-columns:1fr}.shell{grid-template-columns:1fr}.sidebar{position:sticky;top:0;z-index:10}}
  
            .actived:hover {
            background: linear-gradient(135deg, var(--brand), var(--accent));;
            color: white;
        }
  
  </style>
</head>
<body>
<!-- Login Screen -->
<section id="auth" class="login-wrap">
  <div class="login glass" style="position: relative;">
    <!-- Back Button - Only shows on login page -->
    <button class="btn secondary" onclick="goBack()" style="position: absolute; top: -60px; left: -350px; padding: 8px 12px; font-size: 14px;">
      ← Back
    </button>

    <div class="logo" style="margin-bottom:10px">
      <span class="dot"></span>
      <span>Sustainable Planet</span>
    </div>
    <h1>Urban Planner Login</h1>
    <p style="color:var(--muted);margin:0 0 14px 0">Access the interactive dashboard for Dhaka City insights.</p>
    <div class="field">
      <label>Username</label>
      <input id="username" placeholder="e.g. planner@dhaka.gov.bd" />
    </div>
    <div class="field">
      <label>Password</label>
      <input id="password" type="password" placeholder="••••••••" />
    </div>
    <div style="display:flex;gap:10px;align-items:center;margin-top:12px">
      <button class="btn" onclick="login()">Sign in</button>
      <button class="btn secondary" onclick="fillDemo()">Use demo account</button>
    </div>
    <p style="color:var(--muted);font-size:12px;margin-top:14px">For NASA Space Apps Challenge 2025 — prototype only. Do not use real credentials.</p>
  </div>
</section>

<!-- App Shell -->
<section id="app" class="shell" style="display:none">
  <aside class="sidebar">
    <div class="logo">
      <span class="dot"></span>
      <span>Sustainable Planet</span>
    </div>
    <div class="chips" style="margin-top:12px">
      <span class="chip">Dhaka City</span>
      <span class="chip">NASA Open Data</span>
    </div>

    <nav class="nav">
      <button class="active" data-page="dashboard" onclick="switchPage(event)">📊 Dashboard</button>
      <button data-page="waste" onclick="switchPage(event)">🗑️ Waste Management</button>
      <button data-page="rain" onclick="switchPage(event)">🌧️ Rainfall (NASA POWER)</button>
      <button data-page="floods" onclick="switchPage(event)">🌊 Flood Events (EONET)</button>
      <button data-page="air" onclick="switchPage(event)">💨 Air Pollution (Aerosol)</button>
      <button data-page="ndvi" onclick="switchPage(event)">🌱 Green Space / NDVI</button>
      <button data-page="about" onclick="switchPage(event)">ℹ️ About</button>
      <button href="#" onclick="logout()" class="actived" >🔒 Log out</button>
    </nav>

    <div style="position:absolute;bottom:16px;left:20px;right:20px;color:var(--muted);font-size:12px">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
        <span id="userTag">Logged in</span>
    
      </div>
    </div>
  </aside>

  <main class="main">
    <header class="topbar">
      <div style="display:flex;align-items:center;gap:10px">
        <strong id="pageTitle">Dashboard</strong>
        <span class="chip" id="now"></span>
      </div>
      <div style="display:flex;gap:8px;align-items:center">
        <input id="dateFrom" type="date" />
        <input id="dateTo" type="date" />
        <button class="btn" onclick="applyDates()">Apply dates</button>
      </div>
    </header>

    <div id="page-dashboard" class="content">
      <div class="metric-grid">
        <div class="metric">
          <div>Est. Waste Collected / day</div>
          <div class="k" id="m-waste">—</div>
          <small id="m-waste-note">Loading baseline…</small>
        </div>
        <div class="metric">
          <div>Avg. Daily Rain (mm)</div>
          <div class="k" id="m-rain">—</div>
          <small id="m-rain-note">NASA POWER</small>
        </div>
        <div class="metric">
          <div>Active Flood Events</div>
          <div class="k" id="m-floods">—</div>
          <small id="m-floods-note">EONET, Bangladesh bbox</small>
        </div>
        <div class="metric">
          <div>Aerosol (AOD) today</div>
          <div class="k" id="m-aod">—</div>
          <small id="m-aod-note">MODIS Terra (GIBS)</small>
        </div>
      </div>

      <div class="grid-2" style="margin-top:16px">
        <div class="panel">
          <h3>Rainfall trend — Dhaka</h3>
          <canvas id="rainChart" height="140"></canvas>
        </div>
        <div class="panel">
          <h3>Flood events near Bangladesh</h3>
          <div id="map-floods"></div>
        </div>
      </div>

      <div class="grid-3" style="margin-top:16px">
        <div class="panel">
          <h3>Aerosol (Air Pollution) — Map</h3>
          <div id="map-air"></div>
        </div>
        <div class="panel">
          <h3>NDVI (Green space) — Compare</h3>
          <input id="ndviDateA" type="date" style="margin-bottom:6px"/> vs
          <input id="ndviDateB" type="date" style="margin:6px 0"/>
          <input id="ndviBlend" type="range" min="0" max="100" value="50" oninput="blendNDVI(this.value)" style="width:100%"/>
          <div id="map-ndvi" style="margin-top:8px"></div>
        </div>
        <div class="panel">
          <h3>Quick actions</h3>
          <div class="chips">
            <button class="btn" onclick="exportPNG()">Export snapshot PNG</button>
            <button class="btn secondary" onclick="toggleDark()">Toggle theme</button>
          </div>
          <p style="color:var(--muted)">Tip: adjust the date range above and watch the dashboards update.</p>
        </div>
      </div>
    </div>

    <!-- Waste Management -->
    <div id="page-waste" class="content" style="display:none">
      <div class="grid-2">
        <div class="panel">
          <h3>Waste Management — Dhaka City</h3>
          <p class="muted">Prototype map with landfill sites and collection zones. Upload CSV/GeoJSON to add assets.</p>
          <div id="map-waste"></div>
        </div>
        <div class="panel">
          <h3>Assets & Upload</h3>
          <div class="chips">
            <label class="btn secondary">Upload CSV<input id="csvInput" type="file" accept=".csv" hidden onchange="loadCSV(event)"/></label>
            <label class="btn secondary">Upload GeoJSON<input id="geojsonInput" type="file" accept=".geojson,.json" hidden onchange="loadGeoJSON(event)"/></label>
          </div>
          <div id="wasteStats" style="margin-top:10px;color:var(--muted)">No assets uploaded yet.</div>
          <ul id="wasteList"></ul>
        </div>
      </div>
    </div>

    <!-- Rain -->
    <div id="page-rain" class="content" style="display:none">
      <div class="panel">
        <h3>NASA POWER — Rainfall (PRECTOTCORR) for Dhaka</h3>
        <canvas id="rainChart2" height="160"></canvas>
        <p style="color:var(--muted)">Source: NASA POWER Daily, point (23.8103, 90.4125).
          <br/>Parameters: PRECTOTCORR (Corrected Precipitation), temporal=daily.</p>
      </div>
    </div>

    <!-- Floods -->
    <div id="page-floods" class="content" style="display:none">
      <div class="grid-2">
        <div class="panel"><h3>EONET Flood Events Map</h3><div id="map-floods2"></div></div>
        <div class="panel"><h3>Recent flood events (list)</h3><ul id="floodList"></ul></div>
      </div>
    </div>

    <!-- Air -->
    <div id="page-air" class="content" style="display:none">
      <div class="panel">
        <h3>Aerosol Optical Depth (AOD) — MODIS Terra (GIBS)</h3>
        <p class="muted">This layer approximates air pollution via aerosol load. Use the map to inspect today and past dates.</p>
        <div id="map-air2" style="height:520px;border-radius:12px"></div>
      </div>
    </div>

    <!-- NDVI -->
    <div id="page-ndvi" class="content" style="display:none">
      <div class="panel">
        <h3>Green Land Space — NDVI (16-day) comparison</h3>
        <div class="chips" style="margin-bottom:8px">
          <input id="ndviDateA2" type="date"/> vs <input id="ndviDateB2" type="date"/>
          <button class="btn" onclick="applyNDVICompare()">Compare</button>
        </div>
        <div id="map-ndvi2" style="height:520px;border-radius:12px"></div>
      </div>
    </div>

    <!-- About -->
    <div id="page-about" class="content" style="display:none">
      <div class="panel">
        <h3>About Sustainable Planet</h3>
        <p>Built for NASA Space Apps Challenge 2025, this prototype showcases how an urban planner could integrate NASA Earth observation datasets to support evidence-based decisions for Dhaka City.</p>
        <ul>
          <li>Rainfall: <strong>NASA POWER</strong> (PRECTOTCORR)</li>
          <li>Floods: <strong>NASA EONET</strong> events API</li>
          <li>Air Pollution proxy: <strong>GIBS MODIS Terra Aerosol Optical Depth</strong></li>
          <li>Green space: <strong>GIBS MODIS Terra NDVI 16-Day</strong> (time-enabled)</li>
        </ul>
        <p style="color:var(--muted)">Note: Some NASA services require additional credentials (Earthdata Login). This demo uses public endpoints where possible. The provided API key is used for NASA Planetary Earth endpoints to fetch available imagery dates around Dhaka, which you can leverage to align GIBS layers.</p>
      </div>
    </div>

  </main>
</section>

<script>
  /*****************
   * Global Config *
   *****************/
  const API_KEY = 'hQaqbX8mbr6JPjQ5UmbQ1dPYZ2lydQ5omHDGXK6I'; // Provided by user
  const DHAKA = { lat: 23.8103, lng: 90.4125 };
  const DEFAULT_FROM = new Date(new Date().getFullYear(), 0, 1); // Jan 1 current year
  const DEFAULT_TO = new Date();
  const fmtDate = (d)=> d.toISOString().slice(0,10);

  document.getElementById('dateFrom').value = fmtDate(DEFAULT_FROM);
  document.getElementById('dateTo').value = fmtDate(DEFAULT_TO);
  document.getElementById('now').textContent = new Date().toLocaleString();

  /*********** Auth (demo only) ***********/
  function fillDemo(){
    document.getElementById('username').value = 'urban.planner@dhaka.gov.bd';
    document.getElementById('password').value = 'spaceapps2025';
  }
  function login(){
    const u = document.getElementById('username').value.trim();
    const p = document.getElementById('password').value.trim();
    if(!u || !p){ alert('Please enter username & password (demo values are fine).'); return; }
    localStorage.setItem('sp_user', JSON.stringify({u}));
    document.getElementById('userTag').textContent = `Logged in as ${u}`;
    document.getElementById('auth').style.display = 'none';
    document.getElementById('app').style.display = 'grid';
    initApp();
  }
  function logout(){
    localStorage.removeItem('sp_user');
    location.reload();
  }

  /*********** Navigation ***********/
  function switchPage(e){
    document.querySelectorAll('.nav button').forEach(b=>b.classList.remove('active'));
    e.currentTarget.classList.add('active');
    const page = e.currentTarget.dataset.page;
    document.getElementById('pageTitle').textContent = e.currentTarget.textContent.replace(/^[^\w]+\s*/, '');
    document.querySelectorAll('[id^="page-"]').forEach(p=>p.style.display='none');
    document.getElementById(`page-${page}`).style.display = 'block';
    // Lazy initialize page-specific maps if needed
    if(page==='waste' && !window._wasteReady) setupWaste();
    if(page==='floods' && !window._floodsReady2) setupFloodsPage();
    if(page==='air' && !window._airReady2) setupAirMaps(true);
    if(page==='ndvi' && !window._ndviReady2) setupNDVIPage();
  }

  function applyDates(){
    const from = document.getElementById('dateFrom').value;
    const to = document.getElementById('dateTo').value;
    fetchRain(from, to);
    fetchFloods();
    // Air & NDVI maps are time-enabled via their own date pickers
  }

  function toggleDark(){
    document.body.classList.toggle('light');
  }

  /*********** Init ***********/
  let rainChart, rainChart2, mapFloods, mapFloods2, mapAir, mapAir2, mapWaste, mapNDVI, mapNDVI2;
  let ndviLayerA, ndviLayerB; // for blend

  async function initApp(){
    // Dashboard: init charts and maps
    setupAirMaps(false); // sets mapAir for dashboard small map
    setupFloodsMap();
    setupNDVIMini();

    // Fetch datasets
    const from = document.getElementById('dateFrom').value;
    const to = document.getElementById('dateTo').value;
    fetchRain(from, to);
    fetchFloods();
    estimateWaste();

    // Also set up the detailed charts/maps tabs on first open
    setupRainDetail();
  }

  /*********** Waste Management (prototype) ***********/
  const defaultSites = [
    { name: 'Aminbazar Landfill', type:'Landfill', lat:23.804, lng:90.278, capacityTpd:3000 },
    { name: 'Matuail Landfill', type:'Landfill', lat:23.712, lng:90.468, capacityTpd:3500 }
  ];

  function setupWaste(){
    window._wasteReady = true;
    mapWaste = L.map('map-waste').setView([DHAKA.lat, DHAKA.lng], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'© OpenStreetMap'}).addTo(mapWaste);
    const layer = L.layerGroup().addTo(mapWaste);
    defaultSites.forEach(s=>{
      const m=L.marker([s.lat,s.lng]).addTo(layer);
      m.bindPopup(`<b>${s.name}</b><br/>${s.type}<br/>Capacity: ${s.capacityTpd} t/day`);
    });
    updateWasteList(defaultSites);
  }

  function updateWasteList(items){
    const ul = document.getElementById('wasteList');
    ul.innerHTML='';
    items.forEach(i=>{
      const li = document.createElement('li');
      li.textContent = `${i.type}: ${i.name}`;
      ul.appendChild(li);
    });
    document.getElementById('wasteStats').textContent = `Assets loaded: ${items.length}.`;
  }

  function loadCSV(ev){
    const file = ev.target.files[0]; if(!file) return;
    const reader = new FileReader();
    reader.onload = ()=>{
      const rows = reader.result.split(/\r?\n/).filter(Boolean).map(r=>r.split(','));
      const headers = rows.shift();
      const latIdx = headers.findIndex(h=>/lat/i.test(h));
      const lngIdx = headers.findIndex(h=>/(lon|lng|long)/i.test(h));
      const nameIdx = headers.findIndex(h=>/name/i.test(h));
      const typeIdx = headers.findIndex(h=>/type|category/i.test(h));
      const feats = rows.map(r=>({
        name: r[nameIdx]||'Asset', type:r[typeIdx]||'Asset', lat: +r[latIdx], lng:+r[lngIdx]
      })).filter(f=>!Number.isNaN(f.lat) && !Number.isNaN(f.lng));
      updateWasteList([...defaultSites, ...feats]);
      // render
      const layer = L.layerGroup().addTo(mapWaste);
      feats.forEach(f=> L.circleMarker([f.lat,f.lng],{radius:6,color:'#22d3ee'}).bindPopup(`<b>${f.name}</b><br/>${f.type}`).addTo(layer));
      mapWaste.fitBounds(L.latLngBounds(feats.map(f=>[f.lat,f.lng]).concat([[DHAKA.lat,DHAKA.lng]])));
    };
    reader.readAsText(file);
  }

  function loadGeoJSON(ev){
    const file = ev.target.files[0]; if(!file) return;
    const reader = new FileReader();
    reader.onload = ()=>{
      const gj = JSON.parse(reader.result);
      const layer = L.geoJSON(gj, { style:{color:'#60a5fa',weight:2}, pointToLayer:(f,latlng)=>L.circleMarker(latlng,{radius:5, color:'#34d399'}) }).addTo(mapWaste);
      mapWaste.fitBounds(layer.getBounds());
      document.getElementById('wasteStats').textContent = 'GeoJSON added.';
    };
    reader.readAsText(file);
  }

  function estimateWaste(){
    // Simple synthetic estimate for demo — replace with real city data later
    const pop = 10300000; // Metro Dhaka approx (demo)
    const kgPerCapita = 0.55; // daily
    const tpd = Math.round(pop * kgPerCapita / 1000);
    document.getElementById('m-waste').textContent = tpd.toLocaleString() + ' t';
    document.getElementById('m-waste-note').textContent = 'Est. using pop×kg/cap/day';
  }

  /*********** Rain — NASA POWER ***********/
  async function fetchRain(from, to){
    try{
      const url = new URL('https://power.larc.nasa.gov/api/temporal/daily/point');
      url.search = new URLSearchParams({
        parameters:'PRECTOTCORR',
        start: from.replaceAll('-',''),
        end: to.replaceAll('-',''),
        latitude: DHAKA.lat,
        longitude: DHAKA.lng,
        community: 'AG',
        format:'JSON'
      }).toString();
      const res = await fetch(url);
      const json = await res.json();
      const series = json?.properties?.parameter?.PRECTOTCORR || {};
      const labels = Object.keys(series);
      const data = labels.map(k=> series[k]);
      const avg = (data.reduce((a,b)=>a+b,0) / (data.length||1));
      document.getElementById('m-rain').textContent = avg.toFixed(1) + ' mm';

      const ctx = document.getElementById('rainChart').getContext('2d');
      if(rainChart) rainChart.destroy();
      rainChart = new Chart(ctx, { type:'line', data:{ labels, datasets:[{ label:'Daily Rain (mm)', data, tension:.3, fill:true }]}, options:{ responsive:true, plugins:{legend:{display:false}}, scales:{x:{display:false}} }});

      const ctx2 = document.getElementById('rainChart2').getContext('2d');
      if(rainChart2) rainChart2.destroy();
      rainChart2 = new Chart(ctx2, { type:'bar', data:{ labels, datasets:[{ label:'Rain (mm)', data }]}, options:{ responsive:true, plugins:{legend:{display:false}} }});
    }catch(err){ console.error(err); }
  }

  /*********** Floods — EONET v3 ***********/
  function setupFloodsMap(){
    mapFloods = L.map('map-floods').setView([23.8, 90.4], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:12, attribution:'© OpenStreetMap'}).addTo(mapFloods);
  }
  async function fetchFloods(){
    try{
      // Bangladesh-ish bbox [minLon,minLat,maxLon,maxLat]
      const bbox = [88.0, 20.5, 92.7, 26.7].join(',');
      const url = `https://eonet.gsfc.nasa.gov/api/v3/events?status=all&category=floods&limit=50&bbox=${bbox}`;
      const res = await fetch(url); const j = await res.json();
      const events = j?.events || [];
      document.getElementById('m-floods').textContent = events.length;
      document.getElementById('m-floods-note').textContent = 'Last sync ' + new Date().toLocaleString();

      // Plot on dashboard map
      if(mapFloods){
        const grp = L.layerGroup().addTo(mapFloods);
        events.forEach(ev=>{
          const geoms = ev.geometry||[];
          geoms.forEach(g=>{
            if(g.coordinates?.length===2){
              const [lon,lat] = g.coordinates;
              L.circleMarker([lat,lon],{radius:6}).bindPopup(`<b>${ev.title}</b><br/>${new Date(g.date).toDateString()}`).addTo(grp);
            }
          })
        });
      }

      // Detailed list (if already mounted)
      const ul = document.getElementById('floodList'); if(ul){
        ul.innerHTML='';
        events.forEach(ev=>{
          const li=document.createElement('li');
          li.innerHTML = `<b>${ev.title}</b> — <small>${new Date(ev?.geometry?.[0]?.date||Date.now()).toDateString()}</small>`;
          ul.appendChild(li);
        })
      }
    }catch(e){ console.error(e); }
  }

  function setupFloodsPage(){
    window._floodsReady2 = true;
    mapFloods2 = L.map('map-floods2').setView([23.8, 90.4], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:12, attribution:'© OpenStreetMap'}).addTo(mapFloods2);
    // reuse fetchFloods markers by calling again and plotting also here
    (async()=>{
      const bbox = [88.0, 20.5, 92.7, 26.7].join(',');
      const url = `https://eonet.gsfc.nasa.gov/api/v3/events?status=all&category=floods&limit=50&bbox=${bbox}`;
      const res = await fetch(url); const j = await res.json();
      const events = j?.events || [];
      const grp = L.layerGroup().addTo(mapFloods2);
      events.forEach(ev=>{
        (ev.geometry||[]).forEach(g=>{
          if(Array.isArray(g.coordinates) && g.coordinates.length===2){
            const [lon,lat]=g.coordinates; L.circleMarker([lat,lon],{radius:6}).bindPopup(`<b>${ev.title}</b>`).addTo(grp);
          }
        })
      });
      if(events.length){
        const pts = [];
        events.forEach(ev=> (ev.geometry||[]).forEach(g=>{ if(g.coordinates?.length===2){ const [x,y]=g.coordinates; pts.push([y,x]) }}));
        mapFloods2.fitBounds(L.latLngBounds(pts));
      }
    })();
  }

  /*********** Air — GIBS MODIS AOD ***********/
  function gibsTile(layer, date){
    const d = (date || new Date()).toISOString().slice(0,10);
    const tmpl = `https://gibs.earthdata.nasa.gov/wmts/epsg3857/best/${layer}/default/${d}/GoogleMapsCompatible/` + '{z}/{y}/{x}.png';
    return tmpl;
  }

  function setupAirMaps(forPage){
    if(forPage){
      window._airReady2 = true;
      mapAir2 = L.map('map-air2').setView([DHAKA.lat, DHAKA.lng], 5);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:10, attribution:'© OpenStreetMap'}).addTo(mapAir2);
      const aod = L.tileLayer(gibsTile('MODIS_Terra_Aerosol', new Date()),{opacity:0.8});
      aod.addTo(mapAir2);
    } else {
      mapAir = L.map('map-air').setView([DHAKA.lat, DHAKA.lng], 4);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:7, attribution:'© OpenStreetMap'}).addTo(mapAir);
      const aod = L.tileLayer(gibsTile('MODIS_Terra_Aerosol', new Date()),{opacity:0.8});
      aod.addTo(mapAir);
      document.getElementById('m-aod').textContent = 'map';
      document.getElementById('m-aod-note').textContent = 'Visual only (AOD)';
    }
  }

  /*********** NDVI — compare (GIBS) ***********/
  function setupNDVIMini(){
    mapNDVI = L.map('map-ndvi').setView([DHAKA.lat, DHAKA.lng], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:9, attribution:'© OpenStreetMap'}).addTo(mapNDVI);
    const dateA = new Date(); dateA.setMonth(dateA.getMonth()-12);
    const dateB = new Date();
    ndviLayerA = L.tileLayer(gibsTile('MODIS_Terra_NDVI_16Day', dateA),{opacity:1}).addTo(mapNDVI);
    ndviLayerB = L.tileLayer(gibsTile('MODIS_Terra_NDVI_16Day', dateB),{opacity:.5}).addTo(mapNDVI);
    document.getElementById('ndviDateA').value = fmtDate(dateA);
    document.getElementById('ndviDateB').value = fmtDate(dateB);
  }
  function blendNDVI(v){ if(ndviLayerB) ndviLayerB.setOpacity(v/100); }

  function setupNDVIPage(){
    window._ndviReady2 = true;
    mapNDVI2 = L.map('map-ndvi2').setView([DHAKA.lat, DHAKA.lng], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:10, attribution:'© OpenStreetMap'}).addTo(mapNDVI2);
    // defaults from mini
    const a = document.getElementById('ndviDateA').value;
    const b = document.getElementById('ndviDateB').value;
    window._ndviA2 = L.tileLayer(gibsTile('MODIS_Terra_NDVI_16Day', new Date(a)),{opacity:1}).addTo(mapNDVI2);
    window._ndviB2 = L.tileLayer(gibsTile('MODIS_Terra_NDVI_16Day', new Date(b)),{opacity:0.6}).addTo(mapNDVI2);
    document.getElementById('ndviDateA2').value = a;
    document.getElementById('ndviDateB2').value = b;
  }
  function applyNDVICompare(){
    const a = document.getElementById('ndviDateA2').value;
    const b = document.getElementById('ndviDateB2').value;
    if(window._ndviA2){ window._ndviA2.setUrl(gibsTile('MODIS_Terra_NDVI_16Day', new Date(a))); }
    if(window._ndviB2){ window._ndviB2.setUrl(gibsTile('MODIS_Terra_NDVI_16Day', new Date(b))); }
  }

  /*********** Rain detail setup ***********/
  function setupRainDetail(){ /* nothing extra for now; chart built in fetchRain */ }

  /*********** NASA Planetary Earth Assets (uses api.nasa.gov & API key) ***********/
  async function listEarthAssets(){
    // Fetch available imagery dates near Dhaka (to help pick NDVI or analysis dates)
    try{
      const url = `https://api.nasa.gov/planetary/earth/assets?lon=${DHAKA.lng}&lat=${DHAKA.lat}&begin=2015-01-01&api_key=${API_KEY}`;
      const res = await fetch(url);
      const j = await res.json();
      console.log('Earth assets sample', j?.results?.slice(0,5));
    }catch(e){ console.warn('Earth assets failed (may rate-limit):', e); }
  }
  listEarthAssets();

  function goBack() {
  window.history.back();
}

  /*********** Utilities ***********/
  function exportPNG(){
    // Simple screenshot of the current viewport using HTML2Canvas (CDN)
    const s = document.createElement('script');
    s.src='https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js';
    s.onload=()=>{
      html2canvas(document.querySelector('#page-dashboard')).then(canvas=>{
        const url = canvas.toDataURL('image/png');
        const a = document.createElement('a'); a.href=url; a.download='sustainable-planet-dashboard.png'; a.click();
      })
    };
    document.body.appendChild(s);
  }

  // Auto-show app if prior session exists
  (function(){
    const u = localStorage.getItem('sp_user');
    if(u){ document.getElementById('auth').style.display='none'; document.getElementById('app').style.display='grid'; initApp(); document.getElementById('userTag').textContent = `Logged in as ${JSON.parse(u).u}`; }
  })();
</script>
</body>
</html>
