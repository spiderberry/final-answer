<?php
    require_once 'config.php';

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
    // initialize game state
    if (!isset($_SESSION['question_index'])) {
        $_SESSION['question_index'] = 0;
        $_SESSION['score'] = 0;
    }

    // load questions from JSON file and turns into an array
    $questions = json_decode(file_get_contents('data/easy-questions.json'), true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
        $current = $_SESSION['question_index'];
        $question = $questions[$current];

        $selected = $_POST['answer'];

        if ($selected == $question['correct']) {
            $_SESSION['score'] += 100;
            $_SESSION['question_index']++;
        } 

        else {
            echo "Game Over";
            session_destroy();
            exit;
        }

        header("Location: game-logic.php");
        exit();
    }

    $current = $_SESSION['question_index'];
    $question = $questions[$current];


    echo "<h1>{$_SESSION['user']}'s Game</h1>";
    echo "<h2>{$question['question']}</h2>";
    echo "<p>Score: {$_SESSION['score']}</p>";

    foreach ($question['answers'] as $index => $answer) {
        echo "<form method='POST'>
                <button name='answer' value='$index'>$answer</button>
            </form>";
    }
?>
