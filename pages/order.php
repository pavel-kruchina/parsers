<script type="text/javascript" src="<?php echo $Global['Host']?>/java/domtab.js"></script>
<script type="text/javascript">
		document.write('<style type="text/css">');    
		document.write('div.domtab div{display:none;}<');
		document.write('/s'+'tyle>');    
    </script>
	
	<!--[if gt IE 6]>
	<style type="text/css">
		ul.domtabs a:link,
		ul.domtabs a:visited,
		ul.domtabs a:active,
		ul.domtabs a:hover{
			height:3em;
		}
	</style>
	<![endif]-->
	
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
 
	<div id="breadcrums">
		<a href="<?php echo $Global['Host']?>">�������</a>&nbsp;&nbsp;/&nbsp;&nbsp;������� �����
	</div>
	<?php if ($sended) echo $sended;?>
	<form method="post" action="">
	<input type="hidden" name="sender" value="order" />
	<input type="hidden" name="typer" value="��������" />
	<div class="domtab">	
	<input type="radio" id="" name="action" value="������" /><label>������</label><input name="action" value="�������" type="radio" id="" /><label>�������</label><input type="radio" id="" name="action" value="������" /><label>����������</label>
	<ul class="domtabs">
		<li><a OnClick = "document.getElementById('typer').value='��������'" href="#flat">��������</a></li>
		<li><a OnClick = "document.getElementById('typer').value='���'" href="#house">���</a></li>
		<li><a OnClick = "document.getElementById('typer').value='�����'" href="#land">�����</a></li>
	</ul>
	<div>
		<h2><a name="flat" id="flat">���������� ���������</a></h2>
		<table border="0">
			<tr>
				<td valign="top" width="160px">
					������<br />
					<input type="text" id="" name="region" /><br /><br />
					�����<br />
					<input type="text" id="" name="town" /><br /><br />
					�����/�����<br />
					<input type="text" id="" name="area" /><br /><br />
				</td>
				<td valign="top" width="160px">
					������<br />
					<input type="text" id="" name="metr" /><br /><br />
					���������� ������<br />
					<input type="text" id="" name="kom_num" /><br /><br />
					����<br />
					<input type="text" id="" name="et" /><br /><br />
				</td>
				<td valign="top" width="160px">
					���������<br />
					<input type="text" id="" name="price" /><br /><br />
				</td>
			</tr>
		</table>
		<br />�������������<br />
		<textarea id="" name="dops" rows="8" cols="100"></textarea><br /><br />
		<table border="0">
			<tr>
				<td width="160px">���<br /><input type="text" id="" name="fio" /><br /><br /></td>
				<td width="160px">���������� �������<br /><input type="text" name="tel" id="" /><br /><br /></td>
				<td width="160px">E-mail<br /><input type="text" id="" name="email" /><br /><br /></td>
			</tr>
		</table>
	</div>
	<div>
		<h2><a name="house" id="house">���������� ���������</a></h2>
		<table border="0">
			<tr>
				<td valign="top" width="160px">
					������<br />
					<input type="text" id="" name="region1" /><br /><br />
					�����<br />
					<input type="text" id="" name="town1" /><br /><br />
					�����/�����<br />
					<input type="text" id="" name="area1" /><br /><br />
				</td>
				<td valign="top" width="160px">
					������<br />
					<input type="text" id="" name="metr1" /><br /><br />
					���������� ������<br />
					<input type="text" id="" name="kom_num1" /><br /><br />
					���������<br />
					<input type="text" id="" name="ets" /><br /><br />
				</td>
				<td valign="top" width="160px">
					���������<br />
					<input type="text" id="" name="price1" /><br /><br />
				</td>
			</tr>
		</table>
		<br />�������������<br />
		<textarea id="" name="dops1" rows="8" cols="100"></textarea><br /><br />
		<table border="0">
			<tr>
				<td width="160px">���<br /><input type="text" id="" name="fio1" /><br /><br /></td>
				<td width="160px">���������� �������<br /><input type="text" name="tel1" id="" /><br /><br /></td>
				<td width="160px">E-mail<br /><input type="text" id="" name="email1" /><br /><br /></td>
			</tr>
		</table>
	</div>
	<div>
		<h2><a name="land" id="land">���������� ���������</a></h2>
		<table border="0">
			<tr>
				<td valign="top" width="160px">
					������<br />
					<input type="text" id=""  name="region2" />  <br /><br />
					�����/�����<br />
					<input type="text" name="area2" id="" /><br /><br />
				</td>
				<td valign="top" width="160px">
					�������<br />
					<input type="text" id="" name="sq" /><br /><br />
					����������<br />
					<input type="text" id="" name="target" /><br /><br />
				</td>
				<td valign="top" width="160px">
					���������<br />
					<input type="text" id="" name="price2" /><br /><br />
				</td>
			</tr>
		</table>
		<br />�������� ���������<br />
		<textarea id="" name="dops2" rows="8" cols="100"></textarea><br /><br />
		<table border="0">
			<tr>
				<td width="160px">���<br /><input type="text" id="" name="fio2" /><br /><br /></td>
				<td width="160px">���������� �������<br /><input type="text" name="tel2" id="" /><br /><br /></td>
				<td width="160px">E-mail<br /><input type="text" id="" name="email2" /><br /><br /></td>
			</tr>
		</table>
	</div>	
	</div>
	<br /><input type="submit" value="���������" class="button"/>
	</form>
 
 </div>