<?php
session_start(); // Start session to fetch credentials
require_once 'connexion.php';

// Get student ID from query string
$studentId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($studentId > 0) {
    $db_user = $_SESSION['db_user'];
    $db_pass = $_SESSION['db_pass'];

    // Get database connection using credentials from session
    $db = ConnexionBD::getInstance($db_user, $db_pass);

    // Prepare and execute query
    $query = $db->prepare("SELECT * FROM student WHERE id = :id");
    $query->bindParam(':id', $studentId, PDO::PARAM_INT);
    $query->execute();

    // Fetch the student data
    $student = $query->fetch(PDO::FETCH_OBJ);

    if ($student) {
        // Display student details
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Détails de l'Étudiant</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
        <div class="container mt-5">
            <h1 class="text-center mb-4">Détails de l'Étudiant</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($student->name); ?></h5>
                    <p class="card-text"><strong>ID:</strong> <?php echo htmlspecialchars($student->id); ?></p>
                    <p class="card-text"><strong>Date de naissance:</strong> <?php echo htmlspecialchars($student->birth_date); ?></p>
                    <a href="students.php" class="btn btn-primary">Retour à la liste</a>
                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Étudiant introuvable.</p>";
    }
} else {
    echo "<p>ID d'étudiant invalide.</p>";
}
?>
