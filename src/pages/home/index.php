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
    <title>Начало</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="../global_style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
</head>
<body class="loggedin">

<?php include('../navigation.php'); ?>

<div class="content">
    <h2>Начална Страница</h2>
    <p>Добре дошъл, <?= $_SESSION['username'] ?>!</p>
</div>
</body>
</html>
