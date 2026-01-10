<?php
require_once __DIR__ . '/includes/utilities/helpers.php';
$basePath = '/loty';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

$uri = trim($uri, '/');
$page = ($uri === '') ? 'home' : $uri;
$page = str_replace('..', '', $page);
$isConnected = isset($_SESSION['user_id']);
$userId = $isConnected ? $_SESSION['user_id'] : null;

//echo $page;

if ($page !== 'login') {
    session_start();
}

if ($page === 'login') {
    $file = __DIR__ . '/pages/auth/login.php';
} elseif ($page === 'register') {
    $file = __DIR__ . '/pages/auth/register.php';
} elseif ($page === 'profil') {
    $file = __DIR__ . '/pages/auth/profil.php';
} elseif ($page === 'profil/edit') {
    $file = __DIR__ . '/pages/auth/edit.php';
} elseif ($page === 'logout') {
    $file = __DIR__ . '/pages/auth/logout.php';
} elseif ($page === 'dashboard') {
    $file = __DIR__ . '/pages/dashboard/dashboard.php';
} else {
    $file = __DIR__ . '/pages/' . $page . '.php';
}

// Ajout au panier des bentos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {

    header('Content-Type: application/json; charset=utf-8');

    if (
            empty($_POST['bento_id']) ||
            empty($_POST['bento_nom'])
    ) {
        echo json_encode(['status' => 'error']);
        exit();
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $id = (int)$_POST['bento_id'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
                'id' => $id,
                'nom' => $_POST['bento_nom'],
                'quantity' => 1
        ];
    }

    echo json_encode([
            'status' => 'ok',
            'quantity' => $_SESSION['cart'][$id]['quantity']
    ]);
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include __DIR__ . '/includes/meta.php';
    ?>
    <link rel="stylesheet" href="/assets/css/main.css">
    <?php
    if (str_starts_with($page, 'admin')) {
        echo '<link rel="stylesheet" href="/assets/css/admin.css">';
    }

    if ($page === 'home') {
        echo '<link rel="stylesheet" href="/assets/css/home.css">';
    } else if ($page === 'recettes/add') {
        echo '<link rel="stylesheet" href="/assets/css/add-recette.css">';
    } else if ($page === 'profil/edit') {
        echo '<link rel="stylesheet" href="/assets/css/edit-profile.css">';
    }

    $classMain = '';
    if ($page === 'bento') {
        $classMain = 'bentoPage';
    }
    ?>
    <title>LOTY</title>
</head>
<body>
<a href="#content" class="skip-link">Aller au contenu principal</a>
<header>
    <?php include __DIR__ . '/includes/nav.php'; ?>
</header>

<main class="<?= $classMain ?>" id="content">
    <?php
    if (file_exists($file)) {
        require $file;
    } else {
        http_response_code(404);
        require __DIR__ . '/pages/404.php';
    }
    ?>
</main>

<footer>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</footer>

</body>
</html>
