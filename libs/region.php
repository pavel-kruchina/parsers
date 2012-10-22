<?php

class Region extends IntegratedDataBase {
	var $NTable = 'region';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY region_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE region_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['region_name'] = trim($Vars['region_name']);
		if (!$Vars['region_name']) {
			$Errors['region_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['region_id'];
		unset ($Vars['region_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_regions/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"region_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_regions/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			
			global $TOWN;
			$TOWN->Delete($ObjectID);
			$this->DB->DeleteDB($this->NTable, 'region_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_regions");
		}
		
	}
	
	
}

?>