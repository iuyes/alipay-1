<?php 
header( 'Content-Type:text/html; charset=utf-8' );
require_once( 'cfg.tenpay.php' );


//make all paras to be setted
$rq_empty = array( 
	'cmdno','pay_result','date','transaction_id','sp_billno',
	'total_fee','fee_type','attach','attach','sign'
);
$rq = array_merge( array_flip($rq_empty), $_REQUEST );

$sign_r = strtolower( $rq['sign'] ) ;

require_once( 'cls.tenpay_return.php' );
$Teturn = new Tenpay_Return();
$sign_t = $Teturn->TenpaySign_ret( $rq, $tenpay_config );

if(	$sign_r === $sign_t ){
	if( $rq['pay_result'] == 0 ){
		
		//------------------------------
		//处理业务开始
/////////////////////////////////////////////////////////////////////////////////////
		$arr_field = $rq_empty;
		$arr_rq    = ws_alipay_no_empty( $arr_field, $_REQUEST );
		//规范传入参数
		$para_ret = array();
		//支付平台别名
		$para_ret['plat_name']				= 'TENPAY';
		//交易状态
		$para_ret['status']					= 1;
		//商家内部订单号
		$para_ret['out_ordno']				= $arr_rq['sp_billno'];
		//支付平台订单号 
		$para_ret['plat_ordno']				= $arr_rq['transaction_id'];
		//交易总额
		$para_ret['total_fee']				= $arr_rq['total_fee']/100;
		//客户邮箱账号
		$para_ret['buyer_email']			= '';
		//客户数字账号
		$para_ret['buyer_id']				= '';
		//支付时间
		$para_ret['pay_time']				= date( 'Y-m-d H:i:s',$arr_rq['pay_time'] );
		
		//处理返回参数
		require_once( WS_ALIPAY_INC . 'cls.return.php' ); 
		$ins_ret = new wsAlipayReturn( $para_ret );
		$INFO = $ins_ret->returnProcess();
		$url  = ws_alipay_show_url( $INFO, $para_ret['out_ordno'] );
/////////////////////////////////////////////////////////////////////////////////////
?>
<html>
<head>
<meta name="TENCENT_ONLINE_PAYMENT" content="China TENCENT">
<script language="javascript">
window.location.href='<?php echo $url;?>';
</script>
</head>
<body></body>
</html>
<?php	
	}else{
		//支付失败
		$INFO = 'PAY_FAILED';
	}
	
	
	
}else{
	//验证失败
	$INFO = 'VERIFY_FAILED';
}

isset($para_ret['out_ordno']) || $para_ret['out_ordno'] = '';
echo ws_alipay_show_tip( $INFO , $para_ret['out_ordno'] );

?>


