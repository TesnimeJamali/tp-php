<?php
require_once 'class.php';

// --- Combat 1: Deux Pokémon normaux ---
$round1 = 1;
$attackPikachu1 = new AttackPokemon(
    attackMinimal: 30,
    attackMaximal: 80,
    specialAttack: 4,
    probabilitySpecialAttack: 20
);

$attackCharizard1 = new AttackPokemon(
    attackMinimal: 10,
    attackMaximal: 100,
    specialAttack: 2,
    probabilitySpecialAttack: 20
);

$pikachu1 = new Pokemon(
    nom: "Pikachu",
    url: "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png",
    hp: 200,
    attackpokemon: $attackPikachu1
);

$charizard1 = new Pokemon(
    nom: "Charizard",
    url: "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png",
    hp: 200,
    attackpokemon: $attackCharizard1
);

// --- Préparation pour les combats 2 & 3 (Pokémon de différents types) ---
$pokemonList = [
    new PokemonFeu("Salamèche", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png", 100, new AttackPokemon(10, 20, 2, 30)),
    new PokemonEau("Carapuce", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png", 100, new AttackPokemon(12, 18, 1.5, 20)),
    new PokemonPlante("Bulbizarre", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png", 100, new AttackPokemon(8, 16, 1.8, 25)),
    new PokemonFeu("Dracaufeu", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png", 150, new AttackPokemon(25, 40, 3, 15)),
    new PokemonEau("Squirtle", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/10.png", 90, new AttackPokemon(15, 22, 1.6, 10)),
    new PokemonPlante("Herbizarre", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/43.png", 110, new AttackPokemon(14, 22, 2, 20)),
    new PokemonFeu("Reptincel", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/5.png", 120, new AttackPokemon(18, 28, 2.5, 18)),
    new PokemonEau("Pikachu", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png", 100, new AttackPokemon(10, 30, 1.7, 30)),
    new PokemonPlante("Chlorobule", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/46.png", 95, new AttackPokemon(12, 18, 1.5, 15)),
    new PokemonFeu("Volcaropod", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/636.png", 140, new AttackPokemon(28, 35, 3.3, 40)),
    new PokemonEau("Dracolosse", "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/149.png", 200, new AttackPokemon(30, 50, 3.5, 50)),
];

function getRandomPokemonPair() {
    global $pokemonList;
    $randomKeys = array_rand($pokemonList, 2);
    return [$pokemonList[$randomKeys[0]], $pokemonList[$randomKeys[1]]];
}

$combat2Pokemons = getRandomPokemonPair();
$combat3Pokemons = getRandomPokemonPair();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat Pokémon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class='battle-container'>
    <?php
    // --- Combat 1 ---
    echo "<h1 >Combat 1</h1>";
    echo "<h2 >Combat entre " . $pikachu1->getNom() . " et " . $charizard1->getNom() . "</h2>";
    $round = 1;
    while (!$pikachu1->isDead() && !$charizard1->isDead()) {
        echo "<div class='round-container'>";
        echo "<div class='pokemon-box'>";
        echo "<img src='" . $pikachu1->getUrl() . "' alt='" . $pikachu1->getNom() . "'>";
        echo "<h1><strong>" . $pikachu1->getNom() . "</strong> </h1>";
        echo "<h3>HP: " . round($pikachu1->getHp(), 2) . "</h3>";
        echo "<hr>";
        echo "<p>" . $pikachu1->whoAmI() . "</p>";
        echo "</div>";
        echo "<div class='round-number'>Round " . $round . "</div>";
        echo "<div class='pokemon-box'>";
        echo "<img src='" . $charizard1->getUrl() . "' alt='" . $charizard1->getNom() . "'>";
        echo "<h1><strong>" . $charizard1->getNom() . "</strong> </h1>";
        echo "<h3>HP: " . round($charizard1->getHp(), 2) . "</h3>";
        echo "<hr>";
        echo "<p>" . $charizard1->whoAmI() . "</p>";
        echo "</div>";
        echo "</div>";
        $pikachu1->attack($charizard1);
        if (!$charizard1->isDead()) {
            $charizard1->attack($pikachu1);
        }
        $round++;
        echo "<hr>";
    }
    $winner1 = $pikachu1->isDead() ? $charizard1 : $pikachu1;
    echo "<h2 class='declare-winner'>🏆 Vainqueur du Combat 1: " . $winner1->getNom() . "!</h2><img src='" . $winner1->getUrl() . "' alt='" . $winner1->getNom() . "'>";

    // --- Combat 2 ---
    echo "<h1 >Combat 2</h1>";
    echo "<h2 >Combat entre " . $combat2Pokemons[0]->getNom() . " et " . $combat2Pokemons[1]->getNom() . "</h2>";
    $pokemon2a = $combat2Pokemons[0];
    $pokemon2b = $combat2Pokemons[1];
    $round = 1;
    while (!$pokemon2a->isDead() && !$pokemon2b->isDead()) {
        echo "<div class='round-container'>";
        echo "<div class='pokemon-box'>";
        echo "<img src='" . $pokemon2a->getUrl() . "' alt='" . $pokemon2a->getNom() . "'>";
        echo "<h1><strong>" . $pokemon2a->getNom() . "</strong> (" . $pokemon2a->getType() . ")</h1>";
        echo "<h3>HP: " . round($pokemon2a->getHp(), 2) . "</h3>";
        echo "<hr>";
        echo "<p>" . $pokemon2a->whoAmI() . "</p>";
        echo "</div>";
        echo "<div class='round-number'>Round " . $round . "</div>";
        echo "<div class='pokemon-box'>";
        echo "<img src='" . $pokemon2b->getUrl() . "' alt='" . $pokemon2b->getNom() . "'>";
        echo "<h1><strong>" . $pokemon2b->getNom() . "</strong> (" . $pokemon2b->getType() . ")</h1>";
        echo "<h3>HP: " . round($pokemon2b->getHp(), 2) . "</h3>";
        echo "<hr>";
        echo "<p>" . $pokemon2b->whoAmI() . "</p>";
        echo "</div>";
        echo "</div>";
        $pokemon2a->attack($pokemon2b);
        if (!$pokemon2b->isDead()) {
            $pokemon2b->attack($pokemon2a);
        }
        $round++;
        echo "<hr>";
    }
    $winner2 = $pokemon2a->isDead() ? $pokemon2b : $pokemon2a;
    echo "<h2 class='declare-winner'>🏆 Vainqueur du Combat 2: " . $winner2->getNom() . "!</h2><img src='" . $winner2->getUrl() . "' alt='" . $pokemon2b->getNom() . "'>";

    // --- Combat 3 ---
    echo "<h1 >Combat 3</h1>";
    echo "<h2 >Combat entre " . $combat3Pokemons[0]->getNom() . " et " . $combat3Pokemons[1]->getNom() . "</h2>";
    $pokemon3a = $combat3Pokemons[0];
    $pokemon3b = $combat3Pokemons[1];
    $round = 1;
    while (!$pokemon3a->isDead() && !$pokemon3b->isDead()) {
        echo "<div class='round-container'>";
        echo "<div class='pokemon-box'>";
        echo "<img src='" . $pokemon3a->getUrl() . "' alt='" . $pokemon3a->getNom() . "'>";
        echo "<h1><strong>" . $pokemon3a->getNom() . "</strong> (" . $pokemon3a->getType() . ")</h1>";
        echo "<h3>HP: " . round($pokemon3a->getHp(), 2) . "</h3>";
        echo "<hr>";
        echo "<p>" . $pokemon3a->whoAmI() . "</p>";
        echo "</div>";
        echo "<div class='round-number'>Round " . $round . "</div>";
        echo "<div class='pokemon-box'>";
        echo "<img src='" . $pokemon3b->getUrl() . "' alt='" . $pokemon3b->getNom() . "'>";
        echo "<h1><strong>" . $pokemon3b->getNom() . "</strong> (" . $pokemon3b->getType() . ")</h1>";
        echo "<h3>HP: " . round($pokemon3b->getHp(), 2) . "</h3>";
        echo "<hr>";
        echo "<p>" . $pokemon3b->whoAmI() . "</p>";
        echo "</div>";
        echo "</div>";
        $pokemon3a->attack($pokemon3b);
        if (!$pokemon3b->isDead()) {
            $pokemon3b->attack($pokemon3a);
        }
        $round++;
        echo "<hr>";
    }
    $winner3 = $pokemon3a->isDead() ? $pokemon3b : $pokemon3a;
    echo "<h2 class='declare-winner'>🏆 Vainqueur du Combat 3: " . $winner3->getNom() . "!</h2><img src='" . $winner3->getUrl() . "' alt='" . $pokemon3b->getNom() . "'>";
    ?>
</div>

</body>
</html>



