<?php

$id = $_GET["id"];

include '../functions.php';

$con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
if ($con){
    mysql_select_db(DB_NAME);
    $sql = "DELETE FROM `".DB_TB_PRE."first_vote` WHERE `id` = {$id}";
    if(mysql_query($sql,$con)){
        echo '1';
    } else {
        echo '-1';
    }
    
} else
    die('数据库出错啦');