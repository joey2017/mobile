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
<link rel="stylesheet" href="__PUBLIC__/css/idangerous.swiper.css">
</head>

<body>
<!--头部-->
<div class="container-fluid topbox">
    <div class="row top"><h1 style="display:none;">诚车堂汽车网</h1>
        <div class="pg-Current">
            <a href="javascript:history.go(-1);" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
            <img src="__PUBLIC__/images/cheng.png" width="30" height="30">
        </div>
        <div class="pgt">
            <a>资讯</a>
        </div><!--
        <div class="pgbtn">
            <a href=""><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
        </div>
        -->
        
    </div>
</div>

<!--资讯导航-->
<div class="swiper-nav">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><a href='<?php echo U("Article/index",array("cid"=>0));?>' <?php if( $cid == 0 ): ?>class="newsa"<?php endif; ?>>推荐</a></div>
            <div class="swiper-slide"><a href='<?php echo U("Article/index",array("cid"=>15));?>' <?php if( $cid == 15 ): ?>class="newsa"<?php endif; ?>>常识</a></div>
            <div class="swiper-slide"><a href='<?php echo U("Article/index",array("cid"=>6));?>' <?php if( $cid == 6 ): ?>class="newsa"<?php endif; ?>>美容</a></div>
            <div class="swiper-slide"><a href='<?php echo U("Article/index",array("cid"=>8));?>' <?php if( $cid == 8 ): ?>class="newsa"<?php endif; ?>>保养</a></div>
            <div class="swiper-slide"><a href='<?php echo U("Article/index",array("cid"=>38));?>' <?php if( $cid == 38 ): ?>class="newsa"<?php endif; ?>>行业</a></div>
            <div class="swiper-slide"><a href='<?php echo U("Article/index",array("cid"=>7));?>' <?php if( $cid == 7 ): ?>class="newsa"<?php endif; ?>>装潢</a></div>
            <div class="swiper-slide"><a href='<?php echo U("Article/index",array("cid"=>9));?>' <?php if( $cid == 9 ): ?>class="newsa"<?php endif; ?>>喷漆</a></div>
        </div>
</div>
<!--弹出提示框-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<!--文章标题-->
<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 txttitle">
        	<h2><?php echo ($r["title"]); ?></h2>
            <div>
            	<span><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;<?php echo ($r["username"]); ?></span>
                <span><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;<em id="hits"></em></span>   
                <span><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;<?php echo (date("Y-m-d",$r["inputtime"])); ?></span>
                <a href="#dianping" style=" float:right; color:#cd0000;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>查看点评</a>
            </div>
        </div>
        <div class="col-xs-12 txtcontent">
        	<?php echo ($r["content"]); ?>
        </div>
        
        <div class="col-xs-12 dzbox">
        	<a id="btn" data-pid="<?php echo ($r["id"]); ?>">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span><br>
                <i id="like_num"><?php echo ($r["likecount"]); ?></i>
            </a>
        </div>
    </div>
</div>
<script src="http://weixin.17cct.com/news/api.php?op=count&id=<?php echo ($r["id"]); ?>&modelid=1"></script>
<!--分割线-->
<div class="container-fluid line"></div>

<!--文章其他-->
<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 qtnews">
    		<?php if($key_array != null): ?><h3>相关资讯</h3> 
	            <ul>
	            	<?php if(is_array($key_array)): $i = 0; $__LIST__ = $key_array;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href='<?php echo U("Article/view",array("id"=>$vo["id"]));?>'><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
	            </ul><?php endif; ?>
            <center><a href='<?php echo U("Article/index");?>' >查看更多推荐资讯</a></center>
        </div>
    </div>
       <div class="row">
    	<div class="col-xs-5 col-xs-offset-1"><button type="button" onclick="button2()" style="width:100%;"  class="btn btn-default button1"><span></span>发给朋友</button></div>
        <div class="col-xs-5"><button type="button" onclick="button2()" style="width:100%;"  class="btn btn-default button2"><span></span>朋友圈</button></div>
    </div>
	
	 <div class="row" id="dianping">
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
            <!--评论内容结束--> 
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
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">

	function button2(){
		$("#mcover").css("display","block")  // 分享给好友圈按钮触动函数
	}
	function weChat(){
		$("#mcover").css("display","none");  // 点击弹出层，弹出层消失
		}
    (function($) {
    $.extend({
        tipsBox: function(options) {
            options = $.extend({
                obj: null,  //jq对象，要在那个html标签上显示
                str: "+1",  //字符串，要显示的内容;也可以传一段html，如: "<b style='font-family:Microsoft YaHei;'>+1</b>"
                startSize: "10px",  //动画开始的文字大小
                endSize: "30px",    //动画结束的文字大小
                interval: 600,  //动画时间间隔
                color: "red",    //文字颜色
                callback: function() {}    //回调函数
            }, options);
            $("body").append("<span class='num'>"+ options.str +"</span>");
            var box = $(".num");
            var left = options.obj.offset().left + options.obj.width() / 2;
            var top = options.obj.offset().top;
            box.css({
                "position": "absolute",
                "left": left + "px",
                "top": top + "px",
                "z-index": 999,
                "font-size": options.startSize,
                "line-height": options.endSize,
                "color": options.color
            });
            box.animate({
                "font-size": options.endSize,
                "opacity": "0",
                "top": top - parseInt(options.endSize) + "px"
            }, options.interval , function() {
                box.remove();
                options.callback();
            });
        }
    });

		/* 点赞 */
		$("#btn").on("click", function(pid) {
			_this=$(this);
			pid = pid || window.event;
			var c = $(pid.target || pid.srcElement);
			pid = c.attr("data-pid");
			if (!pid || !/^\d{2,8}$/.test(pid));
           var like=$.cookie("like_click");               
            if(like){
              var like_list = like.split(',');                 
              var has=$.inArray('<?php echo ($r["id"]); ?>',like_list);
              if(has!=-1){
                  MsgBox("您已经赞过了!","提示");
                  return false;
               }
            }
			$.ajax({
				url: '<?php echo U("Article/click_like");?>?id='+<?php echo ($r["id"]); ?>,
				type: "GET",
				dataType: "json",									
				success: function(pid) {                    
                if(pid){
                    $("#like_num").html(pid);
                    $.tipsBox({
						obj: _this,
						str: "+1",
		                callback: function() {
		                }
					})
                    if(like==null){
                      $.cookie("like_click",<?php echo ($r["id"]); ?>); 
                    }else{
                      $.cookie("like_click",like+","+<?php echo ($r["id"]); ?>); 
                    }
                }else{
                  MsgBox("再点击一下试试!","提示");
                }										
				}
			});             
		});
})(jQuery);

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
          title: '<?php echo ($r["title"]); ?>',
          desc: '<?php echo ($r["description"]); ?>',
          link: 'http://m.17cct.com/index.php/Article/view/id/<?php echo ($r["id"]); ?>.html',
          imgUrl: '<?php echo ($r["thumb"]); ?>',
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
          title: '<?php echo ($r["title"]); ?>',
          link: 'http://m.17cct.com/index.php/Article/view/id/<?php echo ($r["id"]); ?>.html',
          imgUrl: '<?php echo ($r["thumb"]); ?>',
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

  //测试接口代码
    // wx.checkJsApi({
    //     jsApiList: [
    //         'getLocation',
    //         'onMenuShareTimeline',
    //         'onMenuShareAppMessage'
    //     ],
    //     success: function (res) {
    //         alert(JSON.stringify(res));
    //     }
    // });

});
   
</script>
<div id="mcover" onclick="weChat()" style="display:none;">
          <img src="https://mmbiz.qlogo.cn/mmbiz/vV3bdMHsLIjY2s0npKT0FaJ6iaC1MaiciakM61zfqBsNjYH14ovUG145GEuwMPafiaPjh5drSaAg8DMTic3a2I3icbLg/0" />
</div>

<!--以下个空格不要删-->
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<!--底部固定按钮-->
<script src="__PUBLIC__/js/idangerous.swiper.min.js"></script>
<!--资讯列表导航拖动-->
<script src="__PUBLIC__/js/simple-app.js"></script>
<script type="text/javascript">
    /*手机站底部广告*/
    var cpro_id = "u2250528";
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
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