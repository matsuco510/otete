<?
declare(strict_types=1);

session_start();

// ログアウト処理（セッションに定義したユーザー情報の削除）
if (!empty($_POST['logout']))
{
  unset($_SESSION['id'], $_SESSION['nickname'], $_SESSION['mail']);
  header('Location: /index.php');
}