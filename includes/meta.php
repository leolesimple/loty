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
        return "<title>" . clean($title) . "</title>\n";
    }

    function setDescription($description): string
    {
        return '<meta name="description" content="' . clean($description) . '">' . "\n";
    }

    function setKeywords($keywords): string
    {
        return '<meta name="keywords" content="' . clean($keywords) . '">' . "\n";
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
<meta property="og:title" content="LOTY">
<meta property="og:description" content="Avec LOTY : Explorez une sélection de Bento et de recettes. Ajoutez-les à votre panier, personnalisez les et générez votre liste de courses. Partagez vos créations Bento. Parcourez les Bento de la communautés et votez pour vos favoris.">
<meta property="og:url" content="https://loty.leolesimple.fr/">
<meta property="og:site_name" content="LOTY">
<meta property="og:image" content="https://loty.leolesimple.fr/assets/img/og-image.png">
<meta property="og:image:alt" content="LOTY - Votre plateforme de Bento personnalisés">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/img/favicon.ico">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://fonts.gstatic.com">

<link rel="stylesheet" href="/assets/css/app.css">

<meta name="referrer" content="strict-origin-when-cross-origin">

<meta name="color-scheme" content="light dark">
