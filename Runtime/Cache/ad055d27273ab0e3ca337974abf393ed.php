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

<body id="Jlazy_img">
   <div class="container-fluid topbox">
        <div class="row top">
            <div class="pg-Current">
                <a href="javascript:history.back();" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
            </div>
            <div class="pg-Current">
                <img src="__PUBLIC__/images/shang.png" width="30" height="30">
            </div>
            <div class="pgt">
                <a>最新入驻商家</a>
            </div>
           
        </div>
    </div>

<!--优质门店-->
<div class="container-fluid">
	<div class="row" >
    	<div class="col-xs-12" >
        	<div class="tab_t">
    			<h2></h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12" >
     
        	<div class="row" id="store_list">
                
            </div> 
                     
        </div>
    </div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
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
              $.get("<?php echo U('Store/ajax_get_store');?>",{"p":currentpage}
              ,function(html){ 
                      if($.trim(html)!=""){ 
                          if(currentpage==0)
                          {
                            $("#store_list").html(html);
                          } 
                          else
                          {
                            $("#store_list").append(html);
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