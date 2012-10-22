<?php

class SubCat extends IntegratedDataBase {
	var $NTable = 'subcat';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll($cat_id) {
		
		$this->Objects = $this->DB->ReadAss("
            SELECT sc.*, CONCAT( o_cat.url, '/',sc.sc_url) as full_url 
            FROM {$this->NTable} sc, o_cat 
            WHERE sc.cat_id=$cat_id AND o_cat.cat_id=sc.cat_id  
            ORDER BY sc.sc_name");
		
	}
	
	function ReadSame($sc_id) {
		
		$cat_id = $this->DB->ReadScalar("Select cat_id FROM {$this->NTable} WHERE sc_id = ".$sc_id);
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} where cat_id=$cat_id ORDER BY sc_name DESC");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("
              SELECT sc.*, CONCAT( o_cat.url, '/',sc.sc_url) as full_url 
              FROM {$this->NTable} sc, o_cat 
              WHERE sc_id='$ObjectID' AND o_cat.cat_id=sc.cat_id ",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['sc_name'] = trim($Vars['sc_name']);
		if (!$Vars['sc_name']) {
			$Errors['sc_name'] = $Global['No value'];
			return false;
		}
		
		return true;
	}
	
	function Edit() {
		global $User;
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['sc_id'];
		unset ($Vars['sc_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return false;
			
			if (!$this->CheckSentVars($Vars)) return;
			$Vars['sc_url'] = translit($Vars['sc_name']);
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_cats/{$Vars[cat_id]}/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$Vars['sc_url'] = translit($Vars['sc_name']);
			$this->DB->EditDB($Vars,$this->NTable,"sc_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_cats/{$Vars[cat_id]}/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return false;
			
			$this->DB->DeleteDB($this->NTable, 'sc_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_cats/{$Vars[cat_id]}");
		}
		
	}
	
	
}

?>