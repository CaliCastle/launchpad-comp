<?php
include '../functions.php';

$vote_to = $_GET["to"];
$user_login = $_GET["from"];

$con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);

if ($con){
    mysql_select_db(DB_NAME);
    $sql = "SELECT * FROM `" . DB_TB_PRE . "first_comp` WHERE `id` = {$vote_to};";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    if (!$row)
        die('-3');

    $sql = "SELECT COUNT(*) FROM `" . DB_TB_PRE . "first_vote` WHERE `user_login` = '{$user_login}'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    
    if ($row["COUNT(*)"] == 3){
        die('-2');
    }
    $sql = "INSERT INTO `" . DB_TB_PRE . "first_vote` (`vote_to`,`user_login`) VALUES ({$vote_to},'{$user_login}');";
    if (mysql_query($sql,$con)){
        $sql = "UPDATE `" . DB_TB_PRE . "first_comp` SET `user_votes` = `user_votes`+1 WHERE `id` = {$vote_to};";
        if (mysql_query($sql,$con))
            echo '1';
        else
            echo '-1';
    } else {
        echo '-1';
    }
} else {
    die('数据库连接出错啦');
}