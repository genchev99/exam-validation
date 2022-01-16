<?php
require_once(__DIR__ . '/../config.php');

class CreateUserTable {
    private function connection() {
        return new PDOConfig();
    }

    public function up() {
        $table_name = 'user';
        $sql = 'CREATE TABLE `' . $table_name . '` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(64) NOT NULL,
            password_hash VARCHAR(128) NOT NULL,
            first_name VARCHAR(64) NOT NULL,
            last_name VARCHAR(64) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
        $table_name = 'user';
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
