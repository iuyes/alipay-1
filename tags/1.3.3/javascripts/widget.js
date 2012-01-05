var $ = jQuery.noConflict();
var $wsAliWidgetArr = [];

$(function(){//BOJQ

$('.ws_alipay_widget_wrap').bind({
	mouseenter:function(){ $(this).children('.ws_alipay_widget_form').css('display','block'); },
	mouseleave:function(){ $(this).children('.ws_alipay_widget_form').css('display','none');  },
});
	
});//EOJQ