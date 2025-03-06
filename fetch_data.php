<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$dbname = 'monitors';
$port = 3308;

$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database Connection Failed: " . $conn->connect_error]));
}

$sql = "SELECT timestamp, water_level, water_amount FROM water_levels ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "timestamp" => $row["timestamp"],
        "level" => $row["water_level"],
        "amount" => $row["water_amount"]
    ];
}

echo json_encode($data);

$conn->close();
?>
