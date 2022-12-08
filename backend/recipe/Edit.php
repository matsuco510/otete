<?
namespace RecipeApplication;

require_once 'RecipeController.php';

session_start();

// CSRF対策
if (!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token'])
{
  die('不正なリクエストです。処理を中断します。');
}

unset($_SESSION['token']);

// 変更、登録処理
$r = new RecipeController();
if (!empty($_POST['title']) && !empty($_POST['mates_id']) && !empty($_POST['mates']) && !empty($_POST['grams']) && !empty($_POST['content_id']) && !empty($_POST['content']))
{
  $title = $r->escape($_POST['title']);
  $mates_id = $_POST['mates_id'];
  $mates = $_POST['mates'];
  $grams = $_POST['grams'];
  $contents_id = $_POST['content_id'];
  $contents = $_POST['content'];

  // 材料、下準備、作り方を配列に入れる
  $mates_all = array([
    'mate_id' => $mates_id,
    'mate' => $mates,
    'gram' => $grams,
  ]);

  if (!empty($_POST['sub_content_id']))
  {
    $sub_content_all[] = [
      'sub_content_id' => $_POST['sub_content_id'],
      'sub_content' => $_POST['sub_content'],
    ];
  }

  $content_all = array([
    'content_id' => $contents_id,
    'content' => $contents,
  ]);

  if (!empty($_FILES['image']['tmp_name']))
  {
    $name = $_FILES['image']['name'];
    $type = $_FILES['image']['type'];
    $content_img = file_get_contents($_FILES['image']['tmp_name']);
    $size = $_FILES['image']['size'];
  
    // 画像を一時的にセッションに保存し、表示する。
    $_SESSION['image']['content'] = $content_img;
    $_SESSION['image']['name'] = $name;
  }
  
  // 変更の処理
  $r->edit($_GET['recipe_id'], $title, $mates_all, $content_all, $_SESSION['id']);

  if (!empty($sub_content_all))
  {
    $r->editSub($_GET['recipe_id'], $sub_content_all, $_SESSION['id']);
  }

  if (!empty($content_img))
  {
    $r->editImage($name, $type, $content_img, $size, $_GET['recipe_id'], $_SESSION['id']);
  }
} elseif (isset($_POST['cancel'])) {
  header('Location: /views/user.php?'.$_SESSION['nickname']);
  unset($_SESSION['image']);
}

// 新しく入力があれば、変数に定義
if (isset($_POST['mates_in']) && isset($_POST['grams_in']) || isset($_POST['sub_in']) || isset($_POST['con_in']))
{
  if (!is_null($_POST['mates_in']) && !is_null($_POST['grams_in']))
  {
    $mates_in = $_POST['mates_in'];
    $grams_in = $_POST['grams_in'];
    $mate_in = array_combine($mates_in, $grams_in);
  }
  $sub_in = $_POST['sub_in'];

  $con_in = $_POST['con_in'];
}

// 登録処理
if (!empty($mate_in) && !empty($con_in) || !empty($sub_in))
{
  $r->createMateContent($_GET['recipe_id'], $mate_in, $con_in, $_SESSION['id']);

  $r->createSubContent($_GET['recipe_id'], $sub_in, $_SESSION['id']);
}

header('Location: /views/cooking.php?recipe_id='.$_GET['recipe_id']);