<?php
session_start();
include('db.php');
include('isAuthenticated.php'); // Ensure the user is authenticated
include('studentclass.php');
include('sectionclass.php');
$error = '';

// Ensure the student ID is provided
if (!isset($_GET['id'])) {
    die("ID de l'étudiant manquant !");
}

$studentId = $_GET['id'];
$studentObj = new Student($conn);

// Fetch the student by ID
$student = $studentObj->getStudentById($studentId);

// Check if the student exists
if (!$student) {
    die("Étudiant non trouvé !");
}

// Fetch all sections
$sectionObj = new Section($conn);
$sections = $sectionObj->getAllSections(); // Assuming getAllSections() method exists

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];
    
    // Handle image upload (if provided)
    $image = $student['image'];  // Default to the current image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
        
        // Validate file type (allow only images)
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($imageExt), $allowedExts)) {
            // Create a unique image name to avoid overwriting
            $imagePath = 'uploads/' . uniqid() . '.' . $imageExt;
            move_uploaded_file($imageTmp, $imagePath);
            $image = $imagePath;
        } else {
            $error = "Format de fichier invalide. Seuls les fichiers image sont autorisés.";
        }
    }

    // Update the student details
    if (empty($error)) {
        if ($studentObj->updateStudent($studentId, $name, $birthday, $section, $image)) {
            header("Location: student.php");  // Redirect to admin dashboard after update
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

        select {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23343a40" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M1.5 5.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 0 1H2a.5.5 0 0 1-.5-.5z"/><path d="M8 0a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
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

    <?php if ($error) { echo "<p style='color:red;'>$error</p>"; } ?>

    <form action="edit_student.php?id=<?= $studentId ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($student['name']) ?>" required><br><br>
        </div>
        <div class="form-group">
            <label for="birthday">Date de naissance:</label>
            <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($student['birthday']) ?>" required><br><br>
        </div>
        <div class="form-group">
            <label for="section">Section:</label>
            <select id="section" name="section" required>
                <?php foreach ($sections as $section): ?>
                    <option value="<?= htmlspecialchars($section['designation']) ?>" <?= $section['designation'] == $student['section'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($section['designation']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>
        </div>
        <div class="form-group">
            <label for="image">Image (facultatif):</label>
            <input type="file" id="image" name="image"><br><br>
        </div>
        <div class="form-group">
            <?php if ($student['image']): ?>
                <p>Image actuelle:</p>
                <img src="<?= $student['image'] ?>" width="100" alt="Current Image"><br><br>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter l'étudiant</button>
        </form>
    <br>
    <div class="mt-3">
            <a href="admin_dash.php" class="btn btn-secondary">Retour à l'administration</a>
        </div>
</body>
</html>
