<?php

require_once("cls.tenpay_submit.php");

if( !class_exists('TenpayService')):
class TenpayService {
	
	var $tenpay_config;
	/**
	 *财付通网关地址
	 */
	var $tenpay_gateway = 'http://service.tenpay.com/cgi-bin/v3.0/payservice.cgi?';

	function __construct($tenpay_config){
		$this->tenpay_config = $tenpay_config;
	}
    function tenpayService($tenpay_config) {
    	$this->__construct($tenpay_config);
    }


	/**
	 *构造提交表单
	 *@param $para_temp 商品参数
	 *@param $redi_html 跳转页面显示文字
	 *@return 表单
	 *
	 */
	function tenpayForm( $para_temp, $redi_html = '' ) {
		//实例化表单
		$tenpaySubmit = new tenpaySubmit();
		
		//接口入口直接把把参数和网关传入构造表单类中
		$html_text = $tenpaySubmit->buildForm( $para_temp, $this->tenpay_gateway, "get", $redi_html,$this->tenpay_config);

		return $html_text;
	}
	
	/**
	 *构造请求链接,直接跳入
	 *@param $para_temp 请求参数数组
	 *@param $redi_html 跳转页面
	 *@return 接口链接
	 */
	function tenpayApiLink(  $para_temp ){
		//实例化提交类
		$tenpaySubmit = new tenpaySubmit();
		
		//构造接口链接
		$apilink = $tenpaySubmit->buildRequestParaToString( $para_temp, $this->tenpay_config );
		
		return $this->tenpay_gateway.$apilink;
	}
}

endif;
?>