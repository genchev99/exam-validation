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
            timestamp TIMESTAMP NOT NULL,
            faculty_number VARCHAR(16) NOT NULL,
            question_number INT NOT NULL,
            purpose_of_question VARCHAR(1024) NOT NULL,
            question VARCHAR(2048) NOT NULL,
            hardness INT NOT NULL,
            response_on_error VARCHAR(1024) NOT NULL,
            response_on_success VARCHAR(1024) NOT NULL,
            note VARCHAR(1024) NOT NULL,
            type INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            quiz_id INT,
            INDEX q_id (quiz_id),
            FOREIGN KEY (quiz_id)
                REFERENCES Quizzes(id)
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
