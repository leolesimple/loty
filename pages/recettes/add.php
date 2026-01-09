<?php
global $conn;
require_once __DIR__ . '/../../includes/utilities/auth.php';
require_once __DIR__ . '/../../includes/utilities/db.php';
require_once __DIR__ . '/../../includes/utilities/recipes.php';

check_logged_in();

$ingredientsStmt = $conn->query("SELECT id_ingredient, nom FROM ingredients ORDER BY nom");
$ingredientsList = $ingredientsStmt->fetchAll(PDO::FETCH_ASSOC);

$unitesStmt = $conn->query("SELECT id_unites, unites FROM unites ORDER BY unites");
$unitesList = $unitesStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $recipeId = addRecipe($_POST, $_SESSION['user_id'], $conn);
        header("Location: /loty/recette/view?id=" . $recipeId);
        exit();
    } catch (Throwable $e) {
        $formError = "Une erreur est survenue lors de l’enregistrement.";
    }
}

?>
<style>
    .stepSelector {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .stepButton {
        width: 40px;
        height: 40px;
        border: 2px solid var(#e84b4b);
        background: transparent;
        color: var(#e84b4b);
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .stepButton:hover,
    .stepButton:focus-visible {
        background-color: rgba(232, 75, 75, 0.1);
        outline: none;
    }

    .stepButton.active {
        background-color: var( #e84b4b);
        color: #ffffff;
    }

    .stepsContainer {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .stepField {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .stepField label {
        font-weight: 600;
        color: var(--accent-color, #e84b4b);
    }

    .stepField textarea {
        resize: vertical;
        min-height: 90px;
        padding: 12px;
        border-radius: 10px;
        border: 2px solid var(--accent-color, #e84b4b);
        background-color: transparent;
        font-family: inherit;
        font-size: 1rem;
    }

    .stepField textarea:focus-visible {
        outline: none;
        box-shadow: 0 0 0 3px rgba(232, 75, 75, 0.25);
    }

    .stepField textarea[aria-invalid="true"] {
        border-color: #b00020;
    }

</style>
<main class="addRecipePage">

    <nav class="navigationAction" aria-label="Navigation secondaire">
        <a href="/recettes" class="backButton" aria-label="Retour aux recettes">
            <span class="iconArrowLeft"></span>
        </a>
    </nav>

    <header class="addRecipeHeader">
        <h1>Ajouter ma recette</h1>
    </header>

    <form method="post" action="" id="addRecipeForm" novalidate>

        <section class="recipeIdentity">

            <div class="formField">
                <label for="recette_nom">Nom</label>
                <input type="text" id="recette_nom" name="recette_nom" required aria-required="true">
                <span class="error" id="nameError" aria-live="polite"></span>
            </div>

            <div class="formField">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" required aria-required="true"></textarea>
                <span class="error" id="descriptionError" aria-live="polite"></span>
            </div>

        </section>

        <section class="ingredientsSection">
            <h2>Ingrédients</h2>

            <ul class="ingredientsList" id="ingredientsList">
                <li class="ingredientRow">

                    <label class="sr-only" for="ingredient_0">Ingrédient</label>
                    <select name="ingredients[0][id_ingredient]" id="ingredient_0" class="ingredientSelect">
                        <option value="">Choisir un ingrédient</option>
                        <?php foreach ($ingredientsList as $ingredient): ?>
                            <option value="<?= $ingredient['id_ingredient'] ?>">
                                <?= htmlspecialchars($ingredient['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="new">+ Ajouter un nouvel ingrédient</option>
                    </select>

                    <input
                            type="text"
                            name="ingredients[0][new_nom]"
                            class="newIngredientInput"
                            placeholder="Nom du nouvel ingrédient"
                            hidden
                    >

                    <label class="sr-only" for="quantite_0">Quantité</label>
                    <input type="number" step="any" name="ingredients[0][quantite]" id="quantite_0">

                    <label class="sr-only" for="unite_0">Unité</label>
                    <select name="ingredients[0][id_unite]" id="unite_0">
                        <option value="">Unité</option>
                        <?php foreach ($unitesList as $unite): ?>
                            <option value="<?= $unite['id_unites'] ?>">
                                <?= htmlspecialchars($unite['unites']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </li>
            </ul>

            <button type="button" id="addIngredientButton" aria-label="Ajouter un ingrédient">
                +
            </button>
        </section>

        <section class="stepsSection">
            <h2>Nombre d’étapes</h2>

            <div class="stepSelector" role="group" aria-label="Sélection des étapes">
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <button type="button" class="stepButton" data-step="<?= $i ?>" aria-pressed="false">
                        <?= $i ?>
                    </button>
                <?php endfor; ?>
            </div>

            <div class="stepsContainer" id="stepsContainer"></div>
        </section>

        <div class="formActions">
            <button type="submit" class="mainSubmitButton">
                Ajouter
            </button>
        </div>

    </form>

</main>
<script>
    const ingredientsList = document.getElementById("ingredientsList")
    const addIngredientButton = document.getElementById("addIngredientButton")

    let ingredientIndex = 1

    ingredientsList.addEventListener("change", event => {
        if (!event.target.classList.contains("ingredientSelect")) return

        const row = event.target.closest(".ingredientRow")
        const newInput = row.querySelector(".newIngredientInput")

        if (event.target.value === "new") {
            newInput.hidden = false
            newInput.required = true
        } else {
            newInput.hidden = true
            newInput.required = false
            newInput.value = ""
        }
    })

    addIngredientButton.addEventListener("click", () => {
        const li = document.createElement("li")
        li.className = "ingredientRow"

        li.innerHTML = `
        <select name="ingredients[${ingredientIndex}][id_ingredient]" class="ingredientSelect">
            <option value="">Choisir un ingrédient</option>
            <?php foreach ($ingredientsList as $ingredient): ?>
                <option value="<?= $ingredient['id_ingredient'] ?>">
                    <?= htmlspecialchars($ingredient['nom']) ?>
                </option>
            <?php endforeach; ?>
            <option value="new">+ Ajouter un nouvel ingrédient</option>
        </select>

        <input
            type="text"
            name="ingredients[${ingredientIndex}][new_nom]"
            class="newIngredientInput"
            placeholder="Nom du nouvel ingrédient"
            hidden
        >

        <input type="number" step="any" name="ingredients[${ingredientIndex}][quantite]">

        <select name="ingredients[${ingredientIndex}][id_unite]">
            <option value="">Unité</option>
            <?php foreach ($unitesList as $unite): ?>
                <option value="<?= $unite['id_unites'] ?>">
                    <?= htmlspecialchars($unite['unites']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    `

        ingredientsList.appendChild(li)
        ingredientIndex++
    })

    const form = document.getElementById("addRecipeForm")
    const nameInput = document.getElementById("recette_nom")
    const descInput = document.getElementById("description")
    const stepsContainer = document.getElementById("stepsContainer")
    const stepButtons = document.querySelectorAll(".stepButton")
/*    const addIngredientButton = document.getElementById("addIngredientButton")
    const ingredientsList = document.getElementById("ingredientsList")

    let ingredientIndex = 1*/
    let steps = {}

    const createdSteps = new Set()

    stepButtons.forEach(button => {
        button.addEventListener("click", () => {
            const step = button.dataset.step

            if (createdSteps.has(step)) {
                return
            }

            createdSteps.add(step)

            button.classList.add("active")
            button.setAttribute("aria-pressed", "true")

            const wrapper = document.createElement("div")
            wrapper.className = "stepField"
            wrapper.dataset.step = step

            const label = document.createElement("label")
            label.setAttribute("for", "step_" + step)
            label.textContent = "Étape " + step

            const textarea = document.createElement("textarea")
            textarea.id = "step_" + step
            textarea.name = "steps[" + step + "]"
            textarea.rows = 3
            textarea.required = true

            wrapper.appendChild(label)
            wrapper.appendChild(textarea)
            stepsContainer.appendChild(wrapper)
        })
    })

    addIngredientButton.addEventListener("click", () => {
        const li = document.createElement("li")
        li.className = "ingredientRow"

        li.innerHTML = `
        <input type="text" name="ingredients[${ingredientIndex}][nom]" aria-label="Nom de l’ingrédient" required>
        <input type="number" step="any" name="ingredients[${ingredientIndex}][quantite]" aria-label="Quantité">
        <input type="text" name="ingredients[${ingredientIndex}][unite]" aria-label="Unité">
    `

        ingredientsList.appendChild(li)
        ingredientIndex++
    })

    form.addEventListener("submit", event => {
        let valid = true

        if (!nameInput.value.trim()) {
            valid = false
            document.getElementById("nameError").textContent = "Le nom est obligatoire."
        }

        if (!descInput.value.trim()) {
            valid = false
            document.getElementById("descriptionError").textContent = "La description est obligatoire."
        }

        const stepFields = stepsContainer.querySelectorAll("textarea")
        stepFields.forEach(field => {
            if (!field.value.trim()) {
                valid = false
                field.setAttribute("aria-invalid", "true")
            }
        })

        if (!valid) {
            event.preventDefault()
        }
    })
</script>
