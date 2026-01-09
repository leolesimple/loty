<?php
global $conn;
require_once __DIR__ . '/../../includes/utilities/db.php';
require_once __DIR__ . '/../../includes/utilities/auth.php';
require_once __DIR__ . '/../../includes/utilities/bentos.php';

check_logged_in();

// Affichage des erreurs
if (isset($_GET['error'])) {
    $error_code = $_GET['error'];
    $error_messages = [
            'logged_in' => "Vous êtes déjà connecté.",
    ];
    if (array_key_exists($error_code, $error_messages)) {
        echo "<p class='error-message' aria-live='polite' aria-atomic='true'>" . clean($error_messages[$error_code]) . "</p>";
    }
}


$user_data_query = $conn->prepare("SELECT * FROM user WHERE id = :id LIMIT 1");
$user_data_query->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
$user_data_query->execute();
$user_data = $user_data_query->fetchAll();

if ($user_data[0]['photo'] === null || $user_data[0]['photo'] === '') {
    $user_data[0]['photo'] = 'assets/img/default-profile.png';
}


$profileCardTemplate = '
    <section class="profileCard">
        <div class="profilePicture">
            <img src="' . $user_data[0]["photo"] . '" alt="Photo de profil par défaut" width="290" height="290" class="profileImg">
        </div>
        <div class="profileInfo">
            <h2>' . clean($user_data[0]["nom"]) . " " . clean($user_data[0]["prenom"]) . '</h2>
            <span class="registerDate">Inscrit depuis le : ' . clean(date("d/m/Y", strtotime($user_data[0]["date_creation"]))) . '</span>
            <p>' . clean($user_data[0]["bio"]) . '</p>
        </div>
        <a class="editProfileButton" href="/profil/edit">
            <img src="/assets/icons/pen.svg" alt="" width="24" height="24">
            <span class="sr-only">Éditer le profil</span>
        </a>
        <a class="logoutProfileButton" href="/logout">
            <img src="/assets/icons/logout.svg" alt="" width="24" height="24">
            <span class="sr-only">Se déconnecter</span>
        </a>
    </section>';

?>
    <h1>Mon Profil</h1>
    <p>Nom d'utilisateur : <?php echo clean($_SESSION['username']); ?></p>
    <?php echo $profileCardTemplate; ?>
    <div class="faceTofaceContainer">
        <div class="bentoLayout">
            <div class="bentoGrid">
                <div class="bentoCol">
                    <h2>Mes créations Bento</h2>
                    <?php echo generateUserBentoLayout(3); ?>
                    <a class="seeMoreButton" href="/profil/bento">
                        <span>Voir plus de Bento</span>
                    </a>
                </div>
                <div class="bentoCol">
                    <h2>Mes recettes</h2>
                    <?php echo generateUserRecetteLayout(3); ?>
                    <a class="seeMoreButton" href="/profil/bento">
                        <span>Voir plus de recettes</span>
                    </a>
                </div>
            </div>
            <div class="bentoGrid">
                <div class="bentoCol">
                    <h2>Mes favoris</h2>
                    <!--Contenu des favoris Bento-->
                    <p>Fonctionnalité à venir.</p>
                </div>
                <div class="bentoCol">
                    <h2>Mes derniers votes</h2>
                    <!--Contenu des favoris Recettes-->
                    <p>Fonctionnalité à venir.</p>
                </div>
            </div>
        </div>
    </div>