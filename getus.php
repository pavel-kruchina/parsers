<?php
session_start();
error_reporting();
header("Content-Type: application/octet-stream");
        header("content-disposition: attachment; filename=\"users.csv\""); 
include('place_settings.cfg');
include('settings.cfg');
//--------------

include('libs/_error.php');

$ERROR = new Error;

include('libs/_db.php');
$DB = new DataBase();

include('libs/_user.php');
$USER = new User($DB);

include('libs/groups.php');
$GROUP = new Group($DB);


include('libs/cat.php');
$CAT = new Cat($DB);

include ('libs/subcats.php');
$SUBCAT = new SubCat($DB);

include ('libs/good.php');
$GOOD = new Good($DB);

include ('libs/mats.php');
$MAT = new Mat($DB);

include ('libs/basket.php');
$BASKET = new Basket($DB);


include ('libs/tnews.php');
$NEW = new News($DB);

include ('libs/gallery.php');
$GALLERY = new Gallery($DB);

include ('libs/talarm.php');
$ALARM = new Alarm($DB);

$spam = $DB->ReadAss('select * from spam order by spam_id desc');

foreach ($spam as $row) {
	
	echo("\"".(addslashes($row['mail']))."\";\n");
}

?>