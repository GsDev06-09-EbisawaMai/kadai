
<?php

function h($str){
	$str = htmlspecialchars($str,ENT_QUOTES);
	return $str;
	// returnは関数の外に出せる
}

?>
