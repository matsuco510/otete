<?
namespace RecipeApplication;

use RecipeApplication;

require_once '../backend/recipe/RecipeController.php';

session_start();
$r = new RecipeController();
$token = $r->generateToken();
$_SESSION['token'] = $token;

// セッションが切れたらログインページに遷移
if (!isset($_SESSION['id'])) {
header("Location: login.php");
}

$recipes = $r->show($_GET['recipe_id']);
?>
<!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? print $_SESSION['nickname'];?>さんのページ</title>
    <!-- css -->
    <link rel="stylesheet" href="./css/destyle.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/mobile.css">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
    <!-- font awesome -->
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
        <h1 class="card_header">料理を編集する</h1>
        <div class="edit_container">
          <form action="../backend/recipe/Edit.php?recipe_id=<? print $_GET['recipe_id']; ?>" method="post" enctype="multipart/form-data" id="menu" class="form">
          <input type="hidden" name="token" value="<? print $token; ?>">
          <label for="image">写真を変更</label><br>
          <div class="image">
          <? if ($recipes['content_img'] === '')
          {
            print '<img src="./images/recipe_no_image.png">'; ?><br>
      <? } else {
            $img = base64_encode($recipes['content_img']);
            print '<img src="data:'.$recipes['name'].';base64,'.$img.'">'; ?><br>
      <? } ?>
          </div>
          <label for="file" class="image_attention">4MB以内の画像を登録してください。</label><br>
          <input type="file" name="image" enctype="multipart/form-data"><br>
          <label for="title">タイトル</label><br>
          <input type="text" name="title" value="<? print $recipes['title']; ?>" class="form_control">
          <table>
            <thead>
              <tr>
                <th>材料</th>
                <th>数量</th><br>
              </tr>
            </thead>
            <tbody>
            <?
                if (isset($recipes['mate_id']))
                {
            ?>
              <? foreach ($recipes['mate_id'] as $key => $mate_id)
                { 
              ?>
                <input type="hidden" name="mates_id[]" value="<? print $mate_id; ?>">
            <? }
              $mates = array_combine($recipes['mate'], $recipes['gram']);
              foreach ($mates as $mate => $gram)
              {
              ?>
              <tr>
                <td>
                  <input type="text" name="mates[]" id="mate" class="mate_control" value="<? print $mate; ?>">
                </td>
                <td>
                  <input type="text" name="grams[]" id="gram" class="gram_control" value="<? print $gram; ?>">
                </td>
              </tr>
          <? }
          } ?>
            <tr>
                <td><input type="text" name="mates_in[]" id="mate" class="mate_control"></td>
                <td><input type="text" name="grams_in[]" id="gram" class="gram_control"></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td>
                  <button type="button" id="add">＋</button>
                </td>
              </tr>
            </tfoot>
          </table>
          <label>下準備</label><br>
          <? 
          if (!empty($recipes['sub_content']))
          {
            foreach ($recipes['sub_content_id'] as $sub_content_id)
            {
          ?>
            <input type="hidden" name="sub_content_id[]" value="<? print $sub_content_id; ?>">
          <? }
            foreach ($recipes['sub_content'] as $sub_content)
            { ?>
            <input type="text" name="sub_content[]" class="form_control" value="<? print $sub_content; ?>"><br>
        <? }
          } ?>
            <input type="text" name="sub_in[]" class="form_control"><br>
            <input type="text" name="sub_in[]" class="form_control"><br>
            <input type="text" name="sub_in[]" class="form_control"><br>
            <input type="text" name="sub_in[]" class="form_control"><br>
            <input type="text" name="sub_in[]" class="form_control"><br>
          <label>作り方</label><br>
          <?
            if (isset($recipes['content_id'])) {
              foreach ($recipes['content_id'] as $content_id) {
          ?>
            <input type="hidden" name="content_id[]" value="<? print $content_id;?>">
          <? }
              foreach($recipes['content'] as $content)
              {
            ?>
            <input type="text" name="content[]" class="form_control" value="<? print $content;?>"><br>
            <? }
            } else { ?>
            <input type="text" name="con_in[]" class="form_control"><br>
            <input type="text" name="con_in[]" class="form_control"><br>
            <input type="text" name="con_in[]" class="form_control"><br>
            <input type="text" name="con_in[]" class="form_control"><br>
            <input type="text" name="con_in[]" class="form_control"><br>
          <? } ?>
          <input type="text" name="con_in[]" class="form_control"><br>
          <input type="text" name="con_in[]" class="form_control"><br>
          <div class="btn_form">
            <input type="submit" name="edit_btn" value="変　更" class="btn">
            <button type="submit" name="cancel" class="cancel_btn">キャンセル</button>
          </div>
        </form>
      </div>
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
        '<td><input type="text" name="mates_in[]" class="mate_control"></td>' +
        '<td><input type="text" name="grams_in[]" class="gram_control"></td>' +
      '</tr>';

      $(tr_form).appendTo($('table > tbody'));

      });
    });
  </script>
  </body>
</html>