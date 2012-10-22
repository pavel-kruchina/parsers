<?php
//error_reporting(0);
//ini_set ("display_errors","0");
//session_start();


//$User = $_SESSION['User'];

include('place_settings.cfg');
include('settings.cfg');
//--------------

include('libs/_error.php');

include('libs/_db.php');
include ('libs/functions.php');
$DB = new DataBase();

$tmp = $DB->ReadAss('select * from subcat');
foreach ($tmp as $row) {
	$DB->EditDB(array('sc_url'=>translit($row['sc_name'])), 'subcat', 'sc_id='.$row['sc_id']);
}

$tmp = $DB->ReadAss('select * from goods');

foreach ($tmp as $row) {
	$i++;
	$DB->EditDB(array('good_url'=>translit($row['good_name']).'_art'.$row['good_art']), 'goods', 'good_id='.$row['good_id']);

}

?>