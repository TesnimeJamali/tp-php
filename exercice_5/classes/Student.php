<?php

require_once 'User.php';

class Etudiant extends User {
    private ?string $name;
    private ?string $birthday;
    private ?string $image;
    private ?int $sectionId;

    public function __construct(?int $id, string $username, string $email, string $password, ?string $name = null, ?string $birthday = null, ?string $image = null, ?int $sectionId = null) {
        parent::__construct($id, $username, $email, $password, 'etudiant');
        $this->name = $name;
        $this->birthday = $birthday;
        $this->image = $image;
        $this->sectionId = $sectionId;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function getBirthday(): ?string {
        return $this->birthday;
    }

    public function getImage(): ?string {
        return $this->image;
    }

    public function getSectionId(): ?int {
        return $this->sectionId;
    }

    // Méthodes pour interagir avec la base de données (spécifiques à l'étudiant)
    public static function findById(PDO $db, int $id): ?Etudiant {
        $stmt = $db->prepare("SELECT u.id, u.username, u.email, u.password, s.name, s.birthday, s.image, s.section_id
                               FROM users u
                               JOIN students s ON u.id = s.id
                               WHERE u.id = :id AND u.role = 'etudiant'");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $etudiantData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($etudiantData) {
            return new Etudiant(
                $etudiantData['id'],
                $etudiantData['username'],
                $etudiantData['email'],
                $etudiantData['password'],
                $etudiantData['name'],
                $etudiantData['birthday'],
                $etudiantData['image'],
                $etudiantData['section_id']
            );
        }
        return null;
    }

    // Méthode pour récupérer les informations de l'étudiant connecté via l'ID utilisateur
    public static function findByUserId(PDO $db, int $userId): ?Etudiant {
        $stmt = $db->prepare("SELECT u.id, u.username, u.email, u.password, s.name, s.birthday, s.image, s.section_id
                               FROM users u
                               JOIN students s ON u.id = s.id
                               WHERE u.id = :user_id AND u.role = 'etudiant'");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $etudiantData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($etudiantData) {
            return new Etudiant(
                $etudiantData['id'],
                $etudiantData['username'],
                $etudiantData['email'],
                $etudiantData['password'],
                $etudiantData['name'],
                $etudiantData['birthday'],
                $etudiantData['image'],
                $etudiantData['section_id']
            );
        }
        return null;
    }
}

?>