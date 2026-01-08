<?php
session_start();
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_bento'])) {

    if (!empty($_POST['bento_nom']) && !empty($_POST['description'])) {

        $stmt = $conn->prepare("
            INSERT INTO bento (bento_nom, description, id_user)
            VALUES (:nom, :description, :user)
        ");

        if ($stmt->execute([
                'nom' => $_POST['bento_nom'],
                'description' => $_POST['description'],
                'user' => $_SESSION['user_id']
        ])) {
            $message = "Le bento a bien été ajouté.";
            $messageType = "success";
        } else {
            $message = "Erreur lors de l’ajout du bento.";
            $messageType = "error";
        }

    } else {
        $message = "Veuillez remplir tous les champs pour ajouter un bento.";
        $messageType = "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_bento'])) {

    if (
            !empty($_POST['id_bento']) &&
            !empty($_POST['bento_nom']) &&
            !empty($_POST['description'])
    ) {

        $stmt = $conn->prepare("
            UPDATE bento
            SET bento_nom = :nom, description = :description
            WHERE id_bento = :id
        ");

        if ($stmt->execute([
                'nom' => $_POST['bento_nom'],
                'description' => $_POST['description'],
                'id' => (int) $_POST['id_bento']
        ])) {
            $message = "Le bento a bien été modifié.";
            $messageType = "success";
        } else {
            $message = "Erreur lors de la modification du bento.";
            $messageType = "error";
        }

    } else {
        $message = "Tous les champs sont requis pour modifier un bento.";
        $messageType = "error";
    }
}

if (isset($_GET['delete'])) {

    $stmt = $conn->prepare("DELETE FROM bento WHERE id_bento = :id");

    if ($stmt->execute(['id' => (int) $_GET['delete']])) {
        $message = "Le bento a bien été supprimé.";
        $messageType = "success";
    } else {
        $message = "Erreur lors de la suppression du bento.";
        $messageType = "error";
    }
}

$stmt = $conn->query("
    SELECT
        bento.id_bento,
        bento.bento_nom,
        bento.description,
        user.username
    FROM bento
    JOIN user ON bento.id_user = user.id
    ORDER BY bento.id_bento DESC
");

$bentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="adminContainer">

    <header class="adminHeader">
        <h1>Administration · Bentos</h1>
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

        <h2>Ajouter un bento</h2>

        <form method="post" class="adminForm">

            <label>
                Nom du bento
                <input type="text" name="bento_nom" required>
            </label>

            <label>
                Description
                <textarea name="description" required></textarea>
            </label>

            <button type="submit" name="create_bento" class="adminButton">
                Ajouter le bento
            </button>

        </form>

    </section>

    <section class="adminSection">

        <h2>Bentos existants</h2>

        <?php if (empty($bentos)): ?>
            <p>Aucun bento enregistré.</p>
        <?php endif; ?>

        <?php foreach ($bentos as $bento): ?>

            <article class="adminItem">

                <form method="post" class="adminForm">

                    <input
                            type="hidden"
                            name="id_bento"
                            value="<?= (int) $bento['id_bento'] ?>"
                    >

                    <label>
                        Nom
                        <input
                                type="text"
                                name="bento_nom"
                                value="<?= htmlspecialchars($bento['bento_nom']) ?>"
                                required
                        >
                    </label>

                    <label>
                        Description
                        <textarea name="description" required><?= htmlspecialchars($bento['description']) ?></textarea>
                    </label>

                    <p>
                        Créé par :
                        <strong><?= htmlspecialchars($bento['username']) ?></strong>
                    </p>

                    <div class="adminItemFooter">

                        <button
                                type="submit"
                                name="update_bento"
                                class="adminButton"
                        >
                            Enregistrer
                        </button>

                        <a
                                href="/admin/bentos?delete=<?= (int) $bento['id_bento'] ?>"
                                class="adminDelete"
                                onclick="return confirm('Supprimer ce bento ?')"
                        >
                            Supprimer
                        </a>

                    </div>

                </form>

            </article>

        <?php endforeach; ?>

    </section>

</main>
