<?php
	$deleted = file_get_contents("zapret.txt");
	$deleted .= "\n".$_GET['mail'];
	file_put_contents("zapret.txt", $deleted);
?>