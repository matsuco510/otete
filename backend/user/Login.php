<?
namespace UserApplication;

use UserApplication\Validator\Validator;
use UserApplication\UserController;

require_once 'Validator.php';
require_once 'UserController.php';

session_start();


$u = new UserController();

$mail = $u->escape($_POST['mail']);
$pass = $u->escape($_POST['password']);

$v = new Validator();
$v->checkMail($mail);
$v->checkPassword($pass);

$u->login($mail, $pass);
?>
<!-- login form -->
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
      <li><a href="/views/about.php">Oteteとは</a></li>
      <li><a href="/views/login.php">ログイン</a></li>
      <li><a href="/views/register.php">新規登録</a></li>
    </ul>
  </div>
  </header><!-- header -->
  <div class="layout">
    <div class="container">
      <h1 class="card_header">ログイン</h1>
      <div class="err_msg">
        <?
        print $u->login($mail, $pass);
        $v->__invoke();
        ?>
      </div>
      <form action="/backend/user/login.php" method="post" class="form">
        <input type="hidden" name="token" value="<? print $token;?>">
        <label for="mail">メールアレドレス</label><br>
        <input type="mail" name="mail" class="form_control"><br>
        <label for="password">パスワード</label><br>
        <input type="password" name="password" class="form_control"><br>
        <input type="submit" class="btn"><br>
      </form>
    </div>
  </div>
  <footer class="footer">
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