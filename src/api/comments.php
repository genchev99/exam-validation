<?php
require_once __DIR__ . "/../database/models/comment.php";
require_once __DIR__ . "/../database/models/token.php";
require_once __DIR__ . "/../utils.php";

session_start();



header('Content-Type: application/json');

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
    $comment_model = new CommentModel();

    if (!isset($_GET['question_id'])) {
      echo json_encode(["success" => true, "data" => $comment_model->select_all()], JSON_UNESCAPED_UNICODE);
      return;
    }
    $question_id = $_GET['question_id'];
    echo json_encode(["success" => true, "data" => $comment_model->select_by_question_id($question_id)], JSON_UNESCAPED_UNICODE);
    return;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_model = new CommentModel();
    $body = json_decode(file_get_contents('php://input'), true);

    if (!isset($body['questionId'])) {
      http_response_code(400);
      die(400);
    }

    $question_id = $body['questionId'];
    $comment = $body['comment'];

    $comment_model->create_comment($comment, $question_id, $user_id);
    echo json_encode(["success" => true]);
  }
}

handle();
