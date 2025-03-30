<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_host = 'localhost';
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_name = 'school_db'; 

    try {
        $conn = new PDO("mysql:host=$db_host", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
        $conn->exec($sql); 

        $conn->exec("USE $db_name");

        $sql = "
            CREATE TABLE IF NOT EXISTS student (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                birth_date DATE NOT NULL
            );
        ";

        $conn->exec($sql);

        $checkQuery = "SELECT COUNT(*) FROM student WHERE name = 'Samy Dupré' AND birth_date = '2005-01-01'";
        $result = $conn->query($checkQuery)->fetchColumn();

        if ($result == 0) {
            $insertSql = "
                INSERT INTO student (name, birth_date) VALUES
                ('Samy Dupré', '2005-01-01'),
                ('Amélie Dupré', '2006-02-15'),
                ('Bruno Lecoq', '2005-03-10');
            ";
            $conn->exec($insertSql);
        }

        $_SESSION['db_user'] = $db_user;
        $_SESSION['db_pass'] = $db_pass;
        
        echo "<div class='alert alert-success custom-alert' role='alert'>";
        echo "<strong>Succès!</strong> La base de données et la table ont été créées avec succès.";
        echo "</div>";

        echo "<div class='text-center'>";
        echo "<a href='students.php' class='btn btn-primary custom-btn'>Voir les étudiants</a>";
        echo "</div>";
        
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        margin-top: 50px;
    }

    .custom-alert {
        background-color: #28a745; /* Green */
        color: white;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .custom-btn {
        background-color: #007bff;
        color: white;
        font-size: 16px;
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .custom-btn:hover {
        background-color: #0056b3;
        text-decoration: none;
    }

    .text-center {
        margin-top: 30px;
    }
</style>
