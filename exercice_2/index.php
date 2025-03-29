<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require 'session.php';
$session = Session::getInstance();
if (!$session->has('nbvisits')) {
    $session->set('nbvisits', 1);
    echo "<br>Bienvenue à notre platforme";
} else {
    $nbVisits = $session->get('nbvisits');
    $session->set('nbvisits', $nbVisits + 1);  // Incrémente et met à jour
    echo "<br>Merci pour votre fidélité, c'est votre " . $session->get('nbvisits') . "ème visite.";
}
?>
</body>
</html>

