<?php
session_start();
include('db.php');
include('isAuthenticated.php');
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['section_id']) || !is_numeric($_GET['section_id'])) {
    header('Location: list_sections.php'); // Redirect si l'ID de la section est manquant ou invalide
    exit();
}

$sectionId = $_GET['section_id'];

try {
    $stmt_section = $conn->prepare("SELECT designation FROM section WHERE id = :id");
    $stmt_section->bindParam(':id', $sectionId, PDO::PARAM_INT);
    $stmt_section->execute();
    $section = $stmt_section->fetch(PDO::FETCH_ASSOC);

    if (!$section) {
        header('Location: list_sections.php'); // Redirect si la section n'existe pas
        exit();
    }
    $sectionDesignation = htmlspecialchars($section['designation']);

    $stmt_students = $conn->prepare("SELECT * FROM etudiant WHERE section = :section");
    $stmt_students->bindParam(':section', $sectionDesignation, PDO::PARAM_STR);
    $stmt_students->execute();
    $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Étudiants de la section <?= $sectionDesignation ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background-color: #f8f9fa;
            color: #495057;
            line-height: 1.6;
        }

        h2 {
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

        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin-right: 5px;
            border: 1px solid #007bff;
            border-radius: 0.25rem;
            text-decoration: none;
            color: #007bff;
            background-color: transparent;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .btn:hover {
            background-color: #007bff;
            color: white;
        }

        .empty-message {
            text-align: center;
            padding: 30px;
            color: #6c757d;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Étudiants de la section : <?= $sectionDesignation ?></h2>
        <p><a href="section.php" class="btn btn-outline-primary btn-sm mb-3">Return</a></p>

        <?php if (empty($students)): ?>
            <p class="empty-message">Aucun étudiant inscrit dans cette section.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Date de naissance</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['id']) ?></td>
                            <td><?= htmlspecialchars($student['name']) ?></td>
                            <td><?= htmlspecialchars($student['birthday']) ?></td>
                            <td>
                                <?php if (!empty($student['image'])): ?>
                                    <img src="<?= htmlspecialchars($student['image']) ?>" alt="Photo" style="max-width: 50px; max-height: 50px;">
                                <?php else: ?>
                                    Aucun
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>