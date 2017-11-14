<?php
class SupOrderAction extends SupBaseAction
{
    /**
     * 支付方式 
     */
    private $payments = array(
        7 => '余额支付', 1 => '支付宝',    2 => '微信支付', 3 => '现金支付',
        4 => '刷卡支付', 5 => '转账支付', 6 => '物流代收'
    );
    
    /**
     * 订单状态 
     */
    private $status = array(
        1 => '未打印',2 => '未拣货',3 => '未发货', 4 => '已发货', 5 => '已收货'
    );

    /**
     * 订单列表
     */
    public function index(){
        //员工列表[区域经理]
        $login_info  = session('pms_supplier');
        $employee_list = get_supplier_employee($login_info['supplier_id'], 11);
        $this->assign('employee_list', $employee_list);
        $this->display();
    }

    public function navig(){
        //员工列表[区域经理]
        $login_info  = session('pms_supplier');
        $employee_list = get_supplier_employee($login_info['supplier_id'], 11);
        $this->assign('employee_list', $employee_list);
        $this->assign('title', '交易/客户');
        $this->display();
    }


    public function order_list()
    {
        $login_info  = session('pms_supplier');
        $keyword     = isset($_GET['keyword']) ? htmlspecialchars(strip_tags($_GET['keyword']), ENT_QUOTES, 'UTF-8') : '';
        $attr        = isset($_GET['attr_value']) ? trim($_GET['attr_value']) : '';
        $sort        = intval($_GET['sort']);
        $page        = intval($_GET['currentpage']);
        $limit       = ($page*8).",8";

        $which['po.supplier_id'] = $login_info['supplier_id'];
        $which['po.is_refund']   = 0;
        $which['po.system']      = 0;

        $which['po.is_del'] = 0;


        // 关键字搜索
        if ($keyword !== '') {
            $where['po.order_sn']      = array('like', '%'.$keyword.'%');
            // $where['po.receive_user']  = array('like', '%'.$keyword.'%');
            $where['po.location_name'] = array('like', '%'.$keyword.'%');
            $where['_logic']        = 'or';
            $which['_complex']      = $where;
        }

        $order_list = M('pms_order as po');
        //根据条件筛选
        if($attr){
            $attr = explode(',', $attr);
            //6:邓禄普,1:125,1:135,1:275,2:20,2:40,2:55,3:13,11:70,11:119,7:M,95:660,95:668
            foreach ($attr as $k => $v) {
                $attr[$k] = explode(':',$v);
            }

            foreach($attr as $a){
                //根据客户顾问筛选
                if($a[0] == 'employee_id'){
                    $which['pl.'.$a[0]] = array('in',$a[1]);
                    $which['pl.is_del']      = 0;
                    $which['pl.supplier_id'] = $login_info['supplier_id'];
                    $order_list->join('fw_pms_location as pl ON pl.location_id=po.location_id');
                }else{
                    $which['po.'.$a[0]] = array('in',$a[1]);
                }

            }

        }

        //按排序
        if(in_array($sort, array(0,1,2,3,4))){
            switch ($sort) {
                case 0:
                    $order_list->order('po.id desc');
                    break;
                case 1:
                    $order_list->order('po.total_price asc');
                    break;
                case 2:
                    $order_list->order('po.total_price desc');
                    break;
                case 3:
                    $order_list->order('po.create_time desc');
                    break;
                case 4:
                    $order_list->order('po.create_time asc');
                    break;
            }
        }

        $order_list = $order_list->field('po.id,po.order_sn,po.total_price,po.type,po.status,po.pay_status,po.means_of_payment,po.location_name,po.pay_type,po.create_time')
        ->where($which)->limit($limit)
        ->select();

        if ($order_list) {
            foreach ($order_list as $k => $v) {
                //付款状态
                $order_list[$k]['pay_status_msg'] = get_pay_status($v['pay_status'], $v['type'], $v['means_of_payment']);
                //订单状态
                $order_list[$k]['status_msg'] = get_order_status_mes($v['status']);
                //支付方式
                $order_list[$k]['means_of_payment_msg'] = get_pay_type($v['means_of_payment'], $v['pay_type']);
            }
            $this->assign('order_list', $order_list);
            echo $html=$this->fetch();
        }else{
            echo '';
        }
    }

    public function detail(){
        $id          = intval($_REQUEST['id']);
        $login_info  = session('pms_supplier');
        $location_id = $login_info['supplier_id'];

        $goods = M('pms_order_item as poi')
            ->field('poi.goods_name,poi.goods_id,poi.sell_price,poi.num,poi.thumbnail,poi.is_gift,pg.supplier_id,pg.unit,fps.name,fps.mobile,fpo.*')
            ->join('fw_pms_goods as pg on pg.id=poi.goods_id')
            ->join('fw_pms_supplier as fps on fps.id=pg.supplier_id')
            ->join('fw_pms_order as fpo on fpo.id=poi.order_id')
            ->where('poi.order_id='.$id.' and fpo.system=0')
            ->select();
        if(!$goods){
            $this->error('无此订单信息',U('SupOrder/index'),3);
        }
        foreach ($goods as $k => $v) {
            $goods_list[$v['supplier_id']]['supplier_name']=$v['name'];
            $goods_list[$v['supplier_id']]['mobile']=$v['mobile'];
            $goods_list[$v['supplier_id']]['goods'][]=$v;
        }
        $info['order_sn']         = $v['order_sn'];
        $info['create_time']      = $v['create_time'];
        $info['pay_time']         = $v['pay_time'];
        $info['status']           = $v['status'];
        $info['total_price']      = $v['total_price'];
        $info['discount_price']   = $v['discount_price'];
        $info['remark']           = $v['remark'];
        $info['address']          = $v['address'];
        $info['receive_user']     = $v['receive_user'];
        $info['means_of_payment'] = $v['means_of_payment'];
        $info['location_name']    = $v['location_name'];
        $info['receive_tel']      = $v['receive_tel'];
        if($v['pay_time'])
            $info['pay_type'] = get_pay_type($v['means_of_payment'],$v['type']);

        $info['order_status'] = get_order_status_mes($info['status']);

        $this->assign('title','诚车堂-订货管理小助手！');
        $this->assign('goods_list',$goods_list);
        $this->assign('info',$info);
        $this->display();
    }

    //获取门店余额支付账户
    public function get_pay_account()
    {
        $location_id = intval($_POST['location_id']);
        $login_info  = session('pms_supplier');
        if(intval($location_id) > 0){
            $account = M('pms_recharge')
            ->field('id,account,balance')
            ->where(array('location_id'=>$location_id,'is_del'=>0,'supplier_id'=>$login_info['supplier_id']))
            ->select();
            if(!empty($account))
                $this->ajaxReturn(array('status'=>1,'info'=>$account));
            else
                $this->ajaxReturn(array('status'=>0));
        }else
            $this->ajaxReturn(array('status'=>0));

    }


    /**
    * 代客下单
    */
    public function store_order(){
        $quick_order = I('post.quick_order');
        $login_info  = session('pms_supplier');
        $class_id    = isset($_REQUEST['class_id']) ? intval($_REQUEST['class_id']) : 2;//默认轮胎分类id
        $location = M('pms_location')
            ->field('id,location_id,location_name,contact,mobile,address')
            ->where(array('is_del'=>0,'supplier_id'=>$login_info['supplier_id']))
            ->order('id desc')
            ->limit(5)
            ->select();

        //员工列表
        $employee_list = get_supplier_employee($login_info['supplier_id'],1);

        //物流公司
        $express_list = M('pms_express')
            ->field('id,name')
            ->where(array('supplier_id'=>$login_info['supplier_id']))
            ->select();


        // 二级分类列表
        $class_list=M('pms_class')->where('is_del=0')->order('sort asc')->select();
        foreach ($class_list as $k => $v) {
            if($v['pid']==0){
                $cl[$v['id']]['c_name']=$v['class_name'];
            }else{
                $cl[$v['pid']]['item'][]=$v;
            }

            if($v['id']==$class_id){
                $class_name=$v['class_name'];
            }
        }

        //门店列表
        $location = M('pms_location')->field('id,location_id,location_name,contact,mobile,address')
        ->where(array('supplier_id'=>$login_info['supplier_id'],'is_del'=>0,'system'=>0))
        ->order('id desc')
        ->limit(10)
        ->select();

        //银行卡信息
        $bank_info = M('pms_bank_account')
            ->where(array('supplier_id' => intval($login_info['supplier_id'])))
            ->select();

        //仓库列表
        $warehouse_list = get_warehouse_list_info($login_info['supplier_id']);

        //商品属性
        $attr_list=M('pms_attr')->field('id,attr_name,attr_val')->where('class_id='.$class_id)->order('sort desc')->select();

        foreach ($attr_list as $k => $v) {
            $attr_list[$k]['attr_val'] = explode(',', $v['attr_val']);
        }

        $this->assign("location",$location);
        $this->assign("class_list",$cl);
        $this->assign("attr_list",$attr_list);
        $this->assign("class_id",$class_id);
        $this->assign('class_name',$class_name);
        $this->assign('location',$location);

        $this->assign("employee_list",$employee_list);
        $this->assign("express_list",$express_list);
        $this->assign("warehouse_list",$warehouse_list);
        $this->assign("warehouse_count",count($warehouse_list));
        $this->assign("bank_info",$bank_info);
        $this->assign("quick_order",$quick_order);
        $this->display();

    }

    /**
     * 代客下单保存
     * 1.快速开单(下单->结算)(快速开单时选择出库仓库,下单完成后订单呈已发货状态)
     * 2.管控开单(下单->打印->拣货->发货->结算)
     **/
    public function store_order_add()
    {
        $login_info       = session('pms_supplier');
        $pay_type         = intval($_POST['pay_type']);
        $means_of_payment = intval($_POST['means_of_payment']);
        $make_user_id     = $_POST['make_user_id'];
        $make_user_name   = $_POST['make_user_name'];
        $act_id           = intval($_POST['act_id']);
        $coupon_id        = intval($_POST['coupon_id']);
        $location_id      = intval($_POST['location_id']);
        $location_name    = $_POST['location_name'];
        $num_old          = $_POST['num'];
        $gid_old          = $_POST['gid'];
        $price_old        = $_POST['price'];
        $total_price      = 0;
        $total_num        = 0;
        $total_costs      = 0;
        //赠品
        $num_old_gift     = $_POST['num_gift'];
        $gid_old_gift     = $_POST['gid_gift'];

        if (!$_POST['location_id'] || !$_POST['receive_user'] || !$_POST['receive_tel'] || !$_POST['receive_address'] || !$_POST['gid'] || !$_POST['price'] || !$_POST['num'])
            $this->ajaxReturn(array('status' => 0, 'msg' => '请完整填写订单信息'));

        if($make_user_id == 0)
            $this->ajaxReturn(array('status' => 0, 'msg' => '请选择制单人'));

        $gid   = array();
        $price = array();
        $num   = array();
        foreach ($gid_old as $k => $v) {
            $gid[$v]                        = $v;
            $price[$v]                      = $price_old[$k];
            $num[$v]                        = $num[$v] + $num_old[$k];

            if(isset($warehouse)){
                if(isset($goods_warehouse_num[$v][$warehouse[$k]]))
                    $this->ajaxReturn(array('status' => 0, 'msg' => '同一个商品不能选择相同的仓库'));
                else
                    $goods_warehouse_num[$v][$warehouse[$k]] = $num_old[$k];
            }
        }

        foreach ($price as $k => $v) {
            $total_price   += ($v * $num[$k]);
            $total_num     += $num[$k];
            $new_price[$k] = $v * $num[$k];//单位总价
        }

        if($total_price == 0&&!user_can_access('SupOrder','store_order_add_zero')){
            $this->ajaxReturn(array('status' => 0, 'msg' => '您没有零元开单的权限'));
        }

        foreach ($num_old_gift as $k => $v) {
            $total_num    += $num_old_gift[$k];
        }

        //判断是否能参与活动、使用优惠券。并返回一个二维数组
        $goods_data[$login_info['supplier_id']]['goods_id'] = $gid;
        $goods_data[$login_info['supplier_id']]['price']    = $new_price;
        $act_data = $this->use_act_coupon($act_id, $coupon_id, $goods_data, $location_id);

        //新增订单
        $order_data = array(
            'order_sn'             => 'CG' . date('Ymdhis', time()) . rand(10, 99),
            'location_id'          => $location_id,
            'location_name'        => $location_name,
            'receive_user'         => trim($_POST['receive_user']),
            'receive_tel'          => trim($_POST['receive_tel']),
            'address'              => trim($_POST['receive_address']),
            'create_time'          => time(),
            'supplier_id'          => $login_info['supplier_id'],
            'pay_status'           => 1,
            'pay_time'             => time(),
            'means_of_payment'     => $means_of_payment,
            'status'               => $quick_order == 1 ? 4 : 1,
            'total_original_price' => $act_data[$login_info['supplier_id']]['total_original_price'],
            'total_price'          => $act_data[$login_info['supplier_id']]['total_price'],
            'act_id'               => $act_data[$login_info['supplier_id']]['act_id'],
            'location_coupon_id'   => $act_data[$login_info['supplier_id']]['location_coupon_id'],
            'discount_price'       => $act_data[$login_info['supplier_id']]['discount_price'],
            'is_del'               => 0,
            'remark'               => '代客下单',
            'total_num'            => $total_num,
            'type'                 => 2,
            'distribution_type'    => intval($_POST['distribution_type']),
            'express'              => trim($_POST['express']),
            'distribution_remark'  => trim($_POST['distribution_remark']),
            'pay_type'             => $pay_type,
            'pay_remark'           => trim($_POST['pay_remark']),
            'make_user_id'         => $make_user_id,
            'make_user_name'       => $make_user_name,
            'make_remark'          => trim($_POST['make_remark'])
        );

        if ($means_of_payment == 7) {
            //账户余额是否充足(余额支付)
            $account_id = intval($_POST['account_id']);
            $result = M('pms_recharge')
            ->field('balance,account')
            ->where(array('id' => $account_id, 'is_del' => 0, 'location_id' => $order_data['location_id'], 'supplier_id' => $login_info['supplier_id']))
            ->find();
            if (!$result || ($result && $result['balance'] < $order_data['total_price'])) {
                $this->ajaxReturn(array('status' => 0, 'msg' => '余额不足，请先充值或选择其他支付方式'));
            } else {
                $res = M('pms_recharge')->where(array('id' => $account_id))->setDec('balance',$order_data['total_price']);
                if (!$res) {
                    $this->ajaxReturn(array('status' => 0, 'msg' => '余额扣减失败'));
                }
                $order_data['pay_status']  = 2;
                $order_data['paid_amount'] = $order_data['total_price'];
            }

        }

        $order_id = M('pms_order')->add($order_data);

        if ($order_id) {

            //添加一条结算记录
            if ($means_of_payment == 7) {
                $info = array(
                    'order_id'              => $order_id,
                    'price'                 => $order_data['total_price'],
                    'means_of_payment'      => $order_data['means_of_payment'],
                    'pay_time'              => time(),
                    'settlement_staff_name' => '',
                    'settlement_staff_ids'  => 0,
                    'login_user_id'         => $login_info['id'],
                    'pay_detail'            => '',
                    'type'                  => 2,
                    'trade_id'              => 0,
                    'recharge_id'           => $account_id,
                    'recharge_account'      => $result['account']
                );
                M('pms_order_deal')->add($info);
            }

            // 新增订单详情
            $goods_list = M('pms_goods as pg')->field('pg.id, pg.goods_name, pg.costs, pg.thumbnail, pga.attr_name_val')
            ->where(array('pg.id' =>array('in',$gid),'pg.supplier_id' => $login_info['supplier_id']))
            ->join('fw_pms_goods_attr as pga ON pga.goods_id=pg.id')
            ->select();

            if (!$goods_list)
                $this->ajaxReturn(array('status' => 0, 'msg' => '商品不存在'));

            foreach ($gid as $k => $v) {
                $goods_add_list[$v]['price'] = $price[$k];
                $goods_add_list[$v]['num']   = $num[$k];
            }

            foreach ($goods_list as $k => $v) {
                $goods_list[$k]['price'] = $goods_add_list[$v['id']]['price'];
                $goods_list[$k]['num']   = $goods_add_list[$v['id']]['num'];
                $total_costs             += ($v['costs'] * $goods_add_list[$v['id']]['num']);
            }

            if ($total_costs > 0) {
                // 更新订单成本
                $costs_result = M('pms_order')->where(array('id' => $order_id, 'supplier_id' => $login_info['supplier_id']))->save(array('costs' => $total_costs));
                if (!$costs_result)
                    $this->ajaxReturn(array('status' => 0, 'msg' => '更新订单成本失败'));
            }

            // 订单详情二维数组
            foreach ($goods_list as $k => $v) {
                $order_item_data[$k]['order_id']     = $order_id;
                $order_item_data[$k]['goods_name']   = $v['goods_name'];
                $order_item_data[$k]['goods_id']     = $v['id'];
                $order_item_data[$k]['sell_price']   = $v['price'];
                $order_item_data[$k]['num']          = $v['num'];
                $order_item_data[$k]['erp_goods_id'] = 0;
                $order_item_data[$k]['thumbnail']    = isset($v['thumbnail']) ? $v['thumbnail'] : '';
                $order_item_data[$k]['attr_val']     = isset($v['attr_name_val']) ? $v['attr_name_val'] : '';
                $order_item_data[$k]['is_gift']      = 0;
            }

            foreach ($order_item_data as $item) {
                $item_id = M('pms_order_item')->add($item);
            }

            // 新增合并订单
            $merge_order_data = array(
                'order_sn'         => 'JY' . date('Ymdhis', time()) . rand(10, 99),
                'order_ids'        => $order_id,
                'receive_user'     => trim($_POST['receive_user']),
                'receive_tel'      => trim($_POST['receive_tel']),
                'location_id'      => $location_id,
                'create_time'      => time(),
                'total_price'      => $act_data[$login_info['supplier_id']]['total_price'],
                'pay_status'       => 1,
                'pay_type'         => $pay_type,
                'pay_time'         => time(),
                'means_of_payment' => $means_of_payment,
                'is_del'           => 0,
                'type'             => 2
            );

            if ($means_of_payment == 7) {
                $merge_order_data['pay_status'] = 2;
            }

            $result = M('pms_merge_order')->add($merge_order_data);

            if(!empty($gid_old_gift)){

                //赠品
                $gid_gift   = array();
                $num_gift   = array();
                foreach ($gid_old_gift as $k => $v) {
                    $gid_gift[$v]                        = $v;
                    $num_gift[$v]                        = $num_gift[$v] + $num_old_gift[$k];

                    if(isset($warehouse)) {
                        if (isset($goods_warehouse_num_gift[$v][$warehouse_gift[$k]]))
                            $this->ajaxReturn(array('status' => 0, 'msg' => '同一个商品不能选择相同的仓库'));
                        else
                            $goods_warehouse_num_gift[$v][$warehouse_gift[$k]] = $num_old_gift[$k];
                    }
                }

                // 赠品商品详情
                $goods_list_gift = M('pms_goods as pg')
                ->field('pg.id, pg.goods_name, pg.costs, pg.thumbnail, pga.attr_name_val')
                ->where(array(
                        'pg.id'          => array('in',$gid_gift),
                        'pg.supplier_id' => $login_info['supplier_id']
                    ))
                ->join('fw_pms_goods_attr as pga ON pga.goods_id=pg.id')
                ->select();

                // 赠品
                if (!$goods_list_gift)
                    $this->ajaxReturn(array('status' => 0, 'msg' => '赠品不存在'));

                // 赠品
                foreach ($gid_gift as $k => $v) {
                    $goods_add_list_gift[$v]['num']   = $num_gift[$k];
                }

                // 赠品
                foreach ($goods_list_gift as $k => $v) {
                    $goods_list_gift[$k]['num']   = $goods_add_list_gift[$v['id']]['num'];
                }

                // 赠品详情二维数组
                foreach ($goods_list_gift as $k => $v) {
                    $order_item_data_gift[$k]['order_id']     = $order_id;
                    $order_item_data_gift[$k]['goods_name']   = $v['goods_name'];
                    $order_item_data_gift[$k]['goods_id']     = $v['id'];
                    $order_item_data_gift[$k]['sell_price']   = 0;
                    $order_item_data_gift[$k]['num']          = $v['num'];
                    $order_item_data_gift[$k]['erp_goods_id'] = 0;
                    $order_item_data_gift[$k]['thumbnail']    = $v['thumbnail'];
                    $order_item_data_gift[$k]['attr_val']     = $v['attr_name_val'];
                    //赠品字段
                    $order_item_data_gift[$k]['is_gift']     = 1;

                }

                //赠品
                foreach ($order_item_data_gift as $item) {
                    $item_id = M('pms_order_item')->add($item);
                }
            }

            if ($result) {
                //给门店发送微信消息
                $wxid_list     = $this->get_wxid_list($location_id);
                $supplier_info = $this->get_supplier_info();
                $employee_info = $this->get_employee_info($location_id);
                if ($wxid_list) {
                    foreach ($wxid_list as $k => $v) {
                        $this->send_wx_msg($v['open_id'], 1, $supplier_info['name'], $order_data['order_sn'], $order_id, $supplier_info['mobile'], $employee_info['name'], $employee_info['mobile']);
                    }
                }

                //给供应商发送消息
                $supplier_wxid_list = $this->get_supplier_wxid_list();
                if ($supplier_wxid_list) {
                    foreach ($supplier_wxid_list as $k => $v) {
                        $this->send_supplier_wx_msg($v['open_id'], $order_data['order_sn'], $location_name, $supplier_info['name']);
                    }
                }

                $this->ajaxReturn(array('status' => 1, 'msg' => '代客下单成功', 'quick_order' => $quick_order));
            } else {
                $this->ajaxReturn(array('status' => 0, 'msg' => '代客下单失败'));
            }
        } else {
            $this->ajaxReturn(array('status' => 0, 'msg' => '代客下单失败'));
        }

    }

    /**
    * 获得下单门店wxid列表
    **/
    private function get_wxid_list($store_id){
        $wxid_list = M('pms_weixin')
        ->field('open_id')
        ->where(array('relation_id'=>$store_id,'type'=>1))
        ->select();
        return $wxid_list;
    }

    /**
    * 获得供应商wxid列表
    **/
    private function get_supplier_wxid_list(){
        $login_info = session('pms_supplier');
        $wxid_list = M('pms_weixin')
        ->field('open_id')
        ->where(array('relation_id'=>$login_info['supplier_id'],'type'=>2))
        ->select();

        return $wxid_list;
    }

    /**
    * 获得供应商信息
    **/
    private function get_supplier_info(){
        $login_info = session('pms_supplier');
        $supplier_info = M('pms_supplier')->where(
            array(
                'is_del' => 0,
                'id'     => $login_info['supplier_id']
            )
        )->select();
        return $supplier_info;
    }

    /**
    * 获得区域经理信息
    **/
    private function get_employee_info($location_id){

        $login_info = session('pms_supplier');

        //区域经理
        $employee_info = M('pms_location as pl')->field('pe.name,pe.mobile')
        ->where(
            array(
                'pl.supplier_id'    =>$login_info['supplier_id'],
                'pl.location_id'    =>$location_id,
                'pl.is_del'         =>0,
                'pe.supplier_id'    =>$login_info['supplier_id']
            ))
        ->join('fw_pms_employee as pe ON pe.id=pl.employee_id')
        ->find();

        return $employee_info;
    }

    /**
    * 发送采购订单状态微信消息
    **/
    private function send_wx_msg($wxid,$type,$supplier_name,$order_sn,$order_id,$supplier_tel,$employee_name,$employee_tel){

        if($type ==1){
            $first = '亲，"'.$supplier_name.'"代您下了一条新订单，请您打开手机登录或者电脑登录账号进行【确认订单】。';
            $status = '下单成功';
        }elseif ($type == 2) {
            $first = '亲，您的订单正在打印中，请知悉！';
            $status = '打印中';
        }elseif ($type == 3) {
            $first = '亲，您的订单正在拣货中，请知悉！';
            $status = '拣货中';
        }elseif ($type == 4) {
            $first = '亲，您的订单正在配送中，收到货请打开手机进行【确认收货】！';
            $status = '配送中';
        }elseif ($type == 5) {
            $first = "亲，您的订单已结算完成，感谢您对我们的信任和支持！\n'".$supplier_name."'欢迎您再次惠顾，平台里还有其它商品，欢迎选购和垂询！\n顺祝您生意兴隆，鸡年吉祥！";
            $status = '已结算';
        }elseif ($type == 6) {
            $first = '亲，"'.$supplier_name.'"代您下了一条欠款订单。';
            $status = '下单成功';
        }

        if($employee_name && $employee_tel){
            $employee_msg = '或区域经理'.$employee_name.':'.$employee_tel;
        }
        $remark = "如有问题请致电'".$supplier_name."'客服电话：".$supplier_tel.$employee_msg."，我们将第一时间为您服务。\n【车堂盛世】诚车堂-订货管理小助手！";

        $json=array("touser"=>$wxid,
                    "template_id"=>"P4l0GDvpYTR_DmSKflGmYehFC-w8VKxMCRTk8ktvE7M",
                    "url"=>"http://m.17cct.com/index.php/Biz/purchase_detail.html?id=".$order_id,
                    "topcolor"=>"#FF0000",
                    "data"=>array('first'=>array('value'=>$first),
                                'keyword1'=>array('value'=>$order_sn),
                                'keyword2'=>array('value'=>$status),
                                'remark'=>array('value'=>$remark)
                        )
            );
        $this->send_template_info($json);

    }

    /**
    * 获取诚车堂商户版access_token
    **/
    private function get_sj_acc_token()
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxb09359ac1d3f2267&secret=7e161c7930c9de1f3213dd13d6bb7a9c");
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $access_token = curl_exec($ch);
        $access_token=json_decode($access_token, true); 
        return $access_token['access_token'];   
    }

    /**
    * 发送模板消息
    **/
    private function send_template_info_dirc($json){

        $access_token  = $this->get_sj_acc_token();
        $get_token_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;         
        $ch  = curl_init() ;
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,urldecode(json_encode(($json))));
        curl_setopt($ch, CURLOPT_URL,$get_token_url);           
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        $result = curl_exec($ch) ;
        curl_close($ch);

    }


    /**
     * 给门店发送核销微信消息
     **/
    private function send_chargeoff_wx_msg($wxid,$money,$order){
        $first = '"'.$order['supplier_name'].'"为"'.$order['location_name'].'"核销一笔订单，本次核销金额为'.$money.'元。';

        if($order['employee_name'] && $order['employee_tel']){
            $employee_msg = '或区域经理'.$order['employee_name'].':'.$order['employee_tel'];
        }
        $detail = '单据日期'.date('Y-m-d',$order['create_time']).'，单据金额'.price($order['total_price']).'元，已核销金额'.price($order['paid_amount']).'元，未核销金额'.price($order['unpay']).'元。';
        $remark = "如有问题请致电'".$order['supplier_name']."'客服电话：".$order['supplier_tel'].$employee_msg."，我们将第一时间为您服务。\n【车堂盛世】诚车堂-订货管理小助手！";
        $json=array("touser"=>$wxid,
            "template_id"=>"qc6787P6B7zEtuf4cD3vYYBc8gB0-eiSdMuMIRSyQ2w",
            "url"=>"http://m.17cct.com/index.php/Biz/purchase_detail.html?id=".$order['id'],
            "topcolor"=>"#FF0000",
            "data"=>array('first'=>array('value'=>$first),
                'keyword1'=>array('value'=>$order['order_sn']),
                'keyword2'=>array('value'=>$detail),
                'remark'=>array('value'=>$remark)
            )
        );

        $this->send_template_info_dirc($json);
    }
    
    /**
    * 给供应商发送微信消息
    **/
    private function send_supplier_wx_msg($wxid,$order_sn,$location_name,$supplier_name){

        $first = '"'.$supplier_name.'"代"'.$location_name.'"下了一条新订单，请您及时跟进。';

        $json=array("touser"=>$wxid,
                    "template_id"=>"P4l0GDvpYTR_DmSKflGmYehFC-w8VKxMCRTk8ktvE7M",
                    "topcolor"=>"#FF0000",
                    "data"=>array('first'=>array('value'=>$first),
                                'keyword1'=>array('value'=>$order_sn),
                                'keyword2'=>array('value'=>'代客下单'),
                                'remark'=>array('value'=>'【车堂盛世】诚车堂-订货管理小助手！')
                        )
            );

        $this->send_template_info($json);

    }

    /**
    * 发送模板消息
    **/
    private function send_template_info($json){
        $add = M('pms_wxmsg_queue')->add(
            array(
                'url'       => 'https://api.weixin.qq.com/cgi-bin/message/template/send',
                'data'      => urldecode(json_encode(($json))),
                'add_time'  => time(),
                'status'    => 0
        ));
        
        return $add;
    }

    public function select_pay_way()
    {
        $payType = intval($_POST['val']);
        $html  = '<option value="3">现金支付</option>';
        $html .= '<option value="4">刷卡支付</option>';
        $html .= '<option value="5">转账支付</option>';
        switch ($payType) {
            case '1':
                $html .= '<option value="6">物流代收</option>';
                break;

            case '2':
                break;

            case '3':
                break;
            
            case '4':
                $html = '<option value="7">余额支付</option>';
                break;
            
            default:
                break;
        }
        echo $html;

    }

    /**
    * 代客下单时，获得门店能参与的供应商活动列表
    **/
    public function get_act_list(){
        //获得数组
        $goods_ids  = $_POST['goods_ids'];
        $prices     = $_POST['prices'];
        $nums       = $_POST['nums'];
        $login_info = session('pms_supplier');

        if(count($goods_ids) == 0 || count($prices) == 0 || count($nums) == 0 || count($goods_ids) != count($prices)){
            $this->ajaxReturn(array('status'=>0));
        }
        
        foreach ($prices as $k => $v) {
            $new_prices[$k] = $v * $nums[$k]; 
        }

        $act_list = $this->get_activity($goods_ids,$new_prices,$login_info['supplier_id']);

        if($act_list){
        
            $str = '<option value="0">选择活动</option>';
            foreach ($act_list as $k => $v) {
                $str .= '<option value="'.$v['id'].'_'.$v['act_store_price'].'_'.$v['discount_money'].'_'.$v['act_type'].'">'.$v['act_name'].'</option>';       
            }

            $this->ajaxReturn(array('status'=>1,'str'=>$str));
        }else{
            $this->ajaxReturn(array('status'=>0));
        }

    }

    /**
    * 代客下单时，获得门店能使用的优惠券列表
    **/
    public function get_coupon_list(){
        //获得数组
        $goods_ids   = $_POST['goods_ids'];
        $prices      = $_POST['prices'];
        $nums        = $_POST['nums'];
        $location_id = intval($_POST['location_id']);
        $login_info  = session('pms_supplier');

        if(count($goods_ids) == 0 || count($prices) == 0 || count($nums) == 0 || count($goods_ids) != count($prices)){
            $this->ajaxReturn(array('status'=>0));
        }

        foreach ($prices as $k => $v) {
            $new_prices[$k] = $v * $nums[$k]; 
        }

        $coupon_list = $this->get_coupon($goods_ids,$new_prices,$login_info['supplier_id'],$location_id);

        if($coupon_list){
        
            $str = '<option value="0">选择优惠券</option>';
            foreach ($coupon_list as $k => $v) {
                $str .= '<option value="'.$v['id'].'_'.$v['discount_money'].'">'.$v['coupon_name'].'</option>';
            }

            $this->ajaxReturn(array('status'=>1,'str'=>$str));
        }else{
            $this->ajaxReturn(array('status'=>0));
        }

    }


    /**
    * 获得供应商活动
    * @param    $goods_id       购买的商品id数组(按供应商分)
    * @param    $price          购买的商品售价数组(按供应商分)
    * @param    $supplier_id    供应商id
    * @return   $act_rule_list  可使用的供应商活动规则列表
    */
    private function get_activity($goods_id,$price,$supplier_id){
        
        //查找符合的有效期内的供应商活动
        $act_list = M('pms_activity')
        ->field('id,act_name,goods_ids,act_type')
        ->where('supplier_id='.$supplier_id.' and is_del=0 and (unix_timestamp() between start_time and end_time)')
        ->select();

        if($act_list){
            foreach ($act_list as $k => $v) {

                foreach ($goods_id as $g_k => $g_v) {
                    if($v['goods_ids'] == 0){//所有商品
                        $act[$v['id']]['price'] += $price[$g_k];
                        $act[$v['id']]['act_type'] = $v['act_type'];
                        $act[$v['id']]['is_all_val'] = '全部商品';
                    }else{//部分商品
                        $had_goods_id = explode(',', $v['goods_ids']);
                        if(in_array($g_v, $had_goods_id)){
                            $act[$v['id']]['price'] += $price[$g_k];
                            $act[$v['id']]['act_type'] = $v['act_type'];
                            $act[$v['id']]['is_all_val'] = '部分商品';
                        }
                    }
                }

            }

            if($act){
                foreach ($act as $k => $v) {
                    $act_rule = $this->get_act_rule($k,$v['price'],$v['act_type'],$v['is_all_val']);
                    if($act_rule){
                        foreach ($act_rule as $a_k => $a_v) {
                            $act_rule_list[] = $a_v;
                        }
                    }
                }
            }
            
        }

        return $act_rule_list;
            
    }

    /**
    * 获得供应商活动规则列表（满减和满折活动，购物赠券活动客户自己下单时才参加）
    * @param    $act_id             能使用的活动id
    * @param    $act_store_price    参与活动的金额
    * @param    $act_type           活动类型，1为满就减，2为满就折
    * @param    $is_all_val         全部商品/部分商品
    * @return   $act_rule_list      可使用的供应商活动规则列表
    */
    private function get_act_rule($act_id,$act_store_price,$act_type,$is_all_val){

        //金额满足能使用的规则
        if($act_type == 1 || $act_type == 2){//满减、满折
            $act_rule_list = M('pms_activity_rule')->where("act_id=".$act_id." and ".$act_store_price.">=full_money")->select();
        }

        if($act_rule_list){
            foreach ($act_rule_list as $k => $v) {

                $act_rule_list[$k]['act_type'] = $act_type;
                $act_rule_list[$k]['act_store_price'] = $act_store_price;
                if($act_type == 1)
                    $act_rule_list[$k]['act_name'] = $is_all_val.'满'.round($v['full_money'],2).'减'.round($v['discount_money'],2);
                if($act_type == 2)
                    $act_rule_list[$k]['act_name'] = $is_all_val.'满'.round($v['full_money'],2).'打'.round($v['discount_money'],2).'折';
            }
        }
        return $act_rule_list;
    }

    /**
    * 获得能使用的优惠券列表
    * @param    $goods_id        购买的商品id数组(按供应商分)
    * @param    $price           购买的商品售价数组(按供应商分)
    * @param    $supplier_id     供应商id
    * @param    $location_id     门店id
    * @return   $location_coupon 能使用的优惠券列表
    */
    private function get_coupon($goods_id,$price,$supplier_id,$location_id){

        //查找门店在该供应商的优惠券列表
        $location_coupon = M('pms_location_coupon')
        ->field('id,goods_ids,full_money,discount_money')
        ->where("location_id=".intval($location_id)." and supplier_id=".$supplier_id." and num>0 and (unix_timestamp() between start_time and end_time)")
        ->select();

        if($location_coupon){
            foreach ($location_coupon as $k => $v) {

                foreach ($goods_id as $g_k => $g_v) {
                    if($v['goods_ids'] == 0){//所有商品
                        $coupon[$v['id']]['price'] += $price[$g_k];
                    }else{//部分商品
                        $had_goods_id = explode(',', $v['goods_ids']);
                        if(in_array($g_v, $had_goods_id)){
                            $coupon[$v['id']]['price'] += $price[$g_k];
                        }
                    }
                }

            }

            foreach ($location_coupon as $k => $v) {

                if($coupon[$v['id']]['price'] >= $v['full_money']){//金额满足

                    $is_all = $v['goods_ids'] == 0 ? '全部商品':'部分商品';
                    $location_coupon[$k]['coupon_name'] = round($v['discount_money'],2)."元优惠券（".$is_all."满".round($v['full_money'],2)."元使用）";
                    
                }else{
                    unset($location_coupon[$k]);
                }

            }

            return $location_coupon;

        }
    }

    /**
    * 代客下单提交订单时判断 1.是否能使用活动规则 2.是否能使用优惠券
    * @param    $act_rule_id 活动规则id列表 逗号隔开 一个供应商一个规则
    * @param    $coupon_ids  门店优惠券列表 逗号隔开 一个供应商一张优惠券
    * @param    $datas       二维数组，键值是供应商id。包含goods_id数组和对应的price小计数组
    * @return   $new_datas   返回二维数组，键值是供应商id。包含原始总金额、总金额、优惠总金额、参与活动金额、活动id、门店优惠券id
    */
    private function use_act_coupon($act_rule_id,$coupon_ids,$datas,$location_id){

        // 1.参与活动
        if($act_rule_id){
            //有效期内、有效的活动规则
            $act_list = M('pms_activity_rule as par')
            ->field('par.act_id,par.full_money,par.discount_money,pa.start_time,pa.end_time,pa.supplier_id,pa.goods_ids,pa.act_type')
            ->where('pa.is_del=0 and par.id in ('.$act_rule_id.') and (unix_timestamp() between pa.start_time and pa.end_time)')
            ->join('fw_pms_activity as pa on pa.id=par.act_id')
            ->select();
        }

        if($act_list){
            foreach ($act_list as $k => $v) {
                $act[$v['supplier_id']] = $v;
            }
        }

        foreach ($datas as $k => $v) {

            //初始化 活动金额、活动id、门店优惠券id、优惠金额 
            $new_datas[$k]['act_price'] = 0;
            $new_datas[$k]['act_id'] = 0;
            $new_datas[$k]['location_coupon_id'] = 0;
            $new_datas[$k]['discount_price'] = 0;

            foreach ($v['goods_id'] as $d_k => $d_v) {

                //原始总金额
                $new_datas[$k]['total_original_price'] += $v['price'][$d_k];
                //总金额(未扣除优惠)
                $new_datas[$k]['total_price'] += $v['price'][$d_k];

                if($act[$k]){//如果存在该供应商活动

                    if($act[$k]['goods_ids'] == 0){//全部商品
                        $new_datas[$k]['act_price'] += $v['price'][$d_k];
                    }else{//部分商品
                        $had_goods_id = explode(',', $act[$k]['goods_ids']);
                        if(in_array($d_v, $had_goods_id)){
                            $new_datas[$k]['act_price'] += $v['price'][$d_k];
                        }
                    }

                }

            }

        }

        foreach ($datas as $k => $v) {
            //判断是否能参与活动，获得优惠或折扣
            if($new_datas[$k]['act_price'] >= $act[$k]['full_money'] && $new_datas[$k]['act_price']>0 && $act[$k]['full_money']>0){

                $new_datas[$k]['act_id'] = $act[$k]['act_id'];

                if($act[$k]['act_type'] == 1 && $act[$k]['discount_money']>0 && $act[$k]['discount_money']<$act[$k]['full_money']){//1为满就减
                    $new_datas[$k]['discount_price'] = $act[$k]['discount_money'];//优惠金额
                    $new_datas[$k]['total_price'] -= $act[$k]['discount_money'];//总金额减去优惠金额
                }
                if($act[$k]['act_type'] == 2 && $act[$k]['discount_money']>0 && $act[$k]['discount_money']<10){//2为满就折
                    $new_datas[$k]['discount_price'] = $new_datas[$k]['act_price']*((10-$act[$k]['discount_money'])/10);//折扣金额
                    $new_datas[$k]['total_price'] -= $new_datas[$k]['act_price']*((10-$act[$k]['discount_money'])/10);//总金额减去折扣金额
                }

            }
        }

        //2.使用优惠券
        if($coupon_ids){
            $coupon_list = M('pms_location_coupon')
            ->where("location_id=".intval($location_id)." and num>0 and (unix_timestamp() between start_time and end_time) and id in (".$coupon_ids.")")
            ->select();
        }

        if($coupon_list){
            foreach ($coupon_list as $k => $v) {
                $coupon[$v['supplier_id']] = $v;
            }
        }

        foreach ($datas as $k => $v) {

            foreach ($v['goods_id'] as $d_k => $d_v) {

                if($coupon[$k]){//如果存在优惠券

                    if($coupon[$k]['goods_ids'] == 0){//全部商品
                        $new_datas[$k]['coupon_act_price'] += $v['price'][$d_k];
                    }else{//部分商品
                        $coupon_goods_id = explode(',', $coupon[$k]['goods_ids']);
                        if(in_array($d_v, $coupon_goods_id)){
                            $new_datas[$k]['coupon_act_price'] += $v['price'][$d_k];
                        }
                    }

                }

            }

        }

        foreach ($datas as $k => $v) {
            // 判断是否能使用优惠券
            if($new_datas[$k]['coupon_act_price'] >= $coupon[$k]['full_money'] && $new_datas[$k]['coupon_act_price']>0 && $coupon[$k]['full_money']>0){

                $new_datas[$k]['location_coupon_id'] = $coupon[$k]['id'];

                if($coupon[$k]['discount_money']>0 && $coupon[$k]['discount_money']<$coupon[$k]['full_money']){
                    $new_datas[$k]['discount_price'] += $coupon[$k]['discount_money']; //(活动优惠、折扣金额)+优惠券金额
                    $new_datas[$k]['total_price'] -= $coupon[$k]['discount_money'];//总金额减去优惠券金额(已减活动金额) 
                }
                if($coupon[$k]['id']){
                    $new_location_coupon_id[] = $coupon[$k]['id'];//用于减优惠券数量
                }

            }
        }

        //减优惠券数量
        if($new_location_coupon_id){
            M('pms_location_coupon')->where("id in (".implode(',', $new_location_coupon_id).")")->setDec('num');
        }
        
        return $new_datas;

    }


    //获取门店列表
    public function get_location(){
        $val        = I('post.name');
        $login_info = session('pms_supplier');
        // $search     = array();
        $map = array('supplier_id'=>$login_info['supplier_id'],'is_del'=>0);
        if($val){
            $map['location_name'] = array('like', '%' . $val . '%');
            // $search['contact']       = array('like', '%' . $val . '%');
            // $search['address']       = array('like', '%' . $val . '%');
            // $search['_logic']        = 'or';
            // $map['_complex']         = $search;
        }
        $location = M('pms_location')
            ->field('id,location_id,location_name,contact,mobile,address')
            ->where($map)
            ->order('id desc')
            ->limit(10)
            ->select();

        echo json_encode($location);exit;
    }

    /**
     * 获得门店信息
     */
    public function get_store_info(){

        $login_info = session('pms_supplier');
        $id = intval(I('post.id'));
        if($id){
            //门店信息
            $store_info = M('pms_location')
                ->field('location_id,location_name,contact,mobile,address')
                ->where(array('id'=>$id,'supplier_id'=>$login_info['supplier_id'],'is_del'=>0))
                ->find();

            //区域经理和授信额度
            $which = array(
                'pl.supplier_id' => $login_info['supplier_id'],
                'pl.id'          => $id,
                'pl.is_del'      => 0,
                'pe.supplier_id' => $login_info['supplier_id']
            );
            $info = M('pms_location as pl')
                ->field('pl.credit_line,pe.name,pe.mobile')
                ->join('fw_pms_employee as pe ON pe.id=pl.employee_id')
                ->where($which)
                ->find();

            if($store_info){
                if($info){
                    $store_info['employee_name']   = $info['name'];
                    $store_info['employee_mobile'] = $info['mobile'];
                }
                //客户挂账金额 除了支付宝和微信外，已支付、未收款订单+客户确认的历史欠款订单
                $where = array(
                    'is_del'           => 0,
                    'system'           => 0,
                    'is_refund'        => 0,
                    'pay_status'       => 1,
                    'pay_time'         => array('gt', 0),
                    'location_id'      => $store_info['location_id'],
                    'supplier_id'      => $login_info['supplier_id'],
                    'means_of_payment' => array('in', array(0, 3, 4, 5, 6))
                );
                $price = M('pms_order')->where($where)->sum('total_price');
                $paid  = M('pms_order')->where($where)->sum('paid_amount');
                unset($where);

                //本月采购次数
                //php获取本月起始时间戳和结束时间戳
                $thismonth_start = mktime(0, 0, 0, date('m'), 1, date('Y'));
                $thismonth_end   = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
                $where = array(
                    'po.is_del'      => 0,
                    'po.supplier_id' => $login_info['supplier_id'],
                    'po.location_id' => $store_info['location_id']
                );
                $whereTime['po.create_time'] = array('between',array($thismonth_start,$thismonth_end));
                $order = M('pms_order as po')
                    ->field('count(*) as total,po.id,po.create_time')
                    ->where($where)
                    ->where($whereTime)
                    ->order('po.id desc')
                    ->find();
                if(!empty($order['id'])){
                    $store_info['purchase_number'] = $order['total'];
                    $store_info['last_purchase_time'] = date('Y-m-d',$order['create_time']);
                }else{
                    $store_info['purchase_number'] = 0;
                    $store_info['last_purchase_time'] = 0;
                }
                if($price > 0){
                    $store_info['price'] = round(($price-$paid),2);
                }else{
                    $store_info['price'] = 0;
                }
                if($info['credit_line'] > 0){
                    if($price > 0){
                        $surplus = '&nbsp;&nbsp;授信余额：'.round(($info['credit_line'] - ($price-$paid)),2).'元';
                    }
                    $store_info['credit_line'] = round($info['credit_line'],2).'元';
                }else{
                    $store_info['credit_line'] = '不限制';
                }

                //获取余额
                $result = M('pms_recharge')
                    ->field('id,account,balance')
                    ->where(array('location_id'=>$store_info['location_id'],'supplier_id'=>$login_info['supplier_id'],'is_del'=>0))
                    ->select();
                $html = '<option value="0">-请选择余额支付账户-</option>';
                if(!$result){
                    $store_info['balance_account'] = 0;
                }else{
                    foreach($result as $k => $v){
                        $html .= "<option value=".$v['id']." data=".$v['balance']." selected>".$v['account']."(余额".$v['balance']."元)</option>";
                        $store_info['balance_account'] += $v['balance'];
                    }
                }

                $this->ajaxReturn(array('status'=>1,'info'=>$store_info,'balance_html'=>$html));
            }else{
                $this->ajaxReturn(array('status'=>0));
            }
        }else{
            $this->ajaxReturn(array('status'=>0));
        }
    }

    /*
     * 查询供应商门店是否存在
     */
    public function location_existence(){
        $login_info    = session('pms_supplier');
        $location_name = isset($_POST['name']) ? I('post.name') : 0;
        if(!empty($location_name)){
            $result = M('pms_location')
                ->field('id,location_id')
                ->where(array('location_name'=>$location_name,'supplier_id'=>$login_info['supplier_id'],'is_del'=>0))
                ->find();
        }
        if(!$result){
            $this->ajaxReturn(array('status'=>0,'msg'=>'门店不存在,请在列表框中选择'));
        }
    }

    public function deal_record()
    {
        $location_id = intval($_GET['location_id']);
        $this->assign('location_id',$location_id);
        $this->display();
    }

    /**
     * 交易记录
     */
    
    public function get_deal_record(){

        $location_id = intval($_GET['location_id']);
        $start_time  = isset($_GET['start_time'])?intval(strtotime($_GET['start_time'])):'';
        $end_time    = isset($_GET['end_time'])?intval(strtotime($_GET['end_time'])):'';
        $page        = isset($_GET['currentpage']) ? intval($_GET['currentpage'])  : 0;
        $keyword     = isset($_GET['keyword']) ? htmlspecialchars(strip_tags($_GET['keyword']), ENT_QUOTES, 'UTF-8') : '';
        $limit       = ($page * 8).",8";

        if($location_id <= 0 || $location_id == null || !is_numeric($location_id)){
            $this->ajaxReturn(array('status'=>0,'msg'=>'缺少门店信息'));
        }

        $where = array(
            'po.pay_status' => array('in', '1,2'),
            'po.type'       => array('in', '0,2'),
            'pl.location_id'=> $location_id
        );

        if($keyword != ''){
            $where['po.order_sn'] = array('like','%'.$keyword.'%');
        }

        $order_list = $this->get_order_list($start_time,$end_time,$limit,$where);

        if(!empty($order_list)){
            
            $this->assign('order_list', $order_list);
            echo $this->fetch();
        }else{
            echo '';
        }

    }

    /*
     * 获得订单明细
     * @param $start_time  开始时间
     * @param $end_time 结束时间
     * @param $where 条件
     */
    private function get_order_list($start_time,$end_time,$limit,$where=''){
        $login_info = session('pms_supplier');
        $whereBase = array(
            'po.is_del'      => 0,
            'po.is_refund'   => 0,
            'po.system'      => 0,
            'po.supplier_id' => $login_info['supplier_id'],
            'pl.supplier_id' => $login_info['supplier_id'],
        );

        if($start_time!=''&&$start_time!=0&&is_numeric($start_time)&&$end_time!=0&&$end_time!=''&&is_numeric($end_time))
        {
            $whereBase['po.create_time'] = array('between',array($start_time,$end_time));
        }

        $order_list = M('pms_order as po')
            ->field('po.*,poi.goods_name,poi.sell_price,poi.num,pl.employee_name')
            ->join('fw_pms_order_item as poi ON poi.order_id=po.id')
            ->join('fw_pms_location as pl ON pl.location_id=po.location_id')
            ->where($whereBase)
            ->where($where)
            ->limit($limit)
            ->select();
        foreach ($order_list as $k => $v) {
            $list[$v['id']]['id']            = $v['id'];
            $list[$v['id']]['employee_name'] = $v['employee_name'];
            $list[$v['id']]['order_sn']      = $v['order_sn'];
            $list[$v['id']]['total_price']   = $v['total_price'];
            $list[$v['id']]['location_name'] = $v['location_name'];
            $list[$v['id']]['receive_user']  = $v['receive_user'];
            $list[$v['id']]['receive_tel']   = $v['receive_tel'];
            $list[$v['id']]['create_time']   = $v['create_time'];
            $list[$v['id']]['item'][]        = $v['goods_name'] . '：' . round($v['sell_price'], 2) . '×' . $v['num'];
        }
        foreach ($list as $k => $v) {
            $list[$k]['item'] = implode(',', $v['item']);
        }
        return $list;
    }

    //会员修改
    public function edit(){
        $location_id = intval($_REQUEST['id']);
        $location_id = 260;
        $login_info  = session('pms_supplier');

        //客服顾问
        $customer = get_supplier_employee($login_info['supplier_id'],12);

        //区域经理
        $regional = get_supplier_employee($login_info['supplier_id'],11);

        $this->assign("customer",$customer);
        $this->assign("regional",$regional);

        $location_info=M('pms_location')
            ->where(array('is_del'=>0,'location_id'=>$location_id,'supplier_id'=>$login_info['supplier_id']))
            ->find();
        $this->assign("location_info",$location_info);
        $this->display();
    }

    public function location_edit(){
        $id       = I('post.id');
        $id_img   = I('post.id_img');
        $customer = I('post.customer');
        $contact  = I('post.contact');
        $employee = I('post.employee');
        $remark   = I('post.remark');
        $mobile   = I('post.mobile');
        $credit   = I('post.credit');
        $address  = I('post.address');

        $login_info = session('pms_supplier');

        //修改客户
        $location = array(
            'id_img'	    =>$id_img,
            'contact'	    =>$contact,
            'mobile'	    =>$mobile,
            'credit_line'	=>$credit,
            'customer_id'	=>$customer[0],
            'customer_name'	=>$customer[1],
            'employee_id'	=>$employee[0],
            'employee_name'	=>$employee[1],
            'remark'        =>$remark,
            'address'		=>$address
        );

        $r = M('pms_location')
            ->where(array('id' => $id,'supplier_id'=>$login_info['supplier_id']))
            ->save($location);

        if($r){
            ajax_return(array('status'=>1,'msg'=>'修改成功'));
        }else{
            ajax_return(array('status'=>0,'msg'=>'修改失败'));
        }

    }

    /**
     * 判断是否已添加过
     **/
    public function had_store(){

        $store_id = intval($_POST['store_id']);
        $login_info = session('pms_supplier');

        $result = M('pms_location')
            ->field('id')
            ->where(array('supplier_id' => $login_info['supplier_id'], 'location_id' => $store_id, 'is_del' => 0))
            ->find();

        if($result)
            $num = 1;
        else
            $num = 0;

        $this->ajaxReturn(array('num'=>$num));

    }

    //新增客户
    public function add(){
        $login_info = session('pms_supplier');

        $location = M('supplier_location')->field('id,name,contact,mobile,tel,address')->order('id desc')->limit(5)->select();

        //区域经理
        $regional =  get_supplier_employee($login_info['supplier_id'],11);

        //客服顾问
        $customer =  get_supplier_employee($login_info['supplier_id'],12);

        $this->assign("customer",$customer);
        $this->assign("regional",$regional);
        $this->assign("location",$location);
        $this->display();
    }

    /**
     * 订单结算页面
     *  
     * @DateTime 2017-11-06
     * @return   void 
     */
    public function settlement()
    {
        $employee_list = get_supplier_employee($_SESSION['pms_supplier']['supplier_id'],11);
        $this->assign("employee_list",$employee_list);

        $this->assign("title",'结算订单');
        $this->display();
    }

	//订单结算
    public function order_settlement()
    {
        //获取结算订单列表
        $keyword = isset($_GET['keyword']) ? htmlspecialchars(strip_tags($_GET['keyword']), ENT_QUOTES, 'UTF-8') : '';
        $page    = isset($_GET['currentpage']) ? intval($_GET['currentpage']) : 0;
        $attr    = isset($_GET['attr_value']) ? trim($_GET['attr_value']) : '';
        $sort    = intval($_GET['sort']);
        $limit   = ($page * 8) . ",8";

        $whereArr  = array();
        $whereBase = array(
            'po.type'        => array('in',array('0','2')),
            'po.status'      => array('in',array('4','5')),
            'po.pay_status'  => 1,
            'po.is_del'      => 0,
            'po.is_refund'   => 0,
            'po.system'      => 0,
            'po.supplier_id' => $_SESSION['pms_supplier']['supplier_id']
        );
        $results = M('pms_order')->alias('po');

        //根据属性筛选
        if($attr){
            $attr = explode(',', $attr);
            //6:邓禄普,1:125,1:135,1:275,2:20,2:40,2:55,3:13,11:70,11:119,7:M,95:660,95:668
            foreach ($attr as $k => $v) {
                $attr[$k] = explode(':',$v);
            }
            foreach($attr as $a){
                $attr_list[$a[0]][] = $a[1];
            }
            foreach ($attr_list as $k => $v) {
                if($k == 'employee_id'){
                    $whereBase['pl.'.$k] = array('in',$v);

                    $results->join('fw_pms_location as pl on pl.location_id=po.location_id');
                }
                else
                    $whereBase['po.'.$k] = array('in',$v);
            }

        }

        //按数量/商品排序
        if(in_array($sort, array(0,1,2,3,4))){
            switch ($sort) {
                case 0:
                    $results->order('po.id asc');
                    break;
                case 1:
                    $results->order('po.total_price asc');
                    break;
                case 2:
                    $results->order('po.total_price desc');
                    break;
                case 3:
                    $results->order('po.create_time desc');
                    break;
                case 4:
                    $results->order('po.create_time asc');
                    break;
            }           
        }

        //根据关键字搜索
        if($keyword){
            $whereLike['po.order_sn']      = array('like', '%' . $keyword . '%');
            $whereLike['po.receive_tel']   = array('like', '%' . $keyword . '%');
            $whereLike['po.receive_user']  = array('like', '%' . $keyword . '%');
            $whereLike['po.location_name'] = array('like', '%' . $keyword . '%');
            $whereLike['_logic'] = 'OR';
            $whereBase['_complex'] = $whereLike; 
        }

        // 根据时间搜索
        if (isset($start_time) && is_numeric($start_time) && $start_time != 0 &&
            isset($end_time) && is_numeric($end_time) && $end_time != 0)
        {
            $new_end_time = $end_time + 60 * 60 * 24;//时间戳加一天
            $whereArr['po.create_time'] = array('between', array($start_time,$new_end_time));
            $results->where($whereArr);
        }

         $order_list = $results->field('po.id,po.create_time,po.order_sn,po.location_name,po.total_price,po.paid_amount,
                        (po.total_price - po.paid_amount) as unpay_amount,po.pay_time,po.make_user_name,po.status' )
            ->where($whereBase)
            ->limit($limit)
            ->select();
        
        if($order_list){
            foreach ($order_list as $k => $v) {
                //付款状态
                $order_list[$k]['pay_status_msg'] = get_pay_status($v['pay_status'],$v['type'],$v['means_of_payment']);
                //订单状态
                $order_list[$k]['status_msg'] = get_order_status_mes($v['status']);
                //支付方式
            }
            $this->assign("order_list",$order_list);
            $this->assign("type",1);
            echo $this->fetch('SupOrder:order_list');
        }else{
            echo '';
        }

    }

    /**
     * 收款 
     */
    public function receipt(){
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        
        $login_info = session('pms_supplier');
        
        if(!empty($id)){
            $result = M('pms_order')->where(array(
                    'id'            => $id,
                    'is_del'        => 0,
                    'is_refund'     => 0,
                    'system'        => 0,
                    'supplier_id'   => $login_info['supplier_id'],
                    'type'          => array('in','0,1,2')
                ))->find();
        }
        if(empty($result))
            $this->ajaxReturn(array(
                            'status'    => 0,
                            'msg'       => '未找到指定项目或该项目不可操作'
                        ));
        
        if(!empty($_POST['token'])){
            $payment            = isset($_POST['payment'])  ? $_POST['payment']     : array();
            $account            = isset($_POST['account'])  ? $_POST['account']     : array();
            $price              = isset($_POST['price'])    ? $_POST['price']       : array();
            $payee              = isset($_POST['payee'])    ? $_POST['payee']       : array();
            $employee           = isset($_POST['employee']) ? $_POST['employee']    : array();
            $recharge_id        = isset($_POST['recharge_id']) ? $_POST['recharge_id'] : array();
            $recharge_account   = isset($_POST['recharge_account']) ? $_POST['recharge_account'] : array();
            $token              = isset($_POST['token'])    ? trim($_POST['token']) : '';
            $remark             = isset($_POST['remark'])   ? htmlspecialchars(strip_tags($_POST['remark']), ENT_QUOTES, 'UTF-8') : '';
            
            is_array($price) || $price = array($price);
            
            $data = array();
            
            if($token == ''){
                $data = array(
                    'status'    => 0,
                    'msg'       => '页面已过期，请刷新后重试'
                );
            }
            elseif(empty($price)){
                $data = array(
                    'status'    => 0,
                    'msg'       => '请填写本次核销金额'
                );
            }
            else{
                $total = 0;
                $balanceNum = array();
                $args   = array();
                 
                foreach($price as $k => $p){
                    $p *= 1;
                    
                    if($p <= 0)
                        continue;
                    
                    $total += $p;
                    
                    $args[$k] = array(
                        'order_id'              => $id,
                        'price'                 => $p,
                        'pay_time'              => time(),
                        'login_user_id'         => $login_info['id'],
                        'pay_detail'            => $remark,
                        'type'                  => $result['type'],
                        'trade_id'              => isset($account[$k])  ? intval($account[$k])  : 0,
                        'means_of_payment'      => isset($payment[$k])  ? intval($payment[$k])  : 0,
                        'settlement_staff_ids'  => isset($payee[$k])    ? intval($payee[$k])    : 0,
                        'settlement_staff_name' => isset($employee[$k]) ? htmlspecialchars(strip_tags($employee[$k]), ENT_QUOTES, 'UTF-8') : '',
                    );
                    if($payment[$k] == 7){
                        if($recharge_id[$k] == 0){
                            $data = array(
                               'status' =>  0,
                               'msg'    =>  '请选择余额支付账户'
                            );
                            $this->ajaxReturn($data);
                        }
                        if(empty($balanceNum[$recharge_id[$k]]))
                            $balanceNum[$recharge_id[$k]] = 0;

                        $balanceNum[$recharge_id[$k]] += $p;
                        $args[$k]['recharge_id']      = $recharge_id[$k];
                        $args[$k]['recharge_account'] = $recharge_account[$k];
                    }
                 }
                if(!empty($balanceNum)){
                    foreach ($balanceNum as $k => $v){

                        //余额是否充足
                        $res = M('pms_recharge')->field('account,balance,id')->where(
                            array(
                                'is_del'=>0,
                                'location_id'=>$result['location_id'],
                                'supplier_id'=>$login_info['supplier_id'],
                                'id'=>$k)
                        )->find();

                        if(!$res || ($res && $res['balance'] < $v)){
                            $data = array(
                                'status'    => 0,
                                'msg'       => '账户余额不足'
                            );
                            $this->ajaxReturn($data);

                        }else{
                            $update = M('pms_recharge')->where(array('id'=>$k))->setDec('balance',$v);
                            if(!$update){
                                $data = array(
                                    'status'   =>   0,
                                    'msg'      =>   '账户余额扣减失败，请稍后重试'
                                );

                                $this->ajaxReturn($data);
                            }
                        }

                    }
                }

                if($total > $result['total_price'] - $result['paid_amount']){
                    $data = array(
                        'status'    => 0,
                        'msg'       => '核销金额不能大于欠款金额'
                    );
                }
                else{
                    $add = false;
                     
                    if(!empty($args))
                        $add = M('pms_order_deal')->addAll($args);
                     
                    if($add){
                        $oargs = array(
                            'pay_time'      => time(),
                            'paid_amount'   => $result['paid_amount'] + $total
                        );
                        
                        // 已等于欠款金额时更新订单支付状态
                        if($total == $result['total_price'] - $result['paid_amount'])
                            $oargs['pay_status'] = 2;
                        
                        $update = M('pms_order')->where(array('id' => $id))->data($oargs)->save();
                        
                        if($update && $total == $result['total_price'] - $result['paid_amount']){
                            $this->get_shop_commission($id);
                            
                            // 发送微信消息
                            $wxid_list      = $this->get_wxid_list($result['location_id']);
                            $supplier_info  = $this->get_supplier_info();
                            $employee_info  = $this->get_employee_info($result['location_id']);
                            
                            if($wxid_list){
                                foreach($wxid_list as $k => $v){
                                    $this->send_wx_msg($v['open_id'], 5, $supplier_info['name'], $result['order_sn'], $id, $supplier_info['mobile'], $employee_info['name'], $employee_info['mobile']);
                                }
                            }
                        }elseif($update && $total < $result['total_price'] - $result['paid_amount']){
                            // 发送核销成功微信消息
                            $wxid_list      = $this->get_wxid_list($result['location_id']);
                            $supplier_info  = $this->get_supplier_info();
                            $employee_info  = $this->get_employee_info($result['location_id']);
                            $order = array('id'=>$id,'order_sn'=>$result['order_sn'],'supplier_name'=>$supplier_info['name'],'supplier_tel'=>$supplier_info['mobile'],'location_name'=>$result['location_name'],'employee_name'=>$employee_info['name'],'employee_tel'=>$employee_info['mobile'],'total_price'=>$result['total_price'],'paid_amount'=>$result['paid_amount']+$total,'create_time'=>$result['create_time']);
                            $order['unpay'] = $result['total_price'] - $result['paid_amount'] - $total;

                            if($wxid_list){
                                foreach($wxid_list as $k => $v){
                                    $this->send_chargeoff_wx_msg($v['open_id'], $total, $order);
                                }
                            }
                        }
                        
                        $data = array(
                            'status'    => 1,
                            'msg'       => '保存成功'
                        );
                    }
                    else{
                        $data = array(
                            'status'    => 0,
                            'msg'       => '保存失败，请稍后重试'
                        );
                    }
                }
            }
            
            $this->ajaxReturn($data);
        }
        else{
            // 订单商品
            $items = M('pms_order_item')->where(array('order_id' => $id))->select();
            
            // 已核销列表
            $paid = M('pms_order_deal as pod')->field('pod.*, b.bank_name, b.account as bank_account')
            ->where(array('pod.order_id' => $id))
            ->join('fw_pms_bank_account as b ON b.id=pod.trade_id')
            ->order('id asc')
            ->select();

            // 银行账户
            $account = M('pms_bank_account')
            ->field('id, bank_name, account, account_name')
            ->where(array('supplier_id' => $login_info['supplier_id']))
            ->order(array('is_default' => 'desc', 'id' => 'asc'))
            ->select();

            // 余额账户
            $recharge_account = M('pms_recharge')->field('id, account, balance')->where(
                array(
                    'supplier_id' => $login_info['supplier_id'],
                    'location_id'=>$result['location_id'],
                    'is_del'=>0))->order('id desc')->select();
            
            // 收款人
            $employee = get_supplier_employee($login_info['supplier_id'], 5);
            
            $this->assign('result', $result);
            $this->assign('items', $items);
            $this->assign('paid', $paid);
            $this->assign('account', $account);
            $this->assign('recharge_account', $recharge_account);
            $this->assign('employee', $employee);
            $this->assign('payments', $this->payments);
            $this->assign('status', $this->status);
            
            $this->display();
        }
    }

    /**
    * 代理供应商、代理门店 获得所发展门店的采购提成
    * @param $order_id 订单id
    **/
    private function get_shop_commission($order_id){

        //平台提成设置(轮胎、电瓶、机油) 单位 %
        $platform_set = array(2=>0.5,8=>0.5,6=>2);

        //代理商提成设置(轮胎、电瓶、机油) 单位 % 
        $agent_set = array(2=>0.5,8=>0.5,6=>2);

        $login_info = session('pms_supplier');
        $platform_total_commission = 0;//平台获得的总提成

        //已收款的采购订单,查询一条记录得到商品分类(不考虑一条订单多个商品分类)
        $order_info = M('pms_order as po')
        ->field('po.total_price,po.location_id,po.supplier_id,pg.class_id')
        ->where(array(
                'id'         => $order_id,
                'is_del'     => 0,
                'is_refund'  => 0,
                'supplier_id'=> $login_info['supplier_id'],
                'type'       => 0,
                'pay_status' => 2
            ))->join('fw_pms_order_item as poi ON poi.order_id=po.id')
        ->join('fw_pms_goods as pg ON pg.id=poi.goods_id')
        ->find();

        if($order_info['total_price']>0 && $order_info['location_id']>0 && $order_info['supplier_id']>0 && $order_info['class_id']>0){

            //平台提成
            $platform_commission = $order_info['total_price'] * ($platform_set[$order_info['class_id']]/100);

            if($platform_commission > 0){

                $platform_total_commission += $platform_commission;

            }
            
            //新增代理商提成
            $agent_commission = $order_info['total_price'] * ($agent_set[$order_info['class_id']]/100);

            if($agent_commission > 0){

                //判断该门店是否是代理门店
                $agent_qrcode = M('agent_qrcode')->where(array(
                        'shop_id'   => $order_info['location_id'],
                        'type'      => 2
                    ))->select();

                if($agent_qrcode){

                    //判断是否有上级代理
                    if($agent_qrcode['parent_id'] == 0){
                        //没有上级代理则提成归平台
                        $platform_total_commission += $agent_commission;
                    }

                    if($agent_qrcode['parent_id'] > 0){

                        $parent_agent_qrcode = M('agent_qrcode')->where(array(
                                'id'    => $agent_qrcode['parent_id']
                            ))->find();

                        if($parent_agent_qrcode){

                            //上级代理获得提成
                            $agent_data = array(
                                'order_id'    => $order_id,
                                'order_price' => $order_info['total_price'],
                                'order_supplier_id' => $order_info['supplier_id'],
                                'location_id' => $order_info['location_id'],
                                'commission'  => $agent_commission,
                                'type'        => 2,
                                'shop_id'     => $parent_agent_qrcode['shop_id'],
                                'shop_type'   => $parent_agent_qrcode['type'],
                                'create_time' => time()
                            );

                            M('pms_shop_commission')->add($agent_data);

                        }else{
                            //找不到上级则提成归平台
                            $platform_total_commission += $agent_commission;
                        }

                    }

                }else{
                    //该门店不是代理则提成归平台
                    $platform_total_commission += $agent_commission;
                }

            }

            //新增平台提成
            if($platform_total_commission > 0){

                $platform_data = array(
                    'order_id'    => $order_id,
                    'order_price' => $order_info['total_price'],
                    'order_supplier_id' => $order_info['supplier_id'],
                    'location_id' => $order_info['location_id'],
                    'commission'  => $platform_total_commission,
                    'type'        => 1,
                    'create_time' => time()
                );

                M('pms_shop_commission')->add($platform_data);

            }

            
        }

    }

}