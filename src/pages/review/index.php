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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Рецензия</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../questions/style.css">
  <link rel="stylesheet" href="style.css">


  <script src="script.js"></script>
</head>

<body class="loggedin">
  <div>
    <nav class="navtop">
      <div>
        <h1>Puffin Въпросник</h1>
        <a href="profile.php"><i class="fas fa-user-circle"></i>Моят профил</a>
        <a href="../../logout.php"><i class="fas fa-sign-out-alt"></i>Изход</a>
      </div>
    </nav>
    <div class="content">
      <h2>Рецензия</h2>
      <div id="root" class="generator">
        <div class="group">
          <ol id="questions"></ol>
        </div>
      </div>
    </div>
</body>

</html>