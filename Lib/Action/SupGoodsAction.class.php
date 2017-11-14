<?php
class SupGoodsAction extends SupBaseAction {

    /**
     * 选择商品
     */
	public function chooes_goods(){
        $login_info = session('pms_supplier');
        $class_id   = isset($_REQUEST['class_id']) ? intval($_REQUEST['class_id']) : 2;//默认轮胎分类id
        $page       = isset($_GET['p']) ? intval($_GET['p'])  : 0;
        $keyword    = isset($_GET['k']) ? htmlspecialchars(strip_tags($_GET['k']), ENT_QUOTES, 'UTF-8') : '';
        $attr       = isset($_REQUEST['attr']) ? trim($_REQUEST['attr']) : '';
        $sort       = intval($_REQUEST['sort']);
        $limit      = ($page * 10).",10";

        $map = array(
            'pg.is_del'       => 0,
            'pg.is_sale'      => 1,
            'pwg.is_del'      => 0,
            'pwg.supplier_id' => $login_info['supplier_id'],
            'pg.supplier_id'  => $login_info['supplier_id'],
            'pg.is_merge'     => 0
        );

        $model = M('pms_goods as pg');

        // 名称模糊搜索
        $where = array();
        if($keyword !== ''){
            $where['pg.goods_name']   = array('like', '%' . $keyword . '%');
            $where['pg.goods_number'] = array('like', '%' . $keyword . '%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }

        // 赠品只选轮胎
        /*if($is_gift == 'gift'){
            $map['pg.class_id'] = array(array('eq',2),array('eq',43), 'or') ;
        }*/

        // 按分类筛选
        if($class_id > 0){
            $map['pg.class_id'] = $class_id;
        }

        //根据条件筛选
        if($attr){
            $filter = '';
            $attr = explode(',', $attr);
            //6:邓禄普,1:125,1:135,1:275,2:20,2:40,2:55,3:13,11:70,11:119,7:M,95:660,95:668
            foreach ($attr as $k => $v) {
                $attr[$k] = explode(':',$v);
            }
            foreach($attr as $a){
                $attr_list[$a[0]][] = $a[1];
            }
            foreach ($attr_list as $k => $v) {
                $filter .= " and (";
                foreach($v as $vl){
                    $filter .= " FIND_IN_SET('".$k.":".$vl."',pga.attr_val) or";
                }
                //去掉多余的or
                $filter = substr($filter,0,-2);
                $filter .= ")";
                $filter_sql = substr($filter,5);

            }
            $model->where($filter_sql);
        }

        //按排序
        if(in_array($sort, array(0,1,2,3,4))){
            switch ($sort) {
                case 0:
                    $model->order('pg.id desc');
                    break;
                case 1:
                    $model->order('pg.price asc');
                    break;
                case 2:
                    $model->order('pg.price desc');
                    break;
                case 3:
                    $model->order('pg.sales desc');
                    break;
                case 4:
                    $model->order('pg.sales asc');
                    break;
            }
        }


        $results = $model->field('pg.goods_name,pg.is_sale,pg.id,pg.costs,pg.class_id,pg.unit,pg.price,pg.stock,pg.is_merge,sum(pwg.stock) as warehouse_stock,pwg.id as pwgid,pwg.warehouse_id,pc.class_name,pg.goods_number,pg.thumbnail')
            ->join('fw_pms_warehouse_goods as pwg on pwg.goods_id=pg.id')
            ->join('fw_pms_goods_attr as pga ON pga.goods_id=pg.id')
            ->join('fw_pms_class as pc on pc.id=pg.class_id')
            ->where($map)
            ->group('pwg.goods_id')
            ->limit($limit)
            ->select();

        if(empty($results))
            $this->ajaxReturn(0);


        $this->assign('results', $results);

       echo $html = $this->fetch();
    }

    /**
     * @DateTime  2017-11-06
     * @param     [id]
     * @return    [type]      [description]
     */
    public function detail()
    {
        $id=intval($_GET['id']);
        if(!session('pms_supplier')){
            session('redirect_url',U('SupGoods/detail',array('id'=>$id)));
            header("Location:".U("SupLogin/login"));

        }

        $where=" and pg.id=".$id;

        //详情信息
        $info=M('pms_goods as pg')
        ->join('fw_pms_goods_attr as fpga on fpga.goods_id=pg.id')
        ->join('fw_pms_supplier as fps on fps.id=pg.supplier_id')
        ->field('pg.id,pg.goods_name,pg.unit,pg.sales,pg.thumbnail,pg.price,pg.stock,pg.promotion_price,pg.market_price,pg.detail,pg.imgs,pg.car_ids,fpga.attr_val,fpga.attr_name_val,fps.name as supplier_name,fps.qq')
        ->where('pg.is_sale=1 and pg.is_del=0 '.$where)
        ->find();

        if(!$info){
            $this->error('商品不存在或已下架');
        }

        $info['imgs']=array_values(array_filter(explode(',',$info['imgs'])));


        $info['detail']=str_replace('src="/ueditor/','src="http://www.17cct.com/ueditor/',$info['detail']);
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
            $car_list = M('car')->field('id,name,parent_id,level')->where('level in(0,1,2) and id in('.$info['car_ids'].')')->select();
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
        $this->assign("attr_vals",$attr_vals);
        $this->assign("attr_names",$attr_names);
        $this->assign("car",$car);
        $this->assign('info',$info);
        $this->assign('title',$info['goods_name']);
        $this->display();
    }
}