<?php
require_once __DIR__ . '/../includes/utilities/db.php';
global $conn;

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "<p>Accès refusé. Vous devez être connecté.</p>";
    exit();
}

$sql = "SELECT role FROM user WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['role'] !== 'admin') {
    http_response_code(403);
    echo "<p>Accès refusé. Vous n’êtes pas administrateur.</p>";
    exit();
}
?>

<main class="adminDashboard">

    <header class="adminHeader">
        <h1>Administration LOTY</h1>
        <p>Interface de gestion</p>
    </header>

    <section class="adminNavigation">

        <nav aria-label="Navigation administration">
            <ul>
                <li>
                    <a href="/admin/bentos">
                        Gérer les bentos
                    </a>
                </li>
                <li>
                    <a href="/admin/recettes">
                        Gérer les recettes
                    </a>
                </li>
                <li>
                    <a href="/admin/users">
                        Gérer les utilisateurs
                    </a>
                </li>
            </ul>
        </nav>

    </section>

    <section class="adminInfo">
        <p>
            Connecté en tant qu’administrateur.
        </p>
    </section>

</main>
