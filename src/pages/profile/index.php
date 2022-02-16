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
    <title>Профил</title>
    <script defer src="./script.js"></script>

    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="../global_style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="loggedin">

<?php include('../navigation.php'); ?>

<div class="content">
    <h2>Профил</h2>
    <div class="wrapper">
        <div class="card">
            <h1 id="name">Зареждане...</h1>
            <p class="title" id="fn">Зареждане...</p>
            <p>ФМИ, СУ Софийски Университет “Св. Климент Охридски”</p>
            <p id="created-at">Зареждане...</p>

        </div>
        <?php if ($_SESSION['is_admin']) { ?>
            <button id="export" class="btn-info" onclick="handleOnClickExport()">Екоспортиране на всички въпроси</button>
        <?php } ?>
    </div>
</div>
</body>

</html>
