<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'monitors', 3308);

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
echo "✅ Database Connected Successfully!";
?>
