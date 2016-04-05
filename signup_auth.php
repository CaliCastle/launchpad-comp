<?php
require_once 'db.inc.php';

$user_login = $_GET["user_login"];

$con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
if ($con){
    mysql_select_db(DB_NAME);
    $sql = "SELECT * FROM `" . DB_TB_PRE . "first_sign_up` WHERE `user_login`='{$user_login}'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    if (!$row){
        // DOES NOT EXIST
        $sql = "INSERT INTO `". DB_TB_PRE . "first_sign_up` (`user_login`) VALUES ('{$user_login}')";
        if (mysql_query($sql, $con)){
            echo '2';
        } else {
            echo '-1';
        }
    } else { 
        // EXISTS
        echo '1';
    }
} else {
    die('数据库连接出错啦！');
}