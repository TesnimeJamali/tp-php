<?php
session_start();
include('db.php');  // Include the PDO database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user data from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
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
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        // If there is an issue with the database connection
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
    font-family: sans-serif;
    margin: 20px;
    background-color: #f4f4f4;
    color: #333;
}

h1 {
    color: #007bff;
    text-align: center;
    
    
}

h2, h3 {
    color: #007bff;
}

.container {
    max-width: 960px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}


.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

.actions a {
    margin-right: 5px;
    text-decoration: none;
}

.actions .btn-edit {
    background-color: #28a745;
}

.actions .btn-edit:hover {
    background-color: #1e7e34;
}

.actions .btn-delete {
    background-color: #dc3545;
}

.actions .btn-delete:hover {
    background-color: #c82333;
}


.home-section {
    margin-bottom: 30px;
    padding: 20px;
    background-color: #e9ecef;
    border-radius: 8px;
}


form {
    margin-top: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
}


input[type="submit"],
a button {
    display: inline-block;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    margin-top: 20px; 
}


input[type="submit"] {
    background-color: #007bff; 
    color: white;
}

input[type="submit"]:hover {
    background-color: #0056b3; 
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
}

input[type="submit"]:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
}

a button {
    background-color: #6c757d; 
    color: white;
}

a button:hover {
    background-color: #545b62; 
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
}

a button:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.5);
}
/* Styles pour les messages d'erreur de formulaire */
.error-message {
    color: red;
    font-size: 0.9em;
    margin-top: 5px;
}
    </style>
</head>
<body>
    <h2>Register</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>

    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Role:</label>
        <select name="role" id="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <input type="submit" value="Register">
    </form>

    <br>
    <a href="login.php"><button>Back to Login</button></a>
</body>
</html>
