					<?php if ($Success) echo $Success; else { ?>
					Введите свои данные:
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="sender" value="registration" />
					<?php $Vars=$HTTP_POST_VARS;?>
					
					<table>
					<tr><td class="form_caption">
						<?php $USER->ShowUserError("Логин:", 'user_login');?>
					</td><td>
						<input maxlength="255" name="user_login" value = "<?php echo $Vars['user_login'];?>" />
					</td>
					</tr>
					
					<tr><td class="form_caption">
						<?php $USER->ShowUserError("Пароль:", 'user_password');?>
					</td><td>
						<input type="password" maxlength="100" name="user_password" value = "<?php echo $Vars['user_password'];?>" />
					</td>
					</tr>
					
					<tr><td class="form_caption">
						<?php $USER->ShowUserError("Повторите пароль:", 'retry');?>
					</td><td>
						<input type="password" maxlength="100" name="retry" value = "" />
					</td>
					</tr>
					
					<tr><td class="form_caption">
						<?php $USER->ShowUserError("ФИО:", 'user_fio');?>
					</td><td>
						<input  maxlength="255" name="user_fio" value = "<?php echo $Vars['user_fio'];?>" />
					</td>
					</tr>
					
					<tr><td class="form_caption">
					
							<?php $USER->ShowUserError("Контактные данные:", 'user_contacts');?>
					</td><td>
						<textarea name="user_contacts"><?php echo $Vars['user_contacts'];?></textarea>
					</td>
					</tr>
					
					<tr><td class="form_caption">
					
						<input type="submit" value="Зарегистрироваться"/>
					</td>
					</tr>
					</table>
					</form>
<? } ?>