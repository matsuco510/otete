<?
declare(strict_types=1);

namespace RecipeApplication;

use RecipeApplication\Validator\Validator;
use RecipeApplication\RecipeController;

require_once 'RecipeController.php';
require_once 'Validator.php';

session_start();

if (!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token'])
{
  header('Location: /views/recipe_insert.php');
}

unset($_SESSION['token']);
$r = new RecipeController();

// 写真のデータを変数に代入
if (!empty($_FILES['image']['tmp_name']))
{
  $name = $_FILES['image']['name'];
  $type = $_FILES['image']['type'];
  $content_img = file_get_contents($_FILES['image']['tmp_name']);
  $size = $_FILES['image']['size'];

  // 画像を一時的にセッションに保存し、表示する。
  $_SESSION['image']['content'] = $content_img;
  $_SESSION['image']['name'] = $name;
}

// 新規登録するレシピを変数に代入
$title = $r->escape($_POST['title']);
$mates = $_POST['mate'];
$grams = $_POST['gram'];
$contents = array_filter($_POST['content']);

$v = new Validator();
$v->checkTitle($title);
$v->checkMate($mates);
$v->checkGram($mates, $grams);
$v->checkContent($contents);

if (!empty($mates) && !empty($grams))
{
  $mate_all = array_combine($mates, $grams);
}

if (!empty($_POST['sub_content']))
{
  $sub_contents = array_filter($_POST['sub_content']);
}

if (isset($_POST['cancel']))
{
  header('Location: /views/user.php?'.$_SESSION['nickname']);
  unset($_SESSION['image']);
}

if (!empty($title) && !empty($mate_all) && !empty($contents) || !empty($sub_contents))
{
  $r->create($title, $_SESSION['id'], $mate_all, $contents);
  $r->createSub($sub_contents, $title, $_SESSION['id']);
  if (isset($name) && isset($type) && isset($content_img) && isset($size))
  {
    $r->createImage($name, $type, $content_img, $size, $title, $_SESSION['id']);
  }

  header('Location: /views/user.php?'.$_SESSION['id']);
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
        <li><a href="/views/user.php?<? print $_SESSION['nickname']; ?>">マイページ</a></li>
        <li><a href="/views/Logout.php">ログアウト</a></li>
      </ul>
    </div>
  </header><!-- header -->
  <div class="layout">
    <div class="container">
      <h1 class="card_header">料理の登録を確認する</h1>
      <div class="err_msg">
    <?
      $v->__invoke();
    ?>
    </div>
      <form action="/backend/recipe/Create.php" method="post" enctype="multipart/form-data" id="menu" class="form">
        <label for="image"  style="font-weight: 600;">料理の写真</label><br>
        <div class="image">
        <?
        if (isset($_SESSION['image']['content']))
        {
          $img = base64_encode($_SESSION['image']['content']);
          print '<img src="data:'.$_SESSION['image']['name'].';base64,'.$img.'">';
        } else {
          print '<img src="/views/images/recipe_no_image.png">';
        }
        ?>
        </div>
        <label for="file" style="font-size: 14px; color: red;">4MB以内の画像を登録してください。</label><br>
        <input type="file" name="image" enctype="multipart/form-data"><br>
        <label for="title" style="font-weight: 600;">タイトル</label><br>
        <?
          if (!empty($title))
          {
        ?>
        <input type="text" name="title" value="<? print $title; ?>" class="form_control"><br>
        <?
          } else {
        ?>
        <input type="text" name="title" class="form_control"><br>
        <?
          }
        ?>
        <table>
          <thead>
            <tr>
              <th>材料</th>
              <th>数量</th>
            </tr>
          </thead>
            <?
            if (!is_array($mates) && !is_array($grams))
            {
              foreach ($mate_all as $mate => $gram)
              {
            ?>
          <tbody>
            <tr>
              <td>
                <input type="text" name="mate[]" class="mate_control" value="<? print $mate; ?>">
              </td>
              <td>
                <input type="text" name="gram[]" class="gram_control" value="<? print $gram; ?>">
              </td>
            </tr>
          </tbody>
            <?
              }
            } else {
            ?>
          <tbody>
            <tr>
              <td><input type="text" name="mate[]" class="mate_control"></td>
              <td><input type="text" name="gram[]" class="gram_control"></td>
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
            <?
              }
            ?>
        </table><br>
        <label for="sub_content" style="font-weight: 600;">下準備</label><br>
        <?
        if (!empty($sub_contents))
        {
          foreach ($sub_contents as $sub_content)
          {
        ?>
          <input type="text" name="sub_content[]" value="<? print $sub_content; ?>" class="form_control"><br>
        <?
          }
        } else {?>
          <input type="text" name="sub_content[]" class="form_control"><br>
          <input type="text" name="sub_content[]" class="form_control"><br>
          <input type="text" name="sub_content[]" class="form_control"><br>
          <input type="text" name="sub_content[]" class="form_control"><br>
          <input type="text" name="sub_content[]" class="form_control"><br>
        <?
        }
        ?>
        <label for="content" style="font-weight: 600;">作り方</label><br>
        <?
        if (!empty($content))
        {
        
          foreach ($contents as $content)
          {
        ?>
        <input type="text" name="content[]" value="<? print $content; ?>" class="form_control"><br>
        <?}
        } else {
        ?>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>
        <input type="text" name="content[]" class="form_control"><br>

        <?
        }
        ?>
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
        <li><a href="/views/termsOfUse.php">利用規約</a></li>
        <li><a href="/views/privacy.php">プライバシーポリシー</a></li>
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