<!DOCTYPE html>
<html lang="en">

<style>
      /* Root Variables for Theme */
  :root {
    --primary-color: #1a2b3c;
    --secondary-color: #2c3e50;
    --accent-color: #d4d4d4;
    --background-color: #ffffff;
    --card-bg: #ffffff;
    --text-color: #333;
    --success-color: #2ecc71;
    --danger-color: #e74c3c;
    --shadow-color: rgba(0, 0, 0, 0.2);
    --hover-bg: #ecf0f1;
}

/* Global Reset */
* {
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--background-color);
    color: var(--text-color);
    line-height: 1.6;
}

.container {
    max-width: 1400px;
    margin: 0;
    padding: 0 20px;
}

header {
    color: #000000;
    margin: 0;
    padding: 0 20px;
    padding: 10px;
    border-radius: 10px;
}

/* Dashboard Styles */
.dashboard {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

.status-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-top: 10px;
}

.status-card {
    background-color: #1a1a50;
    color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 150px;
    height: 120px;
}

.history-panel {
    position: absolute;
    right: 20px;
    top: 20px;
    background-color: #3575a6;
    padding: 15px;
    border-radius: 10px;
    width: 150px;
}

.close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

/* Profile Section */
.profile-section {
    display: flex;
    align-items: center;
    position: absolute;
    top: 10px;
    right: 20px;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.logout-button {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logout-button i {
    font-size: 24px;
    color: #e74c3c;
    transition: color 0.3s;
}

.logout-button:hover i {
    color: #c0392b;
}


h1, h2 {
    margin-bottom: 15px;
    font-size: 2rem;
}

/* Cards for Machine Status */
.machine-status {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin: 30px 0;
    flex-wrap: wrap;
}

.status-card {
    background: var(--card-bg);
    border-radius: 15px;
    box-shadow: 0 5px 15px var(--shadow-color);
    padding: 20px;
    text-align: center;
    width: 23%;
    transition: all 0.3s ease;
    position: relative;
    background: #507288;
    box-shadow: 20px;
}

.status-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px var(--shadow-color);
}

.status-card h3 {
    margin-bottom: 15px;
    font-size: 1.2rem;
    color: var(--primary-color);
}

canvas {
    margin: 10px 0;
}

/* Controls Section */
.controls {
    background: var(--card-bg);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px var(--shadow-color);
    margin-bottom: 30px;
    display: flex;
    justify-content: space-around;
    gap: 20px;
}

.btn {
    background-color: var(--accent-color);
    color: #fff;
    padding: 12px 20px;
    margin: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    justify-content: center;
}

.btn:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
}

.btn i {
    font-size: 18px;
}

/* Tables */
table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
    box-shadow: 0 4px 10px var(--shadow-color);
    background: var(--card-bg);
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background: var(--secondary-color);
    color: #fff;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: var(--hover-bg);
}

@media (max-width: 768px) {
    .status-card {
        width: 48%;
    }
}

@media (max-width: 480px) {
    .status-card {
        width: 100%;
    }

    .btn {
        width: 100%;
        text-align: center;
    }

    .controls {
        flex-direction: column;
    }
}


/* Sidebar */
.sidebar {
    width: 250px;
    height: 100vh;
    background: var(--primary-color);
    color: #f8f5f5;
    position: fixed;
    top: 0;
    left: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 2px 0 10px var(--shadow-color);
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.5rem;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 10px;
    transition: background 0.3s;
    cursor: pointer;
}

.sidebar ul li:hover {
    background: #245688;
}

.sidebar ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 1rem;
    display: block;
}

/* Main content adjusted for sidebar */
.container {
    margin-left: 270px; /* Adjusted for sidebar */
    width: calc(100% - 270px);
    max-width: none;
    padding: 20px;
}

/* Responsive Sidebar */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }

    .container {
        margin-left: 220px;
        width: calc(100% - 220px);
    }
}

@media (max-width: 480px) {
    .sidebar {
        width: 180px;
        padding: 15px;
    }

    .container {
        margin-left: 190px;
        width: calc(100% - 190px);
    }
}




</style>
<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}
?>




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solar AgriTech</title>
    <link rel="stylesheet" href="design.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <script src="code.js"></script>
</head>
<body>

    
    <div class="container">
        <header>
            <h1>Solar AgriTech</h1>
            <div class="profile-section">
                <img src="avatar.png" alt="Profile" class="avatar">
                <button class="logout-button" onclick="logout()">
    <img src="logout.png" alt="Logout" width="30" height="30">
</button>

<script>
    function logout() {
        window.location.href = 'logout.php'; 
    }
</script>

                
            </div>
        </header>

        <div class="sidebar">
            <h2>AgriTech</h2>
            <ul>
                <li><a href="#" onclick="showTable('machine-status')">Dashboard</a></li>
                <li><a href="#" onclick="showTable('soilMonitorTable')">Soil Monitor</a></li>
                <li><a href="#" onclick="showTable('seedMonitorTable')">Seed Monitor</a></li>
                <li><a href="#" onclick="showTable('waterLevelTable')">Water Level</a></li>
                <li><a href="#" onclick="showTable('solarInputTable')">Solar Input</a></li>
                <li><a href="#" onclick="showTable('setting')">Setting</a></li>
            </ul>
        </div>
        
       
        <section class="data-section">
            <table id="soilMonitorTable" class="data-table" style="display:none;">
                <tr><th>Operation</th><th>Start Time</th><th>End Time</th><th>Status</th></tr>
            </table>
            
            <table id="seedMonitorTable" class="data-table" style="display:none;">
            <tr><th>Operation</th><th>Start Time</th><th>End Time</th><th>Status</th></tr>
            </table>
            
            <table id="waterLevelTable" class="data-table" style="display:none;">
            <tr><th>Operation</th><th>Start Time</th><th>End Time</th><th>Status</th></tr>
            </table>
            
            <table id="solarInputTable" class="data-table" style="display:none;">
            <tr><th>Operation</th><th>Start Time</th><th>End Time</th><th>Status</th></tr>
            </table>
            
            <table id="setting" class="data-table" style="display:none;">
                
            </table>
        </section>

    
 <!-- Machine Status Section with Pie Charts -->
 <section class="machine-status">
    <div class="status-card">
        <h3>Battery Level</h3>
        <canvas id="batteryChart"></canvas>
    </div>
    <div class="status-card">
        <h3>Water Level</h3>
        <canvas id="waterChart"></canvas>
    </div>
    <div class="status-card">
        <h3>Soil Level</h3>
        <canvas id="solarChart"></canvas>
    </div>
    <div class="status-card">
        <h3>Seed Level</h3>
        <canvas id="seedChart"></canvas>
    </div>
</section>
  
</body>
</html>
<script>
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function() {
        window.history.pushState(null, "", window.location.href);
    };


    document.getElementById("toggle-btn").addEventListener("click", function() {
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
    const formTitle = document.getElementById("form-title");

    if (loginForm.style.display === "none") {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        formTitle.innerText = "Login";
        this.innerText = "Register";
    } else {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        formTitle.innerText = "Register";
        this.innerText = "Login";
    }
});
document.getElementById("register-form").addEventListener("submit", function(event) {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm-password").value;
    let errorMessage = document.getElementById("password-error");

    if (password !== confirmPassword) {
        errorMessage.style.display = "block";
        event.preventDefault(); // Stop form submission
    } else {
        errorMessage.style.display = "none";
    }
});

//for sidebar
function showTable(tableId) {
    let tables = document.querySelectorAll('.data-table');
    let statusSection = document.querySelector('.machine-status');
    
    if (tableId === 'machine-status') {
        statusSection.style.display = 'flex';
        tables.forEach(table => table.style.display = 'none');
    } else {
        statusSection.style.display = 'none';
        tables.forEach(table => {
            table.style.display = table.id === tableId ? 'table' : 'none';
        });
    }
}

//for login
function logout() {
    window.location.href = 'login.php';
}



</script>
