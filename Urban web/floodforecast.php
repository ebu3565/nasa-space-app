<?php
// Get the current page name for active state
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FloodWatcher · NASA EONET Floods</title>
  <meta name="description" content="Interactive map of current flood events from NASA's EONET API" />
  <link rel="preconnect" href="https://unpkg.com" crossorigin>
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin="anonymous"
  />
  <style>
    :root{--bg:#0b1020;--panel:#0f1630;--text:#e6e9f2;--muted:#9aa3b2;--accent:#7cc0ff;--ok:#2ecc71;--warn:#ffb020;--err:#ff5566}
    html,body{height:100%}
    body{margin:0;background:var(--bg);color:var(--text);font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,sans-serif}
    header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:linear-gradient(180deg,rgba(124,192,255,.15),transparent)}
    h1{font-size:1.15rem;margin:0;font-weight:700;letter-spacing:.2px}
    .muted{color:var(--muted)}
    .container{display:grid;grid-template-columns:400px 1fr;grid-template-rows:auto 1fr;gap:0;height:calc(100vh - 64px)}
    #sidebar{background:var(--panel);padding:1rem;border-right:1px solid rgba(255,255,255,.06);overflow:auto}
    #map{height:100%;width:100%}
    .controls{display:grid;gap:.75rem}
    .card{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:.75rem}
    label{display:block;font-size:.8rem;color:var(--muted);margin-bottom:.35rem}
    input,select,button{width:100%;padding:5px 3px;border-radius:10px;border:1px solid rgba(255,255,255,.08);background:#0b132b;color:var(--text)}
    button{cursor:pointer;border-color:rgba(124,192,255,.45);background:rgba(124,192,255,.08)}
    button:hover{background:rgba(124,192,255,.18)}
    .legend{display:flex;flex-wrap:wrap;gap:.35rem;margin-top:.35rem}
    .legend span{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;padding:.25rem .5rem;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.06);border-radius:999px}
    .dot{width:10px;height:10px;border-radius:999px;display:inline-block}
    .dot-open{background:var(--ok)}
    .dot-closed{background:var(--warn)}
    .events{margin-top:.5rem;display:grid;gap:.5rem}
    .event{padding:.6rem;border:1px solid rgba(255,255,255,.08);border-radius:10px}
    .event h3{font-size:.95rem;margin:.1rem 0 .35rem}
    .event small{color:var(--muted)}
    .footer{font-size:.8rem;color:var(--muted);margin-top:.75rem}
    .pill{display:inline-flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);padding:.25rem .5rem;border-radius:999px;font-size:.75rem}
    .key{font-family:ui-monospace,Menlo,Consolas,monospace;color:#b8ffb8}
    a{color:var(--accent)}
    @media (max-width: 1000px){.container{grid-template-columns:1fr;grid-template-rows:360px 1fr} #sidebar{grid-row:2}}
  </style>
</head>
<body>
      <!-- Include Navigation Bar -->
    <?php include 'essentials/navbar.php'; ?>


  <div class="container">
    <aside id="sidebar">
      <div class="controls">
        <div class="card">
          <label for="days">Look-back window (days)</label>
          <input id="days" type="number" min="1" max="365" value="30" />
          <div class="legend"><span><i class="dot dot-open"></i> open</span><span><i class="dot dot-closed"></i> closed</span></div>
        </div>
        <div class="card">
          <label for="bbox">Optional bounding box (minLon,maxLat,maxLon,minLat)</label>
          <input id="bbox" type="text" placeholder="e.g., 80,27,93,20 (Bangladesh region)" />
          <small class="muted">Use WGS84 degrees. Leave empty for global.</small>
        </div>
        <div class="card">
          <label for="status">Status</label>
          <select id="status">
            <option value="open" selected>Open (ongoing)</option>
            <option value="all">All (open + closed)</option>
            <option value="closed">Closed (ended)</option>
          </select>
        </div>
        <div class="card">
          <button id="refresh">Fetch floods</button>
        </div>
        <div class="card">
          <div><strong>NASA API key</strong></div>
          <small class="muted">EONET does not require a key, but we keep it here for future NASA endpoints.</small>
        </div>
        <div class="card">
          <div><strong>Events</strong> <span class="muted" id="count"></span></div>
          <div class="events" id="events"></div>
        </div>
        <div class="footer">Data: <a href="https://eonet.gsfc.nasa.gov/docs/v3" target="_blank" rel="noopener">NASA EONET v3</a>. Map © <a href="https://www.openstreetmap.org/" target="_blank" rel="noopener">OSM</a>.</div>
      </div>
    </aside>

    <main id="map"></main>
  </div>
  <?php include 'essentials/footer.php'; ?>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>
  <script>
    // === CONFIG ===
    const NASA_API_KEY = 'hQaqbX8mbr6JPjQ5UmbQ1dPYZ2lydQ5omHDGXK6I';
    // EONET base
    const EONET_BASE = 'https://eonet.gsfc.nasa.gov/api/v3';

    // === MAP ===
    const map = L.map('map', { zoomControl: true }).setView([20, 0], 2.4);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const floodLayer = L.geoJSON([], {
      style: f => ({
        color: f.properties && f.properties.closed ? '#ffb020' : '#2ecc71',
        weight: 2,
        fillOpacity: 0.2
      }),
      pointToLayer: (f, latlng) => L.circleMarker(latlng, {
        radius: 6,
        color: '#0b1020',
        weight: 1,
        fillColor: f.properties && f.properties.closed ? '#ffb020' : '#2ecc71',
        fillOpacity: 0.95
      }),
      onEachFeature: (feature, layer) => {
        const p = feature.properties || {};
        const coords = feature.geometry && feature.geometry.type === 'Point' ? feature.geometry.coordinates.slice().reverse() : null;
        const date = p.date ? new Date(p.date).toUTCString() : '—';
        const cat = (p.categories || []).map(c => c.title).join(', ');
        const sources = (p.sources || []).map(s => `<a href="${s.url || s.id || '#'}" target="_blank">${s.id || s.title || 'source'}</a>`).join(' · ');
        const status = p.closed ? '<span class="pill">closed</span>' : '<span class="pill">open</span>';
        layer.bindPopup(`
          <div style="min-width:260px">
            <div style="font-weight:700;margin-bottom:.35rem">${p.title || 'Flood event'}</div>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:.35rem">${status}<span class="pill">${cat || 'Floods'}</span></div>
            <div class="muted" style="margin-bottom:.35rem">${date}</div>
            ${coords ? `<div class="muted">Lat ${coords[0].toFixed(3)}, Lon ${coords[1].toFixed(3)}</div>` : ''}
            ${p.description ? `<p style="margin:.5rem 0 0">${p.description}</p>` : ''}
            ${sources ? `<div style="margin-top:.5rem">${sources}</div>` : ''}
          </div>
        `);
      }
    }).addTo(map);

    let bboxLayer; // visualize user BBOX

    // === UI ELEMENTS ===
    const $days = document.getElementById('days');
    const $bbox = document.getElementById('bbox');
    const $status = document.getElementById('status');
    const $events = document.getElementById('events');
    const $count = document.getElementById('count');
    const $refresh = document.getElementById('refresh');

    $refresh.addEventListener('click', fetchFloods);
    window.addEventListener('DOMContentLoaded', fetchFloods);

    async function fetchFloods(){
      try{
        const days = Math.max(1, Math.min(365, parseInt($days.value || '30', 10)));
        const status = $status.value || 'open';
        const bboxTxt = ($bbox.value || '').trim();

        // Build EONET GeoJSON query for Floods
        const params = new URLSearchParams({ category: 'floods', days: String(days), status });
        if(bboxTxt){ params.set('bbox', bboxTxt); drawBBox(bboxTxt); } else { clearBBox(); }
        const url = `${EONET_BASE}/events/geojson?${params.toString()}`;

        // NOTE: EONET v3 does not require an API key. We retain NASA_API_KEY for future NASA endpoints.
        const res = await fetch(url);
        if(!res.ok) throw new Error(`EONET request failed (${res.status})`);
        const gj = await res.json();

        renderMap(gj);
        renderList(gj);
      }catch(err){
        console.error(err);
        alert('Failed to load flood data. See console for details.');
      }
    }

    function renderMap(gj){
      floodLayer.clearLayers();
      if(!gj || !gj.features){ return; }
      floodLayer.addData(gj);
      // Fit to data if available
      try{
        const b = floodLayer.getBounds();
        if(b && b.isValid()) map.fitBounds(b.pad(0.2));
      }catch{ /* no-op */ }
    }

    function renderList(gj){
      const feats = (gj && gj.features) ? gj.features : [];
      $count.textContent = `(${feats.length})`;
      $events.innerHTML = '';
      if(!feats.length){
        $events.innerHTML = `<div class="muted">No events found for the chosen filters.</div>`;
        return;
      }
      // Sort newest first by properties.date
      feats.sort((a,b)=> new Date(b.properties?.date||0) - new Date(a.properties?.date||0));
      for(const f of feats.slice(0, 50)){
        const p = f.properties || {};
        const title = p.title || 'Flood event';
        const date = p.date ? new Date(p.date).toUTCString() : '—';
        const status = p.closed ? 'closed' : 'open';
        const src = (p.sources||[])[0];
        const link = p.link || '#';
        const div = document.createElement('div');
        div.className = 'event';
        div.innerHTML = `
          <h3>${title}</h3>
          <small class="muted">${date} · ${status.toUpperCase()}</small>
          <div style="margin-top:.35rem">
            <a href="${link}" target="_blank" rel="noopener">View in EONET</a>
            ${src ? ` · <a href="${src.url || '#'}" target="_blank" rel="noopener">Source</a>` : ''}
          </div>
        `;
        div.addEventListener('click',()=>{
          try{
            const layer = floodLayer.getLayers().find(l => (l.feature && l.feature.id) === f.id);
            if(layer){ map.fitBounds(layer.getBounds ? layer.getBounds().pad(0.4) : L.latLngBounds([layer.getLatLng()])); layer.openPopup(); }
          }catch{}
        });
        $events.appendChild(div);
      }
    }

    function drawBBox(txt){
      const parts = txt.split(',').map(v=>parseFloat(v.trim()));
      if(parts.length!==4 || parts.some(isNaN)) return clearBBox();
      const [minLon, maxLat, maxLon, minLat] = parts;
      const sw = L.latLng(minLat, minLon);
      const ne = L.latLng(maxLat, maxLon);
      const bounds = L.latLngBounds(sw, ne);
      if(bboxLayer){ map.removeLayer(bboxLayer); }
      bboxLayer = L.rectangle(bounds, { color:'#7cc0ff', weight:1, dashArray:'4 3', fill:false });
      bboxLayer.addTo(map);
      map.fitBounds(bounds.pad(0.1));
    }
    function clearBBox(){ if(bboxLayer){ map.removeLayer(bboxLayer); bboxLayer = null; } }
  </script>
</body>
</html>
