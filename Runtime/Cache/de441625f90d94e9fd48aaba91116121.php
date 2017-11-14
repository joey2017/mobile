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
<script type="text/javascript" src="http://s.17cct.com/v5/js/erp/echarts.common.min.js"></script>
<style type="text/css">
.work_order_top{padding:5px 15px; color: #fff; font-size: 25px; position:relative;}
.work_order_top a{color: #fff;}

/*筛选框*/
.screen_btn{ font-size: 16px;}
.screen_btn span,.tuichuico{display: inline-block; width: 24px; height: 19px;vertical-align: middle;}
.screen_btn span{background: url(__PUBLIC__/images/bossico.svg) no-repeat 6px 0; background-size: 76px;}
.tuichuico{background: url(__PUBLIC__/images/bossico.svg) no-repeat -51px -1px; background-size: 95px;}

.screenbox{ position: absolute; width: 100%; padding:10px; top: 50px; left: 0; color: #4C4C4C; font-size: 14px; background:#fff; display: none; border-bottom: 1px solid #eee;z-index: 90;}
.screenbox dl{margin-bottom: 3px;}
.screenbox dt{margin-right: 10px;line-height: 30px;}
.screenbox dd{padding-left: 40px;}
.screenbox a{padding:4px 10px;display: inline-block; border:1px solid #eee; color:#4C4C4C; margin-bottom: 5px;margin-right: 7px;}
.screen_cur{background: #FF962A;border:1px solid #FF962A !important; color: #fff !important;}

</style>


<!-- 顶部筛选 刷新 -->
<div class="container-fluid topbox">
    <div class="row top work_order_top">
        <a href="javascript:;" class="screen_btn"><?php echo ($n_location_name); ?><span></span></a>
        <div class="screenbox">
            <dl>
                <dt class="pull-left">门店</dt>
                <dd>
                     <a href="<?php echo U('Biz/month_plan');?>" <?php if($n_location_id == null): ?>class="screen_cur"<?php endif; ?>>全部</a>
                  <?php if(is_array($location_names)): foreach($location_names as $key=>$ln): ?><a href="<?php echo U('Biz/month_plan',array('id'=>$ln['id']));?>" <?php if($n_location_id == $ln['id']): ?>class="screen_cur"<?php endif; ?>><?php echo ($ln["name"]); ?></a><?php endforeach; endif; ?>
                </dd>
            </dl>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".screen_btn").click(function(){
                    $(".screenbox").slideToggle(200);
                });
            })
        </script>
        <a onclick="window.document.location.reload();" class="pull-right"><span class="refreshico"></span></a>
    </div>
</div>

<div class="row" style="margin:10px;margin-left:20px;">
    <div style="float:left; margin-right:10px;width:45%;">
        <select class="form-control" id="years" name="years">
            <option value="2016">2016年</option>
            <option value="2017">2017年</option>
            <option value="2018">2018年</option>
            <option value="2019">2019年</option>
            <option value="2020">2020年</option>
        </select>
        <input type="hidden" id="select_years" value="<?php echo ($select_years); ?>"> 
    </div>
    <div style="float:left; margin-right:10px;width:45%;">
        <select class="form-control" id="months" id="months">
            <option value="01">1月</option>
            <option value="02">2月</option>
            <option value="03">3月</option>
            <option value="04">4月</option>
            <option value="05">5月</option>
            <option value="06">6月</option>
            <option value="07">7月</option>
            <option value="08">8月</option>
            <option value="09">9月</option>
            <option value="10">10月</option>
            <option value="11">11月</option>
            <option value="12">12月</option>
        </select>
        <input type="hidden" id="select_months" value="<?php echo ($select_months); ?>"> 
        <input type="hidden" id="store_id" value="<?php echo ($n_location_id); ?>">
    </div>
</div>
 <script type="text/javascript">
            var select_years=$('#select_years').val(),select_months=$('#select_months').val();
            $("#years option[value='"+select_years+"']").prop("selected",true); 
            $("#months option[value='"+select_months+"']").prop("selected",true); 

            $('#years,#months').change(function(){
                var years=$('#years').val(),months=$('#months').val(),id=$('#store_id').val();
                window.location.href="<?php echo U('Biz/month_plan');?>?id="+id+"&years="+years+"&months="+months;
            })
        </script>

<div class="tab_t" style="padding:0 15px;"><h2>月度计划</h2></div>

                <div class="col-sm-12"> 
                    <div class="panel-body">
                        <div id="month_plan" style="height:400px;"></div>
                    </div>
                </div>

                <div class="col-sm-12"> 
                    <div class="panel-body">
                        <div id="total" style="height:300px;"></div>
                    </div>
                </div>


<script type="text/javascript">
 var month_plan=echarts.init(document.getElementById('month_plan')),total=echarts.init(document.getElementById('total'));
  option = {
    title : {
        text: '',
        subtext: ''
    },
    dataZoom:{
        orient:"horizontal", //水平显示
        show:true, //显示滚动条
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
            },
    toolbox: {
        show : true,
        feature : {
            dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data: ["美容项目","精品项目","轮胎项目","快修项目","改装项目","洗车项目","车务项目","保险项目","其他项目"]
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name: '今日交易',
            type: 'bar',
            data: [<?php echo ($today_val[$cate_ids[0]]); ?>,<?php echo ($today_val[$cate_ids[1]]); ?>,<?php echo ($today_val[$cate_ids[2]]); ?>,<?php echo ($today_val[$cate_ids[3]]); ?>,<?php echo ($today_val[$cate_ids[4]]); ?>,<?php echo ($today_val[$cate_ids[5]]); ?>,<?php echo ($today_val[$cate_ids[6]]); ?>,<?php echo ($today_val[$cate_ids[7]]); ?>,<?php echo ($today_val[$cate_ids[8]]); ?>]
        },
        {
            name: '实际营业额',
            type: 'bar',
            data: [<?php echo ($actual_val[$cate_ids[0]]); ?>,<?php echo ($actual_val[$cate_ids[1]]); ?>,<?php echo ($actual_val[$cate_ids[2]]); ?>,<?php echo ($actual_val[$cate_ids[3]]); ?>,<?php echo ($actual_val[$cate_ids[4]]); ?>,<?php echo ($actual_val[$cate_ids[5]]); ?>,<?php echo ($actual_val[$cate_ids[6]]); ?>,<?php echo ($actual_val[$cate_ids[7]]); ?>,<?php echo ($actual_val[$cate_ids[8]]); ?>]
        },
        {
            name: '计划金额',
            type: 'bar',
            data: [<?php echo ($plan_val[$cate_ids[0]]); ?>,<?php echo ($plan_val[$cate_ids[1]]); ?>,<?php echo ($plan_val[$cate_ids[2]]); ?>,<?php echo ($plan_val[$cate_ids[3]]); ?>,<?php echo ($plan_val[$cate_ids[4]]); ?>,<?php echo ($plan_val[$cate_ids[5]]); ?>,<?php echo ($plan_val[$cate_ids[6]]); ?>,<?php echo ($plan_val[$cate_ids[7]]); ?>,<?php echo ($plan_val[$cate_ids[8]]); ?>]
        }
    ]
};
 month_plan.setOption(option);
totaloption = {
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        }, 
        series : [
            {
                name: '交易累计',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:[
                    {value:<?php echo ($plan_sum_val[0]); ?>, name:'本月实际完成金额'},
                    {value:<?php echo ($plan_sum_val[1]); ?>, name:'本月未完成金额'}
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
 total.setOption(totaloption);

 window.onresize = function () {
        month_plan.resize();
        total.resize();
    }
</script>

<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="gwbt" style="height:auto;position: fixed;bottom: 50px">
    <a class="btn-danger" href="<?php echo U('Biz/shop_count',array('id'=>$n_location_id));?>"><i class="fa fa-reply"></i> 返回</a>
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

</body>
</html>