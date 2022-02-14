<?php

class TokenModel extends PDOStatement {
    private $connection;

    public $id;
    public $token;
    public $created_at;
    public $updated_at;

    public function __construct() {
    }

    private function connection(): PDOConfig {
        return new PDOConfig();
    }

    public static function from_dict($dict): TokenModel {
        $record = new self();
        $record->id = $dict['id'];
        $record->token = $dict['token'];
        $record->created_at = $dict['created_at'];
        $record->updated_at = $dict['updated_at'];

        return $record;
    }

    /**
     * Create user session token
     */
    public function create_token($token, $user_id, $expires) {
        $sql = "INSERT INTO Tokens(token, user_id, expires_at) VALUES (:token, :user_id, :expires_at)";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':token', $token);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':expires_at', $expires->format('Y-m-d H:i:s'));
            $statement->execute();
            $connection = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function select_by_token($token) {
        $sql = "SELECT * FROM Tokens WHERE token=:token";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':token', $token);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $connection = null;
            return array_map('self::from_dict', $result);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * Check whether the token is valid
     */
    public function is_authorized($token): bool {
        $tokens = $this->select_by_token($token);

        if (empty($tokens)) {
            return false;
        }

        if (new DateTime($tokens[0]->expires_at) > new DateTime()) {
            return false;
        }

        return true;
    }
}
