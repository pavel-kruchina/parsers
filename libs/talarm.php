<?

class Alarm extends IntegratedDataBase{
	
	Function Mail($Reason,$Adress, $Text = '', $sender='�������� ������') {
	global $Global;	
	
	if (!$sender) $sender='�������� ������';
	
		$headers = 
'Content-Type: text/plain; charset="windows-1251"
From: '.$sender.'
';
		
						
		$message .= $Text; $Subject .= $Reason;
		
		mail($Adress, $Subject, $message, $headers,'-finfo@galkom.ru');
		
	}
	
	
} 
?>