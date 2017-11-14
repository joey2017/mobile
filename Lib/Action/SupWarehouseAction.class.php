<?php
class SupWarehouseAction extends SupBaseAction {

     /**
     * 权限白名单，白名单中的操作方法不受权限限制
     * 该名单主要用于一些特殊无涉及权限分配的方法
     *
     * @var array
     * @access protected
     */
    protected $accessAllowed = array(
        'ajax_get_goods','ajax_get_attr','ajax_get_warehouse','ajax_get_alarm_goods'
        );

	public function index(){

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

		$this->assign('title','诚车堂-订货管理小助手！');
		$this->assign('t',$t);
		$this->assign('class_name',$class_name);
		$this->assign('class_list',$cl);
		$this->assign('attr_list',$attr_list);
		$this->display();
	}

    //导航
    public function navig()
    {
        $this->display();
    }
    
	//获取商品
	public function ajax_get_goods(){

		$index_search = isset($_POST['index_search'])?I('post.index_search'):0;//首页搜索条件
		$class_id     = isset($_REQUEST['class_id'])?intval($_REQUEST['class_id']):2;//默认轮胎分类id
		$keyword      = isset($_REQUEST['keyword'])?trim($_REQUEST['keyword']):'';
		$attr         = isset($_REQUEST['attr_value'])?trim($_REQUEST['attr_value']):'';
		$warehouse    = isset($_REQUEST['warehouse'])?trim($_REQUEST['warehouse']):'';
		$sort         = intval($_REQUEST['sort']);
		$page         = intval($_REQUEST['currentpage']);
		$limit        = ($page*8).",8";

		//保存库存总数量变量

		$where = ' and pg.supplier_id='.$_SESSION['pms_supplier']['supplier_id'];	

		//根据关键字搜索
		if($keyword){
			$where .= " and (pg.goods_name like '%".$keyword."%' or pg.goods_number like '%".$keyword."%')";
		}

		if(!$index_search){
			$where.=" and pg.class_id=".$class_id;
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

		}

		//按数量/商品排序
		if(in_array($sort, array(0,1,2,3,4))){
			switch ($sort) {
				case 0:
					$sort = " order by pg.id asc";
					break;
				case 1:
					$sort = " order by pg.price asc";
					break;
				case 2:
					$sort = " order by pg.price desc";
					break;
				case 3:
					$sort = " order by pg.stock desc";
					break;
				case 4:
					$sort = " order by pg.stock asc";
					break;
			}			
		}


		//根据仓库筛选
		if(!empty($warehouse)){
			$where.=" and pwg.is_del=0 and pwg.warehouse_id in (".$warehouse.")";
			$goods=M()->query("select pg.id,pg.goods_name,pg.thumbnail,pg.price,pg.unit,pg.promotion_price,ps.name as supplier_name,pg.sales,pwg.stock,pw.warehouse_name from ".C('DB_PREFIX')."pms_goods as pg left join ".C('DB_PREFIX')."pms_goods_attr as pga on pga.goods_id=pg.id left join ".C('DB_PREFIX')."pms_supplier as ps on ps.id=pg.supplier_id left join ".C('DB_PREFIX')."pms_warehouse_goods as pwg on pwg.goods_id=pg.id left join ".C('DB_PREFIX')."pms_warehouse as pw on pw.id=pwg.warehouse_id where pw.is_del=0 and pg.is_sale=1 and pg.is_del=0 ".$where.$sort." limit ".$limit);
		}else{
			
			$goods=M()->query("select pg.id,pg.goods_name,pg.thumbnail,pg.price,pg.unit,pg.promotion_price,ps.name as supplier_name,pg.sales,pg.stock from ".C('DB_PREFIX')."pms_goods as pg left join ".C('DB_PREFIX')."pms_goods_attr as pga on pga.goods_id=pg.id left join ".C('DB_PREFIX')."pms_supplier as ps on ps.id=pg.supplier_id where pg.is_sale=1 and pg.is_del=0 ".$where.$sort." limit ".$limit);
		}

		foreach ($goods as $k => $v) {
			if($v['promotion_price']>0){
				$goods[$k]['price']=$v['promotion_price'];
			}
		}

        $this->assign('goods',$goods);
		$this->assign('warehouse',$warehouse);
		$this->assign('type',$_REQUEST['type']);
		echo $html=$this->fetch('Purchase:ajax_get_goods');		
	}

	//获取分类属性
	public function ajax_get_attr(){

		//默认轮胎id
		$class_id = isset($_REQUEST['class_id'])?intval($_REQUEST['class_id']):2;

		$attr_list=M('pms_attr')
            ->field('id,attr_name,attr_val')
            ->where('class_id='.$class_id)
            ->order('sort desc')
            ->select();

		foreach ($attr_list as $k => $v) {
			$attr_list[$k]['attr_val'] = explode(',', $v['attr_val']);		
		}

		$this->assign('attr_list',$attr_list);
		$this->assign('type',$_REQUEST['type']);

		echo $html=$this->fetch('Purchase:ajax_get_attr');
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

	//商品库存详情
	public function detail()
	{
		$id=intval($_GET['id']);
        $supplier_id = $_SESSION['pms_supplier']['supplier_id'];

		$where=" and pg.id=".$id;

		//详情信息
		$info=M('pms_goods as pg')
            ->join('fw_pms_goods_attr as fpga on fpga.goods_id=pg.id')
            ->join('fw_pms_supplier as fps on fps.id=pg.supplier_id')
            ->field('pg.id,pg.goods_name,pg.unit,pg.sales,pg.thumbnail,pg.price,pg.stock,pg.promotion_price,pg.market_price,pg.detail,pg.imgs,pg.car_ids,fpga.attr_val,fpga.attr_name_val,fps.name as supplier_name,fps.qq')
            ->where('pg.is_sale=1 and pg.is_del=0 and pg.supplier_id =' . $supplier_id . $where)
            ->find();

		$info['imgs']=array_values(array_filter(explode(',',$info['imgs'])));
		$attr_val=explode(',',$info['attr_name_val']);

		foreach ($attr_val as $k => $v) {
			$value=explode('：',$v);
			if($info['class_id']==2){
				if($value[0]=='胎面宽度'){
				$last_attr=$value[1].'/';
				}
				elseif($value[0]=='扁平比')
				{
					$last_attr.=$value[1].'R';
				}
				elseif($value[0]=='轮胎直径'){
					$last_attr.=$value[1];
				}
			}elseif($info['class_id']==8){
				if($value[0]=='长度'){
					$last_attr=$value[1].'*';
				}
				elseif($value[0]=='宽度')
				{
					$last_attr.=$value[1].'*';
				}
				elseif($value[0]=='高度'){
					$last_attr.=$value[1];
				}
			}
			$attr_names[]=$value[0];
			$attr_vals[]=$value[1];
		}
		
		if($info['class_id']==2){
			array_splice($attr_names, 1,0,array('1'=>'规格'));
			array_splice($attr_vals, 1,0,array('1'=>$last_attr));
		}elseif($info['class_id']==8){
			array_splice($attr_names, 1,0,array('1'=>'尺寸'));
			array_splice($attr_vals, 1,0,array('1'=>$last_attr));
		}
		
		//适用车型
		if($info['car_ids']){
			$car_list = M('car')
                ->field('id,name,parent_id,level')
                ->where('level in(0,1,2) and id in('.$info['car_ids'].')')
                ->select();
			if($car_list){
				foreach ($car_list as $k => $v) {
					if($v['level'] == 1){
						$car[$v['id']]['cate2'] = $v['name']; 
					}
					if($v['level'] == 2){
						$car[$v['parent_id']]['cate3'][] = $v['name']; 
					}
				}
				foreach ($car as $k => $v) {
					$car[$k]['cate3'] = implode(' 、', $v['cate3']);
				}
			}
		}

		$warehouse_goods = M('pms_warehouse_goods as pwg')
            ->join('fw_pms_warehouse as pw ON pw.id = pwg.warehouse_id')
            ->where(array('pwg.goods_id'=>$id,'pwg.is_del'=>0,'pwg.supplier_id'=>$supplier_id))
            ->select();

		$this->assign('cart_num',intval($cart_info['number']));
		$this->assign("attr_vals",$attr_vals);
		$this->assign("attr_names",$attr_names);
		$this->assign("car",$car);
		$this->assign("warehouse_goods",$warehouse_goods);
		$this->assign('info',$info);
		$this->assign('title',$info['goods_name']);
		$this->display();
	}

    public function stockAlarm()
    {
        $t = intval($_REQUEST['t']) == 0 ? 2 : intval($_REQUEST['t']);

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

        $attr_list = M('pms_attr')->field('id,attr_name,attr_val')->where('class_id=2')->order('sort desc')->select();

        foreach ($attr_list as $k => $v) {
            $attr_list[$k]['attr_val'] = explode(',', $v['attr_val']);
        }

        $this->assign('title','诚车堂-订货管理小助手！');
        $this->assign('t',$t);
        $this->assign('class_name',$class_name);
        $this->assign('class_list',$cl);
        $this->assign('attr_list',$attr_list);
        $this->display();
    }

    //获取库存警报商品
    public function ajax_get_alarm_goods(){

        $index_search = isset($_REQUEST['index_search']) ? intval($_REQUEST['index_search']) : 0;//首页搜索条件
        $class_id     = isset($_REQUEST['class_id']) ? intval($_REQUEST['class_id']) : 2;//默认轮胎分类id
        $keyword      = isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';
        $attr         = isset($_REQUEST['attr_value']) ? trim($_REQUEST['attr_value']) : '';
        $sort         = intval($_REQUEST['sort']);
        $price_sort   = intval($_REQUEST['price_sort']);
        $page         = intval($_REQUEST['currentpage']);
        $limit        = ($page * 8) . ",8";
        
        $where        = '';


        //根据关键字搜索
        if($keyword){
            $where .= " and pg.goods_name like '%".$keyword."%'";
        }

        if(!$index_search){
            $where.=" and pg.class_id=".$class_id;
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
        }

        //按销量排序
        if(in_array($sort, array(0,1,2,3,4))){
            switch ($sort) {
                case 0:
                    $sort = " order by pg.id asc";
                    break;
                case 1:
                    $sort = " order by pg.price asc";
                    break;
                case 2:
                    $sort = " order by pg.price desc";
                    break;
                case 3:
                    $sort = " order by pg.sales desc";
                    break;
                case 4:
                    $sort = " order by pg.sales asc";
                    break;
            }
        }

        $supplier_id = $_SESSION['pms_supplier']['supplier_id'];

        $where.=" and pg.alarm_minstock > pg.stock and supplier_id = ".$supplier_id;

        $goods=M()->query("select pg.id,pg.goods_name,pg.thumbnail,pg.alarm_minstock,pg.stock,pg.price,pg.unit,pg.promotion_price,ps.name as supplier_name,pg.sales from fw_pms_goods as pg left join fw_pms_goods_attr as pga on pga.goods_id=pg.id left join fw_pms_supplier as ps on ps.id=pg.supplier_id where pg.is_sale=1 and pg.is_del=0 ".$where.$sort." limit ".$limit);

        foreach ($goods as $k => $v) {
            if($v['promotion_price']>0){
                $goods[$k]['price']=$v['promotion_price'];
            }
        }

        $this->assign('goods',$goods);
        echo $html=$this->fetch();
    }
}