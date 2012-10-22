 <div id="menu" align="right">
	<ul>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>">Главная</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/news">Новости</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/about">О компании</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/contacts">Контакты</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/help">Справка</a></li>
		<li  class="last"><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/search">Поиск</a></li>
	</ul>
 </div>

 <div id="line_after_menu_left"></div>
 <div id="line_after_menu_right"></div>
 <div id="line_after_menu_bg"></div>
 <div id="line_after_menu_ln"></div>

 <div id="left">
 
	<div id="breadcrums">
		<a href="<?php echo $Global['Host']?>">Главная</a>&nbsp;&nbsp;/&nbsp;&nbsp;Ипотечный калькулятор
	</div>
	<script>
	function calc() {
		
		var v1 = parseInt(document.getElementById('allprice').value);
		if (!v1) {
			alert('Цена введена не правильно!');
			return;
		}
		
		var v2 = parseInt(document.getElementById('first').value);
		
		
		var v3 = parseInt(document.getElementById('term').value);
		if (!v3) {
			alert('Срок кредита введен не правильно!');
			return;
		}
		
		var v4 = parseInt(document.getElementById('perc').value);
		if (!v4) {
			alert('Процентная ставка введена не правильно!');
			return;
		}
		
		document.getElementById('res').innerHTML = (v1 - (v1 - v1 * v2/100))/v3 + (v1 - (v1 - v1 * v2/100)) * v4 * (v3/12) +" руб.";
		
	}
	</script>
	<div id="calc">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					Полная стоимость объекта (руб.)<br />
					<input  type="text" id="allprice" /><br /><br />
					Сумма первоначального взноса (%)<br />
					<input type="text" id="first" /><br /><br />
					Срок кредита (мес.)<br />
					<input type="text" id="term" /><br /><br />
					Процентная ставка (%)<br />
					<input type="text" id="perc" /><br /><br />
				</td>
				<td valign="bottom">
					<div class="calc_result" valign="top">Ежемесячная сумма платежа <br /><br /><h1><div id="res">Введите данные и нажмите "рассчитать"</div></h1></div>
					<a href="#nogo" ><img  OnClick="calc();" src="<?php echo $Global['Host']?>/css/images/calc_action.gif" width="112" height="33" alt="" /></a>
				</td>
			</tr>
		</table>
	</div>
 
 </div>>
