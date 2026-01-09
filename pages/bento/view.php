<?php

require_once __DIR__ . '/../../includes/utilities/db.php';
require_once __DIR__ . '/../../includes/utilities/auth.php';

check_logged_in();
global $conn;

if (!isset($_GET['id'])) {
    echo "<p>ID de bento manquant.</p>";
    exit();
}

$bentoId = (int)$_GET['id'];

$sql = "
SELECT
    bento.id_bento,
    bento.bento_nom,
    bento.description,
    recette.id_recette,
    recette.recette_nom
FROM bento
LEFT JOIN bento_recettes ON bento.id_bento = bento_recettes.id_bento
LEFT JOIN recette ON bento_recettes.id_recette = recette.id_recette
WHERE bento.id_bento = :bentoId
";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':bentoId', $bentoId, PDO::PARAM_INT);
$stmt->execute();
$bentoData = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$bentoData) {
    echo "<p>Bento introuvable.</p>";
    exit();
}

$bento = [
        'id' => $bentoData[0]['id_bento'],
        'nom' => $bentoData[0]['bento_nom'],
        'description' => $bentoData[0]['description']
];

$recipes = [];

foreach ($bentoData as $row) {
    if ($row['id_recette']) {
        $recipes[$row['id_recette']] = [
                'id' => $row['id_recette'],
                'nom' => $row['recette_nom']
        ];
    }
}

$bento_image = '/assets/img/bentoVide_default.png';

?>
<div class="navigationAction" role="navigation">
    <a href="/bento" class="btn btn_red btn_icon">
        <img src="/assets/icons/chevron-left-white.svg" alt="" style="margin-right: 8px;">
        <span>Retour</span>
    </a>
</div>

<header class="bentoDetailHeader">
    <h1 class="bentoTitle">
        <?= htmlspecialchars($bento['nom']) ?>
    </h1>
    <p class="bentoDescription">
        <?= nl2br(htmlspecialchars($bento['description'])) ?>
    </p>
</header>

<section class="bentoMainContent">

    <section class="bentoIdentity">

        <div class="recipeVisualColumn">
            <div class="imageWrapper">
                <?= '<img src="' . htmlspecialchars($bento_image) . '" alt="" class="bentoImage" width="800">'; ?>
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

    </section>

    <section class="bentoRecipes" aria-labelledby="bento-recipes-title">

        <h2 id="bento-recipes-title" class="recipesSectionTitle">
            Recettes du Bento
        </h2>

        <ul class="bentoRecipesList">

            <?php foreach ($recipes as $recipe): ?>
                <li class="bentoRecipeItem">

                    <article class="bentoRecipeCard">

                        <a href="/recettes/view?id=<?= (int)$recipe['id'] ?>" class="bentoRecipeLink">

                            <figure class="recipeThumbnailWrapper">
                                <div class="recipeThumbnail"></div>
                            </figure>

                            <h3 class="recipeName">
                                <?= htmlspecialchars($recipe['nom']) ?>
                            </h3>

                        </a>

                    </article>

                </li>
            <?php endforeach; ?>

        </ul>

    </section>

</section>

<section class="bentoActions">

    <form method="post" class="addToCartForm">
        <input type="hidden" name="add_to_cart" value="1">
        <input type="hidden" name="bento_id" value="<?= (int)$bento['id'] ?>">
        <input type="hidden" name="bento_nom" value="<?= htmlspecialchars($bento['nom']) ?>">

        <button type="submit" class="btn btn_red">
            Ajouter au panier
        </button>
    </form>

    <a href="/bento/perso?id=<?= $bento['id'] ?>" class="btn btn_beige">Personnaliser</a>
    <span class="cartFeedback" aria-live="polite"></span>

</section>
<script>
    const form = document.querySelector(".addToCartForm")
    const feedback = document.querySelector(".cartFeedback")

    if (form) {
        form.addEventListener("submit", async (event) => {
            event.preventDefault()

            const response = await fetch(window.location.href, {
                method: "POST",
                body: new FormData(form),
                headers: {
                    "Accept": "application/json"
                }
            })

            const text = await response.text()

            try {
                const data = JSON.parse(text)

                if (data.status === "ok") {
                    feedback.textContent = "Ajouté au panier (x" + data.quantity + ")"
                } else {
                    feedback.textContent = "Erreur lors de l’ajout."
                }
            } catch (e) {
                console.error("Réponse invalide :", text);
                alert("Le serveur a renvoyé ceci au lieu du JSON :\n\n" + text);
                feedback.textContent = "Erreur technique."
            }
        })
    }
</script>