<?php
session_start();

// Check if the user is logged in and credentials exist in session
if (!isset($_SESSION['db_user']) || !isset($_SESSION['db_pass'])) {
    die("Veuillez vous connecter pour configurer la base de données.");
}

require_once 'connexion.php';

try {
    $db = ConnexionBD::getInstance(); // Get the database connection
    
    // Fetch all students from the database
    $query = $db->query("SELECT * FROM student");
    
    // Fetch all results as objects
    $results = $query->fetchAll(PDO::FETCH_OBJ);
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Liste des Étudiants</h1>
    <?php if ($results): ?>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date de Naissance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student->id); ?></td>
                        <td><?php echo htmlspecialchars($student->name); ?></td>
                        <td><?php echo htmlspecialchars($student->birth_date); ?></td>
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
