<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<title>消息中心</title>
		<link rel="stylesheet" href="__PUBLIC__/css/iconfont.css" />
		<link rel="stylesheet" href="__PUBLIC__/css/reset.css" />
		<link rel="stylesheet" href="__PUBLIC__/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/text.css"/>
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/css.css?v=20150617">
		<script type="text/javascript" src="__PUBLIC__/js/jquery.js" ></script>
		<script type="text/javascript" src="__PUBLIC__/js/bootstrap.min.js" ></script>
		<script type="text/javascript" src="__PUBLIC__/js/wap_v4_common.js"></script>
	</head>
	<body>
		<div class="alertBg" id="msgBox" style="display:none;">
		    <h4 class="alerttitle" id="alerttitle"></h4>
		    <span class="vm f20" id='alertdetail'></span>
		</div>
		<div class="box">
			<!--信息 开始-->
			<ul class="dope">
				
			</ul>
			
			<!--信息 结束-->			
		</div>
		<!--盒子 结束-->
		<div style="height: 45px;clear:both;"></div>
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
	</body>
	
	<script type="text/javascript" src="__PUBLIC__/js/move.js" ></script>	
</html>
<script type="text/javascript" src="__PUBLIC__/js/sup.common.js"></script>
<script type="text/javascript">
    mob.init("<?php echo U('SupInfo/msg_list');?>",$(".box .dope"));
    $('.pos-nav a').eq(0).addClass('nav-red');
</script>