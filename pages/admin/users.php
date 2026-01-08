<?php
require_once __DIR__ . '/../../includes/utilities/db.php';
global $conn;

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Accès refusé");
}

$stmt = $conn->prepare("SELECT role FROM user WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$currentUser || $currentUser['role'] !== 'admin') {
    http_response_code(403);
    exit("Accès réservé à l’administration");
}

$message = '';
$messageType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {

    if (
        !empty($_POST['id_user']) &&
        !empty($_POST['username']) &&
        !empty($_POST['mail']) &&
        !empty($_POST['role'])
    ) {

        $stmt = $conn->prepare("
            UPDATE user
            SET username = :username,
                mail = :mail,
                role = :role
            WHERE id = :id
        ");

        if ($stmt->execute([
            'username' => $_POST['username'],
            'mail' => $_POST['mail'],
            'role' => $_POST['role'],
            'id' => (int) $_POST['id_user']
        ])) {
            $message = "L’utilisateur a bien été mis à jour.";
            $messageType = "success";
        } else {
            $message = "Erreur lors de la mise à jour de l’utilisateur.";
            $messageType = "error";
        }

    } else {
        $message = "Tous les champs sont requis pour modifier un utilisateur.";
        $messageType = "error";
    }
}

if (isset($_GET['delete'])) {

    $deleteId = (int) $_GET['delete'];

    if ($deleteId === (int) $_SESSION['user_id']) {
        $message = "Impossible de supprimer votre propre compte.";
        $messageType = "error";
    } else {

        $stmt = $conn->prepare("DELETE FROM user WHERE id = :id");

        if ($stmt->execute(['id' => $deleteId])) {
            $message = "L’utilisateur a bien été supprimé.";
            $messageType = "success";
        } else {
            $message = "Erreur lors de la suppression de l’utilisateur.";
            $messageType = "error";
        }
    }
}

$stmt = $conn->query("
    SELECT
        id,
        username,
        nom,
        prenom,
        mail,
        role,
        date_creation
    FROM user
    ORDER BY date_creation DESC
");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="adminContainer">

    <header class="adminHeader">
        <h1>Administration · Utilisateurs</h1>
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

        <h2>Utilisateurs</h2>

        <?php if (empty($users)): ?>
            <p>Aucun utilisateur enregistré.</p>
        <?php endif; ?>

        <?php foreach ($users as $user): ?>

            <article class="adminItem">

                <form method="post" class="adminForm">

                    <input
                        type="hidden"
                        name="id_user"
                        value="<?= (int) $user['id'] ?>"
                    >

                    <label>
                        Nom d’utilisateur
                        <input
                            type="text"
                            name="username"
                            value="<?= htmlspecialchars($user['username']) ?>"
                            required
                        >
                    </label>

                    <label>
                        Email
                        <input
                            type="email"
                            name="mail"
                            value="<?= htmlspecialchars($user['mail']) ?>"
                            required
                        >
                    </label>

                    <label>
                        Rôle
                        <select name="role" required>
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>
                                Utilisateur
                            </option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
                                Administrateur
                            </option>
                        </select>
                    </label>

                    <p>
                        Nom complet :
                        <strong>
                            <?= htmlspecialchars($user['prenom']) ?>
                            <?= htmlspecialchars($user['nom']) ?>
                        </strong>
                    </p>

                    <p>
                        Inscrit le :
                        <strong><?= htmlspecialchars($user['date_creation']) ?></strong>
                    </p>

                    <div class="adminItemFooter">

                        <button
                            type="submit"
                            name="update_user"
                            class="adminButton"
                        >
                            Enregistrer
                        </button>

                        <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                            <a
                                href="/admin/users?delete=<?= (int) $user['id'] ?>"
                                class="adminDelete"
                                onclick="return confirm('Supprimer cet utilisateur ?')"
                            >
                                Supprimer
                            </a>
                        <?php endif; ?>

                    </div>

                </form>

            </article>

        <?php endforeach; ?>

    </section>

</main>
