<?php
session_start();
require_once __DIR__ . '/../../includes/utilities/db.php';
global $conn;

if (empty($_SESSION['cart'])) {
    echo "<p>Panier vide.</p>";
    exit();
}

/* ---------- CONFIG MAIL ---------- */

$sendMail = isset($_POST['send_mail']);
$userMail = $_POST['email'] ?? null;

/* ---------- RÉCUP BENTOS ---------- */

$bentoIds = array_keys($_SESSION['cart']);
$placeholders = implode(',', array_fill(0, count($bentoIds), '?'));

/* ---------- SQL ---------- */

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

/* ---------- AGRÉGATION ---------- */

$ingredients = [];

foreach ($rows as $row) {

    $name = $row['ingredient_nom'];
    $qty = (float) $row['quantite'];
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

/* ---------- FORMAT FINAL ---------- */

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

/* ---------- ENVOI MAIL ---------- */

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

    <header>
        <h1>Liste des ingrédients</h1>
    </header>

    <section>
        <h2>Bentos sélectionnés</h2>
        <ul>
            <?php foreach ($_SESSION['cart'] as $bento): ?>
                <li><?= htmlspecialchars($bento['nom']) ?></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section>
        <h2>Ingrédients totaux</h2>

        <ul>
            <?php foreach ($finalIngredients as $item): ?>
                <li>
                    <?= rtrim(rtrim(number_format($item['quantite'], 2, '.', ''), '0'), '.') ?>
                    <?= htmlspecialchars($item['unite']) ?>
                    <?= htmlspecialchars($item['nom']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section>
        <button onclick="window.print()">Imprimer la liste</button>
    </section>

    <section>
        <h2>Envoyer par mail</h2>

        <form method="post">
            <label for="email">Votre email :</label>
            <input type="email" id="email" name="email" required placeholder="Votre email">
            <input type="hidden" name="send_mail" value="1">
            <button type="submit">Envoyer</button>
        </form>

        <?php if ($mailStatus): ?>
            <p><?= htmlspecialchars($mailStatus) ?></p>
        <?php endif; ?>
    </section>

</main>
