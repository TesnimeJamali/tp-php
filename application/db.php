<?php
// Database configuration
$servername = "localhost"; // The hostname (usually localhost)
$username = "root"; // Your MySQL username (usually root for XAMPP)
$password = "Hippopotame$2014"; // Your MySQL password (if you have set one)
$dbname = "user_management"; // The name of your database

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
