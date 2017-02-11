<?php

    session_start(); //セッションを開始する。

    $sid = session_id(); //セッションidを変数に代入

    echo "<pre>"; // これをすると中身が綺麗に改行されて見える。....
    var_dump($_SESSION); // sessionの中身を表示する。
    echo "</pre>";

    echo $_SESSION["name"];

?>