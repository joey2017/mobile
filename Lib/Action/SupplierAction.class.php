<?php
// 本类由系统自动生成，仅供测试用途
require_once 'jiami.php';
class SupplierAction extends SupBaseAction {

	/**
     * 权限白名单，白名单中的操作方法不受权限限制
     * 该名单主要用于一些特殊无涉及权限分配的方法
     *
     * @var array
     * @access protected
     */
    protected $accessAllowed = array(
        'ajaxModifyPassWord','index','authorize_add','authorize_del'
        );
	
    public function _initialize()
    {
        parent::_initialize();
    }
    public function index(){

		$pms_supplier = session('pms_supplier');

		//收益 未结，已结， 累计
		$commission=M('pms_shop_commission')
            ->field('commission,is_settlement')
            ->where('type=2 and shop_type=1 and shop_id='.intval($pms_supplier['supplier_id']))
            ->select();
        $commission_list = array();
		foreach ($commission as $k => $v) {

			$commission_list['total']+=$v['commission'];
			if($v['is_settlement']){
				$commission_list['settled']+=$v['commission'];
			}else{
				$commission_list['not_settled']+=$v['commission'];
			}	
		}

		//发展门店数
		$location_num=M('agent_qrcode')->where('type=1 and shop_id='.intval($pms_supplier['supplier_id']))->getField('register_num');
		//首页信息
		$top_count = $this->get_purchase_info();
		$this->shop_count();
		$this->assign('title','供应商中心');
		$this->assign('location_num',$location_num);
		$this->assign('top_count',$top_count);
		$this->assign('commission_list',$commission_list);
		$this->assign('supplier',$pms_supplier);
		$this->display();
	}

	//收入列表
	public function income(){

		$pms_supplier=session('pms_supplier');

		$commission_list=M('pms_shop_commission')->field('commission,create_time,is_settlement')->where('shop_type=1 and shop_id='.intval($pms_supplier['supplier_id']))->select();		

		//今日
		$stime = strtotime(date('Y-m-d'));
	   	$etime = $stime+86399;

		//昨日
		$lastday_first=strtotime(date("Y-m-d",strtotime("-1 day")));
		$lastday_end=$stime;
		
		//今年
		$thisyear_first=strtotime(date('Y').'-1-1');
		$thisyear_end=$stime;
		
		//当月
	   	$thismoon_first=mktime(0,0,0,date('m'),1,date('Y'));
		$thismoon_end=mktime(23,59,59,date('m'),date('t'),date('Y'));

		//上月
		$lastmoon_first = date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))); //上个月的开始日期
		$lastmoon_end = date('Y-m-d', mktime(0,0,0,date('m')-1,$t,date('Y'))); //上个月的结束日期
		

		foreach ($commission_list as $k => $v) {
			$time=$v['create_time'];			
			if($time>=$stime&&$time<=$etime){
				$commission['today']+=$v['commission'];
			}
			if($time>=$lastday_first&&$time<=$lastday_end){
				$commission['lastday']+=$v['commission'];
			}
			if($time>=$thisyear_first){
				$commission['thisyear']+=$v['commission'];
			}
			if($time>=$thismoon_first&&$time<=$thismoon_end){
				$commission['thismoon']+=$v['commission'];
			}
			if($time>=$lastmoon_first&&$time<=$lastmoon_end){
				$commission['lastmoon']+=$v['commission'];
			}
		}
		$this->assign('title','收入统计');
		$this->assign('supplier',$pms_supplier);
		$this->assign('commission',$commission);
		$this->display();
	}

	//发展门店列表
	public function location(){
		
		//$month_first_day=mktime(0,0,0,date('m'),1,date('Y'));//月初
		//$month_now_day=time();//当前时间
		$start_time=htmlspecialchars(addslashes(trim($_REQUEST['start_time'])));
		$end_time=htmlspecialchars(addslashes(trim($_REQUEST['end_time'])));
		$employee_id=intval($_REQUEST['employee_id']);

		$start_time=$start_time==''?$month_first_day:$start_time;
		$end_time=$end_time==''?$month_now_day:$end_time;

		$t_start_time=strtotime($start_time);
		$t_end_time=strtotime($end_time);
		if($_REQUEST['is_redirect']==1)
		{
			redirect(U('Supplier/location',array("id"=>$n_location_id,"start_time"=>$t_start_time,"end_time"=>$t_end_time,"employee_id"=>$employee_id)));
		}

		if(isset($start_time)&&is_numeric($start_time)&&$start_time!=0&&isset($end_time)&&is_numeric($end_time)&&$end_time!=0){	
			$month_first_day=$start_time;
			$month_now_day=$end_time+60*60*24;
			$where.=" and fao.pay_time between ".$month_first_day." and ".$month_now_day;	 
		}

		$pms_supplier=session('pms_supplier');

		if($employee_id&&$pms_supplier['is_authority']){
			$where.=" and af.shop_user_id=".$employee_id;
		}elseif($pms_supplier['is_authority']==0){
			$where.=" and af.shop_user_id=".$pms_supplier['id'];
		}


		
		$location = M('agent_fans as af')->field('fsl.name,fsl.address,fsl.mobile,fpsa.a_name')->join('fw_pms_supplier_account as fpsa on fpsa.id=af.shop_user_id')->join('fw_supplier_location as fsl on fsl.id=af.location_id')->join('fw_agent_order as fao on fao.open_id=af.open_id')->where('af.shop_type=1 and af.shop_id='.intval($pms_supplier['supplier_id'])." and af.location_id!=''".$where)->select();
		
		$count=M('agent_fans as af')->join('fw_pms_supplier_account as fpsa on fpsa.id=af.shop_user_id')->join('fw_supplier_location as fsl on fsl.id=af.location_id')->join('fw_agent_order as fao on fao.open_id=af.open_id')->where('af.shop_type=1 and af.shop_id='.intval($pms_supplier['supplier_id'])." and af.location_id!=''".$where)->count();
		
		foreach ($location as $k => $v) {
			if(!$v['a_name']){
				$location[$k]['a_name']=$pms_supplier['name'];
			}
		}
		if($pms_supplier['is_authority']){
			$employee=M('pms_supplier_account')->where('supplier_id='.intval($pms_supplier['supplier_id'])." and is_del=0")->select();
		}
		
		$this->assign('count',intval($count));
		$this->assign('price',$count*500);
		$this->assign('location',$location);
		$this->assign('supplier',$pms_supplier);
		$this->assign("employee_id",$employee_id);
		$this->assign("employee",$employee);
		$this->assign("commission",$commission);
		$this->assign("start_time",$start_time);
		$this->assign("end_time",$end_time);
		$this->assign('title','发展门店');
		$this->display();
	}

	//推广
	public function myagent(){

		$agent_code=$_GET['code'];

		if($agent_code){

				//员工帐号id及类型数组
				$info=explode('_',passport_decrypt($agent_code,'17cct_com_supplier_agent_key'));	
			  	
			  	//type=1为供应商,2为门店
			  	if($info[1]==1){
			  		$pms_supplier=M('pms_supplier as ps')->field('ps.id,ps.name,fpsa.a_name,fpsa.img')->join('fw_pms_supplier_account as fpsa on fpsa.supplier_id=ps.id')->where('fpsa.id='.$info[0])->find();	
			  		
			  	}else{
			  		$pms_supplier=M('supplier_location as sl')->field('sl.id,sl.name,fsa.account_name as a_name')->join('fw_supplier_account_location_link as fsall on fsall.location_id = sl.id')->join('fw_supplier_account as fsa on fsa.id=fsall.account_id')->where('fsall.account_id='.$info[0])->find();
			  	}

			  	if(!$pms_supplier){
			  		$this->error('该链接为无效链接',U('Index/index'),3);
			  	}
			  
			  	//门店二维码信息
			  	$qrcode_info=M('agent_qrcode')->where('shop_id='.$pms_supplier['id']." and type=".$info[1])->find();

			  	import('@.ORG.Wechat');
				if(!$this->wxAPI)
				$this->wxAPI = new Wechat();

				//二维码id
				$open_id=session('oprate_opend_id');
				
				//微信token
				$token = getshopAccToken();

			  	//获取用户微信基本信息
			    $user_data=$this->wxAPI->get_wx_info($open_id,$token);	   	  		  			 
			    
		  		$fans=M('agent_fans')->where("open_id='".$open_id."'")->find();

		  		if($fans==null&&$open_id)//首次访问
		  		{	
		  			$d['open_id']=$open_id;
		  			$d['qrcode_id']=$qrcode_info['id'];
			  		$d['shop_user_id']=$info[0];
					$d['shop_id']=intval($pms_supplier['id']);		
					$d['shop_type']=intval($info[1]);
					$d['location_id']=0;
					$d['is_vip']=0;
					$d['add_time']=time();
					if($user_data['nickname'])
		  			$d['nickname']=$user_data['nickname'];  			
		  				
		  			M('agent_fans')->add($d);	  			
		  		}else{
		  			if($fans['is_submit']==0&&$open_id){
		  				//更新扫描信息 	
			  			$d['shop_user_id']=$info[0];
			  			$d['qrcode_id']=$qrcode_info['id'];
						$d['shop_id']=intval($pms_supplier['id']);		
						$d['shop_type']=intval($info[1]);
						$d['add_time']=time();
						if($user_data['nickname'])
			  			$d['nickname']=$user_data['nickname'];  
			  			M('agent_fans')->where('id='.$fans['id'])->save($d);
		  			}	  			
		  		}		

		  	$qrcode=$qrcode_info['qrcode'];

		}else{

			//登录信息
			$pms_supplier=session('pms_supplier');

			//门店二维码
			$qrcode=M('agent_qrcode')->where('type=1 and shop_id='.intval($pms_supplier['supplier_id']))->getField('qrcode');	

			
			$key="17cct_com_supplier_agent_key";

			$agent_code=trim(passport_encrypt($pms_supplier['id'].'_1',$key));
		
		}
		$qrcode_shop_count=intval(M('agent_qrcode')->count())+1000;
		//已加入门店数,不够五位用0补充
		$shop_count=str_split(sprintf("%05d",$qrcode_shop_count));

		$nonceStr=createNonceStr();
		$this->assign('nonceStr',$nonceStr);//随机串
		$time=time();	
	    $ticket=get_jsdk_ticket();
	    $config_sign=sha1("jsapi_ticket=".$ticket."&noncestr=".$nonceStr."&timestamp=".$time."&url=".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	    $this->assign('time',$time);
	    $this->assign('sign',$config_sign);	  
	    $this->assign('pms_supplier',$pms_supplier);
	    $this->assign('qrcode',$qrcode);
	    $this->assign('agent_code',$agent_code);		 
	    $this->assign('shop_count',$shop_count);
	    $this->assign('title','我要推广');
		$this->display();
	}



	public function get_open_id(){
		$code=$_GET['code'];
		$refererUrl = U('Supplier/myagent',array('code'=>$code)); //登录前一个页面的Url		
		$redirectUrl = urlencode(DOMAIN_URL.U('Agent/OAuth_wx'));  //授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
		$Url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb09359ac1d3f2267&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=".$refererUrl."#wechat_redirect";
		header("Location:".$Url);
	}

	/*public function agent(){		

			$code=$_GET['code'];

			//员工帐号id及类型数组
			$info=explode('_',passport_decrypt($code,'17cct_com_supplier_agent_key'));	
		  	
		  	//type=1为供应商,2为门店
		  	if($info[1]==1){
		  		$shop_info=M('pms_supplier as ps')->field('ps.id,ps.name,fpsa.a_name')->join('fw_pms_supplier_account as fpsa on fpsa.supplier_id=ps.id')->where('fpsa.id='.$info[0])->find();	
		  		
		  	}else{
		  		$shop_info=M('supplier_location as sl')->field('sl.id,sl.name,fsa.account_name as a_name')->join('fw_supplier_account_location_link as fsall on fsall.location_id = sl.id')->join('fw_supplier_account as fsa on fsa.id=fsall.account_id')->where('fsall.account_id='.$info[0])->find();
		  	}

		  	if(!$shop_info){
		  		$this->error('该链接为无效链接',U('Index/index'),3);
		  	}

		  
		  	//门店二维码信息
		  	$qrcode_info=M('agent_qrcode')->where('shop_id='.$shop_info['id']." and type=".$info[1])->find();

		  	import('@.ORG.Wechat');
			if(!$this->wxAPI)
			$this->wxAPI = new Wechat();


			//已加入门店数,不够五位用0补充
			$shop_count=str_split(sprintf("%05d",M('agent_qrcode')->count()));

			//二维码id
			$open_id=session('oprate_opend_id');
			
			//微信token
			$token = getshopAccToken();

		  	//获取用户微信基本信息
		    $user_data=$this->wxAPI->get_wx_info($open_id,$token);	   	  		  			 
		    
	  		$fans=M('agent_fans')->where("open_id='".$open_id."'")->find();

	  		if($fans==null)//首次访问
	  		{	
	  			$d['open_id']=$open_id;
	  			$d['qrcode_id']=$qrcode_info['id'];
		  		$d['shop_user_id']=$id;
				$d['shop_id']=intval($shop_info['id']);		
				$d['shop_type']=intval($type);
				$d['location_id']=0;
				$d['is_vip']=0;
				$d['add_time']=time();
				if($user_data['nickname'])
	  			$d['nickname']=$user_data['nickname'];  			
	  				
	  			M('agent_fans')->add($d);	  			
	  		}else{
	  			if($fans['is_submit']==0){
	  				//更新扫描信息 	
		  			$d['shop_user_id']=$id;
		  			$d['qrcode_id']=$qrcode_info['id'];
					$d['shop_id']=intval($shop_info['id']);		
					$d['shop_type']=intval($type);
					$d['add_time']=time();
					if($user_data['nickname'])
		  			$d['nickname']=$user_data['nickname'];  
		  			M('agent_fans')->where('id='.$fans['id'])->save($d);
	  			}	  			
	  		}		

	  	$this->assign('agent_code',$code);
	  	$this->assign('pms_supplier',$shop_info);	
	  	$this->assign('shop_count',$shop_count);
	  	$this->assign('qrcode',$qrcode_info['qrcode']);
		$this->display();
				
	}	*/


	//修改密码
	public function password(){
		$pms_supplier=session('pms_supplier');
		$this->assign('supplier',$pms_supplier);
		$this->display();
	}
	
	//ajax 修改密码
	public function ajaxModifyPassWord()
	{	
		

		$new_pwd1   = trim($_REQUEST['new_pwd1']);
		$new_pwd2   = trim($_REQUEST['new_pwd2']);
		$reg = '/^[a-zA-Z0-9]+$/';		
		
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

		$pms_supplier=session('pms_supplier');
		
		$pwd =md5(htmlspecialchars(addslashes($new_pwd1)));
		$r = M('pms_supplier_account')->where(array('id'=>$pms_supplier['id']))->setField('a_password',$pwd);	
		if ($r) {
			
			$this->ajaxReturn(U('Supplier/index'),"修改成功",1);
		} else {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);	
		}
	}


	//微信授权、用于门店下单系统推送消息
	public function authorize(){

		// $this->check_login();

		$pms_supplier=session('pms_supplier');
		$supplier_id = $pms_supplier['supplier_id'];

		$open_id=session('oprate_opend_id');
		if(!$open_id){
			$refererUrl = U('Supplier/authorize'); //登录前一个页面的Url		
			$redirectUrl = urlencode(DOMAIN_URL.U('Agent/OAuth_wx'));  //授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
			$Url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb09359ac1d3f2267&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=".$refererUrl."#wechat_redirect";
			header("Location:".$Url);
		}

		$info = M('pms_weixin')->where(array('relation_id'=>$supplier_id,'open_id'=>$open_id,'type'=>2))->find();

		$this->assign('info',$info);
		$this->display();
	}
	
	//授权
	public function authorize_add(){
		if(!session('pms_supplier')){
			$this->ajaxReturn(U('Supplier/login'),'请重新登录',0);
		}

		$pms_supplier=session('pms_supplier');
		$supplier_id = $pms_supplier['supplier_id'];

		$open_id=session('oprate_opend_id');

		if(!$open_id){
			$this->ajaxReturn(U('Supplier/authorize'),'请重新授权',0);
		}

		$info = M('pms_weixin')->where(array('relation_id'=>$supplier_id,'open_id'=>$open_id,'type'=>2))->find();

		if($info){
			$this->ajaxReturn(U('Supplier/authorize'),'您已授权，无需重复授权',0);
		}

		$data['account_id'] = $pms_supplier['id'];
		$data['account_name'] = $pms_supplier['a_name'];
		$data['open_id'] = $open_id;
		$data['relation_id'] = $supplier_id;
		$data['type'] = 2;
		$data['create_time'] = time();

		$result = M('pms_weixin')->add($data);

		if($result){
			$this->ajaxReturn(U('Supplier/authorize'),'授权成功',1);
		}else{
			$this->ajaxReturn(U('Supplier/authorize'),'授权失败，请重新授权',0);
		}
	}

	//删除授权
	public function authorize_del(){
		if(!session('pms_supplier')){
			$this->ajaxReturn(U('Supplier/login'),'请重新登录',0);
		}

		$pms_supplier=session('pms_supplier');
		$supplier_id = $pms_supplier['supplier_id'];

		$open_id=session('oprate_opend_id');

		if(!$open_id){
			$this->ajaxReturn(U('Supplier/authorize'),'信息不存在',0);
		}

		$info = M('pms_weixin')->where(array('relation_id'=>$supplier_id,'open_id'=>$open_id,'type'=>2))->find();

		if(!$info){
			$this->ajaxReturn(U('Supplier/authorize'),'信息不存在',0);
		}

		$result = M('pms_weixin')->where(array('relation_id'=>$supplier_id,'open_id'=>$open_id,'type'=>2))->delete(); 

		if($result){
			$this->ajaxReturn(U('Supplier/index'),'取消授权成功',1);
		}else{
			$this->ajaxReturn(U('Supplier/authorize'),'取消授权失败',0);
		}
	}

	public function shop_count(){
		
		$login_info = session('pms_supplier');
		$where = array(
            'supplier_id' => $login_info['supplier_id'],
            'pay_status'  => array('in', array(1,2)),
            'is_del'      => 0,
            'system'      => 0,
            'is_refund'   => 0,
        );

		//供应商名称
		$supplier_name = M('pms_supplier')
            ->field('name')
            ->where("is_del = 0 and id =".$login_info['supplier_id'])
            ->find();

        //登录账号
		$supplier_account = M('pms_supplier_account')
            ->field('a_name')
            ->where("is_del = 0 and id =".$login_info['id'])
            ->find();

	  	//客户总数
		$member_count_sum = M('pms_location')
            ->where('is_del=0 and supplier_id='.$login_info['supplier_id'])
            ->count();

		//本周交易的开始时间跟结束时间
		$this_Mon = mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"));
        $this_Sun = mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y")); 
		$where['pay_time'] = array('between',array($this_Mon,$this_Sun));
        $this_week_total = M('pms_order')
            ->where($where)
            ->sum('total_price');

		//本月交易
		$this_moon_first = mktime(0,0,0,date('m'),1,date('Y'));
		$this_moon_end   = mktime(23,59,59,date('m'),date('t'),date('Y'));
        $where['pay_time'] = array('between',array($this_moon_first,$this_moon_end));
		$this_moon_total = M('pms_order')
            ->where($where)
            ->sum('total_price');

	    $this->assign("supplier_name",$supplier_name);
	    $this->assign("supplier_account",$supplier_account);
	    $this->assign('this_week_total',$this_week_total);
	    $this->assign('this_moon_total',$this_moon_total);
	    $this->assign('member_count_sum',$member_count_sum);
	}


	/**
     * 顶部信息(订单、成交金额、未处理订单)
     * 通知信息
     **/

    protected function get_purchase_info()
    {

        $stime       = strtotime(date('Y-m-d'));
        $etime       = $stime + 86399;
        $login_info  = session('pms_supplier');
        $supplier_id = $login_info['supplier_id'];
        $account_id  = $login_info['id'];
        $where['is_del']      = 0;
        $where['is_refund']   = 0;
        $where['system']      = 0;
        $where['supplier_id'] = $supplier_id;
        $where['pay_status']  = array('in','1,2');
        $map['pay_time']      = array('between',array($stime, $etime));

        $order = M('pms_order')->field('total_price')->where($where)->where($map)->select();

        $where['status'] = array('in','1,2,3');
        $where['type']   = array('in','0,2');

        $untreated_order = M('pms_order')->field('total_price')->where($where)->select();

        $top_count['count'] = $top_count['total_price'] = $top_count['untreated_count'] = 0;
        foreach ($order as $k => $v) {
            $top_count['count']++;
            $top_count['total_price'] += $v['total_price'];
        }
        foreach ($untreated_order as $k => $v) {
            $top_count['untreated_count']++;
        }

        return $top_count;

    }

}