<?php
global $conn;
// Session start if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/utilities/db.php';
require_once __DIR__ . '/../includes/utilities/bentos.php';
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

<nav>
    <div class="top_nav">
        <div></div>
        <img src="../assets/img/LOTY_Logo.svg" class="nav_logo">
        <div class="nav_actions">
            <a href="/auth/profil.php"><img src="../assets/icons/accounts-icon.svg" class="profile_icon"></a>
            <a>PANIER</a>
        </div>
    </div>
    <div class="bottom_nav">
        <ul>
            <li><a>ACCUEIL</a></li>
            <li><a class="blueText">BENTO</a></li>
            <li><a>RECETTES</a></li>
            <li><a>PODIUM</a></li>
        </ul>
    </div>
</nav>

<section class="bentoHeader">
    <img src="../assets/img/bento-home.svg" alt="">
    <h1>
        Choisissez votre <span class="blueText">Bento</span> !
    </h1>
</section>
<section class="emptyBento">
    <h2>
        Envie de créer ton Bento de zéro ? Pars d’un Bento vide !
    </h2>
        <a href="/bento/create?type=empty" class="EmptyBentoCard">
            <div class="EmptyBentoCard_left">
                <img src="/assets/img/bento-empty.svg" alt="Bento vide">
            </div>
            <div class="EmptyBentoCard_right">
                <h3 class="bentoTitle">Bento Vide</h3>
                <p>
                Crée un Bento personnalisé en partant d'une base vierge. Laisse libre cours à ta créativité !
                </p>
        </div>
        </a>
</section>

<section class="teamBento">
    <div class="teamBento_left">
        <h2>Les Bento de l'équipe LOTY</h2>
        <p>
            Des compositions créées par notre équipe étoilée !
        </p>
        <a class="seeMoreLink" href="/bento/team">
            Voir plus de Bento de l'équipe
        </a>
</div>

    <div class="bentoGrid">
        <!-- echo generateTeamBentoLayout(3); -->
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

<footer>
    <img src="../assets/img/LOTY_Logo.svg">
    FOOTER
</footer>

</body>
</html>

