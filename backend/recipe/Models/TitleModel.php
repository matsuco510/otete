<?
declare(strict_types=1);

namespace RecipeApplication\Models;

require_once dirname(__FILE__) . '/Connect.php';

class TitleModel
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = connectRecipe();
  }

  public function find($title, $user_id)
  {
    $sql = 'SELECT * FROM recipe WHERE user_id = :user_id AND title = :title';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':title', $title);
    $stmt->execute();
    $recipes = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $recipes;
  }

  public function findUser($user_id)
  {
    $sql = 'SELECT * FROM recipe WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    $recipes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $recipes;
  }

  public function findId($id)
  {
    $sql = 'SELECT * FROM recipe WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
    $recipes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $recipes;
  }

  public function search($keyword, $user_id)
  {
    $keyword = "%".$keyword."%";
    $sql = 'SELECT * FROM recipe WHERE title LIKE :title AND user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':title', $keyword);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    $recipes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $recipes;
  }

  public function edit($id, $title, $user_id)
  {
    $sql = 'UPDATE recipe SET title = :title, user_id = :user_id WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
  }

  public function create($title, $user_id)
  {
    $sql = 'INSERT INTO recipe(title, user_id, created_at) VALUES (:title, :user_id, now())';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

  public function del($id)
  {
    $sql = 'DELETE FROM recipe WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
  }

  public function delUser($user_id)
  {
    $sql = 'DELETE FROM recipe WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

}