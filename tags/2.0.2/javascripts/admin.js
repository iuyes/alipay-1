// JavaScript Document
jQuery(function($){
	$('#ws_alipay_add_product').on('click',function()
	{
		location.href = $(this).attr('action-href');
	});	
	
	
	$('.ws_alipay_prolink').on('click',function()
	{
		//location.href = $(this).val();
		window.open( $(this).val(),'_blank')
	});	
	
	
});