<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gs): $mod = ($k % 2 );++$k;?><div class="col-xs-6 zsimg" <?php if($k == 3): ?>style="clear: both;"<?php endif; ?>>
    	<a href="<?php echo U('Store/view',array('id'=>$gs['id']));?>">
        	<img class="lazy_img" src="<?php echo (getimgurl($gs["preview"],'large')); ?>"  onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');">
            <div><?php echo ($gs["name"]); echo ($gs["preview"]); ?></div>
        </a>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
<script type="text/javascript">

</script>