<?php

interface IRepository {
    public function findAll();
    public function findById($id);
    public function create(array $params);
    public function delete($id);
}

require_once 'db.php';

abstract class Repository implements IRepository {
    protected PDO $db;
    protected string $tableName;

    public function __construct(string $tableName, PDO $db) {
        $this->db = $db;
        $this->tableName = $tableName;
    }

    public function findAll(): array {
        $query = "SELECT * FROM {$this->tableName}";
        $response = $this->db->query($query);
        return $response->fetchAll(PDO::FETCH_OBJ);
    }

    public function findById($id): ?object {
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $response = $this->db->prepare($query);
        $response->execute([':id' => $id]);
        return $response->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function create(array $params): ?object {
        $keys = array_keys($params);
        $keyString = implode(", ", $keys);
        $valuePlaceholders = implode(", ", array_fill(0, count($keys), '?'));
        $query = "INSERT INTO {$this->tableName} ({$keyString}) VALUES ({$valuePlaceholders})";
        $response = $this->db->prepare($query);
        $response->execute(array_values($params));

        $lastInsertId = $this->db->lastInsertId();

        return $this->findById($lastInsertId);
    }

    public function delete($id): void {
        $query = "DELETE FROM {$this->tableName} WHERE id = :id";
        $response = $this->db->prepare($query);
        $response->execute([':id' => $id]);
    }
}


class SectionRepository extends Repository {
    public function __construct(PDO $db) {
        parent::__construct('section', $db);
    }

}

class EtudiantRepository extends Repository {
    public function __construct(PDO $db) {
        parent::__construct('etudiant', $db);
    }

}
class UserRepository extends Repository {
    public function __construct(PDO $db) {
        parent::__construct('user', $db);
    }
    public function findByUsername($username): ?object {
        $query = "SELECT * FROM {$this->tableName} WHERE username = :username";
        $response = $this->db->prepare($query);
        $response->execute([':username' => $username]);
        return $response->fetch(PDO::FETCH_OBJ) ?: null;
    }
}

$sectionRepo = new SectionRepository($conn);

echo "<h2>Tests pour la table 'section'</h2>";

echo "<h3>findAll()</h3>";
$sections = $sectionRepo->findAll();
echo "<pre>";
print_r($sections);
echo "</pre>";

echo "<h3>create()</h3>";
$newSectionData = ['nom_section' => 'Commerce', 'description' => 'Section dédiée au commerce'];
$newSection = $sectionRepo->create($newSectionData);
echo "<pre>";
print_r($newSection);
echo "</pre>";

echo "<h3>findById()</h3>";
if ($newSection && isset($newSection->id)) {
    $foundSection = $sectionRepo->findById($newSection->id);
    echo "<pre>";
    print_r($foundSection);
    echo "</pre>";

    echo "<h3>delete()</h3>";
    $deleteResult = $sectionRepo->delete($newSection->id);
    echo "Section supprimée (vérifiez la base de données).<br>";

    echo "<h3>findAll() après suppression</h3>";
    $sectionsAfterDelete = $sectionRepo->findAll();
    echo "<pre>";
    print_r($sectionsAfterDelete);
    echo "</pre>";
} else {
    echo "Erreur lors de la création de la section, impossible de tester findById et delete.<br>";
}

echo "<hr>";


$userRepo = new UserRepository($conn);

echo "<h2>Tests pour la table 'user'</h2>";


echo "<h3>findAll()</h3>";
$users = $userRepo->findAll();
echo "<pre>";
print_r($users);
echo "</pre>";


echo "<h3>create()</h3>";
$newUserData = ['username' => 'another_user', 'password' => 'secure_pass', 'role' => 'admin'];
$newUser = $userRepo->create($newUserData);
echo "<pre>";
print_r($newUser);
echo "</pre>";


echo "<h3>findById()</h3>";
if ($newUser && isset($newUser->id)) {
    $foundUser = $userRepo->findById($newUser->id);
    echo "<pre>";
    print_r($foundUser);
    echo "</pre>";

    echo "<h3>delete()</h3>";
    $deleteResult = $userRepo->delete($newUser->id);
    echo "Utilisateur supprimé (vérifiez la base de données).<br>";

    echo "<h3>findAll() après suppression</h3>";
    $usersAfterDelete = $userRepo->findAll();
    echo "<pre>";
    print_r($usersAfterDelete);
    echo "</pre>";
} else {
    echo "Erreur lors de la création de l'utilisateur, impossible de tester findById et delete.<br>";
}

echo "<hr>";

?>