<?php
require_once(__DIR__ . '/../config.php');

class CreateReferatTable {
    private function connection() {
        return new PDOConfig();
    }

    public function up() {
        $table_name = 'Referats';
        $sql = 'CREATE TABLE `' . $table_name . '` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            referat_title VARCHAR(1024) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
        $table_name = 'Referats';
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
