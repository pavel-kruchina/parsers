
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
			<table cellspacing=0 cellpadding=0 width="100%"><tr valign="top"><td style="width: 611px">	
			
			<div style="padding-top: 14px; padding-left: 17px; float: left; width: 250px">
				<div class="newski"></div>
				<div>
					<?php 
					$User['koef'] = $User['koef']?$User['koef']:1;
					global $GOOD; 
					$GOOD->ReadNewski(2);
					foreach ($GOOD->Objects as $row) {
			
						$foto = $DB->ReadScalar('Select photo_id from o_photos where good_id='.$row['good_id'].' Order By photo_id limit 1');
						$price = 0;
						$price = $DB->ReadScalar('Select matprice from mat_price where good_id='.$row['good_id'].' AND mat_id=8 Order By matprice limit 1');
						
						if (!$price)
							$price = $DB->ReadScalar('Select matprice from mat_price where good_id='.$row['good_id'].' AND matprice Order By matprice limit 1');
						
						$price = (int)($price*$User['koef']);
						$foto = (int) $foto;
						$sc_url = $DB->ReadScalar("Select sc_url from subcat where sc_id={$row['sc_id']}");
						echo '
						<div style="width: 250px; height: 100px;">
						<div class="newski_image">
						<a href = "'.$Global['Host'].'/catalog/'.$sc_url.'/'.$row['good_url'].'"><img src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$foto.'.jpg"></a>
						</div>
						<div class="newski_text"><div style="height: 50px; width: 150px"><b style="color:#40709f">'.$row['good_name'].'</b>
						<br /><span class=grey><b>#'.$row['good_art'].'</b></span></div>
						
						<span class="price"><b>'.ReturnPrice($price).'</b></span>
						</div>
						</div>
						';
					}
					
					?>
					<div class="short_main"></div>
					<?php echo getShort();?>
					<div style="float: right"><a href="<?php echo $Global['Host']?>/about">Подробнее</a></div>
				</div>
			</div>
			
			<div class="article" style="width: 290px; float: right; margin-right: 8px; padding-right: 8px">
				<div style="width: 0px; height: 700px; float: left;"></div>
				<div class="bestcellers"></div>
				<div>
					<?php 
					$GOOD->ReadBestCellers(2);
					foreach ($GOOD->Objects as $row) {
			
						$foto = $DB->ReadScalar('Select photo_id from o_photos where good_id='.$row['good_id'].' Order By photo_id limit 1');
						$price = 0;
						$price = $DB->ReadScalar('Select matprice from mat_price where good_id='.$row['good_id'].' AND mat_id=8 Order By matprice limit 1');
						
						if (!$price)
							$price = $DB->ReadScalar('Select matprice from mat_price where good_id='.$row['good_id'].' AND matprice Order By matprice limit 1');
						
						$price = (int)($price*$User['koef']);
						$foto = (int) $foto;
						$sc_url = $DB->ReadScalar("Select sc_url from subcat where sc_id={$row['sc_id']}");
						echo '
						<div style="width: 270px; height: 100px;">
						<div class="newski_image" style="padding-left: 0px;">
						<a href = "'.$Global['Host'].'/catalog/'.$sc_url.'/'.$row['good_url'].'"><img src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$foto.'.jpg"></a>
						</div>
						<div class="newski_text"><div style="height: 50px; width: 170px"><b style="color:#40709f">'.$row['good_name'].'</b>
						<br /><span class=grey><b>#'.$row['good_art'].'</b></span></div>
						
						<span class="price"><b>'.ReturnPrice($price).'</b></span>
						</div>
						</div>
						';
					}
					
					?>
				</div>
				
				<div class="last_otzivs"></div>
				<?php
$temp = $DB->ReadAss('SELECT * from recall  ORDER BY recall_id DESC limit 2');
if ($temp) {

	global $User;
	global $USER;

	foreach ($temp as $row) {
		if (($USER->CheckRights('adm_comment', $User) || $row['recall_adm'])) {
			echo '<div class="separator" style="width:280px" ></div>';
			echo "<b><span style='color: #6689a9'>{$row['recall_name']}</span></b><br />";
			echo $row['recall_text'];
		}
		if ($USER->CheckRights('delete_comment', $User)) {
			echo '<form class="edition_form" action="" method="post" enctype="multipart/form-data">';
			echo '<input type="hidden" name="sender" value="delete_comment" />';
			echo '<input type="hidden" name="recall_id" value="'.$row['recall_id'].'" />';
			echo '<input class="button" type="submit" name="delete" value="Удалить">';
			echo '</form>';
		}
		
		if ($USER->CheckRights('delete_comment', $User) && !$row['recall_adm']) {
			echo '<form class="edition_form" action="" method="post" enctype="multipart/form-data">';
			echo '<input type="hidden" name="sender" value="adm_comment" />';
			echo '<input type="hidden" name="recall_id" value="'.$row['recall_id'].'" />';
			echo '<input class="button" type="submit" name="delete" value="Допустить">';
			echo '</form>';
		}
		if (($USER->CheckRights('adm_comment', $User) || $row['recall_adm'])) {
			echo '<br />';
			echo '<br />';
		}
	}
}

	echo '<div style="float: right"><a href="'.$Global['Host'].'/otziv">Все отзывы</a></div>'
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