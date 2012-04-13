<?php 


if(!class_exists('Tenpay_Return')):

class Tenpay_Return{
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
	
	function TenpaySign_ret( $parameters, $tenpay_config ) {
		
		//设置密钥
		$this->setKey($tenpay_config);
		
		$signPars = "";
		ksort( $parameters );
		
		
		$signPars = "cmdno=" 			. $parameters['cmdno'] 			. "&" .
					"pay_result=" 		. $parameters['pay_result'] 	. "&" .
					"date=" 			. $parameters['date'] 			. "&" .
					"transaction_id="   . $parameters['transaction_id'] . "&" .
					"sp_billno=" 		. $parameters['sp_billno'] 		. "&" .
					"total_fee=" 		. $parameters['total_fee'] 		. "&" .
					"fee_type="		    . $parameters['fee_type'] 		. "&" .
					"attach=" 			. $parameters['attach'] 		. "&" ;
		$signPars .= "key=" 			. $this->key;
		
		$sign = strtolower(md5($signPars));
		return $sign;
			
	}
	
}

endif;

?>