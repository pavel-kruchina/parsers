<?php

class Koef extends IntegratedDataBase {
	var $NTable = 'koefs';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY koef_order DESC, koef_value");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE koef_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['koef_name'] = trim($Vars['koef_name']);
		if (!$Vars['koef_name']) {
			$Errors['koef_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['koef_id'];
		unset ($Vars['koef_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_koefs/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"koef_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_koefs/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			
			
			$this->DB->DeleteDB($this->NTable, 'koef_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_koefs");
		}
		
	}
}

?>