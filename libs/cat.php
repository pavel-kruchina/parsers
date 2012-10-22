<?php

class Cat extends IntegratedDataBase {
	var $NTable = 'o_cat';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("
            SELECT {$this->NTable}.*, bs.name as bsection_name 
            FROM {$this->NTable}, bsections bs 
            WHERE {$this->NTable}.bsection_id=bs.id 
            ORDER BY bs.order DESC, bs.id, cat_order DESC, cat_name");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE cat_id='$ObjectID' ",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['cat_name'] = trim($Vars['cat_name']);
		if (!$Vars['cat_name']) {
			$Errors['cat_name'] = $Global['No value'];
			return false;
		}
				
		return true;
	}
	
	function Edit() {
		global $User;
		global $HTTP_POST_VARS;
		global $HTTP_POST_FILES;
		$File = $HTTP_POST_FILES['file'];
		global $Global;
		global $IMAGE;
		global $Errors;
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['cat_id'];
		unset ($Vars['cat_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		//add
		if(!$ObjectID){
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return false;
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			if ($File) {
			
				if (!(int)$File['error'] && file_exists($File['tmp_name']) && $File['size'] < $Global['File.MaxSize']) {
					
					$IMAGE->ResizeOutImage($File['tmp_name'], $Global['Cat.Dir'].'/'.$ObjectID.'.jpg', 274, 73, 'jpg');
					
				} else {
					if ($File['size'] >= $Global['File.MaxSize']) {
							$Errors['foto'] = $Global['Big File'];
					} else 	$Errors['foto'] = $Global['Error File'];
				}
				
			}
	
			$this->Go("{$Global['Host']}/edit_cats/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			echo 1;
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"cat_id='$ObjectID'");
			
			if ($File) {
			echo 2;
				if (!(int)$File['error'] && file_exists($File['tmp_name']) && $File['size'] < $Global['File.MaxSize']) {
					
					$IMAGE->ResizeOutImage($File['tmp_name'], $Global['Cat.Dir'].'/'.$ObjectID.'.jpg', 274, 73, 'jpg');
					
				} else {
				echo 3;
					if ($File['size'] >= $Global['File.MaxSize']) {
							$Errors['foto'] = $Global['Big File'];
					} else 	$Errors['foto'] = $Global['Error File'];
				}
				
			}
			
			$this->Go("{$Global['Host']}/edit_cats/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return false;
			unlink($Global['Cat.Dir'].'/'.$ObjectID.'.jpg');
			$this->DB->DeleteDB($this->NTable, 'cat_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_cats");
		}
		
	}
	
	function GetCats() {
		global $Global;
		global $SUBCAT;
		
		$this->ReadAll();
		$height = 3;
		foreach($this->Objects as $row) {
			
			$SUBCAT->ReadAll($row['cat_id']);
			
			echo '<div class="catsep"></div>';
			echo '<div OnClick="location=\''.$Global['Host'].'/catalog/'.$SUBCAT->Objects[0]['sc_url'].'\'" onmouseover="fadein(\'mi'.$row['cat_id'].'\',0)" onMouseOut="fadeout(\'mi'.$row['cat_id'].'\',0)" class="menuitem" style="overflow: hidden; background: URL(\''.$Global['Host'].'/'.$Global['Cat.Dir'].'/'.$row['cat_id'].'.jpg\')">
				<img onMouseOut="fadeout(\'mi'.$row['cat_id'].'\',0)" src="'.$Global['Host'].'/css/images/fade.png" style="display: block; position: relative; top: -100px;" id="mi'.$row['cat_id'].'" />
			</div>';
			
			$height += 3+73;
		}
		
		echo '<div class="" catsep></div>';
		echo '<script> var mh='.$height.' </script>';
	}
	
	function eGetCats() {
		global $Global;
		global $SUBCAT;
		
		$res='';
		
		$this->ReadAll();
		$height = 3;
		foreach($this->Objects as $row) {
			
			$SUBCAT->ReadAll($row['cat_id']);
			
			$res.= '<div class="catsep"></div>';
			$res.= '<div OnClick="location=\''.$Global['Host'].'/catalog/'.$SUBCAT->Objects[0]['sc_url'].'\'" onmouseover="fadein(\'mi'.$row['cat_id'].'\',0)" onMouseOut="fadeout(\'mi'.$row['cat_id'].'\',0)" class="menuitem" style="overflow: hidden; background: URL(\''.$Global['Host'].'/'.$Global['Cat.Dir'].'/'.$row['cat_id'].'.jpg\')">
				<img onMouseOut="fadeout(\'mi'.$row['cat_id'].'\',0)" src="'.$Global['Host'].'/css/images/fade.png" style="display: block; position: relative; top: -100px;" id="mi'.$row['cat_id'].'" />
			</div>';
			
			$height += 3+73;
		}
		
		$res.= '<div class="" catsep></div>';
		$res.= '<script> var mh='.$height.' </script>';
		return $res;
	}
	
	function ShowLeftMenu($open_subcat) {
		global $Global;
		global $SUBCAT;
		
		$SUBCAT->ReadOneObject($open_subcat);
		
		$this->ReadAll();
		$res="";
                $bsection = "";
		foreach($this->Objects as $row) {
			if ($bsection!= $row['bsection_name']) {
                            if ($bsection) $res .= '<hr />';
                            
                            $bsection = $row['bsection_name'];
                            $res .= '<h2>'.$bsection.'</h2>';
                        }
                        
                        
                        $h = 40;
			$tmp = "";
			
			$SUBCAT->ReadAll($row['cat_id']);
			foreach ((array)$SUBCAT->Objects as $sc) {
				$tmp .='<a href="'.$Global['Host'].'/catalog/'.$sc['full_url'].'"><div class="leftsubcat'.(($open_subcat==$sc['sc_id'])?'a':'').'">'.$sc['sc_name'].'</div></a>';
				$h+=21;
			}
			
			if ($SUBCAT->Object['cat_id'] == $row['cat_id']) {
				$style = 'style="height: '.$h.'px; font-weight: 900; background: URL(\'/css/images/downlm.jpg\') right top no-repeat"';
				$res .= '<script>lastid = "lmg'.$row['cat_id'].'";</script>';
			} else $style = "";
			
			$res .= '<div '.$style.' class="leftmenu_groop" id="lmg'.$row['cat_id'].'">';
			$res .='<div onClick="OpenCat(\'lmg'.$row['cat_id'].'\', 14, '.$h.', 15,1)"  class="leftmenu_cap">'.mb_strtoupper($row['cat_name']).'</div>';
			$res .= $tmp;
			$res .='</div>';
		}
		
		echo $res;
	}
	
}

?>