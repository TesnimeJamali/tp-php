<?php
session_start();
include('db.php');
include('sectionclass.php');
if ($_SESSION['role']=='user') {
    header('Location: login.php');
    exit();
}
$error = '';

// Ensure the section ID is provided
if (!isset($_GET['id'])) {
    die("ID de section manquant !");
}

$sectionId = $_GET['id'];
$sectionObj = new Section($conn);

// Fetch the section by its ID
$section = $sectionObj->getSectionById($sectionId);

// Check if the section exists
if (!$section) {
    die("Section non trouvée !");
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $designation = $_POST['designation'];
    $description = $_POST['description'];

    if ($sectionObj->updateSection($sectionId, $designation, $description)) {
        header("Location: section.php");  // Redirect to admin dashboard after update
        exit();
    } else {
        $error = "Erreur lors de la mise à jour de la section.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Modifier Section</title>
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
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #495057;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        textarea {
            resize: vertical; /* Allow vertical resizing of the textarea */
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: 1px solid #007bff;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
            background-color: transparent;
            transition: background-color 0.2s ease, color 0.2s ease;
            font-size: 1rem;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h2>Modifier la section</h2>

        <?php if ($error) { echo "<p class='error-message'>$error</p>"; } ?>

        <form action="edit_section.php?id=<?= $sectionId ?>" method="POST">
            <div class="form-group">
                <label for="designation">Désignation:</label>
                <input type="text" id="designation" name="designation" class="form-control" value="<?= htmlspecialchars($section['designation']) ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4" required><?= htmlspecialchars($section['description']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour la section</button>
        </form>

        <div class="mt-3">
            <a href="admin_dash.php" class="btn btn-secondary">Retour à l'administration</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
