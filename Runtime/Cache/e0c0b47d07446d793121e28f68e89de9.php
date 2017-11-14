<?php if (!defined('THINK_PATH')) exit(); if(is_array($service)): $i = 0; $__LIST__ = $service;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><div class="container-fluid">
    <div class="row shoptitle">
        <div class="col-xs-7">
            <h4 class="my_od_f"><?php echo ($s["name"]); ?></h4>
            <p  class="my_od_f"><a href=""><?php echo ($s["address"]); ?></a></p>
        </div>

        <div class="col-xs-5 text-right">
            <p style="margin: 9px 0 0 0; font-size: 19px;color: #cd0000;"><?php echo ($s["distance"]); ?>km</p>
            <em>等待<?php echo ($s["wait_time"]); ?></em>
        </div>
    </div>
    <div class="<?php if($s["count"] > 2): ?>shoplist<?php else: ?>shoplist_2<?php endif; ?>">
		<?php if(is_array($s['list'])): $i = 0; $__LIST__ = $s['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sl): $mod = ($i % 2 );++$i;?><div class="reservelist">
		        <a href="<?php echo U('Advance/advance_add',array('id'=>$sl['id']));?>">
		            <div class="col-xs-8" style="padding-left:0;">
		                <span class="<?php echo ($sl["project_type"]); ?>"></span>
		                <?php echo ($sl["goods_name"]); ?>
		            </div>
		            <div class="col-xs-4 text-right">
		                <h5 class="money-h"><i><?php echo (price($sl["selling_price"])); ?></i>元</h5>
		                <i class="fa fa-angle-right"></i>
		            </div>
		        </a>
		    </div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<?php if($s["count"] > 2): ?><div class="row re_more" onclick="show_more(this)">
	        <a  class="text-center more"  style="display:block;">
	            <i class="fa fa-angle-down"></i>
	            查看更多
	        </a>
	    </div><?php endif; ?>

</div><?php endforeach; endif; else: echo "" ;endif; ?>