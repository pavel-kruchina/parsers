					<?php 
						$brend_id = (int)$Global['Url.Page'][1];
											
						$BREND->ReadOneObject($brend_id);
						$Vars = array_merge($BREND->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$BREND->ReadAll();
					?>
					<h1>Разделы</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_brends">Добавить</a><br /><br />
					<?php 
					if ($BREND->Objects)
					foreach ($BREND->Objects as $brend){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_brends/<?php echo $brend['b_id']; ?>"><?php echo $brend['b_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="b_id" value="<?php echo $brend_id;?>" />
					<input type="hidden" name="sender" value="edit_brends" />
					<table>
					
					<tr><td class="form_caption">
							<?php $BREND->ShowUserError("Раздел:", 'b_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="b_name" value="<?php echo $Vars['b_name'];?>" />
						</td>
					</tr>
										
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($brend_id) {?> 
						<input class="button" type="submit" onclick="confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					<?php
					if ($brend_id) {
					
						$model_id = (int)$Global['Url.Page'][2];
											
						$MODEL->ReadOneObject($model_id);
						$Vars = array_merge($MODEL->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$MODEL->ReadAll($brend_id);
					?>
					<h1>Фирмы</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_brends/<?php echo $brend_id?>">Добавить</a><br /><br />
					<?php 
					if ($MODEL->Objects)
					foreach ($MODEL->Objects as $model){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_brends/<?php echo $model['b_id'].'/'.$model['m_id']; ?>"><?php echo $model['m_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="m_id" value="<?php echo $model_id;?>" />
					<input type="hidden" name="sender" value="edit_models" />
					<table>
					
					<tr><td class="form_caption">
							<?php $MODEL->ShowUserError("Фирма:", 'm_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="m_name" value="<?php echo $Vars['m_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $MODEL->ShowUserError("URL:", 'm_url');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="m_url" value="<?php echo $Vars['m_url'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $MODEL->ShowUserError("Раздел:", 'b_id');?>
						</td>
						<td class="form_input">
						<select name = "b_id">
						<?php 
						foreach ($BREND->Objects as $brend) {
							$selected=($brend['b_id']==$brend_id)?'selected':'';
							echo '<option value="'.$brend['b_id'].'" '.$selected.'>'.$brend['b_name'].'</option>';
						}
						?>
						</select>
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($model_id) {?> 
						<input class="button" type="submit" onclick="confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					
					
					<?php
					}
?>