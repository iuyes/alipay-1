<?php

require_once( WS_ALIPAY_INC . 'fnc.api_core.php' );

if( !class_exists('TenpaySubmit')):
class TenpaySubmit {
	//-----------------------请勿修改以上内容-----------------------------
	//财付通密钥设置:
	private $key = '';
	//
	//-----------------------请勿修改以下内容-----------------------------	
	
	//检测密钥是否已经安全
	function isKeySet(){
		return (empty($this->key))?false:true;		
	} 
	
	/**
	 * 设置密钥, 优先使用数据库中的密钥
	 */
	private function setKey($config){
		if( !empty($config['key']) )
			$this->key = $config['key'];
	} 
	
	/**
     * 生成要请求给财付通的参数数组
     * @param $para_temp 请求前的参数数组
     * @param $tenpay_config 基本配置信息数组
     * @return 要请求的参数数组
     */
	function buildRequestPara($para_temp,$tenpay_config) {
		
		//设置密钥
		$this->setKey($tenpay_config);
		
		//生成签名结果
		$mysign = $this->TenpaySign( $para_temp, trim($this->key));
		
		//签名结果与签名方式加入请求提交参数组中
		$para_temp['sign'] = $mysign;
		
		return $para_temp;
	}

	/**
     * 生成要请求给财付通的参数数组
     * @param $para_temp 请求前的参数数组
	 * @param $tenpay_config 基本配置信息数组
     * @return 要请求的参数数组字符串
     */
	function buildRequestParaToString($para_temp,$tenpay_config) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp,$tenpay_config);
		
		//把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$request_data = ws_alipay_createLinkstring($para);
		
		return $request_data;
	}
	
    /**
     * 构造提交表单HTML数据
     * @param $para_temp 请求参数数组
     * @param $gateway 网关地址
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
	function buildForm($para_temp, $gateway, $method, $button_name, $tenpay_config) {
		if( $button_name == '' )
			$button_name = '正在跳转中, 请稍候......';

		//待请求参数数组
		$para = $this->buildRequestPara($para_temp,$tenpay_config);
		
		$sHtml ='';
		$sHtml .= "<form id='tenpaysubmit' name='tenpaysubmit' action='".$gateway."' method='".$method."'>";
		while (list ($key, $val) = each ($para)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }
		
		$sHtml .= "</form>";
		$sHtml .= "<script>document.forms['tenpaysubmit'].submit();</script".">";

		return $sHtml;
	}
	
	/**
     * 构造模拟远程HTTP的POST请求，获取财付通的返回XML处理结果
	 * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * @param $para_temp 请求参数数组
     * @param $gateway 网关地址
	 * @param $tenpay_config 基本配置信息数组
     * @return 财付通返回XML处理结果
     */
	function sendPostInfo($para_temp, $gateway, $tenpay_config) {
		$xml_str = '';
		
		//待请求参数数组字符串
		$request_data = $this->buildRequestParaToString($para_temp,$tenpay_config);
		
		//请求的url完整链接
		$url = $gateway . $request_data;
		//远程获取数据
		$xml_data = ws_alipay_getHttpResponse($url);
	    //$xml_data = getHttpResponseCURL( $url );
//die($xml_data);
		//解析XML
		$doc = new DOMDocument();
		@$doc->loadHTML($xml_data);

		return $doc;
	}
	
	
	private function TenpaySign( $param ,$key ) {
		$cmdno 				= $param["cmdno"];
		$date 				= $param["date"];
		$bargainor_id		= $param["bargainor_id"];
		$transaction_id 	= $param["transaction_id"];
		$sp_billno 			= $param["sp_billno"];
		$total_fee 			= $param["total_fee"];
		$fee_type 			= $param["fee_type"];
		$return_url 		= $param["return_url"];
		$attach 			= $param["attach"];
		$spbill_create_ip 	= $param["spbill_create_ip"];
		$key = $key;
		
		$signPars = "cmdno=" 			. $cmdno 			. "&" .
					"date=" 			. $date 			. "&" .
					"bargainor_id=" 	. $bargainor_id 	. "&" .
					"transaction_id="	. $transaction_id 	. "&" .
					"sp_billno=" 		. $sp_billno 		. "&" .
					"total_fee=" 		. $total_fee 		. "&" .
					"fee_type=" 		. $fee_type 		. "&" .
					"return_url=" 		. $return_url 		. "&" .
					"attach=" 			. $attach 			. "&" ;
		
		if( !empty( $spbill_create_ip )) {
			$signPars .= "spbill_create_ip=" . $spbill_create_ip . "&";
		}
		
		$signPars .= "key=" . $key;
		
		$sign = strtolower(md5($signPars));
		
		return $sign;
	}
	
	
	
	
}

endif;
?>