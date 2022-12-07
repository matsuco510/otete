<?
namespace UserApplication;

use UserApplication\UserController;

require_once './UserController.php';

session_start();

$u = new UserController();

$mail = 'gest@gest.com';
$pass = 'gest0000';

$u->login($mail, $pass);
