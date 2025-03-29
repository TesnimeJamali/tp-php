<?php
require_once 'connexion.php';

// Vérifier si l'ID de l'étudiant est présent dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $studentId = intval($_GET['id']); // Récupérer et sécuriser l'ID

    $db = ConnexionBD::getInstance();

    // Préparer la requête SQL avec un placeholder pour l'ID
    $stmt = $db->prepare("SELECT id, name, birth_date FROM student WHERE id = :id");

    // Lier la valeur de l'ID au placeholder
    $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);

    // Exécuter la requête préparée
    $stmt->execute();

    // Récupérer l'étudiant
    $student = $stmt->fetch(PDO::FETCH_OBJ);

    if ($student) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Détails de l'Étudiant</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                .student-details {
                    margin-top: 30px;
                    padding: 20px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    background-color: #f9f9f9;
                }

                .student-details h2 {
                    margin-bottom: 15px;
                    color: #333;
                }

                .student-details p {
                    margin-bottom: 10px;
                }

                .back-link {
                    margin-top: 20px;
                    display: block;
                    color: #007bff;
                    text-decoration: none;
                }

                .back-link:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class="container mt-5">
                <h1 class="text-center mb-4">Détails de l'Étudiant</h1>
                <div class="student-details">
                    <h2><?php echo htmlspecialchars($student->name); ?></h2>
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($student->id); ?></p>
                    <p><strong>Date de Naissance:</strong> <?php echo htmlspecialchars($student->birth_date); ?></p>
                    <a href="index.php" class="back-link">Retour à la liste des étudiants</a>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Si l'étudiant n'est pas trouvé
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Étudiant Non Trouvé</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container mt-5">
                <div class="alert alert-danger" role="alert">
                    Étudiant non trouvé.
                    <a href="index.php" class="alert-link">Retour à la liste des étudiants</a>.
                </div>
            </div>
        </body>
        </html>
        <?php
    }
} else {
    // Si l'ID n'est pas présent ou n'est pas valide
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erreur</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container mt-5">
            <div class="alert alert-danger" role="alert">
                Erreur : ID de l'étudiant manquant ou invalide.
                <a href="index.php" class="alert-link">Retour à la liste des étudiants</a>.
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
