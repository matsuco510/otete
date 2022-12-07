<?
declare(strict_types=1);

namespace RecipeApplication\Models;

require_once dirname(__FILE__) . '/Connect.php';

class MateModel
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = connectRecipe();
  }

  public function find($id)
  {
    $sql = 'SELECT * FROM mate WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
    $mates = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $mates;
  }

  public function search($keyword, $user_id)
  {
    $keyword = "%".$keyword."%";
    $sql = 'SELECT * FROM mate WHERE mate LIKE :mate AND user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':mate', $keyword);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    $mates = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $mates;
  }

  public function edit($id, $mate_id, $mate, $gram, $user_id)
  {
    $sql = 'UPDATE mate SET mate = :mate, gram = :gram, user_id = :user_id, updated_at = now() WHERE mate_id = :mate_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':mate', $mate);
    $stmt->bindValue(':gram', $gram);
    $stmt->bindValue(':mate_id', $mate_id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

  public function create($id, $mate, $gram, $user_id)
  {
    $sql = 'INSERT INTO mate(recipe_id, mate, gram, user_id, created_at) VALUES(:recipe_id, :mate, :gram, user_id, now())';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->bindValue(':mate', $mate);
    $stmt->bindValue(':gram', $gram);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }

  public function del($id)
  {
    $sql = 'DELETE FROM mate WHERE recipe_id = :recipe_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':recipe_id', $id);
    $stmt->execute();
  }

  public function delUser($user_id)
  {
    $sql = 'DELETE FROM mate WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
  }
}