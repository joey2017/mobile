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
<div class="container-fluid topbox">
    <div class="row top">
        <div class="pg-Current">
        	<a href="<?php echo U('User/index');?>" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
        	<img src="__PUBLIC__/images/cheng.png" width="30" height="30">
        </div>
        <div class="pgt">
        	<a>账号信息</a>
        </div>             
    </div>
</div>

<!--分割线-->
<div class="container-fluid line"></div>

<!--号码-->
<div class="container-fluid">	
    <div class="row oder">
    	<div class="col-xs-12">
        	<a href="<?php echo U('User/modify_name');?>" class="oder_1">
                <i class="Number wd"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></i>
                <span><?php echo ($u["show_name"]); ?></span>                
                <div style="float:right;">
                	<em style="color:#F00;">修改昵称</em>
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                </div>  
            </a>  	
        </div>
    </div>
    <div class="row oder">
    	<div class="col-xs-12">
        	<a href="javascript:void(0);" class="oder_1">
                <i class="Balance wd"><span class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></span></i>
                <span>车堂币余额</span> 
                <em style="color:#F00; margin-left:10px;"><?php echo ($u["score"]); ?></em>               
                <!-- <div style="float:right;">                	
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                </div>  --> 
            </a>  	
        </div>
    </div>
   <!--  <div class="row oder" style="border-bottom:none;">
    	<div class="col-xs-12">
        	<a href="" class="oder_1">
                <i class="Address wd"></i>
                <span>收获地址</span>                
                <div style="float:right;">
                	<em style="color:#F00;">修改/添加</em>
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                </div>  
            </a>  	
        </div>
    </div> -->
</div>

<!--分割线-->
<div class="container-fluid line"></div>

<!--安全等级-->
<div class="container-fluid">	
    <div class="row oder">
    	<div class="col-xs-12">        	                
            <div style="float:left; line-height:45px;color:#636363;">账户安全等级&nbsp;&nbsp;&nbsp;<?php echo ($u["safe"]); ?></div>                
            <div style="float:right;font-size:12px; color:#999;margin-top:15px;">请设置一下项目保护账号</div>      	
        </div>
    </div> 
    <div class="row oder">
    	<div class="col-xs-12">
        	<a href="<?php echo U('User/change_mobile');?>" class="oder_1">
                <i class="Binding wd"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span></i>
                <span>已绑定手机号</span> 
                <em style="color:#999;"><?php echo (substr_replace($u["mobile"],'****',3,4)); ?></em>               
                <div style="float:right;">
                	<em style="color:#F00;">更换</em>
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                </div>  
            </a>  	
        </div>
    </div> 
    <div class="row oder">
    	<div class="col-xs-12">
        	<a href="<?php echo U('User/modify_password');?>" class="oder_1">
                <i class="Modification wd"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></i>
                <span>修改账户密码</span>
                <em style="color:#F00; margin-left:10px;">强度：<?php echo ($u["safe_pwd"]); ?></em>           
                <div style="float:right;">
                	<em style="color:#F00;">修改</em>
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                </div>  
            </a>  	
        </div>
    </div>  
</div>

<!--退出账户
<div class="container-fluid" >
    <div class="row">
        <div class="col-xs-12" style="margin-top:25px;"><center><a href="<?php echo U('User/loginOut');?>"><button type="button" class="btn btn-danger btn-lg" style="padding-left:40px;padding-right:40px;">退出账户</button></a></center></div>
    </div>
</div>
-->
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