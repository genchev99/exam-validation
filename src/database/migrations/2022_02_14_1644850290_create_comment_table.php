<?php
require_once(__DIR__ . '/../config.php');

class CreateCommentTable
{
  private function connection()
  {
    return new PDOConfig();
  }

  public function up()
  {
    $table_name = 'Comments';
    $sql = 'CREATE TABLE `' . $table_name . '` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            comment VARCHAR(5000) NOT NULL,
            question_id INT,
            user_id INT,
            FOREIGN KEY (question_id)
                REFERENCES Questions(id)
                ON DELETE CASCADE,
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

  public function down()
  {
    $table_name = 'Comments';
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
