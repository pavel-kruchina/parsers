<?php
class Price extends IntegratedDataBase{
	var $Error;
	
	function Price(&$DataBaseVariable){
		//Конструктор IntegratedDataBase для создания ссылки на DB
		$this->IntegratedDataBase(&$DataBaseVariable);
	}
	//serialize
		
	function Edit() {
	
		global $price_list;
		global $list_count;
		global $added_count;
		global $Global;
		
		global $HTTP_POST_VARS;
		$Vars=$HTTP_POST_VARS;
		
		global $HTTP_POST_FILES;
		$File=$HTTP_POST_FILES['price'];

		var_dump($Vars);
		
		if ($Vars['load_price']) {
		
			if (!(int)$File['error'] && file_exists($File['tmp_name'])) {
				
				copy($File['tmp_name'], 'price/price.csv');
				$this->Error = false;
				
				$f = fopen('price/price.csv', 'r');
				
				$price_list = array();
				$list_count = 0;
				
				do{
					
					$price_list[$list_count] = fgetcsv($f, 2000, ';');
					
					$list_count++;
					
				} while ($price_list[$list_count-1]);
				
				session_register("list_count");
				session_register("price_list");
				$added_count = 0;
				session_register("added_count");
				$this->Submit = true;
			} else {
		
				$this->Info = 'Ошибка загрузки файла';
			}
		} else {
		
		$price_list = $_SESSION['price_list'];
			for ($i = $_SESSION['added_count']; $i<$_SESSION['list_count'] && $i<$_SESSION['added_count']+$Global['Price.Page.Size']; $i++) {
				if (!trim($price_list[$i][1]))	{ 
					$i=$_SESSION['list_count'];
					BREAK;
				}
				$temp = array('mag_id' => trim($price_list[$i][1]), '`desc`' => trim($price_list[$i][3]), 'on_stock' => ((trim($price_list[$i][8]))?1:0));
								
				$t = $this->DB->ReadScalar('Select a_id from acs where a_name="'.AddSlashes(trim($price_list[$i][2])).'"');
				if (!$t) {
					
					$this->DB->EditDB(array('a_name'=>trim($price_list[$i][2])),'acs');
					$t = $this->DB->LastInserted;
				}
				$temp['ac_id'] = $t;
				
				if (!trim($price_list[$i][4])) {
					$temp['brend_id'] = 0;
				} else {	
					$t = $this->DB->ReadScalar('Select b_id from brends where b_name="'.AddSlashes(trim($price_list[$i][4])).'"');
					if (!$t) {
						
						$this->DB->EditDB(array('b_name'=>trim($price_list[$i][4])),'brends');
						$t = $this->DB->LastInserted;
					}
					$temp['brend_id'] = $t;
				}
				
				if (!trim($price_list[$i][5])) {
					$temp['model_id'] = 0;
				} else {
					$t = $this->DB->ReadScalar('Select m_id from models where m_name="'.AddSlashes(trim($price_list[$i][5])).'" and b_id='.$temp['brend_id']);
					if (!$t) {
						
						$this->DB->EditDB(array('m_name'=>trim($price_list[$i][5]), 'b_id'=>$temp['brend_id']),'models');
						$t = $this->DB->LastInserted;
					}
					$temp['model_id'] = $t;
				}
				
				$t = $this->DB->ReadScalar('Select m_id from mackers where m_name="'.AddSlashes(trim($price_list[$i][7])).'"');
				if (!$t) {
					
					$this->DB->EditDB(array('m_name'=>trim($price_list[$i][7])),'mackers');
					$t = $this->DB->LastInserted;
				}
				$temp['macker_id'] = $t;
				$temp['price'] = str_replace(",",".",$price_list[$i][6]);
				
				$temp = array_merge($tmp, $temp);
				$this->DB->EditDB($temp, 'products');
			}
			
			$_SESSION['added_count'] = $i;
			if ($_SESSION['added_count'] >= $_SESSION['list_count']) {
				session_unregister("list_count");
				session_unregister("price_list");
				session_unregister("added_count");
				$this->Info = 'Прайс успешно добавлен';
			} else {
			
				session_register("list_count");
				session_register("price_list");
				session_register("added_count");
				
				$this->Info = 'Загружено '.$added_count.' из '.$list_count;
				$this->Submit = true;
			}
		}
		
				
	}
	
	function Next() {
		echo $this->Submit;
		if ($this->Submit) { ?>
			
			<script language="javascript" >
				document.form_price.submit();
			</script><?
		}
	}
	
};
?>