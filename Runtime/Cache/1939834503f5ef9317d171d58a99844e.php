<?php if (!defined('THINK_PATH')) exit(); if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><div class="productlist  col-xs-12">
		<?php if($type == 1): ?><a href="<?php echo U('SupWarehouse/detail',array('id'=>$g['id']));?>" class="box_flex">
		<?php else: ?>
			<a href="<?php echo U('Purchase/detail',array('id'=>$g['id']));?>" class="box_flex"><?php endif; ?>
	    	<div class="leftimg">
	    		<img src="<?php echo ($g["thumbnail"]); ?>!middle">
	    	</div>
	    	<div class="rightinfo flex1">
	    		<h3><?php echo ($g["goods_name"]); ?></h3>
	    		<div style="display: inline">
		    		<p class="text-right"><span style="font-size:12px;margin-left:3px;float: left"><?php echo ($g["warehouse_name"]); ?></span><?php echo ($g["supplier_name"]); ?></p>
	    		</div>
	    		<div class="d-main">
	    			<span class="price">￥:<?php echo (price($g["price"])); ?></span> 
	    			<span>/<?php echo ($g["unit"]); ?></span>
	    			<?php if($type == 1): ?><span class="pull-right">数量 <span style="color: #eb5211;font-size: 14px;"><?php echo ($g["stock"]); ?></span></span>
	    			<?php else: ?>
	    			<span class="pull-right">已售 <?php echo ($g["sales"]); ?></span><?php endif; ?>
	    		</div>
	    	</div>
	    </a>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>