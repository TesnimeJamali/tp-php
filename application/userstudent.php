<?php
session_start();
include('db.php');
include('isAuthenticated.php');

require 'vendor/autoload.php';


$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
}


$filterSection = '';
if (isset($_GET['filter_section'])) {
    $filterSection = trim($_GET['filter_section']);
}

try {

    $sql = "SELECT * FROM etudiant";
    $conditions = [];
    $params = [];

    if (!empty($searchTerm)) {
        $conditions[] = "name LIKE :searchTerm";
        $params[':searchTerm'] = '%' . $searchTerm . '%';
    }

    if (!empty($filterSection)) {
        $conditions[] = "section = :filterSection";
        $params[':filterSection'] = $filterSection;
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Gestion des Etudiants</title>
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
            <a class="nav-link active" href="userstudent.php" aria-current="page">Etudiants</a>
        </li>
        <li class="nav-item mx-2">
            <a class="nav-link" href="usersection.php" aria-current="page">Sections</a>
        </li>
        <li class="nav-item mx-2">
            <a class="nav-link" href="logout.php" aria-current="page">Logout</a>
        </li>
    </ul>
</header>

    <div class="container">
        <h2>Liste des Etudiants</h2>
        

        
        <button class="btn btn-color-2" onclick="location.href='generate_files.php?type=excel';" >
    Excel
</button>

<button class="btn btn-color-2" onclick="location.href='generate_files.php?type=csv';" >
    CSV
</button>

<button class="btn btn-color-2" onclick="location.href='generate_files.php?type=pdf';" >
    PDF
</button>

            <form method="get" role="search" style="margin-top: 20px;">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
          </form>

          <div class="mb-3">
    <form method="get">
        <label for="filter_section" class="form-label">Filtrer par section :</label>
        <select class="form-select" id="filter_section" name="filter_section">
            <option value="">Toutes les sections</option>
            <?php
            try {
                $stmt_sections = $conn->prepare("SELECT DISTINCT section FROM etudiant ORDER BY section");
                $stmt_sections->execute();
                $sections = $stmt_sections->fetchAll(PDO::FETCH_COLUMN);
                foreach ($sections as $section_name):
                    $selected = (isset($_GET['filter_section']) && $_GET['filter_section'] === $section_name) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($section_name) . '" ' . $selected . '>' . htmlspecialchars($section_name) . '</option>';
                endforeach;
            } catch (PDOException $e) {
                echo '<option value="" disabled>Erreur lors de la récupération des sections</option>';
            }
            ?>
        </select>
        <button type="submit" class="btn btn-primary mt-2">Filtrer</button>
    </form>
</div>



        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th>Image</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($etudiants)): ?>
                    <tr><td colspan="5" class="text-center">Aucun étudiant trouvé.</td></tr>
                <?php else: ?>
                    <?php foreach ($etudiants as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td><?= htmlspecialchars($student['birthday']) ?></td>
                        <td>
                            <?php if (!empty($student['image'])): ?>
                                <img src="<?= htmlspecialchars($student['image']) ?>" alt="Photo" width="50">
                            <?php else: ?>
                                Aucun
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($student['section']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
