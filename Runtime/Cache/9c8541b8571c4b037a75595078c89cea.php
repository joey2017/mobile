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
 <!--弹出提示框-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<body>
<!--头部-->
<div class="container-fluid topbox">
    <div class="row top"><h1 style="display:none;">诚车堂汽车网</h1>
        <div class="pg-Current">
        	<a href="javascript:history.go(-1)" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
        	<img src="__PUBLIC__/images/meng.png" width="30" height="30">
        </div>
        <div class="pgt">
        	<a>活动详情</a>
        </div>
        <!--
        <div class="cybtn">
        	<a href=""><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>报名</a>
        </div>
        -->
    </div>
</div>

<!--活动内容-->
<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 txttitle">
        	<h2><?php echo ($a["name"]); ?></h2>
            <div>
            	<span><span class="glyphicon glyphicon-user" aria-hidden="true"></span><?php echo ($a["publisher"]); ?></span>
                <span><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>2541</span>   
                <span><span class="glyphicon glyphicon-time" aria-hidden="true"></span><?php echo (date("Y-m-d",$a["addtime"])); ?></span>  
            </div>
        </div>        
        <div class="col-xs-12 txtcontent">
        	<p><span class="glyphicon glyphicon-time tabspan" aria-hidden="true"></span>时间：<?php echo (date("Y-m-d",$a["star_time"])); ?> 至 <?php echo (date("Y-m-d",$a["end_time"])); ?></p>
            <p><span class="glyphicon glyphicon-indent-right tabspan" aria-hidden="true"></span>报名截止：<?php echo (date("Y-m-d",$a["end_enroll_time"])); ?></p>
            <p><span class="glyphicon glyphicon-map-marker tabspan" aria-hidden="true"></span>地点：<?php echo ($a["type"]); ?></p> 
            <p><span class="glyphicon glyphicon-usd tabspan" aria-hidden="true"></span>费用：<?php echo ($a["cost"]); ?>元/人</p>
            <p><span class="glyphicon glyphicon-globe tabspan" aria-hidden="true"></span>人数限制：<?php echo ($a["number_of_people"]); ?></p>
            <p><span class="glyphicon glyphicon-user tabspan" aria-hidden="true"></span>已报名：<?php echo ($a["enroll_num"]); ?>人</p>
        </div>
        <div class="col-xs-12 txtcontent">
            <?php echo ($a["detail"]); ?>
        </div>
        
        <div class="col-xs-12">
            <?php echo ($a["status"]); ?>
            <p></p>
        </div>
    </div>
</div>

<!--分割线-->
<div class="container-fluid line"></div>

<!--其他活动-->
<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 qtnews">
        	<h3>其他活动</h3>
            <ul>
                <?php if(is_array($oa)): $i = 0; $__LIST__ = $oa;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$o): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Club/activity_detail',array('id'=>$o['id']));?>"><?php echo ($o["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <center><a href="<?php echo U('Club/activity',array('id'=>$a['circle_id']));?>" >查看更多活动</a></center>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-5 col-xs-offset-1"><button type="button" onclick="button2()" style="width:100%;"  class="btn btn-default button1"><span></span>发给朋友</button></div>
        <div class="col-xs-5"><button type="button" onclick="button2()" style="width:100%;"  class="btn btn-default button2"><span></span>朋友圈</button></div>
    </div>

        <div class="row">
            <div class="col-xs-12 plbox">
                <!--评论内容开始-->
                <!-- UY BEGIN -->
                <script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=1976552"></script>
                <!-- UY END -->
                <div style="padding:10px;background:#fff;">

                 <div id="respond" class="no_webshot">
                    <form id="commentform">
                      <!-- UY BEGIN -->
                      <div id="uyan_frame"></div>
                      <!-- UY END -->
                    </form>
                  </div>
                  <div id="postcomments">
                  </div>
                </div>  
            </div>
        </div>
    </div>
    <style>
             #mcover {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                display: none;
                z-index: 20000;
             }
             #mcover img {
                position: fixed;
                right: 18px;
                top: 5px;
                width: 260px!important;
                height: 180px!important;
                z-index: 20001;
             }
             .text {
                margin: 15px 0;
                font-size: 14px;
                word-wrap: break-word;
                color: #727272;
             }
             #mess_share {
                margin: 15px 0;
                display: block;
             }
             #share_1 {
                float: left;
                width: 49%;
                display: block;
             }
             #share_2 {
                float: right;
                width: 49%;
                display: block;
             }
             .clr {
                display: block;
                clear: both;
                height: 0;
                overflow: hidden;
             }
            
             #mess_share img {
                width: 22px!important;
                height: 22px!important;
                vertical-align: top;
                border: 0;
             }
        </style>
<script type="text/javascript">
        function button2(){
            $("#mcover").css("display","block")  // 分享给好友圈按钮触动函数
        }
        function weChat(){
            $("#mcover").css("display","none");  // 点击弹出层，弹出层消失
        }
</script>
<div id="mcover" onclick="weChat()" style="display:none;">
      <img src="https://mmbiz.qlogo.cn/mmbiz/vV3bdMHsLIjY2s0npKT0FaJ6iaC1MaiciakM61zfqBsNjYH14ovUG145GEuwMPafiaPjh5drSaAg8DMTic3a2I3icbLg/0" />
</div>

<p>&nbsp;</p><p>&nbsp;</p>
<!--底部固定按钮-->
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
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    $(function(){
  
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
              title: '【诚车堂】<?php echo ($a["name"]); ?>',
              desc: '<?php echo (strip_tags($a["detail"])); ?>',
              link: 'http://m.17cct.com/index.php/Club/activity_detail/id/<?php echo ($a["id"]); ?>.html',
              imgUrl: '<?php echo (get_circle_img($a["circle_id"],$a["cover_img"])); ?>',
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
              title: '【诚车堂】<?php echo ($a["name"]); ?>',
              link: 'http://m.17cct.com/index.php/Club/activity_detail/id/<?php echo ($a["id"]); ?>.html',
              imgUrl: '<?php echo (get_circle_img($a["circle_id"],$a["cover_img"])); ?>',
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