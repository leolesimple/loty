<?php
if (isset($_SESSION['user_id'])) {
    echo "<p>Vous êtes connecté en tant que " . clean($_SESSION['username']) . ".</p>";
    echo '<a href="/loty/dashboard">Aller au tableau de bord</a>';
} else {
    echo "<p>Vous n'êtes pas connecté.</p>";
}
?>

<h1>Bienvenue chez LOTY</h1>
<a href="/loty/login">Se connecter</a>
<a href="/loty/register">S'inscrire</a>