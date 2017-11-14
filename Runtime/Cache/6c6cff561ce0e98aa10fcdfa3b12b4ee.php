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
<style type="text/css">
.tab_parent{padding-left: 15px;}
.tab_subset{margin:0; padding: 0 15px 0 0;}
.o_f{overflow: hidden;}
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}

.shopbtn{padding: 12px 10px; }
.shopbtn a,.nav_telbtn a{text-align: center;font-size: 12px;}
.shopbtn a span{display: block;width: 48px; height: 48px; border-radius: 32px; margin: 0 auto 5px auto;}
.shopbtnico{background-image: url(__PUBLIC__/images/storeico.svg);background-repeat: no-repeat;background-size: 397px;}
.pcolor01{background-color: #ff5441; background-position: 10px 13px;}
.pcolor02{background-color: #fd9229;  background-position: -40px 12px;}
.pcolor03{background-color: #54c7ac;  background-position: -94px 12px;}
.pcolor04{background-color: #589fe4;  background-position: -158px 12px;}
.pcolor05{background-color: #bd64e4;  background-position: -216px 12px;}
.pcolor06{background-color: #617bf1;  background-position: -273px 12px;}
.pcolor07{background-color: #ff744d;  background-position: -324px 12px}


.nav_telbtn{width: 116px; padding-top: 15px; margin-bottom: 15px; margin-left: 5px;}
.nav_telbtn a{float: left;}
.nav_telbtn a span{display: block;width: 48px; height: 48px; border-radius: 5px; margin: 0 auto 5px auto;}

.shopinfo h3{ font-size: 14px; margin: 15px 0 5px 0; font-weight: bold;}
.shopinfo .address{font-size: 12px; margin: 0; color: #7d7d7d;}
.imgnumber{position:absolute; right:5px; bottom:40px; padding:0 10px; border-radius:15px; color:#FFF; background:#000; background:rgba(0,0,0,0.4);filter:alpha(opacity=40);}
.n_bg{background:#cd0000 url(__PUBLIC__/images/cardbg.png) repeat-x 0 87px;}
.c_bg{background:#f47300 url(__PUBLIC__/images/cardbg.png) repeat-x 0 87px;}
.cardul{box-shadow: 1px 1px 0 #e9e9e9; padding: 6px; margin-top: 12px;  height:145px; border-radius: 10px;}

.cardul h2{height: 45px; overflow: hidden; font-size: 20px; color: #fff; margin: 11px 0 0 0;}
.cardul h2 i{margin-right: 6px;}
.cardul h2 i img{border-radius: 45px;}
.cardul p.mintxt{ color: #fff; height: 17px; overflow: hidden; font-size: 12px; text-indent: 4.2em;}
.cardul .row{margin-top: 24px;}

.yh_ico{width: 30px;height: 30px;display: block; position: absolute;top: 5px;right: 6px;border-radius: 30px;color:#cd0000;text-align: center;line-height: 30px;font-size: 12px;background:#ffe400;}
.pointab{font-size: 12px;}
.djx{vertical-align: middle;}
.pointab p{margin: 5px 10px 5px 0}

/*焦点图*/
.swiper-container,.swiper-slide{height: 200px;}
.xqtitle h1{display: block;  flex-basis: 1px;  display: -webkit-box;  -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    word-wrap: break-word;  overflow: hidden;  -webkit-box-pack: center;  line-height: 1.35em;  height: 3em; font-size: 14px; color: #051B28;}


.swiper-slide a{width: 100%; text-align: center;}
.shopname,.imgnumber{z-index: 2;text-align: left;}


</style>
<body id="Jlazy_img">
<!--头部-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<div class="container-fluid topbox">
    <div class="row top">
        <div class="pg-Current">
        	<a href="javascript:history.back();" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
        	<img src="__PUBLIC__/images/shang.png" width="30" height="30">
        </div>
        <div class="pgt">
        	<a>商家详情</a>
        </div>
    </div>
</div>

<!--商家概况
<div class="container-fluid" >
	<div class="row" style="position:relative;">
			<img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($supplier["preview"],'large')); ?>" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');" style="width:100%; height:auto;"> 
        <div class="shopname">
            <h2><span><img src="__PUBLIC__/images/chuang.png" width="30" height="30"></span><?php echo ($supplier["name"]); ?></h2>
            <p><?php if($supplier['business_scope']): ?>经营项目： <?php echo ($supplier["business_scope"]); endif; ?></p>
        </div>
	</div>
</div>-->




<!--焦点图-->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <a href="<?php echo U('Store/album',array('id'=>$supplier['id']));?>"><img  src="<?php echo (getimgurl($supplier["preview"],'large')); ?>"  onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');"></a>
        </div>
        <?php if(is_array($album)): $i = 0; $__LIST__ = $album;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                <a href="<?php echo U('Store/album',array('id'=>$supplier['id']));?>"><img  src="<?php echo (getimgurl($a["image"],'large')); ?>" src2="" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');"></a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="shopname">
       <!--  <h2><span><img src="__PUBLIC__/images/chuang.png" width="30" height="30"></span><?php echo ($supplier["name"]); ?></h2> -->
    </div>
    <span class="imgnumber"><?php echo ($supplier["album_count"]); ?></span>
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



<!-- <div class="container-fluid" >
    <div class="row" style="position:relative;">
        <a href="<?php if($supplier["album_count"] == 0): ?>javascript:MsgBox('相册暂无相片');<?php else: echo U('Store/album',array('id'=>$supplier['id'])); endif; ?>"><img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($supplier["preview"],'large')); ?>" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');" style="width:100%; height:auto;"> </a>
        <div class="shopname">
            <h2><span><img src="__PUBLIC__/images/chuang.png" width="30" height="30"></span><?php echo ($supplier["name"]); ?></h2>
        </div>
        <span class="imgnumber"><?php echo ($supplier["album_count"]); ?></span>
    </div>
</div> -->

<div class="shopbtn box_flex">
    <div class="flex1">
        <a href="<?php echo U('Store/info',array('id'=>$supplier['id']));?>" class="btn-block"><span class="shopbtnico pcolor01"></span>门店介绍</a>
    </div>
    <div class="flex1">
        <a href="<?php echo U('Store/goods',array('id'=>$supplier['id']));?>" class="btn-block"><span class="shopbtnico pcolor02"></span>项目分类</a>
    </div>
    <div class="flex1">
        <a href="<?php echo U('Store/project',array('id'=>$supplier['id']));?>" class="btn-block"><span class="shopbtnico pcolor03"></span>服务案例</a>
    </div>
    <div class="flex1">
        <a href="<?php echo U('Store/staff_style',array('id'=>$supplier['id']));?>" class="btn-block"><span class="shopbtnico pcolor04"></span>员工风采</a>
    </div>
    <div class="flex1">
        <a href="<?php echo U('Store/news',array('id'=>$supplier['id']));?>" class="btn-block"><span class="shopbtnico pcolor05"></span>门店资讯</a>
    </div>
</div>


<!--电话地址
<div class="container-fluid" >
	<div class="row phon">
    		<div class="col-xs-1"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></div>
			<div class="col-xs-8"><a href="<?php echo U('Store/map',array('id'=>$supplier['id']));?>"><?php echo ($supplier["address"]); ?></a></div>
            <div class="col-xs-2"><a href="tel:<?php echo ($supplier["tel"]); ?>"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span></a></div>
	</div>
</div>
-->
<div class="container-fluid line"></div>

<div class="container">
    <div class="row" >
        <div class="col-xs-12" >
            <div class="tab_t">
                <h2>商家信息</h2>
                <!-- <a style="font-size: 14px;margin-top: 10px;margin-bottom: 10px;" href="<?php echo U('Advance/reservation');?>"><button type="button" class="btn btn-primary">预约</button></a> -->
            </div>
        </div>
    </div>
</div>



<div class="box_flex col-xs-12 o_f">
    <div class="flex1 shopinfo o_f">
        <h3><?php echo ($supplier["name"]); ?></h3>
        <p class="address"><?php echo ($supplier["address"]); ?></p>
        <p><span class="glyphicon glyphicon-map-marker"></span> <span id='distance'>计算距离中...</span></p>
    </div>
    <div class="nav_telbtn">
        <a href="<?php echo U('Store/map',array('id'=>$supplier['id']));?>">
            <span class="shopbtnico pcolor06"></span>
            一键导航
        </a>
        <a style="width: 1px; height: 37px; background: #d6d6d6; display: inline-block;margin: 5px 8px 0 8px;"></a>
        <a href="tel:<?php echo ($supplier["tel"]); ?>">
            <span class="shopbtnico pcolor07"></span>
            一键拨号
        </a>
    </div>
</div>


<!--分割线-->


<!--商家简介
<div class="container-fluid" >
	<div class="row">
    		<div class="shopjj">
            	<p>营业时间：08:30-18:00</p>
                <p>成交： <?php echo ($supplier["count_order"]); ?></p>
                <p class="text-left" style="float:left;"><span class="djx" id="pf05"></span>4.92分</p>
            </div>
			<div class="shopxc">
            	<a href="<?php if($supplier["album_count"] == 0): ?>javascript:MsgBox('相册暂无相片');<?php else: echo U('Store/album',array('id'=>$supplier['id'])); endif; ?>" style=" display:block;">
                	<img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($supplier["preview"],'160x100')); ?>" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');" style=" width:100%; height:auto;">
                    <P><?php echo ($supplier["album_count"]); ?></P>
                </a>
            </div>
	</div>
</div>-->

<!-- <div class="container-fluid line"></div>E卡专区
<div class="container">
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
                <h2><i><img class="lazy_img" src="<?php echo (getimgurl($preview,'little')); ?>" width="45" height="45"  onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');"/></i><?php echo ($c["name"]); ?></h2>
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

</if>
<!--分割线-->
<div class="container-fluid line"></div>

<!--服务项目-->
<div class="container">
	<div class="row" >
    	<div class="col-xs-12" >
        	<div class="tab_t">
    			<h2>服务项目、汽车用品</h2>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v2.0&ak=tEflu9uwxEGzOsVPA11HS9Yl"></script> 
<script type="text/javascript">
//计算距离
var geolocation = new BMap.Geolocation();
 $(function(){
    geolocation.getCurrentPosition(function (r) {
        if (this.getStatus() == BMAP_STATUS_SUCCESS) {
            $.post("<?php echo U('Service/getDistanceToStore');?>",{id:'<?php echo ($supplier["id"]); ?>',lng:r.point.lng,lat:r.point.lat},//lng 经度 lat 纬度
                   function(d){
                        if(d){
                            if (d.status == 1) {
                                 $('#distance').text(d.data+'km'); 
                            } else{
                                $('#distance').text(d.info); 
                            }
                        }else {
                            $('#distance').text('计算失败，请刷新后重试');
                        }
                   }, "json");
        }else if(this.geStatus()==BMAP_STATUS_SERVICE_UNAVAILABLE) {      
            MsgBox("位置结果未知");
        }
        else if(this.getStatus() == BMAP_STATUS_SERVICE_UNAVAILABLE) {      
            MsgBox("无法通过浏览器定位您的位置.您可以在我们诚车堂微信中发送您的地理位置给我们，以便获取您附近的商家");
        }else if(this.getStatus()==BMAP_STATUS_TIMEOUT) {
            MsgBox("请求超时,请刷新再试");
        }
    }); 
});
</script>  
<div class="container-fluid">
<?php if($deals): ?><div class="row">
    	<div class="col-xs-12 " id="store-deals">
            <div class="row">
                <div class="col-xs-12" id="behind-loading">
                <?php if(is_array($deals)): foreach($deals as $key=>$rs): ?><div class="row">
                        <a href="<?php if($rs['is_shop'] == 1): echo U('Goods/view',array('id'=>$rs['id'])); else: echo U('Service/view',array('id'=>$rs['id'])); endif; ?>" class="tab_a tab_b_l">
                            <div class="col-xs-5" style="margin:10px 0 0 0;">
                                <img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($rs["img"],'middle')); ?>" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');" style=" width:100%; height:auto"> 
                            </div>
                            <div class="col-xs-7 txtbox" style="margin:0; padding:0;">
                                <h3><?php echo ($rs["name"]); ?></h3>
                                <p class="tcont"><?php echo ($rs["brief"]); ?></p>
                                <p><b><?php echo (price($rs["current_price"])); ?>元</b><del><?php echo (price($rs["origin_price"])); ?>元</del> <span style="float:right;">已售<?php echo ($rs["order_count"]); ?></span></p>
                            </div>
                        </a>
                    </div><?php endforeach; endif; ?>
                </div>
            </div>
        <?php if($deal_count_nums > 3): ?><div class="row">
            	<div class="col-xs-12">
            		<a href="javascript:void(0);" onclick="loadDeals(this,'<?php echo ($supplier["id"]); ?>');" class="tjbtn"><p class="text-center"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span><span style="margin-left:5px;" id='loading-deals-tip'>查看其他<?php echo ($deal_count_nums-3); ?>条</span><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></p></a>
                </div>
            </div>


<script type="text/javascript">
var r_page = 1 ;
function loadDeals(obj,sid) {
    var loadingTip  =  $('#loading-deals-tip'),                   // 防止重复点击
        allRows     =  parseInt('<?php echo ($deal_count_nums); ?>'),         // 所有的行数
        loadingRows =  5 ,                                           // 每次加载的行数
        existRows   =   parseInt('<?php echo (count($deals)); ?>') ;               // 页面初始已经加载的行数   
    if (loadingTip.text() == '努力加载中...') {
        MsgBox("正在加载中，请稍候");
        return false;
    }
    $.ajax({ 
        type:"post",
        url: "<?php echo U('Store/ajaxGetDeals');?>", 
        data:{
            id:sid,
            page:r_page,
            arows:allRows,
            lrows:loadingRows,
            erows:existRows
        }, 
        dataType:"json",
        beforeSend:function (XMLHttpRequest) {
            loadingTip.text('努力加载中...');
        },
        success: function(d){
            if(d){
                if (d.status == 1 || d.status == 2) {
                    var DealsList = d.data,
                        DealsListLength = d.data.length,
                        html = '';
                    for (var i = 0; i < DealsListLength; i++) {
                        html += '<div class="row isdealsload" >';
                        html +=    '<a href="'+DealsList[i].url+'" class="tab_a tab_b_l">';
                        html +=       '<div class="col-xs-5" style="margin:10px 0 0 0;">';
                        html +=          '<img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="'+DealsList[i].img+'" onerror="imgError(this,"http://s.17cct.com/v3/images/errorimg.jpg");" style=" width:100%; height:auto">';
                        html +=       '</div>';
                        html +=       '<div class="col-xs-7 txtbox" style="margin:0; padding:0;">';
                        html +=          '<h3>'+DealsList[i].name+'</h3>';
                        html +=          '<p class="tcont">'+DealsList[i].brief+'</p>';
                        html +=          '<p><b>'+DealsList[i].current_price+'元</b><del>'+DealsList[i].origin_price+'元</del> <span style="float:right;">已售'+DealsList[i].order_count+'</span></p>';
                        html +=        '</div>';
                        html +=    '</a>';  
                        html +='</div>';
                    }
                    $('#behind-loading').append(html);
                    var deals_img_lazy = Lazy.create({
                                lazyId: "store-deals",
                                trueSrc: 'src2',
                                offset: 0, 
                                delay: 0, 
                                delay_tot: 0 
                              }); 
                    Lazy.init(deals_img_lazy);

                    if (d.status == 1) {
                       loadingTip.text('查看其他'+(allRows-existRows-loadingRows*r_page)+'条');
                       r_page++; 
                    } else{
                        loadingTip.text('收起列表').next(".glyphicon").removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
                        $(obj).attr('onclick','showOrhideDeals(this);');
                    }

                }else {
                    loadingTip.text('查看其他'+(allRows-existRows-loadingRows*(r_page-1))+'条');
                    MsgBox("加载失败，请稍候重试");
                }

            }else{
                loadingTip.text('查看其他'+(allRows-existRows-loadingRows*(r_page-1))+'条');
                MsgBox("加载失败，请稍候重试");
            } 
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            loadingTip.text('查看其他'+(allRows-existRows-loadingRows*(r_page-1))+'条');
            MsgBox("加载失败，请稍候重试");
        }
    });
    return false; 
}
function showOrhideDeals() {
    var _s = $('#store-deals'),
        _si = _s.find('.isdealsload'),
        _l = $('#loading-deals-tip'),
        _text = _l.text();
    if (_text == '收起列表') {
        _l.text('展开列表').next(".glyphicon").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
        _si.hide();
        $("html,body").animate({scrollTop:_s.offset().top}, 500);
    }else{
        _l.text('收起列表').next(".glyphicon").removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
        _si.show();
    }
    return false;
}
</script><?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="row" >
        <p style="color: #5f5f5f;text-align: center;margin-top:10px;">暂无项目</p>
    </div><?php endif; ?>
</div>

<!--分割线-->
<div class="container-fluid line"></div>

<!--交易评价-->
<div class="container">
	<div class="row" >
    	<div class="col-xs-12" >
        	<div class="tab_t">
    			<h2>交易评价</h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
<?php if($reviews): ?><div class="row">
        <div class="col-xs-12">
            <?php if(is_array($reviews)): foreach($reviews as $key=>$re): ?><div class="row" style="border-bottom:1px solid #cbcbcb;">
                    <div class="col-xs-12 pltop" style="margin:10px 0 0 0;">
                        <h4 style="width:98px;overflow:hidden;text-overflow:ellipsis; white-space:nowrap;">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span><?php echo ($re["user_name"]); ?>
                        </h4>
                        <time><?php echo (date("Y-m-d",$re["create_time"])); ?></time>
                        
                    </div>
                    <div class="col-xs-12 pointab">
                    <?php if($re['dp_point_group'] != null): if(is_array($re['dp_point_group'])): foreach($re['dp_point_group'] as $key=>$dp): ?><p class="text-left pull-left"><?php if($dp['group_id'] == 1): ?>服务评分<?php else: ?>技术评分<?php endif; ?><span class="djx" id="pf0<?php echo ($dp["point"]); ?>"></span></p><?php endforeach; endif; ?>
                    <?php else: ?>
                        <p class="text-left pull-left">技术评分<span class="djx" id="pf00"></span></p> 
                        <p class="text-right pull-right">服务评分<span class="djx" id="pf00"></span></p><?php endif; ?>
                         
                    </div>
                    <div class="col-xs-12" style="margin:10px 0 0 0;">
                        <?php echo ($re["content"]); ?>
                    </div>
                    <div class="col-xs-12" style="margin:10px 0 10px 0;">
                        <span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span><a href="<?php echo ($re["deal_url"]); ?>" style="color:#a9a9a9;"><?php echo ($re["title"]); ?></a>
                    </div>  
            </div><?php endforeach; endif; ?>
        <?php if($reviews_count_nums > 3): ?><div class="row" id="d-loading">
                <div class="col-xs-12">
                    <a href="javascript:void(0);" onclick="loadReviews('<?php echo ($supplier["id"]); ?>');" class="tjbtn"><p class="text-center"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span><span style="margin-left:5px;" id='loading-tip'>查看其他<?php echo ($reviews_count_nums-3); ?>条评价</span><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></p></a>
                </div>
            </div>
<script type="text/javascript">
var r_page = 1 ;
function loadReviews(sid) {
    var loadingTip  =  $('#loading-tip'),                   // 防止重复点击
        allRows     =  parseInt('<?php echo ($reviews_count_nums); ?>'), // 所有的行数
        loadingRows =  5 ,                                  // 每次加载的行数
        existRows   =   parseInt('<?php echo (count($reviews)); ?>') ;    // 页面初始已经加载的行数   
    if (loadingTip.text() == '努力加载中...') {
        MsgBox("正在加载中，请稍候");
        return false;
    }
    $.ajax({ 
        type:"post",
        url: "<?php echo U('Store/ajaxGetReviews');?>", 
        data:{
            id:sid,
            page:r_page,
            arows:allRows,
            lrows:loadingRows,
            erows:existRows
        }, 
        dataType:"json",
        beforeSend:function (XMLHttpRequest) {
            loadingTip.text('努力加载中...');
        },
        success: function(d){
            if(d){
                if (d.status == 1 || d.status == 2) {
                    var reviewsList = d.data,ponit_name='',
                        reviewsListLength = d.data.length,
                        html = '';                        
                       // console.log(reviewsList[1]['dp_point_group'][1]['point']);
                    for (var i = 0; i < reviewsListLength; i++) {
                        html += '<div class="row" style="border-bottom:1px solid #cbcbcb;">';
                        html +=    '<div class="col-xs-12 pltop" style="margin:10px 0 0 0;">';
                        html +=      '<h4 style="width:98px;overflow:hidden;text-overflow:ellipsis; white-space:nowrap"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>'+reviewsList[i].user_name+'</h4>';
                        html +=      '<time>'+reviewsList[i].create_time+'</time></div><div class="col-xs-12 pointab">';
                        if(reviewsList[i]['dp_point_group']){
                            for( var j=0; j<2;j++){
                                if(reviewsList[i]['dp_point_group'][j]['group_id']==1){
                                    ponit_name='服务评分';
                                }else{
                                    ponit_name='技术评分';
                                }
                               html += '<p class="text-left pull-left">'+ponit_name+'<span class="djx" id="pf0'+reviewsList[i]['dp_point_group'][j]['point']+'"></span></p>'; 
                            }
                        }else{
                            html += '<p class="text-left pull-left">技术评分<span class="djx" id="pf00"></span></p><p class="text-right pull-right">服务评分<span class="djx" id="pf00"></span></p>';
                        }
                        
                        
                        html +=    '</div>';
                        html +=    '<div class="col-xs-12" style="margin:10px 0 0 0;">'+reviewsList[i].content+'</div>';
                        html +=    '<div class="col-xs-12" style="margin:10px 0 10px 0;">';
                        html +=       '<span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span>';
                        html +=      '<a href="'+reviewsList[i].deal_url+'" style="color:#000;">'+reviewsList[i].title+'</a>';
                        html +=    '</div>';  
                        html +='</div>';
                    }
                    $('#d-loading').before(html);

                    if (d.status == 1) {
                       loadingTip.text('查看其他'+(allRows-existRows-loadingRows*r_page)+'条评价');
                       r_page++; 
                    } else{
                        $('#d-loading').after('<div class="row" ><p style="color: #5f5f5f;text-align: center;margin-top:10px;">已加载全部评论</p></div>');   
                        $('#d-loading').remove();
                    }

                }else {
                    loadingTip.text('查看其他'+(allRows-existRows-loadingRows*(r_page-1))+'条评价');
                    MsgBox("加载失败，请稍候重试");
                }

            }else{
                loadingTip.text('查看其他'+(allRows-existRows-loadingRows*(r_page-1))+'条评价');
                MsgBox("加载失败，请稍候重试");
            } 
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            loadingTip.text('查看其他'+(allRows-existRows-loadingRows*(r_page-1))+'条评价');
            MsgBox("加载失败，请稍候重试");
        }
    });
    return false; 
}
</script><?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="row" >
        <p style="color: #5f5f5f;text-align: center;margin-top:10px;">暂无评论</p>
    </div><?php endif; ?>   
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
var xx_lazy = Lazy.create({
                lazyId: "Jlazy_img",
                trueSrc: 'src2',
                offset: 300, 
                delay: 100, 
                delay_tot: 5000 
              }); 
Lazy.init(xx_lazy);

$(function(){

    document.title = '<?php echo ($title); ?>';
  
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'checkJsApi',
            'openLocation',
            'getLocation',
            'onMenuShareTimeline',
            'onMenuShareAppMessage'
          ]
    });
    wx.ready(function () {
        wx.onMenuShareAppMessage({
          title: '【诚车堂】<?php echo ($title); ?>',
          desc: '<?php echo ($desc); ?>',
          link: 'http://m.17cct.com/index.php/Store/view/id/<?php echo ($sid); ?>.html',
          imgUrl: '<?php echo (getimgurl($supplier["preview"],"middle")); ?>',
          trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
            // alert('用户点击发送给朋友');
          },
          success: function (res) {
            // alert('已分享');
          },
          cancel: function (res) {
            // alert('已取消');
          },
          fail: function (res) {
            // alert(JSON.stringify(res));
          }
        });

        wx.onMenuShareTimeline({
          title: '【诚车堂】<?php echo ($title); ?>',
          link: 'http://m.17cct.com/index.php/Store/view/id/<?php echo ($sid); ?>.html',
          imgUrl: '<?php echo (getimgurl($supplier["preview"],"middle")); ?>',
          trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
            // alert('用户点击分享到朋友圈');
          },
          success: function (res) {
            // alert('已分享');
          },
          cancel: function (res) {
            // alert('已取消');
          },
          fail: function (res) {
            // alert(JSON.stringify(res));
          }
        });
    });
});

</script>

<!--底栏-->
<!--底栏-->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/font-awesome/css/font-awesome.min.css">
<div style=" height: 50px;  clear: both;"></div>
<div class="container-fluid">
    <div class="bottombtn">
        <div class="col-xs-4"><a href="<?php echo U('Biz/entrance');?>" class="b_btn"><i class="fa fa-home"></i><div>首页</div></a></div>
        <div class="col-xs-4"><a href="<?php echo U('Store/view');?>"><i class="fa fa-suitcase"></i><div>我的商城</div></a></div>
        <div class="col-xs-4"><a href="http://www.vzan.com/f/s-707026" ><i class="fa fa-users"></i><div>社区</div></a></div>
    </div>
</div>
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