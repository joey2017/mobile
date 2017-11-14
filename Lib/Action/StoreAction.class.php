<?php
//import('ORG.Util.Page');
class StoreAction extends BaseAction {

	public function view()
	{
		require_once "Jssdk.php";
        $jssdk = new JSSDK("wxbd68bd4fe539eba2", "f2c29cdcbf2543e7531aef5e7651585c");
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
		$sid = intval($_GET["id"]);
        $this->assign('sid',$sid);

		$time = time();
		$Model = new Model(); // 实例化一个model对象 没有对应任何数据表

		if (empty($sid) || $sid < 0) {
			$this->error('该商家不存在');
		}

		$sup_f = 'id,name,tel,mobile,is_microshop,address,preview,business_scope,brief,supplier_id,index_img';
		$sup_w['id'] = $sid;
		// $sup_w['is_effect'] = 1;

		$supplier = M('supplier_location')->field($sup_f)->where($sup_w)->find();
		if (empty($supplier)) {
			$this->error('该商家不存在或者已经下架');
		}


        if($supplier['is_microshop']!=1){
	        $this->error('您还没开通微商城，请联系客服！联系电话：0771-5329781');
        }

		//商家电话
		$supplier['tel'] = empty($supplier['tel']) ? $supplier['mobile'] : $supplier['tel'] ;
	
		//商家图集
		$a_f = 'image,brief';
		$a_w['supplier_location_id'] = $sid;
		$a_w['status'] = 1;
		$album =  M('supplier_location_images')->field($a_f)->where($a_w)->order('sort desc,create_time desc')->limit(4)->select();
		//var_dump($album);
		//商家经营范围
		if (!empty($supplier['business_scope'])) {
			$business_scope_list=explode(',',$supplier['business_scope']);
			$business_scope_arr=array(array('id' =>1,'name'=>'美容'),array('id' =>2,'name'=>'保养'),array('id' =>3,'name'=>'维修'),array('id' =>4,'name'=>'用品装饰'),array('id' =>5,'name'=>'电子影音'),array('id' =>6,'name'=>'改装'),array('id' =>7,'name'=>'轮胎轮毂'),array('id' =>8,'name'=>'钣喷'),array('id' =>9,'name'=>'救援'),array('id' =>10,'name'=>'保险'));
			$business_scope='';
			foreach ($business_scope_list as $v_l) {
				foreach ($business_scope_arr as  $v_a) {
					if($v_l == $v_a['id']){
						$business_scope.= $v_a['name'].' ';
					}
				}
			}
			$supplier['business_scope'] = trim($business_scope);
		}
		$preview=M('supplier')->where('id='.$supplier['supplier_id'])->getField('preview');
		//商家E卡
		/*$model=new Model();
		$card=$model->query('SELECT distinct sc.id,sc.name,sc.price,sc.brief,sc.promotion_time_start,sc.promotion_time_end,sc.promotion_price,sc.view_count,sc.buy_count,sc.location_count,sc.service_count,sc.type FROM fw_shop_card as sc left join fw_shop_card_cate_link as sccl on sccl.card_id=sc.id left join fw_shop_card_cate_deal_link  as sccdl on sccdl.link_id=sccl.id where sccdl.location_id='.$sid.' order by buy_count desc limit 4 ');*/
		$card=M('shop_card')->where('location_id='.$sid." and is_effect=1")->order('id desc')->limit(5)->select();
		foreach ($card as $k => $v) {			
			if($v['promotion_time_start']<=time()&&$v['promotion_time_end']>=time()){
				$card[$k]['is_promotion']=1;
			}
		}
		$this->assign('card',$card);

		//商家订单总数
		$count_order = $Model->query("select count(0) from fw_deal_order_item as fdoi left join fw_deal_order as fdo on fdoi.order_id=fdo.id left join fw_user as fu on fu.id=fdo.user_id left join fw_deal as fd on fd.id=fdoi.deal_id  where fdo.is_delete=0 and fd.location_id=".$sid);
		$supplier['count_order'] = $count_order[0]['count(0)'];

		//商家相册
		// $supplier['album_img'] = M('supplier_location_images')->where(array('supplier_location_id'=>$sid,'status'=>1))->order('sort desc,create_time desc')->getField('image');
		 $supplier['album_count'] = M('supplier_location_images')->where(array('supplier_location_id'=>$sid,'status'=>1))->count(0);
		
		//显示服务、商品项目 3个 
		$rs_f = 'id,name,is_shop,deal_cate_id,current_price,origin_price,promote_price,brand_promote,begin_time,end_time,img,brief';
		$rs_w['location_id'] = $sid ;
		$rs_w['is_effect'] = 1 ;
		$rs_w['is_delete'] = 0 ;
		$rs_w['erp_project_id']=array('gt',0);//只显示ERP中同步的项目/商品

		$deals =  M('deal')->field($rs_f)->where($rs_w)->limit(3)->order('is_recommend desc,sort desc,create_time desc')->select();
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
				//正规订单数量  
				$dor_w = "fw_deal_order_item.deal_id=".$v['id']." AND (!(fdo.type=0 AND fdo.means_of_payment='0')) and fdo.create_time<".$time;
	 			$done_order_recode = M('deal_order_item')->join('fw_deal_order as fdo ON fdo.id = fw_deal_order_item.order_id')->where($dor_w)->count('number');
				//快速预定数量
				$done_fast_recode = M('msg')->where(array('did'=>$v['id']))->count(0);
				$deals[$k]['order_count'] = $done_order_recode + $done_fast_recode;
			}
			//商家服务、商品项目总数
			$deal_count_nums =  M('deal')->where($rs_w)->count(0);
			$this->assign('deals',$deals);
			$this->assign('deal_count_nums',$deal_count_nums);
		}

		//评价 
		$r_f = 'u.user_name,u.true_name,fw_supplier_location_dp.title,fw_supplier_location_dp.rel_param,fw_supplier_location_dp.point,fw_supplier_location_dp.create_time,fw_supplier_location_dp.content,fw_supplier_location_dp.rel_route,fw_supplier_location_dp.id';
		$r_w['fw_supplier_location_dp.supplier_location_id']  = $sid;
		$r_w['fw_supplier_location_dp.content'] 	 = array(array('neq','用户超期未评价，系统自动给出好评。'),array('neq',''));
		$r_w['fw_supplier_location_dp.create_time']  = array('lt',time());

		$reviews = M('supplier_location_dp')->join('fw_user as u ON u.id = fw_supplier_location_dp.user_id')->field($r_f)->where($r_w)->limit(3)->order('create_time desc')->select();
		//var_dump($reviews);
		
	
		if ($reviews){

			foreach ($reviews as $k => $v) {
				$reviews[$k]['content'] = msubstr(strip_tags($v['content']),0,50);
			 	$reviews[$k]['user_name'] = getUserName(array($v['user_name'],$v['true_name']));
			 	$reviews[$k]['deal_url'] = ($v['rel_route'] == 'ydetail') ? U('Service/view',array('id'=>intval(substr($v['rel_param'],3)))) : U('Goods/view',array('id'=>intval(substr($v['rel_param'],3)))) ;
			 	$reviews[$k]['dp_point_group']=M('supplier_location_dp_point_result')->field('group_id,point')->where('group_id in(1,2) and dp_id='.$v['id'])->select();
			}
			$reviews_count_nums = M('supplier_location_dp')->where($r_w)->count(0);
			$this->assign('reviews',$reviews);
			$this->assign('reviews_count_nums',$reviews_count_nums);
		}

		$title = $supplier['name']; 
		$desc = '诚车堂-全心全意为车主服务'; 

		$this->assign("album",$album);
		$this->assign("preview",$preview);
		$this->assign("supplier",$supplier);
		$this->assign("title",$title);
		$this->assign("desc",$desc);
		$this->display();
	}

	//门店介绍
	public function info(){
		$id=intval($_REQUEST['id']);
		$store_info=M('supplier_location')->where('id='.$id)->getField('brief');
		$this->assign('store_info',$store_info);
		$this->assign('id',$id);
		$this->assign("title",'门店介绍');
		$this->display();
	}

	//项目分类
	public function goods()
	{
		$id=intval($_REQUEST['id']);
		$keyword=trim($_REQUEST['keyword']);
		if($keyword){
			$w=" and d.name like '%".$keyword."%'";
		}
		$goods=M('deal as d')->field('d.id,d.name,d.img,d.origin_price,d.current_price,d.cate_id,dc.name as cate_name')->join('fw_deal_cate as dc on dc.id=d.cate_id')->where('d.location_id='.$id.' and d.is_delete=0 and d.is_effect=1 and d.erp_project_id!=0 and cate_id!=0'.$w)->select();
		
		if($goods){

			$cate_list = M('deal_cate')->where('is_show=1')->select();

			foreach ($cate_list as $k => $v) {
				$list[$v['name']] = array();
			}

			foreach ($goods as $k => $v) {
				$list[$v['cate_name']]['item'][]=$v;
			}

			$this->assign('list',$list);
		}
		// else{
		// 	$this->error('抱歉，该门店还没有任何服务项目');
		// }

		$this->assign('id',$id);
		$this->assign('keyword',$keyword);
		//var_dump($list);
		$this->display();
	}

	//资讯列表
	public function news(){
		$id=intval($_REQUEST['id']);
		$this->assign('id',$id);	
		$this->display();
	}

	//ajax请求资讯列表
	public function ajax_get_news(){
		$id=intval($_REQUEST['id']);
		$p=intval($_REQUEST['p']);
		$limit=($p*8).',8';
		$news=M('supplier_article')->where('location_id='.$id.' and type=1')->order('id desc')->limit($limit)->select();
		foreach ($news as $k => $v) {
			if(substr($v['thumb'],0,2)=='/u'){
				$news[$k]['thumb']="http://www.17cct.com/".$v['thumb'];
			}
		}
		$this->assign('news',$news);
		echo $html=$this->fetch();
	}

	//资讯详情
	public function news_detail(){
		$id=intval($_REQUEST['id']);
		$info=M('supplier_article as sa')->field('sa.*,sl.name as sname,sl.id as sid')->join('fw_supplier_location as sl on sl.id=sa.location_id')->where('sa.id='.$id)->find();
		M('supplier_article')->where('id='.$id)->setInc('view');
		$info['content']=str_replace('src="/ueditor/','src="http://www.17cct.com/ueditor/',$info['content']);
		$this->assign('info',$info);
		$this->assign('title',$info['title']);
		$this->display();
	}

	//案例列表
	public function project(){
		$id=intval($_REQUEST['id']);
		$cid=intval($_REQUEST['cid']);
		if($cid){
			$w=" and cate_id=".$cid;
		}
		$list=M('shaidan')->where('cate_id!=0 and is_show=1 and supid='.$id.$w)->order('sid desc')->select();
		// dump($list);
		$cate_list=M('deal_cate')->field('id,name')->where('is_delete=0 and is_effect=1')->select();
		// dump($cate_list);
		$this->assign('cate_list',$cate_list);
		$this->assign('list',$list);
		$this->assign('cid',$cid);
		$this->assign('id',$id);
		$this->display();
	}

	//案例详情
	public function project_detail(){
		$id=intval($_REQUEST['id']);
		$info=M('shaidan as sd')->field('sd.*,sl.name as sname,sl.id')->join('fw_supplier_location as sl on sl.id=sd.supid')->where('sd.sid='.$id)->find();

		M('shaidan')->where('sid='.$id)->setInc('viewcount');
		$this->assign('info',$info);
		$this->assign('title',$info['title']);
		$this->display();
	}

	//风采列表
	public function staff_style(){

		$id=intval($_REQUEST['id']);
		$this->assign('id',$id);	
		$this->display();
	}

	//ajax请求风采列表
	public function ajax_get_style(){
		$id=intval($_REQUEST['id']);
		$p=intval($_REQUEST['p']);
		$limit=($p*8).',8';
		$news=M('supplier_article')->where('location_id='.$id.' and type=2')->limit($limit)->select();
		foreach ($news as $k => $value) {
			if(substr($v['thumb'],0,2)=='/u'){
				$news[$k]['thumb']="http://www.17cct.com/".$v['thumb'];
			}			
		}
		$this->assign('news',$news);
		echo $html=$this->fetch();
	}

	//风采详情
	public function style_detail(){
		$id=intval($_REQUEST['id']);
		$info=M('supplier_article as sa')->field('sa.*,sl.name as sname,sl.id as sid')->join('fw_supplier_location as sl on sl.id=sa.location_id')->where('sa.id='.$id)->find();
		M('supplier_article')->where('id='.$id)->setInc('view');
		
		$info['content']=str_replace('src="/ueditor/','src="http://www.17cct.com/ueditor/',$info['content']);
		$this->assign('title',$info['title']);
		$this->assign('info',$info);
		$this->display();
	}
	// ajax  加载商家服务、商品
	public function ajaxGetDeals()
	{
		$sid     	  =  intval($_POST['id']);      // 服务id
		$page   	  =  intval($_POST['page']);    // 页数（加载次数）
		$allRows  	  =  intval($_POST['arows']);   // 评论总数
		$existRows    =  intval($_POST['erows']);	// 页面初始已经加载的行数
		$loadingRows  =  intval($_POST['lrows']);	// 加载行数
		$time         =  time();

		$rs_f = 'id,name,is_shop,deal_cate_id,current_price,origin_price,promote_price,brand_promote,begin_time,end_time,img,brief';
		$rs_w['location_id'] = $sid ;
		//$rs_w['is_shop'] = array(array('eq',0),array('eq',2), 'or');
		$rs_w['is_effect'] = 1 ;
		$rs_w['is_delete'] = 0 ;
		$rs_w['erp_project_id']=array('gt',0);//只显示ERP中同步的项目/商品
		$rs_l = $existRows+($loadingRows*($page-1)).','.$loadingRows;

		if (empty($sid) || empty($page) || empty($allRows)  || empty($existRows) || empty($loadingRows) ||  $sid < 0 || $allRows < 0 || $page < 0 || $existRows < 0 || $loadingRows < 0) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
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
				//正规订单数量  
				$dor_w = "fw_deal_order_item.deal_id=".$v['id']." AND (!(fdo.type=0 AND fdo.means_of_payment='0')) and fdo.create_time<".$time;
	 			$done_order_recode = M('deal_order_item')->join('fw_deal_order as fdo ON fdo.id = fw_deal_order_item.order_id')->where($dor_w)->count('number');
				//快速预定数量
				$done_fast_recode = M('msg')->where(array('did'=>$v['id']))->count(0);
				$deals[$k]['order_count'] = $done_order_recode + $done_fast_recode;
				$deals[$k]['url'] = ($v['is_shop'] == 1) ? U('Goods/view',array('id'=>$v['id'])) : U('Service/view',array('id'=>$v['id'])) ;
				$deals[$k]['current_price'] = price($deals[$k]['current_price']);
				$deals[$k]['origin_price']  = price($deals[$k]['origin_price']);
			}


			$allShowRows = $existRows+$loadingRows*$page;
			if ($allShowRows >= $allRows) {
				$this->ajaxReturn($deals,"加载成功",2);
			} else {
				$this->ajaxReturn($deals,"加载成功",1);
			}
		}else{
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		} 
	}


	// ajax  加载评论
	public function ajaxGetReviews()
	{
		$sid     	  =  intval($_POST['id']);      // 服务id
		$page   	  =  intval($_POST['page']);    // 页数（加载次数）
		$allRows  	  =  intval($_POST['arows']);   // 评论总数
		$existRows    =  intval($_POST['erows']);	// 页面初始已经加载的行数
		$loadingRows  =  intval($_POST['lrows']);	// 加载行数

		if (empty($sid) || empty($page) || empty($allRows)  || empty($existRows) || empty($loadingRows) ||  $sid < 0 || $allRows < 0 || $page < 0 || $existRows < 0 || $loadingRows < 0) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}

		$r_f = 'u.user_name,u.true_name,fw_supplier_location_dp.title,fw_supplier_location_dp.rel_param,fw_supplier_location_dp.point,fw_supplier_location_dp.create_time,fw_supplier_location_dp.content,fw_supplier_location_dp.id';
		$r_w['fw_supplier_location_dp.supplier_location_id'] = $sid;
		$r_w['fw_supplier_location_dp.content'] = array(array('neq','用户超期未评价，系统自动给出好评。'),array('neq',''));
		$r_w['fw_supplier_location_dp.create_time'] = array('lt',time());
		$r_l = $existRows+($loadingRows*($page-1)).','.$loadingRows;

		$reviews_count = M('supplier_location_dp')->join('fw_user as u ON u.id = fw_supplier_location_dp.user_id')->where($r_w)->count(0);
		$reviews = M('supplier_location_dp')->join('fw_user as u ON u.id = fw_supplier_location_dp.user_id')->field($r_f)->where($r_w)->limit($r_l)->order('create_time desc')->select();
		if ($reviews){
			foreach ($reviews as $k => $v) {
				$reviews[$k]['create_time'] = date('Y-m-d',$v['create_time']);
				$reviews[$k]['content'] = msubstr(strip_tags($v['content']),0,50);
			 	$reviews[$k]['user_name'] = getUserName(array($v['user_name'],$v['true_name']));
			 	$reviews[$k]['dp_point_group']=M('supplier_location_dp_point_result')->field('group_id,point')->where('group_id in(1,2) and dp_id='.$v['id'])->select();
			 	$reviews[$k]['deal_url'] = ($v['rel_route'] == 'ydetail') ? U('Service/view',array('id'=>intval(substr($v['rel_param'],3)))) : U('Goods/view',array('id'=>intval(substr($v['rel_param'],3)))) ;
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

	public function album()
	{
		$sid = intval($_GET["id"]);
		if (empty($sid) || $sid < 0) {
			$this->error('该商家不存在');
		}

		$sup_w['id'] = $sid;
		$sup_w['is_effect'] = 1;
		$supplierName = M('supplier_location')->where($sup_w)->getField('name');
		if (empty($supplierName)) {
			$this->error('该商家不存在或者已经下架');
		}
		$a_f = 'image,brief';
		$a_w['supplier_location_id'] = $sid;
		$a_w['status'] = 1;
		$album =  M('supplier_location_images')->field($a_f)->where($a_w)->order('sort desc,create_time desc')->select();
		if ($album) {
			$album_count =  M('supplier_location_images')->field($a_f)->where($a_w)->count(0);
		}

		$this->assign('album',$album);
		$this->assign('album_count',$album_count);
		$this->assign("title",$supplierName);	
		$this->assign("top_title",'商家相册');
		$this->display();
	}

	//商家地图 (百度地图)
	public function map()
	{
		$sid = intval($_GET["id"]);

		if (empty($sid) || $sid < 0) {
			$this->error('该商家不存在');
		}

		$sup_f = 'name,address,mobile,tel,xpoint,ypoint';
		$sup_w['id'] = $sid;
		$sup_w['is_effect'] = 1;

		$supplier = M('supplier_location')->field($sup_f)->where($sup_w)->find();
		if (empty($supplier)) {
			$this->error('该商家不存在或者已经下架');
		}else if (empty($supplier['xpoint']) && empty($supplier['ypoint'])) {
			$this->error('该商家还没标注位置');

		}
		//商家电话
		$supplier['tel'] = empty($supplier['tel']) ? $supplier['mobile'] : $supplier['tel'] ;
		
		$this->assign('supplier',$supplier);
		$this->assign("title",$supplier['name']);	
		$this->display();
	}

	public function new_add(){
		
		$this->display();
	}

	public function ajax_get_store()
	{
			$page=intval($_GET['p']);
			
		
			$result=M('supplier_location')->field('id,name,preview')->limit(($page*10).',10')->where(" is_effect=1 and city_id=15 ")->select();
		
			$this->assign('list',$result);
    		echo $html=$this->fetch();

	}
}
?>