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
<style>
    #bdmap {width: 100%;position: relative;}
    #allmap {overflow: visible; position: absolute; z-index: 0; left: 0px; top: 0px;}
    #allmap .anchorBL {display: none;}
</style>  
<!--头部--> 
<div class="alertBg" id="msgBox" style="display:none;"> 
<h4 class="alerttitle" id="alerttitle"></h4> 
<span class="vm f20" id="alertdetail"></span> 
</div> 
<div class="container-fluid topbox"> 
<div class="row top"> 
<div class="pg-Current"> 
 <a href="javascript:history.back();"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a> 
</div> 
<div class="pg-Current"> 
 <img src="__PUBLIC__/images/cheng.png" width="30" height="30" /> 
</div> 
<div class="pgt"> 
 <a>商家地图</a> 
</div> 
</div> 
</div> 
<div class="container-fluid"> 
<div class="row"> 
<div class="col-xs-12 "> 
 <div class="row"> 
  <div class="tab_b_l my_od_f"> 
   <div class="col-xs-12" style="margin:10px 0 0 0;"> 
    <h2 style="font-size:16px;margin:5px 0;font-weight:bold;"><?php echo ($supplier["name"]); ?></h2> 
    <p style="font-size:14px;"><?php echo ($supplier["address"]); ?></p> 
   </div> 
  </div> 
 </div> 
</div> 
</div> 
</div> 
<div class="container-fluid" style="position:relative;"> 
<div class="row"> 
<div id="li-1" class="col-xs-6 map">
 <a href="javascript:void(0);" onclick="goStore();"> <span class="glyphicon glyphicon-map-marker" aria-hidden="true" style="color:#0ba0ed;"></span>到这里去</a>
</div> 
<div id="li-2" class="col-xs-6 map"> 
 <a href="tel:&lt;{$supplier.tel}&gt;"><span class="glyphicon glyphicon-earphone" aria-hidden="true" style="color:#e14c03;"></span>联系商家</a> 
</div> 
</div> 
</div> 
<!--地图内容--> 
<div id="bdmap"> 
<div id="allmap"> 
</div> 
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v2.0&ak=tEflu9uwxEGzOsVPA11HS9Yl"></script> 
<script type="text/javascript">
var map_w = $(document.body).width(), map_h = $(window).height();$("#allmap").css("width",map_w);$("#allmap").css("height",map_h-200);$("#bdmap").css("height",map_h-200);
var s_lng = parseFloat('<?php echo ($supplier["xpoint"]); ?>'), s_lat = parseFloat('<?php echo ($supplier["ypoint"]); ?>');
$(function(){
    initialize();
});
//地图参数
function initialize() {    
    // 百度地图API功能    
    var map = new BMap.Map("allmap");         
    // 创建Map实例    
    var point = new BMap.Point(s_lng,s_lat);  
    // 创建点坐标    
    map.centerAndZoom(point,15);              
    // 初始化地图,设置中心点坐标和地图级别。    
    var myIcon = new BMap.Icon("http://s.17cct.com/v3/images/Map_icon2.png", new BMap.Size(27,34));
    //标注图标    
    var marker = new BMap.Marker(point,{icon:myIcon});  
    // 创建标注     
    map.addControl(new BMap.NavigationControl({offset: new BMap.Size(10, 10), anchor: BMAP_ANCHOR_TOP_RIGHT})); 
    // + - 按钮    
    map.addOverlay(marker);                   
    // 将标注添加到地图中
}
function goStore() {
    MsgBox('定位中，请稍候');    
    var  geolocation = new BMap.Geolocation();    
    geolocation.getCurrentPosition(function (r) {        
        if (this.getStatus() == BMAP_STATUS_SUCCESS) {            
            point_lng = r.point.lng; 
            //经度            
            point_lat = r.point.lat; 
            //纬度            
            local_city = r.address.city;            
            url = 'http://api.map.baidu.com/direction?origin=latlng:'+point_lat+','+point_lng+'|name:我的位置&destination=latlng:'+s_lat+','+s_lng+'|name:商家位置&mode=driving&region='+local_city+'&output=html';        
            window.location.href = url;        
        }else if(this.geStatus()==BMAP_STATUS_SERVICE_UNAVAILABLE) {
            MsgBox("位置结果未知");
        }else if(this.getStatus() == BMAP_STATUS_SERVICE_UNAVAILABLE) {                  
            MsgBox("无法通过浏览器定位您的位置.您可以在我们诚车堂微信中发送您的地理位置给我们，以便获取您附近的商家");        
        }else if(this.getStatus()==BMAP_STATUS_TIMEOUT) {            
            MsgBox("请求超时,请刷新再试");        
        }    
    });  
}
</script><!--底栏-->
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