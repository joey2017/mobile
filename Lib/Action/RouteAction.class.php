	<?php

// 本类由系统自动生成，仅供测试用途

class RouteAction extends BaseAction {

     public function index()

	{
		//周边游，不推荐
		$route=M('zjy_route')->field('id,img,title')->where(" is_effect=1 and is_recommend!=1")->order('sort desc')->limit(4)->select();
		$this->assign('route',$route);

		//热门路线，推荐
		$hot_route=M('zjy_route')->field('id,img,title,brief,adult_price,end_enroll_time,max_num,sell_count')->where(" is_effect=1 and is_recommend=1")->order('sort desc')->limit(5)->select();
		foreach ($hot_route as $k => $v) {
			if($v['end_enroll_time']<time()){
				$hot_route[$k]['color']='btn-default';
				$hot_route[$k]['word']='报名逾期';
			}else if($v['sell_count']>=$v['max_num']){
				$hot_route[$k]['color']='btn-default';
				$hot_route[$k]['word']='名额已满';
			}else{
				$hot_route[$k]['color']='btn-info';
				$hot_route[$k]['word']='立即报名';
			}
		}
		$this->assign('hot_route',$hot_route);

		//游记
		$travel=M('zjy_travel')->field('id,thumb,title,view_count,comment_count,user_name,input_time')->where('is_effect=1')->order('comment_count desc')->limit(5)->select();
		foreach ($travel as $k => $v) {
			if(preg_match('/^1[3|4|5|7|8]\d{9}$/',$v['user_name'])){
				$travel[$k]['user_name']=substr_replace($v['user_name'],"*****",3,5);
			}
		}
		$this->assign('title','诚车堂汽车网-自驾游');
		$this->assign('travel',$travel);
		$this->display();
	}

	//支付订单
	public function pay()
	{	
		$oid = intval($_GET['id']);
		if (empty($oid) || $oid <= 0) {
			$this->error('非法订单',U('Route/index'),3);	
		}
		 
		isLogin(U('Route/pay',array('id'=>$oid)));

		$uid = intval(session('uid'));
		
		$order = M('zjy_route_order')->field('fw_zjy_route_order.*,fzr.adult_price as price')->join('fw_zjy_route as fzr on fzr.id=fw_zjy_route_order.route_id')->where("fw_zjy_route_order.is_delete=0  and fw_zjy_route_order.user_id=".$uid." and fw_zjy_route_order.id=".$oid)->find();		
		
		if (!$order){
			$this->error('非法订单',U('Route/index'),3);	
		}

		if($order['status']=='2'){
			$this->error('该订单已支付',U('Route/index'),3);
		}
		elseif($order['status']=='0'){
			$this->error('该订单已删除',U('Route/index'),3);
		}
		elseif($order['status']=='3'){
			$this->error('该订单已退款',U('Route/index'),3);
		}
		elseif($order['status']=='4'){
			$this->error('该订单已消费',U('Route/index'),3);
		}

		$order_detail=M('zjy_route_order_detail')->field('guest_type,price')->where('order_id='.$oid)->select();
		$i=$j=0;
		foreach ($order_detail as $k => $v) {
			if($v['guest_type']==1){
				$i++;
				$detail[0]['type']='成人票X'.$i;
				$detail[0]['price']=$v['price'];
			}else{
				$j++;
				$detail[1]['type']='儿童票X'.$j;
				$detail[1]['price']=$v['price'];
			}
		}
		$order['all_people']=$j+$i;
		$this->assign('order',$order);
		$this->assign('detail',$detail);
		$this->assign('title','支付订单');
		$this->display();
	}

	//ajax 提交订单
	public function paySubmit()
	{	
		$pid = intval($_POST['id']);
		$payment=$_REQUEST['payment'];
		if (empty($pid) || $pid <= 0) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if (!$payment) {
			$this->ajaxReturn(0,'请选择支付方式',0);
		}
		if (!isLogin(U('Route/pay',array('id'=>$pid)),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}

		$uid = intval(session('uid'));
	
		$order = M('zjy_route_order')->where("is_delete=0  and user_id=".$uid." and id=".$pid)->find();
		
		if ($order) {
			if($order['status']=='2'){
				$this->ajaxReturn(0,'该订单已支付',0);
			}
			elseif($order['status']=='0'){
				$this->ajaxReturn(0,'该订单已删除',0);
			}
			elseif($order['status']=='3'){
				$this->ajaxReturn(0,'该订单已退款',0);
			}
			elseif($order['status']=='4'){
				$this->ajaxReturn(0,'该订单已消费',0);
			}
			if($payment=='wxpay'){
				$this->ajaxReturn(U('Pay/go_pay',array('id'=>$pid,'act'=>'route')),'正在处理中，请稍候',1);
			}
		}else {

			$this->ajaxReturn(0,'该订单不存在',0);
		}
	}

	/*public function go_pay(){
		 	$id = intval($_REQUEST['id']);
		 	if($id){
		 		session('route_pay_order_id',$id);
		 		$redirectUrl = urlencode('http://weixin.17cct.com/index.php/Route/wx_pay/');  //授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
				$goUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('wx_id')."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
		 		redirect($goUrl);
		 	}
	 }

	public function wx_pay(){
		header('Content-type: text/html; charset=utf-8');

		$order_id = intval(session('route_pay_order_id'));

		isLogin(U('Route/pay',array('id'=>$order_id)));

		$uid = intval(session('uid'));

		//检查订单（未付款，有效的）
		$order = M('zjy_route_order')->where("is_delete=0  and user_id=".$uid." and id=".$order_id)->find();

		if (!$order) {
			$this->error('非法订单',U('User/index'),3);			
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
		$unifiedOrder->setParameter("notify_url",'http://weixin.17cct.com/index.php/Route/notify_url/');//通知地址 
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
			$order = M('zjy_route_order')->where(array('id'=>intval($xml_array_data['attach'])))->find();
			//means_of_payment 支付工具，0为未使用支付，1为支付宝支付，2为微信支付
			if($order['status']!='2'){
				//更新订单信息
				$data = array('status'=>'2','means_of_payment'=>'2','outer_notice_sn'=>$xml_array_data['transaction_id'],'pay_time'=>time());						
				$r = M('zjy_route_order')->where(array('id'=>$order['id']))->save($data);
				M('zjy_route')->where('id='.$order['route_id'])->setInc('sell_count'); 
				if($r){
						//生成验证码
						$route_data=add_route_coupon($order['id'],$order['route_id'],$order['user_id'],$order['agency_id']);
						if($route_data){
							//发送短信
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
	}*/

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
		$order=M('zjy_coupon')->field('fzro.name,fzro.status,fw_zjy_coupon.sn')->join('fw_zjy_route_order as fzro on fzro.id=fw_zjy_coupon.order_id')->where('order_id='.$order_id)->find();
		$this->assign('order',$order);
		$this->assign("order_sn",$order_sn);
		$this->assign("title","支付结果");
		$this->display();
	}

	
	public function view(){
		$id=intval($_REQUEST['id']);
		if(!$id){
			$this->error('不存在该路线',U('Route/index'),3);
		}
		$route=M('zjy_route')->field('fza.agency_name,fza.mobile,fw_zjy_route.*')->join('fw_zjy_agency as fza on fza.id=fw_zjy_route.agency_id')->where("fza.is_effect=1 and fw_zjy_route.is_effect=1 and fw_zjy_route.id=".$id)->find();

		if(!$route){
			$this->error('不存在该路线',U('Route/index'),3);	
		}
		
		$route['content']=str_replace('src="/ueditor/','src="http://zjy.17cct.com/ueditor/',$route['content']);
		M('zjy_route')->where(array('id'=>$id))->setInc('view');
		
		if($route['end_enroll_time']<time()){
				$route['color']='btn-default';
				$route['word']='报名逾期';				
			}else if($route['sell_count']>=$route['max_num']){
				$route['color']='btn-default';
				$route['word']='名额已满';
			}else{
				$route['color']='btn-info';
				$route['word']='立即报名';
			}

		$this->assign('route',$route);

		//评论 
		$remark=M('zjy_remark')->where('route_id='.$id)->select();	
		foreach ($remark as $k => $v) {
				$remark[$k]['imgs']=explode(',',$v['img']);
			}	
		$this->assign('remark',$remark);
		$medium_num=$route['all_point']-$route['good_point']-$route['bad_point'];
		$point[0]=round(($route['good_point']/$route['all_point'])*100).'%';//好评率
		$point[1]=round(($route['bad_point']/$route['all_point'])*100).'%';//差评率
		$point[2]=round(($medium_num/$route['all_point'])*100).'%';//中评率
		$this->assign('point',$point);
		$this->assign('title',$route['title']);
		$this->display();
	}

	public function submit(){
		$id=intval($_REQUEST['id']);
		if($id<0){
			$this->error('不存在该路线',U('Route/index'),3);
		}		
		isLogin(U('Route/submit',array('id'=>$id)));
		$route=M('zjy_route')->where("is_effect=1  and id=".$id)->find();
		$this->assign('route',$route);
		$u = session('user_info');
		$mobile = substr_replace($u['mobile'],"****",3,4);
		$this->assign('mobile',$mobile);
		$this->assign('title','提交订单');
		$this->display();
	}
	//检查成人,儿童数量合法性
	function check_number(){
		$type=trim($_REQUEST['c']);//a为成人，c为儿童
		$num1=intval($_REQUEST['num1']);//当前选择人数
		$num2=intval($_REQUEST['num2']);//另外一项人数
		$id=intval($_REQUEST['id']);//路线id
		$number=$num1+$num2;//订单报名总人数
		if($type!='c'&&$type!='a'||$num1<0||$num2<0||$id<=0){
			$this->ajaxReturn(0,'非法操作',0);
		}
		$route=M('zjy_route')->field('adult_price,childrens_price,sell_count,max_num,end_enroll_time')->where("is_effect=1 and id=".$id)->find();
		if(!$route){
			$this->ajaxReturn(0,'无该路线信息',0);
		}
		if($route['end_enroll_time']<time()){
			$this->ajaxReturn(0,'路线已过报名期限',0);
		}
		if(($number+intval($route['sell_count']))>intval($route['max_num'])){
			$this->ajaxReturn(0,'人数已超报名上限',0);
		}
		//当前选择为儿童
		if($type=='c'){
			$price=floatval($route['childrens_price']*$num1)+floatval($route['adult_price']*$num2);
		}else{
			$price=floatval($route['adult_price']*$num1)+floatval($route['childrens_price']*$num2);
		}
		$price=price($price);
		$this->ajaxReturn(1,$price,1);
	}

	public function order(){
		$id=intval($_REQUEST['id']);
		if (empty($id)||$id<0) {
			$this->error('不存在该路线',U('Route/index'),3);
		}
		$childrens_count=intval($_REQUEST['childrens_count']);
		$adult_count=intval($_REQUEST['adult_count']);
		isLogin(U('Route/submit',array('id'=>$id,'adult_count'=>$adult_count,'childrens_count'=>$childrens_count)));
		$number=$childrens_count+$adult_count;			
		$route=M('zjy_route')->where("is_effect=1  and id=".$id)->find();
		if(!$route){
			$this->error('不存在该路线',U('Route/index'),3);
		}
		if($route['end_enroll_time']<time()){
			//$this->ajaxReturn(0,'路线已过报名期限',0);
			$this->error('路线已过报名期限',U('Route/submit',array('id'=>$id)),3);
		}
		if($number<=0){
			$this->error('预订人数至少为一人',U('Route/submit',array('id'=>$id)),3);
		}
		if(($number+intval($route['sell_count']))>intval($route['max_num'])){
			$this->error('人数已超报名上限',U('Route/submit',array('id'=>$id)),3);
		}
		$arr=array();
		for($i=0; $i <$number; $i++) { 
			if($i<$adult_count){
				$arr[$i]['type']='成人';
				$arr[$i]['guest_type']=1;
			}else{
				$arr[$i]['type']='儿童';
				$arr[$i]['guest_type']=2;
			}
		}
		$this->assign('people',$adult_count."成人,".$childrens_count."儿童");
		$price=floatval($adult_count*$route['adult_price'])+floatval($childrens_count*$route['childrens_price']);
		$this->assign('arr',$arr);
		$this->assign('price',$price);
		$this->assign('route',$route);
		$this->assign('number',$number);
		$user_info=session('user_info');
		$this->assign('user_info',$user_info);
		$this->assign('title','订单信息');
		$this->display();
	}
	public function object_array($array) {  
	    if(is_object($array)) {  
	        $array = (array)$array;  
	     } if(is_array($array)) {  
	         foreach($array as $key=>$value) {  
	             $array[$key] = $this->object_array($value);  
	             }  
	     }  
	     return $array;  
	}
	public function ajax_order_submit(){

		$id=intval($_REQUEST['id']);
		if (empty($id) || $id <0) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if (!isLogin(U('Route/submit',array('id'=>$did)),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$route=M('zjy_route')->where("is_effect=1  and id=".$id)->find();
		if(!$route){
			$this->ajaxReturn(0,'无该路线信息',0);
		}
		if($route['end_enroll_time']<time()){
			$this->ajaxReturn(0,'路线已过报名期限',0);
		}
		$msg_arr=$this->object_array(json_decode($_POST['msg']));
		$number=count($msg_arr);
		if($number<=0){
			$this->ajaxReturn(0,'报名人数至少为1个',0);
		}
		$audlt=$childrens=0;
		for ($i=0; $i <$number; $i++) { 
			if($msg_arr[$i]['guest_type']==1){
				$audlt++;
			}else{
				$childrens++;
			}
		}
		$user_info = session('user_info');
		$data['order_sn']= date("Ymdhis",$time).rand(10,99);;
		$data['user_id']=session('uid');
		$data['create_time']=time();
		$data['status']='1';
		$data['total_price']=floatval($route['adult_price']*$audlt)+floatval($route['childrens_price']*$childrens);
		$data['route_id']=$id;
		$data['user_name']=$user_info['user_name'];
		$data['mobile']=$user_info['mobile'];
		$data['referer']=1;
		$data['number']=$audlt+$childrens;
		$data['price']=$route['adult_price'];
		$data['name']=$route['title'];
		$data['is_delete']=0;
		$data['agency_id']=$route['agency_id'];
		$data['agency_name']=$route['agency_name'];
		$data['is_delete']=0;
		$order_id = M('zjy_route_order')->add($data);
		if($order_id){
			for ($i=0; $i<$number; $i++) { 
				$detail['order_id']=$order_id;
				$detail['paper_type']=$msg_arr[$i]['paper_type'];
				$detail['paper_number']=$msg_arr[$i]['paper_number'];
				$detail['guest_type']=$msg_arr[$i]['guest_type'];
				$detail['guest_name']=$msg_arr[$i]['guest_name'];
				$detail['route_id']=$id;				 
				if($msg_arr[$i]['guest_type']==1){
					$detail['price']=$route['adult_price'];
				}else{
					$detail['price']=$route['childrens_price'];
				}
				$r=M('zjy_route_order_detail')->add($detail);
			}
			$this->ajaxReturn(U("Route/pay",array('id'=>$order_id)),'生成订单成功',1);
		}else{
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
		
	}

	public function review(){
		$id=intval($_REQUEST['id']);
		$route=M('zjy_route_order')->field('fzr.img,fzr.brief,fw_zjy_route_order.name,fw_zjy_route_order.id')->join('fw_zjy_route as fzr on fzr.id=fw_zjy_route_order.route_id')->where('fw_zjy_route_order.id='.$id." and fw_zjy_route_order.status='4' and fw_zjy_route_order.user_id=".intval(session('uid'))." and fw_zjy_route_order.remark_id=0")->find();
		if(!$route){
			$this->error('不存在可评论订单',U('Route/index'),3);
		}
		$this->assign('route',$route);
		$this->assign('title','评论路线');
		$this->display();
	}

	public function ajax_submit_review(){
		if (!isLogin(U('Index/index'),true)) {
			$this->ajaxReturn(0,"请先登录",0);
		}
		$order_id     = intval($_POST['id']);
		$point 	  = intval($_POST['point']);
		$point_g1 = intval($_POST['point_g1']);
		$point_g2 = intval($_POST['point_g2']);
		$point_g3 = intval($_POST['point_g3']);
		$content  = htmlspecialchars(stripslashes(trim($_POST['content'])));
		$imgs 	  = $_POST['imgs'];

		if ($point <= 0 || $point > 5) {
			$this->ajaxReturn(0,'请选择总体评价',0);
		}
		if ($point_g1 <= 0 || $point_g1 > 5) {
			$this->ajaxReturn(0,'请选择服务态度',0);
		}
		if ($point_g2 <= 0  || $point_g2 > 5) {
			$this->ajaxReturn(0,'请选择施工质量',0);
		}
		if ($point_g3 <= 0  || $point_g3 > 5) {
			$this->ajaxReturn(0,'请选择性价比',0);
		}
		if (empty($content)) {
			$this->ajaxReturn(0,'评价不能为空',0);
		}
		if ($point_g3 <= 0  || $point_g3 > 5) {
			$this->ajaxReturn(0,'请选择性价比',0);
		}
		if ($order_id <= 0 ) {
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
		if ($imgs != '0,0,0') {
			$img_arr = explode(',', $imgs);
			if (!empty($img_arr)) {
				foreach ($img_arr as $k => $v) {
					if (empty($v)) {
						unset($img_arr[$k]);
					}
				}
				$imgs = implode(',',$img_arr);
			}else{
				$imgs = '';
			}
		}else{
			$imgs = '';
		}
		$order_info=M('zjy_route_order')->field('agency_id,route_id')->where('id='.$order_id)->find();
		$data['img']=$imgs;
		$data['order_id']=$order_id;
		$data['agency_id']=$order_info['agency_id'];
		$data['route_id']=$order_info['route_id'];
		$data['content']=$content;
		$data['add_time']=time();
		$data['point']=$point;
		$data['service_point']=$point_g1;
		$data['cost_ratio_point']=$point_g2;
		$data['quality_point']=$point_g3;
		$data['user_id']=session('uid');
		$data['user_name']=session('user_name');
		$r=M('zjy_remark')->add($data);
		if($r){
			if($point>=4){
				$arr['good_point']=array('exp', 'good_point+1');		
			}else{
				$arr['bad_point']=array('exp', 'bad_point+1');
			}
			$arr['all_point']=array('exp', 'all_point+1');
			$arr['view']=array('exp', 'view+1');
			M('zjy_agency')->where(array('id'=>$order_info['agency_id']))->setField($arr);
			//M('zjy_agency')->where(array('id'=>$id))->setInc('view');
			$d['remark_id']=$r;
			$r1=M('zjy_route_order')->where('id='.$order_id)->save($d);
			$this->ajaxReturn(U('User/index'),'评论成功',1);
		}else{
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
	}

	//游记列表页面
	public function travel(){
		$province_id = intval($GLOBALS['_COOKIE']['zjy_province']);
		$travel=M('zjy_travel')->field('id,thumb,title,view_count,comment_count,user_name,input_time')->where('is_effect=1 and province_id = '.$province_id)->order('comment_count desc')->limit(5)->select();

		$this->assign('travel',$travel);
		$this->assign('title','游记列表');
		$this->display();

	}
	//加载更多游记
	public function ajax_get_travel(){
		$province_id = intval($GLOBALS['_COOKIE']['zjy_province']);
		$page=$_GET['p'];

		$travel=M('zjy_travel')->field('id,thumb,title,view_count,comment_count,user_name,input_time')->where('is_effect=1')->order('comment_count desc')->limit($page*5,5)->select();

    	foreach ($travel as $k => $v) {
			if(preg_match('/^1[3|4|5|7|8]\d{9}$/',$v['user_name'])){
				$travel[$k]['user_name']=substr_replace($v['user_name'],"*****",3,5);

			}
		}
    	$this->assign('travel',$travel);
    	echo $html=$this->fetch();
	}

	//精品列表路线
	public function select(){
		//获取参数
		
		if ($_REQUEST['_URL_'][2] == '/' || empty($_REQUEST['_URL_'][2])) {
			if($_REQUEST['keyword']){
				$_REQUEST['_URL_'][2] = '0-0-0-0-0-'.trim($_REQUEST['keyword']);
			}else{
				$_REQUEST['_URL_'][2] = '0-0-0-0-0-0' ;
			}
		}
		$parameter=explode('-',$_REQUEST['_URL_'][2]);
		$p1=$parameter[0];//城市
		$p2=$parameter[1];//主题
		$p3=$parameter[2];//月份
		$p4=$parameter[3];//行程
		$p5=$parameter[4];//排序
		$p6=$parameter[5];//关键词
	
		//查询路线
		if($p6){
			//$where .=" and r.title like '%".$p6."%'";
			$select[6]['url']=__ACTION__.'/'.implode('-', $parameter);
			$select[6]['name']=$p6;
		}
		//目的地 城市
		
		$city = M('region_conf')->field('id,name')->where('pid=7 and region_level = 3')->select();
		
		foreach ($city as $k => $v) {							
			if($p1==$v['id']){	
				//$where .=" and r.whither_city_id=".intval($v['id']);
				$parameter[0]=0;
				$select[0]['url']=__ACTION__.'/'.implode('-', $parameter);
				$select[0]['name']=$v['name'];	
				$select_city 	= $v['name'];					
				//break;
			}else{
				$parameter[0]=$v['id'];
				$city[$k]['url']=__ACTION__.'/'.implode('-', $parameter);
			}
		}		
		$parameter[0]=0;
		array_unshift($city,array('id' => 0,'name'=>'全部','url'=>__ACTION__.'/'.implode('-', $parameter)));
		
		$parameter[0]=$p1;//还原目的地	


		//主题推荐
		$theme=M('zjy_theme')->field('id,theme_name')->where('is_effect=1')->order('sort desc')->select();
		foreach ($theme as $k => $v) {							
			if($p2==$v['id']){
				//$where .=" and r.theme_id=".intval($v['id']);					
				$parameter[1]=0;
				$select[1]['url']=__ACTION__.'/'.implode('-', $parameter);
				$select[1]['name']=$v['theme_name'];	
				$select_theme	=$v['theme_name'];				
				//break;
			}else{
				$parameter[1]=$v['id'];
				$theme[$k]['url']=__ACTION__.'/'.implode('-', $parameter);				
			}
		}
		$parameter[1]=0;
		array_unshift($theme,array('id' => 0,'theme_name'=>'全部','url'=>__ACTION__.'/'.implode('-', $parameter)));
		$parameter[1]=$p2;//还原主题推荐

		//出发月份	
		$month = array();
		//当前月份
		$current_month = date('m');
		$int_current_month = intval($current_month);
		$month[0]['val']  = $current_month;	
		$month[0]['name'] = $int_current_month."月";
		//获取后五个月
		for ($i=1; $i <6; $i++) { 			
			$next_month 	  = date("m",strtotime("+$i month"));
			$int_next_month   = intval($next_month);
			$month[$i]['val'] = $next_month;
			$month[$i]['name']= (($int_next_month < $int_current_month) ? '明年' : '' ).$int_next_month ."月";	
			
		}
		foreach ($month as $k => $v) {		
			if($p3==$v['val']){	
				//明年
				/*if(intval(date('m'))>$v['val']){
					$where .=" and FROM_UNIXTIME(r.depart_time,'%Y')='".date("Y",strtotime("+1 year"))."-".$v['val']."'";
				}else{
					$where .=" and FROM_UNIXTIME(r.depart_time,'%Y-%m')='".date("Y")."-".$v['val']."'";
				}*/
				$parameter[2]=0;
				$select[2]['url']=__ACTION__.'/'.implode('-', $parameter);
				$select[2]['name']=$v['name'];	
				$select_month = $v['name'];						
				//break;
			}else{
				$parameter[2]=$v['val'];
				$month[$k]['url']=__ACTION__.'/'.implode('-', $parameter);				
			}
		}
		$parameter[2]=0;
		array_unshift($month,array('id' => 0,'name'=>'全部','url'=>__ACTION__.'/'.implode('-', $parameter)));
		$parameter[2]=$p3;//还原出发月份

		//行程天数
		$travel_day[0]['name']='1-3天';
		$travel_day[0]['val']='1';

		$travel_day[1]['name']='4-7天';
		$travel_day[1]['val']='2';

		$travel_day[2]['name']='8-15天';
		$travel_day[2]['val']='3';

		$travel_day[3]['name']='15天以上';
		$travel_day[3]['val']='4';
		foreach ($travel_day as $k => $v) {							
			if($p4==$v['val']){	
				/*switch ($v['val'])
				{
					case '1':
					$where .=" and r.travel_days between 1 and 3";	
						break;
					case '2':
					$where .=" and r.travel_days between 4 and 7";	
						break;
					case '3':
					$where .=" and r.travel_days between 8 and 15";	
						break;
					case '4':
					$where .=" and r.travel_days >15";	
						break;
				}	*/			
				$parameter[3]=0;
				$select[3]['url']=__ACTION__.'/'.implode('-', $parameter);
				$select[3]['name']=$v['name'];	
				$select_travel = $v['name'];
				//break;
			}else{
				$parameter[3]=$v['val'];
				$travel_day[$k]['url']=__ACTION__.'/'.implode('-', $parameter);				
			}
		}
		$parameter[3]=0;
		array_unshift($travel_day,array('id' => 0,'name'=>'全部','url'=>__ACTION__.'/'.implode('-', $parameter)));
		$parameter[3]=$p4;//还原行程天数


		//排序
		$order ='r.id desc';
		$sort_order = array();
		$sort_order[0]['name']='综合';
		$sort_order[0]['val']='0';
		$sort_order[1]['name']='推荐';//倒序
		$sort_order[1]['val']='1';
		$sort_order[2]['name']='销量';//倒序
		$sort_order[2]['val']='2';
		$sort_order[3]['name']='价格';//倒序
		$sort_order[3]['val']='3';

		foreach ($sort_order as $k => $v) {
			if ($p5==$v['val']) {
				/*switch ($v['val'])
				{	
					case '0':
					$order ='r.is_recommend desc, r.sell_count desc , r.view desc';
					$v['val']='7';	
						break;
					case '1':
					$order ='r.is_recommend desc';	
					$v['val']='4';
						break;
					case '2':
					$order ='r.sell_count desc';
					$v['val']='5';
						break;
					case '3':
					$order ='r.adult_price desc';
					$v['val']='6';
						break;
					case '4':
					$order ='r.is_recommend asc';
					$v['val']='1';
						break;
					case '5':
					$order ='r.sell_count asc';
					$v['val']='2';
						break;
					case '6':
					$order ='r.adult_price asc';
					$v['val']='3';
						break;
					case '7':
					$order ='r.is_recommend asc, r.sell_count asc , r.view asc';	
					$v['val']='0';
						break;
				}		*/		
				$parameter[4]=$v['val'];
				$sort_order[$k]['url']=__ACTION__.'/'.implode('-', $parameter);	
				$sort_order[$k]['selected'] = '1';
			} else {
				$parameter[4] = $v['val'];
				$sort_order[$k]['url']=__ACTION__.'/'.implode('-', $parameter);	
				
			}
		}
		$parameter[4]=$p5;

		$id = implode('-', $parameter);
		
	
		$this->assign("id",$id);
		$this->assign("city",$city);
		$this->assign("select_city",$select_city);
		$this->assign("theme",$theme);
		$this->assign("select_theme",$select_theme);
		$this->assign("month",$month);
		$this->assign("select_month",$select_month);
		$this->assign("travel_day",$travel_day);
		$this->assign("select_travel",$select_travel);
		$this->assign("sort_order",$sort_order);
		$this->assign('select',$select);
		$this->assign("delete_all",__ACTION__.'/0-0-0-0-0-0');
		$this->assign('route_list',$route_list);
		$this->assign('title','精品路线');
		$this->display();

	}

	//加载更多精品路线
	public function ajax_get_select(){
		
		$page=$_GET['p'];

		//获取参数
		$parameter=explode('-',$_REQUEST['id']);
		$p1=$parameter[0];//城市
		$p2=$parameter[1];//主题
		$p3=$parameter[2];//月份
		$p4=$parameter[3];//行程
		$p5=$parameter[4];//排序
		$p6=$parameter[5];//关键词
	
		//查询路线
		if($p6){
			$where .=" and r.title like '%".$p6."%'";
		}

		//目的地 城市		
		if($p1){
			$where .=" and r.whither_city_id=".intval($p1);
		}		

		//主题 
		if($p2){
			$where .=" and r.theme_id=".intval($p2);	
		}
		

		//出发月份	
		$month = array();
		//当前月份
		$current_month = date('m');
		$int_current_month = intval($current_month);
		$month[0]['val']  = $current_month;	
		$month[0]['name'] = $int_current_month."月";
		//获取后五个月
		for ($i=1; $i <6; $i++) { 			
			$next_month 	  = date("m",strtotime("+$i month"));
			$int_next_month   = intval($next_month);
			$month[$i]['val'] = $next_month;
			$month[$i]['name']= (($int_next_month < $int_current_month) ? '明年' : '' ).$int_next_month ."月";	
			
		}
		foreach ($month as $k => $v) {		
			if($p3==$v['val']){	
				//明年
				if(intval(date('m'))>$v['val']){
					$where .=" and FROM_UNIXTIME(r.depart_time,'%Y')='".date("Y",strtotime("+1 year"))."-".$v['val']."'";
				}else{
					$where .=" and FROM_UNIXTIME(r.depart_time,'%Y-%m')='".date("Y")."-".$v['val']."'";
				}			
			}
		}

		switch ($p4)
			{
				case '1':
				$where .=" and r.travel_days between 1 and 3";	
					break;
				case '2':
				$where .=" and r.travel_days between 4 and 7";	
					break;
				case '3':
				$where .=" and r.travel_days between 8 and 15";	
					break;
				case '4':
				$where .=" and r.travel_days >15";	
					break;
			}

		//排序
		$order ='r.id desc';
	
		switch ($p5)
		{	
			case '0':
			$order ='r.is_recommend desc, r.sell_count desc , r.view desc';	
			break;
			case '1':
			$order ='r.is_recommend desc';	
				break;
			case '2':
			$order ='r.sell_count desc';
				break;
			case '3':
			$order ='r.adult_price desc';
				break;
			case '4':
			$order ='r.is_recommend asc';
				break;
			case '5':
			$order ='r.sell_count asc';
				break;
			case '6':
			$order ='r.adult_price asc';
				break;
			case '7':
			$order ='r.is_recommend asc, r.sell_count asc , r.view asc';
				break;
		}		
		

		$r_field = "r.id,r.img,r.title,r.brief,r.adult_price,r.market_price,r.end_enroll_time,r.max_num,r.is_recommend,r.travel_days,r.view,r.sell_count,r.depart_time,r.depart_time,'%c' as depart_month,t.theme_name";
		$r_where = " r.is_effect=1 and t.is_effect=1 ".$where;
		
		$offect = $page*5;

		$r_sql   = "select ".$r_field." from fw_zjy_route as r left join fw_zjy_theme as t on r.theme_id = t.id where ".$r_where." order by ".$order.' limit '.$offect.',5';
		$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
		$route_list = $Model->query($r_sql);
		foreach ($route_list as $k => $v) {
			if($v['end_enroll_time']<time()){
				$route_list[$k]['color']='btn-default';
				$route_list[$k]['word']='报名逾期';
			}else if($v['sell_count']>=$v['max_num']){
				$route_list[$k]['color']='btn-default';
				$route_list[$k]['word']='名额已满';
			}else{
				$route_list[$k]['color']='btn-info';
				$route_list[$k]['word']='立即报名';
			}
		}


		
		$this->assign('route_list',$route_list);
    	echo $html=$this->fetch();
	}
	//路书列表页面
	public function book(){
		$province_id = intval($GLOBALS['_COOKIE']['zjy_province']);
		//获取参数
		if ($_REQUEST['_URL_'][2] == '/' || empty($_REQUEST['_URL_'][2])) {
			$_REQUEST['_URL_'][2] = '0-0-0' ;
		}
		$parameter=explode('-',$_REQUEST['_URL_'][2]);

		$p1=$parameter[0];//主题
		$p2=$parameter[1];//月份
		$p3=$parameter[2];//行程


		//主题推荐
		$theme=M('zjy_theme')->field('id,theme_name')->where('is_effect=1')->order('sort desc')->select();
		foreach ($theme as $k => $v) {					
			if($p1==$v['id']){

				$where .=" and b.theme_id=".intval($v['id']);					
				$parameter[0]=0;
				$select[0]['url']=__ACTION__.'/'.implode('-', $parameter);
				$select[0]['name']=$v['theme_name'];	
				$select_theme	=$v['theme_name'];				
				//break;
			}else{
				$parameter[0]=$v['id'];
				$theme[$k]['url']=__ACTION__.'/'.implode('-', $parameter);				
			}
		}
		$parameter[0]=0;
		array_unshift($theme,array('id' => 0,'theme_name'=>'全部','url'=>__ACTION__.'/'.implode('-', $parameter)));
		$parameter[0]=$p1;//还原主题推荐
		
		//游玩月份	
		//时间
		$month_list = array();
		$cmonth = date('m'); //当前月份
		$int_cmonth = intval($cmonth);
		$month_list[1]['val']  = $cmonth;	
		$month_list[1]['name'] = $int_cmonth."月";
		$m = $parameter[1];
		//获取后 六个月
		for ($i = 2; $i < 8; $i++) { 	
			$_m = $i - 1; 
			$nmonth 	  = date("m",strtotime("+$_m month"));
			$int_nmonth   = intval($nmonth);
			$month_list[$i]['val'] = $nmonth;
			$month_list[$i]['name']= (($int_nmonth < $int_cmonth) ? '明年' : '' ).$int_nmonth ."月";
			if ($i == 7) {
				$month_list[$i]['name']= '往期';
				$month_list[$i]['time_start'] = strtotime(date('Y-m-01', time()));
				$time_end = (($int_nmonth < $int_cmonth) ? date("Y",strtotime("+1 year")) : date("Y")).'-'. date("m",strtotime("+6 month")).'-01';
				$month_list[$i]['time_end'] = strtotime($time_end);
			}
		}
		if($m > 0) //被选择时
		{
			if (!empty($month_list[$m])) 
			{	
				if ($m == 7) { // 往期
					$where .=" AND b.play_time NOT BETWEEN ".$month_list[7]['time_start']." AND ".$month_list[7]['time_end'];
				}
				elseif($int_cmonth > $m){ // 明年
					$where .=" AND FROM_UNIXTIME(b.play_time,'%Y-%m')='".date("Y")."-".$month_list[$m]['val']."'";
				}else{
					$where .=" AND FROM_UNIXTIME(b.play_time,'%Y-%m')='".date("Y")."-".$month_list[$m]['val']."'";
				}
				$parameter[1] = 0 ;
				$select['month']['url']  = __ACTION__.'/'.implode('-', $parameter);
				$select['month']['name'] = $month_list[$m]['name'];
				$select_month = $month_list[$m]['name'];
				$parameter[1] = $m ;
			}

		}
		
		foreach ($month_list as $k => $v) 
		{	
			$parameter[1] = $k;
			$month_list[$k]['url'] = __ACTION__.'/'.implode('-', $parameter);
		}
		$parameter[1] = $p2;
			
	
		//价格
		$price_list[0]['name']='100以下';
		$price_list[0]['val']='1';

		$price_list[1]['name']='100-200元';
		$price_list[1]['val']='2';

		$price_list[2]['name']='200-300元';
		$price_list[2]['val']='3';

		$price_list[3]['name']='300-400元';
		$price_list[3]['val']='4';

		$price_list[4]['name']='400-500元';
		$price_list[4]['val']='4';

		$price_list[5]['name']='500元以上';
		$price_list[5]['val']='6';
				
		foreach ($price_list as $k => $v) {							
			if($p3==$v['val']){	
				switch ($v['val'])
				{
					case '1':
					$where .=" and bcpow(left_operand, right_operand).price < 100";	
						break;
					case '2':
					$where .=" and b.price between 100 and 200";	
						break;
					case '3':
					$where .=" and b.price between 200 and 300";	
						break;
					case '4':
					$where .=" and b.price between 300 and 400";	
						break;
					case '5':
					$where .=" and b.price between 400 and 500";	
						break;
					case '6':
					$where .=" and b.price > 500";	
						break;
				}				
				$parameter[2]=0;
				$select[2]['url']=__ACTION__.'/'.implode('-', $parameter);
				$select[2]['name']=$v['name'];	
				$select_price = $v['name'];
				//break;
			}else{
				$parameter[2]=$v['val'];
				$price_list[$k]['url']=__ACTION__.'/'.implode('-', $parameter);				
			}
		}
		$parameter[2]=0;
		array_unshift($price_list,array('id' => 0,'name'=>'全部','url'=>__ACTION__.'/'.implode('-', $parameter)));
		$parameter[2]=$p3;//还原价格
				
		

		$b_field = "b.id,b.title,b.brief,b.input_time,b.view_count,b.thumb,b.price,b.play_time,b.is_recommend,t.theme_name";
		$b_where = "b.province_id = ".$province_id." AND b.is_effect = 1 AND b.useful_time < ".time().$where;
		
		$b_sql = "select ".$b_field." from fw_zjy_book as b left join fw_zjy_theme as t on b.theme_id = t.id where ".$b_where." order by b.is_recommend desc,b.sort desc ";	

		$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
	
		$book_list = $Model->query($b_sql);
		$parameter = implode('-', $parameter);
		
	
		$this->assign("parameter",$parameter);
	
		$this->assign("theme",$theme);
		$this->assign("select_theme",$select_theme);
		$this->assign('month_list',$month_list);
		$this->assign("select_month",$select_month);
		$this->assign("price_list",$price_list);
		$this->assign("select_price",$select_price);
		$this->assign("delete_all",__ACTION__.'/0-0-0');
		$this->assign('selected',$selected);
		$this->assign('select',$select);
		$this->assign('book_list',$book_list);
		$this->assign('title','路书列表');
		$this->display();

	}
	//路书列表分页 加载
	public function ajax_get_book(){

		$province_id = intval($GLOBALS['_COOKIE']['zjy_province']);
		$page=$_GET['p'];
		
		//获取参数
		
		$parameter=explode('-',$_REQUEST['parameter']);

		$p1=$parameter[0];//主题
		$p2=$parameter[1];//月份
		$p3=$parameter[2];//行程

		if($p1){
			$where .=" and b.theme_id=".intval($p1);		
		}
		
	
		//时间
		$month_list = array();
		$cmonth = date('m'); //当前月份
		$int_cmonth = intval($cmonth);
		$month_list[1]['val']  = $cmonth;	
		$month_list[1]['name'] = $int_cmonth."月";
		$m = $parameter[1];
		//获取后 六个月
		for ($i = 2; $i < 8; $i++) { 	
			$_m = $i - 1; 
			$nmonth 	  = date("m",strtotime("+$_m month"));
			$int_nmonth   = intval($nmonth);
			$month_list[$i]['val'] = $nmonth;
			$month_list[$i]['name']= (($int_nmonth < $int_cmonth) ? '明年' : '' ).$int_nmonth ."月";
			if ($i == 7) {
				$month_list[$i]['name']= '往期';
				$month_list[$i]['time_start'] = strtotime(date('Y-m-01', time()));
				$time_end = (($int_nmonth < $int_cmonth) ? date("Y",strtotime("+1 year")) : date("Y")).'-'. date("m",strtotime("+6 month")).'-01';
				$month_list[$i]['time_end'] = strtotime($time_end);
			}
		}
		if($m > 0) //被选择时
		{
			if (!empty($month_list[$m])) 
			{	
				if ($m == 7) { // 往期
					$where .=" AND b.play_time NOT BETWEEN ".$month_list[7]['time_start']." AND ".$month_list[7]['time_end'];
				}
				elseif($int_cmonth > $m){ // 明年
					$where .=" AND FROM_UNIXTIME(b.play_time,'%Y-%m')='".date("Y")."-".$month_list[$m]['val']."'";
				}else{
					$where .=" AND FROM_UNIXTIME(b.play_time,'%Y-%m')='".date("Y")."-".$month_list[$m]['val']."'";
				}
				
			}

		}		
	
		switch ($p3)
			{
				case '1':
				$where .=" and bcpow(left_operand, right_operand).price < 100";	
					break;
				case '2':
				$where .=" and b.price between 100 and 200";	
					break;
				case '3':
				$where .=" and b.price between 200 and 300";	
					break;
				case '4':
				$where .=" and b.price between 300 and 400";	
					break;
				case '5':
				$where .=" and b.price between 400 and 500";	
					break;
				case '6':
				$where .=" and b.price > 500";	
					break;
			}
	
				
		$limit=$page*5;

		$b_field = "b.id,b.title,b.brief,b.input_time,b.view_count,b.thumb,b.price,b.play_time,b.is_recommend,t.theme_name";
		$b_where = " b.is_effect = 1 AND b.useful_time < ".time().$where;//b.province_id = ".$province_id." AND
		
		$b_sql = "select ".$b_field." from fw_zjy_book as b left join fw_zjy_theme as t on b.theme_id = t.id where ".$b_where." order by b.is_recommend desc,b.sort desc  limit ".$limit.',5';	
		
		$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
	
		$book_list = $Model->query($b_sql);
			
		
		$this->assign('book_list',$book_list);
		echo $html=$this->fetch();

	}
	//路书内容页面
	public function book_view(){

		$id = isset($_GET['id']) ? ((empty($_GET['id']) || intval($_GET['id']) <=0) ? 0 : intval($_GET['id'])) : 0 ;
		if($id < 0)
		{
			$this->error("不存在该路书",0,U('Route/book'),3);
		} 
		$book = M('zjy_book')->field('*')->where('is_effect=1 and useful_time<'.time().' and id='.$id)->find();
		
			if (!empty($book)) 
			{
				//截取摘要
				$patterns  = array ('/<p><br\/><\/p>/','/&nbsp;/','/<img[^>]*>/');
 				$replace  = array ('','','[图]');
				$book['desc'] = msubstr(strip_tags(preg_replace($patterns, $replace,$book['content'])),0,90);
				$book['content']=str_replace('src="/ueditor/','src="http://zjy.17cct.com/ueditor/',$book['content']);
				//出发月份
				$int_cmonth = intval(date('Ym')); //当前月份
				$int_nmonth = intval(date('Ym',$book['play_time']));
				$book['ptime']= (($int_nmonth > $int_cmonth) ? '明年' : '' ). (intval(date('m',$book['play_time']))) ."月";
			} 
			else 
			{
				$this->error('不存在该路书',U('Route/index'),3);
			}
		
		
		M('zjy_book')->where(array('id'=>$id))->setInc('view_count');
		$this->assign('title','路书详情');
		$this->assign('book',$book);
		$this->display();
	}

	//游记详情
	public function travel_view(){
		$id=intval($_REQUEST['id']);
		if(!$id){
			$this->error('不存在该游记',U('Route/index'),3);
		}
		$travel=M('zjy_travel')->where('id='.$id." and is_effect=1")->find();
		$travel['content']=str_replace('src="/ueditor/','src="http://zjy.17cct.com/ueditor/',$travel['content']);
		$travel['user_img']=get_user_avatar($travel['user_id'],'middle');
		if(preg_match('/^1[3|4|5|7|8]\d{9}$/',$travel['user_name'])){
			$travel['user_name']=substr_replace($travel['user_name'],"*****",3,5);
		}
		$this->assign('travel',$travel);

		$remark=M('zjy_travel_remark')->where('travel_id='.$id)->order('id desc')->select();
		foreach ($remark as $k => $v) {
			$remark[$k]['user_img']=get_user_avatar($v['user_id'],'middle');
		}
		$this->assign('title','游记详情');
		$this->assign('remark',$remark);
		$this->display();
	}

	//游记评论
	public function ajaxtravelreview(){
		$id=intval($_REQUEST['id']);
		$content=trim($_REQUEST['content']);
		if(!session('uid')){
			$this->ajaxReturn(0,'请先登录',0);
		}
		if(!$id){
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
		if(!$content){
			$this->ajaxReturn(0,'评论内容为空',0);
		}
		$data['travel_id']=$id;
		$data['content']=$content;
		$data['user_id']=session('uid');
		$data['user_name']=session('user_name');
		$data['add_time']=time();
		$r=M('zjy_travel_remark')->add($data);
		if($r){
			$this->ajaxReturn(1,'点评成功',U('Route/travel_view',array('id'=>$id)));
		}else{
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
	}

	public function camp(){
		if ($_REQUEST['_URL_'][2] == '/' || empty($_REQUEST['_URL_'][2])) {
			$_REQUEST['_URL_'][2] = '0-0' ;
		}
		$parameter=explode('-',$_REQUEST['_URL_'][2]);

		$city = M('region_conf')->field('id,name')->where('pid=7 and region_level = 3')->select();
		$parameter=explode('-',$_REQUEST['_URL_'][2]);
		$p1=$parameter[0];//城市
		$p2=$parameter[1];//营地分类
		foreach ($city as $k => $v) {							
			if($p1==$v['id']){	
				$parameter[0]=0;
				$select[0]['url']=__ACTION__.'/'.implode('-', $parameter);
				$select[0]['name']=$v['name'];	
				$select_city= $v['name'];
			}else{
				$parameter[0]=$v['id'];
				$city[$k]['url']=__ACTION__.'/'.implode('-', $parameter);
			}
		}	
		$parameter[0]=0;
		array_unshift($city,array('id' => 0,'name'=>'全部','url'=>__ACTION__.'/'.implode('-', $parameter)));		
		$parameter[0]=$p1;//还原目的地	
		$this->assign('city',$city);

		//主题推荐
		$class=M('zjy_camp_class')->field('id,title')->where('is_effect=1')->order('sort desc')->select();
		foreach ($class as $k => $v) {					
			if($p2==$v['id']){
				$where .=" and b.theme_id=".intval($v['id']);					
				$parameter[1]=0;
				$select[1]['url']=__ACTION__.'/'.implode('-', $parameter);
				$select[1]['name']=$v['title'];	
				$select_theme	=$v['title'];				
				//break;
			}else{
				$parameter[1]=$v['id'];
				$class[$k]['url']=__ACTION__.'/'.implode('-', $parameter);				
			}
		}
		$parameter[1]=0;
		array_unshift($class,array('id' => 0,'title'=>'全部','url'=>__ACTION__.'/'.implode('-', $parameter)));
		$parameter[1]=$p2;//还原主题推荐

		$this->assign('select',$select);
		$this->assign('class',$class);
		$parameter = implode('-', $parameter);
		$this->assign('parameter',$parameter);
		$this->assign('title','营地列表');
		$this->display();
	}
	public function ajax_get_camp(){
		$page=$_GET['p'];		
		//获取参数
		$parameter=explode('-',$_REQUEST['parameter']);
		$p1=$parameter[0];//城市
		$p2=$parameter[1];//营地分类
		$where=' 1=1 ';
		if($p1){
			$where =' city_id='.intval($p1);		
		}

		if($p2){
			$where .=' and class='.intval($p2);
		}

		$camp_list = M('zjy_camp')->field('fw_zjy_camp.id,fw_zjy_camp.thumb,fw_zjy_camp.title,fw_zjy_camp.detail,frc.name')->join('fw_region_conf as frc on frc.id=fw_zjy_camp.city_id')->where($where)->limit($page*5,5)->select();
				$patterns  = array ('/<p><br\/><\/p>/','/&nbsp;/','/<img[^>]*>/');
 				$replace  = array ('','','[图]');
					
		foreach ($camp_list as $k => $v) {
			$camp_list[$k]['detail'] = msubstr(strip_tags(preg_replace($patterns, $replace,$v['detail'])),0,90);	
		}
		$this->assign('camp_list',$camp_list);
		echo $html=$this->fetch();

	}

	public function camp_view(){
		$id=intval($_REQUEST['id']);
		if(!$id){
			$this->error('不存在该营地',U('Route/index'),3);
		}
		$camp=M('zjy_camp')->where('is_effect=1 and id='.$id)->find();
		$camp['detail']=str_replace('src="/ueditor/','src="http://zjy.17cct.com/ueditor/',$camp['detail']);
		if(!$camp){
			$this->error('不存在该营地',U('Route/index'),3);
		}
		$this->assign('camp',$camp);
		$this->assign('title','营地详情');
		$this->display();
	}

}

?>	