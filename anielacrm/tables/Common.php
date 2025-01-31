<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
class Common
{		
	
	protected $langVars;	
	protected $headerFiles = array();
	protected $showBackLink = true;
	
	public function logError($message, $file, $line)
	{
		$message = sprintf('An error occurred in script %s on line %s: %s',$file,$line,$message);
		throw new Exception($message);
		echo '<span style="color: red;">'.$message.'</span>';
		//var_dump($message);
		exit();
	}


	protected function displayHeaderHtml()
	{
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
		<title>Mate Example</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="../css/table_styles.css" rel="stylesheet" type="text/css" />
		<link href="../css/icon_styles.css" rel="stylesheet" type="text/css" />
		<link href="../css/menustyle.css" rel="stylesheet" type="text/css" />
		
		<link rel='stylesheet' href='../css/bootstrap.min.css' type='text/css'/>
		<link rel='stylesheet' href='../css/font-awesome.min.css' type='text/css'/>
		<link rel='stylesheet' href='../css/profile.css' type='text/css'/>
		<script src='../js/jquery.js'></script>
		<script src='../js/bootstrap.min.js'></script>	
		<script src='../js/jquery.backstretch.min.js'></script>
		<script src='../js/custom.js'></script>
		
		<link href="../js/jquery/css/redmond/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../js/jquery/js/jquery-1.8.3.js"></script>
		<script type="text/javascript" src="../js/jquery/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="../js/jquery/js/jquery.json.min.js"></script>

		<!-- Only needed if using cookie storage -->
		<script type="text/javascript" src="../js/jquery/js/jquery.cookie.js"></script>

		<script type="text/javascript" src="../js/jquery/js/jquery.storageapi.min.js"></script>
		
		<script type="text/javascript" src="../js/ajax_table_editor.js"></script>

		<?php echo implode("\n",$this->headerFiles); ?>
		
		

		</head>	
		<body>
		<div class="preloader">
			<div class="sk-spinner sk-spinner-wordpress">
				<span class="sk-inner-circle"></span>
			</div>
		</div>
		<?php
	}		
	
	protected function displayFooterHtml()
	{
		?>
		<?php if($this->showBackLink): ?>
			<br /><br /><br /><br />
		<?php endif; ?>
		</body>
		</html>
		<?php
	}	
	
	protected function getAjaxUrl()
	{
		$ajaxUrl = $_SERVER['PHP_SELF'];
		if(count($_GET) > 0)
		{
			$queryStrArr = array();
			foreach($_GET as $var => $val)
			{
				$queryStrArr[] = $var.'='.urlencode($val);
			}
			$ajaxUrl .= '?'.implode('&',$queryStrArr);
		}
		return $ajaxUrl;
	}
	
}
?>
