<?php
global $conn;
require_once __DIR__ . '/../../includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

// Affichage des erreurs éventuelles
// Aller chercher dans la base de données SQL l'id de l'erreur passée en paramètre GET "error"
if (isset($_GET['error'])) {
    $error_code = $_GET['error'];
    $error_messages = [
            'logged_in' => "Vous êtes déjà connecté.",
    ];
    if (array_key_exists($error_code, $error_messages)) {
        echo "<p class='error-message' aria-live='polite' aria-atomic='true'>" . htmlspecialchars($error_messages[$error_code]) . "</p>";
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
            <h2>' . htmlspecialchars($user_data[0]["nom"]) . " " . htmlspecialchars($user_data[0]["prenom"]) . '</h2>
            <span class="registerDate">Inscrit depuis le : ' . htmlspecialchars(date("d/m/Y", strtotime($user_data[0]["date_creation"]))) . '</span>
            <p>' . htmlspecialchars($user_data[0]["bio"]) . '</p>
        </div>
        <a class="editProfileButton" href="/profil/edit">
            <img src="/assets/icons/pen.svg" alt="" width="24" height="24">
            <span class="sr-only">Éditer le profil</span>
        </a>
        <a class="editProfileButton" href="/logout">
            <img src="/assets/icons/logout.svg" alt="" width="24" height="24">
            <span class="sr-only">Se déconnecter</span>
        </a>
    </section>';


// Layout avec variables prêtes à l'emploi
function renderBentoItem(string $image, string $title, string $description): string
{
    return '
    <div class="bentoItem">
        <img src="' . $image . '" alt="" width="215" height="215" class="bentoImage">
        <div class="bentoInfo">
            <h3>' . $title . '</h3>
            <p>' . $description . '</p>
        </div>
        <img src="assets/icons/chevron-right.svg" alt="" width="auto" height="24" class="chevronIcon">
    </div>';
}


function generateBentoLayout($count): string
{
    global $conn;
    $bentoLayout = '';
    $bento_query = $conn->prepare("SELECT id_bento, bento_nom, description FROM bento WHERE id_user = ? ORDER BY id_bento DESC LIMIT ?");
    $bento_query->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $bento_query->bindValue(2, $count, PDO::PARAM_INT);
    $bento_query->execute();
    $bento_items = $bento_query->fetchAll();
    foreach ($bento_items as $bento) {
        $image = '/assets/img/bento-default.png';
        $title = $bento['bento_nom'];
        $description = $bento['description'];
        $bentoLayout .= renderBentoItem($image, htmlspecialchars($title), htmlspecialchars($description));
    }
    return $bentoLayout;
}

function renderRecetteItem(string $image, string $title): string
{
    return '
    <div class="recetteItem">
        <img src="' . $image . '" alt="" width="215" height="215" class="recetteImage">
        <div class="recetteInfo">
            <h3>' . $title . '</h3>
        </div>
        <img src="assets/icons/chevron-right.svg" alt="" width="auto" height="24" class="chevronIcon">
    </div>';
}

function generateRecetteLayout($count): string
{
    global $conn;
    $recetteLayout = '';
    $recette_query = $conn->prepare("SELECT id_recette, recette_nom FROM recette WHERE id_user = ? ORDER BY id_recette DESC LIMIT ?");
    $recette_query->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $recette_query->bindValue(2, $count, PDO::PARAM_INT);
    $recette_query->execute();
    $recette_items = $recette_query->fetchAll();
    foreach ($recette_items as $recette) {
        $image = '/assets/img/recette-default.png';
        $title = $recette['recette_nom'];
        $recetteLayout .= renderRecetteItem($image, htmlspecialchars($title));
    }
    return $recetteLayout;
}

?>
<main>
    <style>
        a.editProfileButton {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 10px;
            background-color: #E94141;
            color: #F9F2E8;
            text-decoration: none;
            border-radius: 9px 9px 0 0;
            margin-top: 15px;

        }
    </style>
    <h1>Mon Profil</h1>
    <p>Nom d'utilisateur : <?php echo htmlspecialchars($_SESSION['username']); ?></p>
    <?php echo $profileCardTemplate; ?>
    <div class="faceTofaceContainer">
        <div class="bentoLayout">
            <div class="bentoGrid">
                <div class="bentoCol">
                    <h2>Mes créations Bento</h2>
                    <?php echo generateBentoLayout(3); ?>
                    <!--Voir plus de bento-->
                    <a class="seeMoreButton" href="/profil/bento">
                        <span>Voir plus de Bento</span>
                    </a>
                </div>
                <div class="bentoCol">
                    <h2>Mes recettes</h2>
                    <?php echo generateRecetteLayout(3); ?>
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
</main>
