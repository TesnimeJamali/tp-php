<?php

class User {
    private ?int $id;
    private string $username;
    private string $email;
    private string $password;
    private string $role;

    public function __construct(?int $id, string $username, string $email, string $password, string $role = 'student') {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getRole(): string {
        return $this->role;
    }
    public function getPassword(): string {
        return $this->password;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function setUsername(string $username): void {
        $this->username = $username;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }
    public function setPassword(string $password): void {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
    public function setRole(string $role): void {
        $this->role = $role;
    }
    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password);
    }
     // Méthodes pour interagir avec la base de données (communes à tous les utilisateurs)
     public static function findById(PDO $db, int $id): ?User {
        $stmt = $db->prepare("SELECT id, username, email, password, role FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new User($user['id'], $user['username'], $user['email'], $user['password'], $user['role']);
        }
        return null;
    }

    public static function findByUsername(PDO $db, string $username): ?User {
        $stmt = $db->prepare("SELECT id, username, email, password, role FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new User($user['id'], $user['username'], $user['email'], $user['password'], $user['role']);
        }
        return null;
    }
    public static function createUser(PDO $db, string $username, string $email, string $password, string $role = 'student'): ?int {
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        return $db->lastInsertId();
    }
}
?>