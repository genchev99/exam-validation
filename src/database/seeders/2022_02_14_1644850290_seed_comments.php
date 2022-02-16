<?php
require_once(__DIR__ . '/../config.php');

class SeedComments {
    private function connection() {
        return new PDOConfig();
    }

    public function seed() {
        $table_name = 'Comments';
        $sql = 'INSERT INTO `' . $table_name . "` (
            comment,
            question_id,
            user_id
        ) VALUES
        ('Много добре зададен въпрос!', '1', '1'),
        ('Има двумислица', '2', '1'),
        ('Уебсайтът, към който води линка-източник, не работи!', '1', '2'),
        ('За този въпрос повече информация можем да получим от секция 3 в реферата, а не секция 2!', '2', '2')

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
