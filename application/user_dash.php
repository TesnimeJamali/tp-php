<?php
session_start();
include('isAuthenticated.php'); // Vérification de l'authentification de l'utilisateur
include('db.php'); // Connexion à la base de données
echo $_SESSION['user'];

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background-color: #f8f9fa;
            color: #495057;
            line-height: 1.6;
        }

        h1 {
            color: #343a40;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .container {
            max-width: 100%; 
            margin: 0; 
            background-color: #fff;
            padding: 30px;
            border-radius: 0; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.3s ease-in-out;
        }

        td.actions {
            white-space: nowrap;
        }

        td.actions a {
            display: inline-block;
            padding: 10px 18px;
            margin-right: 8px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        td.actions a.edit {
            background-color: #28a745;
            color: white;
            border: 1px solid transparent;
        }

        td.actions a.edit:hover {
            background-color: #1e7e34;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        td.actions a.delete {
            background-color: #dc3545;
            color: white;
            border: 1px solid transparent;
        }

        td.actions a.delete:hover {
            background-color: #c82333;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        .button-container {
            margin-top: 40px;
            text-align: left; /* Aligner les boutons à gauche */
        }

        .button {
            display: inline-block;
            padding: 12px 22px;
            border: 2px solid #007bff;
            border-radius: 8px;
            background-color: transparent;
            color: #007bff;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-right: 15px; /* Espacement entre les boutons */
        }

        .button:hover {
            background-color: #007bff;
            color: white;
            border-color: #0056b3;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        .button.logout {
            border-color: #6c757d;
            color: #6c757d;
        }

        .button.logout:hover {
            background-color: #6c757d;
            color: white;
            border-color: #545b62;
        }

        .empty-message {
            text-align: center;
            padding: 30px;
            color: #6c757d;
            font-size: 1.1rem;
        }
        .fs-4 {
    font-size: 1.5rem; 
    font-weight: bold; 
    color: #007bff; 
        }
    </style>
</head>
<body>

<h2>Liste des Étudiants</h2>
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4" >Student Management System</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="logout.php" class="nav-link active" aria-current="page">logout</a></li>
      </ul>
    </header>
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
                <img src="uploads/<?= htmlspecialchars($etudiant['image']) ?>" alt="Photo">
            <?php else: ?>
                Aucun
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($etudiant['section']) ?></td>

    </tr>
    <?php endforeach; ?>
</table>


</body>
</html>
