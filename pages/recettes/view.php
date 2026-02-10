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
    recette.recette_img_link,
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
$recette_image = $recipe['recette_img_link'] ?: '/assets/img/recette-default.png';
ksort($steps);


?>

<div class="navigationAction" role="navigation">
    <a href="/recettes" class="btn btn_red btn_icon">
        <img src="/assets/icons/chevron-left-white.svg" alt="" style="margin-right: 8px;">
        <span>Retour</span>
    </a>
</div>

<h1 class="recipeTitle">
    <?= htmlspecialchars($recipe['recette_nom']) ?>
</h1>

<section class="recipeMainContent">

    <div class="recipeHeaderContent">
        <div class="recipeVisualColumn">
            <div class="imageWrapper">
                <?= '<img src="/uploads/recettes/' . htmlspecialchars($recette_image) . '@1x.webp" alt="Image de la recette ' . htmlspecialchars($recipe['recette_nom']) . '" class="recipeImage">'; ?>

            </div>
            <div class="floatingActions">
                <button class="actionButton saveButton" aria-label="Sauvegarder" id="saveRecipeBtn">
                    <img src="/assets/icons/save.svg" alt="">
                    <span class="sr-only">Sauvegarder</span>
                </button>
                <button class="actionButton sendButton" aria-label="Envoyer" id="sendRecipeBtn">
                    <img src="/assets/icons/sendBtn.svg" alt="">
                    <span class="sr-only">Envoyer</span>
                </button>
            </div>
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
<script>
    document.getElementById('saveRecipeBtn').addEventListener('click', function () {
        alert('Fonction de sauvegarde de recette à venir !');
    });

    document.getElementById('sendRecipeBtn').addEventListener('click', function () {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                url: window.location.href
            }).then(() => {
                console.log('Recette partagée avec succès');
            }).catch((error) => {
                console.error('Erreur lors du partage de la recette :', error);
            });
        } else {
            alert('Le partage n\'est pas supporté sur ce navigateur.');
        }
    });
</script>