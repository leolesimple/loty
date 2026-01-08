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
} elseif ($page === 'logout') {
    $file = __DIR__ . '/pages/auth/logout.php';
} elseif ($page === 'dashboard') {
    $file = __DIR__ . '/pages/dashboard/dashboard.php';
} else {
    $file = __DIR__ . '/pages/' . $page . '.php';
}

//echo $file;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include __DIR__ . '/includes/meta.php';
    ?>
    <!-- <link rel="stylesheet" href="/assets/css/temp.css"> -->
    <link rel="stylesheet" href="/assets/css/main.css">
    <title>LOTY</title>
</head>
<body>

<header>
    <?php include __DIR__ . '/includes/nav.php'; ?>
</header>

<main id="content">
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
