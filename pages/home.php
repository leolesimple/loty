<?php
if (isset($_SESSION['user_id'])) {
    echo "<p>Vous êtes connecté en tant que " . clean($_SESSION['username']) . ".</p>";
    echo '<a href="/loty/dashboard">Aller au tableau de bord</a>';
} else {
    echo "<p>Vous n'êtes pas connecté.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenue chez LOTY</h1>
<a href="/loty/login">Se connecter</a>
<a href="/loty/register">S'inscrire</a>
</body>
</html>

