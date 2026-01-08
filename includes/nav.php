<nav>
    <div class="top_nav">
        <div></div>
        <a href="/">
            <img src="../assets/img/LOTY_Logo.svg" class="nav_logo">
            <span class="sr-only">Aller à l'accueil</span>
        </a>
        
        <div class="nav_actions">
            <a href="/auth/profil.php"><img src="../assets/icons/accounts-icon.svg" class="profile_icon"></a>
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
            echo '<a href="/login" class="nav-button-link">
                    <p class="button-text">S\'identifier</p>
                  </a>';
        }
        ?>
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