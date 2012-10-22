
		<div class="bigmenu">
			<div class="productbox">
				<div class="arrowup" onClick="Up();"></div>
				<div class="box"><div id="lenta" style="position: relative; top:0px"><?php $CAT->GetCats()?></div></div>
				
				<div class="arrowdown" onClick="Down();"></div>
				<script>
					var shag = 76;
					var pos = 0;
					function Up() {
						if (pos < 0-shag) {
							konv("lenta", shag, pos);
							pos+=shag;
						} else {
							if (pos < 0) {
								konv("lenta", -pos, pos);
								pos = 0;
							} else document.getElementById("lenta").style.top="0px";
						}
					}
					
					function Down() {
						if (pos > 231-mh+shag) {
							konv("lenta", -shag, pos);
							pos-=shag;
						} else {
							if (pos > 231-mh) {
								konv("lenta", 231-mh-pos, pos);
								pos = 231-mh;
							}
						}
					}
					
				</script>
				
			</div>
			<div class="flash">
			
			<?php echo showFlash();?>
			</div>
		</div>
		
		<div  class="content">
			<table cellspacing=0 cellpadding=0 width="100%"><tr valign="top"><td>
            <div class="article">
            <img src="http://galkom.ru/css/images/head_contacts_01.gif" /><br />
            <br />
			<b>Информация о юридическом лице:</b><br />
			Наименование - ООО "Галком Про"<br>
 ОГРН - 1095027007778 <a target="_blank" href="http://galkom.ru/images/document.jpg"><br />свидетельство</a><br />
 <br />
            <b>Адрес:</b><br />
            40005, г. Люберцы, ул. Кирова, 20А, (территория ОАО ДОК-13, проходная с улицы Калараш)
            <br />
            <b>Тел/факс:</b><br />
            +7 (495) 517-09-03<br />
            <br />
            <b>E-mail:</b><br />
            stm@galkom.ru<br />
            <br />
            <b>Карта:</b><br />	
			<div id="map_canvas" style="width: 581px; height: 357px; margin-top:5px"></div></div></td>
			<td class="news">
				<div class="news">
				<div class="new_cap"></div><br />
				<?php $NEW->ShowLastNews(2);?>
				<div class="mailing">
					<div style="padding-bottom:2px">Подписаться на рассылку: </div>
					<input style="color: #d9d9d9" id="mail"  value="Ваш e-mail" OnFocus="FirstEmailClick(this)" /><div OnClick="AddToList()" id="ok" class="ok"></div>
				</div>
				</div>
			</td>
			</tr></table>
		</div>
	</div>