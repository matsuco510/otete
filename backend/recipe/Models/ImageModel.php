<?
declare(strict_types=1);

namespace RecipeApplication\Models;

require_once dirname(__FILE__) . '/Connect.php';

class ImageModel
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = connectRecipe();
  }

  public function find($id)
  {
    $sql = 'SELECT * FROM recipe_image WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
    $image = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $image;
  }

  public function edit($name, $type, $content, $size, $id, $user_id)
  {
    try {
    $sql = 'UPDATE recipe_image SET name = :name, type = :type, content = :content, size = :size, user_id = :user_id, updated_at = now() WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
    $stmt->bindValue(':type', $type, \PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, \PDO::PARAM_LOB);
    $stmt->bindValue(':size', $size, \PDO::PARAM_INT);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    } catch (PDOException $e) {
      $e->getMessage();
    }
  }

  public function create($name, $type, $content, $size, $id, $user_id)
  {
    try {
      $sql = 'INSERT INTO recipe_image(recipe_id, name, type, content, size, user_id, created_at) VALUES(:recipe_id, :name, :type, :content, :size, :user_id, now())';
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':recipe_id', $id, \PDO::PARAM_INT);
      $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
      $stmt->bindValue(':type', $type, \PDO::PARAM_STR);
      $stmt->bindValue(':content', $content, \PDO::PARAM_LOB);
      $stmt->bindValue(':size', $size, \PDO::PARAM_INT);
      $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_STR);
      $stmt->execute();

    } catch(PDOException $e) {
      $e->getMessage();
    }
  }

  public function del($id)
  {
    $sql = 'DELETE FROM recipe_image WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
  }

  public function delUser($user_id)
  {
    $sql = 'DELETE FROM recipe_image WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }
}