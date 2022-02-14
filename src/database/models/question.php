<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/option.php');

class QuestionModel extends PDOStatement {
    private $connection;
    private $table_name = 'Questions';

    public $id;
    public $purpose_of_question;
    public $question;
    public $hardness;
    public $response_on_incorrect;
    public $response_on_correct;
    public $note;
    public $type;
    public $created_at;
    public $updated_at;

    public function __construct() {
    }

    private function connection(): PDOConfig {
        return new PDOConfig();
    }

    public static function from_dict($dict): QuestionModel {
        $record = new self();
        $record->id = $dict['id'];
        $record->purpose_of_question = $dict['purpose_of_question'];
        $record->question = $dict['question'];
        $record->hardness = $dict['hardness'];
        $record->response_on_incorrect = $dict['response_on_incorrect'];
        $record->response_on_correct = $dict['response_on_correct'];
        $record->note = $dict['note'];
        $record->type = $dict['type'];
        $record->created_at = $dict['created_at'];
        $record->updated_at = $dict['updated_at'];

        return $record;
    }

    private function _join_options($question) {
        $option_model = new OptionModel();
        $question["options"] = $option_model->select_by_question_id($question["id"]);

        return $question;
    }

    public function create_empty() {
        $sql = "INSERT INTO Questions (question, purpose_of_question, hardness, response_on_correct, response_on_incorrect, note, type, user_id)
        VALUES
        ('','',1,'Верен отговор!','Грешен отговор!','',1,:user_id)";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':user_id', 1);
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function select($as_json = true, $join_options = true) {
        $sql = "SELECT * FROM " . $this->table_name;

        try {
            $connection = $this->connection();
            $statement = $connection->query($sql);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $connection = null;

            if ($join_options) {
                $result = array_map('self::_join_options', $result);
            }

            if ($as_json) {
                return $result;
            }

            return array_map('self::from_dict', $result);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($question_id) {
        $sql = "DELETE FROM Questions WHERE id=:question_id";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':question_id', $question_id);
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update_column($question_id, $column, $value) {
        $sql = "UPDATE Questions SET " . $column . "=:value, updated_at=NOW() WHERE id=:question_id";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':question_id', $question_id);
            $statement->bindValue(':value', $value);
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update($question_id, $question, $hardness, $response_on_incorrect, $response_on_correct, $note, $type) {
        $sql = "UPDATE Questions SET question=:question, hardness=:hardness, response_on_incorrect=:response_on_incorrect, response_on_correct=:response_on_correct, note=:note, type=:type, update_at=NOW() WHERE id=:question_id";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':question', $question);
            $statement->bindValue(':hardness', $hardness);
            $statement->bindValue(':response_on_incorrect', $response_on_incorrect);
            $statement->bindValue(':response_on_correct', $response_on_correct);
            $statement->bindValue(':note', $note);
            $statement->bindValue(':type', $type);
            $statement->bindValue(':question_id', $question_id);
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
