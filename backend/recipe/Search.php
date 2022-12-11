<?
declare(strict_types=1);

namespace RecipeApplication;

use RecipeApplication\RecipeController;

require_once 'RecipeController.php';

session_start();

// // セッションが切れたらログインページに遷移
if (!isset($_SESSION['id']))
{
  header("Location: /views/login.php");
}

// 検索キーワードを変数に定義
$keyword = $_POST['search'];

$r = new RecipeController();
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
  <form action="/backend/recipe/Search.php" method="post">
    <div class="search">
      <input type="text" name="search" class="search_control" value="<? print $keyword; ?>">
      <input type="submit" value="検　索" class="search_btn">
    </div>
  </form><!-- search -->
  <?
  // キーワードを検索
  if (!empty($keyword))
  {
    $searches = $r->search($keyword, $_SESSION['id']);
    if (isset($searches))
    {
      foreach ($searches as $search)
      {
        $recipes = $r->show($search);
        $title[] = $recipes['title'];
        $recipe_id[] = $search;
      }
  ?>
  <div class="recipes">
    <div class="form_recipe">
      <?
        $count = count($searches);
        for ($i = 0;$i < $count;$i++)
        { ?>
      <div class="recipes_item">
        <p class="recipe_title">
          <? print $title[$i]; ?>
        </p>
        <div class="recipe_img">
          <a href="/views/cooking.php?recipe_id=<? print $recipe_id[$i]; ?>">
      <? $image = $r->show($recipe_id[$i]);
          if ($image['content_img'] === '')
          { ?>
            <img src="/views/images/recipe_no_image.png">
      <?
          } else {
            $img = base64_encode($image['content_img']);
            print '<img src="data:'.$image['name'].';base64,'.$img.'">';
          }?>
          </a>
        </div>
      </div>
      <?
        }
    } else { ?>
      <div class="no_recipe">
        <img src="/views/images/squirrel.png" alt="squirrel">
        <h1>『<? print $keyword; ?>』を含むレシピは見つかりませんでした。</h1>
      </div>
    <?
    }
      ?>
    </div>
  </div>
  <?
  } else {
  ?>
  <div class="no_recipe">
    <img src="/views/images/squirrel.png" alt="squirrel">
    <h1>検索ワードを入力してください。</h1>
  </div>
  <?
  }
  ?>
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