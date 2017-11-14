<?php
class AdvanceAction extends BaseAction 
{

	public function index(){
		
		$aid = intval($_GET['aid'])>0?intval($_GET['aid']):0; //区
		$qid = intval($_GET['qid'])>0?intval($_GET['qid']):0; //路
		$oid = intval($_GET['oid'])>0?intval($_GET['oid']):0; //排序
		$tid = intval($_GET['tid'])>0?intval($_GET['tid']):0; //车型	

		$sqlWhere =  $this->getSqlWhere($aid,$qid,$oid,$tid);
	
		$this->assign("order_name",$sqlWhere['order_name']);
		$this->assign("area_name",$sqlWhere['area_name']);
		$this->assign("type_name",$sqlWhere['type_name']);
		$link = $this->link_url($_REQUEST,4);	
	
		$this->assign("link",$link);
		
		$this->display();
	}

	public function area()
	{	
		$link = $this->link_url($_REQUEST,1);
		$aid  = $_REQUEST['aid'];
		$qid  = $_REQUEST['qid'];
		$area = M('area')->cache(true,600)->field('id,name')->where(array('city_id'=>15,'pid'=>0))->order('sort desc,id desc')->select();
		$area[]=array("name"=>'全城',"aid"=>0);
		foreach ($area as $k => $v) {
			if($aid == $v['id']){
				$area[$k]['class'] = 'active';
				$area[$k]['son_class'] = '';
			}else{
				$area[$k]['class'] = 'normal';
				$area[$k]['son_class'] = 'none';
			}
			$area[$k]['son'] =  M('area')->cache(true,600)->field('id,name')->where(array('pid'=>$v['id']))->order('sort desc,id desc')->select();
			$area[$k]['son'][] = array("name"=>'全部',"qid"=>0);
			if ($area[$k]['son']) {
				foreach ($area[$k]['son'] as $s_k => $s_v) {
					if($aid == $v['id'] && $qid == $s_v['id']){
						$area[$k]['son'][$s_k]['style'] = 'style="color:#cd0000;font-weight:bold;"';
					}
					$area[$k]['son'][$s_k]['url']= $link."&aid=".$v['id']."&qid=".$s_v['id'];
				}
			}
			krsort($area[$k]['son']);
		}
		krsort($area);
		$this->assign("mytab","myTab0");
		$this->assign("resultlist",$area);
		$this->display('tabbox');
	}

	public function car_type(){
		$oid  = $_REQUEST['oid'];
		$link = $this->link_url($_REQUEST,2);
		$car_arr[0] = array(id=>0,name=>'全部');
		$car_arr[1] = array(id=>1,name=>'5座');
		$car_arr[2] = array(id=>2,name=>'7座');
		$car_arr[3] = array(id=>3,name=>'SUV');
		$car = array(array(id=>0,name=>'全部','class'=>'active','son_class'=>'','url'=>$link."&oid=".$v['id']));
		$car[0]['son'] = $car_arr;

		foreach ($car[0]['son'] as $s_k => $s_v) {
			if($oid == $s_v['id']){
				$car[0]['son'][$s_k]['style']='style="color:#cd0000;font-weight:bold;"';
			}
			$car[0]['son'][$s_k]['url']= $link."&tid=".$s_v['id'];
		}
		$this->assign("mytab","myTab2");
		$this->assign("resultlist",$car);
		$this->display('tabbox');
	}

	public function order_by()
	{
		$oid  = $_REQUEST['oid'];
		$link = $this->link_url($_REQUEST,3);
		$order_arr[0] = array(id=>0,name=>'离我最近');
		$order_arr[1] = array(id=>1,name=>'价格最低');
		$order_by = array(array(id=>0,name=>'排序','class'=>'active','son_class'=>'','url'=>$link."&oid=".$v['id']));
		$order_by[0]['son'] = $order_arr;

		foreach ($order_by[0]['son'] as $s_k => $s_v) {
			if($oid == $s_v['id']){
				$order_by[0]['son'][$s_k]['style']='style="color:#cd0000;font-weight:bold;"';
			}
			$order_by[0]['son'][$s_k]['url']= $link."&oid=".$s_v['id'];
		}
		$this->assign("mytab","myTab3");
		$this->assign("resultlist",$order_by);
		$this->display('tabbox');
	}

	public function ajax_get_service(){
		$page=$_REQUEST['p'];
		$aid = intval($_GET['aid'])>0?intval($_GET['aid']):0; //区
		$qid = intval($_GET['qid'])>0?intval($_GET['qid']):0; //路
		$oid = intval($_GET['oid'])>0?intval($_GET['oid']):0; //排序
		$tid = intval($_GET['tid'])>0?intval($_GET['tid']):0; //车型
		$y = $_GET['lat']; //纬度
		$x = $_GET['lng']; //经度
		$sqlWhere =  $this->getSqlWhere($aid,$qid,$oid,$tid);
		$order_by=" sort desc,sid desc";
		if($oid==1){
			$order_by=" selling_price asc,sid desc";
		}
		
		$list=M('erp_goods')->field('fsl.id as sid,fsl.name,fsl.address,fw_erp_goods.id,fw_erp_goods.goods_name,fw_erp_goods.selling_price,fsl.xpoint,fsl.ypoint,fepc.pid')->join('fw_supplier_location as fsl on fsl.id=fw_erp_goods.store_id')->join('fw_erp_product_category as fepc on fepc.id=fw_erp_goods.cate_id')->where('fepc.top_id=33 and fw_erp_goods.is_del=0 and fsl.is_effect=1 '.$sqlWhere['str'])->order($order_by)->select();
	
		foreach ($list as $k => $v) {
			$service[$v['sid']]['name']=$v['name'];			
			if($y!='null'&&$x&&$v['ypoint']&&$v['xpoint']){				
				$distance = round(getDistance($y,$x,$v['ypoint'],$v['xpoint']),2);
			}else{
				$distance = '';
			}			
			$v['project_type']=$v['pid']==183?'project1':'project2';
			$service[$v['sid']]['distance'] = $distance;
			$service[$v['sid']]['address'] = $v['address'];
			$service[$v['sid']]['list'][]=$v;
			$service[$v['sid']]['count']++;
			$service[$v['sid']]['wait_time']=$this->car_wash_wait($v['sid']);
		}
		if($oid == 0){
			$service = multi_array_sort($service,'distance',$sort=SORT_ASC);			
		}
		$service = array_slice($service,$page*6,6);	
		$this->assign('service',$service);
		echo $html=$this->fetch();
	}


	public function link_url($arr,$a)
	{
		$link = '?';

		if($arr['aid'] && $a!=1){ //大区
			$link.="&aid=".$arr['aid'];
		}
		if($arr['qid'] && $a!=1){ //小区
			$link.="&qid=".$arr['qid'];
		}
		if($arr['oid'] && $a!=3){ //排序
			$link.="&oid=".$arr['oid'];
		}
		if($arr['tid'] && $a!=2){ //车型
			$link.="&tid=".$arr['tid'];
		}
		return $link;
	}

	public function getSqlWhere($aid=0,$qid=0,$oid=0,$tid=0)//store service goods
	{	
		$where = '';
		if($aid>0)
		{
			if($qid>0)
				{	
					$area_name = M("area")->cache(true,600)->getFieldById($qid,"name");
					$kw_unicode = strToUnicodeString($area_name);
					//有筛选
					$where .=" and (match(fsl.locate_match) against('".$kw_unicode."' IN BOOLEAN MODE))";
				}
				else
				{	
					$area_name =M("area")->cache(true,600)->getFieldById($aid,"name");
					$quan_list =M("area")->cache(true,600)->where(array('pid'=>$aid))->Field("id,name")->select();
					$unicode_quans = array();
					foreach($quan_list as $k=>$v){
						$unicode_quans[] = strToUnicodeString($v['name']);
					}
					$kw_unicode = implode(" ", $unicode_quans);
					$where.= " and (match(fsl.locate_match) against('".$kw_unicode."' IN BOOLEAN MODE))";
				}
		}else{
			$area_name ="全城";
		}

		$type=array('ids'=>array(1=>'  in (185,188)','2'=>' in(186,189)','3'=>' in(187,190)'),'names'=>array('1'=>'5座','2'=>'7座','3'=>'suv'));
	
		if($tid>0&&$type['ids'][$tid]){
			$where.=" and fepc.id".$type['ids'][$tid];
			$type_name =$type['names'][$tid];
		}else{
			$where.=" and fepc.pid in (183,184)";
			$type_name ="全部";
		}
		if($oid==1){
			$order_name="价格最低";
		}else{			
			$order_name="离我最近";
		}

		$result['str'] = $where;
		$result['area_name'] = $area_name;
		$result['type_name'] = $type_name;
		$result['order_name'] = $order_name;
		return $result;
	}


	public function car_wash_wait($location_id){

    	$advance = M("erp_advance_setting")->where("location_id=".intval($location_id))->find();

		$construction_num=M("erp_order_item as eoi")->join("fw_erp_order as eo on eo.id=eoi.order_id")->join("fw_erp_goods as eg on eoi.project_id=eg.id")->join("fw_erp_product_category as epc on eg.cate_id=epc.id")->where("epc.top_id=33 and eo.status='1' and eo.is_delete='0' and eo.location_id=".intval($location_id))->count();

		if($construction_num<$advance['station_num']){
			$msg='0分钟';
		}else{
			$time=intval($construction_num/$advance['station_num'])*$advance['work_time'];
			if($time<60){
				$msg='<b>'.$time.'</b>'.'分钟';
			}else{
				$hour=intval($time/60);
				$minute=$time%60;
				if($minute==0){
					$msg=$hour.'小时';
				}else{
					$msg='<b>'.$hour.'</b>'.'小时'.'<b>'.$minute.'</b>'.'分钟';
				}
			}
		}
		return $msg;	
    }


	

	// ajax  计算通过定位后与商家的距离
	public function getDistanceToStore()
	{
		$sid   = intval($_POST['id']);  //商家id
		$mylat = $_POST['lat']; //纬度
		$mylng = $_POST['lng']; //经度

		if (empty($sid)|| empty($mylat)|| empty($mylng) || $sid <= 0 ) {
			$this->ajaxReturn(0,'定位参数错误，请刷新后重试',0);
		}

		$storePosition = M('supplier_location')->field('xpoint,ypoint')->find($sid);
		if ($storePosition) {
			if ($storePosition['xpoint'] == '' || $storePosition['ypoint'] == '') {
				$this->ajaxReturn(0,'商家未标注位置',0);
			}
			$distance = getDistance($mylat,$mylng,$storePosition['ypoint'],$storePosition['xpoint']);
			$this->ajaxReturn($distance,'计算距离成功',1);
		}else {
			$this->ajaxReturn(0,'计算距离失败，请刷新后重试',0);
		}
	}


	//预约下单
	public function advance_add(){

		$goods_id=intval($_REQUEST['id']);
		
		isLogin(U('Advance/advance_add',array('id'=>$goods_id)));

		$u = session('user_info');
		$user_name=$u['true_name'];
		$mobile=$u['mobile'];

		if($goods_id){

			//如果是店面会员，则将信息写入页面
			$member=M("erp_member as em")->field("em.id,em.m_name,sui.car_sn,femb.member_card_type,femb.member_card_name")->join("fw_shop_user_info as sui on sui.member_id=em.id")->join('fw_erp_member_balance as femb on femb.mobile=em.mobile')->where("em.mobile=".$mobile)->find();
			
			if($member){
				$user_name=$member['m_name'];
				$car_sn=$member['car_sn'];
			}

			$goods=M("erp_goods as eg")->field("eg.goods_name,eg.selling_price,fsl.name,fsl.id as location_id")->join("fw_supplier_location as fsl on fsl.id=eg.store_id")->where("eg.id=".$goods_id)->find();

			if($goods){
				$goods['discount_price']=$goods['selling_price'];
				if($member['member_card_type']){ 
					$discount=M("erp_card_discount")->where("card_type=".$member['member_card_type']." and cate_id=33")->getField("discount");
					
					if($discount){
						$goods['discount_price']=$goods['selling_price']*($discount/10);
					}
				}
				$prov=array('桂','粤','浙','京','沪','川','津','渝','鄂','赣','冀','蒙','鲁','苏','辽','吉','皖','湘','黑','琼','贵','云','藏','陕','甘','宁','青','豫','闽','新','晋');//车牌信息

				$letter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

				$this->assign("member",$member);
				$this->assign("prov",$prov);
				$this->assign("letter",$letter);
				$this->assign("goods_id",$goods_id);
				$this->assign("car_sn",$car_sn);
				$this->assign("user_name",$user_name);
				$this->assign("mobile",$mobile);
				$this->assign("goods",$goods);
				$this->display();
			}else{
				$this->error('服务不存在',U('Advance/index'),3);
			}

		}else{
			$this->error('服务不存在',U('Advance/index'),3);
		}		
		
	}

	public function advance_save(){

		isLogin(U('Advance/advance_save'));

		$u = session('user_info');

		$mobile=$u['mobile'];

		//预约信息
		$advance_goods_id=intval($_REQUEST['advance_goods_id']);
		$advance_user_name=trim($_REQUEST['advance_user_name']);		
		$advance_mobile=trim($_REQUEST['advance_mobile']);
		$advance_time=strtotime($_REQUEST['advance_time']);
		$advance_car_sn=trim($_REQUEST['prov']).trim($_REQUEST['letter']).trim($_REQUEST['advance_car_sn']);
		$advance_remark=trim($_REQUEST['advance_remark']);

		if($advance_goods_id!=''&&$advance_user_name!=''&&$advance_mobile!=''&&$advance_time!=''&&$advance_car_sn!=''){

			$goods=M("erp_goods as eg")->field("eg.id,eg.goods_name,eg.selling_price,fsl.name as location_name,fsl.id as location_id")->join("fw_supplier_location as fsl on fsl.id=eg.store_id")->where("eg.id=".$advance_goods_id)->find();

			//根据登录者手机查询member信息
			$member=M("erp_member as em")->field("em.id,em.m_name,emb.member_card_type,emb.member_card_name")->join("fw_erp_member_balance as emb on em.mobile=emb.mobile")->where("em.mobile=".$mobile)->find();

			if($member){
				if($member['member_card_type']){
					$discount=M("erp_card_discount")->where("card_type=".$member['member_card_type']." and cate_id=33")->getField("discount");
					if($discount){
						$order['total_price']=$goods['selling_price']*($discount/10);
					}
				}else{
					$order['total_price']=$goods['selling_price'];
				}

				$order['user_id']=$member['id'];

			}else{
				$order['total_price']=$goods['selling_price'];
			}

			//下单
			$order['user_name']=$advance_user_name;
			$order['order_sn']=date("Ymdhis",time()).rand(10,99);
			$order['create_time']=time();
			$order['pay_status']='0';
			$order['total_original_price']=$goods['selling_price'];
			$order['type']='3';//预约订单
			$order['means_of_payment']='0';//0为待结算
			$order['is_delete']='0';
			$order['mobile']=$advance_mobile;
			$order['status']='0';//0为预约订单
			$order['location_id']=$goods['location_id'];
			$order['car_sn']=$advance_car_sn;
			$order['remark']=$advance_remark;
			$order['wx_user_id']=intval(session('uid'));
			$order['advance_time']=$advance_time;			
			$order_id=M('erp_order')->add($order);
			
			if($order_id){
				$order_item['order_id']=$order_id;
				$order_item['type']='1';//1为服务
				$order_item['unit_price']=$goods['selling_price'];
				$order_item['discount_rate']=$discount;
				$order_item['sell_price']=$order['total_price'];
				$order_item['num']=1;
				$order_item['project_id']=$goods['id'];
				$order_item['project_name']=$goods['goods_name'];

				$order_item_id=M('erp_order_item')->add($order_item);
				
				if($order_item_id){

					$this->ajaxReturn(U('Advance/advance_info',array('id'=>$order_id)),'提交信息成功',1);

				}else{

					$this->ajaxReturn(0,'预约失败',0);
					
				}
			}
		}else{
			$this->error('请正确填写预约信息',U('Advance/index'),3);
		}	
	
	}
	public function advance_info(){

		$id=intval($_REQUEST['id']);

		isLogin(U('Advance/advance_info',array('id'=>$id)));

		$u = session('user_info');
		$mobile=$u['mobile'];

		if($id){

			$order=M("erp_order_item as eoi")->field("eo.advance_time,eo.id,eoi.project_name,eo.total_price,fsl.name as location_name,eo.location_id,fsl.supplier_id")->join("fw_erp_order as eo on eoi.order_id=eo.id")->join("fw_supplier_location as fsl on fsl.id=eo.location_id")->where("eo.id=".$id." and eo.wx_user_id=".intval(session('uid'))." and eo.type='3' and pay_status='0'")->find();
			
			if($order){

				//会员卡余额
				$member_card_balance=M("erp_member_balance")->where("mobile=".$mobile)->getField('member_card_balance');
				
				//E卡余额
				$old_card_balance=M('erp_member')->where('supplier_id='.$order['supplier_id'].' and mobile='.$u['mobile'])->getField('old_card_balance');

			
				if($member_card_balance&&$member_card_balance>=$order['total_price']){
					$this->assign("member_card_balance",$member_card_balance);
				}

				if($old_card_balance&&$old_card_balance>=$order['total_price']){
					$this->assign("old_card_balance",$old_card_balance);
				}
				$this->assign("order",$order);
				$this->assign("member_card_name",$member_card_name);
				$this->display();
			}else{
				$this->error('没有找到预约信息',U('Advance/index'),3);
			}

		}else{
			$this->error('没有找到预约信息',U('Advance/index'),3);
		}	
	}

	//判断服务所属门店,额度够不够
	public function erp_e_member_pay(){		
		if(!session('user_info')){
			$result['status'] = 0;
			$result['msg'] = '请先登录';	
			$this->ajaxReturn($result);
		}
		$id=intval($_REQUEST['id']);
		$pay_type=intval($_REQUEST['pay_type']);
		if($pay_type!=3&&$pay_type!=6){
			$result['status'] = 0;
			$result['msg'] = '请选择支付方式';	
			$this->ajaxReturn($result);
		}
		$uid=intval(session('uid'));
		$order = M('erp_order')->field('fw_erp_order.id,fw_erp_order.total_price,fw_erp_order.pay_status,fw_erp_order.wx_user_id,fw_erp_order.user_id,fw_erp_order.location_id,fw_erp_order.type,feoi.project_name,feoi.project_id,fw_erp_order.mobile')->join('fw_erp_order_item as feoi on feoi.order_id=fw_erp_order.id')->where('fw_erp_order.id='.$id." and fw_erp_order.wx_user_id=".$uid." and fw_erp_order.type='3' and pay_status='0'")->find();
		
		if($order){
			$u=session('user_info');
			if($pay_type==6){
				$member=M('erp_member')->field('id,old_card_balance')->where('is_del=0 and location_id='.$order['location_id'].' and mobile='.$u['mobile'])->find();

				if(!$member){
					$result['status'] = 0;
					$result['msg'] = '没有E卡余额';	
					$this->ajaxReturn($result);
				}
				if($order['total_price']>$member['old_card_balance']){
					$result['status'] = 0;	
					$result['msg'] = 'E卡余额不足';	
					$this->ajaxReturn($result);
				}

				$data['old_card_balance']=$member['old_card_balance']-$order['total_price'];
				
				if($data['old_card_balance']>=0){
					$r=M('erp_member')->where('id='.intval($member['id']))->setField('old_card_balance',$data['old_card_balance']);
								
				}
			}else{ 	
				$card=M('erp_member_balance')->where('mobile='.$u['mobile'])->find();
				if(!$card){
					$result['status'] = 0;
					$result['msg'] = '没有会员卡';	
					$this->ajaxReturn($result);
				}
				if($order['total_price']>$card['member_card_balance']){
					$result['status'] = 0;
					$result['msg'] = '会员卡余额不足';	
					$this->ajaxReturn($result);
				}

				$data['member_card_balance']=$card['member_card_balance']-$order['total_price'];
				//var_dump($data);
				if($data['member_card_balance']>=0){
					$r=M('erp_member_balance')->where('mobile='.$u['mobile'])->setField('member_card_balance',$data['member_card_balance']);			
				}
				//var_dump(M('erp_member_balance')->getlastsql());exit;
			}

			if($r){

					//修改订单状态
					$order_update=array('pay_amount'=>$order['total_price'],'pay_status'=>'1','means_of_payment'=>"$pay_type",'pay_time'=>time());
					M('erp_order')->where('id='.$id)->save($order_update);

					//订单交易详情
					$order_deal['order_id']=$order['id'];
					$order_deal['price']=$order['total_price'];
					$order_deal['mean_of_payment']="$pay_type";
					$order_deal['pay_time']=time();
					M('erp_order_deal')->add($order_deal);

					$store = M('supplier_location')->field('name,tel,mobile,address,supplier_id')->where(array('id'=>$order['location_id']))->find();
					$store['tel'] = empty($store['tel']) ? $store['mobile'] : $store['tel'] ;
					// 生成服务码
					$coupon['is_del']=0;
					$coupon['member_id']=$order['user_id'];
					$coupon['user_id']=$order['wx_user_id'];
					$coupon['order_id']=$order['id'];
					$coupon['goods_id']=$order['project_id'];
					$coupon['supplier_id']=$store['supplier_id'];
					$coupon['location_id']=$order['location_id'];
					$coupon['add_time']=time();
					$coupon['sn']=rand(100000000,9999999999);					
					while(!M('erp_coupon')->add($coupon))
					{
						$coupon['sn'] = rand(100000000,9999999999);
					}
					$userMsg['order_id']       = $order['id'];
					$userMsg['user_true_name'] = $u['true_name'];
					$userMsg['user_mobile']    = $u['mobile'];
					$userMsg['user_wxid']      = $u['wxid'];
					$userMsg['deal_id']        = $order['id'];
					$userMsg['deal_name']      = $order['project_name'];
					$userMsg['deal_tpye']      = '3';
					$userMsg['deal_attr']      = '';
					$userMsg['coupon'] 	       = $coupon['sn'];
					$userMsg['store_tel']      = $store['tel'];
					$userMsg['store_name']     = $store['name'];
					$userMsg['store_address']  = $store['address'];
					$userMsg['send_type']  = 'erp';
					paySuccessSendMsg('user',$userMsg);

					//发送 商家 短信 微信
					$storeMsg['user_true_name'] = $u['true_name'];
					$storeMsg['user_mobile']    = $u['mobile'];
					$storeMsg['deal_name']   	= $order['project_name'];
					$storeMsg['deal_tpye'] 		= '3';
					$storeMsg['store_mobile']   = $store['mobile'];
					//paySuccessSendMsg('store',$storeMsg);	
					
					$result['status'] = 1;
					$result['msg'] = '付款成功';
					$result['data']=U('Advance/order_detail',array('id'=>$id));	
					$this->ajaxReturn($result);
				}else{
					$msg=$pay_type==3?'会员卡':'E卡';
					$result['status'] = 0;
					$result['msg'] =$msg.'扣款失败';	
					$this->ajaxReturn($result);
				}

		}else{
			$result['status'] = 0;
			$result['msg'] = '无此订单信息';	
			$this->ajaxReturn($result);
		}
	}

	//会员卡支付
	/*public function erp_card_pay(){
		$id=intval($_REQUEST['id']);
		isLogin(U('User/index',array('id'=>$id)));
		$uid=intval(session('uid'));
		$order = M('erp_order')->field('fw_erp_order.id,fw_erp_order.total_price,fw_erp_order.pay_status,fw_erp_order.wx_user_id,fw_erp_order.user_id,fw_erp_order.location_id,fw_erp_order.type,feoi.project_id,feoi.project_name,fw_erp_order.mobile')->join('fw_erp_order_item as feoi on feoi.order_id=fw_erp_order.id')->where('fw_erp_order.id='.$id." and fw_erp_order.wx_user_id=".$uid." and fw_erp_order.type='3' and pay_status='0'")->find();
		
		if($order){
			$u=session('user_info');
			$card=M('erp_member_balance')->where('mobile='.$u['mobile'])->find();
			if(!$card){
				$result['status'] = 0;
				$result['msg'] = '没有会员卡';	
				$this->ajaxReturn($result);
			}
			if($order['total_price']>$card['member_card_balance']){
				$result['status'] = 0;
				$result['msg'] = '会员卡余额不足';	
				$this->ajaxReturn($result);
			}

			$data['member_card_balance']=$card['member_card_balance']-$order['total_price'];
			if($data['member_card_balance']>=0){
				$r=M('erp_member_balance')->where('mobile='.$u['mobile'])->save($data);
				if($r){				
					//修改订单状态
					$order_update=array('pay_amount'=>$order['total_price'],'pay_status'=>'1','means_of_payment'=>'3');
					M('erp_order')->where('id='.$id)->save($order_update);

					//订单交易详情
					$card_deal['card_id']=$card['member_card_id'];
					$card_deal['card_type']=$card['member_card_type'];
					$card_deal['card_number']=$card['member_card_number'];
					$card_deal['type']='3';
					$card_deal['order_id']=$order['id'];
					$card_deal['member_id']=$order['user_id'];
					$card_deal['order_id']=$order['id'];
					$card_deal['total_price']=$order['total_price'];
					$card_deal['mean_of_payment']='3';
					$card_deal['add_time']=time();
					$card_deal['balance']=$data['member_card_balance'];
				
					$card_insert=M('erp_card_deal')->add($card_deal);
			
					$store = M('supplier_location')->field('name,tel,mobile,address,supplier_id')->where(array('id'=>$order['location_id']))->find();
					$store['tel'] = empty($store['tel']) ? $store['mobile'] : $store['tel'] ;
					// 生成服务码
					$coupon['is_del']=0;
					$coupon['member_id']=$order['user_id'];
					$coupon['user_id']=$order['wx_user_id'];
					$coupon['order_id']=$order['id'];
					$coupon['goods_id']=$order['project_id'];
					$coupon['supplier_id']=$store['supplier_id'];
					$coupon['location_id']=$order['location_id'];
					$coupon['add_time']=time();
					$coupon['sn']=rand(100000000,9999999999);
					while(!M('erp_coupon')->add($coupon))
					{
						$coupon['sn'] = rand(100000000,9999999999);
					}

					$userMsg['order_id']       = $order['id'];
					$userMsg['user_true_name'] = $u['true_name'];
					$userMsg['user_mobile']    = $u['mobile'];
					$userMsg['user_wxid']      = $u['wxid'];
					$userMsg['deal_id']        = $order['id'];
					$userMsg['deal_name']      = $order['project_name'];
					$userMsg['deal_tpye']      = '3';
					$userMsg['deal_attr']      = '';
					$userMsg['coupon'] 	       = $coupon['sn'];
					$userMsg['store_tel']      = $store['tel'];
					$userMsg['store_name']     = $store['name'];
					$userMsg['store_address']  = $store['address'];
					$userMsg['send_type']  = 'erp';
					//paySuccessSendMsg('user',$userMsg);

					//发送 商家 短信 微信
					$storeMsg['user_true_name'] = $u['true_name'];
					$storeMsg['user_mobile']    = $u['mobile'];
					$storeMsg['deal_name']   	= $order['project_name'];
					$storeMsg['deal_tpye'] 		= '3';
					$storeMsg['store_mobile']   = $store['mobile'];
					//paySuccessSendMsg('store',$storeMsg);	

				}else{
					$result['status'] = 0;
					$result['msg'] = '会员卡扣款失败';	
					$this->ajaxReturn($result);
				}
			}


		}else{
			$result['status'] = 0;
			$result['msg'] = '无此订单信息';	
			$this->ajaxReturn($result);
		}
	}*/

	//预约页面
	public function reservation(){
		isLogin(U('Advance/reservation'));
	
		$store_info = M('supplier_location')->field('id,name,address,tel,preview')->where('is_effect=1 and city_id=15')->limit(0,20)->select();

		$item_info = M('erp_product_category')->field('name')->where('pid=0 and is_del=0 and level=1 and id not in(4913,343)')->select();
		
		$this->assign('user_info',session('user_info'));
		$this->assign('store_info',$store_info);
		$this->assign('item_info',$item_info);
		$this->assign('title','预约服务');
		$this->display();
	}

	//预约信息处理
	public function reservation_process(){
		// 设置字段自动完成
		$rules = array ( 
			array('status','0'),  
			array('create_time','time',1,'function'),    
			array('push','0'), 
		);
		$data['store_name'] = I('post.store_name');
		$data['store_contact'] = I('post.store_contact');
		$data['store_address'] = I('post.store_address');

		$data['item'] = I('post.item');
		$data['service_time'] = strtotime($_POST['service_time']);
		$data['uid'] = $_SESSION['user_info']['id'];
		$data['car_owner'] = I('post.car_owner');
		$data['user_mobile'] = I('post.user_mobile');
		$data['remark'] = I('post.remark');
		$data['store_id']=intval($_POST['store_id']);
		$data['order_sn']=date("Ymdhis",time()).rand(10,99);
		$user = M('reservation');

		if($user->auto($rules)->create($data)){
			$result = $user->add();
			if($result){
				$openid_list=M('pms_weixin')->field('open_id')->where('relation_id='.$data['store_id'].' and type=1')->select();
				
				if($openid_list){
					$first_msg='尊敬的'.$data['store_name'].':顾客"'.$data['car_owner'].'"网上预约到贵店接受服务';
					$user_car_info=M('shop_user_info as sui')->field('sui.car_sn,c.name')->join('fw_car as c on c.id=sui.models_id')->where('mobile='.$data['user_mobile'])->find();
					
					if($user_car_info){
						if($user_car_info['name']){
							$car_info=$user_car_info['name'].',';
						}
						$car_info.=$user_car_info['car_sn'];
					}else{
						$car_info='暂无';
					}
					foreach ($openid_list as $k => $v) {
						$this->reservation_done_msg($v['open_id'],$first_msg,$data['order_sn'],$data['user_mobile'],$_POST['service_time'],$data['item'],$car_info);
					}
				}

				$this->ajaxReturn(array('status'=>1,'msg'=>$result));
			}else{
				$this->ajaxReturn(array('status'=>0,'msg'=>'添加预约信息失败'));
			}
		}else{
			$this->ajaxReturn(array('status'=>0,'msg'=>'请稍后重试'));
		}
	}

	//发送预约模板消息
	public function reservation_done_msg($wxid,$first_msg,$order_sn,$mobile,$data_time,$item,$car_info){
		$json=array("touser"=>$wxid,
					"template_id"=>"p4JkowvwSg-c8VvuftA-IRIsitS8trPiOI3WPPop7TY",
					"url"=>"http://m.17cct.com/index.php/Biz/reservation_list.html",
					"topcolor"=>"#FF0000",
					"data"=>array('first'=>array('value'=>$first_msg),
								'keyword1'=>array('value'=>$order_sn),
								'keyword2'=>array('value'=>$mobile),
								'keyword3'=>array('value'=>$data_time),
								'keyword4'=>array('value'=>$car_info),
								'keyword5'=>array('value'=>$item),
								'remark'=>array('value'=>'如有问题请致电0771-2756623或直接在微信留言，我们将第一时间为您服务！')
						)
			);
		$this->send_template_info($json);
	}

	//发送模板
	public function send_template_info($json){
		
		    $access_token  = $this->get_sj_acc_token();
			
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

	/**
	* 获取诚车堂商户版access_token
	**/
	private function get_sj_acc_token()
	{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxb09359ac1d3f2267&secret=7e161c7930c9de1f3213dd13d6bb7a9c");
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$access_token = curl_exec($ch);
		$access_token=json_decode($access_token, true); 
		return $access_token['access_token'];	
	}


	//预约成功页面
	public function reservation_success(){
		isLogin(U('Advance/reservation_success'));
		$rid = trim($_GET['rid']) + 0;
		$sql = "SELECT r.id,r.service_time,r.car_owner,r.user_mobile,r.item,r.store_name,r.store_contact,r.remark FROM fw_reservation r WHERE r.id='$rid'";
		$reservation_info = M()->query($sql);
		$this->assign('title','预约成功');
		$this->assign('info',$reservation_info);
		$this->display();
	}

	//查看预约记录
	public function reservation_record(){
		// $user_info=session('user_info');
		// $sql = "SELECT r.id,r.status,r.service_time,r.item,r.store_name,r.store_contact,r.store_address,r.car_owner,r.user_mobile FROM fw_reservation r WHERE r.uid=".$user_info['id'];
		// // echo $sql;
		// $record = M('reservation')->query($sql);
		// // dump($record);
		// $this->assign('record',$record);
		isLogin(U('Advance/reservation_record'));
		$this->assign('title','预约列表');
		$this->display();
	}

	//ajax加载预约信息
	public function ajax_get_reservation(){
		$user_info=session('user_info');
		if(!$user_info){
			die("请登录后重试");
		}
		$page = intval($_REQUEST['p']);
		$limit =($page*8).",8";
		
		$condition = trim($_REQUEST['qt']);
		$condition = !empty($condition) ? $condition : "全部";

		switch ($condition) {
			case '全部':
				$sql = "SELECT r.id,r.status,r.service_time,r.item,r.store_name,r.store_contact,r.store_address,r.car_owner,r.user_mobile,r.remark FROM fw_reservation r WHERE r.uid=".$user_info['id']." ORDER BY r.id DESC LIMIT ".$limit;
				break;

			case '本周':
				$maxtime = time();
				$mintime = strtotime("last monday");
				$sql = "SELECT r.id,r.status,r.service_time,r.item,r.store_name,r.store_contact,r.store_address,r.car_owner,r.user_mobile,r.remark FROM fw_reservation r WHERE r.uid=".$user_info['id']." AND (create_time > {$mintime} AND create_time < {$maxtime}) ORDER BY r.id DESC LIMIT ".$limit;
				break;

			case '本月':

				$y = date('Y');
				$m = date('m');

				$maxtime = time();
				$mintime = strtotime($y.'-'.$m.'-'.'01 00:00:00');
				// dump($mintime);
				$sql = "SELECT r.id,r.status,r.service_time,r.item,r.store_name,r.store_contact,r.store_address,r.car_owner,r.user_mobile,r.remark FROM fw_reservation r WHERE r.uid=".$user_info['id']." AND (create_time > {$mintime} AND create_time < {$maxtime}) ORDER BY r.id DESC LIMIT ".$limit;
				break;

			case '更早':

				$y = date('Y');
				$m = date('m');

				$time = strtotime($y.'-'.$m.'-'.'01 00:00:00');
				$sql = "SELECT r.id,r.status,r.service_time,r.item,r.store_name,r.store_contact,r.store_address,r.car_owner,r.user_mobile,r.remark FROM fw_reservation r WHERE r.uid=".$user_info['id']." AND create_time < {$time} ORDER BY r.id DESC LIMIT ".$limit;
				break;
			
			default:
				die("找不到合适的内容，请稍后重试");
				break;
		}

		$record = M('reservation')->query($sql);
		
		$this->assign('ajaxRecord',$record);
		echo $html=$this->fetch();
	}

	//取消预约
	public function reservation_cancel(){
		$rid = $_POST['rid'] + 0;
		$data['status'] = 1;
		$result = M('reservation')->data($data)->where('id='.$rid)->save();
		// dump($result);
		if($result){
			$this->ajaxReturn(1);
		}else{
			$this->ajaxReturn(0);
		}
	}
	public function advance_order(){		
		isLogin(U('Advance/advance_order'));
		$t=intval($_REQUEST['t'])==0?'1':intval($_REQUEST['t']);
		$this->assign('t',$t);
		$this->display();
	}

	public function ajax_get_advance_order(){
		$uid=intval(session('uid'));
		$page=$_REQUEST['p'];
		$t=intval($_REQUEST['t']);
		if($t==2){
			$where=" and fec.sn!='' and fec.confirm_time=0";
		}else if($t==3){
			$where=" and fec.sn!='' and fec.confirm_time!=0";
		}else if($t==4){
			$where=" and fw_erp_order.pay_status='0'";
		}
		$order_list = M('erp_order')->field('fw_erp_order.id,fw_erp_order.car_sn,fw_erp_order.order_sn,fw_erp_order.status,fw_erp_order.pay_status,feoi.project_name,feoi.sell_price,fw_erp_order.create_time,fec.sn,fec.confirm_time')->join('fw_erp_order_item as feoi on feoi.order_id=fw_erp_order.id')->join('fw_erp_coupon as  fec on fec.order_id=fw_erp_order.id')->where('fw_erp_order.wx_user_id='.$uid." and fw_erp_order.type='3'".$where)->limit($page*8,8)->order('id desc')->select();
		//var_dump($order_list);exit;
		foreach ($order_list as $k => $v) {			
				
				$order_list[$k]['status']=$this->get_order_status($v['confirm_time'],$v['status']);
			
			}
		$this->assign('order_list',$order_list);
		echo $html=$this->fetch();
	}

	public function get_order_status($confirm_time,$status){
		if(!$confirm_time){
			return '未消费';
		}else{
			switch ($status) {
				case '1':
				return	'施工中';
					break;
				case '2':
				return	'验收中';
				default:
				case '1':
				return	'已消费';
					break;
			}
		}
	}

	public function order_detail(){
		$id=intval($_REQUEST['id']);
		isLogin(U('Advance/order_detail',array('id'=>$id)));
		$user_info=session('user_info');
		$order_info = M('erp_order as eo')->field('eo.id,eo.total_price,eo.status,eo.create_time,eo.order_sn,eo.advance_time,fec.sn,feoi.project_name,fsl.name,fsl.address,fsl.id as sid,fec.confirm_time')->join('fw_erp_coupon as fec on eo.id=fec.order_id')->join('fw_erp_order_item as feoi on feoi.order_id=eo.id')->join('fw_supplier_location as fsl on fsl.id=eo.location_id')->where('eo.id='.$id.' and eo.wx_user_id='.intval(session('uid'))." and eo.type='3'")->find();

		//var_dump(M('erp_order as eo')->getlastsql());
		if(!$order_info){
			$this->error('不存在的工单',U('Advance/advance_order'),3);
		}

		$order_info['status']=$this->get_order_status($order_info['confirm_time'],$order_info['status']);
		$this->assign('oi',$order_info);
		$this->display();
	}

	//支付回调页面
	public function pay_back()
	{

		$order_id = intval($_REQUEST['order_id']);
		$order_sn = trim($_REQUEST['order_sn']);

		isLogin(U('User/index'));
		$uid = session('uid');
		
		$order=M("erp_order_item as eoi")->field("eo.advance_time,eo.order_sn,eo.id,eoi.project_name,eo.total_price,fec.sn")->join("fw_erp_order as eo on eoi.order_id=eo.id")->join("fw_erp_coupon as fec on fec.order_id=eo.id")->where("eo.id=".$order_id." and eo.wx_user_id=".intval(session('uid'))." and eo.type='3'")->find();
	
		if (!$order) {
			$this->error('不存在的订单');
		}
		$this->assign('order',$order);
		$this->assign("title","支付结果");
		$this->display();
	}

	public function gift_car_wash(){
		isLogin(U('Advance/gift_car_wash'));
		$user_info=session('user_info');
		$car_list=M('erp_member as em')->field('fsui.car_sn')->join('fw_shop_user_info as fsui on em.id=fsui.member_id')->where('em.mobile='.$user_info['mobile'])->select();
		$this->assign('car_list',$car_list);		
		$this->display();
	}


}
?>