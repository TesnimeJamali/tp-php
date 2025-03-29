<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des sessions </title>
    <link rel="stylesheet" href="exercice2.css">
</head>
<body>
<?php
require 'session.php';
$session = Session::getInstance();
if (!$session->has('nbvisits')) {
    $session->set('nbvisits', 1);
    echo "<br> <h1> Bienvenue à notre platforme </h1>";
} else {
    $nbVisits = $session->get('nbvisits');
    $session->set('nbvisits', $nbVisits + 1);  // Incrémente et met à jour
    echo "  <h1> <br>Merci pour votre fidélité, c'est votre " . $session->get('nbvisits') . "ème visite. </h1>
    ";
}
if (isset($_POST['reset_session'])) {
    $session->destroy(); // Détruit la session
    echo "<h1> La session a été réinitialisée </h1>";
    header("Location: index.php"); // Redirect pour réinitialiser l'affichage
    exit();

}
?>
<div>
<form method="post">
            <button type="submit" name="reset_session" class="reset-button">Réinitialiser la session</button>
        </form>
    </div>
</body>
</html>

