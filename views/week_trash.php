<?
declare(strict_types=1);

namespace RecipeApplication;

use RecipeApplication\RecipeController;
use RecipeApplication\Validator\Validator;

require_once '../backend/recipe/RecipeController.php';
require_once '../backend/recipe/Validator.php';

session_start();

// セッションが切れたらログインページに遷移
if (!isset($_SESSION['id']))
{
  header("Location: login.php");
}

$v = new Validator();
if (empty($_POST['recipe']))
{
  $v->checkWeekRecipe($_POST['recipe']);
}

$r = new RecipeController();
$weeks = $r->showWeek($_SESSION['id']);
if (!empty($_POST['recipe']))
{
  $recipes_id = $_POST['recipe'];
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
      <h1 class="card_header">調理は済みましたか？</h1>
      <? if (!empty($v->__invoke()))
      {?>
          <div class="err_msgs">
            <? $v->__invoke(); ?>
          </div>
      <? } ?>
      <form action="../backend/recipe/WeekTrash.php" method="post">
        <label for="week">週数</label>
        <div class="week">
          <input type="date" name="before" class="week_control" value="<? print $weeks['before']; ?>">
          〜
          <input type="date" name="after" class="week_control" value="<? print $weeks['after']; ?>">
        </div>
        <?
        if (isset($recipes_id) && !is_null($recipes_id)) { ?>
        <div class="recipes">
          <div class="form_week">
            <?
              foreach ($recipes_id as $recipe_id)
              {
            ?>
            <div class="recipes_item">
              <p class="recipe_title">
                <input type="checkbox" name="recipe[]" value="<? print $recipe_id; ?>" checked> 
                <?
                $recipe = $r->show($recipe_id); 
                print $recipe['title'];?>
              </p>
              <div class="recipe_img">
                <a href="./cooking.php?recipe_id=<? print $recipe_id; ?>">
                <?
                if ($recipe['content_img'] === '')
                { ?>
                  <img src="./images/recipe_no_image.png">
                <? } else {
                  $img = base64_encode($recipe['content_img']);
                  print '<img src="data:'.$recipe['name'].';base64,'.$img.'">';
                } ?>
                </a>
              </div>
            </div>
            <? } ?>
        </div>
      </div>
        <div class="btn_form">
          <input type="submit" name="delete" value="　OK　" class="btn">
          <button type="submit" name="cancel" class="cancel_btn">キャンセル</button>
    </div>
        <? } elseif (empty($_POST['recipe'])) { ?>
    <div class="recipes">
      <div class="form_week">
       <? $count = count($weeks['recipe_id']);
          $recipe_id = $weeks['recipe_id'];
          for ($i = 0;$i < $count;$i++)
          { ?>
            <div class="recipes_item">
              <p class="recipe_title">
                <input type="checkbox" name="recipe[]" value="<? print $recipe_id[$i]; ?>"> 
                <?
                $recipe = $r->show($recipe_id[$i]); 
                print $recipe['title'];?>
              </p>
              <div class="recipe_img">
                <a href="./cooking.php?recipe_id=<? print $recipe_id[$i]; ?>">
                <?
                if ($recipe['content_img'] === '')
                { ?>
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
           <? } ?>
          <div class="btn_form">
            <input type="submit" name="delete" value="O K" class="btn">
            <button type="submit" name="cancel" class="cancel_btn">キャンセル</button>
          </div>
        </div>
      </div>
     <? } ?>
      </form>
    </div>
  </div><!-- week_cooking-->
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