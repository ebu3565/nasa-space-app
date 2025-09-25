<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Planning Environmental Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        :root {
            --primary: #2E86AB;
            --secondary: #A23B72;
            --accent: #F18F01;
            --dark: #2B2D42;
            --light: #F8F9FA;
            --success: #4CAF50;
            --warning: #FFC107;
            --danger: #DC3545;
        }
        
        body {
            background-color: #f0f5f9;
            color: #333;
            line-height: 1.6;
        }
        
        header {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 1.2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem;
            border-radius: 4px;
            transition: background 0.3s;
        }
        
        nav a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 1.5rem;
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .sidebar {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            height: fit-content;
        }
        
        .sidebar-section {
            margin-bottom: 2rem;
        }
        
        .sidebar h2 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--light);
        }
        
        
        
        .layers-list {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        
        .layer-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.8rem;
            background: var(--light);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .layer-item:hover {
            background: #e6f0f7;
        }
        
        .layer-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
        
        .map-container {
            position: relative;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            height: 75vh;
        }
        
        #map {
            height: 100%;
            width: 100%;
            z-index: 1;
        }
        
        .map-overlay {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 2;
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        
        .map-overlay h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .map-controls {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        
        .map-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .visualization-tabs {
            display: flex;
            background: white;
            border-radius: 8px 8px 0 0;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-top: 1.5rem;
        }
        
        .tab {
            padding: 1.2rem 1.5rem;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .tab:hover {
            background: #f0f7ff;
        }
        
        .tab.active {
            background: var(--primary);
            color: white;
            box-shadow: inset 0 -3px 0 var(--dark);
        }
        
        .tab-content {
            display: none;
            background-color: white;
            border-radius: 0 0 8px 8px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .visualization-container {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            height: 600px;
        }
        
        iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }
        
        .info-section {
            margin-top: 2rem;
        }
        
        .info-section h2 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            line-height: 1.7;
        }
        
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .stat-card {
            flex: 1;
            min-width: 200px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        @media (max-width: 1200px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                order: 2;
            }
            
            .map-container {
                order: 1;
            }
        }
        
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            
            .map-overlay {
                width: 90%;
                left: 5%;
                right: 5%;
            }
            
            .stat-card {
                min-width: 100%;
            }
        }


/* Resilience Planner Styles - Exact Copy */
.resilience-planner {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.resilience-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.resilience-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 1.4rem;
}

.resilience-search-container {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 40%;
}

.resilience-search-box {
    position: relative;
    flex: 1;
}

.resilience-search {
    width: 100%;
    padding: 10px 15px 10px 40px;
    border: none;
    border-radius: 30px;
    font-size: 1rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    background: white;
}

.resilience-search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #7f8c8d;
}

.resilience-btn {
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
}

.resilience-btn-primary {
    background-color: var(--secondary);
    color: white;
}

.resilience-main-container {
    display: flex;
    gap: 1.5rem;
    height: 70vh;
}

.resilience-sidebar {
    width: 350px;
    background-color: white;
    padding: 20px;
    overflow-y: auto;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.resilience-map-container {
    flex: 1;
    position: relative;
    border-radius: 8px;
    overflow: hidden;
}

#resilience-map {
    width: 100%;
    height: 100%;
}

.resilience-panel {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 320px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    padding: 15px;
    z-index: 800;
}

.resilience-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.resilience-panel-title {
    font-weight: 700;
    color: var(--primary);
}

.resilience-metric-card {
    background-color: #f8f9fa;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 12px;
    border-left: 4px solid var(--secondary);
}

.resilience-metric-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.resilience-metric-title {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--dark);
}

.resilience-metric-value {
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 5px;
}

.resilience-metric-trend {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    color: #7f8c8d;
}

.resilience-trend-up { color: var(--danger); }
.resilience-trend-down { color: var(--success); }

.resilience-layer-controls {
    background-color: white;
    position: absolute;
    bottom: 20px;
    left: 20px;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    z-index: 800;
    width: 250px;
}

.resilience-control-header {
    font-weight: 700;
    margin-bottom: 10px;
    color: var(--primary);
}

.resilience-layer-item {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.resilience-forecast-controls {
    background-color: white;
    position: absolute;
    top: 20px;
    left: 20px;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    z-index: 800;
    width: 250px;
}

.resilience-slider-container {
    margin: 15px 0;
}

.resilience-slider-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
}

.resilience-recommendation-section {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.resilience-recommendation-card {
    background-color: #e8f4fc;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 12px;
}

.resilience-recommendation-title {
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 8px;
}

.resilience-risk-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

.resilience-risk-high { background-color: #ffeaea; color: #e74c3c; }
.resilience-risk-medium { background-color: #fff4e6; color: #f39c12; }
.resilience-risk-low { background-color: #e6f7ee; color: #27ae60; }

.resilience-tab-container {
    margin-top: 15px;
}

.resilience-tabs {
    display: flex;
    border-bottom: 1px solid #ddd;
    margin-bottom: 15px;
}

.resilience-tab {
    padding: 8px 15px;
    cursor: pointer;
    border-bottom: 3px solid transparent;
}

.resilience-tab.active {
    border-bottom: 3px solid var(--secondary);
    font-weight: 600;
    color: var(--secondary);
}

.resilience-tab-content {
    display: none;
}

.resilience-tab-content.active {
    display: block;
}



/* Bangladesh Waste Management Dashboard Styles */
.waste-dashboard {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    margin-top: 2rem;
}

.waste-header {
    background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
    color: white;
    padding: 20px 0;
    border-radius: 10px;
    margin-bottom: 20px;
    text-align: center;
}

.waste-header h1 {
    font-size: 28px;
    margin-bottom: 5px;
}

.waste-subtitle {
    font-size: 16px;
    opacity: 0.9;
}

.waste-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.waste-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
}

.waste-card-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #1e5799;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

#waste-map {
    height: 500px;
    width: 100%;
    border-radius: 10px;
}

.waste-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-top: 20px;
}

.waste-stat-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    border-left: 4px solid #1e5799;
}

.waste-stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #1e5799;
}

.waste-stat-label {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

.district-list {
    max-height: 400px;
    overflow-y: auto;
}

.district-item {
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.2s;
}

.district-item:hover {
    background-color: #f0f5ff;
}

.district-item:last-child {
    border-bottom: none;
}

.district-name {
    font-weight: 600;
}

.waste-level {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.level-low {
    background-color: #e8f5e9;
    color: #2e7d32;
}

.level-medium {
    background-color: #fff3e0;
    color: #ef6c00;
}

.level-high {
    background-color: #ffebee;
    color: #c62828;
}

.level-critical {
    background-color: #fce4ec;
    color: #ad1457;
}

.red-zone {
    background-color: #ffebee;
    border-left: 4px solid #f44336;
}

.waste-prediction-card {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    color: white;
}

.waste-prediction-title {
    color: white;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
}

.waste-prediction-content {
    display: flex;
    align-items: center;
    gap: 15px;
}

.waste-prediction-icon {
    font-size: 40px;
}

.waste-prediction-text {
    flex: 1;
}

.waste-alert {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 5px;
    padding: 10px 15px;
    margin: 15px 0;
    font-size: 14px;
}

.waste-alert-warning {
    background-color: #fff3cd;
    border-color: #ffeaa7;
    color: #856404;
}

.waste-alert-critical {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.waste-action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.waste-btn {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.waste-btn-primary {
    background-color: #1e5799;
    color: white;
}

.waste-btn-primary:hover {
    background-color: #16457a;
}

.waste-btn-warning {
    background-color: #ffc107;
    color: #212529;
}

.waste-btn-warning:hover {
    background-color: #e0a800;
}

.waste-btn-danger {
    background-color: #dc3545;
    color: white;
}

.waste-btn-danger:hover {
    background-color: #c82333;
}

.waste-chart-container {
    height: 300px;
    margin-top: 20px;
}

.population-growth {
    display: flex;
    align-items: center;
    margin-top: 5px;
    font-size: 14px;
}

.growth-up {
    color: #e53935;
}

.growth-down {
    color: #43a047;
}

.population-icon {
    margin-right: 5px;
}

.waste-tab-container {
    margin-top: 20px;
}

.waste-tabs {
    display: flex;
    border-bottom: 1px solid #ddd;
    margin-bottom: 15px;
}

.waste-tab {
    padding: 10px 20px;
    cursor: pointer;
    border-bottom: 3px solid transparent;
}

.waste-tab.active {
    border-bottom: 3px solid #1e5799;
    font-weight: 600;
    color: #1e5799;
}

.waste-tab-content {
    display: none;
}

.waste-tab-content.active {
    display: block;
}

.waste-nasa-data-info {
    background-color: #e3f2fd;
    padding: 10px 15px;
    border-radius: 5px;
    margin: 15px 0;
    font-size: 14px;
}

.current-time {
    font-size: 14px;
    opacity: 0.9;
}

@media (max-width: 992px) {
    .waste-container {
        grid-template-columns: 1fr;
    }
    
    .waste-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .waste-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .waste-action-buttons {
        flex-direction: column;
    }
}



        
    </style>
</head>
<body>
    <!-- Include Navigation Bar -->
    <?php include 'essentials/navbar.php'; ?>
    
    <div class="container">
        <div class="dashboard">
            <div class="sidebar">
                <div class="sidebar-section">
                    <h2><i class="fas fa-layer-group"></i> Data Layers</h2>
                    <div class="layers-list">
                        <div class="layer-item">
                            <div class="layer-color" style="background: #2E86AB;"></div>
                            <span>Flood Zones</span>
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="layer-item">
                            <div class="layer-color" style="background: #4CAF50;"></div>
                            <span>Forest Cover</span>
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="layer-item">
                            <div class="layer-color" style="background: #A23B72;"></div>
                            <span>Soil Moisture</span>
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="layer-item">
                            <div class="layer-color" style="background: #F18F01;"></div>
                            <span>Urban Areas</span>
                            <i class="fas fa-eye-slash"></i>
                        </div>
                        <div class="layer-item">
                            <div class="layer-color" style="background: #DC3545;"></div>
                            <span>Risk Zones</span>
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-section">
                    <h2><i class="fas fa-info-circle"></i> Map Legend</h2>
                    <div class="layers-list">
                        <div class="layer-item">
                            <div class="layer-color" style="background: #2E86AB;"></div>
                            <span>Water Bodies</span>
                        </div>
                        <div class="layer-item">
                            <div class="layer-color" style="background: #4CAF50;"></div>
                            <span>Dense Vegetation</span>
                        </div>
                        <div class="layer-item">
                            <div class="layer-color" style="background: #8BC34A;"></div>
                            <span>Sparse Vegetation</span>
                        </div>
                        <div class="layer-item">
                            <div class="layer-color" style="background: #FFC107;"></div>
                            <span>Residential Areas</span>
                        </div>
                        <div class="layer-item">
                            <div class="layer-color" style="background: #795548;"></div>
                            <span>Commercial Zones</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="map-container">
                <div id="map"></div>
                <div class="map-overlay">
                    <h3><i class="fas fa-search-location"></i> Location Analysis</h3>
                    <div class="map-controls">
                        <div class="map-control">
                            <input type="text" placeholder="Search address or coordinates..." style="flex: 1; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                            <button style="background: var(--primary); color: white; border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="map-control">
                            <label style="flex: 1;">Opacity: </label>
                            <input type="range" min="0" max="100" value="80" style="flex: 2;">
                        </div>
                        <div class="map-control">
                            <button style="flex: 1; background: var(--primary); color: white; border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-plus"></i> Add Marker
                            </button>
                            <button style="flex: 1; background: var(--secondary); color: white; border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="visualization-tabs">
            <div class="tab active" data-tab="flood">
                <i class="fas fa-water"></i>
                Flood Mapping
            </div>
            <div class="tab" data-tab="forest">
                <i class="fas fa-tree"></i>
                Forest Loss
            </div>
            <div class="tab" data-tab="soil">
                <i class="fas fa-leaf"></i>
                Soil Moisture
            </div>
        </div>
        
        <div class="tab-content active" id="flood-content">
            <div class="visualization-container">
                <iframe src="https://ee-motalebhossainemon.projects.earthengine.app/view/cloud-drone-flood-mapping" title="Flood Mapping Visualization"></iframe>
            </div>
            
            <div class="info-section">
                <h2><i class="fas fa-water"></i> Flood Mapping Analysis</h2>
                <p>This visualization uses satellite imagery and drone data to map flood-affected areas. The technology helps urban planners in disaster response and management by identifying the extent of flooding, assessing damage, and planning relief operations.</p>
                
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-number">23%</div>
                        <div class="stat-desc">of natural disasters are floods</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">$40B</div>
                        <div class="stat-desc">annual global flood damage costs</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">2.3B</div>
                        <div class="stat-desc">people affected by floods since 1998</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-content" id="forest-content">
            <div class="visualization-container">
                <iframe src="https://ee-motalebhossainemon.projects.earthengine.app/view/forest-lost" title="Forest Loss Visualization"></iframe>
            </div>
            
            <div class="info-section">
                <h2><i class="fas fa-tree"></i> Forest Loss Monitoring</h2>
                <p>This tool tracks deforestation patterns over time using satellite imagery. Monitoring forest loss is crucial for urban planners to understand climate change impacts, biodiversity loss, and develop conservation strategies within urban environments.</p>
                
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-number">420 M</div>
                        <div class="stat-desc">hectares of forest lost since 2001</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">12%</div>
                        <div class="stat-desc">of global CO2 emissions from deforestation</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">50%</div>
                        <div class="stat-desc">of world's forests already cleared</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-content" id="soil-content">
            <div class="visualization-container">
                <iframe src="https://ee-motalebhossainemon.projects.earthengine.app/view/soil-mouisture" title="Soil Moisture Visualization"></iframe>
            </div>
            
            <div class="info-section">
                <h2><i class="fas fa-leaf"></i> Soil Moisture Assessment</h2>
                <p>This visualization monitors soil moisture levels using remote sensing technology. Soil moisture data is essential for urban planners in agriculture planning, drought prediction, water resource management, and climate change adaptation strategies.</p>
                
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-number">60%</div>
                        <div class="stat-desc">of water in agriculture is lost due to poor irrigation</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">40%</div>
                        <div class="stat-desc">of global food production affected by drought</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">1.5B</div>
                        <div class="stat-desc">people affected by drought this century</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Urban Resilience Planner Section - Exact Copy -->
<section class="resilience-planner">
    <header class="resilience-header">
        <div class="resilience-logo">
            <i class="fas fa-city"></i>
            <span>Urban Resilience Planner</span>
        </div>
        
        <div class="resilience-search-container">
            <div class="resilience-search-box">
                <i class="fas fa-search resilience-search-icon"></i>
                <input type="text" id="resilience-country-search" class="resilience-search" placeholder="Search for a country...">
            </div>
            <button class="resilience-btn resilience-btn-primary" id="resilience-search-btn">
                <i class="fas fa-play"></i> Analyze
            </button>
        </div>
        
    </header>

    <div class="resilience-main-container">
        <div class="resilience-sidebar">
            <div class="resilience-panel-header">
                <h2 class="resilience-panel-title">Country Overview</h2>
                <i class="fas fa-info-circle" style="color: #7f8c8d;"></i>
            </div>
            
            <div class="resilience-metric-card">
                <div class="resilience-metric-header">
                    <div class="resilience-metric-title">Flood Risk Areas</div>
                    <div class="resilience-risk-badge resilience-risk-high">High</div>
                </div>
                <div class="resilience-metric-value">18.5% of territory</div>
                <div class="resilience-metric-trend">
                    <i class="fas fa-arrow-up resilience-trend-up"></i>
                    <span>Projected increase to 22.3% in 5 years</span>
                </div>
            </div>
            
            <div class="resilience-metric-card">
                <div class="resilience-metric-header">
                    <div class="resilience-metric-title">Forest Loss (5 yrs)</div>
                    <div class="resilience-risk-badge resilience-risk-medium">Moderate</div>
                </div>
                <div class="resilience-metric-value">12,450 km²</div>
                <div class="resilience-metric-trend">
                    <i class="fas fa-arrow-up resilience-trend-up"></i>
                    <span>12% increase from previous period</span>
                </div>
            </div>
            
            <div class="resilience-metric-card">
                <div class="resilience-metric-header">
                    <div class="resilience-metric-title">Air Pollution (PM2.5)</div>
                    <div class="resilience-risk-badge resilience-risk-high">High</div>
                </div>
                <div class="resilience-metric-value">32.4 μg/m³</div>
                <div class="resilience-metric-trend">
                    <i class="fas fa-arrow-down resilience-trend-down"></i>
                    <span>8% improvement in 5 years</span>
                </div>
            </div>
            
            <div class="resilience-metric-card">
                <div class="resilience-metric-header">
                    <div class="resilience-metric-title">Infrastructure Damage</div>
                    <div class="resilience-risk-badge resilience-risk-medium">Moderate</div>
                </div>
                <div class="resilience-metric-value">4,250 buildings</div>
                <div class="resilience-metric-trend">
                    <i class="fas fa-arrow-up resilience-trend-up"></i>
                    <span>Mostly in coastal regions</span>
                </div>
            </div>
            
            <div class="resilience-tabs">
                <div class="resilience-tab active" data-tab="recommendations">Recommendations</div>
                <div class="resilience-tab" data-tab="data-sources">Data Sources</div>
                <div class="resilience-tab" data-tab="methods">Methods</div>
            </div>
            
            <div class="resilience-tab-container">
                <div class="resilience-tab-content active" id="recommendations-content">
                    <div class="resilience-recommendation-section">
                        <h3 class="resilience-recommendation-title">Settlement Suitability</h3>
                        
                        <div class="resilience-recommendation-card">
                            <div class="resilience-metric-header">
                                <div>High Suitability Zones</div>
                                <div class="resilience-risk-badge resilience-risk-low">Low Risk</div>
                            </div>
                            <p>Northern plateau regions show optimal conditions for development with minimal hazard exposure.</p>
                        </div>
                        
                        <div class="resilience-recommendation-card">
                            <div class="resilience-metric-header">
                                <div>Relocation Priority</div>
                                <div class="resilience-risk-badge resilience-risk-high">High Priority</div>
                            </div>
                            <p>Coastal communities in the southeast should be prioritized for relocation programs due to flood risk.</p>
                        </div>
                        
                        <div class="resilience-recommendation-card">
                            <div class="resilience-metric-header">
                                <div>Green Infrastructure</div>
                                <div class="resilience-risk-badge resilience-risk-medium">Moderate Priority</div>
                            </div>
                            <p>Implement urban green corridors in metropolitan areas to reduce air pollution and mitigate heat island effects.</p>
                        </div>
                    </div>
                </div>
                
                <div class="resilience-tab-content" id="data-sources-content">
                    <p><strong>Flood Data:</strong> NASA GFMS, Dartmouth Flood Observatory</p>
                    <p><strong>Forest Cover:</strong> Global Forest Watch, Hansen/GLAD</p>
                    <p><strong>Air Quality:</strong> OpenAQ, WHO database</p>
                    <p><strong>Infrastructure:</strong> OpenStreetMap, UNOSAT</p>
                    <p><strong>Population:</strong> WorldPop, GEOSTAT</p>
                </div>
                
                <div class="resilience-tab-content" id="methods-content">
                    <p><strong>Predictive Models:</strong> Random Forest with spatio-temporal covariates</p>
                    <p><strong>Flood Model AUC:</strong> 0.89</p>
                    <p><strong>Forest Loss RMSE:</strong> 0.14</p>
                    <p><strong>Uncertainty:</strong> 95% confidence intervals shown for all projections</p>
                </div>
            </div>
        </div>
        
        <div class="resilience-map-container">
            <div id="resilience-map"></div>
            
            <div class="resilience-panel">
                <div class="resilience-panel-header">
                    <h2 class="resilience-panel-title">Netherlands Overview</h2>
                    <i class="fas fa-times" style="cursor: pointer;"></i>
                </div>
                
                <div class="resilience-metric-card">
                    <div class="resilience-metric-header">
                        <div class="resilience-metric-title">Population Density</div>
                    </div>
                    <div class="resilience-metric-value">423/km²</div>
                    <div class="resilience-metric-trend">
                        <i class="fas fa-info-circle"></i>
                        <span>67% urban population</span>
                    </div>
                </div>
                
                <div class="resilience-metric-card">
                    <div class="resilience-metric-header">
                        <div class="resilience-metric-title">Settlement Suitability Index</div>
                    </div>
                    <div class="resilience-metric-value">68/100</div>
                    <div class="resilience-metric-trend">
                        <i class="fas fa-arrow-up resilience-trend-down"></i>
                        <span>5% decrease from 2015 due to flood risk</span>
                    </div>
                </div>
                
                <div class="resilience-metric-card">
                    <div class="resilience-metric-header">
                        <div class="resilience-metric-title">Resilience Investment Priority</div>
                    </div>
                    <div class="resilience-metric-value">Flood Defense</div>
                    <div class="resilience-metric-trend">
                        <i class="fas fa-exclamation-triangle" style="color: #e74c3c;"></i>
                        <span>Critical need in coastal regions</span>
                    </div>
                </div>
            </div>
            
            <div class="resilience-forecast-controls">
                <h3 class="resilience-control-header">Forecast Parameters</h3>
                
                <div class="resilience-slider-container">
                    <div class="resilience-slider-label">
                        <span>Time Horizon</span>
                        <span id="resilience-years-value">3 years</span>
                    </div>
                    <input type="range" id="resilience-years-slider" min="1" max="5" value="3">
                </div>
                
                <div class="resilience-slider-container">
                    <div class="resilience-slider-label">
                        <span>Climate Scenario</span>
                        <span>RCP 4.5</span>
                    </div>
                    <input type="range" id="resilience-scenario-slider" min="1" max="4" value="2">
                </div>
                
                <button class="resilience-btn resilience-btn-primary" style="width: 100%; margin-top: 10px;">
                    <i class="fas fa-chart-line"></i> Run Forecast
                </button>
            </div>
            
            <div class="resilience-layer-controls">
                <h3 class="resilience-control-header">Map Layers</h3>
                
                <div class="resilience-layer-item">
                    <input type="checkbox" id="resilience-flood-layer" checked>
                    <label for="resilience-flood-layer">Flood Risk</label>
                </div>
                
                <div class="resilience-layer-item">
                    <input type="checkbox" id="resilience-forest-layer" checked>
                    <label for="resilience-forest-layer">Forest Loss</label>
                </div>
                
                <div class="resilience-layer-item">
                    <input type="checkbox" id="resilience-pollution-layer" checked>
                    <label for="resilience-pollution-layer">Air Pollution</label>
                </div>
                
                <div class="resilience-layer-item">
                    <input type="checkbox" id="resilience-infrastructure-layer" checked>
                    <label for="resilience-infrastructure-layer">Infrastructure Damage</label>
                </div>
                
                <div class="resilience-layer-item">
                    <input type="checkbox" id="resilience-population-layer">
                    <label for="resilience-population-layer">Population Density</label>
                </div>
                
                <div class="resilience-layer-item">
                    <input type="checkbox" id="resilience-suitability-layer">
                    <label for="resilience-suitability-layer">Settlement Suitability</label>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Bangladesh Waste Management Dashboard Section -->
<section class="waste-dashboard">
    <div class="waste-header">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
            <div>
                <h1>Bangladesh Urban Waste Management Dashboard</h1>
                <p class="waste-subtitle">Monitoring waste levels and population growth in 9 districts with NASA data integration</p>
            </div>
            <div class="current-time" id="currentTime"></div>
        </div>
    </div>
    
    <div class="waste-container">
        <div class="waste-card">
            <h2 class="waste-card-title">Bangladesh Waste Management Map</h2>
            <div id="waste-map"></div>
            <div class="waste-nasa-data-info">
                <strong>NASA Data Integration:</strong> Population growth indicators shown with 📈 symbols based on NASA's Socioeconomic Data and Applications Center (SEDAC)
            </div>
        </div>
        
        <div class="waste-card">
            <h2 class="waste-card-title">District Waste Levels</h2>
            <div class="district-list" id="districtList">
                <!-- District list will be populated by JavaScript -->
            </div>
        </div>
        
        <div class="waste-card">
            <h2 class="waste-card-title">Waste & Population Statistics</h2>
            <div class="waste-stats-grid">
                <div class="waste-stat-card">
                    <div class="waste-stat-value" id="totalWaste">1,250 tons</div>
                    <div class="waste-stat-label">Daily Waste Generated</div>
                </div>
                <div class="waste-stat-card">
                    <div class="waste-stat-value" id="recycled">420 tons</div>
                    <div class="waste-stat-label">Daily Recycled</div>
                </div>
                <div class="waste-stat-card">
                    <div class="waste-stat-value" id="redZones">3</div>
                    <div class="waste-stat-label">Red Zone Areas</div>
                </div>
            </div>
            
            <div class="waste-tab-container">
                <div class="waste-tabs">
                    <div class="waste-tab active" data-tab="waste">Waste Trends</div>
                    <div class="waste-tab" data-tab="population">Population Growth</div>
                </div>
                
                <div class="waste-tab-content active" id="waste-tab">
                    <div class="waste-chart-container">
                        <canvas id="wasteChart"></canvas>
                    </div>
                </div>
                
                <div class="waste-tab-content" id="population-tab">
                    <div class="waste-chart-container">
                        <canvas id="populationChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="waste-alert waste-alert-warning">
                <strong>Warning:</strong> 2 districts approaching red zone status. Immediate action recommended.
            </div>
        </div>
        
        <div class="waste-card waste-prediction-card">
            <h2 class="waste-card-title waste-prediction-title">Real-time Predictive Analysis</h2>
            <div class="waste-prediction-content">
                <div class="waste-prediction-icon">⚠️</div>
                <div class="waste-prediction-text">
                    <p>Based on current waste accumulation trends and population growth data from NASA, <strong>Dhaka</strong> and <strong>Chittagong</strong> are predicted to become red zones within 48 hours if current patterns continue.</p>
                    <div class="waste-action-buttons">
                        <button class="waste-btn waste-btn-warning">View Detailed Report</button>
                        <button class="waste-btn waste-btn-danger">Emergency Protocol</button>
                        <button class="waste-btn waste-btn-primary">Population Impact Analysis</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    
<?php include 'essentials/footer.php'; ?>


    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>


// Districts data with waste and population information
const districts = [
    { 
        id: 1, 
        name: "Dhaka", 
        lat: 23.8103, 
        lng: 90.4125, 
        wasteLevel: "critical", 
        dailyWaste: 450, 
        redZone: true,
        population: 10400000,
        populationGrowth: 3.5,
        nasaData: { populationDensity: 23000, growthRate: "high" }
    },
    { 
        id: 2, 
        name: "Chittagong", 
        lat: 22.3569, 
        lng: 91.7832, 
        wasteLevel: "high", 
        dailyWaste: 220, 
        redZone: false,
        population: 4200000,
        populationGrowth: 2.8,
        nasaData: { populationDensity: 15000, growthRate: "high" }
    },
    { 
        id: 3, 
        name: "Khulna", 
        lat: 22.8456, 
        lng: 89.5403, 
        wasteLevel: "medium", 
        dailyWaste: 120, 
        redZone: false,
        population: 1500000,
        populationGrowth: 1.9,
        nasaData: { populationDensity: 8000, growthRate: "medium" }
    },
    { 
        id: 4, 
        name: "Rajshahi", 
        lat: 24.3745, 
        lng: 88.6042, 
        wasteLevel: "medium", 
        dailyWaste: 95, 
        redZone: false,
        population: 850000,
        populationGrowth: 1.7,
        nasaData: { populationDensity: 6000, growthRate: "medium" }
    },
    { 
        id: 5, 
        name: "Barisal", 
        lat: 22.7010, 
        lng: 90.3535, 
        wasteLevel: "low", 
        dailyWaste: 70, 
        redZone: false,
        population: 340000,
        populationGrowth: 1.2,
        nasaData: { populationDensity: 4500, growthRate: "low" }
    },
    { 
        id: 6, 
        name: "Sylhet", 
        lat: 24.8949, 
        lng: 91.8687, 
        wasteLevel: "low", 
        dailyWaste: 65, 
        redZone: false,
        population: 480000,
        populationGrowth: 2.1,
        nasaData: { populationDensity: 5200, growthRate: "medium" }
    },
    { 
        id: 7, 
        name: "Rangpur", 
        lat: 25.7439, 
        lng: 89.2752, 
        wasteLevel: "medium", 
        dailyWaste: 85, 
        redZone: false,
        population: 650000,
        populationGrowth: 1.8,
        nasaData: { populationDensity: 5800, growthRate: "medium" }
    },
    { 
        id: 8, 
        name: "Mymensingh", 
        lat: 24.7471, 
        lng: 90.4203, 
        wasteLevel: "low", 
        dailyWaste: 75, 
        redZone: false,
        population: 420000,
        populationGrowth: 1.5,
        nasaData: { populationDensity: 3800, growthRate: "low" }
    },
    { 
        id: 9, 
        name: "Comilla", 
        lat: 23.4682, 
        lng: 91.1782, 
        wasteLevel: "high", 
        dailyWaste: 110, 
        redZone: true,
        population: 590000,
        populationGrowth: 2.5,
        nasaData: { populationDensity: 7200, growthRate: "high" }
    }
];

// Initialize the waste management dashboard
function initializeWasteManagement() {
    // Initialize the map
    const wasteMap = L.map('waste-map').setView([23.6850, 90.3563], 7);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(wasteMap);
    
    // Define color based on waste level
    function getColor(level) {
        return level === 'critical' ? '#d32f2f' :
               level === 'high' ? '#f57c00' :
               level === 'medium' ? '#fbc02d' :
               '#388e3c'; // low
    }
    
    // Add markers for each district
    districts.forEach(district => {
        const markerColor = getColor(district.wasteLevel);
        
        // Create custom icon with population indicator
        const populationIcon = L.divIcon({
            html: `<div style="background-color: ${markerColor}; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; border: 2px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.5);">
                        ${district.nasaData.growthRate === 'high' ? '📈' : district.nasaData.growthRate === 'medium' ? '↗️' : '➡️'}
                      </div>`,
            className: 'population-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });
        
        const marker = L.marker([district.lat, district.lng], { icon: populationIcon }).addTo(wasteMap);
        
        // Add popup with district information
        marker.bindPopup(`
            <strong>${district.name}</strong><br>
            Waste Level: <span style="color:${markerColor}; font-weight:bold">${district.wasteLevel.toUpperCase()}</span><br>
            Daily Waste: ${district.dailyWaste} tons<br>
            Population: ${district.population.toLocaleString()}<br>
            Population Growth: ${district.populationGrowth}%<br>
            ${district.redZone ? '<span style="color:red; font-weight:bold">RED ZONE - DANGEROUS</span>' : ''}
        `);
        
        // Add click event to highlight the district in the list
        marker.on('click', function() {
            highlightDistrict(district.id);
        });
    });
    
    // Populate district list
    const districtList = document.getElementById('districtList');
    
    districts.forEach(district => {
        const districtItem = document.createElement('div');
        districtItem.className = `district-item ${district.redZone ? 'red-zone' : ''}`;
        districtItem.dataset.id = district.id;
        
        districtItem.innerHTML = `
            <div>
                <div class="district-name">${district.name}</div>
                <div class="population-growth ${district.populationGrowth > 2 ? 'growth-up' : 'growth-down'}">
                    <span class="population-icon">${district.nasaData.growthRate === 'high' ? '📈' : district.nasaData.growthRate === 'medium' ? '↗️' : '➡️'}</span>
                    Population: ${(district.population/1000000).toFixed(1)}M (${district.populationGrowth}%)
                </div>
            </div>
            <div class="waste-level level-${district.wasteLevel}">${district.wasteLevel.toUpperCase()}</div>
        `;
        
        // Add click event to center map on district
        districtItem.addEventListener('click', function() {
            wasteMap.setView([district.lat, district.lng], 10);
            highlightDistrict(district.id);
        });
        
        districtList.appendChild(districtItem);
    });
    
    // Function to highlight a district in the list
    function highlightDistrict(id) {
        // Remove highlight from all items
        document.querySelectorAll('.district-item').forEach(item => {
            item.style.backgroundColor = '';
        });
        
        // Highlight the selected district
        const selectedItem = document.querySelector(`.district-item[data-id="${id}"]`);
        if (selectedItem) {
            selectedItem.style.backgroundColor = '#e3f2fd';
            selectedItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
    
    // Update current time
    function updateTime() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('currentTime').textContent = now.toLocaleDateString('en-US', options);
    }
    
    // Update time immediately and then every second
    updateTime();
    setInterval(updateTime, 1000);
    
    // Initialize charts
    let wasteChart, populationChart;
    
    function initializeCharts() {
        const wasteCtx = document.getElementById('wasteChart').getContext('2d');
        wasteChart = new Chart(wasteCtx, {
            type: 'bar',
            data: {
                labels: districts.map(d => d.name),
                datasets: [{
                    label: 'Daily Waste (tons)',
                    data: districts.map(d => d.dailyWaste),
                    backgroundColor: districts.map(d => 
                        d.wasteLevel === 'critical' ? '#d32f2f' :
                        d.wasteLevel === 'high' ? '#f57c00' :
                        d.wasteLevel === 'medium' ? '#fbc02d' : '#388e3c'
                    ),
                    borderColor: districts.map(d => 
                        d.wasteLevel === 'critical' ? '#b71c1c' :
                        d.wasteLevel === 'high' ? '#e65100' :
                        d.wasteLevel === 'medium' ? '#f9a825' : '#1b5e20'
                    ),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Tons per day'
                        }
                    }
                }
            }
        });
        
        const populationCtx = document.getElementById('populationChart').getContext('2d');
        populationChart = new Chart(populationCtx, {
            type: 'line',
            data: {
                labels: districts.map(d => d.name),
                datasets: [{
                    label: 'Population Growth Rate (%)',
                    data: districts.map(d => d.populationGrowth),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Growth Rate (%)'
                        }
                    }
                }
            }
        });
    }
    
    // Tab functionality
    document.querySelectorAll('.waste-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            document.querySelectorAll('.waste-tab').forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Hide all tab content
            document.querySelectorAll('.waste-tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Show the corresponding tab content
            const tabId = this.getAttribute('data-tab');
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });
    
    // Simulate real-time data updates
    function updateWasteData() {
        // Randomly adjust waste levels for simulation
        districts.forEach(district => {
            // Small random change to waste amount
            const change = (Math.random() - 0.5) * 10;
            district.dailyWaste = Math.max(10, district.dailyWaste + change);
            
            // Update waste level based on new amount
            if (district.dailyWaste > 200) {
                district.wasteLevel = 'critical';
                district.redZone = true;
            } else if (district.dailyWaste > 100) {
                district.wasteLevel = 'high';
                district.redZone = false;
            } else if (district.dailyWaste > 60) {
                district.wasteLevel = 'medium';
                district.redZone = false;
            } else {
                district.wasteLevel = 'low';
                district.redZone = false;
            }
        });
        
        // Update UI with new data
        updateUI();
    }
    
    // Update the UI with current data
    function updateUI() {
        // Update statistics
        const totalWaste = districts.reduce((sum, district) => sum + district.dailyWaste, 0);
        const recycled = Math.round(totalWaste * 0.34); // Assume 34% recycling rate
        const redZones = districts.filter(d => d.redZone).length;
        
        document.getElementById('totalWaste').textContent = `${Math.round(totalWaste)} tons`;
        document.getElementById('recycled').textContent = `${recycled} tons`;
        document.getElementById('redZones').textContent = redZones;
        
        // Update district list
        const districtItems = document.querySelectorAll('.district-item');
        districtItems.forEach((item, index) => {
            const district = districts[index];
            const wasteLevelElement = item.querySelector('.waste-level');
            
            wasteLevelElement.className = `waste-level level-${district.wasteLevel}`;
            wasteLevelElement.textContent = district.wasteLevel.toUpperCase();
            
            if (district.redZone) {
                item.classList.add('red-zone');
            } else {
                item.classList.remove('red-zone');
            }
        });
        
        // Update charts
        if (wasteChart) {
            wasteChart.data.datasets[0].data = districts.map(d => d.dailyWaste);
            wasteChart.data.datasets[0].backgroundColor = districts.map(d => 
                d.wasteLevel === 'critical' ? '#d32f2f' :
                d.wasteLevel === 'high' ? '#f57c00' :
                d.wasteLevel === 'medium' ? '#fbc02d' : '#388e3c'
            );
            wasteChart.update();
        }
        
        // Update prediction message
        const highWasteDistricts = districts.filter(d => d.wasteLevel === 'high' || d.wasteLevel === 'critical');
        if (highWasteDistricts.length > 0) {
            const predictionText = document.querySelector('.waste-prediction-text p');
            predictionText.innerHTML = `Based on current waste accumulation trends and NASA population data, <strong>${highWasteDistricts.map(d => d.name).join('</strong> and <strong>')}</strong> ${highWasteDistricts.length > 1 ? 'are' : 'is'} predicted to become red zones within 48 hours if current patterns continue.`;
        }
    }
    
    // Initialize charts and update data every 30 seconds for simulation
    initializeCharts();
    updateUI();
    setInterval(updateWasteData, 30000);
}

// Call the initialization function when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Your existing code...
    
    // Initialize Waste Management Dashboard
    initializeWasteManagement();
});





        document.addEventListener('DOMContentLoaded', function() {
// Resilience Planner Map - Exact Copy
const resilienceMap = L.map('resilience-map').setView([52.1326, 5.2913], 8); // Center on Netherlands

// Add base map layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(resilienceMap);

// Add sample overlay layers
const resilienceFloodRiskLayer = L.rectangle([[51.8, 4.8], [52.5, 5.8]], {
    color: "#2980b9",
    weight: 1,
    fillColor: "#3498db",
    fillOpacity: 0.5,
    className: 'flood-layer'
}).addTo(resilienceMap);

const resilienceForestLossLayer = L.polygon([
    [[52.0, 5.0], [52.4, 5.0], [52.2, 5.6], [52.0, 5.0]]
], {
    color: "#27ae60",
    weight: 1,
    fillColor: "#2ecc71",
    fillOpacity: 0.5,
    className: 'forest-layer'
}).addTo(resilienceMap);

// Add sample markers for infrastructure damage (round dots)
const resilienceDamageMarker1 = L.circleMarker([52.09, 5.11], {
    color: '#e74c3c',
    radius: 8,
    fillColor: '#e74c3c',
    fillOpacity: 0.7,
    className: 'damage-marker'
}).addTo(resilienceMap).bindPopup('15 buildings damaged in 2022 floods');

const resilienceDamageMarker2 = L.circleMarker([52.18, 5.40], {
    color: '#e74c3c',
    radius: 12,
    fillColor: '#e74c3c',
    fillOpacity: 0.7,
    className: 'damage-marker'
}).addTo(resilienceMap).bindPopup('42 buildings at risk of future flooding');

// Tab functionality
document.querySelectorAll('.resilience-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        // Remove active class from all tabs
        document.querySelectorAll('.resilience-tab').forEach(t => t.classList.remove('active'));
        // Add active class to clicked tab
        tab.classList.add('active');
        
        // Hide all tab content
        document.querySelectorAll('.resilience-tab-content').forEach(content => content.classList.remove('active'));
        // Show the corresponding tab content
        const tabName = tab.getAttribute('data-tab');
        document.getElementById(`${tabName}-content`).classList.add('active');
    });
});

// Layer control functionality
document.getElementById('resilience-flood-layer').addEventListener('change', (e) => {
    if (e.target.checked) {
        resilienceMap.addLayer(resilienceFloodRiskLayer);
    } else {
        resilienceMap.removeLayer(resilienceFloodRiskLayer);
    }
});

document.getElementById('resilience-forest-layer').addEventListener('change', (e) => {
    if (e.target.checked) {
        resilienceMap.addLayer(resilienceForestLossLayer);
    } else {
        resilienceMap.removeLayer(resilienceForestLossLayer);
    }
});

document.getElementById('resilience-infrastructure-layer').addEventListener('change', (e) => {
    if (e.target.checked) {
        resilienceMap.addLayer(resilienceDamageMarker1);
        resilienceMap.addLayer(resilienceDamageMarker2);
    } else {
        resilienceMap.removeLayer(resilienceDamageMarker1);
        resilienceMap.removeLayer(resilienceDamageMarker2);
    }
});

// Year slider functionality
const resilienceYearSlider = document.getElementById('resilience-years-slider');
const resilienceYearValue = document.getElementById('resilience-years-value');

resilienceYearSlider.addEventListener('input', () => {
    const years = resilienceYearSlider.value;
    resilienceYearValue.textContent = `${years} year${years > 1 ? 's' : ''}`;
});

// Search functionality
document.getElementById('resilience-search-btn').addEventListener('click', () => {
    const country = document.getElementById('resilience-country-search').value;
    if (country) {
        // In a real app, this would geocode the country and update the map
        alert(`Searching for: ${country}. In a real application, this would update the map and data.`);
    } else {
        alert('Please enter a country name');
    }
});

// Simulate loading a country
document.getElementById('resilience-country-search').value = 'Netherlands';







            // Initialize map
            const map = L.map('map').setView([40.7128, -74.0060], 11);
            
            // Add base layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Add sample markers and layers for demonstration
            const floodLayer = L.layerGroup().addTo(map);
            const forestLayer = L.layerGroup().addTo(map);
            const soilLayer = L.layerGroup().addTo(map);
            
            // Add sample data (in a real application, this would come from APIs)
            L.marker([40.7128, -74.0060]).addTo(floodLayer)
                .bindPopup('Flood Risk Area: High')
                .openPopup();
                
            L.marker([40.7282, -73.9842]).addTo(forestLayer)
                .bindPopup('Forest Cover Loss: 12% since 2010');
                
            L.marker([40.7580, -73.9855]).addTo(soilLayer)
                .bindPopup('Soil Moisture: Optimal for construction');
            
            // Tab functionality
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabId = tab.getAttribute('data-tab');
                    
                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked tab and corresponding content
                    tab.classList.add('active');
                    document.getElementById(`${tabId}-content`).classList.add('active');
                    
                    // Adjust map layers based on selected tab
                    if (tabId === 'flood') {
                        map.addLayer(floodLayer);
                        map.removeLayer(forestLayer);
                        map.removeLayer(soilLayer);
                    } else if (tabId === 'forest') {
                        map.addLayer(forestLayer);
                        map.removeLayer(floodLayer);
                        map.removeLayer(soilLayer);
                    } else if (tabId === 'soil') {
                        map.addLayer(soilLayer);
                        map.removeLayer(floodLayer);
                        map.removeLayer(forestLayer);
                    }
                });
            });
            
            // Layer visibility toggle
            const layerItems = document.querySelectorAll('.layer-item');
            layerItems.forEach(item => {
                item.addEventListener('click', function() {
                    const eyeIcon = this.querySelector('i');
                    if (eyeIcon.classList.contains('fa-eye')) {
                        eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                });
            });
        });
    </script>
</body>
</html>