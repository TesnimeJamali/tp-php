<?php
session_start();
include('db.php');
include('sectionclass.php');
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}
// Ensure the section ID is provided
if (!isset($_GET['id'])) {
    die("ID de section manquant !");
}

$sectionId = $_GET['id'];
$sectionObj = new Section($conn);

// Delete the section
if ($sectionObj->deleteSection($sectionId)) {
    header("Location: section.php");  // Redirect to the admin dashboard after successful deletion
    exit();
} else {
    echo "Erreur lors de la suppression de la section.";
}
?>
