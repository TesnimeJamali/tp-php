<?php
session_start();
include('db.php');
include('studentclass.php');

// Ensure the section ID is provided
if (!isset($_GET['id'])) {
    die("ID de l'etudiant manquant !");
}

$studentId = $_GET['id'];
$studentObj = new Student($conn);

// Delete the section
if ($studentObj->deleteStudent($studentId)) {
    header("Location: student.php");  // Redirect to the admin dashboard after successful deletion
    exit();
} else {
    echo "Erreur lors de la suppression de l'etudiant'.";
}
?>
