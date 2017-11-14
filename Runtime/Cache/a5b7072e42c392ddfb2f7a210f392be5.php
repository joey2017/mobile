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

<style type="text/css">
    .work_order_top{padding:5px 15px; color: #fff; font-size: 25px; position:relative;}
    .work_order_top a{color: #fff;}

    /*筛选框*/
    .screen_btn{ font-size: 16px;}
    .screen_btn span,.refreshico{display: inline-block; width: 24px; height: 19px;vertical-align: middle;}
    .screen_btn span{background: url(__PUBLIC__/images/bossico.svg) no-repeat 6px 0; background-size: 35px;}
    .refreshico{background: url(__PUBLIC__/images/bossico.svg) no-repeat -23px -1px; background-size: 48px;}

    .screenbox{ position: absolute; width: 100%; padding:10px; top: 50px; left: 0; color: #4C4C4C; font-size: 14px; background:#fff; display: none; border-bottom: 1px solid #eee;}
    .screenbox dl{margin-bottom: 3px;}
    .screenbox dt{margin-right: 10px;line-height: 30px;}
    .screenbox dd{padding-left: 40px;}
    .screenbox a{padding:4px 10px;display: inline-block; border:1px solid #eee; color:#4C4C4C; margin-bottom: 5px;}
    .screen_cur{background: #FF962A;border:1px solid #FF962A !important; color: #fff !important;}

    /*主要数据*/
    .main_data{ background: #ff3e3e; padding: 15px 0; overflow: hidden; color: #fff; }
    .data_tab{position: relative; padding: 30px 0 0 0; width: 150px; margin: 15px auto; height: 150px; border-radius: 50%; border: 1px solid #ff6d6d; background-color: #f33636;}
    .data_tab h4{color: #ffe400; font-size: 24px;font-weight: bold;}
    .data_tab a,.datah a{color: #fff; display:block;}
    .box-flex{ display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox;  display: flex; }
    .flex1{-webkit-box-flex: 1;-moz-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;}
    .data_b_r{border-right: 1px solid #ff7575;}
    .datah{padding-top: 5px;}
    .datah p,.turnover p{font-size: 12px;}
    .datah h5{font-size: 16px; color: #ffe400; font-weight: bold;}
    .turnover h5{font-size: 20px; color: #ff3e3e; font-weight: bold;}
    .data_rb{border-right:1px solid #eee;}

    .data_btn span{display: block;width: 50px;height: 50px; margin: 15px auto 7px auto; border-radius: 50%;}

    .da_btn8{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -160px -56px;background-size: 230px;background-color:#88AFF3;}
    .da_btn9{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -2px -104px;background-size: 230px;background-color:#F3B088;}
    .da_btn10{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -55px -103px;background-size: 230px;background-color:#9B88CA;}
    .da_btn15{ background: url(__PUBLIC__/images/authorize.svg) no-repeat 8px 7px;background-size: 34px;background-color:#34c566;}
    /*.da_btn13{ background: url(__PUBLIC__/images/purchase_order.svg) no-repeat 8px 7px;background-size: 34px;background-color:#7ec7f7;}*/

</style>


<!--头部-->

<div class="container-fluid topbox">
    <div class="row top">
        <div class="pg-Current">
            <a href="" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pgt"><a>返回</a></div>
    </div>
</div>

<!--服务券-->
<div class="box-flex text-center">
    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/authorize',array('id'=>$n_location_id));?>">
            <span class="da_btn15"></span>
            <p>推送授权</p>
        </a>
    </div>
    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/myagent',array('id'=>$n_location_id));?>">
            <span class="da_btn10"></span>
            <p>代理推广</p>
        </a>
    </div>
    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/income',array('id'=>$n_location_id));?>">
            <span class="da_btn8"></span>
            <p>代理收入</p>
        </a>
    </div>
    <!-- <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/purchase_order',array('id'=>$n_location_id));?>">
            <span class="da_btn13"></span>
            <p>采购订单</p>
        </a>
    </div> -->
    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/location',array('id'=>$n_location_id));?>">
            <span class="da_btn9"></span>
            <p>发展门店</p>
        </a>
    </div>
</div>
<!--分割线-->
<div class="container-fluid line" ></div>

</body>
</html>