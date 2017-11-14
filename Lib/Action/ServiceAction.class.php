<?php
class ServiceAction extends BaseAction 
{
	//服务详细页
	public function view()
	{
		require_once "Jssdk.php";
        $jssdk = new JSSDK("wxbd68bd4fe539eba2", "f2c29cdcbf2543e7531aef5e7651585c");
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
		$did = intval($_GET["id"]);
		$city_id = session('city_id');
		$time = time();

		if (empty($did) || $did < 0) {
			$this->error('该服务不存在');
		}

		$d_f = 'fw_deal.id as did,fw_deal.name as dname,fw_deal.deal_cate_id,fw_deal.current_price,fw_deal.begin_time,fw_deal.end_time,fw_deal.brand_promote';
		$d_f .= ',fw_deal.promote_price,fw_deal.origin_price,fw_deal.brief,fw_deal.description,fw_deal.img,fsl.id as sid,fsl.name as lname,fsl.address,fsl.tel,fsl.mobile';
		$d_w['fw_deal.id'] = $did ;
		$d_w['fw_deal.is_shop'] = array(array('eq',0),array('eq',2), 'or');
		$d_w['fw_deal.is_effect'] = 1 ;
		$d_w['fw_deal.is_delete'] = 0 ; 
		$d_w['fw_deal.erp_project_id']=array('gt',0);//只显示ERP中同步的项目/商品
		$d_w['fsl.is_effect'] = 1;

		$deal =  M('deal')->join('fw_supplier_location as fsl ON fsl.id = fw_deal.location_id')->field($d_f)->where($d_w)->find();

		if (empty($deal)) {
			$this->error('该服务不存在或者已经下架');
		}

		$deal['description']=str_replace('src="/ueditor/','src="http://www.17cct.com/ueditor/',$deal['description']);

		//图片
		$deal['img'] = empty($deal['img']) ? M('deal_cate_type')->getFieldById($deal['deal_cate_id'],'img') : $deal['img'] ;
		//图文详情
		$deal['img_detail'] = getImageAttribute($deal['description']);
		//价格
		if($deal['brand_promote'] == 1 && $deal['begin_time'] < $time && $time < $deal['end_time']){
			if($deal['promote_price'] >= 0){
				$deal['current_price'] = $deal['promote_price'];
			}
		}
		//简介
		if (empty($deal['brief'])) {
			$deal_cate_id_detail = M('deal_cate_type')->getFieldById($deal['deal_cate_id'],'detail');
			$deal['brief'] = empty($deal_cate_id_detail) ? '暂无简介' : $deal_cate_id_detail;
		}
		//商家电话
		$deal['tel'] = empty($deal['tel']) ? $deal['mobile'] : $deal['tel'] ;
		//属性
		$deal = $this->getAttrList($deal);

		//评价 
		$r_f = 'u.user_name,u.true_name,fw_supplier_location_dp.title,fw_supplier_location_dp.point,fw_supplier_location_dp.create_time,fw_supplier_location_dp.content,fw_supplier_location_dp.imgs,fw_supplier_location_dp.id';
		$r_w['fw_supplier_location_dp.rel_param']    = 'id='.$did;
		$r_w['fw_supplier_location_dp.content'] 	 = array(array('neq','用户超期未评价，系统自动给出好评。'),array('neq',''));
		$r_w['fw_supplier_location_dp.create_time']  = array('lt',time());

		$reviews = M('supplier_location_dp')->join('fw_user as u ON u.id = fw_supplier_location_dp.user_id')->field($r_f)->where($r_w)->limit(3)->order('create_time desc')->select();
		if ($reviews){
			foreach ($reviews as $k => $v) {
				$reviews[$k]['user_name'] =getUserName(array($v['user_name'],$v['true_name']));
				$reviews[$k]['content'] = msubstr(strip_tags($v['content']),0,50);
				$reviews[$k]['dp_point_group']=M('supplier_location_dp_point_result')->field('group_id,point')->where('group_id in(1,2) and dp_id='.$v['id'])->select();
				if ($v['imgs']) {
					$imgs_arr = explode(',',$v['imgs']);
					$reviews[$k]['imgs'] = $imgs_arr;
				}
			}
			$reviews_count_nums = M('supplier_location_dp')->where($r_w)->count(0);
			$this->assign('reviews',$reviews);
			$this->assign('reviews_count_nums',$reviews_count_nums);
		} 

		//看了本服务的用户还看了
		$rs_f = 'fw_deal.id,fw_deal.name,fw_deal.deal_cate_id,fw_deal.buy_count,fw_deal.transaction_count,fw_deal.current_price,fw_deal.origin_price,fw_deal.begin_time,fw_deal.end_time,fw_deal.brand_promote,fw_deal.promote_price,fw_deal.img,fw_deal.brief';
		$rs_w['fw_deal.id'] = array('neq',$did) ;
		$rs_w['fw_deal.is_shop'] = array(array('eq',0),array('eq',2), 'or');
		//$rs_w['fw_deal.is_recommend'] = 1 ;
		$rs_w['fw_deal.is_effect'] = 1 ;
		$rs_w['fw_deal.is_delete'] = 0 ;
		$rs_w['fw_deal.erp_project_id']=array('gt',0);//只显示ERP中同步的项目/商品
		$rs_w['fw_deal.city_id'] = $city_id ;
		$rs_w['fsl.is_effect'] = 1 ;
		$rs_w['fsl.city_id'] = $city_id ;

		$recommend_deals =  M('deal')->join('fw_supplier_location as fsl ON fsl.id = fw_deal.location_id')->field($rs_f)->where($rs_w)->limit(3)->order('rand(),fw_deal.click_count desc,fw_deal.sort desc,fw_deal.create_time desc')->select();
		foreach ($recommend_deals as $k => $v) {
			if (empty($v['img'])) {
				$recommend_deals[$k]['img'] = M('deal_cate_type')->getFieldById($v['deal_cate_id'],'img');
			}
			if (empty($v['brief'])) {
				$deal_cate_id_detail = M('deal_cate_type')->getFieldById($v['deal_cate_id'],'detail');
				$recommend_deals[$k]['brief'] = empty($deal_cate_id_detail) ? '暂无简介' : $deal_cate_id_detail;
			}
			if($v['brand_promote'] == 1 && $v['begin_time'] < $time && $time < $v['end_time']){
				if($v['promote_price'] >= 0){
					$recommend_deals[$k]['current_price'] = $v['promote_price'];
				}
			}
			
			//订单数量  
			$recommend_deals[$k]['order_count'] = $v['buy_count'] + $v['transaction_count'];
		}
		$this->assign('recommend_deals',$recommend_deals);

 		// 浏览量加1
		M('deal')->where(array('id'=>$did))->setInc('click_count');
		$this->assign('deal',$deal);
		$this->assign('did',$did);
		$this->assign('title',$deal['dname']);
		$this->display();
	}

	// ajax  加载评论
	public function ajaxGetReviews()
	{
		$did     	  =  intval($_POST['id']);      // 服务id
		$page   	  =  intval($_POST['page']);    // 页数（加载次数）
		$allRows  	  =  intval($_POST['arows']);   // 评论总数
		$existRows    =  intval($_POST['erows']);	// 页面初始已经加载的行数
		$loadingRows  =  intval($_POST['lrows']);	// 加载行数

		if (empty($did) || empty($page) || empty($allRows)  || empty($existRows) || empty($loadingRows) ||  $did < 0 || $allRows < 0 || $page < 0 || $existRows < 0 || $loadingRows < 0) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}

		$r_f = 'u.user_name,u.true_name,fw_supplier_location_dp.title,fw_supplier_location_dp.point,fw_supplier_location_dp.create_time,fw_supplier_location_dp.content,fw_supplier_location_dp.imgs';
		$r_w['fw_supplier_location_dp.rel_param']    = 'id='.$did;
		$r_w['fw_supplier_location_dp.content'] 	 = array(array('neq','用户超期未评价，系统自动给出好评。'),array('neq',''));
		$r_w['fw_supplier_location_dp.create_time']  = array('lt',time());
		$r_l = $existRows+($loadingRows*($page-1)).','.$loadingRows;

		$reviews_count = M('supplier_location_dp')->join('fw_user as u ON u.id = fw_supplier_location_dp.user_id')->where($r_w)->count(0);
		$reviews = M('supplier_location_dp')->join('fw_user as u ON u.id = fw_supplier_location_dp.user_id')->field($r_f)->where($r_w)->limit($r_l)->order('create_time desc')->select();
		if ($reviews){
			foreach ($reviews as $k => $v) {
				$reviews[$k]['user_name'] =getUserName(array($v['user_name'],$v['true_name']));
				$reviews[$k]['create_time'] = date('Y-m-d',$v['create_time']);
				$reviews[$k]['content'] = msubstr(strip_tags($v['content']),0,50);
				if ($v['imgs']) {
					$imgs_arr = explode(',',$v['imgs']);
					foreach ($imgs_arr as $i_k => $i_v) {
						$imgs_arr[$i_k] = getImgUrl($i_v,'thumbnail');
					}
					$reviews[$k]['imgs'] = $imgs_arr;
				}
			}
			$allShowRows = $existRows+$loadingRows*$page;
			if ($allShowRows >= $allRows) {
				$this->ajaxReturn($reviews,"加载成功",2);
			} else {
				$this->ajaxReturn($reviews,"加载成功",1);
			}
		}else{
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		} 
	}

	// ajax  计算通过定位后与商家的距离
	public function getDistanceToStore()
	{
		$sid   = intval($_POST['id']);  //商家id
		$mylat = $_POST['lat']; //纬度
		$mylng = $_POST['lng']; //经度

		if (empty($sid)|| empty($mylat)|| empty($mylng) || $sid <= 0 ) {
			$this->ajaxReturn(0,'定位参数错误，请刷新后重试',0);
		}

		$storePosition = M('supplier_location')->field('xpoint,ypoint')->find($sid );
		if ($storePosition) {
			if ($storePosition['xpoint'] == '' || $storePosition['ypoint'] == '') {
				$this->ajaxReturn(0,'商家未标注位置',0);
			}
			$distance = getDistance($mylat,$mylng,$storePosition['ypoint'],$storePosition['xpoint']);
			$this->ajaxReturn($distance,'计算距离成功',1);
		}else {
			$this->ajaxReturn(0,'计算距离失败，请刷新后重试',0);
		}
	}

	//属性价格信息
	public function getAttrList($deal = array())
	{	
		if (!is_array($deal)) {
			return false;
		}
		$did = $deal['did'];
		//默认属性
		$submeter_info = M('deal_submeter')->where(array('deal_id'=>$did))->order('id asc')->find();
		if($submeter_info){
			$deal['deal_submeter_id'] = $submeter_info['id'];
			$deal['origin_price'] = $submeter_info['origin_price'];
			if($submeter_info['begin_time']<time() && $submeter_info['end_time']>time()){
				$deal['current_price'] = $submeter_info['promote_price'];
			}else{
				$deal['current_price'] = $submeter_info['price'];
			}
			//属性列表
		    $d_f = 'dta.name,fw_deal_attr_record.attr_value,fw_deal_attr_record.id,fw_deal_attr_record.goods_type_attr_id,fw_deal_attr_record.deal_submeter_id';
		    $d_w = array('fw_deal_attr_record.deal_id'=>$did);
		    $d_o = 'dta.sort desc,fw_deal_attr_record.id asc';
		    $deal_attrs_res = M('deal_attr_record')->join('fw_goods_type_attr as dta ON dta.id = fw_deal_attr_record.goods_type_attr_id')->field($d_f)->where($d_w)->order($d_o)->select();
		   
		    $attr_arr=array();
		    foreach ($deal_attrs_res as $k => $v) {				 
			    	$attr_arr[$v['name']][]=$v;
		    }
		    foreach ($attr_arr as $key => $val) {
		   		foreach ($val as $k => $v) {
		   			if($attr_list[$v['attr_value'].$v['goods_type_attr_id']]){
		   				if(!$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['is_first']){
		   					if($submeter_info['id']==$v['deal_submeter_id']){		   				
								$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['is_first']=1;}else{
								$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['is_first']=0;
							}
		   				}
		   				if(trim($attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['name'])==trim($v['name'])){
		   					$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['id'].='_'.$v['id'];
			   				$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['deal_submeter_id'].='_'.$v['deal_submeter_id'];

		   				}else{
		   					$attr_list[$v['attr_value'].$v['goods_type_attr_id']][]=$v;
		   				}
		   				
		   			}else{
		   				if($submeter_info['id']==$v['deal_submeter_id']){			   				
							$v['is_first']=1;								
						}else{
							$v['is_first']=0;
						}

		   				$attr_list[$v['attr_value'].$v['goods_type_attr_id']][]=$v;
		   			}
		   			$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['ids'][]=$v['id'];
					$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['deal_submeter_ids'][]=$v['deal_submeter_id'];	
		   		}			   			
		    }
			if($attr_list)
			{
				$attr_arr=array_values($attr_list);
				foreach($attr_arr as $key=>$val)
				{ 
					foreach ($val as $k => $v) {
						//排序链接字符串
						$sort_ids=$v['ids'];							
						sort($sort_ids);
						$sort_id=implode('_', $sort_ids);
						$v['id']=$sort_id;
						$deal_submeter_ids=$v['deal_submeter_ids'];
						sort($deal_submeter_ids);
						$deal_submeter_id=implode('_', $deal_submeter_ids);
						$v['deal_submeter_id']=$deal_submeter_id;
						$deal_attr[$v['goods_type_attr_id']]['name'] = $v['name'];
						$deal_attr[$v['goods_type_attr_id']]['attrs'][] = $v;	

					}
						
				}
				$deal['deal_attr_list'] = $deal_attr;
			}				
		}
		return $deal;
	}

	//AJAX获取属性差价
	public function ajaxGetAttrPrice(){

		$deal_id = intval($_POST['deal_id']);
		$sub_ids = explode('_',$_POST['subid']);//点击的deal_submeter_id
		$cl = $_POST['cl'];//btn-default即为取消选择,btn-danger即为选中
		$fcid = explode('_',$_POST['fcid']);//当前点击的按钮
		$sub_id=implode(',',$sub_ids);

		if (!M('deal_submeter')->getFieldById($sub_ids[0],'deal_id')) {
			$deal['selectFinish'] = -1;
			$this->ajaxReturn($deal,'',0);
		}

		$attr_id = rtrim($_POST['attr_id'],',');
		if(session('sub_id_s') != $sub_ids[0])
		{
			//全部属性列表
			$d_f = 'dta.name,fw_deal_attr_record.attr_value,fw_deal_attr_record.id,fw_deal_attr_record.goods_type_attr_id,fw_deal_attr_record.deal_submeter_id';
		    $d_w = array('fw_deal_attr_record.deal_id'=>$deal_id);
		    $d_o = 'dta.sort desc';
		    $deal_attrs_res = M('deal_attr_record')->join('fw_goods_type_attr as dta ON dta.id = fw_deal_attr_record.goods_type_attr_id')->field($d_f)->where($d_w)->order($d_o)->select();

			$record_attr_arr=array();
		    foreach ($deal_attrs_res as $k => $v) {				 
			   	$record_attr_arr[$v['name']][]=$v;
		   	}
		   	foreach ($record_attr_arr as $key => $val) {
		   		foreach ($val as $k => $v) {
		   			
		   			if($attr_list[$v['attr_value'].$v['goods_type_attr_id']]){
		   				if($attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['name']==$v['name']){
		   					$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['id'].='_'.$v['id'];		
			   				$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['deal_submeter_id'].='_'.$v['deal_submeter_id'];
		   				}else{
		   					$attr_list[$v['attr_value'].$v['goods_type_attr_id']][]=$v;
		   				}		   						   				
		   			}else{
		   				$attr_list[$v['attr_value'].$v['goods_type_attr_id']][]=$v;
		   			}
		   			$all_attr_list[$v['deal_submeter_id']][]=$v;
		   			$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['ids'][]=$v['id'];
					$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['deal_submeter_ids'][]=$v['deal_submeter_id'];		   			
		   		}			   			
			 } 
		
			 $attr_list=array_values($attr_list);
			 foreach ($attr_list as $key => $val) {			 
			 	foreach ($val as $k => $v) {
			 		$sort_ids=$v['ids'];							
					sort($sort_ids);
					$sort_id=implode('_', $sort_ids);
					$v['id']=$sort_id;
					$deal_submeter_ids=$v['deal_submeter_ids'];
					sort($deal_submeter_ids);
					$deal_submeter_id=implode('_', $deal_submeter_ids);
					$v['deal_submeter_id']=$deal_submeter_id;
			 		$attr_id_list[]=$v['id'];
			 		$attr_attr_list[]=$v;
			 	}			 	
			 }
			
		$all_attr_list=array_values($all_attr_list);
		foreach($attr_attr_list as $key => $val) {				
			foreach($all_attr_list as $k => $v) {
					foreach($v as $k1 => $v1) {						
						if(in_array($v1['deal_submeter_id'],$val['deal_submeter_ids'])){
							$all_attr_list[$k][$k1]['deal_submeter_ids']=$val['deal_submeter_id'];
						}
						if(in_array($v1['id'],$val['ids'])){
							$all_attr_list[$k][$k1]['ids']=$val['id'];
						}
					}
					
			}	
		
		}
		foreach($all_attr_list as $k => $v) {					
				foreach($v as $k1 => $v1) {						
					$all_finish_arr[$k][]=$v1['ids'];
				}					
			}
			session('attr_id_list',$attr_id_list);
			session('all_finish_arr',$all_finish_arr);
			session('sub_id_s',$sub_ids[0]);
		}
		if($attr_id){
			$attr_ids = explode(',', $attr_id);	
			foreach ($attr_ids as $k => $v) {
				if(is_numeric($v)){
					$attr_arr[]=$v;
				}else{
					$arr=explode('_',$v);
					foreach ($arr as $key => $value) {
						$attr_arr[]=$value;
					}
				}
			}
			$all_finish_arr = session('all_finish_arr');
			foreach ($all_finish_arr as $k => $v) {
				$count=0;
				foreach ($v as $k1 => $v1) {
					foreach ($attr_ids as $k2 => $v2) {
						if($v2==$v1){
							$count++;
						}
					}
				}
				if($count==count($v)){
					$select_attr=1;
					break;
				}else{
					$select_attr=0;
				}
			}
			//选择完成，对比时数组值的顺序也必须一致
			if($select_attr){
				$can[]=$attr_ids;
				foreach ($all_finish_arr as $k => $v) {							
					if(intval(count(array_diff($v,$attr_ids)))==1){
						$can[]=$all_finish_arr[$k];					
					}			     
				}
				$finish_sel_ids = M('deal_attr_record')->field('id,deal_submeter_id')->where(array('deal_submeter_id'=>array('in',$sub_id)))->select();
				foreach ($finish_sel_ids as $k => $v) {
					$finish_arr[$v['deal_submeter_id']][]=$v['id'];
				}		
				foreach ($finish_arr as $k => $v) {
					$count=0;
					foreach ($v as $k1 => $v1) {
						foreach ($attr_arr as $k2 => $v2) {
							if($v2==$v1){
								$count++;
							}
						}
					}
					//对比完成
					if($count==count($v)){
						$submeter_info = M('deal_submeter')->join('fw_deal_attr_record as dar ON dar.deal_submeter_id = fw_deal_submeter.id')->field('fw_deal_submeter.*')->where(array('dar.id'=>$v[0]))->find();
						$deal['sub_id']=$submeter_info['id'];
						$deal['origin_price']=$submeter_info['origin_price'];
						if($submeter_info['begin_time']<time()&&$submeter_info['end_time']>time()){
							$deal['price']=$submeter_info['promote_price'];
						}else{
							$deal['price']=$submeter_info['price'];
						}				
						$deal['selectFinish'] = 1;
						break;
					}
				}						
			}else{
				//取消选中
				if($_REQUEST['cl']=='btn-default'){
					$can[]=$attr_ids;
					foreach ($all_finish_arr as $k => $v) {					
						if(intval(count(array_diff($v,$attr_ids)))>0){
							$can[]=$all_finish_arr[$k];					
						}			     
					}	
				}else{
					$fc_id[]=$_REQUEST['fcid'];
					foreach ($all_finish_arr as $k => $v) {
						if(array_intersect($fc_id,$v)){
							$other_ids=$v;
							$can[]=$v;
						}
						if($other_ids){							
							if(intval(count(array_diff($v,$other_ids)))==1){
								$can[]=$all_finish_arr[$k];					
							}		
						}								     
					}						
					if($other_ids){
						foreach ($all_finish_arr as $k => $v) {	
								if(intval(count(array_diff($v,$other_ids)))==1){
									$can[]=$all_finish_arr[$k];					
								}		
							}								     
					}

				}

				$deal['selectFinish'] = 0;
			}
			$attr_id_list=session('attr_id_list');
			if($can){
				foreach ($can as $key => $val) {
					foreach ($val as $k => $v) {
						$can_sel_ids[]=$v;
					}
				}	
			}else{
				$can_sel_ids[]=$attr_id_list;
			}
			$can_sel_ids=array_unique($can_sel_ids);//值去重	
		    $canot_attrs_res = array_diff($attr_id_list, $can_sel_ids);	    	
		    $deal['canot_sel_ids']=array_values($canot_attrs_res);		    
			$deal['can_sel_ids']=array_values($can_sel_ids);
		
		}else{
			$deal['selectFinish'] = 0;
			$deal['canot_sel_ids']=array();		    
			$deal['can_sel_ids']=array_values($attr_id_list);
		}
		$this->ajaxReturn($deal,'',1);
	}
}
?>