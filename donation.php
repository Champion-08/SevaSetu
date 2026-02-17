<?php
session_start();

/* If not logged in as user → go login */
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

/* If logged in → go to add donation */
header("Location: user_add_donation.php");
exit();
?>
