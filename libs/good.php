<?php

class Good extends IntegratedDataBase {
	var $NTable = 'goods';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll($sc_id, $sort='good_name', $check=0) {
        
		$sc_id = (int)$sc_id;
		if ($check) $check = " {$this->NTable}.good_check AND";
		else $check = '';
        
		$this->Objects = $this->DB->ReadAss("SELECT goods.*, vendor.id as vendor_id, vendor.name as vendor_name, vendor.style as vendor_style
				FROM goods_x_subcat as gxs, {$this->NTable} as goods inner join vendor on goods.vendor_id = vendor.id where $check gxs.sc_id = $sc_id AND goods.good_id = gxs.good_id ORDER BY ".$sort);
	}
    
    function readVsPages($sc_id, $sort='good_name', $page, $onPage, $cond=1) {
        
        if ($sc_id) {
            $subcat = "gxs.sc_id = $sc_id";
        } else {
            $subcat = "1";
        }
        
        $this->Objects = $this->DB->ReadAss("
        SELECT 
           SQL_CALC_FOUND_ROWS goods.*, vendor.id as vendor_id, vendor.name as vendor_name, 
                vendor.style as vendor_style, CONCAT( o_cat.url, '/',subcat.sc_url) as full_url
                
				FROM goods_x_subcat as gxs, subcat, {$this->NTable} as goods, vendor, o_cat  
                WHERE 
                   goods.vendor_id = vendor.id AND {$this->NTable}.good_check AND $subcat AND 
                   goods.good_id = gxs.good_id AND gxs.sc_id = subcat.sc_id AND o_cat.cat_id=subcat.cat_id AND $cond
                Group by goods.good_id
                ORDER BY ".$sort.
                ' LIMIT '.(($page-1)*$onPage).', '.$onPage   
            );
        $goods_count = $this->DB->ReadScalar('SELECT FOUND_ROWS()');
        $this->goods_count = $goods_count;
        $this->page_count = ((int)($goods_count/$onPage)) + (($goods_count%$onPage)?1:0); 
    }
	
	function Search($query_string, $sort='good_name', $page, $onPage) {
		global $Global;
		
		$ask = '"'.mysql_real_escape_string($query_string).'"';
		
		$tid = $this->DB->ReadAssRow('select * from goods where good_art='.$ask);
		
		if ($tid['good_id']) {
			$sc_url = $this->DB->ReadScalar('select sc_url from subcat where sc_id='.$tid['sc_id']);
			$this->Go($Global['Host'].'/catalog/'.$sc_url.'/'.$tid['good_url']);
		}
		
		$key_words = trim(mysql_real_escape_string($query_string));
		
		if ($key_words) {
			$kw = explode(' ',$key_words);
			$key_words = "";
			foreach ($kw as $row) {
				
				$key_words[] = " CONCAT_WS(',', goods.good_name, goods.good_desc, subcat.sc_name) LIKE '%$row%' ";				
			}
			
			$key_words = implode(' AND ', $key_words);
			
		} else $key_words="1";
		
		
		$this->readVsPages(0, $sort, $page, $onPage, $key_words);
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT {$this->NTable}.*, o_cat.cat_id
			FROM {$this->NTable},o_cat, subcat WHERE {$this->NTable}.good_id='$ObjectID'  AND subcat.sc_id = goods.sc_id AND o_cat.cat_id = subcat.cat_id ",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['good_name'] = trim($Vars['good_name']);
		if (!$Vars['good_name']) {
			$Errors['good_name'] = $Global['No value'];
			
		}
		if (count($Errors)) return false;		
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $HTTP_POST_FILES;
		global $Global;
		global $SUBCAT;
		global $User;
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['good_id'];
		unset ($Vars['good_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		global $IMAGE;
		
		$SUBCAT->ReadOneObject((int)$Vars['sc_id']);
		
		//add
		if(!$ObjectID){
			if (!$this->CheckSentVars($Vars)) return;
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return false;
			
			$addvars = array(
				'good_name' 	=> trim($Vars['good_name']),
				'good_art' 		=> trim($Vars['good_art']),
				'good_price' 	=> (double)$Vars['good_price'],
				'sc_id' 		=> (int)$Vars['sc_id'],
				'good_desc' 	=> $Vars['good_desc'],
				'good_url'=>translit($Vars['good_name']).'_art'.$Vars['good_art']
			);
			
			$addvars['good_adv'] = $Vars['good_adv']?1:0;
			$addvars['good_check'] = $Vars['good_check']?1:0;
			$addvars['good_new'] = $Vars['good_new']?1:0;
			$addvars['good_bestceller'] = $Vars['good_bestceller']?1:0;
			
			$this->DB->EditDB($addvars,$this->NTable);
			
			$ObjectID = $this->DB->LastInserted;
			
			$files = $HTTP_POST_FILES['photos'];
			
			foreach ($files['name'] as $key=>$row) {
				
				if ($row) {
					$this->DB->EditDB(array('good_id'=>$ObjectID),'o_photos');
					$OID = $this->DB->LastInserted;
					if (!(int)$files['error'][$key] && file_exists($files['tmp_name'][$key]) && $files['size'][$key] < $Global['File.MaxSize']) {
						copy($files['tmp_name'][$key], $Global['Foto.Dir'].'/'.$OID.'.jpg');
						$IMAGE->ResizeOutImage($files['tmp_name'][$key], $Global['Foto.MinDir'].'/'.$OID.'.jpg', $Global['Foto.MinW'], $Global['Foto.MinH'], 'jpg');
					
					} else {
						if ($files['size'][$key] >= $Global['File.MaxSize']) {
								$Errors['foto'] = $Global['Big File'];
						} else 	$Errors['foto'] = $Global['Error File'];
					}
				}
			}

			foreach ($HTTP_POST_VARS['color'] as $row) {
				
				if ($row!='') {
					$this->DB->EditDB(array('good_id'=>$ObjectID,'color_value'=>$row),'colors');
				}
			}
			
			foreach ($HTTP_POST_VARS['mat'] as $key=>$row) {
				
					$this->DB->EditDB(array('good_id'=>$ObjectID,'matprice'=>$row,'mat_id'=>$key),'mat_price');
				
			}
			
			$this->Go("{$Global['Host']}/edit_cats/{$SUBCAT->Object['cat_id']}/{$Vars[sc_id]}/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			if (!$this->CheckSentVars($Vars)) return;
			
			$addvars = array(
				'good_name' 	=> trim($Vars['good_name']),
				'good_art' 		=> trim($Vars['good_art']),
				'good_price' 	=> (double)$Vars['good_price'],
				'sc_id' 		=> (int)$Vars['sc_id'],
				'good_desc' 	=> $Vars['good_desc'],
				'good_url'=>translit($Vars['good_name']).'_art'.$Vars['good_art']
			);
			
			$addvars['good_adv'] = $Vars['good_adv']?1:0;
			$addvars['good_check'] = $Vars['good_check']?1:0;
			$addvars['good_new'] = $Vars['good_new']?1:0;
			$addvars['good_bestceller'] = $Vars['good_bestceller']?1:0;
			
			
			if (!($User['user_rights']&$Global['Right.Admin'])) {
				$this->ReadOneObject($ObjectID);
				$addvars['good_check'] = $this->Object['good_check'];
			}
			
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) {
				unset($addvars['good_price']);
				unset($addvars['good_art']);
			}
			
			$this->DB->EditDB($addvars,$this->NTable,'good_id='.$ObjectID);
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return;
			
			$files = $HTTP_POST_FILES['photos'];
	
			
			
			foreach ($files['name'] as $key=>$row) {
				
				if ($row) {
					$this->DB->EditDB(array('good_id'=>$ObjectID),'o_photos');
					$OID = $this->DB->LastInserted;
					if (!(int)$files['error'][$key] && file_exists($files['tmp_name'][$key]) && $files['size'][$key] < $Global['File.MaxSize']) {
						unlink($Global['Foto.Dir'].'/'.$OID.'.jpg');
						copy($files['tmp_name'][$key], $Global['Foto.Dir'].'/'.$OID.'.jpg');
						$IMAGE->ResizeOutImage($files['tmp_name'][$key], $Global['Foto.MinDir'].'/'.$OID.'.jpg', $Global['Foto.MinW'], $Global['Foto.MinH'], 'jpg');
					
					} else {
						if ($files['size'][$key] >= $Global['File.MaxSize']) {
								$Errors['foto'] = $Global['Big File'];
						} else 	$Errors['foto'] = $Global['Error File'];
					}
				}
			}
			
			$this->DB->DeleteDB('colors','good_id = '.$ObjectID);			
			
			foreach ($HTTP_POST_VARS['color'] as $row) {
				
				if ($row !='') {
					$this->DB->EditDB(array('good_id'=>$ObjectID,'color_value'=>$row),'colors');
				}
					
			}
			$files = $HTTP_POST_FILES['exphotos'];
	
			if ($User['user_rights']&$Global['Right.Admin']) {
				$this->DB->DeleteDB('mat_price','good_id = '.$ObjectID);			
		
				foreach ($HTTP_POST_VARS['mat'] as $key=>$row) {
					
						$this->DB->EditDB(array('good_id'=>$ObjectID,'matprice'=>$row,'mat_id'=>$key),'mat_price');
					
				}
			}
			foreach ($files['name'] as $key=>$row) {
				$key= (int)$key;
				if ($Vars['delete'.$key]) {
					$this->DB->DeleteDB('o_photos','photo_id='.$key);
					unlink($Global['Foto.MinDir'].'/'.$key.'.jpg');
					unlink($Global['Foto.Dir'].'/'.$key.'.jpg');
				} else {
					
					if ($row) {
						$OID = $key;
						if (!(int)$files['error'][$key] && file_exists($files['tmp_name'][$key]) && $files['size'][$key] < $Global['File.MaxSize']) {
							copy($files['tmp_name'][$key], $Global['Foto.Dir'].'/'.$OID.'.jpg');
							$IMAGE->ResizeOutImage($files['tmp_name'][$key], $Global['Foto.MinDir'].'/'.$OID.'.jpg', $Global['Foto.MinW'], $Global['Foto.MinH'], 'jpg');
						
						} else {
							if ($files['size'][$key] >= $Global['File.MaxSize']) {
									$Errors['foto'] = $Global['Big File'];
							} else 	$Errors['foto'] = $Global['Error File'];
						}
					}
				}
			}

			
			
			$this->Go("{$Global['Host']}/edit_cats/{$SUBCAT->Object['cat_id']}/{$Vars[sc_id]}/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return false;
			
			$this->DB->DeleteDB('colors','good_id = '.$ObjectID);			
			$this->DB->DeleteDB($this->NTable, 'good_id=' . $ObjectID);
			
			$tmp = $this->DB->ReadAss('SELECT * from o_photos where good_id');
			
			foreach ($tmp as $row) {
				
				unlink($Global['Foto.MinDir'].'/'.$row.'.jpg');
				unlink($Global['Foto.Dir'].'/'.$row.'.jpg');
			}
			
			$this->DB->DeleteDB('o_photos','good_id='.$ObjectID);
			$this->DB->DeleteDB('order_goods','good_id='.$ObjectID);
			$this->DB->DeleteDB('basket','good_id='.$ObjectID);
			$this->Go("{$Global['Host']}/edit_cats/{$SUBCAT->Object['cat_id']}/{$Vars[sc_id]}/$ObjectID");
		}
		
	}
	
	function ReadNewski($limit) {
		$this->Objects = $this->DB->ReadAss('select * from goods where good_new AND good_check order BY good_id DESC limit '.$limit);
	}
	
	function ReadBestCellers($limit) {
		$this->Objects = $this->DB->ReadAss('select * from goods where good_bestceller AND good_check order BY good_id DESC limit '.$limit);
	}
}

?>