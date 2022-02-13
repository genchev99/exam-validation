<?php
require_once __DIR__ . "/database/models/user.php";


$u = new UserModel();
$res = $u->select_by_username("test");
print_r($res);
echo PHP_EOL;
