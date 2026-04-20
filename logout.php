// Source - https://stackoverflow.com/a/3512570
// Posted by Freyja
// Retrieved 2026-04-16, License - CC BY-SA 2.5

<?php

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
header("Location: index.php");
exit();
?>