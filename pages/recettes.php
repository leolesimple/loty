<?php
global $conn;
// Session start if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/utilities/db.php';
require_once __DIR__ . '/../includes/utilities/recipes.php';
?>

<header class="bentoHeader">
    <img src="/assets/img/bento-home.svg" alt="">
    <h1>
        Les <span class="blueText">Recettes</span> !
    </h1>
    <a href="/recettes/add" class="bentoButton">
        <img src="/assets/icons/plus-white.svg" alt="" width="24" height="24">
        Ajouter une recette
    </a>
</header>

<section class="recettesContainer">
    <header class="bentoSectionHeader">
        <h2>Entrées</h2>
    </header>

    <section class="bentoGrid">
        <?php echo generateRecetteLayout(6, 1); ?>
        <a href="/recettes/viewAll?type=1" class="seeAllLink">
            Voir toutes les entrées
            <img src="/assets/icons/chevron-right.svg" alt="" width="auto" height="24" class="chevronIcon">
        </a>
    </section>

    <section class="bentoGrid">
        <header class="bentoSectionHeader">
            <h2>Plats</h2>
        </header>

        <?php echo generateRecetteLayout(6, 2); ?>
        <a href="/recettes/viewAll?type=2" class="seeAllLink">
            Voir tous les plats
            <img src="/assets/icons/chevron-right.svg" alt="" width="auto" height="24" class="chevronIcon">
        </a>
    </section>

    <section class="bentoGrid">
        <header class="bentoSectionHeader">
            <h2>Desserts</h2>
        </header>

        <?php echo generateRecetteLayout(6, 3); ?>
        <a href="/recettes/viewAll?type=3" class="seeAllLink">
            Voir tous les desserts
            <img src="/assets/icons/chevron-right.svg" alt="" width="auto" height="24" class="chevronIcon">
        </a>
    </section>
</section>
