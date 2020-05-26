<?php
	session_start(); 
	ob_start();

	$head = "<html>
	<head>
	<link href='../css/menustyle.css' rel='stylesheet' type='text/css'/>
	<link href='../css/table_styles.css' rel='stylesheet' type='text/css'/>
	<meta charset='utf-8'>
	<title>Profile</title>

	<link rel='stylesheet' href='../css/bootstrap.min.css' type='text/css'/>
	<link rel='stylesheet' href='../css/font-awesome.min.css' type='text/css'/>
	<link rel='stylesheet' href='../css/profile.css' type='text/css'/>
	<script src='../js/jquery.js'></script>
	<script src='../js/jquery.backstretch.min.js'></script>
	<script src='../js/bootstrap.min.js'></script>	
	<script src='../js/custom.js'></script>
	</head>
	<body>";
	
	echo $head;
	$link = "profile";
	$var_id = $_SESSION['perm'];
	$tableName = (isset($_GET['gn']) && $_GET['gn'] !== '') ? $_GET['gn'] : 'prof';
	include_once "menu.php";

	$db = mysqli_connect("localhost:3308", "root", "", "project");
	$id = $_SESSION['user_id'];
	$sql_user_info = "SELECT * FROM project.employees where user_id=$id";
	
	$result = mysqli_query($db, $sql_user_info);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$user_role = $row['ROLE_ID'];

	$sql_user_role = "SELECT * FROM project.roles_ref where role_id=$user_role";
	$result2 = mysqli_query($db, $sql_user_role);
	$role = mysqli_fetch_array($result2, MYSQLI_ASSOC);
	$sql_tasks = "SELECT count(*) from project.tasks where EXECUTOR_ID=$id";
	$result3 = mysqli_query($db, $sql_tasks);
	$tasks = mysqli_fetch_array($result3, MYSQLI_ASSOC);

	$sql_tasks_open = "SELECT count(*) from project.tasks where EXECUTOR_ID=$id and task_status_id=1";
	$result4 = mysqli_query($db, $sql_tasks);
	$tasks_opened = mysqli_fetch_array($result4, MYSQLI_ASSOC);

	$sql_tasks_compl = "SELECT count(*) from project.tasks where EXECUTOR_ID=$id and task_status_id=2";
	$result5 = mysqli_query($db, $sql_tasks_compl);
	$tasks_completed = mysqli_fetch_array($result5, MYSQLI_ASSOC);

	$num_tasks = $tasks['count(*)'];
	$num_open_tasks = $tasks_opened['count(*)'];
	$num_compl_tasks = $tasks_completed['count(*)'];
	$num_closed_tasks = $num_tasks - $num_open_tasks  - $num_compl_tasks;

	$percent = $num_open_tasks/($num_open_tasks + $num_compl_tasks) * 100;
	$percent = round($percent);
?>

<div data-spy="scroll" data-target=".navbar-collapse">

<!-- preloader section -->
<div class="preloader">
	<div class="sk-spinner sk-spinner-wordpress">
       <span class="sk-inner-circle"></span>
     </div>
</div>
<!-- header section -->
<!-- <div class="panel panel-default" style="width: 60rem;"> -->
<div class="container">
	<div class="row">
		<!-- <div class="col-2">
			<h1 class="tm-title bold shadow">Picture</h1>
		</div> -->
		<div class="col-2">
			<h1 class="bold shadow" style="text-indent:50px">   Hi, <?php echo $row['LAST_NAME']." ".$row['FIRST_NAME']?></h1>
			<h1 class="bold shadow" style="text-indent:50px"><?php echo    $role['ROLE_DESC'];?></h1>
		</div>
	</div>

<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="panel with-nav-tabs panel-default" style="width:1200" >
	<div class="panel-heading">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab1default" data-toggle="tab">Info</a></li>
				<li><a href="#tab2default" data-toggle="tab">Calendar</a></li>
				<li><a href="#tab3default" data-toggle="tab">Personal Statistics</a></li>
			</ul>
	</div>
	<div class="panel-body">
		<div class="tab-content">
			<div class="tab-pane fade in active" id="tab1default">
			<section class="container-fluid">
				<div class="card">
					<div class="col-md-6 col-sm-12">
						<div class="about">
							<h3 class="accent">Contracts</h3>
							<p>Here you can see your contracts by type</p>
							<iframe width="500" height="325" src="//embed.chartblocks.com/1.0/?c=5ecc11b23ba0f67804d82b5b&t=1d738ad96a103df" frameBorder="0"></iframe>
						</div>
					</div>
					
					<div class="col-md-6 col-sm-12">
						<div class="skills">
							<h2 class="white">Tasks</h2>
							<strong>Task opened: <?php echo $num_open_tasks?></strong><br>
							<strong>Task completed: <?php echo $num_compl_tasks?></strong>
							<span class="pull-right"><?php echo $percent?>%</span>
								<div class="progress">
									<div class="progress-bar progress-bar-primary" role="progressbar" 
									aria-valuenow="<?php echo $percent?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent + "%"?>"></div>
								</div>
						</div>
					</div>
					
					
				</div>
			</section>
			<!-- contact and experience -->
			<section class="container">
				<div class="row">
					<div class="col-md-4 col-sm-12">
						<div class="contact"  >
							<h2>Contact</h2>
								<p  ><el class="fa fa-phone"> </i> <?php echo $row['TEL_NUM'] ?></p>
								<strong><p><el class="fa fa-envelope"></i><?php echo $row['EMAIL'] ?></p></strong>
								<p ><el class="fa fa-globe"></i> www.company.com</p>
						</div>
					</div>
				</div>
			</section>
			</div>
			<div class="tab-pane fade" id="tab2default">
				<iframe src="calendar/calendar.html" height="900" width="1200" style="border:none;"></iframe>
			</div>
			<div class="tab-pane fade" id="tab3default">
				
				<iframe width="650" height="400" src="//embed.chartblocks.com/1.0/?c=5eca92a63ba0f6986ed82b5c&t=4061f4e113da87e" frameBorder="0"></iframe>
				

				<iframe width="500" height="400" src="//embed.chartblocks.com/1.0/?c=5eca96133ba0f63770d82b5b&t=a98e4d46d9486b5" frameBorder="0"></iframe>
	
			</div>
		</div>
	</div>
</div>
</div>



<!-- </div> -->
<!-- footer section -->
<!-- javascript js -->	

</div>
</body>
</html>