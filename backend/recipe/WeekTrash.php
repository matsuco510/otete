<?
declare(strict_types=1);

namespace RecipeApplication;

use RecipeApplication\RecipeCOntroller;

require_once 'RecipeController.php';

session_start();

$r = new RecipeController();
if (isset($_POST['cancel']))
{
  header('Location: /views/user.php?'.$_SESSION['nickname']);
}

if (isset($_POST['delete']))
{
  $recipes = $_POST['recipe'];
  $r->delWeek($recipes, $_SESSION['id']);
  header('Location: /views/user.php?'.$_SESSION['nickname']);
}
?>