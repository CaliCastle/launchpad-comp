<?php include '../functions.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<?php include 'head.php';?>
<title>仪表盘 - Abletive首届Launchpad工程大赛</title>
</head>
<body>
       <?php include 'header.php'; ?>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   <div class="xs">
  	 <h3>大赛概览</h3>
  	 <?php
            $con = mysql_connect(DB_HOST,DB_ADMIN,DB_PWD);
            if ($con){
                mysql_select_db(DB_NAME);
                
                $sql = "SELECT COUNT(*) FROM `".DB_TB_PRE."first_comp`;";
                $row = mysql_fetch_array(mysql_query($sql));
        ?>
    <div class="col_3">
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-thumbs-up user1 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php echo $row["COUNT(*)"]; ?>个</strong></h5>
                      <span>作品</span>
                    </div>
                </div>
        	</div>
        	<?php
                $sql = "SELECT COUNT(*) FROM `".DB_TB_PRE."first_vote`;";
                $row = mysql_fetch_array(mysql_query($sql));
                ?>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-heart icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php echo $row["COUNT(*)"]; ?>次</strong></h5>
                      <span>投票</span>
                    </div>
                </div>
        	</div>
        	<?php
                $sql = "SELECT COUNT(*) FROM `".DB_TB_PRE."first_sign_up`;";
                $row = mysql_fetch_array(mysql_query($sql));
                ?>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-table user2 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php echo $row["COUNT(*)"]; ?>人</strong></h5>
                      <span>报名</span>
                    </div>
                </div>
        	</div>
        	<?php
                $sql = "SELECT COUNT(*) FROM `".DB_TB_PRE."admin`;";
                $row = mysql_fetch_array(mysql_query($sql));
                ?>
        	<div class="col-md-3 widget">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-user-secret dollar1 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php echo $row["COUNT(*)"]; ?>名</strong></h5>
                      <span>管理员</span>
                    </div>
                </div>
        	 </div>
        	<div class="clearfix"> </div>
      </div>
        <?php include 'widgets/calendar.php'; ?>
        <div class="col-md-6">
        <div class="cloud">
			<div class="grid-date">
				<div class="date">
					<p class="date-in">距离结束</p>
					<span class="date-on"><i class="fa fa-calendar"> </i></span>
					<div class="clearfix"> </div>							
				</div>
				<h4><?php
                    $due_date = "2015-10-11";
                    $due_time = strtotime($due_date);
                    $left_time = $due_time - time();
                    $left_days = $left_time/(24*60*60);

                    if ($left_days <= 0){
                        echo '已结束';
                    } else
                        echo floor($left_days).'天';
                    ?>
                    </h4>
			</div>
			<p class="monday">2015-10-11</p>
		  </div>
		  </div>
   </div>
  </div>
            </div>
    <?php
            }
    ?>
   <script src="js/admin_action.js"></script>
<?php
    include 'footer.php';
?>