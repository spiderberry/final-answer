<?php
require_once('config.php');
// Source - https://stackoverflow.com/a/21429652
// Posted by Fancy John, modified by community. See post 'Timeline' for change history
// Retrieved 2026-04-14, License - CC BY-SA 4.0

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        if (isUsernameTaken($username)) {
            $error = "Username is already taken!";
        } else {
            $user_data = $username . "|" . $password . PHP_EOL;

            $dir = __DIR__ . "/data";
            if (!is_dir($dir)) {
                mkdir($dir);
            }

            if (file_put_contents($dir . '/users.txt', $user_data, FILE_APPEND)) {
                $_SESSION['user'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "System error. Please try again.";
            }
        }
    } else {
                $error = "All fields are required!";
            
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Answer | Register</title>
    <link rel="stylesheet" href="GameShow.css">
</head>
<body>
    <div class="auth-container">
        <h2>Join Team Billionaire</h2>
        <?php if ($error): ?>
            <p class="error" style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Username" required 
                   value="<?php echo isset($_POST['username']) ? sanitize($_POST['username']) : ''; ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Create Account</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>