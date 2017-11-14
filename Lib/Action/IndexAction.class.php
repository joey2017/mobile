<?php
class IndexAction extends BaseAction 
{
	public function index()
	{	
		
		if (session('city_uname')) {
			$_getCityInfo = M('deal_city')->field('id,name,uname')->where(array('uname'=>'nn','is_effect'=>1,'is_delete'=>0))->find();
			if ($_getCityInfo) {
				session('city_id',intval($_getCityInfo['id']));
				session('city_name',$_getCityInfo['name']);
				session('city_uname',$_getCityInfo['uname']);
				cookie('deal_city',intval($_getCityInfo['id']),array('expire'=>7*24*60*60,'path'=>'/','domain'=>'.17cct.com'));
			}
		}

		$city_id = '15';
		$time = time();

		//幻灯片
		$banner_ad = M('adv')->field('adv_url,img')->where(array('adv_id'=>34,'city_id'=>array('in','1,'.$city_id),'is_effect'=>1))->order('sort desc')->select();
		$this->assign('banner_ad',$banner_ad);

		//卡券专区 
		/*$ss_f = 'fw_deal.id,fw_deal.name,fw_deal.brief,fw_deal.current_price,fw_deal.deal_cate_id,fw_deal.end_time,fw_deal.promote_price,fw_deal.origin_price,fw_deal.img';
		$ss_w['fw_deal.is_shop'] = 2 ;
		//$ss_w['fw_deal.brand_promote'] = 1 ;
		$ss_w['fw_deal.is_recommend'] = 1 ;
		$ss_w['fw_deal.is_effect'] = 1 ;
		$ss_w['fw_deal.is_delete'] = 0 ;
		$ss_w['fw_deal.id'] = array('in',('5648,5649,5650,2330'));
		//$ss_w['fw_deal.begin_time'] = array('lt',$time); 
		//$ss_w['fw_deal.end_time'] = array('gt',$time);
		$ss_w['fw_deal.city_id'] = $city_id; 
		$ss_w['fsl.is_effect'] = 1;

		$specialsale_services =  M('deal')->join('fw_supplier_location as fsl ON fsl.id = fw_deal.location_id')->field($ss_f)->where($ss_w)->limit(4)->order('fw_deal.sort desc,fw_deal.create_time desc')->select();
		foreach ($specialsale_services as $k => $v) {
			if (empty($v['img'])) {
				$specialsale_services[$k]['img'] = M('deal_cate_type')->getFieldById($v['deal_cate_id'],'img');
			}
		}
		$this->assign('specialsale_services',$specialsale_services);*/

		
		//E卡专区
		$card=M('shop_card')->field('fw_shop_card.*,fs.preview')->join('fw_supplier as fs on fs.id=fw_shop_card.supplier_id')->where('fw_shop_card.is_effect=1 and fs.city_id='.$city_id)->limit(2)->order('fw_shop_card.sort desc')->select();	

		//判断活动促销
		foreach ($card as $k => $v) {			
			if($v['promotion_time_start']<=time()&&$v['promotion_time_end']>=time()){
				$card[$k]['is_promotion']=1;
			}
		}
		$this->assign('card',$card);
		//优质门店（推荐门店）
		/*$gs_w['is_recommend'] = 1 ;
		$gs_w['is_verify'] = 1 ;
		$gs_w['is_payment'] = 1 ;
		$gs_w['is_effect'] = 1 ;
		$gs_w['city_id'] = $city_id ;*/
		$gs_w="is_recommend=1 and is_verify=1 and is_payment=1 and is_effect=1 and city_id=".$city_id;
		if(session('uid')){
			$card_location_id=M('shop_card_order')->where('status="2" and user_id='.session('uid'))->getField('location_id');
			if($card_location_id){
				$card_where=' or ( is_effect=1 and is_payment=1 and id='.$card_location_id.' and city_id='.$city_id.')';
				//$rs_w['fw_deal.location_id']=$card_location_id;
			}
		}
		$good_stores = M('supplier_location')->field('id,name,preview')->where($gs_w.$card_where)->limit(4)->select();
		$this->assign('good_stores',$good_stores);

		//平台推荐（推荐服务）
		$rs_f = 'fw_deal.id,fw_deal.name,fw_deal.deal_cate_id,fw_deal.current_price,fw_deal.origin_price,fw_deal.promote_price,fw_deal.brand_promote,fw_deal.end_time,fw_deal.begin_time,fw_deal.img,fw_deal.brief,fw_deal.buy_count,fw_deal.transaction_count';
		$rs_w['fw_deal.is_shop'] = array('in',('0,2')) ;
		$rs_w['fw_deal.is_recommend'] = 1 ;
		$rs_w['fw_deal.is_effect'] = 1 ;
		$rs_w['fw_deal.is_delete'] = 0 ;
		$rs_w['fw_deal.erp_project_id']=array('gt',0);//只显示ERP中同步的项目/商品
		$rs_w['fw_deal.city_id'] = $city_id ;
		$rs_w['fsl.is_effect'] = 1;
		$rs_w['fsl.city_id'] = $city_id ;
		$rs_w['fw_deal.id'] = array('not in',('5649,5650,2330'));
		$recommend_services =  M('deal')->join('fw_supplier_location as fsl ON fsl.id = fw_deal.location_id')->field($rs_f)->where($rs_w)->limit(5)->order('fw_deal.sort desc,fw_deal.create_time desc')->select();
		foreach ($recommend_services as $k => $v) {
			if (empty($v['img'])) {
				$deal_cate_type_img = M('deal_cate_type')->getFieldById($v['deal_cate_id'],'img');
				$recommend_services[$k]['img'] = $deal_cate_type_img;
			}
			if (empty($v['brief'])) {
					$deal_cate_id_detail = M('deal_cate_type')->getFieldById($v['deal_cate_id'],'detail');
					$recommend_services[$k]['brief'] = empty($deal_cate_id_detail) ? '暂无简介' : $deal_cate_id_detail;
			}
			if($v['brand_promote'] == 1 && $v['begin_time'] < $time && $time < $v['end_time']){
				if($v['promote_price'] >= 0){
					$recommend_services[$k]['current_price'] = $v['promote_price'];
				}
			}
			
			$recommend_services[$k]['order_count'] = $v['buy_count'] + $v['transaction_count'];
		}

		
		$this->assign('city_name',session('city_name'));
		$this->assign('recommend_services',$recommend_services);
		$this->assign('title','诚车堂汽车网');
		$this->display();	
	}

	//联系我们
	public function contact_us()
	{
		$this->assign('title','联系我们');
		$this->display();
	}

	//推荐车友会活动
	public function club_activity()
	{
		$time =time();
		$a_f  = 'fw_circle_activity.circle_id as cid,fw_circle_activity.id,fw_circle_activity.name,fw_circle_activity.star_time,fw_circle_activity.end_time,fw_circle_activity.end_enroll_time';
		$a_f .= ',fw_circle_activity.city,fw_circle_activity.cost,fw_circle_activity.number_of_people,fw_circle_activity.enroll_num,fw_circle_activity.cover_img';
		$a_w  = 'fw_circle_activity.recommend=1 AND c.circle_status=1 AND (!(fw_circle_activity.number_of_people!=0 AND fw_circle_activity.number_of_people<=fw_circle_activity.enroll_num)) AND fw_circle_activity.end_enroll_time >='.$time;
		$a_o  = 'fw_circle_activity.sort desc,fw_circle_activity.star_time asc,fw_circle_activity.addtime desc';

		$club_activitys = M('circle_activity')->join('fw_circle as c ON c.circle_id = fw_circle_activity.circle_id')->field($a_f)->where($a_w)->limit(3)->order($a_o)->select();
		if ($club_activitys) {
			foreach ($club_activitys as $k => $v) {
				$area = getArea($v['city']);
				$club_activitys[$k]['city'] = empty($area) ? '线上' : $area['province']['name'].'-'.$area['city']['name'] ;
				$club_activitys[$k]['cost'] = empty($v['cost']) ? '免费' : $v['cost'].'元' ;
				$club_activitys[$k]['cover_img'] = getClubImgUrl($v['cover_img'],array('img',$v['cid'],'160x100'));
			}
			$count_nums =M('circle_activity')->join('fw_circle as c ON c.circle_id = fw_circle_activity.circle_id')->where($a_w)->count(0);
			$this->assign("count_nums",$count_nums);
		}

		$this->assign("club_activitys",$club_activitys);
		$this->assign('title','活动推荐');
		$this->display();
	}

	// ajax  推荐车友会活动
	public function ajaxGetClubActivity()
	{
		$page   	  =  intval($_POST['page']);    // 页数（加载次数）
		$allRows  	  =  intval($_POST['arows']);   // 评论总数
		$existRows    =  intval($_POST['erows']);	// 页面初始已经加载的行数
		$loadingRows  =  intval($_POST['lrows']);	// 加载行数

		if ( empty($page) || empty($allRows)  || empty($existRows) || empty($loadingRows)  || $allRows < 0 || $page < 0 || $existRows < 0 || $loadingRows < 0) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}

		$time =time();
		$a_f  = 'fw_circle_activity.circle_id as cid,fw_circle_activity.id,fw_circle_activity.name,fw_circle_activity.star_time,fw_circle_activity.end_time,fw_circle_activity.end_enroll_time';
		$a_f .= ',fw_circle_activity.city,fw_circle_activity.cost,fw_circle_activity.number_of_people,fw_circle_activity.enroll_num,fw_circle_activity.cover_img';
		$a_w  = 'fw_circle_activity.recommend=1 AND c.circle_status=1 AND (!(fw_circle_activity.number_of_people!=0 AND fw_circle_activity.number_of_people<=fw_circle_activity.enroll_num)) AND fw_circle_activity.end_enroll_time >='.$time;
		$a_o  = 'fw_circle_activity.sort desc,fw_circle_activity.star_time asc,fw_circle_activity.addtime desc';
		$a_l  = $existRows+($loadingRows*($page-1)).','.$loadingRows;

		$club_activitys = M('circle_activity')->join('fw_circle as c ON c.circle_id = fw_circle_activity.circle_id')->field($a_f)->where($a_w)->limit($a_l)->order($a_o)->select();
		if ($club_activitys) {
			foreach ($club_activitys as $k => $v) {
				$area = getArea($v['city']);
				$club_activitys[$k]['city'] = empty($area) ? '线上' : $area['province']['name'].'-'.$area['city']['name'] ;
				$club_activitys[$k]['cost'] = empty($v['cost']) ? '免费' : $v['cost'].'元' ;
				$club_activitys[$k]['cover_img'] = getClubImgUrl($v['cover_img'],array('img',$v['cid'],'160x100'));
				$club_activitys[$k]['star_time'] = date('Y-m-d',$v['star_time']) ;
				$club_activitys[$k]['end_time'] = date('Y-m-d',$v['end_time']) ;
				$club_activitys[$k]['url'] = U('Club/activity_detail',array('id'=>$v['id']));
			}
			$allShowRows = $existRows+$loadingRows*$page;
			if ($allShowRows >= $allRows) {
				$this->ajaxReturn($club_activitys,"加载成功",2);
			} else {
				$this->ajaxReturn($club_activitys,"加载成功",1);
			}
		}else{
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		} 
	}

	//礼品兑换
	public function exchange()
	{
		// isLogin(U('Index/exchange'));

		// $uid = intval(session('uid'));
	    $t = intval($_GET['t']);
		$t = in_array($t, array(1,2)) ? $t : 1 ;//$t 1.积分 2.车堂币
		$field = 'id,thumb,name,count,score,point';
		$where = 'is_exchange=1 and ( valid_time>now() and valid_time!=0 or valid_time=0 ) and count>0';
		if ($t == 1) {
			$where .=' and score=0 and point!=0';
			$sql = 'select '.$field .' from fw_exchange_goods where '.$where.' order by point asc limit 8';		
			$sql_count = 'select count(0) as ex_count from fw_exchange_goods where '.$where; 
		}elseif ($t == 2) {
			$where .=' and score!=0 and point=0';
			$sql = 'select '.$field .' from fw_exchange_goods where '.$where.' order by score asc limit 8';
			$sql_count = 'select count(0) as ex_count from fw_exchange_goods where '.$where; 
		}
		$Model = new Model();
		$exchange = $Model->query($sql);
		if ($exchange) {
			$count_nums = $Model->query($sql_count);
			$this->assign("count_nums",$count_nums[0]['ex_count']);
		}
		$this->assign("exchange",$exchange);
		$this->assign('t',$t);
		$this->assign('title','礼品兑换');
		$this->display();
	}

	// ajax 加载礼品兑换
	public function ajaxGetExchange()
	{
		$page   	  =  intval($_POST['page']);    // 页数（加载次数）
		$allRows  	  =  intval($_POST['arows']);   // 评论总数
		$existRows    =  intval($_POST['erows']);	// 页面初始已经加载的行数
		$loadingRows  =  intval($_POST['lrows']);	// 加载行数

		if ( empty($page) || empty($allRows)  || empty($existRows) || empty($loadingRows)  || $allRows < 0 || $page < 0 || $existRows < 0 || $loadingRows < 0) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}

		$t = intval($_GET['t']);
		$t = in_array($t, array(1,2)) ? $t : 1 ;//$t 1.积分 2.车堂币
		$field = 'id,thumb,name,count,score,point';
		$where = 'is_exchange=1 and ( valid_time>now() and valid_time!=0 or valid_time=0 ) and count>0';
		$limit  = $existRows+($loadingRows*($page-1)).','.$loadingRows;
		if ($t == 1) {
			$where .=' and score=0 and point!=0';
			$sql = 'select '.$field.' from fw_exchange_goods where '.$where.' order by point asc limit '.$limit;		
			$sql_count = 'select count(0) as ex_count from fw_exchange_goods where '.$where; 
		}elseif ($t == 2) {
			$where .=' and score!=0 and point=0';
			$sql = 'select '.$field.' from fw_exchange_goods where '.$where.' order by score asc limit '.$limit;
			$sql_count = 'select count(0) as ex_count from fw_exchange_goods where '.$where; 
		}

		$Model = new Model();
		$exchange = $Model->query($sql);

		if ($exchange) {
			foreach ($exchange as $k => $v) {
				$exchange[$k]['thumb'] = getImgUrl($v['thumb'],'middle');
			}
			$allShowRows = $existRows+$loadingRows*$page;
			if ($allShowRows >= $allRows) {
				$this->ajaxReturn($exchange,"加载成功",2);
			} else {
				$this->ajaxReturn($exchange,"加载成功",1);
			}
		}else{
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		} 
	}

	//ajax 兑换礼品
	function ajaxExchangeGift(){

		if (!isLogin(U('Index/exchange'),true)) {
			$this->ajaxReturn(0,"请先登录",0);
		}

		$gid = intval($_POST['id']);
		$gift = M('exchange_goods')->find($gid);
	
		if(empty($gift) || empty($gid)){
			$this->ajaxReturn(0,"非法操作",0);
		}
		if($gift['is_exchange'] == 0){
			$this->ajaxReturn(0,"此奖品已不能兑换,请重选",0);
		}
		if($gift['valid_time'] && $gift['valid_time']<time()){
			$this->ajaxReturn(0,"此奖品已过了兑换时间,请重选",0);
		}
		if($gift['count']<=0){
			$this->ajaxReturn(0,"此奖品库存不足,请重选",0);
		}

		$user = session('user_info');
		$user_name = empty($user['true_name']) ? $user['user_name'] : $user['true_name'];
		$score = intval($user['score'] - $gift['score']);
		$point = intval($user['point'] - $gift['point']);
		if($score < 0 || $point < 0 ){
			if($score < 0 && $point >= 0){
				$this->ajaxReturn(0,'您还差'.abs($score).'个车堂币才可兑换,重新选一个吧',0);
			}
			if($point < 0 && $score >= 0){
				$this->ajaxReturn(0,'您还差'.abs($point).'个积分才可兑换,重新选一个吧',0);
			}
			if($score < 0 && $point < 0 ){
				$this->ajaxReturn(0,'您还差'.abs($point).'个积分,和'.abs($score).'个车堂币才可兑换,重新选一个吧',0);
			}
		}
		$r1 = M('exchange_goods')->where(array('id'=>$gid))->setDec('count'); 
		if ($r1) {
			$r2 = M('user')->where(array('id'=>$user['id']))->save(array('score'=>$score,'point'=>$point));
			if ($r2) {
				$ins['name']		=  $gift['name'];
				$ins['gid']			=  $gid;
				$ins['uid']			=  $user['id'];
				$ins['location_id']	=  $gift['location_id'];
				$ins['add_time']    =  time();
				$ins['status']		=  0;
				$ins['score']		=  $gift['score'];
				$ins['point']		=  $gift['point'];
				$ins['user_name']	=  $user_name;
				$ins['mobile']		=  $user['mobile'];
				$r3 = M('exchange_record')->add($ins);
			}
		}
		session('user_info',null); 
		$user['score'] = $score;
		$user['point'] = $point;
		session('user_info',$user);

		//发送通知信息
		// $user_msg = "恭喜您成功兑换了奖品[".$gift['name']."],请联系诚车堂客服:0771-2756623领取,领取时以本兑换短信为准,请勿删除。【诚车堂】";
		$user_msg = "恭喜您成功兑换了奖品[".$gift['name']."],请联系诚车堂客服:0771-2756623领取,领取时以本兑换短信为准,请勿删除。";
		// sendPhoneSms($user['mobile'],$user_msg);
		send_sms($user['mobile'],$user_msg);

		// $admin_msg="您好! 用户".$user_name."兑换了奖品[".$gift['name']."]。用户电话:".$user['mobile']."【诚车堂】";
		$admin_msg="您好! 用户".$user_name."兑换了奖品[".$gift['name']."]。用户电话:".$user['mobile'];
		// sendPhoneSms(C('exchange_admin_mobile'),$admin_msg);
		send_sms(C('exchange_admin_mobile'),$admin_msg);

		$pm_title = '兑换奖品信息';
		$pm_content = "恭喜您成功兑换了奖品[".$gift['name']."],请联系诚车堂客服:0771-2756623领取。";
		sendCCTMsg($pm_title,$pm_content,0,$user_info['id'],time(),0,true,true);

		$this->ajaxReturn(U('User/exchange'),'恭喜您成功兑换了奖品',1);
	}

	//今日抽奖
	public function lottery()
	{
		isLogin(U('Index/lottery'));

		$this->assign('login',$login);
		$this->assign('title','今日抽奖');
		$this->display();
	}

	//ajax 抽奖
	public function ajaxDoLottery()
	{
		if (!isLogin(U('Index/lottery'),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$lid = 3;
		$u = session('user_info');
		$uid = $u['id'];

		$today_start = strtotime('today');
		$today_end = strtotime('tomorrow');
		$allow_num = M('lottery_act')->getFieldById($lid,'num'); //每天允许的次数
		if (empty($allow_num)) {
			$this->ajaxReturn(0,"非常抱歉，该抽奖活动已过期",0);
		}
		$lottery_num = M('lottery_record')->where(array('user_id'=>$uid,'addtime'=>array('between',$today_start.','.$today_end)))->count(0);
		if ($allow_num <= $lottery_num) {
			$this->ajaxReturn(0,"对不起，你今天抽奖次数已经达到限制。每天只能抽".$allow_num."次。请明天再来吧",0);
		}

		$lottery_list = M('lottery_prize')->field('id,prize_name,prize,prize_type,chance,sort')->where(array('lid'=>$lid))->order('sort asc')->select();
		$res = $this->getRand($lottery_list); //根据概率获取奖项
		//中奖记录
		$add['user_id']  = $uid ;
		$add['status']   = $res['prize_type'];
		$add['prize_id'] = $res['id'];
		$add['addtime']  = time();
		$r = M('lottery_record')->add($add);
		if ($r) {
			if ($res['prize_type'] != 0) {
				$rp = M("user") -> where(array('id'=>$uid))->setInc('point',$res['prize']);
				if ($rp) {
					//写入用户积分日记
					$uname = empty($u['true_name']) ? $u['user_name'] : $u['true_name']; 
					insertUserPointLog($uid,$uname,20,$r,$res['prize'],'抽奖');
					//重新设置session
					session('user_info',null);
					$u['point'] = M('user')->getFieldById($uid,'point');
					session('user_info',$u);
				}else{
					M('lottery_record')->where(array('id'=>$r))->delete();
					$this->ajaxReturn(0,'网络延迟，请稍后重试',0);
				}
			}
			$this->ajaxReturn($res['sort'],'',1);
		}else {
			$this->ajaxReturn(0,'网络延迟，请稍后重试',0);
		}
	}
	function getRand($proArr) { 
		//概率数组的总概率精度 
		$proSum = 0;
		foreach ($proArr as $key => $value) {
			$proSum += $value['chance'];
		}
		foreach ($proArr as $k => $v) { 
	        $randNum = mt_rand(1, $proSum); 
	        if ($randNum <= $v['chance']) { 
	            return $proArr[$k];
	        } else { 
	            $proSum -= $v['chance']; 
	        } 
	    } 
	}

	public function help()
	{
		$aid = intval($_GET['id']);
		if (empty($aid) || $aid<0 ) {
			$this->error('该文章不存在');
		}
		$article = M('article')->field('title,content')->where(array('id'=>$aid,'is_effect'=>1,'is_delete'=>0))->find();
		if ($article) {
			M('article')->where(array('id'=>$aid))->setInc('click_count');
		}else {
			$this->error('该文章不存在');
		}

		$this->assign('article',$article);
		$this->assign('title',$article['title']);
		$this->display();
	}

	//新手指南
	public function guide()
	{
		$this->assign('title','新手指南');
		$this->display();
	}


	//获取当前城市信息
	public function getCurrentCity()
	{
		$city_name = $this->_post('city_name'); 
		$city_info = M('deal_city')->field('id,name,uname')->where(array('name'=>array('like','%'.$city_name.'%'),'is_effect'=>1,'is_delete'=>0))->find();
		if (!$city_info) {
			$this->ajaxReturn(0,'该城市还为开启分站',0);
		}

		if ($city_info['id']==session('city_id')) {
			$url = '';
		}else {
			$url = DOMAIN_URL.'?city='.$city_info['uname'];
		}
		$this->ajaxReturn($city_info,$url,1);
	}
}
?>