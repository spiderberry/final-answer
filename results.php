<?php
require_once 'config.php';
checkAuth();

$final_money = $_SESSION['money'] ?? 0;
$user = $_SESSION['user'];
$date = date("Y-m-d");

$entry = "$user|$final_money|$date" . PHP_EOL;
file_put_contents(__DIR__ . '/data/leaderboard.txt', $entry, FILE_APPEND);

unset($_SESSION['question_index']);
unset($_SESSION['money']);
unset($_SESSION['tier']);
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
        <p>Congratulations, <strong><?php echo sanitize($user); ?></strong>!</p>
        <p>You walked away with: <strong>$<?php echo number_format($final_money); ?></strong></p>
        
        <div class="actions">
            <a href="game-logic.php" class="btn">Play Again</a>
            <a href="leaderboard.php" class="btn">View Leaderboard</a>
            <a href="index.php" class="btn">Home</a>
        </div>
    </div>
</body>
</html>