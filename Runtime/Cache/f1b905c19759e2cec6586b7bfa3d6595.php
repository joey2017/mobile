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


/*搜索条*/
.topsearch{height: 48px; padding: 6px 10px;z-index: 2;position:absolute;}
.uearbtn{line-height: 34px;}
.purchasesvg{background-image: url(__PUBLIC__/images/user_center.svg); background-repeat: no-repeat;}
.uearbtn a{color: #fff; margin-right: 8px;}
.uearbtn a span{width: 15px; height: 24px; display: inline-block; background-position: 0px -31px; background-size: 30px;
    vertical-align: middle;}
.searchtab{position: relative; width: 100%; height: 36px; border-radius: 5px; margin-right:10px; }
.searchtab span{position: absolute; width: 30px; height: 30px; display: block; top: 2px; left: 2px; background:url(__PUBLIC__/images/searchico.svg) no-repeat  2px 4px; background-size: 22px;}
.searchtab input{border:0; background: #fff; background: rgba(255, 255, 255, 0.75); filter: alpha(opacity=75); text-indent: 1em;}
.searchbtn{width: 55px; height: 36px;}
.searchbtn button{width: 100%; height: 33px;background: #fff; background: rgba(255, 255, 255, 0.75); filter: alpha(opacity=75);  border:0; color: #cc830c; border-radius: 3px; font-size: 12px;}


/*焦点图*/
.xqtitle h1{display: block;  flex-basis: 1px;  display: -webkit-box;  -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    word-wrap: break-word;  overflow: hidden;  -webkit-box-pack: center;  line-height: 1.35em;  height: 3em; font-size: 14px; color: #051B28;}
.swiper-slide a{width: 100%; text-align: center;}
.swiper-slide a img{width: 100%;}
.swiper-container{height: auto;}
.swiper-container-horizontal>.swiper-pagination{bottom: 0 !important;}




/*导航*/
.purindex{background-image: url(__PUBLIC__/images/purindex.svg);background-repeat: no-repeat;background-size: 207px;}
.p_menu{margin: 15px 0 0 0;}
.p_menu .tab_subset{margin-bottom: 15px;}
.p_menu a{text-align: center;font-size: 12px;}
.p_menu a span{display: block;width: 48px; height: 48px; border-radius: 32px; margin: 0 auto;}
.pcolor01{background-color: #ff523f; background-position: 9px 9px;}
.pcolor02{background-color: #ffa40e; background-position: -51px 8px;}
.pcolor03{background-color: #21cba8; background-position: -107px 8px;}
.pcolor04{background-color: #06afee; background-position: -164px 8px;}
.pcolor05{background-color: #68b7fb; background-position: -164px -44px;}
.pcolor06{background-color: #cd77d4;  background-position: 9px -44px;}
.pcolor07{background-color: #bc7ef7;  background-position: -50px -45px;}
.pcolor08{background-color: #6b99ea; background-position: -88px -34px; background-size: 176px;}

.inline{height: 5px; background: #eee;}
/*产品列表*/
.proinfo{border:1px solid #eee; font-size: 12px;margin-bottom: 13px;}
.proinfo img{width: 100%; margin-bottom: 3px;}
.proinfo p{ margin:5px; border-bottom: 1px solid #eee;line-height: 22px; height: 48px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;  font-size: 12px;  word-break: break-all;}
.d-main{padding: 0px 5px 5px 5px; line-height: 30px;}
.d-main .pull-right{font-size: 12px; color: #717171;}
.price{ color: #eb5211;font-size: 14px;}
</style>


<div class="topsearch col-xs-12 box_flex">
	<div class="uearbtn">
		<a href="<?php echo U('Biz/shop_count');?>" class="btn-block"><span class="purchasesvg"></span> 用户中心</a>
	</div>
	<div class="flex1 searchtab">
		<span></span>
		<input type="text" id="keyword" class="form-control" value="" placeholder="请输入商品名称" >
	</div>
	<div class="searchbtn">
		<button id="search">搜索</button>
	</div>
</div>
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<script type="text/javascript">
	$('#search').click(function(){
		var k=$('#keyword').val()
		if(k==''){
			MsgBox('请输入关键词搜索');
			return false;
		}
		window.location.href="<?php echo U('Purchase/search');?>?keyword="+k;
	})
</script>

<!--焦点图-->
<div class="swiper-container"style="clear:both;">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <a href=""><img src="http://image.17cct.com/images/m/purchase_adv.jpg" ></a>
      </div>
      <div class="swiper-slide">
        <a href=""><img src="http://image.17cct.com/images/m/purchase_adv_2.jpg" ></a>
      </div>  
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


<!-- 导航 -->
<div class="p_menu tab_parent o_f">
	<div class="col-xs-3 tab_subset">
		<a href="<?php echo U('Purchase/index',array('t'=>2));?>" class="btn-block"><span class="purindex pcolor01"></span>轮胎</a>
	</div>
	<div class="col-xs-3 tab_subset">
		<a href="<?php echo U('Purchase/index',array('t'=>5));?>" class="btn-block"><span class="purindex pcolor05"></span>轮毂</a>
	</div>
	<div class="col-xs-3 tab_subset">
		<a href="<?php echo U('Purchase/index',array('t'=>6));?>" class="btn-block"><span class="purindex pcolor02"></span>润滑油</a>
	</div>
	<div class="col-xs-3 tab_subset">
		<a href="<?php echo U('Purchase/index',array('t'=>8));?>" class="btn-block"><span class="purindex pcolor03"></span>电瓶</a>
	</div>
	<div class="col-xs-3 tab_subset">
		<a href="<?php echo U('Purchase/class_list',array('t'=>16));?>" class="btn-block"><span class="purindex pcolor04"></span>美容</a>
	</div>
	<div class="col-xs-3 tab_subset">
		<a href="<?php echo U('Purchase/class_list',array('t'=>9));?>" class="btn-block"><span class="purindex pcolor06"></span>养护</a>
	</div>
	<div class="col-xs-3 tab_subset">
		<a href="<?php echo U('Purchase/index',array('t'=>27));?>" class="btn-block"><span class="purindex pcolor07"></span>精品</a>
	</div>
	<div class="col-xs-3 tab_subset">
		<a href="<?php echo U('Purchase/class_list',array('t'=>0));?>" class="btn-block"><span class="purindex pcolor08"></span>全部分类</a>
	</div>
	<!-- <div class="col-xs-3 tab_subset">
		<a href="<?php echo U('Purchase/index',array('t'=>4));?>" class="btn-block"><span class="purindex pcolor04"></span>美容保养</a>
	</div> -->
</div>

<div class="inline"></div>

<!-- 精品推荐 -->
<h3 class="col-xs-12" style=" font-size: 16px;margin: 12px 0;">精品推荐</h3>

<script type="text/javascript">

	var currentpage=0;
	ajax_get_qualitygoods();//初始化添加商品列表
	//滚动加载
	$(window).scroll(function(){ 
        totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 
        if($(document).height() <= totalheight){ 
            if(stop==true){ 
            	MsgBox('正在加载...');
            	currentpage++;
                ajax_get_qualitygoods();
            } 
        } 
    });

    //加载商品
	function ajax_get_qualitygoods(){
		//var keyword=$('#keyword').val(),attr_value=$('#attr_value').val(),sort=$('#sort').val(),class_id=$('#class_id').val();
	    $("#load").show();
	    stop=false;
	    $.get("<?php echo U('Purchase/ajax_get_qualitygoods');?>",{"p":currentpage}
	  	,function(html){
	          if(html!=""){ 
	            if(currentpage==0) {
	                $("#goods_list").html(html);
	            }else {
	               $("#goods_list").append(html);                                               
	            }
	            stop=true;                 	
	          }else{
	          	MsgBox('已加载全部数据');
	          	if(currentpage==0){
	          		$("#goods_list").html('<div class="no_record col-sm-12">暂无数据</div>');
	          	}                  	
	          }                
	         $("#load").hide();  
	    });
	}
</script>

<div class='tab_parent' id="goods_list">

</div>

<div class="purchase_index"><a class="btn-block" href="<?php echo U('Purchase/home');?>"></a></div>

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
<script src="__PUBLIC__/js/iscroll.js"></script>
<script src="__PUBLIC__/js/jquery.drawer.min.js"></script>
</body>
</html>