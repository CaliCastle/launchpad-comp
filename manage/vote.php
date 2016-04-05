<?php include '../functions.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<?php include 'head.php';?>
<title>投票管理 - Abletive首届Launchpad工程大赛</title>
</head>
<body>
       <?php include 'header.php'; ?>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   <div class="xs">
  	 <h3>投票管理</h3>
<div class="panel">
  	<div class="panel-body no-padding">
    <table class="table table-striped">
      <thead>
        <tr class="primary">
          <th class="col-lg-8">投票详情</th>
          <th class="col-lg-2">投票时间</th>
          <th class="col-lg-2">管理</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
            if ($con){
                mysql_select_db(DB_NAME);
                mysql_query("set names utf8;");
                $sql = "SELECT `".DB_TB_PRE."first_vote`.`id`, `".DB_TB_PRE."first_vote`.`user_login`, `".DB_TB_PRE."first_comp`.`user_nickname`, `".DB_TB_PRE."first_comp`.`title`,`".DB_TB_PRE."first_vote`.`vote_time` FROM `".DB_TB_PRE."first_vote` INNER JOIN `".DB_TB_PRE."first_comp` ON `".DB_TB_PRE."first_vote`.`vote_to`=`".DB_TB_PRE."first_comp`.`id` ORDER BY `user_login`;";
                $result = mysql_query($sql);
        
                while($row = mysql_fetch_array($result)){
            ?>
                <tr id="row-<?php echo $row["id"]; ?>">
                    <th scope="row">
                        <?php echo "{$row["user_login"]}投给了{$row["user_nickname"]}的《{$row["title"]}》"; ?>
                    </th>
                    <th>
                        <?php echo date("m/d h:i",strtotime($row["vote_time"])); ?>
                    </th>
                    <th><a class="btn btn-danger" id="vote-del-button" data-id="<?php echo $row["id"]; ?>">删除</a></th>
                </tr>
        <?php
                }
                
            }
          ?>
      </tbody>
    </table>
   </div>
  </div>
          <h3>异常投票</h3>
           <div class="panel">
  	<div class="panel-body no-padding">
    <table class="table table-striped">
      <thead>
        <tr class="primary">
          <th class="col-lg-8">投票详情</th>
          <th class="col-lg-2">投票时间</th>
          <th class="col-lg-2">管理</th>
        </tr>
      </thead>
      <tbody>
        <?php
                $sql = "SELECT `".DB_TB_PRE."first_vote`.`vote_to`,`".DB_TB_PRE."first_vote`.`user_login`,`".DB_TB_PRE."first_vote`.`vote_time`, `".DB_TB_PRE."first_vote`.`id` AS `vote_id`, `".DB_TB_PRE."first_comp`.`id` AS `comp_id` FROM `".DB_TB_PRE."first_vote` LEFT JOIN `".DB_TB_PRE."first_comp` ON `".DB_TB_PRE."first_vote`.`vote_to` = `".DB_TB_PRE."first_comp`.`id`;";
                $result = mysql_query($sql);
        
                while($row = mysql_fetch_array($result)){
                    if (!$result["comp_id"]){
                        echo '<tr id="row-'.$row["vote_id"].'"><th scope="row">'.$row["user_login"].'投给了#'.$row["vote_to"].'号选手(作品已删除)</th><th>';
                        echo date("m/d h:i",strtotime($row["vote_time"]));
                        echo '</th><th><a class="btn btn-danger" id="vote-del-button" data-id="'.$row["vote_id"].'">删除</a></th></tr>';
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