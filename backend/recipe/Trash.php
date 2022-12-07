<?
declare(strict_types=1);

namespace RecipeApplication;

use RecipeApplication\RecipeController;

require_once 'RecipeController.php';

session_start();

if (!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token'])
{
  die('不正なリクエストです。処理を中断します。');
}

unset($_SESSION['token']);

$r = new RecipeController();
if (isset($_POST['cancel']))
{
  header('Location: /views/user.php?'.$_SESSION['nickname']);
}

if (isset($_POST['delete']))
{
  $r->del($_GET['recipe_id']);
}

?>
<!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? print $_SESSION['nicknam'];?>さんのページ</title>
    <!-- css -->
    <link rel="stylesheet" href="/views/css/destyle.css">
    <link rel="stylesheet" href="/views/css/index.css">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  </head>
  <body>
    <header>
      <div class="left">
        <h1><a href="/index.php">Otete</a></h1>
      </div>
      <div class="right">
        <ul>
          <li><a href="/views/about.php">Oteteとは</a></li>
          <li><a href="/views/user.php?<? print $_SESSION['nickname']; ?>">マイページ</a></li>
          <li><a href="/views/Logout.php">ログアウト</a></li>
        </ul>
      </div>
    </header><!-- header -->
    <h1 class="trash_title">レシピが削除されました。</h1>
    <img src="/views/images/acorn.png" class="trash_img">
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