<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is already logged in redirect to the index page...
if (isset($_COOKIE['token'])) {
    header('Location: /pages/home/index.php');
    exit;
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta chareset="utf-8"/>

    <title>Login</title>

    <script defer src="./script.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body>
<div class="login">
    <h1>Login</h1>
    <div id="errors" class="isa_error"></div>
    <form id="login-form">
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" placeholder="Username" id="username" required>
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
