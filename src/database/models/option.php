<?php
require_once(__DIR__ . '/../config.php');

class OptionModel extends PDOStatement {
    private $connection;
    private $table_name = 'Options';

    public $id;
    public $is_correct;
    public $opt;
    public $created_at;
    public $updated_at;

    public function __construct() {
    }

    private function connection(): PDOConfig {
        return new PDOConfig();
    }

    public static function from_dict($dict): OptionModel {
        $record = new self();
        $record->id = $dict['id'];
        $record->is_correct = $dict['is_correct'];
        $record->opt = $dict['opt'];
        $record->created_at = $dict['created_at'];
        $record->updated_at = $dict['updated_at'];

        return $record;
    }

    public function create_empty($question_id) {
        $sql = "INSERT INTO Options (opt, question_id)
        VALUES
        ('', :question_id)";

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

    public function delete($option_id) {
        $sql = "DELETE FROM Options WHERE id=:option_id";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':option_id', $option_id);
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update_option($option_id, $new_option) {
        $sql = "UPDATE Options SET opt=:value, updated_at=NOW() WHERE id=:option_id";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':option_id', $option_id);
            $statement->bindValue(':value', $new_option);
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function select_by_question_id($question_id, $as_json = true) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE question_id=:question_id";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':question_id', $question_id);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $connection = null;

            if ($as_json) {
                return $result;
            }

            return array_map('self::from_dict', $result);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
