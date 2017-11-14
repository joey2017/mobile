<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<title>交易/客户</title>
		<link rel="stylesheet" href="__PUBLIC__/css/iconfont.css" />
		<link rel="stylesheet" href="__PUBLIC__/css/reset.css" />
		<link rel="stylesheet" href="__PUBLIC__/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/text.css"/>
		<script type="text/javascript" src="__PUBLIC__/js/jquery.js" ></script>
	</head>
	<body>
		<div class="box">
			<!--列表 开始-->
			<ul class="listing">
				<li>
					<a href="<?php echo U('SupOrder/store_order');?>">
						<i class="iconfont icon-xiadan li-icon1"></i>
						<p>代客下单</p>
						<span class="iconfont icon-jiantou-copy-copy"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('SupOrder/settlement');?>">
						<i class="iconfont icon-jiesuan li-icon2"></i>
						<p>结算订单</p>
						<span class="iconfont icon-jiantou-copy-copy"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('SupOrder/index');?>">
						<i class="iconfont icon-dingdanchaxun li-icon3"></i>
						<p>订单查询</p>
						<span class="iconfont icon-jiantou-copy-copy"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('SupMember/index');?>">
						<i class="iconfont icon-kehuxinxi li-icon4"></i>
						<p>客户信息</p>
						<span class="iconfont icon-jiantou-copy-copy"></span>
					</a>
				</li>
			</ul>
			<!--列表 结束-->
		</div>
		
		
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
	
<script type="text/javascript" src="__PUBLIC__/js/move.js" ></script>