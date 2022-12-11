<?
namespace UserApplication;

use UserApplication\UserController;

require_once '../backend/user/UserController.php';

session_start();
$u = new UserController();
$token = $u->generateToken();
$_SESSION['token'] = $token;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Otete</title>
  <!-- css -->
  <link rel="stylesheet" href="./css/destyle.css">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="./css/mobile.css">
  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- favicon -->
  <link rel="icon" type="image/png" href="./images/favicon.png">
</head>
<body>
  <header>
    <div class="left">
      <h1><a href="./index.php">Otete</a></h1>
    </div>
    <div class="right">
      <ul>
        <li><a href="./about.php">Oteteとは</a></li>
        <li><a href="./login.php">ログイン</a></li>
        <li><a href="./register.php">新規登録</a></li>
      </ul>
    </div>
  </header><!-- header -->
  <div class="layout">
    <div class="container">
      <h1 class="card_header">新規登録</h1>
      <form action="../backend/user/Register.php" method="post" name="register" class="form">
        <input type="hidden" name="token" value="<? print $token;?>">
        <label for="id">ID</label><br>
        <input type="text" name="id" class="form_control" id="mobile_form"><br>
        <label for="name">名前</label><br>
        <input type="text" name="name" class="form_control" id="mobile_form"><br>
        <label for="nickname">ニックネーム</label> <span>※後で設定できます。</span><br>
        <input type="text" name="nickname" class="form_control" id="mobile_form" value="user"><br>
        <label for="mail">メールアドレス</label><br>
        <input type="mail" name="mail" class="form_control" id="mobile_form"><br>
        <label for="password">パスワード</label><br>
        <input type="text" name="password" class="form_control" id="mobile_form"><br>
        <label for="password-conf">パスワード(確認)</label><br>
        <input type="text" name="password-conf" class="form_control" id="mobile_form"><br>
        <input type="submit" class="btn" id="btn" name="btn">
      </form>
    </div>
  </div><!-- register_form -->
  <footer class="footer">
  <div class="footer_menu">
      <ul>
        <li><a href="./termsOfUse.php">利用規約</a></li>
        <li><a href="./privacy.php">プライバシーポリシー</a></li>
      </ul>
    </div>
    <p>©️ 2022 Otete Portfolio</p>
  </footer><!-- footer -->
</body>
</html>