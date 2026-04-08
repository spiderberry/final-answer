<?php
require_once('config.php');

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $user_data = $username . "|" . $password . PHP_EOL;

        if (file_put_contents('users.txt', $user_data, FILE_APPEND)) {
            $_SESSION['user'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "System error. Please try again.";
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Join Team Billionaire</h2>
        <?php if ($error): ?>
            <p class="error" style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Choose Username" required 
                   value="<?php echo isset($_POST['username']) ? sanitize($_POST['username']) : ''; ?>">
            <input type="password" name="password" placeholder="Choose Password" required>
            <button type="submit">Create Account</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>