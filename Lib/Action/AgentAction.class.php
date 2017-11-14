<?php
// 本类由系统自动生成，仅供测试用途
class AgentAction extends Action {

	public function index(){
		$open_id=session('oprate_opend_id');
		if(!$open_id){
			$refererUrl = U('Agent/index'); //登录前一个页面的Url		
			$redirectUrl = urlencode(DOMAIN_URL.U('Agent/OAuth_wx'));  //授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
			$Url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb09359ac1d3f2267&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=".$refererUrl."#wechat_redirect";
			header("Location:".$Url);
		}else{

			//邀请方
			$fans=M('agent_fans')->where("open_id='".$open_id."'")->find();
			if($fans['shop_type']==1){
		  		$sup_name=M('pms_supplier')->where('id='.$fans['shop_id'])->getField('name');
		  	}elseif($fans['shop_type']==2){
		  		$sup_name=M('supplier_location')->where('id='.$fans['shop_id'])->getField('name');
		  	}else{
		  		$sup_name='车堂盛世';
		  	}	  

			//订单信息
			$order=M('agent_order')->where("open_id='".$open_id."'")->find();
			
			//未提交过订单
			if($order && $order['pay_status']==0){
				header("Location:".U('Agent/order_info'));
				exit;
			}else if($order && $order['pay_status']==2){

				header("Location:".U('Agent/audit_info',array('status'=>$order['status'])));
				exit;
			}else{
				$this->assign('sup_name',$sup_name);
				$this->display();
			}
			
		}		
	}

	//合伙人福利
	public function welfare(){
		$this->assign('title','合伙人福利');
		$this->display();
	}

	//加入合伙人
	public function join(){
		$this->assign('title','成为合伙人');
		$this->display();
	}

	//快速推广
	public function spread(){
		$this->assign('title','快速推广');
		$this->display();
	}

	public function audit_info(){
		$this->assign('title','合伙人审核');
		$open_id=session('oprate_opend_id');
		$order=M('agent_order')->where("open_id='".$open_id."'")->find();
		$this->assign('order',$order);
		$this->display();
	}

	// OAuth 2.0 网页授权 文档说明：http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html
    public function OAuth_wx()
    {
		if($_REQUEST["code"]=='authdeny'){
			echo '<script>history.back(-1);</script>';
			exit;
		}

    	$refererUrl  = $_REQUEST['state'];  	
    	$code        = $_REQUEST["code"]; 
    	$gu = curl_init();
		$timeout = 5;
		curl_setopt($gu, CURLOPT_URL, "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxb09359ac1d3f2267&secret=7e161c7930c9de1f3213dd13d6bb7a9c&code=".$code."&grant_type=authorization_code");
		curl_setopt($gu, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($gu, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($gu, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($gu);
		$data = json_decode($data, true);
	  	
	  	session('oprate_opend_id',$data['openid']);
	
	  	header("Location:".$refererUrl);
	  	//redirect($refererUrl);
	}


	//提交门店资料
	public function save_location_info(){
		$location_name=$_POST['location_name'];
		$contacts     =$_POST['contacts'];
		$mobile       =$_POST['mobile'];
		$oprate_opend_id=session('oprate_opend_id');

		if(!$location_name){
			$data['info']='门店名称不能为空';
			$data['status']=0;
		}elseif(!$contacts) {
			$data['info']='联系人不能为空';
			$data['status']=0;
		}elseif(!$mobile) {
			$data['info']='联系电话不能为空';
			$data['status']=0;
		}elseif(!M('agent_fans')->where("open_id='".$oprate_opend_id."'")->find()){
			$data['info']='未关注公众号不能提交资料';
			$data['status']=0;
		}elseif(M('agent_order')->where("open_id='".$oprate_opend_id."'")->find()){
			$data['info']='您已提交过门店资料';
			$data['status']=0;
		}else{
			$add_data['order_sn']=date('Ymdhis').rand(10,1000);
			$add_data['location_name']=$location_name;
			$add_data['contacts']=$contacts;
			$add_data['mobile']=$mobile;
			$add_data['total_price']=880;
			$add_data['pay_status']=0;
			$add_data['pay_time']=0;
			$add_data['create_time']=time();
			$add_data['status']=0;
			$add_data['open_id']=$oprate_opend_id;
			$add_data['name']='成为车堂盛世门店合伙人';
			$r=M('agent_order')->add($add_data);
			if($r){
				$update['is_submit']=1;
				M('agent_fans')->where("open_id='".$oprate_opend_id."'")->save($update);
				$data['info']='添加成功,跳转支付中';
				$data['status']=1;
				$data['data']=U('Pay/agent_go_pay',array('id'=>$r));
			}else{
				$data['info']='添加失败';
				$data['status']=0;
			}
		}

		$this->ajaxReturn($data);
	}

	public function order_info(){
		$open_id=session('oprate_opend_id');
		$order_info=M('agent_order')->where("open_id='".$open_id."'")->find();
		if(!$order_info){
			$this->error('不存在的订单',U('Agent/index'),3);
		}
		$this->assign('order',$order_info);
		$this->display();
	}

	
	//支付回调页面
	public function pay_back()
	{

		$order_id = intval($_REQUEST['order_id']);

		// isLogin(U('User/index'));
		// $uid = session('uid');
		
		$order= M('agent_order')->field('total_price,name,id,order_sn,pay_time')->where('pay_status=2  and id='.$order_id)->find();
	
		if (!$order) {
			$this->error('不存在的订单',U('Index/index'),3);
		}
		$this->assign('order',$order);
		$this->assign("title","支付结果");
		$this->display();
	}

	

	
}