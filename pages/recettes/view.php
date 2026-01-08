<?php
global $conn;
require_once __DIR__ . '/../../includes/utilities/db.php';

if (isset($_GET['id'])) {
    $recipeId = $_GET['id'] ?? null;
} else {
    echo "<p>ID de recette manquant.</p>";
    exit();
}

$recipeSql = "SELECT
    recette.id_recette,
    recette.recette_nom,
    user.id AS user_id,
    user.username,
    user.nom,
    user.prenom,
    ingredients.id_ingredient,
    ingredients.nom AS ingredient_nom,
    ingredients_recettes.quantite,
    unites.unites AS unite,
    etapes_recettes.num_etape,
    etapes_recettes.description_etape
FROM recette
JOIN user ON recette.id_user = user.id
LEFT JOIN ingredients_recettes ON recette.id_recette = ingredients_recettes.id_recette
LEFT JOIN ingredients ON ingredients_recettes.id_ingredients = ingredients.id_ingredient
LEFT JOIN unites ON ingredients_recettes.unites = unites.id_unites
LEFT JOIN etapes_recettes ON recette.id_recette = etapes_recettes.id_recette
WHERE recette.id_recette = :recipeId
ORDER BY etapes_recettes.num_etape ASC;
";
$recipeStmt = $conn->prepare($recipeSql);
$recipeStmt->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
$recipeStmt->execute();
$recipeData = $recipeStmt->fetchAll(PDO::FETCH_ASSOC);
if (!$recipeData) {
    echo "<p>Recette non trouvée.</p>";
    exit();
}

$recipe = $recipeData[0];

$ingredients = [];
$steps = [];

foreach ($recipeData as $row) {
    if ($row['id_ingredient']) {
        $ingredients[$row['id_ingredient']] = [
                'nom' => $row['ingredient_nom'],
                'quantite' => $row['quantite'],
                'unite' => trim($row['unite'])
        ];
    }

    if ($row['num_etape'] !== null) {
        $steps[$row['num_etape']] = $row['description_etape'];
    }
}

ksort($steps);


?>

<main class="recipePageContainer">

    <div class="navigationAction">
        <button class="backButton" aria-label="Retour">
            <span class="iconArrowLeft"></span>
        </button>
    </div>

    <h1 class="recipeTitle">
        <?= htmlspecialchars($recipe['recette_nom']) ?>
    </h1>

    <section class="recipeMainContent">

        <div class="recipeVisualColumn">
            <div class="imageWrapper">
                <div class="recipeImage">Image recette</div>

                <div class="floatingActions">
                    <button class="actionButton saveButton" aria-label="Sauvegarder">
                    </button>
                    <button class="actionButton sendButton" aria-label="Envoyer">
                    </button>
                </div>
            </div>

            <p class="recipeShortDescription">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque augue dolor, fringilla.
            </p>
        </div>

        <div class="ingredientsColumn">
            <h2 class="ingredientsSectionTitle">Ingrédient</h2>

            <ul class="ingredientsList">
                <?php foreach ($ingredients as $ingredient): ?>
                    <li class="ingredientCard">
                        <div class="ingredientThumbnail"></div>
                        <span class="ingredientQuantity">
                <?php
                if ($ingredient['quantite'] !== null) {
                    echo htmlspecialchars($ingredient['quantite'] . $ingredient['unite']);
                } else {
                    echo '';
                }
                ?>
            </span>
                        <span class="ingredientName">
                <?= htmlspecialchars($ingredient['nom']) ?>
            </span>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </section>

    <section class="recipeStepsSection">
        <?php if ($steps): ?>
            <?php foreach ($steps as $num => $description): ?>
                <article class="stepContainer">
                    <h3 class="stepTitle">Étape <?= (int)$num ?></h3>
                    <div class="stepDescriptionBox">
                        <p><?= nl2br(htmlspecialchars($description)) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune étape renseignée pour cette recette.</p>
        <?php endif; ?>
    </section>


    <div class="shareContainer">
        <button class="mainShareButton">Partager</button>
    </div>

</main>