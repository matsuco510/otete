<?
namespace RecipeApplication;

use RecipeApplication\RecipeController;

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
      <h1 class="trash_title">本当に削除してもよろしいですか？</h1>
      <p class="trash_explanation"><span class="trash_exp_icon"></span>削除をすると元に戻すことはできませんのでご注意ください。</p>
      <div class="trash_recipe">
        <form action="../backend/recipe/Trash.php?recipe_id=<? print $_GET['recipe_id'];?>" method="post">
        <input type="hidden" name="token" value="<?print $token; ?>">
        <div class="cooking_header">
          <div class="cooking_title">
            <h1>
              <span class="cooking_title_icon"></span>
        <?  print $recipes['title']; ?>
            </h1>
          </div>
        </div>
        <div class="cooking">
          <div class="cooking_left">
          <?
          if (empty($recipes['image'])) { ?>
            <img src="./images/recipe_no_image.png" alt="no_image">
      <?  } else {
            $images = $recipes['image'];
            foreach ($images as $key => $image) {
              $img = base64_encode($image['content']);
              print '<img src="data:'.$recipe_images['name'].';base64,'.$img.'">';
            }
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
              print $sub_content;
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
        </div>
      </div>
      <div class="btn_form">
        <input type="submit" name="delete" value="削　除" class="trash_btn">
        <button type="submit" name="cancel" class="trash_cancel_btn">キャンセル</button>
      </div>
    </form>
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