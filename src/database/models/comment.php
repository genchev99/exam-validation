<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/question.php');
require_once(__DIR__ . '/user.php');

class CommentModel extends PDOStatement
{
  private $connection;
  private $table_name = 'Comments';

  public $id;
  public $comment;
  public $created_at;
  public $updated_at;

  public function __construct()
  {
  }

  private function connection(): PDOConfig
  {
    return new PDOConfig();
  }

  public static function from_dict($dict): CommentModel
  {
    $record = new self();
    $record->id = $dict['id'];
    $record->comment = $dict['comment'];
    $record->created_at = $dict['created_at'];
    $record->updated_at = $dict['updated_at'];

    return $record;
  }

  public function create_comment($comment, $question_id, $user_id)
  {
    $sql = "INSERT INTO Comments (comment, question_id, user_id)
        VALUES
        (:comment, :question_id, :user_id)";

    try {
      $connection = $this->connection();
      $statement = $connection->prepare($sql);
      $statement->bindValue(':comment', $comment);
      $statement->bindValue(':question_id', $question_id);
      $statement->bindValue(':user_id', $user_id);
      $statement->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function delete($comment_id)
  {
    $sql = "DELETE FROM Comments WHERE id=:comment_id";

    try {
      $connection = $this->connection();
      $statement = $connection->prepare($sql);
      $statement->bindValue(':comment_id', $comment_id);
      $statement->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function update_comment($comment_id, $new_comment)
  {
    $sql = "UPDATE Comments SET comment=:value, updated_at=NOW() WHERE id=:comment_id";

    try {
      $connection = $this->connection();
      $statement = $connection->prepare($sql);
      $statement->bindValue(':comment_id', $comment_id);
      $statement->bindValue(':value', $new_comment);
      $statement->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function select_all($as_json = true)
  {
    $sql = "SELECT Comments.id, Comments.comment, Comments.question_id, Users.faculty_number, Users.id, Users.username FROM Comments JOIN Users ON Comments.user_id=Users.id";

    try {
      $connection = $this->connection();
      $statement = $connection->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      $connection = null;

      if ($as_json) {
        return $result;
      }

      return array_map('self::from_dict', $result);
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function select_by_question_id($question_id, $as_json = true)
  {
    $sql = "SELECT * FROM " . $this->table_name . " WHERE question_id=:question_id";

    try {
      $connection = $this->connection();
      $statement = $connection->prepare($sql);
      $statement->bindValue(':question_id', $question_id);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      $connection = null;

      if ($as_json) {
        return $result;
      }

      return array_map('self::from_dict', $result);
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function select_by_id($comment_id, $as_json = true)
  {
    $sql = "SELECT * FROM Comments WHERE id=:comment_id";

    try {
      $connection = $this->connection();
      $statement = $connection->prepare($sql);
      $statement->bindValue(':comment_id', $comment_id);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      $connection = null;

      if ($as_json) {
        return $result;
      }

      return array_map('self::from_dict', $result);
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }
}
