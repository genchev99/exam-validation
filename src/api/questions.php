<?php
require_once __DIR__ . "/../database/models/question.php";
require_once __DIR__ . "/../database/models/token.php";
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
  $req_url = $_SERVER['REQUEST_URI'];
  $user_id = $_SESSION['user_id'];

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $question_model = new QuestionModel();
    echo json_encode(["success" => true, "data" => $question_model->select_by_user_id($user_id)], JSON_UNESCAPED_UNICODE);
    return;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $question_model = new QuestionModel();
    $body = json_decode(file_get_contents('php://input'), true);

    if (!isset($body['property'])) {
      http_response_code(400);
      die(400);
    }

    $property = $body['property'];
    $question_id = $body['questionId'];
    $new_value = $body['newValue'];

    if (!$question_model->is_owner($user_id, $question_id)) {
      http_response_code(403);
      die(403);
    }

    if (!in_array($property, array('question', 'purpose_of_question', 'response_on_incorrect', 'response_on_correct', 'note'))) {
      http_response_code(400);
      die(400);
    }

    $question_model->update_column($question_id, $property, $new_value);
    echo json_encode(["success" => true]);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $question_model = new QuestionModel();
    $body = json_decode(file_get_contents('php://input'), true);

    if (!isset($body['questionId'])) {
      http_response_code(400);
      die(400);
    }

    $question_id = $body['questionId'];

    if (!$question_model->is_owner($user_id, $question_id)) {
      http_response_code(400);
      die(403);
    }

    $question_model->delete($question_id);
    echo json_encode(["success" => true]);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
     * Creates an empty question in the database
     */
    $question_model = new QuestionModel();

    $question_model->create_empty($user_id);
    echo json_encode(["success" => true]);
  }
}

handle();
