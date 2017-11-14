<?php

class BalanceAction extends Action {	
	 //余额支付
	 public function balance_pay(){

	 	$order_id = intval($_REQUEST['id']);

	 	$uid = intval(session('uid'));

		//检查订单（未付款，有效的）
		$o_j = array('fw_payment_notice as p ON p.order_id = fw_deal_order.id','fw_deal_order_item as doi ON doi.order_id = fw_deal_order.id');
		$o_w = array('fw_deal_order.id'=>$order_id,'fw_deal_order.user_id'=>$uid,'fw_deal_order.pay_status'=>0,'fw_deal_order.is_delete'=>0);
		$o_f = 'fw_deal_order.id,fw_deal_order.order_sn,fw_deal_order.total_price,fw_deal_order.pay_status,fw_deal_order.user_id,doi.name,p.money';
		$order = M('deal_order')->join($o_j)->field($o_f)->where($o_w)->find();
		if ($order) {
			if ($order['money'] != $order['total_price']) {//付款订单与付款信息金额比对
				$this->error('非法订单',U('Index/index'),3);
			}
		}else {
			$this->error('该订单不存在');
		}	

		//查询余额
		$balance=M('user')->where('id='.session('uid'))->getField('money');

		//支付后的余额
		$poor=doubleval($balance)-doubleval($order['total_price']);
		if($poor<0){
			$this->error('余额不足');
			die();
		}
		//更新钱数
		$r_money=M('user')->where('id='.session('uid'))->setDec('money',$order['total_price']);

		if($r_money){
			//means_of_payment 支付工具，0为未使用支付，1为支付宝支付，2为微信支付
			if($order['pay_status']!=2){
				//更新订单信息
				$data = array('pay_status'=>2,'order_status'=>1,'means_of_payment'=>'3','pay_amount'=>$order['total_price']);						
				$r = M('deal_order')->where(array('id'=>$order['id']))->save($data);

				//更新支付信息
				$data_notice = array('pay_time'=>time(),'is_paid'=>1);
				$r1 = M('payment_notice')->where(array('order_id'=>$order['id']))->save($data_notice);
				// 生成服务码
				if (!M('deal_coupon')->where(array('order_id'=>$order['id']))->getField('id')) {
					$order_items = M('deal_order_item')->field('id,deal_id,number,attr_str')->where(array('order_id'=>$order['id']))->select();
					if ($order_items) {
						$store_arr = array();
						foreach ($order_items as $k => $v) {
							$u = M('user')->where(array('id'=>$order['user_id']))->field("wxid,mobile,true_name,user_name")->find();
							$u['true_name'] = empty($u['true_name']) ? $u['user_name'] : $u['true_name'];
							$deal = M('deal')->field('id,name,sub_name,is_shop,code,coupon_begin_time,end_time,supplier_id,location_id')->find($v['deal_id']);
							$deal['sub_name'] = empty($deal['sub_name']) ? $deal['name'] : $deal['sub_name'] ;
							$store = M('supplier_location')->field('name,tel,mobile,address')->where(array('id'=>$deal['location_id']))->find();
							$store['tel'] = empty($store['tel']) ? $store['mobile'] : $store['tel'] ;
							//购买数量
							$num = intval($v['number']);
							for ($i = 0; $i < $num; $i++) { 
								$coupon = addCoupon($order['id'],$v['id'],$order['user_id'],$deal);
								$userMsg['order_id']       = $order['id'];
								$userMsg['user_true_name'] = $u['true_name'];
								$userMsg['user_mobile']    = $u['mobile'];
								$userMsg['user_wxid']      = $u['wxid'];
								$userMsg['deal_id']        = $deal['id'];
								$userMsg['deal_name']      = $deal['sub_name'];
								$userMsg['deal_tpye']      = $deal['is_shop'];
								$userMsg['deal_attr']      = $v['attr_str'];
								$userMsg['coupon'] 	       = $coupon;
								$userMsg['store_tel']      = $store['tel'];
								$userMsg['store_name']     = $store['name'];
								$userMsg['store_address']  = $store['address'];
								paySuccessSendMsg('user',$userMsg);
							}	
							$storeMsg['user_true_name'] = $u['true_name'];
							$storeMsg['user_mobile']    = $u['mobile'];
							$storeMsg['deal_name']   	= $deal['sub_name'];
							$storeMsg['deal_tpye'] 		= $deal['is_shop'];
							$storeMsg['store_mobile']   = $store['mobile'];
							paySuccessSendMsg('store',$storeMsg);								
						}
						//订单支付成功记录
						saveLog('deal_order_log',array('log_info'=>$xml_array_data['attach'].'结单成功','log_time'=>time(),'order_id'=>$order['id']));
						redirect(U('Wxpay/pay_back',array('order_id'=>$order['id'],'order_sn'=>$order['order_sn'])));
					}
				}			
			} 	
		}else{
			$this->error('扣款失败');
		}
	 }


}

?>