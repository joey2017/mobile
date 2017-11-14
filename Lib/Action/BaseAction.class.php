<?php
// 本类由系统自动生成，仅供测试用途
class BaseAction extends Action {

	function __construct()
	{
		parent::__construct();	
		
		// if(session('uid')){
		// 	$this->assign('head_img',getUserAvatar(session('uid'),'small'));
		// }

		// $locationIpArr =  getIp('180.136.232.51');
		// $locaIp   = $locationIpArr['ip'];
		// $locaCity = $locationIpArr['country'];
		// var_dump($locationIpArr);

		if (!session('city_id')) {
			$_cityInfo = M('deal_city')->field('id,name,uname')->where(array('is_default'=>1))->find();
			session('city_id',intval($_cityInfo['id']));
			session('city_name',$_cityInfo['name']);
			session('city_uname',$_cityInfo['uname']);
			
		}else{
			if (cookie('deal_city') && cookie('deal_city')!=session('city_id')) {
				$_cityInfo = M('deal_city')->field('id,name,uname')->where(array('id'=>intval(cookie('deal_city')),'is_effect'=>1,'is_delete'=>0))->find();
				if ($_cityInfo) {
					session('city_id',intval($_cityInfo['id']));
					session('city_name',$_cityInfo['name']);
					session('city_uname',$_cityInfo['uname']);
				}
			}
		}
	}

	

}