<?php
global $conn;

/*
 * Applique le template d'un item Bento réutilisable partout.
 * */
function renderBentoItem(string $image, string $title, string $description, string $id_bento): string
{
    return '
    <a href="/bento/view?id=' . urlencode($id_bento) . '" class="bentoLink">
        <article class="bentoItem">
            <img src="' . $image . '" alt="" width="215" height="215" class="bentoImage">
            <div class="bentoInfo">
                <h3>' . $title . '</h3>
                <p>' . $description . '</p>
            </div>
            <img src="assets/icons/chevron-right.svg" alt="" width="auto" height="24" class="chevronIcon">
        </article>
    </a>';
}

/*
 * Génère le layout des bentos créés par l'utilisateur sur la page /profil.
 */
function generateUserBentoLayout($count): string
{
    global $conn;
    // si aucune création, afficher un message
    if ($count <= 0) {
        return '<p>Retrouvez ici vos créations de Bento !</p>';
    }
    $bentoLayout = '';
    $bento_query = $conn->prepare("SELECT id_bento, bento_nom, description FROM bento WHERE id_user = ? ORDER BY id_bento DESC LIMIT ?");
    $bento_query->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $bento_query->bindValue(2, $count, PDO::PARAM_INT);
    $bento_query->execute();
    $bento_items = $bento_query->fetchAll();
    foreach ($bento_items as $bento) {
        $image = '/assets/img/bento-default.png';
        $title = $bento['bento_nom'];
        $description = $bento['description'];
        $id_bento = $bento['id_bento'];
        $bentoLayout .= renderBentoItem($image, clean($title), clean($description), $id_bento);
    }
    return $bentoLayout;
}

/*
 * Génère le layout des bentos créés par la communauté d'utilisateur sur la page /bento.
 */
function generateCommunityBentoLayout($count): string
{
    global $conn;

    $bentoLayout = '';
    if ($count === 0) {
        $bento_query = $conn->prepare(
            "SELECT id_bento, bento_nom, description
         FROM bento
         WHERE id_user NOT BETWEEN 1 AND 4
         AND id_user != :user_id
             ORDER BY date_creation DESC"
        );
    } else {
        $bento_query = $conn->prepare(
            "SELECT id_bento, bento_nom, description
         FROM bento
         WHERE id_user NOT BETWEEN 1 AND 4
         AND id_user != :user_id
         ORDER BY date_creation DESC
         LIMIT :count"
        );
        $bento_query->bindValue(':count', $count, PDO::PARAM_INT);
    }
    $bento_query->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $bento_query->execute();
    $bento_items = $bento_query->fetchAll();
    foreach ($bento_items as $bento) {
        $image = '/assets/img/bento-default.png';
        $title = $bento['bento_nom'];
        $description = $bento['description'];
        $id_bento = $bento['id_bento'];
        $bentoLayout .= renderBentoItem($image, clean($title), clean($description), $id_bento);
    }
    return $bentoLayout;
}

/*
 * Génère le layout des bentos créés par la communauté d'utilisateur sur la page /bento.
 */
function generateTeamBentoLayout($count): string
{
    global $conn;

    $bentoLayout = '';
    if ($count === 0) {
        $bento_query = $conn->prepare(
            "SELECT id_bento, bento_nom, description
             FROM bento
             WHERE id_user BETWEEN 1 AND 4
             ORDER BY date_creation DESC"
        );
    } else {
        $bento_query = $conn->prepare(
            "SELECT id_bento, bento_nom, description
             FROM bento
             WHERE id_user BETWEEN 1 AND 4
             ORDER BY date_creation DESC
             LIMIT :count"
        );
        $bento_query->bindValue(':count', $count, PDO::PARAM_INT);
    }

    $bento_query->execute();
    $bento_items = $bento_query->fetchAll();
    foreach ($bento_items as $bento) {
        $image = '/assets/img/bento-default.png';
        $title = $bento['bento_nom'];
        $description = $bento['description'];
        $id_bento = $bento['id_bento'];
        $bentoLayout .= renderBentoItem($image, clean($title), clean($description), $id_bento);
    }
    return $bentoLayout;
}


/*
 * Génère le layout des recettes créées par l'utilisateur sur la page /profil.
 */
function generateUserRecetteLayout($count): string
{
    global $conn;
    // si aucune création, afficher un message
    if ($count <= 0) {
        return '<p>Retrouvez ici vos créations de Recettes !</p>';
    }
    $recetteLayout = '';
    $recette_query = $conn->prepare("SELECT id_recette, recette_nom FROM recette WHERE id_user = ? ORDER BY id_recette DESC LIMIT ?");
    $recette_query->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $recette_query->bindValue(2, $count, PDO::PARAM_INT);
    $recette_query->execute();
    $recette_items = $recette_query->fetchAll();
    foreach ($recette_items as $recette) {
        $image = '/assets/img/recette-default.png';
        $title = $recette['recette_nom'];
        $recetteLayout .= renderRecetteItem($image, clean($title));
    }
    return $recetteLayout;
}

/*
 * Applique le template d'un item Recette réutilisable.
 * (utilisé dans la page profil uniquement)
 * */
function renderRecetteItem(string $image, string $title): string
{
    return '
    <article class="recetteItem">
        <img src="' . $image . '" alt="" width="215" height="215" class="recetteImage">
        <div class="recetteInfo">
            <h3>' . $title . '</h3>
        </div>
        <img src="assets/icons/chevron-right.svg" alt="" width="auto" height="24" class="chevronIcon">
    </article>';
}
