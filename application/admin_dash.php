<?php
session_start();
include('db.php'); // Connexion à la base de données
include('isAuthenticated.php'); // Vérification de l'authentification de l'utilisateur
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}
try {
    // Récupérer tous les étudiants de la base de données
    $stmt = $conn->prepare("SELECT * FROM etudiant");
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<h2>Liste des Étudiants</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Date de naissance</th>
        <th>Image</th>
        <th>Section</th>
    </tr>
    <?php foreach ($etudiants as $etudiant): ?>
    <tr>
        <td><?= htmlspecialchars($etudiant['id']) ?></td>
        <td><?= htmlspecialchars($etudiant['name']) ?></td>
        <td><?= htmlspecialchars($etudiant['birthday']) ?></td>
        <td>
            <?php if (!empty($etudiant['image'])): ?>
                <img src="<?= htmlspecialchars($etudiant['image']) ?>" alt="Photo">
            <?php else: ?>
                Aucun
            <?php endif; ?>
        </td>
        <td>
    <a href="save.php?id=<?= htmlspecialchars($etudiant['section']) ?>">
        <?= htmlspecialchars($etudiant['section']) ?>
    </a>
</td>

    </tr>
    <?php endforeach; ?>
</table>
<a href="logout.php"><button>Déconnecter</button></a>
<a href="student.php"><button>Modifier Etudiants</button></a>
<a href="section.php"><button>Modifier Sections</button></a>

</body>
</html>
