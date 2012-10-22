<?php 
						$group_id = (int)$Global['Url.Page'][1];
											
						$GROUP->ReadOneObject($group_id);
						$Vars = array_merge($GROUP->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$GROUP->ReadAll();
					?>
					<h1>Группы</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_groups">Добавить</a><br /><br />
					<?php 
					if ($GROUP->Objects)
					foreach ($GROUP->Objects as $group){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_groups/<?php echo $group['group_id']; ?>"><?php echo $group['group_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="group_id" value="<?php echo $group_id;?>" />
					<input type="hidden" name="sender" value="edit_groups" />
					<table>
					
					<tr><td class="form_caption">
							<?php $GROUP->ShowUserError("Название группы:", 'group_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="group_name" value="<?php echo $Vars['group_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $GROUP->ShowUserError("Значение коефициента:", 'group_koef');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="group_koef" value="<?php echo $Vars['group_koef'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($group_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>