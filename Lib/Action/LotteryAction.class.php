<?php
// 本类由系统自动生成，仅供测试用途
class LotteryAction extends BaseAction {

    public function index(){   
	    //先注册并登录才能进入页面
	    isLogin(U('Lottery/index'));		
    	$user_list=M('activity_lottery_record')->select();
    	foreach ($user_list as $k => $v) {
    		$user_list[$k]['mobile']=substr_replace($v['mobile'], '***',3,4);
    		switch ($v['prize_id']) {
    			case '1':
    				$prize='一等奖';
    				break;
    			case '2':
    				$prize='二等奖';
    				break;
    			case '3':
    				$prize='三等奖';
    				break;
    			case '4':
    				$prize='四等奖';
    				break;
    			case '5':
    				$prize='五等奖';
    				break;
    			case '6':
    				$prize='幸运奖';
    				break;
    		}
    		$user_list[$k]['prize']=$prize;
    	}
    	$this->assign('user_list',$user_list);
    	$this->assign('title','购新年美车套餐，赢大奖，中奖率100%');
		$this->display();
	}


	//抽奖程序
	public function get_activity_prize(){
		
		//未输入密码
		if(!session('location_num')){
			$this->ajaxReturn(0,"请让店长输入密码获取抽奖权限",0);
		}

		$uid = intval(session('uid'));//3682;

		//已经抽过奖
		$lottery_record=M('activity_lottery_record')->where('user_id='.$uid)->find();
		if($lottery_record||$uid==0){
			$this->ajaxReturn(-1,"您已经抽过奖了,做人不能太贪哦",-1);
		}

		//能抽奖的奖品
		$prize=M('activity_prize')->where('num>0')->select();
		if(!$prize){
			$this->ajaxReturn(-1,"您来晚了,奖品都被抽完了",-1);
		}
		//中奖号码
		$lottery_num=mt_rand(0,count($prize)-1);

		$lottery_prize=$prize[$lottery_num];		

		$user_info=session('user_info');//M('user')->where('id=3682')->find();

		$data['user_name']=$user_info['true_name'];
		$data['user_id']  =$user_info['id'];
		$data['mobile']=$user_info['mobile'];
		$data['location_id']=session('location_num');
		$data['add_time']=time();
		$data['prize_id']=$lottery_prize['id'];
		$data['prize_name']=$lottery_prize['prize_name'];

		$add_result=M('activity_lottery_record')->add($data);
		if($add_result){
			M('activity_prize')->where('id='.$lottery_prize['id'])->setDec('num');
			session('location_num',0);
			$this->ajaxReturn(($lottery_prize['id']-1)*60,"恭喜您抽中了【".$lottery_prize['prize_name'].'】',$lottery_prize['id']);
		}else{
			$this->ajaxReturn(-1,"差点就抽奖了,再试一次看看",-1);
		}

	}

	//验证门店密码
	public function set_location_pass(){
		$pass=trim($_POST['pass']);
		if(!$pass){
			$this->ajaxReturn(0,"请让店长输入密码获取抽奖权限",0);
		}

		//门店验证码列表 982=优轮家恒大新城店:30953327,981=优轮家白云店:25957889,980=D驾族青山店:87920162,254=车宝堂一号店:69705392
		$list=array('69705392'=>254,'30953327'=>982,'25957889'=>981,'87920162'=>980);

		if(!$list[$pass]){
			$this->ajaxReturn(0,"密码输入不正确",0);
		}else{
			session('location_num',$list[$pass]);
			$this->ajaxReturn(1,"密码输入正确,请进行抽奖",1);
		}

	}





	public function prize_list()
	{
		$pid=$_REQUEST['pid'];//中奖奖项id
		$rid=$_REQUEST['rid'];//中奖记录id
		if(!$pid||!$rid){
			header("Location:".U("Lottery/index"));
		}
		$list=M("lottery_prize_list")->field('img,id,name,shop_id')->where("prize_id=".$pid." and num>0")->select();
		foreach ($list as $k => $v) {
			$si=M('supplier_location')->field('address,name,tel')->where('id='.$v['shop_id'])->find();
			$list[$k]['address']=$si['address'];
			$list[$k]['sp_name']=$si['name'];
			$list[$k]['tel']=$si['tel'];
		}		
        $this->assign('rid',$rid);
		$this->assign('list',$list);	
		$this->display();
	}
	public function select_prize()
	{
		$rid=$_REQUEST['rid'];//记录id
		$pid=$_REQUEST['pid'];//lottery_prize_list的奖品id
		$lr=M('lottery_record')->field('prize_id')->where('id='.$rid)->find();
		$data=M("lottery_prize_list")->field('num,name,shop_id,end_time,prize_id')->where("id=".$pid)->find();		
		if(!$pid||!$rid||$lr['prize_id']!=$data['prize_id']){
			$result['info']="请不要兑换不是您的奖品,谢谢合作!";
			$result['status']=0;
			echo json_encode($result);	
			return;		
		}				
		$d['num']=$data['num']-1;		
		if($d['num']<0){
			$result['info']="奖品前一秒被别人兑换完了,另选一个吧!";
			$result['status']=0;
			echo json_encode($result);	
			return;
		}
		$r1=M('lottery_prize_list')->where("id=".$pid)->save($d);
		if($r1){
			$d['pid']=$pid;
			$r2=M('lottery_record')->where('id='.$rid)->save($d);
			if($r2){
				$user=M('user')->field('mobile,user_name,true_name')->where('id='.session('uid'))->find();	
				$shop_info=M('supplier_location')->field('address,name,tel')->where('id='.$data['shop_id'])->find();		
					if($user['mobile']){								
						// $c=$user['true_name'].",恭喜您抽奖中了".$data['name'].",请于8月17日前到".$shop_info['name']."领取,联系电话:".$shop_info['tel']."[诚车堂]";		
						$c=$user['true_name'].",恭喜您抽奖中了".$data['name'].",请于8月17日前到".$shop_info['name']."领取,联系电话:".$shop_info['tel'];		
						send_sms($user['mobile'],$c);
					}
				$result['msg']=$user['true_name'].",恭喜您抽奖中了".$data['name'].",请于8月17日前到".$shop_info['name']."领取,地址:".$shop_info['address'].",联系电话:".$shop_info['tel']."【诚车堂】";
				
				$result['info']="奖品选择成功!";
				$result['status']=1;
				echo json_encode($result);	
			}else{
				$result['info']="奖品选择失败!";
				$result['status']=0;
				echo json_encode($result);	
			}
		}else{
			$result['info']="奖品选择失败!";
			$result['status']=0;
			echo json_encode($result);	
		}
		
		
	}
	public function see_prise()
	{
		$list=M("lottery_prize")->where("lid=2 and prize_type=1")->order("sort")->select();		
		foreach ($list as $key => $value) {
			$list[$key]['p']=M("lottery_prize_list")->field('img,fw_lottery_prize_list.name,fsl.address,fsl.name as sp_name,fsl.tel,num,shop_id')->join('fw_supplier_location as fsl on fsl.id=fw_lottery_prize_list.shop_id')->where("prize_id=".$value['id'])->select();
		}	
		
		$this->assign("list",$list);
		$this->display();
	}

	//分享到朋友圈获得再抽一次的机会
	public function tO_friend()
	{
		if(isset($_SESSION['zcyc']))
		{
			echo "您已经分享过了，每天只能使用一次。明天再来吧，我们等着你^_^";

		}else{

			session("zcyc",1);//赐予一次抽奖机会
			echo "愿意分享的人永远是好人，恭喜你获得了一次抽奖的机会。快去抽奖吧，愿幸运女神保护你！";

		}
	}

		//获取抽奖
	public function get_prize()
	{
			$start_time=strtotime(date('Y-m-d'));
			$end_time=strtotime(date('Y-m-d',strtotime('+1 day')));
			$map['addtime']  = array('between',array($start_time,$end_time));
			$map['user_id']=array('eq',session('uid'));
			$count=M('lottery_record')->where($map)->count();
			if($count>=4){
				$result['angle'] =-1;
				$result['prize'] = "分享到朋友圈每天只能使用一次,明天再接再厉☺"; 
				echo json_encode($result);
				exit;
			}
			if($count>=3){				
			  if(isset($_SESSION['zcyc'])&&$_SESSION['zcyc']==1)
				{
					session("zcyc",2);

				}else if(isset($_SESSION['zcyc'])&&$_SESSION['zcyc']==2){
						$result['angle'] =-1;
						$result['prize'] = "分享到朋友圈每天只能使用一次,明天再接再厉☺"; 
						echo json_encode($result);
						exit;

				}else{
					$result['angle'] =-1;
					$result['prize'] = "您今天已经抽过三次奖了,如果你点击右上角的菜单，然后分享到朋友圈。你就可以获得再抽一次机会哦！"; 
					echo json_encode($result);
					exit;
				}
			}
			
			
		    $list=M("lottery_prize")->where("lid=2 ")->order('sort asc')->select();

		    $raido=45;
		    foreach ($list as $key => $value) {
		    	$prize_arr[$key]=array('id'=>$value['id'],'min'=>$key*$raido,'max'=>($key+1)*$raido,'prize'=>$value['prize_name'],'v'=>$value['chance'],'t'=>$value['prize_type'],"num"=>$value['prize_num']);
		    }	 

			foreach ($prize_arr as $key => $val) { 
			    $arr[$key] = $val['v']; 
			} 			 
			$rid =$this->getRand($arr); //根据概率获取奖项id

			$res = $prize_arr[$rid]; //中奖项	
				
			//当所抽中的奖项奖品数量为0时则重新抽，直到抽到奖品数量不为0的			
			while ($res['num']==0) {
				$rid =$this->getRand($arr); //根据概率获取奖项id 
				$res = $prize_arr[$rid]; //中奖项					
			}			
			$data['user_id']=session('uid');
			$data['addtime']=time();		
			if($res['t']){
				$data['status']=1;//中奖未领取	
				$result['status']=$res['id'];
				$d['prize_num'] = array('exp','prize_num-1');
				$r1=M('lottery_prize')->where('id='.$res['id'])->save($d);
			}else{
				$data['status']=0;//未中奖
				$result['status']=-1;
			}			
			$data['prize_id']=$res['id'];		
			$r=M('lottery_record')->add($data);
			if($r){	
				//if($r1){
					$min = $res['min']; 
					$max = $res['max']; 
					$result['info']=$r;
					$result['angle'] = mt_rand($min,$max); //随机生成一个角度 
					$result['prize'] = "恭喜您，抽中了".$res['prize']; 	
					
				/*}else{
					$result['angle'] = -3;
					$result['prize'] = "转得有点晕,再转一次吧!"; 
				}	*/	 
			
			}else{
				$result['angle'] = -2;
				$result['prize'] = "转得有点晕,再转一次吧!"; 		 
					
			}
			echo json_encode($result);	 
	}
	function send_msg(){

			$access_token=$this->get_acc_token();
			$jsonData='{"touser":"'.session('wxid').'","msgtype":"text","text":{"content":"'.$_REQUEST['prize']."".'"}}';
			$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
			
			$ch = curl_init($url) ;
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			$result_data = curl_exec($ch) ;
			curl_close($ch) ;
			$r3=json_decode($result_data,true);

	}
	function get_acc_token()
	{
				//获取access_token
				$ch = curl_init();
				$timeout = 5;
				curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx7ea1cd13c9f42d97&secret=3d55215b8df74e2c5d468e975c94e48e");
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$access_token = curl_exec($ch);
				$access_token=json_decode($access_token, true); 
				return $access_token['access_token'];
	}
	function getRand($proArr) { 
	    $result = ''; 
	 	if(session('uid')==1707||session('uid')==3134){
	 		return 1;
	 	}

	    //概率数组的总概率精度 
	    $proSum = array_sum($proArr);	 
	    //概率数组循环 
	    foreach ($proArr as $key => $proCur) { 
	        $randNum = mt_rand(1, $proSum); 
	        if ($randNum <= $proCur) { 
	            $result = $key; 
	            break; 
	        } else { 
	            $proSum -= $proCur; 
	        } 
	    } 
	    unset ($proArr);	 
	    return $result; 
	} 

	function update_deal_detail(){
		/*$list=M("deal")->field('id,name,description')->where("description LIKE '%有效期：2014年7月17日至2014年8月17日（请在有效期内进行消费，过期无效！）%' ")->select();
		foreach ($list as $k => $v) {
			$d['description']=str_replace('有效期：2014年7月17日至2014年8月17日（请在有效期内进行消费，过期无效！）','',$v['description']);
			$r=M('deal')->where('id='.$v['id'])->save($d);
			var_dump($r);
		}*/
		//var_dump($list);
	}

	
}
?>