<?php

class Product extends IntegratedDataBase {
	var $NTable = 'products';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY mag_id DESC");
		
	}
	
	function ReadIDs($IDs) {
		
		$this->Objects = array();
		
		foreach ($IDs as $id) {
		
		$this->Objects[] = $this->DB->ReadAssRow("
		SELECT 
		products.*, 
		models.m_name as model_name,
		acs.a_name as ac_name,
		mackers.m_name as macker_name,
		brends.b_name as brend_name		
		
		FROM {$this->NTable}, brends, mackers, acs, models
		
		WHERE
		acs.a_id = products.ac_id AND
		models.m_id = products.model_id AND
		brends.b_id = products.brend_id AND
		mackers.m_id = products.macker_id AND
		products.p_id=$id");
		}
		
	}
	
	function ReadConditional($Cond) {
		
		$this->Objects = $this->DB->ReadAss("
		SELECT distinct
		products.*, 
		models.m_name as model_name,
		acs.a_name as ac_name,
		mackers.m_name as macker_name,
		brends.b_name as brend_name		
		
		FROM {$this->NTable}, brends, mackers, acs, models
		
		WHERE
		acs.a_id = products.ac_id AND
		(models.m_id = products.model_id) AND
		(brends.b_id = products.brend_id) AND
		mackers.m_id = products.macker_id AND
		$Cond
		
		ORDER BY a_name ");
		
	}
	 
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE p_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		if (!$Vars['brend_id']) {
			$Errors['brend_id'] = $Global['No value'];
		}
		
		if (!$Vars['model_id']) {
			$Errors['model_id'] = $Global['No value'];
		}
		
		$Vars['mag_id'] = trim($Vars['mag_id']);
		if (!$Vars['mag_id']) {
			$Errors['mag_id'] = $Global['No value'];
			return false;
		}
		$t = $this->DB->ReadScalar('Select mag_id from '.$this->NTable.' where mag_id = "'.$Vars['mag_id'].'" and p_id != "'.$Vars['p_id'].'"');
		if ($t) {
			$Errors['mag_id'] = $Global['Exist value'];
			return false;
		}
		
		if (count($Errors)) {
			return false;
		}
		
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		global $HTTP_POST_FILES;
		
		$File = $HTTP_POST_FILES['foto'];
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['p_id'];
		
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			unset ($Vars['p_id']);
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
			
			if ($File) {
				if (!(int)$File['error'] && file_exists($File['tmp_name']) && $File['size'] < $Global['File.MaxSize']) {
					copy($File['tmp_name'], $Global['Foto.Dir'].'/'.$ObjectID.'.jpg');
					//$Image->ResizeOutImage($File['tmp_name'], $Global['Gallery.ImageSmall.Dir'].'/'.$ObjectID.'.png', $MemVars['mem_img_width'], $MemVars['mem_img_height'], 'png');
				
				} else {
					if ($File['size'] >= $Global['File.MaxSize']) {
							$Errors['foto'] = $Global['Big File'];
					} else 	$Errors['foto'] = $Global['Error File'];
				}
			}
			
			$this->Go("{$Global['Host']}/edit_products/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			unset ($Vars['p_id']);
			
			if ($File) {
				if (!(int)$File['error'] && file_exists($File['tmp_name']) && $File['size'] < $Global['File.MaxSize']) {
					copy($File['tmp_name'], $Global['Foto.Dir'].'/'.$ObjectID.'.jpg');
					//$Image->ResizeOutImage($File['tmp_name'], $Global['Gallery.ImageSmall.Dir'].'/'.$ObjectID.'.png', $MemVars['mem_img_width'], $MemVars['mem_img_height'], 'png');
				
				} else {
					if ($File['size'] >= $Global['File.MaxSize']) {
							$Errors['foto'] = $Global['Big File'];
					} else 	$Errors['foto'] = $Global['Error File'];
				}
			}
			
			$this->DB->EditDB($Vars,$this->NTable,"p_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_products/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			$this->DB->DeleteDB($this->NTable, 'p_id=' . $ObjectID);
			unlink($Global['Foto.Dir'].'/'.$ObjectID.'.jpg');
			$this->Go("{$Global['Host']}/edit_products");
		}
		
	}
	
	public static function addFromParsers($data, $images, $vendor_id, $cat_id) {
        global $Global;
        global $IMAGE;
        global $DB;
        
        $data['good_check']=1;
        
        $good = $DB->ReadScalar("select good_id from goods where vendor_id={$vendor_id} and good_art='{$data['good_art']}'");
        if (!$good) {
            $data['sc_id'] = $cat_id;
            $DB->EditDB($data,'goods');
            $ObjectID = $DB->LastInserted;
            $DB->EditDB(array('good_id'=>$ObjectID, 'sc_id'=>$cat_id),'goods_x_subcat');
        
            $DB->EditDB(array("good_url"=>translit($data['good_name']).'_'.$ObjectID),'goods', "good_id=$ObjectID");

            $SN = new Snoopy();
            foreach ($images as $img) {
                
                $SN->fetch($img);
                $str = $SN->results;
                $DB->EditDB(array('good_id'=>$ObjectID),'o_photos');
                $OID = $DB->LastInserted;
                file_put_contents(PATH.$Global['Foto.Dir'].'/'.$OID.'.jpg', $str);
                $IMAGE->ResizeOutImage(PATH.$Global['Foto.Dir'].'/'.$OID.'.jpg', PATH.$Global['Foto.MinDir'].'/'.$OID.'.jpg', $Global['Foto.MinW'], $Global['Foto.MinH'], 'jpg');
            }
            
        } else {
            $DB->EditDB($data,'goods', 'good_id='.$good);
            $isLink = $DB->ReadScalar("select id from goods_x_subcat where good_id=$good and sc_id=$cat_id");
            if (!$isLink) {
                $DB->EditDB(array('good_id'=>$good, 'sc_id'=>$cat_id),'goods_x_subcat');
            }
        }
    }
}

?>