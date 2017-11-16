<?php
class SupMemberAction extends SupBaseAction
{
    /**
     * 权限白名单，白名单中的操作方法不受权限限制
     * 该名单主要用于一些特殊无涉及权限分配的方法
     *
     * @var array
     * @access protected
     */
    protected $accessAllowed = array(
        'ajax_get_member','ajax_get_credit','get_order_refund','can_refund_list','order_refund_search','refund_save','recharge','navig'
        );
    /**
     * 支付方式 
     */
    private $payments = array(
        7 => '余额支付', 1 => '支付宝',    2 => '微信支付', 3 => '现金支付',
        4 => '刷卡支付', 5 => '转账支付', 6 => '物流代收'
    );
    /**
     * 门店列表
     */
    public function index()
    {
        $login_info = session('pms_supplier');
        //区域经理
        $employee_list = get_supplier_employee($login_info['supplier_id'],11);

        $this->assign('employee_list',$employee_list);
        $this->display();
    }

    //导航
    public function navig()
    {
        $this->display();
    }

    public function ajax_get_member()
    {
        $page       = isset($_GET['currentpage']) ? intval($_GET['currentpage']) : 0;
        $keyword    = isset($_GET['keyword']) ? htmlspecialchars(strip_tags($_GET['keyword']), ENT_QUOTES, 'UTF-8') : '';
        $employee_id = intval($_REQUEST['employee_id']);
        $attr        = isset($_GET['attr_value']) ? trim($_GET['attr_value']) : '';
        $sort        = intval($_GET['sort']);

        $login_info = session('pms_supplier');

        $limit  = ($page * 8).",8";
        $which = array('pl.supplier_id'=>$login_info['supplier_id'],'pl.is_del'=>0);

        // 名称模糊搜索
        if($keyword !== ''){
            $where['pl.location_name']      = array('like', '%'.$keyword.'%');
            $where['pl.contact']  = array('like', '%'.$keyword.'%');
            $where['pl.mobile'] = array('like', '%'.$keyword.'%');
            $where['_logic']        = 'or';
            $which['_complex']      = $where;
        }

        //根据条件筛选
        if($attr){

            $attr = explode(',', $attr);
            //6:邓禄普,1:125,1:135,1:275,2:20,2:40,2:55,3:13,11:70,11:119,7:M,95:660,95:668
            foreach ($attr as $k => $v) {
                $attr[$k] = explode(':',$v);
            }

            foreach($attr as $a){
                $which['pl.'.$a[0]] = $a[1];
               
            }
        }

        // 仅可查看当前登录账号对应的区域经理的数据
        if($login_info['is_authority'] < 1 && !user_can_access('index', 'member', 'viewall')){
            $which['pl.employee_id'] = $login_info['employee_id'];
        }

         $model = M('pms_location as pl');
         //按排序
        if(in_array($sort, array(0,1,2,3,4))){
            switch ($sort) {
                case 0:
                    $model->order('pl.id desc');
                    break;
                case 1:
                    $model->order('a.order_price asc');
                    break;
                case 2:
                    $model->order('a.order_price desc');
                    break;
                case 3:
                    $model->order('a.order_count desc');
                    break;
                case 4:
                    $model->order('a.order_count asc');
                    break;
            }
        }

        $sql = "SELECT count(id) AS order_count,sum(total_price) AS order_price,location_id FROM ".C('DB_PREFIX')."pms_order WHERE `supplier_id`=".$login_info['supplier_id']." and `pay_time`>0 and `pay_status` in(1,2) and `system`=0 and `is_refund`=0 and `is_del`=0 GROUP BY location_id ";

        $order_info = $model->field('pl.*,pe.name,pe.position_id,pr.account,pr.balance,a.order_count,a.order_price')
        ->where($which)
        ->join('fw_pms_employee as pe ON pe.id=pl.employee_id')
        ->join('fw_pms_recharge as pr ON pr.location_id=pl.location_id')
        ->join('left join ('.$sql.') as a ON a.location_id=pl.location_id')
        ->limit($limit)        
        ->select();

        $this->assign('order_info',$order_info);
        echo $html = $this->fetch();
    }

    //客户信用
    public function credit()
    {
        $login_info = session('pms_supplier');
        //区域经理
        $employee_list = get_supplier_employee($login_info['supplier_id'],11);

        $this->assign('employee_list',$employee_list);
        $this->display();
    }

   public function ajax_get_credit()
    {
        $page       = isset($_GET['currentpage']) ? intval($_GET['currentpage']) : 0;
        $keyword    = isset($_GET['keyword']) ? htmlspecialchars(strip_tags($_GET['keyword']), ENT_QUOTES, 'UTF-8') : '';
        $employee_id = intval($_REQUEST['employee_id']);
        $attr        = isset($_GET['attr_value']) ? trim($_GET['attr_value']) : '';
        $sort        = intval($_GET['sort']);

        $login_info = session('pms_supplier');

        $limit  = ($page * 8).",8";
        $which = array('pl.supplier_id'=>$login_info['supplier_id'],'pl.is_del'=>0);

        // 名称模糊搜索
        if($keyword !== ''){
            $where['pl.location_name']      = array('like', '%'.$keyword.'%');
            $where['pl.contact']  = array('like', '%'.$keyword.'%');
            $where['pl.mobile'] = array('like', '%'.$keyword.'%');
            $where['_logic']        = 'or';
            $which['_complex']      = $where;
        }

        //根据条件筛选
        if($attr){

            $attr = explode(',', $attr);
            //6:邓禄普,1:125,1:135,1:275,2:20,2:40,2:55,3:13,11:70,11:119,7:M,95:660,95:668
            foreach ($attr as $k => $v) {
                $attr[$k] = explode(':',$v);
            }

            foreach($attr as $a){
                $which['pl.'.$a[0]] = $a[1];
               
            }
        }

        // 仅可查看当前登录账号对应的区域经理的数据
        if($login_info['is_authority'] < 1 && !user_can_access('index', 'member', 'viewall')){
            $which['pl.employee_id'] = $login_info['employee_id'];
        }

         $model = M('pms_location as pl');
         //按排序
        if(in_array($sort, array(0,1,2,3,4))){
            switch ($sort) {
                case 0:
                    $model->order('pl.id desc');
                    break;
                case 1:
                    $model->order('pl.credit_line asc');
                    break;
                case 2:
                    $model->order('pl.credit_line desc');
                    break;
                case 3:
                    $model->order('a.price asc');
                    break;
                case 4:
                    $model->order('a.price desc');
                    break;
            }
        }

        $sql = "SELECT sum(total_price-paid_amount) AS price,location_id FROM ".C('DB_PREFIX')."pms_order WHERE `supplier_id`=".$login_info['supplier_id']." and `pay_time`>0 and `pay_status`=1 and `system`=0 and `is_refund`=0 and `is_del`=0 and means_of_payment in(0,3,4,5,6) GROUP BY location_id ";

        $order_info = $model->field('pl.*,pe.name,pe.position_id,pr.account,pr.balance,a.price')
        ->where($which)
        ->join('fw_pms_employee as pe ON pe.id=pl.employee_id')
        ->join('fw_pms_recharge as pr ON pr.location_id=pl.location_id')
        ->join('left join ('.$sql.') as a ON a.location_id=pl.location_id')
        ->limit($limit)        
        ->select();
        if(!empty($order_info)){
            foreach ($order_info as $k => &$v) {
                $v['surplus']    = $v['credit_line'] - $v['price'];
            }
            $this->assign('order_info',$order_info);
            echo $html = $this->fetch();
        }else
            echo '';
    }

    public function order_refund(){
        $login_info = session('pms_supplier');
        $employee_list = get_supplier_employee($login_info['supplier_id'],11);
        $this->assign("employee_list",$employee_list);
        $this->display();
    }

    public function get_order_refund(){
        $login_info = session('pms_supplier');
        $keyword = isset($_GET['keyword']) ? htmlspecialchars(strip_tags($_GET['keyword']), ENT_QUOTES, 'UTF-8') : '';
        $page    = isset($_GET['currentpage']) ? intval($_GET['currentpage']) : 0;
        $attr    = isset($_GET['attr_value']) ? trim($_GET['attr_value']) : '';
        $sort    = intval($_GET['sort']);
        $limit   = ($page * 8) . ",8";

        $where  = " where por.supplier_id=".$login_info['supplier_id'];

        // 关键字搜索
        if($keyword !== ''){
            $where .= " and (por.refund_sn like '%".$keyword."%' or po.location_name like '%".$keyword."%') ";
        }

        // 根据时间搜索
        if(isset($start_time)&&is_numeric($start_time)&&$start_time!=0&&isset($end_time)&&is_numeric($end_time)&&$end_time!=0){
            $new_end_time = $end_time+60*60*24;//时间戳加一天
            $where .= " and por.time between ".$start_time." and ".$new_end_time;
        }

         $order_list = M()->query("select por.id,por.refund_sn,por.order_sn,por.total_price,por.total_num,por.time,po.location_name,po.total_price as order_total_price,po.paid_amount as order_paid_amount,po.total_price - po.paid_amount as unpay,po.create_time,po.make_user_name
         from fw_pms_order_refund as por left join fw_pms_order as po on por.order_id = po.id ".$where." order by por.id desc limit ".$limit);
         
         if(!empty($order_list)){

            $this->assign('order_list', $order_list);
            echo $this->fetch();
         }else{
            echo '';
         }

    }

    /**
     * 可退单列表
     */
    public function refund_search(){
        //员工列表[区域经理]
        $login_info  = session('pms_supplier');
        $employee_list = get_supplier_employee($login_info['supplier_id'], 11);
        $this->assign('employee_list', $employee_list);
        $this->display();
    }

    public function can_refund_list(){
        $login_info  = session('pms_supplier');
        $keyword     = isset($_GET['keyword']) ? htmlspecialchars(strip_tags($_GET['keyword']), ENT_QUOTES, 'UTF-8') : '';
        $attr        = isset($_GET['attr_value']) ? trim($_GET['attr_value']) : '';
        $sort        = intval($_GET['sort']);
        $page        = intval($_GET['currentpage']);
        $limit       = ($page*8).",8";

        $which = array(
            'po.supplier_id' => $login_info['supplier_id'],
            'po.is_del'      => 0,
            'po.is_refund'   => 0,
            'po.pay_status'  => array('in',array(1,2)),
            'po.system'      => 0,
            'po.status'      => array('EGT','4'),
        );

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

        $order_list = $order_list->field('po.id,po.order_sn,po.total_price,po.paid_amount,(po.total_price-po.paid_amount) as unpay,po.type,po.status,po.pay_status,po.location_name,po.create_time,po.make_user_name')
        ->where($which)
        ->limit($limit)
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

    public function order_refund_search()
    {
        $login_info  = session('pms_supplier');
        $keyword     = isset($_GET['keyword']) ? htmlspecialchars(strip_tags($_GET['keyword']), ENT_QUOTES, 'UTF-8') : '';
        $attr        = isset($_GET['attr_value']) ? trim($_GET['attr_value']) : '';
        $sort        = intval($_GET['sort']);
        $page        = intval($_GET['currentpage']);
        $location_id = intval($_GET['location_id']);
        $order_id    = intval($_GET['order_id']);
        $limit       = ($page*8).",8";

        $which = array(
            'po.supplier_id' => $login_info['supplier_id'],
            'po.is_del'      => 0,
            'po.is_refund'   => 0,
            'po.pay_status'  => array('in',array(0,1)),
            'po.system'      => 0,
            'po.status'      => array('EGT','4'),
            'po.location_id' => $location_id,
            'po.id'          => array('NEQ',$order_id),
        );

        // 关键字搜索
        if ($keyword !== '') {
            $where['po.order_sn']      = array('like', '%'.$keyword.'%');
            $where['po.receive_user']  = array('like', '%'.$keyword.'%');
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

        $order_list = $order_list->field('po.id,po.order_sn,po.total_price,po.paid_amount,(po.total_price-po.paid_amount) as unpay,po.type,po.status,po.pay_status,po.location_name,po.create_time,po.make_user_name')
        ->where($which)
        ->limit($limit)
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

    //退货详情
    public function refund_detail(){
        $id = intval($_REQUEST['id']);
        $login_info = session('pms_supplier');
        if($id){
            //订单详情
            $refund_status = array('0'=>'未审核','1'=>'审核通过','2'=>'作废','3'=>'已入库');
            $refund_info = M('pms_order_refund as por')->field('por.*,pori.*,pw.warehouse_name,pg.goods_name,pg.unit,pg.thumbnail')
            ->where(array(
                    'por.id'         => $id,
                    'por.supplier_id'=> $login_info['supplier_id']
                ))->join('fw_pms_order_refund_item as pori ON pori.refund_id=por.id')
            ->join('fw_pms_goods as pg ON pg.id=pori.goods_id')
            ->join('fw_pms_warehouse as pw ON pw.id=pori.warehouse_id')
            ->select();
            if(!empty($refund_info)){
                $refundStatus = $refund_status[$refund_info[0]['status']]; 
            }else{
                $this->error('退货单不存单');
            }

            $order = M('pms_order')->where(array('id'=>$refund_info[0]['order_id'],'supplier_id'=> $login_info['supplier_id']))->find();

            $refund = M('pms_order_refund')->where(array('id'=>$id,'supplier_id'=> $login_info['supplier_id']))->find();
            $this->assign("info",$order);
            $this->assign("refundStatus",$refundStatus);
            $this->assign("arrears",$refund['total_price'] - $refund['pay_amount']);
            $this->assign("refund",$refund);
            $this->assign("refund_info",$refund_info);
            
            $this->display();
        }
    }


    /**
     * 退货页面
     */
    public function refund(){
        $id         = intval($_GET['id']);
        $login_info = session('pms_supplier');

        $pay_type = array('1'=>'现金结算','2'=>'月底结算','3'=>'约定结算','4'=>'预付款结算');

        if ($id) {
            $where = array(
                    'po.id'          => $id,
                    'po.supplier_id' => $login_info['supplier_id']
                );
            //订单详情
            $order_info = M('pms_order as po')->field('po.*, poi.goods_name, poi.goods_id, poi.sell_price, poi.num, poi.thumbnail, poi.attr_val, (poi.sell_price * poi.num) AS subtotal,poi.is_gift')
            ->where($where)
            ->join('fw_pms_order_item as poi ON poi.order_id=po.id')
            ->order('poi.is_gift asc')
            ->select();
            foreach ($order_info as $k => &$v) {
                $v['pay_type'] = $pay_type[$v['pay_type']];
            }

            // 已核销列表
            $paid = M('pms_order_deal as pod')
            ->field('pod.*,sum(pod.price) as paid_money, pba.bank_name, pba.account as bank_account')
            ->where(array('pod.order_id' => $id))
            ->join('fw_pms_bank_account as pba ON pod.trade_id = pba.id')
            ->order('pod.id asc')
            ->select();
            $unpay = $order_info[0]['total_price']-$paid[0]['paid_money'];

            // 银行账户
            $account = M('pms_bank_account')
            ->field('id, bank_name, account, account_name')
            ->where(array('supplier_id' => $login_info['supplier_id']))
            ->select();

            /*$bank_short = array('中国农业银行'=>'农行','中国工商银行'=>'工行','中国建设银行'=>'建行','邮政储蓄银行'=>'邮政','中国交通银行'=>'交行','上海浦发银行'=>'浦发','广东发展银行'=>'广发','招商银行'=>'招行','广西北部湾银行'=>'北部湾','广西农村信用社'=>'农信');
            foreach ($account as $k => &$v) {
                $v['bank_name'] = $bank_short[$v['bank_name']];
            }*/
            //获取下单门店信息
            $store_info = M('pms_location')->field('location_id,location_name')
            ->where(
                array(
                    'location_id' => $order_info[0]['location_id'], 
                    'supplier_id' => $login_info['supplier_id'], 
                    'is_del' => 0
                    )
                )->find();

            // 收款人
            $employee = get_supplier_employee($login_info['supplier_id'], 5);
            // 仓库列表
            $warehouse = get_warehouse_list_info($login_info['supplier_id']);
            // 退货人
            $employees = get_supplier_employee($login_info['supplier_id'], 9);


            $this->assign("warehouse_list", $warehouse);
            $this->assign("employee_list", $employees);
            $this->assign("unpay", $unpay);
            $this->assign("account", $account);
            $this->assign("employee", $employee);
            $this->assign("store_info", $store_info);
            $this->assign("paid", $paid);
            $this->assign("order", $order_info[0]);
            $this->assign("order_info", $order_info);
            $this->assign("t", $t);
            $this->assign("order_id", $id);
            $this->assign("payments", $this->payments);
            $this->display();
        }
    }

    /**
     * 退货提交
     */
    public function refund_save(){
        $order_id           = $_POST['id'];
        $user_id            = $_POST['user_id'];
        $user_name          = $_POST['user_name'];
        $remark             = $_POST['remark'];
        $goods_list         = $_POST['goods_list'];
        $warehouse_id       = $_POST['warehouse_id'];
        $refund_money_type  = intval($_POST['refund_money_type']);
        $receipt_order_id   = $_POST['receipt_order_id'];
        $refund_account     = isset($_POST['refund_account']) ? $_POST['refund_account'] : 0;
        $refund_money       = isset($_POST['refund_money']) ? $_POST['refund_money'] : 0;
        $recharge_money     = isset($_POST['recharge_money']) ? $_POST['recharge_money'] : 0;
        $login_info         = session('pms_supplier');
        $total_price        = 0;
        $total_num          = 0;
        $type               = 1;
        $goods_data         = array();
        $goods_ids          = array();

        //赠品
        $goods_list_gift    = $_POST['goods_list_gift'];
        $total_num_gift     = 0 ;


        /**
         * 1.更新订单
         * 2.把商品退回仓库库存
         * 3.更新总库存和销量
         * 4.写入退货记录
         */

        $order_which = array(
            'id'            => $order_id,
            'is_del'        => 0,
            'is_refund'     => 0,
            'system'        => 0,
            'supplier_id'   => $login_info['supplier_id']
        );

        $order = M('pms_order')->where($order_which)->find();

        $order_item = M('pms_order_item')->where(array('order_id' => $order_id,'is_gift' => 0))->select();

        if(!$order){
            $this->ajaxReturn(array(
                'status'=>0,
                'msg'=>'找不到订单')
            );
        }

        if(count($goods_list) <= 0 && count($goods_list_gift) <= 0){
            $this->ajaxReturn(array(
                'status'=>0,
                'msg'=>'至少选择一个退货商品')
            );
        }

        if($order['status'] == 1){ //未发货
            $this->ajaxReturn(array(
                'status'=>0,
                'msg'=>'订单未发货不能退货')
            );
        }

        //合并数据
        foreach ($goods_list as $goods){
            $total_price += $goods['num'] * $goods['price'];
            $total_num   += $goods['num'];

            $goods_data[$goods['gid']]['num']   = $goods['num'];
            $goods_data[$goods['gid']]['price'] = $goods['price'];
            $goods_ids[] = $goods['gid'];
        }

        //赠品总数量
        foreach ($goods_list_gift as $goods){
            $total_num_gift   += $goods['num'];
        }

        //region ======================== 更新order[start] ===========================\\

        $update_order_data = array(
            'total_num'             => $order['total_num'] - $total_num,
            'total_original_price'  => $order['total_original_price'] - $total_price,
            'total_price'           => $order['total_price'] - $total_price,
            'costs'                 => $order['costs'] - $total_price,
        );
        $extra_money = $order['paid_amount'] - $update_order_data['total_price'];
        //如果退货金额加已付金额大于订单总金额,置已付金额和订单总金额一样,并且回删核销记录
        if($extra_money > 0){
            $order_deal = M('pms_order_deal')->where(array('order_id'=>$order_id))->order('id desc')->select();

            foreach ($order_deal as $od){
                $extra_money = $extra_money - $od['price'];
                if($extra_money > 0){
                    M('pms_order_deal')->where(array('id' => $od['id']))->delete();
                }else{
                    M('pms_order_deal')
                    ->data(array('price'=>abs($extra_money)))
                    ->where(array('id' => $od['id']))
                    ->save();
                    break;
                }
            }

            $update_order_data['paid_amount'] = $update_order_data['total_price'];
            $update_order_data['pay_status']  = 2;
        }

        if($order['total_num'] == $total_num + $total_num_gift){
            $type = 2;
            $update_order_data['is_refund']   = 1;
            $update_order_data['refund_time'] = time();
        }

        M('pms_order')->data($update_order_data)->where(array('id' => $order['id'],'supplier_id'=>$login_info['supplier_id']))->save();

        //endregion ======================== 更新order[end] =============================\\

        //region ======================== 更新order_item[start] ==========================\\

        foreach ($order_item as $item){
            $goods_item = $goods_data[$item['goods_id']];

            if(isset($goods_item)){
                $num = $item['num'] - $goods_item['num'] ;
                if($num <= 0 )
                    M('pms_order_item')->where(array('id' => $item['id']))->delete();
                else
                    M('pms_order_item')->data(array('num' => $num))->where(array('id' => $item['id']))->save();
            }
        }

        //endregion ===================== 更新order_item[end] ============================\\

        //region ======================== 更新order_goods[start] ===========================\\

        $update_goods = M('pms_goods')->where(array('id' => array('in',$goods_ids),'supplier_id'=>$login_info['supplier_id']))->select();

        foreach ($update_goods as $goods){
            M('pms_goods')->data(
                array(
                    'stock' => $goods['stock'] + $goods_data[$goods['id']]['num'],
                    'sales' => $goods['sales'] - $goods_data[$goods['id']]['num']
                ))->where(
                array(
                    'id' => $goods['id'],
                    'supplier_id'=>$login_info['supplier_id']
                ))->save();
        }

        //endregion ===================== 更新order_goods[end] ===========================\\

        //region ======================== 更新pms_warehouse_goods[start] ===========================\\

        $update_warehouse_goods = M('pms_warehouse_goods')->where(array(
                'goods_id' =>array('in',$goods_ids),
                'warehouse_id' => $warehouse_id,
                'supplier_id'=>$login_info['supplier_id']
            ))->select();

        foreach ($update_warehouse_goods as $warehouse_goods){
            M('pms_warehouse_goods')->data(array(
                'stock' => $warehouse_goods['stock'] + $goods_data[$warehouse_goods['goods_id']]['num']))
            ->where(array(
                    'goods_id' => $warehouse_goods['goods_id'],
                    'supplier_id'=>$login_info['supplier_id'],
                    'warehouse_id'=>$warehouse_id
                ))->save();

            $goods_data[$warehouse_goods['goods_id']]['wgid'] = $warehouse_goods['id'];
        }

        //endregion ===================== 更新pms_warehouse_goods[end] ===========================\\

        //region ======================== 写入退货记录[start] ===========================\\

        $refund = array(
            'supplier_id'       => $login_info['supplier_id'],
            'order_id'          => $order['id'],
            'order_sn'          => $order['order_sn'],
            'refund_sn'         => 'TH'.date('Ymdhis',time()).rand(10,99),
            'type'              => $type,
            'user_id'           => $user_id,
            'user_name'         => $user_name,
            'total_price'       => $total_price,
            'pay_amount'        => 0,
            'means_of_payment'  => 1 ,
            'login_user_id'     => intval($login_info['id']),
            'total_num'         => $total_num+$total_num_gift,
            'status'            => 3,
            'remark'            => $remark,
            'refund_money_type' => $refund_money_type,
            'refund_account'    => $refund_account,
            'refund_money'      => $refund_money,
            'recharge_money'    => $recharge_money,
            'receipt_order_id'  => $receipt_order_id,
            'time'              => time(),
        );

        $refund_id = M('pms_order_refund')->add($refund);

        if($refund_id){ //记录退货数量到"pms_order_refund_item"表
            foreach ($goods_list as $key => $g){
                $data[$key] = array(
                    'refund_id' => $refund_id,
                    'goods_id' => $g['gid'],
                    'warehouse_goods_id' => $goods_data[$g['gid']]['wgid'],
                    'warehouse_id' => $warehouse_id,
                    'num' => $g['num'],
                    'is_gift' => 0,
                    'price' => $g['price'],
                    'time' => time(),
                );
                M('pms_order_refund_item')->add($data[$key]);
            }

        }

        //endregion ===================== 写入退货记录[end] ===========================\\

        //region ======================== 更新出库记录[start] =========================\\

        foreach ($goods_data as $key => $goods_num) {
            //region 更新以前的记录[开始]
            $order_g_w = M('pms_order_item_warehouse')
            ->where(array('order_id'=>$order_id,'goods_id'=>$key))
            ->order('id desc')
            ->select();

            $n_num = $goods_num['num'];
            foreach ($order_g_w as $item){
                $n_num = $n_num - $item['num'];
                if($n_num >= 0){
                    M('pms_order_item_warehouse')->where(array('id' => $item['id']))->delete();
                }else{
                    M('pms_order_item_warehouse')
                    ->data(array('num'=>abs($n_num)))
                    ->where(array('id' => $item['id']))
                    ->save();
                    break;
                }
            }
            //endregion 更新以前的记录[结束]

            //添加库存
            $warehouse_goods = M('pms_warehouse_goods')->where(array('goods_id'=>$key,'warehouse_id'=>$warehouse_id))->find();
            M('pms_warehouse_goods')
            ->data(array('num'=>$warehouse_goods['stock'] +  $goods_num['num']))
            ->where(array('id' => $warehouse_goods['id']))
            ->save();            

        }

        //endregion ===================== 更新出库记录[end] ===========================\\

        if(!empty($goods_list_gift) && $total_num_gift > 0){
            $goods_data_gift    = array();
            $goods_ids_gift     = array();
            //赠品
            $order_item_gift = M('pms_order_item')->where(array('order_id' => $order_id,'is_gift' => 1))->select();

            //赠品
            foreach ($goods_list_gift as $goods){

                $goods_data_gift[$goods['gid']]['num']   = $goods['num'];
                $goods_ids_gift[] = $goods['gid'];
            }
            //赠品
            foreach ($order_item_gift as $item){
                $goods_item_gift = $goods_data_gift[$item['goods_id']];

                if(isset($goods_item_gift)){
                    $num_gift = $item['num'] - $goods_item_gift['num'] ;
                    if($num_gift <= 0 )
                        M('pms_order_item')->where(array('id' => $item['id']))->delete();
                    else
                        M('pms_order_item')->data(array('num' => $num_gift))->where(array('id' => $item['id']))->save();
                }
            }

            //赠品
            $update_goods_gift = M('pms_goods')->where(array(
                    'id' => array('in',$goods_ids_gift),
                    'supplier_id'=>$login_info['supplier_id']
                ))->select();

            foreach ($update_goods_gift as $goods){
                M('pms_goods')->data(
                    array(
                        'stock' => $goods['stock'] + $goods_data_gift[$goods['id']]['num'],
                        'sales' => $goods['sales'] - $goods_data_gift[$goods['id']]['num']
                        ))->where(array('id' => $goods['id'],'supplier_id'=>$login_info['supplier_id']))->save();
            }


            //赠品
            M('pms_warehouse_goods')->where(array(
                    'goods_id' => array('in',$goods_ids_gift),
                    'warehouse_id' => $warehouse_id,
                    'supplier_id'=>$login_info['supplier_id']
                ))->select();

            foreach ($update_warehouse_goods_gift as $warehouse_goods){
                M('pms_warehouse_goods')->data(
                    array(
                        'stock' => $warehouse_goods['stock'] + $goods_data_gift[$warehouse_goods['goods_id']]['num']
                        ))->where(array(
                        'goods_id' => $warehouse_goods['goods_id'],
                        'supplier_id'=>$login_info['supplier_id'],
                        'warehouse_id'=>$warehouse_id
                    ))->save();

                $goods_data_gift[$warehouse_goods['goods_id']]['wgid'] = $warehouse_goods['id'];
            }

            //region ======================== 写入退货记录[start] ===========================\\

            if($refund_id){ //记录退货数量到"pms_order_refund_item"表

                //赠品
                foreach ($goods_list_gift as $key => $g){
                    $data_gift[$key] = array(
                        'refund_id' => $refund_id,
                        'goods_id' => $g['gid'],
                        'warehouse_goods_id' => $goods_data_gift[$g['gid']]['wgid'],
                        'warehouse_id' => $warehouse_id,
                        'num' => $g['num'],
                        'price' => 0,
                        'is_gift' => 1,
                        'time' => time(),
                    );
                }
                M('pms_order_refund_item')->addAll($data_gift);
            }

            //endregion ===================== 写入退货记录[end] ===========================\\

            //赠品
            foreach ($goods_data_gift as $key => $goods_num) {
                //region 更新以前的记录[开始]
                $order_g_w = M('pms_order_item_warehouse')
                ->where(array('order_id'=>$order_id,'goods_id'=>$key))
                ->order('id desc')
                ->select();

                $n_num = $goods_num['num'];
                foreach ($order_g_w as $item){
                    $n_num = $n_num - $item['num'];
                    if($n_num >= 0){
                        M('pms_order_item_warehouse')->where(array('id' => $item['id']))->delete();
                    }else{
                        M('pms_order_item_warehouse')
                        ->data(array('num' => abs($n_num)))
                        ->where(array('id' => $item['id']))
                        ->save();
                        break;
                    }
                }
                //endregion 更新以前的记录[结束]

                //添加库存
                $warehouse_goods = M('pms_warehouse_goods')->where(array('goods_id'=>$key,'warehouse_id'=>$warehouse_id))->find();
                M('pms_warehouse_goods')
                ->data(array('num'=>$warehouse_goods['stock'] + $goods_num['num']))
                ->where(array('id' => $warehouse_goods['id']))
                ->save();

            }
        }

        $this->ajaxReturn(array('status'=>1,'msg'=>'退货成功'));
    }

    /**
     * 客户充值
     **/
    public function recharge(){
        $login_info = session('pms_supplier');

        //如果是表单提交操作，执行数据添加，否则只展示充值页面
        if($_POST['type']){

            //查询登录账号所属的供应商名称
            $supplier = M('pms_supplier')->field('name')->where(array('is_del'=>0,'id'=>$login_info['supplier_id']))->find();
            //数据收集
            $data = array(
                'recharge_sn'     =>    'CZ'.date('Ymdhis',time()).rand(10,99),
                'account'         =>    $_POST['location_name'],
                'location_id'     =>    intval($_POST['location_id']),
                'location_name'   =>    $_POST['location_name'],
                'supplier_id'     =>    intval($login_info['supplier_id']),
                'supplier_name'   =>    $supplier['name'],
                'recharge_amount' =>    $_POST['recharge_amount'],
                'login_user_id'   =>    intval($login_info['id']),
                'login_user_name' =>    $login_info['a_name'],
                'create_time'     =>    time(),
                'remark'          =>    $_POST['remark']
            );

            //判断数据合法性
            if(empty($data['location_id']))
                $this->ajaxReturn(array('status'=>'0','msg'=>'请选择需要充值的客户'));
            if(empty($data['recharge_amount']))
                $this->ajaxReturn(array('status'=>'0','msg'=>'请填写充值金额'));
            if(!is_numeric($data['recharge_amount']) || $data['recharge_amount'] < 0)
                $this->ajaxReturn(array('status'=>'0','msg'=>'请填写正确的充值金额'));

            //判断是否存在充值账户
            $info = M('pms_recharge')->where(array('location_id'=>$data['location_id'],'supplier_id'=>$data['supplier_id']))->find();

            //添加一条账户信息
            if(!$info){
                $add = array(
                    'account'        =>  $data['location_name'],
                    'location_id'    =>  $data['location_id'],
                    'location_name'  =>  $data['location_name'],
                    'supplier_id'    =>  $data['supplier_id'],
                    'supplier_name'  =>  $data['supplier_name'],
                    'balance'        =>  $data['recharge_amount'],
                    'create_time'    =>   time(),
                    'is_del'         =>   0,
                    'remark'         =>   $data['remark']
                );
                $add['update_time'] = $add['create_time'];

                //默认充值(type==1)，如果是扣减类型(预留扩展功能)
                if(intval($_POST['type']) == 2){
                    $add['balance'] = -$data['recharge_amount'];
                }

                $result = M('pms_recharge')->add($add);
            }else{
                if(intval($_POST['type']) == 1){
                    $value = $data['recharge_amount'];
                }else{
                    $value = -$data['recharge_amount'];
                }
                $v['update_time'] = time();
                $result = M('pms_recharge')
                ->where(array('location_id'=>$data['location_id'],'supplier_id'=>$data['supplier_id']))
                ->setInc('balance',$value);
                $res = M('pms_recharge')->data($v)->where(array('location_id'=>$data['location_id'],'supplier_id'=>$data['supplier_id']))->save();
            }
            if($result){
                $message = array(
                    'status'    =>  '1',
                    'msg'       =>  '充值成功'
                );
            }else{
                $message = array(
                    'status'    =>  '0',
                    'msg'       =>  '充值失败'
                );
            }
            //添加充值记录
            $insert = M('pms_recharge_record')->add($data);

            if(!$insert){
                $message = array(
                    'status'    =>  '0',
                    'msg'       =>  '添加充值记录失败'
                );
            }
            $this->ajaxReturn($message);

        }else{

            //查询供应商客户
            $location = M('pms_location')->field('location_id','location_name','contact','mobile','address')
            ->where(array('is_del'=>0,'supplier_id'=>$login_info['supplier_id']))
            ->order('id desc')
            ->limit(5)
            ->select();

            $this->assign('location',$location);
            $this->display();
        }
    }


}