<?php
include('includes/header.php');
checkAuth(); 

if (isset($_POST['reset']) || !isset($_SESSION['question_number'])) {
    unset($_SESSION['current_tier_pool']);
    $_SESSION['question_number'] = 1;
    $_SESSION['question_index'] = 0;
    $_SESSION['p1_money'] = 0;
    $_SESSION['p2_money'] = 0;
    $_SESSION['current_turn'] = 1;
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
        $questions = json_decode(file_get_contents($tierFile), true);
        shuffle($questions);
        $_SESSION['current_tier_pool'] = $questions;
    } else {
        die("Error: Missing $tierFile");
    }
}

if (!isset($_SESSION['current_tier_pool'][$_SESSION['question_index']])) {
    unset($_SESSION['current_tier_pool']);
    $_SESSION['question_index'] = 0;
    header("Location: game-logic.php");
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
            $reward = 1000 * $tier;
            if ($_SESSION['current_turn'] == 1) {
                $_SESSION['p1_money'] += $reward;
            } else {
                $_SESSION['p2_money'] += $reward;
            }

            $_SESSION['question_number']++;
            $_SESSION['question_index']++;
            $_SESSION['current_turn'] = ($_SESSION['current_turn'] == 1) ? 2 : 1;
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
        <div style="margin-bottom: 15px;">
            <span style="color: var(--amber-flame); font-size: 1.6rem; font-weight: 900;">
                PLAYER <?= $_SESSION['current_turn'] ?>'s TURN
            </span>
        </div>
        <span>Question <?= $_SESSION['question_number'] ?> / 21</span> | 
        <span>P1: <span class="money-display">$<?= number_format($_SESSION['p1_money']) ?></span></span> | 
        <span>P2: <span class="money-display">$<?= number_format($_SESSION['p2_money']) ?></span></span>
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
            <?php $hide = isset($_SESSION['fifty_indices']) && !in_array($index, $_SESSION['fifty_indices']); ?>
            <form method="POST" style="<?= $hide ? 'visibility:hidden;' : '' ?>">
                <button name="answer" value="<?= $index ?>">
                    <?= htmlspecialchars($answer) ?>
                </button>
            </form>
        <?php endforeach; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>