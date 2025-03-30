<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $db_host = 'localhost';
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_name = 'school_db'; // The name of the database to be created

    try {
        // Step 1: Connect to MySQL using the provided user credentials
        $conn = new PDO("mysql:host=$db_host", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions

        // Step 2: Create the database if it doesn't exist
        $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
        $conn->exec($sql); // Execute the query

        // Step 3: Select the database
        $conn->exec("USE $db_name");

        // Step 4: Create the table if it doesn't exist
        $sql = "
            CREATE TABLE IF NOT EXISTS student (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                birth_date DATE NOT NULL
            );
        ";

        $conn->exec($sql);

        // Step 5: Check if the students already exist
        $checkQuery = "SELECT COUNT(*) FROM student WHERE name = 'Samy Dupré' AND birth_date = '2005-01-01'";
        $result = $conn->query($checkQuery)->fetchColumn();

        // If the student doesn't exist, insert the data
        if ($result == 0) {
            $insertSql = "
                INSERT INTO student (name, birth_date) VALUES
                ('Samy Dupré', '2005-01-01'),
                ('Amélie Dupré', '2006-02-15'),
                ('Bruno Lecoq', '2005-03-10');
            ";
            $conn->exec($insertSql);
        }

        // Step 6: Save credentials in the session and redirect to students page
        $_SESSION['db_user'] = $db_user;
        $_SESSION['db_pass'] = $db_pass;
        
        echo "<p>Base de données et table créées avec succès!</p>";
        echo "<a href='students.php'>Voir les étudiants</a>";
        
    } catch (PDOException $e) {
        // Catch and display any errors that occur
        echo "Erreur : " . $e->getMessage();
    }
}
?>
