<?php

class SearchAction extends BaseAction {  

	public function index()
	{
		$this->assign("title","搜索");
		$this->display();
	}

	//ajax 搜索建议
	public function ajaxGetSuggest()
	{
		$keyword = trim($_REQUEST['keyword']);
		$type 	 = intval($_REQUEST['t']);
		if (empty($keyword) || empty($type)) {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
		}
		$city_id = session('city_id');

		switch ($type) {
			case 1://服务
			case 2://商品
				$d_w['fw_deal.is_shop'] = ($type == 1) ? array(array('eq',0),array('eq',2), 'or') : 1 ;
				$d_w['fw_deal.name']      = array('like','%'.$keyword.'%');
				$d_w['fw_deal.is_effect'] = 1 ;
				$d_w['fw_deal.is_delete'] = 0 ;
				$d_w['fw_deal.erp_project_id']=array('gt',0);//只显示ERP中同步的项目/商品
				$d_w['fw_deal.city_id']   = $city_id ;
				$d_w['fsl.city_id'] 	  = $city_id ;
				$d_w['fsl.is_effect']     = 1;
				$d_o = 'fw_deal.is_recommend desc,fw_deal.sort desc,fw_deal.buy_count desc';
				$result =  M('deal')->join('fw_supplier_location as fsl ON fsl.id = fw_deal.location_id')->field('fw_deal.name')->where($d_w)->order($d_o)->limit(10)->select();
				break;
			case 3://商家
				$s_w['name']      = array('like','%'.$keyword.'%');
				$s_w['is_effect'] = 1;
				$s_w['city_id']   = $city_id;
				$s_o = 'is_recommend desc,avg_point desc';
				$result = M('supplier_location')->field('name')->where($s_w)->order($s_o)->limit(10)->select();
				break;
		}
		if ($result) {
			$this->ajaxReturn($result,'搜索成功',1);
		}else {
			$this->ajaxReturn(0,'搜索失败',0);
		}
	}

	public function deal()
	{		
		$keyword = trim($_REQUEST['keyword']);
		$city_id = session("city_id");
		$aid = intval($_GET['aid'])>0?intval($_GET['aid']):0; //区
		$qid = intval($_GET['qid'])>0?intval($_GET['qid']):0; //路
		$oid = intval($_GET['oid'])>0?intval($_GET['oid']):1; //排序
		$type = trim($_REQUEST['type']);
		$time = time();
	
		$sd_w = "fw_deal.is_effect=1 and fw_deal.is_delete=0 and fw_deal.erp_project_id>0 and fw_supplier_location.is_effect=1 and fw_supplier_location.city_id = ".$city_id." and fw_deal.city_id=".$city_id;//只显示ERP中同步的项目/商品
		if(!empty($keyword)) {
			$sd_w.=' and fw_deal.name like "%'.$keyword.'%"';
			$this->assign("keyword",$keyword);
		}
		if ($type == 'service') {
			$cid = intval($_GET['cid'])>0?intval($_GET['cid']):0; //大分类
			$tid = intval($_GET['tid'])>0?intval($_GET['tid']):0; //小分类
			$sqlWhere =  $this->getSqlWhere('n_service',$aid,$qid,$cid,$tid);
			$sd_w .= $sqlWhere['str'];
		}elseif ($type == 'goods') {
			$gcid = intval($_GET['gcid'])>0?intval($_GET['gcid']):0; //大分类
			$gtid = intval($_GET['gtid'])>0?intval($_GET['gtid']):0; //小分类
			$sqlWhere =  $this->getSqlWhere('goods',$aid,$qid,$gcid,$gtid);
			$sd_w .= $sqlWhere['str'];
		}else {
			$this->error('非法操作');
		}
		//获取排序
		$sqlOrder = $this->getSqlOrder('n_deal',$oid);

		$result = M('deal')->join('fw_supplier_location on fw_supplier_location.id=fw_deal.location_id')->field('fw_supplier_location.id')->where($sd_w)->select();
		if ($result) {
			$resultList = array();
			foreach ($result as $k => $v) {
				if (empty($resultList[$v['id']])) {
					$resultList[$v['id']]['sid'] = $v['id'];
				}
			}
		}
		$result_count = count($resultList);

		$this->assign("count",$result_count);
		$this->assign("oid",$oid);
		$this->assign("orderby",$sqlOrder['name']);
		$this->assign("cate_name",$sqlWhere['cate_name']);
		$this->assign("area_name",$sqlWhere['area_name']);
		$link = $this->link_url($_REQUEST,1);
		$this->assign("type",$type);
		$this->assign("link",$link);
		$this->assign("title",$sqlWhere['cate_name']);
		$this->display();
	}

	public function ajaxGetDeal()
	{	
		$keyword = trim($_REQUEST["keyword"]);
		$city_id = session("city_id");
		$aid = intval($_GET['aid'])>0?intval($_GET['aid']):0; //区
		$qid = intval($_GET['qid'])>0?intval($_GET['qid']):0; //路
		$oid = intval($_GET['oid'])>0?intval($_GET['oid']):1; //排序
		$type = trim($_REQUEST['type']);
		$y = $_GET['lat']; //纬度
		$x = $_GET['lng']; //经度
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		$time = time();
		//查找条件
		$sd_w = "fw_deal.is_effect=1 and fw_deal.is_delete=0 and fw_deal.erp_project_id>0 and fw_supplier_location.is_effect=1 and fw_supplier_location.city_id = ".$city_id." and fw_deal.city_id=".$city_id;//只显示ERP中同步的项目/商品
		if(!empty($keyword)){
			$sd_w .= ' and fw_deal.name like "%'.$keyword.'%"';
		} 
		if ($type == 'service') {
			$cid = intval($_GET['cid'])>0?intval($_GET['cid']):0; //大分类
			$tid = intval($_GET['tid'])>0?intval($_GET['tid']):0; //小分类
			$sqlWhere =  $this->getSqlWhere('n_service',$aid,$qid,$cid,$tid);
			$sd_w .= $sqlWhere['str'];
		}elseif ($type == 'goods') {
			$gcid = intval($_GET['gcid'])>0?intval($_GET['gcid']):0; //大分类
			$gtid = intval($_GET['gtid'])>0?intval($_GET['gtid']):0; //小分类
			$sqlWhere =  $this->getSqlWhere('goods',$aid,$qid,$gcid,$gtid,false);
			$sd_w .= $sqlWhere['str'];
		}else {
			$this->error('非法操作');
		}

		//查找属性
		$sd_f  = 'fw_deal.end_time,fw_deal.begin_time,fw_deal.current_price,fw_deal.origin_price,fw_deal.name,fw_deal.sub_name,fw_deal.brief,fw_deal.brand_promote,fw_deal.promote_price,fw_deal.buy_count,fw_deal.transaction_count';
		$sd_f .= ',fw_deal.id,fw_deal.deal_cate_id,fw_deal.img,fw_supplier_location.address,fw_supplier_location.name as sname,fw_supplier_location.ypoint,fw_supplier_location.xpoint,fw_supplier_location.id as sid';
		$sd_f .= ',fw_supplier_location.preview as preview,fw_supplier_location.good_rate,fw_supplier_location.avg_point,fw_supplier_location.tel';

		//获取排序
		$sqlOrder = $this->getSqlOrder('n_deal',$oid);

		$searchDeal = M('deal')->join('fw_supplier_location on fw_supplier_location.id=fw_deal.location_id')->field($sd_f)->where($sd_w)->order($sqlOrder['str'])->select();

		if ($searchDeal) {
			$resultList = array();
			foreach ($searchDeal as $k => $v) {
				if (empty($v['img'])) {
					$searchDeal[$k]['img'] = M('deal_cate_type')->cache(true,600)->getFieldById($v['deal_cate_id'],'img');
				}
				if (empty($v['brief'])) {
					$deal_cate_id_detail = M('deal_cate_type')->cache(true,600)->getFieldById($v['deal_cate_id'],'detail');
					$searchDeal[$k]['brief'] = empty($deal_cate_id_detail) ? '暂无简介' : msubstr($deal_cate_id_detail,0,80);
				}
				if ($type == 'service') {
					$searchDeal[$k]['url'] = U('Service/view',array('id'=>$v['id']));
				}else {
					$searchDeal[$k]['url'] = U('Goods/view',array('id'=>$v['id']));
				}
				$searchDeal[$k]['img'] = getImgUrl($searchDeal[$k]['img'],'middle');
				
				$searchDeal[$k]['origin_price'] = $v['origin_price'];	
				if($v['brand_promote'] == 1 && $v['end_time'] >= $time && $time > $v['begin_time'])
				{
					if($v['promote_price'] >= 0){
						$searchDeal[$k]['current_price'] = $v['promote_price'];
					}					
				} 

				//订单数量  
				$searchDeal[$k]['order_count'] = $v['buy_count'] + $v['transaction_count'];

				if (empty($resultList[$v['sid']])) {
					$resultList[$v['sid']]['sid'] 	    = $v['sid'];
					$resultList[$v['sid']]['url'] 	    = U('Store/view',array('id'=>$v['sid']));
					$resultList[$v['sid']]['sname'] 	= $v['sname'];
					$resultList[$v['sid']]['address']   = $v['address'];
					$resultList[$v['sid']]['avg_point'] = $v['avg_point'];
					$resultList[$v['sid']]['preview'] = getImgUrl($v['preview'],'thumbnail');
					if($y && $x){
						$distance = round(getDistance($y,$x,$v['ypoint'],$v['xpoint']),2);
						$resultList[$v['sid']]['distance'] = $distance;
					}
				}
				$resultList[$v['sid']]['items'][] = $searchDeal[$k];
			}
		}else {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
		}
		if($oid == 1){
			$resultList = multi_array_sort($resultList,'distance',$sort=SORT_ASC);	
		}
			
		$resultList=array_merge($resultList);
		foreach ($resultList as $k => $v){
			if (count($v['items']) >8) {
				$resultList[$k]['items'] = array_slice($v['items'],0,8);
			}			
		}
		$resultList = array_slice($resultList,$page*$lnums,$lnums);	
		$this->ajaxReturn($resultList,'加载成功',1);
	}

	public function specialsale()
	{
		$city_id = session("city_id");
		$aid = intval($_GET['aid'])>0?intval($_GET['aid']):0; //区
		$qid = intval($_GET['qid'])>0?intval($_GET['qid']):0; //路
		$oid = intval($_GET['oid'])>0?intval($_GET['oid']):0; //排序
		$type = trim($_REQUEST['type']);
		$time = time();

		$sd_w ="fw_deal.is_effect=1 and fw_deal.is_delete=0 and fw_deal.erp_project_id>0 and fw_deal.brand_promote = 1 and fw_deal.begin_time <".$time." and fw_deal.end_time >".$time." and fw_supplier_location.is_effect=1 and fw_deal.city_id=".$city_id;//只显示ERP中同步的项目/商品
		if ($type == 'service') {
			$cid = intval($_GET['cid'])>0?intval($_GET['cid']):0; //大分类
			$tid = intval($_GET['tid'])>0?intval($_GET['tid']):0; //小分类

			$sqlWhere =  $this->getSqlWhere('s_service',$aid,$qid,$cid,$tid);
			$sd_w .= $sqlWhere['str'];
		}elseif ($type == 'goods') {

			$gcid = intval($_GET['gcid'])>0?intval($_GET['gcid']):0; //大分类
			$gtid = intval($_GET['gtid'])>0?intval($_GET['gtid']):0; //小分类

			$sqlWhere =  $this->getSqlWhere('goods',$aid,$qid,$gcid,$gtid);
			$sd_w .= $sqlWhere['str'];
		}else {
			$this->error('非法操作');
		}
		//获取排序
		$sqlOrder = $this->getSqlOrder('s_deal',$oid);

		$result_count = M('deal')->join('fw_supplier_location on fw_supplier_location.id=fw_deal.location_id')->field('fw_deal.id')->where($sd_w)->count(0);
		$this->assign("count",$result_count);
		$this->assign("oid",$oid);
		$this->assign("orderby",$sqlOrder['name']);
		$this->assign("cate_name",$sqlWhere['cate_name']);
		$this->assign("area_name",$sqlWhere['area_name']);
		$link = $this->link_url($_REQUEST,1);
		$this->assign("type",$type);
		$this->assign("link",$link);
		$this->assign("title",$sqlWhere['cate_name']);
		$this->display();
	}

	public function ajaxGetSpecialsaleDeal()
	{
		$city_id = session("city_id");
		$aid = intval($_GET['aid'])>0?intval($_GET['aid']):0; //区
		$qid = intval($_GET['qid'])>0?intval($_GET['qid']):0; //路
		$oid = intval($_GET['oid'])>0?intval($_GET['oid']):0; //排序
		$type = trim($_REQUEST['type']);
		$y = $_GET['lat']; //纬度
		$x = $_GET['lng']; //经度
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		$time = time();

		$sd_w ="fw_deal.is_effect=1 and fw_deal.is_delete=0 and fw_deal.erp_project_id>0 and fw_deal.brand_promote = 1 and fw_deal.begin_time <".$time." and fw_deal.end_time >".$time." and fw_supplier_location.is_effect=1 and fw_deal.city_id=".$city_id;//只显示ERP中同步的项目/商品
		if ($type == 'service') {
			$cid = intval($_GET['cid'])>0?intval($_GET['cid']):0; //大分类
			$tid = intval($_GET['tid'])>0?intval($_GET['tid']):0; //小分类
			$sqlWhere =  $this->getSqlWhere('s_service',$aid,$qid,$cid,$tid);
			$sd_w .= $sqlWhere['str'];
		}elseif ($type == 'goods') {
			$gcid = intval($_GET['gcid'])>0?intval($_GET['gcid']):0; //大分类
			$gtid = intval($_GET['gtid'])>0?intval($_GET['gtid']):0; //小分类
			$sqlWhere =  $this->getSqlWhere('goods',$aid,$qid,$gcid,$gtid,false);
			$sd_w .= $sqlWhere['str'];
		}else {
			$this->error('非法操作');
		}
		//查找属性 
		$sd_f = 'fw_deal.id,fw_deal.end_time,fw_deal.origin_price,fw_deal.name,fw_deal.promote_price,fw_deal.deal_cate_id,fw_deal.img,fw_deal.buy_count,fw_deal.transaction_count,fw_supplier_location.ypoint,fw_supplier_location.xpoint';
		//排序
		$sqlOrder = $this->getSqlOrder('s_deal',$oid);
		if ($oid != 1) {
			$sd_l = ($page*$lnums).','.$lnums;
		}

		$specialsaleDeal = M('deal')->join('fw_supplier_location on fw_supplier_location.id=fw_deal.location_id')->field($sd_f)->where($sd_w)->order($sqlOrder['str'])->limit($sd_l)->select();
		if ($specialsaleDeal) {
			foreach ($specialsaleDeal as $k => $v) {
				if (empty($v['img'])) {
					$specialsaleDeal[$k]['img'] = M('deal_cate_type')->cache(true,300)->getFieldById($v['deal_cate_id'],'img');
				}
				$specialsaleDeal[$k]['img'] = getImgUrl($specialsaleDeal[$k]['img'],'middle');
				if ($type == 'service') {
					$specialsaleDeal[$k]['url'] = U('Service/view',array('id'=>$v['id']));
				}else{
					$specialsaleDeal[$k]['url'] = U('Goods/view',array('id'=>$v['id']));
				}				

				//订单数量  
				$specialsaleDeal[$k]['order_count'] = $v['buy_count'] + $v['transaction_count'];

				if($y && $x){
					$specialsaleDeal[$k]['distance'] = round(getDistance($y,$x,$v['ypoint'],$v['xpoint']),2);
				}	
			}
		}else {
			$this->ajaxReturn('0',"网络繁忙，请稍后重试",0);
		}
		if($oid == 1){
			$specialsaleDeal = multi_array_sort($specialsaleDeal,'distance',$sort=SORT_ASC);
			$specialsaleDeal = array_slice($specialsaleDeal,$page*$lnums,$lnums);		
		}
		$this->ajaxReturn($specialsaleDeal,'加载成功',1);
	}

	public function store()
	{
		$keyword = trim($_REQUEST["keyword"]);
		$city_id = session("city_id");
		$keyword = trim($_REQUEST["keyword"]);
		$aid = intval($_GET['aid'])>0?intval($_GET['aid']):0; //区
		$qid = intval($_GET['qid'])>0?intval($_GET['qid']):0; //路
		$oid = intval($_GET['oid'])>0?intval($_GET['oid']):0; //排序
		
		$s_w ="fw_supplier_location.is_effect=1 and fw_supplier_location.city_id=".$city_id;
		if(!empty($keyword)){
			$s_w .= ' and fw_supplier_location.name like "%'.$keyword.'%"';
			$this->assign("keyword",$keyword);
		} 
		//获取查找条件
		$sqlWhere = $this->getSqlWhere('store',$aid,$qid);
		$s_w .=  $sqlWhere['str'];
		//获取排序
		$sqlOrder = $this->getSqlOrder('store',$oid);

		$result_count = M('supplier_location')->where($s_w)->count(0);

		$this->assign("count",$result_count);
		$this->assign("oid",$oid);
		$this->assign("orderby",$sqlOrder['name']);
		$this->assign("area_name",$sqlWhere['area_name']);
		$link = $this->link_url($_REQUEST,1);
		$this->assign("link",$link);
		$this->assign("title",'商家列表');
		$this->display();
	}

	public function  ajaxGetStore()
	{
		$keyword = trim($_REQUEST["keyword"]);
		$city_id = session("city_id");
		$aid = intval($_GET['aid'])>0?intval($_GET['aid']):0; //区
		$qid = intval($_GET['qid'])>0?intval($_GET['qid']):0; //路
		$oid = intval($_GET['oid'])>0?intval($_GET['oid']):0; //排序
		$y = $_GET['lat']; //纬度
		$x = $_GET['lng']; //经度
		$page = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		$time = time();

		//获取查找条件
		$s_w ="fw_supplier_location.is_effect=1 and fw_supplier_location.city_id=".$city_id;
		if(!empty($keyword)){
			$s_w .= ' and fw_supplier_location.name like "%'.$keyword.'%"';
		} 
		$sqlWhere = $this->getSqlWhere('store',$aid,$qid);
		$s_w .=  $sqlWhere['str'];

		$s_f = 'id,name as sname,xpoint,ypoint,address,avg_point,preview';
		//排序
		$sqlOrder = $this->getSqlOrder('store',$oid);
		if ($oid != 1) {
			$s_l = ($page*$lnums).','.$lnums;
		}

		$store = M('supplier_location')->field($s_f)->where($s_w)->order($sqlOrder['str'])->limit($s_l)->select();

		if ($store) {
			$i_f = 'id,name,brief,img,deal_cate_id,is_shop,origin_price,current_price,brand_promote,promote_price,begin_time,end_time,buy_count,transaction_count';
			foreach ($store as $k => $v) {
				if($y && $x){
					$store[$k]['distance'] = round(getDistance($y,$x,$v['ypoint'],$v['xpoint']),2);
				}
				$store[$k]['url'] =U('Store/view',array('id'=>$v['id']));
				$store[$k]['preview'] = getImgUrl($store[$k]['preview'],'thumbnail');
				$condition['location_id']=$v['id'];
				$condition['is_delete']=0;
				$condition['is_effect']=1;
				$condition['erp_project_id']=array('gt',0);//只显示ERP中同步的项目/商品
				$store[$k]['items'] = M('deal')->field($i_f)->where($condition)->order('is_recommend desc,sort desc,create_time desc')->limit(2)->select();
				if ($store[$k]['items']) {
					$store[$k]['items_count'] = M('deal')->where($condition)->count(0);
					foreach ($store[$k]['items']as $i_k => $i_v) {
						if (empty($i_v['img'])) {
							$store[$k]['items'][$i_k]['img'] = M('deal_cate_type')->cache(true,600)->getFieldById($i_v['deal_cate_id'],'img');
						}
						if (empty($i_v['brief'])) {
							$deal_cate_id_detail = M('deal_cate_type')->getFieldById($i_v['deal_cate_id'],'detail');
							$store[$k]['items'][$i_k]['brief'] = empty($deal_cate_id_detail) ? '暂无简介' : msubstr($deal_cate_id_detail,0,80);
						}
						$store[$k]['items'][$i_k]['img'] = getImgUrl($store[$k]['items'][$i_k]['img'],'middle');
						if($i_v['brand_promote'] == 1 && $i_v['end_time'] >= $time && $time > $i_v['begin_time'])
						{
							if($i_v['promote_price']>=0){
								$store[$k]['items'][$i_k]['current_price'] = $i_v['promote_price'];
							}						
						} 
						if ($i_v['is_shop'] == 1) {
							$store[$k]['items'][$i_k]['url'] = U('Goods/view',array('id'=>$i_v['id']));
						}else{
							$store[$k]['items'][$i_k]['url'] = U('Service/view',array('id'=>$i_v['id']));
						}

						//订单数量  
						$store[$k]['items'][$i_k]['order_count'] = $i_v['buy_count'] + $i_v['transaction_count'];
					}
				}
			}
		}else {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
		}
		if($oid == 1){
			$store = multi_array_sort($store,'distance',$sort=SORT_ASC);
			$store = array_slice($store,$page*$lnums,$lnums);
		}
		$this->ajaxReturn($store,'加载成功',1);
	}

	//ajax 商家搜索页面查看更多 服务、商品
	public function ajaxGetDeals()
	{
		$sid     	  =  intval($_POST['id']);      // 商家id
		$page   	  =  intval($_POST['page']);    // 页数（加载次数）
		$allRows  	  =  intval($_POST['arows']);   // 评论总数
		$existRows    =  intval($_POST['erows']);	// 页面初始已经加载的行数
		$loadingRows  =  intval($_POST['lrows']);	// 加载行数
		$time         =  time();

		$rs_f = 'id,name,is_shop,deal_cate_id,current_price,origin_price,promote_price,brand_promote,begin_time,end_time,img,brief,buy_count,transaction_count';
		$rs_w['location_id'] = $sid ;
		$rs_w['is_effect'] = 1 ;
		$rs_w['is_delete'] = 0 ;
		$rs_w['erp_project_id']=array('gt',0);//只显示ERP中同步的项目/商品
		$rs_l = $existRows+($loadingRows*($page-1)).','.$loadingRows;

		if (empty($sid) || empty($page) || empty($allRows)  || empty($existRows) || empty($loadingRows) ||  $sid < 0 || $allRows < 0 || $page < 0 || $existRows < 0 || $loadingRows < 0) {
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
		}

		$deals =  M('deal')->field($rs_f)->where($rs_w)->limit($rs_l)->order('is_recommend desc,sort desc,create_time desc')->select();
		if ($deals) {
			foreach ($deals as $k => $v) {
				if (empty($v['img'])) {
					$deals[$k]['img'] = M('deal_cate_type')->getFieldById($v['deal_cate_id'],'img');
				}
				if (empty($v['brief'])) {
					$deal_cate_id_detail = M('deal_cate_type')->getFieldById($v['deal_cate_id'],'detail');
					$deals[$k]['brief'] = empty($deal_cate_id_detail) ? '暂无简介' : msubstr($deal_cate_id_detail,0,80);
				}
				if($v['brand_promote'] == 1 && $v['begin_time'] < $time && $time < $v['end_time']){
					if($v['promote_price'] >= 0){
						$deals[$k]['current_price'] = $v['promote_price'];
					}
				}
				$deals[$k]['img'] = getImgUrl($deals[$k]['img'],'middle');
				$deals[$k]['url'] = ($v['is_shop'] == 1) ? U('Goods/view',array('id'=>$v['id'])) : U('Service/view',array('id'=>$v['id'])) ;
				$deals[$k]['current_price'] = price($deals[$k]['current_price']);
				$deals[$k]['origin_price']  = price($deals[$k]['origin_price']);
				$deals[$k]['order_count']   = $v['buy_count'] + $v['transaction_count'];
			}
			$allShowRows = $existRows+$loadingRows*$page;
			if ($allShowRows >= $allRows) {
				$this->ajaxReturn($deals,"加载成功",2);
			} else {
				$this->ajaxReturn($deals,"加载成功",1);
			}
		}else{
			$this->ajaxReturn(0,"网络繁忙，请稍后重试",0);
		} 
	}

	public function area()
	{	
		$city_id = session("city_id");
		$link = $this->link_url($_REQUEST,4);
		$aid  = $_REQUEST['aid'];
		$qid  = $_REQUEST['qid'];
		$area = M('area')->cache(true,600)->field('id,name')->where(array('city_id'=>$city_id,'pid'=>0))->order('sort desc,id desc')->select();
		$area[]=array("name"=>'全城',"aid"=>0);
		foreach ($area as $k => $v) {
			if($aid == $v['id']){
				$area[$k]['class'] = 'active';
				$area[$k]['son_class'] = '';
			}else{
				$area[$k]['class'] = 'normal';
				$area[$k]['son_class'] = 'none';
			}
			$area[$k]['son'] =  M('area')->cache(true,600)->field('id,name')->where(array('pid'=>$v['id']))->order('sort desc,id desc')->select();
			$area[$k]['son'][] = array("name"=>'全部',"qid"=>0);
			if ($area[$k]['son']) {
				foreach ($area[$k]['son'] as $s_k => $s_v) {
					if($aid == $v['id'] && $qid == $s_v['id']){
						$area[$k]['son'][$s_k]['style'] = 'style="color:#cd0000;font-weight:bold;"';
					}
					$area[$k]['son'][$s_k]['url']= $link."&aid=".$v['id']."&qid=".$s_v['id'];
				}
			}
			krsort($area[$k]['son']);
		}
		krsort($area);
		$this->assign("mytab","myTab0");
		$this->assign("resultlist",$area);
		$this->display('tabbox');
	}

	public function service_cate()
	{
		$link = $this->link_url($_REQUEST,3);
		$cid  = $_REQUEST['cid'];
		$tid  = $_REQUEST['tid'];

		$service_cate = M('deal_cate')->cache(true,600)->field('id,name')->where(array('is_effect'=>1,'is_delete'=>0,'pid'=>0))->order('sort asc,id asc')->select();
		$service_cate[]=array("name"=>'全部',"cid"=>0);
		foreach ($service_cate as $k => $v) {
			if($cid == $v['id']){
				$service_cate[$k]['class'] = 'active';
				$service_cate[$k]['son_class'] = '';
			}else{
				$service_cate[$k]['class'] = 'normal';
				$service_cate[$k]['son_class'] = 'none';
			}
			$service_cate[$k]['son'] =  M('deal_cate_type')->cache(true,600)->join('fw_deal_cate_type_link as ctl on ctl.deal_cate_type_id=fw_deal_cate_type.id')->field('fw_deal_cate_type.id,fw_deal_cate_type.name')->where(array('cate_id'=>$v['id']))->order('sort desc')->select();
			$service_cate[$k]['son'][] = array("name"=>'全部',"tid"=>0);
			if ($service_cate[$k]['son']) {
				foreach ($service_cate[$k]['son'] as $s_k => $s_v) {
					if($cid == $v['id'] && $tid == $s_v['id']){
						$service_cate[$k]['son'][$s_k]['style']='style="color:#cd0000;font-weight:bold;"';
					}
					$service_cate[$k]['son'][$s_k]['url']= $link."&cid=".$v['id']."&tid=".$s_v['id'];
				}
			}
			krsort($service_cate[$k]['son']);
		}
		krsort($service_cate);
		$this->assign("mytab","myTab1");
		$this->assign("resultlist",$service_cate);
		$this->display('tabbox');
	}

	public function goods_cate()
	{
		$link = $this->link_url($_REQUEST,5);
		$gcid  = $_REQUEST['gcid'];
		$gtid  = $_REQUEST['gtid'];

		$goods_cate = M('shop_cate')->cache(true,600)->field('id,name')->where(array('is_effect'=>1,'is_delete'=>0,'pid'=>0))->order('sort desc,id asc')->select();
		$goods_cate[]=array("name"=>'全部',"gcid"=>0);
		foreach ($goods_cate as $k => $v) {
			if($gcid == $v['id']){
				$goods_cate[$k]['class'] = 'active';
				$goods_cate[$k]['son_class'] = '';
			}else{
				$goods_cate[$k]['class'] = 'normal';
				$goods_cate[$k]['son_class'] = 'none';
			}
			$goods_cate[$k]['son'] =  M('shop_cate')->cache(true,600)->field('id,name')->where(array('is_effect'=>1,'is_delete'=>0,'pid'=>$v['id']))->order('sort desc,id asc')->select();
			$goods_cate[$k]['son'][] = array("name"=>'全部',"gtid"=>0);
			if ($goods_cate[$k]['son']) {
				foreach ($goods_cate[$k]['son'] as $s_k => $s_v) {
					if($gcid == $v['id'] && $gtid == $s_v['id']){
						$goods_cate[$k]['son'][$s_k]['style']='style="color:#cd0000;font-weight:bold;"';
					}
					$goods_cate[$k]['son'][$s_k]['url']= $link."&gcid=".$v['id']."&gtid=".$s_v['id'];
				}
			}
			krsort($goods_cate[$k]['son']);
		}
		krsort($goods_cate);
		$this->assign("mytab","myTab2");
		$this->assign("resultlist",$goods_cate);
		$this->display('tabbox');
	}

	public function order_by()
	{
		$link = $this->link_url($_REQUEST,2);
		$oid  = $_REQUEST['oid'];

		$order_arr[0] = array(id=>0,name=>'默认排序');
		$order_arr[1] = array(id=>1,name=>'离我最近');
		$order_arr[2] = array(id=>2,name=>'评价最高');

		if (empty($_REQUEST['ot'])) { //$_REQUEST['ot'] != 1; 
			$order_arr[3] = array(id=>3,name=>'最新发布');
			$order_arr[4] = array(id=>4,name=>'人气最高');
			$order_arr[5] = array(id=>5,name=>'价格最低');
			$order_arr[6] = array(id=>6,name=>'价格最高');
		}

		$order_by = array(array(id=>0,name=>'排序','class'=>'active','son_class'=>'','url'=>$link."&oid=".$v['id']));
		$order_by[0]['son'] = $order_arr;

		foreach ($order_by[0]['son'] as $s_k => $s_v) {
			if($oid == $s_v['id']){
				$order_by[0]['son'][$s_k]['style']='style="color:#cd0000;font-weight:bold;"';
			}
			$order_by[0]['son'][$s_k]['url']= $link."&oid=".$s_v['id'];
		}
		$this->assign("mytab","myTab3");
		$this->assign("resultlist",$order_by);
		$this->display('tabbox');
	}
		
	public function link_url($arr,$a)
	{
		$link = '?search=ok';

		if($arr['aid'] && $a!=4){ //大区
			$link.="&aid=".$arr['aid'];
		}
		if($arr['qid'] && $a!=4){ //小区
			$link.="&qid=".$arr['qid'];
		}
		if($arr['oid'] && $a!=2){ //排序
			$link.="&oid=".$arr['oid'];
		}
		if($arr['cid'] && $a!=3){ //服务小分类
			$link.="&cid=".$arr['cid'];
		}
		if($arr['tid'] && $a!=3){ //服务小分类
			$link.="&tid=".$arr['tid'];
		}
		if($arr['gcid'] && $a!=5){ //商品大分类
			$link.="&gcid=".$arr['gcid'];
		}
		if($arr['gtid'] && $a!=5){ //商品小分类
			$link.="&gtid=".$arr['gtid'];
		}
		if($arr['keyword']){ //关键词
			$link .= "&keyword=".urlencode($arr['keyword']);
		}
		if ($arr['type']) { //类型：服务、商品
			$link .= "&type=".$arr['type'];
		}
		if ($arr['ot']) { //排序
			$link .= "&ot=".$arr['ot'];
		}
		return $link;
	}

	public function getSqlWhere($type,$aid=0,$qid=0,$cid=0,$tid=0,$need_name = true)//store service goods
	{	
		$where = '';
		if($aid>0)
		{
			if($qid>0)
				{	
					$area_name = M("area")->cache(true,600)->getFieldById($qid,"name");
					$kw_unicode = strToUnicodeString($area_name);
					//有筛选
					$where .=" and (match(fw_supplier_location.locate_match) against('".$kw_unicode."' IN BOOLEAN MODE))";
				}
				else
				{	
					$area_name =M("area")->cache(true,600)->getFieldById($aid,"name");
					$quan_list =M("area")->cache(true,600)->where(array('pid'=>$aid))->Field("id,name")->select();
					$unicode_quans = array();
					foreach($quan_list as $k=>$v){
						$unicode_quans[] = strToUnicodeString($v['name']);
					}
					$kw_unicode = implode(" ", $unicode_quans);
					$where.= " and (match(fw_supplier_location.locate_match) against('".$kw_unicode."' IN BOOLEAN MODE))";
				}
		}else{
			$area_name ="全城";
		}
		if ($type == 'store') {
			$result['str'] = $where;
			$result['area_name'] = $area_name;
			return $result;
		}

		if ($type == 'n_service' || $type == 's_service') {
			if ($type == 'n_service') {
				$where .= ' and fw_deal.is_shop in (0,2)';
			}else{
				$where .= ' and fw_deal.is_shop = 0';
			}
			if($tid > 0){
				if ($need_name){
					$cate_name = M("deal_cate_type")->cache(true,600)->getFieldById($tid,"name");
				}
				$where.=" and fw_deal.deal_cate_id=".$tid;
			}else if ($cid > 0) {
				if ($need_name){
					$cate_name = M("deal_cate")->cache(true,600)->getFieldById($cid,"name");
				}
				$where.=" and fw_deal.cate_id=".$cid;
			}else {
				$cate_name = '服务分类';
			}

		}elseif($type == 'goods') {
			$where .= ' and fw_deal.is_shop = 1';
			if ($cid > 0) {
				if($tid > 0){
					if ($need_name){
						$cate_name = M("shop_cate")->cache(true,600)->getFieldById($tid,"name");
					}	
					$where.=" and fw_deal.shop_cate_id=".$tid;
				}else {
					if ($need_name){
						$cate_name = M("shop_cate")->cache(true,600)->getFieldById($cid,"name");
					}
					$goods_cate_list = M("shop_cate")->cache(true,600)->where(array('pid'=>$cid))->Field("id,name")->select();
					$unicode_goods_cate = array();
					foreach($goods_cate_list as $k=>$v){
						$unicode_goods_cate[] = strToUnicodeString($v['name']);
					}
					$goods_cate_unicode = implode(" ", $unicode_goods_cate);
					$where .= " and (match(fw_deal.shop_cate_match) against('".$goods_cate_unicode."' IN BOOLEAN MODE))";
				}
			}else {
				$cate_name = '商品分类';
			}
		}else {
			$this->error('非法操作');
		}

		$result['str'] = $where;
		$result['area_name'] = $area_name;
		$result['cate_name'] = $cate_name;
		return $result;
	}

	//获取sql排序
	public function getSqlOrder($type,$oid)
	{
		if (empty($type)) {
			return '';
		}
		$oid  = intval($oid);
		if ($type == 'store') {
			switch ($oid) {
				case 0:
					$str = "is_recommend desc,avg_point desc";
					$name = '默认排序';
					break;
				case 1:
					$str = '';
					$name = '离我最近';
					break;
				case 2:
					$str = "avg_point desc";
					$name = '评价最高';
					break;
				default:
					$str = "is_recommend desc,avg_point desc";
					$name = '默认排序';
					break;
			}
		}elseif ($type == 'n_deal' || $type == 's_deal') { //n_deal普通服务 s_deal特卖服务
			switch ($oid) {
				case 0:
					$str = "fw_deal.is_recommend desc,fw_deal.sort desc,fw_deal.buy_count desc";
					$name = '默认排序';
					break;
				case 1:
					$str = '';
					$name = '离我最近';
					break;
				case 2:
					$str = "fw_deal.total_point desc";
					$name = '评价最高';
					break;
				case 3:
					$str = "fw_deal.create_time desc";
					$name = '最新发布';
					break;
				case 4:
					$str = "fw_deal.click_count desc";
					$name = '人气最高';
					break;
				case 5:
					$str = ($type == 'n_deal') ? "fw_deal.current_price asc" : "fw_deal.promote_price asc" ;
					$name = '价格最低';
					break;
				case 6:
					$str = ($type == 'n_deal') ? "fw_deal.current_price desc" : "fw_deal.promote_price desc" ;
					$name = '价格最高';
					break;
				default:
					$str = "fw_deal.is_recommend desc,fw_deal.sort desc,fw_deal.buy_count desc";
					$name = '默认排序';
					break;
			}
		}
		return array('str'=>$str,'name'=>$name);
	}
}
?>