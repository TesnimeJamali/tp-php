<?php

class Section {
    private ?int $id;
    private string $designation;
    private ?string $description;

    public function __construct(?int $id, string $designation, ?string $description) {
        $this->id = $id;
        $this->designation = $designation;
        $this->description = $description;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getDesignation(): string {
        return $this->designation;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    // Méthodes statiques pour interagir avec la base de données
    public static function findById(PDO $db, int $id): ?Section {
        $stmt = $db->prepare("SELECT id, designation, description FROM sections WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $section = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($section) {
            return new Section($section['id'], $section['designation'], $section['description']);
        }
        return null;
    }

    public static function getAll(PDO $db): array {
        $stmt = $db->query("SELECT id, designation, description FROM sections");
        $sectionsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $sections = [];
        foreach ($sectionsData as $section) {
            $sections[] = new Section($section['id'], $section['designation'], $section['description']);
        }
        return $sections;
    }

    public static function create(PDO $db, string $designation, ?string $description): ?int {
        $stmt = $db->prepare("INSERT INTO sections (designation, description) VALUES (:designation, :description)");
        $stmt->bindParam(':designation', $designation);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function update(PDO $db, int $id, string $designation, ?string $description): bool {
        $stmt = $db->prepare("UPDATE sections SET designation = :designation, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':designation', $designation);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public static function delete(PDO $db, int $id): bool {
        $stmt = $db->prepare("DELETE FROM sections WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>