<?php 
						
					?>
					<h1>�������������</h1>
									
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">

					<input type="hidden" name="sender" value="change_phone" />
					<table>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("�������:", 'phone');?>
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
							<?php $SPETIAL->ShowUserError("���������������� e-mail:", 'mail');?>
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
							<?php $SPETIAL->ShowUserError("����� flash-������:", 'flash');?>
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
							<?php $SPETIAL->ShowUserError("�������� �����:", 'seo');?>
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
							<?php $SPETIAL->ShowUserError("����� �� �������:", 'short');?>
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
							<?php $SPETIAL->ShowUserError("��������:", 'del');?>
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
							<?php $SPETIAL->ShowUserError("���������� ���:", 'koef');?>
							<br />
							<?php if ($set_koef) echo '���������� ����������'; ?>
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
				