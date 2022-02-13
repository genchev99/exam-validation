<?php
require_once(__DIR__ . '/../config.php');

class CreateTokenTable {
    private function connection() {
        return new PDOConfig();
    }

    public function up() {
        $table_name = 'Tokens';
        $sql = 'CREATE TABLE `' . $table_name . '` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token VARCHAR(128) NOT NULL,
            expires TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            user_id INT,
            INDEX u_id (user_id),
            FOREIGN KEY (user_id)
                REFERENCES Users(id)
                ON DELETE CASCADE
        )';
        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $connection = null;

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function down() {
        $table_name = 'Tokens';
        $sql = 'DROP TABLE IF EXISTS `' . $table_name . '`';

        try {
            $connection = $this->connection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $connection = null;

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();

            return false;
        }
    }
}
