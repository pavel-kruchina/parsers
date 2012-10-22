<?php 
						$cat_id = (int)$Global['Url.Page'][1];
						
						$sc_id = (int)$Global['Url.Page'][2];
						$good_id = (int)$Global['Url.Page'][3];
						
						$CAT->ReadOneObject($cat_id);
						$Vars = array_merge($CAT->Object, $HTTP_POST_VARS, $HTTP_GET_VARS);
				
						$CAT->ReadAll();
						
						
						$sajax_request_type = "POST";
						$sajax_remote_uri = $Global['Host'].'/ajax.php';
						sajax_init();
						sajax_export("get_cat", "get_subcats", "get_subcat", "get_goods", "get_good");
						sajax_handle_client_request();	
					?>
					<script>
					<?php 
						sajax_show_javascript();
					?>
					
					function respCat(data) {
						document.getElementById("catform").innerHTML = data;
					}
					
					function respSubCats(data) {
						document.getElementById("subcats").innerHTML = data;
					}
					
					function getSubCats(cat_id) {
						document.getElementById("subcats").innerHTML = "�����������...";
						document.getElementById("goods").innerHTML = "";
						x_get_subcats(cat_id, respSubCats);
					}
					
					function AddPhoto() {
						document.getElementById("photo1").innerHTML += '<input style="width: 200px" type="file" name="photos[]"><br />';
					}
					
					function ColorText() {
						return '<select onchange="this.style.background = this.value" name="color[]">'+
						 '<OPTION SELECTED VALUE="">�������� ����'+
					     '<OPTION VALUE="#000000">������'+
						 '<OPTION VALUE="#2e3192">�����'+
					     '<OPTION VALUE="#79000e">��������'+
					     '<OPTION VALUE="#541214">������'+
						 '<OPTION VALUE="#335a44">������'+
					     '<OPTION VALUE="darkred">�����-�������'+
						 '<OPTION  VALUE="#FFFFFF">�����'+
						 '<OPTION VALUE="blue">�������'+
					     '<OPTION VALUE="aquamarine">���������'+
					     '<OPTION VALUE="chocolate">����������'+
					     '<OPTION VALUE="darkred">�����-�������'+
					     '<OPTION VALUE="gold">�������'+
					     '<OPTION VALUE="red">�������'+
					     '<OPTION VALUE="yellow">������'+
					     '<OPTION VALUE="lime">�����������'+ 
					     '<OPTION VALUE="darkkhaki">����'+
					     '<OPTION VALUE="cadetblue ">Cadet Blue '+
					     '<OPTION VALUE="darkgoldenrod">Dark Goldenrod'+ 
					     '<OPTION VALUE="darkslateblue">Darkslate Blou'+
					     '<OPTION VALUE="deeppink">Deep Pink'+
					     '<OPTION VALUE="salmon">���� ������'+
					     '<OPTION VALUE="tan">���� ������'+
					     '<OPTION VALUE="wheat">���������'+
					     '<OPTION VALUE="tomato">��������'+
					     '<OPTION VALUE="springgreen">�������� ������'+
					     '<OPTION VALUE="turquoise">���������'+
						'</select>'
					}
					
					function AddColor() {
						document.getElementById("color").innerHTML += ColorText()+'<br />';
					}
					
					function getCat() {
						var id = document.getElementById("cat_id").value; 
						if (id!=0) {
							document.getElementById("catform").style.display = "none";
							document.getElementById("editcat").style.display = "block";
						} else {
							document.getElementById("catform").style.display = "block";
							document.getElementById("editcat").style.display = "none";
						}
						document.getElementById("catform").innerHTML = "�����������...";
						x_get_cat(id, respCat);
						getSubCats(id);
					}
					
					function respGetSC(data) {
						document.getElementById("subcatform").innerHTML = data;
					}
					
					function respGoods(data) {
						document.getElementById("goods").innerHTML = data;
					}
					
					function getSC() {
						var id = document.getElementById("sc_id").value; 
						if (id!=0) {
							document.getElementById("subcatform").style.display = "none";
							document.getElementById("editsubcat").style.display = "block";
						} else {
							document.getElementById("subcatform").style.display = "block";
							document.getElementById("editsubcat").style.display = "none";
						}
						document.getElementById("subcatform").innerHTML = "�����������...";
						x_get_subcat(id, respGetSC);
						
						document.getElementById("goods").innerHTML = "�����������...";
						x_get_goods(id, respGoods);
					}
					
					function getGood(sc_id) {
						document.getElementById("goodform").innerHTML = "�����������...";
						var id = document.getElementById("good_id").value; 
						x_get_good(id, sc_id, respGood);
					}
					
					function respGood(data) {
						document.getElementById("goodform").innerHTML = data;
					}
					
					</script>
					<h1>���������</h1>
					
					<select id="cat_id" OnChange = "getCat()" name="cat_id" style="float: left;">
					<option value="0">�������� ���������</option>
					<?php 
					if ($CAT->Objects)
					foreach ($CAT->Objects as $cat){
					?>
						<option value="<?php echo $cat['cat_id']; ?>" <?php echo ($cat_id==$cat['cat_id'])?'selected':""; ?> ><?php echo $cat['cat_name'];?></option>	
					<?php }?>
					</select> <div id="editcat" OnClick='document.getElementById("editcat").style.display = "none"; document.getElementById("catform").style.display = "block";' <?php echo (!$cat_id)?'style="display: none; float: left; margin-left: 5px;"':'style="float: left; margin-left: 5px;"'; ?> ><a href="#nogo">�������������</a></div>
					<div <?php if ($sc_id) echo 'style="display: none"'?> id="catform">
					<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="cat_id" value="<?php echo $cat_id;?>" />
					<input type="hidden" name="sender" value="edit_cats" />
					<table width="100%">
					
					<tr><td class="form_caption">
							<?php $CAT->ShowUserError("���������:", 'cat_name');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="cat_name" value="<?php echo $CAT->Object['cat_name'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $CAT->ShowUserError("�������:", 'cat_order');?>
						</td>
						<td class="form_input">
						<input maxlength="255" name="cat_order" value="<?php echo $CAT->Object['cat_order'];?>" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							<?php $CAT->ShowUserError("��������:", 'foto');?>
							<?php if ($cat_id) echo '<img src="'.$Global['Host'].'/'.$Global['Cat.Dir'].'/'.$cat_id.'.jpg" />' ?>
						</td>
						<td class="form_input">
						<input type="file" name="file" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					
					<tr><td class="form_caption">
						<?php if($cat_id) {?> 
						<input class="button" type="submit" onclick="return confirm('�� ������������� ������ �������?');" name="delete" value="�������">
						<?php } ?>
					</td><td class="form_input"></td></tr>
					</table>
					</form>
					</div>
					
					<div id = "subcats" style="width: 100%; clear: both">
					<?php
						if ($cat_id) {
							
							$SUBCAT->ReadAll($cat_id);
	$CAT->ReadAll();
	
	$cats = '<select name="cat_id" >';
	foreach ($CAT->Objects as $cat){
		$cats .='<option value="'.$cat['cat_id'].'"'.(($cat_id==$cat['cat_id'])?'selected':"").' >'.$cat['cat_name'].'</option>';	
	}
	$cats .='</select>';
	
	$SUBCAT->ReadOneObject($sc_id);
	
	$res='	<select id="sc_id" OnChange = "getSC()" name="sc_id" style="float: left;">
					<option value="0">�������� ������������</option>
					'; 
	if ($SUBCAT->Objects)
	foreach ($SUBCAT->Objects as $sc){
		$res .= '<option '.(($sc['sc_id']==$sc_id)?'selected':'').' value="'.$sc['sc_id'].'">'.$sc['sc_name'].'</option>';
	}
	$res.='</select> <div id="editsubcat" OnClick=\'document.getElementById("editsubcat").style.display = "none"; document.getElementById("subcatform").style.display = "block";\' '.((!$cat_id)?'style="display: none; float: left; margin-left: 5px;"':'style="float: left; margin-left: 5px;"').'><a href="#nogo">�������������</a></div>
		<div '.($sc_id?'style="display: none;"':'').' id="subcatform">
		
		<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="sc_id" value="'.$SUBCAT->Object['sc_id'].'" />
					<input type="hidden" name="sender" value="edit_subcats" />
					<table width="100%">
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("������������:", 'sc_name').'
						</td>
						<td class="form_input">
						<input maxlength="255" name="sc_name" value="'.$SUBCAT->Object['sc_name'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("������������ ���������:", 'cat_id').'
						</td>
						<td class="form_input">
						'.$cats.'
						</td>
					</tr>
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("���������:", 'sc_header').'
						</td>
						<td class="form_input">
						<input maxlength="255" name="sc_header" value="'.$SUBCAT->Object['sc_header'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("��������:", 'sc_desc').'
						</td>
						<td class="form_input">
						<input  name="sc_desc" value="'.$SUBCAT->Object['sc_desc'].'" />
						</td>
					</tr>
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("�������������� �����:", 'sc_text').'
						</td>
						<td class="form_input">
						<textarea name="sc_text">'.$SUBCAT->Object['sc_text'].'</textarea>
						</td>
					</tr>
					
					
					<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					<tr><td class="form_caption">';
						if($sc_id) { 
						$res .= '<input class="button" type="submit" onclick="return confirm(\'�� ������������� ������ �������?\');" name="delete" value="�������">';
						} 
					$res.='
					</td><td class="form_input"></td></tr>
					</table>
					</form>
		
		
		
		</div>
		';
	
	echo $res;
							
						}
					?>
					</div>
					
					<div id = "goods" style="width: 100%; clear: both">
					<?php
					if ($sc_id) {
					$GOOD->ReadAll($sc_id);
	$SUBCAT->ReadSame($sc_id);
					
					$subcats = '<select name="sc_id" >';
	foreach ($SUBCAT->Objects as $cat){
		$subcats .='<option value="'.$cat['sc_id'].'"'.(($sc_id==$cat['sc_id'])?'selected':"").' >'.$cat['sc_name'].'</option>';	
	}
	$subcats .='</select>';
	
	$res='	<select id="good_id" OnChange = "getGood('.$sc_id.')" name="good_id" style="float: left;">
					<option value="0">�������� �����</option>
					'; 
					
	$GOOD->ReadOneObject($good_id);
					
	if ($GOOD->Objects)
	foreach ($GOOD->Objects as $good){
		$selected = ($good['good_id']==$good_id)?('selected'):'';
		$res .= '<option '.$selected.' value="'.$good['good_id'].'">��� '.$good['good_art'].' '.$good['good_name'].'</option>';
	}
	
	$prices = $MAT->GetPriceForGood($good_id);
	
	$res.='</select> 
		<div id="goodform" style="clear: both">
		
		<form class="edition_form" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="good_id" value="'.$GOOD->Object['good_id'].'" />
					<input type="hidden" name="sender" value="edit_goods" />
					<table width="100%">
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("�������� ������:", 'good_name').'
						</td>
						<td class="form_input">
						<input maxlength="29" name="good_name" value="'.$GOOD->Object['good_name'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("������� ������:", 'good_art').'
						</td>
						<td class="form_input">
						<input maxlength="255" name="good_art" value="'.$GOOD->Object['good_art'].'" />
						</td>
					</tr>
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("������������ ���������:", 'sc_id').'
						</td>
						<td class="form_input">
						'.$subcats.'
						</td>
					</tr>
					
					';
					if ($User['user_rights']&$Global['Right.Admin']) {
						$res .= '
						<tr><td class="form_caption">
								����:
							</td>
							<td class="form_input">
							</td>
						</tr>';
						
						foreach ($prices as $row) {
							$res.='<tr><td class="form_caption">
								'.$row['mat_name'].'
							</td>
							<td class="form_input">
							<input maxlength="255" name="mat['.$row['mat_id'].']" value="'.$row['matprice'].'" />
							</td>
						</tr>';
						}
					
					};
					$res.='<tr><td class="form_caption">
							����������:
						</td>
						<td class="form_input">
						<button OnClick="AddPhoto(); return false;">�������� ����</button>
						</td>
					</tr>';
					
					if ($good_id>0) {
						
							$tmp = $DB->ReadAss('Select * FROM o_photos where good_id='.$good_id);
							if ($tmp)
							foreach ($tmp as $row) {
								
								$res.= '<tr><td><img src="'.$Global['Host'].'/'.$Global['Foto.MinDir'].'/'.$row['photo_id'].'.jpg" ></td><td><input style="width: 200px" type="file" name="exphotos['.$row['photo_id'].']"><br />�������<input type="checkbox" value=1 name="delete'.$row['photo_id'].'"></td></tr>';
							}
					}
					
					$res .= '<tr><td class="form_caption">
						</td><td class="form_input">
							<div id="photo1">
							</div>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							�����:
						</td>
						<td class="form_input">
						<button OnClick="AddColor(); return false;">�������� ����</button>
						</td>
					</tr>
					';
					
					if ($good_id>0) {
						
							$tmp = $DB->ReadAss('Select * FROM colors where good_id='.$good_id);
							foreach ($tmp as $row) {
								
						$res.= '<tr><td></td><td><select onchange="this.style.background = this.value" name="color[]">'.
						 '<OPTION  '.(($row['color_value']=="")?'selected':'').' VALUE="">�������� ����'.
						 '<OPTION '.(($row['color_value']=="#000000")?'selected':'').' VALUE="#000000">������'.
						 '<OPTION '.(($row['color_value']=="#2e3192")?'selected':'').' VALUE="#2e3192">�����'.
					     '<OPTION '.(($row['color_value']=="#79000e")?'selected':'').' VALUE="#79000e">��������'.
					     '<OPTION '.(($row['color_value']=="#541214")?'selected':'').' VALUE="#541214">������'.
						 '<OPTION '.(($row['color_value']=="#335a44")?'selected':'').' VALUE="#335a44">������'.
						 '<OPTION '.(($row['color_value']=="#FFFFFF")?'selected':'').' VALUE="#FFFFFF">�����'.
						 '<OPTION'.(($row['color_value']=="blue")?'selected':'').' VALUE="blue">�������'.
					     '<OPTION '.(($row['color_value']=="aquamarine")?'selected':'').' VALUE="aquamarine">���������'.
					     '<OPTION '.(($row['color_value']=="chocolate")?'selected':'').' VALUE="chocolate">����������'.
					     '<OPTION '.(($row['color_value']=="darkred")?'selected':'').' VALUE="darkred">�����-�������'.
					     '<OPTION '.(($row['color_value']=="gold")?'selected':'').' VALUE="gold">�������'.
					     '<OPTION '.(($row['color_value']=="red")?'selected':'').' VALUE="red">�������'.
					     '<OPTION '.(($row['color_value']=="yellow")?'selected':'').' VALUE="yellow">������'.
					     '<OPTION '.(($row['color_value']=="lime")?'selected':'').' VALUE="lime">�����������'. 
					     '<OPTION '.(($row['color_value']=="darkkhaki")?'selected':'').' VALUE="darkkhaki">����'.
					     '<OPTION '.(($row['color_value']=="cadetblue")?'selected':'').' VALUE="cadetblue ">Cadet Blue '.
					     '<OPTION '.(($row['color_value']=="darkgoldenrod")?'selected':'').' VALUE="darkgoldenrod">Dark Goldenrod'. 
					     '<OPTION '.(($row['color_value']=="darkslateblue")?'selected':'').' VALUE="darkslateblue">Darkslate Blou'.
					     '<OPTION '.(($row['color_value']=="deeppink")?'selected':'').' VALUE="deeppink">Deep Pink'.
					     '<OPTION '.(($row['color_value']=="salmon")?'selected':'').' VALUE="salmon">���� ������'.
					     '<OPTION '.(($row['color_value']=="tan")?'selected':'').' VALUE="tan">���� ������'.
					     '<OPTION '.(($row['color_value']=="wheat")?'selected':'').' VALUE="wheat">���������'.
					     '<OPTION '.(($row['color_value']=="tomato")?'selected':'').' VALUE="tomato">��������'.
					     '<OPTION '.(($row['color_value']=="springgreen")?'selected':'').' VALUE="springgreen">�������� ������'.
					     '<OPTION '.(($row['color_value']=="turquoise")?'selected':'').' VALUE="turquoise">���������'.
					    '</select></td></tr>';
							}
					}
					
					
					$res.='
					<tr><td class="form_caption">
						</td><td class="form_input">
							<div id="color">
							</div>
						</td>
					</tr>
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("�������� ������:", 'good_desc').'
						</td>
					</tr>
					<tr>	
					<td class="form_input" colspan=2>
					';
						$EDITOR = new FCKeditor("good_desc");
						$EDITOR->Value = $GOOD->Object['good_desc'];
						$EDITOR->Width = "100%";
						$EDITOR->Height = "300px";
						$res.=$EDITOR->CreateHtml();
					
					$res.='</td></tr>
					
					<tr><td class="form_caption">
							'.$CAT->HTMLUserError("��������� �����:", 'good_adv').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_adv']?'checked':'').' maxlength="255" name="good_adv" value="1" />
						</td>
					</tr>
					';					
					if ($User['user_rights']&$Global['Right.Admin'])
					$res .= '<tr><td class="form_caption">
							'.$CAT->HTMLUserError('� ���� "�������":', 'good_new').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_new']?'checked':'').' maxlength="255" name="good_new" value="1" />
						</td>
					</tr>';
					
					if ($User['user_rights']&$Global['Right.Admin'])
					$res .= '<tr><td class="form_caption">
							'.$CAT->HTMLUserError('� ���� "�����������":', 'good_bestceller').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_bestceller']?'checked':'').' maxlength="255" name="good_bestceller" value="1" />
						</td>
					</tr>';
					
					if ($User['user_rights']&$Global['Right.Admin'])
					$res .= '<tr><td class="form_caption">
							'.$CAT->HTMLUserError("����� �����������:", 'good_check').'
						</td>
						<td class="form_input">
						<input type="checkbox" '.($GOOD->Object['good_check']?'checked':'').' maxlength="255" name="good_check" value="1" />
						</td>
					</tr>';
					
					$res .= '<tr><td class="form_caption">
						<input class="button" type="submit" value="OK">
					</td><td class="form_input"></td></tr>
					<tr><td class="form_caption">';
						if($good_id) {
						$res .= '<input class="button" type="submit" onclick="return confirm(\'�� ������������� ������ �������?\');" name="delete" value="�������">';
						}
					$res.='
					</td><td class="form_input"></td></tr>
					</table>
					</form>
		
		
		
		</div>
		';
		
		echo $res;
					
		}
					
					?>
					</div>
					
					<div style="height: 20px;">
					</div>