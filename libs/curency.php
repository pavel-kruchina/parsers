<?php

class Carency extends IntegratedDataBase {
	var $NTable = 'carency';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY carency_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE carency_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['carency_name'] = trim($Vars['carency_name']);
		$Vars['carency_value'] = (double)($Vars['carency_value']);
		$Vars['carency_yvalue'] = (double)($Vars['carency_yvalue']);
		if (!$Vars['carency_name']) {
			$Errors['carency_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['carency_id'];
		unset ($Vars['carency_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_carency/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"carency_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_carency/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			
			
			$this->DB->DeleteDB($this->NTable, 'carency_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_carency");
		}
		
	}
	
	function GetCurs() {
		global $Global;
		$this->ReadAll();
		
		echo '<h2>Курсы валют</h2>';
		echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
		echo'	<tr>
				<td width="75px" height="20px"></td>
				<td class="date" width="60px">'.(date("d.m",time()-24*3600)).'</td>';
		echo'		<td class="date" width="60px">'.(date("d.m")).'</td>';
		echo'		<td width="auto"></td>
			</tr>' ;
			
		foreach ($this->Objects as $row) {
			
			if ($row['carency_id']==1) {
				
				$class='dollar';
			} else $class='euro';
			
			
			if ($row['carency_value']>$row['carency_yvalue']) {
			
				
				$im = '<img src="'.$Global['Host'].'/css/images/up.gif" width="10" height="12" alt="" />';
			} elseif ($row['carency_value']<$row['carency_yvalue']) {
				
				
				$im = '<img src="'.$Global['Host'].'/css/images/down.gif" width="10" height="12" alt="" />';
			} else {
				
				
				$im = "";
			}
			
			echo'<tr>
				<td class="'.$class.'" width="75px" height="20px">'.$row['carency_name'].'</td>
				<td width="60px">'.$row['carency_yvalue'].'</td>
				<td width="60px">'.$row['carency_value'].'</td>
				<td width="auto">'.$im.'</td>
			</tr>';
		}
		echo '</table>';
	}
}

?>