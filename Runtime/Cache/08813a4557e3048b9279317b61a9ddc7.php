<?php if (!defined('THINK_PATH')) exit(); if(is_array($qualitygoods)): $i = 0; $__LIST__ = $qualitygoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><div class="col-xs-6 tab_subset producttab">
		<div class="proinfo">
			<a href="<?php echo U('Purchase/detail',array('id'=>$g['id']));?>" class="btn-block">
				<img src="<?php echo ($g["thumbnail"]); ?>!purchase">
				<p><?php echo ($g["goods_name"]); ?></p>
				<div class="d-main">
	    			<span class="price">￥:<?php echo (price($g["price"])); ?></span> 
	    			<span>/<?php echo ($g["unit"]); ?></span>
	    			<span class="pull-right">已售 <?php echo ($g["sales"]); ?></span>
	    		</div>
    		</a>
		</div>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>