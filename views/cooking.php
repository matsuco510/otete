<?
namespace RecipeApplication;

use RecipeApplication\RecipeController;

require_once '../backend/recipe/RecipeController.php';
session_start();
// セッションが切れたらログインページに遷移
if (!isset($_SESSION['id']))
{
  header("Location: login.php");
}

$r = new RecipeController();
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
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/6f9f6b33ef.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <header>
      <div class="left">
        <h1><a href="./index.php">Otete</a></h1>
      </div>
      <div class="right">
        <ul>
          <li><a href="./about.php">Oteteとは</a></li>
          <li><a href="./user.php?<? print $_SESSION['nickname']; ?>">マイページ</a></li>
          <li><a href="./Logout.php">ログアウト</a></li>
        </ul>
      </div>
    </header><!-- header -->
    <div class="cooking_header">
      <div class="cooking_title">
        <h1>
    <?  print $recipes['title']; ?>
        </h1>
      </div>
      <ul class="cooking_edit_menu">
        <li><a href="./recipe_edit.php?recipe_id=<? print $_GET['recipe_id']; ?>" class="edit">編集</a></li>
        <li><a href="./recipe_trash.php?recipe_id=<? print $_GET['recipe_id']; ?>" class="trash">削除</a></li>
      </ul>
    </div>
    <div class="cooking">
      <div class="cooking_left">
      <?
      if ($recipes['content_img'] === '') { ?>
         <img src="./images/recipe_no_image.png" alt="no_image">
   <? } else {
        $img = base64_encode($recipes['content_img']);
        print '<img src="data:'.$recipes['name'].';base64,'.$img.'">';
      }
  ?>
      </div>
      <div class="cooking_right">
        <ul>
          <? 
          $mate_count = count($recipes['mate']);
          $mates = $recipes['mate'];
          $grams = $recipes['gram'];
          for ($i = 0;$i < $mate_count; $i++)
          {
          ?>
          <li>
          <?
            print $mates[$i];
            ?>
            <span class="gram">
            <?
              print $grams[$i];
            ?>
            </span>
          </li>
          <?
          }
        ?>
        </ul>
      </div>
    </div>
    <div class="cooking_contents">
      <?
      if (!empty($recipes['sub_content']))
      {
      ?>
        <div class="sub_content">
          <h1>下準備するもの</h1>
          <li>
        <?
        foreach ($recipes['sub_content'] as $sub_content)
        {
          print '<li>'.$sub_content.'</li>';
        }
        ?>
          </li>
        </div>
    <?}?>
        <div class="contents">
          <h1>作り方</h1>
          <? foreach ($recipes['content'] as $content) 
          {
         ?>
          <li>
        <? print $content; ?>
          </li>
       <? } ?>
        </div>
    </div><!--- cooking -->
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