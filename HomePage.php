<?php 
require_once('config.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Answer | Home</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container">
        <h1>Who Wants to Be a Millionaire?</h1>
        
        <?php if (isset($_SESSION['user'])): ?>
            <p>Welcome back, <strong><?php echo $_SESSION['user']; ?></strong>!</p>
            <form action="game_init.php" method="POST">
                <button type="submit" name="start">Start New Game</button>
            </form>
            <a href="leaderboard.php">View Leaderboard</a> | 
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <p>Ready to test your knowledge?</p>
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>
        <?php endif; ?>
    </div>
</body>
</html>