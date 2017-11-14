<?php
// 本类由系统自动生成，仅供测试用途
class ChequanAction extends Action {


    public function index(){
        $time = time();
        $nonceStr = createNonceStr();
        $ticket=get_jsdk_ticket();
        $config_sign = $config_sign=sha1("jsapi_ticket=".$ticket."&noncestr=".$nonceStr."&timestamp=".$time."&url=".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $this->assign('nonceStr',$nonceStr);//随机串
        $this->assign('time',$time);
        $this->assign('sign',$config_sign);
        $this->display();
    }
    public function index_a(){
        $time = time();
        $nonceStr = createNonceStr();
        $ticket=get_jsdk_ticket();
        $config_sign = $config_sign=sha1("jsapi_ticket=".$ticket."&noncestr=".$nonceStr."&timestamp=".$time."&url=".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $this->assign('nonceStr',$nonceStr);//随机串
        $this->assign('time',$time);
        $this->assign('sign',$config_sign);
        $this->display();
    }

    //提交门店资料
	public function save_location_info(){
		$name     =$_POST['name'];
		$mobile   =$_POST['mobile'];
		$car_type =$_POST['car_type'];
		$card     =$_POST['card'];
		$taocan   =$_POST['taocan'];
		// $oprate_opend_id=session('oprate_opend_id');

		if(!$name){
			$data['info']='姓名不能为空';
			$data['status']=0;
		}elseif(!$mobile) {
			$data['info']='联系电话不能为空';
			$data['status']=0;
		}/*elseif(!M('agent_fans')->where("open_id='".$oprate_opend_id."'")->find()){
			$data['info']='未关注公众号不能提交资料';
			$data['status']=0;
		}elseif(M('_order')->where("open_id='".$oprate_opend_id."'")->find()){
			$data['info']='您已提交过门店资料';
			$data['status']=0;
		}*/else{
			$add_data['order_sn']=date('Ymdhis').rand(10,1000);
			$add_data['name']=$name;
			$add_data['mobile']=$mobile;
			$add_data['car_type']=$car_type;
			$add_data['card']=$card;
			$add_data['pay_money']=50;
			$add_data['pay_status']=0;
			$add_data['add_time']=time();
			$add_data['status']=0;
			$add_data['taocan']=$taocan;
			// var_dump($add_data);die;
			// $add_data['open_id']=$oprate_opend_id;
			// var_dump(M('chequan_payment'));
			$r=M('chequan_payment')->add($add_data);
			if($r){
				// $update['is_submit']=1;
				// M('agent_fans')->where("open_id='".$oprate_opend_id."'")->save($update);
				$data['info']='添加成功,跳转支付中';
				$data['status']=1;
				$data['data']=U('agent_go_pay',array('id'=>$r));
			}else{
				$data['info']='添加失败';
				$data['status']=0;
			}
		}

		$this->ajaxReturn($data);
	}

	//代理订单支付
	public function agent_go_pay(){
		 	$id = intval($_REQUEST['id']);		 	
		 	if($id){
		 		session('chequan_pay_order_id',$id);
		 		$redirectUrl = urlencode('http://m.17cct.com/index.php/Pay/chequan_order_pay');
		 		// $redirectUrl = urlencode('http://192.168.2.15/mobile/index.php/Chequan/agent_order_pay');  
		 		//授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
				$goUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('wx_id')."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
		 		redirect($goUrl);
		 	}
	 }



	//全返套餐
	public function chequan_notify_url()
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
			session('chequan_pay_order_id',null);
			$attach=$xml_array_data['attach'];

				//订单信息

				$order = M('chequan_payment')->where(" id=".intval($attach))->find();

				if($order['pay_time']==0&&$order['status']==0){

					//更新订单信息
					$data = array('pay_time'=>time(),'pay_status'=>'1');
					$r = M('chequan_payment')->where(array('id'=>$order['id']))->save($data);

					// //发送 商家 短信 微信
					// $storeMsg['user_true_name'] = $u['true_name'];
					// $storeMsg['user_mobile']    = $u['mobile'];
					// $storeMsg['deal_name']   	= $order['project_name'];
					// $storeMsg['deal_tpye'] 		= '3';
					// $storeMsg['store_mobile']   = $store['mobile'];
					//paySuccessSendMsg('store',$storeMsg);
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

		// isLogin(U('User/index'));
		// $uid = session('uid');
		
		$order= M('chequan_payment')->field('*')->where('pay_status=1 and id='.$order_id)->find();

		if (!$order) {
			$this->error('不存在的订单',U('index'),3);
		}
		$this->assign('order',$order);
		$this->assign("title","支付结果");
		$this->display();
	}
}