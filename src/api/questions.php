<?php
require_once __DIR__ . "/../database/models/question.php";
require_once __DIR__ . "/../database/models/token.php";
require_once __DIR__ . "/../database/models/user.php";
require_once __DIR__ . "/../utils.php";

session_start();

//header('Content-Type: application/json');

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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $question_model = new QuestionModel();
        $user_model = new UserModel();

        if (isset($_GET['export_csv'])) {
            if (!$user_model->is_admin($user_id)) {
                http_response_code(403);
                exit("Unauthorized");
            }

            $all_questions = $question_model->export_all();
            $headers = array('Timestamp', 'Факултетен номер', 'Номер на въпроса', 'Цел на въпроса', 'Въпрос', 'Опция 1', 'Опция 2', 'Опция 3', 'Опция 4', 'Верен отговор', 'Ниво на трудност', 'Обратна връзка при верен отговор', 'Обратна връзка при грешен отговор', 'Забележка', 'Тип на въпроса');
            $csv = array($headers);

            foreach ($all_questions as $question) {
                $row = array();

                $row[] = $question['question_created_at'];
                $row[] = $question['faculty_number'];
                $row[] = $question['id'];
                $row[] = $question['purpose_of_question'];
                $row[] = $question['question'];

                $options = $question['options'];
                // Fills the array with options if not enough (4) answers were added
                $options = array_replace(array_fill_keys(range(0, 4), array('opt' => '', 'is_correct' => false)), $options);
                // add answers
                $row[] = $options[0]['opt'];
                $row[] = $options[1]['opt'];
                $row[] = $options[2]['opt'];
                $row[] = $options[3]['opt'];
                $row[] = first_index_of_arr_of_objects($options, 'is_correct', 1);

                // add the rest
                $row[] = $question['hardness'];
                $row[] = $question['response_on_correct'];
                $row[] = $question['response_on_incorrect'];
                $row[] = $question['note'];
                $row[] = $question['type'];

                $csv[] = $row;
            }

            array_to_csv_download($csv);
            return;
        }

        if (isset($_GET['referat_id'])) {
            $referat_id = $_GET['referat_id'];
            echo json_encode([
                "success" => true,
                //            "data" => $question_model->select_by_user_id($user_id)
                "data" => $question_model->select_all($referat_id)
            ], JSON_UNESCAPED_UNICODE);
            return;
        }
        echo json_encode([
            "success" => true,
            //            "data" => $question_model->select_by_user_id($user_id)
            "data" => $question_model->select_by_user_and_referat($user_id, $_SESSION['referat_id'])
        ], JSON_UNESCAPED_UNICODE);
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

        $question_model->create_empty($user_id, $_SESSION['referat_id']);
        echo json_encode(["success" => true]);
    }
}

handle();
