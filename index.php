<?php 
    include 'functions.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title><?php echo $home_title; ?></title>
    <meta name="title" content="<?php echo $home_title; ?>" />
    <meta name="description" content="<?php echo $home_desc; ?>" />
    <meta content="<?php echo $home_url; ?>" property="og:url" />
    <meta content="<?php echo $home_url . 'img/poster.jpg'?>" property="og:image" />
    <link rel="icon" id="favicon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" id="favicon" href="favicon.ico" type="image/x-icon">
    <meta name="author" content="Cali">
    <link rel="canonical" href="<?php echo $home_url; ?>" />
    <link href='css/onepage-scroll.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/flexslider.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no">
</head>

<body>
   <?php $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
    if ($con){
    ?>
    <div class="wrapper">
        <div class="main">
            <!-- Intro -->
            <section class="page1">
                <div class="blur_container">
                    <div class="container_background"></div>
                </div>
                <div class="page_container container text-center">
                    <div class="row">
                        <h1>Abletive首届<br>Launchpad工程大赛</h1>
                        <h2>Abletive社区第一届Launchpad工程制作大比拼.<br>亲自动手 证明你的实力</h2>
                    </div>
                    <div class="row">
                        <div class="social">
                           <span class="animated fadeIn delay-15s">分享给好友：</span>
                            <ul class="social-buttons">
                                <li><a href="http://service.weibo.com/share/share.php?url=<?php echo $home_url; ?>&title=<?php echo '推荐大家来参加'.$home_title; ?>&appkey=1343713053&searchPic=true" target="_blank" class="social-btn weibo" title="分享到新浪微博"><i class="fa fa-weibo"></i></a></li>
                                <li><a href="http://connect.qq.com/widget/shareqq/index.html?url=<?php echo $home_url; ?>&title=<?php echo $home_title; ?>&desc=<?php echo $home_title . '开始举办啦，快来报名参加吧'; ?>" target="_blank" class="social-btn qq" title="分享给QQ好友"><i class="fa fa-qq"></i></a></li>
                                <li><a href="http://tieba.baidu.com/f/commit/share/openShareApi?url=<?php echo $home_url; ?>&title=<?php echo $home_title; ?>&desc=<?php echo $home_title . '开始举办啦，快来报名参加吧'; ?>&comment=" target="_blank" class="social-btn tieba" title="分享到贴吧"><i class="fa">贴</i></a></li>
                                <li><a href="javascript:void(0)" class="social-btn wechat" title="分享到微信" id="wechat-button"><i class="fa fa-wechat"></i></a>
                                <img src="<?php echo "http://qr.liantu.com/api.php?text={$home_page_url}&bg=EEEEEE&fg=111111&w=300&el=5"; ?>" alt="微信分享" id="wechat-share" class="animated">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="btns">
                           <?php
    
        mysql_select_db(DB_NAME);
        $sql = "SELECT COUNT(*) FROM `" . DB_TB_PRE . "first_sign_up`;";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $count = $row["COUNT(*)"];
        echo '<p>已有'. $count .'人报名</p>';
                            ?>
                        <a class="reload" href="submission.php">现在报名</a>
                    </div>
                </div>
                <div class="container_overlay"></div>
            </section>
            <!-- Description -->
            <section class="page2">
               <div class="page2_overlay"></div>
                <div class="page_container">
                    <h1>大赛详情</h1>
                    <h2>冠军奖品: <span>Novation Launch Control</span></h2>
                    <h4 style="color:#EEE;">大赛时间：8月11日 至 10月4日<br>参加方式：在期间报名并成功提交作品即可<br></h4>
                    <div class="btns">
                        <a class="reload btn" href="steps/">查看参赛流程</a>
                    </div>
                </div>
                <div class="blur_container"><div id="container_background"></div></div>
            </section>
            <!-- Competitors -->
            <section class="page3">
                <div class="page_container container">
                    <div class="row">
                        <h1>作品展示</h1>
                    </div>
                    <div class="row">
                           <?php 
        mysql_select_db(DB_NAME);
        mysql_query("set names utf8;");
        $sql = "SELECT COUNT(*) FROM `" . DB_TB_PRE . "first_comp`;";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $count = $row["COUNT(*)"];
        if ($count > 0){
            echo '<div id="competitorSlider"><ul class="slides"><li>';
            $sql = "SELECT * FROM `" . DB_TB_PRE . "first_comp`;";
            $result = mysql_query($sql);

            $times = 0;
            while($row = mysql_fetch_array($result)){
                if ($times < $count - $count % 3){
                    // Not the last list
                    echo '<div class="col-md-4">';
                    echo '<img src="img/img-placeholder.jpg" alt="'.$row["user_nickname"].'" data-id="' . $row["user_id"] . '" class="img-circle" id="comp-img"><span><i class="fa fa-thumbs-up"></i> ' . $row["user_votes"] . '票</span><h3>' . $row["user_nickname"] . '</h3><p>';
                    if(mb_strlen($row["description"],'utf8') >= 100){
                        $newstr = mb_substr($row["description"],0,99,'utf8');
                        echo "{$newstr}...";
                    } else
                        echo $row["description"];
                    echo '</p></div>';
                } else {
                    // The last list
                    echo '<div class="col-md-';
                    echo 12/($count%3);// the variable
                    echo '">';
                    echo '<img src="img/img-placeholder.jpg" alt="'.$row["user_nickname"].'" data-id="' . $row["user_id"] . '" class="img-circle" id="comp-img"><span><i class="fa fa-thumbs-up"></i> ' . $row["user_votes"] . '票</span><h3>' . $row["user_nickname"] . '</h3><p>';
                    if(mb_strlen($row["description"],'utf8') >= 100){
                        $newstr = mb_substr($row["description"],0,99,'utf8');
                        echo "{$newstr}...";
                    } else
                        echo $row["description"];
                    echo '</p></div>';
                }
                $times++;// counter
                if ($times % 3 == 0 && $count-$times > 0){
                    // add a list
                    echo '</li><li>';
                }
            }
            echo '</li></ul></div>';
        }else {
            echo '<h3 style="margin: 50px 0;"><i class="fa fa-smile-o"></i> 还没有人提交作品，赶快抢首发~</h3>';
        }
                            ?>
                    </div>
                    <div class="row">
                        <h2>以上是选手们已经提交的作品，喜欢的话就赶快为Ta投一票吧！<br>如果你也想提交自己的工程作品点击下面前往报名吧！</h2>
                        <div class="btns">
                            <a class="reload btn" href="submission.php" id="signup-button">前往报名</a>
                            <a class="reload btn" href="vote/" id="vote-button">前往投票</a>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
    <script src="js/jquery-2.1.4.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.onepage-scroll.js"></script>
    <script src="js/jquery.flexslider.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).ready(function () {
            $(".main").onepage_scroll({
                sectionContainer: "section",
                responsiveFallback: 800,
                loop: true,
                easing: "cubic-bezier(0.175, 0.885, 0.420, 1.010)"
            });
        });
    </script>
    <?php }
    else
        die('数据库连接出错啦'); ?>
</body>

</html>