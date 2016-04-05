<?php

$user_login = $_GET["user_login"];

include '../functions.php';

$con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
if ($con){
    mysql_select_db(DB_NAME);
    $sql = "SELECT * FROM `".DB_TB_PRE."admin` WHERE `user_login` = '{$user_login}';";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    if($row)
        die('-1');
    $sql = "INSERT INTO `".DB_TB_PRE."admin` (`user_login`) VALUES ('{$user_login}');";
    if(mysql_query($sql,$con)){
        echo '1';
    } else {
        echo '-1';
    }
    
} else
    die('数据库出错啦');