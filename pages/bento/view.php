<?php
session_start();

require_once __DIR__ . '/../../includes/utilities/db.php';
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
?>
<main class="bentoPageContainer">

    <nav class="navigationAction" aria-label="Navigation secondaire">
        <a href="/bento" class="backButton" aria-label="Retour à la liste des bentos">
            <span class="iconArrowLeft"></span>
        </a>
    </nav>

    <header class="bentoHeader">

        <h1 class="bentoTitle">
            <?= htmlspecialchars($bento['nom']) ?>
        </h1>

    </header>

    <section class="bentoMainContent">

        <section class="bentoIdentity">

            <figure class="bentoImageWrapper">

                <?php if (!empty($bento['image_src'])): ?>
                    <img
                            src="<?= htmlspecialchars($bento['image_src']) ?>"
                            alt="Image du bento <?= htmlspecialchars($bento['nom']) ?>"
                            class="bentoImage"
                    >
                <?php else: ?>
                    <div class="bentoImage placeholder">Image bento</div>
                <?php endif; ?>

                <figcaption class="floatingActions">
                    <button class="actionButton saveButton" aria-label="Sauvegarder le bento"></button>
                    <button class="actionButton sendButton" aria-label="Partager le bento"></button>
                </figcaption>

            </figure>

            <p class="bentoDescription">
                <?= nl2br(htmlspecialchars($bento['description'])) ?>
            </p>

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

            <button type="submit" class="mainAddButton">
                Ajouter au panier
            </button>
        </form>

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


</main>