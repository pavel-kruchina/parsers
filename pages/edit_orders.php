<?php $order_id = (int)$Global['Url.Page'][1];
if ($order_id) {
	$order = $DB->ReadAssRow("Select * from orders where order_id = $order_id");
	$us = $DB->ReadAssRow("Select * from users where user_id = {$order['user_id']}");
}
?>
<table width="100%"><tr><td>
<script>

var rowCount = <?php echo (int)$BASKET->DB->ReadScalar("Select count(good_id) as cc from order_goods where order_id = $order_id group by order_id") ?>;


var prices = [];


function ReCalc() {
	
	var i;
	var pr;
	var j;
	
	var flag = false;
	var col;
	var all=0;
	
	for (i=0; i<rowCount; i++) {
		if (document.getElementById('inp'+i)) {
			
			col = parseInt(document.getElementById('inp'+i).value);
			pr = 1;
						
			pr *= prices[i];
			
			pr = parseInt(pr);
			
			all+=pr*col;
			
			document.getElementById('price'+i).innerHTML = parseInt(pr)+".-";
			document.getElementById('pr'+i).innerHTML = parseInt(pr*col)+".-";
		}
	}
	if (!flag) {
		document.getElementById('allprice').innerHTML = parseInt(all)+".-";
		document.getElementById('help').style.display = 'none';
	}
	else {
		document.getElementById('allprice').innerHTML = parseInt(all)+".-*";
		document.getElementById('help').style.display = 'block';
	}
}

function deleteResp(data) {
	return;
}
					
function deleteFromBasket(rowId, goodId, matId) {
	
	if (confirm("Вы действительно желаете удалить эту позицию?")){
		el = document.getElementById(rowId);
		el.parentNode.removeChild(el);
		
		ReCalc();
	}
}
</script>
<div class="basfon">
 <?php if ($order_id) { ?>
	<b>Данные пользователя </b> <?php echo "<a href='{$Global['Host']}/edit_users/{$us['user_id']}'>< {$us['user_login']} ></a> 
	<br />
	<b>ФИО: </b> <nobr>{$us['user_soname']} {$us['user_name']} {$us['user_pname']}</nobr> <br />
	<nobr><b>Организация: </b>\"{$us['user_org']}\"<br /> 
	<b>Город: </b>{$us['user_town']} <br />
	<b>Адрес: </b>{$us['user_adr']}<br />
	<b>e-mail:</b> {$us['user_mail']}"; 
									?>  
<?php }?>
	
	
	<form name="delete_zak" method="POST" action="">
	<input type="hidden" name="sender" value="delete_zak_man" />
	<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
	
	</form>
	
	<form name="zak" method="POST" action="">
	<input type="hidden" name="sender" value="zak" />
	<input type="hidden" name="order_id" value="<?php echo $order_id?>" />
	
	<?php if ($Errors['file']) echo'<script>alert("'.$Errors['file'].'")</script>'; 
	
			
			$allp = 0;
		
		$goods = $BASKET->MGetOrder($order_id);
		$i=0;
		if ($goods)
		foreach ($goods as $row) {
		
			$GOOD->ReadOneObject($row['good_id']);
			$sc_id = $GOOD->Object['sc_id'];
			$foto =  $DB->ReadScalar('Select photo_id from o_photos where good_id='.$row['good_id'].' Order By photo_id ');
			echo'
			<input type="hidden" name="goods['.$i.']" value="'.$row['good_id'].'" />
			<div id="br'.$i.'" class="basrow">
			<a target="_blanck" href="'.$Global['Host'].'/catalog/'.$sc_id.'/'.$row['good_id'].'">
			<img  style="float: left" class="small" '.$style.' src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$foto.'.jpg">
			</a>
			
			';
			
			$good = $DB->ReadAssRow('Select * from goods where good_id='.$row['good_id']);
			
			echo '<div class="smallname" style=" 
			height:28px; float: left; padding-top: 6px; padding-left: 19px; color: #7b9ebe; width: 200px">'.$good['good_name'].'
					<div style="padding-top: 2px;" class="advart">[арт. '.$good['good_art'].']</div>
				</div>';
			
			$price = $row['good_price'];
			$allp += $price*$row['goods_count'];
			
			echo '<input id = "price'.$i.'" name="price['.$i.']" style="width: 40px; padding-left: 10px; border: 1px solid #99b5ca; float: left; margin-right: 20px; margin-top: 6px;" class="smallprice" value="'.$price.'" />';
			
			echo '<div style="float: left; padding-top: 6px; padding-left: 2px; width: 110px"> 
					<input id="inp'.$i.'"  name="good_count['.$i.']" style="width: 62px; padding-left: 10px; border: 1px solid #99b5ca; float: left; margin-right: 6px" value="'.$row['goods_count'].'" /> <span style="float: left;">шт.</span>
				</div>'; 
			
			echo '<div id = "pr'.$i.'"	style="font-weight:600; float: left; padding-top: 6px; padding-left: 2px; width: 85px; text-align: right"> 
					'.ReturnPrice($price*$row['goods_count']).'
				</div>';
			
			echo '<div OnClick="deleteFromBasket(\'br'.$i.'\', '.$row['good_id'].', '.$row['mat_id'].')" class="delete" ></div>';
			
			echo '<script> prices['.$i.'] = '.$price.'  </script>';
			
			echo '</div>';
			$i++;
		}
		
		
	?>
	
	<div style="margin-top: 20px; margin-bottom: 20px; width: 100%; background: white; height: 1px" ></div>
 <?php if ($order_id) { ?>	
	
		<div style="float: left; width: 210px; text-align: left;">
			
			<nobr>Статус: 
				<select name="state">
				
					<option <?php if ($order['order_state']==0) echo 'selected';?> value="0">Ожидает</option>
					<option <?php if ($order['order_state']==1) echo 'selected';?> value="1">В обработке</option>
					<option <?php if ($order['order_state']==2) echo 'selected';?> value="2">Выполняется</option>
					<option <?php if ($order['order_state']==3) echo 'selected';?> value="3">Готов</option>
				</select>
			</nobr><br />
			<a href="#" OnCLick="document.zak.submit();">Сохранить изменения</a> <br /><br />
			

			<a href="#" OnCLick="if (confirm('Действительно удалить?')) document.delete_zak.submit();">Удалить заказ</a> 
		<hr>
		<a href="<?php echo $Global['Host'].'/order.php?order_id='.$order_id; ?>">Информация в .csv</a><br />
		<?php 
			if ($order['file_name']) {?>
				Прикреплёно: <a target="_blank" href="<?php echo $Global['Host'].'/'.$Global['File.Dir'].'/'.$order['file_name'] ?>"><?php echo $order['file_name'];?></a> <br /><br />
			<?php }?>
			Комментарий: <br />
			<textarea style=" width: 328px; height: 200px" name="order_com"><?php echo $order['order_com']?></textarea><br/>
		</div>
	</form>
	<?php } ?>
	<div  class=itogo>ИТОГО:</div><div id=allprice class=allprice><?php echo ReturnPrice($allp); if ($flag) echo '*'?></div>
	
	
	<div id="help" style="width: 500px; text-align: left; float: left; padding-top: 5px; <?php if (!$flag) echo 'display: none'; ?>">* Цена по некоторым позициям может отличатся от заявленной</div>
</div>

<div class="history" style="background: url(<?php echo $Global['Host']?>/css/images/sort.jpg) repeat-x; padding-top: 5px">
	&nbsp;&nbsp;<b>Заказы</b> <br/><br/>
	<?php 
	
	
	if (!$_SESSION['osearch']) $_SESSION['osearch'] = array(); 
	
	$_SESSION['osearch'] = array_merge($_SESSION['osearch'], $_POST);
	$_POST = $_SESSION['osearch'];
	if (!isset($_POST['sstate'])) $_POST['sstate'] = -1;
	?>
	<div style="line-height: 15px;">
	<form method="POST" >
	<input type="hidden" name="sender" value="search_order" />
	
	Пользователь: <input style="width: 258px" name="ukw" value="<?php echo $_POST['ukw']; ?>" /><br/><br/>
	Дата, формат дд.мм.гггг <br />
	С <input style="width: 80px" name="startd" value="<?php echo $_POST['startd']; ?>" /> ПО <input style="width: 80px" name="stopd" value="<?php echo $_POST['stopd']; ?>" />
	<br />
	<br />
	Статус <select name="sstate">
		<option <?php if ($_POST['sstate']==-1) echo 'selected';?> value="-1">Не важно</option>
		<option <?php if ($_POST['sstate']==0) echo 'selected';?> value="0">Ожидает</option>
		<option <?php if ($_POST['sstate']==1) echo 'selected';?> value="1">В обработке</option>
		<option <?php if ($_POST['sstate']==2) echo 'selected';?> value="2">Выполняется</option>
		<option <?php if ($_POST['sstate']==3) echo 'selected';?> value="3">Готов</option>
	</select>

	<input type="submit" value="Найти" />
	
	
	</div>
	<br />
	<b>Найдено:</b>
	<hr />
	<?php
	
	$state = (int)$_POST['sstate'];
	$orders = $BASKET->SearchOrders($_POST['ukw'], $_POST['startd'], $_POST['stopd'], $state);
	if ($orders)
	foreach ($orders as $row) {
		if ($order_id == $row['order_id'])
				echo '<div style="float: left"><b>Заказ #'.(AddZero($row['order_id'],4)).'</b> от '.(date("d.m.Y",$row['order_date'])).'&nbsp;</div>'.$Global['Status'][$row['order_state']].'<br />';
		
		else 	echo '<a href="'.$Global['Host'].'/edit_orders/'.$row['order_id'].'"><div style="float: left"><b>Заказ #'.(AddZero($row['order_id'],4)).'</b> от '.(date("d.m.Y",$row['order_date'])).'&nbsp;</div></a>'.$Global['Status'][$row['order_state']].'<br />';
	}
	?>
	
	</form>
</div>

</td></tr>
</table>
	