<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}
echo "<h2>Dashboard</h2>";
echo "<p>Bienvenue, " . clean($_SESSION['username']) . "!</p>";