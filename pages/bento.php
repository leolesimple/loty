<?php
global $conn;
require_once __DIR__ . '/../includes/utilities/auth.php';

//check_logged_in();
// Session start if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/utilities/db.php';
require_once __DIR__ . '/../includes/utilities/bentos.php';
?>

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
                <img src="/assets/img/bentoVide_default.png" alt="" width="150" height="auto">
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
        <div class="">
            <a  href="/bento/team" class="btn_beige btn">
            Voir plus de Bento de l'équipe
        </a>
        </div>
        
</div>
    <div class="teamBento_right">
        <?php
        echo generateTeamBentoLayout(3);
        ?>
    </div>
</section>

<section class="communityBento">
    <header class="bentoSectionHeader">
        <h2 class="teamBentoTitle">Manque d’inspiration ?</h2>
        <p>
            Parcours les Créations Bento de la communauté
        </p>
        <a class="btn btn_red" href="/bento/community">
            Les Bento de la communauté
        </a>
    </header>
    <div class="bentoGrid">
        <?php echo generateCommunityBentoLayout(8); ?>
    </div>
</section>

</body>
</html>

