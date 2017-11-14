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
<style type="text/css">
  .no_record{height: 24px;  padding-top: 205px;  text-align: center;  background: url(http://s.17cct.com/v5/images/erp/empty.png) no-repeat center 20px;  background-size: 180px 180px;}
</style>
<body>
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<!--头部-->
<div class="container-fluid topbox">
    <div class="row top"><h1 style="display:none;">诚车堂汽车网</h1>
        <div class="pg-Current">
            <a href="<?php echo U('Biz/shop_count');?>"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
            <img src="__PUBLIC__/images/cheng.png" width="30" height="30">
        </div>
        <div class="pgt">
            <a>采购订单</a>
        </div>             
    </div>
</div>

<!--选项卡-->
<div class="container-fluid">
    <div class="row">
        <div class="all wd_1 <?php if($t == 1): ?>Underline<?php endif; ?>"><a href="<?php echo U('Biz/purchase_order');?>?t=1">已付款(<?php echo ($count["paid"]); ?>)</a></div>     
        <div class="all wd_1 <?php if($t == 2): ?>Underline<?php endif; ?> "><a href="<?php echo U('Biz/purchase_order');?>?t=2">未付款(<?php echo ($count["nopay"]); ?>)</a></div>  
        <div class="all wd_1 <?php if($t == 5): ?>Underline<?php endif; ?> "><a href="<?php echo U('Biz/purchase_order');?>?t=5">待确认(<?php echo ($count["noconfirm"]); ?>)</a></div>     
        <div class="all wd_1 <?php if($t == 3): ?>Underline<?php endif; ?> "><a href="<?php echo U('Biz/purchase_order');?>?t=3">待提交(<?php echo ($count["uncommitted"]); ?>)</a></div>
        <div class="all wd_1 <?php if($t == 4): ?>Underline<?php endif; ?> "><a href="<?php echo U('Biz/purchase_order');?>?t=4">已取消(<?php echo ($count["canceled"]); ?>)</a></div>
    </div>
</div>
<script type="text/javascript">
       var currentpage=0;   
        $(window).scroll(function(){ 
            totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 
            if($(document).height() <= totalheight){ 
                if(stop==true){ 
                    ajaxRed();
                } 
            } 
        });
     ajaxRed();
    function ajaxRed(){ 
        $("#load").show();
        stop=false;
        $.get("<?php echo U('Biz/ajax_get_purchase');?>",{"p":currentpage,"t":<?php echo ($t); ?>}
        ,function(html){
                if(html!=""){ 
                  if(currentpage==0) {
                      $("#purchase_list").html(html);
                  }
                  else {                   
                     $("#purchase_list").append(html);                                               
                  }                   
                 stop=true;
                }else{
                   MsgBox('已加载全部数据');
                   if(currentpage==0){
                      $("#purchase_list").html('<div class="no_record col-sm-12">暂无数据</div>');
                    }
                }
                currentpage++;
               $("#load").hide();  
           });
      }



</script>


<div id="purchase_list">
    
</div>


<!--分割线-->

<!--加载-->
<div class="container-fluid" id="load">
    <div class="row">
        <div class="col-xs-12" style="margin-top:10px;">
            <center>
            <img src="__PUBLIC__/images/minilodging.gif" width="24" height="24" style="vertical-align:middle;"> 
            正在加载... 
            </center>
        </div>
    </div>
</div>



<p>&nbsp;</p>
<p>&nbsp;</p>

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

<script type="text/javascript">

document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script>