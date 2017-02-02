<?php
//1. POSTデータ取得
$bookname   = $_POST["bookname"];
$bookurl  = $_POST["bookurl"];
$comment = $_POST["comment"];


//2. DB接続します この形を必ず使う 接続するには、これをかく
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());//エラーだしたくなければ、ここの（）の中身を消す。
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, bookname, bookurl, comment,
indate )VALUES(NULL, :bookname, :bookurl, :comment, sysdate())");
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();


//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）この中身を変えることは基本的にはない。
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: select.php"); // 必ず:の後ろに半角" "をいれる。
  exit;

}
?>
