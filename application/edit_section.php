<?php
session_start();
include('db.php');
include('sectionclass.php');
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}
$error = '';

// Ensure the section ID is provided
if (!isset($_GET['id'])) {
    die("ID de section manquant !");
}

$sectionId = $_GET['id'];
$sectionObj = new Section($conn);

// Fetch the section by its ID
$section = $sectionObj->getSectionById($sectionId);

// Check if the section exists
if (!$section) {
    die("Section non trouvée !");
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $designation = $_POST['designation'];
    $description = $_POST['description'];

    if ($sectionObj->updateSection($sectionId, $designation, $description)) {
        header("Location: section.php");  // Redirect to admin dashboard after update
        exit();
    } else {
        $error = "Erreur lors de la mise à jour de la section.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Section</title>
</head>
<body>
    <h2>Modifier la section</h2>

    <?php if ($error) { echo "<p style='color:red;'>$error</p>"; } ?>

    <form action="edit_section.php?id=<?= $sectionId ?>" method="POST">
        <label for="designation">Désignation:</label>
        <input type="text" id="designation" name="designation" value="<?= htmlspecialchars($section['designation']) ?>" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($section['description']) ?></textarea><br><br>

        <input type="submit" value="Mettre à jour la section">
    </form>
    <br>
    <a href="admin_dash.php">Retour à l'administration</a>
</body>
</html>
