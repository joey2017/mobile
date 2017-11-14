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

<style type="text/css">
    /*布局样式重置*/
    .tab_parent{padding-left: 15px;}
    .tab_subset{margin:0; padding: 0 15px 0 0;}
    a{color: #333;}
    a:focus,a:active, a:hover{color: #333; text-decoration: none;}
    .box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
    .flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}
    .o_f{overflow: hidden;}
    .locate{position: relative;}
    .absolute_fix{position:absolute;}

    .new_topbg{height: 220px; background:url(__PUBLIC__/images/new_stop_index.jpg) no-repeat center 100%;}
    .new_topbg h1{color: #fff; font-size: 24px; margin-top: 65px;}
    .new_index_logo{padding:20px 0 0 20px;}

    .new_index_icon{background: url(__PUBLIC__/images/new_stop_index_icon.svg) no-repeat;background-size: 440px; }
    .Purchase{background-position: 13px 21px;}
    .e_shop{background-position: -110px 19px;}
    .admini{background-position: -230px 19px;}
    .more{background-position: -333px 19px;}


    .new_stop_index_line{top: 0; left: 0; z-index: 2;}
    .index_btn{padding-top: 25px; padding-bottom: 25px;}
    .index_btn span{display: block; height: 80px; width: 80px; margin: 0 auto;}
    .left_border{border-left:1px #e7e7e7 solid;}
    .bottom_border{border-bottom:1px #e7e7e7 solid;}

    .new_bottom_line{background: #da1f1f; height: 10px; position: fixed; left: 0; bottom: 0; width: 100%;}



    @media (min-width:425px) {
        .new_topbg{background-size: 100%;}
    }
    .tuichu{  z-index: 1;  width: 36px;  height: 36px;  top: 24px; right: 20px;}
    .tuichuico{ display: inline-block;  width: 36px;  height: 36px; vertical-align: middle;background: url(http://www.17cct.com/mobile/Public/images/bossico.svg) no-repeat -53px 5px; background-size: 110px;}


</style>


<div class="new_topbg locate">
    <div class="new_index_logo">
        <img src="__PUBLIC__/images/lodlogo2.png" width="190">
    </div>
    <h1 class="text-center"><?php echo ($n_location_name); ?></h1>
   <!--  <div class="row" style="margin-top:15px;">
        <a href="<?php echo U('Biz/login_out');?>" class="btn btn-warning btn-block btn-lg">退出登录</a>
    </div> -->
    <a  href="<?php echo U('Biz/login_out');?>" class="pull-right absolute_fix tuichu"><span class="tuichuico"></span></a>
</div>


<div class="text-center locate">
    <img src="__PUBLIC__/images/new_stop_index_line.svg" width="100%" class="absolute_fix new_stop_index_line" >

    <div class="col-xs-6 index_btn bottom_border">
        <a href="<?php echo U('Purchase/home');?>">
            <span class="new_index_icon Purchase"></span>
            批发采购
        </a>
    </div>
    <div class="col-xs-6 index_btn left_border bottom_border">
        <a href="<?php echo U('Store/view',array('id'=>$n_location_id));?>">
            <span class="new_index_icon e_shop"></span>
            微商城
        </a>
    </div>
    <div class="col-xs-6 index_btn bottom_border">
        <a href="<?php echo U('Biz/shop_count');?>">
            <span class="new_index_icon admini"></span>
            门店管理
        </a>
    </div>
    <div class="col-xs-6 index_btn left_border bottom_border">
        <a href="<?php echo U('Biz/entrance_more',array('id'=>$n_location_id));?>">
            <span  class="new_index_icon more"></span>
            更多
        </a>
    </div>
</div>


<div class="new_bottom_line"></div>
</body>
</html>