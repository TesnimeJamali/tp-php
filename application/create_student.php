<?php

session_start();
include('db.php');
include('studentclass.php');
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}
$error = '';

// Créer un objet Student pour manipuler la base de données
$studentObj = new Student($conn);

// Traitement du formulaire de soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];
    $image = null;  // Initialiser la variable image

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath =$imageName;
        $image = $imageName;  // Mettre à jour le nom de l'image si le téléchargement est réussi
    }

    if ($studentObj->createStudent($name, $birthday, $image, $section)) {
        header("Location: student.php");  // Rediriger vers le tableau de bord après ajout
        exit();
    } else {
        $error = "Erreur lors de l'ajout de l'étudiant.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Étudiant</title>
</head>
<body>
    <h2>Ajouter un nouvel étudiant</h2>

    <?php if ($error) { echo "<p style='color:red;'>$error</p>"; } ?>

    <!-- Formulaire d'ajout d'un étudiant -->
    <form action="create_student.php" method="POST" enctype="multipart/form-data">
        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="birthday">Date de naissance:</label>
        <input type="date" id="birthday" name="birthday" required><br><br>

        <label for="section">Section:</label>
<select id="section" name="section" required>
    <?php
    // Assuming you have a Section class that handles section-related queries
    include('sectionclass.php');  // Include the Section class file
    $sectionObj = new Section($conn);  // Create a Section object
    $sections = $sectionObj->getAllSections();  // Fetch all available sections from the database

    // Loop through the sections and create an option for each one
    foreach ($sections as $section) {
        echo '<option value="' . htmlspecialchars($section['id']) . '">' . htmlspecialchars($section['designation']) . '</option>';
    }
    ?>
</select><br><br>

        <label for="image">Image (facultatif):</label>
        <input type="file" id="image" name="image"><br><br>

        <input type="submit" value="Ajouter l'étudiant">
    </form>

    <br>
    <a href="admin_dash.php">Retour à l'administration</a>
</body>
</html>
