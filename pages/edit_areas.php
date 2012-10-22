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
						
						$area_id = (int)$Global['Url.Page'][1];
						$AREA->ReadOneObject($area_id);
						
						if (!$AREA->Object) $AREA->Object = array();
						$Vars = array_merge($AREA->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);

						$town_id = $Vars['town_id'];
						if ($AREA->Object['town_id']) {
							
							$town_id = $AREA->Object['town_id'];
						}
						if ($town_id) {
							
							$AREA->ReadAll($town_id);
							
							$TOWN->ReadOneObject($town_id);
							if (!$TOWN->Object) $TOWN->Object = array();
							
							$region_id = $Vars['region_id'];
							if ($TOWN->Object['town_id']) {
								
								$region_id = $TOWN->Object['region_id'];
							}
			
							if ($region_id) {
								
								$TOWN->ReadAll($region_id);
							}
						}
						
						$REGION->ReadAll();
						
						
						$sajax_request_type = "POST";
						$sajax_remote_uri = $Global['Host'].'/ajax.php';
						sajax_init();
						sajax_export("get_atowns", "get_areas");
						sajax_handle_client_request();	
						
					?>
					
					<script>
					<?php 
						sajax_show_javascript();
					?>
					
					function tresponse(data) {
						
						document.getElementById("towns").innerHTML = data;
						
					}
					
					function get_atowns() {
						document.getElementById("forma").style.display='none';
						document.getElementById("forma").style.display='none';
						document.getElementById("areas").innerHTML = "Выберите город";
						
						document.getElementById("towns").innerHTML = "Загружается. Подождите...";
						x_get_atowns(document.getElementById("region").value,tresponse);
						
					}
					
					function response(data) {
						
						document.getElementById("areas").innerHTML = data;
						if (data=="Выберите город") {
							document.getElementById("forma").style.display='none';
						} else {
							document.getElementById("forma").style.display='block';
						}
					}
					
					function get_areas() {
						document.getElementById("forma").style.display='none';
						document.getElementById("areas").innerHTML = "Загружается. Подождите...";
						x_get_areas(document.getElementById("town").value,response);
					}
					
					</script>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					
					<select id = "region" OnChange="get_atowns()">
					<option value=0> Выберите регион</option>
					<?php
					foreach ($REGION->Objects as $row) { 
						$selected = ($region_id==$row['region_id'])?"selected":"";
						
						echo '<option value='.$row['region_id'].' '.$selected.'>'.$row['region_name'].'</option>';
						
					}
					
					?>
					</select>
					
					<div id="towns">
					<select id = "town" name="town_id" OnChange="get_areas()">
					<?php if ($TOWN->Objects) {?>
						<option value=0> Выберите город</option>
						<?php
						foreach ($TOWN->Objects as $row) { 
							$selected = ($town_id==$row['town_id'])?"selected":"";
							
							echo '<option value='.$row['town_id'].' '.$selected.'>'.$row['town_name'].'</option>';
							
						}
					
					} else echo '<option value=0> Выбирете регион</option>';?>
					</select>
					</div>
					
					<h1>Районы</h1>
					
					
					
					<div id="areas" class="links_overflow">
					<?php if ($town_id) {?>
					<a href="<?php echo $Global['Host']; ?>/edit_areas?town_id=<?php echo $town_id?>">Добавить</a><br /><br />
					<?php 
					
					if ($AREA->Objects)
					foreach ($AREA->Objects as $area){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_areas/<?php echo $area['area_id']; ?>"><?php echo $area['area_name'];?></a><br />	
					<?php }?>
					<?php }else echo 'Выберите город'?>
					</div>
					
					
					<div id = "forma" style="display: <?php echo ($town_id)?'block':'none'; ?>">
					<input type="hidden" name="area_id" value="<?php echo $area_id;?>" />
					<input type="hidden" name="sender" value="edit_areas" />
					<table>
					
					<tr><td class="form_caption">
							<?php $TOWN->ShowUserError("Район:", 'area_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="area_name" value="<?php echo $Vars['area_name'];?>" />
						</td>
					</tr>
										
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($area_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</div>
					</form>
</div>