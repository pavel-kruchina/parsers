					<?php 
							if (!isset($Global['Url.Page'][1])) {
								$Global['Url.Page'][1] = $Global['MainMenu.Index'];
							}
							
							if (isset($HTTP_GET_VARS['parent_id'])) {
								$parent_id = $HTTP_GET_VARS['parent_id'];
								$section_id = 0;
								$SECTION->ReadOneObject($section_id);
							} else {
								$section_id =(int)$Global['Url.Page'][1];								
								$SECTION->ReadOneObject($section_id);
								$parent_id = (int)$SECTION->Object['parent_id'];
							}
						
							if ($HTTP_POST_VARS['section_text']) 
							$HTTP_POST_VARS['section_text'] = stripslashes($HTTP_POST_VARS['section_text']);
					
							$SECTION->ReadAll($section_id);
							
							
							$Vars = array_merge($SECTION->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
							
						$PAGE->ReadAll($section_id);

					$page_id = (int)$Global['Url.Page'][2];

					if ($HTTP_POST_VARS['page_text']) {
						$HTTP_POST_VARS['page_text'] = stripslashes($HTTP_POST_VARS['page_text']);
					}
					if (!$section_id) {		echo '<h2>'.Get_Path($parent_id, 1).'</h2>';
					} else 					echo '<h2>'.Get_Path($section_id, 1).'</h2>';
					
					if ((int)$Global['Url.Page'][2] OR $HTTP_POST_VARS['page_type']) {
							$parent_id = $section_id;
							$PAGE->ReadOneObject($page_id);
							$Vars = array_merge($PAGE->Object, $HTTP_POST_VARS);
						
						
						if ($Vars['page_type'])
							include('pages/edit_templates/'.$Vars['page_type'].'.php'); 
						
					} else {
					if ($section_id) {
					?>
					<h2>Разделы</h2>
					<?php 
						
					?>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_pages?parent_id=<?php echo $section_id; ?>">Новый подраздел</a><br /><br />
					<?php 
					if ($SECTION->Objects)
					foreach ($SECTION->Objects as $section){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_pages/<?php echo $section['section_id']; ?>/0"><?php echo $section['section_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					
	
					<a name='pages'></a><h2>Страницы раздела</h2>
					
					<div class="links_overflow">
					<form name="new_page" action="<?php echo $Global['Host']; ?>/edit_pages/<?php echo $section_id?>#pages" method="post" enctype="multipart/form-data">
					<a href="" onClick="document.new_page.submit(); return false;">Новая</a>
					<select style="display:none" name = 'page_type'>
						<?php
							foreach ($PageTypes as $Page=>$Name) {
								echo ('<option value="'.$Page.'">'.$Name.'</option>');
							}							
						?>
					</select>
					</form>
					<br />
					<?php 
					
											
					if ($PAGE->Objects)
					foreach ($PAGE->Objects as $page){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_pages/<?php echo $page['section_id'].'/'.$page['page_id']; ?>#pages"><?php echo $page['page_name'];?></a><br />	
					<?php }?>
					
					</div>
					<?php }?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="section_id" value="<?php echo $section_id;?>" />
					<input type="hidden" name="sender" value="edit_sections" />
					<input type="hidden" name="parent_id" value="<?php echo $Vars['parent_id'];?>" />
					<table>
					<tr><td class="form_caption">
					
					</td><td class="form_input"></td></tr>
					<?php  if ($section_id!=$Global['MainMenu.Index']) {?>
					<tr><td class="form_caption">
							<?php $SECTION->ShowUserError("Название подраздела:", 'section_name');?>
						</td><td class="form_input">
						<input maxlength="100" name="section_name" value="<?php echo $Vars['section_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $SECTION->ShowUserError("Адрес подраздела:", 'section_point');?>
						</td><td class="form_input">
						<input maxlength="100" name="section_point" value="<?php echo $Vars['section_point'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Заголовок раздела:", 'section_title');?>
					</td><td class="form_input">
						<input name="section_title" value="<?php echo $Vars['section_title'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $SECTION->ShowUserError("Текст подраздела:", 'section_text');?>
						</td>
					</tr>
					<tr>	
					<td class="form_input" colspan=2><?php  
						$EDITOR = new FCKeditor('section_text');
						$EDITOR->Value = $Vars['section_text'];
						$EDITOR->Width = '700px';
						$EDITOR->Height = '300px';
						$EDITOR->Create();
					?> </td></tr>
					
					<tr><td class="form_caption">
							Описание раздела
					</td><td class="form_input"></td></tr>
					<tr><td colspan=2>
					<textarea name='section_desc'><?php echo $Vars['section_desc'];?></textarea>	
					</td></tr>
										
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($section_id) {?> 
						<input class="button" type="submit" onclick="confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					<?php } ?>
					</table>
					</form>

					<?php  }
					
					?>
					