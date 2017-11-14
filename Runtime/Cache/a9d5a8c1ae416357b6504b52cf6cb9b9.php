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
<!--头部-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<style type="text/css">
.shoptitle{background: #f4f4f4; height: 70px; }
.shoptitle p,.shoptitle em{font-size: 12px; color: #808080;}
.shoptitle em,.money-h i{font-style: normal;}
.reservelist{ padding: 10px 0; border-bottom: 1px solid #eaeaea; overflow: hidden;}
.reservelist span{ width: 64px; height: 64px; display: inline-block; border-radius: 50%; vertical-align: middle; margin-right: 10px;}
.project1{background: url(__PUBLIC__/images/reserve.svg) no-repeat 14px 9px; background-size: 420px; background-color: #f2d445;}
.project2{background: url(__PUBLIC__/images/reserve.svg) no-repeat -57px 9px; background-size: 420px; background-color: #4db9f9;}
.money-h{font-size: 18px; margin-top: 16px;    display: inline-block;}
.money-h i{font-size: 26px; color: #ffa800;}
.re_more{padding: 10px 0; border-bottom: 1px solid #eaeaea;}
.shoplist{overflow: hidden; height: 172px;}
.shoplist_2{overflow: hidden;}
a:focus, a:hover { color: #5f5f5f;text-decoration: initial;}
</style>
<div class="container-fluid topbox">
    <div class="row top">
        <div class="pg-Current">
            <a href="javascript:history.back();" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
            <img src="__PUBLIC__/images/shang.png" width="30" height="30">
        </div>
        <div class="pgt">
            <a>预约洗车</a>
        </div>
       
    </div>
</div>



<!--菜单属性筛选-->
<nav id="cbp-hrmenu" class="cbp-hrmenu">
    <ul>        
        <li id="area" date-url="<?php echo U('Advance/area'); echo ($link); ?>"> <a href="#" class="hrmenutopa my_od_f"><?php echo ($area_name); ?><span></span></a>
            <div id="area_html"></div>
        </li>
     
            <li id="car_type" date-url="<?php echo U('Advance/car_type'); echo ($link); ?>"> <a href="#" class="hrmenutopa my_od_f"><?php echo ($type_name); ?><span></span></a>
                <div id="car_type_html">
                    

                </div>
            </li>
   
       
        <li id="order_by" date-url="<?php echo U('Advance/order_by'); echo ($link); ?>"> <a href="#" class="hrmenutopa my_od_f"><?php echo ($order_name); ?><span></span></a>
            <div id="order_by_html"></div>
        </li>
    </ul>
</nav>

<!-- <div class="black" id="black" style="top:145px;">
    <div style="width:37px; height:37px; position:absolute; z-index:9; top:10px; left:50%; margin-left:-12px;"><img src="__PUBLIC__/images/kitload.gif"></div>
</div> -->
<script>
$('body').css('position','relative');
var cbpHorizontalMenu = (function() {
    var b = $("#cbp-hrmenu > ul > li"),
    g = b.children("a"),
    c = $("body"),
    bk = $("#black"),
    d = -1;
    function f() {
        g.on("click", a);
        b.on("click",
        function(h) {
            h.stopPropagation()
        })
    }
    function a(j) {
        if (d !== -1) {
            b.eq(d).removeClass("cbp-hropen");
            bk.hide();  
        }
        var i = $(j.currentTarget).parent("li"),
        h = i.index();
        if (d === h) {
            i.removeClass("cbp-hropen");
            bk.hide();  
            d = -1;
        } else {
            i.addClass("cbp-hropen");
            doselect(i.attr('id'),i.attr('date-url'))
            bk.show(); 
            d = h;
            c.off("click").on("click", e);
        }
        return false
    }
    function e(h) {
        b.eq(d).removeClass("cbp-hropen");
        bk.hide(); 
        d = -1;
    }
    return {
        init: f
    }
})();

$(function() {
    cbpHorizontalMenu.init();
   
});
    
//筛选菜单下的选项卡
function nTabs(thisObj,Num){
   if(thisObj.className == "active")return;
    var tabObj = thisObj.parentNode.id;
    var tabList = document.getElementById(tabObj).getElementsByTagName("li");
    var tabListLength = tabList.length;
    for(i = 0 ; i < tabListLength; i++)
    {
        if (i == Num)
        {
           tabList[tabListLength-i-1].className = "active"; 
           document.getElementById(tabObj+"_Content"+i).className = "";
        }else{
           tabList[tabListLength-i-1].className = "normal"; 
           document.getElementById(tabObj+"_Content"+i).className = "none";
        }
    } 
    return false;
}
function doselect(name, url) {
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'html',
        success: function(data) {
            $("#" + name + "_html" ).html(data);
        }
    });
}

function getPosition() {
        $('#position-tip').show();
        var geolocation = new BMap.Geolocation(); 
        
        geolocation.getCurrentPosition(function (r) {
             console.log(this.getStatus())
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                point_lng=r.point.lng;
                point_lat=r.point.lat;

                address = r.address.district+' '+r.address.street+r.address.street_number;
                var expiresDate= new Date();
                
                expiresDate.setTime(expiresDate.getTime() + (2*60*1000));  
                $.cookie('lng',point_lng, {expires: expiresDate});
                $.cookie('lat',point_lat, {expires: expiresDate});
                $.cookie('address',address, {expires: expiresDate});
                $('#position-tip').hide();               
                 ajaxRed(point_lng,point_lat);
            }else if(this.getStatus()==BMAP_STATUS_SERVICE_UNAVAILABLE){            
                MsgBox("无法通过浏览器定位您的位置.您可以在我们诚车堂微信中发送您的地理位置给我们，以便获取您附近的商家");
                 ajaxRed(0,0);
            }else if(this.getStatus()==BMAP_STATUS_TIMEOUT) {
                MsgBox("请求超时,请刷新再试"); 
                 ajaxRed(0,0);
            }
         }); 
    }

   
    
</script>


    <div class="none" id="position-tip">
        <div class="container-fluid">
            <div class="row"><center><div style="line-height:40px;"><img src=" __PUBLIC__/images/minilodging.gif">正在加载...</div></center></div>
        </div>
    </div>
    <div class="line none" id="address" style=" border-top:0; min-height:3.5rem; line-height:3.5rem; padding:0 1rem;}" onclick="reGetPosition();">
        <p id="address-show" style="width:90%;white-space: nowrap;text-overflow: ellipsis;overflow: hidden; float:left;color:#616161;"></p>
        <span class="glyphicon glyphicon-repeat" aria-hidden="true" style="float:right;line-height:3.5rem;"></span>
    </div>
    <div id="adlist"></div>

<script type="text/javascript" src="http://api.map.baidu.com/api?v2.0&ak=tEflu9uwxEGzOsVPA11HS9Yl"></script> 

<script type="text/javascript">
    var currentpage=0;
    if($.cookie('lng')){
        ajaxRed(0,0); 
    }else{
         getPosition();
    }
   
    $(window).scroll(function(){ 
            totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 
            if($(document).height() <= totalheight){ 
                if(stop==true){ 
                    ajaxRed();
                } 
            } 
        });
    function ajaxRed(p_lng,p_lat){ 
                $("#load").show();
                  stop=false;
                  var lng,lat;
                  if(p_lng&&p_lat){
                     lng=p_lng;
                     lat=p_lat;
                  }else{
                     lng =$.cookie('lng');
                     lat =$.cookie('lat');    
                  }
                                 
                  $.get("<?php echo U('Advance/ajax_get_service'); echo ($link); ?>"+'&lng='+lng+'&lat='+lat,{"p":currentpage}
                  ,function(html){
                          if(html!=""){ 
                            if(currentpage==0) {
                                $("#adlist").html(html);
                            }
                            else {
                               $("#adlist").append(html);                                               
                            } 
                          }else{
                            MsgBox('已加载全部洗车');
                          }
                          stop=true;
                          currentpage++;
                         $("#load").hide();  
                     });
      }
        function show_more(tag){
            if($(tag).parent().find('.shoplist').hasClass('show_more')){
                 $(tag).parent().find('.shoplist').css('height','172px').removeClass('show_more');
                  $(tag).find('a').html('查看更多')
            }else{
                $(tag).parent().find('.shoplist').css('height','auto').addClass('show_more');
                 $(tag).find('a').html('收起更多')
            }
            
           
        }

         


</script>

<p>&nbsp;</p>
<p>&nbsp;</p>

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