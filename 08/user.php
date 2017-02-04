<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ブックマークアプリ　課題　ユーザー登録追加版</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <!-- ユーザー登録 -->
    <div class="navbar-header"><a class="navbar-brand" href="index.php">本を登録する</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="bm_list_view.php">データ一覧</a></div>
    <!-- ユーザー登録 -->
    <div class="navbar-header"><a class="navbar-brand" href="user.php">ユーザー登録する</a></div>
    <!-- ユーザー登録 -->
    <div class="navbar-header"><a class="navbar-brand" href="user_list_view.php">ユーザーデータ一覧</a></div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ユーザー登録をします。</legend>
     <label>名前：<input type="text" name="name"></label><br>
     <label>IDを登録します。：<input type="text" name="lid"></label><br>
     <label>パスワードを登録します。：<input type="text" name="lpw"></label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>