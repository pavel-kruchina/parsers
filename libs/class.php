<?php

class OClass extends IntegratedDataBase {
	var $NTable = 'o_class';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY class_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE class_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['class_name'] = trim($Vars['class_name']);
		if (!$Vars['class_name']) {
			$Errors['class_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['class_id'];
		unset ($Vars['class_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB(array('class_name'=>$Vars['class_name'], 'class_text'=>$Vars['class_text']),$this->NTable);
			$ObjectID = $this->DB->LastInserted;
			
			foreach($Vars['options'] as $row) {
				$row = trim($row);
				if ($row) {
					
					$this->DB->EditDB(array('option_name'=>$row,'class_id'=>$ObjectID),'n_options');
				}
			}
			
			$this->Go("{$Global['Host']}/edit_classes/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB(array('class_name'=>$Vars['class_name'], 'class_text'=>$Vars['class_text']),$this->NTable,"class_id='$ObjectID'");
			
			foreach($Vars['options'] as $row) {
				$row = trim($row);
				if ($row) {
					
					$this->DB->EditDB(array('option_name'=>$row,'class_id'=>$ObjectID),'n_options');
				}
			}
			
			foreach($Vars['exoptions'] as $key=>$row) {
				
				$key = (int)$key;
				$row = trim($row);
				if ($row) {
					
					$this->DB->EditDB(array('option_name'=>$row),'n_options', 'option_id = '.$key);
				} else {
					
					$this->DB->DeleteDB('n_options','option_id = '.$key);
					$this->DB->DeleteDB('v_options', 'option_id=' . $key);
				}
			}
			
			$this->Go("{$Global['Host']}/edit_classes/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
		
			$this->DB->DeleteDB($this->NTable, 'class_id=' . $ObjectID);
			
			$tmp = $this->DB->ReadAss('Select * from n_options WHERE class_id = '.$ObjectID);
			foreach($tmp as $row) {
				
				$this->DB->DeleteDB('v_options', 'option_id=' . $row['option_id']);
			}
			
			$this->DB->DeleteDB('n_options', 'class_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_classes");
		}
		
	}
	
	function GetExOptions($class_id) {
		
		$class_id = (int)$class_id;
		$tmp = $this->DB->ReadAss('Select * from n_options WHERE class_id = '.$class_id.' ORDER by option_name');
		foreach ($tmp as $row) {
			
			echo '<input name="exoptions['.$row['option_id'].']" value="'.addslashes($row['option_name']).'"> <br/>';
		}
	}
	
	
}

?>