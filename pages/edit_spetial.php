<div id="menu" align="right">
	<ul>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>">�������</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/news">�������</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/about">� ��������</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/contacts">��������</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/help">�������</a></li>
		<li class="last"><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/search">�����</a></li>
	</ul>
 </div>
 <div id="line_after_menu_left"></div>
 <div id="line_after_menu_right"></div>
 <div id="line_after_menu_bg"></div>
 <div id="line_after_menu_ln"></div>

 <div id="left">
<?php 
						$spetial_id = (int)$Global['Url.Page'][1];
											
						$SPETIAL->ReadOneObject($spetial_id);
						$Vars = array_merge($SPETIAL->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$SPETIAL->ReadAll();
					?>
					<h1>����. �����������</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_spetial">��������</a><br /><br />
					<?php 
					if ($SPETIAL->Objects)
					foreach ($SPETIAL->Objects as $spetial){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_spetial/<?php echo $spetial['sp_id']; ?>"><?php echo $spetial['sp_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="sp_id" value="<?php echo $spetial_id;?>" />
					<input type="hidden" name="sender" value="edit_spetial" />
					<table>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("��������:", 'sp_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="sp_name" value="<?php echo $Vars['sp_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("��������:", 'foto');?>
							<?php if ($spetial_id) echo '<img src="'.$Global['Host'].'/'.$Global['Spec.Dir'].'/'.$spetial_id.'.jpg" />' ?>
						</td>
						<td class="form_input">
						<input type="file" name="file" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("��������:", 'sp_prev');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="sp_prev" value="<?php echo $Vars['sp_prev'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("����� ������� ���������(� http://):", 'sp_url');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="sp_url" value="<?php echo $Vars['sp_url'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $SPETIAL->ShowUserError("�������:", 'sp_activ');?>
						</td>
						<td class="form_input">
						<input type=checkbox name="sp_activ" value="1" <?php if ($Vars['sp_activ']) echo 'checked' ;?> />
						</td>
					</tr>
										
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($spetial_id) {?> 
						<input class="button" type="submit" onclick="return confirm('�� ������������� ������ �������?');" name="delete" value="�������">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
</div>