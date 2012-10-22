<?php
//error_reporting(0);

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

include ('libs/otzivs.php');
$OTZIV = new Otziv($DB);


include ('libs/gallery.php');
$GALLERY = new Gallery($DB);

include ('libs/functions.php');
include ('libs/Sajax.php');
include ('libs/timage.php');
$IMAGE = new ImageResizer($DB);

$Global['AdminMail'] = getMail();

$str = $HTTP_SERVER_VARS['REQUEST_URI'];
$str = explode('?', $str);
$str = $str[0];
if (!$str) {

} else {
	$Global['Url.Page'] = explode('/', substr($str,1)); 
}
if ($Global['Url.Page'][0]=='gallery') {
	header("Cache-Control: public");
	header("Expires: " . date("r", time() + 3600));
}

$sajax_request_type = "POST";
						$sajax_remote_uri = $Global['Host'].'/ajax.php';
						sajax_init();
						sajax_export("delete_spam", "add_to_spam", "send_pass", "feedback", "show_new", "get_arh", "delete_from_order", "reg", "login", "show_page", "save_count", "get_news", "get_cat", "get_subcats", "get_subcat", "get_goods", "get_good", "add_good", "delete_good");
						sajax_handle_client_request();	
				

echo'<?xml version="1.0" encoding="Windows-1251"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
 
 <head>
 <script type="text/javascript" src="<?php echo $Global['Host']?>/ckeditor/ckeditor.js"></script
 <meta name='yandex-verification' content='588934ed680a6009' />  
 <meta name="verify-v1" content="TU1iL1W3ejnYuZU1Le/r4D/CtZ6CinQDHmQQnLvcHLo=" />
 <link rel="icon" href="<?php echo $Global['Host']?>/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo $Global['Host']?>/favicon.ico" type="image/x-icon"> 
 <title><?php echo ShowHeader();?></title>
   <meta name="keywords" content="<?php echo getSEO()?>">
  <meta name="description" content="<?php echo ShowDesc();?>" />
	<meta name=""author"" content=""Древаль Максим Алексеевич"">
  <script src = "<? echo $Global['Host']?>/java/java.js"></script>
 <link href="<? echo $Global['Host']?>/css/style.css" rel="stylesheet" type="text/css" />			   
 </head>
<!--[if IE 6]>
<style>
div.main {
	
	width: 918px;
	padding: 0px;
	background: green;
}
</style>
<![endif]-->

<script>

function RespATL(data) {
	
	document.getElementById('ok').style.background = "URL('<?php echo $Global['Host']?>/css/images/ok.jpg') no-repeat top left";
	alert(data['info']);
}

function AddToList() {
	
	x_add_to_spam(document.getElementById('mail').value, RespATL);
	document.getElementById('ok').style.background = "URL('<?php echo $Global['Host']?>/css/images/serok.jpg') no-repeat top left";
}

function TryLogin() {
	
	document.getElementById('enter').style.background = "URL('<?php echo $Global['Host']?>/css/images/naenter.jpg') no-repeat top left";
	x_login(document.getElementById('login').value,document.getElementById('password').value, ResLogin);
}

function RespRegister(data) {
	
	if (data['succesful']) {
		alert (data['error']);
		CloseLayer();
	} else {
		alert (data['error']);
	}
}

function ResLogin(data) {
	
	document.getElementById('enter').style.background = "URL('<?php echo $Global['Host']?>/css/images/enter.jpg') no-repeat top left";
	if (data['succesful']) {
		document.location="<?php echo $Global['Host']?>/basket";
	} else {
		alert (data['error']);
	}
}

<?php 
						sajax_show_javascript();
					?>


</script>

 <BODY OnLoad ="prep()" OnResize="ResizeLayer()">
 
	<table class="maintab" cellpadding = 0 cellspacing=0>
	<tr valign=center><td class="main" align=center>
	<div class=main style="background: none; padding: 0px; border: 0px; height: 15px; padding-right: 5px">
	<a href="<?php echo $Global['Host'].'/site_map.html'?>"><div title="Карта сайта" class="topmap"></div></a>
	
	 <div  title="Обратная связь" OnClick="GetOnLayer('feedback')" class="topletter"></div>
	<a href="<?php echo $Global['Host']?>"> <div title="Главная" class="tophome"></div> </a>
	
	</div>
	<div class=main>
		<div style="text-align: left"><?php $MENU->ShowStaticMenu($AdminMenu, $Global['Right.Admin']); ?></div>
		<div class="head">
			<a href="<? echo $Global['Host']?>"><div class="logo"></div></a>
			
			<div class="lngis">
				
				<div class="lng">  <div class="rus"></div> <div class="eng"></div>  </div>
				<form action="<?php echo $Global['Host']?>/search" name="fsearch" method="GET">
				<div class="search"><input name=search_string value="<?php echo addslashes($HTTP_GET_VARS['search_string']) ?>" /> <div Onclick="fsearch.submit()" class="searchb"></div> </div></form>
			</div>
			
			<div class=rh>
				<div class="telcap"></div> <div class="tel"><b><?php echo getPhone()?></b></div>
				<div class="usmenu"><?php echo CreateUserMenu()?></div>
			</div>
			
		</div>
		<div class="menu">
			<b>
			<? if ($Global['Url.Page'][0]!="catalog") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/catalog'?>"><?php }?><div class="but_pr" <? if ($Global['Url.Page'][0]=="catalog") echo 'style="background-position: 0px -33px; cursor: default"'; ?>
				></div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][1]!="mat") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/main/mat'?>"><?php }?><div class="but_mat" <? if ($Global['Url.Page'][1]=="mat") echo 'style="background-position: 0px -33px; cursor: default"'; ?> >
				</div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][0]!="news") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/news'?>"><?php }?><div class="but_new" <? if ($Global['Url.Page'][0]=="news") echo 'style="background-position: 0px -33px; cursor: default"'; ?> ></div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][0]!="gallery") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/gallery'?>"><?php }?><div class="but_gal" <? if ($Global['Url.Page'][0]=="gallery") echo 'style="background-position: 0px -33px; cursor: default"'; ?> ></div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][1]!="cond") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/main/cond'?>"><?php }?><div class="but_cond" <? if ($Global['Url.Page'][1]=="cond") echo 'style="background-position: 0px -33px; cursor: default"'; ?> ></div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][1]!="otziv") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/otziv'?>"><?php }?><div class="but_otz" <? if ($Global['Url.Page'][1]=="otziv") echo 'style="background-position: 0px -33px; cursor: default"'; ?> ></div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][0]!="contacts") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/contacts'?>"><?php }?><div class="but_cont" <? if ($Global['Url.Page'][0]=="contacts") echo 'style="background-position: 0px -33px; cursor: default"'; ?> ></div></a>
			</b>
		</div>
		
		<?php include('router.php'); ?>
	
	</td>
	</tr>
	<tr valign=center><td class="footer" align=center>
	
		<div class="main" style="height: 50px">
			<div class="copy">
				<a style="color: #888888" href="<?php echo $Global['Host']?>/" >GALKOM</a> ® All Rights Reserved 2009<br />
				<div class="webe"><a target="_blank" style="color: black" title="Разработка, продвижение, поддержка сайтов" href="http://webengineer.com.ua"><b>Web</b>Engineer.com.ua</a>
				<br />
				<span style="color: black">Project manager - </span><a target="_blank" style="color: black" href="<?php echo $Global['Host']?>/main/project_manager" title="Менеджер проектов - Максим Древаль"><b>Max D' Reval</b></a>
				
				</div>
				
			</div>
			
			<div class="dopmenu">
				
				<? if ($Global['Url.Page'][0]!="catalog") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/catalog'?>"><?php }?>Продукция</a> | 
				<? if ($Global['Url.Page'][1]!="mat") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/main/mat'?>"><?php }?>Материалы</a> | 
				
				<? if ($Global['Url.Page'][0]!="news") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/'?>"><?php }?>Новости</a> | 
				<? if ($Global['Url.Page'][0]!="gallery") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/gallery'?>"><?php }?>Галерея</a> | 
				<? if ($Global['Url.Page'][1]!="cond") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/main/cond'?>"><?php }?>Партнерам</a> | 
				<? if ($Global['Url.Page'][1]!="otziv") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/otziv'?>"><?php }?>Отзывы</a> | 
				<? if ($Global['Url.Page'][0]!="contacts") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/contacts'?>"><?php }?>Контакты</a> | 
				<? if ($Global['Url.Page'][1]!="vac") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/main/vac'?>"><?php }?>Вакансии</a> |
				<? if ($Global['Url.Page'][1]!="link") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/links621360.php'?>"><?php }?>Ссылки</a> | 

		
		<div style="float: right; padding-top:7px; padding-right: 4px;">
		<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='http://counter.yadro.ru/hit?t57.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+";"+Math.random()+
"' alt='' title='LiveInternet' "+
"border='0' width='88' height='31'><\/a>")
//--></script><!--/LiveInternet-->
		</div>
		
		<div style="float: right; padding-top:7px; padding-right: 4px;">	<!-- begin of Top100 logo -->
<a href="http://top100.rambler.ru/home?id=1870394" target="_blank"><img src="http://top100-images.rambler.ru/top100/banner-88x31-rambler-brown2.gif" alt="Rambler's Top100" width="88" height="31" border="0" /></a>
<!-- end of Top100 logo --></div>

<div style="float: right; padding-top:7px; padding-right: 4px;"><!--SpyLOG-->
<span id="spylog2037766"></span><script type="text/javascript"> var spylog = { counter: 2037766, image: 25, next: spylog }; document.write(unescape("%3Cscript%20src=%22http" +
(("https:" == document.location.protocol) ? "s" : "") +
"://counter.spylog.com/cnt.js%22%20defer=%22defer%22%3E%3C/script%3E")); </script>
<!--SpyLOG--></div>

		<div style="float: right; padding-top:7px; padding-right: 4px;">
		<!-- HotLog -->
<script type="text/javascript" language="javascript">
hotlog_js="1.0"; hotlog_r=""+Math.random()+"&s=2016765&im=33&r="+
escape(document.referrer)+"&pg="+escape(window.location.href);
document.cookie="hotlog=1; path=/"; hotlog_r+="&c="+(document.cookie?"Y":"N");
</script>
<script type="text/javascript" language="javascript1.1">
hotlog_js="1.1"; hotlog_r+="&j="+(navigator.javaEnabled()?"Y":"N");
</script>
<script type="text/javascript" language="javascript1.2">
hotlog_js="1.2"; hotlog_r+="&wh="+screen.width+"x"+screen.height+"&px="+
(((navigator.appName.substring(0,3)=="Mic"))?screen.colorDepth:screen.pixelDepth);
</script>
<script type="text/javascript" language="javascript1.3">
hotlog_js="1.3";
</script>
<script type="text/javascript" language="javascript">
hotlog_r+="&js="+hotlog_js;
document.write('<a href="http://click.hotlog.ru/?2016765" target="_top"><img '+
'src="http://hit32.hotlog.ru/cgi-bin/hotlog/count?'+
hotlog_r+'" border="0" width="88" height="31" alt="HotLog"><\/a>');
</script>
<noscript>
<a href="http://click.hotlog.ru/?2016765" target="_top"><img
src="http://hit32.hotlog.ru/cgi-bin/hotlog/count?s=2016765&amp;im=33" border="0"
width="88" height="31" alt="HotLog"></a>
</noscript>
<!-- /HotLog -->


		</div>


			</div>
		</div>
	
	</td>
	
	</tr>
	</table>
<div id="uplayer" class="uplayer">
</div>
</div>
<?php if ($Global['Url.Page'][0]=="" ) { ?>
<!-- begin of Top100 code -->
<script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?1870394"></script><noscript><img src="http://counter.rambler.ru/top100.cnt?1870394" alt="" width="1" height="1" border="0"/></noscript>
<!-- end of Top100 code --> <?php }?>
 
 <script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10196532-1");
pageTracker._trackPageview();
} catch(err) {}</script>



 </body>
</html>