<?php 
						$gallery_id = (int)$Global['Url.Page'][1];
											
						$GALLERY->ReadOneObject($gallery_id);
						if (!$GALLERY->Object) $GALLERY->Object = array();
						$Vars = array_merge($GALLERY->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$GALLERY->ReadAll();
					?>
					<h1>Галерея</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_gallery">Добавить</a><br /><br />
					<?php 
					if ($GALLERY->Objects)
					foreach ($GALLERY->Objects as $gallery){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_gallery/<?php echo $gallery['gallery_id']; ?>"><?php echo $gallery['gallery_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="gallery_id" value="<?php echo $gallery_id;?>" />
					<input type="hidden" name="sender" value="edit_gallery" />
					<table>
					
					<tr><td class="form_caption">
							<?php $GALLERY->ShowUserError("Изображение:", 'ColorIm');?>
							<?if ($gallery_id) echo '<img align="right" src="'.$Global['Host'].'/'.$Global['Gal.CDir'].'/'.$gallery_id.'.jpg" >'; ?>
						</td>
						<td class="form_input">
						<input type="file" maxlength="255" name="ColorIm"  />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $GALLERY->ShowUserError("Описание:", 'gallery_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="gallery_name" value="<?php echo $Vars['gallery_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($gallery_id) {?> 
						<input class="button" type="submit" onclick="return confirm('Вы действительно хотите удалить?');" name="delete" value="Удалить">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>