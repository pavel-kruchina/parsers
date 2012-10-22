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
						$baner_id = (int)$Global['Url.Page'][1];
											
						$BANER->ReadOneObject($baner_id);
						$Vars = array_merge($BANER->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$BANER->ReadAll();
					?>
					<h1>Спец. предложения</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_baners">Добавить</a><br /><br />
					<?php 
					if ($BANER->Objects)
					foreach ($BANER->Objects as $baner){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_baners/<?php echo $baner['b_id']; ?>"><?php echo $baner['b_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="b_id" value="<?php echo $baner_id;?>" />
					<input type="hidden" name="sender" value="edit_baners" />
					<table>
					
					<tr><td class="form_caption">
							<?php $BANER->ShowUserError("Название:", 'b_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="b_name" value="<?php echo $Vars['b_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $BANER->ShowUserError("Контент:", 'b_text');?>
							
						</td>
						<td class="form_input">
						<textarea name = "b_text" style="width:200px; height: 200px"><?php echo $Vars['b_text'];?></textarea>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $BANER->ShowUserError("Расположение:", 'b_place');?>
						</td>
						<td class="form_input">
						<select name = "b_place">
							<option value = 1>Слева</option>
							<option value = 2 <?php echo ($Vars['b_place']==2)?"selected":"";?> >На главной</option>
						</select>
						</td>
					</tr>
										
					<tr><td class="form_caption">
							<?php $BANER->ShowUserError("Активно:", 'b_activ');?>
						</td>
						<td class="form_input">
						<input type=checkbox name="b_activ" value="1" <?php if ($Vars['b_activ']) echo 'checked' ;?> />
						</td>
					</tr>
										
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($baner_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
</div>