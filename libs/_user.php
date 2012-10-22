<?php
class User extends IntegratedDataBase {
	var $NTable = 'users';
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function Login() {
		global $HTTP_POST_VARS;
		global $Global;
		global $Errors;
		global $User;
		global $BASKET;
		
		global $_SESSION;
		
		$Vars = $HTTP_POST_VARS;
		
		$User = $this->DB->ReadAssRow("SELECT * FROM {$this->NTable} WHERE user_login='".addslashes($Vars['user_login'])."' AND user_password='".addslashes($Vars['user_password'])."'");
		
		if (!$User) {
			$Errors['Password'] = $Global['Error password'];

			return;
		}
		
		$this->ReadOneObject($User['user_id']);
		
		if (!$this->Object['user_checked']) {
			$Errors['Check'] = 'Вход не возможен. Учётная запись не активированна
Вам на почту('.$this->Object['user_mail'].') было выслано письмо. 
Пожалуйста, ознакомтесь с его содержанием.
Если Вы не правильно указали почту, зарегистрируйтесь ещё раз';
			return;
		}
		
		$User = $this->Object;
		
		$User['Rights'] = $User['user_rights']; 
		
		$_SESSION['User'] = $User;
		
		$BASKET->FromSessionToDB();
	}
	
	function ChangePass() {
		global $HTTP_POST_VARS;
		global $Global;
		global $Errors;
		global $User;
		
		$old_pass = $HTTP_POST_VARS['old_password'];
		
		$User1 = $this->DB->ReadAssRow("SELECT * FROM {$this->NTable} WHERE 'user_id' = {$User['user_id']} AND user_password='".addslashes($old_pass)."'");
		
		if (!User1) {
			$Errors['Old Password'] = $Global['Error password'];
			return;
		}
		
		if ($HTTP_POST_VARS['new_password'] != $HTTP_POST_VARS['retry_password']) {
			$Errors['Retry Password'] = $Global['Error password'];
			return;
		}
		
		$User1['user_password'] = $HTTP_POST_VARS['new_password'];
		
		$this->DB->EditDB($User1 , $this->NTable, "user_id = {$User['user_id']}");
		$this->Go($Global['Host']);
	}
	
	function CheckRights($Page, $User) {
		global $Access; 
		
		if (!$Access[$Page]) return true;
		
		
		if ($User['Rights'] & $Access[$Page]) return true;
		
		return false;
	}
	
	function Logout() {
		global $PAGE;
		
		session_unregister('User');
		$PAGE->ShowPage();
	}
	
	
	function ReadAll($pgroup_id) {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} where pgroup_id=$pgroup_id ORDER BY user_login");
		
	}
	
	function ReadOneObject($ObjectID){
		global $GROUP;
		if($ObjectID) {
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE user_id='$ObjectID'",'*1');
			if ($this->Object['group_id']) {
			
				$GROUP->ReadOneObject($this->Object['group_id']);
				$this->Object['koef'] = $GROUP->Object['group_koef'];
			} else $this->Object['koef'] = 1;
		}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);
	}
	
	function CheckSentVars(&$Vars) {
		global $Global;
		global $Errors;
		
		$Vars['user_login'] = trim($Vars['user_login']);
		if (!$Vars['user_login']) {
			$Errors['user_login'] = $Global['No value'];
			return false;
		}
		$t = $this->DB->ReadScalar('Select user_login from '.$this->NTable.' where user_login = "'.$Vars['user_login'].'" AND user_id != '.((int)$Vars['user_id']));
		if ($t) {
			$Errors['user_login'] = $Global['Exist value'];
			return false;
		}
		
		return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = (int)$Vars['user_id'];
		$Vars['user_id'] = $ObjectID;
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		unset($Vars['user_mail']);
		
		//add
		if(!$ObjectID){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_users/{$Vars['pgroup_id']}/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if (!$this->CheckSentVars($Vars)) return;
			$this->DB->EditDB($Vars,$this->NTable,"user_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_users/{$Vars['pgroup_id']}/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			$this->DB->DeleteDB($this->NTable, 'user_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_users/{$Vars['pgroup_id']}");
		}
		
	}
	
	function Register() {
		global $ALARM;
		global $HTTP_POST_VARS;
		global $Global;
		global $Errors;
		
		global $Success;
		
		$Success = "";
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$Vars['user_checked'] = 0;
		$Vars['user_checkcode'] = (rand(1000, 9999)).(rand(23,78)).rand(100,999);
		
		$Vars['user_rights'] = $Global['Right.User'];
		$Vars['group_id'] = 1;
		
		$Vars['user_login'] = $this->CleanEngStr($Vars['user_login']);
		if (!$Vars['user_login']) {
			$Errors['user_login'] = "Не введён логин (Логин должен состоять из латинских букв или цифр)";
			return false;
		}
		$t = $this->DB->ReadScalar('Select user_login from '.$this->NTable.' where user_login = "'.$Vars['user_login'].'"');
		if ($t) {
			$Errors['user_login'] ='Такой логин уже существует';
			return false;
		}
		
		$Vars['user_name'] = trim($Vars['user_name']);
		if (!$Vars['user_name']) {
			$Errors['user_name'] = "Не введено имя";
			return false;
		}
		
		$Vars['user_soname'] = trim($Vars['user_soname']);
		
		
		$Vars['user_pname'] = trim($Vars['user_pname']);
		$Vars['user_doing'] = trim($Vars['user_doing']);
		
		
		$Vars['user_adr'] = trim($Vars['user_adr']);
		
		
		$Vars['user_town'] = trim($Vars['user_town']);
		if (!$Vars['user_town']) {
			$Errors['user_town'] = "Не введен город";
			return false;
		}
		
		$Vars['user_mail'] = $this->CleanEmail(trim($Vars['user_mail']));
		if (!$Vars['user_mail']) {
			$Errors['user_mail'] = "Не введена почта, или введена не правильно";
			return false;
		}
		$t = $this->DB->ReadScalar('Select user_mail from '.$this->NTable.' where user_mail = "'.$Vars['user_mail'].'"');
		if ($t) {
			$Errors['user_mail'] ='Такоя почта уже существует';
			return false;
		}
		if ($Vars['user_password'] != $Vars['user_retry']) {
			$Errors['user_retry'] = $Global['Error retry'];
			return false;
		}
		
		unset($Vars['user_retry']);
		unset($Vars['rs']);
		unset($Vars['rst']);
		unset($Vars['rsargs']);
		unset($Vars['rsrnd']);
		
		$this->DB->EditDB($Vars,$this->NTable);
		$ObjectID = $this->DB->LastInserted;
		
		
		$ALARM->Mail('Регистрация на сайте '.$Global['Host'], $Vars['user_mail'], 
			'Вы были зарегистрированны на сайте '.$Global['Host'].' под логином '.$Vars['user_login'].'
			Для завершения регистрации перейдите по ссылке: '.$Global['Host'].'/check/'.$ObjectID.'/'.$Vars['user_checkcode']);
		
		$Errors['AllOk'] = 'На '.$Vars['user_mail'].' было выслано письмо с ссылкой, 
необходимой для завершения регистрации';
		
		if ($Vars['user_nonpro']) $this->AddSpam(array('mail'=>$Vars['user_mail']));
		
		return true;
		
		//$this->Login();
		
	}
	
	function AddSpam($Vars) {
		//global $HTTP_POST_VARS;
		global $Global;
		global $ALARM;
		global $inf;
		
		//$Vars = $HTTP_POST_VARS;
		//unset($Vars['sender']);
		
		if (!$Vars['mail']) {
			$inf = 'e-mail пуст или введён не корректно';
			return false;
		}
		
		if (!$Vars['mail']) {
			$inf = 'e-mail пуст';
			return false;
		}
		
		$Vars['spam_checkcode'] = (rand(1,100)).(rand(400,9999)).(rand(0,9999));
		
		$this->DB->EditDB($Vars,'spam');
		$ObjectID = $this->DB->LastInserted;
		$ALARM->Mail('Вы подписались на рассылку сайта '.$Global['Host'], $Vars['mail'], 
'Вы подписались на рассылку сайта '.$Global['Host'].'
Чтобы отказаться от рассылки перейдите по ссылке '.$Global['Host'].'/'.'delfromsend/'.$ObjectID.'/'.$Vars['spam_checkcode']);
		
		return true;
	}
	
}
?>