<ul class="nav navbar-nav">
	<li><a href="?gn=emp_clients" <?php if($tableName == 'emp_clients') echo 'class="active"'; ?>>Clients</a></li>
	<li><a href="?gn=emp_current_tasks" <?php if($tableName == 'emp_current_tasks') echo 'class="active"'; ?>>My current tasks</a></li>
	<li><a href="?gn=emp_task_compl" <?php if($tableName == 'emp_task_compl') echo 'class="active"'; ?>>My completed tasks</a></li>
	<li><a href="?gn=report" <?php if($tableName == 'report') echo 'class="active"'; ?>>Report</a></li>
	<li style="float:right"><a href="?gn=logout" class="logout-btn glyphicon-log-out"> Logout</a></li>
</ul>
<?php
session_start();
switch($tableName)
{		
	case "emp_clients":
	if($link != "emp_clients")
	{
		header("location: emp_clients.php");
	}
		
	break;

	case "emp_current_tasks":
	if($link != "emp_current_tasks")
	{
		header("location: emp_current_tasks.php");
	}
		
	break;
	
	case "emp_task_compl":
	if($link != "emp_task_compl")
	{
		header("location: emp_task_compl.php");
	}
		
	break;
	
	
	case "report":
	if($link != "report")
	{
		header("location: report_main.php");
	}
		
	break;
	

	case "logout":
		unset($_SESSION['user_id']);
		unset($_SESSION['perm']);
		session_destroy();
		header("Location: ../index.php");
		exit;
	break;
}
$tableName = '';
?>