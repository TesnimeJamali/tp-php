<?php
// Database configuration
$servername = "localhost"; // The hostname (usually localhost)
$username = "root"; // Your MySQL username (usually root for XAMPP)
$password = "meriemMySQL1"; // Your MySQL password (if you have set one)
$dbname = "user_management"; // The name of your database

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo "Connected successfully!";
} catch (PDOException $e) {
    // If the connection fails, display the error message
    echo "Connection failed: " . $e->getMessage();
}
?>
