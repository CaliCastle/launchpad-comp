<?php include '../functions.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<?php include 'head.php';?>
<title>排行榜 - Abletive首届Launchpad工程大赛</title>
</head>
<body>
       <?php include 'header.php'; ?>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   <div class="xs">
  	 <h3>排行榜</h3>
  	 <?php
            $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
            if ($con){
                mysql_select_db(DB_NAME);
                mysql_query("set names utf8;");
        ?>
<div class="panel">
  	<div class="panel-body no-padding">
    <table class="table table-striped">
      <thead>
        <tr class="warning">
          <th class="col-lg-2">#</th>
          <th class="col-lg-4">昵称</th>
          <th class="col-lg-4">作品名</th>
          <th class="col-lg-2">票数</th>
        </tr>
      </thead>
      <tbody>
        <?php
                $sql = "SELECT `user_nickname`,`title`,`user_votes` FROM `".DB_TB_PRE."first_comp` ORDER BY `user_votes` DESC;";
                $result = mysql_query($sql);
                $count = 1;
                while($row = mysql_fetch_array($result)){
            ?>
                <tr id="row-<?php echo $row["id"]; ?>">
                    <th scope="row">
                        <?php echo $count ?>
                    </th>
                    <th>
                        <?php echo $row["user_nickname"]; ?>
                    </th>
                    <th>
                        <?php echo $row["title"]; ?>
                    </th>
                    <th>
                        <?php echo $row["user_votes"] . '票'; ?>
                    </th>
                </tr>
        <?php
                    $count++;
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