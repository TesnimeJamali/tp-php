<?php
session_start();
include('db.php');
include('studentclass.php');
include('sectionclass.php');

if ($_SESSION['role'] == 'user') {
    header('Location: login.php');
    exit();
}

$error = '';
$studentObj = new Student($conn);
$sectionObj = new Section($conn);
$sections = $sectionObj->getAllSections();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];
    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);

        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($imageExt), $allowedExts)) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $uniqueName = uniqid() . '.' . $imageExt;
            $imagePath = $uploadDir . $uniqueName;

            if (move_uploaded_file($imageTmp, $imagePath)) {
                $image = $imagePath;
            } else {
                $error = "Erreur lors du téléchargement de l'image.";
            }
        } else {
            $error = "Format de fichier invalide. Seuls les fichiers JPG, PNG ou GIF sont autorisés.";
        }
    }

    if (empty($error)) {
        if ($studentObj->createStudent($name, $birthday, $image, $section)) {
            header("Location: student.php");
            exit();
        } else {
            $error = "Erreur lors de l'ajout de l'étudiant.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            max-width: 800px;
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
    <h2>Ajouter un nouvel étudiant</h2>

    <?php if ($error) { echo "<p class='error-message'>$error</p>"; } ?>

    <form action="create_student.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="birthday">Date de naissance:</label>
            <input type="date" id="birthday" name="birthday" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="section">Section:</label>
            <select id="section" name="section" class="form-control" required>
                <?php
                if (isset($sections) && is_array($sections)):
                    foreach ($sections as $section):
                        echo '<option value="' . htmlspecialchars($section['designation']) . '">' . htmlspecialchars($section['designation']) . '</option>';
                    endforeach;
                else:
                    echo '<option value="" disabled>Aucune section disponible</option>';
                endif;
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Image (facultatif):</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Ajouter l'étudiant</button>
    </form>

    <div class="mt-3">
        <a href="admin_dash.php" class="btn btn-secondary">Retour à l'administration</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
