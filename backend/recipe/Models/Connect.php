<?
declare(strict_types=1);

  function connectRecipe(): PDO
  {
    $dsn = 'mysql:dbname=homestead; host=localhost; charset=utf8';
    $usr = 'root';
    $passwd = 'root';
      
    $pdo = new PDO($dsn, $usr, $passwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
  }