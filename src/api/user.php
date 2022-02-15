<?php
require_once __DIR__ . "/../database/models/user.php";
require_once __DIR__ . "/../database/models/token.php";
require_once __DIR__ . "/../utils.php";

session_start();

function handle()
{
  header('Content-Type: application/json');
  $user_id = $_SESSION['user_id'];
  $token_model = new TokenModel();

  if (!isset($_COOKIE['token']) or !$token_model->is_authorized($_COOKIE['token'], $user_id)) {
    http_response_code(401);
    exit("Unauthorized");
  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_model = new UserModel();
    echo json_encode(["success" => true, "data" => $user_model->select_profile($user_id)], JSON_UNESCAPED_UNICODE);
    return;
  }
}

handle();
