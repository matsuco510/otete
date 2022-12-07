<?
declare(strict_types=1);

namespace UserApplication\Models;

require_once dirname(__FILE__).'/Connect.php';

class IconModel
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = connectUser();
  }

  public function find($id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM icon WHERE user_id = :user_id');
    $stmt->bindValue(':user_id', $id);
    $stmt->execute();
    $image = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $image;
  }

  public function edit($name, $type, $content, $size, $id)
  {
    $sql = 'UPDATE icon SET name = :name, type = :type, content = :content, size = :size, updated_at = now() WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
    $stmt->bindValue(':type', $type, \PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, \PDO::PARAM_LOB);
    $stmt->bindValue(':size', $size, \PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $id);
    $stmt->execute();
  }

  public function create($name, $type, $content, $size, $id)
  {
    $sql = 'INSERT INTO icon(name, type, content, size, user_id, created_at) VALUES(:name, :type, :content, :size, :user_id, now())';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
    $stmt->bindValue(':type', $type, \PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, \PDO::PARAM_LOB);
    $stmt->bindValue(':size', $size, \PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $id);
    $stmt->execute();
  }

  public function del($id)
  {
    $sql = 'DELETE FROM icon WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $id);
    $stmt->execute();
  }
}