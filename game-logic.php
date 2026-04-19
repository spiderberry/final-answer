<?php
include('includes/header.php');
checkAuth(); 

if (isset($_POST['reset']) || !isset($_SESSION['question_number'])) {
    unset($_SESSION['current_tier_pool']);
    $_SESSION['question_number'] = 1;
    $_SESSION['question_index'] = 0;
    $_SESSION['money'] = 0;
    $_SESSION['lifelines'] = ['fifty' => true, 'reroll' => true, 'coin' => true];
    $_SESSION['used_tier_lifeline'] = false;
    unset($_SESSION['fifty_indices']);
}

$qNum = $_SESSION['question_number'];
if ($qNum <= 4) $tier = 1;
elseif ($qNum <= 8) $tier = 2;
elseif ($qNum <= 12) $tier = 3;
elseif ($qNum <= 16) $tier = 4;
elseif ($qNum <= 20) $tier = 5;
else $tier = 6;

$tierFile = "data/tier-{$tier}-questions.json";
if (!isset($_SESSION['current_tier_pool'])) {
    if (file_exists($tierFile)) {
        $json_data = file_get_contents($tierFile);
        $questions = json_decode($json_data, true);
        if ($questions) {
            shuffle($questions);
            $_SESSION['current_tier_pool'] = $questions;
        }
    }
}

if (!isset($_SESSION['current_tier_pool']) || !isset($_SESSION['current_tier_pool'][$_SESSION['question_index']])) {
    header("Location: index.php");
    exit();
}

$currentQuestion = $_SESSION['current_tier_pool'][$_SESSION['question_index']];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['lifeline']) && $_POST['lifeline'] === 'fifty') {
        if ($_SESSION['lifelines']['fifty'] && !$_SESSION['used_tier_lifeline']) {
            $correctIndex = $currentQuestion['correct'];
            $options = array_keys($currentQuestion['answers']);
            unset($options[$correctIndex]);
            $wrongToKeep = array_rand($options);
            $_SESSION['fifty_indices'] = [$correctIndex, $wrongToKeep];
            $_SESSION['lifelines']['fifty'] = false;
            $_SESSION['used_tier_lifeline'] = true;
        }
    }

    if (isset($_POST['answer'])) {
        if ($_POST['answer'] == $currentQuestion['correct']) {
            $_SESSION['money'] += (1000 * $tier);
            $_SESSION['question_number']++;
            $_SESSION['question_index']++;
            unset($_SESSION['fifty_indices']);

            if (($_SESSION['question_number'] - 1) % 4 == 0) {
                unset($_SESSION['current_tier_pool']);
                $_SESSION['question_index'] = 0;
                $_SESSION['used_tier_lifeline'] = false;
            }
            
            if ($_SESSION['question_number'] > 21) {
                header("Location: results.php");
            } else {
                header("Location: game-logic.php");
            }
            exit();
        } else {
            header("Location: results.php");
            exit();
        }
    }
}
?>

<div class="game-container">
    <div class="stats-bar">
        <span>Question <?= $_SESSION['question_number'] ?> / 21</span> | 
        <span class="money-display">Money Earned: $<?= number_format($_SESSION['money']) ?></span>
    </div>

    <h2><?= htmlspecialchars($currentQuestion['question']) ?></h2>

    <div class="lifeline-area">
        <form method="POST">
            <?php if ($_SESSION['lifelines']['fifty'] && !$_SESSION['used_tier_lifeline']): ?>
                <button type="submit" name="lifeline" value="fifty" class="btn">Use 50-50</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="answers">
        <?php foreach ($currentQuestion['answers'] as $index => $answer): ?>
            <?php 
                $hide = isset($_SESSION['fifty_indices']) && !in_array($index, $_SESSION['fifty_indices']);
            ?>
            <form method="POST" style="<?= $hide ? 'visibility:hidden;' : '' ?>">
                <button name="answer" value="<?= $index ?>">
                    <?= htmlspecialchars($answer) ?>
                </button>
            </form>
        <?php endforeach; ?>
    </div>
</div>
<?php include('includes/footer.php'); ?>