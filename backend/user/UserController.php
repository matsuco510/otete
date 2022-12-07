<?
declare(strict_types=1);

namespace UserApplication;

require_once 'UserModelFactory.php';

class UserController
{

  private $modelFactory;

  public function __construct()
  {
    $this->modelFactory = new UserModelFactory();
  }

  public function show($id)
  {
    $images = $this->modelFactory->createIconModel()->find($id);
    if (empty($images))
    {
      print '<img src="/views/images/no_image.png">';
    } else {
      foreach ($images as $image)
      {  
        $img = base64_encode($image['content']);
        print '<img src="data:'.$image['name'].';base64,'.$img.'">';
      }
    }
  }

  public function edit($id, $nickname, $mail)
  {
    $this->modelFactory->createUserModel()->editNickname($id, $nickname);

    $this->modelFactory->createUserModel()->editMail($id, $mail);
  }

  public function editImage($name, $type, $content, $size, $id)
  {
    $image = $this->modelFactory->createIconModel()->find($id);
    if (!empty($image))
    {
      $this->modelFactory->createIconModel()->edit($name, $type, $content, $size, $id);
    } else {
      $this->modelFactory->createIconModel()->create($name, $type, $content, $size, $id);
    }
  }

  public function editPassword($id, $password, $new_password, $password_conf)
  {
    $user_password = $this->modelFactory->createUserModel()->find($id);
    foreach ($user_password as $pass)
    {
      print_r($pass);
      if (isset($pass['pass']) && password_verify($password, $pass['pass']))
      {
        $pass_hash = password_hash($new_password, PASSWORD_DEFAULT);

        try {
          $this->modelFactory->createUserModel()->editPassword($id, $pass_hash);
        } catch (PDOException $e) {
          $r->getMessage();
        }
      }
    }
  }
  public function create($id, $name, $nickname, $mail, $password)
  {
    // パスワードをハッシュ化
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    // 全ての入力値がtrueの場合にDBに登録
    try{
      $this->modelFactory->createUserModel()->create($id, $name, $nickname, $mail, $pass_hash);

      header('Location: /index.php');
    } catch (PDOException $e) {
      $e->getMessage();
    }
  }

  public function createImage($name, $type, $content, $size, $id)
  {
    $this->modelFactory->createIconModel()->create($name, $type, $content, $size, $id);
  }

  public function del($id)
  {
    $this->modelFactory->createUserModel()->del($id);
    $this->modelFactory->createIconModel()->del($id);
  }

  public function login($mail, $password)
  {
    if (!empty($mail) && !empty($password))
    {
      try {
        $users = $this->modelFactory->createUserModel()->findMail($mail);
        if (!empty($users))
        {
          foreach ($users as $user)
          {
            if (isset($user['pass']))
            {

              // パスワードが入力値とDBのパスワードと一致しているかチェック
              if (password_verify($password, $user['pass']))
              {
                $_SESSION['id'] = $user['user_id'];
                $_SESSION['nickname'] = $user['nickname'];
                $_SESSION['mail'] = $user['mail'];
                if (!isset($_SESSION['id']))
                {
                  header('Location: /views/login.php');
                } else {
                  header('Location: /views/user.php?'.$_SESSION['nickname']);
                }
              }
            } else {
              $err = '<li>ユーザーIDまたはパスワードに誤りがあります。</li>';
              return $err;
            }
          }
        } else {
          $no_user = '<li>ユーザーIDまたはパスワードに誤りがあります</li>';
          return $no_user;
        }
      } catch (PDOException $e) {
        $e->getMessage();
      }
    }
  }

  function generateToken()
  {
    $bytes = openssl_random_pseudo_bytes(16);
    return bin2hex($bytes);
  }

  function escape($val)
  {
    return htmlspecialchars($val, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  }
}