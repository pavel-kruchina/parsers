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
						$carency_id = (int)$Global['Url.Page'][1];
											
						$CARENCY->ReadOneObject($carency_id);
						$Vars = array_merge($CARENCY->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$CARENCY->ReadAll();
					?>
					<h1>������</h1>
					<div class="links_overflow">
					
					<a href="<?php echo $Global['Host']; ?>/edit_carency">��������</a><br /><br />
					<?php 
					if ($CARENCY->Objects)
					foreach ($CARENCY->Objects as $carency){
					?>
						<a href="<?php echo $Global['Host'];?>/edit_carency/<?php echo $carency['carency_id']; ?>"><?php echo $carency['carency_name'];?></a><br />	
					<?php }?>
					
					</div>
					
					<?//<hr class="clear">?>
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					
					<input type="hidden" name="carency_id" value="<?php echo $carency_id;?>" />
					<input type="hidden" name="sender" value="edit_carency" />
					<table>
					
					<tr><td class="form_caption">
							<?php $CARENCY->ShowUserError("������:", 'carency_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="carency_name" value="<?php echo $Vars['carency_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $CARENCY->ShowUserError("��. �����, �. �����:", 'carency_mv');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="carency_mv" value="<?php echo $Vars['carency_mv'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $CARENCY->ShowUserError("���� �� ��������� � �����:", 'carency_value');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="carency_value" value="<?php echo $Vars['carency_value'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $CARENCY->ShowUserError("��������� ���� �� ��������� � �����:", 'carency_yvalue');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="carency_yvalue" value="<?php echo $Vars['carency_yvalue'];?>" />
						</td>
					</tr>
										
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($carency_id) {?> 
						<input class="button" type="submit" onclick="return confirm('�� ������������� ������ �������?');" name="delete" value="�������">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
</div>