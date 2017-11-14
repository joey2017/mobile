<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。
	const APPID = 'wx7ea1cd13c9f42d97';
	//受理商ID，身份标识
	const MCHID = '10027595';
	//商户支付密钥Key。
	const KEY = '49A17F4C87D1C7D2CA88313051815372';
	//JSAPI接口中获取openid，
	const APPSECRET = '3d55215b8df74e2c5d468e975c94e48e';
	
	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面 
	const JS_API_CALL_URL = 'http://weixin.17cct.com/index.php/Wxpay/pay/';
	
	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径
	//const SSLCERT_PATH = 'http://weixin.17cct.com/Lib/ORG/WxPay_TEST_PHP/cacert/apiclient_cert.pem';
	//const SSLKEY_PATH = 'http://weixin.17cct.com/Lib/ORG/WxPay_TEST_PHP/cacert/apiclient_key.pem';
	
	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = 'http://weixin.17cct.com/index.php/Wxpay/notify_url/';

	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 5;
}
	
?>