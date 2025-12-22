<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

echo "<h2>Profil de l'utilisateur</h2>";
echo "<p>Nom d'utilisateur : " . htmlspecialchars($_SESSION['username']) . "</p>";
?>