<?php
require_once "db.php";

class User {
    private $conn;

    public function __construct() {
        global $conn; // Use the global $conn from db.php
        $this->conn = $conn;
    }

    // Register a new user
    public function register($username, $email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':role' => $role
        ]);
    }

    // Login user
    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
?>
