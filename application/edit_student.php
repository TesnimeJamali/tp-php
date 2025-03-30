<?php
session_start();
include('db.php');
include('studentclass.php');

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
        $imagePath = 'uploads/' . basename($imageName);
        
        // Move the uploaded image to the uploads directory
        if (move_uploaded_file($imageTmp, $imagePath)) {
            $image = $imageName;  // Update image name if upload is successful
        } else {
            $error = "Erreur lors de l'upload de l'image.";
        }
    }

    // Update the student details
    if (empty($error)) {
        if ($studentObj->updateStudent($studentId, $name, $birthday, $section, $image)) {
            header("Location: admin_dash.php");  // Redirect to admin dashboard after update
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
</head>
<body>
    <h2>Modifier l'étudiant</h2>

    <?php if ($error) { echo "<p style='color:red;'>$error</p>"; } ?>

    <form action="edit_student.php?id=<?= $studentId ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($student['name']) ?>" required><br><br>

        <label for="birthday">Date de naissance:</label>
        <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($student['birthday']) ?>" required><br><br>

        <label for="section">Section:</label>
        <input type="text" id="section" name="section" value="<?= htmlspecialchars($student['section']) ?>" required><br><br>

        <label for="image">Image (facultatif):</label>
        <input type="file" id="image" name="image"><br><br>

        <?php if ($student['image']): ?>
            <p>Image actuelle:</p>
            <img src="uploads/<?= htmlspecialchars($student['image']) ?>" width="100" alt="Current Image"><br><br>
        <?php endif; ?>

        <input type="submit" value="Mettre à jour l'étudiant">
    </form>
    <br>
    <a href="admin_dash.php">Retour à l'administration</a>
</body>
</html>
