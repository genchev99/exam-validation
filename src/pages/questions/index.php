<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_COOKIE['token'])) {
    header('Location: /pages/login/index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Въпроси</title>

    <script defer src="./script.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>Puffin Въпросник</h1>
        <a href="profile.php"><i class="fas fa-user-circle"></i>Моят профил</a>
        <a href="../../logout.php"><i class="fas fa-sign-out-alt"></i>Изход</a>
    </div>
</nav>
<div class="content">
    <h2>Мойте въпроси</h2>
    <div id="root" class="generator">
        <div class="group">
            <button class="btn-info" onclick="addQuestion()">Добавяне на въпрос</button>
            <ol id="questions"></ol>
        </div>
    </div>
</div>
</body>
</html>
