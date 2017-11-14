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

.scroller{height: 320px;}
.scroller img{height: 100%;}
.xqtitle h1{display: block; margin-top: 5px; flex-basis: 1px;  display: -webkit-box;  -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    word-wrap: break-word;  overflow: hidden;  -webkit-box-pack: center;  line-height: 1.35em;  height: 3em; font-size: 14px; color: #051B28;}


.setbox{width: 100px;}
.set_meal{padding: 0;}
.set_meal li{overflow: hidden; margin-bottom: 7px;}
.min,.add{ width: 30px; text-align: center;background-color: #E6E6E6; padding: 0; border:0;  height: 30px;  line-height: 30px;}
.min{border-radius: 3px 0 0 3px;}
.add{border-radius:0 3px 3px 0;}
.text_box{width: 40px; text-align: center; height: 30px; border: 0; margin: 0 -4px; line-height: 30px;box-shadow: none;border-radius: 0;    background: #fbfbfb;
}

.price_quantity{overflow: hidden;}
.price_quantity p{margin-bottom: 5px;}
.price{ color: #eb5211;font-size: 20px;}

.shop_name{font-size: 12px; margin-bottom: 12px;}

.j_indPanel{ width: 100px;}
.j_indPanel .pull-right{font-size: 12px;}
.sold{margin: 6px 0;}

/* 选项卡 */
.nav-tabs{ background: #efefef; border-top: #c40000 1px solid;}
.nav-tabs>li>a{border-radius: 0;}
.tab-pane img{width: 100%;}
.tab-content{padding:10px 10px 60px 10px;}

/*底部按钮*/
.sift_bottom{position:fixed; bottom: 50px; right: 0; width: 100%;}
.sift_bottom button{border:0;}
.sift-btn{ height: 48px;color: #fff;  line-height: 48px; float: left; text-align: center;}
.sift-btn button{background: #e7aa0e;}
.sift-btn-ok button{background: #ea413e;color: #fff;}
.sift-btn-no button {background: #adabab;color: #fff;}

.customer_qq { width: 50px;background: #eee;}
.customer_qq a{ text-align: center;padding-top: 6px; font-size: 12px;color: #8a8a8a;  }
.customer_qq a i{font-size: 22px;color: #6b9af5; display: block;}

/*焦点图*/
.swiper-container{height: auto;}
.xqtitle h1{display: block;  flex-basis: 1px;  display: -webkit-box;  -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    word-wrap: break-word;  overflow: hidden;  -webkit-box-pack: center;  line-height: 1.35em;  height: 3em; font-size: 14px; color: #051B28;}
.swiper-slide a{width: 100%; text-align: center;}
.swiper-slide a img{width: 100%;}

/*购物车按钮*/
.shoppingCart, .purchase_index{position: fixed; bottom: 60px;   width: 36px; height: 36px; background: rgba(0,0,0,0.5);
    filter: alpha(opacity=50);border-radius: 22px;}
.shoppingCart{left: 10px;}
.purchase_index{left: 54px; }
.shoppingCart a, .purchase_index a{   width: 36px; height: 36px;}
.shoppingCart a{background: url(__PUBLIC__/images/shoppingCart.svg) no-repeat center;background-size: 20px;}
.purchase_index a{background: url(__PUBLIC__/images/purchase_index.svg) no-repeat center;background-size: 30px;}
</style>

<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<!--焦点图-->
<div class="swiper-container">
    <div class="swiper-wrapper">
    	<div class="swiper-slide">
	        <img src="<?php echo ($info["thumbnail"]); ?>" >
	      </div>
    <?php if(info.imgs != null): if(is_array($info['imgs'])): $i = 0; $__LIST__ = $info['imgs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
		        <img src="<?php echo ($img); ?>!purchase" >
		      </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>	
   
    </div>
     <div class="swiper-pagination"></div>
</div>

<link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css">
<script type="text/javascript" src="__PUBLIC__/js/swiper.min.js"></script>

<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 2000,
        autoplayDisableOnInteraction: false
    });

</script>

<div class="col-xs-12">
	<div class="xqtitle">
		<h1><?php echo ($info["goods_name"]); ?></h1>
	</div>
	<div class="price_quantity box_flex">
		<div class="flex1">
			<p><?php if($info['promotion_price'] != 0): ?>促销价<?php else: ?>批发价<?php endif; ?><span class="price">￥<?php if($info['promotion_price'] != 0): echo (price($info["promotion_price"])); else: echo (price($info["price"])); endif; ?></span> <?php if($info["unit"] != 0): ?>/<?php echo ($info["unit"]); endif; ?></p>
			<?php if($info['promotion_price'] != 0): ?><p style="font-size: 12px;">批发价<del><span class="">￥<?php echo (price($info["price"])); ?> <?php if($info["unit"] != 0): ?>/<?php echo ($info["unit"]); endif; ?></span></del></p><?php endif; ?>
			<p style="font-size: 12px;">零售价<span class="">￥<?php echo (price($info["market_price"])); ?> <?php if($info["unit"] != 0): ?>/<?php echo ($info["unit"]); endif; ?></span></p>
		</div>
		<div class="pull-right">
			<div class="setbox">
				<input class="min" name="" type="button" value="-" />
				<input class="text_box" disabled type="number" name="goods_num" id="goods_num" type="text" value="1" />
				<input class="add" name="" type="button" value="+" />
			</div>
			<div class="j_indPanel">
				<span class="pull-right sold">已售 <?php echo ($info["sales"]); ?></span>
			</div>
		</div>
	</div>
	<div><span class="pull-right price" style="margin-bottom:10px;font-size: 12px; margin-top: -5px;"><?php echo ($info["supplier_name"]); ?></span></div>
	
</div>

<div style="clear: both;">
	<ul class="nav nav-tabs box_flex" id="myTab">
	  	<li class="flex1"><a href="#details" data-toggle="tab">商品详情</a></li>
        <li class="flex1"><a href="#parameter" data-toggle="tab">规格参数</a></li>
        <li class="flex1"><a href="#deal" data-toggle="tab">适用车型</a></li>
	</ul>
</div>
<div class="tab-content">
	<div class="tab-pane" id="details">
	<?php echo ($info["detail"]); ?>
	</div>
	<div class="tab-pane" id="parameter">
		<table class="table table-bordered">
			<?php if(is_array($attr_names)): $i = 0; $__LIST__ = $attr_names;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$an): $mod = ($i % 2 );++$i;?><tr>
					<td align="right" width="120" class="tdbg"><?php echo ($an); ?></td>
					<td><?php echo ($attr_vals[$key]); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		
		</table>
	</div>
	<div class="tab-pane" id="deal">
		<table class="table table-bordered">
			<?php if(is_array($car)): $i = 0; $__LIST__ = $car;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><tr>
					<td align="right" width="120" class="tdbg"><?php echo ($c["cate2"]); ?></td>
					<td><?php echo ($c["cate3"]); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			
		</table>
	</div>
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

<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script>
</body>
</html>