<?php
$id = $_GET['id'] ?? null;
?>

<section>
    <h1>
        Fonctionnalité à venir !
    </h1>
    <a href="/bento/view?id=<?= urlencode($id) ?>" class="btn btn_red">
        Retourner à la page précédente
    </a>
</section>