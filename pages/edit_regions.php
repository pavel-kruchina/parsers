<div id="menu" align="right">
	<ul>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>">Главная</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/news">Новости</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/about">О компании</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/contacts">Контакты</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/help">Справка</a></li>
		<li class="last"><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/search">Поиск</a></li>
	</ul>
 </div>

 <div id="line_after_menu_left"></div>
 <div id="line_after_menu_right"></div>
 <div id="line_after_menu_bg"></div>
 <div id="line_after_menu_ln"></div>

 <div id="left">
<?php 
						$region_id = (int)$Global['Url.Page'][1];
											
						$REGION->ReadOneObject($region_id);
						$Vars = array_merge($REGION->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$REGION->ReadAll();
					?>
					<h1>Регион</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_regions">Добавить</a><br /><br />
					<?php 
					if ($REGION->Objects)
					foreach ($REGION->Objects as $region){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_regions/<?php echo $region['region_id']; ?>"><?php echo $region['region_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="region_id" value="<?php echo $region_id;?>" />
					<input type="hidden" name="sender" value="edit_regions" />
					<table>
					
					<tr><td class="form_caption">
							<?php $REGION->ShowUserError("Регион:", 'region_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="region_name" value="<?php echo $Vars['region_name'];?>" />
						</td>
					</tr>
										
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($region_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
</div>