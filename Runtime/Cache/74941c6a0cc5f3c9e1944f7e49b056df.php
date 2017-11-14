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
.pgt{padding: 0;}
.tab_parent{padding-left: 15px;}
.tab_subset{margin:0; padding: 0 15px 0 0;}
ul{margin:0;list-style: none; padding: 0;}
a{color: #333;}
a:focus,a:active, a:hover{color: #333; text-decoration: none;}
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}

/*搜索条*/
.topsearch{height: 34px; margin:10px 0;}
.searchtab{position: relative; width: 100%; height: 36px; border-radius: 5px; margin-right:10px; }
.searchtab span{position: absolute; width: 30px; height: 30px; display: block; top: 2px; left: 2px; background:url(__PUBLIC__/images/searchico.svg) no-repeat; background-size: 30px;}
.searchtab input{border:0; background:#efefef; text-indent: 2em;}
.searchbtn{width: 80px; height: 36px;}
.searchbtn button{width: 80px; height: 33px; border:0; background: #f6a915; color: #fff; border-radius: 5px;}

/*服务列表*/
.scleft{overflow: hidden;background: #fff;float: left;height: 100%; position: fixed;width:100px;}

#businessbox{ padding-top:55px;   z-index: 1;}
#businessbox li{margin:-1px 0 0 -1px; height:38px; line-height:38px; text-align:center; cursor: pointer;border-bottom: 1px solid #d5d5d5;}
#businessbox input{background:#09F;}
#businessbox .b_active{background:#f0f0f0;}
.businesstab{display:none; overflow: hidden;margin-left: 110px;}

/*产品列表*/
.productlist{ border-bottom: 1px solid #e8e8e8; overflow: hidden; padding: 0 10px 12px 0; margin-bottom: 12px;}
.leftimg{width: 106px; height: 80px; margin-right: 10px;}
.leftimg img{width: 100%; height: 100%;}
.rightinfo h3{ line-height: 18px; margin: 3px; max-height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;  font-size: 14px;  word-break: break-all; }
.price{ color: #eb5211;font-size: 16px;}

.d-main .pull-right{font-size: 12px; color: #717171;}
.d-main .btn-block{color: #b7b5b5; font-size: 12px;}

.no_record{height: 24px;  padding-top: 205px;  text-align: center;  background: url(http://s.17cct.com/v5/images/erp/empty.png) no-repeat center 20px;  background-size: 180px 180px;}
</style>

</head>

<body>
<!--头部-->
<div style="width: 100%; position: fixed; background:#fff;">
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
    <form action="<?php echo U('Store/goods',array('id'=>$id));?>" method="get">
        <div class="topsearch col-xs-12 box_flex">
            <div class="flex1 searchtab">
                <span></span>
                <input type="text" class="form-control" name="keyword" value="<?php echo ($keyword); ?>" placeholder="请输入关键词">
            </div>
            <div class="searchbtn">
                <button type="submit">搜索</button>
            </div>
        </div>
    </form>
</div>


<div id="businessbox">
<?php if($list != null): ?><div class="scleft">
        <ul>
            <li class="b_active">全部服务</li>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><li><?php echo ($key); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
          <!--   <li>汽车保养</li>
            <li>钣金喷漆</li> -->
        </ul>
    </div>
    <div class="businesstab" style="display:block;">
             <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i; if(is_array($l['item'])): $i = 0; $__LIST__ = $l['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><div class="productlist">
                   
                            <a href="<?php echo U('Service/view',array('id'=>$li['id']));?>" class="box_flex">
                                <div class="leftimg">
                                    <img src="http://www.17cct.com/<?php echo ($li["img"]); ?>" onerror='imgError(this,"http://s.17cct.com/v3/images/errorimg.jpg");'>
                                </div>
                                <div class="rightinfo flex1">
                                    <h3><?php echo ($li["name"]); ?></h3>
                                    <div class="d-main">
                                        <span class="price">￥:<?php echo (price($li["current_price"])); ?></span> 
                                        <span class="btn-block">￥:<del><?php echo (price($li["origin_price"])); ?></del></span>
                                    </div>
                                </div>
                            </a>
                         
                </div><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?> 
    </div>
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($i % 2 );++$i;?><div class="businesstab">
                <?php if(is_array($l['item'])): $i = 0; $__LIST__ = $l['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><div class="productlist">
                        <a href="<?php echo U('Service/view',array('id'=>$li['id']));?>" class="box_flex">
                            <div class="leftimg">
                                <img src="http://www.17cct.com/<?php echo ($li["img"]); ?>" onerror='imgError(this,"http://s.17cct.com/v3/images/errorimg.jpg");'>
                            </div>
                            <div class="rightinfo flex1">
                                <h3><?php echo ($li["name"]); ?></h3>
                                <div class="d-main">
                                    <span class="price">￥:<?php echo (price($li["current_price"])); ?></span> 
                                    <span class="btn-block">￥:<del><?php echo (price($li["origin_price"])); ?></del></span>
                                </div>
                            </div>
                        </a>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
<?php else: ?>
 <div class="no_record col-sm-12">暂无项目</div><?php endif; ?>
</div>




<script type="text/javascript">
    window.onload=function(){
    var oBox =document.getElementById('businessbox');
    var oLi =oBox.getElementsByTagName('ul')[0].getElementsByTagName('li');
    // var oDiv =oBox.getElementsByTagName('div');
    var oDiv =oBox.getElementsByClassName('businesstab');
    for(var i=0;i < oLi.length;i++){
        oLi[i].index=i;
        oLi[i].onclick=function(){
            for(var i=0;i < oLi.length;i++){
                oLi[i].className=''
                oDiv[i].style.display=''
                }
            this.className='b_active'
            
            oDiv[this.index].style.display='block'
            }
        }
    }
</script>




<p>&nbsp;</p>
<p>&nbsp;</p>
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