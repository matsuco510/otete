<?
declare(strict_types=1);

namespace UserApplication\Models;

require_once dirname(__FILE__).'/Connect.php';

class UserModel
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = connectUser();
  }

  public function find($id)
  {
    $sql = 'SELECT * FROM user WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $id);
    $stmt->execute();
    $user = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $user;
  }

  public function findMail($mail)
  {
    $sql = 'SELECT * FROM user WHERE mail = :mail';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':mail', $mail);
    $stmt->execute();
    $login = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $login;
  }

  public function editNickname($id, $nickname)
  {
    $sql = 'UPDATE user SET nickname = :nickname, updated_at = now() WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':nickname', $nickname);
    $stmt->bindValue(':user_id', $id);
    $stmt->execute();
    $_SESSION['nickname'] = $nickname;
  }

  public function editMail($id, $mail)
  {
    $sql = 'UPDATE user SET mail = :mail, updated_at = now() WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':user_id', $id);
    $stmt->execute();
    $_SESSION['mail'] = $mail;
  }

  public function editPassword($id, $pass_hash)
  {
    $sql = 'UPDATE user SET pass = :pass, updated_at = now() WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':pass', $pass_hash);
    $stmt->bindValue(':user_id', $id);
    $stmt->execute();
  }

  public function create($id, $name, $nickname, $mail, $pass_hash)
  {
    $sql = 'INSERT INTO user(user_id, name, nickname, mail, pass, created_at) VALUES (:id, :name, :nickname, :mail, :pass, now())';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':nickname', $nickname);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':pass', $pass_hash);
    $stmt->execute();
  }

  public function del($id)
  {
    $sql = 'DELETE FROM user WHERE user_id = :user_id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $id);
    $stmt->execute();
  }
}