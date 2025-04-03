<?php
session_start();
include('db.php'); // Connexion à la base de données
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}

// Vérifier si l'ID de la section est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de section manquant !");
}

$section_name = $_GET['id']; // Nom de la section
//echo $section_name; // Debug: Afficher l'ID de la section
try {
    // Récupérer les détails de la section
    $stmt = $conn->prepare("SELECT * FROM section WHERE designation = :id");
    $stmt->bindParam(':id', $section_name, PDO::PARAM_STR);  // Use PDO::PARAM_STR for strings
    $stmt->execute();
    $section = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$section) {
        die("Section non trouvée !");
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($section['designation']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #495057;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-size: 1.1rem;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-link {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><?= htmlspecialchars($section['designation']) ?></h2>
    <p><?= nl2br(htmlspecialchars($section['description'])) ?></p>

    <div class="back-link">
        <a href="admin_dash.php">Retour à l'administration</a> <!-- Change en "user.php" si l'utilisateur est normal -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
