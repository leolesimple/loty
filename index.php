<?php
require __DIR__ . '/includes/config.php';

include __DIR__ . '/includes/nav.php';
$basePath = '/loty';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

$uri = trim($uri, '/');

if ($uri === '') {
    $page = 'home';
} else {
    $page = $uri;
}

$page = str_replace('..', '', $page);

$file = __DIR__ . '/pages/' . $page . '.php';

if (file_exists($file)) {
    require $file;
    exit;
}

http_response_code(404);
require __DIR__ . '/pages/404.php';

include __DIR__ . '/includes/footer.php';