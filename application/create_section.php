<?php
session_start();
include('db.php');
include('isAuthenticated.php'); // Vérification de l'authentification de l'utilisateur
include('sectionclass.php');
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $designation = $_POST['designation'];
    $description = $_POST['description'];

    // Create Section object
    $sectionObj = new Section($conn);

    // Insert new section into the database
    if ($sectionObj->createSection($designation, $description)) {
        header("Location: section.php");  // Redirect to admin dashboard after successful insertion
        exit();
    } else {
        $error = "Erreur lors de l'ajout de la section.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Section</title>
</head>
<body>
    <h2>Ajouter une nouvelle section</h2>

    <?php if ($error) { echo "<p style='color:red;'>$error</p>"; } ?>

    <form action="create_section.php" method="POST">
        <label for="designation">Désignation:</label>
        <input type="text" id="designation" name="designation" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <input type="submit" value="Ajouter la section">
    </form>
    <br>
    <a href="admin_dash.php">Retour à l'administration</a>
</body>
</html>
