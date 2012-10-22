<?php
//error_reporting(0);
//ini_set ("display_errors","0");
session_start();
header("Content-Type: text/html; charset=utf-8");

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

//include ('fckeditor/fckeditor_php4.php');

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

include ('libs/pgroups.php');
$PGROUP = new PGroup($DB);

include ('libs/otzivs.php');
$OTZIV = new Otziv($DB);


include ('libs/gallery.php');
$GALLERY = new Gallery($DB);

include ('libs/functions.php');
include ('libs/Sajax.php');
include ('libs/timage.php');
$IMAGE = new ImageResizer($DB);

$Global['AdminMail'] = getMail();
$str = $_SERVER['REQUEST_URI'];
$str = explode('?', $str);
$str = $str[0];
$Global['Url.Query'] = $str;
if (!$str) {

} else {
	$Global['Url.Page'] = explode('/', substr($str,1)); 
}

$sajax_request_type = "POST";
						$sajax_remote_uri = $Global['Host'].'/ajax.php';
						sajax_init();
						sajax_export("delete_spam", "add_to_spam", "send_pass", "feedback", "show_new", "get_arh", "delete_from_order", "reg", "login", "show_page", "save_count", "get_news", "get_cat", "get_subcats", "get_subcat", "get_goods", "get_good", "add_good", "delete_good");
						sajax_handle_client_request();	
				

echo'<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
 <head>
 <script type="text/javascript" src="<?php echo $Global['Host']?>/java/jquery-1.2.6.min.js"></script>
 <link rel="icon" href="<?php echo $Global['Host']?>/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo $Global['Host']?>/favicon.ico" type="image/x-icon"> 
 <title><?php echo ShowHeader();?></title>
   <?php
		$sc_id = $DB->ReadScalar('select sc_id from subcat where sc_url="'.$Global['Url.Page'][1].'"'); 
		switch ($sc_id) {
			case '11': $keywords='������� ��� ��������������'; break;
			case '2': $keywords='����� ��������'; break;
			case '3': $keywords='����� �� ������'; break;
			case '23': $keywords='��������� ����������'; break;
			case '19': $keywords='��������� ���������'; break;
			case '18': $keywords='�������� �������'; break;
			case '14': $keywords='������������� �������'; break;
			default: $keywords = getSEO();
		}
		
   ?>
   <meta name="keywords" content="<?php echo $keywords?>">
  <meta name="description" content="<?php echo ShowDesc();?>" />
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
		document.location=data['location'];
	} else {
		alert (data['error']);
	}
}

<?php 
						sajax_show_javascript();
					?>


</script>



 <BODY OnLoad ="prep();" OnResize="ResizeLayer()">
 
	<table class="maintab" style="" cellpadding = 0 cellspacing=0>
	<tr valign=center><td class="main" align=center>
	
	<div class=main>
		<div style="text-align: left"><?php $MENU->ShowStaticMenu($AdminMenu, $Global['Right.Man']+$Global['Right.SEO']); ?></div>
		<div class="head">
			<a href="<? echo $Global['Host']?>">
				<div class="logo">
					Всё и сразу
					<div style="font-size: 11px; margin-top: 10px">Все каталоги на одном сайте</div>
				</div>
			</a>
			
			<div class="lngis">
				
				<div class="lng">    </div>
				<form action="<?php echo $Global['Host']?>/search" name="fsearch" method="GET">
				<div class="search"><input name=search_string value="<?php echo addslashes($HTTP_GET_VARS['search_string']) ?>" /> <div Onclick="fsearch.submit()" class="searchb"></div> </div></form>
			</div>
			
		</div>
		<div class="menu">
			<?php /*
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
			</b> */
			?>
		</div>
		
		<?php include('router.php'); ?>
	
	</td>
	</tr>
	<tr valign=center><td class="footer" align=center>
	
		<div class="main" style="height: 50px">
			<div class="copy">
				
			</div>
			
			<div class="dopmenu">
				
				<? if ($Global['Url.Page'][0]!="catalog") {?><a style="color: #888888" href="<?php echo $Global['Host'].'/catalog'?>"><?php }?>Каталог</a> |
				

<?php if ($USER->CheckRights($Global['Url.Page'][0], $x)) { ?>
				
		
<?php }?>

			</div>
		</div>
           
	
	</td>
	
	</tr>
	</table>

<div id="uplayer" class="uplayer" OnClick="CloseLayer()">
</div>
<div style="clear:both; position: relative">
<?php
if ($_GET['show_db_statistic_pls']) {
    echo '<pre>';
    var_dump($DB->Log);
    echo '</pre>';
}
?> 
</div>
 </body>
</html>