<?php
class RechargeAction extends BaseAction 
{
	public function index(){	
		$this->display();
	}

	public function ajax_get_recharge(){
		$page=$_REQUEST['p'];
		$recharge=M('recharge_card')->where('is_effect=1')->limit($page*4,4)->select();	
		foreach ($recharge as $k => $v) {					
			$recharge[$k]['img']="http://image.17cct.com".$v['img']."!tiny";		
		}
		$this->assign('recharge',$recharge);
		echo $html=$this->fetch();
	}
	
	public function done(){		

		$id=intval($_REQUEST['id']);
		if(!$id){
			header("Location:".U("Recharge/index"));
		}
		isLogin(U('Recharge/done',array('id'=>$id)));
		$recharge=M('recharge_card')->where('id='.$id." and is_effect=1")->find();
		if(!$recharge){
			header("Location:".U("Recharge/index"));
		}
		$user_info = session('user_info');
		$order['user_id']=$user_info['id'];
		$order['user_name']=$user_info['user_name'];
		$order['mobile']=$user_info['mobile'];
		$order['create_time']=time();
		$order['status']='1';
		$order['total_price']=$recharge['money'];
		$order['name']=$recharge['name'];
		$order['referer']=1;
		$order['number']=1;
		$order['price']=$recharge['money'];
		$order['recharge_id']=$id;
		$order['money']=intval($recharge['money'])+intval($recharge['give']);
		do
		{
			$order['order_sn'] = date("YmdHis",time()).rand(10,99);
			$order_id=M('card_order')->add($order);
		}while($order_id==0);
		if($order_id){
			header("Location:".U("Recharge/order",array('id'=>$order_id)));
		}else{
			header("Location:".U("Recharge/index"));
		}
		
	}

	public function order(){
		$id=intval($_REQUEST['id']);
		if(!$id){
			$this->error('该订单不存在');
		}
		if (!isLogin(U('Recharge/order',array('id'=>$id)))) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$order=M('card_order')->where('id='.$id." and user_id=".session('uid')." and status='1'")->find();
		
		if(!$order){
			$this->error('该订单不存在');
		}
		$this->assign('order',$order);
		$this->display();
	}

	//ajax 提交订单
	public function paySubmit()
	{	
		$pid = intval($_POST['id']);
		if (empty($pid) || $pid <= 0) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if (!isLogin(U('Recharge/order',array('id'=>$pid)),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$uid = intval(session('uid'));
		
		$order=M('card_order')->where('id='.$pid." and user_id=".$uid." and status='1'")->find();
		if ($order) {
			$this->ajaxReturn(U('Recharge/go_pay',array('id'=>$pid)),'正在处理中，请稍候',1);
		}else {
			$this->ajaxReturn(0,'该订单不存在',0);
		}
	}

	public function go_pay(){
		 	$id = intval($_REQUEST['id']);
		 	if($id){
		 		session('recharge_pay_order_id',$id);
		 		$redirectUrl = urlencode('http://m.17cct.com/index.php/Recharge/pay/');  //授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
				$goUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('wx_id')."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
		 		redirect($goUrl);
		 	}
	 }

	public function pay(){
		header('Content-type: text/html; charset=utf-8');

		$order_id = intval(session('recharge_pay_order_id'));

		isLogin(U('Order/pay',array('id'=>$order_id)));
		$uid = intval(session('uid'));

		//检查订单（未付款，有效的）
		$order=M('card_order')->where('id='.$order_id." and user_id=".$uid." and status='1'")->find();

		if (!$order) {
				$this->error('非法订单',U('Recharge/index'),3);
			
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
		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		$unifiedOrder->setParameter("total_fee", $order['total_price']*100);//总金额 单位为分  100分为支付一块钱 
		$unifiedOrder->setParameter("notify_url",'http://m.17cct.com/index.php/Recharge/notify_url/');//通知地址 
		$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		$unifiedOrder->setParameter("attach",$order['id']);
		//非必填参数，商户可根据实际情况选填
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
			$order = M('card_order')->where(array('id'=>intval($xml_array_data['attach'])))->find();
			//means_of_payment 支付工具，0为未使用支付，1为支付宝支付，2为微信支付
			if($order['status']!=2){
				//更新订单信息
				$data = array('status'=>'2','order_status'=>1,'means_of_payment'=>'2','outer_notice_sn'=>$xml_array_data['transaction_id'],'pay_time'=>time());						
				$r = M('card_order')->where(array('id'=>$order['id']))->save($data);
				if($r){
					//加钱
					M('user')->where('id='.intval($order['user_id']))->setInc('money',doubleval($order['money'])); 
					M('recharge_card')->where('id='.$order['recharge_id'])->setInc('count'); 
				}
				// 生成服务码
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
		if (!$order_id||!$order_sn) {
			$this->error('非法操作');
		}
		$order=M('card_order')->where('id='.$order_id)->find();
		$this->assign('order_status',$order['status']);
		$this->assign("money",$order['money']);
		$this->assign("order_sn",$order_sn);
		$this->assign("title","支付结果");
		$this->display();
	}




}
?>