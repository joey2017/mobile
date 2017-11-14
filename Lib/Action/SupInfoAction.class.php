<?php
class SupInfoAction extends SupBaseAction {

    /**
     * 权限白名单，白名单中的操作方法不受权限限制
     * 该名单主要用于一些特殊无涉及权限分配的方法
     *
     * @var array
     * @access protected
     */
    protected $accessAllowed = array('ajax_get_warehouse','msg_list');

	public function index(){
        $this->assign('title', '消息中心');
        $this->display();
	}
	
	public function ajax_get_warehouse(){
		//仓库列表
		$warehouse_list=M('pms_warehouse')
            ->field('id,warehouse_name')
            ->where('is_del=0 and supplier_id='.$_SESSION['pms_supplier']['supplier_id'])
            ->order('id desc')
            ->select();

		$warehouse['attr_name'] = '仓库';
		$warehouse['attr_val'] = array();
		foreach($warehouse_list as $k => $v){
			$warehouse['attr_val'][$warehouse_list[$k]['id']] = $v['warehouse_name'];
		}

		$warehouse = array($warehouse);

		$this->assign('warehouse',$warehouse);
		echo $html=$this->fetch('Purchase:ajax_get_warehouse');
	}

    public function msg_list()
    {
        $login_info  = session('pms_supplier');
        $page        = intval($_REQUEST['currentpage']);
        $limit       = ($page*8).",8";

        $which['pm.supplier_id'] = $login_info['supplier_id'];
        $which['pm.status']   = array('in','0,1');

        $msg_list = M('pms_message as pm');


        $msg_list = $msg_list->field('pm.*')
        ->where($which)
        ->order('pm.id desc')
        ->limit($limit)
        ->select();
        foreach ($msg_list as $key => &$value) {
            $value['time'] = intval((time()-$value['time'])/60).'分钟';
            if($value['time'] >= 60){
                $value['time'] = intval($value['time']/60).'小时';
            }
            if($value['time'] >= 60){
                $value['time'] = intval($value['time']/24).'天';
            }
        }

        $this->assign('msg_list', $msg_list);
        echo $html=$this->fetch();
    }

    public function detail()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if($id <= 0)
            $this->error('消息不存在');
        $msg = M('pms_message')->where('status != -1 and id = '.$id)->find();
        if(empty($msg))
            $this->error('消息不存在');

        $this->assign('msg',$msg);
        $this->display();
    }


}