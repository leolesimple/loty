<?php
global $conn;
?>
<section class="hero-bento-grid" id="hero-bento" aria-labelledby="hero-bento-title">
    <div class="bento-grid">
        <div class="bento-item hero-bento">
            <p class="hero-bento__tagline">Découvre, compose, varie</p>
            <h1 id="hero-bento-title" class="hero-bento__title">Compose ta semaine en un clin d'œil !</h1>
            <p class="hero-bento__text">Inspiré de la cuisine japonaise, organise ta semaine de déjeuner en Bento pour
                des repas variés et </p>
            <div class="hero-bento__actions">
                <a class="btn btn_red" href="/register">Rejoins-nous !</a>
                <a class="btn btn_blue" href="/bento">Voir nos Bentos</a>
            </div>
        </div>
        <div class="bento-col bento-col-left">
            <div class="bento-item bento-idee">
                <h2 class="bento-item__title">Recettes express</h2>
                <p class="bento-item__text">Des Bento prêt en moins de 30 minutes pour les plus pressés ! <br> Retrouvez
                    aussi nos Bentos plus sophiqtiqués pour des recettes variées. </p>
            </div>
            <div class="bento-item bento-mix">
                <span class="bento-item__badge">
                    Bientôt disponible
                </span>
                <h2 class="bento-item__title">Personnalise à fond</h2>
                <p class="bento-item__text">De l'inspiration ? Par d'une base vide et personnalise ton Bento de A à Z.
                    Tu peux aussi partir d'une base déjà composée et la personnaliser selon tes envies.</p>
            </div>
        </div>
        <div class="bento-col bento-col-right">
            <div class="bento-item bento-snack">
                <h2 class="bento-item__title">Varie les plaisirs</h2>
                <p class="bento-item__text">Assemble des recettes selon tes envies, du plus loufouque au plus classique,
                    il y a l'embarra du choix !</p>
            </div>
            <div class="bento-item bento-comm">
                <h2 class="bento-item__title">Communauté</h2>
                <p class="bento-item__text">Prends part à la communauté LOTY et partage tes recettes et compositions à
                    tous.</p>
            </div>
            <div class="bento-item bento-liste">
                <h2 class="bento-item__title">Liste de courses</h2>
                <p class="bento-item__text">On te génère ta liste de courses, tu n'as plus qu'à aller chez ton
                    commerçant préféré pour commencer la préparation de tes Bentos.</p>
            </div>
        </div>
    </div>
</section>
<section class="welcomeLoty">
    <img src="/assets/img/LOTY_accueil_baseline.svg" alt="Bienvenue sur le site de LOTY, Lunch of Tomorrow and beYond"
         class="lotyLogo" loading="lazy">
</section>
<section>
    <div class="aboutLoty">
        <h2 class="aboutLoty__title">Qu'est-ce que LOTY ?</h2>
        <p class="aboutLoty__text">LOTY, c'est la plateforme qui révolutionne ta pause déjeuner en te proposant des
            Bento personnalisables, rapides à préparer et adaptés à tes goûts. Que tu sois pressé ou que tu aimes
            prendre ton temps, LOTY t'offre une variété de recettes pour composer le Bento parfait chaque jour. Rejoins
            notre communauté de passionnés de cuisine et découvre comment rendre tes repas plus savoureux et équilibrés !</p>
    </div>
</section>
<section class="whatsbento">
    <div>
        <h2 class="whatsbento__title">Un Ben-quoi ?</h2>
        <p class="whatsbento__text">Le Bento c'est <span class="upp">le</span> repas complet, équilibré et savoureux, présenté dans une boîte
            compartimentée. Originaire du Japon, le Bento est conçu pour offrir une variété d'aliments en une seule
            portion pratique, idéale pour les déjeuners sur le pouce. Chez LOTY, nous te permettons de composer ton
            propre Bento en choisissant parmi une sélection de recettes délicieuses et adaptées à tes préférences
            alimentaires. Que tu sois fan de cuisine traditionnelle ou que tu aimes expérimenter avec des nouvelles saveurs, notre plateforme t'aide à créer le Bento parfait pour chaque jour de la semaine.</p>
    </div>
<figure class="whatsbento__image">
    <picture>
        <source srcset="/assets/img/bentoVide_default.svg" type="image/svg+xml">
        <source srcset="/assets/img/bentoVide_default.png" type="image/png">
        <img src="/assets/img/bentoVide_default.jpg" alt="Exemple de Bento composé de riz, légumes, œufs et viande" loading="lazy">
    </picture>
    <figcaption>
        Exemple d'une boîte Bento.
    </figcaption>
</figure>
</section>
<section class="joinLoty">
    <a href="/register" class="btn btn_red">
        REJOINS LA COMMUNAUTÉ
    </a>
</section>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js"></script>
