<?php
class Error{

	var $ErrorDescr;

	var $ErrorClass;
	var $ErrorFunction;
	var $ErrorName;

	var $ErrorStyle=
		"background-color: #E5E5E5;
		padding: 5px;
		color: #D10000;
		border-style: solid;
		border-width: 1px;
		border-color: #900000;
		";

	function MySQLError($Name){
		
		$this->ErrorReply = mysql_error();
		echo(	"<div style=\"{$this->ErrorStyle}\">".
			"<b>MySQL Error!</b> ".
			"Name: <b>{$Name}</b>. ".
			"<br />MySQL answer: <b>{$this->ErrorReply}</b>. ".
			"</div>");
		exit();
	}

	function MakeUserError($ErrorText){
		global $Global;
		$Global['Error']=$ErrorText;
		return false;
	}

	function MakeUserInfo($InfoText){
		global $Global;
		$Global['Info']=$InfoText;
		return true;
	}

	function Go($Path){
		?>
		<script language="JavaScript">
		<!--
		document.location='<?php echo $Path; ?>';
		-->
		</script>
		<?php
	//exit();
	}
	
	//очистка значений почты от хтмл тэгов и лишних символов
	function CleanEmail($Str){
		$TempStr=ereg_replace("((<[^<.]*>)|(<[^>.]*)|([^<.]*>)|[^a-zA-Z0-9@_\\.])",'',$Str);
		$TempStr=ereg_replace(" +",' ',$TempStr);
		$TempStr=trim($TempStr);
		
		if (!preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $TempStr)) return false;

		return $TempStr;
	}
	
	//очистка строки от хтмл тэгов и лишних символов
	function CleanStr($Str){
		$TempStr=ereg_replace("((<[^<.]*>)|(<[^>.]*)|([^<.]*>)|[^ a-zA-Zа-яА-Я@_\\-])",'',$Str);
		$TempStr=ereg_replace(" +",' ',$TempStr);
		$TempStr=trim($TempStr);
		return $TempStr;
	}
	
	//очистка "латинской" строки от хтмл тэгов и лишних символов
	function CleanEngStr($Str){
		$TempStr=ereg_replace("((<[^<.]*>)|(<[^>.]*)|([^<.]*>)|[^ a-zA-Z_\\-])",'',$Str);
		$TempStr=ereg_replace(" +",' ',$TempStr);
		$TempStr=trim($TempStr);
		return $TempStr;
	}
	
	//очистка строки от хтмл тэгов и лишних символов
	function CleanTag($Str){
		$TempStr=ereg_replace("((<[^<.]*>)|(<[^>.]*)|([^<.]*>))",'',$Str);
		$TempStr=ereg_replace(" +",' ',$TempStr);
		$TempStr=trim($TempStr);
		return $TempStr;
	}
	
	function ShowUserError($Label, $Object) {
		global $Errors;
		
		if ($Errors[$Object])
			echo "<span class=\"alarm\" title=\"{$Errors[$Object]}\"> $Label </span>";
		else echo $Label;
	}
	
	function HTMLUserError($Label, $Object) {
		global $Errors;
		$res ="";
		if ($Errors[$Object])
			$res = "<span class=\"alarm\" title=\"{$Errors[$Object]}\"> $Label </span>";
		else $res = $Label;
		
		return $res;
	}
	
}
?>
