<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users.user_auth WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        // Store user info in session
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        
        // Redirect to Agritech.html
        header("Location: Agritech.php");
        exit(); // Ensure script stops here
    } else {
        echo "<script>alert('Invalid credentials!'); window.location.href='login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
