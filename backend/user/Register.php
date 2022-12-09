<?
namespace UserApplication;

use UserApplication\Validator\Validator;
use UserApplication\UserController;

require_once 'Validator.php';
require_once 'UserController.php';

session_start();

if (!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token'])
{
  die('不正なリクエストです。処理を中断します。');
}

unset($_SESSION['token']);

$u = new UserController();

$id = $u->escape($_POST['id']);
$name = $u->escape($_POST['name']);
$nickname = $u->escape($_POST['nickname']);
$mail = $u->escape($_POST['mail']);
$password = $u->escape($_POST['password']);
$password_conf = $u->escape($_POST['password-conf']);

$v = new Validator();
$v->checkId($id);
$v->checkName($name);
$v->checkMail($mail);
$v->checkPassword($password);
$v->checkPassConf($password_conf);
$v->checkPassMatch($password, $password_conf);

if (!empty($id) && !empty($name) && !empty($nickname) && !empty($mail) && !empty($password))
{
  $u->create($id, $name, $nickname, $mail, $password);
}
?>
<!-- 入力フォーム html -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    Otete
  </title>
  <!-- css -->
  <link rel="stylesheet" href="/views/css/destyle.css">
  <link rel="stylesheet" href="/views/css/index.css">
  <link rel="stylesheet" href="/views/css/mobile.css">
  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
  <!-- font awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- favicon -->
  <link rel="icon" type="image/png" href="/views/images/favicon.png">
</head>
<body>
  <header>
  <div class="left">
    <h1><a href="/index.php">Otete</a></h1>
  </div>
  <div class="right">
    <ul>
      <li><a href="/views/about.php">tasksとは</a></li>
      <li><a href="/views/login.php">ログイン</a></li>
      <li><a href="/views/register.php">新規登録</a></li>
    </ul>
  </div>
  </header><!-- header -->
  <div class="layout">
    <div class="container">
      <h1 class="card_header">新規登録</h1>
      <div class="err_msg">
        <?
        $v->__invoke();
        ?>
      </div>
      <form action="/backend/user/register.php" method="post" class="form">
        <label for="id">ID</label><br>
        <input type="text" name="id" class="form_control"><br>
        <label for="name">名前</label><br>
        <input type="text" name="name" class="form_control"><br>
        <label for="name">ニックネーム</label><span>※後で設定できます。</span><br>
        <input type="text" name="nickname" class="form_control" value="user"><br>
        <label for="email">メールアドレス</label><br>
        <input type="email" name="email" class="form_control"><br>
        <label for="password">パスワード</label><br>
        <input type="text" name="password" class="form_control"><br>
        <label for="password-conf">パスワード(確認)</label><br>
        <input type="text" name="password-conf" class="form_control"><br>
        <input type="submit" name="btn" class="btn">
      </form>
    </div>
  </div>
  <footer>
  <div class="footer_menu">
      <ul>
        <li><a href="/views/termsOfUse.php">利用規約</a></li>
        <li><a href="/views/privacy.php">プライバシーポリシー</a></li>
      </ul>
    </div>
    <p>©️ 2022 Otete Portfolio</p>
  </footer><!-- footer -->
</body>
</html>