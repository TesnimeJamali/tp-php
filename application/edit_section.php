<?php
session_start();
include('db.php');
include('isAuthenticated.php'); // Ensure the user is authenticated
include('sectionclass.php');
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
    <title>Modifier Section</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #343a40;
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
        }

        .form-textarea {
            width: 100%;
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
            height: 150px;
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Modifier la section</h2>

    <?php if ($error): ?>
        <p class="error-message"><?= $error ?></p>
    <?php endif; ?>

    <form action="edit_section.php?id=<?= $sectionId ?>" method="POST">
        <div class="mb-3">
            <label for="designation" class="form-label">Désignation:</label>
            <input type="text" id="designation" name="designation" class="form-control" value="<?= htmlspecialchars($section['designation']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea id="description" name="description" class="form-textarea" required><?= htmlspecialchars($section['description']) ?></textarea>
        </div>

        <div class="text-center">
            <input type="submit" class="btn" value="Mettre à jour la section">
        </div>
    </form>

    <div class="text-center mt-3">
        <a href="admin_dash.php">Retour à l'administration</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
