<?php 

include ('place_settings.cfg');
include ('libs/_error.php');
include ('libs/_db.php');

$DB = new DataBase();
$arh = array();
$arh['o_cat'] = $DB->ReadAss('select * from o_cat');
$arh['subcat'] = $DB->ReadAss('select * from subcat');
$arh['goods'] = $DB->ReadAss('select * from goods');
$arh['mat_price'] = $DB->ReadAss('select * from mat_price');
$arh['mats'] = $DB->ReadAss('select * from mats');
$arh['news'] = $DB->ReadAss('select * from news');
$arh['pages'] = $DB->ReadAss('select * from pages');
$arh['sections'] = $DB->ReadAss('select * from sections');
$arh['koefs'] = $DB->ReadAss('select * from koefs');
$arh['recall'] = $DB->ReadAss('select * from recall');
$arh['auxiliary'] = $DB->ReadAss('select * from auxiliary');
$arh['o_photos'] = $DB->ReadAss('select * from o_photos');
$arh['gallerys'] = $DB->ReadAss('select * from gallerys');
echo '##'.serialize($arh);
?>