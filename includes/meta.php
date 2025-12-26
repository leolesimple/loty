<?php
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
define('BASE_URL', $scheme . '://' . $_SERVER['HTTP_HOST']);
?>

<?php
    function getCanonicalUrl() {
        return BASE_URL . $_SERVER['REQUEST_URI'];
    }
    function setTitle($title): string
    {
        return "<title>" . htmlspecialchars($title) . "</title>\n";
    }

    function setDescription($description): string
    {
        return '<meta name="description" content="' . htmlspecialchars($description) . '">' . "\n";
    }

    function setKeywords($keywords): string
    {
        return '<meta name="keywords" content="' . htmlspecialchars($keywords) . '">' . "\n";
    }
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>LOTY</title>
<meta name="description" content="">
<meta name="keywords" content="bento, déjeuner, repas, livraison, entreprise, sain, frais, local">
<meta name="author" content="{{AUTHOR_NAME}}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="theme-color" content="#F9F2E8">
<meta name="robots" content="index,follow">
<link rel="canonical" href="<?php echo getCanonicalUrl(); ?>">

<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="LOTY">

<meta property="og:locale" content="fr_FR">
<meta property="og:type" content="website">
<meta property="og:title" content="{{OG_TITLE}}">
<meta property="og:description" content="{{OG_DESCRIPTION}}">
<meta property="og:url" content="{{PAGE_URL}}">
<meta property="og:site_name" content="{{SITE_TITLE}}">
<meta property="og:image" content="{{OG_IMAGE_URL}}">
<meta property="og:image:alt" content="{{OG_IMAGE_ALT}}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/icons/favicon.ico">
<link rel="shortcut icon" href="/assets/icons/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png">
<meta name="msapplication-TileColor" content="#F9F2E8">
<meta name="msapplication-TileImage" content="/assets/icons/mstile-150x150.png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://fonts.gstatic.com">

<link rel="stylesheet" href="/assets/css/app.css">

<meta name="referrer" content="strict-origin-when-cross-origin">

<meta name="color-scheme" content="light dark">
