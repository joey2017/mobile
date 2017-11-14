<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<title>财务/库存</title>
		<link rel="stylesheet" href="__PUBLIC__/css/iconfont.css" />
		<link rel="stylesheet" href="__PUBLIC__/css/reset.css" />
		<link rel="stylesheet" href="__PUBLIC__/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/text.css"/>
		<script type="text/javascript" src="__PUBLIC__/js/jquery.js" ></script>
	</head>
	<body>
		<div class="box">
			<!-- <div style="height: 44px; background: #222;"></div> -->
			<!--列表 开始-->
			<ul class="listing">
				<li>
					<a href="<?php echo U('SupSale/sale_detail');?>">
						<i class="iconfont icon-xiaoshoue li-icon5"></i>
						<p>销售明细</p>
						<span class="iconfont icon-jiantou-copy-copy"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('SupSale/sales_summary');?>">
						<i class="iconfont icon-m-summary li-icon6"></i>
						<p>销售汇总</p>
						<span class="iconfont icon-jiantou-copy-copy"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('SupWarehouse/index');?>">
						<i class="iconfont icon-kucunchaxun li-icon7"></i>
						<p>库存查询</p>
						<span class="iconfont icon-jiantou-copy-copy"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('SupWarehouse/stockAlarm');?>">
						<i class="iconfont icon-kucunyujing li-icon8"></i>
						<p>库存报警</p>
						<span class="iconfont icon-jiantou-copy-copy"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('SupMember/credit');?>">
						<i class="iconfont icon-zhuanshi li-icon9"></i>
						<p>客户信用</p>
						<span class="iconfont icon-jiantou-copy-copy"></span>
					</a>
				</li>
				<li>
					<a href="<?php echo U('SupSale/operating_statement');?>">
						<i class="iconfont icon-baobiao li-icon10"></i>
						<p>经营报表</p>
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