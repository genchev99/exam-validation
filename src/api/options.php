<?php
require_once __DIR__ . "/../database/models/option.php";
require_once __DIR__ . "/../database/models/question.php";
require_once __DIR__ . "/../database/models/token.php";
require_once __DIR__ . "/../utils.php";

session_start();

header('Content-Type: application/json');

function handle() {
    $user_id = $_SESSION['user_id'];
    $token_model = new TokenModel();
    /*
     * Checks if the use is authorized
     * */
    if (!isset($_COOKIE['token']) or !$token_model->is_authorized($_COOKIE['token'], $user_id)) {
        http_response_code(401);
        exit("Unauthorized");
    }

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $option_model = new OptionModel();
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['optionId'])) {
            http_response_code(400);
            die(400);
        }

        $option_id = $body['optionId'];

        if (!$option_model->is_owner($user_id, $option_id)) {
            http_response_code(403);
            die(403);
        }

        if (isset($body['newValue'])) {
            $new_value = $body['newValue'];
            $option_model->update_option($option_id, $new_value);
            echo json_encode(["success" => true]);
        } else if (isset($body['isCorrect'])) {
            $is_correct = $body['isCorrect'];
            $option_model->update_is_correct($option_id, $is_correct);
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            die(400);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $option_model = new OptionModel();
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['optionId'])) {
            http_response_code(400);
            die(400);
        }

        $option_id = $body['optionId'];
        if (!$option_model->is_owner($user_id, $option_id)) {
            http_response_code(403);
            die(403);
        }

        $option_model->delete($option_id);
        echo json_encode(["success" => true]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $option_model = new OptionModel();
        $question_model = new QuestionModel();
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['questionId'])) {
            http_response_code(400);
            die(400);
        }

        $question_id = $body['questionId'];

        if (!$question_model->is_owner($user_id, $question_id)) {
            http_response_code(403);
            die(403);
        }

        $option_model->create_empty($question_id);
        echo json_encode(["success" => true]);
    }
}

handle();
