
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
			
			<div class="otziv"></div><br />
			
		
			
<?php

$temp = $DB->ReadAss('SELECT * from recall  ORDER BY recall_id DESC LIMIT 4');
if ($temp) {

	global $User;
	global $USER;

	foreach ($temp as $row) {
		if (($USER->CheckRights('adm_comment', $User) || $row['recall_adm'])) {
			echo '<div class="separator"></div>';
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

?>			
			<br />
			<a href="#" onClick="GetOnLayer('otziv');"><b>Добавить отзыв</b></a>
			
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
<script>	
	<?php 
		if (count($Errors)) {
			
			foreach ($Errors as $row) {
				
				echo "alert('$row'); ";
			}
		}
	?>
</script>