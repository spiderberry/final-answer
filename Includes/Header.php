<?php
require_once(__DIR__ . '/../Config.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Final Answer | Millionaire Trivia</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <nav>
        <div class="container">
            <a href="index.php" class="logo">Final Answer</a>
            <div class="nav-links">
                <?php if (isset($_SESSION['user'])): ?>
                    <span>Player: <?php echo sanitize($_SESSION['user']); ?></span>
                    <a href="leaderboard.php">Leaderboard</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container">