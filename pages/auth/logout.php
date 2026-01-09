<?php
require_once __DIR__ . '/../../includes/utilities/auth.php';

check_logged_in();

session_start();

$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
header("Location: /login?message=logged_out");
exit();
?>