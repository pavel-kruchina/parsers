<?php
class Price extends IntegratedDataBase {
		
	function Load() {
		global $HTTP_POST_FILES;
		global $Global;
		global $Errors;
		
		$File = $HTTP_POST_FILES['price'];
		
		if (!(int)$File['error'] && file_exists($File['tmp_name']) && $File['size'] < $Global['File.MaxSize']) {
			
			copy($File['tmp_name'], $Global['File.Dir'].'/price.xls');
			$this->Go($Global['Host']);
			exit;
			
		} else {
			if ($File['size'] >= $Global['File.MaxSize']) {
					$Errors['File'] = $Global['Big File'];
			} else 	$Errors['File'] = $Global['Error File'];
		}
	}
}
?>