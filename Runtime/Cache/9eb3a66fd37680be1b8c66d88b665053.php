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
.work_order_top{padding:5px 15px; color: #fff; font-size: 25px; position:relative;}
.work_order_top a{color: #fff;}

.tab_parent{padding-left: 15px;}
.tab_subset{margin:0; padding: 0 15px 0 0;}

/*筛选框*/
.screen_btn{ font-size: 16px;}
.screen_btn span,.tuichuico{display: inline-block; width: 24px; height: 19px;vertical-align: middle;}
.screen_btn span{background: url(__PUBLIC__/images/bossico.svg) no-repeat 6px 0; background-size: 76px;}
.tuichuico{background: url(__PUBLIC__/images/bossico.svg) no-repeat -51px -1px; background-size: 95px;}

.screenbox{ position: absolute; width: 100%; padding:10px; top: 50px; left: 0; color: #4C4C4C; font-size: 14px; background:#fff; display: none; border-bottom: 1px solid #eee;z-index: 1;}
.screenbox dl{margin-bottom: 3px;}
.screenbox dt{margin-right: 10px;line-height: 30px;}
.screenbox dd{padding-left: 40px;}
.screenbox a{padding:4px 10px;display: inline-block; border:1px solid #eee; color:#4C4C4C; margin-bottom: 5px;margin-right: 7px;}
.screen_cur{background: #FF962A;border:1px solid #FF962A !important; color: #fff !important;}

/*主要数据*/
.main_data{ background: #E93131; padding: 15px 0; overflow: hidden; color: #fff; }
.data_tab{padding: 30px 0 0 0; width: 150px; margin:15px auto;  height: 150px; border-radius: 50%; border: 1px solid #FFFFFF; background-color: #f33636;}
.data_tab h4{color: #ffe400; font-size: 24px;font-weight: bold;}
.data_tab a,.datah a{color: #fff; display:block;text-decoration: blink;}
.box-flex{ display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox;  display: flex; }
.flex1{-webkit-box-flex: 1;-moz-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;}
.data_b_r{border-right: 1px solid #ff7575;}
.datah{padding-top: 5px;}
.datah p,.turnover p{font-size: 12px;}
.datah h5{font-size: 16px; color: #ffe400; font-weight: bold;}
.turnover h5{font-size: 20px; color: #ff3e3e; font-weight: bold;margin-bottom: 4px}
.turnover{padding: 7px 0;}
.data_rb{border-right:1px solid #eee;}

.data_btn span{display: block;width: 50px;height: 50px; margin: 15px auto 7px auto; border-radius: 50%;}
.da_btn1{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat 2px 5px;background-size: 196px;background-color: #eec82f;}
.da_btn2{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -44px 5px;background-size: 196px;background-color: #ff7376;}
.da_btn3{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -142px 5px;background-size:206px;background-color: #9ad264;}
.da_btn4{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -51px -53px;background-size:220px;background-color:#7CD6C8;}
.da_btn5{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -2px -57px;background-size:230px;background-color: #E489DA;}
.da_btn6{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -107px -56px;background-size: 230px;background-color: #88AFF3;}
.da_btn7{ background: url(__PUBLIC__/images/commission.svg) no-repeat 8px 7px;background-size: 34px;background-color:#88AFF3;}

.da_btn8{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -160px -56px;background-size: 230px;background-color:#88AFF3;}
.da_btn9{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -2px -104px;background-size: 230px;background-color:#F3B088;}
.da_btn10{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -55px -103px;background-size: 230px;background-color:#9B88CA;}
.da_btn11{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -108px -104px;background-size: 230px;background-color:#f99994;}
.da_btn12{ background: url(__PUBLIC__/images/purchase.svg) no-repeat 8px 7px;background-size: 34px;background-color:#ffb861;}
.da_btn13{ background: url(__PUBLIC__/images/purchase_order.svg) no-repeat 8px 7px;background-size: 34px;background-color:#7ec7f7;}
.da_btn14{ background: url(__PUBLIC__/images/shop.svg) no-repeat 8px 7px;background-size: 34px;background-color:#6ce897;}
.da_btn15{ background: url(__PUBLIC__/images/authorize.svg) no-repeat 8px 7px;background-size: 34px;background-color:#34c566;}
.da_btn16{ background: url(__PUBLIC__/images/bossico2.svg) no-repeat -164px -104px;background-size: 230px;background-color:#79cae9;}
</style>

<!--弹出提示框-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<!-- 顶部筛选 刷新 -->
<div class="container-fluid topbox">
    <div class="row top work_order_top">
        <a href="javascript:;" class="screen_btn"><?php echo ($n_location_name); ?><span></span></a>
        <div class="screenbox">
            <dl>
                <dt class="pull-left">门店</dt>
                <dd>
                  <a href="<?php echo U('Biz/shop_count');?>" <?php if($n_location_id == null): ?>class="screen_cur"<?php endif; ?>>全部</a>
                  <?php if(is_array($location_names)): foreach($location_names as $key=>$ln): ?><a href="<?php echo U('Biz/shop_count',array('id'=>$ln['id']));?>" <?php if($n_location_id == $ln['id']): ?>class="screen_cur"<?php endif; ?>><?php echo ($ln["name"]); ?></a><?php endforeach; endif; ?>
                </dd>
            </dl>
        </div>
        <a  href="<?php echo U('Biz/login_out');?>" class="pull-right"><span class="tuichuico"></span></a>
    </div>
</div>
<script type="text/javascript" src="__PUBLIC__/js/countUp.min.js"></script>

<div class="main_data text-center">
    <div><span>今日</span></div>

    <div class="row tab_parent" >
        <div class="col-xs-6 tab_subset">
            <div class="data_tab">
                <a onclick="window.document.location.reload();">
                    <p>营业额</p>
                    <h4><span id="total_price"><?php echo (price($project_today_deal[0]["total_price"])); ?></span></h4>
                    <span>元</span>
                </a>
            </div>
        </div>
        <div class="col-xs-6 tab_subset">
            <div class="data_tab">
                <a onclick="window.document.location.reload();">
                    <p>实收金额</p>
                    <h4><span id="today_received"><?php echo (price($today_received)); ?></span></h4>
                    <span>元</span>
                </a>
            </div>
        </div>
    </div>

    <div class="box-flex">
        <div class="flex1 datah data_b_r">
            <a href="javascript:;">
                <p>今日车辆</p>
                <h5><span id="today_count"><?php echo ($project_today_deal[0]["today_count"]); ?></span></h5>
            </a>
        </div>
        <div class="flex1 datah data_b_r">
            <a href="javascript:;">
                <p>今日扫码</p>
                <h5><span id="member_bind_count"><?php echo ($member_bind_count); ?></span></h5>
            </a>
        </div>
         <div class="flex1 datah data_b_r">
            <a href="javascript:;">
                <p>新增客户</p>
                <h5><span id="today_member_count"><?php echo ($today_member_count); ?></span></h5>
            </a>
        </div>
        <div class="flex1 datah ">
            <a href="javascript:;">
                <p>售卡金额</p>
                <h5><span id="card_sum_total_price"><?php echo (price($card_sum_total_price)); ?></span></h5>
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
<script type="text/javascript">
    var options = {
      useEasing : true,
      useGrouping : true,
      separator : ',',
      decimal : '.',
      prefix : '',
      suffix : ''
    };

var total_price = new CountUp("total_price", 0,<?php echo (price($project_today_deal["total_price"])); ?>, 2, 1.5, options);
total_price.start();

var today_received = new CountUp("today_received", 0,<?php echo (price($today_received)); ?>, 2, 1.5, options);
today_received.start();

var today_count = new CountUp("today_count", 0,<?php echo ($project_today_deal["count"]); ?>,0, 1.5, options);
today_count.start();

var member_count_sum = new CountUp("member_count_sum", 0,<?php echo ($member_count_sum); ?>,0, 1.5, options);
member_count_sum.start();

var member_bind_count = new CountUp("member_bind_count", 0,<?php echo ($member_bind_count); ?>,0, 1.5, options);
member_bind_count.start();

var card_sum_total_price = new CountUp("card_sum_total_price", 0,<?php echo (price($card_sum_total_price)); ?>,2, 1.5, options);
card_sum_total_price.start();

var this_week_total = new CountUp("this_week_total", 0,<?php echo (price($this_week_total)); ?>,2, 1.5, options);
this_week_total.start();

var this_moon_total = new CountUp("this_moon_total", 0,<?php echo (price($this_moon_total)); ?>,2, 1.5, options);
this_moon_total.start();

var today_member_count = new CountUp("today_member_count", 0,<?php echo ($today_member_count); ?>,0, 1.5, options);
today_member_count.start();
</script>

<!--分割线-->
<div class="container-fluid line" ></div>


<!--<div class="box-flex text-center">
    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Purchase/home');?>">
            <span class="da_btn12"></span>
            <p>批发采购</p>
        </a>
    </div>
     <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/purchase_order',array('id'=>$n_location_id));?>">
            <span class="da_btn13"></span>
            <p>采购订单</p>
        </a>
    </div>
    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Store/view',array('id'=>$n_location_id));?>">
            <span class="da_btn14"></span>
            <p>我的商城</p>
        </a>
    </div>

</div>-->




<hr style="margin:0;">





    <!--<div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/location',array('id'=>$n_location_id));?>">
            <span class="da_btn9"></span>
            <p>发展门店</p>
        </a>
    </div>
    <div class="flex1 data_btn">
        <a href="<?php echo U('Biz/myagent',array('id'=>$n_location_id));?>">
         <span class="da_btn10"></span>
         <p>代理推广</p>
        </a>
    </div>

    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/erp_verify',array('id'=>$n_location_id));?>">
            <span class="da_btn6"></span>
            <p>预约验证</p>
        </a>
    </div> -->


<hr style="margin:0;">
<div class="box-flex text-center">
    <!-- <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/income',array('id'=>$n_location_id));?>">
            <span class="da_btn8"></span>
            <p>代理收入</p>
        </a>
    </div> -->
     <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/today_pay_type',array('id'=>$n_location_id));?>">
            <span class="da_btn4"></span>
            <p>今日营业</p>
        </a>
    </div>
    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/month_plan',array('id'=>$n_location_id));?>">
            <span class="da_btn5"></span>
            <p>月度计划</p>
        </a>
    </div>
     <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/employee_commission',array('id'=>$n_location_id));?>">
         <span class="da_btn7"></span>
         <p>员工提成</p>
        </a>
    </div>
</div>
<hr style="margin:0;">
<div class="box-flex text-center">
   
     <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/pay_type',array('id'=>$n_location_id));?>">
            <span class="da_btn3"></span>
            <p>支付方式</p>
        </a>
    </div>
    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/sell_card',array('id'=>$n_location_id));?>">
            <span class="da_btn1"></span>
            <p>售卡分析</p>
        </a>
    </div>
     <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/project_deal',array('id'=>$n_location_id));?>">
            <span class="da_btn2"></span>
            <p>类目成交</p>
        </a>
    </div>
</div>
<hr style="margin:0">
<div class="box-flex text-center">
   
    <!-- <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/authorize',array('id'=>$n_location_id));?>">
            <span class="da_btn15"></span>
            <p>推送授权</p>
        </a>
    </div> -->
    <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/reservation_list',array('id'=>$n_location_id));?>">
            <span class="da_btn16"></span>
            <p>预约列表</p>
        </a>
    </div>
     <div class="flex1 data_btn data_rb">
        <a href="<?php echo U('Biz/shaidan',array('id'=>$n_location_id));?>">
            <span class="da_btn11"></span>
            <p>门店晒单</p>
        </a>
    </div>
    <div class="flex1 data_btn ">
        <a href="">

        </a>
    </div>
</div>

<hr style="margin:0">



<!---->
<script type="text/javascript" src="http://s.17cct.com/v5/js/erp/echarts.common.min.js"></script>
<!--分割线-->
<div class="container-fluid line" ></div>

<div class="panel-body">
    <div id="main" style="height:400px;"></div>
</div>

<!--底栏-->
<!--底栏-->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/font-awesome/css/font-awesome.min.css">
<div style=" height: 50px;  clear: both;"></div>
<div class="container-fluid">
    <div class="bottombtn">
        <div class="col-xs-4"><a href="<?php echo U('Biz/entrance');?>" class="b_btn"><i class="fa fa-home"></i><div>首页</div></a></div>
        <div class="col-xs-4"><a href="<?php echo U('Biz/shop_count');?>"><i class="fa fa-desktop"></i><div>管理</div></a></div>
        <div class="col-xs-4"><a href="http://www.vzan.com/f/s-707026"><i class="fa fa-users"></i><div>社区</div></a></div>
    </div>
</div>

   <script type="text/javascript">
            $(document).ready(function(){
                $(".screen_btn").click(function(){
                    $(".screenbox").slideToggle(200);
                });
            })
       var myChart=echarts.init(document.getElementById('main'));
         option = {
            title: {
                text: '交易走势图'
            },dataZoom:{
                orient:"horizontal", //水平显示
                show:true, //显示滚动条
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:[]
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : ['1月', '2月', '3月', '4月', '5月', '6月','7月', '8月', '9月', '10月', '11月', '12月']
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'服务下单数量(单)',
                    type:'line',
                    stack: '总量',
                    areaStyle: {normal: {}},
                    data:[<?php echo ($order_data); ?>]
                },
                {
                    name:'项目交易(￥)',
                    type:'line',
                    stack: '总量',
                    areaStyle: {normal: {}},
                    data:[<?php echo ($price_data); ?>]
                },
                {
                    name:'客户数量(个)',
                    type:'line',
                    stack: '总量',
                    areaStyle: {normal: {}},
                    data:[<?php echo ($member_data); ?>]
                },
                {
                    name:'扫码数量(个)',
                    type:'line',
                    stack: '总量',
                    areaStyle: {normal: {}},
                    data:[<?php echo ($member_bind_data); ?>]
                },
                {
                    name:'售卡数量(张)',
                    type:'line',
                    stack: '总量',
                    areaStyle: {normal: {}},
                    data:[<?php echo ($card_data); ?>]
                },
                {
                    name:'售卡金额(￥)',
                    type:'line',
                    stack: '总量',
                    areaStyle: {normal: {}},
                    data:[<?php echo ($card_price); ?>]
                },
                {
                    name:'套餐销售数量(个)',
                    type:'line',
                    stack: '总量',
                    areaStyle: {normal: {}},
                    data:[<?php echo ($package_data); ?>]
                },
                {
                    name:'套餐销售金额(￥)',
                    type:'line',
                    stack: '总量',
                    areaStyle: {normal: {}},
                    data:[<?php echo ($package_price); ?>]
                },
                {
                    name:'总交易额(￥)',
                    type:'line',
                    stack: '总量',
                    areaStyle: {normal: {}},
                    data:[<?php echo ($total_price); ?>]
                }
            ]
    };
    myChart.setOption(option);
     window.onresize = myChart.resize;
        </script>
</body>
</html>