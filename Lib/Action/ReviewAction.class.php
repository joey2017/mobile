<?php
// 本类由系统自动生成，仅供测试用途
class ReviewAction extends BaseAction {

	//每次服务对服务或者商品评论
	public function review_deal()
	{	
		$cpid = intval($_GET['id']);
		if (empty($cpid) || $cpid < 0) {
			$this->error('请消费后，再评价');
		}
		isLogin(U('Review/review_deal',array('id'=>$cpid)));
		$uid  = intval(session('uid'));

		$dc_f = 'fw_deal_coupon.id,fw_deal_coupon.confirm_time,fw_deal_coupon.confirm_account,fw_deal_coupon.message_id,fw_deal_coupon.deal_id';
		$dc_w = array('fw_deal_coupon.id'=>$cpid,'fw_deal_coupon.user_id'=>$uid,'do.pay_status'=>2);
		$ckCoupon = M('deal_coupon')->join('fw_deal_order as do ON do.id=fw_deal_coupon.order_id')->field($dc_f)->where($dc_w)->find();

		if (empty($ckCoupon) || empty($ckCoupon['confirm_time']) || empty($ckCoupon['confirm_account'])) {
			$this->error('请消费后，再评价');
		}
		if (!empty($ckCoupon['message_id'])) {
			$this->error('您已评价过此次服务或商品');
		}

		//评价的服务或者商品
		$d_f = 'fw_deal.id,fw_deal.name,fw_deal.deal_cate_id,fw_deal.brief,fw_deal.img';
		$d_w['fw_deal.id'] = $ckCoupon['deal_id'] ;
		$d_w['fw_deal.is_effect'] = 1 ;
		$d_w['fw_deal.is_delete'] = 0 ; 
		$d_w['fsl.is_effect'] = 1;

		$deal =  M('deal')->join('fw_supplier_location as fsl ON fsl.id = fw_deal.location_id')->field($d_f)->where($d_w)->find();
		// if (empty($deal)) {
		// 	$this->error('服务或商品，不存在或者已经下架');
		// }
		//图片
		$deal['img'] = empty($deal['img']) ? M('deal_cate_type')->getFieldById($deal['deal_cate_id'],'img') : $deal['img'] ;
		if (empty($deal['brief'])) {
			$deal_cate_id_detail = M('deal_cate_type')->getFieldById($deal['deal_cate_id'],'detail');
			$deal['brief'] = empty($deal_cate_id_detail) ? '暂无简介' : $deal_cate_id_detail;
		}

		$this->assign('deal',$deal);
		$this->assign('cpid',$cpid);
		$this->assign('title','发表评价');
		$this->display();
	}

	//ajax 提交评价
	public function ajaxReviewSubmit()
	{
		if (!isLogin(U('Index/index'),true)) {
			$this->ajaxReturn(0,"请先登录",0);
		}

		$cpid     = intval($_POST['id']);
		$point 	  = intval($_POST['point']);
		$point_g1 = intval($_POST['point_g1']);
		$point_g2 = intval($_POST['point_g2']);
		$point_g3 = intval($_POST['point_g3']);
		$content  = htmlspecialchars(stripslashes(trim($_POST['content'])));
		$imgs 	  = $_POST['imgs'];

		if ($point <= 0 || $point > 5) {
			$this->ajaxReturn(0,'请选择总体评价',0);
		}
		if ($point_g1 <= 0 || $point_g1 > 5) {
			$this->ajaxReturn(0,'请选择服务态度',0);
		}
		if ($point_g2 <= 0  || $point_g2 > 5) {
			$this->ajaxReturn(0,'请选择施工质量',0);
		}
		if ($point_g3 <= 0  || $point_g3 > 5) {
			$this->ajaxReturn(0,'请选择性价比',0);
		}
		if (empty($content)) {
			$this->ajaxReturn(0,'评价不能为空',0);
		}
		if ($point_g3 <= 0  || $point_g3 > 5) {
			$this->ajaxReturn(0,'请选择性价比',0);
		}
		if ($cpid <= 0 ) {
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
		if ($imgs != '0,0,0') {
			$img_arr = explode(',', $imgs);
			if (!empty($img_arr)) {
				foreach ($img_arr as $k => $v) {
					if (empty($v)) {
						unset($img_arr[$k]);
					}
				}
				$imgs = implode(',',$img_arr);
			}else{
				$imgs = '';
			}
		}else{
			$imgs = '';
		}

		$uid = intval(session('uid'));

		$dc_f = 'fw_deal_coupon.id,fw_deal_coupon.confirm_time,fw_deal_coupon.confirm_account,fw_deal_coupon.message_id,fw_deal_coupon.deal_id';
		$dc_w = array('fw_deal_coupon.id'=>$cpid,'fw_deal_coupon.user_id'=>$uid,'do.pay_status'=>2);
		$ckCoupon = M('deal_coupon')->join('fw_deal_order as do ON do.id=fw_deal_coupon.order_id')->field($dc_f)->where($dc_w)->find();

		if (empty($ckCoupon) || empty($ckCoupon['confirm_time']) || empty($ckCoupon['confirm_account'])) {
			$this->ajaxReturn(0,'请消费后，再评价',0);
		}
		if (!empty($ckCoupon['message_id'])) {
			$this->ajaxReturn(0,'您已评价过此次服务或商品',0);
		}

		$time = time();

		$deal = M('deal')->field('id,is_shop,name,sub_name,location_id,city_id')->where(array('id'=>$ckCoupon['deal_id']))->find();
		$message['title'] 		= $content;
		$message['content'] 	= $content;
		$message['create_time'] = $time;
		$message['rel_table'] 	= 'deal';
		$message['rel_id'] 		= $ckCoupon['deal_id'];
		$message['user_id'] 	= $uid;
		$message['is_effect'] 	= 1;
		$message['is_buy'] 		= 1;
		$message['point'] 		= $point ;
		$message['city_id']		= $deal['city_id'];
		$r_m = M('message')->add($message);
		if ($r_m) {
			$message['id'] 	   = $r_m;
			$message['imgs']   = $imgs ;
			$dp_point_group[1] = $point_g1;
			$dp_point_group[2] = $point_g2;
			$dp_point_group[3] = $point_g3;
			$r_dp = $this->doReview($deal,$message,$dp_point_group);
			if ($r_dp) {
				M('user')->where(array('id'=>$uid))->setInc('dp_count');
				M('deal_coupon')->where(array('id'=>$cpid))->setField('message_id',$r_m);
				$this->ajaxReturn(U('User/index'),'评论成功',1);
			}else {
				M('message')->where(array('id'=>$r_m))->delete();
				$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
			}
		}else {
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
	}

	public function doReview($deal = array(),$message = array() ,$dp_point_group = array())
	{
		if($deal['is_shop']==2)
		{
			$url_route = array(
				'rel_app_index'	=>	'youhui',
				'rel_route'	=>	'ydetail',
				'rel_param' => 'id='.$deal['id']
			);
			$from_info= "daijin";
		}elseif($deal['is_shop']==0)
		{
			$url_route = array(
				'rel_app_index'	=>	'tuan',
				'rel_route'	=>	'deal',
				'rel_param' => 'id='.$deal['id']
			);
			$from_info= "tuan";
		}elseif($deal['is_shop']==1)
		{
			$url_route = array(
				'rel_app_index'	=>	'shop',
				'rel_route'	=>	'goods',
				'rel_param' => 'id='.$deal['id']
			);
			$from_info= "daijin";
		}

		$dp_title = "对".$deal['sub_name']."的消费点评";
		$r_dp = $this->insert_dp($dp_title,$message['content'],$deal['location_id'],$message['point'],$message['imgs'],1,$from_info,$url_route,$message['id'], $dp_point_group,$deal['id']);
		return $r_dp;
		//increase_user_active(intval($GLOBALS['user_info']['id']),"点评了一个商品"); //活跃度
		// $title = "对".$deal['sub_name']."发表了点评";			
		// $tid = insert_topic($message['content'],$title,$type,$group="", $relay_id = 0, $fav_id = 0,$group_data = "",$attach_list=array(),$url_route);
		// if($tid)
		// {
		// 	$GLOBALS['db']->query("update ".DB_PREFIX."topic set source_name = '网站' where id = ".intval($tid));
		// }
	}

	/**
	 * 
	 * @param $dp_title  点评的标题
	 * @param $dp_content  内容
	 * @param $location_id  点评的门店
	 * @param $point   评分 1-5
	 * @param $is_buy  是否购买点评
	 * @param $from    来源 (event/tuan/youhui/daijin)
	 * @param $url_route  网址参数
	 * @param $message_id  其他部份留言的ID，用于同步
	 */
	public function insert_dp($dp_title,$dp_content,$location_id,$point=0,$imgs='',$is_buy=0,$from="",$url_route=array(),$message_id=0, $dp_point_group = array(),$deal_id = 0)
	{	
		if (!session('uid')) {
			return false;		
		}

		$dp_data = array();
		$dp_data['title'] = $dp_title;
		$dp_data['content'] = $dp_content;
		$dp_data['create_time'] = time();
		$dp_data['point'] = $point;
		if (!empty($imgs)) {
			$dp_data['imgs'] = $imgs;
			$dp_data['is_img'] = 1;
		}
		$dp_data['user_id'] = intval(session('uid'));
		$dp_data['supplier_location_id'] = $location_id;
		$dp_data['status'] = 1;
		$dp_data['from_data'] = $from;
		$dp_data['is_buy'] = $is_buy;
		$dp_data['message_id'] = $message_id;
		foreach($url_route as $k=>$v)
		{
			$dp_data[$k]=$v;
		}
		$r_dp = M('supplier_location_dp')->add($dp_data);
		if($r_dp)
		{
			// t.modify 对服务分组点评
			if(count($dp_point_group) > 0){
				foreach($dp_point_group as $k => $v){
					$data = array(
						'group_id' => $k,
						'point' => $v,
						'supplier_location_id' => $location_id,
						'dp_id' => $r_dp
					);
					M('supplier_location_dp_point_result')->add($data);
				}
			}
			//更新统计
			$this->syn_supplier_locationcount($location_id);
			$this->syn_dealcount($deal_id);
			return $r_dp;
		}else{
			return false;
		}	
	}

	/**
	 * 更新商户统计
	 */
	public function syn_supplier_locationcount($sid)
	{
		if (empty($sid)) {
			return false;
		}
		$sid = intval($sid);
		$sl['dp_count'] = M('supplier_location_dp')->where(array('status'=>1,'supplier_location_id'=>$sid))->count(0);
		$sl['good_dp_count'] = M('supplier_location_dp')->where(array('status'=>1,'supplier_location_id'=>$sid,'point'=>array('egt',3)))->count(0);
		$sl['common_dp_count'] = M('supplier_location_dp')->where(array('status'=>1,'supplier_location_id'=>$sid,'point'=>2))->count(0);
		$sl['bad_dp_count'] = M('supplier_location_dp')->where(array('status'=>1,'supplier_location_id'=>$sid,'point'=>array('lt',2)))->count(0);
		$sl['good_rate'] = floatval($sl['good_dp_count']/$sl['dp_count']);
		//$sl['common_rate'] = floatval($sl['common_dp_count']/$sl['dp_count']);
		//$sl['bad_rate'] = floatval($sl['bad_dp_count']/$sl['dp_count']);
		$sl['total_point'] = M('supplier_location_dp')->where(array('status'=>1,'supplier_location_id'=>$sid))->sum('point');
		$sl['avg_point'] = M('supplier_location_dp')->where(array('status'=>1,'supplier_location_id'=>$sid))->avg('point');
		M('supplier_location')->where(array('id'=>$sid))->save($sl);
	}

	public function syn_dealcount($did)
	{
		if (empty($did)) {
			return false;
		}
		$did = intval($did);
		$m_w = array('rel_table'=>'deal','rel_id'=>$did);
		$total_point  = M('message')->where($m_w)->sum('point');
		$total_comment  = M('message')->where($m_w)->count(0);
		$avg_point = round($total_point/$total_comment); 
		M('deal')->where(array('id'=>$did))->save(array('total_point'=>$total_point,'avg_point'=>$avg_point));
		M('deal')->where(array('id'=>$did))->setInc('dp_count');

	}

	//ajax 上传相片
	public function ajaxUploadImg()
	{
		$imgServerUrl='http://image.17cct.com';
		$d   = explode('-', date('Y-m-d',time()));
		$dir = '../images/'.$d[0].'/'.$d[1].'/'.$d[2].'/';
		//创建目录失败
        if (!file_exists($dir) && !mkdir($dir, 0777, true)) {
           $this->ajaxReturn(0,'创建目录失败',0);
        } else if (!is_writeable($dir)) {
			$this->ajaxReturn(0,'创建目录权限不足',0);
        }

		$isExceedSize = false;
		$img 		  = $_FILES['img'];
		$imgType	  = end(explode('/', $img['type']));
		$isExceedSize = $img['size'] > 2048000;

		//判断图片类型
		$allowType = array('jpg','jpeg','png');
		/*if (!in_array($imgType, $allowType)) {
			$this->ajaxReturn(0,'不允许上传的图片类型！',0);
		}*/
		//检查图片大小
		if ($isExceedSize) {
			$this->ajaxReturn(0,'图片大小超过2M！',0);
		}
		if(!$isExceedSize){
			$imgId	     = time() . rand(1000,9999);
			$newImgName  = $imgId .".". $imgType;        
			$img['name'] = iconv('UTF-8', 'GBK', $newImgName);	// 解决中文文件名乱码问题
			$result 	 = move_uploaded_file($img['tmp_name'],$dir.$img['name']);		
			$img_fpath   = $dir.$newImgName;
			$img_path    = substr($img_fpath, 2);
	 		$img_url	 = $imgServerUrl.$img_path;
		}

		if ($isExceedSize || empty($result)) {
			$this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
		}
		
		/*云上传开始*/
		import("@.ORG.Upyun.upyun");

	    $upyun = new UpYun("img1-cdn","17cct", "17cct!!2013"); 
	    try {
	        $con = $img_path;  
	        // $opts = array(
	        //     UpYun::CONTENT_MD5 => md5(file_get_contents('../'.$con)),
	        //     UpYun::X_GMKERL_THUMBNAIL => 'thumbnail'
	        // );
	     //    $opts = array(
	     //    	UpYun::CONTENT_MD5 => md5(file_get_contents($con)),
		    //     UpYun::X_GMKERL_TYPE    => 'square', // 缩略图类型
		    //     UpYun::X_GMKERL_VALUE   => 150, // 缩略图大小
		    //     UpYun::X_GMKERL_QUALITY => 75,  // 缩略图压缩质量
		    //     UpYun::X_GMKERL_UNSHARP => True // 是否进行锐化处理
		    // );
		     $opts = array(
	        	UpYun::CONTENT_MD5 => md5(file_get_contents($img_fpath))
		    );

	        $fh = fopen($img_fpath, 'rb');
	        $rsp = $upyun->writeFile($con, $fh, True, $opts);   // 上传图片，自动创建目录
	        fclose($fh);
	    } catch(Exception $e) {
	    	@unlink($img_fpath); //删除本地服务器原图
	        $filename = "UpYunErrorLog.txt";
	        $errorcontent = "【评论图片】 时间：".date("Y-m-d H:i:s")." 错误代码：400  错误消息：Bad Request\r\n";
	        $handle = fopen($filename, 'a');
		    fwrite($handle, $errorcontent);
	   	    fclose($handle);
	        $this->ajaxReturn(0,'网络繁忙，请稍后重试',0);
	    }

	    /*云上传结束*/
	    $re['img_name'] =  $newImgName;
		$re['img_path'] =  $img_path;
		$re['img_url']  =  $img_url;
		$this->ajaxReturn($re,'上传成功',1);
	}
}

?>  