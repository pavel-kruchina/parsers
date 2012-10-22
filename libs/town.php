<?php

class Town extends IntegratedDataBase {
	var $NTable = 'towns';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll($region_id) {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} where region_id = $region_id ORDER BY town_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE town_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['region_id'] = (int)$Vars['region_id'];
		
		if (!$Vars['region_id']) return false;
		
		$Vars['town_name'] = trim($Vars['town_name']);
		if (!$Vars['town_name']) {
			$Errors['town_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['town_id'];
		unset ($Vars['town_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_towns/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"town_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_towns/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
		
			$this->DB->DeleteDB($this->NTable, 'town_id=' . $ObjectID);
			$this->DB->DeleteDB("areas", 'town_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_towns");
		}
		
	}
	
	function Delete($region_id) {
		global $AREA;
		
		$this->ReadAll($region_id);
		foreach ($this->Objects as $row) {
			$AREA->Delete($row['town_id']);
		}
		
		$this->DB->DeleteDB($this->NTable, 'region_id=' . $region_id);
		
	}
	
	
}

?>