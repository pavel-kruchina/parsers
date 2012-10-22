/*
setElementOpacity - ��������� ������������
getOpacityProperty - ��������, ���� �� ����������� ������ ������������
fadeOpacity - ������� ��������� ������������
*/

/* ������� ��������������� ��������� ������������

������: setElementOpacity(document.body, 0.5); //������� �������� ���������� �� ��������
*/
function setElementOpacity(oElem, nOpacity)
{
	var p = getOpacityProperty();
	(setElementOpacity = p=="filter"?new Function('oElem', 'nOpacity', 'nOpacity *= 100;	var oAlpha = oElem.filters["DXImageTransform.Microsoft.alpha"] || oElem.filters.alpha;	if (oAlpha) oAlpha.opacity = nOpacity; else oElem.style.filter += "progid:DXImageTransform.Microsoft.Alpha(opacity="+nOpacity+")";'):p?new Function('oElem', 'nOpacity', 'oElem.style.'+p+' = nOpacity;'):new Function)(oElem, nOpacity);
}

// ������� getOpacityProperty() ���������� �������� ������� ������������ ��� ����� ������������ ��� undefined, � ����� �������������� ��� �������� ����������� ��������� ������������
function getOpacityProperty()
{
	var p;
	if (typeof document.body.style.opacity == 'string') p = 'opacity';
	else if (typeof document.body.style.MozOpacity == 'string') p =  'MozOpacity';
	else if (typeof document.body.style.KhtmlOpacity == 'string') p =  'KhtmlOpacity';
	else if (document.body.filters && navigator.appVersion.match(/MSIE ([\d.]+);/)[1]>=5.5) p =  'filter';
	
	return (getOpacityProperty = new Function("return '"+p+"';"))();
}

/* ������� ��� �������� ��������� ������������:

1) fadeOpacity.addRule('opacityRule1', 1, 0.5, 30); //������� ������� �������, ������ ��� �������, ��������� ������������ � ��������, �������������� �������� ��������, ��������� �� �������� ����� ������������
2) fadeOpacity('elemID', 'opacityRule1'); // ��������� ������� ����� ������������ �������� � id ������ elemID, �� ������� opacityRule1
3) fadeOpacity.back('elemID'); //��������� � �������� �������� ������������
*/
function fadeOpacity(sElemId, sRuleName, bBackward)
{
	var elem = document.getElementById(sElemId);
	//if (!elem || !getOpacityProperty() || !fadeOpacity.aRules[sRuleName]) return;
	
	var rule = fadeOpacity.aRules[sRuleName];
	var nOpacity = rule.nStartOpacity;
	
	if (fadeOpacity.aProc[sElemId]) {clearInterval(fadeOpacity.aProc[sElemId].tId); nOpacity = fadeOpacity.aProc[sElemId].nOpacity;}
	if ((nOpacity==rule.nStartOpacity && bBackward) || (nOpacity==rule.nFinishOpacity && !bBackward)) return;

	fadeOpacity.aProc[sElemId] = {'nOpacity':nOpacity, 'tId':setInterval('fadeOpacity.run("'+sElemId+'")', fadeOpacity.aRules[sRuleName].nDalay), 'sRuleName':sRuleName, 'bBackward':Boolean(bBackward)};
}

fadeOpacity.addRule = function(sRuleName, nStartOpacity, nFinishOpacity, nDalay){fadeOpacity.aRules[sRuleName]={'nStartOpacity':nStartOpacity, 'nFinishOpacity':nFinishOpacity, 'nDalay':(nDalay || 30),'nDSign':(nFinishOpacity-nStartOpacity > 0?1:-1)};};

fadeOpacity.back = function(sElemId){fadeOpacity(sElemId,fadeOpacity.aProc[sElemId].sRuleName,true);};

fadeOpacity.run = function(sElemId)
{
	var proc = fadeOpacity.aProc[sElemId];
	var rule = fadeOpacity.aRules[proc.sRuleName];
	
	proc.nOpacity = Math.round(( proc.nOpacity + .1*rule.nDSign*(proc.bBackward?-1:1) )*10)/10;
	setElementOpacity(document.getElementById(sElemId), proc.nOpacity);
	
	if (proc.nOpacity==rule.nStartOpacity || proc.nOpacity==rule.nFinishOpacity) clearInterval(fadeOpacity.aProc[sElemId].tId);
}
fadeOpacity.aProc = {};
fadeOpacity.aRules = {};

var find;

function fade(element,fv) {
	if (document.getElementById(element).fade == 'in') {
		fv+=0.1;
		setElementOpacity(document.getElementById(element), fv);
		if (fv<0.5) setTimeout('fade("'+element+'",'+fv+')', 50);
	} else {
		fv-=0.1;
		setElementOpacity(document.getElementById(element), fv);
		if (fv>0) setTimeout('fade("'+element+'",'+fv+')', 50);
		else document.getElementById(element).style.display = 'none';
	}
}

function fadein(element) {
	document.getElementById(element).fade = 'in';
	var fv = 0;
	//setElementOpacity(document.getElementById(element), fv);
	//document.getElementById(element).style.display = 'block';
	document.getElementById(element).style.top = 0+"px";
	//fade(element,fv); 
}

function fadeout(element) {
	document.getElementById(element).fade = 'out';
	var fv = 0.5;
	//setElementOpacity(document.getElementById(element), fv);
	document.getElementById(element).style.top = -100+"px";
	//fade(element,fv); 
}

function minikonv1(speed , i, shag, id, len, pos) {
	if (i>=2) {
		setTimeout("minikonv2("+speed+", 0, "+shag+", '"+id+"', "+len+", "+pos+")", 0);
	} else {
		document.getElementById(id).style.top = (pos+shag)+"px";
		pos+=shag;
		speed -= 40;
		i++;
		setTimeout("minikonv1("+speed+", "+i+", "+shag+", '"+id+"', "+len+", "+pos+")", speed);
	}
}

function minikonv2(speed , i, shag, id, len, pos) {
	if (i>=5) {
		setTimeout("minikonv3("+speed+", 0, "+shag+", '"+id+"', "+len+", "+pos+")", 0);
	} else {
		document.getElementById(id).style.top = (pos+shag)+"px";
		pos+=shag;
		//speed -= 30;
		i++;
		setTimeout("minikonv2("+speed+", "+i+", "+shag+", '"+id+"', "+len+", "+pos+")", speed);
	}
}

function minikonv3(speed , i, shag, id, len, pos) {
	if (i>=2) {
		setTimeout("endkonv("+id+"', "+len+", "+pos+")", speed);
	} else {
		document.getElementById(id).style.top = (pos+shag)+"px";
		pos+=shag;
		speed += 40;
		i++;
		setTimeout("minikonv3("+speed+", "+i+", "+shag+", '"+id+"', "+len+", "+pos+")", speed);
	}
}

function endkonv(id, len, pos) {
	document.getElementById(id).style.top = (pos+len%9)+"px";
}

function konv(id, len, pos) {
	var shag = len/9;
	var i;
	
	var speed = 100;
	setTimeout("minikonv1("+speed+", 0, "+shag+", '"+id+"', "+len+", "+pos+")", speed);
	
}

var lastid = "";

function OpenCat(id, now, must, shag, start) {
	document.getElementById(id).style.background = "URL('/css/images/downlm.jpg') right top no-repeat";
	
	if (start && (lastid!="")) {
		var s = String(document.getElementById(lastid).style.height);
		var sz = s.split('px');
		var h = parseInt(sz[0]);
		CloseCat(lastid, h, now, shag, 1);
		
		if (lastid==id) {
			lastid = "";
			return;
		}
		
	}
	
	if (start)
		document.getElementById(id).act = 'open';
	else {
		if (document.getElementById(id).act != 'open') return;
	}
	
	lastid = id;
	
	if (now+shag<=must) {
		now+=shag;
		document.getElementById(id).style.height = (now)+"px";
		setTimeout("OpenCat('"+id+"', "+now+", "+must+", "+shag+", 0)", 100);
	} else {
		if (now<must) {
			now = must;
			document.getElementById(id).style.height = (now)+"px";
			setTimeout("OpenCat('"+id+"', "+now+", "+must+", "+shag+", 0)", 100);
		}
	}
}

function CloseCat(id, now, must, shag, start) {
	document.getElementById(id).style.background = "URL('/css/images/rightlm.jpg') right top no-repeat";
	
	if (start)
		document.getElementById(id).act = 'close';
	else {
		if (document.getElementById(id).act != 'close') return;
	}
	
	if (now-shag>=must) {
		now-=shag;
		document.getElementById(id).style.height = (now)+"px";
		setTimeout("CloseCat('"+id+"', "+now+", "+must+", "+shag+", 0)", 100);
	} else {
		if (now>must) {
			now = must;
			document.getElementById(id).style.height = (now)+"px";
			setTimeout("CloseCat('"+id+"', "+now+", "+must+", "+shag+", 0)", 100);
		}
	}
}

var user_koef;

function ChangeKoef() {
	var koef = parseFloat(document.getElementById("koef").value);
	var price = parseFloat(document.getElementById("mat").value);
	var S;
	price  = price*koef;
	
	if (price) {
		S = (parseInt(price))+'.-';
		document.getElementById("good_price").innerHTML = S;
		if (user_koef !=1) {
			document.getElementById("new_good_price").innerHTML = (parseInt(parseInt(price)*user_koef))+'.-';
			document.getElementById("good_price").innerHTML = '<s>'+S+'</s>';
		}
	} else {
		document.getElementById("good_price").innerHTML ='<div class="dogprice">���� ����������</div>';
		if (user_koef !=1) document.getElementById("new_good_price").innerHTML = '';
	}
}

function GetDesc() {
	var desc = ar_desc[document.getElementById("mat").options[document.getElementById("mat").selectedIndex].text];
	document.getElementById("help").title = desc;
}

function ChangeImage(el) {
	document.getElementById(lastim).style.border = "1px solid #cccccc";
	el.style.border = "1px solid black";
	document.getElementById("bim").src = el.src;
	lastim = el.id;
}

function getHeight()
{
  return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientHeight:document.body.clientHeight;

  return document.documentElement.scrollHeight;
}

//������ ��������� �� �����������
function getWidth()
{
    return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientWidth:document.body.clientWidth;
  return document.documentElement.scrollWidth;
}


function prep() {
	document.getElementById("uplayer").style.width = getWidth()+"px";
	document.getElementById("uplayer").style.height = getHeight()+"px";
}

function OpenLayer() {
	var s;
	
	document.getElementById("uplayer").style.display = 'block';
	document.getElementById("uplayer").style.height = getHeight()+"px";
	document.getElementById("uplayer").style.width =getWidth()+"px";
	if (getWidth()>getHeight()) s = "height="+getHeight();
	else s = "width="+getWidth();
	document.getElementById("uplayer").innerHTML = '<img OnClick="CloseLayer()" src="'+bimid+'" '+s+'>';
}

function stopBubble(oEvent){
        if(oEvent && oEvent.stopPropagation)
                oEvent.stopPropagation();
        else
                window.event.cancelBubble = true; //для IE
}


function OpenMap() {
	var s;
	
	document.getElementById("uplayer").style.display = 'block';
	document.getElementById("uplayer").style.height = getHeight()+"px";
	document.getElementById("uplayer").style.width =getWidth()+"px";
	s = "height: 70%; width: 80%; margin-left:10%; margin-top:5%";
	document.getElementById("uplayer").innerHTML = '<div id="gmap" style="'+s+'"></div>';
    
    document.getElementById("gmap").onclick = stopBubble;
}

function ResizeLayer(){
	document.getElementById("uplayer").style.height = getHeight()+"px";
	document.getElementById("uplayer").style.width =getWidth()+"px";
}

function AjaxWait(s) {
	document.getElementById("uplayer").style.display = 'block';
	document.getElementById("uplayer").innerHTML = '<Table OnClick="CloseLayer()" style="width:100%; height: 100%" ><tr valign=center><td align=center><div style="background:white">'+s+'</div><td><tr><table>';
}



function CloseLayer() {
	
	document.getElementById("uplayer").style.display = 'none';
	document.getElementById("uplayer").innerHTML = "";
}


function FirstEmailClick(elem) {
	if (elem.first) return;
	elem.value="";
	elem.first=true;
	elem.style.color="black";
}






  /*Use Object Detection to detect IE6*/
  var  m = document.uniqueID /*IE*/
  && document.execCommand ;
  try{
    if(!!m){
      m("BackgroundImageCache", false, true) /* = IE6 only */
    }
  }catch(oh){};



  
function ShowPage(data) {
	
	document.getElementById('uplayer').style.display="block";
	document.getElementById('uplayer').innerHTML=data;

}





function GetOnLayer(page, param) {
	
	x_show_page(page, param, ShowPage);
}


function LoginOnEnter(event) {
	
	if ((event.keyCode == 13))
  		TryLogin();
}



function TryRegister() {

	x_reg(
	document.getElementById('login').value,
	document.getElementById('password').value, 
	document.getElementById('retry').value, 
	document.getElementById('org').value,
	document.getElementById('doing').value, 
	document.getElementById('adr').value,
	document.getElementById('town').value,
	document.getElementById('name').value, 
	document.getElementById('soname').value,
	document.getElementById('pname').value,
	document.getElementById('user_mail').value, 
	document.getElementById('nonpro').checked, 
	
	RespRegister);
}

function changeIm(element, src) {
	
	element.style.background= "url('"+src+"')";
}

function changeBord(element, color) {
	
	element.style.border= "2px solid "+color;
}

function RespArh(data) {

	document.getElementById('arh_field').innerHTML = data;
	document.getElementById('goto').style.display="block";
}

function GetArh() {
	document.getElementById('goto').style.display="none";
	x_get_arh(
	document.getElementById('type').value,
	document.getElementById('month').value,
	document.getElementById('year').value,
	RespArh);
}

function RespNew(data) {

	document.getElementById('new_content').innerHTML = data;
}

function ShowNew(id) {
	x_show_new(id, RespNew)
	document.getElementById('new_content').innerHTML = "����������� ����� �������...";
}

function RespMess(data) {
	
	if (!data['res']) {
		alert(data['Error']);
	
	} else {
		alert(data['Error']);
		CloseLayer();
	}
}

function TrySendMess() {
	x_feedback(
	
	document.getElementById('mesfio').value,
	document.getElementById('mestopic').value,
	document.getElementById('mesmail').value,
	document.getElementById('mestext').value,
	RespMess);
}

function RespSP(data) {
	
	if (data['success']) {
		alert(data['info']);
		GetOnLayer('login');
	} else {
		alert(data['info']);
	}
	
}

function SendPass() {
	x_send_pass(document.getElementById('pasmail').value, RespSP);
}

function DummyResp(data) {
	return 0;
}

function deleteSpam(rowId, spamId) {

	x_delete_spam(spamId, DummyResp);
	el = document.getElementById(rowId);
	el.parentNode.removeChild(el);
}

function MonthCheck() {
	
	if (document.getElementById('year').value>0) {
		document.getElementById('month').disabled=false;
	} else {
		document.getElementById('month').disabled=true;
	}
}