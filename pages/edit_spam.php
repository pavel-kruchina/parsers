					<?php
					
					$spams = $DB->ReadAss('select * from spam ORDER by spam_id DESC');
					
					?>
					<h2>Управление рассылкой</h2>
					<a href="<?php echo $Global['Host']?>/getus.php">Получить файл</a><br /><br />
					<?php 
					
					foreach ($spams as $key=>$row) {
						
						echo '<div style= "width: 250px; height: 30px;"  id="sr'.$key.'"><div style="width: 200px; overflow: hidden; float: left;">'.$row['mail'].'</div><div OnClick="deleteSpam(\'sr'.$key.'\', '.$row['spam_id'].')" class="delete"></div></div>';
					}
					
					?>
