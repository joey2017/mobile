<?php if (!defined('THINK_PATH')) exit(); if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><div class="productlist  col-xs-12">
		<a href="<?php echo U('SupWarehouse/detail',array('id'=>$g['id']));?>" class="box_flex">
	    	<div class="leftimg">
	    		<img src="<?php echo ($g["thumbnail"]); ?>!middle">
	    	</div>
	    	<div class="rightinfo flex1">
	    		<h3 style="height: 35px"><?php echo ($g["goods_name"]); ?></h3>
				<div style="font-size: 12px">库存量：<?php echo ($g["stock"]); ?></div>
				<div style="font-size: 12px">警报值：<?php echo ($g["alarm_minstock"]); ?></div>
	    		<div class="d-main">
	    			<span class="price">￥:<?php echo (price($g["price"])); ?></span>
	    			<span>/<?php echo ($g["unit"]); ?></span>
	    			<span class="pull-right">已售 <?php echo ($g["sales"]); ?></span>
	    		</div>
	    	</div>
	    </a>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>