					<?php//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
					<input type="hidden" name="sender" value="edit_pages" />
					<input type="hidden" name="page_type" value="<?php echo $Vars['page_type']?>" />
					<table width = 100%>
					<tr><td class="form_caption">
							<h3><?php if($page_id) echo $PAGE->Object['page_name'];?></h3>
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Название страницы:", 'page_name');?>
					</td><td class="form_input">
						<input maxlength="100" name="page_name" value="<? echo $Vars['page_name'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Адрес страницы:", 'page_point');?>
					</td><td class="form_input">
						<input maxlength="100" name="page_point" value="<?php echo $Vars['page_point'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Заголовок страницы:", 'page_title');?>
					</td><td class="form_input">
						<input name="page_title" value="<?php echo $Vars['page_title'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							Раздел:
					</td><td class="form_input">
						<select name="section_id" >
							<?php 
								$SECTION->ReadRealyAll();
								foreach ($SECTION->Objects as $section) { 
								$selected = ($section['section_id'] == $parent_id) ? ("selected") : ("");
							?>
							
							<option <?php echo $selected;?> value="<?php echo $section['section_id'];?>"><?php echo $section['section_name'];?></option>
							
							<?php }?>
						</select>
					</td></tr>
					
					
					<tr><td class="form_caption">
							Текст страницы.
					</td><td class="form_input"></td></tr>
					<tr><td colspan=2>
					<?php  
						$EDITOR = new FCKeditor('page_text');
						$EDITOR->Value = $Vars['page_text'];
						$EDITOR->Width = '100%';
						$EDITOR->Height = '400px';
						$EDITOR->Create();
					?> </td></tr>
					
					<tr><td class="form_caption">
							Описание страницы
					</td><td class="form_input"></td></tr>
					<tr><td colspan=2>
					<textarea name='page_desc'><?php echo $Vars['page_desc'];?></textarea>	
					</td></tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($page_id) {?> 
						<input class="button" type="submit" onclick="confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					</div>