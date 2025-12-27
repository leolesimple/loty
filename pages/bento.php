<?php
require_once __DIR__ . '/../includes/utilities/db.php';
require_once __DIR__ . '/../includes/utilities/bentos.php';
?>

<header class="bentoHeader">
    <img src="/assets/img/bento-home.svg" alt="">
    <h1>
        Choisissez votre <span class="blueText">Bento</span> !
    </h1>
</header>

<section class="emptyBento">
    <h2>
        Envie de créer ton Bento de zéro ? Pars d’un Bento vide !
    </h2>
    <article class="bentoCard">
        <a href="/bento/create?type=empty" class="bentoLink">
            <img src="/assets/img/bento-empty.svg" alt="Bento vide" class="bentoImage">
            <h3 class="bentoTitle">Bento Vide</h3>
            <p>
                Crée un Bento personnalisé en partant d'une base vierge. Laisse libre cours à ta créativité !
            </p>
        </a>
    </article>
</section>

<section class="teamBento">
    <header class="bentoSectionHeader">
        <h2>Les Bento de l'équipe LOTY</h2>
        <p>
            Des compositions créées par notre équipe étoilée !
        </p>
        <a class="seeMoreLink" href="/bento/team">
            Voir plus de Bento de l'équipe
        </a>
    </header>

    <div class="bentoGrid">
        <?php echo generateTeamBentoLayout(3); ?>
    </div>
</section>

<section class="communityBento">
    <header class="bentoSectionHeader">
        <h2>Manque d’inspiration ?</h2>
        <p>
            Parcours les Créations Bento de la communauté
        </p>
        <a class="seeMoreLink" href="/bento/community">
            Voir plus de Bento de la communauté
        </a>
    </header>
    <div class="bentoGrid">
        <?php echo generateCommunityBentoLayout(8); ?>
    </div>
</section>