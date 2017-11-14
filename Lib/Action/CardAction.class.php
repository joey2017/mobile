<?php
class CardAction extends BaseAction 
{
	//列表页
	public function index(){	
		
		$this->assign('title','诚车堂e卡');
		$this->display();
	}

	public function ajax_get_card(){
		$page=$_REQUEST['p'];
		$city_id=session('city_id')!=''?session('city_id'):15;
		$card=M('shop_card')->field('fw_shop_card.*,fs.preview')->join('fw_supplier as fs on fs.id=fw_shop_card.supplier_id')->where('fw_shop_card.is_effect=1 and fs.city_id='.$city_id)->order('fw_shop_card.sort desc')->limit($page*4,4)->select();	

		//判断活动促销
		foreach ($card as $k => $v) {			
			if($v['promotion_time_start']<=time()&&$v['promotion_time_end']>=time()){
				$card[$k]['is_promotion']=1;
			}
		}
		
		$this->assign('card',$card);
		echo $html=$this->fetch();
	}

	//详情页
	public function detail(){

		$id = intval($_GET['id']);
		if($id<=0){
			$this->error('养护卡不存在');
		}
		$card=M('shop_card')->field('fw_shop_card.*,fsl.name as s_name,fs.preview')->join('fw_supplier as fs on fs.id=fw_shop_card.supplier_id')->join('fw_supplier_location as fsl on fsl.id=fw_shop_card.location_id')->where('fw_shop_card.is_effect=1 and fw_shop_card.id='.$id)->find();
		if(!$card){
			$this->error('养护卡不存在');
		}
		// 浏览量加1
		M('shop_card')->where(array('id'=>$id))->setInc('view_count');
		if($card['promotion_time_start']<=time()&&$card['promotion_time_end']>=time()){
			$card['is_promotion']=1;
		}
		//年卡服务,产品
		$card_goods=M('shop_card_cate_link')->field('fw_shop_card_cate_link.*,sc.name')->join('fw_shop_cate as sc on sc.id=fw_shop_card_cate_link.deal_cate_type_id')->where('fw_shop_card_cate_link.card_id='.$id." and sc.pid!=0 and fw_shop_card_cate_link.is_shop=1")->select();
		
		$card_service=M('shop_card_cate_link')->field('fw_shop_card_cate_link.*,dct.name')->join('fw_deal_cate_type as dct on dct.id=fw_shop_card_cate_link.deal_cate_type_id')->where('fw_shop_card_cate_link.card_id='.$id."  and fw_shop_card_cate_link.is_shop=2")->select();
		
		if($card_goods&&$card_service){
			$cate_list=array_merge_recursive($card_goods,$card_service);
		}else{
			$cate_list=$card_goods==''?$card_service:$card_goods;			
		}
		
		foreach ($cate_list as $k => $v) {
			if($v['number_of_user']==0){
				$cate_list[$k]['number_of_user']='不限';
			}			
			$cate_list[$k]['location']=M('shop_card_cate_deal_link')->field('sl.id as sid,sl.name,fw_shop_card_cate_deal_link.deal_id,fw_shop_card_cate_deal_link.location_id,fd.name as deal_name,fd.is_shop')->join('fw_supplier_location as sl on sl.id=fw_shop_card_cate_deal_link.location_id')->join('fw_deal as fd on fd.id=fw_shop_card_cate_deal_link.deal_id')->where('fw_shop_card_cate_deal_link.link_id='.$v['id'])->select();
		}
		foreach ($cate_list as $k => $v) {
			foreach ($v['location'] as $k1 => $v1) {				
				$count['ser'][]=$v1['deal_id'];
				$count['store'][]=$v1['location_id'];
			}
		}
		$card['ser_count']=count(array_unique($count['ser']));
		$card['store_count']=count(array_unique($count['store']));
		$card['detail']=str_replace('src="/ueditor/','src="http://www.17cct.com/ueditor/',$card['detail']);
		$this->assign('cate_list',$cate_list);
		$this->assign('card',$card);
		$this->assign('title',$card['name']);
		$this->display();
	}
	
	//提交订单
	public function done(){		

		$id=intval($_REQUEST['id']);
		if(!$id){
			header("Location:".U("Card/index"));
		}
		isLogin(U('Card/done',array('id'=>$id)));
		$card=M('shop_card')->where('id='.$id." and is_effect=1")->find();
		if(!$card){
			header("Location:".U("Card/index"));
		}
		if($card['buy_count']>=$card['num']&&$card['num']!=0){
			$this->error('该养护卡已销完');
		}
		//判断活动促销
		if($card['promotion_time_start']<=time()&&$card['promotion_time_end']>=time()){
			$order['total_price']=$card['promotion_price'];
		}else{
			$order['total_price']=$card['price'];
		}	
		$user_info = session('user_info');
		$order['user_id']=$user_info['id'];
		$order['user_name']=$user_info['user_name'];
		$order['mobile']=$user_info['mobile'];
		$order['create_time']=time();
		$order['status']='1';
		$order['card_name']=$card['name'];
		$order['referer']='2';
		$order['price']=$card['price'];
		$order['card_id']=$id;
		$order['supplier_id']=$card['supplier_id'];
		$order['location_id']=$card['location_id'];
		do
		{
			$order['order_sn'] = date("YmdHis",time()).rand(10,99);
			$order_id=M('shop_card_order')->add($order);
		}while($order_id==0);
		if($order_id){
			header("Location:".U("Card/order",array('id'=>$order_id)));
		}else{
			header("Location:".U("Card/index"));
		}
		
	}

	public function order(){
		$id=intval($_REQUEST['id']);
		if(!$id){
			$this->error('该订单不存在');
		}
		if (!isLogin(U('Card/order',array('id'=>$id)))) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$order=M('shop_card_order')->where('id='.$id." and user_id=".session('uid')." and status='1'")->find();
		
		if(!$order){
			$this->error('该订单不存在');
		}
		$stime = strtotime(date('Y-m-d'));
	  	$etime = $stime+86399;
	  	if($order['create_time']>=$stime&&$order['create_time']<=$etime){
	  		$this->assign('can_pay',1);	
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
		if (!isLogin(U('Card/order',array('id'=>$pid)),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$uid = intval(session('uid'));
		
		$order=M('shop_card_order')->join('fw_shop_card as fsc on fsc.id=fw_shop_card_order.card_id')->where('fw_shop_card_order.id='.$pid." and fw_shop_card_order.user_id=".$uid." and fw_shop_card_order.status='1' and fsc.is_effect=1")->find();
		if ($order) {
			$this->ajaxReturn(U('Pay/go_pay',array('id'=>$pid,'act'=>'card')),'正在处理中，请稍候',1);
		}else {
			$this->ajaxReturn(0,'年卡不存在或已下架',0);
		}
	}


	//支付回调页面
	public function pay_back()
	{
		$order_id = intval($_REQUEST['order_id']);
		$order_sn = trim($_REQUEST['order_sn']);

		isLogin(U('Index/index'));
		if (!$order_id||!$order_sn) {
			$this->error('非法操作');
		}
		$order=M('shop_card_order')->where('id='.$order_id)->find();
		$this->assign('order_status',$order['status']);
		$this->assign("price",$order['price']);
		$this->assign("order_sn",$order_sn);
		$this->assign("title","支付结果");
		$this->display();
	}




}
?>