<?php

global $conn;
require_once __DIR__ . '/../../includes/utilities/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    // Validation de base
    if (empty($username) || empty($email) || empty($password) || empty($nom) || empty($prenom)) {
        header('Location: /register?error=missing_fields');
        exit();
    }

    // Vérifier la confirmation du mot de passe
    if ($password !== $password_confirm) {
        header('Location: /register?error=password_mismatch');
        exit();
    }

    // Transformer bio en texte brut pour éviter les injections XSS
    $bio = strip_tags($bio);

    // Hasher le mot de passe
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Vérifier si l'utilisateur existe déjà
    $checkUser = $conn->prepare("SELECT * FROM user WHERE username = :user OR mail = :email");
    $checkUser->bindParam(':user', $username);
    $checkUser->bindParam(':email', $email);
    $checkUser->execute();

    if ($checkUser->rowCount() > 0) {
        header('Location: /register?error=user_exists');
        exit();
    }

    // Upload de la photo de profil
    $uploadDir = __DIR__ . '/../../uploads/profiles/';

    // Créer le dossier s'il n'existe pas
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileExtension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        header('Location: /register?error=invalid_file_type');
        exit();
    }

    $newFileName = 'loty_' . $username . '_' . time() . '.' . $fileExtension;
    $uploadFilePath = $uploadDir . $newFileName;
    $photoDbPath = '/uploads/profiles/' . $newFileName;

    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilePath)) {
        header('Location: /register?error=upload_failed');
        exit();
    }

    // Insérer le nouvel utilisateur dans la base de données
    try {
        $inscription = $conn->prepare("INSERT INTO user (nom, prenom, bio, photo, username, mail, motdepasse, role) VALUES (:nom, :prenom, :bio, :photo, :username, :email, :password, 'user')");
        $inscription->bindParam(':nom', $nom);
        $inscription->bindParam(':prenom', $prenom);
        $inscription->bindParam(':bio', $bio);
        $inscription->bindParam(':photo', $photoDbPath);
        $inscription->bindParam(':username', $username);
        $inscription->bindParam(':email', $email);
        $inscription->bindParam(':password', $password_hash);
        $inscription->execute();

        header('Location: /login?error=registered');
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, supprimer la photo uploadée
        if (file_exists($uploadFilePath)) {
            unlink($uploadFilePath);
        }
        header('Location: /register?error=db_error');
        exit();
    }
}

?>
<?php
// Affichage des messages d'erreur
if (isset($_GET['error'])) {
    $error_code = $_GET['error'];
    $error_messages = [
        'missing_fields' => "Veuillez remplir tous les champs obligatoires.",
        'password_mismatch' => "Les mots de passe ne correspondent pas.",
        'user_exists' => "Ce nom d'utilisateur ou cette adresse email existe déjà.",
        'invalid_file_type' => "Type de fichier non autorisé. Veuillez utiliser JPG, PNG, GIF ou WebP.",
        'upload_failed' => "Erreur lors du téléchargement de la photo. Veuillez réessayer.",
        'db_error' => "Erreur lors de l'inscription. Veuillez réessayer.",
    ];
    if (array_key_exists($error_code, $error_messages)) {
        echo "<p class='error-message' aria-live='polite' aria-atomic='true' style='color: #E94141; text-align: center; margin: 20px auto; max-width: 600px; padding: 10px; background: #FFE5E5; border-radius: 10px;'>" . htmlspecialchars($error_messages[$error_code]) . "</p>";
    }
}
?>
<section class="registerContainer">
    <h1>Nous Rejoindre</h1>
    <p>On se connaît déjà ? <a href="/login">Connectez-vous</a></p>
    <form action="" method="POST" enctype="multipart/form-data" class="registerForm">
        <div class="input-group">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" placeholder="johndoe" required>
        </div>
        <div class="input-group">
            <label for="nom">Nom de famille :</label>
            <input type="text" id="nom" name="nom" placeholder="Dupont" required>
        </div>
        <div class="input-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" placeholder="Jean" required>
        </div>
        <div class="input-group">
            <label for="bio">Bio :</label>
            <textarea name="bio" id="bio" placeholder="Parlez-nous de vous..." required></textarea>
        </div>
        <div class="input-group">
            <label for="photo">Télécharger une photo de profil :</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>
        </div>
        <div class="input-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="email@domain.net" required>
        </div>
        <div class="input-group">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
        </div>
        <div class="input-group">
            <label for="password_confirm">Confirmation du mot de passe :</label>
            <input type="password" id="password_confirm" name="password_confirm"
                   placeholder="Confirmez votre mot de passe"
                   required>
        </div>
        <div class="input-group">
            <button type="submit" class="btn btn_red">S'inscrire</button>
        </div>
    </form>
</section>
