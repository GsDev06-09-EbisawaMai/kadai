<?php
//1.POSTでParamを取得
$id = $_POST["id"];
$bookname   = $_POST["bookname"];
$bookurl  = $_POST["bookurl"];
$comment = $_POST["comment"];

//2.DB接続など
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE gs_bm_table SET bookname=:bookname,bookurl=:bookurl,comment=:comment WHERE id=:id");
$stmt->bindValue(':id', $id);
$stmt->bindValue(':bookname', $bookname);
$stmt->bindValue(':bookurl', $bookurl);
$stmt->bindValue(':comment', $comment);
$status = $stmt->execute();


//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: bm_list_view.php");
  exit;
}



?>