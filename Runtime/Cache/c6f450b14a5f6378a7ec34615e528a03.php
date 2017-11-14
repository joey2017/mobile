<?php if (!defined('THINK_PATH')) exit(); if(is_array($order)): $i = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><!--分割线-->
<div class="container-fluid line"></div>

<style type="text/css">
.my_od_1{border-bottom: 1px solid #eee;}
.infopad{margin:8px 0;}
</style>



<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <a href="<?php echo U('Biz/purchase_detail',array('id'=>$order['id']));?>" class="my_od">
                <span style="float:left; font-size:16px; font-weight:bold;"><?php echo ($order["order_sn"]); ?></span>
                <div class="pull-right">                   
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                </div>  
            </a>    
        </div>
    </div>
    <div class="row" >
        <div class="col-xs-12">         
            <a href="" class="my_od_1">
                <div class="my_od_f">
                    <div class="infopad">订单状态：<?php echo ($order["order_status"]); ?></div>
                    <div class="infopad">优惠金额：￥<?php echo (price($order["discount_price"])); ?></div>
                    <div class="infopad">订单金额：<span style="font-weight:bold;color:#F00;">￥<?php echo (price($order["total_price"])); ?></span></div>
                    <div class="infopad">下单时间：<?php echo (date("Y-m-d H:i:s",$order["create_time"])); ?></div>
                </div>
            </a>
                    
        </div>
    </div>
   <!--  <div class="row">       
        <div class="col-xs-12">
            <div style=" line-height: 35px;  border-bottom: 1px solid #e0e0e0; text-align: right;">                
                    <?php echo ($order["order_status"]); ?> 111       
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="col-xs-12">
            <?php if($order['is_del'] == 0): if($order['pay_status'] == 0 AND $type == 3): ?><a type="button" href="<?php echo U('Purchase/order',array('id'=>$order['id'],'t'=>'pms_merge_order'));?>" style="float:right;margin:10px 6px;" class="btn btn-warning btn-sm">提交订单</a><?php endif; ?>  
                <?php if($type == 1 || $type == 2 || $type == 5): if($order['purchase_user_id'] == 0 && $order['type'] == 2): ?><a type="button" href="<?php echo U('Purchase/order',array('id'=>$order['id'],'t'=>'pms_order'));?>" style="float:right;margin:10px 6px;" class="btn btn-warning btn-sm">确认订单</a><?php endif; ?>
                    <?php if($order['status'] == 2): ?><a type="button" href="<?php echo U('Purchase/receipt_goods',array('id'=>$order['id']));?>" style="float:right;margin:10px 6px;" class="btn btn-warning btn-sm">确认收货</a><?php endif; endif; endif; ?>
            <a class="btn btn-default btn-sm" href="<?php if($type == 1 || $type == 2 || $type == 5): echo U('Biz/purchase_detail',array('id'=>$order['id'])); else: echo U('Biz/merge_order_detail',array('id'=>$order['id'])); endif; ?>"  style="float:right;margin:10px 0;">查看详情</a>                   
               
        </div>
    </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>