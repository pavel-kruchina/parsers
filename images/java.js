/*
setElementOpacity - установка прозрачности
getOpacityProperty - проверка, есть ли возможность менять прозрачность
fadeOpacity - плавное изменение прозрачности
*/

/* Функция кроссбраузерной установки прозрачности

Пример: setElementOpacity(document.body, 0.5); //сделать документ прозрачным на половину
*/
function setElementOpacity(oElem, nOpacity)
{
	var p = getOpacityProperty();
	(setElementOpacity = p=="filter"?new Function('oElem', 'nOpacity', 'nOpacity *= 100;	var oAlpha = oElem.filters["DXImageTransform.Microsoft.alpha"] || oElem.filters.alpha;	if (oAlpha) oAlpha.opacity = nOpacity; else oElem.style.filter += "progid:DXImageTransform.Microsoft.Alpha(opacity="+nOpacity+")";'):p?new Function('oElem', 'nOpacity', 'oElem.style.'+p+' = nOpacity;'):new Function)(oElem, nOpacity);
}

// Функция getOpacityProperty() возвращает свойство которое используется для смены прозрачности или undefined, и может использоваться для проверки возможности изменения прозрачности
function getOpacityProperty()
{
	var p;
	if (typeof document.body.style.opacity == 'string') p = 'opacity';
	else if (typeof document.body.style.MozOpacity == 'string') p =  'MozOpacity';
	else if (typeof document.body.style.KhtmlOpacity == 'string') p =  'KhtmlOpacity';
	else if (document.body.filters && navigator.appVersion.match(/MSIE ([\d.]+);/)[1]>=5.5) p =  'filter';
	
	return (getOpacityProperty = new Function("return '"+p+"';"))();
}

/* Функции для плавного изменения прозрачности:

1) fadeOpacity.addRule('opacityRule1', 1, 0.5, 30); //вначале создаем правило, задаем имя правила, начальную прозрачность и конечную, необязательный параметр задержки, влийяющий на скорость смены прозрачности
2) fadeOpacity('elemID', 'opacityRule1'); // выполнить плавную смену прозрачности элемента с id равным elemID, по правилу opacityRule1
3) fadeOpacity.back('elemID'); //вернуться в исходное сотояние прозрачности
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
	setElementOpacity(document.getElementById(element), fv);
	document.getElementById(element).style.display = 'block';
	fade(element,fv); 
}

function fadeout(element) {
	document.getElementById(element).fade = 'out';
	var fv = 0.5;
	setElementOpacity(document.getElementById(element), fv);
	document.getElementById(element).style.display = 'block';
	fade(element,fv); 
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
	document.getElementById(id).style.background = "URL('http://galcom/css/images/downlm.jpg') right top no-repeat";
	
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
	document.getElementById(id).style.background = "URL('http://galkom.mp.zp.ua/css/images/rightlm.jpg') right top no-repeat";
	
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