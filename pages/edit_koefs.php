<?php 
						$koef_id = (int)$Global['Url.Page'][1];
											
						$KOEF->ReadOneObject($koef_id);
						$Vars = array_merge($KOEF->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$KOEF->ReadAll();
					?>
					<h1>Коэффициенты</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_koefs">Добавить</a><br /><br />
					<?php 
					if ($KOEF->Objects)
					foreach ($KOEF->Objects as $koef){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_koefs/<?php echo $koef['koef_id']; ?>"><?php echo $koef['koef_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="koef_id" value="<?php echo $koef_id;?>" />
					<input type="hidden" name="sender" value="edit_koefs" />
					<table>
					
					<tr><td class="form_caption">
							<?php $KOEF->ShowUserError("Название коэффициента:", 'koef_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="koef_name" value="<?php echo $Vars['koef_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $KOEF->ShowUserError("Значение коэффициента:", 'koef_value');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="koef_value" value="<?php echo $Vars['koef_value'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $KOEF->ShowUserError("Порядок:", 'koef_order');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="koef_order" value="<?php echo $Vars['koef_order'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($koef_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>