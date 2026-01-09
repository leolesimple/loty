<?php
global $conn;
require_once __DIR__ . '/../includes/utilities/db.php';
require_once __DIR__ . '/../includes/utilities/auth.php';

check_logged_in();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    header('Content-Type: application/json; charset=utf-8');

    if ($_POST['action'] === 'remove' && isset($_POST['bento_id'])) {

        $id = $_POST['bento_id'];

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

$bentoIds = array_map(fn($item) => (int)$item['id'], $cart);

$bentoData = [];

if (!empty($bentoIds)) {

    $placeholders = implode(',', array_fill(0, count($bentoIds), '?'));

    $stmt = $conn->prepare("
        SELECT 
            b.id_bento,
            b.bento_nom,
            b.description,
            u.prenom,
            u.nom,
            i.nom AS ingredient_nom
        FROM bento b
        JOIN user u ON u.id = b.id_user
        LEFT JOIN bento_recettes br ON br.id_bento = b.id_bento
        LEFT JOIN ingredients_recettes ir ON ir.id_recette = br.id_recette
        LEFT JOIN ingredients i ON i.id_ingredient = ir.id_ingredients
        WHERE b.id_bento IN ($placeholders)
        ORDER BY b.id_bento
    ");

    $stmt->execute(array_values($bentoIds));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $id = $row['id_bento'];

        if (!isset($bentoData[$id])) {
            $bentoData[$id] = [
                    'description' => $row['description'],
                    'author' => trim($row['prenom'] . ' ' . $row['nom']),
                    'ingredients' => []
            ];
        }

        if (!empty($row['ingredient_nom'])) {
            $bentoData[$id]['ingredients'][] = $row['ingredient_nom'];
        }
    }

    foreach ($bentoData as &$bento) {
        $bento['ingredients'] = array_values(array_unique($bento['ingredients']));
    }
}
?>

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

                <?php foreach ($cart as $item):

                    $bentoId = (int)$item['id'];
                    $data = $bentoData[$bentoId] ?? null;
                    ?>

                    <li class="cartBentoItem" data-bento-id="<?= $bentoId ?>">

                        <a href="/bento/view?id=<?= $bentoId ?>">
                            <article class="cartBentoCard">

                                <header class="cartBentoHeader">

                                    <figure class="cartBentoVisual">
                                        <div class="cartBentoImagePlaceholder" aria-hidden="true">
                                            <img src="/assets/img/bento-vide.svg" alt="" width="80" height="80">
                                        </div>
                                        <figcaption class="cartBentoMeta">
                                            <h2 class="cartBentoName">
                                                <?= htmlspecialchars($item['nom']) ?>
                                            </h2>

                                            <p>
                                                <?= $data ? nl2br(htmlspecialchars($data['description'])) : '' ?>
                                            </p>
                                            <p class="cartBentoAuthor">
                                                <?= $data ? 'Par ' . htmlspecialchars($data['author']) : '' ?>
                                            </p>
                                        </figcaption>
                                    </figure>

                                    <button
                                            type="button"
                                            class="removeBentoButton"
                                            data-bento-id="<?= $bentoId ?>"
                                            aria-label="Supprimer ce bento du panier"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20"
                                             viewBox="0 0 18 20"
                                             fill="none">
                                            <path d="M5.49241 0.829546L5.14286 1.81818H1.28571C0.574554 1.81818 0 2.35985 0 3.0303C0 3.70076 0.574554 4.24242 1.28571 4.24242H16.7143C17.4254 4.24242 18 3.70076 18 3.0303C18 2.35985 17.4254 1.81818 16.7143 1.81818H12.8571L12.5076 0.829546C12.3308 0.333333 11.8406 0 11.2862 0H6.71384C6.15938 0 5.6692 0.333333 5.49241 0.829546ZM16.7143 6.06061H1.28571L2.13348 18.2992C2.19777 19.2576 3.04152 20 4.05804 20H13.942C14.9585 20 15.8022 19.2576 15.8665 18.2992L16.7143 6.06061Z"
                                                  fill="#F9F2E8"/>
                                        </svg>
                                    </button>

                                </header>

                                <section class="cartBentoIngredients">
                                    <h3>Ingrédients</h3>

                                    <ul class="ingredientsPreviewList">
                                        <?php if ($data && !empty($data['ingredients'])): ?>
                                            <?php foreach (array_slice($data['ingredients'], 0, 6) as $ingredient): ?>
                                                <li class="ingredientPreview">
                                                    <?= htmlspecialchars($ingredient) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="ingredientPreview">Aucun ingrédient</li>
                                        <?php endif; ?>
                                    </ul>
                                </section>

                            </article>
                        </a>
                    </li>

                <?php endforeach; ?>


            <?php endforeach; ?>

        </ul>

        <div class="cartValidation" id="cartValidation">
            <button type="button" class="btn btn_red" onclick="window.location.href='/panier/valider'">
                Valider
            </button>
        </div>

    <?php endif; ?>

</section>

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
