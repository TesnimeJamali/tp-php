<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des étudiants</title>
</head>
<body>
    <?php

    class Etudiant{
        private $nom;
        private $notes;


        public function __construct($nom, $notes) {
            $this->nom = $nom;
            $this->notes = $notes;
        }
        public function affichernotes(){
            echo "<h3>Les notes de l'étudiant {$this->nom} sont :</h3>";
            echo "<ul>";
            foreach ($this->notes as $note) {
                $style = '';
                if ($note < 10) {
                    $style = 'background-color: red; color: white; padding: 5px; display: inline-block; margin-right: 5px;';
                } elseif ($note > 10) {
                    $style = 'background-color: green; color: white; padding: 5px; display: inline-block; margin-right: 5px;';
                } else {
                    $style = 'background-color: orange; color: white; padding: 5px; display: inline-block; margin-right: 5px;';
                }
                echo "<li style='" . $style . "'>" . $note . "</li>";
            }
            echo "</ul>";
            }
        public function calculerMoyenne() {
                $somme = 0;
                foreach ($this->notes as $note) {
                    $somme += $note;
                }
                return $somme / count($this->notes);
            }
        public function afficher_résultat() {
            $moyenne = $this->calculerMoyenne();
            if ($moyenne < 10) {
                echo "<h3 style='color: red;'>L'étudiant {$this->nom} a échoué avec une moyenne de " . number_format($moyenne, 2) . "</h3>";
            } elseif ($moyenne > 10) {
                echo "<h3 style='color: green;'>L'étudiant {$this->nom} a réussi avec une moyenne de " . number_format($moyenne, 2) . "</h3>";
            } else {
                echo "<h3 style='color: orange;'>L'étudiant {$this->nom} a une moyenne de " . number_format($moyenne, 2) . "</h3>";
            }
        }
    }

    $etudiant1 = new Etudiant("Aymen", [11, 13, 18, 7, 10, 13, 2, 5, 1]);
    $etudiant2 = new Etudiant("Skander", [15, 9, 8, 16]);
    $etudiant1->affichernotes();
    $etudiant1->afficher_résultat();
    echo "<hr>";
    $etudiant2->affichernotes();
    $etudiant2->afficher_résultat();

    ?>
</body>
</html>