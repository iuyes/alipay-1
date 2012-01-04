<?php
header( 'Content-Type:text/html; charset=utf-8' );

require_once( 'cls.alipay_service.php' );
require_once( 'cfg.alipay.php' );


$p = $ws_payto_para;
unset ($ws_payto_para);
/////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////

//构造要请求的参数数组
$parameter = array(
	"service"			=> "create_direct_pay_by_user",

	"payment_type"		=> "1",
	
	"partner"			=> trim($aliapy_config['partner']),
	"_input_charset"	=> trim(strtolower($aliapy_config['input_charset'])),
	"seller_email"		=> trim($aliapy_config['seller_email']),
	"return_url"		=> trim($aliapy_config['return_url']),
	"notify_url"		=> trim($aliapy_config['notify_url']),

	//############################################################################
	'quantity' 			=> $p['num'],
	'price' 			=> $p['price'],
	//############################################################################
	'royalty_type' 		=> "",
	'royalty_parameters'=> "",
	//'out_bill_no'       => '201112142123',
	//############################################################################
	"out_trade_no"		=> $p['ordno'],
	"subject"			=> $p['name'],
	"body"				=> $p['desc'],
	
	"paymethod"			=> $p['paymethod'],
	"defaultbank"		=> $p['bank'],
	
	"anti_phishing_key"	=> $p['anti_phishing_key'],
	"exter_invoke_ip"	=> $p['exter_invoke_ip'],
	
	"show_url"			=> $p['showurl'],
	"extra_common_param"=> $p['extra'],
	
	//"royalty_type"		=> $p['royalty_type'],
	//"royalty_parameters"=> $p['royalty_parameters'],
);



$alipayService = new AlipayService( $aliapy_config );
$html_text = $alipayService->alipayForm( $parameter );
echo '<title>页面跳转中...</title>';
echo $html_text;


?>
