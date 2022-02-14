<?php
require_once __DIR__ . "/../database/models/comment.php";
require_once __DIR__ . "/../utils.php";

session_start();

//$token_model = new TokenModel();
//if (!isset($_COOKIE['token']) or !$token_model->is_authorized($_COOKIE['token'])) {
//    http_response_code(401);
//    exit("Unauthorized");
//}

header('Content-Type: application/json');

function handle()
{
  header('Content-Type: application/json');
  $user_id = $_SESSION['user_id'];

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

    // if (!$question_model->is_owner($user_id, $question_id)) {
    //   http_response_code(403);
    //   die(403);
    // }

    $comment_model->create_comment($comment, $question_id, $user_id);
    echo json_encode(["success" => true]);
  }



  // if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  //   $option_model = new OptionModel();
  //   $body = json_decode(file_get_contents('php://input'), true);

  //   if (!isset($body['optionId']) or !isset($body['newValue'])) {
  //     http_response_code(400);
  //     die(400);
  //   }

  //   $option_id = $body['optionId'];
  //   $new_value = $body['newValue'];

  //   if (!$option_model->is_owner($user_id, $option_id)) {
  //     http_response_code(403);
  //     die(403);
  //   }

  //   $option_model->update_option($option_id, $new_value);
  //   echo json_encode(["success" => true]);
  // }

  // if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  //   $option_model = new OptionModel();
  //   $body = json_decode(file_get_contents('php://input'), true);

  //   if (!isset($body['optionId'])) {
  //     http_response_code(400);
  //     die(400);
  //   }

  //   $option_id = $body['optionId'];
  //   if (!$option_model->is_owner($user_id, $option_id)) {
  //     http_response_code(403);
  //     die(403);
  //   }

  //   $option_model->delete($option_id);
  //   echo json_encode(["success" => true]);
  // }

  // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //   $option_model = new OptionModel();
  //   $question_model = new QuestionModel();
  //   $body = json_decode(file_get_contents('php://input'), true);

  //   if (!isset($body['questionId'])) {
  //     http_response_code(400);
  //     die(400);
  //   }

  //   $question_id = $body['questionId'];

  //   if (!$question_model->is_owner($user_id, $question_id)) {
  //     http_response_code(403);
  //     die(403);
  //   }

  //   $option_model->create_empty($question_id);
  //   echo json_encode(["success" => true]);
  // }
}

handle();
