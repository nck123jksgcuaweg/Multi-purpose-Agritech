//Right now, even after logging out, a user can press Back and see Agritech.html. To prevent this, modify the top of Agritech.html by adding this PHP code:

<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html"); // Redirect if not logged in
    exit();
}
?>
