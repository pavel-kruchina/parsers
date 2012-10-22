<?php
//add
		if ($Vars['edit_members']) {
		
			global $G_MEMBER;
			$G_MEMBER->Edit($Vars['section_id'], $ObjectID);
			return;
		}
		
		$GTable = 'page_galleries';
		$Vars['pg_def_href'] = ((int)$Vars['pg_def_href']) ? ($Vars['pg_def_href']) : 0; 
		$PG = $Vars['pg_id'];
		unset($Vars['pg_id']);
		
		$Page_Vars = array();
		
		$Page_Vars['page_name'] 	= $Vars['page_name']; 
		$Page_Vars['page_point'] 	= $Vars['page_point'];
		$Page_Vars['page_text'] 	= $Vars['page_text'];
		$Page_Vars['section_id'] 	= $Vars['section_id'];
		$Page_Vars['page_type'] 	= $Vars['page_type'];
		
		unset ($Vars['page_name']);
		unset ($Vars['page_point']);		
		unset ($Vars['page_text']);
		unset ($Vars['section_id']);
		unset ($Vars['page_type']);
		
		if(!$ObjectID){
			
			if (!$this->CheckVars($Page_Vars)) {
				return;
			}
				
			$this->DB->EditDB($Page_Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
			
			if ($main) {
				$this->DB->DeleteDB('auxiliary','object="main"');
				$this->DB->EditDB(array('object'=>'main', 'value'=>$ObjectID), 'auxiliary');
			} else $this->DB->DeleteDB('auxiliary','object="main" and value = '.$ObjectID);
			
			$Vars['page_id'] = $ObjectID;
			
			$this->DB->EditDB($Vars,$GTable);
			
			$this->Go("{$Global['Host']}/edit_pages/$SectionID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			if (!$this->CheckVars($Page_Vars)) {
				return;
			}
			
			$this->DB->EditDB($Page_Vars,$this->NTable,"page_id='$ObjectID'");
			
			if ($main) {
				$this->DB->DeleteDB('auxiliary','object="main"');
				$this->DB->EditDB(array('object'=>'main', 'value'=>$ObjectID), 'auxiliary');
			} else $this->DB->DeleteDB('auxiliary','object="main" and value = '.$ObjectID);

			$this->DB->EditDB($Vars,$GTable, 'pg_id='.$PG);
			
			$this->Go("{$Global['Host']}/edit_pages/$SectionID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			$this->DB->DeleteDB($this->NTable, 'page_id=' . $ObjectID);
			$this->DB->DeleteDB($GTable, 'pg_id=' . $PG);
			
			$this->Go("{$Global['Host']}/edit_pages/$SectionID");
		}
		?>