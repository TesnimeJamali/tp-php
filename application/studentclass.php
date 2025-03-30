<?php
class Student
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Récupérer tous les étudiants
    public function getAllStudents()
    {
        $query = "SELECT * FROM etudiant";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un étudiant par ID
    public function getStudentById($id)
    {
        $query = "SELECT * FROM etudiant WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouvel étudiant
    public function createStudent($name, $birthday, $image, $section)
    {
        $query = "INSERT INTO etudiant (name, birthday, image, section) VALUES (:name, :birthday, :image, :section)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':section', $section, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    // Mettre à jour un étudiant
    public function updateStudent($id, $name, $birthday, $section, $image)
    {
        $query = "UPDATE etudiant SET name = :name, birthday = :birthday, image = :image, section = :section WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':section', $section, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Supprimer un étudiant
    public function deleteStudent($id)
    {
        $query = "DELETE FROM etudiant WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>
