<?php if (!defined('THINK_PATH')) exit(); if(is_array($order_info)): $i = 0; $__LIST__ = $order_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$oi): $mod = ($i % 2 );++$i;?><li>
		<div class="brief-left" style="width:139px;">
			<h2 style="font-size: 14px;"><?php echo ($oi["location_name"]); ?></h2>
			<strong><?php echo ($oi["contact"]); ?></strong>
		</div>
		<div class="brief-right">
			<p>联系方式：<?php echo ($oi["mobile"]); ?></p>
			<p>授权额度：<span><?php echo (price($oi["credit_line"])); ?></span></p>
			<p>剩余额度：<span><?php echo (price($oi["surplus"])); ?></span></p>
		</div>
	</li><?php endforeach; endif; else: echo "" ;endif; ?>