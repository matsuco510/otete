<?
declare(strict_types=1);

session_start();

if (!empty($_POST['logout']))
{
  unset($_SESSION['id'], $_SESSION['nickname'], $_SESSION['mail']);
  header('Location: /index.php');
}