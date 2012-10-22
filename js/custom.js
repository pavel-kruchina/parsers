ddaccordion.init({
	headerclass: "expandable", //Shared CSS class name of headers group that are expandable
	contentclass: "categoryitems", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: false, //persist state of opened contents within browser session?
	toggleclass: ["", "openheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["prefix", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "normal", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

$(function(){
$('#menu a.fade')
		.css( {backgroundPosition: "0 0"} )
		.mouseover(function(){
			$(this).stop().animate({backgroundPosition:"(0 -100px)"}, {duration:100})
		})
		.mouseout(function(){
			$(this).stop().animate({backgroundPosition:"(0 0)"}, {duration:1300})
		})
});

$(function(){
$('#content_menu li a')
		.css( {opacity: "0"} )
		.mouseover(function(){
			$(this).stop().animate({opacity:"1"}, {duration:500})
		})
		.mouseout(function(){
			$(this).stop().animate({opacity:"0"}, {duration:500})
		})
});

$(function(){
$('#ind0')
		.mouseover(function(){
			$('#content_papki a').stop().animate({opacity:"1"}, {duration:500})
		})
		.mouseout(function(){
			$('#content_papki a').stop().animate({opacity:"0"}, {duration:500})
		})
});

$(function(){
$('#ind1')
		.mouseover(function(){
			$('#content_sumki a').stop().animate({opacity:"1"}, {duration:500})
		})
		.mouseout(function(){
			$('#content_sumki a').stop().animate({opacity:"0"}, {duration:500})
		})
});

$(function(){
$('#ind2')
		.mouseover(function(){
			$('#content_ezednevnik a').stop().animate({opacity:"1"}, {duration:500})
		})
		.mouseout(function(){
			$('#content_ezednevnik a').stop().animate({opacity:"0"}, {duration:500})
		})
});

$(function(){
$('#ind3')
		.mouseover(function(){
			$('#content_vizitnitsa a').stop().animate({opacity:"1"}, {duration:500})
		})
		.mouseout(function(){
			$('#content_vizitnitsa a').stop().animate({opacity:"0"}, {duration:500})
		})
});

$(function(){
$('#ind4')
		.mouseover(function(){
			$('#content_oblozka a').stop().animate({opacity:"1"}, {duration:500})
		})
		.mouseout(function(){
			$('#content_oblozka a').stop().animate({opacity:"0"}, {duration:500})
		})
});

$(function(){
$('#ind5')
		.mouseover(function(){
			$('#content_albom a').stop().animate({opacity:"1"}, {duration:500})
		})
		.mouseout(function(){
			$('#content_albom a').stop().animate({opacity:"0"}, {duration:500})
		})
});

$(function(){
$('#ind6')
		.mouseover(function(){
			$('#content_restoran a').stop().animate({opacity:"1"}, {duration:500})
		})
		.mouseout(function(){
			$('#content_restoran a').stop().animate({opacity:"0"}, {duration:500})
		})
});

$(function(){
$('#ind7')
		.mouseover(function(){
			$('#content_other a').stop().animate({opacity:"1"}, {duration:500})
		})
		.mouseout(function(){
			$('#content_other a').stop().animate({opacity:"0"}, {duration:500})
		})
})

$(function(){
$('#content_papki')
		.mouseover(function(){
			$('#ind0').stop().animate({backgroundPosition:"(0 -100px)"}, {duration:1000})
		})
		.mouseout(function(){
			$('#ind0').stop().animate({backgroundPosition:"(0 0)"}, {duration:1000})
		})
});

$(function(){
$('#content_sumki')
		.mouseover(function(){
			$('#ind1').stop().animate({backgroundPosition:"(0 -100px)"}, {duration:1000})
		})
		.mouseout(function(){
			$('#ind1').stop().animate({backgroundPosition:"(0 0)"}, {duration:1000})
		})
});

$(function(){
$('#content_ezednevnik')
		.mouseover(function(){
			$('#ind2').stop().animate({backgroundPosition:"(0 -100px)"}, {duration:1000})
		})
		.mouseout(function(){
			$('#ind2').stop().animate({backgroundPosition:"(0 0)"}, {duration:1000})
		})
});

$(function(){
$('#content_vizitnitsa')
		.mouseover(function(){
			$('#ind3').stop().animate({backgroundPosition:"(0 -100px)"}, {duration:1000})
		})
		.mouseout(function(){
			$('#ind3').stop().animate({backgroundPosition:"(0 0)"}, {duration:1000})
		})
});

$(function(){
$('#content_oblozka')
		.mouseover(function(){
			$('#ind4').stop().animate({backgroundPosition:"(0 -100px)"}, {duration:1000})
		})
		.mouseout(function(){
			$('#ind4').stop().animate({backgroundPosition:"(0 0)"}, {duration:1000})
		})
});

$(function(){
$('#content_albom')
		.mouseover(function(){
			$('#ind5').stop().animate({backgroundPosition:"(0 -100px)"}, {duration:1000})
		})
		.mouseout(function(){
			$('#ind5').stop().animate({backgroundPosition:"(0 0)"}, {duration:1000})
		})
});

$(function(){
$('#content_restoran')
		.mouseover(function(){
			$('#ind6').stop().animate({backgroundPosition:"(0 -100px)"}, {duration:1000})
		})
		.mouseout(function(){
			$('#ind6').stop().animate({backgroundPosition:"(0 0)"}, {duration:1000})
		})
});

$(function(){
$('#content_other')
		.mouseover(function(){
			$('#ind7').stop().animate({backgroundPosition:"(0 -100px)"}, {duration:1000})
		})
		.mouseout(function(){
			$('#ind7').stop().animate({backgroundPosition:"(0 0)"}, {duration:1000})
		})
});