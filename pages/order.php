<script type="text/javascript" src="<?php echo $Global['Host']?>/java/domtab.js"></script>
<script type="text/javascript">
		document.write('<style type="text/css">');    
		document.write('div.domtab div{display:none;}<');
		document.write('/s'+'tyle>');    
    </script>
	
	<!--[if gt IE 6]>
	<style type="text/css">
		ul.domtabs a:link,
		ul.domtabs a:visited,
		ul.domtabs a:active,
		ul.domtabs a:hover{
			height:3em;
		}
	</style>
	<![endif]-->
	
	<div id="menu" align="right">
	<ul>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>">Главная</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/news">Новости</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/about">О компании</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/contacts">Контакты</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/help">Справка</a></li>
		<li class="last"><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/search">Поиск</a></li>
	</ul>
 </div>

 <div id="line_after_menu_left"></div>
 <div id="line_after_menu_right"></div>
 <div id="line_after_menu_bg"></div>
 <div id="line_after_menu_ln"></div>
	
	<div id="left">
 
	<div id="breadcrums">
		<a href="<?php echo $Global['Host']?>">Главная</a>&nbsp;&nbsp;/&nbsp;&nbsp;Сделать заказ
	</div>
	<?php if ($sended) echo $sended;?>
	<form method="post" action="">
	<input type="hidden" name="sender" value="order" />
	<input type="hidden" name="typer" value="Квартира" />
	<div class="domtab">	
	<input type="radio" id="" name="action" value="Купить" /><label>Купить</label><input name="action" value="Продать" type="radio" id="" /><label>Продать</label><input type="radio" id="" name="action" value="Аренда" /><label>Арендовать</label>
	<ul class="domtabs">
		<li><a OnClick = "document.getElementById('typer').value='Квартира'" href="#flat">Квартира</a></li>
		<li><a OnClick = "document.getElementById('typer').value='Дом'" href="#house">Дом</a></li>
		<li><a OnClick = "document.getElementById('typer').value='Земля'" href="#land">Земля</a></li>
	</ul>
	<div>
		<h2><a name="flat" id="flat">Определите параметры</a></h2>
		<table border="0">
			<tr>
				<td valign="top" width="160px">
					Регион<br />
					<input type="text" id="" name="region" /><br /><br />
					Город<br />
					<input type="text" id="" name="town" /><br /><br />
					Район/шоссе<br />
					<input type="text" id="" name="area" /><br /><br />
				</td>
				<td valign="top" width="160px">
					Метраж<br />
					<input type="text" id="" name="metr" /><br /><br />
					Количество комнат<br />
					<input type="text" id="" name="kom_num" /><br /><br />
					Этаж<br />
					<input type="text" id="" name="et" /><br /><br />
				</td>
				<td valign="top" width="160px">
					Стоимость<br />
					<input type="text" id="" name="price" /><br /><br />
				</td>
			</tr>
		</table>
		<br />Дополнительно<br />
		<textarea id="" name="dops" rows="8" cols="100"></textarea><br /><br />
		<table border="0">
			<tr>
				<td width="160px">ФИО<br /><input type="text" id="" name="fio" /><br /><br /></td>
				<td width="160px">Контактный телефон<br /><input type="text" name="tel" id="" /><br /><br /></td>
				<td width="160px">E-mail<br /><input type="text" id="" name="email" /><br /><br /></td>
			</tr>
		</table>
	</div>
	<div>
		<h2><a name="house" id="house">Определите параметры</a></h2>
		<table border="0">
			<tr>
				<td valign="top" width="160px">
					Регион<br />
					<input type="text" id="" name="region1" /><br /><br />
					Город<br />
					<input type="text" id="" name="town1" /><br /><br />
					Район/шоссе<br />
					<input type="text" id="" name="area1" /><br /><br />
				</td>
				<td valign="top" width="160px">
					Метраж<br />
					<input type="text" id="" name="metr1" /><br /><br />
					Количество комнат<br />
					<input type="text" id="" name="kom_num1" /><br /><br />
					Этажность<br />
					<input type="text" id="" name="ets" /><br /><br />
				</td>
				<td valign="top" width="160px">
					Стоимость<br />
					<input type="text" id="" name="price1" /><br /><br />
				</td>
			</tr>
		</table>
		<br />Дополнительно<br />
		<textarea id="" name="dops1" rows="8" cols="100"></textarea><br /><br />
		<table border="0">
			<tr>
				<td width="160px">ФИО<br /><input type="text" id="" name="fio1" /><br /><br /></td>
				<td width="160px">Контактный телефон<br /><input type="text" name="tel1" id="" /><br /><br /></td>
				<td width="160px">E-mail<br /><input type="text" id="" name="email1" /><br /><br /></td>
			</tr>
		</table>
	</div>
	<div>
		<h2><a name="land" id="land">Определите параметры</a></h2>
		<table border="0">
			<tr>
				<td valign="top" width="160px">
					Регион<br />
					<input type="text" id=""  name="region2" />  <br /><br />
					Район/шоссе<br />
					<input type="text" name="area2" id="" /><br /><br />
				</td>
				<td valign="top" width="160px">
					Площадь<br />
					<input type="text" id="" name="sq" /><br /><br />
					Назначение<br />
					<input type="text" id="" name="target" /><br /><br />
				</td>
				<td valign="top" width="160px">
					Стоимость<br />
					<input type="text" id="" name="price2" /><br /><br />
				</td>
			</tr>
		</table>
		<br />Описание местности<br />
		<textarea id="" name="dops2" rows="8" cols="100"></textarea><br /><br />
		<table border="0">
			<tr>
				<td width="160px">ФИО<br /><input type="text" id="" name="fio2" /><br /><br /></td>
				<td width="160px">Контактный телефон<br /><input type="text" name="tel2" id="" /><br /><br /></td>
				<td width="160px">E-mail<br /><input type="text" id="" name="email2" /><br /><br /></td>
			</tr>
		</table>
	</div>	
	</div>
	<br /><input type="submit" value="Отправить" class="button"/>
	</form>
 
 </div>