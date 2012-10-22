<?php 
						
					?>
					<h1>Дополнительно</h1>
									
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">

					<input type="hidden" name="sender" value="change_phone" />
					<table>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("Телефон:", 'phone');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="phone" value="<?php echo getPhone();?>" />
						</td>
					</tr>
					
					
										
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					
					
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="sender" value="change_mail" />
					<table>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("Административный e-mail:", 'mail');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="mail" value="<?php echo getMail()?>" />
						</td>
					</tr>				
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="sender" value="change_flash" />
					<table>
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("Адрес flash-ролика:", 'flash');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="flash" value="<?php echo getFlash()?>" />
						</td>
					</tr>					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="sender" value="change_seo" />
					<table>
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("Ключевые слова:", 'seo');?>
						</td>
						<td class="form_input">
						<textarea style="width: 300px; height: 300px" name="seo" ><?php echo getSEO()?></textarea>
						</td>
					</tr>					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					</table>
					</form>
				
				<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="sender" value="change_short" />
					<table>
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("Текст на главной:", 'short');?>
						</td>
						<td class="form_input">
						&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>
<tr>	
					<td class="form_input" colspan=2><?php  
						$EDITOR = new FCKeditor('short');
						$EDITOR->Value = getShort();
						$EDITOR->Width = '500px';
						$EDITOR->Height = '300px';
						$EDITOR->Create();
					?> </td></tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					</table>
					</form>
				
				<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="sender" value="change_del" />
					<table>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("Доставка:", 'del');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="del" value="<?php echo getDel()?>" />
						</td>
					</tr>				
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					
				<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="sender" value="set_koef" />
					<table>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("Коэфициент цен:", 'koef');?>
							<br />
							<?php if ($set_koef) echo 'Коэфициент установлен'; ?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="koef" value="1" />
						</td>
					</tr>				
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					</table>
					</form>
				