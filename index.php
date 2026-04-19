<?php 
include('includes/header.php'); 
?>
<div class="container">
    <h1>Who Wants to Be a Millionaire?</h1>
    <?php if (isset($_SESSION['user'])): ?>
        <p>Welcome back, <strong><?php echo sanitize($_SESSION['user']); ?></strong>!</p>
        <form action="game-logic.php" method="POST">
            <input type="hidden" name="reset" value="true">
            <button type="submit" class="btn">Start New Game</button>
        </form>
        <a href="leaderboard.php">View Leaderboard</a> | 
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>
    <?php endif; ?>
</div>
<?php include('includes/footer.php'); ?>