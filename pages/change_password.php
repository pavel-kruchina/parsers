
					<h1>������� ������</h1>
					
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="sender" value="change_password" />
					<table>
					<tr><td>
							<?php $USER->ShowUserError("������ ������:", 'Old Password');?>
						</td>
						<td><input type="password" maxlength="100" name="old_password" /></td>
					</tr>
					
					<tr>
						<td>
							����� ������
						</td>
						<td>
						<input type="password" maxlength="100" name="new_password" />
					</td></tr>
					
					<tr><td>
							<?php $USER->ShowUserError("�������������:", 'Retry Password');?>
						</td>
						<td>
						<input type="password" maxlength="100" name="retry_password" />
					</td></tr>
					
					<tr>
						<td>
						<input class="button" type="submit" value="��������"/>
					</td></tr>
					</table>
					</form>
