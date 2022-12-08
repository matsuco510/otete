<?
namespace UserApplication\Models;

use UserApplication\UserController;

require_once 'UserController.php';

session_start();

if (!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token'])
{
  die('不正なリクエストです。処理を中断します。');
}

unset($_SESSION['token']);

$nickname = $_POST['nickname'];
$mail = $_POST['email'];
$password = $_POST['password'];
$new_password = $_POST['new_password'];
$password_conf = $_POST['new_password_conf'];

$err_msgs = array();
if (!empty($new_password) && !empty($password_conf))
{
  if (strlen($new_password) <= 4) {
    $err_msgs[] = 'パスワードは4文字以上で入力してください。';
  }

  if (preg_match('/[あ-ょａ-ｚ]/', $new_password)) {
    $err_msgs[] = '半角英数字で入力してください。';
  }
}

if (!empty($_FILES['image']['tmp_name']))
{
  $name = $_FILES['image']['name'];
  $type = $_FILES['image']['type'];
  $content = file_get_contents($_FILES['image']['tmp_name']);
  $size = $_FILES['image']['size'];
}

$u = new UserController();

if (isset($content)|| isset($nickname) || isset($mail) || !empty($password) || !empty($new_password) || !empty($password_conf))
{
  if (isset($content))
  {
  $u->editImage($name, $type, $content, $size, $_SESSION['id']);
  }
  $u->edit($_SESSION['id'], $nickname, $mail);

  if (!empty($password) && !empty($new_password) && !empty($password_conf) && !empty($new_password) === !empty($password_conf))
  {
    $image = $u->show($_SESSION['id']);
    if (isset($image['user_id']))
    {
      $u->editPassword($_SESSION['id'], $password, $new_password, $password_conf);
    } else {
      $u->createIcon($name, $type, $content, $size, $id);
    }
  }
  header('Location: /views/user.php?'.$_SESSION['nickname']);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Otete</title>
  <!-- css -->
  <link rel="stylesheet" href="/views/css/destyle.css">
  <link rel="stylesheet" href="/views/css/index.css">
  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- favicon -->
  <link rel="icon" type="image/png" href="/views/images/favicon.png">
</head>
<body>
  <header>
    <div class="left">
      <h1><a href="/views/home.php">Otete</a></h1>
    </div>
    <div class="right">
      <ul>
        <li><a href="/views/about.php">Oteteとは</a></li>
        <li><a href="/views/user.php?<? print $_SESSION['nickname']; ?>">マイページ</a></li>
        <li><a href="/views/Logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header><!-- header -->
  <div class="layout">
    <div class="container">
      <h1 class="card_header">プロフィール変更</h1>
      <div class="user_icon user_icon_position">
        <? $u->show($_SESSION['id']); ?>
      </div>
      <form action="/backend/user/Edit.php" method="post" enctype="multipart/form-data" class="form">
      <input type="hidden" name="max_file_size" value="1000000">
        <input type="file" name="image">
        <input type="submit" class="btn">
      </form>
    </div>
  </div><!-- nickname_change_form -->
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