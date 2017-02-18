<?php

// session があるかないか正誤判定させる。
session_start();


//0.外部ファイル読み込み
include("functions.php");

if(
    !isset($_SESSION["chk_ssid"]) == session_id()
){
    exit('不正アクセスです。');
}

?>
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
<form method="post" action="insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>本を登録してください。</legend>
     <label>本の名前：<input type="text" name="bookname"></label><br>
     <label>本のURL：<input type="text" name="bookurl"></label><br>
     <label><textArea name="comment" rows="4" cols="40"></textArea></label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
