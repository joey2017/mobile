<?php

/**
 * 获取GMTime
 * @return int
 */
function getGMTime()
{
	return (time() - date('Z'));
}

/**
 * 精确价格，只保留俩位小数
 * @param  int|float $price 价格
 * @return float
 */
function price($price)
{
	return sprintf("%.02f", $price);
}

/**
 * 获取城市名称
 * @param  int $id 城市id
 * @return string 
 */
function getCityName($id)
{
	return empty($id) ? '暂无' : M("deal_city")->where(array('id'=>intval($id)))->getField("name");
}

// /**
//  * 获取车友会所在城市名称
//  * @param  int $id 城市id
//  * @return string 
//  */
// function getClubCityName($id)
// {
// 	return empty($id) ? '暂无' : M("region_conf")->where(array('id'=>intval($id)))->getField("name");
// }

/**
 * 获取车友会信息
 * 使用方法:
 * <code>
 * echo getClubInfo('circle_name',array('circle_id'=>1,'circle_name'=>'测试测试')); //不返回url
 * echo getClubInfo('circle_id,circle_name',array('circle_id'=>1),true); //返回url,$field参数必须包含circle_id 
 * </code>
 * @param  string  $field 查询的字段
 * @param  array   $where 查询条件 
 * @param  boolean $url   是否返回车友会url
 * @return array 
 */
function getClubInfo($field='',$where=array(),$url=false)
{
	if (!is_array($where))  return '查询条件必须为数组';
	$ClubInfo = M('circle')->field($field)->where($where)->find();
	if ($url == true && $ClubInfo) { // $field 参数必须包含 circle_id 
		$ClubInfo['url'] = U('Club/club',array('id'=>$ClubInfo['circle_id']));
	}
	return empty($ClubInfo) ? false : $ClubInfo;
}

/**
* 获取车友会图片（URL）1.logo,2.幻灯片,3.活动封面图,4相册相片
* 使用方法:
* <code>
*	$arr为数组是 $arr=array('img','70','tiny');
*   $arr[0] 类型 (1)img ：1.logo,2.幻灯片,3.活动封面图；(2)album 1.相册相片 
*   $arr[1] 车友会ID
*   $arr[2] 版本号
* </code>
* @param int 	       $img_url 图片URl(名称或URL路径)
* @param string|array  $arr 类型 
* @return url
*/
function getClubImgUrl($img_url,$arr=''){
	if (empty($img_url)){
		return getDefaultImgUrl('300x200');
	} 
	$imgServerUrl='http://image.17cct.com';
	//列举所有的版本号信息
    $version_array  = array('tiny','small','middle','thumbnail','little','ig','big','max','large','txtwenben','90x70','160x100');
	if (!is_array($arr)) {
		if (in_array($arr, $version_array)) { //$arr为版本号
				$arr='!'.$arr;
		}
		if (strstr($img_url,'/ueditor/php/upload/image')) {
			if (strstr($img_url,'http://')) {
				return $img_url;
			}else{
				return CLUB_URL.$img_url;
			}
		}
		if (strstr($img_url,'http://www')) {
			return $img_url;
		}
		if (!strstr($img_url,'http://image.17cct.com')){
			if(substr($img_url,0,1)=='/') {
				return $imgServerUrl.$img_url.$arr;
			}else{
				return $imgServerUrl.'/'.$img_url.$arr;
			} 
		}else{
			return $img_url.$arr;
		}
	}else{
		if (in_array($arr[2], $version_array)) { 
				$arr[2]='!'.$arr[2];
		}
		return $imgServerUrl.'/images/club/'.$arr[0].'/'.$arr[1].'/'.$img_url.$arr[2];
	}
}

/**
 * 获取主站图片
 * @param string $img_url 		图片链接
 * @param string $version_code  版本号
 * @return url
 */
function getImgUrl($img_url = '', $version_code ='' )
{

    if (empty($img_url)) 
	{
		$img_url = 'http://s.17cct.com/images/no_pic/no_pic_500_500.gif';
	}
	elseif (strstr($img_url,'http://image.17cct.com')) //$img_url 内含 http://image.17cct.com
	{
        $version_array  = array('tiny','small','middle','thumbnail','little','ig','big','max','large','txtwenben','90x70','160x100');
        $img_url =  in_array($version_code, $version_array) ? $img_url.'!'.$version_code : $img_url ;
	}
	elseif (strstr($img_url,'http://')) //已有域名
	{
		$img_url =  $img_url;
	}
	elseif (strstr($img_url,'/ueditor/php/upload/image')) { //百度编辑器上传路径
		$img_url =  'http://www.17cct.com'.$img_url;
	}
	else
	{
		$version_array  = array('tiny','small','middle','thumbnail','little','ig','big','max','large','txtwenben','90x70','160x100');
		$img_url = 'http://image.17cct.com'.$img_url;
    	$img_url = in_array($version_code, $version_array) ? $img_url.'!'.$version_code : $img_url ;
	}
	return $img_url;
}

/**
 * 获取默认图片
 * @param string $tpye 类型
 * @return url
 */
function getDefaultImgUrl($tpye){
	switch ($tpye) {
		case 'face_50x50'://头像 50x50
			$image_path=CLUB_TEMPLATES_URL.'/images/face/avatar_50x50.jpg';
			break;
		case 'face_120x120'://头像 120x120
			$image_path=CLUB_TEMPLATES_URL.'/images/face/avatar_120x120.jpg';
			break;
		case 'noPic_160x120'://相册 无封面
			$image_path=CLUB_TEMPLATES_URL.'/images/defaultphoto_160x120.png';
			break;
		case '100x75'://默认图片 100*75
			$image_path=CLUB_TEMPLATES_URL.'/images/defaultphoto4.jpg';
			break;
		case '135x100'://默认图片 135*100
			$image_path=CLUB_TEMPLATES_URL.'/images/defaultphoto2_135x100.png';
			break;
		case '300x200'://默认图片 300*200
			$image_path=CLUB_TEMPLATES_URL.'/images/defaultphoto8_300x200.jpg';
			break;
		default:
			$image_path=CLUB_TEMPLATES_URL.'/images/defaultphoto8_300x200.jpg';
			break;
	}

    return $image_path;
}

function get_car_name($car_id){
		
	if($car_id){
		$car=M("car")->field('name,parent_id')->where('id='.$car_id)->find();		
		$car_name[]=$car['name'];		
		while($car['parent_id']>0){
			$car_id=$car['parent_id'];
		 	$car=M("car")->field('name,parent_id')->where('id='.$car_id)->find();		
			$car_name[]=$car['name'];	 	
		}		
		rsort($car_name);
		if($car_name){
			return $car_name[0];
		}else{
			return '无';
		}
		
	}	
	
}

//获取车友会城市名称
function get_circle_city($id)
{
	
	if($id)
	return M("region_conf")->where("id=".$id)->getField("name");
	else
		return  "暂无";
}

//获取车友会信息
function get_circle_info($id){
	$circle=M('circle')->where('circle_id='.$id." and circle_status=1")->field('circle_id,circle_mcount,circle_identification_count,circle_name')->find();
	if($circle){
		$circle['circle_url']=U('Club/club',array('id'=>$id));	
	}	
	return $circle;
}
//获取车友会缩略图
function get_circle_img($id,$img)
{
	if($id&&$img)
	return 'http://image.17cct.com/images/club/'.'img/'.$id.'/'.$img;
	else
	return  "http://club.17cct.com/templates/default/images/defaultphoto4.jpg";
}


/**
 * 获取字符串中图片属性 
 * @param string $tpye 类型 默认 src属性
 * @return url
 */
function getImageAttribute($str,$attr='src') 
{ 
	if(!isset($str)){
     return '';
    }
    else {
    	$reg ="/<(img|IMG)(.*)(".$attr."|".strtoupper($attr).")=[\"|'|]{0,}([h|\/].*(jpg|JPG|gif|GIF|png|PNG))[\"|'|\s]{0,}/isU";
     	preg_match_all($reg, $str, $out);
 		return $out[4];
    }
}

/**
 * 获取用户名称
 * 使用方法:
 * <code>
 *	1.知道用户名（user_name）、昵称（true_name）
 *  echo getUserName(array('159XXXX1234','丛中一枝花'));
 *	2.知道用户id
 *  echo getUserName(125);   
 * </code>
 * @param int|array $u
 * @return string
 */
function getUserName($u)
{
	if (is_array($u)) {
		$user_name = $u[0];
		$true_name = $u[1];
	} else {
		$user_info=M("user")->field('user_name,true_name')->where(array('id'=>intval($u)))->find();
		$user_name = $user_info['user_name'];
		$true_name = $user_info['true_name'];
	}
	if (empty($user_name) && empty($true_name))  return '匿名';
	$show_name = empty($true_name) ? $user_name : $true_name ;
	return isMobile($show_name) ? substr_replace($show_name,"***",3,6) : $show_name;
}

//获取车友会用户名称
function get_user_name($id)
{	
	$user_info=M("user")->where("id=".$id)->Field("true_name,mobile")->find();
	
	if($user_info){	
		if($user_info['true_name']){
			if(preg_match('/^1[3|4|5|7|8]\d{9}$/',trim($user_info['true_name']))){
				return substr_replace($user_info['true_name'],"*****",2,5);
			}else{
				return $user_info['true_name'];
			}
			
		}else{
			return substr_replace($user_info['mobile'],"*****",2,5);
		}
	}else{
		 return  "匿名";
	}
}


//获取用户头像的文件名
function get_user_avatar($id,$type)
{
	$uid = sprintf("%09d", $id);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$path = $dir1.'/'.$dir2.'/'.$dir3;			
	$id = str_pad($id, 2, "0", STR_PAD_LEFT); 
	$id = substr($id,-2);
	$avatar_file = "http://www.17cct.com/public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	$avatar_check_file = "http://www.17cct.com/public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	return $avatar_file;
	//@file_put_contents($avatar_check_file,@file_get_contents(APP_ROOT_PATH."public/avatar/noavatar_".$type.".gif"));
}

/**
 * 判断是否为11位电话号码
 * @param int $num
 * @return boolean
 */
function isMobile($num)
{
	$num = (String)$num;
	return preg_match('/^1[3|4|5|7|8]\d{9}$/',$num) ;
}

/**
 * 获取全车名 
 * @param int $car_id 第四级id
 * @return string  如：奥迪 一汽奥迪 A4L 2013款 50 TFSI quattro旗舰型
 */
function getCarName($car_id)
{
	if (empty($car_id)) return false;
	$car=M("car")->field('name,parent_id')->where(array('id'=>$car_id))->find();		
	$car_name[]=$car['name'];		
	while($car['parent_id']>0){
		$car_id=$car['parent_id'];
	 	$car=M("car")->field('name,parent_id')->where(array('id'=>$car_id))->find();		
		$car_name[]=$car['name'];	 	
	}		
	rsort($car_name);
	return implode('  ',$car_name);

}

/**
 * 写入会员积分日记
 * @param  int   	$uid:用户id
 * @param  string   $uname:用户名
 * @param  int 		$type:积分类型 1管理员操作 2签到 3会员注册 4免费预定 5购买支付 6个人资料完善 7认证车主 
 *								   8关注微信号 9创建或加入车友会 10第一次发帖 11评论不同的别人帖子 12发两个主题贴 
 *								   13设置精华贴 14会员删帖15会员删评论 16邀请别人注册 17晒单 18删除晒单
 * @param  string 	$itemid:来源id 
 * @param  int 		$point:积分
 * @param  string 	$desc:描述
 */
function insertUserPointLog($uid,$uname,$type,$itemid,$point,$desc=''){
	$insert['user_id']=intval($uid);
	$insert['user_name']=$uname;
	$insert['point_time']=date('Y-m-d');
	$insert['point_value']=intval($point);			
	$insert['point_type']=$type;
	$insert['point_itemid']=$itemid;
	$insert['point_desc']=$desc;
	M('point_log')->add($insert);
}

/**
 * 会员等级升降
 * @param  int  $u_id:积分
 * @param  int  $point:积分
 * @param  int 	$score:车堂币
 */
function checkUserLevel($u_id,$point,$score){
	if (empty($u_id)) {
		return false;
	} else {
		$u_id=intval($u_id);
	}
	$user_info=M('user')->field('id,score,point,level_id,maxlevel')->where(array('id'=>$u_id))->find();
	$user_level=M('user_level')->field('id,name,description')->where("point <=".intval($user_info['point']+$point)." and score<=".intval($user_info['score']+$score))->order('point desc')->find();
	
	if($user_level){
		if($user_level['id']>$user_info['level_id']){
			    if($user_level['id']>$user_info['maxlevel']){
					$d['maxlevel']=$user_level['id'];
			    	$prise="奖励：".$user_level['description']."。联系电话:0771-2756623";
			    }
				$pm_title = "您已经成为".$user_level['name']."";
				$pm_content = "恭喜您，您已经成为".$user_level['name']."。".$prise;	
				$d['level_id']=$user_level['id'];
				M("user")->where(array('id'=>$user_info['id']))->save($d);
				sendCCTMsg($pm_title,$pm_content,0,$user_info['id'],time(),0,true,true);
		}else if($user_level['id']<$user_info['level_id']){
				$pm_title = "您已经降为".$user_level['name']."";
				$pm_content = "很报歉，您已经降为".$user_level['name']."。";
				$d['level_id']=$user_level['id'];
				M("user")->where(array('id'=>$user_info['id']))->save($d);
				sendCCTMsg($pm_title,$pm_content,0,$user_info['id'],time(),0,true,true);
		}
	}else{//0级
		if($user_info['level_id']==1){
			$pm_title = "您已经降为普通会员";
			$pm_content = "很报歉，您已经降为普通会员。";
			$d['level_id']=0;
			M("user")->where(array('id'=>$user_info['id']))->save($d);
			sendCCTMsg($pm_title,$pm_content,0,$user_info['id'],time(),0,true,true);
		}

	}
}

 /**
 * 写入会员任务操作
 * @param  int   	$uid:用户id
 * @param  string   $uname:用户名
 * @param  int   	$type_calss:任务类型 1一次性任务 2重复性任务 3日常任务 4周任务
 * @param  int 		$type:任务类型 1会员注册 2个人资料完成度 3认证车主 4关注微信号 5免费预定(首次)  6购买支付(首次) 
 *                                 7创建车友会 8第一次发帖 9评论不同的别人帖子 10发两个主题贴 11设置精华贴
 *								   12免费预定(重复) 13购买支付(重复) 14邀请会员注册 15晒单(重复)
 * @param  string 	$itemid:来源id
 * @param  int 		$point:积分
 * @param  int 		$done_times:完成任务次数
 * @param  int   	$status:积分领取状态 0未完成未领取 1已完成已领取 2已完成未领取
 * @param  int   	$setDonetimesInc:完成任务次数 0减少 1增加
 */
function insertMytaskLog($uid,$uname,$type_calss,$type,$itemid,$point,$done_times=0,$status=0,$setDonetimesInc=1){
	$uid =intval($uid);
	$type_calss =intval($type_calss);
	$type =intval($type);
	$point =intval($point);
	$done_times =intval($done_times);
	$status =intval($status);
	$setDonetimesInc =intval($setDonetimesInc);
	//1一次性任务 
	if ($type_calss==1) {
		$disposible_task = M('mytask_log')->where(array('user_id'=>$uid,'task_type'=>$type))->getField('task_id');
		if(!$disposible_task){
			doInsertMytaskLog($uid,$uname,$type_calss,$type,$itemid,$point,$done_times,2);
		}
	//2重复性任务 
	}elseif ($type_calss==2) {
		$times_task = M('mytask_log')->where(array('user_id'=>$uid,'task_type'=>$type))->getField('task_id');
		if(!$times_task){
			doInsertMytaskLog($uid,$uname,$type_calss,$type,$itemid,$point,$done_times,$status);
		}else{
			$data['task_time']=date('Y-m-d');
			$data['task_itemid']=$itemid;
			$data['point_value']=$point;
			M("mytask_log")->where(array('task_id'=>intval($times_task)))->save($data);
			if ($setDonetimesInc==1) {
				M('mytask_log')->where(array('task_id'=>intval($times_task)))->setInc('done_times',1);//ThinkPHP 3.0
				//M('mytask_log')->setInc( 'done_times','task_id='.intval($times_task),1); //ThinkPHP 2.0
			}elseif ($setDonetimesInc==0) {
				M('mytask_log')->where(array('task_id'=>intval($times_task)))->setDec('done_times',1);//ThinkPHP 3.0
				//M('mytask_log')->setDec( 'done_times','task_id='.intval($times_task),1); //ThinkPHP 2.0
			}
		}
	}

}

/**
 * 写入会员任务日记
 * time:2014-12-30
 * @param  int   	$uid:用户id
 * @param  string   $uname:用户名
 * @param  int   	$type_calss:任务类型 1一次性任务 2重复性任务 3日常任务 4周任务
 * @param  int 		$type:任务类型 1会员注册 2个人资料完成度 3认证车主 4关注微信号 5免费预定(首次)  6购买支付(首次) 
 *                                 7创建车友会 8第一次发帖 9评论不同的别人帖子 10发两个主题贴 11设置精华贴
 *								   12免费预定(重复) 13购买支付(重复) 14邀请会员注册 15晒单(重复)
 * @param  string 	$itemid:来源id
 * @param  int 		$point:积分
 * @param  int 		$done_times:完成任务次数
 * @param  int   	$status:积分领取状态 0未领取 1已领取
 */
function doInsertMytaskLog($uid,$uname,$type_calss,$type,$itemid,$point,$done_times,$status){
	$insert['user_id']=$uid;
	$insert['user_name']=$uname;
	$insert['task_time']=date('Y-m-d');
	$insert['task_type_class']=$type_calss;			
	$insert['task_type']=$type;
	$insert['task_itemid']=$itemid;
	$insert['point_value']=$point;
	$insert['done_times']=$done_times;
	$insert['task_status']=$status;
	M('mytask_log')->add($insert);
}

/**
 * 改变车友会油值  车友会升降级
 * @param  int   	$uid:用户id
 * @param  string   $uname:用户名
 * @param  int   	$oil_type:来源类型 1管理员操作 2会员增加 3会员退出 4认证会员增加 5认证会员退出 6会员发帖 
 *                                     7会员删帖 8升级为精华帖 9会员免费预订 10会员支付购买 11会员评论帖子 12会员参加官方活动 
 *                                     13车友会排行前三 14会员签到
 * @param  int 		$oil_itemid:来源id
 * @param  int   	$oil_value:油值
 * @param  string 	$desc:描述
 */
function modifyClubOil($uid,$uname,$oil_type,$oil_itemid,$oil_value,$desc=''){
  	$uid=intval($uid);
 	$oil_value=intval($oil_value);
  	$oil_type=intval($oil_type);
  	if (!empty($uid)) {
  		$c_id = M('circle_member')->field('circle_id')->where(array('member_id'=>$uid))->find();
  		if ($c_id) {
  			//查找车友会现油值
			$co = M('circle')->field('circle_oil,circle_oil_level,circle_oillevel_max,circle_masterid,circle_identification_count')->where(array('circle_id'=>intval($c_id['circle_id'])))->find();
			$circle_level=M('circle_mldefault')->where('mld_exp<='.intval($co['circle_oil']+$oil_value)." and mld_identification_count<=".$co['circle_identification_count'])->order('mld_id desc')->find();
			if($circle_level){
				if($circle_level['mld_id']>$co['circle_oil_level']){
					if($circle_level['mld_id']>$co['circle_oillevel_max']){
						$update['circle_oillevel_max']=$circle_level['mld_id'];
						$prise="奖励：".$circle_level['mld_description']."。联系电话:0771-2756623";
					}	
					$pm_title = "您的车友会升级了";
					$pm_content = "恭喜您，您的车友会已经升为".$circle_level['mld_name']."。".$prise;
					$update['circle_oil_level']=$circle_level['mld_id'];
					M('circle')->where(array('circle_id'=>intval($c_id['circle_id'])))->save($update);
				sendCCTMsg($pm_title,$pm_content,0,$co['circle_masterid'],time(),0,true,true);
				}else if($circle_level['mld_id']<$co['circle_oil_level']){
						$pm_title = "您的车友会降级了";
						$pm_content = "很报歉，您的车友会已经降为".$circle_level['mld_name']."。";
						$update['circle_oil_level']=$circle_level['mld_id'];
						M('circle')->where(array('circle_id'=>intval($c_id['circle_id'])))->save($update);
						sendCCTMsg($pm_title,$pm_content,0,$co['circle_masterid'],time(),0,true,true);
				}
			}else{//等级0
					if ($co['circle_oil_level']==1) {
					$pm_title = "您的车友会降级了";
					$pm_content = "很报歉，您的车友会已经降为无星级。";
					$update['circle_oil_level']=0;
					M('circle')->where(array('circle_id'=>intval($c_id['circle_id'])))->save($update);
					sendCCTMsg($pm_title,$pm_content,0,$co['circle_masterid'],time(),0,true,true);
				}

			}

			if($oil_value<0&&intval($co['circle_oil'])<abs($oil_value)){
					$oil_value=-intval($co['circle_oil']);
			}
			//添加/减少油值
			M('circle')->where(array('circle_id'=>intval($c_id['circle_id'])))->setInc('circle_oil',$oil_value);//ThinkPHP 3.0
			//M('circle')->setInc( 'circle_oil','circle_id='.intval($c_id),$oil_value); //ThinkPHP 2.0	
			//油值日记表
			$ins_oillog['circle_id']=$c_id['circle_id'];
			$ins_oillog['member_id']=$uid;
			$ins_oillog['member_name']=$uname;
			$ins_oillog['oil_type']=$oil_type;
			$ins_oillog['oil_value']=$oil_value;
			$ins_oillog['oil_now']=intval($co['circle_oil'])+$oil_value;
			$ins_oillog['oil_time']=time();
			$ins_oillog['oil_itemid']=$oil_itemid;
			$ins_oillog['oil_desc']=$desc;
			M('circle_oillog')->add($ins_oillog);
  		}
  	}
}

/**
 * 会员信息发送（平台内部信息）
 * @param string  $title        标题
 * @param string  $content      内容
 * @param int     $from_user_id 发件人
 * @param int     $to_user_id   收件人
 * @param int     $create_time  时间
 * @param int     $sys_msg_id   系统消息ID
 * @param boolean $only_send    true 为只发送，生成发件数据，不生成收件数据
 * @param boolean $is_notice    true 为只发送，生成发件数据，不生成收件数据 
 */
function sendCCTMsg($title,$content,$from_user_id,$to_user_id,$create_time,$sys_msg_id=0,$only_send=false,$is_notice = false)
{
	$group_arr = array($from_user_id,$to_user_id);
	sort($group_arr);
	if($sys_msg_id>0||$is_notice)
	$group_arr[] = $sys_msg_id;	
	$msg = array();
	$msg['title'] = $title;
	$msg['content'] = $content;
	$msg['from_user_id'] = $from_user_id;
	$msg['to_user_id'] = $to_user_id;
	$msg['create_time'] = $create_time;
	$msg['system_msg_id'] = $sys_msg_id;
	$msg['type'] = 0;
	$msg['group_key'] = implode("_",$group_arr);
	$msg['is_notice'] = intval($is_notice);
	$id=M('msg_box')->add($msg);
	if($is_notice){
		$data['group_key']=$msg['group_key']."_".$id;
		M('msg_box')->where(array('id'=>$id))->save($data);
	}
	if(!$only_send)
	{
		$msg['type'] = 1; //记录发件
		M('msg_box')->add($msg);
	}
}

/**
 * 判断是否已经登录
 * @param string  $url 
 */
function isLogin($url,$need_return = false)
{	
	
	if(!session("uid")||!session("user_info")){	
		if ($need_return) {
			return false;
		}else{
			/*scope（作用域）
			* a.snsapi_base      只获取openid
			* b.snsapi_userinfo  获取个人信息
			*/
			$refererUrl = empty($url) ? $_SERVER['HTTP_REFERER'] : $url ;
			$refererUrl = empty($refererUrl) ? U('Index/index') : $refererUrl ; //登录前一个页面的Url
			session('referer_url',$refererUrl);
			$redirectUrl = urlencode(DOMAIN_URL.U('User/OAuth_wx'));  //授权后重定向的回调链接地址，请使用urlencode对链接进行处理 
			$goUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('wx_id')."&redirect_uri=".$redirectUrl."&response_type=code&scope=snsapi_base&state=".$refererUrl."#wechat_redirect";
			header("Location:".$goUrl);
			//$this->redirect($goUrl);
		}
	}else {
		return true;
	}
}
	
/**
 * 发送订单微信信息
 * @param int     $wxid     接受信息的微信id
 * @param string  $content  内容
 * @param string  $url 
 * @return json     
 */
function sendOrderWxMsg($wxid,$title,$content,$url)
{

	$jsonData='{"touser":"'.$wxid.'","msgtype":"news","news":{"articles": [{
    "title":"'.$title.'",
    "description":"'.$content.'",
    "url":"'.$url.'",
    "picurl":""}]}}';
    $access_token  = getWxAccToken();
	$get_token_url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;			
	$ch  = curl_init($get_token_url) ;
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	$result = curl_exec($ch) ;
	curl_close($ch) ;
	$result = json_decode($result,true);
	return $result;
}

//注册时推送消息
function sendRegistWxMsg($wxid,$title,$content,$url)
{

	$jsonData='{"touser":"'.$wxid.'","msgtype":"news","news":{"articles": [{"title":"有车一族享福利了","description":"汽车服务新时尚 ——O2O电商平台诚车堂汽车服务年卡","url":"http://e.eqxiu.com/s/wlhpsLF7?eqrcode=1","picurl":"http://res.eqxiu.com/group4/M00/85/91/yq0KYFb5-9CAM5gMAACWa9q-5sQ878.jpg"}]}}';
    $access_token  = getWxAccToken();

	$get_token_url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;			
	$ch  = curl_init($get_token_url) ;
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	$result = curl_exec($ch) ;
	curl_close($ch);
	
}

/**
 * 获取微信 access_token  
 * @return json    
 */
function getWxAccToken()
{
	/* $mem = new Memcache; 
	 $mem->connect('localhost', 11211) or die ("Could not connect"); 
	 $access_token = $mem->get('access_token');
	if($access_token){
		return $access_token;
	}else{*/
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".C('wx_id')."&secret=".C('wx_secret'));
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$access_token = curl_exec($ch);
		$access_token=json_decode($access_token, true); 
		//$mem->set('access_token',$access_token['access_token'],0,7000);
		return $access_token['access_token'];
		
	//}	
}

/**
 * 获取商家版公众 access_token  
 * @return json    
 */
function getshopAccToken()
{
	/* $mem = new Memcache; 
	 $mem->connect('localhost', 11211) or die ("Could not connect"); 
	 $access_token = $mem->get('access_token');
	if($access_token){
		return $access_token;
	}else{*/
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxb09359ac1d3f2267&secret=7e161c7930c9de1f3213dd13d6bb7a9c");
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$access_token = curl_exec($ch);
		$access_token=json_decode($access_token, true); 
		//$mem->set('access_token',$access_token['access_token'],0,7000);
		return $access_token['access_token'];
		
	//}	
}


//获取订单状态
function get_order_status($order)
{
	
	$time_now = time();
	//if($order['order_status'] == 1 || $order['is_delete'] == 1){
	if($order['is_delete'] == 1){
		$status = -1;
	}else if($order['order_status'] == '0' && $order['pay_status'] == '0' && $order['type'] == '0'){
		$status = 0;
	}else if($order['pay_status'] == 2 || $order['pay_status'] == '0'){
		//$confirm = $GLOBALS['db']->getRow("SELECT MIN(`confirm_time`) AS `min_confirm`,MAX(`confirm_time`) AS `max_confirm`,MAX(`end_time`) AS `max_end` FROM ".DB_PREFIX."deal_coupon WHERE `order_id`=".$order['id']);
		//$confirm=M('deal_coupon')->field(' MIN(`confirm_time`) AS `min_confirm`,MAX(`confirm_time`) AS `max_confirm`,MAX(`end_time`) AS `max_end`')->where('order_id='.$order['id'])->find();
		if($order['min_confirm'] == '0' && $order['max_confirm'] == '0'){
			if(($order['max_end'] > 0 && $time_now < $order['max_end']) || $order['max_end'] == 0){
				$status = 1;
			}else{
				$status = -2;
			}
		}else if($order['min_confirm'] == 0 && $order['max_confirm'] > 0){
			$status = 2;
		}else{
			$status = 3;
		}
	}else{
		$status=4;
	}
	return $status;
}


/**
 * 同步订单支付状态
 * @return boolean   
 */
function order_paid($order_id)
{	
	$order_id  = intval($order_id);
	//$order = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_order where id = ".$order_id);
	$order=M('deal_order')->where(array('id'=>$order_id))->find();
	
	if($order['pay_amount']>=$order['total_price'])
	{
		//$GLOBALS['db']->query("update ".DB_PREFIX."deal_order set pay_status = 2 where id =".$order_id." and pay_status <> 2");
		//$rs = $GLOBALS['db']->affected_rows();
		$data['pay_status']=2;
		$rs=M('deal_order')->where('id='.$order_id." and pay_status<> 2")->save($data);
		if($rs)
		{
			//支付完成
			//order_paid_done($order_id);
			//$order = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_order where id = ".$order_id);
			if($order['pay_status']==2&&$order['after_sale']==0){
				$result = true;
				
			}				
			else{
				$result = false;
			}
		
		}
		if($order['type']){
			/*
			*免费预定
			*/
			/*积分操作*/
			//写入任务日记 一次性任务 第一次免费预定
			insertMytaskLog($order['user_id'],$order['user_name'],1,5,$order['order_sn'],50);
			//写入任务日记 重复性任务 免费预定 
			insertMytaskLog($order['user_id'],$order['user_name'],2,12,$order['order_sn'],intval($order['total_price']),1,1);
			//增加积分
			$data['point']=array('exp','point+'.intval($order['total_price']));
			check_user_level($order['user_id'],intval($order['total_price']),0);
			//写入积分日志
			do_insert_member_point($order['user_id'],$order['user_name'],4,$order_id,intval($order['total_price']),'免费预定(微信端),订单号（'.$order['order_sn'].'）');
			/*油值操作*/
			//如果为车友会员 送油值
			//modify_circle_oil($order['user_id'],$order['user_name'],9,$order_id,intval($order['total_price']),'免费预定');			
		}
		else{
			/*
			*在线支付
			*/

		   /*在线支付*/
			
			//写入我的任务日记 第一次支付购买
			insertMytaskLog($order['user_id'],$order['user_name'],1,6,$order['order_sn'],50);	
			//写入任务日记 重复性任务 免费预定 
			insertMytaskLog($order['user_id'],$order['user_name'],2,13,$order['order_sn'],intval($order['total_price']),1,1);
			//送车堂币
			$data['score']=array('exp','score+'.intval($order['total_price']));	
			check_user_level($order['user_id'],0,intval($order['total_price']));
			//写入用户记录
			$log_info['log_info'] = $order['order_sn']."订单返车堂币";
			$log_info['log_time'] = time();
			$log_info['log_admin_id'] = 0;
			$log_info['log_user_id'] = intval($order['user_id']);
			$log_info['money'] = 0;
			$log_info['score'] = intval($order['total_price']);
			$log_info['point'] = 0;
			$log_info['user_id'] = intval($order['user_id']);
			M('user_log')->add($log_info);
			//如果为车友会员 送1倍油值
			modify_circle_oil($order['user_id'],$order['user_name'],10,$order_id,intval($order['total_price']),'支付购买');

		}
		$r=M('user')->where('id='.$order['user_id'])->save($data);
	}
	elseif($order['pay_amount']<$order['total_price']&&$order['pay_amount']!=0)
	{
		//$GLOBALS['db']->query("update ".DB_PREFIX."deal_order set pay_status = 1 where id =".$order_id);
		$data['pay_status']=1;
		$rs=M('deal_order')->where('id='.$order_id)->save($data);
		$result = false;  //订单未支付成功
	}
	elseif($order['pay_amount']==0)
	{
		//$GLOBALS['db']->query("update ".DB_PREFIX."deal_order set pay_status = 0 where id =".$order_id);
		$data['pay_status']=0;
		$rs=M('deal_order')->where('id='.$order_id)->save($data);
		$result = false;  //订单未支付成功
	}		
	return $result;
}


/**
 * 获取微信 ticket  
 * @return json    
 */
function getWxTicket()
{
		$mem = new Memcache; 
	    $mem->connect('localhost', 11211) or die ("Could not connect"); 
	    $ticket = $mem->get('ticket');
		if($ticket){
			return $ticket;
		}else{
			$ch = curl_init();
			$timeout = 5;
			$token=getWxAccToken();
			curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$token&type=jsapi");
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$ticket = curl_exec($ch);
			$ticket=json_decode($ticket, true);
			$mem->set('ticket',$ticket['ticket'],0,7200);
			return $ticket['ticket'];	
		}

}

/**
 * 发送微信信息
 * @param string $wxid 微信id
 * @param string $msg  发送内容
 */
function sendWxMsg($wxid,$msg)
{		
	
	$jsonData='{"touser":"'.$wxid.'","msgtype":"text","text":{"content":"'.$msg.'"}}';
	$access_token=getWxAccToken();
	$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
	$ch = curl_init($url) ;
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	$result = curl_exec($ch) ;
	curl_close($ch) ;
	$result=json_decode($result,true);
}

/**
 * 获取六位随机密码 
 * @return int    
 */
function getSixPwd()
{
	$ychar="0,1,2,3,4,5,6,7,8,9";
	$list=explode(",",$ychar);
	for($i=0;$i<6;$i++){
		$randnum=rand(0,9); 
		$authnum.=$list[$randnum];
	}
	return $authnum;
}

/**
 * 获取订单状态 
 * @param array $order 订单详情数组
 * @return int    
 */
function getOrderStatus($order)
{
	$time_now = time();
	//if($order['order_status'] == 1 || $order['is_delete'] == 1){
	if($order['is_delete'] == 1){
		$status = -1;
	}else if($order['order_status'] == '0' && $order['pay_status'] == '0' && $order['type'] == '0'){
		$status = 0;
	}else if($order['pay_status'] == 2 || $order['pay_status'] == '0'){
		//$confirm = $GLOBALS['db']->getRow("SELECT MIN(`confirm_time`) AS `min_confirm`,MAX(`confirm_time`) AS `max_confirm`,MAX(`end_time`) AS `max_end` FROM ".DB_PREFIX."deal_coupon WHERE `order_id`=".$order['id']);
		//$confirm=M('deal_coupon')->field(' MIN(`confirm_time`) AS `min_confirm`,MAX(`confirm_time`) AS `max_confirm`,MAX(`end_time`) AS `max_end`')->where('order_id='.$order['id'])->find();
		if($order['min_confirm'] == '0' && $order['max_confirm'] == '0'){
			if(($order['max_end'] > 0 && $time_now < $order['max_end']) || $order['max_end'] == 0){
				$status = 1;
			}else{
				$status = -2;
			}
		}else if($order['min_confirm'] == 0 && $order['max_confirm'] > 0){
			$status = 2;
		}else{
			$status = 3;
		}
	}else{
		$status=4;
	}
	return $status;
}

/**
 * 获取用户头像的文件名 
 * @param int    $id 订单详情数组
 * @param string $type  1.big 2.middle 3.small
 * @return url    
 */
function getUserAvatar($id,$type)
{
	$uid = sprintf("%09d", $id);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$path = $dir1.'/'.$dir2.'/'.$dir3;			
	$id = str_pad($id, 2, "0", STR_PAD_LEFT); 
	$id = substr($id,-2);
	$avatar_file = "http://www.17cct.com/public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	return $avatar_file;
}

function img_exits($url)
{
    $ch = curl_init();
    curl_setopt($ch, curlopt_url,$url);
    curl_setopt($ch, curlopt_nobody, 1); // 不下载
    curl_setopt($ch, curlopt_failonerror, 1);
    curl_setopt($ch, curlopt_returntransfer, 1);

    if(curl_exec($ch)!==false)
        return true;
    else
        return false;
}

/**
 * 截取字符串（包括汉字） 
 * @param string   $str     字符串
 * @param int      $start   开始截取的位置
 * @param int      $length  截取的长度
 * @param string   $charset 编码类型
 * @param boolean  $suffix  是否加 "…"
 * @return string    
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)  
{  
	
    if(strlen($str)<=$length*2) return $str;
    if(function_exists("mb_substr")){  
        if($suffix)  
             return mb_substr($str, $start, $length, $charset)."…";  
        else 
             return mb_substr($str, $start, $length, $charset);  
    }  
    elseif(function_exists('iconv_substr')) {  
        if($suffix)  
             return iconv_substr($str,$start,$length,$charset)."…";  
        else 
             return iconv_substr($str,$start,$length,$charset);  
    }  
    $re['utf-8']   = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";  
    $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";  
    $re['gbk']    = "/[x01-x7f]|[x81-xfe][x40-xfe]/";  
    $re['big5']   = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";  
    preg_match_all($re[$charset], $str, $match);  
    $slice = join("",array_slice($match[0], $start, $length));  
    if($suffix) return $slice."…";  
    return $slice;
}

/**
 * 会员等级升降
 * time:2014-12-23
 * @param  int  $u_id:积分
 * @param  int  $point:积分
 * @param  int 	$score:车堂币
 */
function check_user_level($u_id,$point,$score){
	if (empty($u_id)) {
		return false;
	} else {
		$u_id=intval($u_id);
	}
	$user_info=M('user')->where('id='.$u_id)->field('id,score,point,level_id,maxlevel')->find();
	$user_level=M('user_level')->where("point <=".intval($user_info['point']+$point)." and score<=".intval($user_info['score']+$score))->field('id,name,description')->order('point desc')->find();
	
	if($user_level){
		if($user_level['id']>$user_info['level_id']){
			    if($user_level['id']>$user_info['maxlevel']){
					$d['maxlevel']=$user_level['id'];
			    	$prise="奖励：".$user_level['description']."。联系电话:0771-2756623";
			    }
				$pm_title = "您已经成为".$user_level['name']."";
				$pm_content = "恭喜您，您已经成为".$user_level['name']."。".$prise;	
				$d['level_id']=$user_level['id'];
				M("user")->where('id='.$user_info['id'])->save($d);
				sendCCTMsg($pm_title,$pm_content,0,$user_info['id'],time(),0,true,true);
		}else if($user_level['id']<$user_info['level_id']){
				$pm_title = "您已经降为".$user_level['name']."";
				$pm_content = "很报歉，您已经降为".$user_level['name']."。";
				$d['level_id']=$user_level['id'];
				M("user")->where('id='.$user_info['id'])->save($d);
				sendCCTMsg($pm_title,$pm_content,0,$user_info['id'],time(),0,true,true);
		}
	}else{//0级
		if($user_info['level_id']==1){
			$pm_title = "您已经降为普通会员";
			$pm_content = "很报歉，您已经降为普通会员。";
			$d['level_id']=0;
			M("user")->where('id='.$user_info['id'])->save($d);
			sendCCTMsg($pm_title,$pm_content,0,$user_info['id'],time(),0,true,true);
		}

	}
}

/**
 * 写入会员积分日记
 * time:2014-12-22
 * @param  int   	$uid:用户id
 * @param  string   $uname:用户名
 * @param  int 		$type:积分类型 1管理员操作 2签到 3会员注册 4免费预定 5购买支付 6个人资料完善 7认证车主 
 *								   8关注微信号 9创建或加入车友会 10第一次发帖 11评论不同的别人帖子 12发两个主题贴 
 *								   13设置精华贴 14会员删帖15会员删评论 16邀请别人注册 17晒单 18删除晒单
 * @param  string 	$itemid:来源id 
 * @param  int 		$point:积分
 * @param  string 	$desc:描述
 */
function do_insert_member_point($uid,$uname,$type,$itemid,$point,$desc=''){
	$insert['user_id']=intval($uid);
	$insert['user_name']=$uname;
	$insert['point_time']=date('Y-m-d');
	$insert['point_value']=intval($point);			
	$insert['point_type']=$type;
	$insert['point_itemid']=$itemid;
	$insert['point_desc']=$desc;
	M('point_log')->add($insert);
}

/**
 * 改变车友会油值  车友会升降级
 * time:2014-12-27
 * @param  int   	$uid:用户id
 * @param  string   $uname:用户名
 * @param  int   	$oil_type:来源类型 1管理员操作 2会员增加 3会员退出 4认证会员增加 5认证会员退出 6会员发帖 
 *                                     7会员删帖 8升级为精华帖 9会员免费预订 10会员支付购买 11会员评论帖子 12会员参加官方活动 
 *                                     13车友会排行前三 14会员签到
 * @param  int 		$oil_itemid:来源id
  * @param  int   	$oil_value:油值
 * @param  string 	$desc:描述
 */
function modify_circle_oil($uid,$uname,$oil_type,$oil_itemid,$oil_value,$desc=''){
  	$uid=intval($uid);
 	$oil_value=intval($oil_value);
  	$oil_type=intval($oil_type);
  	if (!empty($uid)) {
  		$c_id = M('circle_member')->field('circle_id')->where('member_id='.$uid)->find();
  		if ($c_id) {
  			//查找车友会现油值
			$co = M('circle')->field('circle_oil,circle_oil_level,circle_oillevel_max,circle_masterid,circle_identification_count')->where('circle_id='.intval($c_id['circle_id']))->find();
			$circle_level=M('circle_mldefault')->where('mld_exp<='.intval($co['circle_oil']+$oil_value)." and mld_identification_count<=".$co['circle_identification_count'])->order('mld_id desc')->find();
			if($circle_level){
				if($circle_level['mld_id']>$co['circle_oil_level']){
					if($circle_level['mld_id']>$co['circle_oillevel_max']){
						$update['circle_oillevel_max']=$circle_level['mld_id'];
						$prise="奖励：".$circle_level['mld_description']."。联系电话:0771-2756623";
					}	
					$pm_title = "您的车友会升级了";
					$pm_content = "恭喜您，您的车友会已经升为".$circle_level['mld_name']."。".$prise;
					$update['circle_oil_level']=$circle_level['mld_id'];
					M('circle')->where(array('circle_id'=>$c_id['circle_id']))->save($update);
				sendCCTMsg($pm_title,$pm_content,0,$co['circle_masterid'],time(),0,true,true);
				}else if($circle_level['mld_id']<$co['circle_oil_level']){
						$pm_title = "您的车友会降级了";
						$pm_content = "很报歉，您的车友会已经降为".$circle_level['mld_name']."。";
						$update['circle_oil_level']=$circle_level['mld_id'];
						M('circle')->where(array('circle_id'=>$c_id['circle_id']))->save($update);
						sendCCTMsg($pm_title,$pm_content,0,$co['circle_masterid'],time(),0,true,true);
				}
			}else{//等级0
					if ($co['circle_oil_level']==1) {
					$pm_title = "您的车友会降级了";
					$pm_content = "很报歉，您的车友会已经降为无星级。";
					$update['circle_oil_level']=0;
					M('circle')->where(array('circle_id'=>$c_id['circle_id']))->save($update);
					sendCCTMsg($pm_title,$pm_content,0,$co['circle_masterid'],time(),0,true,true);
				}

			}

			if($oil_value<0&&intval($co['circle_oil'])<abs($oil_value)){
					$oil_value=-intval($co['circle_oil']);
			}
			//添加/减少油值
			M('circle')->where('circle_id='.intval($c_id['circle_id']))->setInc('circle_oil',$oil_value);//ThinkPHP 3.0
			//M('circle')->setInc( 'circle_oil','circle_id='.intval($c_id),$oil_value); //ThinkPHP 2.0	
			//油值日记表
			$ins_oillog['circle_id']=$c_id['circle_id'];
			$ins_oillog['member_id']=$uid;
			$ins_oillog['member_name']=$uname;
			$ins_oillog['oil_type']=$oil_type;
			$ins_oillog['oil_value']=$oil_value;
			$ins_oillog['oil_now']=intval($co['circle_oil'])+$oil_value;
			$ins_oillog['oil_time']=time();
			$ins_oillog['oil_itemid']=$oil_itemid;
			$ins_oillog['oil_desc']=$desc;
			M('circle_oillog')->add($ins_oillog);
  		}
  	}
}


/**
 * utf8字符转Unicode字符
 * @param string $char 要转换的单字符
 * @return void
 */
function utf8ToUnicode($char)
{
	switch(strlen($char))
	{
		case 1:
			return ord($char);
		case 2:
			$n = (ord($char[0]) & 0x3f) << 6;
			$n += ord($char[1]) & 0x3f;
			return $n;
		case 3:
			$n = (ord($char[0]) & 0x1f) << 12;
			$n += (ord($char[1]) & 0x3f) << 6;
			$n += ord($char[2]) & 0x3f;
			return $n;
		case 4:
			$n = (ord($char[0]) & 0x0f) << 18;
			$n += (ord($char[1]) & 0x3f) << 12;
			$n += (ord($char[2]) & 0x3f) << 6;
			$n += ord($char[3]) & 0x3f;
			return $n;
	}
}

/**
 * utf8字符串分隔为unicode字符串
 * @param string $str    要转换的字符串
 * @param string $depart 分隔,默认为空格为单字
 * @return string
 */
function strToUnicodeWord($str,$depart=' ')
{
	$arr = array();
	$str_len = mb_strlen($str,'utf-8');
	for($i = 0;$i < $str_len;$i++)
	{
		$s = mb_substr($str,$i,1,'utf-8');
		if($s != ' ' && $s != '　')
		{
			$arr[] = 'ux'.utf8ToUnicode($s);
		}
	}
	return implode($depart,$arr);
}


/**
 * utf8字符串分隔为unicode字符串
 * @param string $str 要转换的字符串
 * @return string
 */
function strToUnicodeString($str)
{
	$string = strToUnicodeWord($str,'');
	return $string;
}

/**
 * 发送手机短信息
 * @param string $phone   发送电话号码
 * @param string $content 发送内容
 * @return string  
 */
/*function sendPhoneSms($phone,$content)
{
	$smsapi = "api.smsbao.com"; //短信网关 
	$charset = "utf8"; //文件编码 
	$user = trim(C('sms_name')); //短信平台帐号 
	$pass = md5(trim(C('sms_pwd'))); //短信平台密码 
	 
	import('@.ORG.snoopy');
	$snoopy = new snoopy();
	$sendurl = "http://{$smsapi}/sms?u={$user}&p={$pass}&m={$phone}&c=".urlencode($content);
	$snoopy->fetch($sendurl);
	$result = $snoopy->results;
	return $result;
}*/

//2017.8.1启用腾讯云短信接口
function send_sms($mobile, $content)
{
    $key = 'a5acf17a312f2b792be491ce19db84e3';
    $aid = '1400036374';
    $rnd = rand(1000, 9999);
    $sig = hash('sha256', 'appkey='.$key.'&random='.$rnd.'&time='.time().'&mobile='.$mobile);
    $url = 'https://yun.tim.qq.com/v5/tlssmssvr/sendsms?sdkappid='.$aid.'&random='.$rnd;
    $json = array(
        'tel'       => array('nationcode' => '86', 'mobile' => $mobile),
        'type'      => 0,
        'msg'       => urlencode($content),
        'sig'       => $sig,
        'time'      => time(),
        'extend'    => '',
        'ext'       => ''
    );
    $json = json_encode($json);
    $json = urldecode($json);
    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    
    $result = curl_exec($curl);
    curl_close($curl);
    
    if(empty($result))
        return false;
    
    $result = json_decode($result, true);
    
    if(empty($result) || $result['result'] != 0)
        return false;
    
    return true;
}


/**
 * 获取距离
 * @param int $lat1 
 * @param int $lng1  
 * @param int $lat2 
 * @param int $lng2  
 * @return int
 */
function getDistance($lat1, $lng1, $lat2, $lng2)  
{  
   $EARTH_RADIUS = 6378.137;  
   $radLat1 = rad($lat1);  
   $radLat2 = rad($lat2);  
   $a = $radLat1 - $radLat2;  
   $b =rad($lng1) - rad($lng2);  
   $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));  
   $s = $s *$EARTH_RADIUS;  
   $s = round($s * 10000) / 10000;  
   return $s;  
}

/**
 * 配合函数 getDistance()
 * @param int $d 
 * @return int
 */
function rad($d)  
{  
    return $d * 3.1415926535898 / 180.0;  
}

/**
 * 获取用户ip 
 * @param int    $id 订单详情数组
 * @param string $type  1.big 2.middle 3.small
 * @return url    
 */

// function getIp()
// {
// 	import('ORG.Net.IpLocation');// 导入IpLocation类
// 	$IpLocation = new IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
// 	$Ip = $IpLocation->getlocation('180.136.232.51'); // 获取某个IP地址所在的位置

// 	return $Ip;
// }
function getIp($ip='',$charset='gbk',$file='ip.dat') 
{     
	import("ORG.Net.IpLocation");         
	$iplocation =  new IpLocation($file);         
	$Ip   =  $iplocation->getlocation($ip);         

	if('utf-8' != $charset) {   
		foreach ($Ip as $k => $v ){
			$Ip[$k] = iconv($charset,'utf-8',$v);   
	    }        
	}     
	return $Ip; 
}

/**
 * 地区 
 * @param int    $aid   地区id
 * @return array    
 */
function getArea($aid)
{
	$aid = intval($aid);
	if (empty($aid)) {
		return false;
	}

	$Region = M('region_conf');
	$areaInfo = $Region->find($aid);
	if (empty($areaInfo) ) {
		return false;
	}
	$area =  array(2=>'province',3=>'city',4 =>'area');
	$re = array();
	$re[$area[$areaInfo['region_level']]] = $areaInfo;
	if ($areaInfo['region_level'] == 3 || $areaInfo['region_level'] == 4) {

		$areaInfo = $Region->find($areaInfo['pid']);
		$re[$area[$areaInfo['region_level']]] = $areaInfo;

		if ($areaInfo['region_level'] == 3) {
			$areaInfo = $Region->find($areaInfo['pid']);
			$re[$area[$areaInfo['region_level']]] = $areaInfo;
		}
	}
	return $re;
}


/**
 * 检查车友会状态 
 * @param int  $cid  	 车友会id
 * @param int  $re_type  返回类型
 * @return int 车友会状态，0关闭，1开启，2审核中，3审核失败  
 */
function ckClub($cid,$re_type=1)
{
	if (empty($cid)) {
		return false;
	}

	$cid = intval($cid);

	$status = M('circle')->where(array('circle_id'=>$cid))->getField('circle_status');	

	if ($re_type == 2) {
		return $status;
	}

	return  $status == 1 ? true : false ;
}

/**
 * 记录日记
 * @param int  $tpye  	 日记类型
 * @param int  $data  	 参数数组
 * 1.$date_name='user_log'
 * $data['log_info'] 	 => 内容 ;
 * $data['log_time'] 	 => 时间 ;
 * $data['log_admin_id'] => 是否为管理员：是 填入管理员ID ;
 * $data['log_user_id']  => 是否为用户：  是 填入管用-ID ;
 * $data['money'] 		 => 未知 ; 
 * $data['score'] 		 => 车堂币 ; 
 * $data['point'] 		 => 积分 ; 
 * $data['credits'] 	 => 未知 ; 
 * $data['user_id'] 	 => 操作对象用户id ; 
 * 使用方法:
 * <code>
 * saveLog('user_log', array('log_info'=>'在2012-09-21 16:10:22注册成功','log_time'=>time(),'log_user_id'=>1,'point'=>100,'user_id'=>3862));
 * </code>
 * @param  str
 */
function saveLog($date_name,$data = array())
{
	if(empty($data) || empty($date_name) || !is_array($data)) {
		return false;
	}

	M($date_name)->add($data);
}

/**
 * 生成路线服务券
 * @param int  $oid  	订单ID
 * @param int  $oiid  	order_item ID
 * @param int  $uid  	用户 ID
 * @param arr  $deal  	服务或商品信息 
 * @return str $coupon['sn']	券号
 */
function add_route_coupon($order_id,$route_id,$user_id,$agency_id)
{
	$coupon['sn']		  	 = $route_id.rand(100000,999999);//服务码
	$coupon['is_valid'] 	 = 1;
	$coupon['route_id']	  	 = $route_id;
	$coupon['user_id']	  	 = $user_id;//用户id
	$coupon['order_id']	  	 = $order_id; //订单id
	$coupon['agency_id']	 = $agency_id;
	while(!M('zjy_coupon')->add($coupon))
	{
		$coupon['sn'] = $route_id.rand(100000,999999);
	}

	return $coupon;
}

/**
 * 生成服务券 商品券
 * @param int  $oid  	订单ID
 * @param int  $oiid  	order_item ID
 * @param int  $uid  	用户 ID
 * @param arr  $deal  	服务或商品信息 
 * @return str $coupon['sn']	券号
 */
function addCoupon($oid,$oiid,$uid,$deal = array())
{
	$coupon['sn']		  	 = $deal['code'].$deal['id'].rand(100000,999999);//服务码
	$coupon['begin_time'] 	 = $deal['coupon_begin_time'];
	$coupon['end_time']	  	 = $deal['end_time'];
	$coupon['user_id']	  	 = $uid;//用户id
	$coupon['deal_id']	  	 = $deal['id'];//服务id
	$coupon['order_id']	  	 = $oid; //订单id
	$coupon['order_deal_id'] = $oiid;
	$coupon['supplier_id']	 = $deal['supplier_id'];
	$coupon['is_valid']	     = 1;
	$r = M('deal_coupon')->add($coupon);
	return $r ? $coupon['sn'] : false ;
}

/**
 * 支付成功后发送信息（手机短信，微信信息）
 * @param int  $tpye  	类型：user 用户 store 商家
 * @param arr  $arr
  * 使用方法:
 * <code>
 * 1.user
 *  $userMsg['order_id']       = $order['id'];
 *  $userMsg['user_true_name'] = $u['true_name'];
 *  $userMsg['user_mobile']    = $u['mobile'];
 *  $userMsg['user_wxid']      = $u['wxid'];
 *  $userMsg['deal_id']        = $deal['id'];
 *  $userMsg['deal_name']      = $deal['sub_name'];
 *  $userMsg['deal_tpye']      = $deal['is_shop'];
 *  $userMsg['coupon'] 	       = $coupon;
 *  $userMsg['store_tel']      = $store['tel'];
 *  $userMsg['store_name']     = $store['name'];
 *  $userMsg['store_address']  = $store['address'];
 *  paySuccessSendMsg('user',$userMsg);
 * 2.store
 * 	$storeMsg['user_true_name'] = $u['true_name'];
 *	$storeMsg['user_mobile']    = $u['mobile'];
 *	$storeMsg['deal_name']   	= $deal['sub_name'];
 *	$storeMsg['deal_tpye'] 		= $deal['is_shop'];
 *	$storeMsg['store_mobile']   = $store['mobile'];
 *	paySuccessSendMsg('store',$storeMsg);
 * </code>
 */
function paySuccessSendMsg($tpye,$arr = array())
{	
	if (!is_array($arr)) {
		return false;
	}
	if ($tpye == 'user') {
		if ($arr['deal_tpye'] == 1) {
			$arr['deal_tpye'] = '商品';
			$arr['deal_url']  = DOMAIN_URL.U('Goods/view',array('id'=>$arr['deal_id']));
		}else{
			$arr['deal_tpye'] = '服务';
			$arr['deal_url']  = DOMAIN_URL.U('Service/view',array('id'=>$arr['deal_id']));
		}
		//发送微信
	    $deal_attr = empty($arr['deal_attr']) ?  '' : $arr['deal_tpye'].'属性：'.$arr['deal_attr'].'\n\n';
	    if($arr['send_type']=='erp'){
	    	 $url = DOMAIN_URL.U('Advance/erp_order_detail',array('id'=>$arr['order_id']));
	    }else{
	    	 $url = DOMAIN_URL.U('User/order').'?t=4';	
	    }
	   

		$content  = '提交时间：'.date('Y-m-d',time()).'\n\n预订'.$arr['deal_tpye'].'：'.$arr['deal_name'].'\n\n'.$deal_attr.$arr['deal_tpye'].'券：'.$arr['coupon'].'\n\n';
		$content .= "商家名称：".$arr['store_name'].'\n\n联系电话：'.$arr['store_tel'].'\n\n'.'商家地址：'.$arr['store_address'].'\n\n如有疑问,请拨打诚车堂客服热线:0771-2756623';
		sendOrderWxMsg($arr['user_wxid'],'新订单通知',$content,$url);

		/*$url = $arr['deal_url'];
		$content  = '提交时间：'.date('Y-m-d',time()).'\n\n客户名称：'.$arr['user_true_name'].'\n\n客户电话：'.$arr['user_mobile'].'\n\n';
		$content .= '预订'.$arr['deal_tpye'].'：'.$arr['deal_name'].'\n\n'.$deal_attr.$arr['deal_tpye'].'券：'.$arr['coupon'].'\n\n';
		$content .= "商家名称：".$arr['store_name'].'\n\n商家电话：'.$arr['store_tel'].'\n\n'.'商家地址：'.$arr['store_address'].'\n\n用户已付款成功，请及时跟进订单';
		sendOrderWxMsg(C('cct_customer_service_wxid'),'跟进订单通知',$content,$url);*/
		//发送手机短信
		// $phoneMsg = "您好! 您在".$arr['store_name']."在线支付预定了（".$arr['deal_name']."）已订购成功，".$arr['deal_tpye']."券：".$arr['coupon']."。预约电话：".$arr['store_tel']."【诚车堂】";
		$phoneMsg = "您好! 您在".$arr['store_name']."在线支付预定了（".$arr['deal_name']."）已订购成功，".$arr['deal_tpye']."券：".$arr['coupon']."。预约电话：".$arr['store_tel'];
		// sendPhoneSms($arr['user_mobile'],$phoneMsg);
		send_sms($arr['user_mobile'],$phoneMsg);
	}else if ($tpye == 'store') {
		// $phoneMsg="您好! 客户".$arr['user_true_name']."在您店铺在线支付预定了（".$arr['deal_name']."）已购买成功,联系电话:".$arr['user_mobile']."。【诚车堂】";
		$phoneMsg="您好! 客户".$arr['user_true_name']."在您店铺在线支付预定了（".$arr['deal_name']."）已购买成功,联系电话:".$arr['user_mobile'];
		// sendPhoneSms($arr['store_mobile'],$phoneMsg);		
		send_sms($arr['store_mobile'],$phoneMsg);		
		$store_user_wx=M('user')->where(array('user_name'=>$arr['store_mobile']))->getField('wxid');
		if($store_user_wx){
			$content  = '提交时间：'.date('Y-m-d H:i',time()).'\n\n客户名称：'.$arr['user_true_name'].'\n\n客户电话：'.$arr['user_mobile'].'\n\n';
			$content .= '预订'.$arr['deal_tpye'].'：'.$arr['deal_name'].'\n\n'.$deal_attr.$arr['deal_tpye'];			
			sendOrderWxMsg($store_user_wx,'跟进订单通知',$content,'');
		}
	}
}

/**
 * 获取服务或商品属性
 * @param int|array  $d  	
 * @return array $deal_submeter	服务或商品属性信息
 */
function getDealSubmeter($did,$dsid)
{
	$did = intval($did);
	$dsid = intval($dsid);
	if (empty($did) || $did < 0 || empty($dsid) || $dsid < 0) {
		return false;
	}

	$deal_submeter = M('deal_submeter')->where(array('id'=>$dsid,'deal_id'=>$did))->find();
	if ($deal_submeter) {
		if($deal_submeter['begin_time']<time() && $deal_submeter['end_time']>time()){
			$deal_submeter['current_price'] = $deal_submeter['promote_price'];
		}else{
			$deal_submeter['current_price'] = $deal_submeter['price'];
		}
		return $deal_submeter;
	}else {
		return false;
	}
}

/**
 * 对多维数组根据某列进行排序
 * @param arr  $multi_array  	
 * @param str  $sort_key  
 * @param str  $sort  
 * @return array $multi_array	
 */
function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){ 
	if(is_array($multi_array)){ 
		foreach ($multi_array as $row_array){ 
			if(is_array($row_array)){ 
				$key_array[] = $row_array[$sort_key]; 
			}else{ 
			return false; 
			} 
		} 
	}else{ 
		return false; 
	} 
	array_multisort($key_array,$sort,$multi_array); 
	return $multi_array; 
}

/**
 * 验证访问IP的有效性
 * @param ip地址 $ip_str
 * @param 访问页面 $module
 * @param 时间间隔 $time_span
 * @param 数据ID $id
 */
function check_ipop_limit($ip_str,$module,$time_span=0,$id=0)
{
	$op = session($module."_".$id."_ip");
	if(empty($op))
	{
		$check['ip']	=	 get_client_ip();
		$check['time']	=	time();
		session($module."_".$id."_ip",$check);    		
		return true;  //不存在session时验证通过
	}
	else 
	{   
		$check['ip']	=	 get_client_ip();
		$check['time']	=	time();    
		$origin	=	session($module."_".$id."_ip");
		
		if($check['ip']==$origin['ip'])
		{
			if($check['time'] - $origin['time'] < $time_span)
			{
				return false;
			}
			else 
			{
				session($module."_".$id."_ip",$check);
				return true;  //不存在session时验证通过    				
			}
		}
		else 
		{
			session($module."_".$id."_ip",$check);
			return true;  //不存在session时验证通过
		}
	}
}

//获取jsdk票据
	function get_jsdk_ticket()
	{
		 
		//var_dump($this->get_apiticket());
		 $mem = new Memcache; 
		 $mem->connect('localhost', 11211) or die ("Could not connect"); 
		 $ticket = $mem->get('ticket');

		if($ticket){
			return $ticket;
		}else{
			$ch = curl_init();
			$timeout = 5;
			$token=getWxAccToken();//获取access_token
			curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$token&type=jsapi");
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$ticket = curl_exec($ch);
			$ticket=json_decode($ticket, true);
			$mem->set('ticket',$ticket['ticket'],0,6000);
			return $ticket['ticket'];	
		}
		
	}

	//生成随机字符串
	function createNonceStr($length = 16) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $str = "";
	    for ($i = 0; $i < $length; $i++) {
	      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	    }
	    return $str;
	}

    /**
     * 获取付款状态
     */
    function get_pay_status($status, $type, $payment){
        switch($status) {
            case 0:
                $msg = '未付款';
                break;
            case 1:
                if($type == 0 || $type == 1){
                    if($payment == 1 || $payment == 2)
                        $msg = '已付款';
                    else
                        $msg = '欠款挂账';
                }
                else{
                    $msg = '欠款挂账';
                }
                break;

            case 2:
                $msg = '已收款';
                break;

            default:
                $msg = '-';
                break;
        }

        return $msg;
    }

    /**
     * 获得订单状态
     **/
    function get_order_status_mes($status_num){

        switch ($status_num) {
            case 1:
                $status = '未打印';
                break;
            case 2:
                $status = '未拣货';
                break;
            case 3:
                $status = '未发货';
                break;
            case 4:
                $status = '已发货';
                break;
            case 5:
                $status = '已收货';
                break;
            default:
                $status = '-';
                break;
        }

        return $status;
    }

    /**
     * 采购支付方式
     **/
    function get_pay_type($means_of_payment,$type){
        if($type == 1){
            $pay_type = '(现金挂账结算)';
        }elseif ($type == 2) {
            $pay_type = '(月底挂账结算)';
        }elseif ($type == 3) {
            $pay_type = '(约定挂账结算)';
        }
        switch ($means_of_payment) {
            case 1:
                $msg = '支付宝';
                break;
            case 2:
                $msg = '微信';
                break;
            case 3:
                $msg = '现金支付'.$pay_type;
                break;
            case 4:
                $msg = '刷卡支付'.$pay_type;
                break;
            case 5:
                $msg = '转账支付'.$pay_type;
                break;
            case 6:
                $msg = '物流代收'.$pay_type;
                break;
            case 7:
                $msg = '余额支付'.$pay_type;
                break;
            default:
                $msg = '-';
                break;
        }

        return $msg;
    }

//----------------------------------------------------------------------

    /**
     * 获取指定供应商员工
     *
     * @param int $sid,	供应商ID
     * @param int $pid,	职务ID
     * 					1: 制单人
     * 					2: 打印人
     * 					3: 拣货人
     * 					4: 发货人
     * 					5: 收款人
     * 					6: 采购人
     * 					7: 调拔人
     * 					8: 盘点人
     * 					9: 退货人
     * 					10: 出库人
     * 					11: 区域经理
     * 					12: 客服顾问
     *                  13: 记账使用人
     *
     * @return array
     */
    function get_supplier_employee($sid, $pid=0){

        if(!empty($pid)){
            $which['ppe.post_id']    = $pid;
            $which['pe.supplier_id'] = $sid;
            $which['pe.is_del']      = 0;

            $employee = M('pms_post_employee')
                ->alias('as ppe')
                ->join('fw_pms_employee as pe ON pe.id=ppe.employee_id')
                ->field('ppe.employee_id as id,pe.name')
                ->where($which)->order('pe.supplier_id asc')->select();
        }

        if(empty($employee)){

            $where['supplier_id'] = $sid;
            $where['is_del'] = 0;
            $employee = M('pms_employee')->field('id,name')->where($where)->select();
        }

        return $employee;
    }

    /***
     * 获取指定供应商的仓库列表
     * @param int $sid 供应商ID
     * @param int $wid 仓库ID $wid==0 时 返回全部仓库
     * @return 仓库列表信息
     */
    function get_warehouse_list_info($sid, $wid=0){
        $which['is_del']      = 0;
        $which['supplier_id'] = $sid;
        if($wid > 0)
            $which['id'] = $wid;
        $warehouse_list = M('pms_warehouse')->where($which)->order('is_default desc')->select();

        return $warehouse_list;
    }

    /**
     * 获取支付方式Key-Value数组
     */
    function get_payments()
    {
        return array(
            1 => '支付宝',
            2 => '微信支付',
            3 => '现金支付',
            4 => '刷卡支付',
            5 => '转账支付',
            6 => '物流代收',
            7 => '余额支付'
        );
    }

//----------------------------------------------------------------------

    /**
     * 用户权限判断
     *
     * @param string	$module,		模块名称
     * @param string	$controller,	控制器名称
     * @param string	$action,		动作名称
     * @param mixed		$user,			需要判断的用户，默认为当前登录的用户
     *
     * @return bool
     */
    function user_can_access($module, $controller, $action='', $user=0){
        $login_info	= session('pms_supplier');

        if(empty($user)){
            if(!empty($login_info['id']))
                $user = $login_info['id'];
            else
                return false;
        }

        if(is_numeric($user))
              $user = M('pms_supplier_account')->where('id='.$user)->find();

        if(empty($user) || $user['is_del'])
            return false;

        if($user['is_authority'] > 0)
            return true;

        static $_access_list = array();

        // 获取所有符合用户角色的权限规则
        if(empty($_access_list[$user['id']])){
            $role = M('pms_role_account')->field('role_id')->where('account_id='.$user['id'])->select();
            $roles	= array();

            if(!empty($role)){
                foreach($role as $r){
                    $roles[] = $r['role_id'];
                }
            }

            if(!empty($roles)){
                $which['role_id'] = array('in',$roles);
                $access = M('pms_role_access')->field('controller,action')->where($which)->select();

                if(!empty($access)){
                    foreach($access as $a){
                        if(empty($_access_list[$user['id']][$a['controller']]))
                            $_access_list[$user['id']][$a['controller']] = array();

                        if(in_array($a['action'], $_access_list[$user['id']][$a['controller']]))
                            continue;

                        $_access_list[$user['id']][$a['controller']][] = $a['action'];
                    }
                }
            }
        }

        if(empty($_access_list[$user['id']]) || empty($_access_list[$user['id']][$controller]))
            return false;

        if($action !== '' && !in_array($action, $_access_list[$user['id']][$controller]))
            return false;

        return true;
    }

?>