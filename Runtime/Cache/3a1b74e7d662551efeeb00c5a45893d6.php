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
    <div class="row top"><h1 style="display:none;">诚车堂汽车网</h1>
        <div class="pg-Current">
        	<a href="javascript:history.go(-1)" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
        	<img src="__PUBLIC__/images/meng.png" width="30" height="30">
        </div>
        <div class="pgt">
        	<a>车友会</a>
        </div>
        <div class="cybtn">
        	<a href="<?php echo U('Club/all_club');?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>查找</a>
        </div>
        <div class="cybtn">
        	<a href="<?php echo U('Club/create');?>"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span>创建</a>
        </div>
    </div>
</div>

<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<!--焦点图-->
<div class="swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <a href=""><img src="http://image.17cct.com/images/m/m_adv1.png!ig" ></a>
      </div>
      <div class="swiper-slide">
        <a href=""><img src="http://image.17cct.com/images/m/m_adv2.png!ig" ></a>
      </div>
      <div class="swiper-slide">
       <a href=""><img src="http://image.17cct.com/images/m/m_adv3.png!ig" ></a>
      </div>
      
    </div>
     <div class="swiper-pagination"></div>
</div>

<!--导航-->
<div class="container-fluid">
	<div class="row cymenu">
		<div class="cynav">
			<a href="<?php echo U('Club/activity',array('id'=>13));?>" >
				<img src="__PUBLIC__/images/c_1.png">
				<p>车友活动</p>
			</a>
		</div>
		<div class="cynav">
			<a href="<?php echo U('Club/ranking');?>" >
				<img src="__PUBLIC__/images/c_2.png">
				<p>排行榜</p>
			</a>
			
		</div>
		<div class="cynav">
			<a href="<?php echo U('Index/exchange');?>" >
				<img src="__PUBLIC__/images/c_3.png">
				<p>礼品兑换</p>
			</a>			
		</div>
		<div class="cynav">
			<a href="<?php echo U('Club/all_club');?>">
				<img src="__PUBLIC__/images/c_4.png">
				<p>车友会</p>
			</a>			
		</div>
        <div class="cynav">
			<a href="http://wpa.qq.com/msgrd?v=3&uin=2111730164&site=qq&menu=yes" >
				<img src="__PUBLIC__/images/c_5.png">
				<p>QQ交流</p>
			</a>
		</div>
	</div>
</div>
<?php if($hj != null): ?><!--分割线-->
<div class="container-fluid line"></div>
<!--我的车友会-->
<div class="container-fluid">
  <div class="row" >
      <div class="col-xs-12" >
          <div class="tab_t">
          <h2>我的车友会</h2>
            </div>
        </div>
    </div>
</div>
<div class="swiper-container">
      <div class="swiper-wrapper">
          <div class="swiper-slide red-slide">
                <div class="container-fluid">
                  <div class="row">
                      <div class="Cheyou_1">
                          <a href="<?php echo ($hj["url"]); ?>"><img src="<?php echo ($hj["circle_img"]); ?>"></a>
                      </div>
                      <div class="Cheyou_2">
                          <h3><a href="<?php echo ($hj["url"]); ?>" style="color:#474747; text-decoration:none;"><?php echo ($hj["circle_name"]); ?></a></h3>
                          <p class="Star_<?php echo ($hj["circle_oil_level"]); ?>"></p>
                          <p>会员：<?php echo ($hj["circle_mcount"]); ?>人(已认证<?php echo ($hj["circle_identification_count"]); ?>人)<span style="float:right;">油值：<?php echo ($hj["circle_oil"]); ?>L</span></p>
                          <p>地区：<?php echo ($hj["region_info"]); ?> <span style="float:right;">车系：<?php echo ($hj["car_info"]); ?></span></p>
                      </div>
                  </div>    
              </div>
          </div>     
    </div>
  </div><?php endif; ?>
<!--分割线-->
<div class="container-fluid line"></div>

<!--推荐车友会-->
<div class="container-fluid">
  <div class="row" >
      <div class="col-xs-12" >
          <div class="tab_t">
          <h2>推荐车友会</h2>
            </div>
        </div>
    </div>
</div>

<div class="swiper-container">
      <div class="swiper-wrapper">
      <?php if(is_array($circle_list)): $i = 0; $__LIST__ = $circle_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cl): $mod = ($i % 2 );++$i;?><div class="swiper-slide red-slide">
                <div class="container-fluid">
                  <div class="row">
                      <div class="Cheyou_1">
                          <a href="<?php echo ($cl["url"]); ?>"><img src="<?php echo ($cl["circle_img"]); ?>"></a>
                      </div>
                      <div class="Cheyou_2">
                          <h3><a href="<?php echo ($cl["url"]); ?>" style="color:#474747; text-decoration:none;"><?php echo ($cl["circle_name"]); ?></a></h3>
                          <p class="Star_<?php echo ($cl["circle_oil_level"]); ?>"></p>
                          <p>会员：<?php echo ($cl["circle_mcount"]); ?>人(已认证<?php echo ($cl["circle_identification_count"]); ?>人)<span style="float:right;">油值：<?php echo ($cl["circle_oil"]); ?>L</span></p>
                          <p>地区：<?php echo ($cl["region_info"]); ?> <span style="float:right;">车系：<?php echo ($cl["car_info"]); ?></span></p>
                      </div>
                  </div>    
              </div>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>        
    </div>
      <div class="pagination"></div>
  </div>



<!--分割线-->
<div class="container-fluid line"></div>

<!--杰出堂主-->
<div class="container-fluid">
  <div class="row" >
      <div class="col-xs-12" >
          <div class="tab_t">
          <h2>杰出堂主</h2>
            </div>
        </div>
    </div>
</div>

<div class="swiper-container">
      <div class="swiper-wrapper">
      <?php if(is_array($master_list)): $i = 0; $__LIST__ = $master_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><div class="swiper-slide red-slide">
                <div class="container-fluid">
                  <div class="row">
                      <div class="tztx">
                          <a href="<?php echo U('User/show',array('id'=>$ml['member_id']));?>"><img src="<?php echo ($ml["member_img"]); ?>" style=" width:100%; min-height:100%" onerror="imgError(this,'http://s.17cct.com/v3/images/man.jpg');"></a>
                      </div>
                      <div class="tzxx">
                          <h3 style="margin:10px 0"><a href="<?php echo ($ml["url"]); ?>"><?php echo ($ml["user_name"]); ?></a></h3>
                          <p><?php echo ($ml["circle_name"]); ?></p>
                          <p>地区：<?php echo ($ml["region_info"]); ?></p>
                      </div>
                      <div class="tztz">
                          <a href="<?php echo ($ml["url"]); ?>">
                              <b><?php echo ($ml["topic_count"]); ?></b>
                              <br>帖子
                          </a>
                      </div>
                  </div>    
              </div>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>
       
    </div>
      <div class="pagination"></div>
  </div>



<!--分割线-->
<div class="container-fluid line"></div>

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
              //$.get("<?php echo U('Club/ajax_index_topic');?>",{"p":currentpage}
                $.get("<?php echo U('Club/ajax_get_activity');?>",{"p":currentpage,"id":13,"type":99}
              ,function(html){ 
                      if($.trim(html)!=""){ 
                          if(currentpage==0)
                          {
                            $("#topic_list").html(html);
                          } 
                          else
                          {
                            $("#topic_list").append(html);
                          }                          
                       stop=true;
                      }else{
                         if(currentpage==0)
                          {
                            MsgBox('暂无活动');
                          } 
                          else
                          {
                            MsgBox('已加载全部结果');
                          }
                      }  
                      currentpage++;
                     $("#load").hide();  
                 });              
        }

</script>

<div id="topic_list"></div>
<!--加载-->
<div class="container-fluid" id="load">
    <div class="row">
        <center><div style="line-height:40px;"><img src="__PUBLIC__/images/minilodging.gif">正在加载...</div></center>
    </div>
</div>

<p>&nbsp;</p><p>&nbsp;</p>
<script type="text/javascript" src="__PUBLIC__/js/swiper.min.js"></script>
<script type="text/javascript">
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: 2000,
    autoplayDisableOnInteraction: false
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