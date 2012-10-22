<?php

class Spetial extends IntegratedDataBase {
	var $NTable = 'spetial';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY sp_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE sp_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['sp_name'] = trim($Vars['sp_name']);
		if (!$Vars['sp_name']) {
			$Errors['sp_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $HTTP_POST_FILES;
		$File = $HTTP_POST_FILES['file'];
		global $Global;
		global $IMAGE;
		global $Errors;
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['sp_id'];
		unset ($Vars['sp_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		$Vars['sp_activ'] = ($Vars['sp_activ'])?1:0; 
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			if ($File) {
			
				if (!(int)$File['error'] && file_exists($File['tmp_name']) && $File['size'] < $Global['File.MaxSize']) {
					
					$IMAGE->ResizeOutImage($File['tmp_name'], $Global['Spec.Dir'].'/'.$ObjectID.'.jpg', 203, 150, 'jpg');
					
				} else {
					if ($File['size'] >= $Global['File.MaxSize']) {
							$Errors['foto'] = $Global['Big File'];
					} else 	$Errors['foto'] = $Global['Error File'];
				}
				
			}
	
			$this->Go("{$Global['Host']}/edit_spetial/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			echo 1;
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"sp_id='$ObjectID'");
			
			if ($File) {
			echo 2;
				if (!(int)$File['error'] && file_exists($File['tmp_name']) && $File['size'] < $Global['File.MaxSize']) {
					
					$IMAGE->ResizeOutImage($File['tmp_name'], $Global['Spec.Dir'].'/'.$ObjectID.'.jpg', 203, 150, 'jpg');
					
				} else {
				echo 3;
					if ($File['size'] >= $Global['File.MaxSize']) {
							$Errors['foto'] = $Global['Big File'];
					} else 	$Errors['foto'] = $Global['Error File'];
				}
				
			}
			
			$this->Go("{$Global['Host']}/edit_spetial/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			
			unlink($Global['Spec.Dir'].'/'.$ObjectID.'.jpg');
			$this->DB->DeleteDB($this->NTable, 'sp_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_spetial");
		}
		
	}
	
	function ShowSpetial() {
		global $Global;
		$sp = $this->DB->ReadAssRow('Select * from spetial WHERE sp_activ ORDER by Rand() LIMIT 1');
		echo '<div id="special">
			<h1>Специальное</h1>
			<h2>предложение</h2>
			<a href="'.$sp['sp_url'].'" class="spec"><b></b>
				<em class="txt">'.$sp['sp_prev'].'</em>			
				<img src="'.$Global['Host'].'/'.$Global['Spec.Dir'].'/'.$sp['sp_id'].'.jpg" width="203" height="150" alt="" />
			</a>
		</div>';
	}
	
	
}

?>