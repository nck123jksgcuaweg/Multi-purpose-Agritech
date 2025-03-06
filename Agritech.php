<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design1.css">
    <title>Agricultural Machine Monitor</title>
</head>
<body>

     
    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 12h18M3 6h18M3 18h18"/>
        </svg>
    </button>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>Agri Monitor</h1>
        </div>
        <nav class="nav-items">
            <a href="#" class="nav-item active" data-section="dashboard">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 3h18v18H3z"/>
                    <path d="M3 9h18M9 21V9"/>
                </svg>
                Dashboard
            </a>
            <a href="#" class="nav-item" data-section="seed-monitor">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5"/>
                </svg>
                Seed Monitor
            </a>
            <a href="#" class="nav-item" data-section="water-level">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v6M12 22v-6M4.93 4.93l4.24 4.24M14.83 14.83l4.24 4.24M2 12h6M22 12h-6M4.93 19.07l4.24-4.24M14.83 9.17l4.24-4.24"/>
                </svg>
                Water Level
            </a>
            <a href="#" class="nav-item" data-section="battery-level">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 3v18h18"/>
                    <path d="M18.5 3l-6 6-4-4L2 11.5"/>
                </svg>
                Battery Level
            </a>
            <a href="#" class="nav-item" data-section="area-covered">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 3H3v18h18V3z"/>
                    <path d="M3 9h18M3 15h18M9 3v18M15 3v18"/>
                </svg>
                Area Covered
            </a>
            <a href="#" class="nav-item" data-section="settings">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
                Settings
            </a>

            <!-- Logout Button-->
<a href="#" class="nav-item" id="logoutBtn">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
        <polyline points="16 17 21 12 16 7"/>
        <line x1="21" y1="12" x2="9" y2="12"/>
    </svg>
    Logout
</a>

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Dashboard Section -->
            <div id="dashboard" class="content-section active">
                <div class="section-header">
                    <h1>Dashboard Overview</h1>
                </div>
                <p class="section-description">
                    Monitor all key metrics of your agricultural machine in real-time. The dashboard provides a comprehensive overview of seed levels, water levels, area covered, and battery status.
                </p>
                <div class="data-controls">
                    <div class="connection-status">
                        <span class="connection-indicator disconnected" id="connectionIndicator"></span>
                        <span id="connectionStatus">Disconnected</span>
                    </div>
                    <button id="connectBtn">Connect to ESP8266</button>
                </div>
                <div class="dashboard">
                    <div class="card" id="seedCard">
                        <h2>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                            Seed Level
                        </h2>
                        <div class="status">
                            <span>Status: <span class="status-indicator status-good"></span> Good</span>
                            <span>12.5 kg remaining</span>
                        </div>
                        <div class="chart-container">
                            <div class="pie-chart">
                                <canvas id="seedChart" width="150" height="150"></canvas>
                                <div class="chart-label" id="seedChartLabel">75%</div>
                            </div>
                            <div class="chart-legend" id="seedChartLegend">
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #4CAF50;"></div>
                                    <span>Remaining</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #f3f3f3;"></div>
                                    <span>Used</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="waterCard">
                        <h2>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2v6M12 22v-6M4.93 4.93l4.24 4.24M14.83 14.83l4.24 4.24M2 12h6M22 12h-6M4.93 19.07l4.24-4.24M14.83 9.17l4.24-4.24"/>
                            </svg>
                            Water Level
                        </h2>
                        <div class="status">
                            <span>Status: <span class="status-indicator status-warning"></span> Warning</span>
                            <span>22.5 L remaining</span>
                        </div>
                        <div class="chart-container">
                            <div class="pie-chart">
                                <canvas id="waterChart" width="150" height="150"></canvas>
                                <div class="chart-label" id="waterChartLabel">45%</div>
                            </div>
                            <div class="chart-legend" id="waterChartLegend">
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #FFC107;"></div>
                                    <span>Remaining</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #f3f3f3;"></div>
                                    <span>Used</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="areaCard">
                        <h2>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 3H3v18h18V3z"/>
                                <path d="M3 9h18M3 15h18M9 3v18M15 3v18"/>
                            </svg>
                            Area Covered
                        </h2>
                        <div class="status">
                            <span>Status: <span class="status-indicator status-good"></span> On Track</span>
                            <span>3.6 hectares</span>
                        </div>
                        <div class="chart-container">
                            <div class="pie-chart">
                                <canvas id="areaChart" width="150" height="150"></canvas>
                                <div class="chart-label" id="areaChartLabel">60%</div>
                            </div>
                            <div class="chart-legend" id="areaChartLegend">
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #4CAF50;"></div>
                                    <span>Covered</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #f3f3f3;"></div>
                                    <span>Remaining</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="batteryCard">
                        <h2>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 3v18h18"/>
                                <path d="M18.5 3l-6 6-4-4L2 11.5"/>
                            </svg>
                            Battery Level
                        </h2>
                        <div class="status">
                            <span>Status: <span class="status-indicator status-critical"></span> Critical</span>
                            <span>2.1 hrs remaining</span>
                        </div>
                        <div class="chart-container">
                            <div class="pie-chart">
                                <canvas id="batteryChart" width="150" height="150"></canvas>
                                <div class="chart-label" id="batteryChartLabel">15%</div>
                            </div>
                            <div class="chart-legend" id="batteryChartLegend">
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #F44336;"></div>
                                    <span>Remaining</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #f3f3f3;"></div>
                                    <span>Used</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seed Monitor Section -->
            <div id="seed-monitor" class="content-section">
                <div class="section-header">
                    <h1>Seed Monitor</h1>
                </div>
                <p class="section-description">
                    Track seed usage, distribution rate, and remaining capacity. The seed monitor helps ensure optimal seeding rates and alerts you when refills are needed.
                </p>
                <div class="data-controls">
                    <div class="connection-status">
                        <span class="connection-indicator disconnected" id="seedConnectionIndicator"></span>
                        <span id="seedConnectionStatus">Disconnected</span>
                    </div>
                    <button id="refreshSeedBtn">Refresh Data</button>
                </div>
                <div class="card">
                    <h2>Seed Level History</h2>
                    <table class="data-table" id="seedDetailTable">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Level (%)</th>
                                <th>Amount (kg)</th>
                                <th>Distribution Rate (kg/ha)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated from ESP8266 -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Water Level Section -->
            <div id="water-level" class="content-section">
                <div class="section-header">
                    <h1>Water Level</h1>
                </div>
                <p class="section-description">
                    Monitor water consumption, tank level, and distribution efficiency. The water level monitor helps prevent dry runs and ensures proper irrigation.
                </p>
                <div class="data-controls">
                    <div class="connection-status">
                        <span class="connection-indicator disconnected" id="waterConnectionIndicator"></span>
                        <span id="waterConnectionStatus">Disconnected</span>
                    </div>
                    <button id="refreshWaterBtn">Refresh Data</button>
                </div>
                <div class="card">
                    <h2>Water Level History</h2>
                    <table class="data-table" id="waterDetailTable">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Level (%)</th>
                                <th>Amount (L)</th>
                                <th>Flow Rate (L/min)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated from ESP8266 -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Battery Level Section -->
            <div id="battery-level" class="content-section">
                <div class="section-header">
                    <h1>Battery Level</h1>
                </div>
                <p class="section-description">
                    Track battery charge, estimated runtime, and power consumption. The battery monitor helps prevent unexpected shutdowns and optimize power usage.
                </p>
                <div class="data-controls">
                    <div class="connection-status">
                        <span class="connection-indicator disconnected" id="batteryConnectionIndicator"></span>
                        <span id="batteryConnectionStatus">Disconnected</span>
                    </div>
                    <button id="refreshBatteryBtn">Refresh Data</button>
                </div>
                <div class="card">
                    <h2>Battery Level History</h2>
                    <table class="data-table" id="batteryDetailTable">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Level (%)</th>
                                <th>Time Left (hrs)</th>
                                <th>Power Usage (kW/h)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated from ESP8266 -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Area Covered Section -->
            <div id="area-covered" class="content-section">
                <div class="section-header">
                    <h1>Area Covered</h1>
                </div>
                <p class="section-description">
                    Monitor field coverage, progress rate, and estimated completion time. The area monitor helps track productivity and plan operations.
                </p>
                <div class="data-controls">
                    <div class="connection-status">
                        <span class="connection-indicator disconnected" id="areaConnectionIndicator"></span>
                        <span id="areaConnectionStatus">Disconnected</span>
                    </div>
                    <button id="refreshAreaBtn">Refresh Data</button>
                </div>
                <div class="card">
                    <h2>Area Coverage History</h2>
                    <table class="data-table" id="areaDetailTable">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Coverage (%)</th>
                                <th>Area (ha)</th>
                                <th>Rate (ha/hr)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated from ESP8266 -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Settings Section -->
            <div id="settings" class="content-section">
                <div class="section-header">
                    <h1>Settings</h1>
                </div>
                <p class="section-description">
                    Configure ESP8266 connection settings, alert thresholds, and system preferences. The settings panel allows you to customize the monitoring system to your needs.
                </p>
                <div class="card">
                    <h2>ESP8266 Connection Settings</h2>
                    <div style="margin-top: 1rem;">
                        <div style="margin-bottom: 1rem;">
                            <label for="ipAddress" style="display: block; margin-bottom: 0.5rem;">IP Address:</label>
                            <input type="text" id="ipAddress" value="192.168.1.100" style="padding: 0.5rem; width: 100%; max-width: 300px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="port" style="display: block; margin-bottom: 0.5rem;">Port:</label>
                            <input type="number" id="port" value="80" style="padding: 0.5rem; width: 100%; max-width: 300px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                        <button id="saveSettingsBtn" style="background-color: #11513c; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Save Settings</button>
                    </div>
                </div>
                <div class="card">
                    <h2>Alert Thresholds</h2>
                    <div style="margin-top: 1rem;">
                        <div style="margin-bottom: 1rem;">
                            <label for="seedThreshold" style="display: block; margin-bottom: 0.5rem;">Low Seed Warning (%):</label>
                            <input type="number" id="seedThreshold" value="30" min="1" max="100" style="padding: 0.5rem; width: 100%; max-width: 300px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="waterThreshold" style="display: block; margin-bottom: 0.5rem;">Low Water Warning (%):</label>
                            <input type="number" id="waterThreshold" value="40" min="1" max="100" style="padding: 0.5rem; width: 100%; max-width: 300px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="batteryThreshold" style="display: block; margin-bottom: 0.5rem;">Low Battery Warning (%):</label>
                  style="display: block; margin-bottom: 0.5rem;">Low Battery Warning (%):</label>
                            <input type="number" id="batteryThreshold" value="30" min="1" max="100" style="padding: 0.5rem; width: 100%; max-width: 300px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                        <button id="saveThresholdsBtn" style="background-color: #11513c; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Save Thresholds</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</html>


<script src="code1.js"></script>