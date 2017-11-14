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
<meta name="format-detection" content="telephone=no" />
<link href="__PUBLIC__/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<style type="text/css">
.member{background:#d32912; position:relative; height: 200px;}
.member_info_box{width: 100%;}
.member_bottom{position: absolute; bottom:-1px; width: 100%; height: 50px; background:url(__PUBLIC__/images/newbg.svg) no-repeat bottom; z-index: 1; }
.member_info{color: #fff;}
.member_info h3{font-size: 16px; margin: 40px 0 7px 0;}
.m_user{ margin: 10px auto; position: relative; height: 64px; width: 78px;}
.m_user img{width:78px;height:78px;border-radius: 50%; margin-right: 7px;}

.erp_react{display: block; text-align: center; padding: 16px 0;border-right: 1px solid #ddd8ce; position: relative;}
.erp_react i{font-size: 24px;}
.erp_react span,.react2 span{position: absolute; width: 20px;height: 20px; display: inline-block; background: #d32912; color: #fff; border-radius: 15px;}
.react2 span{top: 6px;margin-left: 20px;}

.locate{position: relative;}
.absolute_fix{position:absolute;}
.inon_i{width: 40px; height: 40px; overflow: hidden; display:inline-block; vertical-align: middle;}
.mem_ico{background:url(__PUBLIC__/images/memberico.svg) no-repeat;}

.erp_i_bg01{ background-size: 180px; background-position: -14px -10px;}
.erp_i_bg02{ background-size: 150px; background-position: -9px -67px;}

.erp_i_bg03{ background-size: 150px; background-position: -8px -129px;}
.erp_i_bg04{ background-size: 150px; background-position: -8px -192px;}
.erp_i_bg05{ background-size: 188px; background-position: -15px -324px;}

.erp_i_bg06{ background-size: 150px; background-position: -9px -317px;}
.erp_i_bg07{ background-size: 163px; background-position: -10px -414px;}
.erp_i_bg08{ background-size: 162px; background-position: -9px -480px;}
.erp_i_bg09{ background-size: 150px; background-position: -9px -505px;}
.erp_i_bg10{ background-size: 150px; background-position: -9px -574px;}
.erp_i_bg11{ background-size: 150px; background-position: -9px -638px;}
.b_0{border:0;}

</style>

<div class="member">
    <div class="member_info_box">
        <div class="m_user">
            <a href="<?php echo U('User/account');?>" class="pull-left"><img src='<?php if($user["head_img"] == null): ?>http://s.17cct.com/v3/images/man.jpg<?php else: echo ($user["head_img"]); endif; ?>' onerror="imgError(this,'http://s.17cct.com/v3/images/man.jpg');"></a>
        </div>
        <div class="text-center member_info">
            <h3><?php echo ($user["true_name"]); ?></h3>
            <span><?php echo ($user["mobile"]); ?></span>
        </div>
    </div>
    <div class="member_bottom"></div>
</div>

<div class="service">
    <div class="col-xs-inner">  
        <a href="<?php echo U('User/member_card');?>" class="erp_react">         
            <i class="inon_i mem_ico erp_i_bg01"></i>
            会员卡  
        </a>
    </div>
    <div class="col-xs-inner">
        <a href="<?php echo U('User/work_order');?>" class="erp_react b_0">         
            <i class="inon_i mem_ico erp_i_bg02"></i>
            服务工单 <?php if($count["all_count"] != 0): ?><span><?php echo ($count["all_count"]); ?></span><?php endif; ?>          
        </a>
    </div>
</div>



<!--分割线-->
<div class="container-fluid line"></div>

<!--服务券-->
<div class="service">
    <div class="col-xs-inner">  
        <a href="<?php echo U('User/work_order',array('status'=>1));?>" class="react2 b_0 locate">
            <i class="inon_i mem_ico erp_i_bg03"></i>
            <p>施工中</p>
            <?php if($count["construction"] != 0): ?><span><?php echo ($count["construction"]); ?></span><?php endif; ?> 
        </a>
    </div>
    <div class="col-xs-inner">  
        <a href="<?php echo U('User/work_order',array('status'=>2));?>" class="react2 b_0 locate">
            <i class="inon_i mem_ico erp_i_bg04"></i>
            <p>验收中</p>
            <?php if($count["acceptance"] != 0): ?><span><?php echo ($count["acceptance"]); ?></span><?php endif; ?>        
        </a>
    </div>
    <div class="col-xs-inner">  
        <a href="<?php echo U('User/work_order',array('status'=>3));?>" class="react2 b_0 locate">
            <i class="inon_i mem_ico erp_i_bg05"></i>
            <p>待结算</p>
            <?php if($count["settlement"] != 0): ?><span><?php echo ($count["settlement"]); ?></span><?php endif; ?>  
        </a>
    </div>
</div>

<!--分割线-->
<div class="container-fluid line"></div>

<div class="memberico">
    
    <div class="memberrigt">
        <div class="memberrigt-box">
            <div class="memberrigt-tab">
                <a href="<?php echo U('User/package_list');?>" class="react2">
                    <i class="inon_i mem_ico erp_i_bg06"></i>
                    <p>套餐</p>
                </a>
            </div>
            <div class="memberrigt-tab">
                <a href="<?php echo U('User/mycar_info');?>" class="react2" >
                    <i class="inon_i mem_ico erp_i_bg07"></i>
                    <p>车况</p>
                </a>
            </div>
        </div>
        <div class="memberrigt-box">
            <div class="memberrigt-tab">
                <a href="<?php echo U('User/give_list');?>" class="react2" >
                    <i class="inon_i mem_ico erp_i_bg10"></i>
                    <p>赠送项目</p>
                </a>
            </div>
            <div class="memberrigt-tab">
                <a href="<?php echo U('User/order');?>" class="react2" >
                    <i class="inon_i mem_ico erp_i_bg09"></i>
                    <p>订单</p>
                </a>
            </div>
        </div>
        <div class="memberrigt-box">
            <div class="memberrigt-tab">
                <a href="<?php echo U('User/pay_note_index');?>" class="react2" style="border-bottom:none;">
                    <i class="inon_i mem_ico erp_i_bg08"></i>
                    <p>记账</p>
                </a>
            </div>
            <div class="memberrigt-tab">
                <a href="<?php echo U('Advance/reservation_record');?>" class="react2" style="border-bottom:none;">
                    <i class="inon_i mem_ico erp_i_bg11"></i>
                    <p>我的预约</p>
                </a>
            </div>
        </div>

    </div>
</div>

<!--分割线-->
<div class="container-fluid line"></div>

<!-- 剩余天数 -->
<div class="surplusday">
    <div class="s-day">
        <div>
            <p><b><?php echo ($car_info["next_maintain_time"]); ?></b> 天</p>
            <span>下次保养</span>
        </div>
    </div>
    <div class="s-day">
        <div>
            <p><b><?php echo ($car_info["next_insurance_time"]); ?></b> 天</p>
            <span>下次保险</span>
        </div>
    </div>
    <div class="s-day">
        <div>
            <p><b><?php echo ($car_info["next_annually_time"]); ?></b> 天</p>
            <span>下次年检</span>
        </div>
    </div>
</div>

<!--分割线-->
<!-- <?php if(is_array($news)): foreach($news as $key=>$news): ?><div class="container-fluid line"></div>
<div class="container-fluid">
    <div class="row" >
        <div class="col-xs-12" >
            <a href="<?php echo ($news["url"]); ?>" class="newsabox">
                <div class="n_a_l">
                    <h2><?php echo (msubstr($news["data"]["title"],0,10)); ?></h2>
                    <P><?php echo (msubstr($news["data"]["description"],0,13)); ?></P>
                    <P><span><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span><?php echo ($news["views"]); ?></span>   <span><span class="glyphicon glyphicon-time" aria-hidden="true"></span><?php echo (date('Y-m-d',($news["data"]["inputtime"])?($news["data"]["inputtime"]):time())); ?></span></P>
                </div>
                <div class="n_a_r">
                    <img src="<?php echo ($news["data"]["thumb"]); ?>" width="100"  height="73">
                </div>
            </a>
        </div>
    </div>
</div><?php endforeach; endif; ?> -->


<script type="text/javascript">

    function show_err(){
        MsgBox('正在开发中');
    }

/*$(function(){
    loadingData();
});
function loadingData() {
    $.ajax({
        url: '<?php echo U("User/ajaxGetData");?>',
        type: 'post',
        dataType: 'json',
        success: function(d) {
            if (d.status == 1) {
                var list = d.data;  
                $('#uc_point').text(list.uc_point);
                $('#uc_score').text(list.uc_score);
                $('#uc_coupon').text(list.uc_coupon);
                $('#uc_order').text(list.uc_order);
                $('#uc_recommend_activity').text(list.uc_recommend_activity);
                $('#uc_club').text(list.uc_club);
                $('#uc_topic').text(list.uc_topic);
                $('#uc_message').text(list.uc_message);
                $('#uc_prize').text(list.uc_prize);
                $('#uc_exchange').text(list.uc_exchange);
                $('#uc_shaidan').text(list.uc_shaidan);
                $('#uc_zc').text(list.uc_zc);
                $('#uc_card').text(list.uc_card);
            } else {
                MsgBox('网络延迟，数据查找失败');
            }
        }
    });
}*/
</script>
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