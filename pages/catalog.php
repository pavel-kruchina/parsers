<?php 
$User['koef'] = $User['koef']?$User['koef']:1;

$full_url = $Global['Url.Page'][1] . '/' . $Global['Url.Page'][2];
$sc_url = mysql_real_escape_string(urldecode($Global['Url.Page'][2]));
$o_cat = mysql_real_escape_string(urldecode($Global['Url.Page'][1]));
$sc_id = $DB->ReadScalar('select sc.sc_id from subcat sc, o_cat oc where oc.cat_id=sc.cat_id and oc.url="'.$o_cat.'" and sc.sc_url="'.$sc_url.'"');

if (!$sc_id) {
	$sc_id= $DB->ReadScalar('Select sc_id FROM subcat order by Rand()');
  $url = $DB->ReadScalar('SELECT CONCAT(oc.url,"/",sc.sc_url) from subcat sc, o_cat oc WHERE oc.cat_id=sc.cat_id and sc.sc_id='.$sc_id);
	$DB->Go($Global['Host'].'/catalog/'.$url);
}

$sc_text = $DB->ReadScalar('Select sc_text FROM subcat where sc_id="'.$sc_id.'"');
$sort = mysql_real_escape_string($_GET['sort']);
if ($sort!='good_art' & $sort!='good_name' & $sort != 'good_price') $sort = 'good_price'; 

$good_url = mysql_real_escape_string(urldecode($Global['Url.Page'][3]));
$good_id = (int)$DB->ReadScalar('select good_id from goods where good_url="'.$good_url.'"');
		
?>
<script>
function changeAddress(obj) {
    $(".multi_address").css("display", "none");
    $("#ma_"+obj.value).css("display", "block");
} 
</script>
<table width="100%" cellspacing=0 cellpadding = 0>
<tr valign="top">
<td class="leftmenu">
	<?php $CAT->ShowLeftMenu($sc_id) ?>
</td>
<td style="padding-left: 6px;">
	<?php

	if (!$good_id) {

    $page = (int)$_GET['page'];
    if (!$page) $page = 1;
    
	$GOOD->readVsPages($sc_id, $sort, $page, 21);
	
	if (!$GOOD->Objects) {
		echo "нет товаров";
	} else {
	
		$i =0;
		foreach ($GOOD->Objects as $row) {
			
			$foto = $DB->ReadScalar('Select photo_id from o_photos where good_id='.$row['good_id'].' Order By photo_id limit 1');
			
			
			$foto = (int) $foto;

			
			if ($i==0) {
				echo '<div class="sort"><div style="float:left"><div class="sorting"></div></div>
				
				<div class="sortvar"> '. 
				(($sort!='good_price')?'<a href="'.$Global['Host'].'/catalog/'.$full_url.'/?sort=good_price'.'">цена</a>':'цена').' <font color="#aaa9a5">|</font> '.
				(($sort!='good_name')?'<a href="'.$Global['Host'].'/catalog/'.$full_url.'/?sort=good_name'.'">название</a>':'название').' <font color="#aaa9a5">|</font> '.
				(($sort!='good_art')?'<a href="'.$Global['Host'].'/catalog/'.$full_url.'/?sort=good_art'.'">артикул</a>':'артикул').' </div>
				</div><div class="cat_page">';
			}
			
			echo '<div  class="smallgood">
			<div style="height:190px;">
			<img OnClick="document.location=\''.$Global['Host'].'/catalog/'.$row['full_url'].'/'.urlencode($row['good_url']).'\'" src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$foto.'.jpg" width=180 style="max-height: 210px; height:auto !important; height:210px">
			</div>
			<div class="smallname">'.$row['good_name'].'
				<div class="advart">[арт. '.$row['good_art'].'] <span style="'.$row['vendor_style'].'">'.$row['vendor_name'].'</span></div>
			</div>
			<div class="smallprice">
				'.ReturnPrice($row['good_price']).' грн
			</div>
			</div>';
			
			$i++;
		}
	}
	?>
	</div>
	<div class="sort" style="text-align: left; color: #9e9c95">
        <?php
        $query = "".($_GET['sort']?"sort=".$_GET['sort']:'');
        
        for ($i=1; $i<=$GOOD->page_count; $i++) {
            if ($i!=$page)
                echo ' <a href="'.$Global['Host'].$Global['Url.Query'].'?page='.$i.'&'.$query.'">'.$i.'</a> ';
            else 
                echo ' '.$i.' ';
        }
        ?>
        
    </div>
	<div class="desc"> 
			<?php echo $sc_text; ?>
	</div>
	<?php } else { 
		$GOOD->ReadOneObject($good_id);
        
        $vendor = $DB->ReadAssRow("select * from vendor where vendor.id={$GOOD->Object['vendor_id']} ");
		$address = $DB->ReadAss("select * from shop where vendor_id={$vendor['id']}");
        if (!$GOOD->Object['good_id']) {
			echo 'ошибка';
			exit;
		}
		
	?>
	
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?sensor=false&language=ru">
    </script>
    <script>
    var points = []; 
    <?php foreach ($address as $i=>$row)  {
        echo "points[$i]={lat:{$row['lat']}, lng:{$row['lng']}, info:\"{$row['address']}\"};\n";
    }?>
        
    var point_count = <?php echo count($address); ?>;
        
    function initialize() {
        var obj = document.getElementById('adSel');
        if (!obj) {
            var pointNum=0;
        } else var pointNum = obj.value;
        
        var myOptions = {
          scaleControl: true,
          center: new google.maps.LatLng(points[pointNum].lat, points[pointNum].lng),
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('gmap'),
            myOptions);
        
        var markers = [];
        var infowindows = [];
        
        for (var i=0; i<point_count; i++) {
            markers[i] = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(points[i].lat, points[i].lng)
            });
            
            markers[i].ind = i;
            
            infowindows[i] = new google.maps.InfoWindow();
            infowindows[i].setContent(points[i].info);
            google.maps.event.addListener(markers[i], 'click', function() {
                infowindows[this.ind].open(map, this);
            });
        }   
        
        
      }

      //google.maps.event.addDomListener(window, 'load', initialize);
    </script>

    
    
		<div class="leftadv" style="background: #f0f0f0;">
			<div class="good_name"><?php echo $GOOD->Object['good_name']; ?></div>
			<div class="good_art">[арт. <?php echo $GOOD->Object['good_art']; ?>]</div>
			
			<?php if ($User['koef']==1) { ?>
				<div class="good_price" id="good_price"><?php echo ReturnPrice($GOOD->Object['good_price']); ?> грн</div>
			<?php } else{ ?>
				<div class="good_price" style="padding-bottom:0px; font-size: 16px" id="good_price"><s><?php echo ReturnPrice($GOOD->Object['good_price']); ?></s></div>
				<div class="good_price" style="color: #ca0205; padding-top:0px; padding-bottom:0px;" id="new_good_price"><?php echo ReturnPrice($GOOD->Object['good_price']*$User['koef']); ?></div>
			
			<?} ?>
			<div class="good_label">Доступные размеры:</div>
			<div class="good_blabel">
				<?php echo $GOOD->Object['good_sizes'] ?>
			</div>
			
            <?php
            $shop_row = $address[0];
            ?>
            
			<div class="good_label">Магазин:</div>
			<div class="good_blabel">
                <span>
                    <a target="blank" style="<?php echo $vendor['style'] ?>" href="<?php echo $GOOD->Object['good_uri']?>"> <?php echo $vendor['name'] ?></a>
                </span> <br />
                
            </div>
            <div class="good_label">Адрес магазина: </div>
			<?php if (count($address)==1): ?>
                <div class="good_blabel">
                    <div style="float:left"><?php echo $shop_row['address'] ?></div> <div title="Карта" class="address_map"  OnClick="OpenMap(); initialize()"></div>
                </div>
            <?php else: ?>
                <select id="adSel" style="float: left" onChange="changeAddress(this)">
                    <?php 
                    foreach($address as $i=>$row) {
                        echo "<option value='$i'>{$row['address']}</option>";
                    }    
                    ?>
                </select> <div class="address_map" title="Карта"  OnClick="OpenMap(); initialize()"><div style="margin-top:-12px">карта</div></div>
			<?php endif ?>
            
            <?php foreach($address as $i=>$row) : ?>
            <span class="multi_address" id="ma_<?php echo $i?>" style="<?php if($i!=0) echo 'display:none'; ?>" >
			
            <div class="good_label">Телефон:</div>
			<div class="good_blabel">
				<?php echo $row['phones'] ?>
			</div>
			
            <div class="good_label">Рабочее время:</div>
			<div class="good_blabel">
				<?php echo $row['work_time'] ?>
			</div>
            </span>
            <?php endforeach?>
		</div>
		
		<div class="rightadv">
			<div class="gotopright"><div OnClick="OpenLayer()" class="tobig"></div></div>
			
			<?php 
				$foto =  $DB->ReadAss('Select photo_id from o_photos where good_id='.$good_id.' Order By photo_id ');
				$f = $foto[0]['photo_id'];
				if (!$f) $f = 0;
			?>
			
			<div style="width: 100%; height: 245px; float: left">
				<img id="bim" OnClick="OpenLayer()" src = "<?php echo $Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$f; ?>.jpg" width=245 height = 245 />
			</div>
			<script>
				var lastim = 'ims'+<?php echo $f ?>;
				var bimid = "<?php echo $Global['Host'].'/'.$Global['Foto.Dir'].'/'.$f; ?>.jpg";
			</script>
			<?php 
				$i = 0;
				foreach ($foto as $row) {
					$style = $i?'':'style="border: 1px solid black;"';
					echo '<img Onclick="ChangeImage(this); bimid = \''.$Global['Host'].'/'.$Global['Foto.Dir'].'/'.$row['photo_id'].'.jpg\'" id="ims'.$row['photo_id'].'" class="small" '.$style.' src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$row['photo_id'].'.jpg">';
					$i++;
				}
			?>
		</div>
		<div class="sort"><div style="float:left"><div class="opis"></div></div></div>
		<div class="desc"> 
			<?php echo $GOOD->Object['good_desc']; ?>
            
		</div>
		
	<?php }?>
</td>
</tr>
</table>