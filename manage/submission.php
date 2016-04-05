<?php include '../functions.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<?php include 'head.php';?>
<title>后台管理 - Abletive首届Launchpad工程大赛</title>
</head>
<body>
       <?php include 'header.php'; ?>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   <div class="xs">
  	 <h3>作品管理</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>昵称</th>
          <th>作品标题</th>
          <th>工程地址</th>
          <th>视频地址</th>
          <th>票数</th>
          <th>提交时间</th>
          <th>管理</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
            if ($con){
                mysql_select_db(DB_NAME);
                mysql_query("set names utf8;");
                $sql = "SELECT * FROM `".DB_TB_PRE."first_comp`;";
                $result = mysql_query($sql);
                $count = 1;
                while($row = mysql_fetch_array($result)){
            ?>
                <tr<?php echo $count%2==0 ? ' class="active"' : ''; ?> id="row-<?php echo $row["id"]; ?>">
                    <th scope="row">
                        <?php echo $row["id"]; ?>
                    </th>
                    <th>
                        <?php echo $row["user_nickname"]; ?>
                    </th>
                    <th>
                        <?php echo $row["title"]; ?>
                    </th>
                    <th><a href="<?php echo $row["project_path"]; ?>" target="_blank">点击</a>
                    </th>
                    <th><a href="<?php echo $row["video_path"]; ?>" target="_blank">点击</a></th>
                    <th><?php echo $row["user_votes"]; ?></th>
                    <th><?php 
                        $date = $row["submit_date"];
                        echo date("m/d",strtotime($date)); ?></th>
                    <th><a href="javascript:void(0)" class="btn btn-danger" data-id="<?php echo $row["id"]; ?>" id="del-button">删除</a><a href="mailto:<?php echo $row["user_email"]; ?>" class="btn btn-info">通知</a></th>
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
   <script src="js/admin_action.js"></script>
<?php
    include 'footer.php';
?>