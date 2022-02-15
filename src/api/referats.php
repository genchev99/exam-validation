<?php
require_once __DIR__ . "/../database/models/referat.php";
require_once __DIR__ . "/../database/models/token.php";
require_once __DIR__ . "/../utils.php";

session_start();

header('Content-Type: application/json');

function handle() {
    $user_id = $_SESSION['user_id'];
    $token_model = new TokenModel();

    if (!isset($_SESSION['referat_id'])) {
        $_SESSION['referat_id'] = 1;
    }

    /*
     * Checks if the use is authorized
     * */
    if (!isset($_COOKIE['token']) or !$token_model->is_authorized($_COOKIE['token'], $user_id)) {
        http_response_code(401);
        exit("Unauthorized");
    }

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $referat_model = new ReferatModel();
        echo json_encode([
            "success" => true,
            "data" => $referat_model->select(),
            "selected" => $_SESSION['referat_id']
        ], JSON_UNESCAPED_UNICODE);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $referat_model = new ReferatModel();
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['referatId'])) {
            http_response_code(400);
            die(400);
        }

        $referat_id = intval($body['referatId']);

        if (empty($referat_model->select_by_id($referat_id))) {
            http_response_code(400);
            die(400);
        }

        $_SESSION['referat_id'] = $referat_id;
    }
}

handle();
