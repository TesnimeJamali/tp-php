<?php
session_start();
include('db.php');
include('isAuthenticated.php');
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}


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
    <title>Liste des Étudiants</title>
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
            margin: top 20px;
        }
        .export-buttons {
            margin-bottom: 20px;
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
        <h2>Liste des Étudiants</h2>
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4" >Student Management System</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="logout.php" class="nav-link active" aria-current="page">logout</a></li>
            <li class="nav-item"><a href="student.php" class="nav-link " >Edit students</a></li>
            <li class="nav-item"><a href="section.php" class="nav-link " >Edit sections</a></li>


        </ul>
    </header>
    <div class="export-buttons">
    <button class="btn btn-color-2" onclick="location.href='generate_files.php?type=excel';" >
    Excel
</button>

<button class="btn btn-color-2" onclick="location.href='generate_files.php?type=csv';" >
    CSV
</button>

<button class="btn btn-color-2" onclick="location.href='generate_files.php?type=pdf';" >
    PDF
</button>
    </div>

    <form role="search" method="get">
        <input class="form-control" type="search" placeholder="Rechercher par nom" aria-label="Search" name="search" value="<?= htmlspecialchars($searchTerm) ?>" style=" margin-top: 20px;">
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






    <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th>Image</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($etudiants)): ?>
                    <tr><td colspan="5" class="empty-message">Aucun étudiant trouvé.</td></tr>
                <?php else: ?>
                    <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td><?= htmlspecialchars($etudiant['id']) ?></td>
                        <td><?= htmlspecialchars($etudiant['name']) ?></td>
                        <td><?= htmlspecialchars($etudiant['birthday']) ?></td>
                        <td>
                            <?php if (!empty($etudiant['image'])): ?>
                                <img src="<?= htmlspecialchars($etudiant['image']) ?>" alt="Photo" width="50">
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
                <?php endif; ?>
            </tbody>
        </table>


    </div>
</body>
</html>
