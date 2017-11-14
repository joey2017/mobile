	<?php

// 本类由系统自动生成，仅供测试用途

class ClubAction extends BaseAction {

	public function index(){

		$club=M('circle')->field('circle_id,circle_name,circle_oil,circle_mcount,circle_img,region_id,class_id,circle_oil_level,circle_identification_count')->where("circle_status=1")->order('circle_oil desc,circle_mcount desc,circle_oil_level desc')->limit(2)->select();

		//上周一 00:00:00 
		$last_Mon=strtotime("-1 week last Monday");
	
		//上周日 23:59:59 
		$last_Sun=strtotime("last Sunday")+86399;
	
		$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
		//本周杰出会长
		$master_list=$Model->query("select distinct fc.circle_masterid,fc.circle_id,circle_name,circle_masterid,member_id,circle_mastername,circle_desc,circle_img,region_id,sum(oil_value) as sum_val  from fw_circle_oillog as fco left join fw_circle as fc on fco.member_id=fc.circle_masterid where fc.circle_id is not null and oil_time>".$last_Mon." and oil_time<".$last_Sun."  GROUP BY fc.circle_masterid ORDER BY sum_val desc limit 3");
		foreach ($master_list as $k => $v) {
			//链接
			$master_list[$k]['url']=U('Club/club',array('id'=>$v['circle_id']));
			$master_list[$k]['user_name']=get_user_name($v['circle_masterid']);
			$master_list[$k]['region_info']=get_circle_city($v['region_id']);			
			$master_list[$k]['member_img']=getUserAvatar($v['circle_masterid'],'middle');
			$master_list[$k]['topic_count']=M('circle_theme')->where('member_id='.$v['member_id']." and is_closed=0")->count();			
		}
		
		$circle_list=$Model->query("select distinct fc.circle_id,sum(oil_value) as sum_val,circle_name,circle_oil,circle_mcount,circle_img,region_id,class_id,circle_oil_level,circle_identification_count from fw_circle_oillog as fco left join fw_circle as fc on fco.circle_id=fc.circle_id where fc.circle_id is not null and oil_time>".$last_Mon." and oil_time<".$last_Sun." GROUP BY fc.circle_id ORDER BY sum_val desc limit 3");
		
		foreach ($circle_list as $k => $v) {
			$circle_list[$k]['url']=U('Club/club',array('id'=>$v['circle_id']));
			//车型信息
			$circle_list[$k]['car_info']=get_car_name($v['class_id']);
			//地区信息
			$circle_list[$k]['region_info']=get_circle_city($v['region_id']);
			//logo
			$circle_list[$k]['circle_img']=get_circle_img($v['circle_id'],$v['circle_img']);
		}
		$this->assign('circle_list',$circle_list);
		$this->assign('master_list',$master_list);
		$has_join=M("circle_member")->join('fw_circle as fc on fc.circle_id=fw_circle_member.circle_id')->where("cm_state=1 and circle_status=1 and member_id=".session('uid'))->field('fc.circle_name,circle_img,fc.circle_id,fc.circle_oil_level,fc.class_id,fc.circle_mcount,fc.region_id,fc.circle_oil')->find();
		if($has_join){
			//车型信息
			$has_join['car_info']=get_car_name($has_join['class_id']);
			//链接
			$has_join['url']=U('Club/club',array('id'=>$has_join['circle_id']));
			//地区信息
			$has_join['region_info']=get_circle_city($has_join['region_id']);		
			
			$has_join['level']=$has_join['circle_oil_level']*20;
			
			$has_join['circle_img']=get_circle_img($has_join['circle_id'],$has_join['circle_img']);

			$this->assign('hj',$has_join);
		}

		$this->display();	
	}

    public function all_club()
	{
		cookie('city_id','15');
		$city_id=cookie('city_id'); 
		$cid=intval($_REQUEST['cid']);
		$bid=intval($_REQUEST['bid']);
        $link=$this->link_url(0);

		$city= M('region_conf')->field('id,name')->where('region_level = 3 and pid=7')->select();
		//在数组第一位写入全部
		array_unshift($city,array('id'=>0,'name'=>'全部'));
		foreach ($city as $k => $v) {
			if($cid==$v['id']&&$v['id']!=0){
				$this->assign('cname',$v['name']);
			}
			$city[$k]['link']=$this->link_url(1)."&cid=".$v['id'];
		}
		$this->assign('city',$city);

		//汽车品牌
		$brand=M('car')->field('id,name')->where('parent_id =0')->select();
		array_unshift($brand,array('id'=>0,'name'=>'全部'));
		foreach ($brand as $k => $v) {
			if($bid==$v['id']&&$v['id']!=0){
				$this->assign('bname',$v['name']);
			}
			$brand[$k]['link']=$this->link_url(2)."&bid=".$v['id'];
		}		
		$this->assign('brand', $brand); 


		$this->assign('link',$link);
		$where.=" circle_status=1 ";
		require_once 'rankArray.php';
		if($cid>0){
			$where.=" and region_id=".$cid;
		}
		if($bid>0){
			foreach ($car_brandArr as $k =>$v) {
				if($bid==$v['brandId']){
					$where.=" and class_id in(".$v['brand_arr'].")";
				}
			}
		}			
		/*$count=M('circle')->field('id')->where($where)->count();
		if($count<10){
			$count=1;
		}else{
			$count=$count/10;
		}*/
		$this->assign('cid',$cid);
		$this->assign('bid',$bid);
		$this->display();
	}


	public function link_url($a){
		$str=$_REQUEST;
		$link='?';
		if($str['cid']&&$a!=1){
			$link.="&cid=".$str['cid'];
		}
		if($str['bid']&&$a!=2){
			$link.="&bid=".$str['bid'];
		}	
		return $link;
	}

	public function club(){
			$circle_id=intval($_REQUEST['id']);	
				
			$circle=M('circle')->where('circle_id='.$circle_id." and circle_status=1")->find();

			if(!$circle){
				header("Location:".U("Club/index"));
			}		
			
			$focus=M('circle_focus')->field('img,link')->where('circle_id='.$circle_id)->order('sort desc')->find();
			if($focus){
				$focus['img']=get_circle_img($circle['circle_id'],$focus['img']);
			}
			$this->assign('focus',$focus);
			$result=M('circle_theme')->where('is_closed=0 and circle_id='.$circle_id)->order('theme_browsecount desc')->limit(2)->select();	

			//截取摘要
			$patterns  = array ('/<p><br\/><\/p>/','/&nbsp;/','/<img[^>]*>/');	
			if($result){
			foreach ($result as $k => $v) {
						$result[$k]['circle_url']=U('Club/club',array('id'=>$v['circle_id']));
						$result[$k]['user_name']=get_user_name($v['member_id']);
						$result[$k]['head_img']=get_user_avatar($v['member_id'],'middle');
						$result[$k]['theme_content']=str_replace('src="/ueditor/','src="http://club.17cct.com/ueditor/',$result[$k]['theme_content']);
						//获取文章中 前9张图片
						if(preg_match_all("/<(img|IMG)(.*)(src|SRC)=[\"|'|]{0,}([h|\/].*(jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|bmp|BMP|[a-z|A-Z]\/0))[\"|'|\s]{0,}/isU",$result[$k]['theme_content'], $matches)){
							/*if($matches[2]=='image.17cct.com'){
								$matches[4]=$matches[4]."!thumbnail";
							}*/
							$img_count=count($matches[4]);
							if($img_count>4){									
								$result[$k]['img_items']=array_slice($matches[4],0,4);
							}else{
								$result[$k]['img_items']=$matches[4];
							}
							if($result[$k]['img_items']){
								foreach ($result[$k]['img_items'] as $k1 =>$v1) {
									if(substr($v1,0,8)=='http://i'){
										$result[$k]['img_items'][$k1].='!160x100';
									}									
								}
							}
						}
						$result[$k]['theme_content']=msubstr(strip_tags(preg_replace($patterns, $replace,$result[$k]['theme_content'])),0,50);
					}	
				$this->assign('list',$result);
			}
			//车型信息
			$circle['car_info']=get_car_name($circle['class_id']);
			//链接
			$circle['url']=U('Club/club',array('id'=>$circle['circle_id']));
			//地区信息
			$circle['region_info']=get_circle_city($circle['region_id']);		
			//等级
			$circle['level']=$circle['circle_oil_level']*20;
			//logo
			$circle['circle_img']=get_circle_img($circle['circle_id'],$circle['circle_img']);
			//相片统计
			$circle['album_count']=M('circle_album')->where('circle_id='.$circle_id)->count();	
			//帖子统计
			$circle['topic_count']=M('circle_theme')->where('circle_id='.$circle_id." and is_closed=0")->count();
			//活动统计
			$circle['activity_count']=M('circle_activity')->where('circle_id='.$circle_id)->count();
			
			$this->assign('circle',$circle);
				
			$join_info=M('circle_member')->field('cm_state,is_identity,circle_id')->where('member_id='.session('uid'))->find();
			if($join_info['cm_state']&&$join_info['circle_id']==$circle_id){

				$sign_info=M('user')->field('sign_in_time,sign_in_count')->where('id='.session('uid'))->find();	
				//签到日期与次数算出下一个签到日期
				$sign_next_date= date('Y-m-d',strtotime('+'.$sign_info['sign_in_count'].' day',$sign_info['sign_in_time']));	
				
				if(($sign_info['sign_in_count']+1)==8&&$sign_next_date==date('Y-m-d',time())||date('Y-m-d')>$sign_next_date&&$sign_info['sign_in_time']>0){	
					$data['sign_in_time']=0;
					$data['sign_in_count']=0;
					M('user')->where('id='.intval(session('uid')))->save($data);		
					$sign_status=0;
					
				}else{			
					if($sign_next_date==date('Y-m-d',time())||!$sign_info['sign_in_time']&&!$sign_info['sign_in_count']){			
						$sign_status=0;				
					}else{
						$sign_status=1;
					}
				}
				$this->assign('sign_status',$sign_status);
				$this->assign('join_info',1);
			}else{
				if(!$join_info&&session('uid')){
					$this->assign('join_info',2);//申请加入
				}else{
					if($join_info['circle_id']==$circle_id&&$join_info['cm_state']==0){
						$this->assign('join_info',3);//审核中
					}else{
						if(!session('uid')){
							$this->assign('join_info',5);//未登录
						}else{
							$this->assign('join_info',4);//已加入其它组织
						}						
					}
					
				}
			}


		$this->display();
	}

	public function ajax_sign(){

		/*if(!is_login(U('Club/club',array('id'=>$_REQUEST['cid'])))){
			$this->redirect("Users/login","请先登录");
		 }*/


		$sign_info=M('user')->field('sign_in_time,sign_in_count,point')->where('id='.session('uid'))->find();	
	
		//签到日期与次数算出下一个签到日期
		$sign_next_date= date('Y-m-d',strtotime('+'.$sign_info['sign_in_count'].' day',$sign_info['sign_in_time']));	
		
		if($sign_next_date==date('Y-m-d',time())||!$sign_info['sign_in_time']&&!$sign_info['sign_in_count']){
			if(!$sign_info['sign_in_time']){
				$update['sign_in_time']=time();
			}
			
			$now_sign_count=intval($sign_info['sign_in_count']+1);
			$r=check_user_level(($now_sign_count*5),0);
			$update['point']=array('exp','point+'.($now_sign_count*5));
			$update['sign_in_count']=$now_sign_count;
			$r=M('user')->where('id='.session('uid'))->save($update);
		
			if($r){
				$point=$now_sign_count*5;	
				$desc="连续".$now_sign_count."天签到";	
				$now_point=intval($sign_info['point'])+$point;
				do_insert_member_point(session('uid'),session('user_name'),2,session('uid'),$point,$desc);//写入会员积分记录表

				
				
				$join_circle_info=M('circle_member')->join('fw_circle as fc on fc.circle_id=fw_circle_member.circle_id')->field('fw_circle_member.circle_id,fc.circle_oil')->where('member_id='.session('uid'))->find();
		
				if($join_circle_info){

					$now_oil=intval($join_circle_info['circle_oil']+$now_sign_count);

					$return = array("msg"=>$desc,"oil"=>$now_oil,"status"=>1);

					modify_circle_oil(session('uid'),session('user_name'),14,session('uid'),intval($now_sign_count),$desc);
				}
				$this->ajaxReturn($return);
			}else{
				$return = array("status"=>0,"msg"=>"签到失败");
				$this->ajaxReturn($return);
			}			
		}else{
			$return = array("status"=>0,"msg"=>"您今天已经签到了");			
		}		
	}

	public function ajax_get_club()
	{
		
			$cid=$_REQUEST['cid'];//城市
			$bid=$_REQUEST['bid'];//品牌 level=0
			$page=intval($_REQUEST['p']);
			if($page){
				$page=intval($_REQUEST['p']-1);
			}
			
			require_once 'rankArray.php';
			$where.=" circle_status=1 ";
			require_once 'rankArray.php';
			if($cid>0){
				$where.=" and region_id=".$cid;
			}
			if($bid>0){
				foreach ($car_brandArr as $k =>$v) {
					if($bid==$v['brandId']){
						$where.=" and class_id in(".$v['brand_arr'].")";
					}
				}
			}		

			$club=M('circle')->field('circle_id,circle_name,circle_oil,circle_mcount,circle_img,region_id,class_id,circle_oil_level,circle_identification_count')->where($where)->limit($page*10,10)->select();
			foreach ($club as $k => $v) {
				$club[$k]['region_info'];
				//车型信息
				$club[$k]['car_info']=get_car_name($v['class_id']);
				//链接
				$club[$k]['url']=U('Club/club',array('id'=>$v['circle_id']));
				//地区信息
				$club[$k]['region_info']=get_circle_city($v['region_id']);		
				
				$club[$k]['level']=$v['circle_oil_level']*20;				
				//$club[$k]['circle_img']=get_circle_img($v['circle_id'],$v['circle_img']).'!thumbnail';
				$club[$k]['circle_img']=get_circle_img($v['circle_id'],$v['circle_img']);
				if(substr($club[$k]['circle_img'],0,8)=='http://i'){
					$club[$k]['circle_img'].='!thumbnail';
				}
			}
		$this->assign('club',$club);
		echo $html=$this->fetch();
					
	}

	public function member(){
		$cid=intval($_REQUEST['id']);
		if(!$cid){
			$this->redirect("Index/index");
		}
		$this->assign('circle',get_circle_info($cid));
		/*$count=M('circle_member')->field('id')->where("cm_state=1 and circle_id=".$cid)->count();
		$this->assign('member_count',$count);
		$verify_count=M('circle_member')->join('fw_user as fu on fu.id=fw_circle_member.member_id')->field('fu.id')->where('circle_id='.$cid." and cm_state=1 and is_verify=1")->count();
		$this->assign('verify_count',$verify_count);*/
		$this->assign('cid',$cid);
		
		$this->display();
	}
	public function ajax_get_member(){
		$circle_id=$_REQUEST['id'];
		$page=intval($_REQUEST['p']);
		$member=M('circle_member')->join('fw_user as fu on fu.id=fw_circle_member.member_id')->field('fu.true_name,member_id,member_name,is_identity,mobile,is_verify,circle_id')->where('circle_id='.$circle_id." and cm_state=1")->limit($page*10,10)->select();
	
		foreach ($member as $k => $v) {
			if(!$v['true_name']){
				$member[$k]['true_name']=substr_replace($v['mobile'],"*****",2,5);
			}	
			if($v['is_verify']){
				$member[$k]['verify']='认证';
			}

			$member[$k]['oil']=intval(M('circle_oillog')->where('member_id='.$v['member_id']." and circle_id=".$v['circle_id'])->sum('oil_value'));
			$member[$k]['car_info']=M('car')->join('fw_user_car as fuc on fw_car.id=fuc.factory_id')->where('user_id='.$v['member_id'])->getField('name');
			if($v['identity']==1){
				$member[$k]['manage']='堂主';
			}elseif($v['identity']==1){
				$member[$k]['manage']='副堂主';
			}else{
				$member[$k]['manage']='';
			}		
			$member[$k]['head_img']=get_user_avatar($v['member_id'],'middle');
		}
		$this->assign('member',$member);
		echo $html=$this->fetch();
	}
	public function topic(){
		$cid=intval($_REQUEST['id']);
	
		if(!$cid){
			$this->redirect("Index/index");
		}
		$this->assign('circle',get_circle_info($cid));
		$digest=intval($_REQUEST['digest']);
		if($digest){
			$this->assign('digest',$digest);	
		}
		$count=M('circle_theme')->field('id')->where("is_closed=0 and circle_id=".$cid)->count();		
		$this->assign('cid',$cid);
		if($count<10){
			$count=1;
		}else{
			$count=$count/10;
		}
		$this->assign('count',$count);
		$this->display();
	}

	public function ajax_get_topic(){
		if(!isset($_REQUEST['id']))die();
		$cid=intval($_GET['id'])>0?intval($_GET['id']):0;		
		$digest=intval($_GET['digest']);
		if($digest){
			$is_digest=" and is_digest=1";
		}
		$page=$_GET['p'];
		$result=M('circle_theme')->field('theme_id,circle_id,member_id,theme_name,theme_addtime,theme_content')->where('is_closed=0 and circle_id='.$cid.$is_digest)->order('theme_addtime desc')->limit($page*5,5)->select();
				//截取摘要
			$patterns  = array ('/<p><br\/><\/p>/','/&nbsp;/','/<img[^>]*>/');	
			if($result){
			foreach ($result as $k => $v) {
						$result[$k]['circle_url']=U('Club/club',array('id'=>$v['circle_id']));
						$result[$k]['user_name']=get_user_name($v['member_id']);
						$result[$k]['head_img']=get_user_avatar($v['member_id'],'middle');
						
						//获取文章中 前9张图片
						if(preg_match_all("/<(img|IMG)(.*)(src|SRC)=[\"|'|]{0,}([h|\/].*(jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|bmp|BMP|[a-z|A-Z]\/0))[\"|'|\s]{0,}/isU",$result[$k]['theme_content'], $matches)){
							/*if($matches[2]=='image.17cct.com'){
								$matches[4]=$matches[4]."!thumbnail";
							}*/
							$img_count=count($matches[4]);
							if($img_count>4){									
								$result[$k]['img_items']=array_slice($matches[4],0,4);
							}else{
								$result[$k]['img_items']=$matches[4];
							}
							if($result[$k]['img_items']){
								foreach ($result[$k]['img_items'] as $k1 =>$v1) {
									if(substr($v1,0,8)=='http://i'){
										$result[$k]['img_items'][$k1].='!160x100';
									}									
								}
							}
							
						}
						$result[$k]['theme_content']=msubstr(strip_tags(preg_replace($patterns, $replace,$result[$k]['theme_content'])),0,50);
					}	
				$this->assign('list',$result);
				echo $html=$this->fetch();
			}	
			echo '';
	}

	//获取首页帖子
    public function ajax_index_topic(){    
		$page=$_GET['p'];	
		$result=M('circle_theme')->where('is_closed=0')->limit($page*5,5)->order('sort desc,theme_id desc')->select();
		//截取摘要
		$patterns  = array ('/<p><br\/><\/p>/','/&nbsp;/','/<img[^>]*>/');
			$replace  = array ('','','[图]');			
		if($result){
			foreach ($result as $k => $v) {
						$result[$k]['theme_content']=msubstr(strip_tags(preg_replace($patterns, $replace,$v['theme_content'])),0,50);
						$result[$k]['circle_url']=U('Club/club',array('id'=>$v['circle_id']));
					}	
					$this->assign('list',$result);
					echo $html=$this->fetch();
		}			
	
    }

	public function topic_detail(){
		$id=intval($_REQUEST['id']);
		if(!$id){
    		header("Location:".U("Club/index"));
    	}
    	M('circle_theme')->where('theme_id='.$id)->setInc('theme_browsecount'); // 浏览加1
    	$topic=M("circle_theme")->field('theme_id,circle_id,theme_name,theme_content,circle_name,theme_edittime,theme_addtime,theme_likecount,member_id,theme_browsecount')->where("theme_id=".$id)->find();  
    	$topic['user_name']=getUserName($topic['member_id']);
    	$topic['theme_content']=str_replace('src="/ueditor/','src="http://club.17cct.com/ueditor/',$topic['theme_content']);
    	$this->assign('topic',$topic);
    	$this->assign('title',$topic['theme_name']);
    	$topic_list=M('circle_theme')->field('theme_id,theme_name')->where('theme_id !='.$id." and circle_id=".$topic['circle_id'])->limit(3)->order('theme_browsecount desc,theme_likecount desc')->select();
    	$this->assign('topic_list',$topic_list);

		$this->display();
	}

	public function like_click(){
		$id=intval($_REQUEST['id']);
		if(!$id){
    		$this->ajaxReturn(0);
    	}else{
    		$r=M('circle_theme')->where('theme_id='.$id)->setInc('theme_likecount'); // 喜欢加1
    		if($r){
    			$this->ajaxReturn(1);
    		}else{
    			$this->ajaxReturn(0);
    		}
    	}
	}

	public function activity(){
		$cid=intval($_REQUEST['id']);	

		if(!$cid){
			$this->redirect("Index/index");
		}
		$type=intval($_REQUEST['type']);
		if(!$type){
			$type=1;
		}
		$this->assign('type',$type);
		$this->assign('circle',get_circle_info($cid));

		$this->display();
	}
	public function activity_detail(){
		require_once "Jssdk.php";
        $jssdk = new JSSDK("wxbd68bd4fe539eba2", "f2c29cdcbf2543e7531aef5e7651585c");
        $signPackage = $jssdk->GetSignPackage();
		$this->assign('signPackage',$signPackage);
        $this->assign('no_include',1);

		$a_id=$_REQUEST['id'];
    	$activity=M('circle_activity')->where('id='.$a_id)->find();
		if($activity['isonline']==1){
			$activity['type']="线上";
		}else{
			$activity['type']=get_circle_city($activity['city']);
		}

		$activity['detail']=htmlspecialchars_decode($activity['detail']);

		//允许加入的对象  1平台所有会员 2车友会员 3本车友会员 
		if($activity['allowjoin']==1){

			$activity['status']=$this->get_activity_status($activity);

		}elseif($activity['allowjoin']==2){
			if(M('circle_member')->field('circle_id')->where("member_id=".session('uid')." and cm_state=1")->find()||!session('uid')){

				$activity['status'] = $this->get_activity_status($activity);

			}else{
				$activity['status']='<button type="button" onclick="javascript:MsgBox(\'必须加入一个车友会才可参加此活动\',\'提示\');" class="btn  btn-block  btn-warning" >报名参加</button>';
			}
		}else{
			if(M('circle_member')->field('circle_id')->where(" circle_id=".$activity['circle_id']." and member_id=".session('uid'))->find()||!session('uid')){
					$activity['status']=$this->get_activity_status($activity);
			}else{
				$activity['status']='<button type="button" onclick="javascript:MsgBox(\'必须加入本车友会才可参加此活动\',\'提示\');" class="btn  btn-block  btn-warning" >报名参加</button>';
			}
		}
		$other_activity=M('circle_activity')->where('id!='.$a_id." and circle_id=".$activity['circle_id'])->limit(3)->select();
		$this->assign('circle_info',get_circle_info($activity['circle_id']));
    	$this->assign('a',$activity);
    	$this->assign('oa',$other_activity);
    	$this->assign('title',$activity['name']);
		$this->assign('uid',session('uid'));
		$this->display();
	}

	 public function get_activity_status($activity){
    	//报名状态 	
		$join_info=M('circle_activity_enroll')->field('status')->where(' activity_id='.$activity['id']." and member_id=".session('uid'))->find();
    	//status 活动状态  0.我要报名，1审核中，2.已报名，3.报名已结束，4.活动中，5.活动已结束
				
				$result='<a href="'.U('Club/join_activity',array('id'=>$activity['id'],'cid'=>$activity['circle_id'])).'" type="button" class="btn  btn-block  btn-warning">报名参加</a>';

				//1.审核
				if($join_info['status']==1){
					$result='<a type="button" class="btn  btn-block  btn-default" disabled="disabled">审核中</a>';
				}

				//2.取消报名，
				if($join_info['status']==3){
					$result='<a type="button" class="btn  btn-block  btn-default" disabled="disabled">已报名</a>';
				}

			    //3.报名已结束
				if($activity['number_of_people']!=0){

					if($activity['end_enroll_time']<=time()||$activity['enroll_num']>=$activity['number_of_people']){
						if($activity['status']!=2) $result='<a type="button" class="btn  btn-block  btn-default" disabled="disabled">报名已结束</a>';
					}
				}else{			
					if($activity['end_enroll_time']<=time()){
						if($activity['status']!=2) $result='<a type="button" class="btn  btn-block  btn-default" disabled="disabled">报名已结束</a>';
					}
				}

				//4.活动中    
				if($activity['star_time']<=time()&&$activity['end_time']>time()){
					$result='<button type="button" class="btn  btn-block  btn-default" disabled="disabled">活动中</button>';
				}

				//5.活动已结束  
				if($activity['end_time']<=time()){
					$result='<a type="button" class="btn  btn-block  btn-default" disabled="disabled">活动已结束</a>';
				}
				return $result;
    }
    public function join_activity(){

    	$id=intval($_REQUEST['id']);
    	$cid=intval($_REQUEST['cid']);
    	if(!$id||!$cid){
    		$this->redirect("Club/index");
    	}
    	isLogin(U('Club/join_activity',array('id'=>$id,'cid'=>$cid)));
    	$join=M('circle_activity_enroll')->where('member_id='.session('uid')." and activity_id=".$id)->find();
    	if($join){
    		//$this->redirect("Club/activity_detail");
    		$this->redirect('Club/activity_detail',array('id'=>$id),0,'loading……');
    	}
    	
    	$user_info=M('user')->field('true_name,mobile')->where('id='.session('id'))->find();
    	$this->assign('user_info',$user_info);
    	$this->assign('id',$id);
    	$this->assign('cid',$cid);
    	$this->display();
    }

    public function dojoin_activity(){
    	if(!$_REQUEST['name']){
    		echo '名字不能为空';
    		exit;
    	}
    	if(!$_REQUEST['phone']){
    		echo '号码不能为空';
    		exit;
    	}
    	if(!is_numeric($_REQUEST['num'])){
    		echo '人数至少为1';
    		exit;
    	}
    	if(!session('uid')){
    		echo '请登录再操作';
    		exit;
    	}
    	if(!$_REQUEST['id']||!$_REQUEST['cid']){
    		echo '非法操作';
    		exit;
    	}
    	$join=M('circle_activity_enroll')->where('member_id='.session('uid')." and activity_id=".$_REQUEST['id'])->find();
    	if($join){
    		echo '请勿重复报名';
    		exit;
    	}
    	//活动表
		$activity_info=M('circle_activity')->field('number_of_people,enroll_num')->where('id='.$_REQUEST['id'])->find();

		//统计已报名人数
		$count=$_REQUEST['num']+intval($activity_info['enroll_num']);

		//判断报名人数是否超过活动限制人数
			if(intval($activity_info['number_of_people'])==0||$count<=intval($activity_info['number_of_people'])){			
				$data['name']=$_REQUEST['name'];
		    	$data['mobile']=$_REQUEST['phone'];
		    	$data['num']=$_REQUEST['num'];
		    	$data['plate_number']=$_REQUEST['plate_number'];
		    	$data['remarks']=$_REQUEST['remarks'];
		    	$data['circle_id']=$_REQUEST['cid'];
		    	$data['member_id']=session('uid');
		    	$data['activity_id']=$_REQUEST['id'];
		    	$data['enroll_time']=time();
		    	$data['status']='1';
		    	$r=M('circle_activity_enroll')->add($data);
		    	if($r){
		    		echo 200;
		    	}else{
		    		echo '请刷新后重新提交';
		    		exit;
		    	}
								
            }else{
            	echo '报名失败，报名人数超出限制人数';
            	exit;
            }

    	
    }
	public function ajax_get_activity(){
		if(!isset($_REQUEST['id']))die();
		$cid=intval($_REQUEST['id'])>0?intval($_REQUEST['id']):0;		
		$type=intval($_REQUEST['type']);
		$page=$_GET['p'];

		if ($type == 99) {
			$where = array('recommend'=>1);
		}else{
			$where = array('circle_id'=>$cid);
		}
		$activity=M('circle_activity')->where($where)->limit($page*5,5)->order('sort desc,id desc')->select();
    	foreach ($activity as $k => $v){

    		$activity[$k]['cover_img']=get_circle_img($v['circle_id'],$v['cover_img']);
    		//status 活动状态 
    		$join_info=M('circle_activity_enroll')->field('status')->where('circle_id='.$id.' and activity_id='.$v['id']." and member_id=".session('uid'))->find();

			//0.火热报名中，1审核中，2.已报名，3.报名已结束，4.活动中，5.活动已结束

			$activity[$k]['status']='火热报名中';
			$activity[$k]['class']='warning';
			//1.审核中
			if($join_info['status']==1){
				$activity[$k]['status']='审核中';
				$activity[$k]['class']='default';
			}
			//2.已报名
			if($join_info['status']==3){
				$activity[$k]['status']='已报名';
				$activity[$k]['class']='default';
			}
		    //3.报名已结束
			if($v['number_of_people']!=0){
				if($v['end_enroll_time']<=time()||$v['enroll_num']>=$v['number_of_people']){
					if($activity[$k]['status']!=2) $activity[$k]['status']='报名已结束';
					$activity[$k]['class']='danger';
				}
			}else{
				if($v['end_enroll_time']<=time()){
					if($activity[$k]['status']!=2) $activity[$k]['status']='报名已结束';
					$activity[$k]['class']='danger';
				}
			}
			//4.活动中    
			if($v['star_time']<=time()&&$v['end_time']>time()){
				$activity[$k]['status']='活动中';
				$activity[$k]['class']='danger';
			}
			//5.活动已结束  
			if($v['end_time']<=time()){
				$activity[$k]['status']='活动已结束';
				$activity[$k]['class']='danger';
			}

			if($v['isonline']==1){
				$activity[$k]['type']="线上";
			}else{
				$activity[$k]['type']=get_circle_city($v['city']);
			}

    	}
    	$this->assign('list',$activity);
    	echo $html=$this->fetch();
	}

	public function ranking(){
		$cid=intval($_REQUEST['cid']);
		$bid=intval($_REQUEST['bid']);

		$city= M('region_conf')->field('id,name')->where('region_level = 3 and pid=7')->select();
		//在数组第一位写入全部
		array_unshift($city,array('id'=>0,'name'=>'全部'));
		foreach ($city as $k => $v) {
			if($cid==$v['id']&&$v['id']!=0){
				$this->assign('cname',$v['name']);
			}
			$city[$k]['link']=$this->link_url(1)."&cid=".$v['id'];
		}
		$this->assign('city',$city);

		//汽车品牌
		$brand=M('car')->field('id,name')->where('parent_id =0')->select();
		array_unshift($brand,array('id'=>0,'name'=>'全部'));
		foreach ($brand as $k => $v) {
			if($bid==$v['id']&&$v['id']!=0){
				$this->assign('bname',$v['name']);
			}
			$brand[$k]['link']=$this->link_url(2)."&bid=".$v['id'];
		}		
		$this->assign('brand', $brand); 
		$this->assign('cid',$cid);
		$this->assign('bid',$bid);
		$this->display();		
	}

	public function ajax_get_ranking(){

		$cid=$_REQUEST['cid'];//城市
		$bid=$_REQUEST['bid'];//品牌 level=0
		$page=intval($_REQUEST['p']);
		require_once 'rankArray.php';
		$where=" circle_status=1 ";
		require_once 'rankArray.php';
		if($cid>0){
			$where.=" and region_id=".$cid;
		}
		if($bid>0){
			foreach ($car_brandArr as $k =>$v) {
				if($bid==$v['brandId']){
					$where.=" and class_id in(".$v['brand_arr'].")";
				}
			}
		}		

		$club=M('circle')->field('circle_id,circle_name,circle_oil,circle_mcount,circle_img,region_id,class_id,circle_oil_level,circle_identification_count')->where($where)->order('circle_oil desc,circle_mcount desc,circle_oil_level desc')->limit($page*10,10)->select();
	
		foreach ($club as $k => $v) {

			//车型信息
			$club[$k]['car_info']=get_car_name($v['class_id']);
			//链接
			$club[$k]['url']=U('Club/club',array('id'=>$v['circle_id']));
			//地区信息
			$club[$k]['region_info']=get_circle_city($v['region_id']);		
			if(!$page){
				$club[$k]['k']=$k+1;	
			}else{
				$club[$k]['k']=($k+1)+($page*10);
			}
			

			$club[$k]['level']=$v['circle_oil_level']*20;
			
			$club[$k]['circle_img']=get_circle_img($v['circle_id'],$v['circle_img']);
			if(substr($club[$k]['circle_img'],0,8)=='http://i'){
				$club[$k]['circle_img'].='!thumbnail';
			}
		}
		if($club){
			$this->assign('club',$club);
			echo $html=$this->fetch();	
		}else{
			echo '';
		}
		
	}
	public function jump(){
		if($_REQUEST['id']){
			$url="http://weixin.17cct.com/index.php/Club/".$_REQUEST['action'].".html?id=".$_REQUEST['id'];
		}else{
			$url="http://weixin.17cct.com/index.php/Club/".$_REQUEST['action'].".html";
		}		
		isLogin($url);
	}



	//创建车友会
	public function create(){
		isLogin(U('Club/create'));
		//创建人信息
		$uid = session('uid');
		// $uid = 3691;
	    $member_info=M('user')->field('id,user_name,mobile,true_name,sex')->where(array('id'=>$uid))->find();
	  
	    //未登录则跳转到注册页
		
		  
	    //检查是否已经提交创建申请
	    if($this->checkCreate()){
	    	$this->display('success');
	    	exit;
	    }
	    //检查是否已经加入车友会
	    $circle_id = $this->checkJoin();
	    if($circle_id!= 0){
	    	$this->redirect('Club/club',array('id'=>$circle_id),0,'loading……');
	    	exit;
	    }
		//地区信息
		$this->regionInfo(7,97);
		//车系信息
		$car_brand= M('car')->field('id,name')->where('parent_id =0')->select();
	    $this->assign('mobile',$member_info['mobile']);
	    $this->assign('true_name',$member_info['true_name']);
	    $this->assign('sex',$member_info['sex']);
		$this->assign('car_brand',$car_brand);
		$this->display();
	}
	//创建申请检测 -- 是否正在申请车友会
	public function checkCreate(){
		$uid = session('uid');
		// $uid = 3691;
		$has_join=M("circle_member")->join('fw_circle as fc on fc.circle_id=fw_circle_member.circle_id')->where("cm_state=1 and circle_status=2 and member_id=".$uid)->field('fc.circle_id')->find();
		if($has_join){
			return true;
		}else{
			return false;
		}
	}
	//创建申请检测--是否已经加入车友会
	public function checkJoin(){
		$uid = session('uid');
		// $uid = 3691;
		$has_join=M("circle_member")->join('fw_circle as fc on fc.circle_id=fw_circle_member.circle_id')->where("cm_state=1 and circle_status=1 and member_id=".$uid)->field('fc.circle_id')->find();
		if($has_join){
			return $has_join['circle_id'];
		}else{
			return 0;
		}
	}

	public function send_code()
	{
		if(isset($_REQUEST['mobile'])&&$_REQUEST['mobile']!=''){
			//type:
			//1.reg_code-注册 验证码
			//2.pwd_code-找回密码 验证码
			$mobile= trim($_REQUEST['mobile']);
			if(preg_match('/^1[3|4|5|7|8]\d{9}$/', $mobile)){
				$pattern ='1234567890';
			    for($i=0;$i<4;$i++) 
			    { 	
			        $key_code.= $pattern{mt_rand(0,9)};//生成php随机数 
			    }
			    session('check_code_mobile',$mobile);

		    	session('create_club_code',$key_code);
				// $send_msg="您好! 您正在诚车堂使用手机创建车友会，验证码：".$key_code."。如非本人操作请忽略或咨询：0771-2756623【诚车堂】";
				$send_msg="您好! 您正在诚车堂使用手机创建车友会，验证码：".$key_code."。如非本人操作请忽略或咨询：0771-2756623";

				// sendPhoneSms($mobile,$send_msg);
				send_sms($mobile,$send_msg);
				$msg="验证码已经发送到你的手机";
				$this->ajaxReturn(0,$msg,1);
			}
			else{
				$msg="请输入正确手机号";
				$this->ajaxReturn(0,$msg,0);
			}
		}
	}

	//手机短信验证码验证
	public function checkCode($code){
		$realCode = trim(session('create_club_code'));
		// $realCode = 1234;
		$code = trim($code);

		return ($code==$realCode)?true:false;
	}
	//保存车友会信息
	public function saveClub(){
		/***防止提交后返回上一页再次提交 begin***/
		//检查是否已经提交创建申请
	    if($this->checkCreate()){
	    	$this->display('success');
	    	exit;
	    }
	    //检查是否已经加入车友会
	    $circle_id = $this->checkJoin();
	    if($circle_id != 0){
	    	redirect('Club/club',array('id'=>$circle_id),0,'loading……');
	    	exit;
	    }

	    /***防止提交后返回上一页再次提交 end***/

		// print_r($_REQUEST);
		//车友会信息
		$club_name=trim($_REQUEST['c_name']);
		$club_province_id=trim($_REQUEST['club_province_id']);
		$club_city_id=trim($_REQUEST['club_city_id']);
		$car_brand=trim($_REQUEST['car_brand']);
		$factory_id=trim($_REQUEST['factory_id']);
		$models_id=trim($_REQUEST['models_id']);
		$qqGroup=trim($_REQUEST['qqGroup']);
		$c_desc=strip_tags(trim($_REQUEST['info']));

		//会员信息
		$true_name=trim($_REQUEST['user_name']);
		$sex=trim($_REQUEST['sex']);
		$code=trim($_REQUEST['code_num']);

		$returnData = array();
		// 车友会名称长度验证
		if(mb_strlen($club_name,'UTF-8')>12){
			//验证不通过
			$returnData['data'] = "";
			$returnData['info'] = "名称长度不能超过12！";
			$returnData['status'] = -2;

			$this->ajaxReturn($returnData,'JSON');
		}
		//手机短信验证码验证
		/*if(!$this->checkCode($code)){
			//验证不通过
			$returnData['data'] = "";
			$returnData['info'] = "验证码不正确！";
			$returnData['status'] = -2;

			$this->ajaxReturn($returnData,'JSON');
		}*/

		if($car_brand!=""||intval($car_brand)!=0){
			$class_id=intval($car_brand);
		}
		if($factory_id!=""||intval($factory_id)!=0){
			$class_id=intval($factory_id);
		}
		if($models_id!=""||intval($models_id)!=0){
			$class_id=intval($models_id);
		}


		$insert = array();

	    //判断是否为认证车主
	    $uid = session('uid');
	    $user_name = session('user_name');
	    // $uid = 3691;
	    // $user_name = '18178005070';
	    $member_info=M('user')->field('is_verify')->where('id='.intval($uid))->find();
	   	if(intval($member_info['is_verify'])==1){
			$insert['circle_identification_count']	= 1;
		}
		$insert['circle_name']			= $club_name;
		$insert['circle_masterid']		= $uid;
		$insert['circle_mastername']	= $user_name;
		$insert['circle_desc']			= $c_desc;
		$insert['region_id']			= intval($club_city_id);				
		$insert['circle_status']		= 2;
		$insert['is_recommend']			= 0;
		$insert['class_id']				= $class_id;
		$insert['circle_addtime']		= time();
		$insert['circle_mcount']		= 1;
		$insert['qq']					=$qqGroup;	
		//油值
	    $user_info=M('user')->field('is_verify')->where(array('id'=>$uid))->find();

	    $create_oil = M('setting')->field('value')->where(array('name'=>'co_create_club'))->find();
	    if($user_info&&$user_info['is_verify']==1){
	    	$verify_oil = M('setting')->field('value')->where(array('name'=>'co_add_c_member'))->find();
			$insert['circle_oil']		=intval($create_oil['value'])+intval($verify_oil['value']);
	    }else{
	    	$insert['circle_oil']		=intval($create_oil['value']);
	    }
		$insert['circle_joinaudit']		=1;		
		$circle_id= M('circle')->add($insert);
		if($circle_id){
			//创建默认相册
			$album['album_name']='默认相册';
			$album['circle_id']=$circle_id;
			$album['member_id']=$uid;
			$album['add_time']=time();
			$album['is_default']=1;
			$am=M('circle_album')->add($album);	
			if($am){
				// 把车友会堂主的信息加入车友会会员表
				$insert = array();
				$insert['member_id']	= $uid;
				$insert['circle_id']	= $circle_id;
				$insert['circle_name']	= $club_name;
				$insert['member_name']	= $user_name;
				$insert['cm_applytime']	= $insert['cm_jointime'] = time();
				$insert['cm_state']		= 1;
				$insert['cm_level']		= '1';
				$insert['cm_levelname']	= '一星级';
				$insert['cm_exp']		= 1;
				$insert['cm_nextexp']	= '2000';
				$insert['is_identity']	= 1;
				$insert['cm_lastspeaktime'] = '';
				$mb=M('circle_member')->add($insert);	
				if($mb){
					//更新个人信息			
					$u_info=array();
					$u_info['true_name']=$true_name;
					$u_info['sex']=intval($sex);
					$r=M('user')->where('id='.$uid)->save($u_info);
					if($r || $r==0){
						$result['data'] = U('Club/create');
						$result['info'] = "恭喜您，创建车友会成功!";
						$result['status'] = 200;
					}else{
						$result = array('data'=>M()->getLastSql(),'info'=>'会员信息更新失败!',-1);
					}
				}else{
					$result = array('data'=>M()->getLastSql(),'info'=>'车友会会员创建失败!',-1);
				}
			}else{
				$result = array('data'=>M()->getLastSql(),'info'=>'车友会相册创建失败!',-1);
			}				
		}else{
			$result = array('data'=>M()->getLastSql(),'info'=>'车友会创建失败!',-1);
		}
		
		$this->ajaxReturn($result,'JSON');
	}

	public function check_c_name(){
		$circle_info= M('circle')->field('circle_id')->where('circle_name="'.$_REQUEST['name'].'"')->find();
		if($circle_info){
			$this->ajaxReturn('','',0);	
		}else{
			$this->ajaxReturn('','',1);
		}	
	}

	//获取车型信息
	public function get_car_info(){	
		$car_info= M('car')->field('id,name')->where('parent_id='.$_REQUEST['id'])->select();
		$select_id=$_REQUEST['select_id'];
		if($car_info){
			$result="<option value=''>请选择".$_REQUEST['type']."</option>";
			foreach ($car_info as $k => $v) {
					if($select_id==$v['id']){
						$select='selected';
					}
				$result.="<option ".$select."  value='".$v['id']."'>".$v['name']."</option>";

			}
		}		
		echo json_encode($result);
	}

	//车友会地区（3级）
	protected function regionInfo($province_id,$city_id){

		$region_lv2= M('region_conf')->field('id,name')->where('region_level = 2')->select();
		foreach($region_lv2 as $k=>$v)
		{
			if($v['id'] == intval($province_id))
			{
				$region_lv2[$k]['selected'] = 'selected';
				break;
			}
		}
		
		$region_lv3= M('region_conf')->field('id,name')->where('pid ='.intval($province_id))->select();
		foreach($region_lv3 as $k=>$v)
		{
			if($v['id'] == intval($city_id))
			{
				$region_lv3[$k]['selected'] = 'selected';
				break;
			}
		}
		$this->assign('region_lv2', $region_lv2);
		$this->assign('region_lv3', $region_lv3);
	}

	//相册
	public function album(){
		$circle_id=intval($_REQUEST['id']);
		$circle_info=get_circle_info($circle_id);
		if($circle_info){
			$this->assign('circle_info',get_circle_info($circle_id));
			$this->display();	
		}else{
			$this->redirect('Club/index');
		}
		
	}
	//加载相册
	public function ajax_get_album(){
		$circle_id=$_REQUEST['id'];
		$page=$_REQUEST['p'];
		$album=M('circle_album')->where('circle_id='.$circle_id)->limit($page*4,4)->select();	
		foreach ($album as $k => $v) {					
			$album[$k]['cover_img']=getClubImgUrl($v['cover_img'],array('album',$v['circle_id'],'160x100'));
			$album[$k]['count']=intval(M('circle_album_img')->where('album_id='.$v['album_id'])->count());
		}
		$this->assign('album',$album);
		echo $html=$this->fetch();
	}

	public function album_img(){
		$aid=intval($_REQUEST['id']);
		$this->assign('aid',$aid);
		$this->display();
	}
	//加载相册图片
	public function ajax_get_album_img(){

		$album_id=$_REQUEST['id'];
		$page=$_REQUEST['p'];						
		$img=M('circle_album_img')->where('album_id='.$album_id)->limit($page*10,10)->order('img_id desc')->select();
		if($img){
			foreach ($img as $k => $v) {
				$img[$k]['img']=getClubImgUrl($v['img'],array('album',$v['circle_id'],'160x100'));
			}
		}		
		$this->assign('img',$img);
		echo $html=$this->fetch();
	}

	public function apply(){
		if(!session('uid')){
			header("Location:".U("Club/index"));
		}
		$circle_id=intval($_REQUEST['id']);
		$join_info=M('circle_member')->where('member_id='.session('uid'))->getField('circle_id');		
		if($join_info){
			header("Location:".U("Club/club",array('id'=>$join_info)));
		}

		$this->assign('circle_info',get_circle_info($circle_id));

		//车系信息		
		$car_brand=M('car')->field('id,name')->where('parent_id =0')->select();
		
		$this->assign('car_brand', $car_brand);  

		$user=M('user')->field('true_name,sex,city_id,mobile')->where('id='.session('uid'))->find();

		$region_lv3= M('region_conf')->field('id,name')->where('region_level = 3 and pid=7')->select();
		foreach ($region_lv3 as $k => $v) {
			if($v['id']==$user['city_id']){
				$region_lv3[$k]['sel']="selected";
			}
		}
		$this->assign("user",$user);
		$this->assign('region_lv3', $region_lv3);
		$this->display();
	}	

	public function ajax_apply(){
		$circle_id=$_REQUEST['circle_id'];
		$circle=M('circle')->where('circle_id='.$circle_id)->find();

		if(!$circle||!session('uid')){
			$this->ajaxReturn(0,'非法操作',0);
		}
		$insert['member_id']		= session('uid');
		$insert['circle_id']		= $circle_id;
		$insert['circle_name']		= $circle['circle_name'];
		$insert['member_name']		= session('user_name');
		$insert['cm_applytime']		= $insert['cm_jointime']= time();
		
		$insert['cm_state']			= intval($circle['circle_joinaudit']) == 0 ? 1 : 0;//加入车友会时候需要审核，0不需要，1需要	
		$insert['is_identity']		= 3;	
		$r_member=M('circle_member')->add($insert);

 		$u_update=array(
            'true_name'=>$_REQUEST['name'],
            'sex'=>$_REQUEST['sex'],
            'city_id'=>$_REQUEST['cid']
        	);
        M('user')->where('id='.session('uid'))->save($u_update);
		
        $c_update['is_default']=0;

        M('user_car')->where('user_id='.session('uid'))->save($c_update);
		
         $u_car['brand_id']=$_REQUEST['bid'];
         $u_car['factory_id']=$_REQUEST['fid'];
         $u_car['models_id']=$_REQUEST['mid'];
         $u_car['user_id']=session('uid');
         $u_car['is_default']=1;
        
         $r=M('user_car')->add($u_car);   
        
		if(intval($circle['circle_joinaudit']) == 0){//无需审核
			$update = array(
						'circle_id'=>$circle_id,
						'circle_mcount'=>array('exp','circle_mcount+1')
					);
			M('circle')->where('circle_id='.$circle_id)->save($update);			
		}else{
			$update = array(
						'circle_id'=>$circle_id,
						'new_verifycount'=>array('exp', 'new_verifycount+1')
					);
			M('circle')->where('circle_id='.$circle_id)->save($update);
		}

		if($r_member){
			$this->ajaxReturn(1,U('Club/club',array('id'=>$circle_id)),1);
		}else{
			$this->ajaxReturn(0,'申请失败,请刷新后重试',0);
		}

	}

	public function view()
	{		
		$this->display();

	}





	

}

?>	