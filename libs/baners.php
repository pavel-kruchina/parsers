<?php

class Baner extends IntegratedDataBase {
	var $NTable = 'baners';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY b_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE b_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['b_name'] = trim($Vars['b_name']);
		if (!$Vars['b_name']) {
			$Errors['b_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['b_id'];
		unset ($Vars['b_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		$Vars['b_activ'] = ($Vars['b_activ'])?1:0; 
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_baners/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"b_id='$ObjectID'");
			
			$this->Go("{$Global['Host']}/edit_baners/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			
			$this->DB->DeleteDB($this->NTable, 'b_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_baners");
		}
		
	}
	
	function ShowBaner($place) {
		global $Global;
		$b = $this->DB->ReadScalar('Select b_text from baners WHERE b_place ='.$place.' AND b_activ ORDER by Rand() LIMIT 1');
		echo $b;
	}
	
	
}

?>