<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAuth() {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function inGame() {
    return isset($_SESSION['question_index']);
}

function updateScore($points) {
    if (isset($_SESSION['score'])) {
        $_SESSION['score'] += $points;
    }
}

function isUsernameTaken($username) {
    $users_file = realpath(__DIR__) . "/data/users.txt";
    if (file_exists($users_file)) {
        $users = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($users as $user) {
            $parts = explode("|", $user);
            if (count($parts) > 0 && strtolower(trim($parts[0])) === strtolower(trim($username))) {
                return true;
            }
        }
    }
    return false;
}