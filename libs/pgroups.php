<?php

class PGroup extends IntegratedDataBase {
	var $NTable = 'pgroups';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY pgroup_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE pgroup_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['pgroup_name'] = trim($Vars['pgroup_name']);
		if (!$Vars['pgroup_name']) {
			$Errors['pgroup_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['pgroup_id'];
		unset ($Vars['pgroup_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_users/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"pgroup_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_users/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			
			$this->DB->DeleteDB($this->NTable, 'pgroup_id=' . $ObjectID);
			$this->DB->EditDB(array('pgroup_id'=>-1), 'users', 'pgroup_id=' . $ObjectID);
			$this->Go("{$Global['Host']}/edit_users");
		}
		
	}
}

?>