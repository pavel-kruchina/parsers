<?php

class Area extends IntegratedDataBase {
	var $NTable = 'areas';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll($town_id) {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} where town_id = $town_id ORDER BY area_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE area_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['town_id'] = (int)$Vars['town_id'];
		
		if (!$Vars['town_id']) return false;
		
		$Vars['area_name'] = trim($Vars['area_name']);
		if (!$Vars['area_name']) {
			$Errors['area_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['area_id'];
		unset ($Vars['area_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_areas/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"area_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_areas/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
		
			$this->DB->DeleteDB($this->NTable, 'area_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_areas");
		}
		
	}
	
	function Delete($town_id) {
		global $OBJECT;
		
		$this->ReadAll($town_id);
		foreach ($this->Objects as $row) {
			$OBJECT->Delete($row['area_id']);
		}
		
		
		$this->DB->DeleteDB($this->NTable, 'town_id=' . $town_id);
		
	}
	
}

?>