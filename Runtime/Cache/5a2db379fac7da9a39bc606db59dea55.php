<?php if (!defined('THINK_PATH')) exit(); if(is_array($msg_list)): $i = 0; $__LIST__ = $msg_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><li>
        <a href="<?php echo U('SupInfo/detail',array('id'=>$ml['id']));?>">
        <div class="dope-icon"><i class="iconfont icon-laba"></i></div>
        <div class="iconfont icon-jiantou-copy-copy next-more"></div>
        <div class="dope-show">
            <span>系统消息<strong><?php echo ($ml["time"]); ?>前</strong></span>
            <p><?php echo ($ml["content"]); ?></p> 
        </div>
        </a>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>