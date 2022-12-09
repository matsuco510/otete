<?
namespace RecipeApplication;

use RecipeApplication\RecipeController;
use RecipeApplication\Validator;

require_once '../backend/recipe/RecipeController.php';
require_once '../backend/recipe/Validator.php';

session_start();

$r = new RecipeController();
$token = $r->generateToken();
$_SESSION['token'] = $token;
// セッションが切れたらログインページに遷移
if (!isset($_SESSION['id'])) {
header("Location: login.php");
}

if (!empty($_SESSION['image']['content']))
{
  unset($_SESSION['image']);
}

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
      <li><a href="./logout.php">ログアウト</a></li>
    </ul>
  </div>
  </header><!-- header -->
  <div class="layout">
    <div class="container">
    <h1 class="card_header">料理を登録する</h1>
      <form action="../backend/recipe/Create.php" method="post" enctype="multipart/form-data" id="menu" class="form">
        <input type="hidden" name="token" value="<? print $token; ?>">
        <label for="image">料理の写真</label><br>
        <label for="file" class="image_attention">4MB以内の画像を登録してください。</label><br>
        <input type="file" name="image" enctype="multipart/form-data"><br>
        <label for="title">タイトル</label><br>
        <input type="text" name="title" class="form_control"><br>
        <table>
          <thead>
            <tr>
              <th>材料</th>
              <th>数量</th><br>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" name="mate[]" id="mate" class="mate_control"></td>
              <td><input type="text" name="gram[]" id="gram" class="gram_control"></td>
            </tr>
            <tr>
              <td><input type="text" name="mate[]" id="mate" class="mate_control"></td>
              <td><input type="text" name="gram[]" id="gram" class="gram_control"></td>
            </tr>
            <tr>
              <td><input type="text" name="mate[]" id="mate" class="mate_control"></td>
              <td><input type="text" name="gram[]" id="gram" class="gram_control"></td>
            </tr>
            <tr>
              <td><input type="text" name="mate[]" id="mate" class="mate_control"></td>
              <td><input type="text" name="gram[]" id="gram" class="gram_control"></td>
            </tr>
            <tr>
              <td><input type="text" name="mate[]" id="mate" class="mate_control"></td>
              <td><input type="text" name="gram[]" id="gram" class="gram_control"></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td><button type="button" id="add">＋</button></td>
            </tr>
          </tfoot>
        </table>
        <label>下準備</label><br>
        <input type="text" name="sub_content[]" class="form_control"><br>
        <input type="text" name="sub_content[]" class="form_control"><br>
        <input type="text" name="sub_content[]" class="form_control"><br>
        <input type="text" name="sub_content[]" class="form_control"><br>
        <input type="text" name="sub_content[]" class="form_control"><br>
        <label>作り方</label><br>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>
        <div class="btn_form">
          <input type="submit" value="追　加" class="btn">
          <button type="submit" name="cancel" class="cancel_btn">キャンセル</button>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript">
    'use strict';
    $(function() {

      $('button#add').click(function(){

      var tr_form = '' +
      '<tr>' +
        '<td><input type="text" name="mate[]" class="mate_control"></td>' +
        '<td><input type="text" name="gram[]" class="gram_control"></td>' +
      '</tr>';

      $(tr_form).appendTo($('table > tbody'));

      });
    });
  </script>
  </body>
</html>