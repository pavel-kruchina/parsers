<?php
$refer = 'http://ya.ru';
$brouser = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.4) Gecko/2008102920 Firefox/3.0.4";

$out = "GET /sinh.php HTTP/1.0\r\n";
$out .= "Host: galkom.ru:80\r\n";
$out .= "Referer: {$refer}\r\n";
$out .= "User-Agent: {$brouser}\r\nAccept:	text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n";
$out .= "\r\n";
$sock = fsockopen("galkom.ru", 80, $errno, $errstr, 4);

	if (!$sock) { 
			echo $errstr; 
	}
	else {
	fwrite($sock, $out);
	
	while (!feof($sock)) {
		
		$str .= fgets($sock);
		//echo $str;
	}
	}
	//var_dump ($str);
	$arh = explode('##', $str);
	//var_dump ($arh);
	$arh = $arh[1];
	
	$arh = unserialize($arh);
	
	foreach ($arh as $table => $dump) {
		
		$DB->DeleteDB($table, 1);
		foreach ($dump as $row) {
			$DB->EditDB($row, $table);
		}
	}
?>

Всё ок. синхронизировались.