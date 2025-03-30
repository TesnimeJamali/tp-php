<?php
session_start(); // Start session to fetch credentials
require_once 'connexion.php';

$db_user = $_SESSION['db_user'];
$db_pass = $_SESSION['db_pass'];

// Get the database connection instance using the credentials stored in session
$db = ConnexionBD::getInstance($db_user, $db_pass);

// Fetch student data
$query = $db->query("SELECT * FROM student");
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Liste des Étudiants</h1>
    <?php if ($results): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date de Naissance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student->id); ?></td>
                        <td><?php echo htmlspecialchars($student->name); ?></td>
                        <td><?php echo htmlspecialchars($student->birth_date); ?></td>
                        <td><a href="detailEtudiant.php?id=<?php echo $student->id; ?>" class="btn btn-info">Détails </a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun étudiant trouvé.</p>
    <?php endif; ?>
</div>
</body>
</html>
