<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$dbname = 'monitors';
$port = 3308;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["sensorID"]) && isset($_POST["waterLevel"]) && isset($_POST["waterAmount"])) {
        $sensorID = $_POST["sensorID"];
        $waterLevel = $_POST["waterLevel"];
        $waterAmount = $_POST["waterAmount"];

        // Debugging
        echo "Received Data from $sensorID -> Water Level: $waterLevel cm, Water Amount: $waterAmount L\n";

        // Store in the database
        $sql = "INSERT INTO water_levels (sensor_id, water_level, water_amount) VALUES ('$sensorID', '$waterLevel', '$waterAmount')";
        if ($conn->query($sql) === TRUE) {
            echo "✅ Data stored successfully!";
        } else {
            echo "❌ Database Error: " . $conn->error;
        }
    } else {
        echo "⚠️ No valid POST data received.";
    }
} else {
    echo "⚠️ No data received from ESP.";
}

$conn->close();
?>
