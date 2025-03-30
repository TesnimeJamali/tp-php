<?php
class Section
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get all sections
    public function getAllSections()
    {
        $query = "SELECT * FROM section";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a section by ID
    public function getSectionById($id)
    {
        $query = "SELECT * FROM section WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new section
    public function createSection($designation, $description)
    {
        $query = "INSERT INTO section (designation, description) VALUES (:designation, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':designation', $designation, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Update a section
    public function updateSection($id, $designation, $description)
    {
        $query = "UPDATE section SET designation = :designation, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':designation', $designation, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Delete a section
    public function deleteSection($id)
    {
        $query = "DELETE FROM section WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>
