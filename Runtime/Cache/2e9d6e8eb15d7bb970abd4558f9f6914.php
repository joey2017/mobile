<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html lang="zh-CN"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /><title><?php if($title != null): echo ($title); else: ?>诚车堂-全心全意为车主服务<?php endif; ?></title><meta name="keywords" content="诚车堂,养车网,汽车服务平台,自助保养,汽车保养,汽车养护,汽车美容,钣金喷漆,汽车维修,汽车配件,汽车养护,养车无忧,养车无忧网,一站式汽车保养" /><meta name="description" content="修车养车，上诚车堂，省心，省钱，省时间！诚车堂，致力于为广大车主提供一个在线解决汽车服务问题、满足车主在汽车美容、保养、维修、配件等方面的需求， 服务范围包括汽车美容、汽车保养、汽车养护、钣金油漆、汽车维修等，是中国领先的网上汽车服务平台。诚车堂在努力成为车主们首选汽车服务平台的同时,以'让车主享有便捷、高效、经济的爱车养车生活'为己任，希望在用户心中树立起'修车养车,上诚车堂'的良好口碑。" /><link rel="shortcut icon" href="http://s.17cct.com/favicon.ico" type="image/vnd.microsoft.icon"><link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css"><?php if( $no_include != 1): ?><link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css"><?php endif; ?><link rel="stylesheet" type="text/css" href="__PUBLIC__/css/css.css?v=20150617"><script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script><script type="text/javascript" src="__PUBLIC__/js/bootstrap.min.js"></script><script type="text/javascript" src="__PUBLIC__/js/wap.lazy.min.js"></script><script type="text/javascript" src="__PUBLIC__/js/jquery.cookie.js"></script><script type="text/javascript" src="__PUBLIC__/js/wap_v4_common.js"></script><div id='wx_pic' style='margin:0 auto;display:none;'><img src='http://s.17cct.com/v4/images/pic300.jpg' /></div><script type="text/javascript">document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('showToolbar');
  WeixinJSBridge.call('showOptionMenu');
});
</script><link rel="stylesheet" href="__PUBLIC__/font-awesome/css/font-awesome.min.css"><link rel="stylesheet" href="__PUBLIC__/css/iconfont.css" /><link rel="stylesheet" type="text/css" href="__PUBLIC__/css/text.css"/></head><body><style type="text/css">/*布局样式重置*/
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
.xqtitle h1{display: block;  flex-basis: 1px;  display: -webkit-box;  -webkit-line-clamp: 2; -webkit-box-orient: vertical;margin-bottom:0 ;font-size: 16px;
    word-wrap: break-word;  overflow: hidden;  -webkit-box-pack: center;  line-height: 1.35em;  height: 3em; font-size: 14px; color: #051B28;}
.swiper-slide a{width: 100%; text-align: center;}
.swiper-slide a img{width: 100%;}

#myTab .flex1 a{
	padding: 10px;
	text-align: center;
	margin: 0;
}

</style><div class="alertBg" id="msgBox" style="display:none;"><h4 class="alerttitle" id="alerttitle"></h4><span class="vm f20" id='alertdetail'></span></div><!--焦点图--><div class="swiper-container"><div class="swiper-wrapper"><div class="swiper-slide"><img src="<?php echo ($info["thumbnail"]); ?>" ></div><?php if(info.imgs != null): if(is_array($info['imgs'])): $i = 0; $__LIST__ = $info['imgs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><div class="swiper-slide"><img src="<?php echo ($img); ?>!purchase" ></div><?php endforeach; endif; else: echo "" ;endif; endif; ?></div><div class="swiper-pagination"></div></div><link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css"><script type="text/javascript" src="__PUBLIC__/js/swiper.min.js"></script><div class="col-xs-12" style="margin-bottom: 10px;"><div class="xqtitle"><h1><?php echo ($info["goods_name"]); ?></h1></div><div class="row shoujia" style="text-align: center"><div class="col-xs-4"><p><?php if($info['promotion_price'] != 0): ?>促销价<?php else: ?>批发价<?php endif; ?></p><strong><?php if($info['promotion_price'] != 0): echo (price($info["promotion_price"])); else: echo (price($info["price"])); endif; ?></strong></div><div class="col-xs-4"><p>零售价</p><strong><?php echo (price($info["market_price"])); ?></strong></div><div class="col-xs-4"><p>销量</p><strong><?php echo ($info["sales"]); ?></strong></div></div></div><div style="clear: both;"><ul class="nav nav-tabs box_flex" id="myTab"><li class="flex1"><a href="#details" data-toggle="tab">商品详情</a></li><li class="flex1"><a href="#parameter" data-toggle="tab">规格参数</a></li><li class="flex1"><a href="#deal" data-toggle="tab">适用车型</a></li><li class="flex1"><a href="#warehouse" data-toggle="tab">库存详情</a></li></ul></div><div class="tab-content"><div class="tab-pane" id="details"><?php echo ($info["detail"]); ?></div><div class="tab-pane" id="parameter"><table class="table table-bordered"><?php if(is_array($attr_names)): $i = 0; $__LIST__ = $attr_names;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$an): $mod = ($i % 2 );++$i;?><tr><td align="right" width="120" class="tdbg"><?php echo ($an); ?></td><td><?php echo ($attr_vals[$key]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table></div><div class="tab-pane" id="deal"><table class="table table-bordered"><?php if(is_array($car)): $i = 0; $__LIST__ = $car;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><tr><td align="right" width="120" class="tdbg"><?php echo ($c["cate2"]); ?></td><td><?php echo ($c["cate3"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table></div><div class="tab-pane" id="warehouse"><table class="table table-bordered"><?php if(is_array($warehouse_goods)): $i = 0; $__LIST__ = $warehouse_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$wg): $mod = ($i % 2 );++$i;?><tr><td align="right" width="120" class="tdbg"><?php echo ($wg["warehouse_name"]); ?></td><td><?php echo ($wg["stock"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table></div></div><!--底栏--><!--漂浮导航 开始--><div class="row pos-nav"><div class="col-xs-3"><a href="<?php echo U('Supplier/index');?>" <?php if(MODULE_NAME == Supplier): ?>class="nav-red"<?php endif; ?>><i class="iconfont icon-shangdian1"></i><p>首页</p></a></div><div class="col-xs-3"><a href="<?php echo U('SupOrder/navig');?>" <?php if(MODULE_NAME == SupOrder): ?>class="nav-red"<?php endif; ?>><i class="iconfont icon-kehu"></i><p>交易/客户</p></a></div><div class="col-xs-3"><a href="<?php echo U('SupWarehouse/navig');?>" <?php if(MODULE_NAME == SupWarehouse): ?>class="nav-red"<?php endif; ?>><i class="iconfont icon-kucun"></i><p>财务/库存</p></a></div><div class="col-xs-3"><a href="<?php echo U('SupMember/navig');?>" <?php if(MODULE_NAME == SupMember): ?>class="nav-red"<?php endif; ?>><i class="iconfont icon-shouhou"></i><p>售后</p></a></div></div><!--漂浮导航 结束--></body></html></body></html>