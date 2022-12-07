<?
declare(strict_types=1);

namespace RecipeApplication\Validator;

class Validator {
  
  private $err_msgs;

  public function __construct(string $encoding = 'UTF-8')
  {
    $err_msgs = [];

    mb_internal_encoding($encoding);
    $this->checkEncoding($_GET);
    $this->checkEncoding($_POST);
    
  }

  private function checkEncoding(array $date) {
    foreach ($date as $key => $value) {
      if (!mb_check_encoding($value)) {
        $this->err_msgs[] = "{$key}は不正な文字コードです。";
      }
    }
  }

  public function checkTitle($value)
  {
    if (empty($value))
    {
      $this->err_msgs[] = 'タイトルが未入力です。';
    }
  }

  public function checkMate($values)
  {
    $value = array_filter($values);
    if (empty($value))
    {
      $this->err_msgs[] = '材料が未入力です。';
    }
  }

  public function checkGram($mate, $gram)
  {
    if (!empty($mate) && empty($gram))
    {
      $this->err_msgs[] = '数量が未入力です。';
    }
  }

  public function checkContent($values)
  {
    if (is_array($values) && empty($values))
    {
      $this->err_msgs[] = '作り方が未入力です。';
    }
  }

  public function checkWeekBefore($value)
  {
    if (empty($value))
    {
      $this->err_msgs[] = '開始日が登録されていません。';
    }
  }

  public function checkWeekAfter($value)
  {
    if (empty($value))
    {
      $this->err_msgs[] = '終了日が登録されていません。';
    }
  }

  public function checkWeekRecipe($value)
  {
    if (empty($value) && is_null($value))
    {
      $this->err_msgs[] = 'レシピが選択されていません。';
    }
  }

  public function __invoke()
  {
    if (is_array($this->err_msgs) > 0)
    {
      foreach ($this->err_msgs as $msg)
      {
        print '<li>'.$msg.'</li>';
      }
    }
  }
}