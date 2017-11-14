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
<meta name="format-detection" content="telephone=no" />
</head>

<body>

<link href="__PUBLIC__/font-awesome/css/font-awesome.min.css" rel="stylesheet">

<style type="text/css">
.order_top{ height: 220px; background: #E93131 url(__PUBLIC__/images/order.svg) repeat-x 0 204px;background-size: 17px; position: relative; margin-bottom: 10px;}
.order_t_left,.order_t_right{position: absolute;}
.order_t_left{color: #fff;top: 26px; line-height: 1.8em; font-size: 14px;}
.order_t_right{right: 14px; color: #fffc02; top: 86px; padding: 8px 13px; background: #d73a3a;}
.box-flex{ display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox;  display: flex; }
.flex1{-webkit-box-flex: 1;-moz-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;}
.order_name{width: 100px; text-align: right;}
.staff{border-bottom: 1px solid #ddd8ce;border-right: 1px solid #ddd8ce; padding: 9px 0;}

/*项目*/
.th_title{text-align: center; border: 0 !important;}
.order_b{color: #f7b608; font-size: 16px;}
tbody td{line-height: 1.8em !important; padding: 10px 4px !important;}
.numberspan{width: 20px;  height: 20px; display: inline-block; background-color: #E40E0E;   color: #fff; border-radius: 11px; margin-right: 5px;}


/*车辆信息图片*/
.my-gallery{ padding:20px 7px;}
.vehicleimg{margin-right: 7px;}
.vehicleimg a{display: block;}
.vehicleimg img{width: 100%; height: 100%;}

/*评价*/
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}

.scoreli{margin:0; padding: 0;}
.scoreli li{float:left;list-style:none;margin:0 5px 0 0; color: #ffb714; font-size: 32px;}
.scoretitle{ line-height: 45px; margin: 0 0 0 15px;}




.reason{display: none;}

.payul{padding: 5px 0 0 0;}
.payul li{ list-style: none;  position: relative; padding: 10px; margin: 0 5px 5px 0; text-align: left; overflow: hidden; border: 1px solid #d2d2d2; cursor: pointer;  font-size: 12px; float: left;}
.payul li em{display: none;}

.disabled {color: #ccc;}
.disabled span{ background-color: #ccc;}

.selected_pay{padding: 9px !important; border: 2px solid #ff5200 !important;}
.selected_pay em{display: block !important; position: absolute; bottom: -11px;  right: -16px; width: 35px; text-align: center; height: 28px; background: #ff5200; color: #fff; position: absolute; transform: rotate(-45deg); -o-transform: rotate(-45deg); -webkit-transform: rotate(-45deg); -moz-transform: rotate(-45deg);} 
.selected_pay em  i{transform: rotate(45deg); -o-transform: rotate(45deg); -webkit-transform: rotate(45deg); -moz-transform: rotate(45deg); } 
</style>
<!--图片浏览插件-->
<link rel="stylesheet" href="__PUBLIC__/photoswipe/photoswipe.css"> 
<link rel="stylesheet" href="__PUBLIC__/photoswipe/default-skin/default-skin.css">
<script src="__PUBLIC__/photoswipe/photoswipe.min.js"></script> 
<script src="__PUBLIC__/photoswipe/photoswipe-ui-default.min.js"></script> 
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<!-- 顶部信息 -->
<div class="order_top">
    <div class="order_t_left">
        <div class="box-flex">
            <div class="order_name"><b>订单编号：</b></div>
            <div class="flex1"><?php echo ($order_info["order_sn"]); ?></div>
        </div>
        <div class="box-flex">
            <div class="order_name"><b>车牌号码：</b></div>
            <div class="flex1"><?php echo ($order_info["car_sn"]); ?></div>
        </div>
        <div class="box-flex">
            <div class="order_name"><b>客户姓名：</b></div>
            <div class="flex1"><?php echo ($order_info["user_name"]); ?></div>
        </div>
        <div class="box-flex">
            <div class="order_name"><b>电话号码：</b></div>
            <div class="flex1"><?php echo ($order_info["mobile"]); ?></div>
        </div>
        <div class="box-flex">
            <div class="order_name"><b>下单时间：</b></div>
            <div class="flex1"><?php echo (date('Y-m-d H:i:s',$order_info["create_time"])); ?></div>
        </div>
        <div class="box-flex">
            <div class="order_name"><b>消费门店：</b></div>
            <div class="flex1"><?php echo ($order_info["location_name"]); ?></div>
        </div>
    </div>
    <div class="order_t_right"><?php echo ($order_info["status"]); ?></div>
</div>



<!-- 项目概况 -->
<?php if(is_array($order_info['item'])): $key = 0; $__LIST__ = $order_info['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($key % 2 );++$key;?><table style="border: 0;margin-bottom:0;" class="table bootstrap-datatable">     
        <thead >
            <tr>
                <th class="th_title"><span class="numberspan"><?php echo ($key); ?></span>项目名称</th>
                <th class="th_title">数量</th>
                <th class="th_title">金额</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="40%" align="center"><?php echo ($item["project_name"]); ?></td>
                <td width="20%" align="center"><?php echo (round($item["num"],2)); ?></td> 
                <td width="40%" align="center"><b class="order_b"><?php echo (price($item["sell_price"])); ?></b></td> 
            </tr>
        </tbody>
    </table>
    <table style="border: 0; margin-bottom:0;" class="table table-bordered bootstrap-datatable">
        <tbody>
            <?php if($order_info['type'] == '2'): ?><tr>
                    <td width="50%" align="center">销售人：<?php echo ($item["sales_staff_name"]); ?></td>
                    <td width="50%" align="center">施工人：<?php echo ($item["construction_staff_name"]); ?></td> 
                </tr>
                <tr>
                    <td width="50%" align="center">验收人：<?php echo ($item["check_staff_name"]); ?></td>
                    <td width="50%" align="center">结算人：<?php echo ($item["settlement_staff_name"]); ?></td> 
                </tr>
            <?php else: ?>
                 <tr>
                    <td width="50%" align="center">销售人：<?php echo ($item["sales_staff_name"]); ?></td>
                    <td width="50%" align="center">结算人：<?php echo ($item["settlement_staff_name"]); ?></td> 
                </tr><?php endif; ?>
        </tbody>
    </table><?php endforeach; endif; else: echo "" ;endif; ?>

<table style="border: 0; margin-bottom:0;" class="table">
    <tbody>
        <tr>
            <td  align="right"  style="border-top:0;">总计：<span class="order_b" style="font-size:24px; padding-right:15px;"><b>￥<?php echo (price($order_info["total_price"])); ?></b></span></td>
        </tr>
    </tbody>
</table>

<?php if($pay_ment != null and $order_info["can_see_pay"] == 1): ?><div class="container-fluid line"  style="border-top:0;"></div>
    <table class="table table-bordered" style="text-align:center;border-top:0;"> 
        <tr>
            <th class="th_title" width="50%">支付方式</th>
            <th class="th_title" width="50%">金额</th>
        </tr>
        <?php if(is_array($pay_ment)): $key = 0; $__LIST__ = $pay_ment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pm): $mod = ($key % 2 );++$key;?><tr>
                <td><?php echo ($key); ?></td>
                <td><?php echo (price($pm)); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table><?php endif; ?>

<?php if($order_info[upload_imgs][0] != '0' and $order_info[upload_imgs][0] != null): ?><!--分割线-->
<div class="container-fluid line"  style="border-top:0;"></div>

<div class="tab_t" style="padding:0 15px;"><h2>车辆图片</h2></div>


<div class="my-gallery box-flex">
          
                <figure class="vehicleimg flex1">           
                     <?php if($order_info['upload_imgs'][1] == '0' and $order_info[upload_imgs][1] == null): ?><a href='<?php echo ($order_info["upload_imgs"]["0"]); ?>!max'  style="width:25%" data-size="700x700" ><img src="<?php echo ($order_info["upload_imgs"]["0"]); ?>!thumbnail" alt="Image description" /></a>
                    <?php else: ?>
                        <a href='<?php echo ($order_info["upload_imgs"]["0"]); ?>!max'  data-size="700x700" ><img src="<?php echo ($order_info["upload_imgs"]["0"]); ?>!thumbnail" alt="Image description" /></a><?php endif; ?>
                </figure>
          
               <?php if($order_info['upload_imgs'][1] != '0' and $order_info[upload_imgs][1] != null): ?><figure class="vehicleimg flex1"> 
                        
                            <a href="<?php echo ($order_info["upload_imgs"]["1"]); ?>!max" data-size="700x700"><img src="<?php echo ($order_info["upload_imgs"]["1"]); ?>!thumbnail" alt="Image description" /></a> 
                        
                    </figure><?php endif; ?>
                <?php if($order_info['upload_imgs'][2] != '0' and $order_info[upload_imgs][2] != null): ?><figure class="vehicleimg flex1">
                        
                            <a href="<?php echo ($order_info["upload_imgs"]["2"]); ?>!max" data-size="700x700"><img src="<?php echo ($order_info["upload_imgs"]["2"]); ?>!thumbnail" alt="Image description" /></a>
                        
                    </figure><?php endif; ?>
          <?php if($order_info['upload_imgs'][3] != '0' and $order_info[upload_imgs][3] != null): ?><figure class="vehicleimg flex1" style="margin-right:0;">
                  
                    <a href="<?php echo ($order_info["upload_imgs"]["3"]); ?>!max" data-size="700x700"><img src="<?php echo ($order_info["upload_imgs"]["3"]); ?>!thumbnail" alt="Image description" /> </a>

                </figure><?php endif; ?>
            
        </div>
    
        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="pswp__bg"></div>
            <div class="pswp__scroll-wrap">
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>
                <div class="pswp__ui pswp__ui--hidden">
                
                    <div class="pswp__top-bar">
                        <div class="pswp__counter"></div>
                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div> 
                    </div>
                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>
                </div>
            </div>
        </div><?php endif; ?>
<script type="text/javascript">
var initPhotoSwipeFromDOM = function(gallerySelector) {

    // parse slide data (url, title, size ...) from DOM elements 
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
        var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

        for(var i = 0; i < numNodes; i++) {

            figureEl = thumbElements[i]; 

            // include only element nodes 
            if(figureEl.nodeType !== 1) {
                continue;
            }

            linkEl = figureEl.children[0]; 

            size = linkEl.getAttribute('data-size').split('x');

            // create slide object
            item = {
                src: linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };



            if(figureEl.children.length > 1) {
                // <figcaption> content
                item.title = figureEl.children[1].innerHTML; 
            }

            if(linkEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[0].getAttribute('src');
            } 

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
        }

        return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        var eTarget = e.target || e.srcElement;

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
        });

        if(!clickedListItem) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) { 
                continue; 
            }

            if(childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }



        if(index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
        params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');  
            if(pair.length < 2) {
                continue;
            }           
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);

        // define options (if needed)
        options = {

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),

            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect(); 

                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }

        };

        // PhotoSwipe opened from URL
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        // exit if index not found
        if( isNaN(options.index) ) {
            return;
        }

        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll( gallerySelector );

    for(var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i+1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if(hashData.pid && hashData.gid) {
        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
    }
};
// execute above function
initPhotoSwipeFromDOM('.my-gallery');
</script>





<div class="container-fluid line"></div>
<?php if($order_info['settlement_remark'] != ''): ?><div class="tab_t" style="padding:0 15px;"><h2>结算备注</h2></div>
    <div style="min-height: 50px;padding: 7px 6px 0px 15px;">
        <?php echo ($order_info["settlement_remark"]); ?>
    </div>
    <!--分割线-->
<div class="container-fluid line"></div><?php endif; ?>

<?php if($order_info['signature'] != null and $order_info['signature'] != ''): ?><div class="tab_t" style="padding:0 15px;"><h2>签名</h2></div>
    <div>
        <img width="100%" src="http://www.17cct.com/<?php echo ($order_info["signature"]); ?>">
    </div><?php endif; ?>

<div class="tab_t" style="padding:0 15px;"><h2>评价</h2></div>

<div id="warp" class="box_flex">
    <div class="scoretitle">服务态度：</div>
    <ul class="flex1 scoreli">
        <?php if($comment_info['service_star_list'] != ''): echo ($comment_info["service_star_list"]); ?>
        <?php else: ?> 
            <li>☆</li>
            <li>☆</li>
            <li>☆</li>
            <li>☆</li>
            <li>☆</li><?php endif; ?>
    </ul>
</div>
<div class="col-xs-12 <?php if($comment_info == null): ?>reason<?php endif; ?>" id="service_comment">
   <ul class="text-center flex payul">
       <li class="col-xs-inner <?php if($comment_info["comment_1"] != null): ?>selected_pay<?php endif; ?>" data="1">
            服务不热情
            <em><i class="fa fa-check"></i></em>
        </li>
        <li class="col-xs-inner <?php if($comment_info["comment_2"] != null): ?>selected_pay<?php endif; ?>" data='2'>
            态度不好
            <em><i class="fa fa-check"></i></em>
        </li>
        <li class="col-xs-inner <?php if($comment_info["comment_3"] != null): ?>selected_pay<?php endif; ?>" data='3'>
            没人接待
            <em><i class="fa fa-check"></i></em>
        </li>
    </ul>
</div>

<div id="technology" class="box_flex" style="clear:both;">
    <div class="scoretitle">技术质量：</div>
    <ul class="flex1 scoreli">
        <?php if($comment_info['technology_star_list'] != ''): echo ($comment_info["technology_star_list"]); ?>
        <?php else: ?> 
            <li>☆</li>
            <li>☆</li>
            <li>☆</li>
            <li>☆</li>
            <li>☆</li><?php endif; ?>
       
    </ul>
</div>
<div class="col-xs-12 <?php if($comment_info == null): ?>reason<?php endif; ?>" id="technology_comment">
   <ul class="text-center flex payul">
        <li class="col-xs-inner <?php if($comment_info["comment_6"] != null): ?>selected_pay<?php endif; ?>" data='6'>
            技术不过关
            <em><i class="fa fa-check"></i></em>
        </li>
        
        <li class="col-xs-inner <?php if($comment_info["comment_4"] != null): ?>selected_pay<?php endif; ?>" data='4'>
            时间太久
            <em><i class="fa fa-check"></i></em>
        </li>
        <li class="col-xs-inner <?php if($comment_info["comment_5"] != null): ?>selected_pay<?php endif; ?>" data='5'>
            质量不高
            <em><i class="fa fa-check"></i></em>
        </li>
        
    </ul>
</div>
<?php if($comment_info == ''): ?><input type="hidden" id="service_star" value="-1">
    <input type="hidden" id="tec_star" value="-1">

     

    <div class="col-xs-6 col-xs-offset-3">
        <button class="btn btn-lg btn-block btn-warning" id="submit">提交评论</button>
    </div>
 <div style="height:60px; clear:both;"></div>  
<script type="text/javascript" >
    $('#submit').click(function(){
        var service_star=$('#service_star').val(),tec_star=$('#tec_star').val(),s_comment=new Array(),s=new Array(),t=new Array();

        if(service_star==-1){
            MsgBox('请给服务态度打分');
            return false;
        }

        if(tec_star==-1){
            MsgBox('请给技术质量打分');
            return false;
        }

        $('#service_comment ul li').each(function(){
            if($(this).hasClass('selected_pay')){
                s_comment.push($(this).attr('data'));
                s.push($(this).attr('data'))
            }
        })

         $('#technology_comment ul li').each(function(){
            if($(this).hasClass('selected_pay')){
                s_comment.push($(this).attr('data'));
                t.push($(this).attr('data'))
            }
        })

         if(service_star<=2&&s==''){
             MsgBox('请选择服务不满意选项');
            return false;
         }

         if(tec_star<=2&&t==''){
             MsgBox('请选择技术不满意选项');
            return false;
         }

        $('#submit').attr('disable',true);
        $.ajax({
            url:"<?php echo U('User/ajax_work_order_comment');?>",
            type:"POST",
            data:{'service_star':service_star,'tec_star':tec_star,'s_comment':s_comment,'order_id':<?php echo ($order_info["id"]); ?>},
            dataType:"json",
            async: false,
            success:function(data){                
                 MsgBox(data.info);
                if(data.status){
                    setTimeout(function(){
                        window.location.reload();
                    },2000)
                }else{
                    $('#submit').attr('disable',false);
                }
            }
        });

    })

    var oWarp=document.getElementById("warp");
    var oLis=oWarp.getElementsByTagName("li");
    for(var i=0;i<oLis.length;i++){
        var oLi=oLis[i];
        oLi.style.cursor ='pointer';
        oLi.onmousedown=function(){    
        var index = indexof(oLis, this); 
            if(index<=2){
                $('#service_comment').show();
            }else{
                $('#service_comment').hide();
            }
            $('#service_star').val(index);
            for(var j=0;j<=index;j++){
                oLis[j].innerHTML="★";
            }
            for(var z=index+1;z<oLis.length;z++){
                oLis[z].innerHTML="☆";
            }
        }
    }
    function indexof(arr,element){
        for(var i=0;i<arr.length;i++){
            if(arr[i]==element)
            return i;
        }
    
    }

    var oWarp2=document.getElementById("technology");
    var oLis2=oWarp2.getElementsByTagName("li");
    for(var i=0;i<oLis2.length;i++){
        var oLi=oLis2[i];
        oLi.style.cursor ='pointer';
        oLi.onmousedown=function(){
    
        var index = indexof(oLis2, this); 
            $('#tec_star').val(index);
             if(index<=2){
                $('#technology_comment').show();
            }else{
                $('#technology_comment').hide();
            }
            for(var j=0;j<=index;j++){
                oLis2[j].innerHTML="★";
            }
            for(var z=index+1;z<oLis2.length;z++){
                oLis2[z].innerHTML="☆";
            }
        }
    }

$('.col-xs-inner').click(function(){
    $(this).toggleClass('selected_pay');
})    
</script><?php endif; ?>



<p>&nbsp;</p>
<p>&nbsp;</p>

<div class="gwbt" style="height:auto;position: fixed;">
    <a class="btn-danger" href="<?php echo U('User/work_order');?>"><i class="fa fa-reply"></i> 返回</a>
</div>

</body>
</html>