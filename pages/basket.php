<table width="100%"><tr><td>


			<script>
					

function deleteResp(data) {
	document.getElementById("basket").innerHTML = data;
}
					
function deleteFromBasket(rowId, goodId, matId) {
	
	if (confirm("Вы действительно желаете удалить эту позицию?")){
		x_delete_good(goodId, matId, deleteResp);
		el = document.getElementById(rowId);
		el.parentNode.removeChild(el);
		
		ReCalc();
	}
}

function DummyResp(data) {
	
	return;
}

function SaveCount(good_id, mat_id, inp_id) {
	
	var c = document.getElementById(inp_id).value;
	x_save_count(good_id, mat_id, c, DummyResp);
}

var koefs = [];
	koefs['int'] = [];
	koefs['koef'] = [];

var count=0;
	
var rowCount = <?php echo $BASKET->GetGoodsCount() ?>;
<?php

$order_id =(int)$Global['Url.Page'][1];

$User['koef'] = $User['koef']?$User['koef']:1;
	$koefs = $DB->ReadAss("SELECT * FROM koefs WHERE koef_value ORDER BY koef_value DESC");
	$row = CreateRow($koefs);
	
	foreach (array_keys($row['int']) as $inter) {
		
		echo ' koefs["int"][count]='.(int)$row['int'][$inter].';';
		echo ' koefs["koef"][count]='.$row['koef'][$inter].';';
		echo ' count++;';
	}
	
?>

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
			for (j=0; j<count; j++) {
				if ( col<koefs['int'][j] ) {
					if (koefs['koef'][j]) {
						pr = koefs['koef'][j];
						break;
					} else {
						pr = koefs['koef'][j+1];
						flag = true;
						break;
					}
				}
			}
			
			if (col> koefs['int'][count-1]) {
				pr = koefs['koef'][count-1];
				flag = true;
			}
			
			pr *= prices[i];
			
			pr = parseInt(pr);
			
			all+=pr*col;
			
			document.getElementById('price'+i).innerHTML = parseInt(pr)+".-";
			document.getElementById('bbprice'+i).value = parseInt(pr);
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

var conf = false;

function zakConfirm() {
	
			document.basket.submit();

}
</script>
<div class="basfon">
	<div class="basket_cap" ></div>
	
	<?php if ($Errors['file']) echo'<script>alert("'.$Errors['file'].'")</script>'; 
	
	if (!$order_id) {?>
	
	
	<?php
		$allp = 0;
		
		$goods = $BASKET->GetGoods();
		if (!$goods) $goods = array();
		$i=0;
		foreach ($goods as $row) {
		
			$GOOD->ReadOneObject($row['good_id']);
			
			$sc_url = $DB->ReadScalar("Select sc_url from subcat where sc_id='{$GOOD->Object['sc_id']}'");
			
			$foto =  $DB->ReadScalar('Select photo_id from o_photos where good_id='.$row['good_id'].' Order By photo_id ');
			echo'
			<div id="br'.$i.'" class="basrow">
			<a target="_blanck" href="'.$Global['Host'].'/catalog/'.$sc_url.'/'.$GOOD->Object['good_url'].'">
			<img  style="float: left" class="small" '.$style.' src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$foto.'.jpg">
			</a>
			<input type="hidden" name="goods['.$i.']" value="'.$row['good_id'].'" />
			';
			
			$good = $DB->ReadAssRow('Select * from goods where good_id='.$row['good_id']);
			
			echo '<div class="smallname" style=" 
			height:28px; float: left; padding-top: 6px; padding-left: 19px; color: #7b9ebe; width: 200px">'.$good['good_name'].'
					<div style="padding-top: 2px;" class="advart">[арт. '.$good['good_art'].']</div>
				</div>';
			
			$price = $DB->ReadScalar('Select matprice from mat_price where good_id='.$row['good_id'].' AND mat_id='.$row['mat_id']);
			$koef = CalcKoef($row['goods_count']);
			if ($koef<0) {
				$flag = true;
				$koef = -$koef;
			}
			$price = ((float)$price)*((float)$User['koef']);
			
			$olp = (int)$price;
			$price = $price*$koef;
			$price = (int)$price;
			$allp += $price*$row['goods_count'];
			
			echo '<div id = "price'.$i.'" style="text-align: right; float: left; padding-top: 6px; padding-left: 2px; width: 50px; padding-right: 20px; font-size: 12px;" class="smallprice">'.ReturnPrice($price).'</div>';
			echo '<input id="bbprice'.$i.'""  type="hidden" name="good_price['.$i.']" value="'.$price.'" />';
			
			echo '<div style="float: left; padding-top: 6px; padding-left: 2px; width: 110px"> 
					<input OnChange="SaveCount('.$row['good_id'].','.$row['mat_id'].' ,\'inp'.$i.'\')" id="inp'.$i.'" name="good_count['.$i.']" style="width: 62px; padding-left: 10px; border: 1px solid #99b5ca; float: left; margin-right: 6px" value="'.$row['goods_count'].'" /> <span style="float: left;">шт.</span>
				</div>';
			
			echo '<div id = "pr'.$i.'"	style="font-weight:600; float: left; padding-top: 6px; padding-left: 2px; width: 85px; text-align: right"> 
					'.ReturnPrice($price*$row['goods_count']).'
				</div>';
			
			echo '<div OnClick="deleteFromBasket(\'br'.$i.'\', '.$row['good_id'].', '.$row['mat_id'].')" class="delete" ></div>';
			
			echo '<script> prices['.$i.'] = '.$olp.'  </script>';
			
			echo '</div>';
			$i++;
		}
		
		
	?>
	
	<div style="margin-top: 20px; margin-bottom: 20px; width: 100%; background: white; height: 1px" ></div>
	<div OnClick="ReCalc()" class=recount></div>
	<div OnClick="<?php if($User['user_id']) echo'GetOnLayer(\'confirm_zak\');'; else echo'GetOnLayer(\'login\'); return false;'; ?>" class=bassave></div>
	<div class=itogo>ИТОГО:</div><div id=allprice class=allprice><?php echo ReturnPrice($allp); if ($flag) echo '*'?></div>
	
	<?php } else { ?>
	
	<?php
		$allp = 0;
		
		$goods = $BASKET->GetOrder($order_id);
		$i=0;
		foreach ($goods as $row) {
		
			$GOOD->ReadOneObject($row['good_id']);
			$sc_url = $DB->ReadScalar("Select sc_url from subcat where sc_id={$GOOD->Object['sc_id']}");
			$foto =  $DB->ReadScalar('Select photo_id from o_photos where good_id='.$row['good_id'].' Order By photo_id ');
			echo'
			<div id="br'.$i.'" class="basrow">
			<a target="_blanck" href="'.$Global['Host'].'/catalog/'.$sc_id.'/'.$GOOD->Object['good_id'].'">
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
			
			echo '<div id = "price'.$i.'" style="text-align: right; float: left; padding-top: 6px; padding-left: 2px; width: 50px; padding-right: 20px; font-size: 12px;" class="smallprice">'.ReturnPrice($price).'</div>';
			
			echo '<div style="float: left; padding-top: 6px; padding-left: 2px; width: 110px"> 
					<input id="inp'.$i.'" disabled name="good_count['.$i.']" style="width: 62px; padding-left: 10px; border: 1px solid #99b5ca; float: left; margin-right: 6px" value="'.$row['goods_count'].'" /> <span style="float: left;">шт.</span>
				</div>';
			
			echo '<div id = "pr'.$i.'"	style="font-weight:600; float: left; padding-top: 6px; padding-left: 2px; width: 85px; text-align: right"> 
					'.ReturnPrice($price*$row['goods_count']).'
				</div>';
			
			
			echo '</div>';
			$i++;
		}
		
		
	?>
	
	<div style="margin-top: 20px; margin-bottom: 20px; width: 100%; background: white; height: 1px" ></div>
	<?php if ( ((int)$DB->ReadScalar('select order_state from orders where order_id='.$order_id))==0 ){ ?>
	<form name="delete_zak" method="POST" action="<?php echo $Global['Host']?>/basket"><input type="hidden" name="sender" value="delete_zak" />
	<input type="hidden" name="order_id" value="<?php echo $order_id?>" />
	
	</form>
		<div style="float: left; width: 210px; text-align: left; cursor: pointer;" OnCLick="document.delete_zak.submit();"><a href="#">Удалить заказ</a></div>
	<?php } else echo '<div style="float: left; width: 210px;">&nbsp;</div>'; ?>
	<div  class=itogo>ИТОГО:</div><div id=allprice class=allprice><?php echo ReturnPrice($allp); if ($flag) echo '*'?></div>
	
	<?php }?>
	<div id="help" style="width: 500px; text-align: left; float: left; padding-top: 5px; <?php if (!$flag) echo 'display: none'; ?>">* Цена по некоторым позициям может отличатся от заявленной</div>
</div>
<div class="history">
	<?php
	
	if ($User['user_id']) {
	
	$orders = $BASKET->GetOrders($User['user_id']);
	if (!$orders ) $orders = array();
	foreach ($orders as $row) {
		if ($order_id == $row['order_id'])
				echo '<div style="float: left"><b>Заказ #'.(AddZero($row['order_id'],4)).'</b> от '.(date("d.m.Y",$row['order_date'])).'&nbsp;</div>'.$Global['Status'][$row['order_state']].'<br />';
		
		else 	echo '<a href="'.$Global['Host'].'/basket/'.$row['order_id'].'"><div style="float: left"><b>Заказ #'.(AddZero($row['order_id'],4)).'</b> от '.(date("d.m.Y",$row['order_date'])).'</a>&nbsp;</div>'.$Global['Status'][$row['order_state']].'<br />';
	}
	
	}
	?>
</div>

</td></tr>
</table>
	