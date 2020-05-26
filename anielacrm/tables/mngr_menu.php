<div class="collapse navbar-collapse " id="myNavbar">
	<ul class="nav navbar-nav">
		<li><a href="?gn=manager_tasks_current" <?php if($tableName == 'manager_tasks_current') echo 'class="active"'; ?>>My current tasks</a></li>
		<li><a href="?gn=manager_tasks_compl" <?php if($tableName == 'manager_tasks_compl') echo 'class="active"'; ?>>My completed tasks</a></li>
		<li><a href="?gn=employ" <?php if($tableName  == 'employ') echo 'class="active"'; ?>>Employees</a></li>
		<li><a href="?gn=manager_admin_clients" <?php if($tableName == 'manager_admin_clients') echo 'class="active"'; ?>>Clients</a></li>
		<li><a href="?gn=manager_contracts" <?php if($tableName == 'manager_contracts') echo 'class="active"'; ?>>Contracts</a></li>
		<li><a href="?gn=report" <?php if($tableName == 'report') echo 'class="active"'; ?>>Report</a></li>
	</ul>

<ul class="nav navbar-nav navbar-right">
	<li><a href="?gn=profile" <?php if($tableName == 'prof') echo 'class="active"'; ?>>Profile</a></li>
	<li><a href="?gn=logout"> Logout</a></li>
</ul>
</div>

<?php
switch($tableName)
{
	case "manager_admin_clients":
	if($link != "manager_admin_clients")
	{
		header("location: manager_admin_clients.php");
	}
	break;

	case "manager_tasks_compl":
	if($link != "manager_tasks_compl")
	{
		header("location: manager_tasks_compl.php");
	}
	break;
	
	case "emp_task_compl":
	if($link != "emp_task_compl")
	{
		header("location: emp_task_compl.php");
	}
	break;
	
	case "manager_tasks_current":
	if($link != "manager_tasks_current")
	{
		header("location: manager_tasks_current.php");
	}
	break;
	
	case "manager_contracts":
	if($link != "manager_contracts")
	{
		header("location: manager_contracts.php");
	}
	break;
	
	case "report":
	if($link != "report")
	{
		header("location: report_main.php");
	}
	break;
	
	case "employ":
	if($link != "employ")
	{
		header("location: employees.php");
	}
	break;
	
	case "profile":
		if($link != "profile")
		{
			header("location: profile.php");
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

