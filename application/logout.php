<?php
session_start();
$_SESSION['loggedin'] = false; // Set the logged-in status to false
$_SESSION['user'] = null; // Clear the user session variable
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session
header('Location: login.php'); // Redirect to the login page
exit();
?>