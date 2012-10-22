<?php 
echo $Page['page_text'];

global $GALLERY;
global $G_MEMBER;
global $Global;

$GALLERY->ReadAdditionalObject($Page['page_id']);
$G_MEMBER->ReadAll($GALLERY->Object['pg_id']);

$count = $G_MEMBER->DB->LastCount;

$page = (int)$Global['Url.Page'][2];

$im_count = 0;
$i=0;
if ($G_MEMBER->Objects) {
	
	foreach( $G_MEMBER->Objects as $Object) {
	$i++;
		echo '
		<div id="gd'.$i.'" class="row">
		<![if !IE 6]>
		<div style="margin: 0 300px 0px 100px; float:left; width: 0px; height: 100px;">
		<![endif]>
		<!--[if IE 6]>
		<div style="clear:both">
		<![endif]-->
		<a target="blank" href="'.$Object['mem_href'].'">
		<img onmouseover="larger((document.getElementById(\'gd'.$i.'\')),this,468,278)" onmouseout="smaller((document.getElementById(\'gd'.$i.'\')),this,312,192)" class="photo_fon" src="'.$Global['Host'].'/'.$Global['Gallery.ImageSmall.Dir'].'/'.$Object['mem_id'].'.png'.'"></a>
		</div>
		<![if !IE 6]>
		<div style="position: relative; z-index:0; solid black; float:right; width: 200px; height: 100px;">
		<![endif]>
		<!--[if IE 6]>
		<div style="clear:both">
		<![endif]-->
		'.$Object['mem_text'].'
		</div>
		</div>
		
		';

	}
	
echo '</div>';
}
?>
