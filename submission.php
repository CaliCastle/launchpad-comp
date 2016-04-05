<?php include 'functions.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>
       <?php echo isLoggedIn() ? '' : '登录后'; ?>
        <?php echo checkIsSigned() ? '作品提交' : '报名'; ?> - Abletive首届Launchpad工程大赛</title>
    <link rel="icon" id="favicon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" id="favicon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/linkstyles.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <a href="<?php echo $home_page_url; ?>" style="float:left;position:absolute;top:10px;left:20px;font-size:19px;" class="back-button"><i class="fa fa-arrow-left"></i> 返回</a>
            </div>
        </div>
    </header>
    <?php 
        if (!isLoggedIn()){
            echo $login_code;  
        } else {
            if (!checkIsSigned()){
                echo '<div class="main"><div class="page_container"><div class="signup"><a class="link link--ilin" href="javascript:void(0)" id="signup-button"><span>现在</span><span>报名</span></a></div></div></div>';
            } else {
                if (checkHasSubmitted()){
                    echo '<style type="text/css">.text {fill: none;stroke-width: 3;stroke-linejoin: round;stroke-dasharray: 70 330;stroke-dashoffset: 0;-webkit-animation: stroke 14s infinite linear;animation: stroke 6s infinite linear; }.text:nth-child(5n + 1) {stroke: #F2385A;-webkit-animation-delay: -2.4s;animation-delay: -2.4s; }.text:nth-child(5n + 2) {stroke: #F5A503;-webkit-animation-delay: -4.8s;animation-delay: -4.8s; }.text:nth-child(5n + 3) {stroke: #E9F1DF;-webkit-animation-delay: -7.2s;animation-delay: -7.2s; }.text:nth-child(5n + 4) {stroke: #56D9CD;-webkit-animation-delay: -9.6s;animation-delay: -9.6s; }.text:nth-child(5n + 5) {stroke: #3aa1bf;-webkit-animation-delay: -12s;animation-delay: -12s; }@-webkit-keyframes stroke {100% {stroke-dashoffset: -400; } }@keyframes stroke {100% {stroke-dashoffset: -400; } }/* Other stuff */html,body {height: 100%; }body {background: #111;color: #fff; }.content {font: 800 14.5em/1  "PingHei Light", Impact; }svg {width: 50%;height: 200px;margin: 0 auto 50px;display: block;text-transform: uppercase;position: absolute;top: 50%;left: 50%;margin-left: -25%;margin-top: -100px;z-index:999; }</style><div class="main"><div class="background_container"></div><div class="content"><svg viewBox="0 0 800 300"><!-- Symbol --><symbol id="s-text"><text text-anchor="middle" x="50%" y="50%" dy=".2em">感谢提交</text></symbol><!-- Duplicate symbols --><use xlink:href="#s-text" class="text"></use><use xlink:href="#s-text" class="text"></use><use xlink:href="#s-text" class="text"></use><use xlink:href="#s-text" class="text"></use><use xlink:href="#s-text" class="text"></use></svg></div><div class="black_overlay"></div></div>';
                } else {
                    echo '<div class="main">
        <div class="page_container">
            <div class="submit_wrapper col-lg-12 clearfix">
                <form id="submitform" class="form-horizontal">
                   <div class="form-group">
                       <label for="user_nickname" class="col-sm-4">参赛昵称</label>
                       <div class="col-sm-8">
                           <input type="text" placeholder="昵称..." class="form-control" id="user_nickname" name="user_nickname" autofocus>
                       </div>
                   </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-4">工程作品名称</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="作品名称，如：" class="form-control" id="title" name="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="video_path" class="col-sm-4">工程视频地址</label>
                        <div class="col-sm-8">
                            <input type="text" name="video_path" class="form-control" id="video_path" placeholder="土豆，优酷，腾讯等观看url">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="project_path" class="col-sm-4">工程网盘地址</label>
                        <div class="col-sm-8">
                            <input type="text" name="project_path" class="form-control" id="project_path" placeholder="百度，115，360等网盘url(请勿创建私密)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_cell" class="col-sm-4">手机号码</label>
                        <div class="col-sm-8">
                            <input type="number" name="user_cell" id="user_cell" placeholder="手机号码" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_email" class="col-sm-4">邮箱地址</label>
                        <div class="col-sm-8">
                            <input type="email" name="user_email" id="user_email" placeholder="邮箱地址" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description_area" class="col-sm-4">作品简介</label>
                        <div class="col-sm-8">
                            <textarea name="description" id="description_area" cols="40" rows="5" placeholder="这里填写作品的简介..." class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            <input type="button" id="submit-button" class="form-control" value="提交">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>';
                }
            }
        }
    ?>
    <script src="js/jquery-2.1.4.js"></script>
    <script src="js/submit.js"></script>
    <div class="overlay" style="display:none">
        <div class="message-box">
            <p id="message"></p>
        </div>
    </div>
    
</body>

</html>