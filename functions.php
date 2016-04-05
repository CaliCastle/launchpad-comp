<?php
require_once 'db.inc.php';
/* Variables */
$home_page_url = 'http://'.$_SERVER['HTTP_HOST'];
$home_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$home_title = "Abletive首届Launchpad工程大赛";
$home_desc = "Abletive首届Launchpad工程大赛";
$login_code = '<div id="login">
    <div class="login_wrapper">
        <div class="login">
            <form action="'.htmlspecialchars($home_url).'" method="post" class="container offset1 loginform">
                <div id="owl-login">
                    <div class="hand"></div>
                    <div class="hand hand-r"></div>
                    <div class="arms">
                        <div class="arm"></div>
                        <div class="arm arm-r"></div>
                    </div>
                </div>
                <div class="pad">
                    <div class="control-group">
                        <div class="controls">
                            <label for="username" class="control-label fa fa-user"></label>
                            <input id="username" type="text" name="user_login" placeholder="社区的用户名（不是邮箱）" tabindex="1" autofocus="autofocus" class="form-control input-medium">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label for="password" class="control-label fa fa-asterisk"></label>
                            <input id="password" type="password" name="password" placeholder="登录密码" tabindex="2" class="form-control input-medium">
                        </div>
                    </div>
                </div>
                <div class="form-actions"><a href="http://abletive.com/wp-login.php?action=forget_password" tabindex="5" class="social-btn pull-left btn-link text-muted" title="忘记密码?" target="_blank">忘</a><a href="http://abletive.com" tabindex="6" class="btn-link text-muted" target="_blank">没有帐号点击注册</a>
                    <a href="javascript:void(0)" tabindex="4" class="social-btn qq" title="登录" id="login-button">登</a>
                </div>
            </form>
            <h3><a href="' . $home_page_url . '/steps/" target="_blank" style="position: relative;font-size: 16px;">不知道用户名？查看流程第一步</a></h3>
        </div>
    </div>
</div>';

function isLoggedIn(){
    if (isset($_COOKIE['user_cookie'])){
        return true;
    } 
    return false;
}

function isAdmin(){
    if (isset($_COOKIE['admin_cookie'])){
        return true;
    }
    return false;
}

function getUsername(){
    $usercookie = $_COOKIE['user_cookie'];
    $user_login = substr($_COOKIE['user_cookie'], 0, strpos($_COOKIE['user_cookie'],'|'));
    return $user_login;
}

function checkIsSigned(){
    $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
    if ($con){
        mysql_select_db(DB_NAME);
        $username = getUsername();
        $sql = "SELECT * FROM `" . DB_TB_PRE . "first_sign_up` WHERE `user_login`='{$username}'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        if (!$row){
            // DOES NOT EXIST
            return false;
        } else { 
            // EXISTS
            return true;
        }
    } else {
        die('数据库连接出错啦！');
    }
    return false;
}

function checkHasSubmitted(){
    $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
    if ($con){
        mysql_select_db(DB_NAME);
        $username = getUsername();
        $sql = "SELECT * FROM `" . DB_TB_PRE . "first_comp` WHERE `user_name`='{$username}'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        if (!$row){
            // DOES NOT EXIST
            return false;
        } else { 
            // EXISTS
            return true;
        }
    } else {
        die('数据库连接出错啦！');
    }
    return false;
}

function countSubmission(){
    $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
    if ($con){
        mysql_select_db(DB_NAME);
        mysql_query("set names utf8;");
        $sql = "SELECT * FROM `" . DB_TB_PRE . "first_comp`";
        $result = mysql_query($sql);
        $count = 0;
        while($row = mysql_fetch_array($result)){
            $count++;
        }
        return $count;
    } else {
        die('数据库连接出错啦！');
    }
    return 0;
}

function fetchSubmission(){
    $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
    if ($con){
        mysql_select_db(DB_NAME);
        mysql_query("set names utf8;");
        $sql = "SELECT * FROM `" . DB_TB_PRE . "first_comp`";
        $result = mysql_query($sql);
        $rows = mysql_fetch_array($result);
        if (!$rows){
            // DOES NOT EXIST
            return $rows;
        } else { 
            // EXISTS
            return $rows;
        }
    } else {
        die('数据库连接出错啦！');
    }
    return null;
}
