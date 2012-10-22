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
						
						$object_id = (int)$Global['Url.Page'][1];;
						$OBJECT->ReadOneObject($object_id);
						
						if (!$OBJECT->Object) $OBJECT->Object = array();
						$Vars = array_merge($OBJECT->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
						
						$area_id = (int)$Vars['area_id'];
						if ($OBJECT->Object['area_id']) {
							
							$area_id = $OBJECT->Object['area_id'];
						}
						
						if ($area_id) {
							
							$OBJECT->ReadAll($area_id);
							$AREA->ReadOneObject($area_id);
							
							$town_id = $AREA->Object['town_id'];
							
							
							$AREA->ReadAll($town_id);
							
							$TOWN->ReadOneObject($town_id);
							if (!$TOWN->Object) $TOWN->Object = array();
							
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
						sajax_export("get_otowns", "get_oareas", "get_objects", "get_classes", "get_options");
						sajax_handle_client_request();	
						
					?>
					
					<script>
					<?php 
						sajax_show_javascript();
						
						if ($Vars['object_coor']) {
							$tmp = explode('(',$Vars['object_coor']);
							$tmp = explode(')',$tmp[1]);
							$tmp = explode(',', $tmp[0]);
							$sh = trim($tmp[0]);
							$d = trim($tmp[1]);
						}
					?>
					 var map ;
					var label;
					var lg;
					function zoomChange() {
						map.setZoom(parseInt(document.getElementById("zoom").value));
						
					}
					
					function lgChange() {
						var s = String(document.getElementById('coor').value);
						var ar = s.split('(');
						s = ar[1];
						ar = s.split(')');
						s = ar[0];
						ar = s.split(', ');
						
						var myHtml;
						var latlng = new GLatLng(parseFloat(ar[0]), parseFloat(ar[1]));
						if (document.getElementById('label').value) myHtml = document.getElementById('label').value;
						else myHtml = "The GPoint value is: " + map.fromLatLngToDivPixel(latlng) + " at zoom level " + map.getZoom();
						
						map.openInfoWindow(latlng, myHtml);
						
						//lg = getElementById(coor);
					}
					
					function initialize() {
				      if (GBrowserIsCompatible()) {
				        map = new GMap2(document.getElementById("map_canvas"));
				        var lg = new GLatLng(<?php echo ($sh?$sh:55.751656176679255); ?>, <?php echo ($d?$d:37.61770248413086); ?>);
						map.setCenter(lg, <?php echo $Vars['object_zoom']?$Vars['object_zoom']:10; ?>);
						<? if ($Vars['object_zoom'] && $sh && $d && $Vars['object_label']) echo 'map.openInfoWindow(lg, "'.addslashes($Vars['object_label']).'");' ?>
						
				        GEvent.addListener(map, "click", function(overlay,latlng) {
				          if (latlng) {
				 			var myHtml;
							
							if (document.getElementById('label').value) myHtml = document.getElementById('label').value;
							else myHtml = "The GPoint value is: " + map.fromLatLngToDivPixel(latlng) + " at zoom level " + map.getZoom();
				            map.openInfoWindow(latlng, myHtml);
							document.getElementById("zoom").value = map.getZoom();
							document.getElementById("coor").value = latlng;
				          }
				        });
				        map.addControl(new GSmallMapControl());
				        map.addControl(new GMapTypeControl());
				      }
						document.getElementById("forma").style.display="<?php echo ($area_id)?'block':'none'; ?>";
				    }

					
					function tresponse(data) {
						
						document.getElementById("towns").innerHTML = data;
						
					}
					
					function get_atowns() {
						document.getElementById("forma").style.display='none';
						document.getElementById("areas").innerHTML = "Выберите город";
						document.getElementById("objects").innerHTML = "Выберите район";
						
						document.getElementById("towns").innerHTML = "Загружается. Подождите...";
						x_get_otowns(document.getElementById("region").value,tresponse);
						
					}
					
					function aresponse(data) {
						
						document.getElementById("areas").innerHTML = data;
						
					}
					
					function get_oareas() {
						document.getElementById("forma").style.display='none';
						document.getElementById("objects").innerHTML = "Выберите район";
						
						document.getElementById("areas").innerHTML = "Загружается. Подождите...";
						x_get_oareas(document.getElementById("town").value,aresponse);
						
					}
					
					function response(data) {
						
						document.getElementById("objects").innerHTML = data;
						if (data=="Выберите район") {
							document.getElementById("forma").style.display='none';
						} else {
							document.getElementById("forma").style.display='block';
						}
					}
					
					function get_objects() {
						document.getElementById("forma").style.display='none';
						document.getElementById("objects").innerHTML = "Загружается. Подождите...";
						x_get_objects(document.getElementById("area").value,response);
					}
					
					function go_response(data) {
						
						document.getElementById("options").innerHTML = data; 
					}
					
					
					function GetOptions() {
						
						x_get_options(document.getElementById("classes").value, <?php echo $object_id?>, go_response);
						document.getElementById("options").innerHTML = "Загружаю опции";
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
					<select id = "town" OnChange="get_oareas()">
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
					
					<div id="areas">
					<select id = "area" name="area_id" OnChange="get_objects()">
					<?php if ($AREA->Objects) {?>
						<option value=0> Выберите район</option>
						<?php
						foreach ($AREA->Objects as $row) { 
							$selected = ($area_id==$row['area_id'])?"selected":"";
							
							echo '<option value='.$row['area_id'].' '.$selected.'>'.$row['area_name'].'</option>';
							
						}
					
					} else echo '<option value=0> Выбирете город</option>';?>
					</select>
					</div>
					
					<h1>Объекты</h1>
					
					
					
					<div id="objects" class="links_overflow">
					<?php if ($area_id) {?>
					<a href="<?php echo $Global['Host']; ?>/edit_objects?area_id=<?php echo $area_id?>">Добавить</a><br /><br />
					<?php 
					
					if ($OBJECT->Objects)
					foreach ($OBJECT->Objects as $object){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_objects/<?php echo $object['object_id']; ?>"><?php echo $object['object_name'];?></a><br />	
					<?php }?>
					<?php }else echo 'Выберите Район'?>
					</div>
					
					
					<div id = "forma" >
					<input type="hidden" name="object_id" value="<?php echo $object_id;?>" />
					<input type="hidden" name="sender" value="edit_objects" />
					<table valign="top" width="100%">
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("Название обьекта:", 'object_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="object_name" value="<?php echo $Vars['object_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("Адрес обьекта:", 'object_adress');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="object_adress" value="<?php echo $Vars['object_adress'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("цена обьекта (в рублях):", 'object_price');?>
						</td>
						<td class="form_input">
						<input maxlength="15" name="object_price" value="<?php echo $Vars['object_price'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("Статус:", 'object_status');?>
						</td>
						<td class="form_input">
						<select name = "object_status"><option value = 0>Свободен</option> <option <?php echo ($Vars['object_status'])?'selected':'';?> value = 1>Занят</option> </select>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("Категория:", 'cat_id');?>
						</td>
						<td class="form_input">
						<select name = "cat_id">
						
							<?php 
							$CAT->ReadAll();
							foreach ($CAT->Objects as $row) {
								
								$selected =  ($Vars['cat_id']==$row['cat_id'])?'selected':'';
								echo '<option '.$selected.' value='.$row['cat_id'].'>'.$row['cat_name'].'</option>';
							}
							?>
						</select>
						</td>
					</tr>
					
					<tr valign="top"><td class="form_caption">
							<?php $OBJECT->ShowUserError("Класс:", 'class_id');?>
						</td>
						<td class="form_input">
						<select id="classes" name = "class_id" OnChange = "GetOptions()">
						<option value=0>Выберите класс</option>
							<?php 
							$CLASS->ReadAll();
							foreach ($CLASS->Objects as $row) {
								
								$selected = ($Vars['class_id'] == $row['class_id'])?'selected':'';
								echo '<option '.$selected.' value='.$row['class_id'].'>'.$row['class_name'].'</option>';
							}
							?>
						</select>
						<br />
						<div id="options">
						<?php
							if ($Vars['class_id']) {
							
									$tmp  = $CLASS->DB->ReadAss('
									select 
										n_options.option_id, n_options.option_name, v_options.option_value 
									from 
										n_options 
									LEFT JOIN v_options on v_options.option_id = n_options.option_id AND v_options.object_id = '.$object_id.'
									WHERE n_options.class_id  = '.$Vars['class_id'].'  ORDER By n_options.option_name');
								
								foreach ($tmp as $row) {
									
									echo '<div style="width:200px; float: left; text-align:right">'.$row['option_name'].'</div><input name="options['.$row['option_id'].']" value="'.$row['option_value'].'"><br />';
								}
							}
						?>
						</div>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("Описание:", 'object_desc');?>
						</td>
					</tr>
					<tr>	
					<td class="form_input" colspan=2><?php  
						$EDITOR = new FCKeditor('object_desc');
						$EDITOR->Value = $Vars['object_desc'];
						$EDITOR->Width = '100%';
						$EDITOR->Height = '300px';
						$EDITOR->Create();
					?> </td></tr>
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("Фотографии:", 'photos');?>
						</td>
						<td class="form_input">
						<script>
						function AddPhoto() {
								document.getElementById("photo").innerHTML += '<input style="width: 200px" type="file" name="photos[]"><br/>';
							}
						</script>
						<button OnClick="AddPhoto(); return false;">Добавить фото</button>
						</td>
					</tr>
					
					
						<?
						if ($object_id>0) {
						
							$tmp = $DB->ReadAss('Select * FROM o_photos where object_id='.$object_id);
							foreach ($tmp as $row) {
								
								echo '<tr><td><img src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$row['photo_id'].'.jpg" ></td><td><input style="width: 200px" type="file" name="exphotos['.$row['photo_id'].']"><br />Удалить<input type="checkbox" value=1 name="delete'.$row['photo_id'].'"></td></tr>';
							}
						}
						?>
					<tr><td class="form_caption">
						</td><td class="form_input"><div id="photo">
						</div>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("Метка", 'object_label');?>
						</td>
						<td class="form_input">
						<input maxlength="255" id="label" name="object_label" value="<?php echo $Vars['object_label'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("Координаты", 'object_coor');?>
						</td>
						<td class="form_input">
						<input OnChange="lgChange();" id="coor" maxlength="50" name="object_coor" value="<?php echo $Vars['object_coor'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $OBJECT->ShowUserError("Зум", 'object_zoom');?>
						</td>
						<td class="form_input">
						<input OnChange="zoomChange();" id ="zoom" maxlength="50" name="object_zoom" value="<?php echo $Vars['object_zoom'];?>" />
						</td>
					</tr>
					
					<tr>
						<td  colspan=2>
						<div id="map_canvas" style="width: 800px; height: 600px"></div>
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($object_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</div>
					</form>
</div>