<?
namespace UserApplication;

use UserApplication\UserController;

require_once '../backend/user/UserController.php';

session_start();

// セッションが切れたらログインページに遷移
if (!isset($_SESSION['id']))
{
  header("Location: login.php");
}
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
  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- favicon -->
  <link rel="icon" type="image/png" href="./images/favicon.png">
</head>
<body>
  <header>
    <div class="left">
      <h1><a href="../index.php">Otete</a></h1>
    </div>
    <div class="right">
      <ul>
        <li><a href="./about.php">Oteteとは</a></li>
        <li><a href="./user.php?<? print $_SESSION['nickname']; ?>">マイページ</a></li>
        <li><a href="./logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header><!-- header -->
  <div class="layout">
    <div class="container">
      <h1 class="card_header">プロフィール変更</h1>
      <form action="../backend/user/Edit.php" method="post" enctype="multipart/form-data" class="form">
        <input type="hidden" name="token" value="<? print $token; ?>">
        <label for="image">アイコンを変更</label>
        <div class="user_icon user_icon_position">
        <? $u->show($_SESSION['id']); ?>
        </div>
        <input type="file" name="image" enctype="multipart/form-data"><br>
        <label for="nickname">ニックネーム</label><br>
        <input type="text" name="nickname" class="form_control" value="<? print $_SESSION['nickname']?>"><br>
        <label for="mail">メールアドレス</label><br>
        <input type="text" name="email" class="form_control" value="<? print $_SESSION['mail']; ?>"><br>
        <label for="password">元のパスワード</label><br>
        <input type="text" name="password" class="form_control"><br>
        <label for="new_password">新しいパスワード</label><br>
        <input type="text" name="new_password" class="form_control"><br>
        <label for="new_password_conf">新しいパスワード(確認)</label><br>
        <input type="text" name="new_password_conf" class="form_control"><br>
        <input type="submit" class="btn" value="変　更">
      </form>
    </div>
  </div><!-- nickname_change_form -->
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