<?php
class Basket extends IntegratedDataBase {
	var $NTable = 'basket';
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function SearchOrders($key_words, $start_date, $end_date, $status) {
		
		$key_words = trim(addslashes($key_words));
		
		if ($key_words) {
			$kw = explode(' ',$key_words);
			$key_words = "";
			foreach ($kw as $row) {
				
				$key_words.=" AND CONCAT_WS(',', users.user_name, users.user_login, users.user_soname, users.user_pname, users.user_org, users.user_doing, users.user_adr, users.user_town, users.user_mail) LIKE '%$row%' ";				
			}
		} else $key_words="";
		
		if ($start_date) {
			
			$start_date = explode('.',$start_date);
			
			$start_date = ' AND orders.order_date > '.(mktime(0,0,0,$start_date[1],$start_date[0],$start_date[2]));
		} else $start_date="";
		
		if ($end_date) {
			
			$end_date = explode('.',$end_date);
			
			$end_date = ' AND orders.order_date < '.(mktime(23,59,59,$end_date[1],$end_date[0],$end_date[2]));
		} else $end_date="";
		
		$status = (int)$status;
		
		if ($status>-1) {
		
			$status = " AND orders.order_state=$status";
		} else $status="";
		
		$tmp = $this->DB->ReadAss("Select orders.*, users.* from orders, users where orders.user_id=users.user_id $key_words $start_date $end_date $status order by orders.order_date DESC");
		return $tmp;
		
	}
	
	function GetOrders($user_id) {
		
		$tmp = $this->DB->ReadAss("Select * from orders where user_id=$user_id order by order_date DESC");
		return $tmp;
	}
	
	function DeleteOrder() {
		global $User;
		global $Global;
		global $HTTP_POST_VARS;
		$Vars = $HTTP_POST_VARS;
		
		if (!$User['user_id']) return;
		
		$f = $this->DB->ReadScalar('Select user_id from orders where order_id='.$Vars['order_id'].' AND user_id='.$User['user_id'].' AND order_state = 0');
		if (!$f) return;
		
		$goods = $this->DB->ReadAss('Select * from order_goods where order_id='.$Vars['order_id']);
		
		$tmp = array();
		
		$tmp['user_id'] = $User['user_id'];
		
		foreach($goods as $row) {
			
			$tmp['good_id'] = $row['good_id'];
			$tmp['goods_count'] = $row['goods_count'];
			$tmp['mat_id'] = $row['mat_id'];
			
			$this->DB->EditDB($tmp, 'basket');
			$this->DB->DeleteDB('order_goods','order_id='.$Vars['order_id']);
		}
		
		unlink($Global['File.Dir'].'/'.($this->DB->ReadScalar('Select file_name FROM orders WHERE order_id='.$Vars['order_id'])));
		
		$this->DB->DeleteDB('orders','order_id='.$Vars['order_id']);
	}
	
	function OrderProcess() {
		global $User;
		global $Global;
		global $HTTP_POST_VARS;
		$Vars = $HTTP_POST_VARS;
		
		$object_id = (int)$HTTP_POST_VARS['order_id'];
		$goods = $HTTP_POST_VARS['goods'];
		$prices = $HTTP_POST_VARS['price'];
		$good_count = $HTTP_POST_VARS['good_count'];
		
		$order=array('order_state'=>(int)$HTTP_POST_VARS['state'], 'order_com'=>$HTTP_POST_VARS['order_com']);
		
		$this->DB->EditDB($order, 'orders', 'order_id='.$object_id);
		
		foreach ($goods as $key=>$row) {
			
			$tmp =array('goods_count'=>$good_count[$key], 'good_price'=>$prices[$key]);
			$this->DB->EditDB($tmp, 'order_goods', 'order_id='.$object_id.' AND good_id='.$row);
			
		}
		
	}
	
	function ManDeleteOrder() {
		global $User;
		global $Global;
		global $HTTP_POST_VARS;
		$Vars = $HTTP_POST_VARS;
		
		$goods = $this->DB->ReadAss('Select * from order_goods where order_id='.$Vars['order_id']);
		
		$tmp = array();
		
		$tmp['user_id'] = $this->DB->ReadScalar('Select user_id from orders where order_id='.$Vars['order_id']);
		
		foreach($goods as $row) {
			
			$tmp['good_id'] = $row['good_id'];
			$tmp['goods_count'] = $row['goods_count'];
			$tmp['mat_id'] = $row['mat_id'];
			
			$this->DB->EditDB($tmp, 'basket');
			$this->DB->DeleteDB('order_goods','order_id='.$Vars['order_id']);
		}
		
		unlink($Global['File.Dir'].'/'.($this->DB->ReadScalar('Select file_name FROM orders WHERE order_id='.$Vars['order_id'])));
		
		$this->DB->DeleteDB('orders','order_id='.$Vars['order_id']);
	}
	
	function GetOrder($order_id) {
		global $User;
		$f = $this->DB->ReadScalar('Select user_id from orders where order_id='.$order_id.' AND user_id='.$User['user_id']);
		if (!$f) return array();
		
		$goods = $this->DB->ReadAss('Select * FROM order_goods where order_id='.$order_id);
		return $goods;
	}
	
	function MGetOrder($order_id) {
		
		$goods = $this->DB->ReadAss('Select * FROM order_goods where order_id='.$order_id);
		return $goods;
	}
	
	function ZakConfirm() {
		global $Errors;
		global $Global;
		global $User;
		if (!$User['user_id']) return;
		
		global $HTTP_POST_VARS;
		$Vars = $HTTP_POST_VARS;
		
		global $HTTP_POST_FILES;
		$Files=$HTTP_POST_FILES;
		$Vars['order_date'] = time();
		
		$tmp = $Files['add_file'];
		
		if (!(int)$tmp['error'] && file_exists($tmp['tmp_name'])) {
		
			$Vars['file_name'] = $Vars['order_date'].'.'.end(explode(".", $tmp['name']));
			
			copy($tmp['tmp_name'], $Global['File.Dir'].'/'.$Vars['file_name']);
			
		} else {
			if ($tmp['name']!="") {
				
				$Errors['file'] = 'Ошибка обработки файла, заказ не принят';
				return;
			}
		}
		
		$pv = array();
		$pv['order_date'] = $Vars['order_date'];
		$pv['file_name'] = $Vars['file_name'];
		$pv['user_id'] = (int)$User['user_id'];
		$pv['order_com'] = $this->CleanTag($Vars['order_com']);
		$pv['order_state'] = 0;
		
		$this->DB->EditDB($pv,'orders');
		$order_id = $this->DB->LastInserted;
		
		$pv = array();
		$pv['order_id'] = $order_id;
		
		$tmp = $this->GetGoods();
		
		foreach ($tmp as $row) {
		
			$pv['good_id'] = $row['good_id'];
			$pv['goods_count'] = $row['goods_count'];
			$pv['mat_id'] = $row['mat_id'];
			
			$price = $this->DB->ReadScalar('Select matprice from mat_price where good_id='.$row['good_id'].' AND mat_id='.$row['mat_id']);
			$koef = CalcKoef($row['goods_count']);
			if ($koef<0) {
				$koef = -$koef;
			}
			$price *= $User['koef'];
			$price = $price*$koef;
			
			$pv['good_price'] = $price;
			$this->DB->EditDB($pv,'order_goods');
		}
		
		$this->DB->DeleteDB('basket', 'user_id='.$User['user_id']);
		
	}
	
	function AddToBasket($good_id, $mat_id, $count) {
		global $User;
		global $_SESSION;
		
		if ($_SESSION['User']) {
			
			$goods = $this->LoadFromDB();
		} else
		{
			$goods = $this->LoadFromSession();
		}
		
		foreach ($goods as $row) {
		
			if ($row['good_id']==$good_id && $row['mat_id']==$mat_id) {
				$flag=true;
				break;
			}
		}
		
		if (!$flag) {
			$goods[] = array('user_id'=>$_SESSION['User']['user_id'], 'good_id'=>$good_id, 'mat_id'=>$mat_id, 'goods_count'=>$count);
		}
		
		if ($_SESSION['User']) {
			
			$this->SaveToDB($goods);
		} else
		{
			$this->SaveToSession($goods);
		}
		
	}
	
	function SaveCount($good_id, $mat_id, $count) {
		global $_SESSION;
		
		$goods = $this->GetGoods();
		if (!$goods) $goods = array();
		foreach (array_keys($goods) as $row) {
		
			if ($goods[$row]['good_id']==$good_id && $goods[$row]['mat_id']==$mat_id) {
				$goods[$row]['goods_count'] = $count;
				break;
			}
		}
		
		if ($_SESSION['User']) {
			
			$this->SaveToDB($goods);
		} else
		{
			$this->SaveToSession($goods);
		}
	}
	
	function DeleteFromBasket($good_id, $mat_id) {
		global $_SESSION;
		
		$goods = $this->GetGoods();
		if (!$goods) $goods = array();
		foreach (array_keys($goods) as $row) {
		
			if ($goods[$row]['good_id']==$good_id && $goods[$row]['mat_id']==$mat_id) {
				unset($goods[$row]);
				break;
			}
		}
		
		if ($_SESSION['User']) {
			
			$this->SaveToDB($goods);
		} else
		{
			$this->SaveToSession($goods);
		}
		
		return count($goods);
	}
	
	function DeleteFromOrder($good_id, $mat_id, $order_id) {
		global $_SESSION;
		
		$this->DB->DeleteDB('order_goods', "good_id=$good_id AND mat_id=$mat_id AND order_id=$order_id");
	}
	
	function GetGoods() {
		global $_SESSION;
		
		if ($_SESSION['User']) {
			
			$goods = $this->LoadFromDB();
		} else
		{
			$goods = $this->LoadFromSession();
		}
		
		return $goods;
	}
	
	function GetGoodsCount() {
		global $_SESSION;
		
		if ($_SESSION['User']) {
			
			$goods = $this->LoadFromDB();
		} else
		{
			$goods = $this->LoadFromSession();
		}
		
		return (int)count($goods);
	}
	
	function LoadFromDB() {
		global $_SESSION;
		return $this->DB->ReadAss("Select * from {$this->NTable} where user_id={$_SESSION['User']['user_id']} ");
	}
	
	function LoadFromSession() {
		global $_SESSION;
		
		return $_SESSION['goods'];
		
	}
	
	function SaveToDB($goods) {
		global $_SESSION;
		$this->DB->DeleteDB($this->NTable, 'user_id='.$_SESSION['User']['user_id']);
		
		if (!$goods) $goods = array();
		foreach ($goods as $row){
		
			$this->DB->EditDB($row, $this->NTable);
		}
	}
	
	function SaveToSession($goods) {
		global $_SESSION;
		$_SESSION['goods'] = $goods;
	}
	
	function FromSessionToDB() {
		global $User;
		global $_SESSION;
		
		$goods = $_SESSION['goods'];
		if (!$goods) $goods = array();
		//$this->DB->DeleteDB($this->NTable, 'user_id='.$User['user_id']);
		
		foreach ($goods as $row){
			$row['user_id'] = $_SESSION['User']['user_id'];
			$this->DB->EditDB($row, $this->NTable);
		}
	}
};
?>