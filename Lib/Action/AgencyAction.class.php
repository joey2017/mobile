<?php
// 本类由系统自动生成，仅供测试用途
import('ORG.Util.Page');
class AgencyAction extends BaseAction {

	public function check_login(){
		if(!session('agency_info')){
			header("Location:".U("Agency/login"));
			exit;
		}
	}

   public function index()
	{			
		$this->check_login();
		$this->display();
			

	}
	 public function verify()
	{	
		$this->check_login();
		$this->display();
			
	}
	
	public function ajax_verify(){
		$agency_info=session('agency_info');
		if(!$agency_info['id']){
			$this->ajaxReturn(U('Agency/login'),'请重新登录',0);
		}		
		$now = time();
		$sn = trim($_REQUEST['dhm']);
		session('sn','');	
		$agency_id = intval($agency_info['id']);
		
		$coupon_data=M('zjy_coupon')->join('fw_zjy_route_order as zro on fw_zjy_coupon.order_id=zro.id')->field('fw_zjy_coupon.id,fw_zjy_coupon.agency_id,fw_zjy_coupon.route_id,fw_zjy_coupon.confirm_time,zro.status,zro.total_price,zro.name,zro.id as order_id,zro.user_name,zro.mobile')->where("fw_zjy_coupon.sn='".$sn."' and fw_zjy_coupon.agency_id=".$agency_id." and fw_zjy_coupon.is_valid=1 and fw_zjy_coupon.is_delete=0")->find();
		if($coupon_data)
			{
				
				$route_info=M('zjy_route')->where('id='.$coupon_data['route_id']." and agency_id =".$agency_id)->find();
				
				if(!$route_info)
				{
					$result['status'] = 0;
					$result['msg'] = '没有权限';
					$this->ajaxReturn($result);
				}
				
				if($coupon_data['agency_id']!=$agency_id)
				{
					$result['status'] = 0;
					$result['msg'] = '该券为其他团购商户的团购券，不能确认';
					$this->ajaxReturn($result);
				}
				elseif($coupon_data['confirm_time'] > 0)
				{
					$result['status'] = 0;
					$result['msg'] = '该服务券已于'.date('Y-m-d H:i:s',$coupon_data['confirm_time'])."使用";
					$this->ajaxReturn($result);
				}
				else
				{	

					if($coupon_data['status']=='2'){
						$result['status'] = 1;	
						session('sn',$sn);
						$order_detal=M('zjy_route_order_detail')->field('guest_name,guest_type,paper_type,paper_number')->where('order_id='.$coupon_data['id'])->select();
						$guest_msg="<br><br>联系人:".$coupon_data['user_name']."&nbsp;联系方式:".$coupon_data['mobile']."<br><br>旅客信息:<br><br>姓名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否成年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;证件类型&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;证件号码<br><br>";

						foreach ($order_detal as $k => $v) {
							switch ($v['paper_type']) {
								case '1':
									$paper_info='身份证';
									break;
								case '2':
									$paper_info='回乡证';
									break;
								case '3':
									$paper_info='护照';
									break;
								case '4':
									$paper_info='双程证';
									break;
								default:
									$paper_info='身份证';
									break;
							}
							$guest_type=$v['guest_type']==1?'成人':'儿童';
							$guest_msg.= $v['guest_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$guest_type."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$paper_info."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v['paper_number']."<br><br>";
						}
						$result['msg'] = "该服务码所预订的路线为[".$coupon_data['name']."],已在线支付￥".price($coupon_data['total_price'])."请确认已服务<br>".$guest_msg;	
						$this->ajaxReturn($result);
					}else{
						$result['status'] = 0;
						$result['msg'] = '无效的验证码';	
						$this->ajaxReturn($result);
					}
					
				}
			}
			else
			{		
					$result['status'] = 0;
					$result['msg'] = '无效的验证码';	
					$this->ajaxReturn($result);
			}
		
	}
	public function user_account(){
		$agency_info=session('agency_info');
		if(!$agency_info['id']){
			$this->ajaxReturn(U('Agency/login'),'请重新登录',0);
		}		
		$now = time();
		$sn=session('sn');
		$agency_id = intval($agency_info['id']);
		
		$coupon_data=M('zjy_coupon')->join('fw_zjy_route_order as zro on fw_zjy_coupon.order_id=zro.id')->field('fw_zjy_coupon.id,fw_zjy_coupon.agency_id,fw_zjy_coupon.route_id,fw_zjy_coupon.confirm_time,zro.status,zro.total_price,zro.name,zro.id as order_id')->where("fw_zjy_coupon.sn='".$sn."' and fw_zjy_coupon.agency_id=".$agency_id." and fw_zjy_coupon.is_valid=1 and fw_zjy_coupon.is_delete=0")->find();
	
		if($coupon_data)
			{
				$route_info=M('zjy_route')->where('id='.$coupon_data['route_id']." and agency_id =".$agency_id)->find();
				
				if(!$route_info)
				{
					$result['status'] = 0;
					$result['msg'] = '没有权限';
					$this->ajaxReturn($result);
				}
				
				if($coupon_data['agency_id']!=$agency_id)
				{
					$result['status'] = 0;
					$result['msg'] = '该券为其他团购商户的团购券，不能确认';
					$this->ajaxReturn($result);
				}
				elseif($coupon_data['confirm_time'] > 0)
				{
					$result['status'] = 0;
					$result['msg'] = '该服务券已于'.date('Y-m-d H:i:s',$coupon_data['confirm_time'])."使用";
					$this->ajaxReturn($result);
				}
				else
				{				
					$data['confirm_status']=1;
					$data['confirm_time']=$now;
					$r=M('zjy_coupon')->where(array('id'=>intval($coupon_data['id'])))->save($data);
					$d['status']='4';
					$r1=M('zjy_route_order')->where(array('id'=>$coupon_data['order_id']))->save($d);
					if($r&&$r1){
						$result['status'] = 1;
						$result['msg'] = $coupon_data['name']."确认成功,确认时间为:".date('Y-m-d H:i:s',$now);
					}else{
						$result['status'] = 0;
						$result['msg'] = "验证失败,请重新验证";
					}
					

					$this->ajaxReturn($result);
				}
			}
			else
			{		
				$result['status'] = 0;
				$result['msg'] = "验证失败,请重新验证";
				$this->ajaxReturn($result);
			}
	}

	public function login(){
		if(!session('agency_info')){
			$this->display();
		}else{
			header("Location:".U("Agency/index"));
		}	
	
	}

	public function ajax_login(){
			$agency_name = trim($_REQUEST['username']);
			$agency_password = trim($_REQUEST['password']);
			if(!$agency_name){
				$this->ajaxReturn(0,'用户名不能为空!',0);
			}
			if(!$agency_password){
				$this->ajaxReturn(0,'密码不能为空!',0);
			}
			$agency=M("zjy_agency")->where(array('user_name'=>$agency_name,'is_effect'=>1,'status'=>1))->find();			
			if($agency){	
				if($agency['user_pwd']==md5($agency_password)){
					session('agency_info',$agency);
					$d['login_time']=time();
					$d['login_ip']=get_client_ip();
					$r=M("zjy_agency")->where(array('id'=>intval($agency['id'])))->save($d);				
					$this->ajaxReturn(0,U('Agency/index'),1);
				}else{
					$this->ajaxReturn(0,'用户名或密码错误!',0);
				}				
			}else{
				$this->ajaxReturn(0,'用户名或密码错误!',0);
			}		
	
	}

	public function order(){		
		$this->check_login();
			
		
		$status=intval($_REQUEST['status']);
		
       	$this->assign("status",$status);
		$this->display();
	}
	public function ajax_get_order()
	{
		$agency_info=session('agency_info');
		$page=$_REQUEST['p'];
		$where="fw_zjy_route_order.agency_id= ".intval($agency_info['id']);
		$status=intval($_REQUEST['status']);
		if($status){
			$where.=" and fw_zjy_route_order.status='".$status."'";
		}else{
			$where.=" and fw_zjy_route_order.status in('2','4')";
		}
		$route=M('zjy_route_order')->field('zr.brief,zr.market_price,zr.img,zr.adult_price,fw_zjy_route_order.*')->join('fw_zjy_route as zr on zr.id=fw_zjy_route_order.route_id')->where($where)->limit($page*8,8)->select();
	
		foreach ($route as $k => $v) {	
			if($v['img'])
			$route[$k]['img']="http://image.17cct.com".$v['img']."!tiny";			
			$route[$k]['pay_url']=U('Route/pay',array('id'=>$v['id']));	
		}
		$this->assign('list',$route);
		echo $html=$this->fetch();
	}

	 public function fast_order()
	{
		if(!session('account_info')){
			header("Location:".U("Biz/index"));
		}
		$account_info=session('account_info');

		$s_locations = M("supplier_location")->field('id,name,address,tel,mobile')->where(array('supplier_id'=>intval($account_info['supplier_id'])))->select();
		$s_locations_ids=array();
		foreach ($s_locations as $k => $v) {
			array_push($s_locations_ids, $v['id']);
		}
		$fast_order_count = M("msg")->where('sid in  ('.implode(",",$s_locations_ids).')')->order('addtime desc')->count();

		if(!$fast_order_count||$fast_order_count<8){
			$fast_order_count=1;
		}else{		
			$fast_order_count=round(($fast_order_count/8));
		}
        $this->assign("fast_order_count",$fast_order_count);
		$this->display();
	}

	public function ajax_get_fast_order()
	{
		$account_info=session('account_info');

		$page=intval($_GET['p'])-1;
		if($page<0) die();
		$limit=($page*8).",8";

		$s_locations = M("supplier_location")->field('id,name,address,tel,mobile')->where(array('supplier_id'=>intval($account_info['supplier_id'])))->select();
		$s_locations_ids=array();
		foreach ($s_locations as $k => $v) {
			array_push($s_locations_ids, $v['id']);
		}
		$result = M("msg")->where('sid in  ('.implode(",",$s_locations_ids).')')->order('addtime desc')->limit($limit)->select();
		$this->ajaxReturn(0,$result,0);
	}
 
}
?>