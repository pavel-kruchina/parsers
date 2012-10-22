<?php //add
global $Global;
global $User;
		if(!$ObjectID){
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return;
			if (!$this->CheckVars($Vars)) {
				return;
			}
			
			global $HTTP_POST_FILES;
			$Files=$HTTP_POST_FILES;
			
			$tmp = $Files['add_file'];
			if (!(int)$tmp['error'] && file_exists($tmp['tmp_name'])) {
			
				$Vars['file_name'] = $Vars['page_point'].'_'.$tmp['name'];
				
				copy($tmp['tmp_name'], $Global['File.Dir'].$Vars['page_point'].'_'.$tmp['name']);
				
			}
			
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
			
			if ($main) {
				$this->DB->DeleteDB('auxiliary','object="main"');
				$this->DB->EditDB(array('object'=>'main', 'value'=>$ObjectID), 'auxiliary');
			} else $this->DB->DeleteDB('auxiliary','object="main" and value = '.$ObjectID);
			
			$this->Go("{$Global['Host']}/edit_pages/$SectionID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			if (!$this->CheckVars($Vars)) {
				return;
			}
			
			global $HTTP_POST_FILES;
			$Files=$HTTP_POST_FILES;
			
			$tmp = $Files['add_file'];
			if (!(int)$tmp['error'] && file_exists($tmp['tmp_name'])) {
			
				$Vars['file_name'] = $Vars['page_point'].'_'.$tmp['name'];
				
				copy($tmp['tmp_name'], $Global['File.Dir'].'/'.$Vars['page_point'].'_'.$tmp['name']);
				
			}
			
			$this->DB->EditDB($Vars,$this->NTable,"page_id='$ObjectID'");
			
			if ($main) {
				$this->DB->DeleteDB('auxiliary','object="main"');
				$this->DB->EditDB(array('object'=>'main', 'value'=>$ObjectID), 'auxiliary');
			} else $this->DB->DeleteDB('auxiliary','object="main" and value = '.$ObjectID);
			
			$this->Go("{$Global['Host']}/edit_pages/$SectionID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return;
			global $GROUP;
			$this->DB->DeleteDB($this->NTable, 'page_id=' . $ObjectID);
			$this->Go("{$Global['Host']}/edit_pages/$SectionID");
		}
		?>