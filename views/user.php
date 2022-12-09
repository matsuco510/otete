<?
declare(strict_types=1);

namespace UserApplication;
namespace RecipeApplication;

use UserApplication\UserController;
use RecipeApplication\RecipeController;
use \DateTime;

require_once '../backend/user/UserController.php';
require_once '../backend/recipe/RecipeController.php';
session_start();

// セッションが切れたらログインページに遷移
if (!isset($_SESSION['id'])) {
header("Location: login.php");
}

$u = new UserController();
$r = new RecipeController();
$weeks = $r->showWeek($_SESSION['id']);
?>
<!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? print $_SESSION['nickname']; ?>さんのページ</title>
    <!-- css -->
    <link rel="stylesheet" href="./css/destyle.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/mobile.css">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/6f9f6b33ef.js" crossorigin="anonymous"></script>
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
    <div class="user">
      <div id="user_mobile">
        <div class="user_prof">
          <ul>
            <li class="nickname">
              <div class="user_name">
                <?
                print $_SESSION['nickname'];
                ?>
              </div>
            </li>
            <li class="user_icon">
              <?
              $u->show($_SESSION['id']);
              ?>
            </li>
          </ul>
        </div>
        <div class="mobile_user_menu">
          <a href="./user_edit.php" class="menu_btn">
            <img src="./images/avocado.png" alt="avocado"> プロフィール変更
          </a>
          <a href="/views/recipe.php" class="menu_btn">
            <img src="./images/strawberry.png" alt="strawberry"> メニュー一覧
          </a>
          <a href="./recipe_insert.php" class="menu_btn">
            <img src="./images/milk.png" alt="milk"> 料理の追加
          </a>
          <a href="./week.php"  class="menu_btn">
            <img src="./images/human.png" alt="human"> 週数の設定
          </a>
        </div>
      </div>
      <div class="week_menu">
        <div class="week_edit_del">
          <h1>
          <?
            if (!isset($weeks['recipe_id'])) {
              print 'メニュー一覧';
            } else {
                $before = new DateTime($weeks['before']);
                $after = new DateTime($weeks['after']);
                print $before->format('m月d日〜');
                print $after->format('m月d日のメニュー一覧');?>
          <form method="post">
          <div class="cooking_edit_menu">
            <ul>
              <li><input type="submit" formaction="./week_edit.php" value="変更" class="edit"></li>
              <li><input type="submit" formaction="./week_trash.php" value="調理済み" class="trash"></li>
            </ul>
          </div>
         <? }
            ?>
          </h1>
        </div>
        <?
          if (isset($weeks['recipe_id']))
          {
            if (count(array_keys($weeks)) === 1)
            {
        ?>
        <div class="recipes">
          <div class="form_week">
          <? 
          $count = count($weeks['recipe_id']);
          $recipe_id = $weeks['recipe_id'];
          for ($i = 0;$i < $count;$i++)
          { ?>
            <div class="recipes_item_week">
              <p class="recipe_title">
                <input type="checkbox" name="recipe[]" value="<? print $recipe_id[$i]; ?>">
              <?
              $recipe = $r->show($recipe_id[$i]);
              print $recipe['title'];
              ?>
              </p>
              <div class="recipe_img">
                <a href="./cooking.php?recipe_id=<? print $recipe_id[$i]; ?>">
              <?
              if ($recipe['content_img'] === '') {
              ?>
                  <img src="./images/recipe_no_image.png">
              <?
              } else {
                  $img = base64_encode($recipe['content_img']);
                  print '<img src="data:'.$recipe['name'].';base64,'.$img.'">';
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
        <?
        } elseif (count(array_keys($weeks)) > 1) { ?>
          <div class="recipes">
            <div class="form_week">
              <?
              $count = count($weeks['recipe_id']);
              $recipe_id = $weeks['recipe_id'];
              for ($i = 0;$i < $count;$i++)
              { ?>
              <div class="recipes_item_week">
                <p class="recipe_title">
                  <input type="checkbox" name="recipe[]" value="<? print $recipe_id[$i]; ?>">
             <? 
                $recipe = $r->show($recipe_id[$i]);
                print $recipe['title'];
             ?>
                </p>
                <div class="recipe_img">
                  <a href="./cooking.php?recipe_id=<? print $recipe_id[$i]; ?>">
               <? if ($recipe['content_img'] === '')
                  { ?>
                    <img src="./images/recipe_no_image.png">
               <? } else {
                    $img = base64_encode($recipe['content_img']);
                    print '<img src="data:'.$recipe['name'].';base64,'.$img.'">';
                  } ?>
                  </a>
                </div>
              </div>
           <? }?>
            </div>
          </div>
       <? }
       } ?>
      </div>
    </div>
    </form>
    <div class="user_menu">
      <a href="./user_edit.php" class="menu_btn">
        <img src="./images/avocado.png" alt="avocado"> プロフィール変更
      </a>
      <a href="/views/recipe.php" class="menu_btn">
        <img src="./images/strawberry.png" alt="strawberry"> メニュー一覧
      </a>
      <a href="./recipe_insert.php" class="menu_btn">
        <img src="./images/milk.png" alt="milk"> 料理の追加
      </a>
      <a href="./week.php"  class="menu_btn">
        <img src="./images/human.png" alt="human"> 週数の設定
      </a>
    </div><!-- user_page -->
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