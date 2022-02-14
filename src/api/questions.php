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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (preg_match("/update$/", $req_url)) {
            $question_model = new QuestionModel();
//            echo json_encode(json_decode($_POST['data'], true));
            echo $_POST['data'];
            return;
        }
    }
}

handle();
