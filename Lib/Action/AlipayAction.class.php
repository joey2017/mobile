<?php

// 本类由系统自动生成，仅供测试用途



class AlipayAction extends Action {	 

	public function pay(){
		$oid=intval($_GET['id']);
	   	if(!$oid){   		
	   		$this->error('非法操作',U('User/index'),3);
	   	}
		isLogin(U('Alipay/pay',array('id'=>$oid)));
		$this->assign('oid',$oid);
		$this->display();
	}

   public function post(){
   	$oid=intval($_GET['id']);
   	if(!$oid){   		
   		$this->error('非法操作',U('User/index'),3);
   	}
  
   	$order=M('deal_order')->join('fw_deal_order_item as fdoi on fdoi.order_id=fw_deal_order.id')->join('fw_payment_notice as fpn on fpn.order_id=fw_deal_order.id')->field('order_sn,name,fw_deal_order.total_price,money')->where('fw_deal_order.id='.$oid." and fw_deal_order.user_id=".intval(session('uid')))->find();

  	//$order_item=M('deal_order_item')->where('order_id='.$oid)->find();

/*var_dump($order);*/


import("@.ORG.Alipay.lib.alipay_submit");

	 



$alipay_config=$this->setConfig();

//返回格式

$format = "xml";

//必填，不需要修改



//返回格式

$v = "2.0";

//必填，不需要修改



//请求号

$req_id = date('Ymdhis');

//必填，须保证每次请求都是唯一



//**req_data详细信息**



//服务器异步通知页面路径

//$notify_url = U("Alipay/notify_url");

$notify_url ='http://weixin.17cct.com/index.php/Alipay/notify_url.html';

//需http://格式的完整路径，不允许加?id=123这类自定义参数



//页面跳转同步通知页面路径

//$call_back_url =U("Alipay/call_back_url");

$call_back_url ='http://weixin.17cct.com/index.php/Alipay/call_back_url.html';



//需http://格式的完整路径，不允许加?id=123这类自定义参数



//操作中断返回地址

$merchant_url ='http://weixin.17cct.com/index.php/Index/index.html';

//用户付款中途退出返回商户的地址。需http://格式的完整路径，不允许加?id=123这类自定义参数





//卖家支付宝帐户

$seller_email = 'caiwu@17cct.com';

//必填



//商户订单号

$out_trade_no = $order['order_sn'];

//商户网站订单系统中唯一订单号，必填



//订单名称

$subject = mb_substr($order['name'],0,20,'utf-8');

//必填



//付款金额

$total_fee = $order['total_price'];

//必填



//请求业务参数详细

$req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url></direct_trade_create_req>';

//必填



/************************************************************/



//构造要请求的参数数组，无需改动

$para_token = array(

		"service" => "alipay.wap.trade.create.direct",

		"partner" => trim($alipay_config['partner']),

		"sec_id" => trim($alipay_config['sign_type']),

		"format"	=> $format,

		"v"	=> $v,

		"req_id"	=> $req_id,

		"req_data"	=> $req_data,

		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))

);



//建立请求

$alipaySubmit = new AlipaySubmit($alipay_config);

$html_text = $alipaySubmit->buildRequestHttp($para_token);



//URLDECODE返回的信息

$html_text = urldecode($html_text);



//解析远程模拟提交后返回的信息

$para_html_text = $alipaySubmit->parseResponse($html_text);



//获取request_token

$request_token = $para_html_text['request_token'];





/**************************根据授权码token调用交易接口alipay.wap.auth.authAndExecute**************************/



//业务详细

$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';

//必填



//构造要请求的参数数组，无需改动

$parameter = array(

		"service" => "alipay.wap.auth.authAndExecute",

		"partner" => trim($alipay_config['partner']),

		"sec_id" => trim($alipay_config['sign_type']),

		"format"	=> $format,

		"v"	=> $v,

		"req_id"	=> $req_id,

		"req_data"	=> $req_data,

		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))

);



//建立请求

$alipaySubmit = new AlipaySubmit($alipay_config);

$html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');

echo $html_text;

	

	}





	public function setConfig()

	{

		$alipay_config = array();

		 

		 /**************************调用授权接口alipay.wap.trade.create.direct获取授权码token**************************/

		//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

		//合作身份者id，以2088开头的16位纯数字

		$alipay_config['partner']		= trim(C('alipay_pid'));



		//安全检验码，以数字和字母组成的32位字符

		$alipay_config['key']			= trim(C('alipay_key'));





		//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





		//签名方式 不需修改

		$alipay_config['sign_type']    = strtoupper('MD5');



		//字符编码格式 目前支持 gbk 或 utf-8

		$alipay_config['input_charset']= strtolower('utf-8');



		//ca证书路径地址，用于curl中ssl校验

		//请保证cacert.pem文件在当前文件夹目录中

		//$alipay_config['cacert']    = getcwd().'\\cacert.pem';



		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http

		$alipay_config['transport']    = 'http';

		

		return $alipay_config;

	}





	//异步通知页面

	public function notify()

	{

		import("@.ORG.Alipay.lib.alipay_notify");

		$alipay_config=$this->setConfig();

		//计算得出通知验证结果

		$alipayNotify = new AlipayNotify($alipay_config);

		$verify_result = $alipayNotify->verifyNotify();

		$verify_result=true;

		if($verify_result) {//验证成功

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			//请在这里加上商户的业务逻辑程序代



			

			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

			

			//解密（如果是RSA签名需要解密，如果是MD5签名则下面一行清注释掉）

			//	$notify_data = decrypt($_POST['notify_data']);

			

		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

			

			//解析notify_data

			//注意：该功能PHP5环境及以上支持，需开通curl、SSL等PHP配置环境。建议本地调试时使用PHP开发软件

			$doc = new DOMDocument();

			$doc->loadXML($notify_data);

			

			if( ! empty($doc->getElementsByTagName( "notify" )->item(0)->nodeValue) ) {

				//商户订单号

				$out_trade_no = $doc->getElementsByTagName( "out_trade_no" )->item(0)->nodeValue;

				//支付宝交易号

				$trade_no = $doc->getElementsByTagName( "trade_no" )->item(0)->nodeValue;

				//交易状态

				$trade_status = $doc->getElementsByTagName( "trade_status" )->item(0)->nodeValue;

				/*返回状态：

				trade_status = "WAIT_BUYER_PAY"      等待买家付款

				trade_status = "WAIT_SELLER_SEND_GOODS"       买家付款，等待买家发货

				trade_status = "WAIT_BUYER_CONFIRM_GOODS"     卖家付款，等待买家确认

				rade_status = "TRADE_FINISHED" 交易完成*/

				if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {

					M('deal_order')->where("order_sn=".$out_trade_no)->setField("pay_status",2);

					$d['log_info']="订单号：".$out_trade_no."支付成功，交易号为：".$trade_no;

					$d['log_time']=mktime();

					$d['order_id']=$out_trade_no;

					M('deal_order_log')->add($d);

					echo "success";		//请不要修改或删除

				}				

			}



			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

			

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		}

		else {

		    //验证失败

		    echo "fail";



		    //调试用，写文本函数记录程序运行情况是否正常

		    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");

		}

	}





	public function call_back_url()

	{

		$this->assign("webtitle","交易结果");

		//计算得出通知验证结果

		import("@.ORG.Alipay.lib.alipay_notify");

		$alipay_config=$this->setConfig();



		$alipayNotify = new AlipayNotify($alipay_config);

		$verify_result = $alipayNotify->verifyReturn();



		$verify_result=true;

		if($verify_result) {//验证成功

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			//请在这里加上商户的业务逻辑程序代码

			//{$coupon.user_name}你好! 您在诚车堂预定的{$coupon.deal_sub_name}已订购成功，服务券服务码：{$coupon.sn}，请提前1天预约，自购买之日起15天内有效，逾期作废。预约电话：{$supplier_tel}【诚车堂】

			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

		    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表



			//商户订单号

			$out_trade_no = $_GET['out_trade_no'];



			//支付宝交易号

			$trade_no = $_GET['trade_no'];

			$this->assign("out_trade_no",$out_trade_no);

			//交易状态

			$result = $_GET['result'];

			if($_GET['result'] == 'success') {

					/*$order=M('deal_order')->where("order_sn=".$out_trade_no." and user_id=".intval(session('uid')))->find();
					//$coupon=M('deal_coupon')->field('sn')->where("order_sn=".$out_trade_no)->find();
					//means_of_payment 支付工具，0为未使用支付，1为支付宝支付，2为微信支付
					if($order['pay_status']!=2){
						$data = array('pay_status'=>2,'order_status'=>1,'means_of_payment'=>'1','pay_amount'=>$order['total_price']);
						M('deal_order')->where("id=".$order['id'])->setField($data);
					} 				

					$item=M('deal_order_item')->where('order_id='.$order['id'])->find();				
					
					//写进deal_coupon表
					$deal=M('deal')->where('id='.$item['deal_id'])->find();
					$coupon['sn']=$deal['code'].$deal['id'].rand(100000,999999);//服务码
					$coupon['begin_time']=$deal['coupon_begin_time'];
					$coupon['end_time']=$deal['end_time'];
					$coupon['is_valid']=1;
					$coupon['user_id']=$order['user_id'];//用户id
					$coupon['deal_id']=$deal['id'];//服务id
					$coupon['order_id']=$order['id'];//订单id
					$coupon['order_deal_id']=$item['id'];
					$coupon['supplier_id']=$deal['supplier_id'];
					M('deal_coupon')->add($coupon);		

					//$location_id=M('deal')->where('id='.$item['deal_id'])->getField('location_id');

					$sl=M('supplier_location')->field('tel,mobile,name')->where('id='.$deal['location_id'])->find();

					//$t=M('user')->where('id='.$order['user_id'])->getField("mobile");
					$tel=$sl['tel'];
					if($tel=="") $tel=$sl['mobile'];					
					//$order['mobile']
					//$result=sendPhoneSms($order['mobile'],"您好! 您在".$sl['name']."在线支付预定了".$item['sub_name']."已订购成功，服务券服务码：".$coupon['sn']."，请提前1天预约。预约电话：".$tel."【诚车堂】");
					if($sl['mobile']){
						$c="您好! 有客户在您店铺在线支付预定了(".$item['sub_name'].")已订购成功,联系电话:".$order['mobile']."。【诚车堂】";
						//$result=send_sms($sl['mobile'],$c);
					}
					$u=M('user')->where('id='.session("uid"))->field("wxid")->find();
					if($u['wxid']){
						$send_wx_order_url='http://weixin.17cct.com/index.php/User/order_item.html?id='.$order['id'];
						$send_wx_content='提交时间:  '.date('Y-m-d',time()).'\n\n'."预订服务:  ".$deal['sub_name'].'\n\n'."订单类型:  在线支付".'\n\n'."服务码:".$coupon['sn'].'\n\n'."商家名称:  ".$sl['name'].'\n\n'."联系电话:  ".$sl['tel'].'\n\n'."商家地址:  ".$sl['address'].'\n\n'."请提前1天预约,如有疑问,请拨打诚车堂客服热线:0771-2756623";
						$r=sendOrderWxMsg($u['wxid'],'最新订单信息',$send_wx_content,$send_wx_order_url);
						
					}*/


					//订单信息
				$order = M('deal_order')->field('id,pay_status,user_id,total_price')->where(array('order_sn'=>$out_trade_no,'user_id'=>intval(session('uid'))))->find();
				//means_of_payment 支付工具，0为未使用支付，1为支付宝支付，2为微信支付
				if($order['pay_status']!=2){
				//更新订单信息
				$data = array('pay_status'=>2,'order_status'=>1,'means_of_payment'=>'1','pay_amount'=>$order['total_price']);						
				$r = M('deal_order')->where(array('id'=>$order['id']))->save($data);

				//更新支付信息
				$data_notice = array('pay_time'=>time(),'is_paid'=>1,'outer_notice_sn'=>$out_trade_no);
				$r1 = M('payment_notice')->where(array('order_id'=>$order['id']))->save($data_notice);

				// 生成服务码
				if (!M('deal_coupon')->where(array('order_id'=>$order['id']))->getField('id')) {
					$order_items = M('deal_order_item')->field('id,deal_id,number,attr_str')->where(array('order_id'=>$order['id']))->select();
					if ($order_items) {
						$store_arr = array();
						foreach ($order_items as $k => $v) {
							$u = M('user')->where(array('id'=>$order['user_id']))->field("wxid,mobile,true_name,user_name")->find();
							$u['true_name'] = empty($u['true_name']) ? $u['user_name'] : $u['true_name'];
							$deal = M('deal')->field('id,name,sub_name,is_shop,code,coupon_begin_time,end_time,supplier_id,location_id')->where('id='.intval($v['deal_id']))->find();
							if(!$deal['supplier_id']){
								 continue;
							}
							$deal['sub_name'] = empty($deal['sub_name']) ? $deal['name'] : $deal['sub_name'] ;
							$store = M('supplier_location')->field('name,tel,mobile,address')->where(array('id'=>$deal['location_id']))->find();
							$store['tel'] = empty($store['tel']) ? $store['mobile'] : $store['tel'] ;
							//购买数量
							$num = intval($v['number']);
							for ($i = 0; $i < $num; $i++) { 
								$coupon = addCoupon($order['id'],$v['id'],$order['user_id'],$deal);
								$userMsg['order_id']       = $order['id'];
								$userMsg['user_true_name'] = $u['true_name'];
								$userMsg['user_mobile']    = $u['mobile'];
								$userMsg['user_wxid']      = $u['wxid'];
								$userMsg['deal_id']        = $deal['id'];
								$userMsg['deal_name']      = $deal['sub_name'];
								$userMsg['deal_tpye']      = $deal['is_shop'];
								$userMsg['deal_attr']      = $v['attr_str'];
								$userMsg['coupon'] 	       = $coupon;
								$userMsg['store_tel']      = $store['tel'];
								$userMsg['store_name']     = $store['name'];
								$userMsg['store_address']  = $store['address'];
								//paySuccessSendMsg('user',$userMsg);
							}

							//销量加 $num
							M('deal')->where(array('id'=>intval($deal['id'])))->setInc('buy_count',$num);

							//发送 短信 微信
							$storeMsg['user_true_name'] = $u['true_name'];
							$storeMsg['user_mobile']    = $u['mobile'];
							$storeMsg['deal_name']   	= $deal['sub_name'];
							$storeMsg['deal_tpye'] 		= $deal['is_shop'];
							$storeMsg['store_mobile']   = $store['mobile'];
							//paySuccessSendMsg('store',$storeMsg);								
							}
							//订单支付成功记录
							saveLog('deal_order_log',array('log_info'=>$out_trade_no.'结单成功','log_time'=>time(),'order_id'=>$order['id']));
							}
						}
						if(!empty($order['id']) && !empty($out_trade_no)){
							$order_item = M('deal_order_item')->field('id,name,number,attr_str')->where(array('order_id'=>$order['id']))->select();
							if ($order_item) {
								$count_num = 0;
								foreach ($order_item as $k => $v) {
									$order_item[$k]['coupon'] = M('deal_coupon')->field('sn')->where(array('order_deal_id'=>$v['id']))->select();
									$order_item[$k]['count_coupon'] = count($order_item[$k]['coupon']);
									$count_num += $v['number'] ;
								}
								if ($order_item[0]['coupon']) {
									$this->assign('order_id',$order['id']);
									$this->assign('order_sn',$order_sn);
									$this->assign('count_num',$count_num);
									$this->assign('order_item',$order_item);
								}
							}
						}
					} 

				}

				//$this->assign("sn",$coupon['sn']);
				//$this->assign("order_id",$item['id']);

				$r="交易成功";	//请不要修改或删除



			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		}

		else {

		    //验证失败

		    //如要调试，请看alipay_notify.php页面的verifyReturn函数

		    $r="交易失败";

		}

		$this->assign("r",$r);

		$this->display();

	}



}

?>