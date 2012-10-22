<?php
	session_start();
	include('libs/DMT-captcha-gen.php');
	$CAPTCHA = new DMTcaptcha();
	$_SESSION['captcha_keystring'] = $CAPTCHA->getKeyString();
?>