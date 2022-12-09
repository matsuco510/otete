<?
declare(strict_types=1);

session_start();
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
      <h1><a href="../index.php">Otete</a></h1>
    </div>
    <div class="right">
      <ul>
        <li><a href="./about.php">Oteteとは</a></li>
        <li><a href="./user.php?<? print $_SESSION['nickname']; ?>">マイページ</a></li>
        <li><a href="./Logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header><!-- header -->
  <div class="layout">
    <div class="container">
      <h1 class="card_header">ログアウト</h1>
      <form action="../backend/user/Logout.php" class="form" method="post">
        <label for="logout">ログアウトしてもよろしいですか？</label><br>
        <input type="submit" name="logout" value="ログアウト" class="btn">
      </form>
      <h1 class="card_header">OR</h1><br>
      <h1 class="drawal_mobile">退会する</h1>
      <form action="../backend/user/WithDrawal.php" method="post" class="form">
        <p>退会すると、今までのユーザーが登録したデータが全て削除されます<br>
        が、よろしいでしょうか？</p>
        <div class="with_btn">
          <input type="submit" name="withdrawal" value="退会する" class="btn">
        </div>
      </form>
    </div>
  </div>
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