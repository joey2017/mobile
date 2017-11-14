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

<style type="text/css">
body{background-color: #f2f2f2;}
.pgt{padding: 0;}
.tab_parent{padding-left: 10px;}
.tab_subset{margin:0; padding: 0 10px 0 0;}
ul{margin:0;list-style: none; padding: 0;}
a{color: #333;}
a:focus,a:active, a:hover{color: #333; text-decoration: none;}
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}


.imglist a{width: 100%; display: block;margin-top: 10px; background: #fff; padding: 5%; }
.imgtab{overflow: hidden;}
.imgtab img{width: 100%;}
.stafftxt{line-height: 22px; margin: 3px; height: 22px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;  font-size: 14px;  word-break: break-all;}


.no_record{height: 24px;  padding-top: 205px;  text-align: center;  background: url(http://s.17cct.com/v5/images/erp/empty.png) no-repeat center 20px;  background-size: 180px 180px;}
</style>

</head>

<body>
<!--头部-->

<!-- <div class="container-fluid topbox">
    <div class="row top"><h1 style="display:none;">诚车堂汽车网</h1>
        <a href="<?php echo U('Store/view',array('id'=>$id));?>" ><div class="pg-Current">
        	<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pgt">
        	<a>返回</a>
        </div>
    </div>
</div> -->

<div class="container-fluid imglist">

    <div class="row tab_parent" id="list">
       
    </div>

</div>
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
              var sid="<?php echo ($id); ?>";
              $.get("<?php echo U('Store/ajax_get_style');?>",{"p":currentpage,"id":sid}
              ,function(html){ 
                      if($.trim(html)!=""){ 
                          if(currentpage==0)
                          {
                            $("#list").html(html);
                          } 
                          else
                          {
                            $("#list").append(html);
                          }
                           stop=true;
                      }else{
                         if(currentpage==0)
                          {
                            MsgBox('查无结果');
                            $('#list').html('<div class="no_record col-sm-12">暂无信息</div>');
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
<!-- <center>
<ul class="pagination">
    <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
</ul>
</center> -->


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