<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
.my_od_1{border-bottom: 1px solid #eee;}
.infopad{margin:8px 0;}
</style>
<?php if(is_array($order_list)): $i = 0; $__LIST__ = $order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ol): $mod = ($i % 2 );++$i;?><div class="container-fluid">
	    <div class="row">
	        <div class="col-xs-12">
	            <a href="<?php echo U('SupOrder/detail',array('id'=>$ol['id']));?>" class="my_od">
	                <span style="float:left; font-size:16px; font-weight:bold;"><?php echo ($ol["order_sn"]); ?></span>
	                <div class="pull-right">                   
	                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
	                </div>  
	            </a>    
	        </div>
	    </div>
	    <div class="row" >
	        <div class="col-xs-12">         
	            <a class="my_od_1">
	                <div class="my_od_f">
	                    <div class="infopad">门店名称：<?php echo ($ol["location_name"]); ?></div>
	                    <div class="infopad">订单状态：<?php echo ($ol["status_msg"]); ?></div>
	                    <div class="infopad">优惠金额：￥<?php echo (price($ol["discount_price"])); ?></div>
	                    <div class="infopad">订单金额：￥<?php echo (price($ol["total_price"])); ?></div>
	                    <?php if($type == 1): ?><div class="infopad">已核销金额：<?php echo ($ol["paid_amount"]); ?></div>
	                    <div class="infopad">未核销金额：<?php echo ($ol["unpay_amount"]); ?></div><?php endif; ?>
	                    <div class="infopad">下单时间：<?php echo (date("Y-m-d H:i:s",$ol["create_time"])); ?></div>
	                </div>
	            </a>
	                    
	        </div>
	    </div>
	    <div class="row">
	    	
	        <div class="col-xs-12">
	        <?php if($type == 1): ?><!-- <button type="button" href="<?php echo U('SupOrder/receipt',array('id'=>$ol['id']));?>" style="float:right;margin:10px 6px;" class="btn btn-warning confirm btn-sm">确认收款</button> --><?php endif; ?>
	            <a class="btn btn-default btn-sm" href="<?php echo U('SupOrder/detail',array('id'=>$ol['id']));?>"  style="float:right;margin:10px 0;">查看详情</a>                   
	               
	        </div>
	    </div>
	</div>

	<div class="container-fluid line"></div><?php endforeach; endif; else: echo "" ;endif; ?>