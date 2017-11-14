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
<link rel="stylesheet" href="__PUBLIC__/font-awesome/css/font-awesome.min.css">
</head>


<body>

<style type="text/css">
/*布局样式重置*/
.tab_parent{padding-left: 15px;}
.tab_subset{margin:0; padding: 0 15px 0 0;}
a{color: #333;}
a:focus,a:active, a:hover{color: #333; text-decoration: none;}
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}
body{position: relative;}
.o_f{overflow: hidden;}


.topinfo{ background: #ea5b22; color: #fff; padding: 0 15px; line-height: 80px;}
.topinfo span{font-size: 40px;}

/*地址*/
.addinfo{padding: 10px; border-bottom: 5px solid #eee;}
.addinfo .bline p{padding: 0 0 6px 0; margin:0; line-height: 25px; }
.bline{border-bottom: 1px solid #e6e6e6;}
.infotab{padding: 8px 10px; background:#fbfbfb; }


/*门店名*/
.bundlev{height:40px; line-height: 40px; padding: 0 10px;}
.bundlev p{margin: 0;}
.storeico{display: inline-block; width: 20px; height: 20px; vertical-align: middle;background: url(__PUBLIC__/images/store.svg) no-repeat; background-size: 20px; margin-right: 3px;}

/*产品列表*/
.productlist{overflow: hidden; padding: 12px 10px;}
.leftimg{width: 100px; height: 100px; margin-right: 10px;}
.leftimg img{width: 100%; height: 100%;}
.rightinfo h3{ line-height: 22px; margin: 3px; height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;  font-size: 14px;  word-break: break-all;}
.price{ color: #eb5211;font-size: 20px;}
.d-main{line-height: 28px;}
.d-main .pull-right{font-size: 12px; color: #717171;}

.inline{height: 5px; background: #eee; border-top: 1px solid #d0d0d0;}


/*底部按钮*/
.sift_bottom{position:fixed; bottom: 0; right: 0; width: 100%;}
.sift_bottom a{background: #ea413e;color: #fff;border:0;width:100%; height: 48px;line-height: 48px;text-align: center;}


</style>

<div class="topinfo o_f">
  <?php echo ($info["order_status"]); ?>
  <span class="pull-right"><i class="fa fa-clipboard"></i></span>
</div>

<div class=" o_f bline infotab ">
  订单编号：<?php echo ($info["order_sn"]); ?>
</div>

<?php if(is_array($goods_list)): $i = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gl): $mod = ($i % 2 );++$i;?><div class="bundlev bline">
      <span class="storeico"></span><?php echo ($gl["supplier_name"]); ?>
    </div>
    
    <?php if(is_array($gl['goods'])): $i = 0; $__LIST__ = $gl['goods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><div class="productlist box_flex  bline">
        <div class="leftimg">
          <a href="<?php echo U('Purchase/detail',array('id'=>$goods['goods_id']));?>"><img src="<?php echo ($goods["thumbnail"]); ?>"></a>
        </div>
        <div class="rightinfo flex1">
          <h3><a href="<?php echo U('Purchase/detail',array('id'=>$goods['goods_id']));?>"><?php echo ($goods["goods_name"]); ?></a></h3>
          <div class="d-main">
            <span class="price">￥:<?php echo (price($goods["sell_price"])); ?></span> 
            <span>/<?php echo ($goods["unit"]); ?></span>
            <span class="pull-right">× <?php echo ($goods["num"]); ?></span>
          </div>
        </div>
      </div><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
<div class="o_f addinfo">
  <div class="">
    <p class="o_f ">
      <span class="pull-left">供应商电话</span>
      <span class="pull-right"><?php echo ($info["mobile"]); ?></span>
    </p>
    <p>
      收货地址：<?php echo ($info["address"]); ?>
    </p>
  </div>
</div>

<div class="bundlev bline">
  <p>
    <span class="pull-left">优惠金额：</span>
    <span class="pull-right price">￥<?php echo (price($info["discount_price"])); ?></span>
  </p>
</div>
<div class="bundlev bline">
  <p>
    <span class="pull-left">总计金额：</span>
    <span class="pull-right price">￥:<?php echo (price($info["total_price"])); ?></span>
  </p>
</div>
<?php if($info["pay_time"] != 0): ?><div class="bundlev bline">
  <p>
    <span class="pull-left">支付方式：</span>
    <span class="pull-right"><?php echo ($info["pay_type"]); ?></span>
  </p>
</div><?php endif; ?>
<div class="bundlev bline">
  <p>
    <span class="pull-left">收货人：</span>
    <span class="pull-right"><?php echo ($info["receive_user"]); ?></span>
  </p>
</div>

<div class="bundlev bline">
  <p>
    <span class="pull-left">下单时间：</span>
    <span class="pull-right"><?php echo (date("Y-m-d H:i:s",$info["create_time"])); ?></span>
  </p>
</div>
<?php if($info["pay_time"] != 0): if($info["means_of_payment"] == 1 || $info["means_of_payment"] == 2): ?><div class="bundlev bline">
    <p>
      <span class="pull-left">支付时间：</span>
      <span class="pull-right"><?php echo (date("Y-m-d H:i:s",$info["pay_time"])); ?></span>
    </p>
  </div><?php endif; endif; ?>
<div class="bundlev o_f">
  <p>
    订单备注：<?php echo ($info["remark"]); ?>
  </p>
</div>





<div style="height:48px;"></div>
<div class="sift_bottom">
  <a href="<?php echo U('Biz/purchase_order');?>" class="btn-block">返回列表</a>
</div>


<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script>

</body>
</html>