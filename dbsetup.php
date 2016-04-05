<?php

require_once('db.inc.php');

function setup(){
    $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);

    if ($con) {
        if (mysql_query('CREATE DATABASE IF NOT EXISTS ' . DB_NAME . ' DEFAULT CHARSET utf8 COLLATE utf8_general_ci;', $con)){
            mysql_select_db(DB_NAME);
            $table_create_sql = 'CREATE TABLE IF NOT EXISTS ' . DB_TB_PRE . 'first_comp(
            `id` int NOT NULL AUTO_INCREMENT,
            `title` varchar(100) NOT NULL,
            `user_cell` varchar(20) NOT NULL,
            `user_email` varchar(100) NOT NULL,
            `user_id` varchar(255) NOT NULL,
            `user_name` varchar(255) NOT NULL,
            `user_nickname` varchar(255) NOT NULL,
            `description` varchar(2000),
            `video_path` varchar(1000),
            `project_path` varchar(255),
            `submit_date` timestamp NOT NULL,
            `user_votes` int DEFAULT 0,
            PRIMARY KEY (`id`)
            )ENGINE=InnoDB DEFAULT CHARSET utf8 COLLATE utf8_general_ci;';

            mysql_query($table_create_sql, $con);

            $table_create_sql = 'CREATE TABLE IF NOT EXISTS ' . DB_TB_PRE . 'first_sign_up(
            `id` int NOT NULL AUTO_INCREMENT,
            `user_login` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
            )ENGINE=InnoDB DEFAULT CHARSET utf8 COLLATE utf8_general_ci;';
            
            mysql_query($table_create_sql, $con);
            
            $table_create_sql = 'CREATE TABLE IF NOT EXISTS ' . DB_TB_PRE . 'first_vote(
            `id` int NOT NULL AUTO_INCREMENT,
            `user_login` varchar(255) NOT NULL,
            `vote_to` int NOT NULL,
            `vote_time` timestamp NOT NULL,
            PRIMARY KEY (`id`)
            )ENGINE=InnoDB DEFAULT CHARSET utf8 COLLATE utf8_general_ci;';
            
            mysql_query($table_create_sql, $con);
            
            $table_create_sql = "CREATE TABLE IF NOT EXISTS " . DB_TB_PRE . "admin(
            `id` int NOT NULL AUTO_INCREMENT,
            `user_login` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
            )ENGINE=InnoDB DEFAULT CHARSET utf8 COLLATE utf8_general_ci;";
            
            if (mysql_query($table_create_sql,$con)){
                $sql = "INSERT INTO `".DB_TB_PRE."admin` (`user_login`) VALUES ('administrator_cali')";
                mysql_query($sql,$con);
                
                echo '成功啦！';
            }else
                die(mysql_error());
        } else { die('<p>数据库创建失败. <br>Error: ' . mysql_error() . '</p>'); }
    } else {
        die('<p>数据库连接时出错啦！<br>Error: ' . mysql_error() . '</p>');
    }
}

setup();