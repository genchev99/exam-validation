<?php
require_once(__DIR__ . '/../config.php');

class SeedUsers {
    private function connection() {
        return new PDOConfig();
    }

    public function seed() {
        $table_name = 'Users';
        $sql = 'INSERT INTO `' . $table_name . "` (
            username,
            password_hash,
            faculty_number,
            is_admin
        ) VALUES
        ('hgenchev', '098f6bcd4621d373cade4e832627b4f6', '81798', FALSE),
        ('ybelakov', '098f6bcd4621d373cade4e832627b4f6', '81877', FALSE),
        ('admin', '098f6bcd4621d373cade4e832627b4f6', 'admin', TRUE)
        ";
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
