<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><!--活动列表-->
    <div class="container-fluid">
        <div class="row" style="position:relative;">
            <div class="Cheyou_1">
                <a href="<?php echo U('activity_detail',array('id'=>$list['id']));?>"><img src="<?php echo ($list["cover_img"]); ?>!thumbnail"></a>
            </div>
            <div class="Cheyou_2 my_od_f">
                <h3><a href="<?php echo U('activity_detail',array('id'=>$list['id']));?>" style="color:#474747; text-decoration:none;"><?php echo ($list["name"]); ?></a></h3>            
                <p>时间：<?php echo (date("Y-m-d",$list["star_time"])); ?> 至 <?php echo (date("Y-m-d",$list["end_time"])); ?></p>
                <p>地点：<?php echo ($list["type"]); ?></p>
                <p>费用：<?php echo ($list["cost"]); ?></p>
            </div>        
            <button type="button" style="position:absolute; bottom:5px; right:5px;" class="btn btn-<?php echo ($list["class"]); ?>"><?php echo ($list["status"]); ?></button>
            <!--一下两个按钮  在不同情况下样式不同
            <button type="button" style="position:absolute; bottom:5px; right:5px;" class="btn btn-danger">进行中</button>
            <button type="button" style="position:absolute; bottom:5px; right:5px;" class="btn btn-default" disabled="disabled">已结束</button>  
            -->          
        </div>    
    </div><?php endforeach; endif; else: echo "" ;endif; ?>