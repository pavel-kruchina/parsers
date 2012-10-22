<?php 
						$mat_id = (int)$Global['Url.Page'][1];
											
						$MAT->ReadOneObject($mat_id);
						$Vars = array_merge($MAT->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$MAT->ReadAll();
					?>
					<h1>Материалы</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_mats">Добавить</a><br /><br />
					<?php 
					if ($MAT->Objects)
					foreach ($MAT->Objects as $mat){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_mats/<?php echo $mat['mat_id']; ?>"><?php echo $mat['mat_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="mat_id" value="<?php echo $mat_id;?>" />
					<input type="hidden" name="sender" value="edit_mats" />
					<table>
					
					<tr><td class="form_caption">
							<?php $MAT->ShowUserError("Материал:", 'mat_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="mat_name" value="<?php echo $Vars['mat_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $MAT->ShowUserError("Описание:", 'mat_desc');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="mat_desc" value="<?php echo $Vars['mat_desc'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($mat_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>