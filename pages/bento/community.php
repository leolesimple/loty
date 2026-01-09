<?php
global $conn;

require_once __DIR__ . '/../../includes/utilities/db.php';
require_once __DIR__ . '/../../includes/utilities/bentos.php';
require_once __DIR__ . '/../../includes/utilities/auth.php';

check_logged_in();
?>

<header class="bentoHeader">
    <a href="javascript:history.back()" class="backLink">
        <img src="/assets/icons/chevron-left.svg" alt="" height="24">
        Revenir en arrière
    </a>
    <h1>
        Les <span class="blueText">Bento</span> de la communauté
    </h1>
</header>
<section>
    <div class="bentoGrid">
        <?php echo generateCommunityBentoLayout(0); ?>
    </div>
</section>