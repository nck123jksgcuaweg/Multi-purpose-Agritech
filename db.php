<?php
$servername = "127.0.0.1";  // Or "127.0.0.1"
$username = "root";  
$password = "";  // Default is empty in XAMPP
$database = "users";  
$port = 3308;  // Specify the correct port

$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
