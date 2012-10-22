<?php

	$new_id = (int)$Global['Url.Page'][1];
	
	$NEW->ReadOneObject($new_id);
	
	
	
?>

		<div class="bigmenu">
			<div class="productbox">
				<div class="arrowup" onClick="Up();"></div>
				<div class="box"><div id="lenta" style="position: relative;"><?php global $CAT;  $CAT->GetCats()?></div></div>
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
			
			<div class="flash"><?php echo showFlash();?></div>
		</div>
		
		<div  class="content">
			<table cellspacing=0 cellpadding=0 width="100%"><tr valign="top"><td >	
			
			<table cellspacing=0 cellpadding=0 width="100%" height="100%"><tr>
			<td valign=top style="background: #f0f0f0;  border-right: 10px solid white; ">
			<div class="article"  >
			<div style="float: left; width: 0px; height: 300px"></div>
				<a href="<?php echo $Global['Host']?>/news"><div style="cursor: pointer" class="news_cap"></div></a>
				<br /><span id="new_content"> 
				<?php
					if ($new_id) {
						echo '<b>'.(date("d.m.Y", $NEW->Object['new_date'])).'<br/>'.$NEW->Object['new_prew'].'</b><br /><br />';
						echo $NEW->Object['new_text'];
					
					} else {
						$tmp = $DB->ReadAssRow('Select * from sections where section_point="news"');
				echo $tmp['section_text'];
						
					}
				?></span>
			</div>
			</td>
			
			<td valign=top rowspan=2 class="news">
				<div class="news">
				
				<span id="arh_field"><?php 
				if (!$_SESSION['nsearch']) {
					echo '<div class="top5_cap"></div>';
				} else {
					echo '<div class="arh_cap"></div>';
				}
				
				?> 
				<br />
				<?php 
				if (!$_SESSION['nsearch']) {
					$NEW->ShowLastNews(5);
				} else {
					
				}
					
				?>
				
				<div class="mailing">
					<div style="padding-bottom:2px">Подписаться на рассылку: </div>
					<input style="color: #d9d9d9" id="mail"  value="Ваш e-mail" OnFocus="FirstEmailClick(this)" /><div OnClick="AddToList()" id="ok" class="ok"></div>
				</div>
				</span>
				
				
				</div>
			</td>
			
			
			</tr>
			
			<tr style="height: 0px"><td style="height: 0px" valign="bottom">
			
			<div class="arh_sort" style="width: 578px; padding-top: 1px;"><div class="arh"></div> 
				<div class="goto" id="goto" OnCLick="GetArh()"></div>
				<div style="float: right">
					<select name="type" id="type">
						<option value="0">Новости</option>
						<option value="1">Статьи</option>
						<option value="-1">Все</option>
					</select>
					
					<select name="month" id="month" >
						<option value="0">Все</option>
						<option value="1">Январь</option>
						<option value="2">Февраль</option>
						<option value="3">Март</option>
						<option value="4">Апрель</option>
						<option value="5">Май</option>
						<option value="6">Июнь</option>
						<option value="7">Июль</option>
						<option value="8">Август</option>
						<option value="9">Сентябрь</option>
						<option value="10">Октябрь</option>
						<option value="11">Ноябрь</option>
						<option value="12">Декабрь</option>
					</select>
					
					<select name="year" id="year">
					<option value="0">Все</option>
					<?php
					
						$years = $NEW->ReadYears();
						foreach ($years as $row) {
							
							echo '<option value="'.$row.'">'.$row.'</option>';
						}
					?>
					</select>
					
				</div>
			</div> </td></tr></table>
			</td>
			
			
			</tr></table>
		</div>
	</div>