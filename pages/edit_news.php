
					<?php 
						$new_id = (int)$Global['Url.Page'][1];
											
						$NEW->ReadOneObject($new_id);
						$Vars = array_merge($NEW->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$NEW->ReadAll();
					?>
					<h1>�������</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_news">��������</a><br /><br />
					<?php 
					if ($NEW->Objects)
					foreach ($NEW->Objects as $new){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_news/<?php echo $new['new_id']; ?>"><?php echo tstamp_to_date($new['new_date']).' '.$new['new_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="new_id" value="<?php echo $new_id;?>" />
					<input type="hidden" name="sender" value="edit_news" />
					<table width="100%">
					<tr><td class="form_caption">
						����:
						
					</td><td class="form_input"> <input name="new_date" value="<?php echo tstamp_to_date($Vars['new_date']);?>" > </td></tr>
					
					<tr><td class="form_caption">
							<?php $NEW->ShowUserError("��������:", 'new_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="new_name" value="<?php echo $Vars['new_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $NEW->ShowUserError("���:", 'new_type');?>
						</td>
						<td class="form_input">
						<select name="new_type">
							<option value="0">�������</option>
							<option value="1" <?php if ($Vars['new_type']) echo 'selected'; ?> >������</option>
						</select>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $SECTION->ShowUserError("��������������� ��������:", 'new_prew');?>
						</td>
					</tr>
					<tr>	
					<td class="form_input" colspan=2><textarea style="width: 100%; height: 50px;" name="new_prew"><?php echo $Vars['new_prew']; ?></textarea></td></tr>
					
					<tr><td class="form_caption">
							<?php $SECTION->ShowUserError("����� �������:", 'new_text');?>
						</td>
					</tr>
					<tr>	
					<td class="form_input" colspan=2><?php  
						$EDITOR = new FCKeditor('new_text');
						$EDITOR->Value = $Vars['new_text'];
						$EDITOR->Width = '100%';
						$EDITOR->Height = '300px';
						$EDITOR->Create();
					?> </td></tr>
					
					<? if (!$new_id) {?>
					<tr><td class="form_caption">
							<?php $NEW->ShowUserError("� ��������:", 'new_meil');?>
						</td>
						<td class="form_input">
						<input type="checkbox" name="new_meil" value="1" />
						</td>
					</tr>
					<?}?>
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($new_id) {?> 
						<input class="button" type="submit" onclick="confirm('�� ������������� ������ �������?');" name="delete" value="�������">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
