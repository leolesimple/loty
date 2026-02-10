<?php
global $conn;
require_once __DIR__ . '/../../includes/utilities/db.php';
require_once __DIR__ . '/../../includes/utilities/auth.php';
require_once __DIR__ . '/../../includes/utilities/helpers.php';

check_logged_in();

$user_id = $_SESSION['user_id'];
$errors = [];
$success = false;

// Récupérer les données de l'utilisateur
$user_query = $conn->prepare("SELECT * FROM user WHERE id = :id LIMIT 1");
$user_query->bindValue(':id', $user_id, PDO::PARAM_INT);
$user_query->execute();
$user_data = $user_query->fetch(PDO::FETCH_ASSOC);

if (!$user_data) {
    header('Location: /logout');
    exit();
}

// Gestion du formulaire de photo de profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_photo'])) {
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../uploads/profiles/';

        // Créer le dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileExtension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = "Type de fichier non autorisé. Les formats acceptés sont: JPG, PNG, GIF, WEBP.";
        } else {
            $newFileName = 'loty_' . $user_data['username'] . '_' . time() . '.' . $fileExtension;
            $uploadFilePath = $uploadDir . $newFileName;
            $photoDbPath = '/uploads/profiles/' . $newFileName;

            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilePath)) {
                $errors[] = "Erreur lors de l'upload de la photo.";
            } else {
                // Supprimer l'ancienne photo si elle existe
                if (!empty($user_data['photo']) && $user_data['photo'] !== 'assets/img/default-profile.png' && file_exists(__DIR__ . '/../../' . $user_data['photo'])) {
                    unlink(__DIR__ . '/../../' . $user_data['photo']);
                }

                try {
                    $photo_update = $conn->prepare("UPDATE user SET photo = :photo WHERE id = :id");
                    $photo_update->bindValue(':photo', $photoDbPath, PDO::PARAM_STR);
                    $photo_update->bindValue(':id', $user_id, PDO::PARAM_INT);
                    $photo_update->execute();

                    $user_data['photo'] = $photoDbPath;
                    $success = true;
                } catch (PDOException $e) {
                    error_log('Photo update error: ' . $e->getMessage());
                    $errors[] = "Erreur serveur lors de la mise à jour de la photo.";
                }
            }
        }
    } elseif (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $errors[] = "Veuillez sélectionner une photo.";
    }
}

// Gestion du formulaire d'informations personnelles
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $new_password_confirm = $_POST['new_password_confirm'] ?? '';

    // Validation des champs nom et prénom
    if (empty($nom) || empty($prenom)) {
        $errors[] = "Le nom et le prénom sont requis.";
    }

    // Validation de l'email
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }

    // Vérifier si l'email est déjà utilisé par un autre utilisateur
    $email_check = $conn->prepare("SELECT id FROM user WHERE mail = :email AND id != :id");
    $email_check->bindValue(':email', $email, PDO::PARAM_STR);
    $email_check->bindValue(':id', $user_id, PDO::PARAM_INT);
    $email_check->execute();
    if ($email_check->rowCount() > 0) {
        $errors[] = "Cet email est déjà utilisé.";
    }

    // Si l'utilisateur veut changer son mot de passe
    if (!empty($new_password) || !empty($new_password_confirm)) {
        if (empty($current_password)) {
            $errors[] = "Veuillez saisir votre mot de passe actuel pour le modifier.";
        } elseif (!password_verify($current_password, $user_data['motdepasse'])) {
            $errors[] = "Votre mot de passe actuel est incorrect.";
        } elseif ($new_password !== $new_password_confirm) {
            $errors[] = "Les nouveaux mots de passe ne correspondent pas.";
        } elseif (strlen($new_password) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
        }
    }

    // Si pas d'erreurs, mettre à jour la base de données
    if (empty($errors)) {
        try {
            $bio = strip_tags($bio);

            if (!empty($new_password)) {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = $conn->prepare("UPDATE user SET nom = :nom, prenom = :prenom, bio = :bio, mail = :email, motdepasse = :password WHERE id = :id");
                $update_query->bindValue(':password', $password_hash, PDO::PARAM_STR);
            } else {
                $update_query = $conn->prepare("UPDATE user SET nom = :nom, prenom = :prenom, bio = :bio, mail = :email WHERE id = :id");
            }

            $update_query->bindValue(':nom', $nom, PDO::PARAM_STR);
            $update_query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
            $update_query->bindValue(':bio', $bio, PDO::PARAM_STR);
            $update_query->bindValue(':email', $email, PDO::PARAM_STR);
            $update_query->bindValue(':id', $user_id, PDO::PARAM_INT);
            $update_query->execute();

            // Mettre à jour la session si nécessaire
            $_SESSION['username'] = $user_data['username'];

            $success = true;
        } catch (PDOException $e) {
            error_log('Profile update error: ' . $e->getMessage());
            $errors[] = "Erreur serveur lors de la mise à jour du profil.";
        }
    }
}

// Si pas de photo, utiliser l'image par défaut
if (empty($user_data['photo'])) {
    $user_data['photo'] = 'assets/img/default-profile.png';
}
?>

<nav class="navigationAction" aria-label="Navigation secondaire">
    <a href="/profil" class="backButton" aria-label="Retour au profil">
        <span class="iconArrowLeft"></span>
    </a>
</nav>

<section class="editProfileContainer">
    <h1>Éditer mon profil</h1>

    <?php if ($success): ?>
        <p class="success-message" aria-live="polite" aria-atomic="true">
            Votre profil a été mis à jour avec succès.
        </p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="error-container" role="alert" aria-live="assertive">
            <?php foreach ($errors as $error): ?>
                <p class="error-message"><?php echo clean($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" id="photoForm" class="profileEditForm">

        <section class="editProfileSection profilePhotoSection">
            <h2>Photo de profil</h2>
            <div class="profilePictureContainer">
                <img src="/<?php echo clean($user_data['photo']); ?>" alt="Photo de profil actuelle" width="200" height="200" class="currentProfileImg">
                <div class="uploadFieldContainer">
                    <label for="photo" class="uploadLabel">Modifier la photo</label>
                    <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/gif,image/webp" aria-label="Sélectionner une photo de profil" required>
                    <small>Formats acceptés: JPG, PNG, GIF, WEBP (Max 5MB)</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 1rem; align-self: flex-start;">Mettre à jour la photo</button>
            <input type="hidden" name="update_photo" value="1">
        </section>
    </form>

    <form method="post" id="editProfileForm" class="profileEditForm">

        <section class="editProfileSection personalInfoSection">
            <h2>Informations personnelles</h2>

            <div class="formField">
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" value="<?php echo clean($user_data['nom']); ?>" required aria-required="true">
            </div>

            <div class="formField">
                <label for="prenom">Prénom *</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo clean($user_data['prenom']); ?>" required aria-required="true">
            </div>

            <div class="formField">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?php echo clean($user_data['mail']); ?>" required aria-required="true">
            </div>

            <div class="formField">
                <label for="bio">Biographie</label>
                <textarea id="bio" name="bio" rows="4" maxlength="500" aria-label="Votre biographie"><?php echo clean($user_data['bio']); ?></textarea>
                <small>Caractères restants: <span id="bioCharCount">500</span>/500</small>
            </div>
        </section>

        <section class="editProfileSection passwordSection">
            <h2>Modifier le mot de passe</h2>
            <p class="sectionInfo">Laissez ces champs vides si vous ne souhaitez pas changer votre mot de passe.</p>

            <div class="formField">
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" id="current_password" name="current_password" aria-label="Votre mot de passe actuel">
            </div>

            <div class="formField">
                <label for="new_password">Nouveau mot de passe</label>
                <input type="password" id="new_password" name="new_password" aria-label="Votre nouveau mot de passe" minlength="8">
                <small>Minimum 8 caractères</small>
            </div>

            <div class="formField">
                <label for="new_password_confirm">Confirmer le nouveau mot de passe</label>
                <input type="password" id="new_password_confirm" name="new_password_confirm" aria-label="Confirmer votre nouveau mot de passe">
            </div>
        </section>

        <div class="formActions">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="/profil" class="btn btn-secondary">Annuler</a>
        </div>
        <input type="hidden" name="update_profile" value="1">
    </form>
</section>

<script>
    // Mettre à jour le compteur de caractères de la biographie
    const bioTextarea = document.getElementById('bio');
    const bioCharCount = document.getElementById('bioCharCount');

    if (bioTextarea && bioCharCount) {
        bioTextarea.addEventListener('input', function() {
            bioCharCount.textContent = 500 - this.value.length;
        });

        // Initialiser au chargement
        bioCharCount.textContent = 500 - bioTextarea.value.length;
    }

    // Validation du formulaire côté client
    document.getElementById('editProfileForm').addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const newPasswordConfirm = document.getElementById('new_password_confirm').value;
        const currentPassword = document.getElementById('current_password').value;

        if ((newPassword || newPasswordConfirm) && !currentPassword) {
            e.preventDefault();
            alert('Veuillez saisir votre mot de passe actuel pour modifier votre mot de passe.');
            document.getElementById('current_password').focus();
        }

        if (newPassword && newPassword !== newPasswordConfirm) {
            e.preventDefault();
            alert('Les nouveaux mots de passe ne correspondent pas.');
            document.getElementById('new_password_confirm').focus();
        }
    });
</script>

