<?php

class Otziv extends IntegratedDataBase {
	var $NTable = 'recall';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY recall_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE recall_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		global $_SESSION;
		
		
		$Vars['recall_name'] = trim($Vars['recall_name']);
		if (!$Vars['recall_name']) {
			$Errors['recall_name'] = 'Не введёно имя';
			return false;
		}
		
		$Vars['recall_text'] = trim($Vars['recall_text']);
		if (!$Vars['recall_text']) {
			$Errors['recall_text'] = 'Не введён текст';
			return false;
		}
		
		if ($Vars['recall_key'] != $_SESSION['captcha_keystring']) {
			$Errors['recall_key'] = $Global['Wrong Captcha'];
			return false;
		}
		
		unset($Vars['recall_key']);
		
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['recall_id'];
		unset ($Vars['recall_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_recalls/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"recall_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_recalls/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			
			
			$this->DB->DeleteDB($this->NTable, 'recall_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_recalls");
		}
		
	}
	
	function AddComment() {
		
		global $HTTP_POST_VARS;
		global $Global;
		global $User;
		global $ERROR;
		
		$Vars = $HTTP_POST_VARS;
		if (!$this->CheckSentVars($Vars)) return;
		
		unset($Vars['sender']);
		
		if (strstr($Vars['recall_text'],"http")) return 0;
		
		$Vars['recall_text'] = $this->CleanTag($Vars['recall_text']);
		
		$Vars['recall_text'] = str_replace("\n", '<br />', $Vars['recall_text']);
		
		$Vars['recall_name'] = $this->CleanTag($Vars['recall_name']);
		
		$this->DB->EditDB($Vars, 'recall');
	}
	
	function DeleteComment() {
		
		global $HTTP_POST_VARS;
		global $Global;
		global $User;
		global $ERROR;
		
		$Vars = $HTTP_POST_VARS;
		$this->DB->DeleteDB('recall', 'recall_id='.$Vars['recall_id']);
	}
	
	function AdmComment() {
		
		global $HTTP_POST_VARS;
		global $Global;
		global $User;
		global $ERROR;
		
		$Vars = $HTTP_POST_VARS;
		$this->DB->EditDB(array('recall_adm'=>'1'), 'recall', 'recall_id='.$Vars['recall_id']);
	}
	
	function ShowLastComments($count) {
		$tmp = $this->DB->ReadAss('SELECT recall.*,  FROM recall ORDER BY recall_id DESC LIMIT '.$count);
				
		foreach ($tmp as $row) {
			echo "<a href='{$Global['Host']}/{$row['section_point']}/{$row['page_point']}'>{$row['comment_text']}</a>";
			echo "<br /><br />";
			
		}
	}
	
}

?>