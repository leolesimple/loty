<section class="welcomeLoty">
    <img src="/assets/img/LOTY_accueil_baseline.svg" alt="Bienvenue sur le site de LOTY, Lunch of Tomorrow and beYond"
         class="lotyLogo">
    <img src="/assets/img/bento-vide.svg" alt="" class="bentoVide">
</section>
<section class="content">
    <div class="textUpLeft1">
        <h2>
            Travail, études <br>ou encore voyages
        </h2>
        <p>
            Vous devez préparer un repas mais ne savez pas quoi cuisiner ?
        </p>
    </div>

    <div class="textLotyRight">
        <p><span class="blueText">LOTY</span> est la solution !</p>
    </div>

    <div class="explBento">
        <h2>
            Qu’est ce qu’un Bento ?
        </h2>
        <p>
            C’est une boite <a href="/bento">et bien plus</a> !
        </p>
    </div>

    <div class="explBento2">
        <p>Le terme Bento vient du japon, il représente un plat unique composé de plusieurs compartiments.</p>
    </div>

    <div class="textHeIs">
        <h2>
            Il est :
        </h2>
        <p>
        <ul class="bentoList">
            <li>
                → prêt à consommer
            </li>
            <li>
                → équilibré
            </li>
            <li>
                → savoureux
            </li>
            <li>
                → Composé de diverses préparations
            </li>
        </ul>
        </p>
    </div>

    <div class="textUpLeft2 withLoty">
        <h2>
            Avec <span class="blueText">LOTY</span> :<br>
        </h2>
    </div>

    <div class="textColLeft1">
        <p>
            Explorez une sélection de Bento et de recettes.
        </p>
    </div>

    <div class="textColRight1">
        <p>
            Ajoutez-les à votre panier, personnalisez les et générez votre liste de courses.
        </p>
    </div>

    <div class="textColLeft2">
        <p>
            Partagez vos créations Bento.
        </p>
    </div>

    <div class="textColRight2">
        <p>
            Parcourez les Bento de la communautés et votez pour vos favoris.
        </p>
    </div>
</section>
<section class="joinLoty">
    <a href="/register" class="btn btn_red">
        REJOINS LA COMMUNAUTÉ
    </a>
</section>
<script>
    // When the top of .lotyLogo is in the 15% of the top of the viewport, add the class 'step1' to .bentoVide
    const lotyLogo = document.querySelector('.lotyLogo');
    const bentoVide = document.querySelector('.bentoVide');

    window.addEventListener('scroll', () => {
        const lotyLogoTop = lotyLogo.getBoundingClientRect().top;
        const viewportHeight = window.innerHeight;

        if (lotyLogoTop < viewportHeight * 0.1) {
            bentoVide.classList.add('step1');
        } else {
            bentoVide.classList.remove('step1');
        }
    });

    window.addEventListener('scroll', () => {
        const lotyLogoTop = lotyLogo.getBoundingClientRect().top;
        const viewportHeight = window.innerHeight;

        if (lotyLogoTop < viewportHeight * -0.8) {
            bentoVide.classList.add('step2');
        } else {
            bentoVide.classList.remove('step2');
        }
    });

    window.addEventListener('scroll', () => {
        const lotyLogoTop = lotyLogo.getBoundingClientRect().top;
        const viewportHeight = window.innerHeight;

        if (lotyLogoTop < viewportHeight * -1.75) {
            bentoVide.classList.add('step3');
        } else {
            bentoVide.classList.remove('step3');
        }
    });

    window.addEventListener('scroll', () => {
        const lotyLogoTop = lotyLogo.getBoundingClientRect().top;
        const viewportHeight = window.innerHeight;

        if (lotyLogoTop < viewportHeight * -1.95) {
            bentoVide.classList.add('step4');
        } else {
            bentoVide.classList.remove('step4');
        }
    });
</script>