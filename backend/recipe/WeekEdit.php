<?
declare(strict_types=1);

namespace RecipeApplication;

use RecipeApplication\RecipeController;
use RecipeApplication\Validator\Validator;

require_once 'RecipeController.php';
require_once 'Validator.php';

session_start();

// 変数に定義
$before = $_POST['before'];
$after = $_POST['after'];
$recipes_id = $_POST['recipe'];

// バリデーションチェック
$v = new Validator();
$v->checkWeekBefore($before);
$v->checkWeekAfter($after);
$v->checkWeekRecipe($recipes_id);

$r = new RecipeController();

// ユーザーが登録してる料理を定義
$recipes = $r->showUser($_SESSION['id']);
// ユーザーが登録している期間を定義
$weeks = $r->showWeek($_SESSION['id']);

// チェックから外されているレシピを配列に定義
if (isset($weeks['recipe_id']))
{
  $week_del = array_diff($weeks['recipe_id'], $recipes_id);
}

// 新たにチェックされている料理を定義
if (!empty($_POST['recipe_in']))
{
  $recipes_in = $_POST['recipe_in'];
}

// それぞれ定義されたものを処理する
if (!empty($before) && !empty($after) || !empty($recipes_in) || !empty($week_del))
{

  // チェックから外された料理を削除、または変更
  $r->delWeek($week_del, $_SESSION['id']);
  $r->editWeek($before, $after, $_SESSION['id'], $recipes_id);

  // 新しくチェックされた料理を登録
  if (isset($recipes_in))
  {
    $r->createWeek($before, $after, $recipes_in, $_SESSION['id']);
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
  <link rel="stylesheet" href="/views/css/mobile.css">
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
      <h1 class="card_header">週数とレシピを決める</h1>
      <div class="err_msg">
        <? $v->__invoke();?>
      </div>
      <form action="/backend/recipe/WeekEdit.php" method="post">
        <label for="week" class="week_title">週数を設定</label>
        <div class="week">
          <input type="date" name="before" class="week_control" value="<? print $weeks['before'];?>">
          〜
          <input type="date" name="after" class="week_control" value="<? print $weeks['after']; ?>">
        </div>
        <?
        if (count(array_keys($recipes)) === 1) { ?>
    <div class="recipes">
      <div class="form_week">
        <? 
        $count = count($recipes['recipe_id']);
        $title = $recipes['title'];
        $recipe_id = $recipes['recipe_id'];
        $week = array_intersect($recipe_id, $weeks['recipe_id']);
        for ($i = 0;$i < $count;$i++)
        { ?>
        <div class="recipes_item">
       <? if (empty($week[$i]))
          { ?>
          <p class="recipe_title">
            <input type="checkbox" name="recipe_in[]" value="<? print $recipe_id[$i]; ?>"> <? print $title[$i]; ?>
          </p>
       <? } else {?>
        <p class="recipe_title">
          <input type="checkbox" name="recipe[]" value="<? print $recipe_id[$i]; ?>" checked> <? print $title[$i]; ?>
        </p>
       <? } ?>
          <div class="recipe_img">
            <a href="/views/cooking.php?recipe_id=<? print $recipe_id[$i]; ?>">
        <? 
            $image = $r->show($recipe_id[$i]);
            if ($image['content_img'] === '')
            {
        ?>
            <img src="/views/images/no_image.jpg">
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
        <div class="btn_form">
          <input type="submit" value="追　加" class="btn">
          <button type="submit" name="cancel" class="cancel_btn">キャンセル</button>
        </div>
      </div>
    </div>
        <?
        } elseif (count(array_keys($recipes)) > 1) { ?>
    <div class="recipes">
      <div class="form_week">
       <? 
        $count = count($recipes['recipe_id']);
        $title = $recipes['title'];
        $recipe_id = $recipes['recipe_id'];
        if (isset($weeks['recipe_id']))
        {
          $week = array_intersect($recipe_id, $weeks['recipe_id']);
        }
        for ($i = 0;$i < $count;$i++)
        {
        ?>
          <div class="recipes_item">
       <? if (empty($week[$i]))
          { ?>
            <p class="recipe_title">
              <input type="checkbox" name="recipe_in[]" value="<? print $recipe_id[$i]; ?>"> <? print $title[$i]; ?>
            </p>
         <? } else { ?>
            <p class="recipe_title">
              <input type="checkbox" name="recipe[]" value="<? print $recipe_id[$i]; ?>" checked> <? print $title[$i]; ?>
            </p>
              <? 
            } ?>
            <div class="recipe_img">
              <a href="/views/cooking.php?recipe_id=<? print $recipe_id[$i]; ?>">
            <?
            $image = $r->show($recipe_id[$i]);
            if ($image['content_img'] === '')
            { ?>
                <img src="/views/images/no_image.jpg">
          <?} else {
                $img = base64_encode($image['content_img']);
                print '<img src="data:'.$image['name'].';base64,'.$img.'">';
            }
          ?>
            </a>
          </div>
        </div>
        <?}?>
      </div>
    </div>
    <div class="btn_form">
      <input type="submit" value="追　加" class="btn">
      <button type="submit" name="cancel" class="cancel_btn">キャンセル</button>
    </div>
    <? } else { ?>
    <div class="no_recipe">
      <img src="./images/squirrel.png" alt="squirrel">
      <h1>レシピが登録されていません。</h1>
      <a href="/views/recipe_insert.php" class="week_btn">レシピを追加</a>
    </div>
    <? } ?><!-- recipe_menu -->
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
  </body>
</html>