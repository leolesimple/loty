<nav>
    <div class="top_nav">
        <div></div>
        <a href="/">
            <img src="../assets/img/LOTY_Logo.svg" class="nav_logo" alt="Revenir à l'accueil">
            <span class="sr-only">Aller à l'accueil</span>
        </a>
        
        <div class="nav_actions">
            <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="/profil">
                    <img src="/assets/icons/accounts-icon.svg" alt="" class="profile_icon">
                    <span class="sr-only">Voir mon compte</span>
                  </a>';
        } else {
            echo '';
        }
        ?>
            <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="/panier" class="nav-button-link">
                    <p class="button-text">Panier</p>
                  </a>';
        } else {
            echo '<a href="/login" class="btn btn_red">
                    S\'identifier
                  </a>';
        }
        ?>
        </div>
    </div>
    <div class="bottom_nav">
        <ul>
            <li><a class="linkNav" href="/">ACCUEIL</a></li>
            <li><a class="linkNav" href="/bento">BENTO</a></li>
            <li><a class="linkNav" href="/recettes">RECETTES</a></li>
            <li><a class="linkNav" href="/podium" aria-disabled="true">PODIUM</a></li>
        </ul>
    </div>
</nav>