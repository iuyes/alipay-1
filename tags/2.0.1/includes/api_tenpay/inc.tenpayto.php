<?php 
header( 'content-type:text/html;charset=utf-8' );


require_once( 'cfg.tenpay.php' );
require_once( 'cls.tenpay_service.php' );

$p = $ws_payto_para;
unset ($ws_payto_para);
//############################################################################

/* 财付通交易单号，规则为：10位商户号+8位时间（YYYYmmdd)+10位流水号 */
$transaction_id = $tenpay_config['partner'] . $p['date'] . $p['strReq'];	

//############################################################################

$parameter = array(
	//任务代码
	'cmdno'             => 1,
	//日期
	'date'              => $p['date'],
	//商户号(合作者ID)
	'bargainor_id'	    => $tenpay_config['partner'],
	//财付通交易单号
	'transaction_id'    => $transaction_id,
	//商家订单号
	'sp_billno'		    => $p['ordno'],	
	//支付总价格，以分为单位
	'total_fee'		    => $p['price']*$p['num']*100,
	//货币类型
	'fee_type'			=> '1',
	//返回url
	'return_url'	    => $tenpay_config['return_url'],
	//自定义参数
	'attach'	   		=> $p['extra'],
	//用户ip
	'spbill_create_ip'	=> $p['ip'],
	//商品名称
	'desc'	 		    => $p['name'],
	//银行编码
	'bank_type'	   		=> $p['bank'],
	//字符集编码
	'cs'	  			=> $p['charset'],
);

$tenpayService = new TenpayService( $tenpay_config );
$html_text = $tenpayService->tenpayForm( $parameter );
echo $html_text;

?>

