<?
namespace UserApplication;

use UserApplication\UserController;

require_once 'backend/user/UserController.php';

session_start();

$u = new UserController();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Otete</title>
  <!-- css -->
  <link rel="stylesheet" href="./views/css/destyle.css">
  <link rel="stylesheet" href="./views/css/index.css">
  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
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
        <li><a href="./views/about.php">Oteteとは</a></li>
        <li><a href="./views/login.php">ログイン</a></li>
        <li><a href="./views/register.php">新規登録</a></li>
      </ul>
    </div>
  </header><!-- header -->
  <div class="wrap">
    <div class="main">
      <div class="main_img">
        <img src="./views/images/main.png">
        <img src="./views/images/main_back.png" class="img_back">
      </div>
      <div class="main_content">
        <h2>Otete</h2>
        <p>
          単なるレシピ管理アプリ。<br>
          メニューを登録して、<br>
          週単位でメニューを決めて<br>
          無駄なく食材を使い切る。<br>
          メニューはその時食べたいものを<br>
          選んで作れる。<br>
        </p>
        <a href="./views/register.php" class="btn">さあ、はじめよう。</a><br>
        <br>
        <a href="./backend/user/GestLogin.php" class="gest">ゲストログイン</a>
      </div>
    </div><!--  main  -->
  </div>
  <footer class="footer">
    <div class="footer_menu">
      <ul>
        <li><a href="./views/termsOfUse.php">利用規約</a></li>
        <li><a href="./views/privacy.php">プライバシーポリシー</a></li>
      </ul>
    </div>
    <p>©️ 2022 Otete Portfolio</p>
  </footer><!-- footer -->
</body>
</html>