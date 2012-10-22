<?php
class Menu extends IntegratedDataBase {
	var $NTable = 'pages';
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT {$this->NTable}.page_name, {$this->NTable}.page_id, {$this->NTable}.page_point, {$this->NTable}.section_id, 
												sections.section_name, sections.section_point  
						FROM {$this->NTable}, sections WHERE {$this->NTable}.section_id = sections.section_id ORDER BY section_id, page_id");
		
	}
	
	function ShowStaticMenu($Menu, $CheckRights=0, $Caption="") {
		global $Global;
		global $User; 
		global $Access; 
		
		if (!$User && $CheckRights) return;
		
		if (!($User['Rights'] & $CheckRights)) return;
		
		echo '<div class="admin">';
		
		if ($Caption) echo '<h5>'.$Caption.'</h5>';
		
		
		foreach($Menu as $href => $label) {
				
				if( $User['Rights'] & $Access[$href]) {
				echo ' | ';
				echo '<a class="wh" href="'.$Global['Host'].'/'.$href.'">'.$label.'</a>';    }
		}
		
		echo ' | ';
		echo '</div>';
		
	}
	
	function ShowDinamicMenu() {
		global $Global;
		
		$this->ReadAll();
		
		$LastSection = '';
		if ($this->Objects) {
			foreach ($this->Objects as $item) {
				
				if ($LastSection != $item['section_id']) {
					
					$LastSection = $item['section_id'];
						
					if ($item['section_id'] == $Global['MainMenu.Index']) {
						
						1;
					} else {
						
						echo '<h5>'.$item['section_name'].'</h5>';
					}
					
				}
				
				echo '<A class="menu_a" href="'.$Global['Host'].'/'.$item['section_point'].'/'.$item['page_point'].'">'.$item['page_name'].'</A> <br />'; 
			}
		}
	}
	
	function ShowRightMenu($Menu) {
		echo $Menu;
	}
	
}
?>