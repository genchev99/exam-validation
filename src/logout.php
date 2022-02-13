<?php
session_start();
session_destroy();
setcookie("token", "", time() - 3600);
// Redirect to the login page:
header('Location: /pages/login/index.php');
