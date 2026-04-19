<?php
require_once 'config.php';
checkAuth();

$p1_final = $_SESSION['p1_money'] ?? 0;
$p2_final = $_SESSION['p2_money'] ?? 0;
$user = $_SESSION['user'];
$date = date("Y-m-d");

$total_score = $p1_final + $p2_final;
$entry = "$user|$total_score|$date" . PHP_EOL;
file_put_contents(__DIR__ . '/data/leaderboard.txt', $entry, FILE_APPEND);

if ($p1_final > $p2_final) {
    $winnerText = "Player 1 Wins!";
    $winnerColor = "#FB8500"; 
} elseif ($p2_final > $p1_final) {
    $winnerText = "Player 2 Wins!";
    $winnerColor = "#219EBC";
} else {
    $winnerText = "It's a Tie!";
    $winnerColor = "#FFB703";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Answer | Results</title>
    <link rel="stylesheet" href="GameShow.css">
</head>
<body>
    <div class="container">
        <h1>Game Over!</h1>
        
        <h2 style="color: <?= $winnerColor ?>; font-size: 3rem; margin-bottom: 20px;">
            <?= $winnerText ?>
        </h2>

        <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; margin-bottom: 30px;">
            <p style="font-size: 1.5rem;">Player 1 Total: <strong style="color: #FB8500;">$<?= number_format($p1_final) ?></strong></p>
            <p style="font-size: 1.5rem;">Player 2 Total: <strong style="color: #219EBC;">$<?= number_format($p2_final) ?></strong></p>
        </div>
        
        <div class="actions">
            <form action="game-logic.php" method="POST" style="display: inline;">
                <input type="hidden" name="reset" value="true">
                <button type="submit" class="btn">Play Again</button>
            </form>
            <a href="leaderboard.php" class="btn">View Leaderboard</a>
            <a href="index.php" class="btn">Home</a>
        </div>
    </div>
</body>
</html>