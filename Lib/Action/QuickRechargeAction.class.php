<?php
class QuickRechargeAction extends BaseAction 
{
	public function index(){
		isLogin(U('QuickRecharge/index'));	
		$recharge=M('recharge_card')->where('is_effect=1')->limit($page*4,4)->select();	
		$this->assign('recharge',$recharge);
		$this->display();
	}

	public function do_recharge_order(){

		//充值类型，1为充值卡,2为自选充值
		$rechargetype=intval($_REQUEST['rechargetype']);
		//付款类型，1支付宝支付，2为微信支付
		$payment=intval($_REQUEST['payment']);

		$diyrecharge=intval($_REQUEST['diyrecharge']);
		if($rechargetype!=1&&$rechargetype!=2){
			$this->ajaxReturn(0,'非法操作',0);
		}
		if($diyrecharge<=0){
			$this->ajaxReturn(0,'非法操作',0);
		}
		if($rechargetype==1){
			//充值卡充值
			$recharge=M('recharge_card')->where('id='.$diyrecharge." and is_effect=1")->find();
			if(!$recharge){
				$this->ajaxReturn(0,'非法操作',0);	
			}
			$user_info = session('user_info');
			$order['user_id']=$user_info['id'];
			$order['user_name']=$user_info['user_name'];
			$order['mobile']=$user_info['mobile'];
			$order['create_time']=time();
			$order['status']='1';
			$order['total_price']=$recharge['money'];
			$order['name']=$recharge['name'];
			$order['referer']=1;
			$order['number']=1;
			$order['price']=$recharge['money'];
			$order['recharge_id']=$diyrecharge;
			$order['money']=intval($recharge['money'])+intval($recharge['give']);
			do
			{
				$order['order_sn'] = date("YmdHis",time()).rand(10,99);
				$order_id=M('card_order')->add($order);
			}while($order_id==0);						
		}else{
			if(strlen($diyrecharge)>=5){
				$this->ajaxReturn(0,'充值额度过大',0);
			}
			//自定义充值
			$user_info = session('user_info');
			$order['user_id']=$user_info['id'];
			$order['user_name']=$user_info['user_name'];
			$order['mobile']=$user_info['mobile'];
			$order['create_time']=time();
			$order['status']='1';
			$order['total_price']=$diyrecharge;
			$order['name']='自定义充值'.$diyrecharge."元";
			$order['referer']=1;
			$order['number']=1;
			$order['price']=$diyrecharge;
			$order['recharge_id']=0;
			$order['money']=$diyrecharge+doubleval($diyrecharge*0.1);
			do
			{
				$order['order_sn'] = date("YmdHis",time()).rand(10,99);
				$order_id=M('card_order')->add($order);
			}while($order_id==0);	
		}
		if($order_id){
				$this->ajaxReturn(U('Recharge/order',array('id'=>$order_id)),'正在处理中，请稍候',1);	
		}else{
			$this->ajaxReturn(0,'订单生成错误',0);
		}
	}
	


}
?>