<?php

class Gallery extends IntegratedDataBase {
	var $NTable = 'gallerys';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY gallery_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE gallery_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['gallery_name'] = trim($Vars['gallery_name']);
		if (!$Vars['gallery_name']) {
			$Errors['gallery_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		global $IMAGE;
		global $HTTP_POST_FILES;
		$ColorIm = $HTTP_POST_FILES['ColorIm'];
		$BlackIm = $HTTP_POST_FILES['BlackIm'];
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['gallery_id'];
		unset ($Vars['gallery_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			if ($ColorIm) {
			
				if (!(int)$ColorIm['error'] && file_exists($ColorIm['tmp_name']) && $ColorIm['size'] < $Global['File.MaxSize']) {
					
					$IMAGE->ResizeOutImage($ColorIm['tmp_name'], $Global['Gal.CDir'].'/'.$ObjectID.'.jpg', $Global['Gal.MinW'], $Global['Gal.MinH'], 'jpg');
					$IMAGE->ImToGray($Global['Gal.CDir'].'/'.$ObjectID.'.jpg', $Global['Gal.BDir'].'/'.$ObjectID.'.jpg', 'jpg');
					$IMAGE->ResizeOutImage($ColorIm['tmp_name'], $Global['Gal.CFDir'].'/'.$ObjectID.'.jpg', $Global['Gal.FW'], $Global['Gal.FH'], 'jpg');
				} else {
					if ($ColorIm['size'] >= $Global['File.MaxSize']) {
							$Errors['ColorIm'] = $Global['Big File'];
					} else 	$Errors['ColorIm'] = $Global['Error File'];
				}
				
			}
	
			$this->Go("{$Global['Host']}/edit_gallery/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"gallery_id='$ObjectID'");
			if ($ColorIm) {
			
				if (!(int)$ColorIm['error'] && file_exists($ColorIm['tmp_name']) && $ColorIm['size'] < $Global['File.MaxSize']) {
					
					$IMAGE->ResizeOutImage($ColorIm['tmp_name'], $Global['Gal.CDir'].'/'.$ObjectID.'.jpg', $Global['Gal.MinW'], $Global['Gal.MinH'], 'jpg');
					$IMAGE->ImToGray($Global['Gal.CDir'].'/'.$ObjectID.'.jpg', $Global['Gal.BDir'].'/'.$ObjectID.'.jpg', 'jpg');
					$IMAGE->ResizeOutImage($ColorIm['tmp_name'], $Global['Gal.CFDir'].'/'.$ObjectID.'.jpg', $Global['Gal.FW'], $Global['Gal.FH'], 'jpg');
				} else {
					if ($ColorIm['size'] >= $Global['File.MaxSize']) {
							$Errors['ColorIm'] = $Global['Big File'];
					} else 	$Errors['ColorIm'] = $Global['Error File'];
				}
				
			}
			$this->Go("{$Global['Host']}/edit_gallery/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			
			
			$this->DB->DeleteDB($this->NTable, 'gallery_id=' . $ObjectID);
			unlink($Global['Gal.CDir'].'/'.$ObjectID.'.jpg');
			unlink($Global['Gal.CFDir'].'/'.$ObjectID.'.jpg');
			unlink($Global['Gal.BDir'].'/'.$ObjectID.'.jpg');
			$this->Go("{$Global['Host']}/edit_gallery");
		}
		
	}
	
	function ShowGallery() {
		global $Global;
		$tmp = $this->DB->ReadAss('Select * from gallerys order by gallery_id desc');
		
		$res = '';
		if ($tmp)
		foreach ($tmp as $row) {
			
			//$res .= '<div id="g'.$row['gallery_id'].'" class="gal_mini" style="background: url(\''.$Global['Host'].'/'.$Global['Gal.BDir'].'/'.$row['gallery_id'].'.jpg\')"
			
			//OnMouseOver="changeIm(this, \''.$Global['Host'].'/'.$Global['Gal.CDir'].'/'.$row['gallery_id'].'.jpg\'); changeBord(this, \'#c9cfcd\')"
			//OnMouseOut="changeIm(this, \''.$Global['Host'].'/'.$Global['Gal.BDir'].'/'.$row['gallery_id'].'.jpg\'); changeBord(this, \'#a39d8f\')"
			//OnClick = "GetOnLayer(\'gallery\', '.$row['gallery_id'].')"
			//>';
			
			$res .= '<div class="gal_mini" style="background: url(\''.$Global['Host'].'/'.$Global['Gal.CDir'].'/'.$row['gallery_id'].'.jpg\') no-repeat center"
			OnClick = "GetOnLayer(\'gallery\', '.$row['gallery_id'].')"
			>';
			
			$res.='<div id="g'.$row['gallery_id'].'" class="gal_mini" style="border:0px; background: url(\''.$Global['Host'].'/'.$Global['Gal.BDir'].'/'.$row['gallery_id'].'.jpg\')  no-repeat center" 
			OnMouseOut="this.style.backgroundPosition = \' 0px 0px\'; changeBord(this.parentNode, \'#a39d8f\')"
			OnMouseOver="this.style.backgroundPosition = \' -1000px -1000px\'; changeBord(this.parentNode, \'#c9cfcd\')"
			OnClick = "GetOnLayer(\'gallery\', '.$row['gallery_id'].')"
			></div>';
			
			$res .= '</div>';
		}
		return $res;
	}
	
	function ShowOne($id) {
		global $Global;
		
		$tmp = $this->DB->ReadAss('Select * from gallerys order by gallery_id desc');
		
		$i=0;
		for (; $tmp[$i]; $i++) {
			
			if ($tmp[$i]['gallery_id']==$id) break;
		}
		
		$res = '<div style="height: 320px; width: 384px;">';
		
		if ($i>0)
			$res .= '<div OnClick = "GetOnLayer(\'gallery\', '.$tmp[$i-1]['gallery_id'].')" class="pop_gal_leftim"></div>';
		else $res .= '<div OnClick = "GetOnLayer(\'gallery\', '.$tmp[$i-1]['gallery_id'].')" class="pop_gal_leftim" style="background: none; cursor: default"></div>';
		$res .= '<img style="float: left;" src="'.$Global['Host'].'/'.$Global['Gal.CFDir'].'/'.$tmp[$i]['gallery_id'].'.jpg">';
		
		if ($tmp[$i+1])
			$res .= '<div OnClick = "GetOnLayer(\'gallery\', '.$tmp[$i+1]['gallery_id'].')" class="pop_gal_rightim"></div>';
		
		$res .= '</div>';
		
		$res .= '</td>
		<td class="puright">&nbsp;</td>
		</tr>
		<tr>
		<td><div class="imtext">'.($i+1).'. '.$tmp[$i]['gallery_name'].'</div> <div class="forclose"> <div OnClick="CloseLayer()" class="imclose"></div> </div>';
		
		return $res;
	}
	
}

?>