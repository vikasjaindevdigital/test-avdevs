<?php
include 'db.php';

if (!isset($_SESSION['avdevs_user_id'])) {
    header('Location: upload.php');
    exit;
}
// Destroy the session to log the user out
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session

// Redirect to the login page after logout
header('Location: login.php');
exit;

?>

