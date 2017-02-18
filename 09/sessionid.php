<?php
    // session の取得をする記述。
    // 必ず”session_start(); ”関数を最初に実行!!
    session_start();

    $sid = session_id();

    // session id に記述したもの、全てにひも付けられる。
    $_SESSION["name"]="エビサワ";
    $_SESSION["num"]="1000";
    $_SESSION["value"]="100";
    
    echo "<pre>"; // これをすると中身が綺麗に改行されて見える。....
    var_dump($_SESSION); // sessionの中身を表示する。
    echo "</pre>";
?>
