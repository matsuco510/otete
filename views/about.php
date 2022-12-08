<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Otete</title>
  <!-- css -->
  <link rel="stylesheet" href="/views/css/destyle.css">
  <link rel="stylesheet" href="/views/css/index.css">
  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- favicon -->
  <link rel="icon" type="image/png" href="./images/favicon.png">
</head>
<body>
  <header>
    <div class="left">
      <h1><a href="../index.php">Otete</a></h1>
    </div>
    <div class="right">
      <ul>
        <li><a href="./views/about.php">Oteteとは</a></li>
        <li><a href="./views/login.php">ログイン</a></li>
        <li><a href="./views/register.php">新規登録</a></li>
      </ul>
    </div>
  </header><!-- header -->
  <div class="about_layout">
    <div class="about_container">
      <div class="about_title">
        <h1>About</h1>
      </div>
      <div class="content">
        <div class="about_title_sub">
          <h2><span class="about_img"><img src="./images/about.png"></span> Otete の説明書</h2>
        </div>
        <div class="about_content">
          <h2>
            <img src="./images/finger_1.png" class="about_icon">
            レシピの登録
          </h2>
          <p>
            🟠 マイページの「料理の追加」ボタンをクリックする<br>
            <img src="./images/about_1.png" id="about_sample"><br>
            🟠 「料理の追加」に移動すると入力画面になり、画像、下準備以外の項目<br>
            は、必須項目となります。<br>
              ・タイトル<br>
              ・材料、数量<br>
              ・作り方<br>
            🟠 レシピをご登録後、「マイページ」に移動いたしますので、<br>
            マイページの「メニュー一覧」を確認するとご登録いただいたレシピが<br>
            表示されているのを確認してください。<br>
            <img src="./images/about_2.png" id="about_sample"><br>
              
          </p>
        </div>
        <div class="about_content">
          <h2>
            <img src="./images/finger_2.png" class="about_icon">
            日数、週数の設定
          </h2>
          <p>
            🟠 マイページの「週数の設定」ボタンをクリックします。<br>
            <img src="./images/about_3.png" id="about_sample"><br>
            🟠 設定したい期間とその期間で食べたいレシピを選択し登録します。<br>
            🟠 マイページにその期間とレシピが表示されます。<br>
            <img src="./images/userImage.png" class="about_page">
          </p>
        </div>
        <div class="about_content">
          <h2>
            <img src="./images/finger_3.png" class="about_icon">
            調理が終わった後の作業
          </h2>
          <p>
            🟠 マイページにて日数または週数で設定したレシピの中で調理が<br>
            済んだら、調理したレシピを選択し「調理済み」を選択すると、そ<br>
            のレシピが削除され、残りのレシピが残ります。<br>
            🟠 日数または週数の変更、レシピの変更をしたい場合は、「変更」<br>
            クリックすると変更ができます。<br>
          </p>
        </div>
        <div class="about_content">
          <h2>
            <img src="./images/finger_4.png" class="about_icon">
            ユーザー情報の変更
          </h2>
          <p>
            🟠 マイページのプロフィール変更から各項目の変更を行ってください。<br>
            <img src="./images/about_4.png" alt="" id="about_sample">
          </p>
        </div>
      </div>
    </div>
  </div><!-- about -->
  <footer class="footer">
    <div class="footer_menu">
      <ul>
        <li><a href="./termsOfUse.php">利用規約</a></li>
        <li><a href="./privacy.php">プライバシーポリシー</a></li>
      </ul>
    </div>
    <p>©️ 2022 Otete Portfolio</p>
  </footer><!-- footer -->
</body>
</html>