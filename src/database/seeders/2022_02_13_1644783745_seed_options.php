<?php
require_once(__DIR__ . '/../config.php');

class SeedOptions {
    private function connection() {
        return new PDOConfig();
    }

    public function seed() {
        $table_name = 'Options';
        $sql = 'INSERT INTO `' . $table_name . "` (
            is_correct,
            opt,
            question_id
        ) VALUES
        (TRUE,'Да даде възможност даден сайт да бъде разглеждан в режим на виртуална реалност',1),
        (FALSE,'Да отваря обикновени уеб страници',1),
        (FALSE,'Да информира какви решения се взимат за виртуалната реалност',1),
        (FALSE,'Да се отвори уеб страница, която съдържа видеа, свързани с уеб виртуалната реалност',1),
        (TRUE,'комплект за виртуална реалност(слушалки и очила) и съвместим браузър',2),
        (FALSE,'много мощен компютър/лаптоп',2),
        (FALSE,'специално устройство, предназначено конкретно за виртуална реалност',2),
        (FALSE,'само обикновени слушалки и съвместим браузър',2)
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
