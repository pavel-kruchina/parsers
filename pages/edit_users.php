<div style="text-align: left">
					<?php 
						$pgroup_id = (int)$Global['Url.Page'][1];
						$user_id = (int)$Global['Url.Page'][2];
						
						$PGROUP->ReadAll();
						
						if ($pgroup_id) {
						
							$PGROUP->ReadOneObject($pgroup_id);
							$USER->ReadAll($pgroup_id);
							if ($user_id) {
								$USER->ReadOneObject($user_id);
								@$Vars = array_merge($USER->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
							} else {
								
								@$Vars = array_merge($PGROUP->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
							}
						} 
						
						$sajax_request_type = "POST";
						$sajax_remote_uri = $Global['Host'].'/ajax.php';
						sajax_init();
						sajax_export("get_pgroup", "get_users", "get_user");
						sajax_handle_client_request();
					?>
					<script>
					<?php 
						sajax_show_javascript();
					?>
					
					function respPGroup(data) {
						document.getElementById("pgroupform").innerHTML = data;
					}
					
					function respUsers(data) {
						document.getElementById("users").innerHTML = data;
					}
					
					function getUsers(pgroup_id) {
						document.getElementById("users").innerHTML = "�����������...";
						x_get_users(pgroup_id, respUsers);
					}
					
					function getPGroup() {
						var id = document.getElementById("pgroup_id").value; 
						if (id>0) {
							document.getElementById("pgroupform").style.display = "none";
							document.getElementById("editpgroup").style.display = "block";
						} else  {
							if (id==0) {
								document.getElementById("pgroupform").style.display = "block";
								document.getElementById("editpgroup").style.display = "none";
							} else {
								document.getElementById("pgroupform").style.display = "none";
								document.getElementById("editpgroup").style.display = "none";
							}
						}
						document.getElementById("pgroupform").innerHTML = "�����������...";
						x_get_pgroup(id, respPGroup);
						getUsers(id);
					}
					
					function respGetUser(data) {
						document.getElementById("usersform").innerHTML = data;
					}
					
					function getUser() {
						var id = document.getElementById("user_id").value; 
						
						document.getElementById("usersform").innerHTML = "�����������...";
						x_get_user(id, respGetUser);
						
					}
					
					</script>
					
					<h1>������</h1>
					
					<select id="pgroup_id" OnChange = "getPGroup()" name="pgroup_id" style="float: left;">
					<option value="0">�������� ������</option>
					<?php 
					if ($PGROUP->Objects)
					foreach ($PGROUP->Objects as $pgroup){
					?>
						<option value="<?php echo $pgroup['pgroup_id']; ?>" <?php echo ($pgroup_id==$pgroup['pgroup_id'])?'selected':""; ?> ><?php echo $pgroup['pgroup_name'];?></option>	
					<?php }?>
					<option <?php echo ($pgroup_id==-1)?'selected':""; ?> value="-1">��� �����</option>
					</select>

					<div id="editpgroup" OnClick='document.getElementById("editpgroup").style.display = "none"; document.getElementById("pgroupform").style.display = "block";' <?php echo ($pgroup_id<=0)?'style="display: none; float: left; margin-left: 5px;"':'style="float: left; margin-left: 5px;"'; ?> ><a href="#nogo">�������������</a></div>
			
					<div <?php if ($user_id || $pgroup_id==-1) echo 'style="display: none"'?> id="pgroupform">
					
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="pgroup_id" value="<?php echo $pgroup_id;?>" />
					<input type="hidden" name="sender" value="edit_pgroups" />
					<table width="100%">
					
					<tr><td class="form_caption">
							<?php $CAT->ShowUserError("������:", 'pgroup_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="pgroup_name" value="<?php echo $PGROUP->Object['pgroup_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($pgroup_id) {?> 
						<input class="button" type="submit" onclick="return confirm('�� ������������� ������ �������?');" name="delete" value="�������">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					</div>
					
					<div id = "users" style="width: 100%; clear: both">
					<?php if ($pgroup_id) { ?>
					<h2>������������</h2>
					
					<div class="links_overflow">
					<a href="<?php echo $Global['Host'].'/edit_users/'.$pgroup_id; ?>">�������� ������������</a><br /><br />
					<?php 
					if ($USER->Objects)
					foreach ($USER->Objects as $user){
					?>
						<a href="<?php echo $Global['Host'].'/edit_users/'.$user['pgroup_id'].'/'.$user['user_id']; ?>">
						<?php echo ('< '.$user['user_login'].' > '.$user['user_soname'].' '.$user['user_name']);?></a><br />
	
					<?php }?>
					
					</div>
					<div id="usersform" style="width: 100%; clear: both" >
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
					<input type="hidden" name="sender" value="edit_users" />
					<table>
					<tr><td class="form_caption">
						������������:
					</td><td class="form_input"> <?php echo $Vars['user_login'];?> </td></tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("�����:", 'user_login');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_login" value="<?php echo $Vars['user_login'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("������:", 'user_password');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_password" value="<?php echo $Vars['user_password'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("������������:", 'pgroup_id');?>
						</td><td class="form_input">
						<Select name="pgroup_id">
							<?php $PGROUP->ReadAll();
							
								foreach ($PGROUP->Objects as $row) {
									
									$selected = ($Vars['pgroup_id'] == $row['pgroup_id'])?'selected':'';
									echo '<option '.$selected.' value='.$row['pgroup_id'].'>'.$row['pgroup_name'].'</option>';
								}
							?>
							<option value="-1">��� �����</option>
						</select>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("������:", 'group_id');?>
						</td><td class="form_input">
						<Select name="group_id">
							<?php $GROUP->ReadAll();
							
								foreach ($GROUP->Objects as $row) {
									
									$selected = ($Vars['group_id'] == $row['group_id'])?'selected':'';
									echo '<option '.$selected.' value='.$row['group_id'].'>'.$row['group_name'].'</option>';
								}
							?>
						</select>
						</td>
					</tr>
					
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("�����:", 'user_rights');?>
						</td><td class="form_input">
						<Select name="user_rights">
							<option value="<?php echo $Global['Right.User'];?>">������������</option>
							<option value="<?php echo $Global['Right.Man']+$Global['Right.User'];?>" <?php echo  (($Global['Right.Man'] & $Vars['user_rights']) ? 'selected':'');?>>��������</option>
							<option value="<?php echo $Global['Right.User']+$Global['Right.Man']+$Global['Right.StMan'];?>" <?php echo  (($Global['Right.Stman'] & $Vars['user_rights']) ? 'selected':'');?>>������� ��������</option>
							<option value="<?php echo $Global['Right.SEO']+$Global['Right.User']?>" <?php echo ($Global['Right.SEO'] & $Vars['user_rights']) ? 'selected':''?>>���-����������</option>
							<option value="<?php echo $Global['Right.Admin']+$Global['Right.SEO']+$Global['Right.User']+$Global['Right.Man']+$Global['Right.StMan'];?>" <?php echo  (($Global['Right.Admin'] & $Vars['user_rights']) ? 'selected':'');?>>�������������</option>
							
						</select>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("���:", 'user_name');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_name" value="<?php echo $Vars['user_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("�������:", 'user_soname');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_soname" value="<?php echo $Vars['user_soname'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("��������:", 'user_pname');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_pname" value="<?php echo $Vars['user_pname'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						&nbsp;
						</td><td class="form_input">
						
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("�����������:", 'user_org');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_org" value="<?php echo $Vars['user_org'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("��� ������������:", 'user_doing');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_doing" value="<?php echo $Vars['user_doing'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("�����:", 'user_adr');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_adr" value="<?php echo $Vars['user_adr'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("�����:", 'user_town');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_town" value="<?php echo $Vars['user_town'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						&nbsp;
						</td><td class="form_input">
						
						</td>
					</tr>
					<tr><td class="form_caption">
							<?php $USER->ShowUserError("�����:", 'user_mail');?>
						</td><td class="form_input">
						<input maxlength="255" name="user_mail" value="<?php echo $Vars['user_mail'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($user_id) {?> 
						<input class="button" type="submit" onclick="confirm('�� ������������� ������ �������?');" name="delete" value="�������">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					<?php } ?>
					</div>
					</div>
				
</div>