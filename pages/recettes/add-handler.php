<?php
global $conn;
require_once __DIR__ . '/../../includes/utilities/auth.php';
require_once __DIR__ . '/../../includes/utilities/db.php';
check_logged_in();

if (!isset($_SESSION['user_id'])) {
    echo "<p>Accès refusé.</p>";
    exit();
}

if (
    empty($_POST['recette_nom']) ||
    empty($_POST['description']) ||
    empty($_POST['ingredients']) ||
    empty($_POST['steps'])
) {
    print_r($_POST);
    echo "<p>Formulaire incomplet.</p>";
    exit();
}

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("
        INSERT INTO recette (recette_nom, id_user, id_type)
        VALUES (:nom, :id_user, :id_type)
    ");

    $stmt->execute([
        ':nom' => $_POST['recette_nom'],
        ':id_user' => $_SESSION['user_id'],
        ':id_type' => 4
    ]);

    $recipeId = $conn->lastInsertId();

    foreach ($_POST['ingredients'] as $ingredient) {

        if ($ingredient['id_ingredient'] === 'new' && !empty($ingredient['new_nom'])) {
            $stmt = $conn->prepare("INSERT INTO ingredients (nom) VALUES (:nom)");
            $stmt->execute([':nom' => $ingredient['new_nom']]);
            $ingredientId = $conn->lastInsertId();
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

    foreach ($_POST['steps'] as $num => $description) {
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

    $conn->commit();

    echo "
        <main>
            <h1>Recette ajoutée</h1>
            <p>Ta recette a été enregistrée avec succès.</p>
            <a href='/recette/view?id=$recipeId'>Voir la recette</a>
        </main>
    ";
    exit();

} catch (Exception $e) {
    $conn->rollBack();

    echo "
        <main>
            <h1>Erreur</h1>
            <p>Une erreur est survenue lors de l’ajout de la recette.</p>
            <a href='/recettes/add'>Retour au formulaire</a>
        </main>
    ";
    exit();
}
