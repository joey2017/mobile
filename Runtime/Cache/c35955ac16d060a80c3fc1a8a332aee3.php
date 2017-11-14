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
<link rel="stylesheet" href="__PUBLIC__/css/drawer.min.css">
<script src="__PUBLIC__/js/iscroll.js"></script>
<script src="__PUBLIC__/js/jquery.drawer.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/sup.common.js"></script>
</head>


<body class="drawer drawer-right">

<style type="text/css">
/*布局样式重置*/
.tab_parent{padding-left: 15px;}
.tab_subset{margin:0; padding: 0 15px 0 0;}
a{color: #333;}
a:focus,a:active, a:hover{color: #333; text-decoration: none;}
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}
body{position: relative;}
.o_f{overflow: hidden;}

/*地址*/
.addinfo{padding: 10px; border-bottom: 1px solid #eee;}
.addinfo .bline p{padding: 0 0 6px 0; margin:0; line-height: 25px; }
.bline{border-bottom: 1px solid #e6e6e6;}
.infotab{padding: 8px 10px; background:#fbfbfb; }


/*门店名*/
.bundlev{height:40px; line-height: 40px; padding: 0 10px;}
.bundlev p{margin: 0;}
.storeico{display: inline-block; width: 20px; height: 20px; vertical-align: middle;background: url(__PUBLIC__/images/store.svg) no-repeat; background-size: 20px; margin-right: 3px;}

/*产品列表*/
.productlist{overflow: hidden; padding: 12px 10px;margin-top: .09rem;padding-top: 12px;padding-bottom: 12px;}
.leftimg{width: 100px; height: 100px; margin-right: 10px;}
.leftimg img{width: 100%; height: 100%;}
.rightinfo h3{ line-height: 22px; margin: 3px; height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;  font-size: 14px;  word-break: break-all;}
.price{ color: #eb5211;font-size: 20px;}
.d-main{line-height: 28px;}
.d-main .pull-right{font-size: 14px; color: #717171;}

.inline{height: 5px; background: #eee; border-top: 1px solid #d0d0d0;}


/*底部按钮*/
.sift_bottom{position:fixed; bottom: 0; right: 0; width: 100%;}
.sift_bottom a{background: #f0ad4e;color: #fff;border:0;width:100%; height: 48px;line-height: 48px;text-align: center;}

.tickbtn2 {
	width: 40px;
	height: 96px;
	line-height: 96px;
	display: inline-block;
}
.tickico {
	background: url(__PUBLIC__/images/tick.svg) no-repeat;
	background-size: 40px;
}
.tickNull {
	background: url(__PUBLIC__/images/tick.svg) no-repeat -20px 0;
	background-size: 40px;
}
.tickico, .storeico, .tickNull {
	display: inline-block;
	width: 20px;
	height: 20px;
	vertical-align: middle;
}

.bomb_screen{position: absolute; z-index: 5; width: 100%; min-height: 100%; background: #fff; display: none; top: 0;}
.topsearch {
	height: 34px;
	margin: 10px 0;
}
.box_flex{font-size: 14px;display: flex;}

.searchtab {
	position: relative;
	width: 100%;
	height: 36px;
	border-radius: 5px;
	margin-right: 10px;
}
.flex1{
	-webkit-box-flex: 1; flex: 1;
}
.searchtab span {
	position: absolute;
	width: 30px;
	height: 30px;
	display: block;
	top: 2px;
	left: 2px;
	background: url(__PUBLIC__/images/searchico.svg) no-repeat;
	background-size: 30px;
}
.searchtab input {
	border: 0;
	background: #efefef;
	text-indent: 2em;
}
.searchbtn {
	width: 80px;
	height: 36px;
}
.searchbtn button {
	width: 80px;
	height: 33px;
	border: 0;
	background: #f6a915;
	color: #fff;
	border-radius: 5px;
}
.screen {
	height: 42px;
	clear: both;
	text-align: center;
	border-top: 1px solid #e2e2e2;
	border-bottom: 1px solid #e2e2e2;
	padding: 10px 0;
	position: relative;
}
.screen .col-xs-4 {
	padding-left: 0;
	padding-right: 0;
}
a:link, a:active {
	text-decoration: none;
}
a {
	color: #333;
}
.arrowico {
	width: 7px;
	height: 7px;
	display: inline-block;
	background: url(__PUBLIC__/images/down-icon.svg) no-repeat;
	background-size: 7px;
}
.sepline {
	border-right: 1px solid #e2e2e2;
}
.sort_sele, .sort_sele2 {
	display: none;
	width: 100%;
	position: absolute;
	top: 42px;
	left: 0;
	background: #fff;
	padding: 0 15px 10px 15px;
	z-index: 1;
	text-align: left;
	box-shadow: 0 1px 3px #afafaf;
}
.ptick {
	border-bottom: 1px solid #eee;
	margin: 0;
	line-height: 42px;
}
.tick span {
	display: inline-block;
}
.ptick span {
	width: 16px;
	margin-top: 14px;
	background: url(__PUBLIC__/images/tickspan.png) no-repeat;
	height: 16px;
	float: right;
}
.sort_sele, .sort_sele2{
	text-align: left;
}
.screenico {
	width: 7px;
	height: 7px;
	display: inline-block;
	background: url(__PUBLIC__/images/screen.svg) no-repeat;
	background-size: 7px;
}
.sift_row {
	padding: 0 4% 10px;
	border-bottom: 1px solid #e7e7e7;
	overflow: hidden;
}
.row_title {
	padding: 15px 0;
}
.row_body ul {
	list-style: none;
	margin: 0;
	padding: 0;
}
.row_body ul li {
	padding: 0 10px 10px 0;
	text-align: center;
}
a:link, a:active {
	text-decoration: none;
}
.tc_project {
	padding: 5px 0;
	border-radius: 3px;
	border: 1px solid #ddd;
	font-size: 12px;
	overflow: hidden;
	display: -webkit-box;
	-webkit-line-clamp: 1;
	-webkit-box-orient: vertical;
	height: 28px;
	line-height: 19px;
}
.tc_choose {
	background: #e60012;
	border: 1px #e60012 solid;
	color: #fff !important;
}
.sift_bottom {
	position: absolute;
	bottom: 0;
	right: 0;
	width: 100%;
}
.sift-btn {
	width: 50%;
	height: 48px;
	background: #FFF;
	line-height: 48px;
	float: left;
	text-align: center;
	border-top: 1px solid #e7e7e7;
}
.sift-btn-ok {
	color: #fff;
	background: #ff5000;
	border-top-color: #e7e7e7;
}
.sift-btn {
	width: 50%;
	height: 48px;
	line-height: 48px;
	float: left;
	text-align: center;
	border-top: 1px solid #e7e7e7;
}
.no_record{height: 24px;  padding-top: 205px;  text-align: center;  background: url(http://s.17cct.com/v5/images/erp/empty.png) no-repeat center 20px;  background-size: 180px 180px;}


</style>

<!--弹出提示框-->
<div class="alertBg" id="msgBox" style="display:none;">
	<h4 class="alerttitle" id="alerttitle"></h4>
	<span class="vm f20" id='alertdetail'></span>
</div>

<div class="drawer-main drawer-default">
	<nav role="navigation" id="attr_list" style="height:auto;">
		<div class="sift_row">
			<div class="row_title">
			  订单状态
			  <span class="fa fa-caret-down pull-right"></span>
			</div>
			<div class="row_body">
			  <ul class="row li_choose">
				<li class="col-xs-4">
				  <a href="javascript:;" class="tc_project tc_choose" value="0">不限</a>
				</li>
				<li class="col-xs-4">
					<a href="javascript:;" class="tc_project" value="status:4">已发货</a>
				</li>
				<li class="col-xs-4">
					<a href="javascript:;" class="tc_project" value="status:5">已收货</a>
				</li>
			  </ul>
			</div>
		  </div>

		  <div class="sift_row">
			  <div class="row_title">
				  支付状态
				  <span class="fa fa-caret-down pull-right"></span>
			  </div>
			  <div class="row_body">
				  <ul class="row li_choose">
					  <li class="col-xs-4">
						  <a href="javascript:;" class="tc_project tc_choose" value="0">不限</a>
					  </li>
					  <li class="col-xs-4">
						  <a href="javascript:;" class="tc_project" value="pay_status:1">挂账</a>
					  </li>
					  <li class="col-xs-4">
						  <a href="javascript:;" class="tc_project" value="pay_status:2">已收款</a>
					  </li>
				  </ul>
			  </div>
		  </div>

		  <div class="sift_row">
			  <div class="row_title">
				  区域经理
				  <span class="fa fa-caret-down pull-right"></span>
			  </div>
			  <div class="row_body">
				  <ul class="row li_choose">
					  <li class="col-xs-4">
						  <a href="javascript:;" class="tc_project tc_choose" value="0">不限</a>
					  </li>
					  <?php if(is_array($employee_list)): $k = 0; $__LIST__ = $employee_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$el): $mod = ($k % 2 );++$k;?><li class="col-xs-4">
							  <a href="javascript:;" class="tc_project" value="employee_id:<?php echo ($el["id"]); ?>"><?php echo ($el["name"]); ?></a>
						  </li><?php endforeach; endif; else: echo "" ;endif; ?>                   
				  </ul>
			  </div>
		  </div>
		
	</nav>

	<div class="sift_bottom">
		<div class="sift-btn" id="reset_attr">
			重置
		</div>
		<div class="sift-btn sift-btn-ok" onclick="$('.drawer').drawer('close');">
			确定
		</div>
	</div>
</div>

<div class=" o_f bline infotab ">
  订单编号：<?php echo ($order["order_sn"]); ?>
</div>

<input type="hidden" id="order_id" name="order_id" value="<?php echo ($order_id); ?>">
<input type="hidden" id="location_id" name="location_id" value="<?php echo ($order["location_id"]); ?>">
<input type="hidden" id="location_name" name="location_name" value="<?php echo ($order["location_name"]); ?>">
<input type="hidden" id="paid_money" name="paid_money" value="<?php echo (price($order["paid_amount"])); ?>">
<input type="hidden" id="total_price" name="total_price" value="<?php echo (price($order["total_price"])); ?>">
<div class="bundlev bline">
  <span class="storeico"></span><?php echo ($order["location_name"]); ?>
</div>

<?php if(is_array($order_info)): $i = 0; $__LIST__ = $order_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$oi): $mod = ($i % 2 );++$i;?><div class="productlist box_flex bline">
  <a class="tickbtn2 text-center"><span class="tickNull goods_item <?php if($oi["is_gift"] == 1): ?>gift<?php endif; ?>" data-val="<?php echo ($oi["goods_id"]); ?>"></span></a>
	<div class="leftimg">
	  <a href="<?php echo U('SupGoods/detail',array('id'=>$oi['goods_id']));?>"><img src="<?php echo ($oi["thumbnail"]); ?>"></a>
	</div>
	<div class="rightinfo flex1">
	  <h3><a href="<?php echo U('SupGoods/detail',array('id'=>$oi['goods_id']));?>"><?php echo ($oi["goods_name"]); ?></a></h3>
	  <div class="d-main">
		<span class="price" data-price="<?php echo (price($oi["sell_price"])); ?>">￥<?php echo (price($oi["sell_price"])); ?></span> 
		<span class="pull-right" data-num="<?php echo ($oi["num"]); ?>">× <?php echo ($oi["num"]); ?></span>
	  </div>
	</div>
  </div><?php endforeach; endif; else: echo "" ;endif; ?>

<div class="flex1 bundlev bline">
  <a class="wholebtn text-center" id="do_select_all">
	<span id="select_all" class="tickNull"></span>
  </a>全选
	<span class="pull-right" style="height: 40px;line-height: 40px;">合计: <span class="price">￥<span id="refund_total_price">0</span></span></span>
</div>
<div class="o_f addinfo">
  <div class="">
	<p class="o_f">
	  <span class="pull-left">收货人</span>
	  <span class="pull-right"><?php echo ($order["receive_user"]); ?></span>
	</p>
  </div>
  <div class="">
	<p class="o_f ">
	  <span class="pull-left">门店电话</span>
	  <span class="pull-right"><?php echo ($order["receive_tel"]); ?></span>
	</p>
	<p>
	  收货地址：<?php echo ($order["address"]); ?>
	</p>
  </div>
</div>
<div class="bundlev bline">
  <p>
  <span class="pull-left">下单时间</span>
  <span class="pull-right"><?php echo (date("Y-m-d H:i:s",$order["create_time"])); ?></span>
  </p>
</div>
<div class="bundlev bline">
  <p>
	<span class="pull-left">订单总金额</span>
	<span class="pull-right price">￥<?php echo (price($order["total_price"])); ?></span>
  </p>
</div>
<div class="bundlev bline">
  <p>
	<span class="pull-left">已核销金额</span>
	<span class="pull-right price">￥<?php echo (price($order["paid_amount"])); ?></span>
  </p>
</div>
<div class="bundlev bline">
  <p>
	<span class="pull-left">未核销金额</span>
	<span class="pull-right price" style="float:right;">￥<?php echo (price($order["discount_price"])); ?></span>
  </p>
</div>

<div class="bundlev bline">
	<p><span class="pull-left">入库仓库</span></p>
	<div class="box_flex">
		<select id="warehouse" class="col-xs-12 form-control" name="warehouse" style="margin:3px 0 3px 10px;">
			<option value="0">--请选择入库仓库--</option>
			<?php if(is_array($warehouse_list)): foreach($warehouse_list as $key=>$wl): ?><option value="<?php echo ($wl["id"]); ?>"><?php echo ($wl["warehouse_name"]); ?></option><?php endforeach; endif; ?>
		</select>
	</div>  
</div>
<div class="bundlev bline">
	<p><span class="pull-left">退货人员</span></p>
	<div class="box_flex">
		<select id="user_id" class="col-xs-12 form-control" name="user_id" style="margin:3px 0 3px 10px;">
			<option value="0">--请选择退货人员--</option>
			<?php if(is_array($employee_list)): foreach($employee_list as $key=>$el): ?><option value="<?php echo ($el["id"]); ?>"><?php echo ($el["name"]); ?></option><?php endforeach; endif; ?>
		</select>
	</div>  
</div>

<div class="bundlev bline" style="display:none;">
	<p><span class="pull-left">退款类型</span></p>
	<div class="box_flex">
		<select id="refund_money_type" class="col-xs-12 form-control" name="refund_money_type" style="margin:3px 0 3px 10px;">
			<option value="0">--请选择退款类型--</option>
			<option value="1">退钱</option>
			<option value="2">核销</option>
			<option value="3">预存款</option>
		</select>
	</div>  
</div>

<div class="bundlev bline" style="display: none;">
	<p><span class="pull-left">退款账号</span></p>
	<div class="box_flex">
		<select id="refund_account" class="col-xs-12 form-control" name="refund_account" style="margin:3px 0 3px 10px;">
			<option value="0">--请选择退款账号--</option>
			<?php if(is_array($account)): foreach($account as $key=>$a): ?><option value="<?php echo ($a["id"]); ?>"><?php echo ($a["bank_name"]); ?></option><?php endforeach; endif; ?>
		</select>
	</div>  
</div>

<div class="receiptbox" style="display:none;">
	<div class="bundlev bline" id="chooseOrder" onclick="bomb_screen()"> 
		<p><span class="pull-left">核销订单</span></p>
		<div class="pull-right">                   
			<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
		</div>  
	</div>
	<div class="bundlev bline">
	  	<p>
	  		<span class="pull-left">核销单号</span>
	  		<span class="pull-right"></span>
	  	</p>
	</div>
	
	<div class="bundlev bline">
		<p><span class="pull-left">结算方式</span></p>
		<div class="box_flex">
			<select id="payment" class="col-xs-12 form-control" name="payment" style="margin:3px 0 3px 10px;">
				<option value="0">--请选择结算方式--</option>
				<?php if(is_array($payments)): foreach($payments as $key=>$a): ?><option value="<?php echo ($key); ?>"><?php echo ($a); ?></option><?php endforeach; endif; ?>
			</select>
		</div>  
	</div>
	<div class="bundlev bline">
		<p><span class="pull-left">结算账号</span></p>
		<div class="box_flex">
			<select id="receipt_account" class="col-xs-12 form-control" name="receipt_account" style="margin:3px 0 3px 10px;">
				<option value="0">--请选择结算账号--</option>
				<?php if(is_array($account)): foreach($account as $key=>$a): ?><option value="<?php echo ($a["id"]); ?>"><?php echo ($a["bank_name"]); ?></option><?php endforeach; endif; ?>
			</select>
		</div>  
	</div>
	<div class="bundlev bline">
		<p><span class="pull-left" style="width:56px;">收款人</span></p>
		<div class="box_flex">
			<select id="payee" class="col-xs-12 form-control" name="payee" style="margin:3px 0 3px 10px;">
				<option value="0">--请选择收款人--</option>
				<?php if(is_array($account)): foreach($account as $key=>$a): ?><option value="<?php echo ($a["id"]); ?>"><?php echo ($a["account"]); ?></option><?php endforeach; endif; ?>
			</select>
		</div>  
	</div>
	<div class="bundlev bline">
       	<p>
      		<span class="pull-left">本次核销金额</span>
      	</p>
      	<input type="number" name="this_paid_money" id="this_paid_money" readonly class="form-control pull-left" style="margin: 3px 0 3px 10px;width:auto;" value="0">
    </div>
</div>
<div class="bundlev bline" style="display: none;">
  <p>
	<span class="pull-left">充值金额</span>
  </p>
  <input type="number" name="recharge_money" id="recharge_money" readonly class="form-control pull-left" style="margin: 3px 0 3px 10px;width:auto;" value='0'>
</div>


<!-- <div class="bundlev bline">
  <p>
	<span class="pull-left">本次退款：</span>
	<span class="pull-right price">￥:0.00</span>
  </p>
</div> -->

<div class="bundlev bline" style="display: none;">
  <p>
	<span class="pull-left">本次退款</span>
  </p>
  <input type="number" name="refund_money" id="refund_money" readonly class="form-control pull-left" style="margin: 3px 0 3px 10px;width:auto;" value='0'>
</div>

<div class="bundlev" style="padding: 0">
	<input type="text" name="refund_remark" id="refund_remark" placeholder="退货备注：此处填写退货备注" class="form-control">
</div>

<div class="bundlev bline">
  <p>
  <span class="pull-left">本次退款</span>
  <span class="pull-right price">￥<span class="this_refund_money">0</span></span>
  </p>
</div>

<div class="bundlev bline">
  <p>
  <span class="pull-left">退货剩余金额</span>
  <span class="pull-right price">￥<span class="refund_remains_money">0</span></span>
  </p>
</div>

<div style="height:48px;"></div>
<div class="sift_bottom">
  <a href="javascript:;" onclick="refund_confirm(this)" class="btn-block">确认退货</a>
</div>


<!-- 选择商品 -->
<div class="bomb_screen">
	<div class="topsearch col-xs-12 box_flex">
		<div class="flex1 searchtab">
			<span></span>
			<input type="text" class="form-control enter-search" id="keyword" value="" placeholder="请输入商品名称">
		</div>
		<div class="searchbtn">
			<button>搜索</button>
		</div>
	</div>
	<div class="screen">
		<div class="col-xs-6 sepline"><a href="javascript:;" id="comprehensive">综合排序 <span class="arrowico"></span></a></div>
		<div class="col-xs-6 js-trigger">筛选 <span class="screenico"></span></div>

		<div class="sort_sele">
			<p class="ptick tick" onclick="mob.setSort(0,this)"><a href="javascript:;">综合排序</a><span></span></p>
			<p class="ptick" onclick="mob.setSort(1,this)"><a href="javascript:;">金额从低到高</a><span></span></p>
			<p class="ptick" onclick="mob.setSort(2,this)"><a href="javascript:;">金额从高到低</a><span></span></p>
			<p class="ptick" onclick="mob.setSort(3,this)"><a href="javascript:;">时间从高到低</a><span></span></p>
			<p class="ptick" onclick="mob.setSort(4,this)"><a href="javascript:;">时间从低到高</a><span></span></p>
		</div>

		<div class="sort_sele2">
			<ul class="metismenu " id="menu">
			<?php if(is_array($class_list)): $i = 0; $__LIST__ = $class_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><li>
					<a href="#">
						<i class="fa fa-circle-o"></i>
						<?php echo ($c["c_name"]); ?>
						<span class="fa arrow fa-fw"></span>
					</a>
					<ul aria-expanded="false" class="collapse">
					  <?php if(is_array($c['item'])): $i = 0; $__LIST__ = $c['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ci): $mod = ($i % 2 );++$i;?><li <?php if($ci["id"] == $class_id): ?>class="select"<?php endif; ?> onclick="set_class('<?php echo ($ci["id"]); ?>',this)">
								<a href="javascript:;" class="present"><?php echo ($ci["class_name"]); ?> <i class="fa fa-angle-right pull-right"></i></a>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>                 
					</ul>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			
			<!-- 导航插件 -->
			<script type="text/javascript" src="__PUBLIC__/js/metisMenu.js"></script>
			<script>
				$(function () {
					$('#menu').metisMenu();
				});
			</script>

		</div>
	</div>
	<div class="reserve_tab" id="CarWash">
		

	</div>

	<div style="height:90px; clear:both;"></div>
	<div class="col-xs-12 row" style=" position: fixed; bottom: 5px; background: #fff; padding-bottom: 10px;">
		<button class="btn btn-lg btn-block btn-danger" style="margin-left: 15px;" id="confirm-button" onclick="confirm()">确定</button>
	</div>

	<input type="hidden" id="sort" value="0">
	<input type="hidden" id="attr_value" value="">
</div>


<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script>

</body>
</html>
<script type="text/javascript">
$(function(){

	//初始化
	sumTotalPrice();
    var goods_len = $('.productlist').find('.goods_item').length;
    //单选按钮点击事件
    $('.productlist').find('.goods_item').each(function(){
	    var that = $(this);
	    that.click(function(){
			that.toggleClass('tickico').toggleClass('tickNull');
			if(!that.hasClass('tickico')){
	  			$('#select_all').removeClass('tickico').addClass('tickNull');
			}
			if(goods_len == $('.productlist').find('.tickico').length){
	  			$('#select_all').removeClass('tickNull').addClass('tickico');
			}
			sumTotalPrice(); 
			handleData();
	    });
    });

    //全选、取消全选
    $('#select_all').click(function(){
		$(this).toggleClass('tickico').toggleClass('tickNull');
		if($(this).hasClass('tickico')){
			$('.productlist').find('.goods_item').each(function(){
				$(this).removeClass('tickNull').addClass('tickico');
			});
		}else{
			$('.productlist').find('.goods_item').each(function(){
				$(this).removeClass('tickico').addClass('tickNull');
			});
		}
		sumTotalPrice();
		handleData();
  	});

  function handleData(){
	// var _needreturn = $('#refund_total_price').text();
	var _payamount = $('#paid_money').val();
	var _needreturn = $('.refund_remains_money').text();
	if($('#refund_money_type').val() == 1){
	  if(Number(_needreturn) <= Number(_payamount) && Number(_needreturn) > 0)
		  $('#refund_money').val(_needreturn);
	  else if(Number(_needreturn) > Number(_payamount))
		  $('#refund_money').val(_payamount);
	}else if($('#refund_money_type').val() == 3){
	  if(Number(_needreturn) <= Number(_payamount))
		  $('#recharge_money').val(_needreturn);
	  else
		  $('#recharge_money').val(_payamount);
	}
  }

  $('#refund_money_type').change(function(){
	var typeValue = $(this).val();
	if(typeValue == 1){
	  	$('#refund_account').parent().parent().show();
	  	$('#refund_money').parent().show();
	  	$('#recharge_money').parent().hide();
	  	$('#chooseOrder').parent().hide();
	  	$('#recharge_money').val(0);
    	$('#CarWash').find('.goods_item').removeClass('tickico').addClass('tickNull');
	}else if(typeValue == 2){
	  	$('#chooseOrder').parent().show();
	  	$('#refund_account').parent().parent().hide();
	  	$('#refund_money').parent().hide();
	  	$('#recharge_money').parent().hide();
	  	$('#refund_money').val(0);
	  	$('#recharge_money').val(0);
	  	$('#refund_account').val(0);
	}else if(typeValue == 3){
	  	$('#recharge_money').parent().show();
	  	$('#chooseOrder').parent().hide();
	  	$('#refund_account').parent().parent().hide();
	  	$('#refund_money').parent().hide();
	  	$('#refund_money').val(0);
	  	$('#refund_account').val(0);
    	$('#CarWash').find('.goods_item').removeClass('tickico').addClass('tickNull');
	}else{
	  	$('#recharge_money').parent().hide();
	  	$('#chooseOrder').parent().hide();
	  	$('#refund_account').parent().parent().hide();
	  	$('#refund_money').parent().hide();
	  	$('#refund_money').val(0);
	  	$('#recharge_money').val(0);
	  	$('#refund_account').val(0);
    	$('#CarWash').find('.goods_item').removeClass('tickico').addClass('tickNull');
	}

	handleData();

  });
})

//获得退货商品信息和商品总价
function sumTotalPrice(){
  	//订单总价
  	var total_price = Number($('#total_price').val());
  	//已核销金额
  	var paid_amount = Number($('#paid_money').val());
	var goods_arr = [];
	var goods_arr_gift = [];
	var total = 0;
	$.each($('.productlist').find('.tickico'),function(i,v){

		var goods_num  = $(this).parent().parent().find('.d-main').find('.pull-right').attr('data-num');
		var goods_id   = $(this).attr('data-val');
		if($(this).hasClass('gift')){
			var goods_gift = {num:0,gid:0};
			goods_gift.num = goods_num;
			goods_gift.gid = goods_id;
			goods_arr_gift.push(goods_gift);
		}else{
			var goods       = {price:0,num:0,gid:0};
			var goods_price = $(this).parent().parent().find('.d-main').find('.price').attr('data-price');
			// var goods_num   = $(this).parent().parent().find('.d-main').find('.pull-right').attr('data-num');
			// var goods_id    = $(this).attr('data-val');
			goods.price     = goods_price;
			goods.num       = goods_num;
			goods.gid       = goods_id;
			total += goods_price * goods_num;
			goods_arr.push(goods);
		}
	});
  	$('#refund_total_price').text(total);
  	$('.this_refund_money').text(total);
	$('.refund_remains_money').text(total+paid_amount-total_price);
	if(total+paid_amount-total_price > 0)
		$('#refund_money_type').parent().parent().show();
	else
		$('#refund_money_type').parent().parent().hide();

	// return goods_arr;
	return {goods_arr:goods_arr,goods_arr_gift:goods_arr_gift};
}


// 弹框选取核销订单
function bomb_screen(){

	if($('#refund_money_type').val() == 0){
		MsgBox('请先选择退款类型');
		return false;
	}

	$('.bomb_screen').slideToggle(1);

	$('.drawer').drawer();
	$('.js-trigger').click(function(){
		$(".sort_sele2").hide();
		$(".sort_sele").hide();
		$('.drawer').drawer("open");
	});  

	var keyword   = $('#keyword').val(),
    attr_value  = $('#attr_value').val(),
    sort        = $('#sort').val();
    location_id = $('#location_id').val();
    order_id    = $('#order_id').val();
	var dataInfo = {keyword:keyword,attr_value:attr_value,sort:sort,location_id:location_id,order_id:order_id};
	mob.init("<?php echo U('SupMember/order_refund_search');?>","#CarWash",dataInfo);

	//搜索
	$('.searchbtn button').on('click',function(){
		mob.ajaxSearch();
	});

	//属性重置
	$('#reset_attr').click(function(){
		mob.resetAttr();
	});

	//筛选确定
	$('.sift-btn-ok').click(function(){
		mob.sendData.currentpage = 0;
		mob.sendData.keyword     = $('#keyword').val();
		mob.sendData.attr_value  = $('#attr_value').val();
		mob.sendData.sort        = $('#sort').val();
		mob.ajaxGetResults(mob.sendData);

	});


}

// 选择核算订单
function confirm(){
	mob.stop = false;
	$('.bomb_screen').slideToggle(1);
  	var info = getReceiptOrder();
  	if(false !== info){
    	$('#chooseOrder').next().find('.pull-right').text(info.order_sn);
    	$('#this_paid_money').val($('.refund_remains_money').text());
  	}
}

// 核销订单
function receipt_submitForm(){
    // var total = getPayPrice();
	var receipt_order    = getReceiptOrder();
	var surplus_price    = $(".refund_remains_money").text() * 1;
	var receipt_order_id = $('#CarWash').find('.tickico').attr('data-val');
	var price            = $('#this_paid_money').val();
	var account          = $('#receipt_account').val();
	var payment          = $('#payment').val();
	var payee            = $('#payee').val();
	var employee         = $('#payee').find('option:selected').text();
	if(payee == 0)
		employee = '';
	if(Number($('#paid_money').val()) <= 0 || surplus_price <= 0 ){
		MsgBox('请先支付再核销');
		return false;
	}
	if(typeof(receipt_order_id) == 'undefined')
	  receipt_order_id = 0;
	if(receipt_order_id == 0)
		MsgBox('请选择需要核销的订单');

    if(surplus_price > receipt_order.unpay){
        MsgBox('核销金额不能大于未核销金额');
        return false;
    }

    var args = {
        token: 'refund',
        id: receipt_order.receipt_order_id,
        remark: '退货核销',
        payment: [payment],
        account: [account],
        price: [price],
        payee: [payee],
        employee: [employee]
    };


    if(price <= 0){
        MsgBox('请填写核销金额');
        return false;
    }

    if(price != surplus_price){
        MsgBox('核销金额必须等于退货剩余金额');
        return false;
    }

    $.post('<?php echo U("SupOrder/receipt");?>', args, function(data) {

        if(data && typeof(data.status) != 'undefined'){
            if(data.status * 1 > 0){
                MsgBox('核销成功');
                return true;
            }
            else{
                MsgBox('核销失败');
                return false;
            }
        }
        else{
            MsgBox('核销失败');
            return false;
        }
    },'json');
}

//充值提交
function recharge_submitForm(money){
	var args = {
        type:1,
        account:$("#location_name").val(),
        location_name:$("#location_name").val(),
        location_id:$("#location_id").val(),
        recharge_amount:money,
        remark:'门店退货,预存款充值'
	}; 
    $.post('<?php echo U("SupMember/recharge");?>', args, function(data) {
        if (data.status == 1) {
            MsgBox(data.msg);
            return true;
        } else {
            MsgBox(data.msg);
            return false;
        }
    },'json');
}
//核算订单信息
function getReceiptOrder(){
  var param = new Object();
  var receipt = $('#CarWash').find('.tickico');
  if(receipt.length == 0){
    return false;
  }
  param.receipt_order_id = receipt.attr('data-val');
  param.order_sn = receipt.parent().parent().find('span').text().trim();
  param.total_price = receipt.attr('data-price');
  param.paid_amount = receipt.attr('data-paid');
  param.unpay = receipt.attr('data-unpay');
  return param;
}

//确认退货
function refund_confirm(_this){
	var goodsArr = sumTotalPrice();
	var btn = $(_this);
	var text = btn.text();
	var receipt_order_id = $('#CarWash').find('.tickico').attr('data-val');
	if(typeof(receipt_order_id) == 'undefined')
	  receipt_order_id = 0;
	args = {
	  id:$('#order_id').val(),
	  user_id:$('#user_id').val(),
	  user_name:$('#user_id').find('option:selected').text().trim(),
	  remark:$('#refund_remark').val(),
	  goods_list:goodsArr.goods_arr,
	  goods_list_gift:goodsArr.goods_arr_gift,
	  warehouse_id:$('#warehouse').val(),
	  //退款类型
	  refund_money_type:$('#refund_money_type').val(),
	  //核销订单id
	  receipt_order_id:receipt_order_id,
	  //退款账户
	  refund_account:$('#refund_account').val(),
	  //退款金额
	  refund_money:$('#refund_money').val(),
	  //充值金额
	  recharge_money:$('#recharge_money').val()
	}
	if(args.warehouse_id == 0){
		MsgBox('请选择入库仓库');
		return false;
	}
	if(args.goods_list.length == 0){
		MsgBox('请选择退货商品');
		return false;
	}
	if(args.user_id == 0){
		MsgBox('请选择退货人员');
		return false;
	}
	if(Number($('.refund_remains_money').text()) > 0 && args.refund_money_type == 0){
		MsgBox('请选择退款类型');
		return false;
	}
	if($('#refund_money_type').val() == 1 && Number($('.refund_remains_money').text()) > 0){
	    if($('#refund_account').val() == 0){
			MsgBox('请选择退款账号');
	      	return false;
	    }
    }
	if($('#refund_money_type').val() == 3 && Number($('#recharge_money').val()) > 0){
	    var res = recharge_submitForm(args.recharge_money);
	    if(false == res)
	      return false;
    }
    if($('#refund_money_type').val() == 2 && Number($('#this_paid_money').val()) > 0){
	    var result = receipt_submitForm();
	    if(false == result)
	      return false;
    }else if($('#refund_money_type').val() == 2 && Number($('#this_paid_money').val()) <= 0){
    	MsgBox('请选择核销订单');
		return false;
    }

	btn.attr('disabled',true).text('正在处理');
	$.post('<?php echo U("SupMember/refund_save");?>', args, function(data) {
		btn.removeAttr('disabled').text(text);
		if(data.status == 1){
			MsgBox(data.msg);
			location.href = '<?php echo U("SupMember/order_refund");?>';
		}else{
			MsgBox(data.msg);
		}
	});
}
</script>