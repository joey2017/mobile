<?php if (!defined('THINK_PATH')) exit(); if(is_array($sale_list)): $i = 0; $__LIST__ = $sale_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sl): $mod = ($i % 2 );++$i;?><div class="container-fluid">
	    <div class="row">
	        <div class="col-xs-12">
	            <a class="my_od">
	                <span style="float:left;"><?php echo ($sl["order_sn"]); ?></span>
	                <div style="height:45px;">                   
	                </div>  
	            </a>    
	        </div>
	    </div>
	    <div class="row" >
	        <div class="col-xs-12">         
	            <a class="my_od_1">
	                <div class="my_od_f" style="white-space: normal;">
	                    <div class="infopad" style="word-wrap:">门店名称：<?php echo ($sl["location_name"]); ?></div>
	                    <div class="infopad">联系人：<?php echo ($sl["receive_user"]); ?></div>
	                    <div class="infopad">联系方式：<?php echo ($sl["receive_tel"]); ?></div>
	                    <div class="infopad">销售数量：<?php echo (intval($sl["num"])); ?></div>
	                    <div class="infopad">销售金额：￥<?php echo (price($sl["total_price"])); ?></div>
	                    <div class="infopad">下单时间：<?php echo (date('Y-m-d H:i:s',$sl["create_time"])); ?></div>
	                </div>
	            </a>
	                    
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-xs-12">
	            <a style="float:right;height:30px;"></a>                   
	        </div>
	    </div>
	</div>

	<div class="container-fluid line"></div><?php endforeach; endif; else: echo "" ;endif; ?>