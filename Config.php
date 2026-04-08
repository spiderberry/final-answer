<?php

session_start();

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function checkAuth() {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
}
?>