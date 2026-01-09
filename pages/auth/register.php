<?php

global $conn;
require_once __DIR__ . '/../../includes/utilities/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $bio = $_POST['bio'];
    echo $bio;
    //Transformer bio en texte brut pour éviter les injections XSS
    $bio = strip_tags($bio);
    echo $bio;
    $photo = $_FILES['photo'];

    // Vérifier si l'utilisateur existe déjà
    $checkUser = $conn->prepare("SELECT * FROM user WHERE username = :user");
    $checkUser->bindParam(':user', $username);
    $checkUser->execute();

    var_dump($checkUser);

    // Upload de la photo de profil
    $uploadDir = 'uploads/profiles/';
    $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $newFileName = 'loty_' . $username . '_' . time() . '.' . $fileExtension;
    $uploadFilePath = $uploadDir . $newFileName;
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilePath)) {
        $photo = $uploadFilePath;
    } else {
        echo "Erreur lors du téléchargement de la photo.";
        exit();
    }

    if ($checkUser->rowCount() > 0) {
        echo "Ce nom d'utilisateur existe déjà.";
    } else {
        // Insérer le nouvel utilisateur dans la base de données
        $inscription = $conn->prepare("INSERT INTO user (nom, prenom, bio, photo, username, mail, motdepasse, role) VALUES (:nom, :prenom, :bio, :photo, :username, :email, :password, 'user')");
        $inscription->bindParam(':nom', $nom);
        $inscription->bindParam(':prenom', $prenom);
        $inscription->bindParam(':bio', $bio);
        $inscription->bindParam(':photo', $photo);
        $inscription->bindParam(':username', $username);
        $inscription->bindParam(':email', $email);
        $inscription->bindParam(':password', $password);
        $inscription->execute();
    }

    header('Location: /login?error=registered');
    exit();
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
