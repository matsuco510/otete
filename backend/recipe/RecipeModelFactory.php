<?
declare(strict_types=1);

namespace RecipeApplication;

use RecipeApplication\Models\TitleModel;
use RecipeApplication\Models\MateModel;
use RecipeApplication\Models\SubContentModel;
use RecipeApplication\Models\ContentModel;
use RecipeApplication\Models\ImageModel;
use RecipeApplication\Models\WeekModel;

require_once dirname(__FILE__) . '/Models/TitleModel.php';
require_once dirname(__FILE__) . '/Models/MateModel.php';
require_once dirname(__FILE__) . '/Models/SubContentModel.php';
require_once dirname(__FILE__) . '/Models/ContentModel.php';
require_once dirname(__FILE__) . '/Models/ImageModel.php';
require_once dirname(__FILE__) . '/Models/WeekModel.php';

class RecipeModelFactory
{

  public function createTitleModel(): TitleModel
  {
    return new TitleModel();
  }

  public function createMateModel(): MateModel
  {
    return new MateModel();
  }

  public function createSubContentModel(): SubContentModel
  {
    return new SubContentModel();
  }

  public function createContentModel(): ContentModel
  {
    return new ContentModel();
  }

  public function createImageModel(): ImageModel
  {
    return new ImageModel();
  }

  public function createWeekModel(): WeekModel
  {
    return new WeekModel();
  }
}