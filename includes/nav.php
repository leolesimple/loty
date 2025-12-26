<nav class="nav">
    <div class="imgLinks">
        <a href="/">
            <img src="/assets/img/LOTY_Logo.svg" alt="" width="160">
            <span class="sr-only">Aller à l'accueil</span>
        </a>
        <div>
            <ul class="nav-list">
                <li><a href="/" class="nav-link">Accueil</a></li>
                <li><a href="/bento" class="nav-link">Bento</a></li>
                <li><a href="/recettes" class="nav-link">Recettes</a></li>
                <li><a href="/podium" class="nav-link">Podium</a></li>
            </ul>
        </div>
    </div>
    <div class="iconsLinks">
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="/profil" class="icon-link">
                    <img src="/assets/icons/accounts-icon.svg" alt="" width="54" height="54">
                    <span class="sr-only">Voir mon compte</span>
                  </a>';
        } else {
            echo '';
        }
        ?>

        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="/profil" class="nav-button-link">
                    <p class="button-text">Panier</p>
                  </a>';
        } else {
            echo '<a href="/login" class="nav-button-link">
                    <p class="button-text">S\'identifier</p>
                  </a>';
        }
        ?>
    </div>
</nav>