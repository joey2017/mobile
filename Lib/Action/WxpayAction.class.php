<?php

class WxpayAction extends Action {

	function go_pay(){
		 	$id = intval($_REQUEST['id']);
		 	if($id){
		 		session('wx_pay_order_id',$id);
		 		$redirectUrl = urlencode('http://m.17cct.com/index.php/Wxpay/pay/');  //授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
				$goUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('wx_id')."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
		 		redirect($goUrl);
		 	}
	 }

	public function pay()
	{
		header('Content-type: text/html; charset=utf-8');

		$order_id = intval(session('wx_pay_order_id'));

		isLogin(U('Order/pay',array('id'=>$order_id)));
		$uid = intval(session('uid'));

		//检查订单（未付款，有效的）
		$o_j = array('fw_payment_notice as p ON p.order_id = fw_deal_order.id','fw_deal_order_item as doi ON doi.order_id = fw_deal_order.id');
		$o_w = array('fw_deal_order.id'=>$order_id,'fw_deal_order.user_id'=>$uid,'fw_deal_order.pay_status'=>0,'fw_deal_order.is_delete'=>0);
		$o_f = 'fw_deal_order.id,fw_deal_order.order_sn,fw_deal_order.total_price,doi.name,p.money';
		$order = M('deal_order')->join($o_j)->field($o_f)->where($o_w)->find();
		if ($order) {
			if ($order['money'] != $order['total_price']) {//付款订单与付款信息金额比对
				$this->error('非法订单',U('Index/index'),3);
			}
		}else {
			$this->error('该订单不存在');
		}	
		import("@.ORG.WxPay_PHP.WxPayPubHelper");
		//使用jsapi接口
		$jsApi = new JsApi_pub();
		//=========步骤1：网页授权获取用户openid============
		//通过code获得openid
		if (!isset($_GET['code']))
		{
			//触发微信返回code码
			$url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL);
			Header("Location: $url"); 
		}
		else
		{
			//获取code码，以获取openid
		    $code = $_GET['code'];
			$jsApi->setCode($code);
			$openid = $jsApi->getOpenId();
		}
		//=========步骤2：使用统一支付接口，获取prepay_id============
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub();
		//设置统一支付接口参数
		$unifiedOrder->setParameter("openid","$openid");//商品描述
		$unifiedOrder->setParameter("body",$order['name']);//商品描述
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
		//$out_trade_no=$order['order_sn'];
		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		$unifiedOrder->setParameter("total_fee", $order['total_price']*100);//总金额 单位为分  100分为支付一块钱 $order['total_price']*100
		$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
		$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		$unifiedOrder->setParameter("attach",$order['order_sn']);
		//非必填参数，商户可根据实际情况选填
		//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号  
		//$unifiedOrder->setParameter("device_info","XXXX");//设备号 
		//$unifiedOrder->setParameter("attach","XXXX");//附加数据 
		//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
		//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间 
		//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记 
		//$unifiedOrder->setParameter("openid","XXXX");//用户标识
		//$unifiedOrder->setParameter("product_id","XXXX");//商品ID
		$prepay_id = $unifiedOrder->getPrepayId();
		//=========步骤3：使用jsapi调起支付============
		$jsApi->setPrepayId($prepay_id);
		$jsApiParameters = $jsApi->getParameters();
		$this->assign('jsApiParameters',$jsApiParameters);
		$this->assign('order_id',$order['id']);
		$this->assign('order_sn',$order['order_sn']);
		$this->display();	
	}


	//异步通知页面

	public function notify_url()
	{
		import("@.ORG.WxPay_PHP.WxPayPubHelper");
		import('log_',APP_PATH.'Lib/ORG/WxPay_PHP','.php');
		//$data=$GLOBALS["HTTP_RAW_POST_DATA"];
		//使用通用通知接口
		$notify = new Notify_pub();
		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];	
		$notify->saveData($xml);
		$Common = new Common_util_pub();
		$xml_array_data=$Common->xmlToArray($xml);
		if($xml_array_data['result_code']=='SUCCESS'){//返回数据成功
			//订单信息
			$order = M('deal_order')->field('id,pay_status,user_id,total_price')->where(array('order_sn'=>$xml_array_data['attach']))->find();
			//means_of_payment 支付工具，0为未使用支付，1为支付宝支付，2为微信支付
			if($order['pay_status']!=2){
				//更新订单信息
				$data = array('pay_status'=>2,'order_status'=>1,'means_of_payment'=>'2','pay_amount'=>$order['total_price']);						
				$r = M('deal_order')->where(array('id'=>$order['id']))->save($data);

				//更新支付信息
				$data_notice = array('pay_time'=>time(),'is_paid'=>1,'outer_notice_sn'=>$xml_array_data['transaction_id']);
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
								paySuccessSendMsg('user',$userMsg);
							}

							//销量加 $num
							M('deal')->where(array('id'=>intval($deal['id'])))->setInc('buy_count',$num);

							//发送 短信 微信
							$storeMsg['user_true_name'] = $u['true_name'];
							$storeMsg['user_mobile']    = $u['mobile'];
							$storeMsg['deal_name']   	= $deal['sub_name'];
							$storeMsg['deal_tpye'] 		= $deal['is_shop'];
							$storeMsg['store_mobile']   = $store['mobile'];
							paySuccessSendMsg('store',$storeMsg);								
						}
						//订单支付成功记录
						saveLog('deal_order_log',array('log_info'=>$xml_array_data['attach'].'结单成功','log_time'=>time(),'order_id'=>$order['id']));
						echo 'success';
					}
				}
			
			} 								
		}
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
		}
		$returnXml = $notify->returnXml();
		//echo $returnXml;
		
		//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
		
		//以log文件形式记录回调信息
		$log_ = new Log_();
		$log_name=APP_PATH."Lib/ORG/WxPay_PHP/notify_url.log";//log文件路径
		$log_->log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");

		if($notify->checkSign() == TRUE)
		{
			if ($notify->data["return_code"] == "FAIL") {
				//此处应该更新一下订单状态，商户自行增删操作
				$log_->log_result($log_name,"【通信出错】:\n".$xml."\n");
			}
			elseif($notify->data["result_code"] == "FAIL"){
				//此处应该更新一下订单状态，商户自行增删操作
				$log_->log_result($log_name,"【业务出错】:\n".$xml."\n");
			}
			else{
				//此处应该更新一下订单状态，商户自行增删操作
				$log_->log_result($log_name,"【支付成功】:\n".$xml."\n");
			}		
		}	
	}
	//支付回调页面
	public function pay_back()
	{
		$order_id = intval($_REQUEST['order_id']);
		$order_sn = trim($_REQUEST['order_sn']);

		isLogin(U('Index/index'));
		$uid = session('uid');
		if (!M('deal_order')->where(array('id'=>$order_id,'user_id'=>$uid))->getField('id')) {
			$this->error('非法操作');
		}
		if(!empty($order_id) && !empty($order_sn)){
			$order_item = M('deal_order_item')->field('id,name,number,attr_str')->where(array('order_id'=>$order_id))->select();
			if ($order_item) {
				$count_num = 0;
				foreach ($order_item as $k => $v) {
					$order_item[$k]['coupon'] = M('deal_coupon')->field('sn')->where(array('order_deal_id'=>$v['id']))->select();
					$order_item[$k]['count_coupon'] = count($order_item[$k]['coupon']);
					$count_num += $v['number'] ;
				}
				if ($order_item[0]['coupon']) {
					$this->assign('order_id',$order_id);
					$this->assign('order_sn',$order_sn);
					$this->assign('count_num',$count_num);
					$this->assign('order_item',$order_item);
				}
			}
		}
		$this->assign("title","支付结果");
		$this->display();
	}

	public function native()
	{
		import("@.ORG.WxPay_PHP.WxPayPubHelper");
		//使用nativeLink接口
		$nativeLink = new NativeLink_pub();

		/*$timeStamp = time();

		$product_id = WxPayConf_pub::APPID."static";//自定义商品id	

		$id=intval($_REQUEST['id']);

		if($id){
		 	session('native_pay_order_id',$id);		 		
		}
		$nativeLink->setParameter("product_id",$product_id);//商品id

		$product_url=$nativeLink->getUrl();
		var_dump($product_url);
		$this->assign('product_url',$product_url);*/

		$order=M('deal_order_item')->lock(true)->join('fw_deal_order on fw_deal_order.id=fw_deal_order_item.order_id')->field('name,order_sn,fw_deal_order.total_price,fw_deal_order.id')->where('fw_deal_order.id='.intval($_REQUEST['id']))->find();
	
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub();		
		$product_id = WxPayConf_pub::APPID."static";//自定义商品id	
		$unifiedOrder->setParameter("body",$order['name']);//商品描述
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		$unifiedOrder->setParameter("total_fee",1);//总金额 $order['total_price']*100
		$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
		$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
		$unifiedOrder->setParameter("product_id","$product_id");//用户标识
		$unifiedOrder->setParameter("attach",$order['order_sn']);
		
		$CodeUrl = $unifiedOrder->getCodeUrl();
		
		$this->assign('CodeUrl',$CodeUrl);
		$this->display();
	}

	public function native_back_url()
	{

		import('log_',APP_PATH.'Lib/ORG/WxPay_PHP','.php');

		import("@.ORG.WxPay_PHP.WxPayPubHelper");

		$nativeCall = new NativeCall_pub();

		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];

		$nativeCall->saveData($xml);
		
		/*$order=M('deal_order_item')->join('fw_deal_order on fw_deal_order.id=fw_deal_order_item.order_id')->field('name,order_sn,fw_deal_order.total_price,fw_deal_order.id')->where('fw_deal_order.id='.session('native_pay_order_id'))->find();

		$product_id = $nativeCall->getProductId();

		
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub();		

		$unifiedOrder->setParameter("body",$order['name']);//商品描述
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		$unifiedOrder->setParameter("total_fee",1);//总金额
		$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
		$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
		$unifiedOrder->setParameter("product_id","$product_id");//用户标识
		$unifiedOrder->setParameter("attach",$order['order_sn']);
		$prepay_id = $unifiedOrder->getPrepayId();*/
		//$result=send_sms(15177122148,$nativeCall->checkSign());
		if($nativeCall->checkSign() == FALSE){
				$nativeCall->setReturnParameter("return_code","FAIL");//返回状态码
				$nativeCall->setReturnParameter("return_msg","签名失败");//返回信息
		}else{
			    $nativeCall->setReturnParameter("return_code","SUCCESS");//返回状态码
				$nativeCall->setReturnParameter("result_code","SUCCESS");//业务结果

			}
			

		//以log文件形式记录回调信息
		$log_ = new Log_();
		$log_name=APP_PATH."Lib/ORG/WxPay_PHP/native_call.log";//log文件路径

		//将结果返回微信
		$returnXml = $nativeCall->returnXml();		
	
		$log_->log_result($log_name,"【返回微信的native响应】:\n".$returnXml."\n");
		echo $returnXml;
	}
}

?>