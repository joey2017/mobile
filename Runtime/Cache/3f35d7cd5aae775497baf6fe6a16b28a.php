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
<link rel="stylesheet" type="text/css" href="__PUBLIC__/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="__PUBLIC__/css/common_home.css">
<link rel="stylesheet" href="__PUBLIC__/css/iconfont.css" />
<link rel="stylesheet" href="__PUBLIC__/css/reset.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/text.css"/>
<style type="text/css">

.tab_parent{padding-left: 15px;height:110px;}

/*主要数据*/
.main_data{ background: #eeb415; padding: 15px 0; overflow: hidden; color: #fff; }
.data_tab{padding: 10px 0 0 0; width: 160px; margin:15px auto;  height: 150px;}
.data_tab h4{color: #ffe400; font-size: 24px;font-weight: bold;}
.data_tab a,.datah a{color: #fff; display:block;text-decoration: blink;}
.box-flex{ display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox;  display: flex; }
.flex1{-webkit-box-flex: 1;-moz-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;}
.data_b_r{border-right: 1px solid #ffe400;}
.datah{padding-top: 5px;}
.datah p,.turnover p{font-size: 14px;}
.datah h5{font-size: 16px; color: #ffe400; font-weight: bold;margin-top: 10px;margin-bottom: 10px;}
.turnover h5{font-size: 16px; color: #ff3e3e; font-weight: bold;margin-bottom: 10px}
.turnover{padding: 10px 0;}
.data_rb{border-right:1px solid #eee;}
.pos-nav a{margin-top: 4px;}

</style>
</head>
<body>

<!--弹出提示框-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<script type="text/javascript" src="__PUBLIC__/js/countUp.min.js"></script>

<div class="main_data text-center">

    <div class="row tab_parent">
            <div class="" style="float: left;margin-left: 20px;margin-top:10px;">
                <img style="width:70px;" src="__PUBLIC__/images/fenxiao.png" alt="">
            </div>
            <div class="" style="float: left;margin-left: 20px;margin-top: 30px;">
                <p style="font-size:15px;">
                    <?php echo ($supplier_name["name"]); ?>
                </p>
                <p style="text-align: left;font-size: 12px;margin-top: 10px;">登录账号：<?php echo ($supplier_account["a_name"]); ?></p>
            </div>
    </div>

    <div class="box-flex">
        <div class="flex1 datah data_b_r">
            <a href="javascript:;">
                <p>今日订单</p>
                <h5><span id="today_count"><?php echo ($top_count["count"]); ?></span></h5>
            </a>
        </div>
        <div class="flex1 datah data_b_r">
            <a href="javascript:;">
                <p>今日营业</p>
                <h5><span id="member_bind_count"><?php echo ($top_count["total_price"]); ?></span></h5>
            </a>
        </div>
         <div class="flex1 datah">
            <a href="javascript:;">
                <p>待发货订单</p>
                <h5><span id="today_member_count"><?php echo ($top_count["untreated_count"]); ?></span></h5>
            </a>
        </div>

    </div>
</div>

<!-- 历史营业额 -->
<div class="box-flex text-center">
    <div class="flex1 turnover data_rb">
        <h5><span id="member_count_sum"><?php echo ($member_count_sum); ?></span></h5>
        <p>客户总数</p>
    </div>
    <div class="flex1 turnover data_rb">
        <h5><span id="this_week_total"><?php echo (price($this_week_total)); ?></span></h5>
        <p>本周营业</p>
    </div>
    <div class="flex1 turnover ">
        <h5><span id="this_moon_total"><?php echo (price($this_moon_total)); ?></span></h5>
        <p>本月营业额</p>
    </div>
</div>

<div class="container-fluid title">
    <h2 style="margin-top: 1px;">我的信息</h2>
</div>
<div class="query row" style="height:105px;">
    
    <div class="col-xs-4">
        <a href="<?php echo U('SupInfo/index');?>">
            <i class="iconfont icon-xiaoxi"></i>
            <p>消息中心</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('Supplier/authorize');?>">
            <i class="iconfont icon-feiji"></i>
            <p>推送授权</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('Supplier/password');?>">
            <i class="iconfont icon-mima"></i>
            <p>修改密码</p>
        </a>
    </div>

</div>

<div class="container-fluid title">
    <h2 style="margin-top: 1px;">交易/客户</h2>
</div>
<div class="query row">

    <div class="col-xs-4">
        <a href="<?php echo U('SupOrder/store_order');?>">
            <i class="iconfont icon-xiadan li-icon1"></i>
            <p>代客下单</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('SupOrder/settlement');?>">
            <i class="iconfont icon-jiesuan li-icon2"></i>
            <p>结算订单</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('SupOrder/index');?>">
            <i class="iconfont icon-dingdanchaxun li-icon3"></i>
            <p>订单查询</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('SupMember/index');?>">
            <i class="iconfont icon-kehuxinxi li-icon4"></i>
            <p>客户信息</p>
        </a>
    </div>
</div>

<div class="container-fluid title">
    <h2 style="margin-top: 1px;">财务/库存</h2>
</div>
<div class="query row">
    <div class="col-xs-4">
        <a href="<?php echo U('SupSale/sale_detail');?>">
            <i class="iconfont icon-xiaoshoue"></i>
            <p>销售明细</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('SupSale/sales_summary');?>">
            <i class="iconfont icon-m-summary"></i>
            <p>销售汇总</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('SupWarehouse/index');?>">
            <i class="iconfont icon-kucunchaxun"></i>
            <p>库存查询</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('SupWarehouse/stockAlarm');?>">
            <i class="iconfont icon-kucunyujing"></i>
            <p>库存预警</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('SupMember/credit');?>">
            <i class="iconfont icon-zhuanshi icon-4"></i>
            <p>客户信用</p>
        </a>
    </div>

    <div class="col-xs-4">
        <a href="<?php echo U('SupSale/operating_statement');?>">
            <i class="iconfont icon-baobiao"></i>
            <p>经营报表</p>
        </a>
    </div>
</div>

<div class="container-fluid title">
    <h2 style="margin-top: 1px;">售后</h2>
</div>
<div class="query row" style="height:105px;">
    <div class="col-xs-4">
        <a href="<?php echo U('SupMember/order_refund_search');?>">
            <i class="iconfont icon-tuihuo"></i>
            <p>门店退货</p>
        </a>
    </div>
 </div>   
</div>
<div class="container-fluid title" style="height:16px;">
    <h2 style="margin-top: 1px;"></h2>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<!--漂浮导航 开始-->
<div class="row pos-nav">
    <div class="col-xs-3">
        <a href="<?php echo U('Supplier/index');?>" <?php if(MODULE_NAME == Supplier): ?>class="nav-red"<?php endif; ?>>
            <i class="iconfont icon-shangdian1"></i>
            <p>首页</p>
        </a>
    </div>
    <div class="col-xs-3">
        <a href="<?php echo U('SupOrder/navig');?>" <?php if(MODULE_NAME == SupOrder): ?>class="nav-red"<?php endif; ?>>
            <i class="iconfont icon-kehu"></i>
            <p>交易/客户</p>
        </a>
    </div>
    <div class="col-xs-3">
        <a href="<?php echo U('SupWarehouse/navig');?>" <?php if(MODULE_NAME == SupWarehouse): ?>class="nav-red"<?php endif; ?>>
            <i class="iconfont icon-kucun"></i>
            <p>财务/库存</p>
        </a>
    </div>
    <div class="col-xs-3">
        <a href="<?php echo U('SupMember/navig');?>" <?php if(MODULE_NAME == SupMember): ?>class="nav-red"<?php endif; ?>>
            <i class="iconfont icon-shouhou"></i>
            <p>售后</p>
        </a>
    </div>  
</div>
<!--漂浮导航 结束-->

</body>
</html>