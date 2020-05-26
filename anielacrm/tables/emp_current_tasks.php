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
		
		$link = "emp_current_tasks";
		
		$tableName = (isset($_GET['gn']) && $_GET['gn'] !== '') ? $_GET['gn'] : 'emp_current_tasks';
		include 'menu.php';
		
		$emp_id = $_SESSION["user_id"];
		
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
		$tableColumns['TASK_ID'] = array(
			'display_text' => 'ID', 
			'perms' => 'VX'
		);
		
		$tableColumns['TODO_DESC_ID'] = array(
			'display_text' => 'TODO Description', 
			'join' => array(
				'table' => 'todo_desc_ref', 
				
				'column' => 'TODO_DESC_ID', 
				'display_mask' => "todo_desc_ref.TODO_DESC", 
				'type' => 'inner',
			),
			'perms' => 'VCTAXQSHOF'
		);
		
		$tableColumns['CONTRACT_ID'] = array(
		'display_text' => 'Contract', 
				'join' => array(
				'table' => 'fin', 
				'column' => 'ID', 
				'display_mask' => "concat(fin.ID,': ', fin.DESCQ)", 
				'type' => 'inner',
			),
			'perms' => 'VCTAXQSHOF'
			
		);
		
		$tableColumns['AUTHOR_ID'] = array(
			'display_text' => 'Author', 
			'join' => array(
				'table' => 'employees', 
				'column' => 'USER_ID', 
				'display_mask' => "concat(employees.FIRST_NAME,' ',employees.LAST_NAME)", 
				'type' => 'inner',
			),
			'perms' => 'VCTAXQSHOF'
		);
		
		$tableColumns['EXECUTOR_ID'] = array(
			'display_text' => 'Executor',
			
			'perms' => ''
		
		); 
		
		$tableColumns['TASK_STATUS_ID'] = array(
			'display_text' => 'Task Status', 
			'join' => array(
				'table' => 'task_status_ref', 
				'column' => 'TASK_STATUS_ID', 
				'display_mask' => "task_status_ref.TASK_STAT_DESC", 
				'type' => 'inner',
			),			
			'perms' => 'EVCTXQSHOF',
			'default' => 'Open' 
		); 
		
		$tableColumns['PRIORITY_ID'] = array(
			'display_text' => 'Priority', 
			'join' => array(
				'table' => 'priority_ref', 
				'column' => 'PRIORITY_ID', 
				'display_mask' => "priority_ref.PRIORITY_DESC", 
				'type' => 'inner',
			),	
			'perms' => 'VCTAXQSHOF'
		); 
		
		
		
		$tableColumns['DATE_START'] = array(
			'display_text' => 'Date start', 
			'req' => true, 
			'perms' => 'VCTAXQSHOF', 
			'display_mask' => 'date_format(`DATE_START`,"%d %M %Y")', 
			'order_mask' => 'tasks.DATE_START',
			'range_mask' => 'tasks.DATE_START',
			'calendar' => array('js_format' => 'dd MM yy', 
				'options' => array('showButtonPanel' => false)),
			'col_header_info' => 'style="width: 200px;"'
			
		);
		
		$tableColumns['DATE_END'] = array(
			'display_text' => 'Date end', 
			'req' => true, 
			'perms' => 'ECAXQSHOF', 
			'display_mask' => 'date_format(`DATE_END`,"%d %M %Y")', 
			'order_mask' => 'tasks.DATE_END',
			'range_mask' => 'tasks.DATE_END',
			'calendar' => array('js_format' => 'dd MM yy', 
				'options' => array('showButtonPanel' => false)),
			'col_header_info' => 'style="width: 200px;"'
		);

		$tableColumns['COMMENT'] = array(
			'display_text' => 'Comment', 
			'perms' => 'EVCTAXQSHO', 
			'textarea' => array('rows' => 8, 'cols' => 25), 
			'sub_str' => 30
			);
		
		$tableName = 'tasks';
		$primaryCol = 'TASK_ID';
		$errorFun = array(&$this,'logError');
		$permissions = 'EIVQSXU';
		
		//require_once('php/AjaxTableEditor.php');
		
		
		$this->Editor = new AjaxTableEditor($tableName,$primaryCol,$errorFun,$permissions,$tableColumns);
		$this->Editor->setConfig('editScreenFun',array(&$this,'addCkEditor'));
		//$this->Editor->setConfig('allowEditMult',true); 
		$this->Editor->setConfig('tableInfo','cellpadding="1" width="900" class="mateTable"');
		$this->Editor->setConfig('tableTitle','<div class="text-center"><h1>My current tasks</h1></div>');
		$this->Editor->setConfig('addRowTitle','Add new task');
		$this->Editor->setConfig('editRowTitle','Edit task');
		$this->Editor->setConfig('viewRowTitle','View task info');
		//$userActions = array('update_login' => array(&$this,'updateLogin'));
		$this->Editor->setConfig('userActions',$userActions);
		//$this->Editor->setConfig('viewQuery',true);
	
		$this->Editor->setConfig('sqlFilters',"EXECUTOR_ID=" . $_SESSION['user_id'] . " and task_status_ref.TASK_STAT_DESC='Open'"); 
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