<?php
require_once __DIR__ . '/../../includes/utilities/db.php';
global $conn;

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Accès refusé");
}

$stmt = $conn->prepare("SELECT role FROM user WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['role'] !== 'admin') {
    http_response_code(403);
    exit("Accès réservé à l’administration");
}

$message = '';
$messageType = 'success';

$typesStmt = $conn->query("SELECT id_type, nom_type FROM type_recette");
$types = $typesStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_recette'])) {

    if (
        !empty($_POST['recette_nom']) &&
        !empty($_POST['id_type'])
    ) {

        $stmt = $conn->prepare("
            INSERT INTO recette (recette_nom, id_user, id_type)
            VALUES (:nom, :user, :type)
        ");

        if ($stmt->execute([
            'nom' => $_POST['recette_nom'],
            'user' => $_SESSION['user_id'],
            'type' => (int) $_POST['id_type']
        ])) {
            $message = "La recette a bien été ajoutée.";
            $messageType = "success";
        } else {
            $message = "Erreur lors de l’ajout de la recette.";
            $messageType = "error";
        }

    } else {
        $message = "Tous les champs sont requis pour ajouter une recette.";
        $messageType = "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_recette'])) {

    if (
        !empty($_POST['id_recette']) &&
        !empty($_POST['recette_nom']) &&
        !empty($_POST['id_type'])
    ) {

        $stmt = $conn->prepare("
            UPDATE recette
            SET recette_nom = :nom, id_type = :type
            WHERE id_recette = :id
        ");

        if ($stmt->execute([
            'nom' => $_POST['recette_nom'],
            'type' => (int) $_POST['id_type'],
            'id' => (int) $_POST['id_recette']
        ])) {
            $message = "La recette a bien été modifiée.";
            $messageType = "success";
        } else {
            $message = "Erreur lors de la modification de la recette.";
            $messageType = "error";
        }

    } else {
        $message = "Tous les champs sont requis pour modifier une recette.";
        $messageType = "error";
    }
}

if (isset($_GET['delete'])) {

    $stmt = $conn->prepare("DELETE FROM recette WHERE id_recette = :id");

    if ($stmt->execute(['id' => (int) $_GET['delete']])) {
        $message = "La recette a bien été supprimée.";
        $messageType = "success";
    } else {
        $message = "Erreur lors de la suppression de la recette.";
        $messageType = "error";
    }
}

$stmt = $conn->query("
    SELECT
        recette.id_recette,
        recette.recette_nom,
        type_recette.nom_type,
        user.username
    FROM recette
    JOIN type_recette ON recette.id_type = type_recette.id_type
    JOIN user ON recette.id_user = user.id
    ORDER BY recette.id_recette DESC
");

$recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="adminContainer">

    <header class="adminHeader">
        <h1>Administration · Recettes</h1>
        <a href="/admin">← Retour à l’accueil admin</a>
    </header>

    <?php if (!empty($message)): ?>
        <div
            class="adminAlert <?= $messageType === 'success' ? 'adminAlertSuccess' : 'adminAlertError' ?>"
            role="alert"
            aria-live="assertive"
        >
            <p><?= htmlspecialchars($message) ?></p>
        </div>
    <?php endif; ?>

    <section class="adminSection">

        <h2>Ajouter une recette</h2>

        <form method="post" class="adminForm">

            <label>
                Nom de la recette
                <input type="text" name="recette_nom" required>
            </label>

            <label>
                Type de recette
                <select name="id_type" required>
                    <option value="">Choisir un type</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= (int) $type['id_type'] ?>">
                            <?= htmlspecialchars($type['nom_type']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <button type="submit" name="create_recette" class="adminButton">
                Ajouter la recette
            </button>

        </form>

    </section>

    <section class="adminSection">

        <h2>Recettes existantes</h2>

        <?php if (empty($recettes)): ?>
            <p>Aucune recette enregistrée.</p>
        <?php endif; ?>

        <?php foreach ($recettes as $recette): ?>

            <article class="adminItem">

                <form method="post" class="adminForm">

                    <input
                        type="hidden"
                        name="id_recette"
                        value="<?= (int) $recette['id_recette'] ?>"
                    >

                    <label>
                        Nom
                        <input
                            type="text"
                            name="recette_nom"
                            value="<?= htmlspecialchars($recette['recette_nom']) ?>"
                            required
                        >
                    </label>

                    <label>
                        Type
                        <select name="id_type" required>
                            <?php foreach ($types as $type): ?>
                                <option
                                    value="<?= (int) $type['id_type'] ?>"
                                    <?= $type['nom_type'] === $recette['nom_type'] ? 'selected' : '' ?>
                                >
                                    <?= htmlspecialchars($type['nom_type']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <p>
                        Créée par :
                        <strong><?= htmlspecialchars($recette['username']) ?></strong>
                    </p>

                    <div class="adminItemFooter">

                        <button
                            type="submit"
                            name="update_recette"
                            class="adminButton"
                        >
                            Enregistrer
                        </button>

                        <a
                            href="/admin/recettes?delete=<?= (int) $recette['id_recette'] ?>"
                            class="adminDelete"
                            onclick="return confirm('Supprimer cette recette ?')"
                        >
                            Supprimer
                        </a>

                    </div>

                </form>

            </article>

        <?php endforeach; ?>

    </section>

</main>
