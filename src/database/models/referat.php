<?php
require_once(__DIR__ . '/../config.php');

class ReferatModel extends PDOStatement {
    private $connection;
    private $table_name = 'Referats';

    public $id;
    public $referat_title;
    public $created_at;
    public $updated_at;

    public function __construct() {
    }

    private function connection(): PDOConfig {
        return new PDOConfig();
    }

    public static function from_dict($dict): ReferatModel {
        $record = new self();
        $record->id = $dict['id'];
        $record->referat_title = $dict['referat_title'];
        $record->created_at = $dict['created_at'];
        $record->updated_at = $dict['updated_at'];

        return $record;
    }

    public function select($as_json = true) {
        $sql = "SELECT * FROM " . $this->table_name;

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
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

    public function select_by_id($id, $as_json = true) {
        $sql = "SELECT * FROM Referats WHERE id=:id";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':id', $id);
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
