<?php
require_once __DIR__ . '/../includes/utilities/db.php';
session_start();
global $conn;

$data = json_decode(file_get_contents('php://input'), true);

if (
    !isset($data['recettes']) ||
    !is_array($data['recettes']) ||
    empty($data['recettes'])
) {
    http_response_code(400);
    exit();
}

$ids = array_map('intval', $data['recettes']);
$placeholders = implode(',', array_fill(0, count($ids), '?'));

$stmt = $conn->prepare("
    SELECT
        i.nom AS ingredient,
        ir.quantite,
        u.unites
    FROM ingredients_recettes ir
    JOIN ingredients i ON ir.id_ingredients = i.id_ingredient
    JOIN unites u ON ir.unites = u.id_unites
    WHERE ir.id_recette IN ($placeholders)
");
$stmt->execute($ids);

$result = [];

foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $key = $row['ingredient'] . '_' . ($row['unites'] ?? '');

    if (!isset($result[$key])) {
        $result[$key] = [
            'nom' => $row['ingredient'],
            'quantite' => $row['quantite'],
            'unite' => $row['unites']
        ];
    } else {
        if ($row['quantite'] !== null) {
            $result[$key]['quantite'] += $row['quantite'];
        }
    }
}

header('Content-Type: application/json');
echo json_encode(array_values($result));
