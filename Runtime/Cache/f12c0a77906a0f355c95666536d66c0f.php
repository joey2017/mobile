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
</head>

<body id="Jlazy_img">
<!--头部-->
<div class="container-fluid topbox">
    <div class="row top">
        <div class="Current">
            <a href="javascript:void(0);">南宁 <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></a>
            
            <div class="theme-popover"> 
                <h3>城市选择</h3>
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                   
                  <div class="btn-group" role="group">
                    <a href="<?php echo U('Index/index');?>?city=nn" role="button" class="btn btn-default" style="color:#333;">南宁</a>
                    
                  </div>
                  <div class="btn-group" role="group">
                    <a href="<?php echo U('Index/index');?>?city=sz" role="button" class="btn btn-default" style="color:#333;">深圳</a>
                    
                  </div>
                </div>
            </div>
            <div class="theme-popover-mask"></div>
            <style type="text/css">
                .theme-popover-mask { z-index: 9998; position:fixed; top:0; left:0; width:100%; height:100%; background:#000; opacity:0.6;  filter:alpha(opacity=60);  display:none; }
                .theme-popover { z-index:9999; position:fixed; top:50%; left:50%; padding:15px; height: 150px; width:300px; margin:0 0 0 -150px; background-color:#fff; display:none;}
                .theme-poptit {border-bottom:1px solid #ddd;  padding:12px; position: relative;}
            </style>
        </div>
        <div class="Search">  
            <a href="<?php echo U('Search/index');?>">         
                <div class="form-control my_od_f">
                    <i class="glyphicon glyphicon-search" aria-hidden="true" style="color:#b9b9b9;"></i>
                    <span style="margin-left:.6rem; color:#999;">输入服务/商品/商家</span>
                </div> 
            </a>            
        </div>
        <div class="Member">
        	<a href="<?php echo U('User/index');?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
        </div>
    </div>
</div>
<!--焦点图-->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php if(is_array($banner_ad)): foreach($banner_ad as $key=>$ba): ?><div class="swiper-slide">
        <a href="<?php echo ($ba["adv_url"]); ?>"><img src="<?php echo (getimgurl($ba["img"],'')); ?>"></a>
        </div><?php endforeach; endif; ?>
    </div>
     <div class="swiper-pagination"></div>
</div>

<!--导航-->
<div class="container-fluid">
	<div class="row menu" style="padding-top:10px;">
		<div class="col-xs-3">
			<a href="<?php echo U('Search/store');?>?oid=1" >
				<img src="__PUBLIC__/images/1.png?v=1">
				<p>附近商家</p>
			</a>
		</div>
		<div class="col-xs-3">
			<a href="<?php echo U('Search/deal');?>?type=service&cid=17" >
				<img src="__PUBLIC__/images/2.png?v=1">
				<p>汽车美容</p>
			</a>
		</div>
		<div class="col-xs-3">
			<a href="<?php echo U('Search/deal');?>?type=service&cid=15" >
				<img src="__PUBLIC__/images/3.png?v=1">
				<p>常规保养</p>
			</a>			
		</div>
		<div class="col-xs-3">
			<a href="<?php echo U('Article/index');?>">
				<img src="__PUBLIC__/images/4.png?v=1">
				<p>资讯中心</p>
			</a>			
		</div>
        <div class="col-xs-3">
			<a href="<?php echo U('Package/index');?>" >
				<img src="__PUBLIC__/images/5.png?v=1">
				<p>全返活动</p>
			</a>
		</div>
		<div class="col-xs-3">
			<a href="<?php echo U('Search/specialsale');?>?type=service" >
				<img src="__PUBLIC__/images/6.png?v=1">
				<p>特卖会</p>
			</a>
			
		</div>
		<div class="col-xs-3">
			<a href="<?php echo U('Club/index');?>" >
				<img src="__PUBLIC__/images/7.png?v=1">
				<p>车友会</p>
			</a>			
		</div>
		<div class="col-xs-3">
			<!-- <a href="http://wx.wsq.qq.com/262299406"> -->
            <a href="http://www.vzan.com/f/s-707026">
				<img src="__PUBLIC__/images/8.png?v=1">
				<p>社区</p>
			</a>			
		</div>
	</div>
</div>

<!-- 深圳分站暂时隐藏卡券 门店 --
<?php if($_SESSION['city_id'] != 30): ?><div class="container-fluid line"></div>


<div class="container">
	<div class="row" >
    	<div class="col-xs-12" >
        	<div class="tab_t">
    			<h2>卡券专区</h2>
                <a href="<?php echo U('Search/specialsale');?>?type=service"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>更多秒杀</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var serverTime = new Date().getTime();
$(function(){
    var dateTime = new Date();
    var difference = dateTime.getTime() - serverTime;    
    setInterval(function(){
      $(".endtime").each(function(){
        var obj = $(this);
        var endTime = new Date(parseInt(obj.attr('value')) * 1000);
        var nowTime = new Date();
        var nMS=endTime.getTime() - nowTime.getTime() + difference;
        var myD=Math.floor(nMS/(1000 * 60 * 60 * 24));
        var myH=Math.floor(nMS/(1000*60*60)) % 24+(myD*24);
        var myM=Math.floor(nMS/(1000*60)) % 60;
        var myS=Math.floor(nMS/1000) % 60;
        //var myMS=Math.floor(nMS/100) % 10;
        if(myD>= 0){
            var str =myH+"小时"+myM+"分"+myS+"秒";
        }else{
            var str = "已结束！";   
        }
        obj.html(str);
      });
    }, 100);       
});
</script>
<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12">
        <?php if($specialsale_services): if(is_array($specialsale_services)): foreach($specialsale_services as $key=>$ss): ?><div class="row" >
                <a href="<?php echo U('Service/view',array('id'=>$ss['id']));?>" class="tab_a">
                    <div class="col-xs-6" style="margin:10px 0 0 0;">
                        <img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($ss["img"],'middle')); ?>" style=" width:100%; height:auto" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');"> 
                    </div>
                    <div class="col-xs-6" style="margin:0; padding:0px 10px 0 0;">
                        <h3><?php echo ($ss["name"]); ?></h3>
                         <p class="tcont"><?php echo ($ss["brief"]); ?></p>
                        <del>原价：¥<?php echo (price($ss["origin_price"])); ?></del>
                        <p>车堂价：<b>￥<?php echo (price($ss["current_price"])); ?></b></p>
                    </div>
                </a>
            </div><?php endforeach; endif; ?>              
        <?php else: ?>
            <div class="row" >
                <p style="color:#5f5f5f;text-align:center;margin-top:10px;">暂无该类服务</p>
            </div><?php endif; ?>
        </div>
    </div>
</div><?php endif; ?>
-->
<?php if($card != ''): ?><style type="text/css">
.n_bg{background:#cd0000 url(__PUBLIC__/images/cardbg.png) repeat-x 0 87px;}
.c_bg{background:#f47300 url(__PUBLIC__/images/cardbg.png) repeat-x 0 87px;}
.cardul{box-shadow: 1px 1px 0 #e9e9e9; padding: 6px; margin-top: 12px;  height:145px; border-radius: 10px;}

.cardul h2{height: 45px; overflow: hidden; font-size: 20px; color: #fff; margin: 11px 0 0 0;}
.cardul h2 i{margin-right: 6px;}
.cardul h2 i img{border-radius: 45px;}
.cardul p.mintxt{ color: #fff; height: 17px; overflow: hidden; font-size: 12px; text-indent: 4.2em;}
.cardul .row{margin-top: 24px;}

.yh_ico{width: 30px;height: 30px;display: block; position: absolute;top: 5px;right: 6px;border-radius: 30px;color:#cd0000;text-align: center;line-height: 30px;font-size: 12px;background:#ffe400;}
</style>
<div class="container-fluid line"></div><!--E卡专区-->

<!-- <div class="container">
    <div class="row" >
        <div class="col-xs-12" >
            <div class="tab_t">
                <h2>E卡专区</h2>
               <a href="<?php echo U('Card/index');?>"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>更多E卡</a>
            </div>
        </div>
    </div>
</div> 

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12" id="card">
        <?php if(is_array($card)): $i = 0; $__LIST__ = $card;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><div class="cardul <?php if($c["type"] == 1): ?>n<?php else: ?>c<?php endif; ?>_bg" style='position: relative;'>
                <?php if($c["is_promotion"] == 1): ?><a class="yh_ico">惠</a><?php endif; ?>
                <a href="<?php echo U('Card/detail',array('id'=>$c['id']));?>">
                <h2><i><img class="lazy_img" src="<?php echo (getimgurl($c["preview"],'little')); ?>" width="45" height="45"  onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');"/></i><?php echo ($c["name"]); ?></h2>
                <p class="mintxt"><?php echo ($c["brief"]); ?></p>
                </a>
                <div class="row">
                    <?php if($c["is_promotion"] == 1): ?><div class="col-xs-7 Price">￥<b><?php echo (price($c["promotion_price"])); ?></b><del>￥<?php echo (price($c["price"])); ?></del></div>
                    <?php else: ?>
                        <div class="col-xs-7 Price">￥<b><?php echo (price($c["price"])); ?></b></div><?php endif; ?>
                    
                    <div class="col-xs-5"><p class="text-right"><a class="btn btn-default btn-warning" href="<?php echo U('Card/detail',array('id'=>$c['id']));?>" role="button">查看详情</a></p></div>   
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>    
    </div>
  </div>
</div>
-->

<span style="height:12px; display:block;">&nbsp;</span><?php endif; ?>

<div class="container-fluid line"></div>
<!--优质门店-->
<div class="container-fluid">
	<div class="row" >
    	<div class="col-xs-12" >
        	<div class="tab_t">
    			<h2>最新入驻</h2>
                <a href="<?php echo U('Store/new_add');?>"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>更多门店</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12">
        <?php if($good_stores): ?><div class="row" >
                <?php if(is_array($good_stores)): $k = 0; $__LIST__ = $good_stores;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gs): $mod = ($k % 2 );++$k;?><div class="col-xs-6 zsimg" <?php if($k == 3): ?>style="clear: both;"<?php endif; ?>>
                	<a href="<?php echo U('Store/view',array('id'=>$gs['id']));?>">
                    	<img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($gs["preview"],'large')); ?>" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');">
                        <div><?php echo ($gs["name"]); ?></div>
                    </a>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div> 
        <?php else: ?>
            <div class="row" >
                <p style="color: #5f5f5f;text-align: center;margin-top:10px;">暂无信息</p>
            </div><?php endif; ?>               
        </div>
    </div>
</div>


<!--分割线-->
<div class="container-fluid line"></div>

<!--平台推荐-->
<div class="container-fluid">
	<div class="row" >
    	<div class="col-xs-12" >
        	<div class="tab_t">
    			<h2>平台推荐</h2>
                <a href="<?php echo U('Search/deal');?>?type=service"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>更多推荐</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 ">
        <?php if($recommend_services): if(is_array($recommend_services)): foreach($recommend_services as $key=>$rs): ?><div class="row" >
            	<a href="<?php echo U('Service/view',array('id'=>$rs['id']));?>" class="tab_a tab_b_l">
                    <div class="col-xs-5" style="margin:10px 0 0 0;">
                        <img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($rs["img"],'middle')); ?>" style=" width:100%; height:auto"> 
                    </div>
                    <div class="col-xs-7 txtbox" style="margin:0; padding:0;">
                        <h3><?php echo ($rs["name"]); ?></h3>
                        <p class="tcont"><?php echo ($rs["brief"]); ?></p>
                        <p><b><?php echo (price($rs["current_price"])); ?>元</b>&nbsp;&nbsp;<del><?php echo (price($rs["origin_price"])); ?>元</del> <span style="float:right;">已售<?php echo ($rs["order_count"]); ?></span></p>
                    </div>
                </a>
            </div><?php endforeach; endif; ?>
        <?php else: ?>
            <div class="row" >
                <p style="color: #5f5f5f;text-align: center;margin-top:10px;">暂无推荐</p>
            </div><?php endif; ?>
            <div class="row">
                <div class="col-xs-12">
                    <a href="<?php echo U('Search/deal');?>?type=service" class="tjbtn"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>查看全部推荐<span class="glyphicon glyphicon-menu-right" style="float:right;" aria-hidden="true"></span></a>
                </div>
            </div> 
        </div>
    </div>
</div>

<!--底部-->
<div class="container-fluid footer">
    <!--
    <div class="row drbtn">
        <div class="col-xs-4 col-xs-offset-2">
            <a href="<?php echo U('User/index');?>" role="button" class="btn btn-danger btn-block"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> 登录</a>
        </div>
        <div class="col-xs-4 ">
            <a href="<?php echo U('User/index');?>" role="button" class="btn btn-danger btn-block"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 注册</a>
        </div>
    </div>-->
	<div class="row btnav">
    	<div class="col-xs-12">
        	<div class="row">
                <div class="col-xs-3" style=" border-right:1px solid #CCC;"><a href="<?php echo U('Index/help',array('id'=>20));?>">平台简介</a></div>
                <div class="col-xs-3" style=" border-right:1px solid #CCC;"><a href="<?php echo U('Index/guide');?>">新手指南</a></div>
                <div class="col-xs-3" style=" border-right:1px solid #CCC;"><a href="http://www.17cct.com">电脑版</a></div>
                <div class="col-xs-3"><a href="<?php echo U('Index/contact_us');?>">联系方式</a></div>
            </div>
        </div>
        <div class="col-xs-12" style="text-align:center; margin-top:15px;">
        	<p>诚车堂—中国领先的汽车养护O2O平台！</p>
            <p style=" color:#9e9e9e; font-size:12px;">Copyright © 2012-2017 17cct.com 桂ICP备12007244号-7</p>
        </div>
    </div>
    <p>&nbsp;</p>
</div>
<script type="text/javascript" src="__PUBLIC__/js/swiper.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v2.0&ak=tEflu9uwxEGzOsVPA11HS9Yl"></script> 
<script type="text/javascript">
var xx_lazy = Lazy.create({
                lazyId: "Jlazy_img",
                trueSrc: 'src2',
                offset: 300, 
                delay: 100, 
                delay_tot: 5000 
              }); 
Lazy.init(xx_lazy);
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: 2000,
    autoplayDisableOnInteraction: false
});


$(function () {

    //城市选择 弹框脚本
    $('#dw').click(function(){
        $('.theme-popover-mask').fadeIn(100);
        $('.theme-popover').slideDown(200);
    });
    $('.theme-popover-mask').click(function(){
        $('.theme-popover-mask').fadeOut(100);
        $('.theme-popover').slideUp(200);
    });

    //定位城市
    BaiDuGetPosition();
});


function BaiDuGetPosition() {

    if ($.cookie('deal_city')) {
        return;
    }

    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function(r) {
        if (this.getStatus() == BMAP_STATUS_SUCCESS) {
            var current_city = r.address.city;
            if (current_city && current_city != null && current_city != '') {
                var l = current_city.indexOf('市');
                if (l > -1) {
                    current_city = current_city.substr(0, l);
                    getCurrentCity(current_city);
                }
            } else {
                $.cookie('deal_city',15,{expires:7,path:"/",domain:"17cct.com"});
            }
        } else {
            $.cookie('deal_city',15,{expires:7,path:"/",domain:"17cct.com"});
        }
    });
}

function getCurrentCity(cname) {
    $.ajax({ 
        type:"post",
        url: "<?php echo U('Index/getCurrentCity');?>", 
        data:{'city_name':cname},
        success: function(d){
            if (d.status == 1) {
                if (d.info && d.info !='') {
                    if (confirm('检测到您目前所在城市是'+d.data.name+'\n是否要切换')) {
                        $.cookie('deal_city',d.data.id,{expires:7,path:"/",domain:"17cct.com"});
                        document.location.href = d.info;
                    }
                }
            }
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
        }
    });
}
</script>

<script type="text/javascript" src="__PUBLIC__/js/scrolltopcontrol.js"></script>
<div style="display:none"> 
	<script>
		var _hmt = _hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "//hm.baidu.com/hm.js?196428f1e872f7a662e1bdf39f9953ca";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		})();
</script>


</div>
</body>
</html>