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

.box-flex{ display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox;  display: flex; }

.flex1{-webkit-box-flex: 1;-moz-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;}



</style>















<!--头部-->

<div class="alertBg" id="msgBox" style="display:none;">

    <h4 class="alerttitle" id="alerttitle"></h4>

    <span class="vm f20" id='alertdetail'></span>

</div>

<?php if($keyword): ?><div class="container-fluid topbox">

        <div class="row top">

            <div class="Current" style="width:16%;">

                <div class="pg-Current">

                    <a href="javascript:history.back();" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>

                </div>

            </div>

            <div class="Search" style="width:68%;">  

                <a href="<?php echo U('Search/index');?>">         

                    <div class="form-control my_od_f" style="text-align:center;">

                        <i class="glyphicon glyphicon-search" aria-hidden="true" style="color:#b9b9b9;"></i>

                        <span style="margin-left:.6rem; color:#999;">搜索<?php if($type == 'service'): ?>服务<?php elseif($type == 'goods'): ?>商品<?php endif; ?>：<?php echo ($keyword); ?></span>

                    </div> 

                </a>            

            </div>

            <div class="Member" style="width:16%;">

                <a href="<?php echo U('Search/index');?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>搜索</a>

            </div>

        </div>

    </div>

<?php else: ?>

    <div class="container-fluid topbox">

        <div class="row top">

            <div class="pg-Current">

                <a href="javascript:history.back();" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>

            </div>

            <div class="pg-Current">

                <img src="__PUBLIC__/images/shang.png" width="30" height="30">

            </div>

            <div class="pgt">

                <a><?php echo ($stitle); if($type == 'service'): ?>服务筛选<?php elseif($type == 'goods'): ?>商品筛选<?php else: ?>未知<?php endif; ?></a>

            </div>

            <div class="cybtn">

                <a href="<?php echo U('Search/index');?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>搜索</a>

            </div>

        </div>

    </div>

    <div class="container-fluid">

        <div class="row">       

            <a href="<?php echo U('Search/deal');?>?type=service" class="all wd_3 <?php if($type == 'service'): ?>Underline<?php endif; ?>">服务</a>

            <a href="<?php echo U('Search/deal');?>?type=goods" class="all wd_3 <?php if($type == 'goods'): ?>Underline<?php endif; ?>">商品</a>    

        </div>

    </div>

    <div class="container-fluid line"></div><?php endif; ?>



<!--菜单属性筛选-->

<nav id="cbp-hrmenu" class="cbp-hrmenu">

    <ul>

        <?php if($type == 'service'): ?><li id="service_cate" date-url="<?php echo U('Search/service_cate'); echo ($link); ?>"> <a href="#" class="hrmenutopa my_od_f"><?php echo ($cate_name); ?><span></span></a>

                <div id="service_cate_html"></div>

            </li>

        <?php elseif($type == 'goods'): ?>

            <li id="goods_cate" date-url="<?php echo U('Search/goods_cate'); echo ($link); ?>"> <a href="#" class="hrmenutopa my_od_f"><?php echo ($cate_name); ?><span></span></a>

                <div id="goods_cate_html"></div>

            </li><?php endif; ?>

        <li id="area" date-url="<?php echo U('Search/area'); echo ($link); ?>"> <a href="#" class="hrmenutopa my_od_f"><?php echo ($area_name); ?><span></span></a>

            <div id="area_html"></div>

        </li>

        <li id="order_by" date-url="<?php echo U('Search/order_by'); echo ($link); ?>"> <a href="#" class="hrmenutopa my_od_f"><?php echo ($orderby); ?><span></span></a>

            <div id="order_by_html"></div>

        </li>

    </ul>

</nav>



<div class="black" id="black" style="top:145px;">

    <div style="width:37px; height:37px; position:absolute; z-index:9; top:10px; left:50%; margin-left:-12px;"><img src="__PUBLIC__/images/kitload.gif"></div>

</div>

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

</script>



<?php if($count == 0): ?><div class="container-fluid line"></div>

    <div class="container-fluid">

        <div class="row"><p style="color: #5f5f5f;text-align:center;margin-top:10px;">暂无信息</p></div>

    </div>

<?php else: ?>

    <div class="none" id="position-tip">

        <div class="container-fluid">

            <div class="row"><center><div style="line-height:40px;"><img src=" __PUBLIC__/images/minilodging.gif">正在加载...</div></center></div>

        </div>

    </div>

 <!--    <div class="line none" id="address" style=" border-top:0; min-height:3.5rem; line-height:3.5rem; padding:0 1rem;}" onclick="reGetPosition(5,'<?php echo ($count); ?>');">

        <p id="address-show" style="width:90%;white-space: nowrap;text-overflow: ellipsis;overflow: hidden; float:left;color:#616161;"></p>

        <span class="glyphicon glyphicon-repeat" aria-hidden="true" style="float:right;line-height:3.5rem;"></span>

    </div> -->

    <div id="adlist"></div>

<script type="text/javascript" src="__PUBLIC__/js/jquery.esn.autobrowse.js"></script>

<script type="text/javascript" src="http://api.map.baidu.com/api?v2.0&ak=tEflu9uwxEGzOsVPA11HS9Yl"></script> 

<script> 

   $(function() {

        var oid = parseInt('<?php echo ($oid); ?>');

        var allRows = parseInt('<?php echo ($count); ?>');

        var loadingRows = 5 ;

        var totalPage = Math.ceil(allRows/loadingRows);

        var max = totalPage > 100 ? 100 : totalPage;

        if (totalPage >= 1) {

            if (oid == 1) { //离我最近 

                var lng = $.cookie('lng');

                var lat = $.cookie('lat');

                var address = $.cookie('address');

                if (lng && lat) {

                    $('#address-show').text(address);

                    $('#address').removeClass('none');

                    adautobrowse('adlist', '<?php echo U("Search/ajaxGetDeal"); echo ($link); ?>&lnums='+loadingRows+'&lng='+lng+'&lat='+lat,max);

                }else{

                   getPosition(loadingRows,max);

                }  

            }else {

                adautobrowse('adlist', '<?php echo U("Search/ajaxGetDeal"); echo ($link); ?>&lnums='+loadingRows,max);

            }

        }

    });



   function reGetPosition (rows,max) {

        $('#adlist').html('');

        $('#address').addClass('none');;

        jQuery(window).unbind("scroll");

        getPosition(rows,max);

    }



    function getPosition (rows,max) {

        $('#position-tip').show();

        var geolocation = new BMap.Geolocation(); 

        geolocation.getCurrentPosition(function (r) {

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
                if(address)
                $('#address-show').text(address);

                $('#address').removeClass('none');;

                adautobrowse('adlist', '<?php echo U("Search/ajaxGetDeal"); echo ($link); ?>&lnums='+rows+'&lng='+point_lng+'&lat='+point_lat,max);

            }else if(this.getStatus()==BMAP_STATUS_SERVICE_UNAVAILABLE){            

                MsgBox("无法通过浏览器定位您的位置.您可以在我们诚车堂微信中发送您的地理位置给我们，以便获取您附近的商家");

            }else if(this.getStatus()==BMAP_STATUS_TIMEOUT) {

                MsgBox("请求超时,请刷新再试"); 

            }

         }); 

    }



    function adautobrowse(dom, url, total) {

        $("#"+dom).autobrowse({

            url: function(offset) {

                return   url + '&p=' + offset;

            },

            template: function(response) {

                return callbacks(response);

            },

            itemsReturned: function(response) {

                return 1;

            },

            max: total,

            offset: 1,

            sensitivity: 100,

            loader: '<div class="container-fluid"></div><div class="container-fluid"><div class="row"><center><div style="line-height:40px;"><img src="__PUBLIC__/images/minilodging.gif">正在加载...</div></center></div></div>',

            finished: function() {

                MsgBox("已加载全部信息");

            },

            onError: function() {

                MsgBox('网络繁忙，请稍后重试')

            }

        });

    }



    function callbacks(response) {

        var markup = '';

        var errorImg = "this.src='http://s.17cct.com/v3/images/errorimg.jpg';this.onerror=''";

        if (response.data) {

            var list = response.data,

                listLength = list.length;

            for (var i= 0;i<listLength;i++) {

                console.log(list[i])

                markup += '<div class="container-fluid">';

                markup += '    <div class="row"><div class="" style="border-bottom: 1px solid #d2d2d2; padding:0 15px;">';

                // markup += '        <div class="col-xs-12" style=" padding-bottom: 9px; ""><div style="float: left; margin: 15px 13px 0 0;"><img style="width:85px;height:85px;" src="'+list[i].preview+'"></div>';

                markup += '            <div class="sjpg_t" style="border:0;">';

                markup += '                <a href="'+list[i].url+'" ><h2 style="margin-top:14px;margin-bottom:9px;">'+list[i].sname+'</h2></a>';

                markup += '                <p class="text-left" style="float:left;margin:0 0 1px;"><span class="djx" style="margin-right:6px;" id="pf0'+parseInt(list[i].avg_point)+'"></span>'+parseFloat(list[i].avg_point).toFixed(2)+'分</p>';



                if (list[i].distance) {

                    markup += '                <p class="text-right" style="font-weight:bold;color:#ff9d09;margin:0 0 1px;">'+list[i].distance+'km</p>';

                } else{

                    markup += '                <p class="text-right" style=";margin:0 0 1px;">&nbsp</p>';

                }

                markup += '                <p class="my_od_f" style="color:#919191;margin:0 0 5px;">'+'</p>';

                markup += '            </div>';

                markup += '        </div></div>';

                markup += '    </div>';

                markup += '</div>';

                markup += '<div class="container-fluid">';

                markup += '    <div class="row">';

                markup += '        <div class="col-xs-12 ">';

                if (list[i].items) {

                    var listItem = list[i].items;

                    var listItemLength = listItem.length;

                    for (var itm = 0; itm < listItemLength; itm++) {

                        markup += '            <div class="row">';

                        markup += '                <a href="'+listItem[itm].url+'" class="tab_a tab_b_l box-flex" style="padding:0;">';

                        markup += '                    <div class="" style="margin:10px; width:100px;">';

                        markup += '                        <img src="'+listItem[itm].img+'" onerror="'+errorImg+'" style=" width:100%; height:auto">'; 

                        markup += '                    </div>';

                        markup += '                    <div class="flex1 txtbox" style="margin:0; padding:0;">';

                        markup += '                        <h3>'+listItem[itm].name+'</h3>';

                        markup += '                        <p class="tcont">'+listItem[itm].brief+'</p>';

                        markup += '                        <p><b>'+parseFloat(listItem[itm].current_price).toFixed(2)+'元</b>&nbsp;&nbsp;<del>'+parseFloat(listItem[itm].origin_price).toFixed(2)+'元</del><span style="float:right;">已售'+listItem[itm].order_count+'</span></p>';

                        markup += '                    </div>';

                        markup += '                </a>';

                        markup += '            </div>';

                    }

                }

                markup += '        </div>';

                markup += '    </div>';

                //markup += '</div>';

               // markup += '<div class="container-fluid line"></div>';

            }

        } else {

             MsgBox("网络繁忙，请稍后重试");

        }

        return markup;

    }

</script><?php endif; ?>

<p>&nbsp;</p>

<p>&nbsp;</p>

<script type="text/javascript">

    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {

        WeixinJSBridge.call('hideToolbar');

        WeixinJSBridge.call('hideOptionMenu');

    });

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