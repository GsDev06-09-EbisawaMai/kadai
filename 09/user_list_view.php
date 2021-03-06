<?php
//1.  DB接続します
// session があるかないか正誤判定させる。
session_start();
//0.外部ファイル読み込み
include("functions.php");

if(
    !isset($_SESSION["chk_ssid"]) == session_id()
){
    exit('不正アクセスです。');
}

try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<p>";
    $view .= '<a href="user_update_view.php?id='.$result["id"].'">';
    $view .= $result["name"]."[".$result["lid"]."]"."[".$result["lpw"]."]";
    $view .= "</a>";
    $view .= '　';
    $view .= '<a href="user_delete.php?id='.$result["id"].'">';
    $view .= '[削除]';
    $view .= '</a>';
    $view .= "</p>";
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマークアプリ　課題　ユーザー登録追加版</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">

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
<div>
    <div class="container jumbotron"><?=$view?></div>
  </div>
</div>
<!-- Main[End] -->

</body>
</html>
