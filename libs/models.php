<?php

class Model extends IntegratedDataBase {
	var $NTable = 'models';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll($b_id) {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} where b_id=$b_id ORDER BY m_name DESC");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE m_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['m_name'] = trim($Vars['m_name']);
		if (!$Vars['m_name']) {
			$Errors['m_name'] = $Global['No value'];
			return false;
		}
		$t = $this->DB->ReadScalar('Select m_name from '.$this->NTable.' where m_name = "'.$Vars['m_name'].'" AND b_id='.$Vars['b_id']);
		if ($t) {
			$Errors['m_name'] = $Global['Exist value'];
			return false;
		}
		
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['m_id'];
		unset ($Vars['m_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_brends/{$Vars[b_id]}/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"m_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_brends/{$Vars[b_id]}/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			$this->DB->DeleteDB($this->NTable, 'm_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_brends/{$Vars[b_id]}");
		}
		
	}
	
	function ShowLastNews($count=0, $style='all') {
		
		if ($count) {
			$temp = $this->DB->ReadAss("SELECT {$this->NTable}.* FROM {$this->NTable} ORDER BY m_id DESC LIMIT $count");
		} else {
			$temp = $this->DB->ReadAss("SELECT {$this->NTable}.* FROM {$this->NTable} ORDER BY m_id DESC");
		}
		
		foreach ($temp as $row) {
		
			if ($style=='all') {
				
				?> 
				<a href="<?php echo $row['m_url'];?>"><?php echo $row['m_name'];?></a><br /> <?php
			} else {
				?> 
				<a href="<?php echo $row['m_url'];?>"><?php echo $row['m_name'];?></a><br />
				<?php
			}
		}
		
	}
	
}

?>