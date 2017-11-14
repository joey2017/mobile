<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if($title != null): echo ($title); else: ?>诚车堂-全心全意为车主服务<?php endif; ?></title>
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
<link rel="stylesheet" href="__PUBLIC__/css/common_home.css">
</head>
<body>

<div class="distri_top">
    <center>
        <div class="disimg"><img src="__PUBLIC__/images/supplier_default.jpg"></div>
        <h3 class="nametitle">驰程</h3>
    </center>
</div>
    
<div class="fui-icon-group" >
    <a class="fui-icon-col" >
        <div class="icon icon-green radius"><i class="icon d1"></i></div>
        <div class="text" >待付款</div>
    </a>
    <a class="fui-icon-col" >
        <div class="icon icon-green radius"><i class="icon d2" ></i></div>
        <div class="text" >待发货</div>
    </a>
    <a class="fui-icon-col" >
        <div class="icon icon-green radius"><i class="icon d3" ></i></div>
        <div class="text" >待收货</div>
    </a>
    <a class="fui-icon-col" >
        <div class="icon icon-green radius"><i class="icon icon-electrical" ></i></div>
        <div class="text" >退换货</div>
    </a>
</div>

<div class="container-fluid line"></div>

<div class="fui-icon-group col-3" >
    <a class="fui-icon-col" href="">
        <div class="icon icon-green radius"><i class="icon d1"></i></div>
        <div class="text">优惠券</div>
    </a>
    <a class="fui-icon-col" href="">
        <div class="icon icon-green radius"><i class="icon d2" ></i></div>
        <div class="text" >进货明细</div>
    </a>
    <a class="fui-icon-col" href="">
        <div class="icon icon-green radius"><i class="icon d3" ></i></div>
        <div class="text" >信用额度</div>
    </a>
</div>

<div class="container-fluid line"></div>

<div>
    <ul class="list-group">
        <li class="list-group-item">
            <span class="glyphicon glyphicon-user"></span>
            我的账户
            <span class="badge">></span>
        </li>
        <li class="list-group-item">
            <span class="glyphicon glyphicon-user"></span>
            关于我们
            <span class="badge">></span>
        </li>
    </ul>
</div>

<!--底栏-->
<!--底栏-->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/font-awesome/css/font-awesome.min.css">
<div style=" height: 50px;  clear: both;"></div>
<div class="container-fluid">
    <div class="bottombtn">
        <div class="col-xs-3"><a href="<?php echo U('Biz/entrance');?>" class="b_btn"><i class="fa fa-home"></i><div>首页</div></a></div>
        <div class="col-xs-3"><a href="<?php echo U('Purchase/home');?>"><i class="fa fa-map-o"></i><div>采购</div></a></div>
        <div class="col-xs-3"><a href="<?php echo U('Purchase/cart');?>"><i class="fa fa-shopping-cart"></i><div>购物车</div></a></div>
        <div class="col-xs-3"><a href="<?php echo U('Biz/my_home');?>"><i class="fa fa-user fa-fw"></i><div>我的</div></a></div>
    </div>
</div>
<script>
    $('.bottombtn').find('a').removeClass('b_btn').last().addClass('b_btn');
</script>

</body>
</html>