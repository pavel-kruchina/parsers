<?php

$str = $HTTP_SERVER_VARS['REQUEST_URI'];
$str = explode('?', $str);
$str = $str[0];
if (!$str) {

} else {
	$Global['Url.Page'] = explode('/', substr($str,1)); 
}



 if ($HTTP_POST_VARS) {
	
	switch ($HTTP_POST_VARS['sender']) {

		case 'change_short': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			changeShort();
			break;
		
		case 'change_del': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			changeDel();
			break;
		
		case 'set_koef': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
		
			setKoef();
			break;
		
		case 'edit_cats': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$CAT->Edit();
			break;
		
		case 'edit_pgroups': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$PGROUP->Edit();
			break;
		
		case 'edit_gallery': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$GALLERY->Edit();
			break;
		
		case 'registration': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$USER->Register();
			break;
			
		case 'zakconfirm': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$BASKET->ZakConfirm();
			break;
		
		case 'delete_zak': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			$BASKET->DeleteOrder();
			break;
		
		case 'delete_zak_man': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			$BASKET->ManDeleteOrder();
			$DB->Go($Global['Host'].'/edit_orders');
			break;
		
		case 'zak': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			$BASKET->OrderProcess();
			break;
		
		case 'edit_subcats': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$SUBCAT->Edit();
			break;
		
		case 'edit_mats': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$MAT->Edit();
			break;
		
		case 'edit_users': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$USER->Edit();
			break;
		
		case 'edit_goods': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$GOOD->Edit();
			break;
		
		case 'edit_koefs': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$KOEF->Edit();
			break;
		
		case 'edit_classes': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$CLASS->Edit();
			break;
		
		case 'edit_models': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$MODEL->Edit();
			break;
		
		case 'login': 
			$USER->Login();
			if (!count($Errors))
				$DB->Go($Global['Host']);
			break;
			
		case 'change_password': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$USER->ChangePass();
			break;
		
		case 'edit_objects': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$OBJECT->Edit();
			break;
			
		case 'edit_news': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$NEW->Edit();
			break;
			
		case 'edit_pages': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$PAGE->Edit();
			break;
		
		case 'change_phone': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			changePhone();
			break;
		
		case 'change_flash': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			changeFlash();
			break;
		
		case 'change_seo': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			changeSEO();
			break;
		
		
		case 'change_mail': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			changeMail();
			break;
		
		case 'edit_sections': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$SECTION->Edit();
			break;
		
		case 'changePC': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			changePC();
			break;
			
		case 'edit_carency': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$CARENCY->Edit();
			break;
		
		case 'edit_groups': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$GROUP->Edit();
			break;
		
		case 'edit_baners': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$BANER->Edit();
			break;
		
		case 'add_to_spam': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$USER->AddSpam();
			break;
		
		case 'order': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			SendOrder();
			break;
		
		case 'add_comment': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$OTZIV->AddComment();
			break;
		
		case 'delete_comment': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$OTZIV->DeleteComment();
			break;
		
		case 'adm_comment': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$OTZIV->AdmComment();
			break;
		
		
		case 'feed_back': 
			if (!$USER->CheckRights($HTTP_POST_VARS['sender'], $User)) break;
			
			$HTTP_POST_VARS['text'] = '���������� � '.$Global['Host']."\n".$HTTP_POST_VARS['text'];
			
			$HTTP_POST_VARS['text'] .="\r\n����� �����������: ".$HTTP_POST_VARS['mail'];  
			$HTTP_POST_VARS['text'] .="\r\n��� �����������: ".$HTTP_POST_VARS['fio'];
			
			$ALARM->Mail($HTTP_POST_VARS['topic'],$Global['AdminMail'], $HTTP_POST_VARS['text']);
			$sended="�������, ���� ��������� �����������";
			break;
	}
	
}
	
	switch ($Global['Url.Page'][0]) {
		
		case 'edit_cats':
		{
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_cats.php');
			break;
		}
		
		case 'sinh':
		{
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/sinh.php');
			break;
		}
		
		case 'basket':
		{
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/basket.php');
			break;
		}
		
		case 'check':
		{
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/check.php');
			break;
		}
		
		case 'delfromsend':
		{
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/delfromsend.php');
			break;
		}
		
		case 'edit_spam':
		{
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_spam.php');
			break;
		}
		
		case 'edit_mats':
		{
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_mats.php');
			break;
		}
		
		case 'catalog':
		{
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/catalog.php');
			break;
		}
		
		case 'edit_koefs': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_koefs.php');
			break;
		
		case 'edit_carency': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_carency.php');
			break;
			
		case 'edit_orders': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_orders.php');
			break;
		
		case 'edit_regions': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_regions.php');
			break;
		
		case 'edit_groups': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_groups.php');
			break;
		
		case 'edit_dop': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_dop.php');
			break;
		
		case 'edit_gallery': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_gallery.php');
			break;
		
		case 'edit_news': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_news.php');
			break;
			
		
		case 'news': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
					
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/news.php');
			break;

		case 'arhnews': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/arhnews.php');
			break;
		
		case 'edit_users': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_users.php');
			break;
		
		case 'search': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/search.php');
			break;
			
			
		case 'admin': 
			include("pages/admin.php");
			break;
		
		case 'change_password': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/change_password.php');
			break;
		
		case 'contacts': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/contacts.php');
			break;
		
		case 'edit_spetial': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_spetial.php');
			break;
		
		case 'edit_baners': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_baners.php');
			break;
		
		case 'edit_pages': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_pages.php');
			break;
		
		case 'calc': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/calc.php');
			break;
		
		case 'about': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/about.php');
			break;
			
		case 'edit_users': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/edit_users.php');
			break;	
		
		case 'order': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/order.php');
			break;
		
		case 'otziv': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/otziv.php');
			break;
		
		case 'registration': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/registration.php');
			break;
			
		
		case 'gallery': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			include('pages/gallery.php');
			break;
		
		case 'logout': 
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();
				
				break;
			}
			
			$USER->Logout();
			$DB->Go($Global['Host']);
			break;
		
		default:
			if (!$USER->CheckRights($Global['Url.Page'][0], $User)) {
				$PAGE->ShowPage();

				break;
			}

			include('pages/catalog.php');
			break;
			//$PAGE->ShowPage();
	}

?>