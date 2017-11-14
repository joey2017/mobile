<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if($title != null): ?>诚车堂<?php else: ?>诚车堂-全心全意为车主服务<?php endif; ?></title>
<meta name="keywords" content="诚车堂,养车网,汽车服务平台,自助保养,汽车保养,汽车养护,汽车美容,钣金喷漆,汽车维修,汽车配件,汽车养护,养车无忧,养车无忧网,一站式汽车保养" />
<meta name="description" content="修车养车，上诚车堂，省心，省钱，省时间！诚车堂，致力于为广大车主提供一个在线解决汽车服务问题、满足车主在汽车美容、保养、维修、配件等方面的需求， 服务范围包括汽车美容、汽车保养、汽车养护、钣金油漆、汽车维修等，是中国领先的网上汽车服务平台。诚车堂在努力成为车主们首选汽车服务平台的同时,以'让车主享有便捷、高效、经济的爱车养车生活'为己任，希望在用户心中树立起'修车养车,上诚车堂'的良好口碑。" />

<link rel="shortcut icon" href="http://s.17cct.com/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<?php if( $no_include != 1): ?><link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css"><?php endif; ?>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/css.css?v=20150617">
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/wap.lazy.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.cookie.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/wap_v4_common.js"></script>
<div id='wx_pic' style='margin:0 auto;display:none;'>
<img src='http://s.17cct.com/v4/images/pic300.jpg' />
</div>
<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('showToolbar');
  WeixinJSBridge.call('showOptionMenu');
});
</script>
</head>
<body>
<!--头部-->
<div class="container-fluid topbox">
    <div class="row top">
        <div class="pg-Current">
        	<a href="<?php echo U('User/order');?>" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
        	<img src="__PUBLIC__/images/cheng.png" width="30" height="30">
        </div>
        <div class="pgt">
        	<a>支付结果</a>
        </div>             
    </div>
</div>
<!--分割线-->
<?php if($order["pay_status"] >= 1): ?><div class="container-fluid">
        <div class="row"><center><h3 style="margin-top:10px; color:#5cb85c;"><span class="glyphicon glyphicon-ok" style="top:3px;"></span>确认成功</h3></center></div>
    </div>
    <!--订单号-->
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-xs-12"> 
            	<p style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #e0e0e0;">交易单号：<span style="font-weight:bold;"><?php echo ($order["order_sn"]); ?></span></p>
                
                <p style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #e0e0e0;">支付方式：<span style="font-weight:bold;"><?php echo ($order["pay_type"]); ?></span></p>
                 <p style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #e0e0e0;">订单金额：<span style="font-weight:bold;">￥<?php echo (price($order["total_price"])); ?></span></p>  
                 <p style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #e0e0e0;">确认时间：<span style="font-weight:bold;"><?php echo (date("Y-m-d H:i:s",$order["pay_time"])); ?></span></p>             
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container-fluid">
        <div class="row"><center><h3 style="color:#cd0000;margin-top:10px;"><span class="glyphicon glyphicon-remove" style="top:3px;"></span>确认失败</h3></center></div>
    </div><?php endif; ?>
<!--分割线-->
<div class="container-fluid">
	<div class="row">
        <div class="col-xs-12">
            <a role="button" class="btn btn-warning btn-block" href="<?php echo U('Biz/purchase_order');?>"  style="margin-top:10px;">我的订单</a>
        </div>
    </div>
</div>

<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
      WeixinJSBridge.call('hideToolbar');
      WeixinJSBridge.call('hideOptionMenu');
    });
</script>