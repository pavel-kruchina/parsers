<?php

class Search extends IntegratedDataBase {
	var $NTable = 'mats';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY mat_name");
		
	}
	
}

?>