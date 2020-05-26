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
		
		$link = "manager_contracts";
		
		$tableName = (isset($_GET['gn']) && $_GET['gn'] !== '') ? $_GET['gn'] : 'manager_contracts';
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
		$defaultSessionData['orderByColumn'] = 'CLIENT_ID';
	
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
		$tableColumns['CONTRACT_ID'] = array(
			'display_text' => 'ID', 
			'perms' => 'VX'
		);
		
		$tableColumns['CLIENT_ID'] = array(
			'display_text' => 'Client', 
			'join' => array(
				'table' => 'clients', 
				
				'column' => 'CLIENT_ID', 
				'display_mask' => "concat(clients.LAST_NAME,' ', clients.FIRST_NAME)", 
				'type' => 'left',
			),
			'perms' => 'EVCTAXQSHOF'
		);
		

		
		$tableColumns['DESCRIPTION'] = array(
			'display_text' => 'Description', 
			'display_mask' => "concat(contracts.CONTRACT_ID, ': ', contracts.DESCRIPTION)",
			'perms' => 'EVCTAXQSHOF'
		);
		
		$tableColumns['DATE_OF_RECEIPT'] = array(
			'display_text' => 'Date of receipt', 
			'req' => true, 
			'perms' => 'VCTAXQSHOF', 
			'display_mask' => 'date_format(`DATE_OF_RECEIPT`,"%d %M %Y")', 
			'order_mask' => 'contracts.DATE_OF_RECEIPT',
			'range_mask' => 'contracts.DATE_OF_RECEIPT',
			'calendar' => array('js_format' => 'dd MM yy', 
				'options' => array('showButtonPanel' => false)),
			'col_header_info' => 'style="width: 200px;"'
			
		);
		
		
		$tableColumns['DATE_START'] = array(
			'display_text' => 'Date start', 
			'req' => true, 
			'perms' => 'VCTAXQESHOF', 
			'display_mask' => 'date_format(`DATE_START`,"%d %M %Y")', 
			'order_mask' => 'contracts.DATE_START',
			'range_mask' => 'contracts.DATE_START',
			'calendar' => array('js_format' => 'dd MM yy', 
				'options' => array('showButtonPanel' => false)),
			'col_header_info' => 'style="width: 200px;"'
			
		);
		
		$tableColumns['DATE_END'] = array(
			'display_text' => 'Date end', 
			'req' => true, 
			'perms' => 'VCTAXQESHOF', 
			'display_mask' => 'date_format(`DATE_END`,"%d %M %Y")', 
			'order_mask' => 'contracts.DATE_END',
			'range_mask' => 'contracts.DATE_END',
			'calendar' => array('js_format' => 'dd MM yy', 
				'options' => array('showButtonPanel' => false)),
			'col_header_info' => 'style="width: 200px;"'
			
		);
		
		$tableColumns['COST'] = array(
			'display_text' => 'Cost', 		
			'perms' => 'EVCTXQSHOA',
			'prefix' => '$'
		
		); 
		
		
		
		
		
		$tableName = 'contracts';
		$primaryCol = 'CONTRACT_ID';
		$errorFun = array(&$this,'logError');
		$permissions = 'EIVQSXUOAF';
		
		
		
		$this->Editor = new AjaxTableEditor($tableName,$primaryCol,$errorFun,$permissions,$tableColumns);
		$this->Editor->setConfig('editScreenFun',array(&$this,'addCkEditor'));
		//$this->Editor->setConfig('allowEditMult',true); 
		$this->Editor->setConfig('tableInfo','cellpadding="1" width="900" class="mateTable"');
		$this->Editor->setConfig('tableTitle','<div class="text-center"><h1>Contracts</h1></div>');
		$this->Editor->setConfig('addRowTitle','<div class="text-center"><h1>Add new contracts</h1></div>');
		$this->Editor->setConfig('editRowTitle','Edit contract info');
		$this->Editor->setConfig('viewRowTitle','View contract info');
		//$userActions = array('update_login' => array(&$this,'updateLogin'));
		// $this->Editor->setConfig('userActions',$userActions);
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