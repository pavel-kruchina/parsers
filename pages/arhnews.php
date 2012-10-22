<div id="menu" align="right">
	<ul>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>">Главная</a></li>
		<li class="active"><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/news">Новости</a></li>
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
 
 <script>
 </script>
 
				<a href="<?php echo $Global['Host']?>">Главная</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="<?php echo $Global['Host']?>/arhnews">Архив новостей</a>
			</div>
		
		<?php
		
		$sajax_request_type = "POST";
						$sajax_remote_uri = $Global['Host'].'/ajax.php';
						sajax_init();
						sajax_export("get_news");
						sajax_handle_client_request();	
		?>
		<br /><h1>Архив новостей</h1>
		<script>
		<?php 
						sajax_show_javascript();
		?>
		
		var page=0;
		
		function ResData(data) {
		
			document.getElementById("sallnews").innerHTML = data;
		}
		
		function ChangePage(y,m,p) {
			document.getElementById("all_news").innerHTML = "Подождите, загружаю..."; 
			x_get_news(y, m, p, ResData);
			return false;
		}
		
		function DoSearch() {
			
			document.getElementById("sallnews").innerHTML = "Подождите, загружаю..."; 
			x_get_news(document.getElementById('year').value, document.getElementById('month').value,ResData);
			return false;
		}
		
		</script>
		<?php		
		
		
		
?>
<div id="news_arch">
		<table>
			<tr>
				<td width="100px" height="50px" valign="middle">
					Год<br />
					<select id="year">
					<option value="" selected="selected"></option>
					<option value="2009">2009</option>
					</select>
				</td>
				<td width="132px" height="50px" valign="middle">
					Месяц<br />
					<select id="month">
					<option value="0" selected="selected"></option>
					<option value="12">декабрь</option>
					<option value="11">ноябрь</option>
					<option value="10">октябрь</option>
					<option value="9">сентябрь</option>
					<option value="8">август</option>
					<option value="7">июль</option>
					<option value="6">июнь</option>
					<option value="5">май</option>
					<option value="4">апрель</option>
					<option value="3">март</option>
					<option value="2">февраль</option>
					<option value="1">январь</option>
					</select>
				</td>
				
				<td width="150px" height="50px" valign="middle">
					<a href="#nogo" OnClick="return DoSearch();"><img src="<?php echo $Global['Host']?>/css/images/news_arch_search.gif" width="112" height="33" alt="" /></a>
				</td>
				<td class="as">* Выберите год и месяц для поиска</td>
			</tr>
		</table>
	</div>
	<div id="search_line">&nbsp;</div>
	<div id="sallnews">
	<div id="number" align="center"></div>
<div id="all_news">
</div>
	<div id="number" align="center"></div>
	</div>
</div>