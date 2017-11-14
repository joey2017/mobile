<?php

class OrderAction extends BaseAction {  

	//提交订单
	public function submit()
	{	
		$did = intval($_GET['id']);

		if (empty($did) || $did <= 0) {
			$this->error('该服务或商品不存在');
		}

		if (isset($_GET['dsid'])) {
			$dsid = intval($_GET['dsid']);
			if (empty($dsid) || $dsid < 0) {
				$this->error('请选择属性');
			}
			$deal_submete = getDealSubmeter($did,$dsid);
			if (empty($deal_submete)) {
				$this->error('属性错误，请重新下单');
			}
		}

		isLogin(U('Order/submit',array('id'=>$did)));
		$u = session('user_info');
		$mobile = substr_replace($u['mobile'],"****",3,4);

		//服务或商品信息
		$d_w['id'] = $did ;
		$d_w['is_effect'] = 1 ;
		$d_w['is_delete'] = 0 ;
		$d_w['erp_project_id']=array('gt',0);//ERP中同步的项目/商品
		$deal = M('deal')->field("id,name,current_price,promote_price,brand_promote,begin_time,end_time,is_shop")->where($d_w)->find();
		if ($deal) {
			$time = time();
			//检查购买过的数量 
			/*if ($did == 5293 && $u['id'] != 4820) {
				$c_w['do.user_id']     		       =  $u['id'];
				$c_w['fw_deal_order_item.deal_id'] =  $did;
				$c_w['do.pay_status']  	      	   =  2;
				// $c_w['do.create_time'] 		  	   =  array('gt',strtotime('2015-06-09'));
				$c_w['do.create_time'] 		  	   =  array('gt',1433779200);
				$checkBuyNum = M('deal_order_item')->join('fw_deal_order as do ON do.id = fw_deal_order_item.order_id')->where($c_w)->sum('fw_deal_order_item.number');
				if ($checkBuyNum >= 3) {
					$numLimit = 3;
					$this->assign('numLimit',$numLimit);
				}else{
					if($deal['brand_promote'] == 1 && $deal['begin_time'] < $time && $time < $deal['end_time']){
						$deal['current_price'] = $deal['promote_price'];
					}
				}
			}else{*/
				if($deal['brand_promote'] == 1 && $deal['begin_time'] < $time && $time < $deal['end_time']){
					$deal['current_price'] = $deal['promote_price'];
				}
			//}
		}else {
			$this->error('无法找到商品信息，请重试');
		}

		//属性判断
		if (empty($deal_submete)) {
			session('dsid',null);
		}else {
			$deal_attr_list = M('deal_attr_record')->field('attr_value')->where(array('deal_id'=>$did,'deal_submeter_id'=>$dsid))->order('id asc')->select();
			if (empty($deal_attr_list)) {
				$this->error('属性错误，请重新下单');
			} else {
				$deal_attr_str = '';
				foreach ($deal_attr_list as $k => $v) {
					$deal_attr_str .= '，'.$v['attr_value'];
				}
				$deal['attr_str'] = substr($deal_attr_str,3);
			}
			$deal['current_price'] = $deal_submete['current_price'];
			$deal['dsid'] = $deal_submete['id'];
			session('dsid',$deal_submete['id']);
		}
		if(session('wxid')){
			$card_list=$this->getcardlist(session('wxid'));
			if($card_list){
				//卡券功能
			$nonceStr=$this->createNonceStr();
			$this->assign('nonceStr',$nonceStr);//随机串
			$time=time();	
		    $ticket=getWxTicket();
		    $config_sign=sha1("jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$time&url=http://m.17cct.com/index.php/Order/submit/id/".$did.".html");
		    $this->assign('time',$time);
		    $this->assign('sign',$config_sign);
		    $apitick=$this->get_apiticket();//卡券ticket
		    $card_type='';//团购券：GROUPON; 折扣券：DISCOUNT; 礼品券：GIFT; 代金券：CASH; 通用券：GENERAL_COUPON; 会员卡：MEMBER_CARD; 景点门票：SCENIC_TICKET； 电影票：MOVIE_TICKET； 飞机票：BOARDING_PASS； 会议门票：MEETING_TICKET； 汽车票：BUS_TICKET;
		    $app_id=C('wx_id');
		    $arrays = array($apitick,$time,$nonceStr,$card_type,$app_id);
		    $arrays = array_values($arrays);
	        sort($arrays,SORT_STRING);//进行字符串的字典序排序。
		    $signature=sha1(implode($arrays));
		    $this->assign('signature',$signature);
			}
		}

		$this->assign('mobile',$mobile);
		$this->assign('d',$deal);
		$this->assign('u',$u);
		$this->assign('title','提交订单');
		$this->display();
	}

	//查看用户卡券列表
	public function getcardlist($openid){
		//card_id非必填
		$jsonData='{"openid":"'.$openid.'","card_id":""}';		
		$access_token=getWxAccToken();
		$url="https://api.weixin.qq.com/card/user/getcardlist?access_token=".$access_token;
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch) ;
		curl_close($ch) ;
		$result=json_decode($result,true);
		return $result['card_list'];
	}

	//随机串
	private function createNonceStr($length = 16) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $str = "";
	    for ($i = 0; $i < $length; $i++) {
	      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	    }
	    return $str;
	  }
	  //卡券票据
	 //卡券ticket
	public function get_apiticket(){		
		 $mem = new Memcache; 
		 $mem->connect('localhost', 11211) or die ("Could not connect"); 
		 $card_ticket = $mem->get('card_ticket');
		if($card_ticket){
			return $card_ticket;
		}else{
			$ch = curl_init();
			$timeout = 5;
			$token=getWxAccToken();//获取access_token
			curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$token."&type=wx_card");
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$card_ticket = curl_exec($ch);
			$card_ticket = json_decode($card_ticket, true);
			$mem->set('card_ticket',$card_ticket['ticket'],0,7200);
			return $card_ticket['ticket'];	
		}	
	}

	//查看卡券code
	public function getCode(){
		$deal_id=intval($_REQUEST['deal_id']);
		$card_id=trim($_REQUEST['card_id']);
		if($card_id=='p7of3jnlFRHzOKr3ks8XrZIEbZM4'){
			if($deal_id!=5650&&$deal_id!=5649)
			$this->ajaxReturn(0,"本服务不能使用该券",0);
		}
		if($card_id=='p7of3jszx-C2Zp0JHbAqD3cypB3k'){
			if($deal_id!=5648&&$deal_id!=2330)
			$this->ajaxReturn(0,"本服务不能使用该券",0);
		}
		$encrypt_code=trim($_REQUEST['encrypt_code']);
		$jsonData='{"encrypt_code":"'.$encrypt_code.'"}';		
		$access_token=getWxAccToken();
		$url="https://api.weixin.qq.com/card/code/decrypt?access_token=".$access_token;
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch) ;
		curl_close($ch) ;
		$result=json_decode($result,true);
		$this->ajaxReturn($result,"加载成功",1);
	}

	//ajax 购买前验证库存 
	public function ajaxModifyBuy()
	{
		$did = intval($_POST['id']);
		$number = intval($_POST['number']);
		if (empty($did) || empty($number) || $did <0 || $number <0) {
			$this->ajaxReturn(0,'参数错误',0);
		}

		if (session('dsid')) { //有属性的商品、服务
			$dsid = intval(session('dsid'));
			$result = $this->checkDealNumberAttr($did,$dsid,$number);
			$this->ajaxReturn(0,$result['info'],$result['status']);
		}

		$is_shop = intval($_POST['is_shop']);
		if($is_shop == 1){//没有属性的商品
			$result = $this->checkGoodsNumber($did,$number);
			$this->ajaxReturn(0,$result['info'],$result['status']);
		}
	}

	//ajax 提交订单
	public function ajaxOrderSubmit()
	{
		$did = intval($_POST['id']);
		$number = intval($_POST['number']);
		
		//测试数据,测试完成需删除
		/*session('uid',3682);
		$user_info=M('user')->where('id=3682')->find();
		session('user_info',$user_info);*/

		if (empty($did) || empty($number) || $did <0 || $number <0) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if (!isLogin(U('Order/submit',array('id'=>$did)),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$u = session('user_info');


		$uid = intval($u['id']);
		$u['true_name'] = empty($u['true_name']) ? $u['user_name'] : $u['true_name'];
		if (empty($u['mobile'])) {
			$this->error('请先绑定手机号',U('User/account'),3);
		}
		$time = time();
		// $has_order=M('deal_order')->where('user_id='.$uid." and deal_ids=".$did." and ".$time."<create_time+300")->find();
		// if($has_order){
		// 	$this->ajaxReturn(0,'您五分钟内预订过该服务',0);
		// }

		$d_w['fw_deal.id'] = $did ;
		$d_w['fw_deal.is_effect'] = 1 ;
		$d_w['fw_deal.is_delete'] = 0 ;
		$d_w['fw_deal.erp_project_id']=array('gt',0);//ERP中同步的项目/商品
		$d_w['fsl.is_effect'] = 1;
		$d_f  = 'fw_deal.id as did,fw_deal.name,fw_deal.sub_name,fw_deal.is_shop,fw_deal.erp_project_id,fw_deal.begin_time,fw_deal.end_time,fw_deal.supplier_id,fw_deal.location_id';
		$d_f .= ',fw_deal.current_price,fw_deal.promote_price,fw_deal.brand_promote,fw_deal.coupon_begin_time,fw_deal.code';
		
		$deal =  M('deal')->join('fw_supplier_location as fsl ON fsl.id = fw_deal.location_id')->field($d_f)->where($d_w)->find();
		if (empty($deal)) {
			$this->ajaxReturn(0,'该服务或商品不存在,或者已下架',0);
		}

		//检查购买过的数量
		if ($did == 5293 && $uid != 4820) {
			$c_w['do.user_id']     		       =  $u['id'];
			$c_w['fw_deal_order_item.deal_id'] =  $did;
			$c_w['do.pay_status']  	      	   =  2;
			// $c_w['do.create_time'] 		  	   =  array('gt',strtotime('2015-06-09'));
			$c_w['do.create_time'] 		  	   =  array('gt',1433779200);
			$checkBuyNum = M('deal_order_item')->join('fw_deal_order as do ON do.id = fw_deal_order_item.order_id')->where($c_w)->sum('fw_deal_order_item.number');
			if ($checkBuyNum >= 3) {
				$priceChange = true;
			}else {
				$remainNum = 3-abs(intval($checkBuyNum)); //剩余体验次数
				if ($number>$remainNum) {
					$msg = "您还有".($remainNum)."次体验机会，购买数量请小于".($remainNum+1);
					$this->ajaxReturn(0,$msg,0);
				}
			}
		}

		if($deal['is_shop'] == 1){//没有属性的商品,检查在ERP中的库存
			$erp_stock_result = $this->checkGoodsNumber($did,$number);
			if($erp_stock_result['status']==0){
				$this->error($erp_stock_result['info']);
			}
			
		}

		if (!$priceChange) {
			if($deal['brand_promote'] == 1 && $deal['begin_time'] < $time && $time < $deal['end_time'])
			{	if($deal['promote_price'] >= 0){
					$deal['current_price'] = $deal['promote_price'];
				}
			}
		}

		if (session('dsid')) { //有属性时
			$dsid = intval(session('dsid'));
			$deal_submete = getDealSubmeter($did,$dsid);
			if (empty($deal_submete)) {
				$this->error('属性错误，请重新下单');
			}
			//检查库存
			$result = $this->checkDealNumberAttr($did,$dsid,$number);
			if ($result['status'] == 0) {
				$this->error($result['info']);
			}
			if (!$priceChange) {
				$deal['current_price']  = $deal_submete['current_price'];
			}else{
				$deal['current_price']  = $deal_submete['price'];
			}
			
			$attr_arr =  M('deal_attr_record')->field('id,attr_value')->where(array('deal_submeter_id'=>$dsid))->select();
			foreach($attr_arr as $k => $v) {
				$attr_ids .= ",".$v['id'];
				$attr_name_str .= ",".$v['attr_value'];
			}
			$attr_ids = substr($attr_ids,1); 
			$attr_name_str = substr($attr_name_str,1); 
		}
		if($_REQUEST['coupon_code']){
			$consume_result=$this->consume($_REQUEST['coupon_code']);
			if($consume_result){
				if($_REQUEST['coupon_card_id']=='p7of3jnlFRHzOKr3ks8XrZIEbZM4'){
					if($did==5649||$did==5650){
						$discount_price=100;
					}else{
						$this->ajaxReturn(0,'微信卡券未使用成功,请重试',0);
					}
					
				}
				if($_REQUEST['coupon_card_id']=='p7of3jszx-C2Zp0JHbAqD3cypB3k'){
					if($did==5648||$did==2330){
						$discount_price=30;
					}else{
						$this->ajaxReturn(0,'微信卡券未使用成功,请重试',0);
					}
				}
				$notice['memo']= '使用微信卡券优惠￥'.$discount_price; //备注
				$notice['card_id']=$consume_result['card']['card_id']; //卡券id
				$notice['discount_price']=$discount_price; //优惠价格
				$notice['coupon_code']=$_REQUEST['coupon_code']; //优惠价格					
				$prices = round(($number * $deal['current_price'])-$discount_price,2);  //总价格
			}else{
				$this->ajaxReturn(0,'微信卡券未使用成功,请重试',0);
			}			
		}else{
			$prices = $number * $deal['current_price'];  //总价格	
		}		
		
		//开始生成订单
		$order['type'] 				 = 0;       //订单类型 0为付款订单，6为免费预订
		$order['user_id'] 			 = $uid;
		$order['create_time'] 		 = $time;
		$order['total_price'] 		 = $prices; //$data['pay_total_price'];  //应付总额  商品价 - 会员折扣 + 运费 + 支付手续费
		$order['pay_amount'] 		 = 0;
		$order['pay_status'] 		 = 0;       //新单都为零， 等下面的流程同步订单状态
		$order['order_status'] 		 = 0;       //新单都为零， 等下面的流程同步订单状态
		$order['return_total_score'] = $prices; // $data['return_total_score'];  //结单后送的积分
		$order['return_total_money'] = 0;       //$data['return_total_money'];  //结单后送的现金
		$order['mobile']			 = $u['mobile'];
		$order['deal_total_price'] 	 = $prices;	// $data['total_price'];   //团购商品总价
		$order['account_money'] 	 = 0; 		//已经付了多少款
		$order['deal_ids']			 = $did;
		$order['referer'] 			 = "3G";
		$order['user_name'] 		 = $u['true_name'];
		$order['order_sn'] 			 = date("Ymdhis",$time).rand(10,99);
		$order['delivery_status'] 	 = 5;//$data['is_delivery']==0?5:0; //是否已交付
		$order['memo'] 				 = $u['true_name'];  //htmlspecialchars(addslashes(trim($_REQUEST['memo']))); //备注
		//$order['consignee']	=	htmlspecialchars(addslashes(trim($_REQUEST['consignee']))); //收货人
	    //$order['zip']	='';//	htmlspecialchars(addslashes(trim($_REQUEST['zip'])));//邮编
	    //$order['memo'] = htmlspecialchars(addslashes(trim($_REQUEST['memo']))); //备注
		//$order['address']	='';//	htmlspecialchars(addslashes(trim($_REQUEST['address']))); //地址
		//$order['delivery_id'] = $data['delivery_info']['id'];
		//$order['payment_id'] = $data['payment_info']['id']; 
		//$order['payment_fee'] = $data['payment_fee'];
		//$order['payment_fee'] = $data['payment_fee'];
		//$order['bank_id'] = htmlspecialchars(addslashes(trim($_REQUEST['bank_id'])));
		//$order['discount_price'] = $data['user_discount'];
		//$order['delivery_fee'] = $data['delivery_fee'];
		//$order['ecv_money'] 		 = 0;
		//$order['ecv_sn'] = '';
		$order_id = M('deal_order')->add($order);

		if ($order_id) {

			if($deal['is_shop'] == 1){//商品减库存
				$del_stock_sql="update fw_erp_stock set shop_buy_count=shop_buy_count+".$number.",stock=stock-".$number.",all_buy_count=all_buy_count+".$number." where erp_goods_id=".$deal['erp_project_id'];
				M('fw_erp_stock')->execute($del_stock_sql);
			}
			//更新商品或服务销量
			$add_count_sql="update fw_erp_goods set buy_count=buy_count+".$number." where id=".$deal['erp_project_id'];
			M('fw_erp_goods')->execute($add_count_sql);

			//生成 order_item
			// t.modify 加入购物车时根据优惠套餐ID（service_package_id）生成区别套餐的识别码
	   		$verify_code = empty($sp_id) ? md5($id."_".$attr_ids) : md5($id."_".$attr_ids."_".$sp_id) ;

			$order_item['deal_id'] 			  = $did;
			$order_item['number']       	  = $number; 
			$order_item['unit_price']   	  = $deal['current_price'];
			$order_item['total_price']  	  = $prices;
			$order_item['name'] 			  = addslashes($deal['name']);
			$order_item['sub_name'] 		  = addslashes($deal['sub_name']);
			$order_item['attr'] 			  = empty($attr_ids) ? '' : $attr_ids;;
			$order_item['verify_code'] 		  = $verify_code;
			$order_item['order_id'] 		  = $order_id;
			$order_item['return_score'] 	  = 0;
			$order_item['return_total_score'] = 0;
			$order_item['return_money'] 	  = 0;
			$order_item['return_total_money'] = 0;
			$order_item['buy_type']			  = 0;
			$order_item['attr_str']			  = empty($attr_name_str) ? '' : $attr_name_str;
			$order_item_id = M('deal_order_item')->add($order_item);
			if ($order_item_id) {
				$notice['create_time'] = time();
				$notice['order_id']    = $order_id;
				$notice['user_id'] 	   = $uid;
				$notice['notice_sn']   = $order['order_sn'];
				$notice['payment_id']  = 20; //????
				$notice['money']	   = $prices;
				//$notice['memo'] 	   = $order['memo']; //备注
				$payment_notice = M('payment_notice')->add($notice);
				if ($payment_notice) {
					saveLog('deal_order_log',array('log_info'=>$order['order_sn'].'开放订单成功','log_time'=>$time,'order_id'=>$order_id));
					$this->ajaxReturn(U("Order/pay",array('id'=>$order_id)),'生成订单成功',1);
				}else{ // payment_notice 生成失败 删除订单、order_item
					M('deal_order')->where(array('id'=>$order_id))->delete();
					M('deal_order_item')->where(array('order_id'=>$order_id))->delete();
					$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
				}
			}else{ //order_item 生成失败 删除订单
				M('deal_order')->where(array('id'=>$order_id))->delete();
				$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
			}
		}else{ 
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
	}

	public function consume($code){
		$code=trim($code);
		$jsonData='{"code":"'.$code.'"}';		
		$access_token=getWxAccToken();
		$url="https://api.weixin.qq.com/card/code/consume?access_token=".$access_token;
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch) ;
		curl_close($ch) ;
		$result=json_decode($result,true);
		return $result;
	}
	//支付订单
	public function pay()
	{	
		$oid = intval($_GET['id']);
		if (empty($oid) || $oid <= 0) {
			$this->error('该订单不存在');
		}
		isLogin(U('Order/pay',array('id'=>$oid)));
		$uid = intval(session('uid'));
		$o_j = 'fw_payment_notice as p ON p.order_id = fw_deal_order.id';
		$o_f = 'fw_deal_order.id,fw_deal_order.order_sn,p.memo,fw_deal_order.create_time,fw_deal_order.total_price,fw_deal_order.mobile,fw_deal_order.user_id';
		$o_w = array('fw_deal_order.id'=>$oid,'fw_deal_order.user_id'=>$uid,'fw_deal_order.pay_status'=>0,'fw_deal_order.is_delete'=>0);
		$order = M('deal_order')->join($o_j)->field($o_f)->where($o_w)->find();
		if ($order){
			$order['total_number'] = 0;
			$doi_f ='name,number,unit_price,attr,attr_str';
			$doi_w = array('order_id'=>$oid);
			$order['items'] = M('deal_order_item')->field($doi_f)->where($doi_w)->select();
			if ($order['items']) {
				foreach ($order['items'] as $k => $v) {
					$order['total_number'] += $v['number'];
				}
			}else {
				$this->error('该订单不存在');
			}
			$order['items_count'] = count($order['items']);
		}else {
			$this->error('该订单不存在');
		}
		//查询余额
		$balance=M('user')->where('id='.session('uid'))->getField('money');
		if(doubleval($balance)-doubleval($order['total_price'])>=0){
			$this->assign('balance',$balance);
		}
		$this->assign('order',$order);
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
		if (!isLogin(U('Order/pay',array('id'=>$pid)),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$uid = intval(session('uid'));
		$o_j = array('fw_payment_notice as p ON p.order_id = fw_deal_order.id','fw_deal_order_item as doi ON doi.order_id = fw_deal_order.id');
		$o_w = array('fw_deal_order.id'=>$pid,'fw_deal_order.user_id'=>$uid,'fw_deal_order.pay_status'=>0,'fw_deal_order.is_delete'=>0);
		$orderExist = M('deal_order')->join($o_j)->field('fw_deal_order.id,fw_deal_order.total_price')->where($o_w)->find();
		
		if ($orderExist) {
			if($payment=='alipay'){
				$this->ajaxReturn(U('Alipay/pay',array('id'=>$pid)),'正在处理中，请稍候',1);
			}
			if($payment=='wxpay'){
				$this->ajaxReturn(U('Wxpay/go_pay',array('id'=>$pid)),'正在处理中，请稍候',1);
			}else{
				$balance=M('user')->where('id='.session('uid'))->getField('money');
				$poor=doubleval($balance)-doubleval($orderExist['total_price']);
				if($poor<0){
					$this->ajaxReturn(0,'余额不足',0);
					die();
				}
				$this->ajaxReturn(U('Balance/balance_pay',array('id'=>$pid)),'正在处理中，请稍候',1);
			}
			
		}else {
			$this->ajaxReturn(0,'该订单不存在',0);
		}
	}

	//ajax 删除、取消订单
	public function ajaxOperateOrder()
	{
		$oid =  intval($_POST['id']);
		$t   = intval($_POST['t']);
		if (empty($oid) || $oid <= 0) {
			$this->ajaxReturn(0,'参数错误',0);
		}

		if ($t != 1 && $t != 2) {
			$this->ajaxReturn(0,'参数错误',0);
		}
		if (!isLogin(U('User/order'),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$uid = intval(session('uid'));

		$order_info = M('deal_order')->field('order_sn,is_delete')->where(array('id'=>$oid,'user_id'=>$uid))->find();

		if ($order_info['order_sn']) {
			if ($t == 1) {
				$tpye = '取消';
				M('deal_order')->where(array('id'=>$oid,'user_id'=>$uid))->save(array('is_delete'=>1,'order_status'=>1));
				M('deal_coupon')->where(array('order_id'=>$oid,'user_id'=>$uid))->save(array('is_valid'=>0));
			}else{
				$tpye = '删除';
				/*M('deal_order')->where(array('id'=>$oid,'user_id'=>$uid))->delete();
				M('deal_order_item')->where(array('order_id'=>$oid))->delete();
				M('deal_coupon')->where(array('order_id'=>$oid,'user_id'=>$uid))->delete();
				M('payment_notice')->where(array('order_id'=>$oid,'user_id'=>$uid))->delete();*/
				M('deal_order')->where(array('id'=>$oid,'user_id'=>$uid))->save(array('is_delete'=>2,'order_status'=>1));
				M('deal_coupon')->where(array('order_id'=>$oid,'user_id'=>$uid))->save(array('is_valid'=>0));
			}

			if($order_info['is_delete']==0){//当为正常状态时取消或删除则还原库存
				$order_item=M('deal_order_item')->field('deal_id,number')->where(array('order_id'=>$oid))->select();
				if($order_item){
					foreach ($order_item as $k => $v) {
						$deal_info=M('deal')->field('is_shop,erp_project_id')->where(array('id'=>$v['deal_id']))->find();
						if($deal_info['is_shop']==1&&$deal_info['erp_project_id']>0){
							//还原商品库存
							$sql="update fw_erp_stock set shop_buy_count=shop_buy_count-".$v['number'].",stock=stock+".$v['number'].",all_buy_count=all_buy_count-".$v['number']." where erp_goods_id=".$deal_info['erp_project_id'];
							M('fw_erp_stock')->execute($sql);

						}
						if($deal_info['erp_project_id']>0){
							//还原商品或服务销量
							$del_count_sql="update fw_erp_goods set buy_count=buy_count-".$v['number']." where id=".$deal_info['erp_project_id'];
							M('fw_erp_goods')->execute($del_count_sql);
						}
					}
				}
			}

			saveLog('deal_order_log',array('log_info'=>$order_info['order_sn'].$tpye.'订单成功','log_time'=>time(),'order_id'=>$oid));
			$this->ajaxReturn(0,$tpye.'订单成功',1);
		}else {
			$this->ajaxReturn(0,'操作失败',0);
		}
	}

	//检查服务、商品库存数量 有属性的
	public function checkDealNumberAttr($did,$dsid,$number=0)
	{
		$did = intval($did);	
		$dsid = intval($dsid);
		$stock =  M('deal_submeter')->getFieldById($dsid,'stock'); // 库存

		if ($stock == 0) {
			return array('status'=>1,'info'=>'');
		}
		//属性字符串
		$attr_arr =  M('deal_attr_record')->field('id')->where(array('deal_submeter_id'=>$dsid))->select();
		foreach($attr_arr as $k => $v) {
			$attr_ids .= ",".$v['id'];
		}
		$attr_ids = substr($attr_ids,1);
		//1. 订单量 包括未付款
		//$dbc_w['do.pay_status'] = 2;
		$dbc_w['do.is_delete'] = 0;
		$dbc_w['do.after_sale'] = 0;
		$dbc_w['fw_deal_order_item.deal_id'] = $did;
		$dbc_w['fw_deal_order_item.attr'] = $attr_ids;
		$deal_buy_count = M('deal_order_item')->join('fw_deal_order as do ON do.id = fw_deal_order_item.order_id')->where($dbc_w)->sum('fw_deal_order_item.number');

		//2. 购物车内数量
		$ducc_w['deal_id'] = $did;
		$ducc_w['attr'] = $attr_ids;
		$deal_user_cart_count = M('deal_cart')->where($ducc_w)->sum('number');

		if($deal_user_cart_count + $deal_buy_count  + $number > $stock && $stock > 0)
		{		
			$surplus_nums = $stock - $deal_buy_count - $deal_user_cart_count;
			$msg = ($surplus_nums <= 0) ? '非常抱歉没，没有库存了' : '仅剩'.$surplus_nums.'件库存了，赶紧下单吧' ;
			return array('status'=>0,'data'=>($stock-$deal_user_cart_count + $deal_buy_count),'info'=>$msg);
		}
		return array('status'=>1,'info'=>'');
	}

	//检查商品库存数量 无属性的
	private function checkGoodsNumber($did,$number=0)
	{
		$did = intval($did);	

		// $stock =  M('deal')->getFieldById($did,'max_bought'); // 库存
		
		//检查ERP中该商品的库存
		$stock=M('deal')->join('fw_erp_stock as es on es.erp_goods_id=fw_deal.erp_project_id')->where('fw_deal.id='.$did)->getField('es.stock');

		if ($stock == 0) {
			return array('status'=>0,'info'=>'非常抱歉，该商品没有库存了');
		}

		/*//1. 订单量 包括未付款
		//$dbc_w['do.pay_status'] = 2;
		$dbc_w['do.is_delete'] = 0;
		$dbc_w['do.after_sale'] = 0;
		$dbc_w['fw_deal_order_item.deal_id'] = $did;
		$dbc_w['fw_deal_order_item.attr'] = array(array('eq',0),array('eq',''), 'or') ;
		$deal_buy_count = M('deal_order_item')->join('fw_deal_order as do ON do.id = fw_deal_order_item.order_id')->where($dbc_w)->sum('fw_deal_order_item.number');*/
		
		//2. 购物车内数量
		$ducc_w['deal_id'] = $did;
		$ducc_w['attr'] = array(array('eq',0),array('eq',''), 'or') ;
		$deal_user_cart_count = M('deal_cart')->where($ducc_w)->sum('number');

		if($deal_user_cart_count + $number > $stock && $stock > 0)
		{		
			$surplus_nums = $stock - $deal_user_cart_count;
			$msg = ($surplus_nums <= 0) ? '非常抱歉，没有库存了' : '仅剩'.$surplus_nums.'件库存' ;
			return array('status'=>0,'data'=>($stock-$deal_user_cart_count ),'info'=>$msg);
		}
		return array('status'=>1,'info'=>'');
	}
	
}
?>