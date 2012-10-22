
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
				<?php 
				
					$spam_id = (int)$Global['Url.Page'][1];
					$tmp = $DB->ReadAssRow('select * from spam where spam_id ='.$spam_id);
					if ($tmp['spam_checkcode'] == $Global['Url.Page'][2]) {
						
						$DB->DeleteDB('spam','spam_id='.$spam_id);
						echo '<H1>Услуга отключена</H1><br />Ваш e-mail был удалён из списка рассылки';
					} else {
						
						echo '<H1>Ошибка</H1><br />Был введён не правильный код, либо записи не существует. '; 
					}
				?>
			</div>
			<td>
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