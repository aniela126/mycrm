<?php
/*
 * Mysql Ajax Table Editor
 *
 * Copyright (c) 2014 Chris Kitchen <info@mysqlajaxtableeditor.com>
 * All rights reserved.
 *
 * See COPYING file for license information.
 *
 * Download the latest version from
 * http://www.mysqlajaxtableeditor.com
 */
require_once('../DBC.php');
require_once('Common.php');
require_once('../php/lang/LangVars-en.php');
require_once('../php/AjaxTableEditor.php');
class AdminLogin extends Common
{
	protected $mateInstances = array('mate1_');

	protected function displayHtml()
	{
		$link = "login";
		$tableName = (isset($_GET['gn']) && $_GET['gn'] !== '') ? $_GET['gn'] : 'login';
		include 'menu.php';
		
		$html = '

			<div class="mateAjaxLoaderDiv"><div id="ajaxLoader1"><img src="../images/ajax_loader.gif" alt="Loading..." /></div></div>

			<div id="'.$this->mateInstances[0].'information">
			</div>

			<div id="mateTooltipErrorDiv" style="display: none;"></div>

			
			<div id="'.$this->mateInstances[0].'titleLayer" class="mateTitleDiv">
			</div>
			
			<div id="'.$this->mateInstances[0].'tableLayer" class="mateTableDiv">
			</div>
			
			<div id="'.$this->mateInstances[0].'recordLayer" class="mateRecordLayerDiv">
			</div>		
			
			<div id="'.$this->mateInstances[0].'searchButtonsLayer" class="mateSearchBtnsDiv">
			</div>';
		echo $html;
		// Set default session configuration variables here
		$defaultSessionData['orderByColumn'] = 'user_id';
		
		$defaultSessionData = base64_encode($this->Editor->jsonEncode($defaultSessionData));
		
		
		$javascript = '	
			<script type="text/javascript">
				var ' . $this->mateInstances[0] . ' = new mate("' . $this->mateInstances[0] . '");
				' . $this->mateInstances[0] . '.setAjaxInfo({url: "' . $_SERVER['PHP_SELF'] . '", history: false});
				' . $this->mateInstances[0] . '.init("' . $defaultSessionData . '");
			</script>';
		echo $javascript;
	}

	public function updateLogin($empId,$instanceName)
	{
		$query = "select FIRST_NAME, LAST_NAME from employees where USER_ID = :empId";
		$queryParams = array(
		'empId' => $empId);
		$result = $this->Editor->doQuery($query,$queryParams);
		if($row = $result->fetch())
		{
		$suggestedLogin = strtolower(substr($row['FIRST_NAME'],0,1).$row['LAST_NAME']).rand(100,999);
			$this->Editor->setHtmlValue('LOGIN',$suggestedLogin);
		}
	}

	public function checkForPassword($col,$val,$row)
	{
		if(strlen(trim($row['PASSWORD'])) == 0)
		{
			return false;
		}
		return $val;
	}
	
	public function removePassword($col,$val,$row)
	{
		return '';
	}
	
	function valPass($col,$val,$row,$instanceName)
{
     if(preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{6,20}$/', $val) )
	 
	 {
    return true;
         
}
     else
     {
		 
		  $this->Editor->showDefaultValidationMsg = false;
          $this->Editor->addTooltipMsg('Please enter a valid password');
		  return false;
       
         
     }
}
	
	protected function initiateEditor()
	{
		$tableColumns['ID'] = array(
			'display_text' => 'ID', 
			'perms' => ''
		);
		
		$tableColumns['EMP_ID'] = array(
			'display_text' => 'Name', 'perms' => 'VCTAXQS',
			'join' => array(
				'table' => 'employees', 
				'column' => 'USER_ID', 
				'display_mask' => "concat(employees.FIRST_NAME,' ',employees.LAST_NAME)", 
				'type' => 'inner',
			),
			'input_info' => 'onchange="'.$this->mateInstances[0].'.toAjaxTableEditor(\'update_login\',$(this).val());"'
			
	
	);
		
		
		$tableColumns['LOGIN'] = array(
			'display_text' => 'Login', 
			'perms' => 'EVCTAXQS',
 
		);
		
		
		
		$tableColumns['PASSWORD'] = array(
			'display_text' => 'Password', 
			'perms' => 'EVCAXQT', 
			'input_type' => 'password', 
			'on_edit_fun' => array(&$this,'checkForPassword'), 
			//'mysql_add_fun' => 'PASSWORD(:password)',
			//'mysql_add_fun' => 'PASSWORD(#VALUE#)',
			//'mysql_edit_fun' => 'PASSWORD(:password)', 
			//'mysql_edit_fun' => 'PASSWORD(#VALUE#)', 
			'edit_fun' => array(&$this,'removePassword'),
			'val_fun' => array(&$this,'valPass')
		);
		
		
		$tableName = 'user_inform';
		$primaryCol = 'ID';
		$errorFun = array(&$this,'logError');
		$permissions = 'EAVDQSIXU';
		
		//require_once('php/AjaxTableEditor.php');
		
		
		$this->Editor = new AjaxTableEditor($tableName,$primaryCol,$errorFun,$permissions,$tableColumns);
		$this->Editor->setConfig('editScreenFun',array(&$this,'addCkEditor'));
		//$this->Editor->setConfig('allowEditMult',true); 
		$this->Editor->setConfig('tableInfo','cellpadding="1" width="900" class="mateTable"');
		$this->Editor->setConfig('tableTitle','<div class="text-center"><h1>Login information</h1></div>');
		$this->Editor->setConfig('addRowTitle','Add Login Info');
		$this->Editor->setConfig('editRowTitle','Edit Login Info ');
		$this->Editor->setConfig('viewRowTitle','View Login Info');
		$userActions = array('update_login' => array(&$this,'updateLogin'));
		$this->Editor->setConfig('userActions',$userActions);
		//$this->Editor->setConfig('viewQuery',true);
	}
	
	
	
	function __construct()
	{
		session_start();
		ob_start();
		$this->initiateEditor();
		if(isset($_POST['json']))
		{
			if(ini_get('magic_quotes_gpc'))
			{
				$_POST['json'] = stripslashes($_POST['json']);
			}
			$this->Editor->data = $this->Editor->jsonDecode($_POST['json'],true);
			$this->Editor->setDefaults();
			$this->Editor->main();
		}
		else if(isset($_GET['mate_export']))
		{
			$this->Editor->data['sessionData'] = $_GET['session_data'];
			$this->Editor->setDefaults();
			ob_end_clean();
			header('Cache-Control: no-cache, must-revalidate');
			header('Pragma: no-cache');
			header('Content-type: application/x-msexcel');
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="'.$this->Editor->tableName.'.csv"');
			// Add utf-8 signature for windows/excel
			echo chr(0xEF).chr(0xBB).chr(0xBF);
			echo $this->Editor->exportInfo();
			exit();
		}
		else
		{
			$this->displayHeaderHtml();
			$this->displayHtml();
			$this->displayFooterHtml();
		}
	}
}
$page = new AdminLogin();
?>