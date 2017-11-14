<?php
class CardRechargeAction extends BaseAction 
{
	public function index(){	
		isLogin(U('CardRecharge/index'));
		$user_info=session('user_info');
		$has_card=M('erp_member_balance')->where('mobile='.$user_info['mobile'])->find();
		if(!$has_card){
			$this->error('没有会员卡不可充值');
		}		
		$this->assign('title','会员充值');
		$this->assign('card',$has_card);
		$this->display();
	}

	public function ajax_submit_recharge_card(){
		$price=$_REQUEST['val'];
		/*if(!$price||$price<=0){
			$this->ajaxReturn(0,'充值金额不正确',0);
		}*/
		$user_info=session('user_info');
		if(!$user_info){
			$this->ajaxReturn(0,'请先登录',0);
		}
		$member=M('erp_member')->field('fw_erp_member.m_name,fw_erp_member.id as member_id,fw_erp_member.mobile,femb.*')->join('fw_erp_member_balance as femb on femb.mobile=fw_erp_member.mobile')->where('fw_erp_member.mobile='.$user_info['mobile'])->find();
		if(!$member){
			$this->ajaxReturn(0,'非法操作',0);
		}
		
		$recharge['member_id']=$member['member_id'];
		$recharge['create_time']=time();
		$recharge['status']='0';
		$recharge['total_price']=$price;
		$recharge['means_of_payment']='0';
		$recharge['referer']=2;
		$recharge['sales_user_id']='';
		$recharge['location_id']='';
		$recharge['mobile']=$member['mobile'];
		$recharge['name']="会员卡充值".$price."元";
		$recharge['member_name']=$member['m_name'];
		$recharge['location_name']='';
		do
		{
			$recharge['order_sn'] = date('Ymdhis').str_pad(mt_rand(1, 9999),4, '0', STR_PAD_LEFT);
			$r=M('erp_card_recharge')->add($recharge);
		}while($r==0);		
		if($r){			
			$this->ajaxReturn(U('CardRecharge/go_pay',array('id'=>$r)),'跳转支付中...',1);
		}else{
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
	}

	public function go_pay(){
		 	$id = intval($_REQUEST['id']);
		 	if($id){
		 		session('card_recharge_pay_order_id',$id);
		 		$redirectUrl = urlencode('http://m.17cct.com/index.php/CardRecharge/pay_recharge/');  //授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
				$goUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('wx_id')."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
		 		redirect($goUrl);
		 	}
	 }
	
	public function pay_recharge(){
		//检查订单（未付款，有效的）
		$user_info=session('user_info');	
		$id = intval(session('card_recharge_pay_order_id'));
		$order=M('erp_card_recharge')->where('id='.$id." and mobile=".$user_info['mobile']." and status='0'")->find();

		if (!$order) {
			$this->error('非法订单',U('CardRecharge/index'),3);
			
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
		$unifiedOrder->setParameter("notify_url",'http://m.17cct.com/index.php/CardRecharge/notify_url/');//通知地址 
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
			$order = M('erp_card_recharge')->where(array('id'=>intval($xml_array_data['attach'])))->find();
			//means_of_payment 支付工具，0为未使用支付，1为支付宝支付，2为微信支付
			if($order['status']!=1){
				//更新订单信息
				$data = array('status'=>'1','pay_amount'=>$order['total_price'],'means_of_payment'=>'2','outer_notice_sn'=>$xml_array_data['transaction_id'],'pay_time'=>time());						
				$r = M('erp_card_recharge')->where(array('id'=>$order['id']))->save($data);
				if($r){
					//加钱				
					$money=$order['total_price'];
					$user_balance=M('erp_member_balance')->where('mobile='.$order['mobile'])->find();
					$card_balance=$user_balance['member_card_balance']+$money;		
					if($card_balance<1000){
						$card_info=M('erp_card')->where('id=1')->find();
					}else{
						$card_info=M('erp_card')->where('price<='.$card_balance)->order('price desc')->find();					
					}
					
					$user_info=M('user')->field('wxid')->where('mobile')->where('is_effect=1 and is_delete=0 and mobile='.$order['mobile'])->find();	
					if($user_info['wxid']){
						if($card_info['type']!=$user_balance['member_card_type']){
							$first_msg='尊敬的'.$order['member_name'].',恭喜您,您的会员卡已升级为'.$card_info['card_name'];
						}else{
							$first_msg='尊敬的'.$order['member_name'].',您的'.$card_info['card_name'].'已充值成功';
						}
						$this->recharge_done_msg($user_info['wxid'],$first_msg,$user_balance['member_card_number'],$money,$card_balance,'手机充值');
						
					}
				

					M('erp_member_balance')->query('update  fw_erp_member_balance set member_card_balance = member_card_balance +'.$order['total_price'].',member_card_id='.$card_info['id'].',member_card_type="'.$card_info['type'].'",member_card_name="'.$card_info['card_name'].'" where mobile='.$order['mobile']);

					$deal_data['card_id']=$card_info['id'];
					$deal_data['member_id']=$order['member_id'];
					$deal_data['sale_location_id']='';
					$deal_data['sale_user_id']='';
					$deal_data['total_price']=$order['total_price'];
					$deal_data['card_type']=$card_info['type'];
					$deal_data['add_time']=time();
					$deal_data['type']='2';
					$deal_data['balance']= $card_balance;
					$deal_data['order_id']=$order['id'];
					$deal_data['card_number']=$user_balance['member_card_number'];
					M('erp_card_deal')->add($deal_data);
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


	public function recharge_done_msg($wxid,$first_msg,$member_card_number,$money,$card_balance,$location_name){
		$json=array("touser"=>$wxid,
					"template_id"=>"BKZdAz_jKfneYKUqMjD9Ya3XSd8skAECEUu-jd67TpY",
					"url"=>"http://m.17cct.com/index.php/User/index.html",
					"topcolor"=>"#FF0000",
					"data"=>array('first'=>array('value'=>$first_msg),
								'keyword1'=>array('value'=>$member_card_number),
								'keyword2'=>array('value'=>price($money)),
								'keyword3'=>array('value'=>price($card_balance)),
								'keyword4'=>array('value'=>$location_name),
								'keyword5'=>array('value'=>date('Y-m-d H:i:s',time())),
								'Remark'=>array('value'=>'如有问题请致电0771-2756623或直接在微信留言，我们将第一时间为您服务！')
						)
			);
		$this->send_template_info($json);
	}

	public function send_template_info($json){
		
		    $access_token  = getWxAccToken();
			
			$get_token_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;			
			$ch  = curl_init() ;
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS,urldecode(json_encode(($json))));
			curl_setopt($ch, CURLOPT_URL,$get_token_url);			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			$result = curl_exec($ch) ;
			curl_close($ch);
	}

	//支付回调页面
	public function pay_back()
	{
		$order_id = intval($_REQUEST['order_id']);
		$order_sn = trim($_REQUEST['order_sn']);

		isLogin(U('CardRecharge/index'));
		$user_info=session('user_info');
		if (!$order_id||!$order_sn) {
			$this->error('非法操作');
		}
		$order=M('erp_card_recharge')->where('id='.$order_id." and mobile=".$user_info['mobile'])->find();
		if(!$order){
			$this->error('不存在的订单');
		}
		$this->assign('order_status',$order['status']);
		$this->assign("price",$order['total_price']);
		$this->assign("order_sn",$order_sn);
		$this->assign("title","支付结果");
		$this->display();
	}




}
?>