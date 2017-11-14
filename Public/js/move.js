// JavaScript Document

$(document).ready(function(e) {
	var max_Width = 1080; //最大宽度
	var max_FontSize = 100 ; //最大字体px
	function set_fontSize(){
		var p = $(window).width() / max_Width;
		p =  p > 1 ? 1 : (p < 0.3 ? 0.3 : p);
		$("html").css({"font-size":  ( p*max_FontSize ) +"px","display":"block"});
		//console.log(p );
	}	
	$(window).resize(function() {
        set_fontSize();
    });
	set_fontSize();//页面载入执行一次
	
});





