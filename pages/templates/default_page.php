
		<div class="bigmenu">
			<div class="productbox">
				<div class="arrowup" onClick="Up();"></div>
				<div class="box"><div id="lenta" style="position: relative;"><?php global $CAT;  $CAT->GetCats()?></div></div>
				<div class="arrowdown" onClick="Down();"></div>
				
				<script>
					var shag = 76;
					var pos = 0;
					function Up() {
						if (pos < 0-shag) {
							konv("lenta", shag, pos);
							pos+=shag;
						} else {
							if (pos < 0) {
								konv("lenta", -pos, pos);
								pos = 0;
							} else document.getElementById("lenta").style.top="0px";
							
						}
					}
					
					function Down() {
						if (pos > 231-mh+shag) {
							konv("lenta", -shag, pos);
							pos-=shag;
						} else {
							if (pos > 231-mh) {
								konv("lenta", 231-mh-pos, pos);
								pos = 231-mh;
							}
						}
					}
					
				</script>
				
			</div>
			
			<div class="flash"><?php echo showFlash();?></div>
		</div>
		
		<div  class="content">
			<table cellspacing=0 cellpadding=0 width="100%"><tr valign="top"><td >	
			<div class="article" >
			<div style="float: left; width: 0px; height: 300px"></div>
				<?php
					echo $Page['page_text'];
				?>
			</div>
			<td>
			<td class="news">
				<div class="news">
				<div class="new_cap"></div><br />
				<?php global $NEW; $NEW->ShowLastNews(2);?>
				<div class="mailing">
					<div style="padding-bottom:2px">����������� �� ��������: </div>
					<input style="color: #d9d9d9" id="mail"  value="��� e-mail" OnFocus="FirstEmailClick(this)" /><div OnClick="AddToList()" id="ok" class="ok"></div>
				</div>
				</div>
			</td>
			</tr></table>
		</div>
	</div>