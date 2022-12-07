<?
declare(strict_types=1);

namespace UserApplication;

use UserApplication\Models\UserModel;
use UserApplication\Models\IconModel;

require_once dirname(__FILE__) . '/Models/UserModel.php';
require_once dirname(__FILE__) . '/Models/IconModel.php';

class UserModelFactory
{
  public function createUserModel(): UserModel
  {
    return new UserModel();
  }

  public function createIconModel(): IconModel
  {
    return new IconModel();
  }
}