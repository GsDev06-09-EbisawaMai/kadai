<?php
session_start(); // まずセッションをスターと！

$_SESSION["a"] = 1; // aに1をあずける。
$_SESSION["name"] = "yamazaki"; // aに1をあずける。

echo $_SESSION["a"]; // 1をかく。

$_SESSION["a"]+=1; //この時点では2が入るはず！


?>