<?php
include("functions.php");
//1.POSTでParamを取得
$id     = $_POST["id"];
$name   = $_POST["name"];
$email  = $_POST["email"];
$naiyou = $_POST["naiyou"];

//2.DB接続など
$pdo = db_con();

//3.UPDATE gs_an_table SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。
$stmt = $pdo->prepare("UPDATE gs_an_table SET name=:name, email=:email, naiyou=:naiyou WHERE id=:id");
$stmt->bindValue(':name',  $name,   PDO::PARAM_STR);
$stmt->bindValue(':email', $email,  PDO::PARAM_STR);
$stmt->bindValue(':naiyou',$naiyou, PDO::PARAM_STR);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: select.php");
  exit;
}

?>
