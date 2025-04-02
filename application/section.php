<?php
session_start();
include('db.php');  // Database connection
include('sectionclass.php');  // Section class
include('isAuthenticated.php'); // Vérification de l'authentification de l'utilisateur
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}
// Create Section object
$sectionObj = new Section($conn);

// Fetch all sections
$sections = $sectionObj->getAllSections();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Gestion des Sections</title>
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
            max-width: 1200px; /* Increased max-width for wider content */
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .fs-4 {
            font-size: 1.75rem; /* Slightly larger font size */
            font-weight: bold;
            color: #007bff;
        }

        .nav-pills .nav-link {
            background: #e9ecef;
            color: #495057;
            border-radius: 0.375rem;
            margin-left: 10px;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
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

        .btn-danger {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #dc3545;
            color: white;
        }

        .mt-3 {
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Liste des Sections</h2>
        <header class="header-container">
            <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
                <span class="fs-4">Student Management System</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="logout.php" class="nav-link active" aria-current="page">Logout</a></li>
                <li class="nav-item"><a href="create_section.php" class="nav-link">Add section</a></li>
            </ul>
        </header>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Désignation</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sections as $section): ?>
                    <tr>
                        <td><?= $section['id'] ?></td>
                        <td><?= htmlspecialchars($section['designation']) ?></td>
                        <td><?= htmlspecialchars($section['description']) ?></td>
                        <td>
                            <a href="edit_section.php?id=<?= $section['id'] ?>" class="btn btn-primary btn-sm">Modify</a>
                            <a href="delete_section.php?id=<?= $section['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette section?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

       
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
