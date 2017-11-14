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

<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<link href="__PUBLIC__/font-awesome/css/font-awesome.min.css" rel="stylesheet">

<style type="text/css">
body{background: #efeff4;}
.work_order_top{padding:5px 15px; color: #fff; font-size: 25px; position:relative;}
.work_order_top a{color: #fff;}
.work_order_top .title{font-size: 16px;font-weight: bold;position: relative;top: 2px;}
.order_list{margin-top: 15px;}
.order_title{height: 40px; line-height: 40px; padding: 0 10px; background: #e95454; color:#fff;}
.order_title a{color: #fff;}
.order_title span{margin-left:10px;}
.order_info{padding:10px; background: #fff; border-bottom: 1px solid #eee;}
.order_info h3{margin:0 10px 0 0; font-size: 14px; line-height: 1.5em;}
.order_info span{color: #f7b608;}
.order_info span b{font-size: 16px;}
.box-flex{ display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox;  display: flex; }
.flex1{-webkit-box-flex: 1;-moz-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;}
.order_time{padding: 10px;color: #A2A2A2; background: #fff; text-align: right;}

.no_record{height: 24px;  padding-top: 205px;  text-align: center;  background: url(http://s.17cct.com/v5/images/erp/empty.png) no-repeat center 20px;  background-size: 180px 180px;}

.order,.o_btn{    display: inline-block;  width: 24px;  height: 19px;  vertical-align: middle;}
.order{  background: url(__PUBLIC__/images/bossico.svg) no-repeat -84px 0;  background-size: 105px;}
.o_btn{  background: url(__PUBLIC__/images/bossico.svg) no-repeat -23px 0; background-size: 94px;}


/*筛选框*/
.screenbox{ position: absolute; width: 100%; padding:10px;  top: 50px; left: 0; color: #4C4C4C; font-size: 14px; background:#fff; display: none; border-bottom: 1px solid #eee;z-index: 1;}
.screenbox dl{margin-bottom: 3px;}
.screenbox dt{margin-right: 10px; line-height: 30px;}
.screenbox dd{padding-left: 40px;}
.screenbox a{padding:4px 10px;display: inline-block; border:1px solid #eee;  color:#4C4C4C; margin-bottom: 5px;}
.screen_cur{background: #FF962A;border:1px solid #FF962A !important; color: #fff !important;}

</style>


<!-- 顶部筛选 刷新 -->
<div class="container-fluid topbox">
    <div class="row top work_order_top">
        <a href="javascript:;" class="screen_btn"><span class="order"></span></a>
        <div class="screenbox">
            <dl>
                <dt class="pull-left">状态</dt>
                <dd>
                    <a href="<?php echo U('User/work_order');?>" <?php if($status == 0): ?>class="screen_cur"<?php endif; ?>>全部</a>
                    <a href="<?php echo U('User/work_order',array('status'=>1));?>" <?php if($status == 1): ?>class="screen_cur"<?php endif; ?>>施工中</a>
                    <a href="<?php echo U('User/work_order',array('status'=>2));?>" <?php if($status == 2): ?>class="screen_cur"<?php endif; ?>>验收中</a>
                    <a href="<?php echo U('User/work_order',array('status'=>3));?>" <?php if($status == 3): ?>class="screen_cur"<?php endif; ?>>待结算</a>
                    <a href="<?php echo U('User/work_order',array('status'=>4));?>" <?php if($status == 4): ?>class="screen_cur"<?php endif; ?>>已结算</a>
                    <a href="<?php echo U('User/work_order',array('status'=>5));?>" <?php if($status == 5): ?>class="screen_cur"<?php endif; ?>>已作废</a>
                </dd>
            </dl>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".screen_btn").click(function(){
                    $(".screenbox").slideToggle(200);
                });
            })
        </script>
        <span class="title"><?php echo ($title); ?></span>
        <a onclick="window.document.location.reload();" class="pull-right"><span class="o_btn"></span></a>
    </div>
</div>

<script type="text/javascript">
      var currentpage=1;
    ajaxRed();
    $(window).scroll(function(){ 
            totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 
            if($(document).height() <= totalheight){ 
                if(stop==true){ 
                    ajaxRed();
                } 
            } 
        });
    function ajaxRed(){ 
                $("#load").show();
                  stop=false;
                  $.get("<?php echo U('User/ajax_get_work_order');?>",{"p":currentpage,"status":<?php echo ($status); ?>}
                  ,function(html){
                          if(html!=""){ 
                            if(currentpage==1) {                                
                                $("#order_list").html(html);
                            }
                            else {
                               $("#order_list").append(html);                                               
                            } 
                          }else{
                            if(currentpage==1) {                                
                                $("#order_list").html('<div class="no_record col-sm-12">暂无数据</div>');
                            }else{
                                MsgBox('已加载全部数据');  
                            }
                          }
                          stop=true;
                          currentpage++;
                         $("#load").hide();  
                     });
      }
</script>

<!-- 列表 -->
<div class="container-fluid" id="order_list">


</div>

<!--加载-->
<div class="container-fluid" id="load">
    <div class="row">
        <div class="col-xs-12" style="margin-top:10px;">
            <center>
            <img src="__PUBLIC__/images/minilodging.gif" width="24" height="24" style="vertical-align:middle;"> 
            正在加载... 
            </center>
        </div>
    </div>
</div>
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