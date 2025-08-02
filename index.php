<?php
require_once __DIR__ . '/config/config.php';

header("Location: " . INDEX_LOGIN_PAGE);
?>
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login Page</h2>
    <form method="post" action="modules/auth/login_process.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html> -->
