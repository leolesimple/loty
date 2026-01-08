<?php
require_once __DIR__ . '/../../includes/utilities/db.php';

if (isset($_GET['error'])) {
    $error_code = $_GET['error'];
    $error_messages = [
            'logged_out' => "Vous avez été déconnecté avec succès.",
            'logged_in' => "Vous êtes déjà connecté.",
            'registered' => "Inscription réussie. Vous pouvez maintenant vous connecter.",
    ];
    if (array_key_exists($error_code, $error_messages)) {
        echo "<p class='error-message' aria-live='polite' aria-atomic='true'>" . clean($error_messages[$error_code]) . "</p>";
    }
}

if (!isset($conn) || !($conn instanceof PDO)) {
    try {
        $host = $host ?? 'localhost';
        $db = $db ?? 'loty';
        $user = $user ?? 'root';
        $pass = $pass ?? '';
        $charset = $charset ?? 'utf8mb4';
        if (!isset($dsn)) {
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        }
        $conn = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        die('Erreur serveur, réessayez plus tard.');
    }
}

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
$cookieParams = session_get_cookie_params();
$lifetime = 0;
if (isset($_POST['submit_login']) && isset($_POST['remember_me'])) {
    $lifetime = 30 * 24 * 60 * 60;
}
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => $cookieParams['path'],
    'domain' => $cookieParams['domain'],
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

if ($_SESSION['user_id'] ?? false) {
    header("Location: /profil?error=logged_in");
    exit();
}

if (isset($_POST["submit_login"])) {
    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? '';
    $remember = isset($_POST['remember_me']);

    if ($username === '' || $password === '') {
        $error = "Veuillez saisir nom d'utilisateur et mot de passe.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username LIMIT 1");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['motdepasse'])) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                if (password_needs_rehash($user['motdepasse'], PASSWORD_DEFAULT)) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $update = $conn->prepare('UPDATE user SET motdepasse = :pass WHERE id = :id');
                    $update->execute([':pass' => $newHash, ':id' => $user['id']]);
                }

                header("Location: /profil");
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            error_log('Login error: ' . $e->getMessage());
            $error = 'Erreur serveur, réessayez plus tard.';
            echo $e->getMessage();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <title>Document</title>
</head>
<body>
    
<nav>
    <div class="top_nav">
        <div></div>
        <a href="/">
            <img src="../../assets/img/LOTY_Logo.svg" class="nav_logo">
            <span class="sr-only">Aller à l'accueil</span>
        </a>
        
        <div class="nav_actions">
            <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="/profil">
                    <img src="/assets/icons/accounts-icon.svg" alt="" class="profile_icon">
                    <span class="sr-only">Voir mon compte</span>
                  </a>';
        } else {
            echo '';
        }
        ?>
            <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="/panier" class="nav-button-link">
                    <p class="button-text">Panier</p>
                  </a>';
        } else {
            echo '<a href="/login">
                    <p class="btn_red btn">S\'IDENTIFIER</p>
                  </a>';
        }
        ?>
        </div>
    </div>
    <div class="bottom_nav">
        <ul>
            <li><a>ACCUEIL</a></li>
            <li><a class="blueText">BENTO</a></li>
            <li><a>RECETTES</a></li>
            <li><a>PODIUM</a></li>
        </ul>
    </div>
</nav>

<section class="login_container">
<h2>Connexion</h2>
<p>Pas encore de compte ? <a href="/register">Inscrivez-vous</a>.</p>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo clean($error); ?></p>
<?php endif; ?>
<form method="POST" action="" class="login_form">
    <label for="username">Nom d'utilisateur*</label><br>
    <input type="text" id="username" name="username" required value="<?php echo isset($username) ? clean($username) : ''; ?>">
    <br>
    <label for="password">Mot de passe*</label><br>
    <input type="password" id="password" name="password" required>
    <br>
    <label class="remember_me">
        <input type="checkbox" name="remember_me" value="1" <?php echo (isset($remember) && $remember) ? 'checked' : ''; ?>> Se souvenir de moi
    </label>
    <br>
    <button class="btn btn_red" type="submit" name="submit_login">SE CONNECTER</button>
</form>
</section>



</body>
</html>

