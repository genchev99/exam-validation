<?php
require_once(__DIR__ . '/../config.php');

class UserModel extends PDOStatement {
    private $connection;
    private $table_name = 'Users';

    public $id;
    public $username;
    public $password_hash;
    public $faculty_number;
    public $created_at;
    public $updated_at;

    public function __construct() {
    }

    private function connection(): PDOConfig {
        return new PDOConfig();
    }

    public function _toString(): string {
        return "id: " . $this->id .
            "username: " . $this->username .
            "password_hash: " . $this->password_hash .
            "faculty_number: " . $this->faculty_number .
            "created_at: " . $this->created_at .
            "updated_at: " . $this->updated_at;
    }

    public static function from_dict($dict): UserModel {
        $record = new self();
        $record->id = $dict['id'];
        $record->username = $dict['username'];
        $record->password_hash = $dict['password_hash'];
        $record->faculty_number = $dict['faculty_number'];
        $record->created_at = $dict['created_at'];
        $record->updated_at = $dict['updated_at'];

        return $record;
    }

    public function select() {
        $sql = "SELECT * FROM " . $this->table_name;

        try {
            $connection = $this->connection();
            $statement = $connection->query($sql);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $connection = null;
            return array_map('self::from_dict', $result);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function select_by_username($username) {
        $sql = "SELECT * FROM Users WHERE username=:username";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':username', $username);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $connection = null;
            return array_map('self::from_dict', $result);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function select_one_by_username($username) {
        $user_records = $this->select_by_username($username);

        if (empty($user_records)) {
            throw new ErrorException("The user couldn't be found");
        }

        return $user_records[0];
    }

    public static function is_using_valid_credentials($user, $password): bool {
        /**
         * The line below should be change if new password hashes are implemented
         */
        return md5($password) == $user->password_hash;
    }
}
