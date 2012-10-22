<?php
error_reporting(E_ERROR | E_PARSE);
header("Content-Type: application/octet-stream");
header("content-disposition: attachment; filename=\"order.csv\"");
session_start();
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

include('libs/functions.php');


//if (!($User['user_rights'] & $Global['Right.Admin'])) exit;

$order_id = (int)$_GET['order_id'];

$order = $BASKET->MGetOrder($order_id);
$date = $DB->ReadScalar('select order_date from orders where order_id = '.$order_id);
$user_name = $DB->ReadScalar('select users.user_org from orders, users where orders.order_id = '.$order_id.' AND users.user_id = orders.user_id');

$temp=array(
    'dummy' =>'',
	'text'	=>'Общество с ограниченной ответственностью "Галком Про"'
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>'Адрес: 140003, Московская обл., г. Люберцы, ул. 3-е Почтовое отделение, д. 76,'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'тел.: (495) 517-09-03'
);

echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);

echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";


$temp=array(
    'dummy' =>'',
	'text'	=>'Образец заполнения платежного поручения'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'ИНН 5027151172',
	'd1' =>'',
	'd2' =>'',
	't2' =>'КПП 502701001'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'Получатель'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'Общество с ограниченной ответственностью "Галком Про"',
	'd1' =>'',
	'd2' =>'',
	'd3' =>'',
	'd4' =>'',
	'd5' =>'',
	't2' =>'Сч. №',
	't3' =>'40702810300220902317 '
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'Банк получателя',
	'd1' =>'',
	'd2' =>'',
	'd3' =>'',
	'd4' =>'',
	'd5' =>'',
	't2' =>'БИК',
	't3' =>'44660748'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'Филиал НБ ТРАСТ (ОАО) в г. Люберцы',
	'd1' =>'',
	'd2' =>'',
	'd3' =>'',
	'd4' =>'',
	'd5' =>'',
	't2' =>'Сч. №',
	't3' =>'30101810700000000748'
);

echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'Внимание! Счет действителен в течение 3-х (трех) банковских дней'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'',
	'd1' =>'',
	'd2' =>'',
	'd3' =>'Сч. №',
	't2' =>$order_id,
	't2' =>'от',
	't3' =>tstamp_to_strdate($date)
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'Плательщик:',
	'd1' 	=>'',
	't1'	=>$user_name
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'Грузополучатель:',
	'd1' 	=>'',
	't1'	=>$user_name
);
echo (ToCsv($temp))."\n";
$summ = 0;
$k = 0;
$temp=array(
    'dummy' =>'',
	'no'	=>'№',
	'name'	=>'Наименование товара',
	'd3' =>'',
	'd4' =>'',
	'd5' =>'',
	'st'	=>'еденица измерения',
	'count'	=>'Количество',
	'price'	=>'Цена',
	'summ'	=>'Сумма'
);
echo (ToCsv($temp))."\n";
foreach ($order as $key=>$row) {
	
	$GOOD->ReadOneObject($row['good_id']);
	
	$temp=array(
		'dummy' =>'',
		'no'	=>$key+1,
		'name'	=>$GOOD->Object['good_name'],
		'd3' =>'',
	'd4' =>'',
	'd5' =>'',
		'st'	=>'шт.',
		'count'	=>$row['goods_count'],
		'price'	=>$row['good_price'],
		'summ'	=>$row['good_price']*$row['goods_count']
	);
	$summ+=$row['good_price']*$row['goods_count'];
	$k++;
	echo (ToCsv($temp))."\n";
}

$temp=array(
		'dummy' =>'',
		'no'	=>'',
		'no1'	=>'',
		'name'	=>'',
		'd3' =>'',
	'd4' =>'',
	'd5' =>'',
		'count'	=>'',
		'price'	=>'Итого',
		'summ'	=>$summ
	);
	echo (ToCsv($temp))."\n";

$temp=array(
		'dummy' =>'',
		'no'	=>'ООО "Галком Про" работает по упрощенной системе налогооблажения без НДС',
		'no1'	=>'',
		'name'	=>'',
		'd3' =>'',
	'd4' =>'',
	'd5' =>'',
		'count'	=>'',
		'price'	=>'',
		'summ'	=>'---'
	);
	echo (ToCsv($temp))."\n";

$temp=array(
		'dummy' =>'',
		'no'	=>'',
		'no1'	=>'',
		'name'	=>'',
		'd3' =>'',
	'd4' =>'',
	'd5' =>'',
		'count'	=>'',
		'price'	=>'Всего к оплате:',
		'summ'	=>$summ
	);
	echo (ToCsv($temp))."\n";

	$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>'Всего наименований '.$k.', на сумму '.$summ
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>num2str($summ)
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>'Руководитель предприятия_____________________ (Матовников Е.П.)'
);
echo (ToCsv($temp))."\n";	
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>'Главный бухгалтер____________________________ (Матовников Е.П.)'
);
echo (ToCsv($temp))."\n";
?>