<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
.my_od_1{border-bottom: 1px solid #eee;}
.infopad{margin:8px 0;}
</style>
<?php if(is_array($order_list)): $i = 0; $__LIST__ = $order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ol): $mod = ($i % 2 );++$i;?><div class="container-fluid">
	    <div class="row refundsearch">
	        <div class="col-xs-12">
	            <div class="my_od">
	                <span style="float:left; font-size:16px; font-weight:bold;"><?php echo ($ol["order_sn"]); ?></span>
	                <div class="pull-right">                   
	                    <span class="goods_item tickNull" data-val="<?php echo ($ol["id"]); ?>" data-price="<?php echo (price($ol["total_price"])); ?>" data-paid="<?php echo (price($ol["paid_amount"])); ?>" data-unpay="<?php echo (price($ol["unpay"])); ?>"></span>
	                </div>  
	            </div>    
	        </div>
	    </div>
	    <div class="row" >
	        <div class="col-xs-12">         
	            <div class="my_od_1">
	                <div class="my_od_f">
	                    <div class="infopad">下单时间：<?php echo (date("Y-m-d H:i:s",$ol["create_time"])); ?></div>
	                    <div class="infopad">门店名称：<?php echo ($ol["location_name"]); ?></div>
	                    <div class="infopad">订单状态：<?php echo ($ol["status_msg"]); ?></div>
	                    <div class="infopad">支付状态：<?php echo ($ol["pay_status_msg"]); ?></div>
	                    <div class="infopad">订单金额：￥<?php echo (price($ol["total_price"])); ?></div>
	                    <div class="infopad">已核销金额：￥<?php echo (price($ol["paid_amount"])); ?></div>
	                    <div class="infopad">未核销金额：￥<?php echo (price($ol["unpay"])); ?></div>
	                    <div class="infopad">制单人：<?php echo ($ol["make_user_name"]); ?></div>
	                </div>
	            </div>
	                    
	        </div>
	    </div>
	    <div class="row" style="height:20px;"></div>
	</div>

	<div class="container-fluid line"></div><?php endforeach; endif; else: echo "" ;endif; ?>
<script type="text/javascript">
	$('.refundsearch').find('.goods_item').each(function(i){
      var that = $(this);
      that.click(function(){
        $('#CarWash').find('.goods_item').removeClass('tickico').addClass('tickNull');
        that.removeClass('tickNull').addClass('tickico');
      });
  });
</script>