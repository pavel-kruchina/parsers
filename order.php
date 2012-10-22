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
	'text'	=>'�������� � ������������ ���������������� "������ ���"'
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>'�����: 140003, ���������� ���., �. �������, ��. 3-� �������� ���������, �. 76,'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'���.: (495) 517-09-03'
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
	'text'	=>'������� ���������� ���������� ���������'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'��� 5027151172',
	'd1' =>'',
	'd2' =>'',
	't2' =>'��� 502701001'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'����������'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'�������� � ������������ ���������������� "������ ���"',
	'd1' =>'',
	'd2' =>'',
	'd3' =>'',
	'd4' =>'',
	'd5' =>'',
	't2' =>'��. �',
	't3' =>'40702810300220902317 '
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'���� ����������',
	'd1' =>'',
	'd2' =>'',
	'd3' =>'',
	'd4' =>'',
	'd5' =>'',
	't2' =>'���',
	't3' =>'44660748'
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'������ �� ����� (���) � �. �������',
	'd1' =>'',
	'd2' =>'',
	'd3' =>'',
	'd4' =>'',
	'd5' =>'',
	't2' =>'��. �',
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
	'text'	=>'��������! ���� ������������ � ������� 3-� (����) ���������� ����'
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
	'd3' =>'��. �',
	't2' =>$order_id,
	't2' =>'��',
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
	'text'	=>'����������:',
	'd1' 	=>'',
	't1'	=>$user_name
);
echo (ToCsv($temp))."\n";
$temp=array(
    'dummy' =>'',
	'text'	=>'���������������:',
	'd1' 	=>'',
	't1'	=>$user_name
);
echo (ToCsv($temp))."\n";
$summ = 0;
$k = 0;
$temp=array(
    'dummy' =>'',
	'no'	=>'�',
	'name'	=>'������������ ������',
	'd3' =>'',
	'd4' =>'',
	'd5' =>'',
	'st'	=>'������� ���������',
	'count'	=>'����������',
	'price'	=>'����',
	'summ'	=>'�����'
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
		'st'	=>'��.',
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
		'price'	=>'�����',
		'summ'	=>$summ
	);
	echo (ToCsv($temp))."\n";

$temp=array(
		'dummy' =>'',
		'no'	=>'��� "������ ���" �������� �� ���������� ������� ��������������� ��� ���',
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
		'price'	=>'����� � ������:',
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
	'text'	=>'����� ������������ '.$k.', �� ����� '.$summ
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
	'text'	=>'������������ �����������_____________________ (���������� �.�.)'
);
echo (ToCsv($temp))."\n";	
$temp=array(
    'dummy' =>'',
	'text'	=>''
);
echo (ToCsv($temp))."\n";

$temp=array(
    'dummy' =>'',
	'text'	=>'������� ���������____________________________ (���������� �.�.)'
);
echo (ToCsv($temp))."\n";
?>