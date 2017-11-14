<?php if (!defined('THINK_PATH')) exit(); if($order_list != null): if(is_array($order_list)): $i = 0; $__LIST__ = $order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ol): $mod = ($i % 2 );++$i;?><a href="<?php echo U('User/work_order_detail',array('id'=>$ol['id']));?>" style="color:#5f5f5f;">
                <div class="order_list">
                    <div class="order_title">
                            <b><?php echo ($ol["car_sn"]); ?></b>
                            <span>(<?php echo ($ol["status"]); ?>)</span>
                            <i class="fa fa-angle-right pull-right" style="margin-top: 12px;"></i>
                       
                    </div>
                    <?php if(is_array($ol['item'])): $i = 0; $__LIST__ = $ol['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$o): $mod = ($i % 2 );++$i;?><div class="order_info box-flex">
                            <h3 class="flex1"><?php echo ($o["project_name"]); ?></h3>
                            <span class="pull-right">￥<b><?php echo (price($o["sell_price"])); ?></b></span>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                       <!--  <div class="order_info box-flex">
                            <h3 class="flex1">美容项目</h3>
                            <span class="pull-right">￥<b>3000.00</b></span>
                        </div> -->
                    <div class="order_time">
                        <?php echo (date('Y-m-d H:i:s',$ol["create_time"])); ?>
                    </div>
                </div>
             </a><?php endforeach; endif; else: echo "" ;endif; endif; ?>