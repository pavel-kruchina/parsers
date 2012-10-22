<?php 
$User['koef'] = $User['koef']?$User['koef']:1;
$sc_id = 0; 		
$sort = mysql_real_escape_string($_GET['sort']);
if ($sort!='good_art' & $sort!='good_name' & $sort != 'good_price') $sort = 'good_price'; 
		
$good_id = 0;
$page = (int)$_GET['page'];
if (!$page) $page = 1;
?>
<table width="100%" cellspacing=0 cellpadding = 0>
<tr valign="top">
<td class="leftmenu">
	<?php $CAT->ShowLeftMenu($sc_id) ?>
</td>
<td style="padding-left: 6px;">
	<?php

	if (!$good_id) {
	
	$GOOD->Search($_GET['search_string'], $sort, $page, 21);
	
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
				(($sort!='good_price')?'<a href="'.$Global['Host'].'/catalog/'.$sc_url.'/?sort=good_price'.'">цена</a>':'цена').' <font color="#aaa9a5">|</font> '.
				(($sort!='good_name')?'<a href="'.$Global['Host'].'/catalog/'.$sc_url.'/?sort=good_name'.'">название</a>':'название').' <font color="#aaa9a5">|</font> '.
				(($sort!='good_art')?'<a href="'.$Global['Host'].'/catalog/'.$sc_url.'/?sort=good_art'.'">артикул</a>':'артикул').' </div>
				</div><div class="cat_page">';
			}
			
			echo '<div  class="smallgood">
			<div style="height:190px;">
			<img OnClick="document.location=\''.$Global['Host'].'/catalog/'.$row['sc_url'].'/'.$row['good_url'].'\'" src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$foto.'.jpg" width=180 style="max-height: 210px; height:auto !important; height:210px">
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
                echo ' <a href="'.$Global['Host'].$Global['Url.Query'].'?page='.$i.'&search_string='.urlencode($_GET['search_string']).'&'.$query.'">'.$i.'</a> ';
            else 
                echo ' '.$i.' ';
        }
        ?>
        
    </div>

	<?php }?>
</td>
</tr>
</table>