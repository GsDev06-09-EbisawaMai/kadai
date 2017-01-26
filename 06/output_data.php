
<?php
setlocale(LC_ALL, 'ja_JP.SJIS');
include("function.php");
$name = $_POST["name"];
$mail = $_POST["mail"];
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>File書き込み</title>
	</head>
	<body>
		書き込みを行います。<br>
		<?php
		//  セッションを開始する
		session_start();

		//  ポストされたワンタイムチケットを取得する。
		$ticket = isset($_POST['ticket'])    ? $_POST['ticket']    : '';

		//  セッション変数に保存されたワンタイムチケットを取得する。
		$save   = isset($_SESSION['ticket']) ? $_SESSION['ticket'] : '';

		//  セッション変数を解放し、ブラウザの戻るボタンで戻った場合に備え
		//  る。
		unset($_SESSION['ticket']);

		//  ポストされたワンタイムチケットの中身が空だった、または、ポス
		//  トすらされてこなかった場合、不正なアクセスとみなして強制終了す
		//  る。
		if ($ticket === '') {

			die('不正なアクセスです');

		}

		//  ポストされたワンタイムチケットとセッション変数から取得したワン
		//  タイムチケットが同じ場合、正常にポストされたとみなして処理を行
		//  う。
		if ($ticket === $save) {

			// input_data.phpのデータを data.csvに格納する。
			$str = $name.",".$mail."\n";
			$file = fopen("data/data2.csv","a");	// ファイル読み込み
			flock($file, LOCK_EX);			// ファイルロック きめうち　必ずかいておく
			fwrite($file, $str);       // \n は改行 
			flock($file, LOCK_UN);			// ファイルロック解除 きめうち　必ずかいておく
			fclose($file);

			$fp = fopen('data/data2.csv', 'r');
			flock($fp, LOCK_EX);
			while(($data = fgetcsv($fp)) !== FALSE) {
				echo '<p>';
				echo '名前',$data[0];
				echo 'メール：',$data[1];
				echo '</p>';
			}
			flock($fp, LOCK_UN);	
			fclose($fp);

		}
		//  ブラウザの戻るボタンで戻った場合は、セッション変数が存在しない
		//  ため、2重送信とみなすことができる。
		//  また、不正なアクセスの場合もワンタイムチケットが同じになる確率
		//  は低いため、不正アクセス防止にもなる。
		else {

			$fp = fopen('data/data2.csv', 'r');
			flock($fp, LOCK_EX);
			while(($data = fgetcsv($fp)) !== FALSE) {
				echo '<p>';
				echo '名前',$data[0];
				echo 'メール：',$data[1];
				echo '</p>';
			}
			flock($fp, LOCK_UN);	
			fclose($fp);

		}
		?>
		
		
		<ul>
		<li><a href="index.php">index.php</a></li>
		</ul>
	</body>
</html>