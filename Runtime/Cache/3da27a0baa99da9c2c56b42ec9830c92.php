<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
.my_od_1{border-bottom: 1px solid #eee;}
.infopad{margin:8px 0;}
</style>
<?php if(is_array($order_list)): $i = 0; $__LIST__ = $order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ol): $mod = ($i % 2 );++$i;?><div class="container-fluid">
	    <div class="row">
	        <div class="col-xs-12">
	            <a href="<?php echo U('SupSale/detail',array('id'=>$ol['id']));?>" class="my_od">
	                <span style="float:left; font-size:13px; font-weight:bold;"><?php echo ($ol["goods_name"]); ?></span>
	                <div class="pull-right">                   
	                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
	                </div>  
	            </a>    
	        </div>
	    </div>
	    <div class="row" >
	        <div class="col-xs-12">         
	            <a href="<?php echo U('SupSale/detail',array('id'=>$ol['id']));?>" class="my_od_1">
	                <div class="my_od_f">
	                    <div class="infopad">销售数量：<?php echo ($ol["total_num"]); ?></div>
	                    <div class="infopad">销售金额：￥<?php echo (price($ol["tice"])); ?></div>
	                </div>
	            </a>
	                    
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-xs-12">
	            <a class="btn btn-default btn-sm" href="<?php echo U('SupSale/detail',array('id'=>$ol['id'],'start_time'=>$start_time,'end_time'=>$end_time));?>"  style="float:right;margin:10px 0;">查看详情</a>                   
	        </div>
	    </div>
	</div>

	<div class="container-fluid line"></div><?php endforeach; endif; else: echo "" ;endif; ?>