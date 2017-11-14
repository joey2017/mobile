<?php
// 本类由系统自动生成，仅供测试用途
class PackageAction extends Action {

	//套餐详情页
	public function index(){
		// require_once 'jiami.php';
		// $key ="back_package_order_referer";
	
		// $referer=passport_decrypt(trim($_REQUEST['r']),$key);

		// session('package_referer',$referer);

		// echo('解密：'.$referer."<br>");
		
		// var_dump(session('package_referer'));

		// exit;
		// var_dump($_REQUEST);
		
		if($_REQUEST["code"]=='authdeny'){
			echo '<script>history.back(-1);</script>';
			exit;
		}  
		if($_REQUEST["code"]){
			$is_login=isLogin(U('Package/index'),true);
			if(!$is_login){
				
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

				//检查是否关注
				$gu = curl_init();
				$timeout = 5;
				curl_setopt($gu, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".getWxAccToken()."&openid=".$data['openid']."&lang=zh_CN");
				curl_setopt($gu,CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($gu,CURLOPT_CONNECTTIMEOUT, $timeout);
				curl_setopt($gu,CURLOPT_SSL_VERIFYPEER, false);
				$wx_user_info = curl_exec($gu);
				$return_user_info = json_decode($wx_user_info,true);

				if($return_user_info['nickname']==''){
					//未关注
					$this->assign('show_info',0);
				}else{
					//已关注
						$user = M("user")->where(array('wxid'=>$return_user_info['openid']))->find();
						if($user){
							//已注册
							isLogin(U('Package/index'));
							$this->assign('show_info',2);						
						}else{
							//已关注 未注册
							$this->assign('show_info',1);
						}
				}
			}else{
				$this->assign('show_info',2);
				$this->assign('user_info',session('user_info'));
			}
			$this->display();
		}else{
			$refererUrl = U('Package/index'); //登录前一个页面的Url			
			$redirectUrl = urlencode(DOMAIN_URL.U('Package/index'));  //授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
			$goUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('wx_id')."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=".$refererUrl."#wechat_redirect";
			header("Location:".$goUrl);
		}  				
	
	}

	public function detail(){
		$id=intval($_REQUEST['id']);
		if($id<1||$id>12){
			$this->error('不存在的全返套餐',U('Package/index'),3);
		}
		if($id==1||$id==2){
			$this->assign('title','洗车全返');
		}else if($id==3||$id==4){
			$this->assign('title','美容全返');
		}else if($id==5||$id==6){
			$this->assign('title','保养全返');
		}else if($id==7||$id==8){
			$this->assign('title','镀晶全返');
		}else{
			$this->assign('title','套餐全返');
		}

		$this->assign('id',$id);
		$this->display();
	}

	public function package_regist(){
		isLogin(U('Package/index'));
	}

	//创建订单
	public function create_order(){

		$user_info=session('user_info');

		$delivery_mode=intval($_POST['delivery_mode']);//提货方式 1 为到店自提 2为送货上门 10次*38元

		$car_wash=intval($_POST['car_wash']);//洗车选择 0为5座精致洗车,1为7座/suv精致洗车 10次*48元

		$user_name=trim($_POST['user_name'])==''?$user_info['user_name']:trim($_POST['user_name']);
		$mobile=trim($_POST['mobile'])==''?$user_info['mobile']:trim($_POST['mobile']);
		$address=trim($_POST['address']);
		$type=intval($_POST['type']);//返利方式 1 为100%酒 2为100%水 3为50%酒50%水
		$user_id=intval($user_info['id']);

		$order['user_name']=$user_name;
		$order['user_id']=$user_id;
		$order['mobile']=$mobile;
		$order['type']=$type;
		$order['create_time']=time();
		$order['status']=0;
		$order['address']=$address;
		$order['name']='盛世全返套餐-通卡';
		$order['order_sn']=date("Ymdhis",time()).rand(10,99);

		$order_id=M('back_package_order')->add($order);
		$sql= "insert into fw_erp_old_card (p_name,num,cate_id,member_id,mobile,type,package_order_id,price,top_id,add_time) VALUES";
		if($order_id){
			$project_0=intval($_POST['project_0']);//2次×380元  内饰清洁 分类id:4769
			$project_1=intval($_POST['project_1']);//1次×1980元 极致镀晶 分类id:7686
			$project_2=intval($_POST['project_2']);//1次×2680元 铂金镀晶 分类id:7687
			$project_3=intval($_POST['project_3']);//1次×3980元 超级镀晶 分类id:7688

			$project_4=intval($_POST['project_4']);//2次×380元=760  空调清洁 分类id:7695
			$project_5=intval($_POST['project_5']);//2次×380元=760 发动机覆膜 分类id:7696
			$project_6=intval($_POST['project_6']);//1次×580元=580 玻璃镀膜 分类id:7697
			$project_7=intval($_POST['project_7']);//1次×880元=880 漆面镀膜 分类id:7698

			$project_8=intval($_POST['project_8']);//2次×380元=760  轮毂清洗 分类id:7699
			$project_9=intval($_POST['project_9']);//1次×580元=580 大灯翻新 分类id:7701
			$project_10=intval($_POST['project_10']);//1次×880元=880 真皮清洗 分类id:7702
			$project_11=intval($_POST['project_11']);//4次×180元=720 漆面护理 分类id:7703
			$project_12=intval($_POST['project_12']);//1次×980元=980 优贝镀晶 分类id:7704

			//cate_id均为erp共用三级分类id
			if($car_wash==0){
				 $sql.="('5座精致洗车',10,188,'".$user_id."','".$mobile."','6',".$order_id.",38,33,".time()."),";				
				$total_price=380;
			}else{
				 $sql.="('7座/SUV精致洗车',10,189,'".$user_id."','".$mobile."','6',".$order_id.",48,33,".time()."),";			
				$total_price=480;
			}

			if($project_0){
				 $sql.="('内饰清洁',2,4769,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";				
				$total_price+=760;
			}
			if($project_1){
				 $sql.="('极致镀晶',1,7686,'".$user_id."','".$mobile."','6',".$order_id.",1980,28,".time()."),";				
				$total_price+=1980;
			}
			if($project_2){
				 $sql.="('铂金镀晶',1,7687,'".$user_id."','".$mobile."','6',".$order_id.",2980,28,".time()."),";				
				$total_price+=2980;
			}
			if($project_3){
				 $sql.="('极光晶盾',1,7688,'".$user_id."','".$mobile."','6',".$order_id.",4680,28,".time()."),";				
				$total_price+=4680;
			}

			if($project_4){
				 $sql.="('空调清洁',2,7695,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";				
				$total_price+=760;
			}
			if($project_5){
				 $sql.="('发动机覆膜',2,7696,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";				
				$total_price+=760;
			}
			if($project_6){
				 $sql.="('玻璃镀膜',1,7697,'".$user_id."','".$mobile."','6',".$order_id.",580,28,".time()."),";				
				$total_price+=580;
			}

			if($project_7){
				 $sql.="('漆面镀膜',1,7698,'".$user_id."','".$mobile."','6',".$order_id.",880,28,".time()."),";				
				$total_price+=880;
			}
			if($project_8){
				 $sql.="('轮毂清洗',2,7699,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";				
				$total_price+=760;
			}
			if($project_9){
				 $sql.="('大灯翻新',1,7701,'".$user_id."','".$mobile."','6',".$order_id.",580,28,".time()."),";				
				$total_price+=580;
			}
			if($project_10){
				 $sql.="('真皮清洗',1,7702,'".$user_id."','".$mobile."','6',".$order_id.",880,28,".time()."),";				
				$total_price+=880;
			}
			if($project_11){
				 $sql.="('漆面护理',4,7703,'".$user_id."','".$mobile."','6',".$order_id.",180,28,".time()."),";				
				$total_price+=720;
			}
			if($project_12){
				 $sql.="('优贝镀晶',1,7704,'".$user_id."','".$mobile."','6',".$order_id.",980,28,".time()."),";				
				$total_price+=980;
			}


			 $sql = substr($sql,0,strlen($sql)-1);				
			 $r1=M('erp_old_card')->execute($sql);

			 if($r1){
			 	$update_order['total_price']=$total_price;//测试价格均为1分钱

			 	$r2=M('back_package_order')->where('id='.$order_id)->save($update_order);
			 	if($r2){
			 		$this->ajaxReturn(U('Package/order_info',array('id'=>$order_id)),'订单生成成功',1);
			 	}else{
			 		$this->ajaxReturn(0,'订单生成失败',0);
			 	}
			 }else{
			 	   $this->ajaxReturn(0,'订单生成失败',0);
			 }
		}else{
			$this->ajaxReturn(0,'订单生成失败',0);
		}
		
	}

	//创建订单
	public function create_order_new(){

		$user_info=session('user_info');

		$delivery_mode=intval($_POST['delivery_val']);//提货方式 1 为到店自提 2为送货上门 10次*38元

		$car_wash=intval($_POST['car_wash']);//洗车选择 0为5座精致洗车,1为7座/suv精致洗车 10次*48元

		$user_name=trim($_POST['user_name'])==''?$user_info['user_name']:trim($_POST['user_name']);
		$mobile=trim($_POST['mobile'])==''?$user_info['mobile']:trim($_POST['mobile']);
		$address=trim($_POST['address']);
		$type=intval($_POST['type']);//返利方式 1 为100%酒 2为100%水 3为50%酒50%水
		$user_id=intval($user_info['id']);

		//未填写酒数量及名称
		$order['user_name']=$user_name;
		$order['user_id']=$user_id;
		$order['mobile']=$mobile;
		$order['type']=1;
		$order['create_time']=time();
		$order['status']=0;
		$order['address']=$address;
		$order['name']='盛世全返套餐-通卡';
		$order['order_sn']=date("Ymdhis",time()).rand(10,99);

		$order_id=M('back_package_order')->add($order);
		$sql= "insert into fw_erp_old_card (p_name,num,cate_id,member_id,mobile,type,package_order_id,price,top_id,add_time) VALUES";
		if($order_id){
			$project_0=intval($_POST['project_0']);//单项套餐1
			$project_1=intval($_POST['project_1']);//单项套餐2
			$project_2=intval($_POST['project_2']);//单项套餐3
			$project_3=intval($_POST['project_3']);//单项套餐4

			$project_4=intval($_POST['project_4']);//组合套餐1
			$project_5=intval($_POST['project_5']);//组合套餐2
			$project_6=intval($_POST['project_6']);//组合套餐3
			$project_7=intval($_POST['project_7']);//组合套餐4

			$project_8=intval($_POST['project_8']);//组合套餐5			
			

			if($project_0){
				 $sql.="('5座精致洗车',10,188,'".$user_id."','".$mobile."','6',".$order_id.",38,28,".time()."),";				
				$total_price+=380;
			}
			if($project_1){
				$sql.="('SUV精致洗车',8,189,'".$user_id."','".$mobile."','6',".$order_id.",48,33,".time()."),";			
				$total_price+=384;
			}			
			if($project_2){
				 $sql.="('极致镀晶',1,7686,'".$user_id."','".$mobile."','6',".$order_id.",1980,28,".time()."),";				
				$total_price+=1980;
			}
			if($project_3){
				 $sql.="('极光晶盾',1,7688,'".$user_id."','".$mobile."','6',".$order_id.",4680,28,".time()."),";				
				$total_price+=4680;
			}

			if($project_4){
				$sql.="('轿车/SUV精致洗车',10,4692,'".$user_id."','".$mobile."','6',".$order_id.",48,28,".time()."),";	
				$sql.="('标准打蜡',2,55,'".$user_id."','".$mobile."','6',".$order_id.",180,28,".time()."),";				
				$total_price+=740;
			}
			if($project_5){
				$sql.="('轿车/SUV精致洗车',10,4692,'".$user_id."','".$mobile."','6',".$order_id.",48,28,".time()."),";	
				$sql.="('内饰清洁',1,4769,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";					
				$total_price+=760;
			}
			if($project_6){
				$sql.="('轿车/SUV精致洗车',10,4692,'".$user_id."','".$mobile."','6',".$order_id.",48,28,".time()."),";	
				$sql.="('空调清洁',1,7695,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";			
				$total_price+=760;
			}

			if($project_7){
				$sql.="('轿车/SUV精致洗车',10,4692,'".$user_id."','".$mobile."','6',".$order_id.",38,28,".time()."),";	
				$sql.="('极致镀晶',1,7686,'".$user_id."','".$mobile."','6',".$order_id.",1980,28,".time()."),";			
				$total_price+=2360;
			}
			if($project_8){
				$sql.="('轿车/SUV精致洗车',10,4692,'".$user_id."','".$mobile."','6',".$order_id.",48,28,".time()."),";	
				$sql.="('极光晶盾',1,7688,'".$user_id."','".$mobile."','6',".$order_id.",4680,28,".time()."),";		
				$total_price+=5060;
			}

			 $sql = substr($sql,0,strlen($sql)-1);				
			 $r1=M('erp_old_card')->execute($sql);

			 if($r1){
			 	$update_order['total_price']=$total_price;//测试价格均为1分钱

			 	$r2=M('back_package_order')->where('id='.$order_id)->save($update_order);
			 	if($r2){
			 		$this->ajaxReturn(U('Package/order_info',array('id'=>$order_id)),'订单生成成功',1);
			 	}else{
			 		$this->ajaxReturn(0,'订单生成失败',0);
			 	}
			 }else{
			 	   $this->ajaxReturn(0,'订单生成失败',0);
			 }
		}else{
			$this->ajaxReturn(0,'订单生成失败',0);
		}
		
	}

	public function redirect_url(){
		$id=intval($_REQUEST['id']);
		isLogin(U('Package/detail',array('id'=>$id)));
	}

	//创建订单
	public function create_order_third(){

		$user_info=session('user_info');
		$id=intval($_REQUEST['id']);
		if(!$user_info){
			$this->ajaxReturn(U('Package/redirect_url',array('id'=>$id)),'请先登录后再下单购买',-1);
		}
		$user_name=trim($_POST['user_name'])==''?$user_info['user_name']:trim($_POST['user_name']);
		$mobile=trim($_POST['mobile'])==''?$user_info['mobile']:trim($_POST['mobile']);		
		$type=1;//返利方式 1 为100%酒 2为100%水 3为50%酒50%水
		$user_id=intval($user_info['id']);
		
		//未填写酒数量及名称
		$order['user_name']=$user_name;
		$order['user_id']=$user_id;
		$order['mobile']=$mobile;
		$order['type']=1;
		$order['create_time']=time();
		$order['status']=0;
		$order['wine_name']='奔富红酒';//酒名称
		
		$order['referer']='';
		$order['name']='盛世全返套餐-通卡';
		$order['order_sn']=date("Ymdhis",time()).rand(10,99);

		$order_id=M('back_package_order')->add($order);
		$sql= "insert into fw_erp_old_card (p_name,num,cate_id,member_id,mobile,type,package_order_id,price,top_id,add_time) VALUES";
		if($order_id){
			
			switch ($id) {
				case 1:
					$sql.="('5座精致洗车',10,188,'".$user_id."','".$mobile."','6',".$order_id.",38,28,".time()."),";				
					$total_price+=380;
					$update_order['wine_num']=1;//酒数量
					break;
				case 2:
					$sql.="('SUV/7座精致洗车',8,189,'".$user_id."','".$mobile."','6',".$order_id.",48,33,".time()."),";			
					$total_price+=384;
					$update_order['wine_num']=1;//酒数量
					break;
				case 3:
					$sql.="('内饰清洁',1,4769,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";
					$total_price+=380;
					$update_order['wine_num']=1;//酒数量	
					break;
				case 4:
					$sql.="('空调清洁',1,7695,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";		
					$total_price+=380;
					$update_order['wine_num']=1;//酒数量	
					break;
				case 5:
					$sql.="('线束保养',1,10489,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";		
					$total_price+=380;
					$update_order['wine_num']=1;//酒数量
					break;
				case 6:
					$sql.="('刹车保养',1,10490,'".$user_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";		
					$total_price+=380;
					$update_order['wine_num']=1;//酒数量
					break;
				case 7:
					$sql.="('极致镀晶',1,7686,'".$user_id."','".$mobile."','6',".$order_id.",1980,28,".time()."),";	
					$update_order['wine_num']=5;//酒数量			
					$total_price+=1980;
					break;
				case 8:
					 $sql.="('极光晶盾',1,7688,'".$user_id."','".$mobile."','6',".$order_id.",4680,28,".time()."),";
					$update_order['wine_num']=12;//酒数量			
					$total_price+=4680;
					break;
				case 9:
					$sql.="('轿车/SUV精致洗车',5,4692,'".$user_id."','".$mobile."','6',".$order_id.",38,28,".time()."),";	
					$sql.="('标准打蜡',1,55,'".$user_id."','".$mobile."','6',".$order_id.",180,28,".time()."),";				
					$total_price+=370;
					$update_order['wine_num']=1;//酒数量	
					break;
				case 10:
					$sql.="('轿车/SUV精致洗车',5,4692,'".$user_id."','".$mobile."','6',".$order_id.",38,28,".time()."),";	
					$sql.="('四轮定位',1,55,'".$user_id."','".$mobile."','6',".$order_id.",180,28,".time()."),";				
					$total_price+=370;
					$update_order['wine_num']=1;//酒数量	
					break;
				case 11:
					$sql.="('轿车/SUV精致洗车',10,4692,'".$user_id."','".$mobile."','6',".$order_id.",38,28,".time()."),";	
					$sql.="('极致镀晶',1,7686,'".$user_id."','".$mobile."','6',".$order_id.",1980,28,".time()."),";			
					$total_price+=2360;
					$update_order['wine_num']=7;//酒数量	
					break;	
				case 12:
					$sql.="('轿车/SUV精致洗车',10,4692,'".$user_id."','".$mobile."','6',".$order_id.",38,28,".time()."),";	
					$sql.="('极光晶盾',1,7688,'".$user_id."','".$mobile."','6',".$order_id.",4680,28,".time()."),";		
					$total_price+=5060;
					$update_order['wine_num']=15;//酒数量
					break;				
				default:
					$sql.="('5座精致洗车',10,188,'".$user_id."','".$mobile."','6',".$order_id.",38,28,".time()."),";				
					$total_price+=380;
					$update_order['wine_num']=1;//酒数量
					break;
			}

			 $sql = substr($sql,0,strlen($sql)-1);				
			 $r1=M('erp_old_card')->execute($sql);

			 if($r1){
			 	$update_order['total_price']=$total_price;//测试价格均为1分钱			 
			 	$r2=M('back_package_order')->where('id='.$order_id)->save($update_order);
			 	if($r2){
			 		$this->ajaxReturn(U('Package/order_info',array('id'=>$order_id)),'订单生成成功',1);
			 	}else{
			 		$this->ajaxReturn(0,'订单生成失败',0);
			 	}
			 }else{
			 	   $this->ajaxReturn(0,'订单生成失败',0);
			 }
		}else{
			$this->ajaxReturn(0,'订单生成失败',0);
		}
		
	}

	public function order_info(){
		$id=intval($_GET['id']);
		$order=M('back_package_order as bpo')->join('fw_erp_old_card as feoc on feoc.package_order_id=bpo.id')->field('feoc.p_name,feoc.num,feoc.price,bpo.total_price,bpo.type,bpo.address,bpo.user_name,bpo.mobile,feoc.top_id,bpo.create_time,bpo.id,bpo.wine_name,bpo.wine_num')->where('bpo.id='.$id.' and bpo.user_id='.intval(session('uid')).' and bpo.status=0 and feoc.type="6"')->order('feoc.id asc')->select();	
		if(!$order){
			$this->error('该订单不存在',U('Index/index'),3);
		}

		foreach ($order as $k => $v) {
			$order[$k]['price']=round($v['price'],2);
			$order[$k]['item_price']=$v['num']*$v['price'];
		}
		$this->assign('order',$order);
		$this->assign('type',$order[0]['type']);
		$this->assign('id',$id);
		$this->display();

	}

	//支付回调页面
	public function pay_back()
	{

		$order_id = intval($_REQUEST['order_id']);
		$order_sn = trim($_REQUEST['order_sn']);

		isLogin(U('User/index'));
		$uid = session('uid');
		
		$order= M('back_package_order')->field('total_price,name,id,order_sn,pay_time')->where('status=1 and user_id='.$uid." and id=".$order_id)->find();
	
		if (!$order) {
			$this->error('不存在的订单',U('Index/index'),3);
		}
		$this->assign('order',$order);
		$this->assign("title","支付结果");
		$this->display();
	}

	public function view(){		
		
		$pid =  intval($_GET['id']);
		if (empty($pid) || $pid < 0) {
			$this->error('非法操作');
		}
		isLogin(U('Package/view',array('id'=>$pid)));
		$user_info=session('user_info');
		$uid =intval($user_info['id']);
		
		$info = M('back_package_order as bpo')->join('fw_erp_old_card as feoc on bpo.id = feoc.package_order_id')->field('feoc.*')->where("bpo.status=1 and bpo.user_id=".$uid." and feoc.type='6' and feoc.member_id=".$uid." and bpo.id=".$pid)->order('feoc.id asc')->select();

		if (empty($info)) {
			$this->error('数据不存在',U('Index/index'),3);
		}

		$store_list=M('supplier_location')->field('name,id')->where('is_effect=1 and is_recommend=1 and is_main=1 and city_id=15')->select();	
		
		$this->assign('info',$info);
		$this->assign('store_list',$store_list);
		$this->assign('title','套餐使用');
		$this->display();
	}

	public function get_store_list(){

		isLogin(U('Package/index'));

		$y = $_POST['lat']; //纬度
		$x = $_POST['lng']; //经度

		$store_list=M('supplier_location')->field('name,id,ypoint,xpoint')->where('is_effect=1 and is_recommend=1 and is_main=1 and city_id=15')->select();

		if($store_list){

			if($y&&$x){
				foreach ($store_list as $k => $v) {
					$distance = round(getDistance($y,$x,$v['ypoint'],$v['xpoint']),2);
					$store_list[$k]['distance'] = $distance;
				}
				
				$store_list = multi_array_sort($store_list,'distance',$sort=SORT_ASC);	
			}
			
			$data['html']='';
			foreach ($store_list as $k => $v) {
				$deal="'deal'";
				$c='normal';
				if($k==0){
					$c='active';
				}
				$data['html'].='<li class="'.$c.'" onclick="nTabs(this,'.$k.','.$deal.');" data-sid="'.$v['id'].'" >'.$v['name'].'<em class="Project_em"></em></li>';   
                              
			}

			$data['location_id']=$store_list[0]['id'];
			
			$this->ajaxReturn($data,'加载成功',1);
		}else{
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
		}
	
	}

	public function ajaxCreateCardNum(){
		$cate_id=intval($_POST['cate_id']);
		$location_id=intval($_POST['location_id']);

		$deal=M('erp_goods as eg')->join('fw_deal as fd on fd.id=eg.shop_project_id')->field('fd.*')->where('eg.cate_id='.$cate_id.' and eg.store_id='.$location_id.' and eg.type=1 and eg.shop_project_id!=""')->find();

		if(!$deal){
			$this->ajaxReturn(0,'该门店未添加该项目',0);
		}

		$user_info = session('user_info');

		//erp_old_card表id
		$id=intval($_POST['id']);

		$project=M('erp_old_card')->where('id='.$id." and member_id=".intval($user_info['id'])." and type='6'")->find();
		
		//验证所订服务是否已用完次数
		if($project['num']==0) {
			$this->ajaxReturn(0,'次数已用完',0);
		}
		//判断年卡是否已过使用期限
		
		$user_info['true_name'] = empty($user_info['true_name']) ? $user_info['user_name'] : $user_info['true_name'];
		$now = time();
		$order['type'] = 0; //普通订单
		$order['user_id'] = intval($user_info['id']);
		$order['create_time'] = time();
		$order['means_of_payment'] ='5';//通卡支付
		$order['total_price'] = $deal['current_price']; //当前价格总额
		$order['pay_amount'] = $deal['current_price']; //支付金额，年卡购买，直接算已支付
		$order['pay_status'] = 0;  //新单都为零， 等下面的流程同步订单状态
		$order['delivery_status'] =0;  
		$order['order_status'] = 0;  //新单都为零， 等下面的流程同步订单状态
		$order['return_total_score'] = 0;//$deal['return_total_score'];  //结单后送的积分
		$order['return_total_money'] = 0;  //结单后送的现金
		$order['deal_ids']			 = $deal['id'];
		$order['mobile'] = $user_info['mobile']; 
		$order['deal_total_price'] = $deal['current_price'];   //团购商品总价
		$order['ecv_money'] = 0;
		$order['account_money'] = 0;
		$order['ecv_sn'] = '';
		//更新来路
		$order['referer'] ='BACK_'.$project['package_order_id'] ;//全反套餐订单id		
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
		$update_card['num']=$project['num']-1;
		$update_card['used_times']=$project['used_times']+1;
		M('erp_old_card')->where(array('id'=>$id))->save($update_card);
		//写入消费记录		
			
		//改变订单状态
		order_paid($order_id); 
	
		$store = M('supplier_location')->field('name,tel,mobile,address')->where(array('id'=>$deal['location_id']))->find();
		//生成服务码
		$coupon = addCoupon($order_id,$deal_order_item_id,intval($user_info['id']),$deal);
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
		//paySuccessSendMsg('store',$storeMsg);

		$this->ajaxReturn(0,'使用成功,请注意接收验证码',1);
	}

	
}