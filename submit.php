<?php
include 'db.inc.php';

$user_nickname = htmlspecialchars($_GET["user_nickname"]);
$title = htmlspecialchars($_GET["title"]);
$video_path = htmlspecialchars($_GET["video_path"]);
$user_id = htmlspecialchars($_GET["user_id"]);
$user_cell = htmlspecialchars($_GET["user_cell"]);
$user_email = htmlspecialchars($_GET["user_email"]);
$description = htmlspecialchars($_GET["description"]);
$user_name = htmlspecialchars($_GET["user_name"]);
$project_path = htmlspecialchars($_GET["project_path"]);

$con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
if ($con){
    mysql_select_db(DB_NAME);
    mysql_query("set names utf8;");
    $sql = "SELECT * FROM `" . DB_TB_PRE . "first_comp` WHERE `user_id`='{$user_id}'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    if (!$row){
        // DOES NOT EXIST
        $sql = "INSERT INTO `". DB_TB_PRE . "first_comp` (`user_nickname`,`title`,`video_path`,`user_id`,`user_cell`,`user_email`,`description`,`user_name`,`project_path`) VALUES ('{$user_nickname}','{$title}','{$video_path}','{$user_id}','{$user_cell}','{$user_email}','{$description}','{$user_name}','{$project_path}')";
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