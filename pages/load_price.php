					<h1>Загрузить прайс</h1>
					
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="sender" value="load_price" />

					
					<div class="row">
						<div class="text">
							<?php $USER->ShowUserError("Выбрать файл:", 'File');?>
						</div>
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $Global['File.MaxSize'];?>" />
						<input type="file" maxlength="100" name="price" />
					</div>
					
					<div class="row">
						
						<input type="submit" value="Загрузить"/>
					</div>
					
					</form>