<?php
session_start();
session_unset();
session_destroy();

// ✅ Prevent browser from loading cached session
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

// ✅ Redirect to login.php
header("Location: index.html");
exit();
?>
