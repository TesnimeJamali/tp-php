
<?php
session_start();
include('db.php');  // Database connection
include('studentclass.php');  // Section class
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}
// Create Section object
$studentObj = new Student($conn);

// Fetch all sections
$students = $studentObj->getAllStudents();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Etudiants</title>
</head>
<body>
    <h2>Liste des Etudiants</h2>

    <table border="1">
        <tr>
            <th>Name</th>
            <th>Birthday</th>
            <th>Image</th>
            <th>Section</th>
        </tr>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['name'] ?></td>
                <td><?= htmlspecialchars($student['birthday']) ?></td>
                <td><?= htmlspecialchars($student['image']) ?></td>
                <td><?= htmlspecialchars($student['section']) ?></td>
                <td>
                    <a href="edit_student.php?id=<?= $student['id'] ?>">Modifier</a> |
                    <a href="delete_student.php?id=<?= $student['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet etudiant?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="create_student.php">Ajouter un nouveau Etudiant</a><br>
    <a href="admin_dash.php">Retour à l'administration</a>

</body>
</html>
