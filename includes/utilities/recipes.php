<?php
global $conn;
/*
 * Applique le template d'un item recette réutilisable partout.
 * */
function renderRecettesItem(string $image, string $title, string $id_recette): string
{
    return '
    <a href="/recettes/view?id=' . urlencode($id_recette) . '" class="recetteLink">
        <article class="recettesItem" data-title="' . $title . '">
            <img src="' . $image . '" alt="" width="215" height="215" class="recetteImage">
            <div class="recetteInfo">
                <h3>' . $title . '</h3>
            </div>
            <img src="assets/icons/chevron-right.svg" alt="" width="auto" height="24" class="chevronIcon">
        </article>
    </a>';
}

/*
 * Génère le layout des recettes sur la page /recettes ou /profil.
 */
function generateRecetteLayout(int $count, int $type, bool $isProfile = false): string
{
    global $conn;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $user_id = $_SESSION['user_id'] ?? 0;

    $where = 'WHERE id_type = :type';
    if ($isProfile) {
        $where .= ' AND id_user = :user_id';
    }

    $limit = $count === 0 ? '' : ' LIMIT :count';
    $recette_query = $conn->prepare(
        "SELECT id_recette, recette_nom
         FROM recette
         $where
         ORDER BY id_recette DESC$limit"
    );

    if ($count !== 0) {
        $recette_query->bindValue(':count', $count, PDO::PARAM_INT);
    }
    $recette_query->bindValue(':type', $type, PDO::PARAM_INT);
    if ($isProfile) {
        $recette_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    }

    $recette_query->execute();
    $recetteLayout = '';

    if ($recette_query->rowCount() === 0) {
        return '<p>Ajoutez vos recettes ' . ($type === 1 ? 'd\'entrée' : ($type === 2 ? 'de plat' : 'de dessert')) . ' ici !</p>';
    }

    foreach ($recette_query->fetchAll() as $recette) {
        $image = '/assets/img/recette-default.png';
        $title = $recette['recette_nom'];
        $id_recette = $recette['id_recette'];
        $recetteLayout .= renderRecettesItem($image, clean($title), $id_recette);
    }
    return $recetteLayout;
}

function addRecipe(array $data, int $userId, PDO $conn): int
{
    $conn->beginTransaction();

    $stmt = $conn->prepare("
        INSERT INTO recette (recette_nom, id_user, id_type)
        VALUES (:nom, :id_user, :id_type)
    ");

    $stmt->execute([
        ':nom' => $data['recette_nom'],
        ':id_user' => $userId,
        ':id_type' => 4
    ]);

    $recipeId = (int) $conn->lastInsertId();

    foreach ($data['ingredients'] as $ingredient) {

        if ($ingredient['id_ingredient'] === 'new' && !empty($ingredient['new_nom'])) {
            $stmt = $conn->prepare("INSERT INTO ingredients (nom) VALUES (:nom)");
            $stmt->execute([':nom' => $ingredient['new_nom']]);
            $ingredientId = (int) $conn->lastInsertId();
        } elseif (!empty($ingredient['id_ingredient'])) {
            $ingredientId = (int) $ingredient['id_ingredient'];
        } else {
            continue;
        }

        if (!empty($ingredient['id_unite'])) {
            $stmt = $conn->prepare("
                INSERT INTO ingredients_recettes (id_ingredients, id_recette, quantite, unites)
                VALUES (:id_ing, :id_recette, :quantite, :unite)
            ");

            $stmt->execute([
                ':id_ing' => $ingredientId,
                ':id_recette' => $recipeId,
                ':quantite' => $ingredient['quantite'] !== '' ? $ingredient['quantite'] : null,
                ':unite' => (int) $ingredient['id_unite']
            ]);
        }
    }

    if (!empty($data['steps'])) {
        foreach ($data['steps'] as $num => $description) {
            if (!trim($description)) continue;

            $stmt = $conn->prepare("
                INSERT INTO etapes_recettes (id_recette, num_etape, description_etape)
                VALUES (:id_recette, :num_etape, :description)
            ");

            $stmt->execute([
                ':id_recette' => $recipeId,
                ':num_etape' => (int) $num,
                ':description' => $description
            ]);
        }
    }

    $conn->commit();

    return $recipeId;
}
