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

.tab_parent{padding-left: 15px;}
.tab_subset{margin:0; padding: 0 15px 0 0;}
ul{margin:0;list-style: none; padding: 0;}
a{color: #333;}
a:focus,a:active, a:hover{color: #333; text-decoration: none;}
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}






.top-header{ background-color: #f60; width: 100%; overflow: hidden; position: relative; display: table;}
.top-header h3{ font-size: 1.6em; padding: 1em; margin: 0 30%;   white-space: nowrap; text-align: center; overflow: hidden; text-overflow: ellipsis; display: block; color: #fff; font-weight: normal; display: table-cell;}
.top-header a:first-child{width: 14%; display: table-cell;  padding:0 4%;vertical-align: middle;}
.top-header a:last-child{ width: 14%; display:table-cell;padding:0 4%; vertical-align: middle;}
.top-header img{ width: 100%;  display: block;} 
body{ background-color: #f2f2f2;}
/*瀑布流开始*/
.wall {display: block; position: relative;}
.wall-column { display: block; position: relative; width: 50%; float: left; padding: 0 2%; box-sizing: border-box;}
.article { display: block; margin: 8% 0 0 0; padding: 5%; background: white; border-radius: 3px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05);  transition: all 100; overflow: hidden; position: relative;}
.article:hover{ transform: scale(1.01);}
.article img { display: block; width: 100%; margin: 0 0 5% 0;}
.article a{ color: #666;}
.article p{ overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 1.2em; line-height: 1.5; margin: 0;}
/*瀑布流结束*/


.no_record{height: 24px;  padding-top: 205px;  text-align: center;  background: url(http://s.17cct.com/v5/images/erp/empty.png) no-repeat center 20px;  background-size: 180px 180px;}

.rot_label{overflow: hidden; margin-top: 10px; padding: 0 10px}
.container{padding: 0 10px}
.rot_label ul{margin: 0; padding: 0}
.rot_label li{float: left; margin: 0 5px 5px 0;}
.rot_label li a{display: block; padding: 5px 10px; border: 1px solid #ddd; border-radius: 5px;}

.rotcurrent{background:#f57a30; color: #fff !important;border: 1px solid #f57a30 !important;}
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



<div class="container">
    <div class="row" >
        <div class="col-xs-12" >
            <div class="tab_t">
                <h2>案例分类</h2>
            </div>
        </div>
    </div>
</div>
<div class="rot_label">
    <ul>
            <li><a href="<?php echo U('Store/project',array('id'=>$id));?>" <?php if($cid == 0): ?>class="rotcurrent"<?php endif; ?> >全部案例</a></li>  
            <?php if(is_array($cate_list)): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cl): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Store/project',array('id'=>$id,'cid'=>$cl['id']));?>" <?php if($cid == $cl['id']): ?>class="rotcurrent"<?php endif; ?>><?php echo ($cl["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
           <!--  <li><a href="<?php echo U('Store/project_detail',array('id'=>$id,'cid'=>12));?>" <?php if($cid == 12): ?>class="rotcurrent"<?php endif; ?>>汽车改装</a></li>
            <li><a href="<?php echo U('Store/project_detail',array('id'=>$id,'cid'=>13));?>" <?php if($cid == 13): ?>class="rotcurrent"<?php endif; ?>>服务施工</a></li>
            <li><a href="<?php echo U('Store/project_detail',array('id'=>$id,'cid'=>14));?>" <?php if($cid == 14): ?>class="rotcurrent"<?php endif; ?>>钣金油漆</a></li>
            <li><a href="<?php echo U('Store/project_detail',array('id'=>$id,'cid'=>15));?>" <?php if($cid == 15): ?>class="rotcurrent"<?php endif; ?>>汽车保养</a></li>
            <li><a href="<?php echo U('Store/project_detail',array('id'=>$id,'cid'=>16));?>" <?php if($cid == 16): ?>class="rotcurrent"<?php endif; ?>>汽车装潢</a></li>
            <li><a href="<?php echo U('Store/project_detail',array('id'=>$id,'cid'=>17));?>" <?php if($cid == 17): ?>class="rotcurrent"<?php endif; ?>>汽车美容</a></li> -->
            
    </ul>
</div>
<div class="wrapper">
    <?php if($list != null): ?><ul class="wall">
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><li class="article">
                        <a href="<?php echo U('Store/project_detail',array('id'=>$l['sid']));?>">
                            <img src="<?php echo ($l["thumb"]); ?>" />
                            <p><?php echo ($l["title"]); ?></p>
                        </a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>          
            </ul>
        <?php else: ?>
        <div class="no_record col-sm-12">暂无案例</div><?php endif; ?>
</div>


<div style="height:60px; clear:both;"></div>
<script src="__PUBLIC__/js/jaliswall.js"></script>
<script>
   $(function(){
        $('.wall').jaliswall({ item: '.article' });
    });
</script>
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