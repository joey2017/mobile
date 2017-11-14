<?php if (!defined('THINK_PATH')) exit(); if(is_array($order_info)): $i = 0; $__LIST__ = $order_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$oi): $mod = ($i % 2 );++$i;?><li>
		<div class="brief-left" style="width:160px;">
			<h2 style="font-size: 14px;"><?php echo ($oi["location_name"]); ?></h2>
			<strong><?php echo ($oi["contact"]); ?></strong>
		</div>
		<div class="brief-right">
			<p>交易订单：<?php echo (intval($oi["order_count"])); ?></p>
			<p>交易金额：<span><?php echo (price($oi["order_price"])); ?></span></p>
			<p>余额：<span><?php echo (price($oi["balance"])); ?></span></p>
		</div>
	</li><?php endforeach; endif; else: echo "" ;endif; ?>