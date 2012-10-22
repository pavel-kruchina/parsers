
					
					<?php 	$GALLERY->ReadAdditionalObject($page_id);
						$Vars = array_merge($GALLERY->Object, $Vars);
						$page_type = $Vars['page_type'];
						$gallery_id = $Vars['pg_id'];
					?>
					
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
					<input type="hidden" name="pg_id" value="<?php echo $Vars['pg_id'];?>" />
					<input type="hidden" name="sender" value="edit_pages" />
					<input type="hidden" name="page_type" value="<?php echo $page_type?>" />
					<table style="width: 540px">
					<tr><td class="form_caption">
							<h3><?php if($page_id) echo $PAGE->Object['page_name'];?></h3>
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Название галереи:", 'page_name');?>
					</td><td class="form_input">
						<input maxlength="100" name="page_name" value="<? echo $Vars['page_name'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Адрес страницы:", 'page_point');?>
					</td><td class="form_input">
						<input maxlength="100" name="page_point" value="<?php echo $Vars['page_point'];?>" />
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
							Текст вступления.
					</td><td class="form_input"><?php  
						$EDITOR = new FCKeditor('page_text');
						$EDITOR->Value = $Vars['page_text'];
						$EDITOR->Width = '400px';
						$EDITOR->Create();
					?> </td></tr>
					
					<tr><td class="form_caption">
						&nbsp;
					</td><td class="form_input">	
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Стандартная ширина изображения:", 'pg_def_img_width');?>
					</td><td class="form_input">
						<input maxlength="5" name="pg_def_img_width" value="<?php echo $Vars['pg_def_img_width'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Стандартная высота изображения:", 'pg_def_img_height');?>
					</td><td class="form_input">
						<input maxlength="5" name="pg_def_img_height" value="<?php echo $Vars['pg_def_img_height'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Стандартная ширина блока:", 'pg_def_span_width');?>
					</td><td class="form_input">
						<input maxlength="5" name="pg_def_span_width" value="<?php echo $Vars['pg_def_span_width'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $PAGE->ShowUserError("Стандартная высота блока:", 'pg_def_span_height');?>
					</td><td class="form_input">
						<input maxlength="5" name="pg_def_span_height" value="<?php echo $Vars['pg_def_span_height'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
						&nbsp;
					</td><td class="form_input">	
					</td></tr>
					
					<tr><td class="form_caption">
							Ссылаться на неуменьшенное изображение.
					</td><td class="form_input">
						<input type="checkbox" name="pg_def_href" value="1" <?php if ($Vars['pg_def_href']) echo 'checked';?> />
					</td></tr>
					
					<tr><td class="form_caption">
						&nbsp;
					</td><td class="form_input">	
					</td></tr>
					
					<tr><td class="form_caption">
							Сделать главной
					</td><td class="form_input">
						<input type="checkbox" name="main" value="1" <?php if ($page_id == $PAGE->ReadMain()) echo 'checked';?> />
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
					
					
					
					
					
					
					<?php 
					
					if($page_id) {?>
					<hr class="clear">
					<a name="g_elements"><h1>Редактирование элементов галереи</h1> </a>
					
					<div class="links_overflow">
					<a href="<?php echo $Global['Host']; ?>/edit_pages/<?php echo $section_id; ?>/<?php echo $page_id; ?>#g_elements" >Новый элемент</a>
					<br />
					<?php 
					
					$G_MEMBER->ReadAll($gallery_id);
					$g_member_id = (int)$Global['Url.Page'][3];
					
					$G_MEMBER->ReadOneObject($g_member_id);
					
					$Vars = array_merge($G_MEMBER->Object, $HTTP_POST_VARS);
						
					if ($G_MEMBER->Objects)
					foreach ($G_MEMBER->Objects as $g_member){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_pages/<?php echo $section_id.'/'.$page_id.'/'.$g_member['mem_id']; ?>#g_elements"><?php echo $g_member['mem_name'];?></a><br />	
					<?php }?>
					
					</div>

					<form class="edition_form" action="<?php echo $Global['Host']?>" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="page_id" value="<?php echo $page_id;?>" />
					<input type="hidden" name="pg_id" value="<?php echo $gallery_id?>" />
					<input type="hidden" name="sender" value="edit_pages" />
					<input type="hidden" name="page_type" value="<?php echo $page_type?>" />
					<input type="hidden" name="mem_id" value="<?php echo $g_member_id?>" />
					<input type="hidden" name="edit_members" value = "1" />
					<input type="hidden" name="section_id" value="<?php echo $section_id;?>" />
					
					<table>
					<tr><td class="form_caption">
							<h3><?php if($g_member_id) echo $G_MEMBER->Object['mem_name'];?></h3>
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
							<?php $G_MEMBER->ShowUserError("Название обьекта:", 'mem_name');?>
					</td><td class="form_input">
						<input maxlength="100" name="mem_name" value="<? echo $Vars['mem_name'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $G_MEMBER->ShowUserError("Изображение:", 'mem_file');?> <br />
							<?php if (file_exists($Global['Gallery.ImageSmall.Dir'].'/'.$g_member_id.'.png')) {
								echo ('<img src="'.$Global['Host'].'/'.$Global['Gallery.ImageSmall.Dir'].'/'.$g_member_id.'.png'.'">');
							}?>
					</td><td class="form_input">
						<input class="file" type="file" name="mem_file" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $G_MEMBER->ShowUserError("Описание:", 'mem_text');?>
					</td><td class="form_input">
						<textarea name="mem_text"><?php echo ($Vars['mem_text']);?></textarea>
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $G_MEMBER->ShowUserError("Ссылка :", 'mem_img_width');?>
					</td><td class="form_input">
					</td></tr>
					
					<?php  
					
						if ( (!$Vars['mem_href'] && $GALLERY->Object['pg_def_href'])||($Vars['mem_href']==$Global['Host'].'/'.$Global['Gallery.Image.Dir'].'/'.$g_member_id.'.jpg') ) $htype = 1;
						else $htype = 0;
					?>
					
					<tr><td class="form_caption">
							URL<input <?php if(!$htype) echo 'checked' ?> type="radio" name="url_type" value="0"  />
					</td><td class="form_input">
							<input name="mem_href" value="<? echo $Vars['mem_href'];?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<input <?php if($htype) echo 'checked' ?> type="radio" name="url_type" value="1"  />
					</td><td class="form_input">
							Ссылатся на полноразмерное изображение
					</td></tr>
					
					<tr><td class="form_caption">
						&nbsp;
					</td><td class="form_input">	
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $G_MEMBER->ShowUserError("Ширина изображения:", 'mem_img_width');?>
					</td><td class="form_input">
						<input maxlength="5" name="mem_img_width" value="<?php echo ($Vars['mem_img_width'] ? $Vars['mem_img_width'] : $GALLERY->Object['pg_def_img_width']);?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $G_MEMBER->ShowUserError("Высота изображения:", 'mem_img_height');?>
					</td><td class="form_input">
						<input maxlength="5" name="mem_img_height" value="<?php echo ($Vars['mem_img_height'] ? $Vars['mem_img_height'] : $GALLERY->Object['pg_def_img_height']);?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $G_MEMBER->ShowUserError("Ширина блока:", 'mem_span_width');?>
					</td><td class="form_input">
						<input maxlength="5" name="mem_span_width" value="<?php echo ($Vars['mem_span_width'] ? $Vars['mem_span_width'] : $GALLERY->Object['pg_def_span_width']);?>" />
					</td></tr>
					
					<tr><td class="form_caption">
							<?php $G_MEMBER->ShowUserError("Высота блока:", 'mem_span_height');?>
					</td><td class="form_input">
						<input maxlength="5" name="mem_span_height" value="<?php echo ($Vars['mem_span_height'] ? $Vars['mem_span_height'] : $GALLERY->Object['pg_def_span_height']);?>" />
					</td></tr>
					
					<tr><td class="form_caption">
						&nbsp;
					</td><td class="form_input">	
					</td></tr>
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($g_member_id) {?> 
						<input class="button" type="submit" onclick="confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					<?php } 
					?>