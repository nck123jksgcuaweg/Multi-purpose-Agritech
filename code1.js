document.getElementById('logoutBtn')?.addEventListener('click', (e) => {
    e.preventDefault(); // Prevent default anchor behavior

    if (confirm('Are you sure you want to logout?')) {
        fetch('login.php', { method: 'POST', headers: { 'Content-Type': 'application/json' } })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert('You have been logged out.');
                    window.location.href = 'index.html'; // Redirect to login page
                } else {
                    alert('Logout failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Logout failed:', error);
                alert('An error occurred. Please try again.');
            });
    }
});


            // Data storage for ESP8266 readings
        const espData = {
            seed: [],
            water: [],
            battery: [],
            area: []
        };

        // Connection status
        let isConnected = false;
        let socket = null;

        // Settings and thresholds
        const settings = {
            ipAddress: '192.168.1.100',
            port: 80
        };

        const thresholds = {
            seed: 30,
            water: 40,
            battery: 30
        };

        // Format timestamp
        function formatTimestamp(date) {
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }

        // Format date
        function formatDate(date) {
            return date.toLocaleDateString([], { year: 'numeric', month: 'short', day: 'numeric' });
        }

        // Get status based on value and threshold
        function getStatus(value, threshold) {
            if (value <= threshold / 2) return 'critical';
            if (value <= threshold) return 'warning';
            return 'good';
        }

        // Get status text
        function getStatusText(status) {
            switch(status) {
                case 'critical': return 'Critical';
                case 'warning': return 'Warning';
                case 'good': return 'Good';
                default: return 'Unknown';
            }
        }

        // Get color based on status
        function getStatusColor(status) {
            switch(status) {
                case 'critical': return '#F44336';
                case 'warning': return '#FFC107';
                case 'good': return '#4CAF50';
                default: return '#999999';
            }
        }

        // Draw pie chart
        function drawPieChart(canvasId, percentage, status) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = Math.min(centerX, centerY) - 5;
            
            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Draw background circle (used portion)
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
            ctx.fillStyle = '#f3f3f3';
            ctx.fill();
            
            // Draw pie slice (remaining portion)
            if (percentage > 0) {
                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius, -0.5 * Math.PI, (percentage / 100 * 2 - 0.5) * Math.PI);
                ctx.closePath();
                ctx.fillStyle = getStatusColor(status);
                ctx.fill();
            }
            
            // Draw border
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
            ctx.strokeStyle = '#ddd';
            ctx.lineWidth = 1;
            ctx.stroke();
        }

        // Update a specific table
        function updateTable(tableId, data, rowTemplate) {
            const table = document.getElementById(tableId);
            if (!table) return;
            
            const tbody = table.querySelector('tbody');
            tbody.innerHTML = '';
            
            data.forEach(item => {
                tbody.innerHTML += rowTemplate(item);
            });
            
            // If no data, show a message
            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="${table.querySelectorAll('th').length}" style="text-align: center; padding: 20px;">
                            No data available. Connect to ESP8266 to start receiving data.
                        </td>
                    </tr>
                `;
            }
        }
        
        // Update pie charts
        function updatePieCharts() {
            // Update seed chart
            if (espData.seed.length > 0) {
                const seedLevel = espData.seed[0].level;
                const seedStatus = espData.seed[0].status;
                drawPieChart('seedChart', seedLevel, seedStatus);
                document.getElementById('seedChartLabel').textContent = seedLevel + '%';
                
                // Update legend color
                document.querySelector('#seedChartLegend .legend-color').style.backgroundColor = getStatusColor(seedStatus);
            }
            
            // Update water chart
            if (espData.water.length > 0) {
                const waterLevel = espData.water[0].level;
                const waterStatus = espData.water[0].status;
                drawPieChart('waterChart', waterLevel, waterStatus);
                document.getElementById('waterChartLabel').textContent = waterLevel + '%';
                
                // Update legend color
                document.querySelector('#waterChartLegend .legend-color').style.backgroundColor = getStatusColor(waterStatus);
            }
            
            // Update battery chart
            if (espData.battery.length > 0) {
                const batteryLevel = espData.battery[0].level;
                const batteryStatus = espData.battery[0].status;
                drawPieChart('batteryChart', batteryLevel, batteryStatus);
                document.getElementById('batteryChartLabel').textContent = batteryLevel + '%';
                
                // Update legend color
                document.querySelector('#batteryChartLegend .legend-color').style.backgroundColor = getStatusColor(batteryStatus);
            }
            
            // Update area chart
            if (espData.area.length > 0) {
                const areaPercent = espData.area[0].percent;
                const areaStatus = espData.area[0].status;
                drawPieChart('areaChart', areaPercent, areaStatus);
                document.getElementById('areaChartLabel').textContent = areaPercent + '%';
                
                // Update legend color
                document.querySelector('#areaChartLegend .legend-color').style.backgroundColor = getStatusColor(areaStatus);
            }
        }
        
        // Update status indicators
        function updateStatusIndicators() {
            if (espData.seed.length > 0) {
                const seedStatus = espData.seed[0].status;
                document.querySelector('#seedCard .status-indicator').className = `status-indicator status-${seedStatus}`;
                document.querySelector('#seedCard .status').innerHTML = `
                    <span>Status: <span class="status-indicator status-${seedStatus}"></span> ${getStatusText(seedStatus)}</span>
                    <span>${espData.seed[0].amount} kg remaining</span>
                `;
            }
            
            if (espData.water.length > 0) {
                const waterStatus = espData.water[0].status;
                document.querySelector('#waterCard .status-indicator').className = `status-indicator status-${waterStatus}`;
                document.querySelector('#waterCard .status').innerHTML = `
                    <span>Status: <span class="status-indicator status-${waterStatus}"></span> ${getStatusText(waterStatus)}</span>
                    <span>${espData.water[0].amount} L remaining</span>
                `;
            }
            
            if (espData.battery.length > 0) {
                const batteryStatus = espData.battery[0].status;
                document.querySelector('#batteryCard .status-indicator').className = `status-indicator status-${batteryStatus}`;
                document.querySelector('#batteryCard .status').innerHTML = `
                    <span>Status: <span class="status-indicator status-${batteryStatus}"></span> ${getStatusText(batteryStatus)}</span>
                    <span>${espData.battery[0].time} hrs remaining</span>
                `;
            }
            
            if (espData.area.length > 0) {
                const areaStatus = espData.area[0].status;
                document.querySelector('#areaCard .status-indicator').className = `status-indicator status-${areaStatus}`;
                document.querySelector('#areaCard .status').innerHTML = `
                    <span>Status: <span class="status-indicator status-${areaStatus}"></span> On Track</span>
                    <span>${espData.area[0].hectares} hectares</span>
                `;
            }
        }
        
        // Connect to ESP8266
        function connectToESP8266() {
            // Show connecting status
            const connectionIndicators = document.querySelectorAll('.connection-indicator');
            const connectionStatuses = document.querySelectorAll('[id$="ConnectionStatus"]');
            
            connectionIndicators.forEach(indicator => {
                indicator.className = 'connection-indicator disconnected';
            });
            
            connectionStatuses.forEach(status => {
                status.textContent = 'Connecting...';
            });
            
            try {
                // Create WebSocket connection to ESP8266
                const wsUrl = `ws://${settings.ipAddress}:${settings.port}/ws`;
                socket = new WebSocket(wsUrl);
                
                // Connection opened
                socket.addEventListener('open', (event) => {
                    isConnected = true;
                    
                    // Update connection indicators
                    connectionIndicators.forEach(indicator => {
                        indicator.className = 'connection-indicator connected';
                    });
                    
                    connectionStatuses.forEach(status => {
                        status.textContent = 'Connected';
                    });
                    
                    // Update connect button
                    document.getElementById('connectBtn').textContent = 'Disconnect';
                    
                    // Request initial data
                    socket.send(JSON.stringify({ command: 'getData' }));
                });
                
                // Listen for messages from ESP8266
                socket.addEventListener('message', (event) => {
                    try {
                        const data = JSON.parse(event.data);
                        processESP8266Data(data);
                    } catch (error) {
                        console.error('Error parsing data from ESP8266:', error);
                    }
                });
                
                // Connection closed
                socket.addEventListener('close', (event) => {
                    disconnectFromESP8266();
                });
                
                // Connection error
                socket.addEventListener('error', (event) => {
                    console.error('WebSocket error:', event);
                    disconnectFromESP8266();
                    alert('Failed to connect to ESP8266. Please check your settings and try again.');
                });
                
            } catch (error) {
                console.error('Error connecting to ESP8266:', error);
                disconnectFromESP8266();
                alert('Failed to connect to ESP8266. Please check your settings and try again.');
            }
        }
        
        // Process data received from ESP8266
        function processESP8266Data(data) {
            // Get current timestamp
            const timestamp = new Date();
            const formattedTime = formatTimestamp(timestamp);
            
            // Process seed data
            if (data.seed) {
                const seedLevel = data.seed.level;
                const seedAmount = data.seed.amount;
                const seedDistRate = data.seed.rate || 0;
                const seedStatus = getStatus(seedLevel, thresholds.seed);
                
                espData.seed.unshift({
                    timestamp: formattedTime,
                    level: seedLevel,
                    amount: seedAmount,
                    rate: seedDistRate,
                    status: seedStatus
                });
                if (espData.seed.length > 10) espData.seed.pop();
            }
            
            // Process water data
            if (data.water) {
                const waterLevel = data.water.level;
                const waterAmount = data.water.amount;
                const waterFlowRate = data.water.rate || 0;
                const waterStatus = getStatus(waterLevel, thresholds.water);
                
                espData.water.unshift({
                    timestamp: formattedTime,
                    level: waterLevel,
                    amount: waterAmount,
                    rate: waterFlowRate,
                    status: waterStatus
                });
                if (espData.water.length > 10) espData.water.pop();
            }
            
            // Process battery data
            if (data.battery) {
                const batteryLevel = data.battery.level;
                const batteryTime = data.battery.time;
                const powerUsage = data.battery.usage || 0;
                const batteryStatus = getStatus(batteryLevel, thresholds.battery);
                
                espData.battery.unshift({
                    timestamp: formattedTime,
                    level: batteryLevel,
                    time: batteryTime,
                    usage: powerUsage,
                    status: batteryStatus
                });
                if (espData.battery.length > 10) espData.battery.pop();
            }
            
            // Process area data
            if (data.area) {
                const areaPercent = data.area.percent;
                const areaHectares = data.area.hectares;
                const areaRate = data.area.rate || 0;
                const areaStatus = 'good'; // Always good for area
                
                espData.area.unshift({
                    timestamp: formattedTime,
                    percent: areaPercent,
                    hectares: areaHectares,
                    rate: areaRate,
                    status: areaStatus
                });
                if (espData.area.length > 10) espData.area.pop();
            }
            
            // Update tables in detailed sections
            updateAllTables();
            
            // Update status indicators
            updateStatusIndicators();
            
            // Update pie charts
            updatePieCharts();
        }
        
        // Update all tables
        function updateAllTables() {
            // Update detailed tables only (dashboard now uses pie charts)
            updateTable('seedDetailTable', espData.seed, (data) => `
                <tr>
                    <td>${data.timestamp}</td>
                    <td>${data.level}%</td>
                    <td>${data.amount} kg</td>
                    <td>${data.rate} kg/ha</td>
                    <td><span class="status-indicator status-${data.status}"></span> ${getStatusText(data.status)}</td>
                </tr>
            `);
            
            updateTable('waterDetailTable', espData.water, (data) => `
                <tr>
                    <td>${data.timestamp}</td>
                    <td>${data.level}%</td>
                    <td>${data.amount} L</td>
                    <td>${data.rate} L/min</td>
                    <td><span class="status-indicator status-${data.status}"></span> ${getStatusText(data.status)}</td>
                </tr>
            `);
            
            updateTable('batteryDetailTable', espData.battery, (data) => `
                <tr>
                    <td>${data.timestamp}</td>
                    <td>${data.level}%</td>
                    <td>${data.time} hrs</td>
                    <td>${data.usage} kW/h</td>
                    <td><span class="status-indicator status-${data.status}"></span> ${getStatusText(data.status)}</td>
                </tr>
            `);
            
            updateTable('areaDetailTable', espData.area, (data) => `
                <tr>
                    <td>${data.timestamp}</td>
                    <td>${data.percent}%</td>
                    <td>${data.hectares} ha</td>
                    <td>${data.rate} ha/hr</td>
                    <td><span class="status-indicator status-${data.status}"></span> ${getStatusText(data.status)}</td>
                </tr>
            `);
        }
        
        // Disconnect from ESP8266
        function disconnectFromESP8266() {
            isConnected = false;
            
            // Close WebSocket connection
            if (socket && socket.readyState === WebSocket.OPEN) {
                socket.close();
            }
            socket = null;
            
            // Update connection indicators
            const connectionIndicators = document.querySelectorAll('.connection-indicator');
            const connectionStatuses = document.querySelectorAll('[id$="ConnectionStatus"]');
            
            connectionIndicators.forEach(indicator => {
                indicator.className = 'connection-indicator disconnected';
            });
            
            connectionStatuses.forEach(status => {
                status.textContent = 'Disconnected';
            });
            
            // Update connect button
            document.getElementById('connectBtn').textContent = 'Connect to ESP8266';
        }
        
        // Mobile menu toggle
        document.querySelector('.menu-toggle').addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Navigation handling
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Get the section to show
                const sectionId = item.getAttribute('data-section');
                
                // Remove active class from all items
                document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                
                // Add active class to clicked item
                item.classList.add('active');
                
                // Hide all content sections
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });
                
                // Show the selected section
                const selectedSection = document.getElementById(sectionId);
                selectedSection.classList.add('active');
                
                // Highlight the relevant cards based on the section
                highlightRelevantCards(sectionId);
                
                // Close sidebar on mobile
                if (window.innerWidth <= 768) {
                    document.querySelector('.sidebar').classList.remove('active');
                }
            });
        });

        // Highlight relevant cards based on the selected section
        function highlightRelevantCards(sectionId) {
            // Remove highlight from all cards
            document.querySelectorAll('.card').forEach(card => {
                card.classList.remove('highlight');
            });
            
            // Add highlight to relevant cards
            switch(sectionId) {
                case 'seed-monitor':
                    document.getElementById('seedCard')?.classList.add('highlight');
                    break;
                case 'water-level':
                    document.getElementById('waterCard')?.classList.add('highlight');
                    break;
                case 'battery-level':
                    document.getElementById('batteryCard')?.classList.add('highlight');
                    break;
                case 'area-covered':
                    document.getElementById('areaCard')?.classList.add('highlight');
                    break;
                default:
                    // No specific highlight for dashboard or settings
                    break;
            }
        }
        
        // Connect/Disconnect button
        document.getElementById('connectBtn').addEventListener('click', () => {
            if (isConnected) {
                disconnectFromESP8266();
            } else {
                connectToESP8266();
            }
        });
        
        // Refresh data buttons
        document.getElementById('refreshSeedBtn')?.addEventListener('click', () => {
            if (isConnected && socket) {
                socket.send(JSON.stringify({ command: 'getSeedData' }));
            } else {
                alert('Please connect to ESP8266 first.');
            }
        });
        
        document.getElementById('refreshWaterBtn')?.addEventListener('click', () => {
            if (isConnected && socket) {
                socket.send(JSON.stringify({ command: 'getWaterData' }));
            } else {
                alert('Please connect to ESP8266 first.');
            }
        });
        
        document.getElementById('refreshBatteryBtn')?.addEventListener('click', () => {
            if (isConnected && socket) {
                socket.send(JSON.stringify({ command: 'getBatteryData' }));
            } else {
                alert('Please connect to ESP8266 first.');
            }
        });
        
        document.getElementById('refreshAreaBtn')?.addEventListener('click', () => {
            if (isConnected && socket) {
                socket.send(JSON.stringify({ command: 'getAreaData' }));
            } else {
                alert('Please connect to ESP8266 first.');
            }
        });
        
        // Save settings
        document.getElementById('saveSettingsBtn')?.addEventListener('click', () => {
            settings.ipAddress = document.getElementById('ipAddress').value;
            settings.port = parseInt(document.getElementById('port').value);
            
            alert('Settings saved successfully!');
            
            // Reconnect if already connected
            if (isConnected) {
                disconnectFromESP8266();
                setTimeout(() => {
                    connectToESP8266();
                }, 500);
            }
        });
        
        // Save thresholds
        document.getElementById('saveThresholdsBtn')?.addEventListener('click', () => {
            thresholds.seed = parseInt(document.getElementById('seedThreshold').value);
            thresholds.water = parseInt(document.getElementById('waterThreshold').value);
            thresholds.battery = parseInt(document.getElementById('batteryThreshold').value);
            
            // Update status indicators
            updateStatusIndicators();
            
            // Update pie charts
            updatePieCharts();
            
            alert('Alert thresholds saved successfully!');
        });
        
        // Initialize
        window.addEventListener('load', () => {
            // Initialize tables with empty data
            updateAllTables();
            
            // Initialize pie charts
            drawPieChart('seedChart', 75, 'good');
            drawPieChart('waterChart', 45, 'warning');
            drawPieChart('batteryChart', 15, 'critical');
            drawPieChart('areaChart', 60, 'good');
            
            // Set up event listeners for settings inputs
            document.getElementById('ipAddress')?.addEventListener('input', (e) => {
                settings.ipAddress = e.target.value;
            });
            
            document.getElementById('port')?.addEventListener('input', (e) => {
                settings.port = parseInt(e.target.value);
            });
            
            document.getElementById('seedThreshold')?.addEventListener('input', (e) => {
                thresholds.seed = parseInt(e.target.value);
            });
            
            document.getElementById('waterThreshold')?.addEventListener('input', (e) => {
                thresholds.water = parseInt(e.target.value);
            });
            
            document.getElementById('batteryThreshold')?.addEventListener('input', (e) => {
                thresholds.battery = parseInt(e.target.value);
            });
            
        });


//esp water
document.addEventListener("DOMContentLoaded", function () {
    function fetchWaterData() {
        fetch("fetch_water_data.php")
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector("#waterDetailTable tbody");
                tableBody.innerHTML = ""; // Clear existing table data

                data.forEach(row => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${row.timestamp}</td>
                        <td>${row.level}%</td>
                        <td>${row.amount} L</td>
                    `;
                    tableBody.appendChild(tr);
                });
            })
            .catch(error => console.error("Error fetching data:", error));
    }

    // Fetch data every 5 seconds automatically
    setInterval(fetchWaterData, 5000);

    // Also fetch data when clicking refresh button
    document.getElementById("refreshWaterBtn").addEventListener("click", fetchWaterData);

    // Initial fetch
    fetchWaterData();
});
