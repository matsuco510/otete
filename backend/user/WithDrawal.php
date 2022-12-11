<?
declare(strict_types=1);

namespace UserApplication;
namespace RecipeApplication;

use UserApplication\UserController;
use RecipeApplication\RecipeController;

require_once 'UserController.php';
require_once '../recipe/RecipeController.php';

session_start();

// 登録情報の削除
if (!empty($_POST['withdrawal']))
{
  $r = new RecipeController();
  $u = new UserController();
  $r->del($_SESSION['id']);
  $u->del($_SESSION['id']);
  header('Location: /index.php');
}