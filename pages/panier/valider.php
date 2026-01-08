<?php
session_start();
require_once __DIR__ . '/../../includes/utilities/db.php';
global $conn;

if (empty($_SESSION['cart'])) {
    echo "<p>Panier vide.</p>";
    exit();
}

$sendMail = isset($_POST['send_mail']);
$userMail = $_POST['email'] ?? null;

$bentoIds = array_keys($_SESSION['cart']);
$placeholders = implode(',', array_fill(0, count($bentoIds), '?'));

$sql = "
SELECT
    ingredients.id_ingredient,
    ingredients.nom AS ingredient_nom,
    ingredients_recettes.quantite,
    unites.unites AS unite
FROM bento_recettes
JOIN ingredients_recettes ON bento_recettes.id_recette = ingredients_recettes.id_recette
JOIN ingredients ON ingredients_recettes.id_ingredients = ingredients.id_ingredient
JOIN unites ON ingredients_recettes.unites = unites.id_unites
WHERE bento_recettes.id_bento IN ($placeholders)
";

$stmt = $conn->prepare($sql);
$stmt->execute($bentoIds);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$ingredients = [];

foreach ($rows as $row) {

    $name = $row['ingredient_nom'];
    $qty = (float)$row['quantite'];
    $unit = $row['unite'];

    if (!isset($ingredients[$name])) {
        $ingredients[$name] = [
                'g' => 0,
                'ml' => 0,
                'count' => 0
        ];
    }

    switch ($unit) {
        case 'g':
            $ingredients[$name]['g'] += $qty;
            break;
        case 'kg':
            $ingredients[$name]['g'] += $qty * 1000;
            break;
        case 'mL':
            $ingredients[$name]['ml'] += $qty;
            break;
        case 'L':
            $ingredients[$name]['ml'] += $qty * 1000;
            break;
        default:
            $ingredients[$name]['count'] += $qty ?: 1;
            break;
    }
}

$finalIngredients = [];

foreach ($ingredients as $name => $data) {

    if ($data['g'] > 0) {
        if ($data['g'] >= 1000) {
            $finalIngredients[] = [
                    'nom' => $name,
                    'quantite' => $data['g'] / 1000,
                    'unite' => 'kg'
            ];
        } else {
            $finalIngredients[] = [
                    'nom' => $name,
                    'quantite' => $data['g'],
                    'unite' => 'g'
            ];
        }
    }

    if ($data['ml'] > 0) {
        if ($data['ml'] >= 1000) {
            $finalIngredients[] = [
                    'nom' => $name,
                    'quantite' => $data['ml'] / 1000,
                    'unite' => 'L'
            ];
        } else {
            $finalIngredients[] = [
                    'nom' => $name,
                    'quantite' => $data['ml'],
                    'unite' => 'mL'
            ];
        }
    }

    if ($data['count'] > 0) {
        $finalIngredients[] = [
                'nom' => $name,
                'quantite' => $data['count'],
                'unite' => 'x'
        ];
    }
}

$mailStatus = null;

if ($sendMail && filter_var($userMail, FILTER_VALIDATE_EMAIL)) {

    $content = "Liste de courses LOTY\n\n";

    foreach ($finalIngredients as $item) {
        $content .= "- {$item['quantite']} {$item['unite']} {$item['nom']}\n";
    }

    $headers = "From: LOTY <no-reply@loty.fr>";

    if (mail($userMail, "Votre liste de courses LOTY", $content, $headers)) {
        $mailStatus = "Mail envoyé avec succès.";
    } else {
        $mailStatus = "Erreur lors de l’envoi du mail.";
    }
}
?>

<main>
    <header class="headerTitle">
        <h1 class="title">Liste des ingrédients</h1>
    </header>

    <section class="bentosSelected">
        <h2 class="sectionTitle">Bentos sélectionnés</h2>
        <ul class="bentosList">
            <?php foreach ($_SESSION['cart'] as $bento): ?>
                <li class="bentoItem"><?= htmlspecialchars($bento['nom']) ?></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="ingredientsTotal">
        <h2 class="sectionTitle">Ingrédients totaux</h2>

        <ul class="ingredientsList">
            <?php foreach ($finalIngredients as $item): ?>
                <li class="ingredientItem">
                    <?= rtrim(rtrim(number_format($item['quantite'], 2, '.', ''), '0'), '.') ?>
                    <span class="ingredientUnit"><?= htmlspecialchars($item['unite']) ?></span>
                    <span class="ingredientName"><?= htmlspecialchars($item['nom']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="printSection">
        <button class="printButton" onclick="window.print()">Imprimer la liste</button>
    </section>

    <section class="mailSection">
        <h2 class="sectionTitle">Envoyer par mail</h2>

        <form method="post" class="mailForm">
            <label for="email" class="emailLabel">Votre email :</label>
            <input type="email" id="email" name="email" required placeholder="Votre email" class="emailInput">
            <input type="hidden" name="send_mail" value="1" class="sendMailHidden">
            <button type="submit" class="sendButton">Envoyer</button>
        </form>

        <?php if ($mailStatus): ?>
            <p class="mailStatusMessage"><?= htmlspecialchars($mailStatus) ?></p>
        <?php endif; ?>
    </section>
</main>
