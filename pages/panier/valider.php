<?php
session_start();
require_once __DIR__ . '/../../includes/utilities/db.php';
global $conn;

if (empty($_SESSION['cart'])) {
    echo "<p>Panier vide.</p>";
    exit();
}

$bentoIds = array_keys($_SESSION['cart']);

$placeholders = implode(',', array_fill(0, count($bentoIds), '?'));

/*
1. Récupérer toutes les recettes des bentos
2. Récupérer tous les ingrédients de ces recettes
3. Additionner les quantités
*/

$sql = "
SELECT
    ingredients.id_ingredient,
    ingredients.nom AS ingredient_nom,
    ingredients_recettes.quantite,
    unites.unites AS unite_nom
FROM bento_recettes
JOIN ingredients_recettes ON bento_recettes.id_recette = ingredients_recettes.id_recette
JOIN ingredients ON ingredients_recettes.id_ingredients = ingredients.id_ingredient
JOIN unites ON ingredients_recettes.unites = unites.id_unites
WHERE bento_recettes.id_bento IN ($placeholders)
";

$stmt = $conn->prepare($sql);
$stmt->execute($bentoIds);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Agrégation */

$ingredientsFinal = [];

foreach ($rows as $row) {

    $key = $row['id_ingredient'] . '_' . $row['unite_nom'];

    if (!isset($ingredientsFinal[$key])) {
        $ingredientsFinal[$key] = [
            'nom' => $row['ingredient_nom'],
            'quantite' => (float) $row['quantite'],
            'unite' => $row['unite_nom']
        ];
    } else {
        $ingredientsFinal[$key]['quantite'] += (float) $row['quantite'];
    }
}
?>

<main class="ingredientsPageContainer">

    <header class="ingredientsHeader">
        <h1>Liste des ingrédients</h1>
    </header>

    <section class="selectedBentosSection">
        <h2>Bentos sélectionnés</h2>

        <ul class="selectedBentosList">
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <li class="selectedBentoItem">
                    <article>
                        <figure class="bentoThumb"></figure>
                        <h3><?= htmlspecialchars($item['nom']) ?></h3>
                    </article>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="ingredientsListSection">
        <h2>Liste des ingrédients</h2>

        <ul class="ingredientsList">

            <?php foreach ($ingredientsFinal as $ingredient): ?>
                <li class="ingredientRow">
                    <span class="ingredientIcon"></span>

                    <span class="ingredientQuantity">
                        <?= rtrim(rtrim(number_format($ingredient['quantite'], 2, '.', ''), '0'), '.') ?>
                        <?= htmlspecialchars($ingredient['unite']) ?>
                    </span>

                    <span class="ingredientName">
                        <?= htmlspecialchars($ingredient['nom']) ?>
                    </span>
                </li>
            <?php endforeach; ?>

        </ul>
    </section>

    <section class="actionsSection">
        <button type="button" onclick="window.print()">
            Imprimer la liste
        </button>
    </section>

</main>
