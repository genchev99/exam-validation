<?php
require_once(__DIR__ . '/../config.php');

class SeedComments
{
  private function connection()
  {
    return new PDOConfig();
  }

  public function seed()
  {
    $table_name = 'Comments';
    $sql = 'INSERT INTO `' . $table_name . "` (
            comment,
            question_id,
            user_id
        ) VALUES
        ('test', '1', '1'),
        ('test2', '2', '1')
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
