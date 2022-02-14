<?php
require_once __DIR__ . "/../database/models/option.php";
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

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $option_model = new OptionModel();
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['optionId']) or !isset($body['newValue'])) {
            die(400);
        }

        // TODO check if the user owns the question
        $question_id = $body['questionId'];
        $option_id = $body['optionId'];
        $new_value = $body['newValue'];

        $option_model->update_option($option_id, $new_value);
        echo json_encode(["success" => true]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $option_model = new OptionModel();
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['optionId'])) {
            die(400);
        }

        // TODO check if the user owns the question
        $option_id = $body['optionId'];

        $option_model->delete($option_id);
        echo json_encode(["success" => true]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $option_model = new OptionModel();
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['questionId'])) {
            die(400);
        }

        // TODO check if the user owns the question
        $question_id = $body['questionId'];

        $option_model->create_empty($question_id);
        echo json_encode(["success" => true]);
    }
}

handle();
