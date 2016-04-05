<?php include '../functions.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<title>登录后台 - Abletive首届Launchpad工程大赛</title>
<?php include 'head.php'; ?>
</head>
<body id="login">
  <div class="login-logo">
    <a href="index.php"><img src="images/RGB-round-200px.png" alt=""/></a>
  </div>
  <h2 class="form-heading">登录后台</h2>
  <div class="app-cam">
	  <form>
		<input type="text" class="text" value="" placeholder="用户名" id="username">
		<input type="password" value="" placeholder="密码" id="password">
		<div class="submit"><input type="button" id="login-button" onclick="submitLogin()" value="登录"></div>
		<ul class="new">
			<li class="new_left"><p><a href="http://abletive.com/wp-login.php?action=lostpassword" target="_blank">忘记密码 ?</a></p></li>
			<li class="new_right"><p class="sign"><a href="http://abletive.com" target="_blank"> 访问社区</a></p></li>
			<div class="clearfix"></div>
		</ul>
	</form>
  </div>
   <div class="copy_layout login">
      <p>Copyright &copy; 2015. Abletive All rights reserved.</p>
   </div>
   <div class="overlay">
       <div class="message-box">
           <p id="message"></p>
       </div>
   </div>
   <script src="js/custom.js"></script>
</body>
</html>
