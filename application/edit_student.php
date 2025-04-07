<?php
session_start();
include('db.php');
include('isAuthenticated.php');
include('studentclass.php');
include('sectionclass.php');
$error = '';

if (!isset($_GET['id'])) {
    die("ID de l'étudiant manquant !");
}

$studentId = $_GET['id'];
$studentObj = new Student($conn);
$student = $studentObj->getStudentById($studentId);

if (!$student) {
    die("Étudiant non trouvé !");
}

$sectionObj = new Section($conn);
$sections = $sectionObj->getAllSections();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];

    $image = $student['image']; // Par défaut : image actuelle

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
                $image = $imagePath; // Met à jour l'image seulement si l'upload réussit
            } else {
                $error = "Erreur lors du téléchargement de l'image.";
            }
        } else {
            $error = "Format de fichier invalide. Seuls les fichiers image sont autorisés.";
        }
    }

    if (empty($error)) {
        if ($studentObj->updateStudent($studentId, $name, $birthday, $section, $image)) {
            header("Location: student.php");
            exit();
        } else {
            $error = "Erreur lors de la mise à jour de l'étudiant.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Étudiant</title>
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

        input[type="text"],
        input[type="date"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1rem;
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
    <h2>Modifier l'étudiant</h2>

    <?php if ($error): ?>
        <p class="error-message"><?= $error ?></p>
    <?php endif; ?>

    <form action="edit_student.php?id=<?= $studentId ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="birthday">Date de naissance:</label>
            <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($student['birthday']) ?>" required>
        </div>
        <div class="form-group">
            <label for="section">Section:</label>
            <select id="section" name="section" required>
                <?php foreach ($sections as $section): ?>
                    <option value="<?= htmlspecialchars($section['designation']) ?>" <?= $section['designation'] == $student['section'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($section['designation']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image (facultatif):</label>
            <input type="file" id="image" name="image">
        </div>
        <div class="form-group">
            <?php if ($student['image']): ?>
                <p>Image actuelle:</p>
                <img src="/<?= htmlspecialchars($student['image']) ?>" width="100" alt="Image actuelle">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn">Mettre à jour l'étudiant</button>
    </form>
    <br>
    <div>
        <a href="admin_dash.php" class="btn btn-secondary">Retour à l'administration</a>
    </div>
</body>
</html>
