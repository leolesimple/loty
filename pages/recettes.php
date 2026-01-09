<?php
global $conn;
// Session start if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/utilities/db.php';
require_once __DIR__ . '/../includes/utilities/recipes.php';
require_once __DIR__ . '/../includes/utilities/auth.php';

check_logged_in();
?>

<header class="bentoHeader">
    <img src="/assets/img/bento-home.svg" alt="">
    <h1>
        Les <span class="blueText">Recettes</span> !
    </h1>
    <a href="/recettes/add" class="btn btn_red">
        Ajouter une recette
    </a>
</header>

<section class="recettesContainer">
    <header class="recettesSectionHeader">
        <h2>Entrées</h2>
    </header>

    <section class="bentoGrid recetteGrid">
        <?php echo generateRecetteLayout(6, 1); ?>
        <a href="/recettes/viewAll?type=1" class="btn btn_red">
            Voir toutes les entrées
        </a>
    </section>

    <header class="recettesSectionHeader">
        <h2>Plats</h2>
    </header>
    <section class="bentoGrid recetteGrid">

        <?php echo generateRecetteLayout(6, 2); ?>
        <a href="/recettes/viewAll?type=2" class="btn btn_red">
            Voir tous les plats
        </a>
    </section>

    <header class="recettesSectionHeader">
        <h2>Accompagnements</h2>
    </header>

    <section class="bentoGrid recetteGrid">
        <?php echo generateRecetteLayout(6, 3); ?>
        <a href="/recettes/viewAll?type=3" class="btn btn_red">
            Voir tous les accompagnements
        </a>
    </section>

    <header class="recettesSectionHeader">
        <h2>Desserts</h2>
    </header>

    <section class="bentoGrid recetteGrid">
        <?php echo generateRecetteLayout(6, 4); ?>
        <a href="/recettes/viewAll?type=3" class="btn btn_red">
            Voir tous les desserts
        </a>
    </section>
</section>
