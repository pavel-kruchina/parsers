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
<?php 
						$town_id = (int)$Global['Url.Page'][1];
						
						$TOWN->ReadOneObject($town_id);
						
						if (!$TOWN->Object) $TOWN->Object = array();
						
						$Vars = array_merge($TOWN->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
						
						$region_id = $Vars['region_id'];
					
						if ($TOWN->Object['town_id']) {
							
							$region_id = $TOWN->Object['region_id'];
						}
						
						if ($region_id) {
							
							$TOWN->ReadAll($region_id);
						}
						$REGION->ReadAll();
						//$TOWN->ReadAll();
						
						$sajax_request_type = "POST";
						$sajax_remote_uri = $Global['Host'].'/ajax.php';
						sajax_init();
						sajax_export("get_towns");
						sajax_handle_client_request();	
						
					?>
					
					<script>
					<?php 
						sajax_show_javascript();
					?>
					
					function response(data) {
						
						document.getElementById("towns").innerHTML = data;
						if (data=="Выбирете регион") {
							document.getElementById("forma").style.display='none';
						} else {
							document.getElementById("forma").style.display='block';
						}
					}
					
					function get_towns() {
						document.getElementById("forma").style.display='none';
						document.getElementById("towns").innerHTML = "Загружается. Подождите...";
						x_get_towns(document.getElementById("region").value,response);
					}
					</script>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<select id = "region" name="region_id" OnChange="get_towns()">
					<option value=0> Выбирете регион</option>
					<?php
					foreach ($REGION->Objects as $row) { 
						$selected = ($region_id==$row['region_id'])?"selected":"";
						
						echo '<option value='.$row['region_id'].' '.$selected.'>'.$row['region_name'].'</option>';
						
					}
					
					?>
					</select>
					
					<h1>Города</h1>
					
					
					
					<div id="towns" class="links_overflow">
					<?php if ($region_id) {?>
					<a href="<?php echo $Global['Host']; ?>/edit_towns?region_id=<?php echo $region_id?>">Добавить</a><br /><br />
					<?php 
					if ($TOWN->Objects)
					foreach ($TOWN->Objects as $town){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_towns/<?php echo $town['town_id']; ?>"><?php echo $town['town_name'];?></a><br />	
					<?php }?>
					<?php }else echo 'Выберите регион'?>
					</div>
					
					
					<div id = "forma" style="display: <?php echo ($region_id)?'block':'none'; ?>">
					<input type="hidden" name="town_id" value="<?php echo $town_id;?>" />
					<input type="hidden" name="sender" value="edit_towns" />
					<table>
					
					<tr><td class="form_caption">
							<?php $TOWN->ShowUserError("Город:", 'town_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="town_name" value="<?php echo $Vars['town_name'];?>" />
						</td>
					</tr>
										
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($town_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</div>
					</form>
</div>