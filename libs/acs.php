<?php

class Ac extends IntegratedDataBase {
	var $NTable = 'acs';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY a_name DESC");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE a_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['a_name'] = trim($Vars['a_name']);
		if (!$Vars['a_name']) {
			$Errors['a_name'] = $Global['No value'];
			return false;
		}
		$t = $this->DB->ReadScalar('Select a_name from '.$this->NTable.' where a_name = "'.$Vars['a_name'].'"');
		if ($t) {
			$Errors['a_name'] = $Global['Exist value'];
			return false;
		}
		
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['a_id'];
		unset ($Vars['a_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_acs/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"a_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_acs/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			$this->DB->DeleteDB($this->NTable, 'a_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_acs");
		}
		
	}
	
	
}

?>