<?php
global $conn;
// Session start if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../includes/utilities/db.php';
require_once __DIR__ . '/../../includes/utilities/recipes.php';
require_once __DIR__ . '/../../includes/utilities/auth.php';

// Get the type parameter from URL
$type = isset($_GET['type']) ? (int)$_GET['type'] : null;

// Validate type
if ($type === null || $type < 1 || $type > 4) {
    http_response_code(400);
    echo '<p>Type de recette invalide.</p>';
    exit;
}

// Map type ID to label
$typeLabels = [
    1 => 'Entrées',
    2 => 'Plats',
    3 => 'Accompagnements',
    4 => 'Desserts'
];

$typeLabel = $typeLabels[$type] ?? 'Recettes';

// Fetch all recipes of the given type
$recette_query = $conn->prepare(
    "SELECT id_recette, recette_nom, recette_img_link
     FROM recette
     WHERE id_type = :type
     ORDER BY id_recette DESC"
);

$recette_query->bindValue(':type', $type, PDO::PARAM_INT);
$recette_query->execute();

$recettes = $recette_query->fetchAll();
?>

<header class="bentoHeader">
    <h1 class="viewAll">
        Toutes les <span class="blueText"><?php echo htmlspecialchars($typeLabel); ?></span>
    </h1>
    <a href="/recettes/add" class="btn btn_red">
        Ajouter une recette
    </a>
</header>

<section class="recettesContainer">
    <header class="recettesSectionHeader">
        <h2><?php echo htmlspecialchars($typeLabel); ?></h2>
    </header>

    <section class="bentoGrid recetteGrid">
        <?php
        if (count($recettes) === 0) {
            echo '<p>Aucune recette ' . htmlspecialchars(strtolower($typeLabel)) . ' trouvée.</p>';
        } else {
            foreach ($recettes as $recette) {
                $image = $recette['recette_img_link'] ?: 'recette-default';
                $title = $recette['recette_nom'];
                $id_recette = $recette['id_recette'];
                echo renderRecettesItem($image, clean($title), $id_recette);
            }
        }
        ?>
    </section>
    <br><br>
    <a href="/recettes" class="btn btn_red">
        Retour aux recettes
    </a>
</section>
