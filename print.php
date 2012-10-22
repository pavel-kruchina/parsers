<?php
error_reporting(0);
session_start();

$User = $_SESSION['User'];

include('place_settings.cfg');
include('settings.cfg');
//--------------

include('libs/_error.php');

include('libs/_db.php');
$DB = new DataBase();

include ('libs/_menu.php');
$MENU = new Menu($DB);

include('libs/pages.php');
$PAGE = new Page($DB);

include('libs/_user.php');
$USER = new User($DB);

include('libs/sections.php');
$SECTION = new Section($DB);

include ('fckeditor/fckeditor_php4.php');

include ('libs/tnews.php');
$NEW = new News($DB);

include ('libs/town.php');
$TOWN = new Town($DB);

include ('libs/region.php');
$REGION = new Region($DB);

include ('libs/area.php');
$AREA = new Area($DB);

include ('libs/models.php');
$MODEL = new Model($DB);

include ('libs/products.php');
$PRODUCT = new Product($DB);

include ('libs/talarm.php');
$ALARM = new Alarm($DB);

include ('libs/cat.php');
$CAT = new Cat($DB);

include ('libs/class.php');
$CLASS = new OClass($DB);

include ('libs/object.php');
$OBJECT = new Obj($DB);

include ('libs/curency.php');
$CARENCY = new Carency($DB);

include ('libs/spetial.php');
$SPETIAL = new Spetial($DB);

include ('libs/baners.php');
$BANER = new Baner($DB);

include ('libs/functions.php');
include ('libs/Sajax.php');
include ('libs/timage.php');
$IMAGE = new ImageResizer($DB);

$object_id = $HTTP_GET_VARS['es_id'];
$OBJECT->ReadOneObject((int)$object_id);

if ($OBJECT->Object['object_coor']) {
							$tmp = explode('(',$OBJECT->Object['object_coor']);
							$tmp = explode(')',$tmp[1]);
							$tmp = explode(',', $tmp[0]);
							$sh = trim($tmp[0]);
							$d = trim($tmp[1]);
						}
						
echo'<?xml version="1.0" encoding="Windows-1251"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> версия для печати </title>
  <meta name="generator" content="editplus" />
  <meta name="author" content="" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <link href="<?php echo $Global['Host']?>/css/style.css" rel="stylesheet" type="text/css" />
  <style>
	.tdprint {border-bottom: solid 8px #ccc;}
	td {padding: 20px 0 20px 0;}
  </style>
   <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAiW4IuP-4j7XnVtv90vs4nxQ8twITan6xdYx-PO4oXX2izT5kbRS5Gi8f1SxdHpicL1I8SjK8TjEDbQ"
      type="text/javascript"></script>	
    <script type="text/javascript">

	
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
 </head>

 <body onload="initialize();" onunload="GUnload()">
  <center>
  <table width="800px" border="0" cellpadding="5" cellspacing="">
	<tr>
		<td width="600px" class="tdprint" align="left"><a href=""><img src="<?php echo $Global['Host']?>/css/images/logo_print.gif" width="332" height="83" alt="" /></a></td>
		<td width="200px" class="tdprint">
			<div id="phone">
				<div class="left"></div>
				<div class="right">Наш телефон<br /><?php echo getPhone();?></div>
				<div class="clearfloat">&nbsp;</div>
			</div>
		</td>
	</tr>
	<tr>
		<td valign="top" align="left" colspan="2">
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
 
		</td>
	</tr>
  </table>
  </center>
 </body>
</html>