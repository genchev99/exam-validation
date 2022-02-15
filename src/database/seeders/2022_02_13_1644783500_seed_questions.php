<?php
require_once(__DIR__ . '/../config.php');

class SeedQuestions {
    private function connection() {
        return new PDOConfig();
    }

    public function seed() {
        $table_name = 'Questions';
        $sql = 'INSERT INTO `' . $table_name . "` (
            question,
            purpose_of_question,
            hardness,
            response_on_correct,
            response_on_incorrect,
            note,
            type,
            user_id,
            referat_id
        ) VALUES
        ('Какво е предназначението на уеб виртуалната реалност?','Да се разбере дали човекът отсреща знае какво е предназначението на уеб виртуална реалност',1,'Верен отговор!','Грешен отговор!','https://webvr.info/ - обяснява накратко какво е уеб виртуална реалност и дава отговор на поставения въпрос',1,1,1),
        ('Какво е необходимо, за да може да се изпробва виртуалната реалност в уеб?','Да се разбере дали човекът отсреща е разбрал какво е необходимо, за да може да се изпробва уеб виртуалната реалност',1,'Браво, това е верният отговор!','Грешен отговор! За повече информация може да видите секция 2. от реферата','Въпросът няма особености',3,1,1)
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
