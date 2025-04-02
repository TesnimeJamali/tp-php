<?php
session_start();
include('db.php');  // Include the PDO database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user data from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format. Please use the format user@service.domain.";
        header("Location: register.php");
        exit();
    } else {
        // Email is valid, proceed with password hashing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Prepare SQL query to insert a new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");

            // Bind parameters
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);

            // Execute the query
            $stmt->execute();

            // Redirect to the login page after successful registration
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            // If there is an issue with the database connection
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: register.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    <?php
    // Display error message if any
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);  // Clear error message after displaying
    }
    ?>

    <form action="register.php" method="POST">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required 
            pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
            title="Email must be in the format user@service.domain"><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Role:</label>
        <select name="role" id="role">
            <option value="user">Utilisateur</option>
            <option value="admin">Administrateur</option>
        </select><br><br>

        <input type="submit" value="Register">
    </form>

    <br>
    <a href="index.php"><button>Retour à se connecter</button></a>
</body>
</html>
