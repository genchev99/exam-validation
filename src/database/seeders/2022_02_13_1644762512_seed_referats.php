<?php
require_once(__DIR__ . '/../config.php');

class SeedReferats
{
  private function connection()
  {
    return new PDOConfig();
  }

  public function seed()
  {
    $table_name = 'Referats';
    $sql = 'INSERT INTO `' . $table_name . "` (
            referat_title
        ) VALUES
        ('CSS селектори'),
        ('PHP for dummies'),
        ('Vanilla JavaScript and HTML')
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
