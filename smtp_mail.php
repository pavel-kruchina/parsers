<?
//exit;
ini_set("max_execution_time", 15000);

include("class.phpmailer.php");

		$body = file_get_contents("index.html");
		
		$body 			  = str_replace("\t", "", $body);
		$body             = eregi_replace("[\]",'',$body);
		
		$mail             = new PHPMailer();
		
		$mail->Host = 'galkom.ru';
		$mail->Port = 21;
		//$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth = true;
		$mail->Username = 'lgnews';
		$mail->Password = 'lgnews8';
		$mail->SMTPKeepAlive = true;
		
		$mail->CharSet 	  = 'windows-1251';
		$mail->From       = "info@galkom.ru";
		$mail->FromName   = "Galkom";
		$mail->AddReplyTo('info@galkom.ru', 'Galkom');
		$mail->Subject    = "Дайджест от Galkom";
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		$mail->MsgHTML($body);


		$mail_trash = file_get_contents("mails.txt");
		if (preg_match_all('|([\w\d\._-]+@[\w\d\.-]+)|is', $mail_trash, $pockets)) {
			$subscribers = $pockets[1];
		}
		
		$deleted = file_get_contents("zapret.txt");
		if (preg_match_all('|([\w\d\._-]+@[\w\d\.-]+)|is', $deleted, $pockets)) {
			$del_subscribers = $pockets[1];
		}
		$subscribers = array_diff_assoc($subscribers, $del_subscribers);
		
		/*
		$subscribers = array(
			'apuzanok@publicismodem.ru',
			'allexx8266@yandex.ru',
		);
		*/
						
		$used_emails = explode("\n", file_get_contents("mailer_process.txt"));
		
		$ff = fopen("mailer_process.txt", "a+t");
		if ($ff) {
			fwrite($ff, "\n");
			$i = 0;



			foreach ($subscribers as $user) {
				$i++;
				if (!in_array($user, $used_emails)) {
					
					$mail->SetAddress($user, $user);
					if(!$mail->Send()) {
						echo "$i) Mailer Error: " . $mail->ErrorInfo . "<br />";
					} else {
						echo "$i) $user $user $user $user $user $user $user $user $user $user $user $user<br />";
						fwrite($ff, "$user\n");
					}
					/* sleep(mt_rand(4,8)); */
					sleep(mt_rand(1,3));					
				}



			}



		}
		
		fclose($ff);
		
		$mail->SmtpClose();
		
?>