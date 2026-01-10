<?php
require_once __DIR__ . '/../../includes/utilities/db.php';
require_once __DIR__ . '/../../includes/utilities/auth.php';

check_logged_in();
global $conn;

$selectRecettes = $conn->query("
    SELECT recette.id_recette, recette.recette_nom, type_recette.nom_type
    FROM recette
    JOIN type_recette ON recette.id_type = type_recette.id_type
    ORDER BY type_recette.id_type, recette.recette_nom
");
$recettes = $selectRecettes->fetchAll(PDO::FETCH_ASSOC);

$recettesParType = [];
foreach ($recettes as $recette) {
    $recettesParType[$recette['nom_type']][] = $recette;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['bento_nom']) && !empty($_POST['recettes'])) {

        $addBento = $conn->prepare("
            INSERT INTO bento (bento_nom, description, id_user)
            VALUES (:nom, :description, :user)
        ");
        $addBento->execute([
            'nom' => trim($_POST['bento_nom']),
            'description' => $_POST['bento_description'] ?? '',
            'user' => $_SESSION['user_id']
        ]);

        $idBento = $conn->lastInsertId();

        $addBentoRecette = $conn->prepare("
            INSERT INTO bento_recettes (id_bento, id_recette)
            VALUES (:bento, :recette)
        ");

        foreach ($_POST['recettes'] as $idRecette) {
            $addBentoRecette->execute([
                'bento' => $idBento,
                'recette' => (int)$idRecette
            ]);
        }

        header('Location: /bento?id=' . $idBento);
        exit();
    }
}
?>
<main class="bentoCreate">

    <h1>Créer votre bento</h1>

    <form method="post" id="bentoForm">

        <section class="bentoLeft">

            <label>
                Nom du bento
                <input type="text" name="bento_nom" required>
            </label>

            <label>
                Description (optionnel)
                <input type="text" name="bento_description">
            </label>

            <div class="bentoPreview">
                <img src="/assets/img/bento-home.svg" alt="">
            </div>

            <section class="bentoIngredients">
                <h2>Ingrédients</h2>
                <ul id="ingredientsList"></ul>
            </section>

        </section>

        <section class="bentoRight">

            <div class="tabs">
                <?php $tabIndex = 0; ?>
                <?php foreach (array_keys($recettesParType) as $typeLabel): ?>
                    <button type="button" data-tab-index="<?= $tabIndex ?>"><?= htmlspecialchars($typeLabel) ?></button>
                    <?php $tabIndex++; ?>
                <?php endforeach; ?>
             </div>

            <?php foreach ($recettesParType as $type => $liste): ?>
                <div class="tabContent" data-content="<?= htmlspecialchars($type) ?>">
                    <?php foreach ($liste as $recette): ?>
                        <label class="recetteItem">
                            <input
                                type="checkbox"
                                name="recettes[]"
                                value="<?= (int)$recette['id_recette'] ?>"
                                data-recette="<?= (int)$recette['id_recette'] ?>"
                            >
                            <?= htmlspecialchars($recette['recette_nom']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit">
                Ajouter sa recette
            </button>

        </section>

    </form>

</main>

<script>
    // Use index-based tab switching and generate buttons server-side so counts/order always match
    const tabs = Array.from(document.querySelectorAll('[data-tab-index]'))
    const contents = Array.from(document.querySelectorAll('[data-content]'))

    function showTab(index) {
        contents.forEach((c, i) => {
            c.hidden = i !== index
        })
        tabs.forEach((t, i) => {
            t.classList.toggle('active', i === index)
        })
    }

    tabs.forEach((btn) => {
        const idx = Number(btn.getAttribute('data-tab-index'))
        btn.addEventListener('click', () => showTab(idx))
    })

    // Initialize: hide all contents except the first (if any)
    if (tabs.length > 0 && contents.length > 0) {
        showTab(0)
    }

    const ingredientsList = document.getElementById('ingredientsList')
    const checkboxes = document.querySelectorAll('[data-recette]')

    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            fetch('/bento/getIngredients.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    recettes: Array.from(checkboxes)
                        .filter(c => c.checked)
                        .map(c => c.dataset.recette)
                })
            })
                .then(r => r.json())
                .then(data => {
                    ingredientsList.innerHTML = ''
                    data.forEach(i => {
                        const li = document.createElement('li')
                        li.textContent = i
                        ingredientsList.appendChild(li)
                    })
                })
        })
    })

    const form = document.getElementById('bentoForm')
    const nameInput = form.querySelector('input[name="bento_nom"]')
    const recipeInputs = form.querySelectorAll('input[name="recettes[]"]')

    form.addEventListener('submit', e => {
        const hasName = nameInput.value.trim().length > 0
        const hasRecipe = Array.from(recipeInputs).some(i => i.checked)

        if (!hasName || !hasRecipe) {
            e.preventDefault()
            alert('Veuillez donner un nom au bento et sélectionner au moins une recette.')
        }
    })
</script>

<style>
    .bentoCreate {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 24px 64px;
        border-radius: 1.5625rem 1.5625rem 0 0;
        border: 3px solid #E94141;
    }

    .bentoCreate h1 {
        color: #E94141;
        font-family: Shrimp, sans-serif;
        font-size: 2.25rem;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    #bentoForm {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 32px;
    }

    .bentoLeft {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .bentoLeft label {
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 14px;
        font-weight: 500;
    }

    .bentoLeft input[type="text"] {
        padding: 10px 12px;
        font-size: 14px;
        border-radius: 6px;
        border: 1px solid #d6d6d6;
    }

    .bentoPreview {
        border-radius: 1.5625rem 1.5625rem 0 0;
        border: 3px solid #E94141;
        padding: 5.25rem 4.125rem 5.1875rem 4.125rem;

    }

    .bentoPreview img {
        max-width: 100%;
        height: auto;
    }

    .bentoIngredients {
        border-radius: 1.5625rem 1.5625rem 0 0;
        border: 3px solid #E94141;
        padding: 16px;
    }

    .bentoIngredients h2 {
        margin: 0 0 12px;
        color: #E94141;
        font-family: Shrimp, sans-serif;
        font-size: 1.3rem;
        font-style: normal;
        line-height: normal;
        font-weight: 600;
    }

    .bentoIngredients ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .bentoIngredients li {
        font-size: 14px;
        padding: 6px 0;
    }

    .bentoRight {
        display: flex;
        flex-direction: column;
    }

    .tabs {
        display: flex;
    }

    .tabs button {
        flex: 1;
        padding: 10px 8px;
        background: none;
        cursor: pointer;
        border-radius: 0.9375rem 0.9375rem 0 0;
        border-top: 2px solid #E94141;
        border-right: 2px solid #E94141;
        border-left: 2px solid #E94141;
        border-bottom: 2px solid #E94141;
        color: #E94141;
        text-align: center;
        font-size: 1.25rem;
        font-style: normal;
        font-weight: 800;
        line-height: normal;
    }

    .tabs button.active {
        border-bottom: none !important;
        background: #ffffff;
    }

    .tabs button:hover {
        background: #ededed;
    }

    .tabContent {
        border-right: 2px solid #E94141;
        border-bottom: 2px solid #E94141;
        border-left: 2px solid #E94141;
        padding: 12px;
        max-height: 500px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    [hidden] {
        display: none !important;
    }

    .recetteItem {
        font-family: "Fivo Sans", sans-serif;
        display: flex;
        align-items: center;
        padding: 0.875rem 1.9375rem;
        gap: 4.5625rem;
        cursor: pointer;
        border-radius: 1.5625rem 1.5625rem 0 0;
        border: 2px solid #E94141;
        background: #F9F2E8;
        color: #E94141;
        font-size: 1.15rem;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .recetteItem:hover {
        background: #f4f4f4;
    }

    .recetteItem input {
        margin: 0;
        width: 16px;
        height: 16px;
        border: 2px solid #E94141;
        cursor: pointer;
        background: #F9F2E8;
    }

    .bentoRight button[type="submit"] {
        margin-top: 12px;
        padding: 12px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 6px;
        border: 1px solid #c93b36;
        background: #c93b36;
        color: #ffffff;
        cursor: pointer;
    }

    .bentoRight button[type="submit"]:hover {
        opacity: 0.9;
    }

    @media (max-width: 900px) {
        #bentoForm {
            grid-template-columns: 1fr;
        }
    }

</style>
