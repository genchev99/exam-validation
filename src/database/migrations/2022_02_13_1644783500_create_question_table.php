<?php
require_once(__DIR__ . '/../config.php');

class CreateQuestionTable {
    private function connection() {
        return new PDOConfig();
    }

    public function up() {
        $table_name = 'Questions';
        $sql = 'CREATE TABLE `' . $table_name . '` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            purpose_of_question VARCHAR(1024) NOT NULL,
            question VARCHAR(2048) NOT NULL,
            hardness INT NOT NULL,
            response_on_incorrect VARCHAR(1024) NOT NULL,
            response_on_correct VARCHAR(1024) NOT NULL,
            note VARCHAR(1024) NOT NULL,
            type INT NOT NULL,
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
        $table_name = 'Questions';
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
