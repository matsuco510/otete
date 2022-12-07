<?
declare(strict_types=1);

namespace RecipeApplication\Models;

require_once dirname(__FILE__) . '/Connect.php';

class WeekModel
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = connectRecipe();
  }

  public function find($user_id)
  {
    $sql = 'SELECT * FROM week WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    $week = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $week;
  }

  public function create($before, $after, $id, $user_id)
  {
    $sql = 'INSERT INTO week(week_before, week_after, recipe_id, user_id, created_at) VALUES (:before, :after, :recipe_id, :user_id, now())';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':before', $before);
    $stmt->bindValue(':after', $after);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

  public function edit($before, $after, $user_id, $id)
  {
    $sql = 'UPDATE week SET week_before = :before, week_after = :after, updated_at = now() WHERE user_id = :user_id AND recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':before', $before);
    $stmt->bindValue(':after', $after);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
  }

  public function del($id, $user_id)
  {
    $sql = 'DELETE FROM week WHERE recipe_id = :recipe_id AND user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

  public function delUser($user_id)
  {
    $sql = 'DELETE FROM week WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }
}