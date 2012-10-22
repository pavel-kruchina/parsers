<?php

function psort($a1, $a2) {
	
	return ($a1['matprice']-$a2['matprice'])*(-1);
}

class Mat extends IntegratedDataBase {
	var $NTable = 'mats';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY mat_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE mat_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['mat_name'] = trim($Vars['mat_name']);
		if (!$Vars['mat_name']) {
			$Errors['mat_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['mat_id'];
		unset ($Vars['mat_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_mats/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"mat_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_mats/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			
			
			$this->DB->DeleteDB($this->NTable, 'mat_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_mats");
		}
		
	}
	
	function GetPriceForGood($id) {
		$this->ReadAll();
		
		$res = $this->Objects;
		
		$tmp = $this->DB->ReadAss("select mat_price.*, mats.mat_name, mats.mat_desc from mat_price,mats where mat_price.good_id=$id AND mats.mat_id = mat_price.mat_id ORDER by mat_price.matprice DESC");
		
		if (!$tmp) $tmp = array();
		
		foreach ($tmp as $row) {
			
			foreach (array_keys($res) as $key) {
				
				if ($res[$key]['mat_name'] == $row['mat_name'])
					$res[$key]['matprice'] = $row['matprice'];
			}
		}
		//var_dump($res);
		uasort($res, psort);
		//var_dump($res);
		return $res;
	}
}

?>