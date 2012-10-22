<?php echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' ?>
<?
error_reporting(0);
ini_set ("display_errors","0");
include('place_settings.cfg');
include('settings.cfg');
//--------------

include('libs/_error.php');

include('libs/_db.php');
$DB = new DataBase();

include ('libs/_menu.php');
$MENU = new Menu($DB);

include('libs/pages.php');
$PAGE = new Page($DB);

include('libs/_user.php');
$USER = new User($DB);

include('libs/sections.php');
$SECTION = new Section($DB);

include ('fckeditor/fckeditor_php4.php');

include ('libs/tnews.php');
$NEW = new News($DB);

include ('libs/cat.php');
$CAT = new Cat($DB);

include ('libs/subcats.php');
$SUBCAT = new SubCat($DB);

include ('libs/good.php');
$GOOD = new Good($DB);

include ('libs/mats.php');
$MAT = new Mat($DB);

include ('libs/koefs.php');
$KOEF = new Koef($DB);

include ('libs/talarm.php');
$ALARM = new Alarm($DB);

include ('libs/basket.php');
$BASKET = new Basket($DB);

include ('libs/spetial.php');
$SPETIAL = new Spetial($DB);

include ('libs/groups.php');
$GROUP = new Group($DB);

include ('libs/pgroups.php');
$PGROUP = new PGroup($DB);

include ('libs/otzivs.php');
$OTZIV = new Otziv($DB);


include ('libs/gallery.php');
$GALLERY = new Gallery($DB);

include ('libs/functions.php');

function rep($str) {
	$what = array('"','&', '>', '<', '\'');
	$whom = array('&quot;','&amp;', '&gt;', '&lt;', '&apos;');
	return str_replace($what, $whom, $str);
}

?>
<yml_catalog date="<?php echo date("Y-m-d H:i"); ?>">
<shop>
	<name>Galkom</name>
	<company>ООО &quot;Галком&quot;</company>
	<url><?php echo $Global['Host']?></url>

	<currencies>
		<currency id="RUR" rate="1"/>
	</currencies>
	
	<categories>
		<?php $CAT->ReadAll();
			foreach ($CAT->Objects as $row) {
				echo '<category id="'.$row['cat_id'].'">'.rep($row['cat_name']).'</category>';
				$SUBCAT->ReadAll($row['cat_id']);
				foreach ($SUBCAT->Objects as $row1) {
					echo '<category id="'.($row['cat_id']*200).$row1['sc_id'].'" parentId="'.$row['cat_id'].'">'.rep($row1['sc_name']).'</category>';
				}
			}
		?>
	</categories>
	<offers>
		<?php 
			foreach ($CAT->Objects as $row2) {
				$SUBCAT->ReadAll($row2['cat_id']);
				foreach ($SUBCAT->Objects as $row1) {
					
					$GOOD->ReadAll($row1['sc_id']);
					foreach ($GOOD->Objects as $row) {
						$foto = $DB->ReadScalar('Select photo_id from o_photos where good_id='.$row['good_id'].' Order By photo_id limit 1');
						$price = $DB->ReadScalar('Select matprice from mat_price where good_id='.$row['good_id'].' AND matprice Order By matprice limit 1');
						$price = (int)($price);
						$foto = (int) $foto;
													
						echo '
						<offer id="'.$row['good_id'].'" type="vendor.model" available="true" bid="'.$row['good_id'].'">
						<url>'.$Global['Host'].'/catalog/'.$row1['sc_url'].'/'.$row['good_url'].'</url>
						<price>'.$price.'</price>
						<currencyId>RUR</currencyId>
						<categoryId> '.($row2['cat_id']*200).$row1['sc_id'].' </categoryId ><picture>'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$foto.'.jpg</picture>
						<delivery>true</delivery>
						<local_delivery_cost>500</local_delivery_cost>
						<vendor>ООО &quot;Галком&quot;</vendor>
						<vendorCode> '.$row['good_art'].' </vendorCode>
						<model>'.rep($row['good_name']).'</model>
						<description>
						    '.rep($GOOD->CleanTag($row['good_desc'])).'
						</description>
						<manufacturer_warranty>true</manufacturer_warranty>
						<country_of_origin>Россия</country_of_origin>
						 
						</offer>

						';
						
					}
				}
			}
		?>
		
	</offers>

	
</shop>
</yml_catalog>