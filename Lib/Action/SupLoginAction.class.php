<?php
require_once LIB_PATH.'Action/jiami.php';
class SupLoginAction extends EmptyAction {

    /**
     * 不需要登录及权限的方法列表
     * 此列表中的方法属于开放方法
     *
     * @array
     * @access protected
     */
    protected $accessExclude = array('login','ajax_login','login_out');
	
	public function login()
    {
        if(session('pms_supplier')){
            header("Location:".U("Supplier/index"));exit;
        }

        $this->display();
    }

	public function ajax_login(){
        $a_name     = I('post.username');
        $a_password = I('post.password');

		if(!$a_name){
			$this->ajaxReturn(0,'用户名不能为空!',0);
		}
		if(!$a_password){
			$this->ajaxReturn(0,'密码不能为空!',0);
		}

		$pms_supplier=M("pms_supplier_account as psa")
            ->field('fps.name,psa.id,psa.supplier_id,psa.img,psa.a_name,psa.a_password,psa.is_authority')
            ->join("fw_pms_supplier as fps on fps.id=psa.supplier_id")
            ->where(array('a_name'=>$a_name,'psa.is_del'=>0))
            ->find();
		if($pms_supplier['a_password']==md5($a_password)){
			if(!M('agent_qrcode')->where('type=1 and shop_id='.intval($pms_supplier['supplier_id']))->find()){
				$this->ajaxReturn(0,'您还不是合伙人!',0);
			}
			if(intval($_REQUEST['remember'])==1)
			{					
				cookie('a_name',trim($a_name),3600*24*30);
				$key ="17cct_com_supplier_login_key";					
				cookie('a_password',trim(passport_encrypt($a_password,$key)),3600*24*30);
			}
			
			session('pms_supplier',$pms_supplier);
            $d['login_time'] = time();
            $d['login_ip']   = get_client_ip();
			$r=M("pms_supplier_account")->where(array('id'=>intval($pms_supplier['id'])))->save($d);
			
			$this->ajaxReturn(0,U('Supplier/index'),1);
		}else{
			$this->ajaxReturn(0,'用户名或密码错误!',0);
		}		
	
	}

	public function login_out(){
		session('pms_supplier',null);
		$this->redirect("SupLogin/login","退出成功");
	}

}