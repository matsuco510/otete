<?
declare(strict_types=1);

namespace RecipeApplication\Models;

require_once dirname(__FILE__) . '/Connect.php';

class SubContentModel
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = connectRecipe();
  }

  public function find($id)
  {
    $sql = 'SELECT * FROM sub_content WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
    $sub_contents = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $sub_contents;
  }

  public function edit($id, $sub_id, $sub_content, $user_id)
  {
    $sql = 'UPDATE sub_content SET sub_content = :sub_content, user_id = :user_id, updated_at = now() WHERE recipe_id = :recipe_id AND sub_content_id = :sub_content_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':sub_content', $sub_content);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->bindValue(':sub_content_id', $sub_id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

  public function create($id, $sub_content, $user_id)
  {
    $sql = 'INSERT INTO sub_content(recipe_id, sub_content, user_id, created_at) VALUES (:recipe_id, :sub_content, :user_id, now())';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->bindValue(':sub_content', $sub_content);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

  public function del($id)
  {
    $sql = 'DELETE FROM sub_content WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
  }

  public function delUser($user_id)
  {
    $sql = 'DELETE FROM sub_content WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

}