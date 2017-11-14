<?php

class ZcAction extends BaseAction {  

	public function index()
	{
		header("Location:".U("Index/index"));
		$deal_list=M('zc_deal')->where('is_effect=1  and create_time >1436371200')->limit(8)->order('create_time desc')->select();
 		$deal_ids = array();
 		$now_time=time();
		foreach($deal_list as $k=>$v)
		{
			$deal_list[$k]['remain_days'] = ceil(($v['end_time'] - $now_time)/(24*3600));
			if($v['begin_time'] > $now_time){
				$deal_list[$k]['left_days'] = intval(($now_time - $v['create_time']) / 24 / 3600);
			}
			$deal_list[$k]['num_days'] = ceil(($v['end_time'] - $v['begin_time'])/(24*3600));
			$deal_ids[] =  $v['id'];
			//查询出对应项目id的user_level
			$deal_list[$k]['deal_level']=$level_list_array[intval($deal_list[$k]['user_level'])];
			if($v['begin_time'] > $now_time){
				$deal_list[$k]['left_begin_days'] = intval(($v['begin_time']  - $now_time) / 24 / 3600);
			}
			if($v['begin_time'] > $now_time){
					$deal_list[$k]['status']= '0';                                 
			}
			elseif($v['end_time'] < $now_time && $v['end_time']>0){
				if($deal_list[$k]['percent'] >=100){
					$deal_list[$k]['status']= '1';  
				}
				else{
						$deal_list[$k]['status']= '2'; 
				}
			} 
			else{
					if ($v['end_time'] > 0) {
						$deal_list[$k]['status']= '3'; 
					}
					else
					$deal_list[$k]['status']= '4'; 
			}
		}
	
		foreach($deal_list as $k=>$v)
		{
			$deal_list[$k]['url']= U('Zc/view',array('id'=>$v['id']));
			if($v['type']==1){
				$deal_list[$k]['virtual_person']=$deal_list[$k]['invote_num'];
				$deal_list[$k]['support_count'] =$deal_list[$k]['invote_num'];
				$deal_list[$k]['support_amount'] =$deal_list[$k]['invote_money'];
				$deal_list[$k]['percent'] = round(($deal_list[$k]['support_amount'])/$v['limit_price']*100);
				$deal_list[$k]['limit_price_w']=round(($deal_list[$k]['limit_price'])/10000);
				$deal_list[$k]['invote_mini_money_w']=round(($deal_list[$k]['invote_mini_money'])/10000);
			}else{
				$deal_list[$k]['virtual_person']=$deal_list[$k]['virtual_num'];
				$deal_list[$k]['support_count'] =$deal_list[$k]['virtual_num']+$deal_list[$k]['support_count'];
				$deal_list[$k]['support_amount'] =$deal_list[$k]['virtual_price']+$deal_list[$k]['support_amount'];
				$deal_list[$k]['percent'] = round(($deal_list[$k]['support_amount'])/$v['limit_price']*100);
 			}
			 
		}
		$this->assign('deal_list',$deal_list);
		$this->display();
	}

	public function view(){
		header("Location:".U("Index/index"));
		$id = intval($_REQUEST['id']);
		
		$deal_info=M('zc_deal')->field('fw_zc_deal.*,zdl.level as deal_level,zdc.name as deal_type')->join('fw_zc_deal_level as zdl on zdl.id=fw_zc_deal.user_level')->join('fw_zc_deal_cate as zdc on zdc.id=fw_zc_deal.cate_id')->where('fw_zc_deal.id='.$id." and fw_zc_deal.is_delete=0 and fw_zc_deal.is_effect=1")->find();

 		if(!$deal_info)
		{
			header("Location:".U("Zc/index"));
			//app_redirect(url_wap("index"));
		}		
		
		if($deal_info['is_effect']==1)
		{
			//log_deal_visit($deal_info['id']);
		}		
		
		$deal_info =$this->cache_deal_extra($deal_info);
		$this->init_deal_page_wap(@$deal_info);
	
		
		$limit="0,3";
		$log_list=M('zc_deal_log')->where('deal_id='.$deal_info['id'])->order('create_time desc')->limit($limit)->select();	
		$user_ids=array();
		foreach($log_list as $k=>$v){
			if($v['user_id']){
				$user_ids[]=$v['user_id'];
			}
		}
		$user_ids=array_filter($user_ids);
		if($user_ids){
 			$user_id_str=implode(',',array_filter($user_ids));		
			$user_list_array=M('user')->where('id in('.$user_id_str.")")->select();
			foreach($user_list_array as $k=>$v){
				foreach($log_list as $k_log=>$v_log){
 					if($v['id']==$v_log['user_id']){
						$v['avatar']=getUserAvatar($v["id"],"middle");
						
						$log_list[$k_log]['user_info']=$v;
					}
				}
			}
		}
		
		$log_num=M('zc_deal_log')->where('deal_id='.$deal_info['id'])->count('deal_id');

		$this->assign("log_list",$log_list);
		$this->assign("log_num",intval($log_num));
		
		//$comment_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_comment where deal_id = ".$id." and log_id = 0 order by create_time desc limit ".$limit);
		$comment_list=M('zc_deal_comment')->where('deal_id='.$id." and log_id=0")->order('create_time desc')->limit($limit)->select();
		//$comment_count = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_comment where deal_id = ".$id." and log_id = 0");
		$comment_count=M('zc_deal_comment')->where('deal_id='.$id." and log_id=0")->count();
		$user_ids=array();
		foreach($comment_list as $k=>$v){
			if($v['user_id']){
				$user_ids[]=$v['user_id'];
			}
		}
		$user_ids=array_filter($user_ids);

		if($user_ids){
 			$user_id_str=implode(',',array_filter($user_ids));
			//$user_list_array=$GLOBALS['db']->getAll("select * from ".DB_PREFIX."user where id in (".$user_id_str.") ");
			
			$user_list_array=M('user')->where('id in('.$user_id_str.")")->select();
			foreach($user_list_array as $k=>$v){
				foreach($comment_list as $k_comment=>$v_comment){
 					if($v['id']==$v_comment['user_id']){
						//$v['avatar']=get_user_avatar_root($v["id"],"middle");
 						$comment_list[$k_comment]['user_info']=$v;
					}
				}
			}
		}

		$this->assign("info_url",U('Zc/view',array('id'=>$v['id'])));
		$this->assign("comment_list",$comment_list);
		$this->assign("comment_count",intval($comment_count));
		//$this->assign("deal_info",$deal_info);
		
		//$this->assign("usermessage_url",url_wap("ajax#usermessage",array("id"=>$deal_info['user_id'])));
		//$this->assign("home_url",url_wap("deal#home",array("id"=>$deal_info['user_id'])));


		$this->display();
	}
	function init_deal_page_wap($deal_info)
{
	$this->assign("page_title",$deal_info['name']);
	if($deal_info['seo_title']!="")
	$this->assign("seo_title",$deal_info['seo_title']);
	if($deal_info['seo_keyword']!="")
	$this->assign("seo_keyword",$deal_info['seo_keyword']);
	if($deal_info['seo_description']!="")
	$this->assign("seo_description",$deal_info['seo_description']);
	
	//开启限购后剩余几位
	$deal_info['deal_item_count']=0;
	foreach ($deal_info['deal_item_list'] as $k=>$v){
			// 统计所有真实+虚拟（钱）
			$deal_info['total_virtual_person']+= $v['virtual_person'];
			$deal_info['total_virtual_price']+=$v['price'] * $v['virtual_person']+$v['support_amount'];
 			//统计每个子项目真实+虚拟（钱）
 			$deal_info['deal_item_list'][$k]['person']=$v['virtual_person']+$v['support_count'];
 			$deal_info['deal_item_list'][$k]['money']=$v['price'] * $v['virtual_person']+$v['support_amount'];
			//$deal_info['deal_item_list'][$k]['cart_url']=url_wap("cart#index",array("id"=>$v['id']));
			if($v['limit_user']){
				$deal_info['deal_item_list'][$k]['remain_person']=$v['limit_user']-$v['virtual_person']-$v['support_count'];
			}
			$deal_info['deal_item_count']++;
		}
//	$deal_info['deal_type']=$GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_cate where id=".$deal_info['cate_id']);
	$deal_info['tags_arr'] = preg_split("/[ ,]/",$deal_info['tags']);
	
	$deal_info['support_amount_format'] = $this->number_price_format($deal_info['support_amount']);
	$deal_info['limit_price_format'] = $this->number_price_format($deal_info['limit_price']);
 	$deal_info['total_virtual_price_format']=$this->number_price_format($deal_info['total_virtual_price']);
	$deal_info['remain_days'] = ceil(($deal_info['end_time'] - time())/(24*3600));
	$deal_info['percent'] = round($deal_info['support_amount']/$deal_info['limit_price']*100);
	
	//$deal_info['deal_level']=$GLOBALS['db']->getOne("select level from ".DB_PREFIX."deal_level where id=".intval($deal_info['user_level']));
	$deal_info['person']=$deal_info['total_virtual_person']+$deal_info['support_count'];
	$deal_info['percent']=round(($deal_info['total_virtual_price']/$deal_info['limit_price'])*100);

	if($deal_info['begin_time'] > time()){
		$deal_info['status']= '0';  
		$deal_info['left_days'] = ceil(($deal_info['begin_time'] - time())/(24*3600));                               
	}
	elseif($deal_info['end_time'] < time() && $deal_info['end_time']>0){
		if($deal_info['percent'] >=100){
			$deal_info['status']= '1';  
		}
		else{
				$deal_info['status']= '2'; 
		}
	} 
	else{
			if ($deal_info['end_time'] > 0) {
				$deal_info['status']= '3'; 
			}
			else
				$deal_info['status']= '4'; 
	}

	if(!empty($deal_info['vedio'])&&!preg_match("/http://player.youku.com/embed/i",$deal_info['source_video'])){
 		$deal_info['source_vedio']= preg_replace("/id_(.*)\.html(.*)/i","http://player.youku.com/embed/\${1}",baseName($deal_info['vedio'])); 
  		//$GLOBALS['db']->query("update ".DB_PREFIX."deal set source_vedio='".$deal_info['source_vedio']."'  where id=".$deal_info['id']);
  	}
  	$deal_info['description']= str_replace("./public/","http://www.17cct.com/public/",$deal_info['description']);
  	$deal_info['image']= str_replace("./public/","http://www.17cct.com/public/",$deal_info['image']); 
  	$deal_info['image']= str_replace("/images/","http://www.17cct.com/images/",$deal_info['image']); 
  	$this->assign("deal_info",$deal_info);
}
function number_price_format($price)
{
	if($price*100%100==0)
	$price= number_format(round($price,2));
	else
	$price = number_format(round($price,2),2);
	return $price;
}

//缓存项目信息
function cache_deal_extra($deal_info)
{
	if($deal_info['deal_extra_cache']=="")
	{
		$deal_extra_cache = array();
		//$GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_faq where deal_id = ".$deal_info['id']." order by sort asc");	
		$deal_info['deal_faq_list'] = $deal_extra_cache['deal_faq_list'] =M('zc_deal_faq')->where('deal_id='.$deal_info['id'])->order('sort asc')->select();		
		$deal_info['deal_item_list'] =M('zc_deal_item')->where('deal_id='.$deal_info['id'])->order('price asc')->select();
		foreach($deal_info['deal_item_list'] as $k=>$v)
		{
			$deal_info['deal_item_list'][$k]['images'] = M('deal_item_image')->where('deal_id='.$deal_info['id']." and deal_item_id=".$v['id'])->select();
			$deal_info['deal_item_list'][$k]['price_format'] = $this->number_price_format($v['price']);				
		
		}
		$deal_extra_cache['deal_item_list'] = $deal_info['deal_item_list'];
		//$GLOBALS['db']->query("update ".DB_PREFIX."deal set deal_extra_cache  = '".serialize($deal_extra_cache)."' where id = ".$deal_info['id']);
		$data=serialize($deal_extra_cache);
		M('zc_deal')->where('id='.$deal_info['id'])->save($data);
	}
	else
	{
		$deal_extra_cache = unserialize($deal_info['deal_extra_cache']);
		$deal_info['deal_faq_list'] = $deal_extra_cache['deal_faq_list'];
		$deal_info['deal_item_list'] = $deal_extra_cache['deal_item_list'];
	}
	return $deal_info;
}

	public function cate(){

		$id = intval($_REQUEST['id']);
		isLogin(U('Zc/cate',array('id'=>$id)));
		$deal_item=M('zc_deal_item')->where('id='.$id)->find();
		if(!$deal_item){
			header("Location:".U("Zc/index"));
		}elseif(($deal_item['support_count']+$deal_item['virtual_person'])>=$deal_item['limit_user']&&$deal_item['limit_user']!=0)
			{
				header("Location:".U("Zc/view",array("id"=>$deal_item['deal_id'])));
			}
			//发起人信息
			$deal_info=M('zc_deal')->where('is_delete=0 and is_effect=1 and id='.$deal_item['deal_id'])->find();
			if($deal_info['uesr_id']){
				$user_info=M('user')->field('true_name,user_name')->where('id='.$deal_info['user_id'])->find();
				$user_name=$user_info['true_name']?$user_info['true_name']:$user_info['user_name'];
			}else{
				$user_name='诚车堂';
			}
			
			$this->assign("user_name",$user_name);
			$deal_info = $this->cache_deal_extra($deal_info);
			$this->init_deal_page_wap($deal_info);

			if(!$deal_info)
			{
				header("Location:".U("Zc/index"));
			}
			elseif($deal_info['begin_time']>time()||($deal_info['end_time']<time()&&$deal_info['end_time']!=0))
			{
				header("Location:".U("Zc/view",array("id"=>$deal_item['deal_id'])));
			}
			//众筹人信息
			$uinfo=M('user')->where('true_name,mobile')->where('id='.session('uid'))->find();
			$this->assign("uinfo",$uinfo);

			$deal_item['price_format'] =$this->number_price_format($deal_item['price']);
			$deal_item['delivery_fee_format'] =$this->number_price_format($deal_item['delivery_fee']);
			$deal_item['total_price'] = $deal_item['price']+$deal_item['delivery_fee'];
			$deal_item['total_price_format'] =$this->number_price_format($deal_item['total_price']);
			$deal_info['percent'] = round($deal_info['support_amount']/$deal_info['limit_price']*100);
			$deal_info['remain_days'] = ceil(($deal_info['end_time'] - time())/(24*3600));
			$this->assign("deal_item",$deal_item);
		    $this->display();
	}
	public function go_pay(){
		$id=intval($_REQUEST['id']);
		isLogin(U('Zc/go_pay',array('id'=>$id)));
		
		$deal_item =M('zc_deal_item')->where('id='.$id)->find();
		if(!$deal_item){
			header("Location:".U("Zc/index"));
		}
		elseif($deal_item['support_count']>=$deal_item['limit_user']&&$deal_item['limit_user']!=0)
		{
			header("Location:".U("Zc/view",array("id"=>$deal_item['deal_id'])));
		}
		$deal_info=M('zc_deal')->where('is_delete=0 and is_effect=1 and id='.$deal_item['deal_id'])->find();
		if(!$deal_info)
		{
			header("Location:".U("Zc/index"));
		}
		elseif($deal_info['begin_time']>time()||($deal_info['end_time']<time()&&$deal_info['end_time']!=0))
		{
			header("Location:".U("Zc/view",array("id"=>$deal_item['deal_id'])));
		}

		$order_info['deal_id'] = $deal_info['id'];
		$order_info['deal_item_id'] = $deal_item['id'];
		$order_info['user_id'] = intval(session('uid'));
		
		$order_info['user_name'] = $_REQUEST['uname'];
		$order_info['total_price'] = $deal_item['price']+$deal_item['delivery_fee'];
		$order_info['delivery_fee'] = $deal_item['delivery_fee'];
		$order_info['deal_price'] = $deal_item['price'];
		$order_info['support_memo'] = $_REQUEST['memo'];
		$order_info['online_pay'] = 0;
		$order_info['mobile'] = $_REQUEST['mobile'];
		$order_info['deal_name'] = $deal_info['name'];
		$order_info['order_status'] = 0;
		$order_info['create_time']	= time();		
		$order_info['is_success'] = $deal_info['is_success'];
		$order_id=M('zc_deal_order')->add($order_info);		

		if($order_id>0)
		{
			
			//$result =$this->pay_order($order_id);
			//$result =$GLOBALS['db']->getRow("select * from ".DB_PREFIX."zc_deal_order where id = ".$order_id);
			$result=M('zc_deal_order')->where('id='.$order_id)->find();
			if($result['status']==0)
			{
				$money = $result['total_price'] - $result['online_pay'] - $result['credit_pay'];
				$payment_notice['create_time'] = time();
				$payment_notice['user_id'] = intval(session('uid'));
				$payment_notice['money'] = $money;
 				$payment_notice['order_id'] = $order_id;
 				if($order_info['memo'])
				$payment_notice['memo'] = $order_info['memo'];
				$payment_notice['deal_id'] = $order_info['deal_id'];
				$payment_notice['deal_item_id'] = $order_info['deal_item_id'];
				$payment_notice['deal_name'] = $order_info['deal_name'];
				do{
					$payment_notice['notice_sn'] = date("Ymd",time()).$order_id.rand(100,999);
					$notice_id=M('zc_payment_notice')->add($payment_notice);
				}while($notice_id==0);
				 header("Location:".U("Zc/jump",array('id'=>$notice_id)));
			}elseif($result['status']==1)
			{
				$data['pay_status'] = 0;
				$data['pay_info'] = '订单过期.';
 				$this->assign('data',$data);
 				 $this->error('订单过期',U("Zc/index"));
			}elseif($result['status']==2)
			{
				$data['pay_status'] = 0;
				$data['pay_info'] = '订单无库存.';
 				$this->assign('data',$data);
 				$this->error('订单无库存',U("Zc/index"));
 			}
			else
			{
				$data['pay_status'] = 1;
				$data['pay_info'] = '订单支付成功.';
 				$this->assign('data',$data);
 				$this->success('订单支付成功',U("Zc/index"));
 			}
		}
		else
		{
			 $this->error('下单失败',U("Zc/view",array("id"=>$deal_item['deal_id'])));
		}
	}

	//返回array: status:0:未支付 1:已支付(过期) 2:已支付(无库存) 3:成功  money:剩余需支付金额 4:已支付但未判定（锁住订单）
function pay_order($order_id)
{
	$time = time();
	$order_info =M('zc_deal_order')->where('id='.$order_id)->find();	
	$r=M('zc_deal_order')->where('id='.$order_id." and (credit_pay+online_pay>=total_price) and order_status=0")->setField('order_status',4);
	if($r>0) //订单已成功支付
	{
		$order_info['order_status'] = 4;
		if($order_info['credit_pay']+$order_info['online_pay']>$order_info['total_price'])
		{
			$more_money = $order_info['credit_pay']+$order_info['online_pay'] - $order_info['total_price'];
		}
		$order_info['is_refund'] =0;
		$order_info['pay_time'] = $time;
		/*if($order_info['type']==1){			
			$r1=M("zc_deal")->execute("update fw_zc_deal set support_count = support_count + 1,support_amount = support_amount + ".$order_info['deal_price'].",pay_amount = pay_amount + ".$order_info['total_price'].",delivery_fee_amount = delivery_fee_amount + ".$order_info['delivery_fee']." where id = ".$order_info['deal_id']." and is_effect = 1 and is_delete = 0 and begin_time < ".$time ." and (pay_end_time > ".$time ." or pay_end_time = 0)");
			
		}else{*/
		$r1=M("zc_deal")->execute("update fw_zc_deal set support_count = support_count + 1,support_amount = support_amount + ".$order_info['deal_price'].",pay_amount = pay_amount + ".$order_info['total_price'].",delivery_fee_amount = delivery_fee_amount + ".$order_info['delivery_fee']." where id = ".$order_info['deal_id']." and is_effect = 1 and is_delete = 0 and begin_time < ".$time ." and (end_time > ".$time." or end_time = 0)");
		//}
		if($r1>0)
		{
			//记录支持日志
			$support_log['deal_id'] = $order_info['deal_id'];
			$support_log['user_id'] = $order_info['user_id'];
			$support_log['create_time'] = $time ;
			$support_log['price'] = $order_info['deal_price'];
			$support_log['deal_item_id'] = $order_info['deal_item_id'];
			//$GLOBALS['db']->autoExecute(DB_PREFIX."zc_deal_support_log",$support_log);
			$support_log_id =M('zc_deal_support_log')->add($support_log);

			$r2=M('zc_deal_item')->execute("update fw_zc_deal_item set support_count = support_count + 1,support_amount = support_amount +".$order_info['deal_price']." where (support_count + 1 <= limit_user or limit_user = 0) and id = ".$order_info['deal_item_id']);

		
			if($r2>0)
			{
				$result['status'] = 3;
				$order_info['order_status'] = 3;

				//$deal_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."zc_deal where id = ".$order_info['deal_id']." and is_effect = 1 and is_delete = 0");
				$deal_info=M('zc_deal')->where('id='.$order_info['deal_id']." and is_effect=1 and is_delete=0")->find();
				//下单项目成功，准备加入准备队列
				if($deal_info['is_success'] == 0)
				{
					//未成功的项止准备生成队列
					$notify['deal_id'] = $deal_info['id'];
					$notify['create_time'] = $time ;
					M('zc_deal_notify')->add($notify);
				}	

				M('zc_deal_log')->where('deal_id='.$deal_info['id'])->setField('deal_info_cache','');
				M('zc_deal')->where('id='.$deal_info['id'])->setField('deal_extra_cache','');
				
				//同步项目状态
				$this->syn_zc_deal_status($order_info['deal_id']);
				//$this->syn_zc_deal($order_info['deal_id']);

			}
			else
			{
				$result['status'] = 2;
				$order_info['order_status'] = 2;
				$order_info['is_refund'] =1;
				M('zc_deal')->execute("update ".DB_PREFIX."zc_deal set support_count = support_count - 1,support_amount = support_amount - ".$order_info['deal_price'].",pay_amount = pay_amount - ".$order_info['total_price'].",delivery_fee_amount = delivery_fee_amount - ".$order_info['delivery_fee']." where id = ".$order_info['deal_id']);
				M('zc_deal_support_log')->where('id='.$support_log_id)->delete();
			}
		}
		else
		{
			$result['status'] =1;
			$order_info['order_status'] =1;
			$order_info['is_refund'] =1;
		}
		//$r_end=M('zc_deal_order')->execute("update ".DB_PREFIX."zc_deal_order set order_status = ".intval($order_info['order_status']).",pay_time = ".$order_info['pay_time']." where id = ".$order_id);
		$r_end=M('zc_deal_order')->where('id='.$order_id." and order_status=4")->setField('order_status',3);
		
	}
	else
	{
		
		$result['status'] = 0;
		$result['money'] = $order_info['total_price'] - $order_info['online_pay'] - $order_info['credit_pay'];
	}
	return $result;
}

function syn_zc_deal_status($deal_id)
{
	$time = time();
	$deal_info=M('zc_deal')->where('id='.$deal_id)->find();

	$r=M('zc_deal_item')->execute("update fw_zc_deal set is_success = 1,success_time = ".$time." where id = ".$deal_id." and is_effect=  1 and is_delete = 0 and (support_amount+virtual_price) >= limit_price and begin_time <".$time." and (end_time > ".$time." or end_time = 0)");
	if($r>0)
	{
		//$GLOBALS['db']->query("update ".DB_PREFIX."zc_deal_order set is_success = 1 where deal_id = ".$deal_id);
		M('zc_deal_order')->where('deal_id='.$deal_id)->setField('is_success',1);
		//项目成功，加入项目成功的待发队列
		$deal_notify['deal_id'] = $deal_id;
		$deal_notify['create_time'] = $time;
		M('zc_deal_notify')->add($deal_notify);
	}
}

/*众筹开始*/
function syn_zc_deal($deal_id)
{
	
	$deal_info=M('zc_deal')->where('id='.$deal_id)->find();
	if($deal_info)
	{
		
		$deal_info['comment_count']=intval(M('zc_deal_comment')->where('deal_id='.$deal_info['id']." and log_id=0")->count());
	
		$deal_info['support_count']=intval(M('zc_deal_support_log')->where('deal_id='.$deal_info['id'])->count());
		
		$deal_info['support_amount']=doubleval(M('zc_deal_support_log')->where('deal_id='.$deal_info['id'])->sum('price'));

		$deal_info['delivery_fee_amount']=doubleval(M('zc_deal_order')->where('deal_id='.$deal_info['id']." and order_status=3")->sum('delivery_fee'));
		if($deal_info['type']==0){
			
			$deal_info['delivery_fee_amount']=M('zc_deal_item')->where('deal_id='.$deal_id)->sum('virtual_person');
			
			$deal_info['virtual_price']=M('zc_deal_item')->where('deal_id='.$deal_id)->sum('virtual_person*price');
			if(($deal_info['support_amount']+$deal_info["virtual_price"])>=$deal_info['limit_price'])
			{
				$deal_info['is_success'] = 1;
			}
			else
			{
				$deal_info['is_success'] = 0;
			}
		}
		if($deal_info['pay_radio'] > 0){
			$deal_info['pay_amount'] = ($deal_info['support_amount']*(1-$deal_info['pay_radio']))+$deal_info['delivery_fee_amount'];
		}
		else
		{
			$deal_info['pay_amount'] = ($deal_info['support_amount']*(1-app_conf("pay_radio")))+$deal_info['delivery_fee_amount'];
		}

		$deal_info['tags_match'] = "";
		$deal_info['tags_match_row'] = "";
		M('zc_deal')->where('id='.$deal_info['id'])->save($deal_info);
		//$GLOBALS['db']->autoExecute(DB_PREFIX."zc_deal", $deal_info, $mode = 'UPDATE', "id=".$deal_info['id'], $querymode = 'SILENT');
		
	}
}
public function jump(){
	$id=intval($_REQUEST['id']);
	isLogin(U('Zc/jump',array('id'=>$id)));
	if($id){
		 session('zc_pay_order_id',$id);
		 header("Location:".U("Zc/pay"));
	}else{
		header("Location:".U("Zc/index"));
	}
}
public function pay(){
		header('Content-type: text/html; charset=utf-8');
		$order_id = intval(session('zc_pay_order_id'));
		isLogin(U('Zc/pay'));

		//检查订单（未付款，有效的）	
		$order=M('zc_payment_notice')->where('id='.$order_id." and is_paid=0 and user_id=".session('uid'))->find();
		if (!$order) {
				$this->error('非法订单',U('Zc/index'),3);			
		}
		$deal_item=M('zc_deal_item')->where('id='.$order['deal_item_id'])->find();
		if(!$deal_item){
			$this->error('非法操作',U('Zc/index'),3);
		}
		elseif($deal_item['support_count']>=$deal_item['limit_user']&&$deal_item['limit_user']!=0)
		{
			$this->error('订单已无效',U('Zc/index'),3);
		}
		$deal_info=M('zc_deal')->where('is_delete=0 and is_effect=1 and id='.$deal_item['deal_id'])->find();
		if(!$deal_info)
		{
			$this->error('非法操作',U('Zc/index'),3);
		}
		elseif($deal_info['begin_time']>time()||($deal_info['end_time']<time()&&$deal_info['end_time']!=0))
		{
			$this->error('订单已无效',U('Zc/index'),3);
		}
		

		import("@.ORG.WxPay_PHP.WxPayPubHelper");
		//使用jsapi接口
		$jsApi = new JsApi_pub();

		//=========步骤1：网页授权获取用户openid============
		//通过code获得openid
		if (!isset($_GET['code']))
		{
			//触发微信返回code码
			$url = $jsApi->createOauthUrlForCode("http://weixin.17cct.com/index.php/Zc/pay/");
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
		$unifiedOrder->setParameter("body",$order['deal_name']);//商品描述
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
		//$out_trade_no=$order['order_sn'];
		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		$unifiedOrder->setParameter("total_fee", $order['money']*100);//总金额 单位为分  100分为支付一块钱 $order['total_price']*100
		$unifiedOrder->setParameter("notify_url","http://weixin.17cct.com/index.php/Zc/notify_url/");//通知地址 
		$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		$unifiedOrder->setParameter("attach",$order['id']);

		$prepay_id = $unifiedOrder->getPrepayId();
		
		//=========步骤3：使用jsapi调起支付============
		$jsApi->setPrepayId($prepay_id);
		$jsApiParameters = $jsApi->getParameters();		
		$this->assign('jsApiParameters',$jsApiParameters);
		$this->assign('order_id',$order['id']);
		$this->assign('order_sn',$order['notice_sn']);
		$this->display();	
}

//支付回调页面
	public function pay_back()
	{
		$payment_id = intval($_REQUEST['order_id']);
		isLogin(U('Zc/pay_back',array('order_id'=>$payment_id)));
		/*isLogin(U('Index/index'));*/
		$payment=M('zc_payment_notice')->where('id='.$payment_id." and user_id=".session('uid'))->find();
		if (!$payment) {
			$this->error('非法操作');
		}
		
		$this->assign('payment',$payment);
		$this->assign("title","支付结果");
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
			$payment_notice=M('zc_payment_notice')->where('id='.$xml_array_data['attach'])->find();

			//检查订单是否已修改
			/*$check_order=M('zc_deal_order')->where('id='.$payment_notice['order_id'])->find();
			if(!$check_order['is_success']&&!$check_order['pay_time']){*/
				M('zc_deal_order')->execute("update fw_zc_deal_order set online_pay=".$payment_notice['money'].",is_success=1,pay_time=".time()."  where id = ".$payment_notice['order_id']);
			//}

			//检查下单信息是否已同步
			$check_payment_notice=M('zc_payment_notice')->field('is_paid,transaction_id')->where('id='.$xml_array_data['attach'])->find();
			if(!$check_payment_notice['is_paid']&&!$check_payment_notice['transaction_id']){

				if(strlen(intval($payment_notice['order_id']))==3){
					$sn=rand(10000,99999).$payment_notice['order_id'];//抽奖号码
				}

				if(strlen(intval($payment_notice['order_id']))==4){
					$sn=rand(1000,9999).$payment_notice['order_id'];//抽奖号码
				}				

				$r=M('zc_payment_notice')->execute("update fw_zc_payment_notice set pay_time=".time().",outer_notice_sn='".$xml_array_data['out_trade_no']."',is_paid=1,transaction_id='".$xml_array_data['transaction_id']."',lottery_sn='".$sn."'  where id = ".$xml_array_data['attach']);
				$this->pay_order($payment_notice['order_id']);	
				if($r){
					// $content="恭喜您,已成功支持了众筹项目[".$payment_notice['deal_name']."],抽奖码为:".$sn.",请妥善保管！【诚车堂】";
					$content="恭喜您,已成功支持了众筹项目[".$payment_notice['deal_name']."],抽奖码为:".$sn.",请妥善保管！";
					$mobile=M('user')->field('mobile')->where('id='.$payment_notice['user_id'])->find();
					// $result=sendPhoneSms($mobile['mobile'],$content);
					$result=send_sms($mobile['mobile'],$content);
				}
				
				
			}					

			echo 'SUCCESS';			
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

}



?>