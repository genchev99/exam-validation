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
  <link href="../global_style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../questions/style.css">
  <link rel="stylesheet" href="style.css">


  <script src="script.js"></script>
</head>

<body class="loggedin">
  <?php include('../navigation.php'); ?>
  <div>
    <div class="content">
      <h2>Рецензия</h2>

      <div id="referat-select">
        <span class="custom-dropdown big">
          <label for="referat">Избор на реферат</label>
          <select id="referat">
            <option>Unloaded</option>
          </select>
        </span>
      </div>

      <div id="root" class="generator">
        <div class="group">
          <ol id="questions"></ol>
        </div>
      </div>
    </div>
</body>

</html>