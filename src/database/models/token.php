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

    /**
     * Create user session token
     */
    public function create_token($token, $user_id, $expires) {
        $sql = "INSERT INTO Tokens(token, user_id, expires) VALUES (:token, :user_id, :expires)";

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->bindValue(':token', $token);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':expires', $expires);
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
            $connection = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * Check whether the token is valid
     */
    public function check_token($token): array {
        $query = $this->db->selectTokenQuery(array("token" => $token));

        /**
         * If the query was executed successfully we can check whether the token is valid and
         * to return the user's  data
         */
        if ($query["success"]) {
            /**
             * $query["data"] holds a PDO object with the result of the executed query.
             * We can get the data from the returned result as associative array, calling
             * the fetch(PDO::FETCH_ASSOC) method on $query["data"].
             */
            $userToken = $query["data"]->fetch(PDO::FETCH_ASSOC);

            /**
             * If there wasn't found a token variable $userToken will be null
             */
            if ($userToken) {
                if ($userToken["expires"] > time()) {
                    $query = $this->db->selectUserById(["id" => $userToken["userId"]]);

                    if ($query["success"]) {
                        $user = $query->fetch(PDO::FETCH_ASSOC);

                        if ($user) {
                            $user = new User($user['userName'], $user['password']);
                            $user->setEmail($user['email']);
                            $user->setUserId($user['id']);

                            return ['success' => true, 'user' => $user];
                        } else {
                            return ["success" => false, "error" => "Invalid token"];
                        }
                    } else {
                        return $query;
                    }
                } else {
                    return ["success" => false, "error" => "Token expired."];
                }
            } else {
                return ["success" => false, "error" => "Invalid token"];
            }
        } else {
            return $query;
        }
    }
}
