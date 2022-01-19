<?php
require_once(__DIR__ . '/../config.php');

class CreateOptionTable {
    private function connection() {
        return new PDOConfig();
    }

    public function up() {
        $table_name = 'Options';
        $sql = 'CREATE TABLE `' . $table_name . '` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            is_correct BOOLEAN DEFAULT FALSE,
            opt VARCHAR(2048) NOT NULL,
            question_id INT,
            INDEX ques_id (question_id),
            FOREIGN KEY (question_id)
                REFERENCES Questions(id)
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
        $table_name = 'Options';
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
