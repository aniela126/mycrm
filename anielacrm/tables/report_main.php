<?php
	session_start(); 
	ob_start();
	require_once "report.php";

	$head = "<html>
	<head>
	<link href='../css/menustyle.css' rel='stylesheet' type='text/css'/>
	<link href='../css/table_styles.css' rel='stylesheet' type='text/css'/>
	<link rel='stylesheet' href='../css/bootstrap.min.css' type='text/css'/>
	<link rel='stylesheet' href='../css/font-awesome.min.css' type='text/css'/>
	<link rel='stylesheet' href='../css/profile.css' type='text/css'/>
	<script src='../js/jquery.js'></script>
	<script src='../js/bootstrap.min.js'></script>	
	<script src='../js/jquery.backstretch.min.js'></script>
	<script src='../js/custom.js'></script>
	<title>Reports</title>
	</head>
	<body>";
	$end = "</body></html>";
	
	
	
	echo $head;
	$link = "report";
	$var_id = $_SESSION['perm'];
	$tableName = (isset($_GET['gn']) && $_GET['gn'] !== '') ? $_GET['gn'] : 'report';
	include "menu.php";
	$report = new Report;
	$report->run()->render();
	
	
	
	echo $end;
	
?>



<div data-spy="scroll" data-target=".navbar-collapse">

<!-- preloader section -->
<div class="preloader">
	<div class="sk-spinner sk-spinner-wordpress">
       <span class="sk-inner-circle"></span>
     </div>
</div>



