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
<nav class="navigationAction" aria-label="Navigation secondaire">
    <a href="/recettes" class="backButton" aria-label="Retour aux recettes">
        <span class="iconArrowLeft"></span>
    </a>
</nav>

<header class="addRecipeHeader">
    <h1>Ajouter ma recette</h1>
</header>

<form method="post" action="" id="addRecipeForm">

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
                    <span class="ingredientSelectWrapper">
                    <label class="" for="ingredient_0">Ingrédient</label>
                    <select name="ingredients[0][id_ingredient]" id="ingredient_0" class="ingredientSelect">
                        <optgroup label="Nouveaux ingrédients">
                        <option value="">Choisir un ingrédient</option>
                        <option value="new">+ Ajouter un nouvel ingrédient</option>
                        </optgroup>
                        <optgroup label="Ingrédients existants">
                        <?php foreach ($ingredientsList as $ingredient): ?>
                            <option value="<?= $ingredient['id_ingredient'] ?>">
                                <?= htmlspecialchars($ingredient['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                        </optgroup>
                    </select>
                    </span>

                <div class="input-group">
                    <label for="new_ingredient_0" hidden="hidden" aria-hidden="true">Nom du nouvel ingrédient</label>
                    <input
                            type="text"
                            name="ingredients[0][new_nom]"
                            id="new_ingredient_0"
                            class="newIngredientInput"
                            placeholder="Nom du nouvel ingrédient"
                            hidden
                    >
                </div>
                <div class="qty-group">
                    <div class="input-group fullSize">
                        <label class="" for="quantite_0">Quantité</label>
                        <input type="number" step="any" name="ingredients[0][quantite]" id="quantite_0"
                               class="ingredientInput">
                    </div>
                    <div class="input-group">
                        <label class="" for="unite_0">Unité</label>
                        <select name="ingredients[0][id_unite]" id="unite_0" class="ingredientSelect">
                            <option value="">Unité</option>
                            <?php foreach ($unitesList as $unite): ?>
                                <option value="<?= $unite['id_unites'] ?>">
                                    <?= htmlspecialchars($unite['unites']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </li>
        </ul>

        <button type="button" id="addIngredientButton" aria-label="Ajouter un ingrédient" class="btn btn_red">
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
        <button type="submit" class="btn btn_red">
            Ajouter
        </button>
    </div>

</form>
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
        <span class="ingredientSelectWrapper">
            <label for="ingredient_${ingredientIndex}">Ingrédient</label>
            <select name="ingredients[${ingredientIndex}][id_ingredient]" id="ingredient_${ingredientIndex}" class="ingredientSelect">
                <optgroup label="Nouveaux ingrédients">
                    <option value="">Choisir un ingrédient</option>
                    <option value="new">+ Ajouter un nouvel ingrédient</option>
                </optgroup>
                <optgroup label="Ingrédients existants">
                    <?php foreach ($ingredientsList as $ingredient): ?>
                        <option value="<?= $ingredient['id_ingredient'] ?>"><?= htmlspecialchars($ingredient['nom']) ?></option>
                    <?php endforeach; ?>
                </optgroup>
            </select>
        </span>

        <div class="input-group">
            <label for="new_ingredient_${ingredientIndex}" hidden aria-hidden="true">Nom du nouvel ingrédient</label>
            <input
                type="text"
                name="ingredients[${ingredientIndex}][new_nom]"
                id="new_ingredient_${ingredientIndex}"
                class="newIngredientInput"
                placeholder="Nom du nouvel ingrédient"
                hidden
            >
        </div>

        <div class="qty-group">
            <div class="input-group fullSize">
                <label for="quantite_${ingredientIndex}">Quantité</label>
                <input type="number" step="any" name="ingredients[${ingredientIndex}][quantite]" id="quantite_${ingredientIndex}" class="ingredientInput">
            </div>
            <div class="input-group">
                <label for="unite_${ingredientIndex}">Unité</label>
                <select name="ingredients[${ingredientIndex}][id_unite]" id="unite_${ingredientIndex}" class="ingredientSelect">
                    <option value="">Unité</option>
                    <?php foreach ($unitesList as $unite): ?>
                        <option value="<?= $unite['id_unites'] ?>"><?= htmlspecialchars($unite['unites']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
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
