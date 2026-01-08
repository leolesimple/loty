<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];

/* ===== HANDLER AJAX ===== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    header('Content-Type: application/json; charset=utf-8');

    if ($_POST['action'] === 'remove' && isset($_POST['bento_id'])) {

        $id = (int) $_POST['bento_id'];

        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }

        echo json_encode([
            'status' => 'ok',
            'remaining' => count($_SESSION['cart'])
        ]);
        exit();
    }

    echo json_encode(['status' => 'error']);
    exit();
}
?>

<main class="cartPageContainer">

    <nav class="navigationAction" aria-label="Navigation secondaire">
        <a href="/loty/bento" class="backButton" aria-label="Retour">
            ←
        </a>
    </nav>

    <header class="cartHeader">
        <h1 class="cartTitle">Votre panier</h1>
    </header>

    <section class="cartContent">

        <?php if (empty($cart)): ?>
            <p class="emptyCartMessage" id="emptyCartMessage">
                Votre panier est vide.
            </p>
        <?php else: ?>

            <ul class="cartBentoList" id="cartBentoList">

                <?php foreach ($cart as $item): ?>

                    <li class="cartBentoItem" data-bento-id="<?= (int)$item['id'] ?>">

                        <article class="cartBentoCard">

                            <header class="cartBentoHeader">

                                <figure class="cartBentoVisual">
                                    <div class="cartBentoImagePlaceholder"></div>
                                    <figcaption class="cartBentoMeta">
                                        <h2 class="cartBentoName">
                                            <?= htmlspecialchars($item['nom']) ?>
                                        </h2>
                                        <p class="cartBentoAuthor">
                                            Par utilisateur
                                        </p>
                                    </figcaption>
                                </figure>

                                <button
                                    type="button"
                                    class="removeBentoButton"
                                    data-bento-id="<?= (int)$item['id'] ?>"
                                    aria-label="Supprimer ce bento du panier"
                                >
                                    🗑
                                </button>

                            </header>

                            <section class="cartBentoDescription">
                                <p>
                                    Description du bento à afficher ici.
                                </p>
                            </section>

                            <section class="cartBentoIngredients">
                                <h3>Ingrédients</h3>

                                <ul class="ingredientsPreviewList">
                                    <li class="ingredientPreview"></li>
                                    <li class="ingredientPreview"></li>
                                    <li class="ingredientPreview"></li>
                                    <li class="ingredientPreview"></li>
                                </ul>
                            </section>

                        </article>

                    </li>

                <?php endforeach; ?>

            </ul>

            <div class="cartValidation" id="cartValidation">
                <button type="button" class="mainValidateButton">
                    Valider
                </button>
            </div>

        <?php endif; ?>

    </section>

</main>

<script>
    document.addEventListener("click", async (event) => {

        const button = event.target.closest(".removeBentoButton")
        if (!button) return

        const bentoId = button.dataset.bentoId
        const item = document.querySelector(`[data-bento-id="${bentoId}"]`)

        if (!item) return

        const response = await fetch(window.location.href, {
            method: "POST",
            headers: {
                "Accept": "application/json"
            },
            body: new URLSearchParams({
                action: "remove",
                bento_id: bentoId
            })
        })

        const data = await response.json()

        if (data.status === "ok") {
            item.remove()

            if (data.remaining === 0) {
                document.getElementById("cartBentoList")?.remove()
                document.getElementById("cartValidation")?.remove()

                const p = document.createElement("p")
                p.id = "emptyCartMessage"
                p.textContent = "Votre panier est vide."
                document.querySelector(".cartContent").appendChild(p)
            }
        }
    })
</script>
