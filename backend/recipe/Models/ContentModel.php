<?
declare(strict_types=1);

namespace RecipeApplication\Models;

require_once dirname(__FILE__) . '/Connect.php';

class ContentModel
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = connectRecipe();
  }

  public function find($id)
  {
    $sql = 'SELECT * FROM content WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
    $contents = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $contents;
  }

  public function create($id, $content, $user_id)
  {
    $sql = 'INSERT INTO content(recipe_id, content, user_id, created_at) VALUES (:recipe_id, :content, :user_id, now())';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

  public function edit($id, $content_id, $content, $user_id)
  {
    $sql = 'UPDATE content SET content = :content, user_id = :user_id, updated_at = now() WHERE recipe_id = :recipe_id AND content_id = :content_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->bindValue(':content_id', $content_id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

  public function del($id)
  {
    $sql = 'DELETE FROM content WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
  }

  public function delUser($user_id)
  {
    $sql = 'DELETE FROM content WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }
}