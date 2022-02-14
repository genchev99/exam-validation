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

function handle() {
    header('Content-Type: application/json');
    $req_url = $_SERVER['REQUEST_URI'];

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $question_model = new QuestionModel();
        echo json_encode(["success" => true, "data" => $question_model->select()], JSON_UNESCAPED_UNICODE);
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $question_model = new QuestionModel();
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['property'])) {
            die(400);
        }

        $property = $body['property'];
        $question_id = $body['questionId'];
        $new_value = $body['newValue'];

        // TODO: add validation if the auth user is the owner of the question

        if (!in_array($property, array('question', 'purpose_of_question', 'response_on_incorrect', 'response_on_correct', 'note'))) {
            die(400);
        }

        $question_model->update_column($question_id, $property, $new_value);
    }
}

handle();
