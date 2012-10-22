<?php
//include('../libs/semi.php');

function translit($str) {
	$trans = array(" "=>'_',"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e", "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i","й"=>"i","к"=>"k","л"=>"l", "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t", "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch", "ш"=>"sh","щ"=>"sh","ы"=>"i","э"=>"e","ю"=>"u","я"=>"ya",
  "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"E", "Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I","Й"=>"I","К"=>"K", "Л"=>"L","М"=>"M","Н"=>"N","О"=>"O","П"=>"P", "Р"=>"R","С"=>"S","Т"=>"T","У"=>"Y","Ф"=>"F", "Х"=>"H","Ц"=>"C","Ч"=>"Ch","Ш"=>"Sh","Щ"=>"Sh", "Ы"=>"I","Э"=>"E","Ю"=>"U","Я"=>"Ya",
  "Ъ"=>"","ъ"=>"","ь"=>"","Ь"=>"");
  return strtr($str, $trans);
}

function Get_Path($parent_id, $admin=0) {
	global $DB;
	global $Global;
	$parent_id = (int)$parent_id;
	$path_array = array();
	
	while ($parent_id>0) {
		$temp = $DB->ReadAssRow('SELECT * FROM sections WHERE section_id='.$parent_id);
		if ($admin) {
			$path_array[] = '<a href="'.$Global['Host'].'/edit_pages/'.$temp['section_id'].'">'.$temp['section_name'].'</a> / ';
		} else {
			
			$path_array[] = '<a href="'.$Global['Host'].'/'.$temp['section_point'].'">'.$temp['section_name'].'</a> / ';
		}
		
		$parent_id = $temp['parent_id'];
		
	}
	
	//if ($admin) {
	//	$res = '<a href="'.$Global['Host'].'/edit_pages">������ ����</a> / ';
	//}
	
	while (count($path_array)) {
	
		$res .= array_pop($path_array);
	}
	
	return $res;
	
}

function tstamp_to_date($time) {
	
	if (!$time) $time=time();
	
	return date('d.m.y',$time);
}

function tstamp_to_strdate($time) {
	
	$Y = date('Y', $time);
	$d = date('j', $time);
	
	$month = array( '������', '�������', '�����', '������', '���', '����', '����', '�������', '��������', '�������', '������', '�������');
	$m = date('n', $time);
	
	$dw = array('�����������', '�����������', '�������', '�����', '�������', '�������', '�������');
	$i = date('w', $time);
	
	return $d.' '.$month[$m-1].', '.$Y;
}

function get_str_date() {
	
	$Y = date('Y');
	$d = date('j');
	
	$month = array( '������', '�������', '�����', '������', '���', '����', '����', '�������', '��������', '�������', '������', '�������');
	$m = date('n');
	
	$dw = array('�����������', '�����������', '�������', '�����', '�������', '�������', '�������');
	$i = date('w');
	
	return $dw[$i].', '.$d.' '.$month[$m-1].', '.$Y;
	
}

function AddToBasket() {
	global $HTTP_GET_VARS;
	global $_SESSION;
	
	global $b_m;
	$b_m = $_SESSION['b_m'];
	
	$b_m[] = $HTTP_GET_VARS['p_id'];
	session_unregister('b_m');
	session_register('b_m');
}

function DeleteFromBasket() {
	global $HTTP_GET_VARS;
	global $_SESSION;
	
	global $b_m;
	$b_m = $_SESSION['b_m'];
	
	foreach (array_keys($b_m) as $k) {
		
		if ($b_m[$k] == $HTTP_GET_VARS['p_id']) {
			unset($b_m[$k]);
			break;
		}
	}
	session_unregister('b_m');
	session_register('b_m');
}

function GetSearchPath($Vars) {
	global $Global;
	global $DB;
	$res = '';
	if ((int)$Vars['cat_id']) {
		
		$Vars['cat_id'] = (int)$Vars['cat_id'];
		$tmp = $DB->ReadAssRow('select cat_id, cat_name FROM o_cat WHERE cat_id = '.$Vars['cat_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'">'.$tmp['cat_name'].'</a>';
	} else return $res;
	
	if ((int)$Vars['class_id']) {
		
		$Vars['class_id'] = (int)$Vars['class_id'];
		$tmp = $DB->ReadAssRow('select class_id, class_name FROM o_class WHERE class_id = '.$Vars['class_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'&class_id='.$Vars['class_id'].'">'.$tmp['class_name'].'</a>';
	} else return $res;
	
	if ((int)$Vars['region_id']) {
		
		$Vars['region_id'] = (int)$Vars['region_id'];
		$tmp = $DB->ReadAssRow('select region_id, region_name FROM region WHERE region_id = '.$Vars['region_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'&class_id='.$Vars['class_id'].'&region_id='.$Vars['region_id'].'">'.$tmp['region_name'].'</a>';
	} else return $res;
	
	if ((int)$Vars['town_id']) {
		
		$Vars['town_id'] = (int)$Vars['town_id'];
		$tmp = $DB->ReadAssRow('select town_id, town_name FROM towns WHERE town_id = '.$Vars['town_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'&class_id='.$Vars['class_id'].'&region_id='.$Vars['region_id'].'&town_id='.$Vars['town_id'].'">'.$tmp['town_name'].'</a>';
	} else return $res;
	
	if ((int)$Vars['area_id']) {
		
		$Vars['area_id'] = (int)$Vars['area_id'];
		$tmp = $DB->ReadAssRow('select area_id, area_name FROM areas WHERE area_id = '.$Vars['area_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'&class_id='.$Vars['class_id'].'&region_id='.$Vars['region_id'].'&town_id='.$Vars['town_id'].'&area_id='.$Vars['area_id'].'">'.$tmp['area_name'].'</a>';
	} else return $res;
	
	return $res;
}

function GetSearchPathById($object_id) {
	global $Global;
	global $DB;
	
	$Vars = $DB->ReadAssRow('select objects.object_name, objects.cat_id, region.region_id, towns.town_id, areas.area_id, objects.class_id FROM objects, region, towns, areas where objects.object_id ='.$object_id.' AND areas.area_id = objects.area_id AND towns.town_id = areas.town_id AND region.region_id = towns.region_id');
	
	$res = '';
	if ((int)$Vars['cat_id']) {
		
		$Vars['cat_id'] = (int)$Vars['cat_id'];
		$tmp = $DB->ReadAssRow('select cat_id, cat_name FROM o_cat WHERE cat_id = '.$Vars['cat_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'">'.$tmp['cat_name'].'</a>';
	} else return $res;
	
	if ((int)$Vars['class_id']) {
		
		$Vars['class_id'] = (int)$Vars['class_id'];
		$tmp = $DB->ReadAssRow('select class_id, class_name FROM o_class WHERE class_id = '.$Vars['class_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'&class_id='.$Vars['class_id'].'">'.$tmp['class_name'].'</a>';
	} else return $res;
	
	if ((int)$Vars['region_id']) {
		
		$Vars['region_id'] = (int)$Vars['region_id'];
		$tmp = $DB->ReadAssRow('select region_id, region_name FROM region WHERE region_id = '.$Vars['region_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'&class_id='.$Vars['class_id'].'&region_id='.$Vars['region_id'].'">'.$tmp['region_name'].'</a>';
	} else return $res;
	
	if ((int)$Vars['town_id']) {
		
		$Vars['town_id'] = (int)$Vars['town_id'];
		$tmp = $DB->ReadAssRow('select town_id, town_name FROM towns WHERE town_id = '.$Vars['town_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'&class_id='.$Vars['class_id'].'&region_id='.$Vars['region_id'].'&town_id='.$Vars['town_id'].'">'.$tmp['town_name'].'</a>';
	} else return $res;
	
	if ((int)$Vars['area_id']) {
		
		$Vars['area_id'] = (int)$Vars['area_id'];
		$tmp = $DB->ReadAssRow('select area_id, area_name FROM areas WHERE area_id = '.$Vars['area_id']);
		$res.='&nbsp;&nbsp;/&nbsp;&nbsp;<a href="'.$Global['host'].'/search?cat_id='.$Vars['cat_id'].'&class_id='.$Vars['class_id'].'&region_id='.$Vars['region_id'].'&town_id='.$Vars['town_id'].'&area_id='.$Vars['area_id'].'">'.$tmp['area_name'].'</a>';
	} else return $res;
	
	$res.='&nbsp;&nbsp;/&nbsp;&nbsp'.$Vars['object_name'];
	
	return $res;
}

function FormURL($page) {
		global $Global;
		global $HTTP_GET_VARS;
		$Vars = $HTTP_GET_VARS;
		$res ="";
		$res.=$Global['Host'].'/search/'.$page.'?cat_id='.$Vars['cat_id'].'&class_id='.$Vars['class_id'].'&region_id='.$Vars['region_id'].'&town_id='.$Vars['town_id'].'&area_id='.$Vars['area_id'].'&min_v='.$Vars['min_v'].'&max_v='.$Vars['max_v'];
		return $res;
}

function changePC() {

	global $PC;
	global $HTTP_POST_VARS;
	global $_SESSION;
	
	$PC = (int)$HTTP_POST_VARS['pc'];

	$_SESSION['PC'] = $PC;
	
	//session_unregister('PC');
	session_register('PC');
}

function RangeMoney($Sum) {
	/*$ar = array('0'=>'', '1'=>'���', '2'=>'���', '3'=>'����');
	
	for($i=0; $Sum> 1000; $i++, $Sum= (int)($Sum/1000));
	
	return $Sum.' '.$ar[$i];*/
	return (int) $Sum;
}



function changePhone() {
	global $HTTP_POST_VARS;
	global $Global;
	global $DB	;	

	$DB->DeleteDB('auxiliary','object = "phone"');
	$DB->EditDB(array('object'=>'phone','value'=>$HTTP_POST_VARS['phone']), 'auxiliary');
}

function changeMail() {
	global $HTTP_POST_VARS;
	global $Global;
	global $DB	;	

	$DB->DeleteDB('auxiliary','object = "mail"');
	$DB->EditDB(array('object'=>'mail','value'=>$HTTP_POST_VARS['mail']), 'auxiliary');
}


function getPhone() {
	global $DB;		

	return $DB->ReadScalar('select value from auxiliary where object = "phone"');
}

function getMail() {
	global $DB;		

	return $DB->ReadScalar('select value from auxiliary where object = "mail"');
}
 
function SendOrder() {
	global $HTTP_POST_VARS;
	global $ALARM;
	global $Global;
	
	$Vars = $HTTP_POST_VARS;

	$text =  "����� � ����� ".$Global['Host']." \n��������� ������:\n";
	$text.='��������: '.$Vars['action']."\n";
	$text.='���: '.$Vars['typer']."\n";
	
	if ($Vars['region'])$text.='������: '.$Vars['region']."\n";
	if ($Vars['region1'])$text.='������: '.$Vars['region1']."\n";
	if ($Vars['region2'])$text.='������: '.$Vars['region2']."\n";
	
	if ($Vars['town']) $text.='�����: '.$Vars['town']."\n";
	
	if ($Vars['area'])$text.='�����: '.$Vars['area']."\n";
	if ($Vars['area1'])$text.='�����: '.$Vars['area1']."\n";
	if ($Vars['area2'])$text.='�����: '.$Vars['area2']."\n";
	
	if ($Vars['metr']) $text.='������: '.$Vars['metr']."\n";
	if ($Vars['metr1']) $text.='������: '.$Vars['metr1']."\n";
	
	if ($Vars['kom_num']) $text.='���������� ������: '.$Vars['kom_num']."\n";
	if ($Vars['kom_num1']) $text.='���������� ������: '.$Vars['kom_num1']."\n";
	
	if ($Vars['et'])$text.='����: '.$Vars['et']."\n";
	
	if ($Vars['ets']) $text.='���������: '.$Vars['ets']."\n";
	
	
	if ($Vars['sq']) $text.='�������: '.$Vars['sq']."\n";
	
	if ($Vars['target'])$text.='����������: '.$Vars['target']."\n";
	
	if ($Vars['price']) $text.='���������: '.$Vars['price']."\n";
	if ($Vars['price1']) $text.='���������: '.$Vars['price1']."\n";
	if ($Vars['price2']) $text.='���������: '.$Vars['price2']."\n";
	
	if ($Vars['dops']) $text.='�������������: '.$Vars['dops']."\n";
	if ($Vars['dops1']) $text.='�������������: '.$Vars['dops1']."\n";
	if ($Vars['dops2']) $text.='�������������: '.$Vars['dops2']."\n";
	
	if ($Vars['fio']) $text.='���: '.$Vars['fio']."\n";
	if ($Vars['fio1']) $text.='���: '.$Vars['fio1']."\n";
	if ($Vars['fio2']) $text.='���: '.$Vars['fio2']."\n";
	
	if ($Vars['tel']) $text.='���������� �������: '.$Vars['tel']."\n";
	if ($Vars['tel1']) $text.='���������� �������: '.$Vars['tel1']."\n";
	if ($Vars['tel2']) $text.='���������� �������: '.$Vars['tel2']."\n";
	
	if ($Vars['mail']) $text.='E-mail : '.$Vars['mail']."\n";
	if ($Vars['mail1']) $text.='E-mail : '.$Vars['mail1']."\n";
	if ($Vars['mail2']) $text.='E-mail : '.$Vars['mail2']."\n";
	
	$ALARM->Mail('����� �����', $Global['AdminMail'], $text);
	
	global $sended;
	$sended="�������, ���� ��������� ����������� <br/>";
	
}

function CreateUserMenu() {
	global $Global;
	global $User;
	global $_SESSION;
	global $BASKET;
	
	$res = '<a style="color: #404040" href='.$Global['Host'].'/basket><div class=bascet></div> � ������� (<span id=basket>'.($BASKET->GetGoodsCount()).'</span>)</a>';
	
	
	if (!($User['Rights']&$Global['Right.User'])){
		$res.= ' | <a style="color: #404040" Onclick="GetOnLayer(\'login\'); return false;" href="'.$Global['Host'].'/admin">�����</a> | <a style="color: #404040" Onclick="GetOnLayer(\'registration\'); return false;" href="'.$Global['Host'].'/registration">�����������</a>';
	} else {
		
		$res.= ' | <a style="color: #404040"  href="'.$Global['Host'].'/logout">�����</a>';
	}
	
	return $res;
}

function ReturnPrice($p) {
	return $p;
}

function CreateRow($koefs) {
	
	$row = array();
	foreach ($koefs as $r) {
		
		$ar = explode('��', $r['koef_name']);
		$ar = explode('��', $ar[1]);
		$from = trim($ar[0]);
		$to = trim($ar[1]);
		if (!count($row)) {
			$row['int'][] = $from;
			$row['koef'][] = 0;
		}
		$row['int'][] = $to;
		$row['koef'][] = $r['koef_value'];
	}
	
	return $row;
}

function CalcKoef($kol) {
	global $DB;

	$koefs = $DB->ReadAss("SELECT * FROM koefs WHERE koef_value ORDER BY koef_value DESC");
	$row = CreateRow($koefs);
	foreach (array_keys($row['int']) as $inter) {
		
		if ( $kol<$row['int'][$inter] ) {
			if ($row['koef'][$inter])
				return $row['koef'][$inter];
			else 
				return (-$row['koef'][$inter+1]);
		}
	}
	
	return (-$row['koef'][count($row['koef'])-1]);
}

function changeFlash() {
	global $HTTP_POST_VARS;
	global $Global;
	global $DB	;	

	$DB->DeleteDB('auxiliary','object = "flash"');
	$DB->EditDB(array('object'=>'flash','value'=>$HTTP_POST_VARS['flash']), 'auxiliary');
}

function getFlash() {
	global $DB;		

	return $DB->ReadScalar('select value from auxiliary where object = "flash"');
}

function changeSEO() {
	global $HTTP_POST_VARS;
	global $Global;
	global $DB	;	

	$DB->DeleteDB('auxiliary','object = "seo"');
	$DB->EditDB(array('object'=>'seo','value'=>$HTTP_POST_VARS['seo']), 'auxiliary');
}

function getSEO() {
	global $DB;		

	return $DB->ReadScalar('select value from auxiliary where object = "seo"');
}

function setKoef() {
	global $DB;
	global $_POST;
	global $set_koef;
	
	$koef = (float)$_POST['koef'];
	if ($koef) {
		$DB->Exec("update goods set good_price=good_price*$koef where 1");
		$DB->Exec("update mat_price set matprice=matprice*$koef where 1");
		$set_koef = 1;
	}
}

function changeShort() {
	global $HTTP_POST_VARS;
	global $Global;
	global $DB	;	

	$DB->DeleteDB('auxiliary','object = "short"');
	$DB->EditDB(array('object'=>'short','value'=>$HTTP_POST_VARS['short']), 'auxiliary');
}

function getShort() {
	global $DB;		

	return $DB->ReadScalar('select value from auxiliary where object = "short"');
}

function changeDel() {
	global $HTTP_POST_VARS;
	global $Global;
	global $DB	;	

	$DB->DeleteDB('auxiliary','object = "del"');
	$DB->EditDB(array('object'=>'del','value'=>$HTTP_POST_VARS['del']), 'auxiliary');
}

function getDel() {
	global $DB;		

	return $DB->ReadScalar('select value from auxiliary where object = "del"');
}

function showFlash() {
	global $DB;		
	
	$tmp = getFlash();
	if ($tmp!="") {
	
		$res = '<embed src="'.$tmp.'" wmode="opaque"  quality="high" width="632" height="269" name="flash"  type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>';
	} else $res = '';
	return $res;
}

function ShowHeader() {
	global $Global;
	global $SUBCAT;
	global $GOOD;
	global $DB;
	global $NEW;
	
	if (!$Global['Url.Page'][0]) {
		return addslashes($DB->ReadScalar('select page_title from pages where page_point="main"'));
	}
	
	if ($Global['Url.Page'][0] == 'news' && $Global['Url.Page'][1]) { 
		$NEW->ReadOneObject((int)$Global['Url.Page'][1]);
		return (str_replace('"',' ', $NEW->CleanTag($NEW->Object['new_prew'])));
	}
	
	if ($Global['Url.Page'][0] != 'catalog') { 
	
		if ($Global['Url.Page'][0]) {
				
			if ($Global['Url.Page'][1]) {
				
				return $DB->ReadScalar('select page_title from pages where page_point="'.(addslashes($Global['Url.Page'][1])).'"');
			} else {
				return $DB->ReadScalar('select section_title from sections where section_point="'.(addslashes($Global['Url.Page'][0])).'"');
			}
		}
		return 'Всё и сразу, все каталоги на одном сайте';
	}
	
	if ($Global['Url.Page'][2]) {
	
		$name = urldecode($Global['Url.Page'][2]);
		$GOOD->Object = $DB->ReadAssRow("select * from goods where good_url='$name'");
		return $GOOD->Object['good_name'].' - '.strip_tags($GOOD->Object['good_desc']);
	} else {
		
		$name = urldecode($Global['Url.Page'][1]);
		$SUBCAT->Object = $DB->ReadAssRow("select * from subcat where sc_url='$name'");
		return $SUBCAT->Object['sc_header'];
	}
	
}

function ShowDesc() {
	global $Global;
	global $SUBCAT;
	global $GOOD;
	global $DB;
	global $NEW;
	
	if (!$Global['Url.Page'][0]) {
		return $DB->ReadScalar('select page_desc from pages where page_point="main"');
	}
	
	if ($Global['Url.Page'][0] == 'news' && $Global['Url.Page'][1]) { 
		$NEW->ReadOneObject((int)$Global['Url.Page'][1]);
		return (str_replace('"',' ', substr($NEW->CleanTag($NEW->Object['new_text']),0,300))).'...';
	}
	
	if ($Global['Url.Page'][0] != 'catalog') { 
	
		if ($Global['Url.Page'][0]) {
				
			if ($Global['Url.Page'][1]) {
				
				return $DB->ReadScalar('select page_desc from pages where page_point="'.(addslashes($Global['Url.Page'][1])).'"');
			} else {
				return $DB->ReadScalar('select section_desc from sections where section_point="'.(addslashes($Global['Url.Page'][0])).'"');
			}
		}
		
		return 'Все и сразу';
	}
	
	if ($Global['Url.Page'][2]) {
	
		$name = urldecode($Global['Url.Page'][2]);
		$GOOD->Object = $DB->ReadAssRow("select * from goods where good_url='$name'");
		return $DB->CleanTag($GOOD->Object['good_name'].' '.(addslashes($GOOD->Object['good_desc'])));
	} else {
		
		$name = urldecode($Global['Url.Page'][1]);
		$SUBCAT->Object = $DB->ReadAssRow("select * from subcat where sc_url='$name'");
		return $SUBCAT->Object['sc_desc'];
	}
	
}

function AddZero($num, $zero) {
	$res = $num;
	$big = pow(10, $zero-1);
	
	for (; $num<$big; $num*=10) {
		$res='0'.$res;
	}
	
	return $res;
	
}

function ToCsv($ar) {
	
	$str = "";
	foreach ($ar as $row) {
		$str.='"'.(str_replace('"','""',$row)).'";';
	}
	return $str;
}

function GetBetween($start, $stop, &$text) {
    $tmp = explode($start, $text, 2);
    if (count($tmp) !=2) return '';
    $tmp = $tmp[1];
    $tmp = explode($stop, $tmp, 2);
    if (count($tmp) !=2) return '';
    
    $text = $tmp[1];
    
    return $tmp[0];
}

?>