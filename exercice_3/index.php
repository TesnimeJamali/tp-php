<?php
require_once 'class.php'; 

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

function getRandomPokemon() {
    global $pokemonList;
    $randomPokemons = array_rand($pokemonList, 2); // Choisit deux Pokémon au hasard
    return [$pokemonList[$randomPokemons[0]], $pokemonList[$randomPokemons[1]]];
}
$list = getRandomPokemon();
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

<?php
$pokemon1 = $list[0]; 
$pokemon2 = $list[1]; 
$round = 1;
echo "<div class='battle-container'>";
while (!$pokemon1->isDead() && !$pokemon2->isDead()) {
    echo "<div class='round-container'>";
    echo "<div class='pokemon-box'>";
    echo "<img src='" . $pokemon1->getUrl() . "' alt='" . $pokemon1->getNom() . "'>";
    echo "<h1><strong>" . $pokemon1->getNom() . "</strong> (" . $pokemon1->getType() . ")</h1>";
    echo "<h3>HP: " . round($pokemon1->getHp(), 2) . "</h3>";
    echo "<hr>";
    echo "<p>" . $pokemon1->whoAmI() . "</p>";
    echo "</div>";
    echo "<div class='round-number'>Round $round</div>";
    echo "<div class='pokemon-box'>";
    echo "<img src='" . $pokemon2->getUrl() . "' alt='" . $pokemon2->getNom() . "'>";
    echo "<h1><strong>" . $pokemon2->getNom() . "</strong> (" . $pokemon2->getType() . ")</h1>";
    echo "<h3>HP: " . round($pokemon2->getHp(), 2) . "</h3>";
    echo "<hr>";
    echo "<p>" . $pokemon2->whoAmI() . "</p>";
    echo "</div>";
    echo "</div>";
    $pokemon1->attack($pokemon2);
    if (!$pokemon2->isDead()) {
        $pokemon2->attack($pokemon1);
    }
    $round++;
    echo "<hr>";
}

$winner = $pokemon1->isDead() ? $pokemon2 : $pokemon1;
echo "<h2 class='declare-winner'>🏆 Vainqueur: " . $winner->getNom() . "!</h2><img src='" . $winner->getUrl() . "' alt='" . $pokemon2->getNom() . "'>";
echo "</div>"; 
?>

</body>
</html>
