<?php
include '../functions.php';

$username = $_GET["username"];

$con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
if($con){
    mysql_select_db(DB_NAME);
    $sql = "SELECT * FROM `".DB_TB_PRE."admin` WHERE `user_login`='{$username}'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    
    if (!$row){
        echo '-1';
    } else {
        echo '1';
    }
} else {
    die('数据库连接出错啦');
}