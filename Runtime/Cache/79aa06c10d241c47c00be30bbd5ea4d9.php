<?php if (!defined('THINK_PATH')) exit(); if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$n): $mod = ($i % 2 );++$i;?><div class="col-xs-6 tab_subset" >
            <a href="<?php echo U('Store/style_detail',array('id'=>$n['id']));?>">
                <div class="imgtab">
                    <img src="<?php echo ($n["thumb"]); ?>">
                </div>
                <p class="stafftxt"><?php echo ($n["title"]); ?></p>
            </a>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>