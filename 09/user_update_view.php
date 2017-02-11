<?php
$id = $_GET["id"];

//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id=:id");
$stmt->bindValue(":id",$id,PDO::PARAM_INT); //STR=varchar or INT=int PARAMの後ろはどっちかになる。
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
    //一件しか帰ってこない場合
    $res = $stmt->fetch(); //1レコード取得する書き方
  }
?>

<!-- index.phpのコピペ -->
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
<form method="post" action="user_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ユーザーデータを更新します。</legend>
     <label>名前：<input type="text" name="name" value="<?=$res["name"]?>"></label><br>
     <label>IDを登録します。：<input type="text" name="lid" value="<?=$res["lid"]?>"></label><br>
     <label>パスワードを登録します。：<input type="text" name="lpw" value="<?=$res["lpw"]?>"></label><br>
     <input type="hidden" name="id" value="<?=$id?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
