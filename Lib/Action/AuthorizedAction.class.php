<?php
// 本类由系统自动生成，仅供测试用途
class AuthorizedAction extends Action {

	Public function _initialize(){
       // 初始化的时候检查用户权限
		$model=explode('/',__ACTION__);
		//var_dump($model);
		//isLogin(U($model[2].'/'.$model[3]));
		var_dump('1');
   }

	
}