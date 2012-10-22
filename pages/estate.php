<?php 
$return_path = $HTTP_POST_VARS['return_path'];

$object_id = (int)$Global['Url.Page'][1];
if (!$object_id) $DB->Go($Global['Host']);
$OBJECT->ReadOneObject($object_id);

if (!$OBJECT->Object['object_id']) $DB->Go($Global['Host']);

if ($OBJECT->Object['object_coor']) {
							$tmp = explode('(',$OBJECT->Object['object_coor']);
							$tmp = explode(')',$tmp[1]);
							$tmp = explode(',', $tmp[0]);
							$sh = trim($tmp[0]);
							$d = trim($tmp[1]);
						}


 ?>
  
  <script type="text/javascript" src="<?php echo $Global['Host']?>/java/jquery-1.2.6.min.js"></script>
  <script type="text/javascript" src="<?php echo $Global['Host']?>/java/map.js"></script>
  <script type="text/javascript">
	$(document).ready(function(){  

		$(".thumb a").hover(function(){
				var imgHref = $(this).attr('href');  //get the src of the thumbnail
				$(".thumb a").removeClass("selected");  //remove .selected class from all other links
				$(this).addClass("selected");  //add .selected class to current link
				$(".big").stop();
			$(".big").stop().fadeTo(700, 0, function() {  //fade image out
				$('.big').attr('src',imgHref);  //give new image a src attribute
				
			}).fadeTo("slow", 1);  //fade the image in
		},function(){    //for onmouseout not used here
		});		
		
	});
	
	function initialize() {
	  if (GBrowserIsCompatible()) {
		map = new GMap2(document.getElementById("map_canvas"));
		var lg = new GLatLng(<?php echo ($sh?$sh:55.751656176679255); ?>, <?php echo ($d?$d:37.61770248413086); ?>);
		map.setCenter(lg, <?php echo $OBJECT->Object['object_zoom']?$OBJECT->Object['object_zoom']:10; ?>);
		<? if ($OBJECT->Object['object_zoom'] && $sh && $d && $OBJECT->Object['object_label']) echo 'map.openInfoWindow(lg, "'.addslashes($OBJECT->Object['object_label']).'");' ?>
		
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
	  }
		
	}

  </script>
 <div id="menu" align="right">
	<ul>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>">Главная</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/news">Новости</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/about">О компании</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/contacts">Контакты</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/help">Справка</a></li>
		<li  class="active"><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/search">Поиск</a></li>
	</ul>
 </div>

 <div id="line_after_menu_left"></div>
 <div id="line_after_menu_right"></div>
 <div id="line_after_menu_bg"></div>
 <div id="line_after_menu_ln"></div>

 <div id="left">
 
	<div id="breadcrums">
		<a href="<?php echo $Global['Host'] ?>/search">Поиск</a><?php echo  GetSearchPathByID($object_id)?>
	</div>

	<div id="object">
		<div id="obj_top">
			<div class="gallery" align="center">
				
				<?php $tmp = $DB->ReadAss('select photo_id from o_photos where object_id ='. $object_id);?>
				<img width = 300 height = 222 src="<?php echo $Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$tmp[0]['photo_id'].'.jpg' ?>" alt="" class="big" />  <br /><br />  
				
				<ul class="thumb">
				
				<?php 

				foreach ($tmp as $row ) {
					
					echo '<li><a target=blank href="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$row['photo_id'].'.jpg"><img width = 96 height =72 src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$row[photo_id].'.jpg" alt="" /></a></li>';
				}
				
				?>
				
					
				</ul>
			</div>
			<div class="parametr">
				<p>
					<?php
					
					echo '<h1>'.$OBJECT->Object['object_name'].'</h1>';
					
					$options = $DB->ReadAss('
						SELECT v_options.option_value, n_options.option_name 
						FROM v_options, n_options
						WHERE v_options.object_id='.$object_id.' AND n_options.option_id = v_options.option_id
						ORDER BY option_name
						');
					
					foreach ($options as $row) {
						echo $row['option_name'].': '.$row['option_value'].'<br />';
					}
					
					echo '<h2>Статус: '.($OBJECT->Object['object_status']?'занято':'свободно').'</h2>';
					?>
					
				</p>
				<p>
					<h1>Стоимость</h1>
					<?php
					echo RangeMoney($OBJECT->Object['object_price']).' рублей<br />';
					$CARENCY->ReadAll();
					foreach ($CARENCY->Objects as $car) {
					
						echo RangeMoney($OBJECT->Object['object_price']/((double)$car['carency_value'])).' '.$car['carency_mv'].'<br />';
					}
					?> 
				</p>
				<p>
					<h1>Расположение</h1>
					<?php
					echo '
					Регион: '.$OBJECT->Object['region_name'].'<br />
					Город: '.$OBJECT->Object['town_name'].'<br />
					Район/шоссе: '.$OBJECT->Object['area_name'].'<br /><br />
					Адрес: '.$OBJECT->Object['object_adress'].'<br />';
					?>
				</p>

				<div id="pref_menu">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<?php if ($return_path) echo'<td width="30%" height="72px" align="center" valign="middle"><img src="'.$Global['Host'].'/css/images/prev.gif" width="9" height="9" alt="" /><br /><a href="'.$return_path.'">Назад к списку</a></td> '; ?>
							<td width="30%" height="72px" align="center" valign="middle"><img src="<?php echo $Global['Host'] ?>/css/images/new_search.gif" width="10" height="10" alt="" /><br /><a href="'.$Global['Host'].'/search">Новый поиск</a></td>
							<td width="30%" height="72px" align="center" valign="middle"><img src="<?php echo $Global['Host'] ?>/css/images/print.gif" width="11" height="10" alt="" /><br /><a href="<?php echo $Global['Host'].'/'.'print.php?es_id='.$object_id; ?>">Версия для печати</a></td>
						</tr>
					</table>
				</div>

			</div>
			<div class="clearfloat"></div>
		</div>
		<div id="obj_dopinfo">
			<h1>Дополнительная информация</h1>
			<p><?php echo $OBJECT->Object['object_desc']?></p>
		</div>
		<div id="map_zag">Карта расположения объекта</div>
		<div id="map_canvas" style="width: 99%; height: 320px"></div>
	</div>
 
 </div>
