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
class Employee extends Common
{
	protected $Editor;
	protected $instanceName = 'mate1_';
	
	protected function setHeaderFiles()
	{
		$this->headerFiles[] = '<script type="text/javascript" src="//cdn.jsdelivr.net/ckeditor/4.0.1/ckeditor.js"></script>';
	}
	
	protected function displayHtml()
	{
		
		$link = "employ";
		$tableName = (isset($_GET['gn']) && $_GET['gn'] !== '') ? $_GET['gn'] : 'employ';
		
		include 'menu.php';

		
		
		$html = '

			<div class="mateAjaxLoaderDiv"><div id="ajaxLoader1"><img src="../images/ajax_loader.gif" alt="Loading..." /></div></div>

			<div id="'.$this->instanceName.'information">
			</div>
			
			<div id="'.$this->instanceName.'titleLayer" class="mateTitleDiv">
			</div>
			
			<div id="'.$this->instanceName.'tableLayer" class="mateTableDiv">
			</div>
			
			<div id="'.$this->instanceName.'searchButtonsLayer" class="mateSearchBtnsDiv">
			</div>
			
			<div id="'.$this->instanceName.'recordLayer" class="mateRecordLayerDiv">
			</div>'
			
			;
			
		echo $html;
		
		// Set default session configuration variables here
		$defaultSessionData['orderByColumn'] = 'first_name';

		$defaultSessionData = base64_encode($this->Editor->jsonEncode($defaultSessionData));
		
		$javascript = '	
			<script type="text/javascript">
				var ' . $this->instanceName . ' = new mate("' . $this->instanceName . '");
				' . $this->instanceName . '.setAjaxInfo({url: "' . $_SERVER['PHP_SELF'] . '", history: true});
				' . $this->instanceName . '.init("' . $defaultSessionData . '");
				
				function addCkEditor(id)
				{
					if(CKEDITOR.instances[id])
					{
					   CKEDITOR.remove(CKEDITOR.instances[id]);
					}
					CKEDITOR.replace(id);
				}
				
			</script>';
		echo $javascript;
	}



public function valEmail($col,$val,$row,$instanceName)
{
     if(preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $val) || preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/',$val))
     {
          return true;
     }
     else
     {
          // Create custom validation message and return false
          $this->Editor->showDefaultValidationMsg = false;
          $this->Editor->addTooltipMsg('Please enter a valid email address');
          return false;
     }
}

public function valTel($col,$val,$row,$instanceName)
{
   if (preg_match("/^\+([0-9]{3} ){3}[0-9]{3}$/", $val)) {
   

     
          return true;
     }
     else
     {
          // Create custom validation message and return false
          $this->Editor->showDefaultValidationMsg = false;
          $this->Editor->addTooltipMsg('Please enter a valid telephone_number');
          return false;
     }
}



	
	protected function initiateEditor()
	{
		$tableColumns['USER_ID'] = array(
			'display_text' => 'Employee ID', 
			'perms' => 'TQSO'
		);
		
		$tableColumns['ROLE_ID'] = array(
			'display_text' => 'Role', 
			'join' => array(
				'table' => 'roles_ref', 
				'column' => 'ROLE_ID', 
				'display_mask' => "roles_ref.role_desc", 
				'type' => 'inner',
			),
			'perms' => 'EVCTAXQSF', 'req' => true
		);
		
		$tableColumns['LAST_NAME'] = array(
			'display_text' => 'Last Name', 
			'perms' => 'EVCTAXQSHOF'
		);
		
		$tableColumns['FIRST_NAME'] = array(
			'display_text' => 'First Name', 
			'perms' => 'EVCTAXQSHOF'
		);
		
		$tableColumns['EMAIL'] = array(
			'display_text' => 'E-Mail', 
			'input_type' => 'email',
			'perms' => 'EVCTAXQSHOF',
            'val_fun' => array(&$this,'valEmail')			
		); 
		
		
		
		$tableColumns['TEL_NUM'] = array(
			'display_text' => 'Telephone', 
			'perms' => 'EVCTAXQSHOF', 
			'val_fun' => array(&$this,'valTel')	
		); 
		
		
	
		
		$tableName = 'employees';
		$primaryCol = 'USER_ID';
		$errorFun = array(&$this,'logError');
		$permissions = 'EAVDQCSXHOI';
		
		$this->Editor = new AjaxTableEditor($tableName,$primaryCol,$errorFun,$permissions,$tableColumns);
		$this->Editor->setConfig('tableInfo','cellpadding="1" cellspacing="1" align="center" width="1100" class="mateTable"');
		$this->Editor->setConfig('orderByColumn','last_name');
		$this->Editor->setConfig('tableTitle','<div class="text-center"><h1>Employees</h1></div>');
		$this->Editor->setConfig('addRowTitle','Add Employee');
		$this->Editor->setConfig('editRowTitle','Edit Employee');
		
		$this->Editor->setConfig('instanceName',$this->instanceName);
		$this->Editor->setConfig('persistentAddForm',false);
		$this->Editor->setConfig('paginationLinks',true);
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
			$this->setHeaderFiles();
			$this->displayHeaderHtml();
			$this->displayHtml();
			$this->displayFooterHtml();
		}
	}
}
$page = new Employee();
?>
