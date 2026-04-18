<?php
require_once 'Config.php';
checkAuth();

$leaderboard_file = __DIR__ . 'data/leaderboard.txt';
$scores = [];

if (file_exists($leaderboard_file)) {
    $lines = file($leaderboard_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        list($username, $score, $date) = explode('|', $line);
        $scores[] = [
            'username' => sanitize($username),
            'score' => (int)$score,
            'date' => $date
        ];
    }

    usort($scores, function($a, $b) {
        return $b['score'] <=> $a['score'];
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Millionaire | Leaderboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Global Leaderboard</h1>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Player</th>
                    <th>Money Earned</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($scores)): ?>
                    <tr><td colspan="4">No scores yet. Be the first!</td></tr>
                <?php else: ?>
                    <?php foreach (array_slice($scores, 0, 10) as $rank => $entry): ?>
                        <tr>
                            <td><?php echo $rank + 1; ?></td>
                            <td><?php echo $entry['username']; ?></td>
                            <td>$<?php echo number_format($entry['score']); ?></td>
                            <td><?php echo $entry['date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>