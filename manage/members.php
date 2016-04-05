<?php include '../functions.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<?php include 'head.php';?>
<title>查看报名 - Abletive首届Launchpad工程大赛</title>
</head>
<body>
       <?php include 'header.php'; ?>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   <div class="xs">
  	 <h3>查看报名</h3>
  	 <?php
            $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
            if ($con){
                mysql_select_db(DB_NAME);
                mysql_query("set names utf8;");
                $sql = "SELECT COUNT(*) FROM `".DB_TB_PRE."first_sign_up`;";
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
        ?>
  	 <p>共有<?php echo $row["COUNT(*)"]; ?>人报名</p>
<div class="panel">
  	<div class="panel-body no-padding">
    <table class="table table-striped">
      <thead>
        <tr class="info">
          <th class="col-lg-2">#</th>
          <th class="col-lg-10">用户名</th>
        </tr>
      </thead>
      <tbody>
        <?php
                $sql = "SELECT * FROM `".DB_TB_PRE."first_sign_up`;";
                $result = mysql_query($sql);
        
                while($row = mysql_fetch_array($result)){
            ?>
                <tr id="row-<?php echo $row["id"]; ?>">
                    <th scope="row">
                        <?php echo $row["id"]; ?>
                    </th>
                    <th>
                        <?php echo $row["user_login"]; ?>
                    </th>
                </tr>
        <?php
                }
            }
          ?>
      </tbody>
    </table>
   </div>
  </div>
            </div>
   <script src="js/admin_action.js"></script>
<?php
    include 'footer.php';
?>