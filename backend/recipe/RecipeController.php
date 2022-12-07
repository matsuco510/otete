<?

declare(strict_types=1);

namespace RecipeApplication;

require_once dirname(__FILE__) . '/RecipeModelFactory.php';

class RecipeController
{

  private $modelFactory;

  public function __construct()
  {
    $this->modelFactory = new RecipeModelFactory();
  }

  public function showUser($user_id)
  {
    // タイトルの表示
    $recipes = $this->modelFactory->createTitleModel()->findUser($user_id);
    if (!empty($recipes))
    {
      foreach ($recipes as $recipe)
      {
        $title[] = $recipe['title'];
        $recipe_id[] = $recipe['recipe_id'];
      }
      $data = [
        'title' => $title,
        'recipe_id' => $recipe_id,
      ];

      return $data;
    }
  }

  public function show($id)
  {
    // レシピのタイトルを表示
    $recipes = $this->modelFactory->createTitleModel()->findId($id);
    foreach($recipes as $recipe)
    {
      $title = $recipe['title'];
    }

    // 材料と量を表示
    $mate_all = $this->modelFactory->createMateModel()->find($id);
    foreach ($mate_all as $key => $mates)
    {
      $mate_id[] = $mates['mate_id'];
      $mate[] = $mates['mate'];
      $gram[] = $mates['gram'];
    }

    // 下準備が登録されていれば表示
    $sub_content_all = $this->modelFactory->createSubContentModel()->find($id);
    if (empty($sub_content_all))
    {
      $sub_content_id = '';
      $sub_content = '';

    } elseif (!empty($sub_content_all)) {
      foreach ($sub_content_all as $key => $sub_contents)
      {
        $sub_content_id[] = $sub_contents['sub_content_id'];
        $sub_content[] = $sub_contents['sub_content'];
      }
    }

    // 作り方を表示
    $content_all = $this->modelFactory->createContentModel()->find($id);
    foreach ($content_all as $key => $contents)
    {
      $content_id[] = $contents['content_id'];
      $content[] = $contents['content'];
    }

    // 料理の写真を表示
    $images = $this->modelFactory->createImageModel()->find($id);
    if (!empty($images['content']))
    {
      $content_img = $images['content'];
      $name = $images['name'];
    } else {
      $content_img = '';
      $name = '';
    }

    $data = [
      'title' => $title,
      'mate_id' => $mate_id,
      'mate' => $mate,
      'gram' => $gram,
      'sub_content_id' => $sub_content_id,
      'sub_content' => $sub_content,
      'content_id' => $content_id,
      'content' => $content,
      'content_img' => $content_img,
      'name' => $name,
    ];
    return $data;
  }

  public function showWeek($user_id)
  {
    $weeks = $this->modelFactory->createWeekModel()->find($user_id);
    foreach ($weeks as $week)
    {
      if (isset($week['user_id']))
      {
        $recipe_id[] = $week['recipe_id'];
        $before = $week['week_before'];
        $after = $week['week_after'];
      }
    }
    if (!empty($before) && !empty($after) && !empty($recipe_id))
    {
      $data = [
        'before' => $before,
        'after' => $after,
        'recipe_id' => $recipe_id,
        'user_id' => $user_id,
      ];
      return $data;
    }
  }

  public function search($keyword, $user_id)
  {
    if (!empty($keyword))
    {
      $titles_all = $this->modelFactory->createTitleModel()->search($keyword, $user_id);
      $mates_all = $this->modelFactory->createMateModel()->search($keyword, $user_id);
      if (!empty($titles_all))
      {
        foreach ($titles_all as $titles)
        {
          $recipe_id[] = $titles['recipe_id'];
        }
      }
      if (!empty($mates_all))
      {
        foreach ($mates_all as $mates)
        {
          $recipe_id[] = $mates['recipe_id'];
        }
      }
      if (!empty($recipe_id))
      {
        $id = array_unique($recipe_id);      return $id;
      }
    }
  }

  public function create($title, $user_id, $mates, $contents)
  {
    if (!empty($title))
    {
    $recipe = $this->modelFactory->createTitleModel()->create($title, $user_id);
    $recipe_find = $this->modelFactory->createTitleModel()->find($title, $user_id);
    }

    // レシピIDが登録されたら処理を実行する
    if (isset($recipe_find['recipe_id']))
    {
      $id = $recipe_find['recipe_id'];

      // 材料の登録
      foreach ($mates as $mate => $gram)
      {
        if (!empty($mate) && !empty($gram))
        {
        $this->modelFactory->createMateModel()->create($id, $mate, $gram, $user_id);
        }
      }

      // 作り方の登録
      foreach ($contents as $content)
      {
        if (!empty($content))
        {
          $this->modelFactory->createContentModel()->create($id, $content, $user_id);
        }
      }
    }
  }

  public function createMateContent($id, $mates, $contents, $user_id)
  {
    // 材料の登録
    if (!empty($mates))
    {
      foreach ($mates as $mate => $gram)
      {
        if (!empty($mate) && !empty($gram))
        {
          $this->modelFactory->createMateModel()->create($id, $mate, $gram, $user_id);
        }
      }
    }

    // 作り方の登録
    if (!empty($contents))
    {
      foreach ($contents as $content)
      {
        if (!empty($content))
        {
          $this->modelFactory->createContentModel()->create($id, $content, $user_id);
        }
      }
    }
  }

  public function createSub($sub_contents, $title, $user_id)
  {
    $id = $this->modelFactory->createTitleModel()->find($title, $user_id);

    // 下準備の登録
    foreach ($sub_contents as $sub_content)
    {
      if (!empty($sub_content))
      {
        $this->modelFactory->createSubContentModel()->create($id['recipe_id'], $sub_content, $user_id);
      }
    }
  }

  public function createSubContent($id, $sub_contents, $user_id)
  {
    $sub_count = count($sub_contents);
    if ($sub_count > 1)
    {
      foreach ($sub_contents as $sub_content)
      {
        if (!empty($sub_content))
        {
          $this->modelFactory->createSubContentModel()->create($id, $sub_content, $user_id);
        }
      }
    } else {
      if (!empty($sub_content))
      {
        $this->modelFactory->createSubContentModel()->create($id, $sub_content, $user_id);
      }
    }
  }

  public function createImage($name, $type, $content, $size, $title, $user_id)
  {
    $id = $this->modelFactory->createTitleModel()->find($title, $user_id);
    if (!empty($id['recipe_id']))
    {
      $this->modelFactory->createImageModel()->create($name, $type, $content, $size, $id['recipe_id'], $user_id);
    }
  }

  public function createWeek($before, $after, $recipes, $user_id)
  {
    foreach ($recipes as $id)
    {
    $this->modelFactory->createWeekModel()->create($before, $after, $id, $user_id);
    }
  }

  public function edit($id, $title, $mate_all, $content_all, $user_id)
  {
    // タイトルの変更
    $this->modelFactory->createTitleModel()->edit($id, $title, $user_id);

    // 材料と量の変更
    foreach ($mate_all as $key => $mates)
    {
      $mate_count = count($mates['mate']);
      for ($i = 0; $i < $mate_count; $i++)
      {
        $mate = [
          'mate_id' => $mates['mate_id'][$i],
          'mate' => $mates['mate'][$i],
          'gram' => $mates['gram'][$i],
        ];
        $this->modelFactory->createMateModel()->edit($id, $mate['mate_id'], $mate['mate'], $mate['gram'], $user_id);
      }
    }

    foreach ($content_all as $contents)
    {
      $content_count = count($contents['content_id']);
      for ($i = 0; $i < $content_count; $i++)
      {
        $content = [
          'content_id' => $contents['content_id'][$i],
          'content' => $contents['content'][$i],
        ];
        $this->modelFactory->createContentModel()->edit($id, $content['content_id'], $content['content'], $user_id);
      }
    }
  }

  public function editSub($id, $sub_content_all, $user_id)
  {
    foreach ($sub_content_all as $sub_contents)
    {
      $sub_count = count($sub_contents['sub_content_id']);
      if ($sub_count >= 1)
      {    
        for ($i = 0; $i < $sub_count; $i++)
        {
          $sub_content = [
            'sub_content_id' => $sub_contents['sub_content_id'][$i],
            'sub_content' => $sub_contents['sub_content'][$i],
          ];
          $this->modelFactory->createSubContentModel()->edit($id, $sub_content['sub_content_id'], $sub_content['sub_content'], $user_id);
        }
      } elseif ($sub_count == 0) {
        break;
      }
    }
  }

  public function editImage($name, $type, $content, $size, $id, $user_id)
  {
    $images = $this->modelFactory->createImageModel()->find($id);
    if (!empty($images['recipe_id']))
    {
      foreach ($images as $image)
      {
          $this->modelFactory->createImageModel()->edit($name, $type, $content, $size, $id, $user_id);
      }
    }
  }

  public function editWeek($before, $after, $user_id, $recipes_id)
  {
    foreach ($recipes_id as $id)
    {
      $this->modelFactory->createWeekModel()->edit($before, $after, $user_id, $id);
    }
  }

  public function del($id)
  {
    $this->modelFactory->createTitleModel()->del($id);
    $this->modelFactory->createMateModel()->del($id);
    $this->modelFactory->createSubContentModel()->del($id);
    $this->modelFactory->createContentModel()->del($id);
    $this->modelFactory->createImageModel()->del($id);
  }

  public function delWeek($recipes, $user_id)
  {
    foreach ($recipes as $id)
    {
      $this->modelFactory->createWeekModel()->del($id, $user_id);
    }
  }

  public function delUser($user_id)
  {
    $this->modelFactory->createTitleModel()->delUser($user_id);
    $this->modelFactory->createMateModel()->delUser($user_id);
    $this->modelFactory->createSubContentModel()->delUser($user_id);
    $this->modelFactory->createContentModel()->delUser($user_id);
    $this->modelFactory->createImageModel()->delUser($user_id);
    $this->modelFactory->createWeekModel()->delUser($user_id);
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


