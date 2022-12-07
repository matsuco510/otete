<?
declare(strict_types=1);

namespace RecipeApplication;

use RecipeApplication;

require_once '../backend/recipe/RecipeController.php';

session_start();
// セッションが切れたらログインページに遷移
if (!isset($_SESSION['id'])) {
header("Location: login.php");
}

$r = new RecipeController();
$recipes = $r->showUser($_SESSION['id']);
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
    <form action="../backend/recipe/Search.php" method="post">
      <div class="search">
        <input type="text" name="search" class="search_control">
        <input type="submit" value="検　索" class="search_btn">
      </div>
    </form><!-- search -->
      <?
      if (!empty($recipes))
      {
        if (count(array_keys($recipes)) === 1) { ?>
    <div class="recipes">
      <div class="form_recipe">
        <?
        $count = count($recipes['recipe_id']);
        $title = $recipes['title'];
        $recipe_id = $recipes['recipe_id'];
        for($i = 0;$i < $count;$i++)
        { ?>
        <div class="recipes_item">
          <p class="recipe_title">
            <? print $title[$i]; ?>
          </p>
          <div class="recipe_img">
            <a href="./cooking.php?recipe_id=<? print $recipe_id[$i]; ?>">
       <? $image = $r->show($recipe_id[$i]);
          if ($image['content_img'] === '') {
        ?>
            <img src="./images/recipe_no_image.png">
        <?
          } else {
            $img = base64_encode($image['content_img']);
            print '<img src="data:'.$image['name'].';base64,'.$img.'">';
          }
        ?>
              </a>
            </div>
          </div>
       <? } ?>
      </div>
    </div>
        <?
        } elseif (count(array_keys($recipes)) > 1) { ?>
    <div class="recipes">
      <div class="form_recipe">
      <? 
          $count = count($recipes['recipe_id']);
          $title = $recipes['title'];
          $recipe_id = $recipes['recipe_id'];
          for ($i = 0;$i < $count;$i++)
          {
       ?>
          <div class="recipes_item">
            <p class="recipe_title">
              <? print $title[$i]; ?>
            </p>
            <div class="recipe_img">
              <a href="./cooking.php?recipe_id=<? print $recipe_id[$i]; ?>">
         <? $image = $r->show($recipe_id[$i]);
            if ($image['content_img'] === '')
            { ?>
                <img src="./images/recipe_no_image.png">
         <? } else {
              $img = base64_encode($image['content_img']);
              print '<img src="data:'.$image['name'].';base64,'.$img.'">';
            }
           ?>
            </a>
            </div>
          </div>
         <?
          }
        ?>
      </div>
    </div>
    <? }
    } else { ?>
    <div class="no_recipe">
      <img src="./images/squirrel.png" alt="squirrel">
      <h1>レシピが登録されていません。</h1>
      <a href="./recipe_insert.php" class="recipe_btn">レシピを追加</a>
    </div>
    <? } ?><!-- recipe_menu -->
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