<?php
return array(
//线下 数据库
	'DB_HOST'=>'192.168.2.200',
	'DB_NAME'=>'fuwu_17cct_com',
	'DB_USER'=>'root',
	'DB_PWD'=>'root',
	'DB_PORT'=>'3306',
	'DB_PREFIX'=>'fw_',
//线上 数据库
	// 'DB_HOST'=>'localhost',
	// 'DB_NAME'=>'db_17cct_v3',
	// 'DB_USER'=>'17cct_fuwu',
	// 'DB_PWD'=>'K2b6AvwPjN',
	// 'DB_PORT'=>'3306',
	// 'DB_PREFIX'=>'fw_',
// 开启字段类型验证
	'DB_FIELDTYPE_CHECK'=>true,  		
// 修改定界符,避免JS混淆
	'TMPL_L_DELIM'=>'<{',				
	'TMPL_R_DELIM'=>'}>',
// 开启静态缓存
	// 'HTML_CACHE_ON'=>true,
	// 'HTML_CACHE_RULES'=> array('service:view'=>array('{id}',600)),
//默认错误、成功跳转对应的模板文件
	'TMPL_ACTION_ERROR' => 'Inc:jump',
	'TMPL_ACTION_SUCCESS' => 'Inc:jump',
//兑换 管理员 手机号
	//'exchange_admin_mobile' => '13597348545',
	'exchange_admin_mobile' => '15177122148',
//订单成功交易后客服跟进  客服WxId
	'cct_customer_service_wxid' => '',
	//'cct_customer_service_wxid' => 'o7of3ju1wAFrxyfdIG3SOgope9Z4',	
//微信公众号信息
	'wx_id' => 'wxbd68bd4fe539eba2',
  	'wx_secret' => 'f2c29cdcbf2543e7531aef5e7651585c',
	// 'wx_id' => 'wx146ee32e157c07a0',
 	// 'wx_secret' => '6a1d594d577a1fc13568fffb050ecc40',
//支付宝账号信息
	'alipay_name' => 'caiwu@17cct.com',
  	'alipay_pid' => '2088901674644999',
  	'alipay_key' => '2s7l8rmy7wrbu9oxteujrs1x1h2qgubz',
//短信接口账号信息
  	'sms_name'=>'yoooop',
  	'sms_pwd'=>'cMZcYw2oB4GP',
  	'URL_MODEL '=>2,
  	'NEWS'=>"mysql://root:root@192.168.2.200:3306/www_cheyoupei_com",
//开启页面show_page_trace
    // 'SHOW_PAGE_TRACE' =>true
);
?>