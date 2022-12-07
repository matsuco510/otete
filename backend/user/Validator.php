<?php
declare(strict_types=1);

namespace UserApplication\Validator;

class Validator {

  private $err_msgs;

  public function __construct(string $encoding = 'UTF-8') {
    //プライベート変数$err_msgsを初期化
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


  public function checkId($value) {
    if (empty($value)) {
      $this->err_msgs[] = 'IDが未入力です。';
    }
  }

  public function checkName($value) {
    if (empty($value)) {
      $this->err_msgs[] = '名前が未入力です。';
    }
  }

  public function checkMail($value) {
    if (empty($value)) {
      $this->err_msgs[] = 'メールアドレスが未入力です。';
    }
  }

  public function checkPassword($value) {
    if (empty($value)) {
      $this->err_msgs[] = 'パスワードが未入力です。';
    }

    if (strlen($value) <= 4) {
      $this->err_msgs[] = 'パスワードは4文字以上で入力してください。';
    }

    if (preg_match('/[あ-ょａ-ｚ]/', $value)) {
      $this->err_msgs[] = '半角英数字で入力してください。';
    }
  }

  public function checkPassConf($value) {
    if (empty($value)) {
      $this->err_msgs[] = 'パスワード(確認)が未入力です。';
    }
  }

  public function checkPassMatch($pass, $pass_conf) {
    if ($pass !== $pass_conf) {
      $this->err_msgs[] = 'パスワードとパスワード(確認)が一致しません。';
    }
  }

  public function __invoke() {
    if (is_array($this->err_msgs) > 0) {
      foreach ($this->err_msgs as $msg) {
        print '<li>'.$msg.'</li>';
      } 
    }
  }
}