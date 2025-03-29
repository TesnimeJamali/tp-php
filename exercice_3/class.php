<?php
    /**
     * Classe représentant les caractéristiques d'attaque d'un Pokémon.
     */
    class AttackPokemon {
        /**
         * Attaque minimale du Pokémon.
         * @var float
         */
        private float $attackMinimal;

        /**
         * Attaque maximale du Pokémon.
         * @var float
         */
        private float $attackMaximal;

        /**
         * Coefficient multiplicateur pour l'attaque spéciale.
         * @var float
         */
        private float $specialAttack;

        /**
         * Probabilité (en pourcentage) de déclencher une attaque spéciale.
         * @var float
         */
        private float $probabilitySpecialAttack;

        /**
         * Constructeur de la classe AttackPokemon.
         *
         * @param float $attackMinimal Attaque minimale.
         * @param float $attackMaximal Attaque maximale.
         * @param float $specialAttack Coefficient de l'attaque spéciale.
         * @param float $probabilitySpecialAttack Probabilité de l'attaque spéciale (en pourcentage).
         */
        public function __construct(float $attackMinimal, float $attackMaximal, float $specialAttack, float $probabilitySpecialAttack) {
            $this->attackMinimal = $attackMinimal;
            $this->attackMaximal = $attackMaximal;
            $this->specialAttack = $specialAttack;
            $this->probabilitySpecialAttack = $probabilitySpecialAttack;
        }

        /**
         * Récupère l'attaque minimale.
         *
         * @return float L'attaque minimale.
         */
        public function getAttackMinimal(): float {
            return $this->attackMinimal;
        }

        /**
         * Récupère l'attaque maximale.
         *
         * @return float L'attaque maximale.
         */
        public function getAttackMaximal(): float {
            return $this->attackMaximal;
        }

        /**
         * Récupère le coefficient de l'attaque spéciale.
         *
         * @return float Le coefficient de l'attaque spéciale.
         */
        public function getSpecialAttack(): float {
            return $this->specialAttack;
        }

        /**
         * Récupère la probabilité de l'attaque spéciale.
         *
         * @return float La probabilité de l'attaque spéciale (en pourcentage).
         */
        public function getProbabilitySpecialAttack(): float {
            return $this->probabilitySpecialAttack;
        }

        /**
         * Modifie l'attaque minimale.
         *
         * @param float $attackMinimal La nouvelle attaque minimale.
         * @return void
         */
        public function setAttackMinimal(float $attackMinimal): void {
            $this->attackMinimal = $attackMinimal;
        }

        /**
         * Modifie l'attaque maximale.
         *
         * @param float $attackMaximal La nouvelle attaque maximale.
         * @return void
         */
        public function setAttackMaximal(float $attackMaximal): void {
            $this->attackMaximal = $attackMaximal;
        }

        /**
         * Modifie le coefficient de l'attaque spéciale.
         *
         * @param float $specialAttack Le nouveau coefficient de l'attaque spéciale.
         * @return void
         */
        public function setSpecialAttack(float $specialAttack): void {
            $this->specialAttack = $specialAttack;
        }

        /**
         * Modifie la probabilité de l'attaque spéciale.
         *
         * @param float $probabilitySpecialAttack La nouvelle probabilité de l'attaque spéciale (en pourcentage).
         * @return void
         */
        public function setProbabilitySpecialAttack(float $probabilitySpecialAttack): void {
            $this->probabilitySpecialAttack = $probabilitySpecialAttack;
        }
    }
//----------------------------------------------------------------------------------------------------------------------


    /**
     * Classe de base représentant un Pokémon.
     */
    class Pokemon{
        /**
         * Nom du Pokémon.
         * @var string
         */
        private string $nom;

        /**
         * URL de l'image du Pokémon.
         * @var string
         */
        private string $url;

        /**
         * Points de vie (HP) du Pokémon.
         * @var float
         */
        private float $hp;

        /**
         * Objet AttackPokemon contenant les caractéristiques d'attaque du Pokémon.
         * @var AttackPokemon
         */
        private AttackPokemon $attackpokemon;

        /**
         * Type du Pokémon (par défaut 'Normal').
         * @var string
         */
        protected string $type = 'Normal';

        /**
         * Constructeur de la classe Pokemon.
         *
         * @param string $nom Nom du Pokémon.
         * @param string $url URL de l'image du Pokémon.
         * @param float $hp Points de vie du Pokémon.
         * @param AttackPokemon $attackpokemon Objet AttackPokemon du Pokémon.
         * @param string $type Type du Pokémon (optionnel, par défaut 'Normal').
         */
        public function __construct(string $nom, string $url, float $hp, AttackPokemon $attackpokemon, string $type = 'Normal') {
            $this->nom = $nom;
            $this->url = $url;
            $this->hp = $hp;
            $this->attackpokemon = $attackpokemon;
            $this->type = $type;
        }

        /**
         * Récupère le nom du Pokémon.
         *
         * @return string Le nom du Pokémon.
         */
        public function getNom(): string {
            return $this->nom;
        }

        /**
         * Récupère l'URL de l'image du Pokémon.
         *
         * @return string L'URL de l'image du Pokémon.
         */
        public function getUrl(): string {
            return $this->url;
        }

        /**
         * Récupère les points de vie du Pokémon.
         *
         * @return float Les points de vie du Pokémon.
         */
        public function getHp(): float {
            return $this->hp;
        }

        /**
         * Récupère l'objet AttackPokemon du Pokémon.
         *
         * @return AttackPokemon L'objet AttackPokemon.
         */
        public function getAttackPokemon(): AttackPokemon {
            return $this->attackpokemon;
        }

        /**
         * Récupère le type du Pokémon.
         *
         * @return string Le type du Pokémon.
         */
        public function getType(): string {
            return $this->type;
        }

        /**
         * Modifie le nom du Pokémon.
         *
         * @param string $nom Le nouveau nom du Pokémon.
         * @return void
         */
        public function setNom(string $nom): void {
            $this->nom = $nom;
        }

        /**
         * Modifie l'URL de l'image du Pokémon.
         *
         * @param string $url La nouvelle URL de l'image du Pokémon.
         * @return void
         */
        public function setUrl(string $url): void {
            $this->url = $url;
        }

        /**
         * Modifie les points de vie du Pokémon.
         *
         * @param float $hp Les nouveaux points de vie du Pokémon.
         * @return void
         */
        public function setHp(float $hp): void {
            $this->hp = $hp;
        }

        /**
         * Modifie l'objet AttackPokemon du Pokémon.
         *
         * @param AttackPokemon $attackpokemon Le nouvel objet AttackPokemon.
         * @return void
         */
        public function setAttackPokemon(AttackPokemon $attackpokemon): void {
            $this->attackpokemon = $attackpokemon;
        }

        /**
         * Modifie le type du Pokémon.
         *
         * @param string $type Le nouveau type du Pokémon.
         * @return void
         */
        public function setType(string $type): void {
            $this->type = $type;
        }

        /**
         * Vérifie si le Pokémon est K.O.
         *
         * @return bool True si les HP sont inférieurs ou égaux à 0, false sinon.
         */
        public function isDead(): bool {
            return $this->hp <= 0;
        }

        /**
         * Effectue une attaque sur un autre Pokémon.
         *
         * @param Pokemon $pokemon Le Pokémon à attaquer.
         * @return void
         */
        public function attack(Pokemon $pokemon): void {
            // Calcule les dégâts de l'attaque de base
            $attack = rand($this->attackpokemon->getAttackMinimal(), $this->attackpokemon->getAttackMaximal());
            $specialAttack = false;

            // Vérifie si une attaque spéciale se déclenche
            if (rand(0, 100) < $this->attackpokemon->getProbabilitySpecialAttack()) {
                $attack *= $this->attackpokemon->getSpecialAttack();
                $specialAttack = true;
            }

            // Obtient l'efficacité du type de l'attaquant contre le type du défenseur
            $typeEffectiveness = $this->getTypeEffectiveness($pokemon->getPokemonType());
            // Calcule les dégâts finaux
            $damage = $attack * $typeEffectiveness;
            // Applique les dégâts au Pokémon attaqué
            $pokemon->setHp($pokemon->getHp() - $damage);

            echo "<p class='attack-info'> <img src='" . $this->getUrl() . "' alt='" . $this->getNom() . "'>" . round($damage, 2) . " points.";
            if ($specialAttack) {
                echo " (Attaque spéciale !)";
            }
            if ($typeEffectiveness > 1) {
                echo " (C'est super efficace !)";
            } elseif ($typeEffectiveness < 1 && $typeEffectiveness > 0) {
                echo " (Ce n'est pas très efficace...)";
            } elseif ($typeEffectiveness === 0) {
                echo " (Aucun effet...)";
            }
            echo "</p><br>";
        }

        /**
         * Récupère le type du Pokémon (pour usage interne).
         *
         * @return string Le type du Pokémon.
         */
        protected function getPokemonType(): string {
            return $this->type;
        }

        /**
         * Détermine l'efficacité du type de l'attaquant contre le type du défenseur.
         *
         * @param string $targetType Le type du Pokémon défenseur.
         * @return float Le multiplicateur d'efficacité (2.0 = super efficace, 0.5 = pas très efficace, 0 = aucun effet, 1.0 = normal).
         */
        protected function getTypeEffectiveness(string $targetType): float {
            if ($this->type === 'Feu') {
                if ($targetType === 'Plante') return 2.0;
                if ($targetType === 'Eau' || $targetType === 'Feu') return 0.5;
            } elseif ($this->type === 'Eau') {
                if ($targetType === 'Feu') return 2.0;
                if ($targetType === 'Eau' || $targetType === 'Plante') return 0.5;
            } elseif ($this->type === 'Plante') {
                if ($targetType === 'Eau') return 2.0;
                if ($targetType === 'Plante' || $targetType === 'Feu') return 0.5;
            }
            return 1.0; // Dégâts normaux pour les autres types (y compris Normal)
        }

        /**
         * Affiche les informations du Pokémon.
         *
         * @return void
         */
        public function whoAmI(): void {
            echo "Attaque Minimale: " . $this->attackpokemon->getAttackMinimal() . "<br>";
            echo "Attaque Maximale: " . $this->attackpokemon->getAttackMaximal() . "<br>";
            echo "Coefficient Attaque Spéciale: " . $this->attackpokemon->getSpecialAttack() . "<br>";
            echo "Probabilité Attaque Spéciale: " . $this->attackpokemon->getProbabilitySpecialAttack() . "%<br><br>";
        }
    }

    /**
     * Classe représentant un Pokémon de type Feu, héritant de la classe Pokemon.
     */
    class PokemonFeu extends Pokemon {
        /**
         * Le type spécifique de ce Pokémon.
         * @var string
         */
        protected string $type = 'Feu';

        /**
         * Constructeur de la classe PokemonFeu.
         *
         * @param string $nom Nom du Pokémon.
         * @param string $url URL de l'image du Pokémon.
         * @param float $hp Points de vie du Pokémon.
         * @param AttackPokemon $attackpokemon Objet AttackPokemon du Pokémon.
         */
        public function __construct(string $nom, string $url, float $hp, AttackPokemon $attackpokemon) {
            parent::__construct($nom, $url, $hp, $attackpokemon, 'Feu');
        }
    }

    /**
     * Classe représentant un Pokémon de type Eau, héritant de la classe Pokemon.
     */
    class PokemonEau extends Pokemon {
        /**
         * Le type spécifique de ce Pokémon.
         * @var string
         */
        protected string $type = 'Eau';

        /**
         * Constructeur de la classe PokemonEau.
         *
         * @param string $nom Nom du Pokémon.
         * @param string $url URL de l'image du Pokémon.
         * @param float $hp Points de vie du Pokémon.
         * @param AttackPokemon $attackpokemon Objet AttackPokemon du Pokémon.
         */
        public function __construct(string $nom, string $url, float $hp, AttackPokemon $attackpokemon) {
            parent::__construct($nom, $url, $hp, $attackpokemon, 'Eau');
        }
    }

    /**
     * Classe représentant un Pokémon de type Plante, héritant de la classe Pokemon.
     */
    class PokemonPlante extends Pokemon {
        /**
         * Le type spécifique de ce Pokémon.
         * @var string
         */
        protected string $type = 'Plante';

        /**
         * Constructeur de la classe PokemonPlante.
         *
         * @param string $nom Nom du Pokémon.
         * @param string $url URL de l'image du Pokémon.
         * @param float $hp Points de vie du Pokémon.
         * @param AttackPokemon $attackpokemon Objet AttackPokemon du Pokémon.
         */
        public function __construct(string $nom, string $url, float $hp, AttackPokemon $attackpokemon) {
            parent::__construct($nom, $url, $hp, $attackpokemon, 'Plante');
      
        }
    }
    ?>