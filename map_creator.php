<?php
error_reporting(E_ERROR | E_PARSE);

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

include ('libs/cat.php');
$CAT = new Cat($DB);

include ('libs/subcats.php');
$SUBCAT = new SubCat($DB);

include ('libs/good.php');
$GOOD = new Good($DB);

include ('libs/mats.php');
$MAT = new Mat($DB);

include ('libs/koefs.php');
$KOEF = new Koef($DB);

include ('libs/talarm.php');
$ALARM = new Alarm($DB);

include ('libs/basket.php');
$BASKET = new Basket($DB);

include ('libs/spetial.php');
$SPETIAL = new Spetial($DB);

include ('libs/groups.php');
$GROUP = new Group($DB);

include ('libs/functions.php');
include ('libs/Sajax.php');
include ('libs/timage.php');
$IMAGE = new ImageResizer($DB);

$res = '<?xml version="1.0" encoding="Windows-1251"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
 
 <head>
 <script type="text/javascript" src="'.$Global['Host'].'/ckeditor/ckeditor.js"></script
 <meta name=\'yandex-verification\' content=\'588934ed680a6009\' />  
 <meta name="verify-v1" content="TU1iL1W3ejnYuZU1Le/r4D/CtZ6CinQDHmQQnLvcHLo=" />
 <link rel="icon" href="'.$Global['Host'].'/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="'.$Global['Host'].'/favicon.ico" type="image/x-icon"> 
 <title>'.(ShowHeader()).'</title>
   <meta name="keywords" content="'.(getSEO()).'">
  <meta name="description" content="<?php echo ShowDesc();?>" />
	<meta name=""author"" content=""Древаль Максим Алексеевич"">
  <script src = "'.$Global['Host'].'/java/java.js"></script>
 <link href="'.$Global['Host'].'/css/style.css" rel="stylesheet" type="text/css" />			   
 </head>
<!--[if IE 6]>
<style>
div.main {
	
	width: 908px;
	padding: 0px;
	background: green;
}
</style>
<![endif]-->

 <BODY >
 
	<table class="maintab" cellpadding = 0 cellspacing=0>
	<tr valign=center><td class="main" align=center>
	
	<div class=main>
		<div class="head">
			<a href="'.$Global['Host'].'"><div class="logo"></div></a>
			
			<div class="lngis">
				
				<div class="lng"> <div class="rus"></div> <div class="eng"></div> </div>
				<div class="search"><input name=search_string /> <div class="searchb"></div> </div>
			</div>
			
			<div class=rh>
				<div class="telcap"></div> <div class="tel"><b>'.(getPhone()).'</b></div>
				
			</div>
			
		</div>
		<div class="menu">
			
			<b>
			<a style="color: #333333" href="'.$Global['Host'].'/catalog"><div class="but_pr"></div></a>
			<div class="ms"></div>
			<a style="color: #333333" href="'.$Global['Host'].'/main/mat"><div class="but_mat" >
				</div></a>
			<div class="ms"></div>
			<a style="color: #333333" href="'.$Global['Host'].'/news"><div class="but_new" ></div></a>
			<div class="ms"></div>
			<a style="color: #333333" href="'.$Global['Host'].'/gallery"><div class="but_gal" ></div></a>
			<div class="ms"></div>
			<a style="color: #333333" href="'.$Global['Host'].'/main/cond"><div class="but_cond" ></div></a>
			<div class="ms"></div>
			<a style="color: #333333" href="'.$Global['Host'].'/otziv"><div class="but_otz"  ></div></a>
			<div class="ms"></div>
			<a style="color: #333333" href="'.$Global['Host'].'/contacts"><div class="but_cont"  ></div></a>
			</b>
		</div>
		
	';
	
	$res.='
	
		<div class="bigmenu">
			<div class="productbox">
				<div class="arrowup" onClick="Up();"></div>
				<div class="box"><div id="lenta" style="position: relative;">'.($CAT->eGetCats()).'</div></div>
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
			
			<div class="flash">'.(showFlash()).'</div>
		</div>
		
		<div  class="content">
			<table cellspacing=0 cellpadding=0 width="100%"><tr valign="top"><td >	
			<div class="article" >
			<div style="float: left; width: 0px; height: 300px"></div>
			<h1>Карта сайта</h1>
				';
	
	$i=1;
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'">Главная</a></div>'; $i++;
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/catalog">Продукция</a>'; 
		$CAT->ReadAll(); 
		$j = 1;
		foreach ($CAT->Objects as $row) {
			
			$res.= '<div class="map_item">'.$i.'.'.$j.'. '.$row['cat_name']; 
			$SUBCAT->ReadAll($row['cat_id']);
			$k=1;
			foreach ($SUBCAT->Objects as $sc) {
				
				$res.= '<div class="map_item">'.$i.'.'.$j.'.'.$k.'. <a href="'.$Global['Host'].'/catalog/'.$sc['sc_url'].'">'.$sc['sc_name'].'</a>'; 
				$GOOD->ReadAll($sc['sc_id']);
				$c = 1;
				foreach ($GOOD->Objects as $good) {
					
					$res.= '<div class="map_item">'.$i.'.'.$j.'.'.$k.'.'.$c.'. <a href="'.$Global['Host'].'/catalog/'.$sc['sc_url'].'/'.$good['good_url'].'">'.$good['good_name'].'</a></div>'; $c++;
				}
				$k++;
				$res.= '</div>';	
			}
			$j++;
			$res.= '</div>';
		}
	$i++;
	$res.= '</div>';
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/main/mat">Материалы</a></div>'; $i++;
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/news">Новости</a>';
		$NEW->ReadAll();
		$j = 1;
		foreach ($NEW->Objects as $row) {
			
			$res.= '<div class="map_item">'.$i.'.'.$j.'. <a href="'.$Global['Host'].'/news/'.$row['new_id'].'">'.$row['new_prew'].'</a></div>'; 
		}
	$res.= '</div>';
	$i++;
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/galery">Галерея</a></div>'; $i++; 
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/main/cond">Партнёрам</a></div>'; $i++; 
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/otzivy">Отзывы</a></div>'; $i++; 
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/contacts">Контакты</a></div>'; $i++;
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/galery">Галерея</a></div>'; $i++; 
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/main/vac">Вакансии</a></div>'; $i++; 	
	$res.= '<div class="map_item">'.$i.'. <a href="'.$Global['Host'].'/main/project_manager">Project manager</a></div>'; $i++; 	
	
	$res.=
				'
			</div>
			<td>
			<td class="news">
				<div class="news">
				<div class="new_cap"></div><br />
				'.($NEW->eShowLastNews(2)).'
				<div class="mailing">
					<div style="padding-bottom:2px">Подписаться на рассылку: </div>
					<input style="color: #d9d9d9" name="mail" value="Ваш e-mail" OnFocus="FirstEmailClick(this)" /><div class="ok"></div>
				</div>
				</div>
			</td>
			</tr></table>
		</div>
	</div>
	';
	
	
	
	$res .= '
	</td>
	</tr>
	<tr valign=center><td class="footer" align=center>
	
		<div class="main" style="height: 50px">
			<div class="copy">
				<a style="color: #888888" href="'.$Global['Host'].'/" >GALKOM</a> ® All Rights Reserved 2009<br />
				<div class="webe"><a target="_blank" style="color: black" title="Разработка, продвижение, поддержка сайтов" href="http://webengineer.com.ua"><b>Web</b>Engineer.com.ua</a>
				<br />
				<span style="color: black">Project manager - </span><a target="_blank" style="color: black" href="'.$Global['Host'].'/main/project_manager" title="Менеджер проектов - Максим Древаль"><b>Max D\' Reval</b></a>
				
				</div>
				
			</div>
			
			<div class="dopmenu">
				<a style="color: #888888" href="'.$Global['Host'].'/catalog">Продукция</a> | 
				<a style="color: #888888" href="'.$Global['Host'].'/main/mat">Материалы</a> | 
				
				<a style="color: #888888" href="'.$Global['Host'].'/news">Новости</a> | 
				<a style="color: #888888" href="'.$Global['Host'].'/galery">Галерея</a> | 
				<a style="color: #888888" href="'.$Global['Host'].'/main/cond">Партнерам</a> | 
				<a style="color: #888888" href="'.$Global['Host'].'/">Отзывы</a> | 
				<a style="color: #888888" href="'.$Global['Host'].'/contacts">Контакты</a> | 
				<a style="color: #888888" href="'.$Global['Host'].'/main/vac">Вакансии</a>

		
		<div style="float: right; padding-top:7px; padding-right: 4px;">
		<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href=\'http://www.liveinternet.ru/click\' "+
"target=_blank><img src=\'http://counter.yadro.ru/hit?t57.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+";"+Math.random()+
"\' alt=\'\' title=\'LiveInternet\' "+
"border=\'0\' width=\'88\' height=\'31\'><\/a>")
//--></script><!--/LiveInternet-->
		</div>
		
		<div style="float: right; padding-top:7px; padding-right: 4px;">	<!-- begin of Top100 logo -->
<a href="http://top100.rambler.ru/home?id=1870394" target="_blank"><img src="http://top100-images.rambler.ru/top100/banner-88x31-rambler-brown2.gif" alt="Rambler\'s Top100" width="88" height="31" border="0" /></a>
<!-- end of Top100 logo --></div>



			</div>
		</div>
	
	</td>
	
	</tr>
	</table>
<div id="uplayer" class="uplayer">
</div>
</div>


 </body>
</html>
';

file_put_contents('site_map.html', $res);

?>

