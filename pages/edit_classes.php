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
						$class_id = (int)$Global['Url.Page'][1];
											
						$CLASS->ReadOneObject($class_id);
						$Vars = array_merge($CLASS->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$CLASS->ReadAll();
					?>
					<h1>Классы</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_classes">Добавить</a><br /><br />
					<?php 
					if ($CLASS->Objects)
					foreach ($CLASS->Objects as $class){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_classes/<?php echo $class['class_id']; ?>"><?php echo $class['class_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
					<input type="hidden" name="sender" value="edit_classes" />
					<table>
					
					<tr><td class="form_caption">
							<?php $CLASS->ShowUserError("Класс:", 'class_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="class_name" value="<?php echo $Vars['class_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $CAT->ShowUserError("Текст класса:", 'class_text');?>
						</td>
						<td class="form_input">
						</td>
					</tr>
					<td class="form_input" colspan=2><?php  
						$EDITOR = new FCKeditor('class_text');
						$EDITOR->Value = $Vars['class_text'];
						$EDITOR->Width = '100%';
						$EDITOR->Height = '300px';
						$EDITOR->Create();
					?> </td></tr>
					
					<tr><td class="form_caption">
							Опции класса
						</td>
						<td class="form_input">
						<script>
							function add_option() {
								document.getElementById("options").innerHTML += '<input name="options[]"><br />';
							}
						</script>
						<button OnClick = "add_option(); return false;">Добавить опцию</button> Чтобы удалить - очистите имя опции.
						</td>
					</tr>
					
					<tr><td class="form_caption">
						
					</td><td class="form_input"> 
						
						<?php $CLASS->GetExOptions($class_id)?>
						
						<div id="options"></div> 
					</td></tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					
					
					<tr><td class="form_caption">
						<?php if($class_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
</div>