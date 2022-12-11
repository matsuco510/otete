<?
declare(strict_types=1);

namespace RecipeApplication;

use RecipeApplication\RecipeCOntroller;

require_once 'RecipeController.php';

session_start();

// キャンセルをクリックされたらユーザーページへ移遷する
$r = new RecipeController();
if (isset($_POST['cancel']))
{
  header('Location: /views/user.php?'.$_SESSION['nickname']);
}

// 削除をクリックされたら処理する
if (isset($_POST['delete']))
{
  $recipes = $_POST['recipe'];
  $r->delWeek($recipes, $_SESSION['id']);
  header('Location: /views/user.php?'.$_SESSION['nickname']);
}
?>