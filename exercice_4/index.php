<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion à la Base de Données</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href=style.css rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Connexion à la Base de Données MySQL</h1>
    <form action="setup.php" method="POST">
        <div class="mb-3">
            <label for="db_user" class="form-label">Nom d'utilisateur MySQL</label>
            <input type="text" class="form-control" id="db_user" name="db_user" required>
        </div>
        <div class="mb-3">
            <label for="db_pass" class="form-label">Mot de passe MySQL</label>
            <input type="password" class="form-control" id="db_pass" name="db_pass" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>
</body>
</html>
