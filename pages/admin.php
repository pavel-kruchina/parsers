
					<h1>Вход. <?php echo $Errors['Password']?></h1>
					
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="sender" value="login" />
					
					<div style="width:100%; margin-top: 10px;">
						<div class="text1">
							Логин
						</div>
						<input maxlength="255" name="user_login" />
					</div>
					
					<div  style="width:100%; margin-bottom: 10px;">
						<div class="text1">
							Пароль
						</div>
						<input type="password" maxlength="100" name="user_password" />
					</div>
					
					<div class="row">
						
						<input type="submit" value="Войти"/>
					</div>
					</form>
