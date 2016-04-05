<?php include '../functions.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<?php include 'head.php';?>
<title>用户管理 - Abletive首届Launchpad工程大赛</title>
</head>
<body>
       <?php include 'header.php'; ?>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   <div class="xs">
  	 <h3>用户管理</h3>
  	 <a onclick="addUser()" class="btn btn-primary" id="add-admin">添加管理员</a>
<div class="panel">
  	<div class="panel-body no-padding">
    <table class="table table-striped">
      <thead>
        <tr class="success">
          <th class="col-lg-2">#</th>
          <th class="col-lg-6">用户名</th>
          <th class="col-lg-4">管理</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
            if ($con){
                mysql_select_db(DB_NAME);
                mysql_query("set names utf8;");
                $sql = "SELECT * FROM `".DB_TB_PRE."admin`;";
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
                    <th><a href="javascript:void(0)" class="btn btn-danger" data-id="<?php echo $row["id"]; ?>" id="user-del-button">删除</a></th>
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