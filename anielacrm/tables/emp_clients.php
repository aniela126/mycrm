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
class TaskCompl extends Common
{
	protected $mateInstances = array('mate1_');

	protected function displayHtml()
	{
		
		$link = "emp_clients.php";
		$tableName = (isset($_GET['gn']) && $_GET['gn'] !== '') ? $_GET['gn'] : 'emp_clients.php';
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
	
		$defaultSessionData = base64_encode($this->Editor->jsonEncode($defaultSessionData));
		
		
		$javascript = '	
			<script type="text/javascript">
				var ' . $this->mateInstances[0] . ' = new mate("' . $this->mateInstances[0] . '");
				' . $this->mateInstances[0] . '.setAjaxInfo({url: "' . $_SERVER['PHP_SELF'] . '", history: false});
				' . $this->mateInstances[0] . '.init("' . $defaultSessionData . '");
			</script>';
		echo $javascript;
	}

	
	
	protected function initiateEditor()
	{
		$tableColumns['CLIENT_ID'] = array(
			'display_text' => 'ID', 
			'perms' => 'VX'
		);
		
		$tableColumns['CLIENT_TYPE_ID'] = array(
			'display_text' => 'Client Type', 
			'join' => array(
				'table' => 'client_type_ref', 
				
				'column' => 'CLIENT_TYPE_ID', 
				'display_mask' => "client_type_ref.CLIENT_TYPE_DESC", 
				'type' => 'inner',
			),
			'perms' => 'VCTAXQSHOF'
		);
		
		$tableColumns['COMPANY_ID'] = array(
		'display_text' => 'Company', 
				'join' => array(
				'table' => 'client_company_ref', 
				'column' => 'COMPANY_ID', 
				'display_mask' => " client_company_ref.COMPANY_DESC", 
				'type' => 'inner',
			),
			'perms' => 'EVCTAXQSHOF'
			
		);
		
		$tableColumns['LAST_NAME'] = array(
			'display_text' => 'Last Name', 
			
			'perms' => 'EVCTAXQSHOF'
		);
		
		$tableColumns['FIRST_NAME'] = array(
			'display_text' => 'First Name',
			
			'perms' => 'EVCTAXQSHO'
		
		); 
		
		$tableColumns['TEL_NUM'] = array(
			'display_text' => 'Telephone', 		
			'perms' => 'EVCTXQSHO',
		
		); 
		
		$tableColumns['EMAIL'] = array(
			'display_text' => 'E-mail', 
			
			'perms' => 'EVCTAXQSHO'
		); 
		
		
		
		$tableName = 'clients';
		$primaryCol = 'LAST_NAME';
		$errorFun = array(&$this,'logError');
		$permissions = 'VQSXUOF';
		
		//require_once('php/AjaxTableEditor.php');
		
		
		$this->Editor = new AjaxTableEditor($tableName,$primaryCol,$errorFun,$permissions,$tableColumns);
		$this->Editor->setConfig('editScreenFun',array(&$this,'addCkEditor'));
		//$this->Editor->setConfig('allowEditMult',true); 
		$this->Editor->setConfig('tableInfo','cellpadding="1" width="900" class="mateTable"');
		$this->Editor->setConfig('tableTitle','Clients');
		$this->Editor->setConfig('addRowTitle','<div class="text-center"><h1>Add new client</h1></div>');
		$this->Editor->setConfig('editRowTitle','Edit client info');
		$this->Editor->setConfig('viewRowTitle','View client info');
		//$userActions = array('update_login' => array(&$this,'updateLogin'));
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

		$page = new TaskCompl();
?>