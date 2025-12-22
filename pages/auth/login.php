<?php
// Démarrage de la session avec paramètres de cookie sécurisés.
// Si l'utilisateur coche "Se souvenir de moi", on prolongera la durée du cookie de session.
require_once __DIR__ . '/../../includes/config.php';

// Fallback : si includes/config.php n'a pas défini $conn (ou pour satisfaire l'analyse statique),
// créer une connexion PDO avec les mêmes variables si elles existent, sinon des valeurs par défaut.
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
        error_log('DB connect fallback error: ' . $e->getMessage());
        // Ne pas exposer les détails ; afficher un message générique et arrêter.
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

if (isset($_POST["submit_login"])) {
    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? '';
    $remember = isset($_POST['remember_me']);

    if ($username === '' || $password === '') {
        $error = "Veuillez saisir nom d'utilisateur et mot de passe.";
    } else {
        try {
            // Utiliser la connexion PDO fournie par includes/config.php ($conn)
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username LIMIT 1");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe
            if ($user && password_verify($password, $user['motdepasse'])) {
                // Bonne pratique : régénérer l'ID de session après connexion
                session_regenerate_id(true);

                // Stocker les informations essentielles en session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Si le hash du mot de passe est obsolète, le re-hasher
                if (password_needs_rehash($user['motdepasse'], PASSWORD_DEFAULT)) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $update = $conn->prepare('UPDATE user SET motdepasse = :pass WHERE id = :id');
                    $update->execute([':pass' => $newHash, ':id' => $user['id']]);
                }

                // Redirection après connexion
                header("Location: /loty/dashboard");
                exit();
            } else {
                // Échec de la connexion
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            // Ne pas exposer l'erreur aux utilisateurs ; la logguer côté serveur
            error_log('Login error: ' . $e->getMessage());
            $error = 'Erreur serveur, réessayez plus tard.';
            echo $e->getMessage();
        }
    }
}

$hash = password_hash('040506', PASSWORD_DEFAULT);
echo $hash;
?>
<h2>Connexion</h2>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="POST" action="">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
    <br>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label>
        <input type="checkbox" name="remember_me" value="1" <?php echo (isset($remember) && $remember) ? 'checked' : ''; ?>> Se souvenir de moi
    </label>
    <br>
    <button type="submit" name="submit_login">Se connecter</button>
</form>
