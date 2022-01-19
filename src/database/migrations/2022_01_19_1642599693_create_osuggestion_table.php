<?php
require_once(__DIR__ . '/../config.php');

class CreateOsuggestionTable {
    private function connection() {
        return new PDOConfig();
    }

    public function up() {
        $table_name = 'OSuggestions';
        $sql = 'CREATE TABLE `' . $table_name . '` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            suggestion VARCHAR(2048) NOT NULL,
            is_resolved BOOLEAN DEFAULT FALSE,
            option_id INT,
            INDEX op_id (option_id),
            FOREIGN KEY (option_id)
                REFERENCES Options(id)
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
        $table_name = 'OSuggestions';
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
