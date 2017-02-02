<?php
// セッションを開始する
session_start();

// トークンを発行する
$ticket = md5(uniqid(rand(), true));

// トークンをセッションに保存
$_SESSION['ticket'] = $ticket;
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>POST練習</title>
		</head>
	<body>
		<form action="output_data.php" method="post">
			お名前: <input type="text" name="name">
			EMAIL: <input type="text" name="mail">
			<input type="submit" value="送信">
			<!--  生成したワンタイムチケットを隠しフィールドとして、
				  登録処理へPOSTする  -->
			<input type="hidden" name="ticket" value="<?=$ticket?>">
		</form>
		<ul>
			<li><a href="index.php">index.php</a></li>
		</ul>
	</body>
</html>