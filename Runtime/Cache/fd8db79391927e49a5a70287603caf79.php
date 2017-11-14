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
<link rel="stylesheet" href="__PUBLIC__/font-awesome/css/font-awesome.min.css">
</head>

<body class="drawer drawer-right">
<link href="__PUBLIC__/css/mobiscroll_date.css" rel="stylesheet" />
<script src="__PUBLIC__/js/mobiscroll_date.js" charset="gb2312"></script>
<script src="__PUBLIC__/js/mobiscroll.js"></script>
<link rel="stylesheet" href="__PUBLIC__/css/iconfont.css" />
<link rel="stylesheet" href="__PUBLIC__/css/reset.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/text.css"/>
<script src="__PUBLIC__/js/sup.common.js"></script>

<link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css">
<script type="text/javascript" src="__PUBLIC__/js/swiper.min.js"></script>
<style type="text/css">
    /*布局样式重置*/
    .tab_parent{padding-left: 15px;}
    .tab_subset{margin:0; padding: 0 15px 0 0;}
    a{color: #333;}
    a:focus,a:active, a:hover{color: #333; text-decoration: none;}
    .box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
    .flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}
    body{position: relative;}

    /* 选项卡 */
    .nav-tabs{ background: #efefef; border-top: #c40000 1px solid; text-align: center}
    .nav-tabs>li>a{border-radius: 0;;padding: 10px 10px;margin-right: 0;}
    .tab-pane img{width: 100%;}
    .tab-content{padding:10px 10px 60px 10px;}

    /*底部按钮*/
    .sift_bottom{position:fixed; bottom: 50px; right: 0; width: 100%;}
    .sift_bottom button{border:0;}
    .sift-btn{ height: 48px;color: #fff;  line-height: 48px; float: left; text-align: center;}
    .sift-btn button{background: #e7aa0e;}
    .sift-btn-ok button{background: #ea413e;color: #fff;}
    .sift-btn-no button {background: #adabab;color: #fff;}

    .customer_qq { width: 50px;background: #eee;}
    .customer_qq a{ text-align: center;padding-top: 6px; font-size: 12px;color: #8a8a8a;  }
    .customer_qq a i{font-size: 22px;color: #6b9af5; display: block;}


    /*筛选按钮*/
    .screen{height: 52px; clear: both; text-align: center;padding: 10px 0; position: relative}
    .screen .col-xs-5 {padding-left: 10px; padding-right: 0;}
    .searchbtn input{width: 50px; height: 33px; border:0; background: #f6a915; color: #fff; border-radius: 5px;}

    .pos-nav a{margin-top: 5px;}

</style>

<form action='<?php echo U("SupSale/operating_statement");?>' method="post">
<div class="screen">
    <div class="col-xs-5">
        <input class="form-control mobiscroll" readonly="true" id="start_time" name="start_time" type="text" value="<?php echo ($start_time); ?>"
               placeholder="开始时间">
    </div>
    <div class="col-xs-5" >
        <input class="form-control mobiscroll" readonly="true" id="end_time" name="end_time" type="text" value="<?php echo ($end_time); ?>"
               placeholder="结束时间">
    </div>
    <div class="searchbtn col-xs-2" style="padding: 0;">
        <input type="submit" value="搜索">
    </div>
</div>
</form>

<div style="clear: both;">
    <ul class="nav nav-tabs box_flex" id="myTab">
        <li class="flex1 active"><a href="#sale" data-toggle="tab">销售报表</a></li>
        <li class="flex1"><a href="#stock" data-toggle="tab">库存报表</a></li>
        <li class="flex1"><a href="#pay" data-toggle="tab">支付方式报表</a></li>
    </ul>
</div>
<div class="tab-content">
    <div class="tab-pane active" id="sale">
        <table class="table table-bordered">
            <thead style="background-color: #eee;">
                <tr><td>统计项目</td><td>项目值</td></tr>
            </thead>
            <?php if(is_array($results_sales)): $i = 0; $__LIST__ = $results_sales;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?><tr>
                    <td align="right" width="120" class="tdbg"><?php echo ($key); ?></td>
                    <td><?php echo ($rs); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </div>

    <div class="tab-pane" id="stock">
        <table class="table table-bordered">
            <thead style="background-color: #eee;">
                <tr><td>类型</td><td>商品数量</td><td>合计金额</td></tr>
            </thead>
            <?php if(is_array($results_stock)): $i = 0; $__LIST__ = $results_stock;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?><tr>
                    <td align="right" width="120" class="tdbg"><?php echo ($key); ?></td>
                    <td><?php echo ($rs['total']); ?></td>
                    <td><?php echo ($rs['paid_price']); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </div>

    <div class="tab-pane" id="pay">
        <table class="table table-bordered">
            <thead style="background-color: #eee;">
                <tr><td>支付方式</td><td>交易数量</td><td>交易金额</td></tr>
            </thead>
            <?php if(is_array($results_payments)): $i = 0; $__LIST__ = $results_payments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rp): $mod = ($i % 2 );++$i;?><tr>
                    <td align="right" width="120" class="tdbg"><?php echo ($key); ?></td>
                    <td><?php echo ($rp['num']); ?></td>
                    <td><?php echo ($rp['price']); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </div>
</div>

<!--底栏-->
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
<script type="text/javascript">
    mob.timePlugin();
</script>
</body>
</html>