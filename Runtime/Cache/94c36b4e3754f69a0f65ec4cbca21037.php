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

<section class="w320 pb20">
    <div class="server mt10">
         <div id="adlist" class="line20">

        </div>
    </div>
</section>

<!--加载-->
<div class="container-fluid" id="load">
    <div class="row">
        <div class="col-xs-12" style="margin-top:10px;"><center><img src="__PUBLIC__/images/minilodging.gif" width="24" height="24">正在加载...</center></div>
    </div>
</div>

<script type="text/javascript" src="http://s.17cct.com/v3/js/jquery.lazyload.js?v=20141216"></script>
<script type="text/javascript">
      var stop=true; 
        var currentpage=0;
        ajaxRed()
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
              var cid="<?php echo ($cid); ?>";
              $.get("<?php echo U('Article/ajax_get_a');?>",{"p":currentpage,"cid":cid}
              ,function(html){ 
                      if($.trim(html)!=""){ 
                          if(currentpage==0)
                          {
                            $("#adlist").html(html);
                          } 
                          else
                          {
                            $("#adlist").append(html);
                          }
                           stop=true;
                      }else{
                         if(currentpage==0)
                          {
                            MsgBox('查无结果');
                          } 
                          else
                          {
                            MsgBox('已查出全部结果');
                          }
                      }                     
                      currentpage++;
                     $("#load").hide();  
                 });              
        }

</script>
<!--
<script type="text/javascript" src="__PUBLIC__/js/jquery.esn.autobrowse.js"></script>
 <script>
     $(function(){
  $("img.lazyload").lazyload({
      effect: "fadeIn",
      threshold: 200,
      load: function() {
        $(this).removeClass("lazyload")
      }
    });
})
var staticUrl = "http://s.17cct.com/v3";
    $(function() {

        var totalPage = '<?php echo ($count); ?>';

        var cid='<?php echo ($cid); ?>';

        totalPage = parseInt(totalPage);

        var max = totalPage > 100 ? 100 : totalPage;

        if (totalPage >= 1) {
            adautobrowse('adlist', '<?php echo U("Article/ajax_get_a");?>?cid='+cid, max);
        }
    });

    function adautobrowse(dom, url, total) {
        $('.container-fluid').show();
        $("#"+dom).autobrowse(
                {
                    url: function(offset) {
                       
                        return url + '&p=' + offset;

                    },

                    template: function(response) {

                        return callbacks(response);

                    },

                    itemsReturned: function(response) {
                        return response.length;
                    },

                    max: total,

                    offset: 1,

                    sensitivity: 100,

                    loader: '',

                    itemsReturned:function(response) {
                        return 1;
                    },

                    finished: function() {
                        $('#load').hide();
                    },
                }
        );

    }


    function callbacks(response) {

        var markup = '';

        var errorImgInfo = "this.src='http://image.17cct.com/adv/new_login_bg.jpg';this.onerror=''";

        if (response.info) {

            for (var i=0;i<response.info.length;i++) {  

                markup += '<div class="container-fluid"><div class="row" ><div class="col-xs-12" ><a href=<?php echo U("Article/view");?>?id='+response.info[i].id+' class="newsabox"><div class="n_a_l"><h2>'+response.info[i].title+'</h2><p>'+response.info[i].description+'</p> <P><span><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;'+response.info[i].view+'</span>   <span><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;'+response.info[i].inputtime+'</span></P> </div><div class="n_a_r"><img data-original="'+response.info[i].thumb+'" src="http://s.17cct.com/v3/images/space.gif" class="lazyload" onerror="'+errorImgInfo+'" width="100"  height="73"> </div></a></div></div></div><div class="container-fluid line"></div>';
            }

        } else {

            markup = '<p>小编努力为您查询了，但还是找不到数据哦！^_^!</p>';

        }
        return markup;
    }


</script>
-->
    
<p>&nbsp;</p>
<p>&nbsp;</p>
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

<script src="__PUBLIC__/js/idangerous.swiper.min.js"></script>
<!--资讯列表导航拖动-->
<script src="__PUBLIC__/js/simple-app.js"></script>