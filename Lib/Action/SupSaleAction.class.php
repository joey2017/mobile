<?php
class SupSaleAction extends SupBaseAction
{
    public function sale_detail()
    {
        $t=intval($_REQUEST['t'])==0?2:intval($_REQUEST['t']);

        $class_list=M('pms_class')->where('is_del=0')->order('sort asc')->select();
        foreach ($class_list as $k => $v) {
            if($v['pid']==0){
                $cl[$v['id']]['c_name']=$v['class_name'];
            }else{
                $cl[$v['pid']]['item'][]=$v;
            }

            if($v['id']==$t){
                $class_name=$v['class_name'];
            }
        }

        $attr_list=M('pms_attr')->field('id,attr_name,attr_val')->where('class_id=2')->order('sort desc')->select();

        foreach ($attr_list as $k => $v) {
            $attr_list[$k]['attr_val'] = explode(',', $v['attr_val']);
        }

        $this->assign('title','销售明细');
        $this->assign('t',$t);
        $this->assign('class_name',$class_name);
        $this->assign('class_list',$cl);
        $this->assign('attr_list',$attr_list);
        $this->display();
    }

    public function detail()
    {
        $id         = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $start_time = isset($_GET['start_time']) ? intval($_GET['start_time']) : '';
        $end_time   = isset($_GET['end_time']) ? intval($_GET['end_time']) : '';
        if($id <= 0)
            $this->error('商品不存在');
        $goods = M('pms_goods')->field('goods_name')->where('id = '.$id)->find();
        $this->assign('id',$id);
        $this->assign('goods',$goods);
        $this->assign('start_time',$start_time);
        $this->assign('end_time',$end_time);
        $this->assign('title','商品销售详情');
        $this->display();
    }

    /**
     * 单个商品销售列表
     *  
     * @DateTime 2017-11-09
     * @return   [type]     [description]
     */
    public function lists()
    {
        $id         = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $start_time = isset($_GET['start_time']) ? intval($_GET['start_time']) : '';
        $end_time   = isset($_GET['end_time']) ? intval($_GET['end_time']) : '';
        $page       = intval($_GET['currentpage']);
        $limit      = ($page * 8) . ",8";
        if($id <= 0)
            $this->error('商品不存在');

        $whereBase = array(
            'po.is_del'      => 0,
            'po.is_refund'   => 0,
            'po.system'      => 0,
            'po.pay_status'  => array('in','1,2'),
            'po.supplier_id' => $_SESSION['pms_supplier']['supplier_id'],
            'poi.goods_id'   => $id
        );

        $model = M('pms_order_item as poi');
        if(!empty($start_time) && is_numeric($start_time) && !empty($end_time) && is_numeric($end_time)){
            $new_end_time = $end_time + 60 * 60 * 24;//时间戳加一天
            $where['po.create_time'] = array('between', array($start_time,$new_end_time));
            $model->where($where); 
        }

        $sale_list = $model
        ->field('po.id,po.order_sn,po.create_time,po.location_name,po.receive_user,po.receive_tel,poi.sell_price,poi.num')
        ->where($whereBase)
        ->join('fw_pms_order as po ON po.id=poi.order_id')
        ->order('po.id')
        ->limit($limit)
        ->select();
        foreach ($sale_list as $k => &$v) {
            $v['total_price'] = $v['sell_price']*$v['num'];
        }
        // echo M()->getLastSql();die;
       
        // echo '<pre>';
        //     print_r($sale_list);
        // echo '</pre>';die;
        if(!empty($sale_list)){
            $this->assign('sale_list',$sale_list);
            echo $this->fetch();
        }else{
            echo '';
        }
    }
    
    //获取商品销售明细
    public function ajax_get_sale_detail_goods()
    {
        $keyword   = isset($_GET['keyword'])  ? trim($_GET['keyword']) : '';
        $class_id  = isset($_GET['class_id']) ? intval($_GET['class_id']) : 2;//默认轮胎分类id
        $attr      = isset($_GET['attr_value']) ? trim($_GET['attr_value']) : '';
        $start_time= isset($_GET['start_time']) ? strtotime($_GET['start_time']) : '';
        $end_time  = isset($_GET['end_time']) ? strtotime($_GET['end_time']) : '';
        $sort      = isset($_GET['sort']) ? intval($_GET['sort']) : 0;
        $page      = intval($_GET['currentpage']);
        $limit     = ($page * 8) . ",8";
        $whereSQL  = '';

        $whereBase = array(
            'po.is_del'      => 0,
            'po.is_refund'   => 0,
            'po.system'      => 0,
            'po.pay_status'  => array('in','1,2'),
            'po.supplier_id' => $_SESSION['pms_supplier']['supplier_id']
        );

        $model = M('pms_goods as pg');
        //根据关键字搜索
        if($keyword){
            $whereBase['pg.goods_name'] = array('like', '%' . $keyword . '%');
        }

        // 根据时间搜索
        if (isset($start_time) && is_numeric($start_time) && $start_time != 0 &&
            isset($end_time) && is_numeric($end_time) && $end_time != 0)
        {
            $new_end_time = $end_time + 60 * 60 * 24;//时间戳加一天
            $whereBase['po.create_time'] = array('between', array($start_time,$new_end_time));
        }

        //分类
        if($class_id){
            $whereBase['pg.class_id'] = $class_id;
        }

         //按排序
        if(in_array($sort, array(0,1,2,3,4))){
            switch ($sort) {
                case 0:
                    $model->order('pg.id desc');
                    break;
                case 1:
                    $model->order('tice asc');
                    break;
                case 2:
                    $model->order('tice desc');
                    break;
                case 3:
                    $model->order('total_num desc');
                    break;
                case 4:
                    $model->order('total_num asc');
                    break;
            }
        }


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
                $where .= " and (";
                foreach($v as $vl){
                    $where .= " FIND_IN_SET('".$k.":".$vl."',pga.attr_val) or";
                }
                //去掉多余的or
                $where = substr($where,0,-2);
                $where .= ")";

            }
            $where = substr($where,4);
            $model->where($where);
        }

        $order_list = $model
            ->field(' SUM(poi.num) as total_num,SUM(poi.num * poi.sell_price) as tice,pg.id,pg.goods_name')
            ->join(' fw_pms_goods_attr as pga ON pg.id = pga.goods_id')
            ->join(' fw_pms_order_item as poi ON pg.id = poi.goods_id')
            ->join(' fw_pms_order as po ON poi.order_id = po.id')
            ->group('poi.goods_id')
            ->where($whereBase)
            ->limit($limit)->select();

        // echo M()->getLastSql();die;
        if(!empty($order_list)){
            $this->assign('order_list',$order_list);
            $this->assign('start_time',$start_time);
            $this->assign('end_time',$end_time);
            echo $this->fetch('sale_list');
        }else
            echo '';
    }

    /**
     * 销售汇总页面
     *  
     * @DateTime 2017-11-06
     * @return   void
     */
    public function sales_summary()
    {
        $this->assign('title','销售汇总');
        $this->display();
    }

    /**
     * ajax获取销售汇总信息
     *
     * @DateTime 2017-11-07
     * @return   void
     */
    public function get_sales_summary()
    {
        $login_info = session('pms_supplier');
        $id = intval($_REQUEST['id']);
        $start_time = isset($_REQUEST['start_time']) ? intval(strtotime($_REQUEST['start_time'])) : '';
        $end_time   = isset($_REQUEST['end_time']) ? intval(strtotime($_REQUEST['end_time'])) : '';

        $where = array(
            'location_id'=>$id ,
            'supplier_id'=>$login_info['supplier_id']
        );

        // 根据时间搜索
        if (isset($start_time) && is_numeric($start_time) && $start_time != 0 && isset($end_time) && is_numeric($end_time) && $end_time != 0) {
            $new_end_time = $end_time + 60 * 60 * 24;//时间戳加一天
            $where['create_time'] = array('between', $start_time . ',' . $new_end_time);
        }

        $results = M('pms_order')
            ->field('Round(SUM(total_price),2) as total_price , COUNT(*) as total_num')
            ->where($where)
            ->find();

        $this->ajaxReturn(array('status'=>1,'results'=>$results));
    }

    /**
     * 查询下单门店
     *  
     * @DateTime 2017-11-06
     * @return   void
     */
    public function get_order_location(){
        $val        = I('post.name');
        $login_info = session('pms_supplier');
        $search     = array();
        $html       = "";
        $map = array('supplier_id'=>$login_info['supplier_id'],'is_del'=>0);
        if($val){
            $search['location_name'] = array('like', '%' . $val . '%');
            $search['contact']       = array('like', '%' . $val . '%');
            $search['address']       = array('like', '%' . $val . '%');
            $search['_logic']        = 'or';
            $map['_complex']         = $search;
        }
        $location = M('pms_location')
            ->field('id,location_id,location_name,contact,mobile,address')
            ->where($map)
            ->order('id desc')
            ->limit(10)
            ->select();

        
        echo json_encode($location);exit;
    }

    //经营报表
    public function operating_statement()
    {
        $start_time     = isset($_REQUEST['start_time']) ? intval(strtotime(trim($_REQUEST['start_time']))) : '';
        $end_time       = isset($_REQUEST['end_time']) ? intval(strtotime(trim($_REQUEST['end_time']))) : '';
        $login_info     = session('pms_supplier');
        $which_payments = array('system' => 0, 'is_refund' => 0, 'is_del' => 0, 'supplier_id' => $login_info['supplier_id']);
        $which_sales    = array(
            'system'           => 0,
            'is_refund'        => 0,
            'is_del'           => 0,
            'pay_time'         => array('gt', '0'),
            'supplier_id'      => $login_info['supplier_id'],
            'pay_status'       => 1,
            'means_of_payment' => array('in', '0,3,4,5,6')
        );

        $searchTime = false;
        // 根据时间搜索
        if (isset($start_time) && is_numeric($start_time) && $start_time != 0 && isset($end_time) && is_numeric($end_time) && $end_time != 0) {
            $new_end_time = $end_time + 60 * 60 * 24;//时间戳加一天
            $searchTime = true;
        }

        if ($searchTime)
            $which_sales['create_time'] = array('between', $start_time . ',' . $new_end_time);

        //销售
        $results_sales = M('pms_order')
            ->field("count(*) as 销售数量,IFNULL(sum(total_price),0) as 销售金额,IFNULL(sum(discount_price),0) as 抵扣金额,IFNULL(sum(costs),0) as 销售成本,IFNULL(sum(paid_amount),0) as 实收金额")
            ->where($which_sales)
            ->find();
        $results_sales['挂账金额']  = $results_sales['销售金额'] - $results_sales['实收金额'];
        $results_sales['销售利润'] = $results_sales['销售金额'] - $results_sales['销售成本'];
        $results_sales['毛利率']   = number_format(($results_sales['销售金额'] - $results_sales['销售成本']) / $results_sales['销售金额'] * 100, 2);


        $results_payments = array(
            '其他'   => array('num' => 0, 'price' => 0),
            '支付宝'  => array('num' => 0, 'price' => 0),
            '微信支付' => array('num' => 0, 'price' => 0),
            '余额支付' => array('num' => 0, 'price' => 0),
            '现金支付' => array('num' => 0, 'price' => 0),
            '刷卡支付' => array('num' => 0, 'price' => 0),
            '转账支付' => array('num' => 0, 'price' => 0),
            '物流代收' => array('num' => 0, 'price' => 0),
            '合计'   => array('num' => 0, 'price' => 0),
        );

        //付款方式
        $which_payments['pod.pay_time'] = array('between', array($start_time, $new_end_time));
        $results = M('pms_order')
            ->field('count(*) as total_num, sum(pod.price) as paid_price,pod.means_of_payment')
            ->join('fw_pms_order_deal as pod ON pod.order_id=fw_pms_order.id')
            ->where($which_payments)
            ->group('pod.means_of_payment')
            ->select();

        foreach ($results as $v) {
            switch ($v['means_of_payment']) {
                case 0:
                    $results_payments['其他']['num']   = $v['total_num'];
                    $results_payments['其他']['price'] = $v['paid_price'];
                    break;
                case 1:
                    $results_payments['支付宝']['num']   = $v['total_num'];
                    $results_payments['支付宝']['price'] = $v['paid_price'];
                    break;
                case 2:
                    $results_payments['微信支付']['num']   = $v['total_num'];
                    $results_payments['微信支付']['price'] = $v['paid_price'];
                    break;
                case 3:
                    $results_payments['现金支付']['num']   = $v['total_num'];
                    $results_payments['现金支付']['price'] = $v['paid_price'];
                    break;
                case 4:
                    $results_payments['余额支付']['num']   = $v['total_num'];
                    $results_payments['余额支付']['price'] = $v['paid_price'];
                    break;
                case 5:
                    $results_payments['转账支付']['num']   = $v['total_num'];
                    $results_payments['转账支付']['price'] = $v['paid_price'];
                    break;
                case 6:
                    $results_payments['物流代收']['num']   = $v['total_num'];
                    $results_payments['物流代收']['price'] = $v['paid_price'];
                    break;
                case 7:
                    $results_payments['余额支付']['num']   = $v['total_num'];
                    $results_payments['余额支付']['price'] = $v['paid_price'];
                    break;
                default:
                    break;
            }

            $results_payments['合计']['num']   += $v['total_num'];
            $results_payments['合计']['price'] += $v['paid_price'];
        }

        //库存报表
        //采购
        $where = array(
            'is_del'      => 0,
            'supplier_id' => $login_info['supplier_id']
        );
        if ($searchTime)
            $where['create_time'] = array('between', array($start_time, $new_end_time));

        $results_purchase = M('pms_purchase')
            ->field('IFNULL(sum(ppi.num),0) as total,IFNULL(sum(purchase_meet),0) as paid_price')
            ->join('fw_pms_purchase_item as ppi ON ppi.order_id=fw_pms_purchase.id')
            ->where($where)
            ->find();
        unset($where);



        //调入
        $where = array(
            'status'      => array('neq', '0,4'),
            'supplier_id' => $login_info['supplier_id']
        );
        if ($searchTime)
            $where['add_time'] = array('between', array($start_time, $new_end_time));

        $results_allocation = M('pms_allocation_order')
            ->field('IFNULL(sum(pai.num),0) as total,IFNULL(sum(total_price),0) as paid_price')
            ->join('fw_pms_allocation_item as pai ON pai.order_id=fw_pms_allocation_order.id')
            ->where($where)
            ->find();
        unset($where);

        //调出
        $where = array(
            'status'      => array('neq', '0,4'),
            'supplier_id' => $login_info['supplier_id']
        );
        if ($searchTime)
            $where['add_time'] = array('between', array($start_time, $new_end_time));

        $results_stock = M('pms_allocation_order')
            ->field('IFNULL(sum(pai.num),0) as total,IFNULL(sum(total_price),0) as paid_price')
            ->join('fw_pms_allocation_item as pai ON pai.order_id=fw_pms_allocation_order.id')
            ->where($where)
            ->find();
        unset($where);

        //出库
        $where = array(
            'is_del'      => 0,
            'supplier_id' => $login_info['supplier_id']
        );
        if ($searchTime)
            $where['add_time'] = array('between', array($start_time, $new_end_time));

        $results_sold = M('pms_sold')
            ->field('IFNULL(sum(total_number),0) as total,IFNULL(sum(total_price),0) as paid_price')
            ->where($where)
            ->find();

        unset($where);

        //退货
        $where = array(
            'status'      => array('neq', 0),
            'supplier_id' => $login_info['supplier_id']
        );
        if ($searchTime)
            $where['add_time'] = array('between', array($start_time, $new_end_time));

        $results_returns = M('pms_return_order')
            ->field('IFNULL(sum(pri.num),0) as total,IFNULL(sum(pri.num*pri.price),0) as paid_price')
            ->join('fw_pms_return_item as pri ON pri.order_id=fw_pms_return_order.id')
            ->where($where)
            ->find();

        $results_stock = array(
            '采购' => $results_purchase,
            '调入' => $results_allocation,
            '调出' => $results_stock,
            '出库' => $results_sold,
            '退货' => $results_returns
        );

        $this->assign('results_sales', $results_sales);
        $this->assign('results_payments', $results_payments);
        $this->assign('results_stock',$results_stock );

        $this->assign("start_time", date('Y-m-d', $start_time));
        $this->assign("end_time", date('Y-m-d', $end_time));
        $this->display();
    }
}
















































