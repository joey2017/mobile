<?php
// 本类由系统自动生成，仅供测试用途
class PackageAction extends Action {

	//套餐详情页
	public function index(){	
		isLogin(U('Package/index'));
		$this->display();
	}

	//创建订单
	public function create_order(){
		$user_info=session('user_info');

		$delivery_mode=intval($_POST['delivery_mode']);//提货方式 1 为到店自提 2为送货上门 10次*38元

		$car_wash=intval($_POST['car_wash']);//洗车选择 0为5座精致洗车,1为7座/suv精致洗车 10次*48元

		$user_name=trim($_POST['user_name'])==''?$user_info['name']:trim($_POST['user_name']);
		$mobile=trim($_POST['mobile'])==''?$user_info['mobile']:trim($_POST['mobile']);
		$address=trim($_POST['address']);
		$type=intval($_POST['type']);//返利方式 1 为100%酒 2为100%水 3为50%酒50%水
		$member_id=intval($user_info['id']);

		$order['user_name']=$user_name;
		$order['user_id']=$member_id;
		$order['mobile']=$mobile;
		$order['type']=$type;
		$order['create_time']=time();
		$order['status']=0;
		$order['address']=$address;
		$order['name']='全返套餐';
		$order['order_sn']=date("Ymdhis",time()).rand(10,99);

		$order_id=M('back_package_order')->add($order);
		$sql= "insert into fw_erp_old_card (p_name,num,cate_id,member_id,mobile,type,package_order_id,price,top_id,add_time) VALUES";
		if($order_id){
			$project_0=intval($_POST['project_0']);//2次×380元  内饰清洁 分类id:4769
			$project_1=intval($_POST['project_1']);//1次×1980元 极致镀晶 分类id:7686
			$project_2=intval($_POST['project_2']);//1次×2680元 铂金镀晶 分类id:7687
			$project_3=intval($_POST['project_3']);//1次×3980元 超级镀晶 分类id:7688
			//cate_id均为erp共用三级分类id
			if($car_wash==0){
				 $sql.="('5座精致洗车',10,188,'".$member_id."','".$mobile."','6',".$order_id.",38,33,".time()."),";				
				$total_price=380;
			}else{
				 $sql.="('7座/SUV精致洗车',10,189,'".$member_id."','".$mobile."','6',".$order_id.",48,33,".time()."),";			
				$total_price=480;
			}

			if($project_0){
				 $sql.="('内饰清洁',2,4769,'".$member_id."','".$mobile."','6',".$order_id.",380,28,".time()."),";				
				$total_price+=760;
			}
			if($project_1){
				 $sql.="('极致镀晶',1,7686,'".$member_id."','".$mobile."','6',".$order_id.",1980,28,".time()."),";				
				$total_price+=1980;
			}
			if($project_2){
				 $sql.="('铂金镀晶',1,7687,'".$member_id."','".$mobile."','6',".$order_id.",2680,28,".time()."),";				
				$total_price+=2680;
			}
			if($project_3){
				 $sql.="('超级镀晶',1,7688,'".$member_id."','".$mobile."','6',".$order_id.",3980,28,".time()."),";				
				$total_price+=3980;
			}
			 $sql = substr($sql,0,strlen($sql)-1);				
			 $r1=M('erp_old_card')->execute($sql);

			 if($r1){
			 	$update_order['total_price']=$total_price;

			 	$r2=M('back_package_order')->where('id='.$order_id)->save($update_order);
			 	if($r2){
			 		$this->ajaxReturn(1,'订单生成成功',1);
			 	}else{
			 		$this->ajaxReturn(0,'订单生成失败',0);
			 	}
			 }else{
			 	   $this->ajaxReturn(0,'订单生成失败',0);
			 }
		}
		
	}
	public function order_info(){
		$id=intval($_GET['id']);

		$order=M('back_package_order as bpo')->join('fw_erp_old_card as feoc on feoc.package_order_id=bpo.id')->field('feoc.p_name,feoc.num,feoc.price,bpo.total_price,bpo.type,bpo.address,bpo.user_name,bpo.mobile,feoc.top_id,bpo.create_time,bpo.id')->where('bpo.id='.$id.' and bpo.user_id='.intval(session('uid').' and bpo.status=0 and feoc.type="6"')->select();
		
		if(!$order){
			$this->error('该订单不存在');
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

	
}