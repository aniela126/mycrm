<br/>
<div id="container-fluid">
	<ul>
		<li><a href="?gn=login" <?php if($tableName == 'login') echo 'class="active"'; ?>> Login info</a></li>
		<li><a href="?gn=manager_admin_clients" <?php if($tableName  == 'manager_admin_clients') echo 'class="active"'; ?>> Clients</a></li>
		<li><a href="?gn=employ" <?php if($tableName  == 'employ') echo 'class="active"'; ?>> Employees</a></li>
		<li><a href="?gn=tasks" <?php if($tableName == 'tasks') echo 'class="active"'; ?>>Change author for the task</a></li>
		<li><a href="?gn=taskscompl" <?php if($tableName == 'taskscompl') echo 'class="active"'; ?>> Finished tasks</a></li>
		<li style="float:right" class="logout" ><a href="?gn=logout" <?php if($tableName == 'logout') echo 'class="active"'; ?>> Logout</a></li>
	</ul>
</div>
<?php
session_start();
switch($tableName)
{		
	case "login":
	if($link != "login")
	{
		header("location: admin_login.php");
	}
		
	break;

	case "tasks":
	if($link != "tasks")
	{
		header("location: admin_task_author_change.php");
	}
		
	break;
	
	case "taskscompl":
	if($link != "taskscompl")
	{
		header("location: admin_task_coml_change.php");
	}
		
	break;
	
	case "employ":
	if($link != "employ")
	{
		header("location: employees.php");
	}
		
	break;
	
	case "manager_admin_clients":
	if($link != "manager_admin_clients")
	{
		header("location: manager_admin_clients.php");
	}
		
	break;
	
	case "logout":
		session_start();
		unset($_SESSION['email']);
		unset($_SESSION['pass']);
		session_destroy();

		header("Location: ../index.php");
		exit;
	break;
}
$tableName = '';
?>