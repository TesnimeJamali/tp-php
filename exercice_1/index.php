<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1 class="text-center mb-4">Résultats des Étudiants</h1>
    <div class="row">
    <?php
    class Etudiant{
        public function __construct( private string $nom, private $notes) {}
        public function getNom() {
            return $this->nom;
        }
        public function getNotes() {
            return $this->notes;
        }
        public function setNom($nom) {
            $this->nom = $nom;
        }
        public function setNotes($notes) {
            $this->notes = $notes;
        }
        
        public function affichernotes(): void {
            echo "<div class='card mt-3'>";
            echo "<div class='card-header bg-primary text-white text-center'><h3>{$this->nom}</h3></div>";
            echo "<ul class='list-group list-group-flush'>";

            foreach ($this->notes as $note) {
                $class = ($note < 10) ? "red" : (($note == 10) ? "orange" : "green");
                echo "<li class='list-group-item $class'>$note</li>";
            }

            echo "</ul></div>";
        }

        public function calculerMoyenne(): float {
            return array_sum($this->notes) / count($this->notes);
        }

        public function afficher_résultat(): void {
            $moyenne = $this->calculerMoyenne();
            $class = ($moyenne < 10) ? "text-danger" : (($moyenne == 10) ? "text-warning" : "text-success");

            echo "<h3 class='$class text-center mt-2'>Moyenne : " . number_format($moyenne, 2) . "</h3>";
        }
    }
    $etudiants = [
        new Etudiant("Aymen", [11, 13, 18, 7, 10, 13, 2, 5, 1]),
        new Etudiant("Skander", [15, 9, 8, 16]),
        new Etudiant("Sarah", [14, 12, 10, 19, 17]),
        new Etudiant("Omar", [5, 6, 8, 9, 10])
    ];
    // pour afficher chaque 2 etudiants dans une ligne
    foreach ($etudiants as $index => $etudiant) {
        echo "<div class='col-md-6'>";
        $etudiant->affichernotes();
        $etudiant->afficher_résultat();
        echo "</div>";
        if (($index + 1) % 2 == 0) {
            echo "</div><div class='row'>";
        }
    }
    ?>
    </div>
</div>
</body>
</html>
