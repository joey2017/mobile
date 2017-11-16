<?php
class SupBaseAction extends EmptyAction {

    /**
     * 权限白名单，白名单中的操作方法不受权限限制
     * 该名单主要用于一些特殊无涉及权限分配的方法
     *
     * @var array
     * @access protected
     */
    protected $accessAllowed = array();

    /**
     * 不需要登录及权限的方法列表
     * 此列表中的方法属于开放方法
     *
     * @array
     * @access protected
     */
    protected $accessExclude = array();

    /**
     * 初始化，检查登录状态
     */

    public function _initialize()
    {
        $this->check_login();
    }

    //检查登录
	private function check_login(){

        $is_logged = session('pms_supplier');

        // 登录判断
        if(!$is_logged && (empty($this->accessExclude) || !in_array(ACTION_NAME, $this->accessExclude))){
            header("Location:".U("SupLogin/login"));
        }

        // 权限判断，排除列表及白名单中的业务将不做权限限制
        if(
            (empty($this->accessExclude) || !in_array(ACTION_NAME, $this->accessExclude)) &&
            (empty($this->accessAllowed) || !in_array(ACTION_NAME, $this->accessAllowed)) &&
            !user_can_access('mobile', MODULE_NAME, ACTION_NAME)
        )
            $this->error('对不起，您没有权限执行该操作');
	}
	
}