<?php
require_once __DIR__ . "/../database/models/user.php";
require_once __DIR__ . "/../database/models/token.php";
require_once __DIR__ . "/../utils.php";

session_start();

header('Content-Type: application/json');

function handle() {
    if (isset($_POST)) {
        $data = json_decode($_POST['data'], true);

        $username = isset($data['username']) ? test_input($data['username']) : '';
        $password = isset($data['password']) ? test_input($data['password']) : '';

        if (!$username) {
            return 'Please enter username';
        }

        if (!$password) {
            return 'Please enter password';
        }

        /* TODO: This can be improved by using static methods instead of creating an instance */
        $user_model = new UserModel();
        try {
            $user = $user_model->select_one_by_username($username);
        } catch (ErrorException $e) {
            return 'Invalid username';
        }

        if ($user_model->is_using_valid_credentials($user, $password)) {
            $_SESSION['username'] = $user->username;
            $_SESSION['user_id'] = $user->id;
            if (!isset($_SESSION['referat_id'])) {
                $_SESSION['referat_id'] = 1;
            }

            $token_model = new TokenModel();
            $token = bin2hex(random_bytes(8));
            $expires = new DateTime('tomorrow');

            setcookie('token', $token, $expires->getTimestamp(), '/');
            $token_model->create_token($token, $_SESSION['user_id'], $expires);
        } else {
//            http_response_code(401);
            return 'Invalid password';
        }
    } else {
//        http_response_code(400);
        return 'Invalid request';
    }
}

$error = handle();

$response = ['success' => true];

if ($error) {
    $response = ['success' => false, 'error' => $error];
}

echo json_encode($response);
