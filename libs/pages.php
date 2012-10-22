<?php
class Page extends IntegratedDataBase {
	var $NTable = 'pages';
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll($SectionID) {
		
		$this->Objects = $this->DB->ReadAss("SELECT {$this->NTable}.*, sections.section_point FROM {$this->NTable}, sections WHERE {$this->NTable}.section_id=$SectionID AND sections.section_id=$SectionID order by page_name");
		
	}
	
	function ReadOneObject($ObjectID){
		if($ObjectID) {
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE page_id='$ObjectID'",'*1');
			
		}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);
	}
	
	function ReadMain() {
		return $this->DB->ReadScalar('SELECT value FROM auxiliary WHERE object = "main"');
	}
	
	function CheckVars(&$Vars) {
		global $HTTP_POST_VARS;
		global $Errors;
		global $Global;
				
		$Vars['page_name'] = $this->CleanTag($Vars['page_name']);
		$Vars['page_name'] = trim($Vars['page_name']);
		if ($Vars['page_name'] == '')
			$Errors['page_name'] = $Global['No value'];
		
		$Vars['page_point'] = $this->CleanEngStr($Vars['page_point']);
		$Vars['page_point'] = trim($Vars['page_point']);
		if ($Vars['page_point'] == '')
			$Errors['page_point'] = $Global['No point'];
		else { 
			if ($this->DB->ReadScalar('SELECT page_point FROM '.$this->NTable.' WHERE page_point ="'.$Vars['page_point'].'" AND section_id='.$Vars['section_id']. ' AND page_id != '.$HTTP_POST_VARS['page_id'])) {
				$Errors['page_point'] = $Global['Exist point'];
			}
		}
		if (count($Errors)) return false;
		else 				return true;
	}
	
	function Edit() {
	
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		
		
		unset($Vars['sender']);
		
		$SectionID = $Vars['section_id'];
		
		$ObjectID = $Vars['page_id'];
		unset ($Vars['page_id']);
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		$main = (int) $Vars['main'];
		unset($Vars['main']);
		
		include('pages/edit_scripts/'.$Vars['page_type'].'.php'); 
		
	}
	
	
	
	function ShowDefaultPage() {
		global $Global;
		global $MENU;
		global $AdminMenu;
		global $ExtraMenu;
		global $SECTION;
		global $NEW;
		global $DB;
		global $CARENCY;
		global $CAT;
		
		include ("pages/main.php");
	}
	
	function ShowPage() {
		global $Global;
		global $MENU;
		global $AdminMenu;
		global $ExtraMenu;
		global $SECTION;
		
		if ($Global['Url.Page'][1]) {
			
			
			
		/*	$Text = $this->DB->ReadAssRow("SELECT pages.page_name, pages.page_text FROM pages, sections 
					WHERE sections.section_point = '{$Global['Url.Page'][0]}' and sections.section_id = pages.section_id 
					and pages.page_point = '{$Global['Url.Page'][1]}'");
			
				if (!$Text) { 
					$this->ShowDefaultPage();
					
					return;
				}
			echo $Text['page_text'];*/
			
			$Page = $this->DB->ReadAssRow("SELECT pages.*, sections.section_name, sections.section_point FROM pages, sections 
					WHERE sections.section_point = '{$Global['Url.Page'][0]}' and sections.section_id = pages.section_id 
					and pages.page_point = '{$Global['Url.Page'][1]}'");
			
			if (!$Page['page_id']) { 
				$this->ShowDefaultPage();
					
				return;
			}
			
			include('pages/templates/'.$Page['page_type'].'.php');
			
		} elseif (isset($Global['Url.Page'][0] )) {
		
			$SECTION->ShowSection($Global['Url.Page'][0]);
		} else {
			
			$this->ShowDefaultPage();
		}
	}
}
?>