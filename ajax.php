<?php
ini_set ("display_errors","0");
session_start();
error_reporting(E_ERROR | E_PARSE);
header("Content-Type: text/html; charset=windows-1251");

require("libs/Sajax.php");
include('place_settings.cfg');
include('settings.cfg');
//--------------

include('libs/_error.php');

$ERROR = new Error;

include('libs/_db.php');
$DB = new DataBase();

include('libs/_user.php');
$USER = new User($DB);

include('libs/groups.php');
$GROUP = new Group($DB);


include('libs/cat.php');
$CAT = new Cat($DB);

include ('libs/subcats.php');
$SUBCAT = new SubCat($DB);

include ('libs/good.php');
$GOOD = new Good($DB);

include ('libs/mats.php');
$MAT = new Mat($DB);

include ('libs/basket.php');
$BASKET = new Basket($DB);


include ('libs/tnews.php');
$NEW = new News($DB);

include ('libs/gallery.php');
$GALLERY = new Gallery($DB);

include ('libs/talarm.php');
$ALARM = new Alarm($DB);

include ('libs/pgroups.php');
$PGROUP = new PGroup($DB);

include ('fckeditor/fckeditor_php4.php');
include('libs/functions.php');

$User = $_SESSION['User'];

function get_cat($id) {
	global $CAT;
	global $Global;
	$cat_id = (int)$id;
	$CAT->ReadOneObject($cat_id);
	$res = "";
	$res = '
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="cat_id" value="'.$cat_id.'" />
					<input type="hidden" name="sender" value="edit_cats" />
					<table width="100%">
					
					<tr><td class="form_caption">
							Категория:
						</td>
						<td class="form_input">
						<input maxlength="255" name="cat_name" value="'.$CAT->Object['cat_name'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Порядок:
						</td>
						<td class="form_input">
						<input maxlength="255" name="cat_order" value="'.$CAT->Object['cat_order'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Картинка:
							'.(($cat_id)?('<img src="'.$Global['Host'].'/'.$Global['Cat.Dir'].'/'.$cat_id.'.jpg" />'):'').'
						</td>
						<td class="form_input">
						<input type="file" name="file" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						'.(($cat_id)?'<input class="button" type="submit" onclick="return confirm(\'Вы действительно хотите удалить?\');" name="delete" value="Удалить">':'').'
					</td><td class="form_input"></td></tr>
					</table>
					</form>
	';
	
	return $res;
}

function get_subcats($cat_id) {
	global $CAT;
	global $Global;
	global $SUBCAT;
	
	$cat_id = (int)$cat_id;
	
	if (!$cat_id) return "";
	
	$SUBCAT->ReadAll($cat_id);
	$CAT->ReadAll();
	
	$cats = '<select name="cat_id" >';
	foreach ($CAT->Objects as $cat){
		$cats .='<option value="'.$cat['cat_id'].'"'.(($cat_id==$cat['cat_id'])?'selected':"").' >'.$cat['cat_name'].'</option>';	
	}
	$cats .='</select>';
	
	$res='	<select id="sc_id" OnChange = "getSC()" name="sc_id" style="float: left;">
					<option value="0">Добавить подкатегорию</option>
					'; 
	if ($SUBCAT->Objects)
	foreach ($SUBCAT->Objects as $sc){
		$res .= '<option value="'.$sc['sc_id'].'">'.$sc['sc_name'].'</option>';
	}
	$res.='</select> <div id="editsubcat" OnClick=\'document.getElementById("editsubcat").style.display = "none"; document.getElementById("subcatform").style.display = "block";\' style="display: none; float: left; margin-left: 5px;"><a href="#nogo">Редактировать</a></div>
		<div id="subcatform">
		
		<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="sc_id" value="0" />
					<input type="hidden" name="sender" value="edit_subcats" />
					<table width="100%">
					
					<tr><td class="form_caption">
							Подкатегория:
						</td>
						<td class="form_input">
						<input maxlength="255" name="sc_name" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Родительская категория:
						</td>
						<td class="form_input">
						'.$cats.'
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Заголовок:
						</td>
						<td class="form_input">
						<input maxlength="255" name="sc_header" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Описание
						</td>
						<td class="form_input">
						<input  name="sc_desc" value="" />
						</td>
					</tr>
					<tr><td class="form_caption">
							Дополнительный текст:
						</td>
						<td class="form_input">
						<textarea name="sc_text"></textarea>
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					</table>
					</form>
		
		
		
		</div>
		';
	
	return $res;
}

function get_pgroup($id) {
	global $PGROUP;
	global $Global;
	$pgroup_id = (int)$id;
	$PGROUP->ReadOneObject($pgroup_id);
	$res = "";
	$res = '
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="pgroup_id" value="'.$pgroup_id.'" />
					<input type="hidden" name="sender" value="edit_pgroups" />
					<table width="100%">
					
					<tr><td class="form_caption">
							Группа:
						</td>
						<td class="form_input">
						<input maxlength="255" name="pgroup_name" value="'.$PGROUP->Object['pgroup_name'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						'.(($pgroup_id)?'<input class="button" type="submit" onclick="return confirm(\'Вы действительно хотите удалить?\');" name="delete" value="Удалить">':'').'
					</td><td class="form_input"></td></tr>
					</table>
					</form>
	';
	
	return $res;
}

function get_users($pgroup_id) {
	global $USER;
	global $User;
	global $Global;
	global $PGROUP;
	
	global $GROUP;
	
	$pgroup_id = (int)$pgroup_id;
	
	if (!$pgroup_id) return "";
	
	$USER->ReadAll($pgroup_id);
	
	$PGROUP->ReadAll();
	$pgroups = '<select name="pgroup_id" >';
	if ($PGROUP->Objects)
	foreach ($PGROUP->Objects as $pgroup){
		$pgroups .='<option value="'.$pgroup['pgroup_id'].'"'.(($pgroup_id==$pgroup['pgroup_id'])?'selected':"").' >'.$pgroup['pgroup_name'].'</option>';	
	}
	$pgroups .='<option '.(($pgroup_id==-1)?'selected':"").' value="-1">Вне групп</option>
	</select>';
	
	$GROUP->ReadAll();
	$groups = '<select name="group_id" >';
	if ($GROUP->Objects)
	foreach ($GROUP->Objects as $group){
		$groups .='<option value="'.$group['group_id'].'" >'.$group['group_name'].'</option>';	
	}
	$groups .='</select>';
	
	$res='<div class="links_overflow">
					<a href="'.$Global['Host'].'/edit_users/'.$pgroup_id.'">Добавить пользователя</a><br /><br />';
					
					if ($USER->Objects)
					foreach ($USER->Objects as $user){
					
						$res.= '<a href="'.$Global['Host'].'/edit_users/'.$user['pgroup_id'].'/'.$user['user_id'].'">
						< '.$user['user_login'].' > '.$user['user_soname'].' '.$user['user_name'].'</a><br />';
	
					}
					
	$res.='</div>
		<div id="usersform">
		
		<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="user_id" value="0" />
					<input type="hidden" name="sender" value="edit_users" />
					<table>
					<tr><td class="form_caption">
						Новый пользователь:
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
							Логин:
						</td><td class="form_input">
						<input maxlength="255" name="user_login" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Пароль:
						</td><td class="form_input">
						<input maxlength="255" name="user_password" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Псевдо группа:
						</td><td class="form_input">
						'.$pgroups.'
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Группа:
						</td><td class="form_input">
						'.$groups.'
						</td>
					</tr>
					
					
					<tr><td class="form_caption">
							Права:
						</td><td class="form_input">
						<Select name="user_rights">
							<option value="'.$Global['Right.User'].'">Пользователь</option>
							<option value="'.($Global['Right.Man']+$Global['Right.User']).'"'.(($Global['Right.Man'] & $Vars['user_rights']) ? 'selected':'').'>Менеджер</option>
							<option value="'.($Global['Right.Man']+$Global['Right.Stman']+$Global['Right.User']).'"'.(($Global['Right.StMan'] & $Vars['user_rights']) ? 'selected':'').'>Старший менеджер</option>
							<option value="'.($Global['Right.SEO']+$Global['Right.User']).'"'.(($Global['Right.SEO'] & $Vars['user_rights']) ? 'selected':'').'>СЕО-специалист</option>
							<option value="'.($Global['Right.Admin']+$Global['Right.Man']+$Global['Right.Stman']+$Global['Right.User']+$Global['Right.SEO']).'"'.(($Global['Right.Admin'] & $Vars['user_rights']) ? 'selected':'').'>Администратор</option>
						</select>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Имя:
						</td><td class="form_input">
						<input maxlength="255" name="user_name" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Фамилия:
						</td><td class="form_input">
						<input maxlength="255" name="user_soname" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Отчество:
						</td><td class="form_input">
						<input maxlength="255" name="user_pname" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						&nbsp;
						</td><td class="form_input">
						
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Организация:
						</td><td class="form_input">
						<input maxlength="255" name="user_org" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Род деятельности:
						</td><td class="form_input">
						<input maxlength="255" name="user_doing" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Адрес:
						</td><td class="form_input">
						<input maxlength="255" name="user_adr" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Город:
						</td><td class="form_input">
						<input maxlength="255" name="user_town" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						&nbsp;
						</td><td class="form_input">
						
						</td>
					</tr>
					<tr><td class="form_caption">
							Почта:
						</td><td class="form_input">
						<input maxlength="255" name="user_mail" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						 
						<input class="button" type="submit" onclick="confirm(\'Вы действительно хотите удалить?\');" name="delete" value="Удалить">
						
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					</div>
		';
	
	return $res;
}

function get_user($user_id) {
	global $PGROUP;
	global $GROUP;
	global $Global;
	global $User;
	global $USER;
	
	$user_id = (int)$user_id;
	$USER->ReadOneObject($user_id);
	$pgroup_id = $USER->Object['pgroup_id'];
	$group_id = $USER->Object['group_id'];
	$Vars = $USER->Object;
	$PGROUP->ReadAll();
	$pgroups = '<select name="pgroup_id" >';
	if ($PGROUP->Objects)
	foreach ($PGROUP->Objects as $pgroup){
		$pgroups .='<option value="'.$pgroup['pgroup_id'].'"'.(($pgroup_id==$pgroup['pgroup_id'])?'selected':"").' >'.$pgroup['pgroup_name'].'</option>';	
	}
	$pgroups .='<option '.(($pgroup_id==-1)?'selected':"").' value="-1">Вне групп</option>
	</select>';
	
	$GROUP->ReadAll();
	$groups = '<select name="group_id" >';
	if ($GROUP->Objects)
	foreach ($GROUP->Objects as $group){
		$groups .='<option value="'.$group['group_id'].'"'.(($group_id==$group['group_id'])?'selected':"").' >'.$group['group_name'].'</option>';	
	}
	$groups .='</select>';
	
	$res='
		<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="user_id" value="'.$user_id.'" />
					<input type="hidden" name="sender" value="edit_users" />
					<table>
					<tr><td class="form_caption">
						Пользователь:
					</td><td class="form_input">'.$Vars['user_login'].' </td></tr>
					
					<tr><td class="form_caption">
							Логин:
						</td><td class="form_input">
						<input maxlength="255" name="user_login" value="'.$Vars['user_login'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Пароль:
						</td><td class="form_input">
						<input maxlength="255" name="user_password" value="'.$Vars['user_password'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Псевдогруппа:
						</td><td class="form_input">
						'.$pgroups.'
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Группа:
						</td><td class="form_input">
						'.$groups.'
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Права
						</td><td class="form_input">
						<Select name="user_rights">
							<option value="'.$Global['Right.User'].'">Пользователь</option>
							<option value="'.($Global['Right.Admin']+$Global['Right.User']).'"'.(($Global['Right.Admin'] & $Vars['user_rights']) ? 'selected':'').'>Администратор</option>
						</select>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Имя:
						</td><td class="form_input">
						<input maxlength="255" name="user_name" value="'.$Vars['user_name'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Фамилия:
						</td><td class="form_input">
						<input maxlength="255" name="user_soname" value="'.$Vars['user_soname'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Отчество:
						</td><td class="form_input">
						<input maxlength="255" name="user_pname" value="'.$Vars['user_pname'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						&nbsp;
						</td><td class="form_input">
						
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Организация:
						</td><td class="form_input">
						<input maxlength="255" name="user_org" value="'.$Vars['user_org'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Род деятельности:
						</td><td class="form_input">
						<input maxlength="255" name="user_doing" value="'.$Vars['user_doing'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Адрес:
						</td><td class="form_input">
						<input maxlength="255" name="user_adr" value="'.$Vars['user_adr'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Город:
						</td><td class="form_input">
						<input maxlength="255" name="user_town" value="'.$Vars['user_town'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						&nbsp;
						</td><td class="form_input">
						
						</td>
					</tr>
					<tr><td class="form_caption">
							Почта:
						</td><td class="form_input">
						<input maxlength="255" name="user_mail" value="'.$Vars['user_mail'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">';
					
					if($user_id) { 
						$res.= '<input class="button" type="submit" onclick="confirm(\'Вы действительно хотите удалить?\');" name="delete" value="Удалить">';
					}
					$res.= '</td><td class="form_input"></td></tr>
					</table>
					</form>';
	return $res;
}

function get_news($year, $month, $page=0) {
	global $DB;
	global $Global;
	
	if ($year) {
		
		if ($month) {
			$start = mktime(0,0,0, $month, 1,$year);
			$stop = mktime(0,0,0, $month, 31,$year);
		}
		else {
		
			$start = mktime(0,0,0, 1, 1,$year);
			$stop = mktime(0,0,0, 12, 31,$year);
		}
	} else {
		if ($month) {
			$start = mktime(0,0,0, $month, 1);
			$stop = mktime(0,0,0, $month, 31);
		} else {
			$start = 0;
			$stop = mktime(0,0,0, 1, 1, 2030);
		}
	}
	
	
	$temp = $DB->ReadAss('select * from news where new_date>'.$start.' AND new_date<'.$stop);
	
	$count = count($temp);		
	$res=""	;
		$res.= '<div id="number" align="center">';
		
		for ($i = 0; $i<=((int)($count/$Global['NewsOnPage.Count'])); $i++) {
			$res.= ' <a OnClick="return ChangePage('.((int)$year).','.((int)$month).', '.$i.')" href="'.$Global['Host'].'/arhnews?page='.$i.'">'.($i+1).'</a> ';
		}
		
		
		$res.= '</div>';
		
		$start = $page*$Global['NewsOnPage.Count'];
		$res.='
		<div id="all_news">';
		
		$i = 0;
		
		foreach ($temp as $row) {
			$i++;
			if ($i<=$start) continue;
			if ($i>$start+$Global['NewsOnPage.Count']) break;
			$res.= '<p ><font class="date">'.(date("d/m/Y", $row['new_date'])).'</font> <a href="'.$Global['Host'].'/news/'.$row['new_id'].'">'.$row['new_name'].'</a><br /><div class="new_text">';
			if (substr($row['new_prew'],strlen($row['new_prew'])-4,4)=="</p>") 
				$row['new_prew'] = substr($row['new_prew'], 0, strlen($row['new_prew'])-4);
			$res.= $row['new_prew'].'&nbsp;<a href="'.$Global['Host'].'/news/'.$row['new_id'].'" title="Читать дальше"><img src="'.$Global['Host'].'/css/images/last_news_arrow.gif" width="8" height="7" alt="Читать дальше" /></a></p></div></p>';
		}
		
		$res.='</div>';
		$res.= '<div id="number" align="center">';
		
		for ($i = 0; $i<=((int)($count/$Global['NewsOnPage.Count'])); $i++) {
			$res.= ' <a OnClick="return ChangePage('.((int)$year).','.((int)$month).', '.$i.')" href="'.$Global['Host'].'/arhnews?page='.$i.'">'.($i+1).'</a> ';
		}
		return $res;
}

function get_subcat($sc_id) {
	global $CAT;
	global $Global;
	global $SUBCAT;
	
	$sc_id = (int)$sc_id;
	
	//$SUBCAT->ReadAll($cat_id);
	$CAT->ReadAll();
	$SUBCAT->ReadOneObject($sc_id);
	
	$cat_id = $SUBCAT->Object['cat_id'];
	
	$cats = '<select name="cat_id" >';
	foreach ($CAT->Objects as $cat){
		$cats .='<option value="'.$cat['cat_id'].'"'.(($cat_id==$cat['cat_id'])?'selected':"").' >'.$cat['cat_name'].'</option>';	
	}
	$cats .='</select>';
	
	$res='
		<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="sc_id" value="'.$SUBCAT->Object['sc_id'].'" />
					<input type="hidden" name="sender" value="edit_subcats" />
					<table width="100%">
					
					<tr><td class="form_caption">
							Подкатегория:
						</td>
						<td class="form_input">
						<input maxlength="255" name="sc_name" value="'.$SUBCAT->Object['sc_name'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Родительская категория:
						</td>
						<td class="form_input">
						'.$cats.'
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Заголовок:
						</td>
						<td class="form_input">
						<input maxlength="255" name="sc_header" value="'.$SUBCAT->Object['sc_header'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Описание:
						</td>
						<td class="form_input">
						<input  name="sc_desc" value="'.$SUBCAT->Object['sc_desc'].'" />
						</td>
					</tr>
					<tr><td class="form_caption">
							Дополнительный текст:
						</td>
						<td class="form_input">
						<textarea name = sc_text>'.$SUBCAT->Object['sc_text'].'</textarea>
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					<tr><td class="form_caption">';
						if($SUBCAT->Object['sc_id']) { 
						$res .= '<input class="button" type="submit" onclick="return confirm(\'Вы действительно хотите удалить?\');" name="delete" value="Удалить">';
						} 
					$res.='
					</td><td class="form_input"></td></tr>
					</table>
					</form>
		
		';
	return $res;
}

function get_goods($sc_id) {
	global $CAT;
	global $Global;
	global $SUBCAT;
	global $GOOD;
	global $User;
	global $MAT;
	
	$sc_id = (int)$sc_id;
	
	if (!$sc_id) return "";
	
	$GOOD->ReadAll($sc_id);
	$SUBCAT->ReadSame($sc_id);
	
	$subcats = '<select name="sc_id" >';
	foreach ($SUBCAT->Objects as $cat){
		$subcats .='<option value="'.$cat['sc_id'].'"'.(($sc_id==$cat['sc_id'])?'selected':"").' >'.$cat['sc_name'].'</option>';	
	}
	$subcats .='</select>';
	
	$res='	<select id="good_id" OnChange = "getGood('.$sc_id.')" name="good_id" style="float: left;">
					<option value="0">Добавить товар</option>
					'; 
	if ($GOOD->Objects)
	foreach ($GOOD->Objects as $good){
		$res .= '<option value="'.$good['good_id'].'">Арт '.$good['good_art'].' '.$good['good_name'].'</option>';
	}
	
	$prices = $MAT->GetPriceForGood(0);
	
	$res.='</select> <div id="editgood" OnClick=\'document.getElementById("editgood").style.display = "none"; document.getElementById("goodform").style.display = "block";\' style="display: none; float: left; margin-left: 5px;"><a href="#nogo">Редактировать</a></div>
		<div id="goodform" style="clear: both">
		
		<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="good_id" value="0" />
					<input type="hidden" name="sender" value="edit_goods" />
					<table width="100%">
					
					<tr><td class="form_caption">
							Название товара:
						</td>
						<td class="form_input">
						<input maxlength="29" name="good_name" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Артикл товара:
						</td>
						<td class="form_input">
						<input maxlength="255" name="good_art" value="" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Родительская категория:
						</td>
						<td class="form_input">
						'.$subcats.'
						</td>
					</tr>
					';
					if ($User['user_rights']&$Global['Right.Admin']) {
						$res .= '
						<tr><td class="form_caption">
								Цены:
							</td>
							<td class="form_input">
							</td>
						</tr>';
						
						foreach ($prices as $row) {
							$res.='<tr><td class="form_caption">
								'.$row['mat_name'].'
							</td>
							<td class="form_input">
							<input maxlength="255" name="mat['.$row['mat_id'].']" value="'.$row['matprice'].'" />
							</td>
						</tr>';
						}
					
					};
					$res.='
					
					<tr><td class="form_caption">
							Фотографии:
						</td>
						<td class="form_input">
						<button OnClick="AddPhoto(); return false;">Добавить фото</button>
						</td>
					</tr>
					
					<tr><td class="form_caption">
						</td><td class="form_input">
							<div id="photo1">
							</div>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Цвета:
						</td>
						<td class="form_input">
						<button OnClick="AddColor(); return false;">Добавить цвет</button>
						</td>
					</tr>
					
					<tr><td class="form_caption">
						</td><td class="form_input">
							<div id="color">
							</div>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Описание товара:
						</td>
					</tr>
					<tr>	
					<td class="form_input" colspan=2>
					';
						$EDITOR = new FCKeditor("good_desc");
						$EDITOR->Value = "";
						$EDITOR->Width = "100%";
						$EDITOR->Height = "300px";
						$res.=$EDITOR->CreateHtml();
					
					$res.='</td></tr>
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("Рекламный товар:", 'good_adv').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_adv']?'checked':'').' maxlength="255" name="good_adv" value="1" />
						</td>
					</tr>
					
					';
					
					if ($User['user_rights']&$Global['Right.Admin'])
					$res .= '<tr><td class="form_caption">
							'.$CAT->HTMLUserError('В блок "новинки":', 'good_new').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_new']?'checked':'').' maxlength="255" name="good_new" value="1" />
						</td>
					</tr>';
					
					if ($User['user_rights']&$Global['Right.Admin'])
					$res .= '<tr><td class="form_caption">
							'.$CAT->HTMLUserError('В блок "Бестселлеры":', 'good_bestceller').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_bestceller']?'checked':'').' maxlength="255" name="good_bestceller" value="1" />
						</td>
					</tr>';
					
					if ($User['user_rights']&$Global['Right.Admin'])
					$res .= '<tr><td class="form_caption">
							'.$CAT->HTMLUserError("Товар опубликован:", 'good_check').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_check']?'checked':'').' maxlength="255" name="good_check" value="1" />
						</td>
					</tr>';
					
					$res .= '
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					</table>
					</form>
		
		
		
		</div>
		';
	
	return $res;
}

function get_good($id, $sc_id) {
	global $CAT;
	global $Global;
	global $SUBCAT;
	global $GOOD;
	global $User;
	global $DB;
	global $MAT;
	
	$id = (int)$id;
	//echo id;
	$GOOD->ReadOneObject($id);
	//var_dump($id);
	$SUBCAT->ReadSame((int)$sc_id);
	
	$subcats = '<select name="sc_id" >';
	foreach ($SUBCAT->Objects as $cat){
		$subcats .='<option value="'.$cat['sc_id'].'"'.(($sc_id==$cat['sc_id'])?'selected':"").' >'.$cat['sc_name'].'</option>';	
	}
	$subcats .='</select>';
	
	$prices = $MAT->GetPriceForGood($id);
	
	
	$res.='
		<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="good_id" value="'.$GOOD->Object['good_id'].'" />
					<input type="hidden" name="sender" value="edit_goods" />
					<table width="100%">
					
					<tr><td class="form_caption">
							Название товара:
						</td>
						<td class="form_input">
						<input maxlength="29" name="good_name" value="'.$GOOD->Object['good_name'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Артикл товара:
						</td>
						<td class="form_input">
						<input maxlength="255" name="good_art" value="'.$GOOD->Object['good_art'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Родительская категория:
						</td>
						<td class="form_input">
						'.$subcats.'
						</td>
					</tr>
					
					';
					if ($User['user_rights']&$Global['Right.Admin']) {
						$res .= '
						<tr><td class="form_caption">
								Цены:
							</td>
							<td class="form_input">
							</td>
						</tr>';
						
						foreach ($prices as $row) {
							$res.='<tr><td class="form_caption">
								'.$row['mat_name'].'
							</td>
							<td class="form_input">
							<input maxlength="255" name="mat['.$row['mat_id'].']" value="'.$row['matprice'].'" />
							</td>
						</tr>';
						}
					
					};
					$res.='<tr><td class="form_caption">
							Фотографии:
						</td>
						<td class="form_input">
						<button OnClick="AddPhoto(); return false;">Добавить фото</button>
						</td>
					</tr>';
					
					if ($id>0) {
						
							$tmp = $DB->ReadAss('Select * FROM o_photos where good_id='.$id);
							if ($tmp)
							foreach ($tmp as $row) {
								
								$res.= '<tr><td><img src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$row['photo_id'].'.jpg" ></td><td><input style="width: 200px" type="file" name="exphotos['.$row['photo_id'].']"><br />Удалить<input type="checkbox" value=1 name="delete'.$row['photo_id'].'"></td></tr>';
							}
					}
					
					
					$res.='<tr><td class="form_caption">
						</td><td class="form_input">
							<div id="photo1">
							</div>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Цвета:
						</td>
						<td class="form_input">
						<button OnClick="AddColor(); return false;">Добавить цвет</button>
						</td>
					</tr>
					
					';
					
					if ($id>0) {
						
							$tmp = $DB->ReadAss('Select * FROM colors where good_id='.$id);
							foreach ($tmp as $row) {
								
								$res.= '<tr><td></td><td><select onchange="this.style.background = this.value" name="color[]">'.
						 '<OPTION  '.(($row['color_value']=="")?'selected':'').' VALUE="">Выберите цвет'.
						 '<OPTION '.(($row['color_value']=="#000000")?'selected':'').' VALUE="#000000">Черный'.
						 '<OPTION '.(($row['color_value']=="#2e3192")?'selected':'').' VALUE="#2e3192">Синий'.
					     '<OPTION '.(($row['color_value']=="#79000e")?'selected':'').' VALUE="#79000e">Бордовый'.
					     '<OPTION '.(($row['color_value']=="#541214")?'selected':'').' VALUE="#8c6239">Коньяк'.
						 '<OPTION '.(($row['color_value']=="#335a44")?'selected':'').' VALUE="#335a44">Зелёный'.
						 '<OPTION '.(($row['color_value']=="#FFFFFF")?'selected':'').' VALUE="#FFFFFF">белый'.
						 '<OPTION'.(($row['color_value']=="blue")?'selected':'').' VALUE="blue">Голубой'.
					     '<OPTION '.(($row['color_value']=="aquamarine")?'selected':'').' VALUE="aquamarine">Аквамарин'.
					     '<OPTION '.(($row['color_value']=="chocolate")?'selected':'').' VALUE="chocolate">Шоколадный'.
					     '<OPTION '.(($row['color_value']=="darkred")?'selected':'').' VALUE="darkred">Темно-красный'.
					     '<OPTION '.(($row['color_value']=="gold")?'selected':'').' VALUE="gold">Золотой'.
					     '<OPTION '.(($row['color_value']=="red")?'selected':'').' VALUE="red">Красный'.
					     '<OPTION '.(($row['color_value']=="yellow")?'selected':'').' VALUE="yellow">Желтый'.
					     '<OPTION '.(($row['color_value']=="lime")?'selected':'').' VALUE="lime">Известковый'. 
					     '<OPTION '.(($row['color_value']=="darkkhaki")?'selected':'').' VALUE="darkkhaki">Хаки'.
					     '<OPTION '.(($row['color_value']=="cadetblue")?'selected':'').' VALUE="cadetblue ">Cadet Blue '.
					     '<OPTION '.(($row['color_value']=="darkgoldenrod")?'selected':'').' VALUE="darkgoldenrod">Dark Goldenrod'. 
					     '<OPTION '.(($row['color_value']=="darkslateblue")?'selected':'').' VALUE="darkslateblue">Darkslate Blou'.
					     '<OPTION '.(($row['color_value']=="deeppink")?'selected':'').' VALUE="deeppink">Deep Pink'.
					     '<OPTION '.(($row['color_value']=="salmon")?'selected':'').' VALUE="salmon">Цвет лосося'.
					     '<OPTION '.(($row['color_value']=="tan")?'selected':'').' VALUE="tan">Цвет загара'.
					     '<OPTION '.(($row['color_value']=="wheat")?'selected':'').' VALUE="wheat">Пшеничный'.
					     '<OPTION '.(($row['color_value']=="tomato")?'selected':'').' VALUE="tomato">Томатный'.
					     '<OPTION '.(($row['color_value']=="springgreen")?'selected':'').' VALUE="springgreen">Весенняя Зелень'.
					     '<OPTION '.(($row['color_value']=="turquoise")?'selected':'').' VALUE="turquoise">Бирюзовый'.
					     '</select></td></tr>';
							}
					}
					
					
					$res.='
					
					<tr><td class="form_caption">
						</td><td class="form_input">
							<div id="color">
							</div>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							Описание товара:
						</td>
					</tr>
					<tr>	
					<td class="form_input" colspan=2>
					';
						$EDITOR = new FCKeditor("good_desc");
						$EDITOR->Value = $GOOD->Object['good_desc'];
						$EDITOR->Width = "100%";
						$EDITOR->Height = "300px";
						$res.=$EDITOR->CreateHtml();
					
					$res.='</td></tr>
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("Рекламный товар:", 'good_adv').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_adv']?'checked':'').' maxlength="255" name="good_adv" value="1" />
						</td>
					</tr>
					
					';
					
					if ($User['user_rights']&$Global['Right.Admin'])
					$res .= '<tr><td class="form_caption">
							'.$CAT->HTMLUserError('В блок "новинки":', 'good_new').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_new']?'checked':'').' maxlength="255" name="good_new" value="1" />
						</td>
					</tr>';
					
					if ($User['user_rights']&$Global['Right.Admin'])
					$res .= '<tr><td class="form_caption">
							'.$CAT->HTMLUserError('В блок "Бестселлеры":', 'good_bestceller').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_bestceller']?'checked':'').' maxlength="255" name="good_bestceller" value="1" />
						</td>
					</tr>';
					
					if ($User['user_rights']&$Global['Right.Admin'])
					$res .= '<tr><td class="form_caption">
							'.$CAT->HTMLUserError("Товар опубликован:", 'good_check').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_check']?'checked':'').' maxlength="255" name="good_check" value="1" />
						</td>
					</tr>';
					
					$res .= '
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					<tr><td class="form_caption">';
						if($GOOD->Object['good_id']) { 
						$res .= '<input class="button" type="submit" onclick="return confirm(\'Вы действительно хотите удалить?\');" name="delete" value="Удалить">';
						} 
					$res.='
					</td><td class="form_input"></td></tr>
					</table>
					</form>
		';
	
	return $res;
}

function add_good($good_id, $matprice, $koefname) {
	$good_id = (int)$good_id;
	$matprice = (float)$matprice;
	
	global $DB;
	global $BASKET;
	
	$mat_id = $DB->ReadScalar('select mat_id from mat_price WHERE good_id = '.$good_id.' AND matprice='.$matprice);
	
	$kol = explode(' ', $koefname);
	$kol = (int)array_pop($kol);
	
	if ($kol>1) $kol--;
	else $kol=1;
	
	$BASKET->AddToBasket($good_id, $mat_id, $kol);
	return $BASKET->GetGoodsCount();
	
}

function delete_good($good_id, $mat_id) {
	global $BASKET;
	
	$mat_id = (int)$mat_id;
	$good_id = (int)$good_id;
	
	return $BASKET->DeleteFromBasket($good_id, $mat_id);
}

function save_count($good_id, $mat_id, $count) {
	global $BASKET;
	
	$good_id = (int)$good_id;
	$mat_id = (int)$mat_id;
	$count = (int)$count;
	
	$BASKET->SaveCount($good_id, $mat_id, $count);
}

function show_page($page, $param) {
	global $GALLERY;
	
	switch ($page) {
	
	case "otziv":
		$res = '
		<table style="width: 100%; height: 100%;"><tr valign = top><td align =center>
		<table style="margin-top: 150px" cellspacing=0 cellpadding=0>
		<tr>
		<td class="popup">
		<h1>Добавить отзыв</h1>
		<form class="edition_form" id="otziv" name="otziv" action="" method="post" enctype="multipart/form-data">

	<input type="hidden" name="sender" value="add_comment" />
					<b>Имя:</b> <br/>
					 <input style="width: 563px" name="recall_name" /><br /><br />
						<b>Отзыв:</b> <br />
					<textarea style="width: 563px; height: 95px" name="recall_text"></textarea><br />
					<b>Код:</b>
					<img height=30 src="'.$Global['Host'].'/captcha.php" ><br />
					 <input style="width: 100px; height: 14px; margin-top: 7px; float: left;" name="recall_key" />	
					 <div class="otsub" OnClick="document.getElementById(\'otziv\').submit()" ></div>
					
	</form>
	
	<div style="width: 80px; clear:both; float:right; padding-top:30px; text-decoration:underline;"><a href="#" OnClick="CloseLayer();">Закрыть это окно</a></div>
		</td>
		<td class="puright">&nbsp;</td>
		</tr>
		<tr>
		<td class="pubottom">&nbsp;</td>
		<td class="pucorner">&nbsp;</td>
		</tr>
		
		</table>
		</td></tr></table>';
	break;
	
	case "confirm_zak":
		$res = '
		<table style="width: 100%; height: 100%;"><tr valign = top><td align =center>
		<table style="margin-top: 120px" cellspacing=0 cellpadding=0>
		<tr>
		<td class="popup">
		<h1>Подтверждение заказа</h1>
		<form method="POST" name="basket" enctype="multipart/form-data">
	<input type="hidden" name="sender" value="zakconfirm" />
		Выберите файл:<br /> <input size=39 style="font-family:monospace; width: 332px; height: 24px;" type="file" name="add_file" /><br />
	Комментарий: <br />
	<textarea style=" width: 328px; height: 200px" name="order_com"></textarea>
	</form>
					 <div OnClick="zakConfirm(); return false; " class=bassave style="margin-left: 0px; margin-top: 10px"></div>
					
	</form>
	
	<div style="width: 80px; clear:both; float:right; padding-top:30px; text-decoration:underline;"><a href="#" OnClick="CloseLayer();">Закрыть это окно</a></div>
		</td>
		<td class="puright">&nbsp;</td>
		</tr>
		<tr>
		<td class="pubottom">&nbsp;</td>
		<td class="pucorner">&nbsp;</td>
		</tr>
		
		</table>
		</td></tr></table>';
	break;
		
	case "login":
		
		$res = '
		<table style="width: 100%; height: 100%;"><tr valign = top><td align =center>
		<table style="margin-top: 150px" cellspacing=0 cellpadding=0>
		<tr>
		<td class="popup">
		<div class="login"></div>
		Логин:<br />
		<input onKeyPress="LoginOnEnter(event)" id="login" style="margin-bottom: 10px" /><br />
		Пароль:<br />
		<input type="password" onKeyPress="LoginOnEnter(event)" id="password" style="width:165px; float:left;" /><div OnClick="TryLogin()" id="enter" class="enter"></div><br />
		<div style="clear:left; float:left; padding-top:2px; text-decoration:underline; cursor: pointer;" OnClick="GetOnLayer(\'SendPass\')"">Забыли пароль?</div>
		<div style="float:right; padding-top:2px; text-decoration:underline; cursor: pointer;" OnClick="GetOnLayer(\'registration\')">Регистрация</div>
		
		<div style="width: 80px; clear:both; float:right; padding-top:30px; text-decoration:underline;"><a style="color:#40709f;" href="#" OnClick="CloseLayer();">Закрыть это окно</a></div>
		</td>
		<td class="puright">&nbsp;</td>
		</tr>
		<tr>
		<td class="pubottom">&nbsp;</td>
		<td class="pucorner">&nbsp;</td>
		</tr>
		
		</table>
		</td></tr></table>';
	break;
	
	case "SendPass":
		
		$res = '
		<table style="width: 100%; height: 100%;"><tr valign = top><td align =center>
		<table style="margin-top: 150px" cellspacing=0 cellpadding=0>
		<tr>
		<td class="popup">
		<h1>Восстановление пароля</h1>
		e-mail:<br />
		<input style="width: 246px" id="pasmail" style="margin-bottom: 10px" /><br />
		<div style="float:left; padding-top:2px; text-decoration:underline; cursor: pointer;" OnClick="SendPass()">Получить пароль</div>
		
		<div style="width: 80px; clear:both; float:right; padding-top:30px; text-decoration:underline;"><a style="color:#40709f;" href="#" OnClick="CloseLayer();">Закрыть это окно</a></div>
		</td>
		<td class="puright">&nbsp;</td>
		</tr>
		<tr>
		<td class="pubottom">&nbsp;</td>
		<td class="pucorner">&nbsp;</td>
		</tr>
		
		</table>
		</td></tr></table>';
	break;
	
	case "registration":
		
		$res = '
		<table style="width: 100%; height: 100%;"><tr valign = top><td align =center>
		<table style="margin-top: 10px" cellspacing=0 cellpadding=0>
		<tr>
		<td class="popupr">
		<div class="reg"></div>
		Логин*:<br />
		<input id="login" style="margin-bottom: 3px" /><br />
		Пароль*:<br />
		<input type="password" id="password" style="margin-bottom: 3px" /><br />
		Ещё раз введите пароль*:<br />
		<input type="password" id="retry" style="margin-bottom: 3px" /><br />
		Название организации:<br />
		<input id="org" style="margin-bottom: 3px" /><br />
		Вид деятельности организации:<br />
		<input id="doing" style="margin-bottom: 3px" /><br />
		Адрес организации:<br />
		<input id="adr" style="margin-bottom: 3px" /><br />
		Город*:<br />
		<input id="town" style="margin-bottom: 3px" /><br />
		Фамилия:<br />
		<input id="soname" style="margin-bottom: 3px" /><br />
		Имя*:<br />
		<input id="name" style="margin-bottom: 3px" /><br />
		Отчество:<br />
		<input id="pname" style="margin-bottom: 3px" /><br />
		E-mail*:<br />
		<input  id="user_mail" style="margin-bottom: 3px" /><br />
		Не возражаю против рассылки новостей и акций компании
		<input id="nonpro" checked  type="checkbox" style="width: 20px; border: 0px" /><br />
		<div style="clear:left; float:left; padding-top:10px;">* обязательно для заполнения</div>
		<div style="float:right; padding-top:10px; text-decoration:underline; cursor: pointer" OnClick="TryRegister();">Зарегистрироваться</div>
		
		<div style="width: 80px; clear:both; float:right; padding-top:30px; text-decoration:underline;"><a href="#" OnClick="CloseLayer();">Закрыть это окно</a></div>
		</td>
		<td class="puright">&nbsp;</td>
		</tr>
		<tr>
		<td class="pubottom">&nbsp;</td>
		<td class="pucorner">&nbsp;</td>
		</tr>
		
		</table>
		</td></tr></table>';
	break;
	
	case "gallery" :
		
		$res = '
		<table style="width: 100%; height: 100%;"><tr valign = top><td align =center>
		<table style="margin-top: 150px" cellspacing=0 cellpadding=0>
		<tr>
		<td class="popupr" style="border: 0px; padding: 10px;">';
		
		$res .= $GALLERY->ShowOne($param);
		
		$res .= '
		</td>
		<td class="puright">&nbsp;</td>
		</tr>
		<td class="pubottom">&nbsp;</td>
		<td class="pucorner">&nbsp;</td>
		</tr>
		
		</table>
		</td></tr></table>';
	break;
	
	case "feedback" :
		
		$res ='
		<table style="width: 100%; height: 100%;"><tr valign = top><td align =center>
		<table style="margin-top: 10px" cellspacing=0 cellpadding=0>
		<tr>
		<td class="popupr">
		<h1>Обратная связь</h1>
		ФИО <br /> 
		<input id="mesfio" /> <br /> 
		Тема <br />
		<input id="mestopic" />  <br />
		Ваш электронный адрес * <br />
		<input id="mesmail" /> <br /> 
		Текст сообщения * <br />
		<textarea style="width: 400px; height:200px" id="mestext"></textarea>  <br />
		<div style="clear:left; float:left; padding-top:10px;">* обязательно для заполнения</div>
		<div style="float:right; padding-top:10px; text-decoration:underline; cursor: pointer" OnClick="TrySendMess();">Отправить</div>
		
		<div style="width: 80px; clear:both; float:right; padding-top:30px; text-decoration:underline;"><a href="#" OnClick="CloseLayer();">Закрыть это окно</a></div>
		</td>
		<td class="puright">&nbsp;</td>
		</tr>
		<tr>
		<td class="pubottom">&nbsp;</td>
		<td class="pucorner">&nbsp;</td>
		</tr>
		
		</table>
		</td></tr></table>';
	break;
	}
	return $res;
}

function feedback($fio, $topic, $mail, $text) {
	global $ALARM;
	
	$text = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $text);
	
	$topic = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $topic);
	
	$mail = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $mail);
	
	$fio = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $fio);
	
	$res=array();
	if (!trim($mail))
		return array('Error'=>'Не введён обратный адрес');
	if (!trim($text))
		return array('Error'=>'Не введён текст сообщения');
	
	$text = 'Отправлено с '.$Global['Host']."\n".$text;
	
	$text .="\r\nАдрес отправителя: ".$mail;  
	$text .="\r\nФИО отправителя: ".$fio;
	
	$ALARM->Mail($topic,$Global['AdminMail'], $text, $mail);
	
	return array('Error'=>'Спасибо, Ваше сообщение отправленно', 'res'=>1);
}

function login($login, $pass) {
	global $Errors;
	global $HTTP_POST_VARS;
	global $USER;
	global $BASKET;
	global $Global;
	global $_SERVER;
	
	$HTTP_POST_VARS['user_login'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $login);
	$HTTP_POST_VARS['user_password'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $pass);
	$USER->Login();
	
	if (count($Errors)) {
		
		$res=array('succesful'=>false, 'error'=>array_pop($Errors));
	} else {
		
		if ($BASKET->GetGoodsCount()!=0) {
			$page = $Global['Host'].'/basket';
		} else {
			$page = $_SERVER['HTTP_REFERER'];
		}
		$res=array('succesful'=>true, 'location'=>$page);
	}
	
	return $res;
}

function reg(
		$login,
		$pass,
		$retry,
		$org,
		$doing,
		$adr,
		$town,
		$name,
		$soname,
		$pname,
		$mail,
		$nonpro
		){
	
	global $HTTP_POST_VARS;
	global $USER;
	global $Global;
	global $Errors;
	
	$HTTP_POST_VARS['user_login'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $login); 
	$HTTP_POST_VARS['user_password'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $pass);
	$HTTP_POST_VARS['user_retry'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $retry);
	$HTTP_POST_VARS['user_org'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $org);
	$HTTP_POST_VARS['user_doing'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $doing);
	$HTTP_POST_VARS['user_adr'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $adr);
	$HTTP_POST_VARS['user_town'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $town);
	$HTTP_POST_VARS['user_name'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $name);
	$HTTP_POST_VARS['user_soname'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $soname);
	$HTTP_POST_VARS['user_pname'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $pname);
	$HTTP_POST_VARS['user_mail'] = preg_replace('#%u([0-9A-F]{4})#se',
                  'iconv("UTF-16BE","Windows-1251",pack("H4","$1"))',
                  $mail);
	$HTTP_POST_VARS['user_nonpro'] = $nonpro?1:0;
	
	$f = $USER->Register();
	
	if (count($Errors)) {
		
		$res=array('succesful'=>$f, 'error'=>array_pop($Errors));
	} else {
		
		$res=array('succesful'=>$f);
	}
	
	return $res;
	
}

function delete_from_order($good_id, $mat_id, $order_id) {
	global $BASKET;
	
	$mat_id = (int)$mat_id;
	$good_id = (int)$good_id;
	$order_id = (int)$order_id;
	return $BASKET->DeleteFromOrder($good_id, $mat_id, $order_id);
}

function get_arh($type, $month, $year) {
	Global $NEW;
	
	$type = (int)$type;
	$month = (int)$month;
	$year = (int)$year;
	
	if (!$year) {
		if ($month) {
			
			$years = $NEW->ReadYears();
			$int.='1 ';
			
			foreach ($years as $row) {
				
				$stime = mktime(1,0,0,$month,1,$row);
				$etime = mktime(1,0,0,$month+1,1,$row);
				$int .= " AND new_date>=$stime AND new_date<$etime";
			}
		} else $int = "1";
	} else {
		
		if (!$month) {
			
			$stime = mktime(1,0,0,1,1,$year);
			$etime = mktime(1,0,0,12,1,$year);
			$int = "new_date>=$stime AND new_date<$etime";
		} else {
			$stime = mktime(1,0,0,$month,1,$year);
			$etime = mktime(1,0,0,$month+1,1,$year);
			$int = "new_date>=$stime AND new_date<$etime";
		}
	} 
	
	if ($type>=0)
		$cond = "new_type=$type AND $int";
	else $cond = $int;
	$res = '<div class="arh_cap"></div><br />';
	return $res.($NEW->aShowLastNews(0,$cond));
}

function show_new($id) {
	global $NEW;
	
	$id = (int)$id;
	$NEW->ReadOneObject($id);
	$res =  '<b>'.(date("d.m.Y", $NEW->Object['new_date'])).'<br/>'.$NEW->Object['new_prew'].'</b><br /><br />';
	$res .= $NEW->Object['new_text'];
	
	return $res;
}

function send_pass($mail) {
	global $ALARM;
	global $Global;
	global $DB;
	
	$mail = addslashes($mail);
	if (!$mail) return array('success'=>0, 'info'=>'e-mail пуст');
	$tmp = $DB->ReadAssRow('select * from users where user_mail="'.$mail.'"');
	if (!$tmp) return array('success'=>0, 'info'=>'Учётной записи с таким e-mail не существует');
	else {
		
		$ALARM->Mail('Восстановление пароля на сайте '.$Global['Host'], $mail, 
			'Ваш пароль: '.$tmp['user_password']);
			
		return array('success'=>1, 'info'=>'Пароль выслан Вам на почту');
		
	}
}

function add_to_spam($mail) {
	global $ALARM;
	global $Global;
	global $USER;
	global $inf;
	
	
	$mail = addslashes($mail);
	$mail = $USER->CleanEmail($mail);
	if (!$mail) return array('success'=>0, 'info'=>'e-mail пуст или введён не корректно');
	
	$f = $USER->DB->ReadScalar('select mail from spam where mail="'.$mail.'"');
	
	if ($f) return array('success'=>0, 'info'=>'Ваш e-mail уже есть в списке рассылки');
	
	$USER->AddSpam(array('mail'=>$mail));
	return array('success'=>1, 'info'=>'Вы были добавлины в список рассылки');
}

function delete_spam($id) {
	global $DB;
	
	$id = (int)$id;
	$DB->DeleteDB('spam', 'spam_id='.$id);
}

$sajax_request_type = "POST";
$sajax_remote_uri = $Global['Host'].'/ajax.php';
sajax_init();
sajax_export("get_pgroup", "get_users", "get_user", "delete_spam", "add_to_spam", "send_pass", "feedback", "show_new", "get_arh", "delete_from_order", "reg", "login", "show_page", "save_count", "get_news", "get_cat", "get_subcats", "get_subcat", "get_goods", "get_good", "add_good", "delete_good");
sajax_handle_client_request();	
?>