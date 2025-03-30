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
</head>
<body>

<h2><?= htmlspecialchars($section['designation']) ?></h2>
<p><?= nl2br(htmlspecialchars($section['description'])) ?></p>

<a href="admin_dash.php">Retour</a> <!-- Change en "user.php" si l'utilisateur est normal -->

</body>
</html>