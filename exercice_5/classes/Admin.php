<?php

require_once 'User.php';
require_once 'Student.php';
require_once 'Section.php';

class Admin extends User {
    public function __construct(?int $id, string $username, string $email, string $password) {
        parent::__construct($id, $username, $email, $password, 'admin');
    }

    // Méthodes CRUD pour les étudiants
    public static function createStudent(PDO $db, string $name, ?string $birthday, ?string $image, int $sectionId): ?int {
        return Student::create($db, $name, $birthday, $image, $sectionId);
    }

    public static function getStudentById(PDO $db, int $id): ?Student {
        return Student::findById($db, $id);
    }

    public static function getAllStudents(PDO $db): array {
        return Student::getAll($db);
    }

    public static function updateStudent(PDO $db, int $id, string $name, ?string $birthday, ?string $image, int $sectionId): bool {
        return Student::update($db, $id, $name, $birthday, $image, $sectionId);
    }

    public static function deleteStudent(PDO $db, int $id): bool {
        return Student::delete($db, $id);
    }

    // Méthodes CRUD pour les sections
    public static function createSection(PDO $db, string $designation, ?string $description): ?int {
        return Section::create($db, $designation, $description);
    }

    public static function getSectionById(PDO $db, int $id): ?Section {
        return Section::findById($db, $id);
    }

    public static function getAllSections(PDO $db): array {
        return Section::getAll($db);
    }

    public static function updateSection(PDO $db, int $id, string $designation, ?string $description): bool {
        return Section::update($db, $id, $designation, $description);
    }

    public static function deleteSection(PDO $db, int $id): bool {
        return Section::delete($db, $id);
    }
}

?>