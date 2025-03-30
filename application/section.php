
<?php
session_start();
include('db.php');  // Database connection
include('sectionclass.php');  // Section class
include('isAuthenticated.php'); // Vérification de l'authentification de l'utilisateur
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}
// Create Section object
$sectionObj = new Section($conn);

// Fetch all sections
$sections = $sectionObj->getAllSections();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Sections</title>
</head>
<body>
    <h2>Liste des Sections</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Désignation</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($sections as $section): ?>
            <tr>
                <td><?= $section['id'] ?></td>
                <td><?= htmlspecialchars($section['designation']) ?></td>
                <td><?= htmlspecialchars($section['description']) ?></td>
                <td>
                    <a href="edit_section.php?id=<?= $section['id'] ?>">Modifier</a> |
                    <a href="delete_section.php?id=<?= $section['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette section?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="create_section.php">Ajouter une nouvelle section</a>
    <a href="admin_dash.php">Retour à l'administration</a>

</body>
</html>
