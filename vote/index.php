<?php
include '../functions.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?php echo isLoggedIn() ? '投票' : '登录后投票'; ?> - Abletive首届Launchpad工程大赛</title>
    <link rel="icon" id="favicon" href="../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" id="favicon" href="../favicon.ico" type="image/x-icon">
	<!-- General demo styles & header -->
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<?php if (!isLoggedIn()){
        echo '<link rel="stylesheet" href="../css/reset.css"><link rel="stylesheet" href="../css/bootstrap.min.css"><link rel="stylesheet" href="../css/style.css">';
    } else {
        echo '<link rel="stylesheet" type="text/css" href="fonts/feather/style.css"><link rel="stylesheet" type="text/css" href="css/demo.css" /><link rel="stylesheet" type="text/css" href="css/component.css" /><link rel="stylesheet" type="text/css" href="../css/animate.css" /><script src="js/modernizr.custom.js"></script>';
    }
    ?>
	
</head>

<body>
   <?php
    $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
    if ($con){
        if (!isLoggedIn()){
            echo $login_code;  
        } else {
            mysql_select_db(DB_NAME);
            mysql_query("set names utf8;");
            
            $sql = "SELECT COUNT(*) FROM `" . DB_TB_PRE . "first_vote` WHERE `user_login` = '".getUsername()."';";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            
            echo '<div class="container"><header class="bp-header cf"><span>第一届Launchpad大赛 <span class="bp-icon bp-icon-about" data-content="Abletive音乐社区首届Launchpad工程大赛投票日期：8月11日 - 10月11日"></span></span><h1>投票 (<b id="current-votes">'.$row["COUNT(*)"].'</b>/3)</h1><nav><a href="'.$home_page_url.'" class="bp-icon bp-icon-prev" data-info="返回到主页"><span>返回</span></a><a href="http://abletive.com" class="bp-icon bp-icon-drop" data-info="前往社区" target="_blank"><span>前往社区</span></a></nav></header>';
            
            $sql = "SELECT COUNT(*) FROM `" . DB_TB_PRE . "first_comp`;";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $num = $row["COUNT(*)"];
            if ($num > 0){ 
		    echo '<section class="slider">';
    
            $sql = "SELECT * FROM `" . DB_TB_PRE . "first_comp`;";
            $result = mysql_query($sql);
            $count = 0;
            while($row = mysql_fetch_array($result)){
                echo $count == 0 ? '<div class="slide slide--current" data-content="'.$row["id"].'">' : '<div class="slide" data-content="'.$row["id"].'">';
            ?>
            <div class="slide__mover">
					<div class="zoomer flex-center" data-id="<?php echo $row["id"]; ?>" data-name="<?php echo $row["user_nickname"]; ?>">
						<img class="zoomer__image" src="images/lpd-pro.png" alt="" />
						<div class="preview">
            <?php
                        echo '<img src="'.$home_page_url.'/timthumb.php?w=230&h=230&src='.$home_page_url.'/img/img-placeholder.jpg" alt="'.$row["user_nickname"].'的头像" data-id="'.$row["user_id"].'" />';
            ?>
                            <div class="zoomer__area zoomer__area--size"></div></div></div></div>
            <?php
                    echo '<h2 class="slide__title"><span><i class="fa fa-heart"></i> <b>'.$row["user_votes"].'</b>票</span> '.$row["user_nickname"].'</h2></div>';
                
                $count++;
            }
            ?>
			
			<nav class="slider__nav">
			<?php 
                echo $num > 1 ? '<button class="button button--nav-prev"><i class="icon icon--arrow-left"></i><span class="text-hidden">上一个</span></button><button class="button button--zoom" data-info="查看详情"><i class="icon icon--zoom"></i><span class="text-hidden">查看详情</span></button><button class="button" data-info="给Ta投一票" id="vote-button"><i class="fa fa-heart"></i><span class="text-hidden">给ta投票</span></button><button class="button button--nav-next"><i class="icon icon--arrow-right"></i><span class="text-hidden">下一个</span></button>' : '<button class="button button--zoom" data-info="查看详情"><i class="icon icon--zoom"></i><span class="text-hidden">查看详情</span></button><button class="button" data-info="给Ta投一票" id="vote-button"><i class="fa fa-heart"></i><span class="text-hidden">给ta投票</span></button>';
            ?>
				
			</nav>
		</section>
		<span style="width:100%;text-align:center;position:absolute;top:20px;left:0;" id="tip">支持键盘【方向键】【回车】【V】</span>
		<section class="content">
		<?php
            $sql = "SELECT * FROM `" . DB_TB_PRE . "first_comp`;";
            $result = mysql_query($sql);
            while($row = mysql_fetch_array($result)){
                echo '<div class="content__item" id="'.$row["id"].'">';
                echo '<img class="content__item-img rounded-right" src="'.$home_page_url.'/timthumb.php?w=250&h=250&src='.$home_page_url.'/img/img-placeholder.jpg" alt="" data-id="'.$row["user_id"].'" class="img-loading" /><div class="content__item-inner">';
                echo '<h2>'.$row["user_nickname"].'</h2>';
				echo '<h3>'.$row["title"].'</h3>';
				echo '<h4>参赛ID: #'.$row["id"].'</h4>';
				echo '<span>提交于:'.$row["submit_date"].'</span>';
				echo '<p>'.$row["description"].'</p>';
				echo '<a href="'.$row["video_path"].'" target="_blank">观看视频 <i class="fa fa-film"></i></a>';
				echo '<a href="'.$row["project_path"].'" target="_blank">下载工程 <i class="fa fa-download"></i></a>';
				echo '<p style="color:#555;font-size:1em;">赶快邀请好友来投票</p><ul class="social-buttons"><li><a href="javascript:void(0)" class="social-btn weibo weibo-share"><i class="fa fa-weibo"></i></a></li><li><a href="javascript:void(0)" class="social-btn qq qq-share"><i class="fa fa-qq"></i></a></li><li><a href="javascript:void(0)" class="social-btn tieba tieba-share"><i class="fa">贴</i></a></li><li><a href="javascript:void(0)" class="social-btn wechat" id="wechat-button"><i class="fa fa-wechat"></i></a>';
                echo '<img src="http://qr.liantu.com/api.php?text='.urlencode($home_page_url.'/vote/index.php?id='.$row["id"]).'&bg=EEEEEE&fg=111111&w=300&el=5" alt="微信分享" id="wechat-share" class="animated"></li></ul>';
				echo '</div></div>';
            }
                ?>
                <button class="button button--close"><i class="icon icon--circle-cross"></i><span class="text-hidden">关闭详情</span></button>
		</section>
   <div class="overlay" style="display:none">
        <div class="message-box">
            <p id="message"></p>
        </div>
    </div>
    </div>
    <?php
            }
        }
    ?>
    <script src="../js/jquery-2.1.4.js"></script>
    <script src="js/classie.js"></script>
	<script src="js/dynamics.min.js"></script>
	<script src="js/main.js"></script>
    
    <?php
    } else
        die('数据库连接出错啦');
    ?>
</body>
</html>