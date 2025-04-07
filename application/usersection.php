<?php
session_start();
include('db.php');
include('isAuthenticated.php');
require 'vendor/autoload.php';

$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
}

$filterDesignation = '';
if (isset($_GET['filter_designation'])) {
    $filterDesignation = trim($_GET['filter_designation']);
}

try {
    $sql = "SELECT * FROM section";
    $conditions = [];
    $params = [];

    if (!empty($searchTerm)) {
        $conditions[] = "designation LIKE :searchTerm";
        $params[':searchTerm'] = '%' . $searchTerm . '%';
    }

    if (!empty($filterDesignation)) {
        $conditions[] = "designation = :filterDesignation";
        $params[':filterDesignation'] = $filterDesignation;
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        .btn-color-2 {
    background-color: #007bff; /* Couleur de fond bleue, similaire à l'en-tête */
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
    margin-right: 10px;
    text-decoration: none; /* Pour enlever le soulignement si vous utilisez des <a> au lieu de <button> */
  }

  .btn-color-2:hover {
    background-color: #0056b3; /* Assombrir au survol */
  }

  /* Si vous voulez un style plus discret */
  .btn-outline {
    color: #007bff;
    border: 1px solid #007bff;
    background-color: transparent;
  }

  .btn-outline:hover {
    background-color: #007bff;
    color: white;
  }
    </style>
</head>
<body>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">Gestionnaire des étudiants</span>
    </a>
    <ul class="nav nav-pills">
        <li class="nav-item mx-2">
            <a class="nav-link" href="user_dash.php" aria-current="page">Accueil</a>
        </li>
        <li class="nav-item mx-2">
            <a class="nav-link" href="userstudent.php" aria-current="page">Etudiants</a>
        </li>
        <li class="nav-item mx-2">
            <a class="nav-link active" href="usersection.php" aria-current="page">Sections</a>
        </li>
        <li class="nav-item mx-2">
            <a class="nav-link" href="logout.php" aria-current="page">Se Déconnecter</a>
        </li>
    </ul>
</header>
<h2>Liste des Sections</h2>

        <button class="btn btn-color-2" onclick="window.location.href='sections.php?export=csv'">Export CSV</button>
<button class="btn btn-color-2" onclick="window.location.href='sections.php?export=xlsx'">Export XLSX</button>
<button class="btn btn-color-2" onclick="window.location.href='sections.php?export=pdf'">Export PDF</button>
<form method="get" class="mb-4">
    <br>
    <div class="row g-3 align-items-center">
        <div class="col-md-6">
            <input class="form-control" type="search" placeholder="Rechercher une section" aria-label="Search" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
        </div>
        <div class="col-md-4">
            <select class="form-select" id="filter_designation" name="filter_designation">
                <option value="">Toutes les désignations</option>
                <?php
                try {
                    $stmt_designations = $conn->prepare("SELECT DISTINCT designation FROM section ORDER BY designation");
                    $stmt_designations->execute();
                    $designations = $stmt_designations->fetchAll(PDO::FETCH_COLUMN);
                    foreach ($designations as $designation_name):
                        $selected = ($filterDesignation === $designation_name) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($designation_name) . '" ' . $selected . '>' . htmlspecialchars($designation_name) . '</option>';
                    endforeach;
                } catch (PDOException $e) {
                    echo '<option value="" disabled>Erreur lors de la récupération</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </div>
</form>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Désignation</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sections)): ?>
                    <tr><td colspan="4" class="text-center">Aucune section trouvée.</td></tr>
                <?php else: ?>
                    <?php foreach ($sections as $section): ?>
                    <tr>
                        <td><?= $section['id'] ?></td>
                        <td><?= htmlspecialchars($section['designation']) ?></td>
                        <td><?= htmlspecialchars($section['description']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
