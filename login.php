<?php
require_once('config.php');
// Source - https://stackoverflow.com/a/21429652
// Posted by Fancy John, modified by community. See post 'Timeline' for change history
// Retrieved 2026-04-14, License - CC BY-SA 4.0

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = sanitize($_POST['username']);
        $password = $_POST['password'];

        $users_file = __DIR__ . "/data/users.txt";
        if (file_exists($users_file)) {
            $users = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($users as $user) {
                list($stored_username, $stored_password) = explode("|", $user);

                if ($stored_username === $username && $stored_password === $password) {
                    $_SESSION['user'] = $username;
                    header("Location: index.php");
                    exit();
                }
            }
        }
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Answer | Login</title>
    <link rel="stylesheet" href="GameShow.css">
</head>
<body>
    <div class="auth-container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error" style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required
                   value="<?php echo isset($_POST['username']) ? sanitize($_POST['username']) : ''; ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>