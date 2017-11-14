<?php
   import("@.ORG.Pinyin"); 
class UserAction extends BaseAction {  

	public function index(){
		
		isLogin(U('User/index'));
		
		$uid = intval(session('uid'));	
       	
		$user=M('user')->field('fw_user.user_name,fw_user.mobile,true_name,fw_user.head_img,fw_user.head_img')->where('fw_user.id='.$uid)->find();
		$car_info=M('user')->join('fw_user_car as fwc ON fwc.user_id = fw_user.id')->join('fw_car as fc ON fc.id = fwc.brand_id')->field('fwc.car_sn,fwc.next_insurance_time,fwc.next_maintain_time,fwc.next_annually_time,fwc.brand_id,fwc.models_id,fwc.is_default,fc.name')->where('fw_user.id='.$uid.' and fwc.is_default=1')->find();
		$models_name=M('car')->where('id='.$car_info['models_id'])->getField('name');
	   
		$m=$user['mobile'];	  
		$user['mobile']=substr($m,0,4).'***'.substr($m,-3);	
		
		if($m){
				
			$order=M('erp_order')->field('status,pay_status')->where("mobile=".$m." and is_delete='0' and type in('1','2')")->select();
			
			foreach ($order as $k => $v) {
				if($v['pay_status']==0){

					if($v['status']==1){						
						$count['construction']++;//施工中订单数量
					}else if($v['status']==2){
						$count['acceptance']++;//验收中订单数量
					}else if($v['status']==3||$v['status']==4){
						$count['settlement']++;//待结算(包括结算中和挂账订单)
					}

					$count['all_count']++;//以上订单合计

				}

			}
		
		}

		$car_info['next_insurance_time']=$this->two_date_poor($car_info['next_insurance_time'],time());
		$car_info['next_maintain_time']=$this->two_date_poor($car_info['next_maintain_time'],time());
		$car_info['next_annually_time']=$this->two_date_poor($car_info['next_annually_time'],time());

		$news=M("position_data","news_",C('NEWS'))->where('posid=9 and thumb=1')->field('id,data')->order('id desc')->limit(2)->select();
	  	
		foreach($news as $k=>$v){
		    eval('$news[$k][data]='.$news[$k][data].";");	    
            $news[$k]['views']=1000+(M("hits","news_",C('NEWS'))->where('hitsid="c-1-'.$news[$k]['id'].'"')->getField('views'))*15;
		    $news[$k]['url']=U('Article/view',array('id'=>$news[$k]['id']));
		}

		$this->assign('count',$count);
		$this->assign('news',$news);
		$this->assign('user',$user);
		$this->assign('models_name',$models_name);
        $this->assign('car_info',$car_info);
		$u = session('user_info');
		$this->assign('u',$u);
		$this->assign('title','会员中心');
		$this->display();
	}

	//erp会员卡
	public function member_card(){
		isLogin(U('User/member_card'));
		$user_info=session('user_info');
		$card_list=M('erp_member_card as femc')->join('fw_erp_card_discount as fecd on fecd.card_id = femc.card_id')->join('fw_erp_card as fec on fec.id=femc.card_id')->field('femc.card_id,femc.member_card_name,femc.member_card_balance,femc.member_card_number,femc.supplier_id,fecd.cate_id,fecd.discount,fec.detail')->where("femc.mobile='".$user_info['mobile']."' and femc.status='1'")->select();
		foreach ($card_list as $k => $v) {
			
			$card[$v['card_id']]['supplier_id']=$v['supplier_id'];
			
			$card[$v['card_id']][$v['cate_id']]=round($v['discount'],2);
			$card[$v['card_id']]['member_card_name']=$v['member_card_name'];
			$card[$v['card_id']]['member_card_balance']=$v['member_card_balance'];
			$card[$v['card_id']]['member_card_number']=$v['member_card_number'];
			$card[$v['card_id']]['detail']=$v['detail'];
		}

		foreach ($card as $k => $v) {
			
			$location=M('supplier_location')->where('supplier_id='.$v['supplier_id']." and is_effect=1")->field('name')->select();
			$names='';
			foreach ($location as $k1 => $v1) {
				$names.=$v1['name'].',';
			}
			$names=substr($names,0,strlen($names)-1); 

			$card[$k]['location_name']=$names;
		}
		$card=array_values($card);
		
		$this->assign('head_img',$user_info['head_img']);
		$this->assign('card',$card);
		$this->display();
	}

	public function other(){
	
	    isLogin(U('User/index'));
		$uid = intval(session('uid'));
		$user=M('user')->field('fw_user.user_name,fw_user.mobile,fw_user.head_img,fw_user.head_img')->where('fw_user.id='.$uid)->find();
		$car_info=M('user')->join('fw_user_car as fwc ON fwc.user_id = fw_user.id')->join('fw_car as fc ON fc.id = fwc.brand_id')->field('fwc.car_sn,fwc.brand_id,fc.name')->where('fw_user.id='.$uid.' and fwc.is_default=1')->find();
		
		$m=$user['mobile'];	  
		$user['mobile']=substr($m,0,4).'***'.substr($m,-3);	  
			
		
		$this->assign('user',$user);
		$this->assign('car_info',$car_info);
		$this->display();
	}

	//我的晒单
	public function shaidan()
	{
		isLogin(U('User/shaidan'));

	    $u = session('user_info');
		$shaidans_count = M('shaidan')->where(array('uid'=>intval($u['id']),'is_show'=>1))->count(0);

		$this->assign('show_head',$u['show_head']);
		$this->assign('count',$shaidans_count);
		$this->assign('title','我的晒单');
		$this->display();
	}

	//ajax  加载晒单列表
	public function ajaxGetShaidanList()
	{
		$uid = intval(session("uid"));
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数

		if (empty($uid) || empty($lnums) || $uid < 0 || $page < 0 || $lnums < 0 ) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}

		$imgs = array();
		$onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');";
		$s_f = 'fw_shaidan.sid,fw_shaidan.title,fw_shaidan.detail,fw_shaidan.pubtime,fw_shaidan.supid,fsl.id,fsl.name';
		$s_l = ($page*$lnums).','.$lnums;
		$shaidan = M('shaidan')->join('fw_supplier_location as fsl ON fsl.id = fw_shaidan.supid')->field($s_f)->where(array('fw_shaidan.uid'=>$uid,'fw_shaidan.is_show'=>1))->limit($s_l)->order('fw_shaidan.pubtime desc')->select();
		if ($shaidan) {
			foreach ($shaidan as $k => $v) {
				$shaidan[$k]['shaidanUrl']  = U('Shaidan/view',array('id'=>$v['sid']));
				$shaidan[$k]['imgs'] = '';
				$imgs = getImageAttribute($v['detail'],'image_url');
				if (!empty($imgs)) {
					$img_count = count($imgs);
					if($img_count > 3){
						$imgs = array_slice($imgs,0,3);
					}
					$imgs_str = '';
					foreach ($imgs as $k_i => $v_i) {
						$v_i = getClubImgUrl($v_i,'160x100');
						$imgs_str .= '<a href="'.$shaidan[$k]['shaidanUrl'].'"><img src="'.$v_i.'" onerror="'.$onerror.'"></a>';
					}
					$shaidan[$k]['imgs'] = $imgs_str;
				}
				if (!empty($v['supid']) && !empty($v['id'])) {
					$shaidan[$k]['storeUrl'] = U('Store/view',array('id'=>$v['id']));
				}
				$shaidan[$k]['title']   = msubstr(strip_tags($v['title']),0,12);
				$shaidan[$k]['pubtime'] = date('m-d H:i',$v['pubtime']);
				$shaidan[$k]['detail']  = msubstr(strip_tags($v['detail']),0,50,'utf-8',false);
			}
			$this->ajaxReturn($shaidan,'加载成功',1);
		}else{
			$this->ajaxReturn($shaidan,'加载失败，请稍后重试',0);
		}
	}

	//我的车友会
	public function club()
	{
		isLogin(U('User/club'));

		$uid = intval(session("uid"));
		$c_f = 'c.circle_id as cid,c.circle_name,c.circle_img,c.circle_oil';
		$c_f .= ',c.circle_mcount,c.circle_identification_count,c.region_id,c.class_id,c.circle_status';
		$c_w = array('fw_circle_member.member_id'=>$uid);
		$club = M('circle_member')->join('fw_circle as c ON c.circle_id = fw_circle_member.circle_id')->field($c_f)->where($c_w)->find();
		if ($club) {
			$clubArea = getArea($club['region_id']);
			$club['area'] = empty($clubArea) ? '暂无' : $clubArea['province']['name'].' '.$clubArea['city']['name'] ;
			$club['car'] = M('car')->where(array('id'=>$club['class_id']))->getField('name');
			$club['car'] = empty($club['car']) ? '暂无' : $club['car'] ;
			$club['img'] = getClubImgUrl($club['circle_img'],array('img',$club['cid'],'160x100'));
		}

		$this->assign('club',$club);
		$this->assign('title','我的车友会');
		$this->display();
	}

	//我的帖子
	public function topic()
	{
		isLogin(U('User/topic'));
	 	$uid = intval(session('uid'));
		$t_w['member_id'] = $uid;
	    $t_w['is_closed'] = 0;

	    $topic_count = M('circle_theme')->where($t_w)->count(0);
	    // $existTopic = M('circle_theme')->field('circle_id')->where($t_w)->find();
	    // if ($existTopic) {
	    // 	if (ckClub($existTopic['circle_id'])) {
	    // 		$topic_count = M('circle_theme')->where($t_w)->count(0);
	    // 	}else{
	    // 		$topic_count = 0;
	    // 	}
	    // }else{
	    // 	$topic_count = 0;
	    // }
		$this->assign('count',$topic_count);
		$this->assign('title','我的帖子');
		$this->display();
	}

	//ajax  加载帖子列表
	public function ajaxGetTopicList()
	{
		$uid = intval(session("uid"));
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数

		if (empty($uid) || empty($lnums) || $uid < 0 || $page < 0 || $lnums < 0 ) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}
		$imgs = array();
		$onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');";
		$t_f = 'theme_id,theme_name,theme_content,theme_addtime,theme_browsecount';
		$t_l = ($page*$lnums).','.$lnums;
		$t_o = 'theme_addtime desc';
		$topic = M('circle_theme')->field($t_f)->where(array('member_id'=>$uid,'is_closed'=>0))->limit($t_l)->order($t_o)->select();
		if ($topic) {
			foreach ($topic as $k => $v) {
				//获取文章中 前3张图片
				$topic[$k]['imgs'] = '';
				$imgs = getImageAttribute($topic[$k]['theme_content']);
				if(!empty($imgs)){
					$img_count = count($imgs);
					if($img_count > 6){
						$imgs = array_slice($imgs,0,6);
					}
					foreach ($imgs as $k_i => $v_i) {
						$imgs[$k_i] = getClubImgUrl($v_i,'160x100');
					}
					$topic[$k]['imgs'] = $imgs;
				}
				//截取摘要
				$patterns  = array ('/<p><br\/><\/p>/','/&nbsp;/','/<img[^>]*>/');
				$replace  = array ('','','[图]');
				$topic[$k]['theme_content'] = msubstr(strip_tags(preg_replace($patterns, $replace,$topic[$k]['theme_content'])),0,100,'utf-8',false);
				$topic[$k]['theme_addtime'] = date('Y-m-d',$v['theme_addtime']);
				$topic[$k]['theme_url'] = U('Club/topic_detail',array('id'=>$v['theme_id']));
			}
			$this->ajaxReturn($topic,'加载成功',1);
		}else{
			$this->ajaxReturn($topic,'加载失败，请稍后重试',0);
		}
	}

	//我的订单
	public function order()
	{   
		isLogin(U('User/order'));

		$uid = intval(session('uid'));
	    $t = intval($_GET['t']);
		$t = in_array($t, array(1,2,3,4,5)) ? $t : 1 ;//$t 1.全部订单 2.已取消订单 3未付款 4.未消费 5.已消费 
		$o_w = $this->getOrderSqlCondition($t,$uid);
		
		//订单统计
		if ($t==1 || $t==2 || $t==3) {
			$order_count = M('deal_order')->where($o_w)->count(0);
		}else {
			$o_w = array();
			$o_w['fw_deal_order.user_id'] = intval($uid);
			$o_w['fw_deal_order.type'] = 0;
			$o_w['fw_deal_order.pay_status'] = 2;

			$DealCoupon = M('deal_coupon');
			$o_g = 'fw_deal_coupon.order_id';
		
			if ($t == 4) { //未消费
				$o_w['fw_deal_coupon.confirm_time'] = 0;
				$order = $DealCoupon->join('fw_deal_order ON fw_deal_order.id = fw_deal_coupon.order_id')->field('fw_deal_order.id ')->where($o_w)->group($o_g)->select();
				$order_count = count($order);
			}elseif ($t == 5) {  //已消费 
				$o_f = 'fw_deal_order.id';
				$o_w['fw_deal_coupon.confirm_time'] = array('neq',0);
				$order = $DealCoupon->join('fw_deal_order ON fw_deal_order.id = fw_deal_coupon.order_id')->field($o_f)->where($o_w)->group($o_g)->select();
				if ($order) {
					foreach ($order as $k => $v) {
						$notConsumption = $DealCoupon->where(array('order_id'=>$v['id'],'confirm_time'=>0))->getField('id');
						if($notConsumption){
							unset($order[$k]);
						}
					}
					$order_count = count($order);
				}else {
					$order_count = 0 ;
				}
			} 
		}
		$this->assign('count',$order_count);
		$this->assign('t',$t);
		$this->assign('title','我的订单');
		$this->display();
	}

	//我的工单
	public function work_order(){
		isLogin(U('User/order'));
		$status=intval($_REQUEST['status']);

		switch ($status) {
			case 1:
				$title='施工中工单';
				break;
			case 2:
				$title='验收中工单';
				break;
			case 3:
				$title='待结算工单';
				break;
			case 4:
				$title='已结算工单';
				break;
			case 5:
				$title='已作废工单';
				break;			
			default:
				$title='全部工单';
				break;
		}

		$this->assign('status',$status);
		$this->assign('title',$title);
		$this->display();
	}

	public function ajax_get_work_order(){
		$user_info=session('user_info');
		$page=intval($_REQUEST['p']);
		if($page==0) $page = 1;
		$limit = (($page-1)*5).",5";

		$status=intval($_REQUEST['status']);

		if(in_array($status,array(1,2,3,4,5))){
			if($status==4){
				$w=" and fw_erp_order.status='4' and fw_erp_order.pay_status='1' and fw_erp_order.is_delete='0'";//已结算
			}else if($status==3){
				$w=" and fw_erp_order.status in('3','4') and fw_erp_order.pay_status='0' and fw_erp_order.is_delete='0'";//待结算(结算中和挂账)
			}else if($status==5){
				$w=" and fw_erp_order.is_delete='1'";//已作废
			}else{
				$w=" and fw_erp_order.status in('1','2') and fw_erp_order.pay_status='0' and fw_erp_order.is_delete='0'";//施工中和验收中
			}
		};

		$order_ids=M('erp_order')->field('fw_erp_order.id')->join('fw_erp_member as fem on fem.id=fw_erp_order.user_id')->where('fem.mobile='.$user_info['mobile']." and fw_erp_order.type in('1','2') ".$w)->limit($limit)->order('id desc')->select();

		foreach ($order_ids as $v) {
			$ids[]=$v['id'];
		}

		$ids=implode(',',$ids);

		if($ids){
			$in=" and fw_erp_order.id in (".$ids.")";

			$order_list = M('erp_order')->field('fw_erp_order.id,fw_erp_order.car_sn,fw_erp_order.order_sn,fw_erp_order.status,fw_erp_order.pay_status,feoi.project_name,feoi.sell_price,fw_erp_order.create_time,fw_erp_order.is_delete')->join('fw_erp_order_item as feoi on feoi.order_id=fw_erp_order.id')->join('fw_erp_member as fem on fem.id=fw_erp_order.user_id')->where("fem.mobile=".$user_info['mobile']." and fw_erp_order.type in('1','2') ".$w.$in)->order('id desc')->select();

			foreach ($order_list as $k => $v) {					
				$order[$v['id']]['id']=$v['id'];
				$order[$v['id']]['order_sn']=$v['order_sn'];
				$order[$v['id']]['car_sn']=$v['car_sn'];
				$order[$v['id']]['create_time']=$v['create_time'];
				if($v['is_delete']==0){
					$order[$v['id']]['status']=$this->get_work_order_status($v['pay_status'],$v['status']);
				}else{
					$order[$v['id']]['status']='已作废';
				}
				
				$order[$v['id']]['item'][]=$v;
			}
		}		
		$this->assign('order_list',$order);
		echo $html=$this->fetch();
	}

	//我的套餐
	public function package_list(){
		isLogin(U('User/package_list'));

		$this->display();
	}

	//获得套餐列表
	public function ajax_get_package_list(){

		$user_info=session('user_info');
		$page=intval($_REQUEST['p']);
		if($page==0) $page = 1;
		$limit = (($page-1)*5).",5";

		$package_order_ids=M('erp_package_order')->field('fw_erp_package_order.id')->join('fw_erp_member as em on em.id=fw_erp_package_order.member_id')->where('em.mobile = '.$user_info['mobile'])->limit($limit)->select();

		foreach ($package_order_ids as $v) {
			$ids[]=$v['id'];
		}

		$ids=implode(',',$ids);

		if($ids){
			$in=" and fw_erp_package_order.id in (".$ids.")";

			$package_list=M('erp_package_order')->field('fw_erp_package_order.id,fw_erp_package_order.package_name,fw_erp_package_order.package_detail,fw_erp_package_order.total_price,eoc.p_name,eoc.num,eoc.price,eoc.car_sn,eoc.end_time,eoc.month_limit_user,eoc.supplier_id')->join('fw_erp_old_card AS eoc ON fw_erp_package_order.id = eoc.package_order_id')->join('fw_erp_member AS em ON em.id = eoc.member_id')->where('em.mobile = '.$user_info['mobile'].' and eoc.type="5"'.$in)->order('fw_erp_package_order.id desc')->select();
			
			foreach ($package_list as $k => $v) {					
				$package[$v['id']]['package_name']=$v['package_name'];
				$package[$v['id']]['package_price']=$v['total_price'];
				$package[$v['id']]['supplier_id']=$v['supplier_id'];
				$package[$v['id']]['item'][]=$v;
			}

			foreach ($package as $k => $v) {
				$package[$k]['location_names']=$this->get_supplier_locations_list($v['supplier_id']);//适用门店

				foreach ($v['item'] as $i_k => $i_v) {
					$old_project_list=explode('|',$i_v['package_detail']);
					foreach ($old_project_list as $o_k => $o_v) {
						$old_project=explode('>',$o_v);
						if($i_v['p_name']==$old_project[0]){
							$package[$k]['item'][$i_k]['old_num']=$old_project[1];//套餐原始数量
						}
					}
				}

			}

		}

		//全返套餐查询数据 第一次查就好了
		if($page==1){
			$back=M('back_package_order')->where(' status=1 and (user_id='.intval($user_info['id']).' and location_id=0) or (mobile="'.$user_info['mobile'].'" and location_id!=0)')->order('id desc')->select();
			foreach ($back as $k => $v) {
				$back[$k]['item']=M('erp_old_card')->where("type='6'  and package_order_id=".$v['id'])->order('id asc')->select();
				if($v['location_id'])
				$back[$k]['location_name']=M('supplier_location')->where('id='.intval($v['location_id']))->getField('name');//适用门店
			}//and member_id=".intval($user_info['id'])."
			$this->assign('back_list',$back);
		}	

		$this->assign('package_list',$package);
		echo $html=$this->fetch();
	}


	//赠送项目列表
	public function give_list(){
		isLogin(U('User/gift_list'));

		$user_info=session('user_info');

		$give=M('erp_old_card as eoc')->field('eoc.p_name,eoc.num,eoc.price,fsl.id,eoc.supplier_id,name,car_sn,end_time')->join('fw_supplier_location as fsl on fsl.id=eoc.location_id')->where('eoc.mobile = '.$user_info['mobile']."  and eoc.type in('1','2','3','4') and (eoc.num>0 or eoc.num=-1)")->select();		
		foreach ($give as $k => $v) {
				$give_list[$v['id']]['location_names']=$this->get_supplier_locations_list($v['supplier_id']);//适用门店
				$give_list[$v['id']]['name']=$v['name'];
				$give_list[$v['id']]['list'][]=$v;	
			}
		$this->assign('give_list',$give_list);
		
		$this->display();
	}

	/**
	 * 获得商户门店列表
	 * @param  int $supplier_id 商户id
	 * @return 门店名称列表
	 */
	private function get_supplier_locations_list($supplier_id){
		$location_list=M('supplier_location')->field('name')->where('supplier_id='.$supplier_id.' and is_effect=1')->select();
		foreach ($location_list as $k => $v) {
			$location_names[]=$v['name'];
		}
		return implode('、',$location_names);
	}

	//获取工单状态
	public function get_work_order_status($pay_status,$status){
		switch ($status) {
			case '1':
				$status='施工中';
				break;
			case '2':
				$status='验收中';
				break;
			case '3':
				$status='结算中';
				break;
			case '4':
				if($pay_status=='1'){
					$status='已结算';
				}else{
					$status='挂账中';
				}
				break;
		}
		return $status;
	}

	public function work_order_get_means_payment($type){
		switch ($type) {
			case '0':
				$status='待结算';
				break;
			case '1':
				$status='现金';
				break;
			case '2':
				$status='刷卡';
				break;
			case '3':
				$status='会员卡';
				break;
			case '4':				
				$status='支付宝';	
				break;
			case '5':				
				$status='微信';	
				break;
			case '6':				
				$status='E卡支付';
				break;
			case '8':				
				$status='项目抵扣';
				break;
			case '9':				
				$status='优惠券';
				break;
			case '10':				
				$status='银行转帐';			
				break;
		}
		return $status;
	}

	public function work_order_detail(){
		$id=intval($_REQUEST['id']);
		isLogin(U('User/work_order_detail',array('id'=>$id)));
		$user_info=session('user_info');
		$order_info = M('erp_order')->field('fw_erp_order.id,fw_erp_order.car_sn,fw_erp_order.order_sn,fw_erp_order.status,fw_erp_order.type,fw_erp_order.pay_status,fw_erp_order.is_delete,feoi.project_name,feoi.sell_price,fw_erp_order.create_time,fw_erp_order.signature,fw_erp_order.user_name,fw_erp_order.means_of_payment,fw_erp_order.mobile,fw_erp_order.total_price,fw_erp_order.settlement_remark,fw_erp_order.location_id,feoi.sales_staff_name,feoi.construction_staff_name,feoi.check_staff_name,feoi.settlement_staff_name,fw_erp_order.upload_imgs,feoi.num')->join('fw_erp_order_item as feoi on feoi.order_id=fw_erp_order.id')->join('fw_erp_member as fem on fem.id=fw_erp_order.user_id')->where('fem.mobile='.$user_info['mobile']." and fw_erp_order.id=".$id)->select();
		if(!$order_info){
			$this->error('不存在的工单',U('User/work_order'),3);
		}
		$order['location_name']=M('supplier_location')->where('id='.$order_info[0]['location_id'])->getField('name');
		foreach ($order_info as $k => $v) {					
				$order['id']=$v['id'];
				$order['order_sn']=$v['order_sn'];
				$order['car_sn']=$v['car_sn'];
				$order['create_time']=$v['create_time'];
				$order['user_name']=$v['user_name'];
				$order['mobile']=$v['mobile'];
				$order['total_price']=$v['total_price'];
				$order['type']=$v['type'];
				$order['settlement_remark']=$v['settlement_remark'];
				$order['signature']=$v['signature'];
				$order['upload_imgs']=explode(',',$v['upload_imgs']);
				if($v['is_delete']==0){
					$order['status']=$this->get_work_order_status($v['pay_status'],$v['status']);
				}else{
					$order['status']='已作废';
				}

				if($v['status']==4){
					$order['can_see_pay']=1;
				}
				$order['item'][]=$v;
		}

		$pay_ment=M('erp_order_deal')->field('price,mean_of_payment,pay_detail')->where("order_id=".$id." and type='0'")->select();

		if($pay_ment){
			foreach ($pay_ment as $k => $v) {
				if($v['mean_of_payment']==8||$v['mean_of_payment']==9){
					$pay_ment[$k]['pay_type']=$v['pay_detail'];
				}else{
					$pay_ment[$k]['pay_type']=$this->work_order_get_means_payment($v['mean_of_payment']);
				}	
			}
			//合并相同支付方式
			foreach ($pay_ment as $k => $v) {
				$new_pay_ment[$v['pay_type']]+=$v['price'];
			}
			
		}

		//评论列表
		$comment_info=M('erp_order_comment')->where('user_id='.session('uid').' and order_id='.$id)->find();
		if($comment_info){

			for($i=1;$i<=5;$i++){
				if($i<=$comment_info['service_star']){
					$comment_info['service_star_list'].='<li>★</li>';
				}else{
					$comment_info['service_star_list'].='<li>☆</li>';
				}

				if($i<=$comment_info['technology_star']){
					$comment_info['technology_star_list'].='<li>★</li>';
				}else{
					$comment_info['technology_star_list'].='<li>☆</li>';
				}
			}

			$s_comment=explode(',',$comment_info['commend_id']);

			foreach ($s_comment as $k => $v) {
				$comment_info['comment_'.$v]=$v;
			
			}

			$this->assign('comment_info',$comment_info);
		}

		$this->assign('order_info',$order);
		$this->assign('pay_ment',$new_pay_ment);
		$this->display();
	}

	//提交工单点评
	public function ajax_work_order_comment(){		
		$data['order_id']=intval($_POST['order_id']);
		if(!$data['order_id']){
			$this->ajaxReturn(0,'参数错误',0);
		}

		$user_info=session('user_info');

		$data['service_star']=intval($_POST['service_star'])+1;
		$data['technology_star']=intval($_POST['tec_star'])+1;
		$data['commend_id']=implode(',',$_POST['s_comment']);
		$data['create_time']=time();
		$data['user_id']=session('uid');
		$data['user_name']=$user_info['true_name'];
		$r=M('erp_order_comment')->add($data);
		if($r){
			$this->ajaxReturn(1,'评论成功',1);
		}else{
			$this->ajaxReturn(0,'评论失败',0);
		}
	}


	//我的路线订单
	public function route(){
		isLogin(U('User/route'));
		$t=$_REQUEST['t']?$_REQUEST['t']:-1;
		$this->assign('t',$t);
		$this->display();
	}

	public function route_order_detail(){
		$id=intval($_REQUEST['id']);
		$uid=intval(session('uid'));
		$order=M('zjy_route_order')->field('fzr.img,fzr.brief,fw_zjy_route_order.*')->join('fw_zjy_route as fzr on fzr.id=fw_zjy_route_order.route_id')->where('fw_zjy_route_order.id='.$id." and user_id=".$uid)->find();
		if(!$order){
			$this->error('不存在的订单',U('User/index'),3);
		}

		//订单服务券信息
		if($order['status']=='2'){
			$coupon=M('zjy_coupon')->where('order_id='.$id." and user_id=".$uid)->find();
			$this->assign('coupon',$coupon);
		}

		//机构信息
		$agency=M('zjy_agency')->where('id='.intval($order['agency_id']))->find();

		$this->assign('agency',$agency);
		$this->assign('order',$order);
		$this->display(); 
	}

	//异步加载路线订单
	//0已删除，1未支付，2已支付,3已退款，4已消费
	public function ajax_get_route(){
		$page=$_REQUEST['p'];
		$where="user_id= ".intval(session('uid'));
		if(!empty($_REQUEST['t'])&&$_REQUEST['t']>0){
			$t=intval($_REQUEST['t']);	
			$where.=" and fw_zjy_route_order.status='".$t."'";
		}
		
		$route=M('zjy_route_order')->field('zr.brief,zr.market_price,zr.img,zr.adult_price,fw_zjy_route_order.*')->join('fw_zjy_route as zr on zr.id=fw_zjy_route_order.route_id')->where($where)->order('id desc')->limit($page*8,8)->select();

		foreach ($route as $k => $v) {	
			/*if($v['img'])
			$route[$k]['img']="http://image.17cct.com".$v['img']."!tiny";	*/		
			$route[$k]['pay_url']=U('Route/pay',array('id'=>$v['id']));	
		}
		$this->assign('route',$route);
		echo $html=$this->fetch();
	}

	public function ajax_del_routeorder(){
		$oid =  intval($_POST['id']);
		$t   = intval($_POST['t']);
		if (empty($oid) || $oid <= 0) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if ($t != 1 && $t != 0&& $t != 3) {
			$this->ajaxReturn(0,'参数错误',0);
		}

		/*if (!isLogin(U('User/route'),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		*/
		if($t){
			$arr=array('is_delete'=>1,'status'=>'0');
			$info='删除';	
		}else{
			$arr=array('is_delete'=>0,'status'=>'1');
			$info='重新预订';	
		}
		$r=M('zjy_route_order')->where(array('id'=>$oid,'user_id'=>session('uid')))->save($arr);
			
		if($r){
			$this->ajaxReturn(1,$info.'成功',1);
		}else{
			$this->ajaxReturn(0,$info.'失败',0);
		}	
		
		
	}

	public function recharge(){
		isLogin(U('User/recharge'));
		$this->assign('t',intval($_REQUEST['t']));
		$this->display();
	}

	public function ajax_get_recharge(){
		$page=$_REQUEST['p'];
		$t=intval($_REQUEST['t']);
		if($t==3){
			$where=" and 1=1";
			
		}else{
			$where=" and status='".$t."'";
		}
		$uid =intval(session('uid'));
		$order=M('card_order')->field('rc.img,fw_card_order.*')->join('fw_recharge_card as rc on rc.id=fw_card_order.recharge_id')->where('fw_card_order.user_id='.$uid." and fw_card_order.is_delete=0 ".$where)->limit($page*8,8)->select();
		
		foreach ($order as $k => $v) {					
			$order[$k]['img']="http://image.17cct.com".$v['img']."!tiny";
			$order[$k]['pay_url']=U('Recharge/order',array('id'=>$v['id']));	
		}
		$this->assign('order',$order);
		echo $html=$this->fetch();
	}

	public function ajaxOperateOrder(){
		$oid =  intval($_POST['id']);
		$t   = intval($_POST['t']);
		if (empty($oid) || $oid <= 0) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if ($t != 1 && $t != 0&& $t != 3) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if (!isLogin(U('User/recharge'),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		if($t==3){
			$r=M('card_order')->where(array('id'=>$oid,'user_id'=>session('uid')))->save(array('is_delete'=>1));
			$info='永久删除';		
			if($r){
				$this->ajaxReturn(1,$info.'成功',1);
			}else{
				$this->ajaxReturn(0,$info.'失败',0);
			}	
		}else{
			$type=$t?'1':'0';	
			$r=M('card_order')->where(array('id'=>$oid,'user_id'=>session('uid')))->save(array('status'=>$type));
			$info=$t?'重新预订':'删除订单';		
			if($r){
				$this->ajaxReturn(1,$info.'成功',1);
			}else{
				$this->ajaxReturn(0,$info.'失败',0);
			}	
		}
		
	}

	//ajax  加载订单列表
	public function ajaxGetOrderList()
	{
		$uid = intval(session('uid'));
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		$t = intval($_GET['t']);

		$t = in_array($t, array(1,2,3,4,5)) ? $t : 1 ;//$t 1.全部订单 2.已取消订单 3未付款 4.未消费 5.已消费 

	    if (empty($uid) || empty($lnums) ||  $uid < 0 || $page < 0 || $lnums < 0 ) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}

		$o_f = 'fw_deal_order.id,fw_deal_order.order_sn,fw_deal_order.create_time,fw_deal_order.total_price,fw_deal_order.pay_status,fw_deal_order.order_status,fw_deal_order.pay_amount,fw_deal_order.is_delete';
		$o_w = $this->getOrderSqlCondition($t,$uid);
		$o_l = ($page*$lnums).','.$lnums;
		$o_o = 'fw_deal_order.create_time desc'; 

		//订单
		if ($t==1 || $t==2 || $t==3) {
			$order = M('deal_order')->field($o_f)->where($o_w)->limit($o_l)->order($o_o)->select();
		}else{
			$o_w = array();
			$o_w['fw_deal_order.user_id'] = intval($uid);
			$o_w['fw_deal_order.type'] = 0;
			$o_w['fw_deal_order.pay_status'] = 2;

			$DealCoupon = M('deal_coupon');
			$o_g = 'fw_deal_coupon.order_id';
		
			if ($t == 4) { //未消费
				$o_w['fw_deal_coupon.confirm_time'] = 0;
				$order =$DealCoupon->join('fw_deal_order ON fw_deal_order.id = fw_deal_coupon.order_id')->field($o_f)->where($o_w)->limit($o_l)->order($o_o)->group($o_g)->select();
			}elseif ($t == 5) {  //已消费 
				$o_w['fw_deal_coupon.confirm_time'] = array('neq',0);
				$order = $DealCoupon->join('fw_deal_order ON fw_deal_order.id = fw_deal_coupon.order_id')->field($o_f)->where($o_w)->group($o_g)->select();
				if ($order) {
					foreach ($order as $k => $v) {
						$notConsumption = $DealCoupon->where(array('order_id'=>$v['id'],'confirm_time'=>0))->getField('id');
						if($notConsumption){
							unset($order[$k]);
						}
					}
					$order = array_slice($order,$page*$lnums,$lnums);
				}
			} 
		}
		if ($order) {
			$doi_f = 'd.id as did,d.brief,d.img,d.deal_cate_id,fw_deal_order_item.id as doiid,fw_deal_order_item.name as dname,fw_deal_order_item.deal_id,fw_deal_order_item.number,fw_deal_order_item.unit_price';
			foreach ($order as $k_o => $v_o) {

				// 订单状态
			    $order[$k_o]['status'] = 0; 
				if ($v_o['is_delete'] == 1) {
					$order[$k_o]['status'] = 1 ; //已取消
				}elseif ($v_o['pay_status'] != 2) {
					$order[$k_o]['status'] = 2 ; //未付款
					$order[$k_o]['pay_url'] = U('Order/pay',array('id'=>$v_o['id']));
				}elseif ($v_o['pay_status'] == 2 && $v_o['pay_amount'] >= $v_o['total_price']) {
					$order[$k_o]['status'] = 3 ; //已付款
				}

				// 订单商品，服务总数量
				$order[$k_o]['total_number'] = 0;

				//订单服务列表
				$order[$k_o]['items'] = M('deal_order_item')->join('fw_deal as d ON d.id = fw_deal_order_item.deal_id')->field($doi_f)->where(array('fw_deal_order_item.order_id'=>$v_o['id']))->select();
				if ($order[$k_o]['items']) {
					foreach ($order[$k_o]['items'] as $k_i => $v_i) {
						if (empty($v_i['img'])) {
							$order[$k_o]['items'][$k_i]['img'] = M('deal_cate_type')->getFieldById($v_i['deal_cate_id'],'img');
						}
						if (empty($v_i['brief'])) {
							$deal_cate_id_detail = M('deal_cate_type')->getFieldById($v_i['deal_cate_id'],'detail');
							$order[$k_o]['items'][$k_i]['brief'] = empty($deal_cate_id_detail) ? '暂无简介' : msubstr($deal_cate_id_detail,0,80);
						}

						$order[$k_o]['items'][$k_i]['img'] = getImgUrl($order[$k_o]['items'][$k_i]['img'],'160x100');
						$order[$k_o]['items'][$k_i]['unit_price'] =  price($v_i['unit_price']);
						//已经消费的服务券
						if ($order[$k_o]['status'] ==3 ) {
							$order[$k_o]['items'][$k_i]['used_coupons'] = M('deal_coupon')->where(array('order_id'=>$v_o['id'],'order_deal_id'=>$v_i['doiid'],'deal_id'=>$v_i['did'],'user_id'=>$uid,'confirm_time'=>array('gt',0),'confirm_account'=>array('gt',0)))->count(0);
						}else {
							$order[$k_o]['items'][$k_i]['used_coupons'] = -1;
						}
						$order[$k_o]['total_number'] += $v_i['number'];
						$order[$k_o]['items'][$k_i]['detail_url'] = U('User/order_item',array('id'=>$v_i['doiid']));
					}
				}
				$order[$k_o]['create_time'] = date('Y-m-d H:i:s',$v_o['create_time']);
				$order[$k_o]['total_price'] = price($v_o['total_price']);
			}
		    $this->ajaxReturn($order,'加载成功',1);
		}else{
			$this->ajaxReturn($order,'加载失败，请稍后重试',0);
		}
	}

	//子订单 订单详情
	public function order_item()
	{
		isLogin(U('User/order_item'));

		$uid = intval(session('uid'));
 
		$doi_id =  intval($_GET['id']);
		if (empty($doi_id) || $doi_id < 0) {
			$this->error('非法操作');
		}

		$oid_f  = 'fw_deal_order_item.order_id as do_id,fw_deal_order_item.deal_id as d_id,fw_deal_order_item.unit_price,fw_deal_order_item.number';
		$oid_f .= ',fw_deal_order_item.name,fw_deal_order_item.attr,fw_deal_order_item.attr_str,do.pay_status,do.pay_amount,do.total_price';
		
		$oid_w['do.user_id'] = $uid;
		$oid_w['fw_deal_order_item.id'] = $doi_id;

		$detail = M('deal_order_item')->join('fw_deal_order as do ON do.id=fw_deal_order_item.order_id')->field($oid_f)->where($oid_w)->find();
		if ($detail) {
			//商品、服务信息
			$detail['deal'] = M('deal')->field('img,brief,deal_cate_id,location_id')->where(array('id'=>$detail['d_id']))->find();
			if (empty($detail['deal']['img'])) {
				$detail['deal']['img'] = M('deal_cate_type')->getFieldById($detail['deal']['deal_cate_id'],'img');
			}
			if (empty($detail['deal']['brief'])) {
				$deal_cate_id_detail = M('deal_cate_type')->getFieldById($detail['deal']['deal_cate_id'],'detail');
				$detail['deal']['brief']= empty($deal_cate_id_detail) ? '暂无简介' : msubstr($deal_cate_id_detail,0,80);
			}
			//商家信息
			$detail['store'] = M('supplier_location')->field('name,address,mobile,tel')->where(array('id'=>$detail['deal']['location_id']))->find();
			$detail['store']['tel'] = empty($detail['store']['tel']) ? $detail['store']['mobile'] : $detail['store']['tel'] ;
			//服务券信息
			// if ($detail['pay_status'] == 2 && ($detail['pay_amount'] >= $detail['total_price'])) {
			if ($detail['pay_status'] == 2) {
				$dc_f = 'id,sn,begin_time,end_time,confirm_time,message_id';
				$dc_w = array('order_id'=>$detail['do_id'],'order_deal_id'=>$doi_id,'deal_id'=>$detail['d_id'],'user_id'=>$uid);
				$detail['coupon'] = M('deal_coupon')->field($dc_f)->where($dc_w)->select();
			}
		}

		$this->assign('detail',$detail);
		$this->assign('title','订单详情');
		$this->display();
	}


	//我的养护卡
	public function card()
	{
		isLogin(U('User/card'));

		$uid = intval(session('uid'));
	    $t = intval($_GET['t']);
		$t = in_array($t, array(1,2,3,4)) ? $t : 1 ;//$t 1.全部 2.已支付 3.未支付 4已取消
		
		$this->assign('t',$t);
		$this->assign('title','我的养护卡');
		$this->display();
	}

	public function ajax_get_card()
	{
		$uid = intval(session('uid'));
		$page = intval($_GET['p']);
		$lnums = 10; //每次加载的行数
		$t = intval($_GET['t']);
		$t = in_array($t, array(1,2,3,4)) ? $t : 1 ;//$t 1.全部 2.已支付 3.未支付 4已取消

	    

		$c_f = 'fw_shop_card_order.id,fw_shop_card_order.order_sn,fw_shop_card_order.create_time,fw_shop_card_order.pay_time,fw_shop_card_order.total_price,fw_shop_card_order.status,fs.preview';
		$c_f.= ',fw_shop_card_order.is_delete,fw_shop_card_order.card_name,sc.brief,sc.img,sc.type,sc.end_time';
		$c_w = $this->getCardSqlCondition($t,$uid);
		$c_l = ($page*$lnums).','.$lnums;
		$c_o = 'fw_shop_card_order.id desc'; 

		//养护卡
		$card = M('shop_card_order')->join('fw_shop_card as sc ON sc.id = fw_shop_card_order.card_id')->join('fw_supplier as fs on fs.id=sc.supplier_id')->field($c_f)->where($c_w)->limit($c_l)->order($c_o)->select();
		//var_dump($card);
		if ($card) {
			foreach ($card as $k => $v) {
				// 养护卡订单状态
			    $card[$k]['card_status'] = '0';
			    if ($v['is_delete'] == 1) {
					$card[$k]['card_status'] = 1 ; //已取消
				}
				elseif ($v['status'] == '1') {
					$card[$k]['card_status'] = 2 ; //未付款
					//$card[$k]['pay_url'] = U('Order/pay',array('id'=>$v_o['id']));
				}
				elseif ($v['status'] == '2' ) {
					$card[$k]['card_status'] = 3 ; //已付款
					if($v['end_time']){						
						$card[$k]['user_end_time']=$this->addNDays($v['pay_time'],$v['end_time']);
					}
				}

				$card[$k]['brief'] = empty($v['brief']) ? '暂无简介' : msubstr($v['brief'],0,30);
				$card[$k]['img'] = getImgUrl($v['img'],'160x100');
				$card[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
				$card[$k]['total_price'] = price($v['total_price']);
				$card[$k]['view_url'] = U('User/card_view',array('id'=>$v['id']));
				//$card[$k]['view_url'] = $card[$k]['card_status'] == 3 ? U('User/card_view',array('id'=>$v['id'])) : 'javascript:void(0);' ;	
				
			}
		   
		}
		$this->assign('card',$card);
		echo $html=$this->fetch();
	}
	public function addNDays($date,$n){
        $time=$date+$n*24*3600;
 		$date=date('Y-m-d ',$time);
       return $date;
    }
	//ajax  加载养护卡列表
	/*public function ajaxGetCardList()
	{
		$uid = intval(session('uid'));
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		$t = intval($_GET['t']);
		$t = in_array($t, array(1,2,3,4)) ? $t : 1 ;//$t 1.全部 2.已支付 3.未支付 4已取消

	    if (empty($uid) || empty($lnums) ||  $uid < 0 || $page < 0 || $lnums < 0 ) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}

		$c_f = 'fw_shop_card_order.id,fw_shop_card_order.order_sn,fw_shop_card_order.create_time,fw_shop_card_order.total_price,fw_shop_card_order.status';
		$c_f.= ',fw_shop_card_order.is_delete,fw_shop_card_order.card_name,sc.brief,sc.img,sc.type';
		$c_w = $this->getCardSqlCondition($t,$uid);
		$c_l = ($page*$lnums).','.$lnums;
		$c_o = 'fw_shop_card_order.id desc'; 

		//养护卡
		$card = M('shop_card_order')->join('fw_shop_card as sc ON sc.id = fw_shop_card_order.card_id')->field($c_f)->where($c_w)->limit($c_l)->order($c_o)->select();
		if ($card) {
			foreach ($card as $k => $v) {
				// 养护卡订单状态
			    $card[$k]['card_status'] = '0';
			    if ($v['is_delete'] == 1) {
					$card[$k]['card_status'] = 1 ; //已取消
				}
				elseif ($v['status'] == '1') {
					$card[$k]['card_status'] = 2 ; //未付款
					//$card[$k]['pay_url'] = U('Order/pay',array('id'=>$v_o['id']));
				}
				elseif ($v['status'] == '2' ) {
					$card[$k]['card_status'] = 3 ; //已付款
				}

				$card[$k]['brief'] = empty($v['brief']) ? '暂无简介' : msubstr($v['brief'],0,30);
				$card[$k]['img'] = getImgUrl($v['img'],'160x100');
				$card[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
				$card[$k]['total_price'] = price($v['total_price']);
				$card[$k]['view_url'] = U('User/card_view',array('id'=>$v['id']));
				//$card[$k]['view_url'] = $card[$k]['card_status'] == 3 ? U('User/card_view',array('id'=>$v['id'])) : 'javascript:void(0);' ;	
				
			}
		    $this->ajaxReturn($card,'加载成功',1);
		}else{
			$this->ajaxReturn($card,'加载失败，请稍后重试',0);
		}
	}*/

	//ajax 操作养护卡订单
	public function ajaxOperateCardOrder()
	{
		$coid =  intval($_POST['id']); 
		$t   = intval($_POST['t']);
		if (empty($coid) || $coid <= 0) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if ($t != 1 && $t != 2) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if (!isLogin(U('User/card'),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}

		$uid = intval(session('uid'));
		$r = M('shop_card_order')->where(array('id'=>$coid,'user_id'=>$uid))->getField('id');
		if ($r) {
			if ($t == 1) {
				$tpye = '取消';
				$d = array('is_delete'=>1);
			}else{
				$tpye = '删除';
				$d = array('status'=>'0');
			}
			M('shop_card_order')->where(array('id'=>$coid,'user_id'=>$uid))->save($d);
			$this->ajaxReturn(0,$tpye.'订单成功',1);
		}else {
			$this->ajaxReturn(0,'操作失败',0);
		}
	}

	//我的养护卡 sql 条件
	public function getCardSqlCondition($t=1,$uid)
	{	
		$c_w = array();
		$c_w['fw_shop_card_order.user_id'] = intval($uid); //$t 1.全部 2.已支付 3.未支付 4已取消
		switch ($t) {
			case 1:   //全部
				$c_w['fw_shop_card_order.status'] = array('neq','0');
				break;
			case 2:   //已支付  
				$c_w['fw_shop_card_order.status'] = '2';
				$c_w['fw_shop_card_order.is_delete'] = 0;
				break;
			case 3:   //未支付
				$c_w['fw_shop_card_order.status'] = '1';
				$c_w['fw_shop_card_order.is_delete'] = 0;
				break;
			case 4:   //已取消 
				$c_w['fw_shop_card_order.status'] = array('neq','0');
				$c_w['fw_shop_card_order.is_delete'] = 1;
				break;
			default:
				break;
		}
		return $c_w;
	}

	//我的养护卡 详情
	public function card_view()
	{
		isLogin(U('User/card_view'));
		$cid =  intval($_GET['id']);
		if (empty($cid) || $cid < 0) {
			$this->error('非法操作');
		}

		$uid =intval(session('uid'));
        
		$co_f = 'fw_shop_card_order.id as scoid,fw_shop_card_order.total_price,fw_shop_card_order.card_name,fw_shop_card_order.pay_time,sc.brief,sc.id as scid,sc.img,sc.type,sc.start_time,sc.end_time,sc.type,fw_shop_card_order.create_time,fs.preview,fs.name as strore_name';
		$co_w = array('fw_shop_card_order.id'=>$cid,'fw_shop_card_order.user_id'=>$uid,'fw_shop_card_order.status'=>'2','fw_shop_card_order.is_delete'=>0,'fw_shop_card_order.pay_time'=>array('gt',0));
		$detail = M('shop_card_order')->join('fw_shop_card as sc ON sc.id = fw_shop_card_order.card_id')->join('fw_supplier as fs on fs.id=sc.supplier_id')->field($co_f)->where($co_w)->find();
		if (empty($detail)) {
			$this->error('养护卡订单不存在');
		}

		$detail['brief'] = empty($detail['brief']) ? '暂无简介' : msubstr($detail['brief'],0,30);

		$detail['cate'] = M('shop_card_cate_link')->where(array('card_id'=>$detail['scid']))->select();
		if (empty($detail['cate'])) {
			$this->error('养护卡订单不存在');
		}

		$cate_model[1] = M('shop_cate');
		$cate_model[2] = M('deal_cate_type');

		$field = 'd.id as did,d.name as dname,l.id as lid,l.name as lname';
		$join = array('fw_deal as d ON d.id = fw_shop_card_cate_deal_link.deal_id','fw_supplier_location as l ON l.id = fw_shop_card_cate_deal_link.location_id');
		foreach ($detail['cate'] as $k => $v) {
			$detail['cate'][$k]['cate_name'] = $cate_model[$v['is_shop']]->getFieldById($v['deal_cate_type_id'],'name');
			$detail['cate'][$k]['user_count']= M('shop_card_user_record')->where(array('card_cate_lind_id'=>$v['id'],'user_id'=>$uid,'card_order_id'=>$cid))->count(0);
			if($v['number_of_user']>0){
				$detail['cate'][$k]['number_of_user']=intval($v['number_of_user'])-$detail['cate'][$k]['user_count'];//可用次数	
			}else{;
				$detail['cate'][$k]['number_of_user']=-1;//可用次数,-1为不限
			}
			
			$detail['cate'][$k]['deal'] = M('shop_card_cate_deal_link')->join($join)->field($field)->where(array('fw_shop_card_cate_deal_link.link_id'=>$v['id']))->select();
		}
		 $car_info=M('user_car')->where(array('user_id'=>$uid,'is_default'=>1))->select();
		 foreach($car_info as $k=>$v){
		   $a=$v['car_sn'];		   
		}
		$car_info1=mb_substr($a,0,1,'utf-8');
	    $car_info2=mb_substr($a,1,1,'utf-8'); 
        $car_info3=mb_substr($a,2,5,'utf-8');
        $car_in_sn=array($car_info1,$car_info2,$car_info3);		
		$this->assign('car_in_sn',$car_in_sn);
		
		$city=array('粤','浙','京','沪','川','津','渝','鄂','赣','冀','蒙','鲁','苏','辽','吉','皖','湘','黑','琼','贵','桂','云','藏','陕','甘','宁','青','豫','闽','新','晋');
		$a_z=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');	
		$this->assign('city',$city);
		$this->assign('a_z',$a_z);
		
		//时间限制
		if($detail['start_time']>time()&&$detail['start_time']){
			$detail['no_start']=1;
		}else{
			if($detail['end_time']){
				$Days=$this->two_date_poor(time(),$detail['pay_time']);					
				if($Days-$detail['end_time']>=0){
					$detail['be_overdue']=1;
				}
				$detail['end_time']=$this->addNDays($detail['pay_time'],$detail['end_time']);
			}else{
				$detail['end_time']='永久';
			}
		}	
		$this->assign('detail',$detail);
		$this->assign('title','养护卡详情');
		$this->display();
	}

	public function two_date_poor($day1,$day2){
		$Date_1=date('Y-m-d',$day1);//时间1
		$Date_2=date('Y-m-d',$day2);//时间2
		$Date_List_a1=explode("-",$Date_1);

		$Date_List_a2=explode("-",$Date_2);

		$d1=mktime(0,0,0,$Date_List_a1[1],$Date_List_a1[2],$Date_List_a1[0]);

		$d2=mktime(0,0,0,$Date_List_a2[1],$Date_List_a2[2],$Date_List_a2[0]);
		if($d1<=$d2){
			return 0;
		}
		$Days=round(($d1-$d2)/3600/24);

		return $Days;

	}

	//养护卡生成订单 发送验证码
	public function ajaxCreateCardNum(){
		if (!IS_AJAX) {
			$this->ajaxReturn(0,'非法操作',0);
		}
		$oid = intval($_POST['card_order_id']);//年卡订单id
		$cid =intval($_POST['cate_link_id']);//服务分类关系id
		$deal_id=intval($_POST['deal_id']);//服务id

		if($oid<=0||$cid<=0||$deal_id<=0) {
			$this->ajaxReturn(0,'非法操作',0);
		}

		if (!isLogin(U('User/card_view'),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$uid = intval(session('uid'));
        
		//验证是本人的，已付款的，未删除的年卡
		$co_f = 'fw_shop_card_order.id,fw_shop_card_order.card_id,fw_shop_card_order.car_number,sccl.number_of_user,fsc.end_time,fw_shop_card_order.pay_time,fw_shop_card_order.location_id';
		$co_w = array('fw_shop_card_order.id'=>$oid,'sccl.id'=>$cid,'fw_shop_card_order.user_id'=>$uid,'fw_shop_card_order.status'=>'2','fw_shop_card_order.is_delete'=>0,'fw_shop_card_order.pay_time'=>array('gt',0));
		$card_order = M('shop_card_order')->join('fw_shop_card as fsc on fsc.id=fw_shop_card_order.card_id')->join('fw_shop_card_cate_link as sccl ON sccl.card_id = fw_shop_card_order.card_id')->field($co_f)->where($co_w)->find();
		if(empty($card_order)) {
			$this->ajaxReturn(0,'非法操作',0);
		}

		//现在所选服务分类使用次数
		$user_count = M('shop_card_user_record')->where(array('card_cate_lind_id'=>$cid,'user_id'=>$uid,'card_order_id'=>$oid))->count(0);
		if($card_order['number_of_user']==0 && empty($card_order['car_number'])) {
			$this->ajaxReturn(0,'初次使用请绑定车牌',-1);
		}

		//查询是否之前有生成验证但未消费的
		$no_user_record = M('deal_coupon')->where(array('deal_id'=>$deal_id,'user_id'=>$uid,'is_valid'=>1,'confirm_time'=>0))->count(0);
		if($no_user_record) {
			$this->ajaxReturn(0,'您有一次服务未消费，请消费后再生成',0);
		}

		//验证所订服务是否已用完次数
		if($card_order['number_of_user']!=0 && $user_count>=intval($card_order['number_of_user'])) {
			$this->ajaxReturn(0,'次数已用完',0);
		}
		//判断年卡是否已过使用期限
		if($card_order['end_time']){
			$Days=$this->two_date_poor(time(),$card_order['pay_time']);
			if($Days-$card_order['end_time']>=0){
				$this->ajaxReturn(0,'该卡已过期',0);
			}
		}

		$deal = M('deal')->find($deal_id);
		if($card_order['number_of_user']==0){
			$order['memo'] = $card_order['car_number'];
		}

		$user_info = M('user')->field("wxid,mobile,true_name,user_name")->where(array('id'=>$uid))->find();
		$user_info['true_name'] = empty($user_info['true_name']) ? $user_info['user_name'] : $user_info['true_name'];
		$now = time();
		$order['type'] = 0; //普通订单
		$order['user_id'] = $uid;
		$order['create_time'] = $now;
		$order['means_of_payment'] ='4';//E卡支付
		$order['total_price'] = $deal['current_price'];  //当前价格总额
		$order['pay_amount'] = $deal['current_price']; //支付金额，年卡购买，直接算已支付
		$order['pay_status'] = 0;  //新单都为零， 等下面的流程同步订单状态
		$order['delivery_status'] = $deal['is_delivery']==0?5:0;  
		$order['order_status'] = 0;  //新单都为零， 等下面的流程同步订单状态
		$order['return_total_score'] = $deal['current_price'];//$deal['return_total_score'];  //结单后送的积分
		$order['return_total_money'] = $deal['current_price'];  //结单后送的现金
		$order['deal_ids']			 = $deal_id;
		$order['mobile'] = $user_info['mobile']; 
		$order['deal_total_price'] = $deal['current_price'];   //团购商品总价
		$order['ecv_money'] = 0;
		$order['account_money'] = 0;
		$order['ecv_sn'] = '';
		//更新来路
		$order['referer'] ='WX-CARD_'.$oid ;//年卡订单id		
		$order['user_name'] = trim($user_info['user_name']);
		do
		{
			$order['order_sn'] = date("Ymdhis",$now).rand(10,99);
			$order_id = M('deal_order')->add($order);
		}while($order_id==0);


		//生成订单商品
		$goods_item = array();
		$goods_item['deal_id'] = $deal['id'];
		$goods_item['number'] = 1;
		$goods_item['unit_price'] = $deal['current_price'];
		$goods_item['total_price'] = $deal['current_price'];
		$goods_item['name'] = addslashes($deal['name']);
		$goods_item['sub_name'] = addslashes($deal['sub_name']);
		$goods_item['order_id'] = $order_id;
		$deal_order_item_id = M('deal_order_item')->add($goods_item);
		
		//开始更新订单表的deal_ids
		//M('deal_order')->where(array('id'=>$order_id))->save(array('deal_ids'=>$deal_order_item_id));
		
		//写入消费记录
		$user_record['user_id']=$uid;
		$user_record['card_id']=$card_order['card_id'];
		$user_record['card_cate_lind_id']=$cid;
		$user_record['deal_id']=$deal_id;
		$user_record['user_time']=time();
		$user_record['card_order_id']=$oid;
		$user_record['deal_order_id']=$order_id;
		$user_record['location_id']=$card_order['location_id'];
		$r_record = M('shop_card_user_record')->add($user_record);
		if($r_record){	
			//改变订单状态
			order_paid($order_id); 
		
			$store = M('supplier_location')->field('name,tel,mobile,address')->where(array('id'=>$deal['location_id']))->find();
			//生成服务码
			$coupon = addCoupon($order_id,$deal_order_item_id,$uid,$deal);
			$userMsg['order_id']       = $order_id;
			$userMsg['user_true_name'] = $user_info['true_name'];
			$userMsg['user_mobile']    = $user_info['mobile'];
			$userMsg['user_wxid']      = $user_info['wxid'];
			$userMsg['deal_id']        = $deal['id'];
			$userMsg['deal_name']      = $deal['sub_name'];
			$userMsg['deal_tpye']      = $deal['is_shop'];
			// $userMsg['deal_attr']      = $v['attr_str'];
			$userMsg['coupon'] 	       = $coupon;
			$userMsg['store_tel']      = $store['tel'];
			$userMsg['store_name']     = $store['name'];
			$userMsg['store_address']  = $store['address'];

			//发短信给用户
			paySuccessSendMsg('user',$userMsg);

			//销量加 $num
			M('deal')->where(array('id'=>intval($deal['id'])))->setInc('buy_count',1);

			//发送 短信 微信
			$storeMsg['user_true_name'] = $user_info['true_name'];
			$storeMsg['user_mobile']    = $user_info['mobile'];
			$storeMsg['deal_name']   	= $deal['sub_name'];
			$storeMsg['deal_tpye'] 		= $deal['is_shop'];
			$storeMsg['store_mobile']   = $store['mobile'];
			paySuccessSendMsg('store',$storeMsg);

			$this->ajaxReturn(0,'使用成功,请注意接收验证码',1);
			
		}else{
			$this->ajaxReturn(0,'网络延时，请刷新后再试',0);
		}
	}

	public function car_number(){
		$oid=intval($_REQUEST['oid']);//订单id
		$car_number=trim($_REQUEST['number']);//车牌号码 
		if(!$oid||!$car_number){
			$d['status']=0;
			$d['icon']='warning';
			$d['msg']='非法操作';
			$this->ajaxReturn($d);
		}
       
		//验证是本人的，已付款的，未删除的
		//$card_order=$GLOBALS['db']->getRow("select id from ".DB_PREFIX."shop_card_order  where id=".$oid." and user_id=".intval($GLOBALS['user_info']['id'])." and status='2' and is_delete=0 and pay_time!=0");
		$card_order=M('shop_card_order')->where('user_id='.session('uid')." and status='2' and is_delete=0 and pay_time!=0 and id=".$oid);
		if(!$card_order){
			$this->ajaxReturn(0,'非法操作',0);
		}
		
		$user_car_b=M('user_car')->where(array('car_sn'=>$car_number,'user_id'=>session('uid')))->find();
		if(empty($user_car_b)){
		
		    $dc['car_sn']=$car_number;
			$dc['user_id']=session('uid');
			$a=M('user_car')->data($dc)->add();		
		}
		
		$d['car_number']=$car_number;
		$r=M('shop_card_order')->where('id='.$oid)->save($d);
		//$r=$GLOBALS['db']->query("update ".DB_PREFIX."shop_card_order set car_number = '".$car_number."' where id = ".$oid);
		if($r){
			$d['status']=1;
			$d['icon']='succeed';
			$d['msg']='绑定成功';
			$this->ajaxReturn($d);
		}else{
			$d['status']=0;
			$d['icon']='warning';
			$d['msg']='网络延时，请刷新后再试';
			$this->ajaxReturn($d);
			
			ajax_return($d);
		}

	}



	//用户注册
	public function regist()
	{
		if(!session('wx_return_user_info')){
			redirect(U('Index/index'));
		}

		$this->assign('title','用户注册');
		$this->display();
	}

	//ajax 用户注册
	public function ajaxRegist()
	{
		$wx_return_user_info = session('wx_return_user_info'); // openid nickname headimgurl
	
		if(!session('wx_return_user_info')||!session('return_openid')){
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
		}


		$mobile      = trim($_REQUEST['mobile']);
		$pwd = trim($_REQUEST['password1']);
		$code        = trim($_REQUEST['code']);
		$time 		 = time();
		$reg 		 = '/^[a-zA-Z0-9]+$/';

		if(empty($wx_return_user_info['openid'])&&!session('bind_opend_id')&&!session('return_openid')){
			$this->ajaxReturn(0,'未获取到微信参数，请退出重新进入注册页面',0);
		}
		if(!isMobile($mobile)){
			$this->ajaxReturn(0,'手机号码格式不正确',0);
		}
		if($code != session('reg_code')){
			$this->ajaxReturn(0,'验证码不正确',0);
		}
		if($mobile != session('check_code_mobile')){
			$this->ajaxReturn(0,'请求验证码的手机号不正确',0);
		}
		if(strlen($pwd)<6 || strlen($pwd)>16){
			$this->ajaxReturn(0,'密码长度在6-16个字符之间',0);
		}
		// if (!preg_match($reg, $pwd)) {
		// 	$this->ajaxReturn(0,"密码必须为字母或数字",0);	
		// }
		// if($pwd != $confirm_pwd){
		// 	$this->ajaxReturn(0,'两次输入密码不一样',0);
		// }	
		if(M('user')->where(array('user_name|mobile'=>$mobile))->getField('id'))
		{
			$this->ajaxReturn(0,'该手机号码已注册',0);
		}		
		if(!$wx_return_user_info['openid']){
			$wx_return_user_info['openid']=session('bind_opend_id');
		}
		$data['user_pwd']    = md5(htmlspecialchars(addslashes($pwd)));
		$data['create_time'] = $time;
		$data['update_time'] = $time;
		$data['login_time']  = $time;
		$data['login_ip']    = '移动端微信注册' ;
		$data['is_effect']   = 1;
		$data['user_name']	 = $mobile;
		$data['mobile']      = $mobile;
		$data['true_name']   = session('return_nickname')==''?' ':session('return_nickname');
		$data['head_img']    = session('return_headimgurl')==''?' ':session('return_headimgurl');
		$data['wxid']  		 = session('return_openid');
		$data['group_id']    = M("user_group")->order("score asc")->getField("id"); 

		$r_id = M("user")->add($data);
		if($r_id)
		{	
			//设置粉丝
			M("supplier_fans")->where(array('opendId'=>session('return_openid')))->save(array('userId'=>$r_id,'is_fans'=>1));

			//设置初始积分100
			M("user") -> where(array('id'=>$r_id))->save(array('point'=>array('exp','point+100')));
			//写入用户积分日记
			insertUserPointLog($r_id,session('return_nickname'),3,$r_id,100,'注册成功');
			//写入用户日记
			saveLog('user_log',array('log_info'=>'在'.date("Y-m-d H:i:s",$time).'移动端微信注册成功','log_time'=>$time,'log_user_id'=>$r_id,'point'=>100,'user_id'=>$r_id));

			//注册成功后将user_id、wxid写入erp_member表
			M("erp_member")->where(array('mobile'=>$mobile))->save(array('wxid'=>session('return_openid'),'user_id'=>$r_id));

			$referer_url = session('referer_url');
			$redirectUrl = empty($referer_url) ? U('User/index') : $referer_url ;

			$user = M("user")->find($r_id);
			$user['show_name'] = getUserName(array($user['user_name'],$user['true_name']));	
			$user['show_head'] = empty($u['head_img']) ? getUserAvatar($user['id'],'middle') : $user['head_img'] ;

			session('user_info',$user);  	//设置session
			session('uid',$id); 
			session('user_name',$user['user_name']); 
			session('reg_code',null);		//删除session
			session('bind_opend_id',null);
			session('bind_user_wxid',null);
			session('wx_return_user_info',null);

			$this->ajaxReturn($redirectUrl,"注册成功",1);
		}else {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
		} 	
	}

	//绑定微信号
	public function bind_wx()
	{
		if(!session('bind_opend_id')){
			redirect(U('Index/index'));
		}

		$wxid = session('bind_opend_id');
		session('bind_user_wxid',$wxid);
		$this->display();
	}

	//ajax 绑定微信号
	public function ajaxbindWx()
	{
		if(session('return_openid')){
			$mobile = htmlspecialchars(addslashes(trim($_REQUEST['mobile'])));
			$wxid = session('return_openid');
			$code   = trim($_REQUEST['code']);
			$time   = time();

			if(!isMobile($mobile)){
				$this->ajaxReturn(0,'手机号码格式不正确',0);
			}
			if($code != session('wx_code')){
				$this->ajaxReturn(0,'验证码不正确',0);
			}
			if($mobile != session('check_code_mobile')){
				$this->ajaxReturn(0,'请求验证码的手机号不正确',0);
			}
			$user = M('user')->where(array('mobile'=>$mobile))->find();
			if(empty($user))
			{
				$this->ajaxReturn(0,'不存在该手机号',0);
			}
			// if (!empty($user['wxid'])) {
			// 	$this->ajaxReturn(0,'该用户已绑定微信号',0);
			// }
			$r = M('user')->where(array('mobile'=>$mobile))->setField('wxid',$wxid);
			if ($r) {
				$log_msg = '在'.date("Y-m-d H:i:s",$time).'移动端绑定微信号成功';
				$referer_url = session('referer_url');
				$redirectUrl = empty($referer_url) ? U('User/index') : $referer_url ;
				$user['wxid'] = $wxid;
				$user['show_name'] = getUserName(array($user['user_name'],$user['true_name']));	
				$user['show_head'] = empty($u['head_img']) ? getUserAvatar($user['id'],'middle') : $user['head_img'] ;
				session('user_info',$user);  	//设置session
				session('uid',intval($user['id']));
				session('user_name',$user['user_name']);

				//设置粉丝
				M("supplier_fans")->where(array('opendId'=>$wxid))->save(array('userId'=>intval($user['id']),'is_fans'=>1));

				//绑定微信成功将信息写入erp_member表
				M("erp_member")->where(array('mobile'=>$mobile))->save(array('wxid'=>$wxid,'user_id'=>intval($user['id'])));
				
				//写入用户日记
				saveLog('user_log',array('log_info'=>$log_msg,'log_time'=>$time,'log_user_id'=>$user['id'],'user_id'=>$user['id']));
				session('bind_code',null);		//删除session
				session('return_openid',null);
				//session('bind_user_wxid',null);
				session('wx_return_user_info',null);
				
				$this->ajaxReturn($redirectUrl,"绑定成功",1);
			} else {
				$this->ajaxReturn(0,"网络繁忙，请稍后重试1",0);	
			}
    	}else {
    		$this->ajaxReturn(0,"网络繁忙，请稍后重试2",0);	
    	}
	}

	//绑定手机号
    public function bind_mobile(){  
	
    	if(!session('bind_mobile_user_id') && !session('change_mobile_user_id')){
    		redirect(U('Index/index'));
    	}

    	$this->assign('title','绑定手机号');
		$this->display();
	}

	//ajax 绑定手机号
	public function ajaxbindMobile()
	{
		if(session('bind_mobile_user_id') || session('change_mobile_user_id')){
			$uid = intval(session('bind_mobile_user_id'));
			$uid = empty($uid) ? intval(session('change_mobile_user_id')) : $uid ;
			$mobile      = trim($_REQUEST['mobile']);
			$code        = trim($_REQUEST['code']);
			$time 		 = time();

			if(empty($uid)){
				$this->ajaxReturn(0,'参数错误',0);
			}
			if(!isMobile($mobile)){
				$this->ajaxReturn(0,'手机号码格式不正确',0);
			}
			if($code != session('bind_code')){
				$this->ajaxReturn(0,'验证码不正确',0);
			}
			if($mobile != session('check_code_mobile')){
				$this->ajaxReturn(0,'请求验证码的手机号不正确',0);
			}

			if(M('user')->where(array('mobile'=>$mobile))->getField('id'))
			{
				$this->ajaxReturn(0,'该手机号码已被使用',0);
			}
			$mobile = htmlspecialchars(addslashes($mobile));
			$r = M('user')->where(array('id'=>$uid))->setField('mobile',$mobile);
			if ($r) {
				if (session('bind_mobile_user_id')) {   //绑定手机号 
					$log_msg = '在'.date("Y-m-d H:i:s",$time).'移动端绑定手机号成功';
					$referer_url = session('referer_url');
					$redirectUrl = empty($referer_url) ? U('User/index') : $referer_url ;
					$user = M("user")->find($uid);
					$user['show_name'] = getUserName(array($user['user_name'],$user['true_name']));	
					$user['show_head'] = empty($u['head_img']) ? getUserAvatar($user['id'],'middle') : $user['head_img'] ;
					session('user_info',$user);  	//设置session
					session('uid',$uid);
					session('user_name',$user['user_name']);  	//设置session 
					session('bind_mobile_user_id',null);

				} else {	//更换手机号 
					$log_msg = '在'.date("Y-m-d H:i:s",$time).'移动端更换手机号成功';
					$redirectUrl = U('User/account');
					$user_info = session('user_info'); //更新session
					session('user_info',null);
					$user_info['mobile'] = $mobile;
					session('user_info',$user_info);
					session('change_mobile_user_id',null);
				}
				
				//写入用户日记
				saveLog('user_log',array('log_info'=>$log_msg,'log_time'=>$time,'log_user_id'=>$uid,'user_id'=>$uid));
				session('bind_code',null);		//删除session

				$this->ajaxReturn($redirectUrl,"绑定成功",1);
			} else {
				$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
			}
    	}else {
    		$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
    	}
	}

	//验证手机号码
	public function checkMobile()
	{
		$mobile = trim($_POST['mobile']);
		$checkType   = trim($_POST['type']);
		if (!in_array($checkType, array('bind_mobile','bind_wx','regist'))) {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
		}

		if(!empty($mobile) && isMobile($mobile)){
			
    		// 注册、绑定手机号、更换手机号
    		if ($checkType == 'regist' || $checkType == 'bind_mobile') {
				
				if ($checkType == 'regist') {  //注册
					$map['user_name|mobile'] = $mobile;
					$msg = '该手机号码已被注册,亲换一个呗';
				} elseif ($checkType == 'bind_mobile') { //绑定手机号、更换手机号
					$map['mobile'] = $mobile;
					$msg = '该手机号码已被使用,亲换一个呗';
				}

				$exist = M('user')->where($map)->getField('id');
				if($exist)
				{
					$this->ajaxReturn(0,$msg,0);
				}else{
					$this->ajaxReturn(0,"恭喜您,此号码可使用",1);
				}
			//绑定微信号
			}elseif ($checkType == 'bind_wx') { 

    			$check_user = M('user')->field('id,wxid')->where(array('mobile'=>$mobile))->find();
				if(empty($check_user))
				{
					$this->ajaxReturn(0,'不存在该手机号',0);
				}else {
					$this->ajaxReturn(0,'可以绑定',1);
				}
				// elseif (!empty($check_user['wxid'])) {
				// 	$this->ajaxReturn(0,'该用户已绑定微信号',0);
				// }
			
    		}
    		$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}else{
			$this->ajaxReturn(0,"请输入正确手机号",-1);
		}
	}

	//注册发送短信
	public function sendCode()
	{
		$mobile = trim($_POST['mobile']);
		if (trim($_POST['type']) == 'chm_code') {
			$u = session('user_info');
			$mobile = ($mobile == md5('17CctWeiXin'.$u['id'].$u['mobile'])) ? $u['mobile'] : '' ;
		}
		
		//60秒内只能发送一条短信			
	    if(!check_ipop_limit(get_client_ip(),"send_code",60)){
	    	$this->ajaxReturn(0,"请1分钟后再请求",0);
	    }else{
	    	if(!empty($mobile) && isMobile($mobile)){
				/*
				* type:
				* 1.reg_code  -注册 
				* 2.bind_code -绑定手机 
				* 3.chm_code  -更换手机
				* 4.wx_code   -绑定微信号 
				* 5.pwd_code  -找回密码 
				*/
				$codeType = trim($_POST['type']);
				if (!in_array($codeType, array('reg_code','bind_code','chm_code','wx_code','pwd_code'))) {
					$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
				}
				$pattern ='1234567890';
			    for($i=0;$i<4;$i++) { 	
			        $key_code.= $pattern{mt_rand(0,9)};//生成php随机数 
			    }
			    switch ($codeType) {
			    	case 'reg_code':
			    		session('reg_code',$key_code);
			    		$func = '手机注册';
			    		break;
			    	case 'bind_code':
			    		session('bind_code',$key_code);
			    		$func = '手机绑定';
			    		break;
			    	case 'chm_code':
			    		session('chm_code',$key_code);
			    		$func = '更换手机';
			    		break;
			    	case 'wx_code':
			    		session('wx_code',$key_code);
			    		$func = '微信号绑定';
			    		break;
			    	case 'pwd_code':
			    		session('pwd_code',$key_code);
			    		$func = '找回密码';
			    		break;
			    	default:
			    		$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
			    		break;
			    }
	 			// $send_msg = "您好! 您正在诚车堂使用".$func."，验证码：".$key_code."。如非本人操作请忽略或咨询：0771-2756623【诚车堂】";
	 			$send_msg = "您好! 您正在诚车堂使用".$func."，验证码：".$key_code."。如非本人操作请忽略或咨询：0771-2756623";
			    session('check_code_mobile',$mobile); //记录手机号码	   
				// sendPhoneSms($mobile,$send_msg);
				send_sms($mobile,$send_msg);
				//$mem->set('is_send_mobile',1,0,60);
				$this->ajaxReturn(0,'验证码发送成功',1);
				
			}else{
				$this->ajaxReturn(0,"请输入正确手机号",0);
			}				
	    }		
	}

	//修改用户名
	public function modify_name()
	{
		isLogin(U('User/modify_name'));

		$u = session('user_info');
		$nickname = $u['true_name'];

		$this->assign('nickname',$nickname);
		$this->assign('title','修改用户名');
		$this->display();
	}
	// ajax 修改用户名
	public function ajaxModifyNickName()
	{
		if (!session('uid')) {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
		}
		$uid = intval(session('uid'));
		$nickname = trim($_POST['nickname']);
		$length = mb_strlen($nickname,'utf-8');
		$reg_nickname="/[ '.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/";
		
		if(empty($nickname)){
			$this->ajaxReturn(0,'昵称不能为空',0);
		}elseif(preg_match($reg_nickname, $nickname)){
			$this->ajaxReturn(0,'昵称不能含有特殊字符',0);
		}elseif($length > 12 || $length < 4){
			$this->ajaxReturn(0,'长度应为4-12个汉字或字母',0);
		}
		$nickname = htmlspecialchars(addslashes($nickname));
		$r = M('user')->where(array('id'=>$uid))->setField('true_name',$nickname);
		if ($r) {
			$user_info = session('user_info'); //更新session
			session('user_info',null);
			$user_info['true_name'] = $nickname;
			$user_info['show_name'] = getUserName(array($user['user_name'],$nickname));
			session('user_info',$user_info);
			$this->ajaxReturn(U('User/account'),"修改成功",1);
		} else {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
		}
	}

	//用户 更换手机号码
	public function change_mobile()
	{
		isLogin(U('User/change_mobile'));

		$u = session('user_info');
		$mobile = $u['mobile'];
		$mob = md5('17CctWeiXin'.$u['id'].$u['mobile']);

		$this->assign('mobile',$mobile);
		$this->assign('mob',$mob);
		$this->assign('title','更换手机号码');
		$this->display();
	}
	// ajax 用户 更换手机号码
	public function ajaxChangeMobile()
	{
		if (!session('user_info')) {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
		}

		$u 		= session('user_info');
		$mobile = trim($_REQUEST['mobile']);
		$code   = trim($_REQUEST['code']);
		$time   = time();

		if ($mobile != md5('17CctWeiXin'.$u['id'].$u['mobile'])) {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
		}
		if($code != session('chm_code')){
			$this->ajaxReturn(0,'验证码不正确',0);
		}
		if($u['mobile'] != session('check_code_mobile')){
			$this->ajaxReturn(0,'请求验证码的手机号不正确',0);
		}
		session('check_code_mobile',null);
		session('change_mobile_user_id',$u['id']);
		$this->ajaxReturn(U('User/bind_mobile'),'验证成功',1);
	}

	//修改密码 
	public function modify_password()
	{
		isLogin(U('User/modify_password'));

		$this->assign('title','修改密码');
		$this->display();
	}

	//ajax 修改密码
	public function ajaxModifyPassWord()
	{	
		if (!session('user_info')) {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
		}

		$old_pwd 	= trim($_REQUEST['old_pwd']);
		$new_pwd1   = trim($_REQUEST['new_pwd1']);
		$new_pwd2   = trim($_REQUEST['new_pwd2']);
		$reg = '/^[a-zA-Z0-9]+$/';
		$time   = time();

		if (empty($old_pwd)) {
			$this->ajaxReturn(0,"原密码不能为空",0);	
		}
		if (empty($new_pwd1)) {
			$this->ajaxReturn(0,"新密码不能为空",0);	
		}
		if (empty($new_pwd2)) {
			$this->ajaxReturn(0,"确认密码不能为空",0);	
		}
		if (strlen($new_pwd1) <6 || strlen($new_pwd1)>16) {
			$this->ajaxReturn(0,"密码长度在6-16个字符之间",0);	
		}
		if (!preg_match($reg, $new_pwd1)) {
			$this->ajaxReturn(0,"密码必须为字母或数字",0);	
		}
		if ($new_pwd1 != $new_pwd2) {
			$this->ajaxReturn(0,"两次密码不一致",0);	
		}
		$u = session('user_info');

		if ($u['user_pwd'] != md5($old_pwd)) {
			$this->ajaxReturn(0,"原密码输入错误",0);
		}
		$pwd =md5(htmlspecialchars(addslashes($new_pwd1)));
		$r = M('user')->where(array('id'=>$u['id']))->setField('user_pwd',$pwd);
		if ($r) {
			session('user_info',null);
			$u['user_pwd'] = $pwd;
			session('user_info',$u);
			$this->ajaxReturn(U('User/account'),"修改成功",1);
		} else {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
		}
	}
	public function zc(){
		isLogin(U('User/zc'));
		$this->display();
	}

	public function ajax_get_zc(){
		$page=intval($_REQUEST['p']);
		$zc_list=M('zc_payment_notice')->join('fw_zc_deal_order as fzdo on fzdo.id=fw_zc_payment_notice.order_id')->join('fw_zc_deal as fzd on fzd.id=fzdo.deal_id')->field('fzd.image,fw_zc_payment_notice.id,fzdo.deal_id,fzdo.create_time,fw_zc_payment_notice.deal_name,fzdo.order_status,fzdo.pay_time,fw_zc_payment_notice.lottery_sn')->where('fzdo.user_id='.session('uid'))->limit($page*10,10)->select();
		$this->assign('zc_list',$zc_list);
		echo $html=$this->fetch();
	}

	//我的服务券
	public function coupon()
	{
		isLogin(U('User/coupon'));

		$uid = intval(session('uid'));
		$time = time();
	    $t = intval($_GET['t']);
		$t = in_array($t, array(1,2,3)) ? $t : 1 ;//$t 1.未使用 2.已使用 3.已过期 
		if ($t == 1) {
			$c_w['confirm_time'] = 0;
			$c_w['end_time'] = array(array('eq',0),array('gt',$time),'or') ;
		}elseif ($t == 2) {
			$c_w['confirm_time'] = array('neq',0);		
		}elseif ($t == 3) {
			$c_w['confirm_time'] = 0;
			$c_w['end_time'] = array(array('neq',0),array('lt',$time),'and') ;
		}
		$c_w['user_id']   = $uid;
		$c_w['is_delete'] = 0;
		$c_w['is_valid']  = 1;
		$coupon_count = M('deal_coupon')->where($c_w)->count(0);

		$this->assign('t',$t);
		$this->assign('count',$coupon_count);
		$this->assign('title','我的服务券');
		$this->display();
	}

	//ajax 我的服务券
	public function ajaxGetCouponList()
	{
		$uid = intval(session('uid'));
		$time = time();
	    $t = intval($_GET['t']);
		$t = in_array($t, array(1,2,3)) ? $t : 1 ;//$t 1.未使用 2.已使用 3.已过期 
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		if (empty($uid) || empty($lnums) || $uid < 0 || $page < 0 || $lnums < 0 ) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}
		if ($t == 1) {
			$c_w['confirm_time'] = 0;
			$c_w['end_time'] = array(array('eq',0),array('gt',$time),'or') ;
		}elseif ($t == 2) {
			$c_w['confirm_time'] = array('neq',0);		
		}elseif ($t == 3) {
			$c_w['confirm_time'] = 0;
			$c_w['end_time'] = array(array('neq',0),array('lt',$time),'and') ;
		}
		$onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');";
		$c_w['user_id']   = $uid;
		$c_w['is_delete'] = 0;
		$c_w['is_valid']  = 1;
		$c_f = 'sn,deal_id,begin_time,end_time,confirm_time';
		$c_o = 'order_id desc';
		$c_t = ($page*$lnums).','.$lnums;
		$coupon = M('deal_coupon')->field($c_f)->where($c_w)->order($c_o)->limit($c_t)->select();
		if ($coupon) {
			foreach ($coupon as $k => $v) {
				$coupon[$k]['deal'] =  M('deal')->field('name,is_shop,deal_cate_id,img')->find($v['deal_id']);
				if (empty($coupon[$k]['deal']['img'])) {
					$coupon[$k]['deal']['img'] = M('deal_cate_type')->getFieldById($coupon[$k]['deal']['deal_cate_id'],'img');
				}
				$coupon[$k]['deal']['url']  = ($coupon[$k]['deal']['is_shop'] == 1) ?  U('Goods/view',array('id'=>$v['deal_id'])) : U('Service/view',array('id'=>$v['deal_id']));
				$coupon[$k]['deal']['img']  = '<img src="'.getImgUrl($coupon[$k]['deal']['img'],'thumbnail').'" onerror="'.$onerror.'">';
				$coupon[$k]['begin_time']   = empty($v['begin_time']) ? '' : date('Y.m.d',$v['begin_time']) ;
				$coupon[$k]['end_time']     = empty($v['end_time']) ? '' : date('Y.m.d',$v['end_time']) ;
				$coupon[$k]['confirm_time'] = empty($v['confirm_time']) ? $v['confirm_time'] : date('Y.m.d H:i:s',$v['confirm_time']) ;
			}
			$this->ajaxReturn($coupon,'加载成功',1);
		}else{
			$this->ajaxReturn($coupon,'加载失败，请稍后重试',0);
		}
	}

	//我的兑换
	public function exchange()
	{
		isLogin(U('User/exchange'));

		$uid = intval(session('uid'));
	    $t = intval($_GET['t']);
		$t = in_array($t, array(1,2,3)) ? $t : 1 ;//$t 1.全部 2.已领取 3.未领取
		if ($t == 2) {
			$e_w['status'] = '1';		
		}elseif ($t == 3) {
			$e_w['status'] = '0';
		}
		$e_w['uid']   = $uid;
		$exchange_count = M('exchange_record')->where($e_w)->count(0);

		$this->assign('t',$t);
		$this->assign('count',$exchange_count);
		$this->assign('title','我的兑换');
		$this->display();
	}

	//ajax 我的兑换
	public function ajaxGetExchangeList()
	{
		$uid = intval(session('uid'));
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		if (empty($uid) || empty($lnums) || $uid < 0 || $page < 0 || $lnums < 0 ) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}
	    $t = intval($_GET['t']);
		$t = in_array($t, array(1,2,3)) ? $t : 1 ;//$t 1.全部 2.已领取 3.未领取
		if ($t == 2) {
			$e_w['status'] = '1';		
		}elseif ($t == 3) {
			$e_w['status'] = '0';
		}
		$onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');";
		$e_w['uid']   = $uid;
		$e_f = 'gid,add_time,status';
		$e_o = 'add_time desc';
		$e_t = ($page*$lnums).','.$lnums;
		$exchange = M('exchange_record')->field($e_f)->where($e_w)->order($e_o)->limit($e_t)->select();
		if ($exchange) {
			foreach ($exchange as $k => $v) {
				$exchange[$k]['goods'] = M('exchange_goods')->field('name,thumb,score,point')->find($v['gid']);
				$exchange[$k]['goods']['thumb'] = '<img src="'.getImgUrl($exchange[$k]['goods']['thumb'],'thumbnail').'" onerror="'.$onerror.'">';
				$exchange[$k]['add_time'] = date('Y-m-d',$v['add_time']);
			}
			$this->ajaxReturn($exchange,'加载成功',1);
		}else{
			$this->ajaxReturn($exchange,'加载失败，请稍后重试',0);
		}
	}

	//我的积分
	public function point()
	{
		isLogin(U('User/point'));

		$uid = intval(session('uid'));
		$point = M('user')->getFieldById($uid,'point');
		$p_w['user_id'] = $uid ;
		$point_count = M('point_log')->where($p_w)->count(0);

		$this->assign('count',$point_count);
		$this->assign('point',$point);
		$this->assign('title','我的积分');
		$this->display();
	}

	//ajax 我的积分
	public function ajaxGetPointList()
	{
		$uid = intval(session('uid'));
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		if (empty($uid) || empty($lnums) || $uid < 0 || $page < 0 || $lnums < 0 ) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}

		$p_w['user_id'] = $uid;
		$p_f = 'point_value,point_time,point_type,point_desc';
		$p_o = 'point_id desc';
		$p_t = ($page*$lnums).','.$lnums;
		$point = M('point_log')->field($p_f)->where($p_w)->order($p_o)->limit($p_t)->select();
		if ($point) {
			foreach ($point as $k => $v) {
				if (empty($v['point_desc'])) {
					$point[$k]['point_desc'] = getPointDesc($v['point_type']);
				}
			}
			$this->ajaxReturn($point,'加载成功',1);
		}else{
			$this->ajaxReturn($point,'加载失败，请稍后重试',0);
		}
	}

	//我的消息
	public function message()
	{
		isLogin(U('User/message'));

		$uid = intval(session('uid'));
	    $t = intval($_GET['t']);
		$t = in_array($t, array(1,2)) ? $t : 1 ;//$t 1.未读 2.已读
		if ($t == 1) {
			$m_w['is_read'] = 0;			
		}elseif ($t == 2) {
			$m_w['is_read'] = 1;
		}
		$m_w['to_user_id']   = $uid ;
		$m_w['from_user_id'] = 0;
		$m_w['type']   		 = 0;
		$m_w['is_delete']    = 0;
		$message_count = M('msg_box')->where($m_w)->count(0);

		$this->assign('t',$t);
		$this->assign('count',$message_count);
		$this->assign('title','我的消息');
		$this->display();
	}

	//ajax 我的消息
	public function ajaxGetMessageList()
	{
		$uid = intval(session('uid'));
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		if (empty($uid) || empty($lnums) || $uid < 0 || $page < 0 || $lnums < 0 ) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}
	    $t = intval($_GET['t']);
		$t = in_array($t, array(1,2)) ? $t : 1 ;//$t 1.未读 2.已读
		if ($t == 1) {
			$m_w['is_read'] = 0;			
		}elseif ($t == 2) {
			$m_w['is_read'] = 1;
		}
		$onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');";

		$m_w['to_user_id']   = $uid ;
		$m_w['from_user_id'] = 0;
		$m_w['type']   		 = 0;
		$m_w['is_delete']    = 0;
		$m_f = 'title,content,create_time';
		$m_o = 'id desc';
		$m_t = ($page*$lnums).','.$lnums;

		$message = M('msg_box')->field($m_f)->where($m_w)->order($m_o)->limit($m_t)->select();
		if ($message) {
			foreach ($message as $k => $v) {
				$message[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
			}
			$this->ajaxReturn($message,'加载成功',1);
		}else{
			$this->ajaxReturn($message,'加载失败，请稍后重试',0);
		}
	}

	//ajax 获取用户各项数据的数量
	public function ajaxGetData()
	{
		$uid = intval(session('uid'));
		$time =time();
	
		$u = M('user')->field('point,score,money')->find($uid);
		$re['uc_point']    = $u['point'];
		$re['uc_score']    = $u['score'];
		$re['uc_money']    = $u['money'];
		$re['uc_coupon']   = M('deal_coupon')->where(array('user_id'=>$uid,'is_delete'=>0,'is_valid'=>1))->count(0);
		$re['uc_order']    = M('deal_order')->where(array('user_id'=>$uid,'type'=>0))->count(0);
		$re['uc_club']     = M('circle_member')->join('fw_circle as c ON c.circle_id = fw_circle_member.circle_id')->where(array('c.circle_status'=>1,'fw_circle_member.member_id'=>$uid,'fw_circle_member.cm_state'=>1))->count(0);
	    $re['uc_topic']    = M('circle_theme')->where(array('member_id'=>$uid,'is_closed'=>0))->count(0);
		$re['uc_message']  = M('msg_box')->where(array('to_user_id'=>$uid,'from_user_id'=>0,'type'=>0,'is_delete'=>0))->count(0);
		$re['uc_exchange'] = M('exchange_record')->where(array('uid'=>$uid))->count(0);
		$re['uc_shaidan']  = M('shaidan')->where(array('uid'=>$uid,'is_show'=>1))->count(0);
		$re['uc_zc']    = M('zc_deal_order')->where(array('user_id'=>$uid))->count(0);
		$re['uc_card']    = M('shop_card_order')->where(array('user_id'=>$uid))->count(0);
		$a_w  = 'fw_circle_activity.recommend=1 AND c.circle_status=1 AND (!(fw_circle_activity.number_of_people!=0 AND fw_circle_activity.number_of_people<=fw_circle_activity.enroll_num)) AND fw_circle_activity.end_enroll_time >='.$time;
		$re['uc_recommend_activity'] = M('circle_activity')->join('fw_circle as c ON c.circle_id = fw_circle_activity.circle_id')->where($a_w)->count(0);

		$this->ajaxReturn($re,'查询成功',1);
	}
	

	//退出帐号
	public function loginOut()
	{
		session(null);
		$this->redirect("Index/index","退出成功");
	}

	//帐号信息
	public function account()
	{
		isLogin(U('User/account'));

		$u = session('user_info');
		$uid = session('uid');
		$u['score'] = M('user')->getFieldById($uid,'score');
		session('user_info',null);
		session('user_info',$u);

		$safeLevelOfPwd = $this->safeLevelOfPassword($u['user_pwd']);
		$u['safe_pwd'] = $safeLevelOfPwd[0];
		$u['safe'] = $this->safeLevelOfUser($safeLevelOfPwd[1],$u['mobile']);
		
		$this->assign('u',$u);
		$this->assign('title','帐号信息');
		$this->display();
	}

	//检测用户 安全等级
	public function safeLevelOfUser($safeLevelOfPwd=0,$mobile='')
	{
		if (empty($mobile)) {
			if ($safeLevelOfPwd <= 3) {
				return '极低';
			}else {
			    return '一般';
			}
		}else{
			if ($safeLevelOfPwd <= 3) {
				return '低';
			}elseif ($safeLevelOfPwd <= 6) {
				return '一般';
			}else {
				return '高';
			}
		}
	}

	//检测用户密码 安全等级
	public function safeLevelOfPassword($str)
	{
		$str = (String)$str;
		$leve = 0;
		$return_str = '';

		if(preg_match("/[0-9]+/",$str)){
			$leve ++;
		}
		if(preg_match("/[0-9]{3,}/",$str)){
			$leve ++;
		}
		if(preg_match("/[a-z]+/",$str)){
			$leve ++;
		}
		if(preg_match("/[a-z]{3,}/",$str)){
			$leve ++;
		}
		if(preg_match("/[A-Z]+/",$str)){
			$leve ++;
		}
		if(preg_match("/[A-Z]{3,}/",$str)){
			$leve ++;
		}
		if(preg_match("/[_\-+=*!@#$%^&()]+/",$str)){
			$leve += 2;
		}
		if(preg_match("/[_\-+=*!@#$%^&()]{3,}/",$str)){
			$leve ++ ;
		}
		if(strlen($str) >= 10){
			$leve ++;
		}

		if ($leve <= 3) {
			$return_str = '弱';
		}elseif ($leve > 4 && $leve <= 6){
			$return_str = '一般';
		}elseif ($leve > 7 && $leve <= 8){
			$return_str = '强';
		}elseif ($leve >= 9){
			$return_str = '极强';
		}


		return  array($return_str,$leve);
	}

	//获取积分描述
	public function getPointDesc($type)
	{
		if (empty($type)) {
			return '暂无信息';
		}
		$type = (String)$type;
		switch ($type) {
			case '1':
				$desc="管理员操作";
				break;
			case '2':
				$desc="签到";
				break;
			case '3':
				$desc="会员注册";
				break;
			case '4':
				$desc="免费预定";
				break;
			case '6':
				$desc="个人资料完善";
				break;
			case '7':
				$desc="认证车主";
				break;
			case '9':
				$desc="创建或加入车友会";
				break;						
			case '10':
				$desc="第一次发帖";
				break;
			case '11':
				$desc="评论不同的别人帖子";
				break;
			case '12':
				$desc="发两个主题贴";
				break;
			case '13':
				$desc="设置精华贴";
				break;
			case '14':
				$desc="会员删帖";
				break;
			case '15':
				$desc="会员删评论";
				break;
			case '16':
				$desc="邀请别人注册 ";
				break;	
			case '17':
				$desc="晒单";
				break;		
			case '18':
				$desc="删除晒单";
				break;	
			default:
				$desc="暂无信息";
				break;	
		}
		return $desc;
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
		curl_setopt($gu, CURLOPT_URL, "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".C('wx_id')."&secret=".C('wx_secret')."&code=".$code."&grant_type=authorization_code");
		curl_setopt($gu, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($gu, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($gu, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($gu);
		$data = json_decode($data, true);
	  	$user = M("user")->where(array('wxid'=>$data['openid']))->find();

	  	session('bind_opend_id',$data['openid']);
	  	if (empty($user)) {
			curl_setopt($gu, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".getWxAccToken()."&openid=".$data['openid']."&lang=zh_CN");
			curl_setopt($gu,CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($gu,CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($gu,CURLOPT_SSL_VERIFYPEER, false);
			$wx_user_info = curl_exec($gu);
			$return_user_info = json_decode($wx_user_info,true);			
			curl_close($gu);

			session('return_nickname',$return_user_info['nickname']);
			session('return_openid',$return_user_info['openid']);			
			session('return_headimgurl',$return_user_info['headimgurl']);
			session('wx_return_user_info',$return_user_info);// openid nickname headimgurl	
			//redirect(U('User/regist'));
			header("Location:".U('User/regist'));
			return false;
	  	}elseif (!isMobile($user['mobile'])) {
	  		session('bind_mobile_user_id',$user['id']); 
			redirect(U('User/bind_mobile'));
	  	}else{
			$user['show_name'] = getUserName(array($user['user_name'],$user['true_name']));	
			$user['show_head'] = empty($u['head_img']) ? getUserAvatar($user['id'],'middle') : $user['head_img'] ;
			session('uid',$user['id']); 
			session('user_info',$user); 
			session('user_name',$user['user_name']);
			session('wxid',$user['wxid']);  
			M('user')->where(array('id'=>$user['id']))->save(array('login_ip'=>get_client_ip(),'login_time'=>time()));
	  	}
	  	$refererUrl = empty($refererUrl) ? session('referer_url') : $refererUrl ;
	  	header("Location:".$refererUrl);
	  	//redirect($refererUrl);
	}


	//我的订单 sql 条件
	public function getOrderSqlCondition($t=1,$uid)
	{	
		$o_w =array();
		$o_w['fw_deal_order.user_id'] = intval($uid);
		$o_w['fw_deal_order.type'] = 0;
		$o_w['fw_deal_order.is_delete'] = array('neq',2);
		switch ($t) {
			case 1:   //全部订单
				break;
			case 2:   //已取消  
				$o_w['fw_deal_order.is_delete'] = 1;
				break;
			case 3:   //未付款
				$o_w['fw_deal_order.pay_status'] = array('neq',2);
				break;
			case 4:   //未消费 
			case 5:   //已消费
				//$o_w['fw_deal_order.order_status'] = 1;
				$o_w['fw_deal_order.pay_status'] = 2;
				$o_w['fw_deal_order.pay_amount'] = array('egt','total_price');
				break;
			default:
				break;
		}
		return $o_w;
	}

	public function show()
	{
		$user_info=M('user')->field('id,head_img')->where('id='.intval($_REQUEST['id']))->find();

		$user_info['user_name']=get_user_name($user_info['id']);
		$user_info['head_img']=get_user_avatar($user_info['id'],'middle');
		$user_info['car_info']=M('car')->join('fw_user_car as fuc on fw_car.id=fuc.factory_id')->where('user_id='.$v['member_id'])->getField('name');
		$club_info = M('circle_member')->join('fw_circle as c ON c.circle_id = fw_circle_member.circle_id')->field('c.circle_id,c.circle_name,c.circle_oil,c.circle_mcount,c.circle_img,c.region_id,c.class_id,c.circle_identification_count')->where('c.circle_status=1 and fw_circle_member.cm_state=1 and fw_circle_member.member_id='.intval($_REQUEST['id']))->find();	
		if($club_info){
			//车型信息
			$club_info['car_info']=get_car_name($club_info['class_id']);
			//链接
			$club_info['url']=U('Club/club',array('id'=>$club_info['circle_id']));
			//地区信息
			$club_info['region_info']=get_circle_city($club_info['region_id']);			
			$club_info['circle_img']=get_circle_img($club_info['circle_id'],$club_info['circle_img']);
			if(substr($club_info['circle_img'],0,8)=='http://i'){
				$club_info['circle_img'].='!thumbnail';
			}
			$this->assign('club_info',$club_info);
		}
		$this->assign('user_info',$user_info);
		$this->assign('type',$_REQUEST['type']);
		//var_dump($user_info);
		$this->display();
	}

	public function ajax_get_topic()
	{
		if(!isset($_REQUEST['id']))die();
		$uid=intval($_GET['id'])>0?intval($_GET['id']):0;	
		$type=intval($_REQUEST['t']);	
		$page=$_GET['p'];
		if($type!=2){
			$result=M('circle_theme')->field('theme_id,circle_id,member_id,theme_name,theme_addtime,theme_content')->where('is_closed=0 and member_id='.$uid)->order('theme_addtime desc')->limit($page*5,5)->select();
				//截取摘要
			$patterns  = array ('/<p><br\/><\/p>/','/&nbsp;/','/<img[^>]*>/');	
			if($result){
			foreach ($result as $k => $v) {
						$result[$k]['circle_url']=U('Club/club',array('id'=>$v['circle_id']));
						$result[$k]['user_name']=get_user_name($v['member_id']);
						$result[$k]['head_img']=get_user_avatar($v['member_id'],'middle');
						$result[$k]['theme_content']=str_replace('src="/ueditor/','src="http://club.17cct.com/ueditor/',$result[$k]['theme_content']);
						//获取文章中 前9张图片
						if(preg_match_all("/<(img|IMG)(.*)(src|SRC)=[\"|'|]{0,}([h|\/].*(jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|bmp|BMP|[a-z|A-Z]\/0))[\"|'|\s]{0,}/isU",$result[$k]['theme_content'], $matches)){
							/*if($matches[2]=='image.17cct.com'){
								$matches[4]=$matches[4]."!thumbnail";
							}*/
							$img_count=count($matches[4]);
							if($img_count>4){									
								$result[$k]['img_items']=array_slice($matches[4],0,4);
							}else{
								$result[$k]['img_items']=$matches[4];
							}
							if($result[$k]['img_items']){
								foreach ($result[$k]['img_items'] as $k1 =>$v1) {
									if(substr($v1,0,8)=='http://i'){
										$result[$k]['img_items'][$k1].='!160x100';
									}									
								}
							}
							
						}
						$result[$k]['theme_content']=msubstr(strip_tags(preg_replace($patterns, $replace,$result[$k]['theme_content'])),0,50);
					}	
				$this->assign('theme',$result);
				echo $html=$this->fetch();
			}	
			echo '';
		}else{
			$activity=M('circle_activity')->field('fcae.status,fcae.id as eid,fcae.name as ename,fw_circle_activity.*')->join('fw_circle_activity_enroll as fcae on fcae.activity_id=fw_circle_activity.id')->where('fcae.member_id='.$uid)->limit($page*5,5)->select();
			
			if($activity){
					foreach ($activity as $k => $v){
		    		$activity[$k]['cover_img']=get_circle_img($v['circle_id'],$v['cover_img']);
		    		//status 活动状态 

					//0.火热报名中，1审核中，2.已报名，3.报名已结束，4.活动中，5.活动已结束
					$activity[$k]['status']='火热报名中';
					$activity[$k]['class']='warning';
					//1.审核中
					if($activity['status']==1){
						$activity[$k]['status']='审核中';
						$activity[$k]['class']='default';
					}
					//2.已报名
					if($activity['status']==3){
						$activity[$k]['status']='已报名';
						$activity[$k]['class']='default';
					}
				    //3.报名已结束
					if($v['number_of_people']!=0){
						if($v['end_enroll_time']<=time()||$v['enroll_num']>=$v['number_of_people']){
							if($activity[$k]['status']!=2) $activity[$k]['status']='报名已结束';
							$activity[$k]['class']='danger';
						}
					}else{
						if($v['end_enroll_time']<=time()){
							if($activity[$k]['status']!=2) $activity[$k]['status']='报名已结束';
							$activity[$k]['class']='danger';
						}
					}
					//4.活动中    
					if($v['star_time']<=time()&&$v['end_time']>time()){
						$activity[$k]['status']='活动中';
						$activity[$k]['class']='danger';
					}
					//5.活动已结束  
					if($v['end_time']<=time()){
						$activity[$k]['status']='活动已结束';
						$activity[$k]['class']='danger';
					}

					if($v['isonline']==1){
						$activity[$k]['type']="线上";
					}else{
						$activity[$k]['type']=get_circle_city($v['city']);
					}
		    	}
		    	$this->assign('activity',$activity);	
		    	echo $html=$this->fetch();
			}else{
				echo '';
			}
		}
	}
    //消费记录列表
	function pay_note_index(){
	  isLogin(U('User/pay_note_index'));
	  $uid = intval(session('uid'));
	  $car_sn=M('user_car')->where('user_id='.$uid.' and car_sn!=""')->select();
	  
	  $categorys=array(1=>'洗车费',2=>'维修费',3=>'保养费',4=>'加油费',5=>'通行费',6=>'违章费',7=>'停车费',8=>'保险费',9=>'车船费',10=>'年检费',11=>'钣金',12=>"精品",13=>"其它"); 
     
	  $this->assign('car_sn',$car_sn); 
   	  $this->assign('categorys',$categorys);
	  $this->display();
	
	}
	//消费记录
	function pay_note_add(){
	
	    $uid = intval(session('uid'));
		if($_POST['user_car_sn']!=''&&$_POST['price']!=''&&$_POST['cat']!=''&&$_POST['paytime']!=''){
		    
			$array_car=explode(",",$_POST['user_car_sn']);
		    $data['user_car_id']=$array_car[0];
			$data['user_car_sn']=$array_car[1];
			$data['price']=$_POST['price'];
			$data['category']=$_POST['cat'];
			$data['paytime']=strtotime($_POST['paytime']);
			$data['addtime']=time();
			$data['user_id']=$uid;
			$data['is_del']=0;
			$user_note=M('user_note')->data($data)->add();
			
			if($user_note){
			   $this->ajaxReturn(1);
			}else{
			
			  $this->ajaxReturn(0);
			}
	  }
	  
	}
	function ajax_pay_note(){
	    
	    $page=$_GET['p']*6;
	    $uid = intval(session('uid'));
		$car_sn=$_GET['car_sn'];
	    $timestart=strtotime($_GET['timestart']);
	    $timesend=strtotime($_GET['timesend']);
	    $cate=$_GET['category'];
	    $cate=preg_replace('/\\\\/',"",$cate);
		if($cate=="'0'"){
		  $where="";
		}else{
		
		 $where=" and category=".$cate;
		}
	    $sum_price=M('user_note')->where('user_id='.$uid.' and paytime>='.$timestart.' and paytime<='.$timesend.' and user_car_id='.$car_sn.$where)->sum('price');
		
       if($cate=="'0'"){
	   
          $user_note=M('user_note')->query('select paytime,category,sum(price) as price from fw_user_note where user_id='.$uid.' and paytime>='.$timestart.' and paytime<='.$timesend.' and user_car_id='.$car_sn.' group by category order by price DESC limit '.$page.',6');
	   }else{
	   
		   $user_note=M('user_note')->where('user_id='.$uid.' and category='.$cate.' and paytime>='.$timestart.' and paytime<='.$timesend.' and user_car_id='.$car_sn)->order('paytime')->limit($page,6)->select();
		  
	   }
	  
	   $categorys=array(1=>'洗车费',2=>'维修费',3=>'保养费',4=>'加油费',5=>'通行费',6=>'违章费',7=>'停车费',8=>'保险费',9=>'车船费',10=>'年检费',11=>'钣金',12=>"精品",13=>"其它"); 
	   foreach($user_note as $k=>$v){	  
		 $user_note[$k]['paytime']=date('Y-m-d',$v['paytime']);
	     $user_note[$k]['price']=round($v['price'],2); 
		 $user_note[$k]['category']=$categorys[$v['category']];
        
	   }
	   $this->assign('sum_price',$sum_price);
	   $this->assign('user_note',$user_note);
	   echo $html=$this->fetch();
	
	}
    function mycar_info(){//我的车库列表

	  isLogin(U('User/mycar_info'));
	  $uid = intval(session('uid'));
	  $mycar=M('user_car')->join('fw_car as fc on fc.id=fw_user_car.factory_id')->field('fw_user_car.id,fw_user_car.car_sn,fw_user_car.is_default,fc.name')->where('user_id='.$uid)->select();
	
	 $this->assign('mycar',$mycar);
	 $this->display();
	
	}
	function mycar_add(){ //新增车信息操作
	   
      isLogin(U('User/mycar_add'));
	 
	  $this->mycar_com();
	  $this->display();
	}
	function mycar_add_save(){//新增车信息保存
	      
          $uid = intval(session('uid'));
          
		   if($_GET['brand_id']!=''&&$_GET['car_id']!=''&&$_GET['models_id']!=''&&$_GET['areas']!=''&&$_GET['bd_bp_messNumber']!=''){
		   
		   $is_default=M('user_car')->where('user_id='.$uid.' and is_default=1')->getField('is_default');
	 
	        if(empty($is_default)){
	           $data['is_default']=1;
	        }
		   $data['user_id']=$uid;
		   $data['brand_id']=$_GET['brand_id'];
		   $data['car_id']=$_GET['car_id'];
		   $data['models_id']=$_GET['models_id'];
		   $data['car_sn']=$_GET['areas'].strtoupper($_GET['bd_bp_messNumber']);
		   $data['next_maintain_time']=strtotime($_GET['next_maintain_time']);
		   $data['next_insurance_time']=strtotime($_GET['next_insurance_time']);
		   $data['next_annually_time']=strtotime($_GET['next_annually_time']);
		   $data['last_time_mileage']=intval($_GET['last_time_mileage']);
		   $data['insurance_company']=$_GET['insurance_company'];
		   $data['insure_time']=strtotime($_GET['insure_time']);
		   
		   $user_car=M('user_car')->add($data);
		   if($user_car){
		       $this->ajaxReturn(1);
		   }else{
		   
		       $this->ajaxReturn(0);
		   }
		  }else{	  
		      $this->ajaxReturn(0);	  
		  }
		  	
	}
	function mycar_add_bc(){//ajax获取车款ID
	
	    $factory_id=intval($_GET['id']);
		$b_name=$_GET['name'];
	    if($factory_id!=0){
	       $car_bc=M('car')->where('parent_id='.$factory_id)->field('id,name,parent_id')->select();  
		   
	      $this->assign('car_bc',$car_bc);
		  $this->assign('b_name',$b_name);
		  echo $html=$this->fetch();
	    }
	
	
	}
	function mycar_add_bm(){//ajax获取车型ID
	
	    $pin=new CUtf8_PY();		
	    $factory_id=intval($_GET['id']);
	    if($factory_id!=0){
	       $car_bm=M('car')->where('parent_id='.$factory_id)->field('id,name,parent_id')->select();  
           $brand=array();
           foreach($car_bm as $k=>$v){
		     $brand[strtoupper($pin->encode(mb_substr($v['name'],0,1,'utf-8')))][]=$v;
		   }	       
		    
		    $this->assign('brand',$brand);
		    echo $html=$this->fetch();
	  }	
	}
    function mycar_del(){//我的车库删除
		   $uid = intval(session('uid'));
		   $factory_id=intval($_GET['id']);
		   $mydel=M('user_car')->where(array('user_id'=>$uid,'id'=>$factory_id))->delete();
		   if($mydel){			 
				 $this->ajaxReturn(1);
		   }else{		  
				$this->ajaxReturn(0);
		   }
		
	}
    function mycar_edit(){//我的车库编辑
		
   		  isLogin(U('User/mycar_edit'));
		  $pin=new CUtf8_PY();
		  $uid = intval(session('uid'));
		  $factory_id=intval($_GET['id']);
	   
		 $car_one=M('user_car')->join('fw_car as fc on fc.id=fw_user_car.factory_id')->field('fw_user_car.id,fw_user_car.factory_id,fw_user_car.car_sn,fw_user_car.brand_id,fw_user_car.models_id,fw_user_car.is_default,
		 fw_user_car.next_maintain_time,fw_user_car.next_insurance_time,fw_user_car.next_annually_time,fw_user_car.last_time_mileage,fw_user_car.insure_time,fw_user_car.insurance_company,fc.name,fc.parent_id')->where('fw_user_car.user_id='.$uid.' and fw_user_car.id='.$factory_id)->find();
		 		 
		 $car_brand=M('car')->where('id='.$car_one['brand_id'])->field('id,name')->find();
		 $car_m=M('car')->where('id='.$car_one['models_id'])->field('id,name')->find();
		 $car_ms=M('car')->where('parent_id='.$car_one['factory_id'])->field('id,name')->select();
		
		 $this->mycar_com();
		 
		 $modes=array();
		 foreach($car_ms as $k=>$v){
			 $modes[strtoupper($pin->encode(mb_substr($v['name'],0,1,'utf-8')))][]=$v;
		  }
		
		 $car_one['car_a']=msubstr($car_one['car_sn'],0,2,"utf-8",false);
		 $car_one['car_n']=mb_substr($car_one['car_sn'],2,5,"utf-8");
		 $bx=$car_one['insurance_company'];
				
		 $this->assign('edit_id',$factory_id);
		 $this->assign('modes',$modes);		
		 $this->assign('car_brand',$car_brand);
		 $this->assign('car_m',$car_m);
		 $this->assign('bx',$bx);
		 $this->assign('car_one',$car_one);
		 $this->display();
   }
   function mycar_edit_save(){
          
		   $uid = intval(session('uid'));
		   $id=$_GET['edit_id'];
		   $data['user_id']=$uid;
		   $data['brand_id']=$_GET['brand_id'];
		   $data['factory_id']=$_GET['factory_id'];
		   $data['models_id']=$_GET['models_id'];
		   $data['car_sn']=$_GET['areas'].strtoupper($_GET['bd_bp_messNumber']);
		   $data['next_maintain_time']=strtotime($_GET['next_maintain_time']);
		   $data['next_insurance_time']=strtotime($_GET['next_insurance_time']);
		   $data['next_annually_time']=strtotime($_GET['next_annually_time']);
		   $data['last_time_mileage']=intval($_GET['last_time_mileage']);
		   $data['insurance_company']=intval($_GET['insurance_company']);
		   $data['insure_time']=strtotime($_GET['insure_time']);
		   
		   $user_car=M('user_car')->where(array('user_id'=>$uid,'id'=>$id))->save($data);
			if($user_car){
			  $this->ajaxReturn(1);
		   
			}else{
			 
			      $this->ajaxReturn(0);
			 
			}		 
   }
   
   function mycar_per(){//当前车型修改
		  
		  $uid = intval(session('uid'));
		  $car_id=intval($_GET['id']);
		  $data['is_default']=0;
		  $car_per=M('user_car')->where(array('user_id'=>$uid,'is_default'=>1))->save($data);
		  if($car_per){
			 $data['is_default']=1;
			 $car_per=M('user_car')->where(array('user_id'=>$uid,'id'=>$car_id))->save($data);
			 if($car_per){
				echo $car_id;	
			}

		 }
   }
    function mycar_com(){
   
       $pin=new CUtf8_PY();
       $insurance_company=array('1'=>'安盛天平','2'=>'阳光车险','3'=>'平安车险','4'=>'人保车险','5'=>'太平洋车险','6'=>'大地车险','7'=>'中国太保','8'=>'国寿财险','9'=>'天安保险','10'=>'永安保险','11'=>'安邦保险','12'=>'长安保险','13'=>'民安保险','14'=>'太平保险','15'=>'国泰保险','16'=>'永诚保险','17'=>'都邦保险','18'=>'华农保险','19'=>'天平保险','20'=>'中华保险','21'=>'华泰保险','22'=>'安诚保险','23'=>'浙商保险','24'=>'紫金保险','25'=>'渤海保险','26'=>'信达保险','27'=>'泰山保险','28'=>'中银保险','29'=>'安信农业','30'=>'英大泰和','31'=>'华安保险','32'=>'大众保险','33'=>'安心保险','34'=>'人寿保险','35'=>'人寿财险','36'=>'中华联合保险','37'=>'利宝财险','38'=>'众城保险','39'=>'鼎和保险');
		
	  $prov=array('粤','浙','京','沪','川','津','渝','鄂','赣','冀','蒙','鲁','苏','辽','吉','皖','湘','黑','琼','贵','桂','云','藏','陕','甘','宁','青','豫','闽','新','晋');
	  $letter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	  $car_brands=M('car')->where('parent_id=0')->field('id,name')->select();//查询车品牌
	
	  $brands=array();
	  foreach($car_brands as $k=>$v){
	    foreach($letter as $kl=>$vl){
		   
		   $brands[strtoupper($pin->encode(msubstr($v['name'],0,1,"utf-8",false)))][$v['id']]=$v['name'];
		 }	  
	  }
	
	  $citys=array(); 
	  foreach($prov as $k=>$v){
	     foreach($letter as $kl=>$vl){
		   $citys[strtoupper($pin->encode($v))][$v][]=$v.$vl;
		  
		  }		 
	 }
     $this->assign('brands',$brands);
	 $this->assign('insurance_company',$insurance_company);
	 $this->assign('citys',$citys);
   }

}
?>