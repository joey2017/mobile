<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html lang="zh-CN"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /><title><?php if($title != null): echo ($title); else: ?>诚车堂-全心全意为车主服务<?php endif; ?></title><meta name="keywords" content="诚车堂,养车网,汽车服务平台,自助保养,汽车保养,汽车养护,汽车美容,钣金喷漆,汽车维修,汽车配件,汽车养护,养车无忧,养车无忧网,一站式汽车保养" /><meta name="description" content="修车养车，上诚车堂，省心，省钱，省时间！诚车堂，致力于为广大车主提供一个在线解决汽车服务问题、满足车主在汽车美容、保养、维修、配件等方面的需求， 服务范围包括汽车美容、汽车保养、汽车养护、钣金油漆、汽车维修等，是中国领先的网上汽车服务平台。诚车堂在努力成为车主们首选汽车服务平台的同时,以'让车主享有便捷、高效、经济的爱车养车生活'为己任，希望在用户心中树立起'修车养车,上诚车堂'的良好口碑。" /><link rel="shortcut icon" href="http://s.17cct.com/favicon.ico" type="image/vnd.microsoft.icon"><link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css"><?php if( $no_include != 1): ?><link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css"><?php endif; ?><link rel="stylesheet" type="text/css" href="__PUBLIC__/css/css.css?v=20150617"><script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script><script type="text/javascript" src="__PUBLIC__/js/bootstrap.min.js"></script><script type="text/javascript" src="__PUBLIC__/js/wap.lazy.min.js"></script><script type="text/javascript" src="__PUBLIC__/js/jquery.cookie.js"></script><script type="text/javascript" src="__PUBLIC__/js/wap_v4_common.js"></script><div id='wx_pic' style='margin:0 auto;display:none;'><img src='http://s.17cct.com/v4/images/pic300.jpg' /></div><script type="text/javascript">document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('showToolbar');
  WeixinJSBridge.call('showOptionMenu');
});
</script><body class="drawer drawer-right"><link rel="stylesheet" href="__PUBLIC__/font-awesome/css/font-awesome.min.css"><link href="__PUBLIC__/css/mobiscroll_date.css" rel="stylesheet" /><script src="__PUBLIC__/js/mobiscroll_date.js" charset="gb2312"></script><script src="__PUBLIC__/js/mobiscroll.js"></script><link rel="stylesheet" href="__PUBLIC__/css/iconfont.css" /><link rel="stylesheet" type="text/css" href="__PUBLIC__/css/text.css"/><script type="text/javascript" src="__PUBLIC__/js/sup.common.js"></script></head><link rel="stylesheet" href="__PUBLIC__/css/drawer.min.css"><style type="text/css">*{font-size: 14px;}

/*导航*/
.sidebarbox{ height: 100%; overflow:auto; }
.metismenu,.metismenu ul{margin:0; padding: 0; list-style: none;}
.metismenu a{padding: 12px 10px; display: block; border-bottom: 1px solid rgb(218, 218, 218); }
.metismenu ul a{text-indent: 15px; background-color: #eee;}

.metismenu .arrow{float:right;line-height:1.42857}[dir=rtl] .metismenu .arrow{float:left}.metismenu .glyphicon.arrow:before{content:"\e079"}.metismenu .active>a>.glyphicon.arrow:before{content:"\e114"}.metismenu .fa.arrow:before{content:"\f104"}.metismenu .active>a>.fa.arrow:before{content:"\f107"}.metismenu .ion.arrow:before{content:"\f3d2"}.metismenu .active>a>.ion.arrow:before{content:"\f3d0"}.metismenu .plus-times{float:right}[dir=rtl] .metismenu .plus-times{float:left}.metismenu .fa.plus-times:before{content:"\f067"}.metismenu .active>a>.fa.plus-times{-webkit-transform:rotate(45deg);-ms-transform:rotate(45deg);-o-transform:rotate(45deg);transform:rotate(45deg)}.metismenu .plus-minus{float:right}[dir=rtl] .metismenu .plus-minus{float:left}.metismenu .fa.plus-minus:before{content:"\f067"}.metismenu .active>a>.fa.plus-minus:before{content:"\f068"}.metismenu .collapse{display:none}.metismenu .collapse.in{display:block}.metismenu .collapsing{position:relative;height:0;overflow:hidden;-webkit-transition-timing-function:ease;-o-transition-timing-function:ease;transition-timing-function:ease;-webkit-transition-duration:.35s;-o-transition-duration:.35s;transition-duration:.35s;-webkit-transition-property:height,visibility;-o-transition-property:height,visibility;transition-property:height,visibility}

/*布局样式重置*/
.tab_parent{padding-left: 15px;}
.tab_subset{margin:0; padding: 0 15px 0 0;}

.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}

.drawer-overlay{overflow: hidden;}
.topsearch{height: 34px; margin:10px 0;}
.topsearch_min{height: 34px; margin:10px 0 0 0;}

/*搜索条*/
.searchtab{position: relative; width: 100%; height: 36px; border-radius: 5px;}
.searchtab span{position: absolute; width: 30px; height: 30px; display: block; top: 2px; left: 2px; background:url(__PUBLIC__/images/searchico.svg) no-repeat; background-size: 30px;}
.searchtab input{border:0; background:#efefef; text-indent: 2em;}
.searchbtn{width: 65px; height: 34px;}
.searchbtn button{width: 60px; height: 33px; border:0; background: #f6a915; color: #fff; border-radius: 5px;}

/*筛选按钮*/
.screen{height: 42px; clear: both; text-align: center; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; padding: 10px 0; position: relative;}
.screen .col-xs-4 {padding-left: 0; padding-right: 0;}
.sepline{border-left:1px solid #e2e2e2; border-right:1px solid #e2e2e2;}
.arrowico{width: 7px; height: 7px; display:inline-block;background:url(__PUBLIC__/images/down-icon.svg) no-repeat;background-size: 7px;}
.screenico{width: 7px; height: 7px;display:inline-block; background:url(__PUBLIC__/images/screen.svg) no-repeat; background-size: 7px;}
.sort_sele,.sort_sele2{display: none; width: 100%; position: absolute; top: 42px; left: 0; background: #fff; padding:0 15px 10px 15px; z-index: 1; text-align: left;-webkit-box-shadow: 0 1px 3px #afafaf;  -moz-box-shadow: 0 1px 3px #afafaf; box-shadow: 0 1px 3px #afafaf;}
.ptick{border-bottom: 1px solid #eee; margin: 0; line-height: 42px;}
.ptick span{display: none; width: 16px;margin-top: 14px;background:url(__PUBLIC__/images/tickspan.png) no-repeat; height: 16px;  float: right;}
.tick span{display: inline-block; }

/*右侧筛选弹框*/
.sift_row{padding: 0 4% 10px; border-bottom: 1px solid #e7e7e7; overflow: hidden;}
.row_title{ padding: 15px 0;}

.row_body ul{list-style: none; margin:0; padding: 0; }
.row_body ul li{ padding: 0 10px 10px 0;   text-align: center;}

.tc_project{display: block; padding: 5px 0;  border-radius: 3px; border: 1px solid #ddd; font-size: 12px;overflow: hidden;
    display: -webkit-box;  -webkit-line-clamp: 1;  -webkit-box-orient: vertical;  height: 28px; line-height: 19px;}
.tc_choose{background: #e60012; border:1px #e60012 solid; color: #fff !important;}

.switch_btn{width: 7px; height: 7px; display: inline-block; background: url(__PUBLIC__/images/down-icon.svg) no-repeat; background-size: 7px; margin-top: 6px;}

.spanrotate{-webkit-transform: rotateZ(180deg);
            -moz-transform: rotateZ(180deg);
            -o-transform: rotateZ(180deg);
            -ms-transform: rotateZ(180deg);
            transform: rotateZ(180deg);}

.sift_bottom{position:absolute; bottom: 0; right: 0; width: 100%;}
.sift-btn{ width: 50%; height: 48px; background: #FFF; line-height: 48px; float: left; text-align: center; border-top: 1px solid #e7e7e7;
}
.sift-btn-ok{  color: #fff; background: #ff5000; border-top-color: #e7e7e7;}
.drawer-default nav{padding-bottom: 47px;}

.no_record{height: 24px;  padding-top: 205px;  text-align: center;  background: url(http://s.17cct.com/v5/images/erp/empty.png) no-repeat center 20px;  background-size: 180px 180px;}


</style><div class="alertBg" id="msgBox" style="display:none;"><h4 class="alerttitle" id="alerttitle"></h4><span class="vm f20" id='alertdetail'></span></div><div class="drawer-main drawer-default"><nav role="navigation" style="height:auto;"><div id="attr_list" ><?php if(is_array($attr_list)): $i = 0; $__LIST__ = $attr_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i;?><div class="sift_row"><div class="row_title"><?php echo ($a["attr_name"]); ?><span class="switch_btn pull-right"></span></div><div class="row_body"><ul class="row" ><li class="col-xs-4"><a href="javascript:;" class="tc_project tc_choose" value="0">不限</a></li><?php if(is_array($a['attr_val'])): $k = 0; $__LIST__ = $a['attr_val'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$av): $mod = ($k % 2 );++$k;?><li class="col-xs-4"><a href="javascript:;" class="tc_project" value="<?php echo ($a["id"]); ?>:<?php echo ($av); ?>"><?php echo ($av); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div></div><?php endforeach; endif; else: echo "" ;endif; ?></div><div id='common'></div></nav><div class="sift_bottom"><div class="sift-btn" id="reset_attr">			重置
		</div><div class="sift-btn sift-btn-ok" onclick="$('.drawer').drawer('close');">			确定
		</div></div></div><input type="hidden" id="class_id" value="<?php echo ($t); ?>"><input type="hidden" id="sort" value="0"><input type="hidden" id="attr_value" value=""><div class=""><div class="topsearch_min col-xs-12 box_flex"><div class="flex1 searchtab"><span></span><input type="text" class="form-control enter-search" id="keyword" value="" placeholder="请输入商品名称"></div></div><div class="topsearch_min col-xs-12 box_flex" style="margin-bottom: 5px;"><div class="col-xs-6 tab_subset"><input type="text" class="form-control mobiscroll" id="start_time" name="start_time" value="<?php if($start_time != null): echo (date("Y-m-d",$start_time)); endif; ?>" placeholder=" 起始时间"></div><div class="col-xs-6 tab_subset"><input type="text" class="form-control mobiscroll" id="end_time" name="end_time" value="<?php if($start_time != null): echo (date("Y-m-d",$end_time)); endif; ?>" placeholder=" 结束时间"></div><div class="searchbtn searchtab"><button>搜索</button></div></div><div class="screen" style="margin-bottom:-1px;"><div class="col-xs-4 "><a href="javascript:;" id="comprehensive">综合排序 <span class="arrowico"></span></a></div><div class="col-xs-4 sepline"><a href="javascript:;" id="classification"><?php echo ($class_name); ?><span class="arrowico"></span></a></div><div class="col-xs-4 js-trigger">筛选 <span class="screenico"></span></div><div class="sort_sele"><p class="ptick tick" onclick="mob.setSort(0,this)"><a href="javascript:;">综合排序</a><span></span></p><p class="ptick" onclick="mob.setSort(1,this)"><a href="javascript:;">价格从低到高</a><span></span></p><p class="ptick" onclick="mob.setSort(2,this)"><a href="javascript:;">价格从高到低</a><span></span></p><p class="ptick" onclick="mob.setSort(3,this)"><a href="javascript:;">数量从高到低</a><span></span></p><p class="ptick" onclick="mob.setSort(4,this)"><a href="javascript:;">数量从低到高</a><span></span></p></div><div class="sort_sele2"><ul class="metismenu " id="menu"><?php if(is_array($class_list)): $i = 0; $__LIST__ = $class_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><li><a href="#"><i class="fa fa-circle-o"></i><?php echo ($c["c_name"]); ?><span class="fa arrow fa-fw"></span></a><ul aria-expanded="false" class="collapse"><?php if(is_array($c['item'])): $i = 0; $__LIST__ = $c['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ci): $mod = ($i % 2 );++$i;?><li <?php if($ci["id"] == $t): ?>class="select"<?php endif; ?>><a href="<?php echo U('SupSale/sale_detail',array('t'=>$ci['id']));?>" class="present"><?php echo ($ci["class_name"]); ?><i class="fa fa-angle-right pull-right"></i></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><!-- 导航插件 --><script type="text/javascript" src="__PUBLIC__/js/metisMenu.js"></script><script>                $(function () {
                    $('#menu').metisMenu();
                });
            </script></div></div><div id="order_list"></div></div><div style="height:45px;clear:both"></div><!--漂浮导航 开始--><div class="row pos-nav"><div class="col-xs-3"><a href="<?php echo U('Supplier/index');?>" <?php if(MODULE_NAME == Supplier): ?>class="nav-red"<?php endif; ?>><i class="iconfont icon-shangdian1"></i><p>首页</p></a></div><div class="col-xs-3"><a href="<?php echo U('SupOrder/navig');?>" <?php if(MODULE_NAME == SupOrder): ?>class="nav-red"<?php endif; ?>><i class="iconfont icon-kehu"></i><p>交易/客户</p></a></div><div class="col-xs-3"><a href="<?php echo U('SupWarehouse/navig');?>" <?php if(MODULE_NAME == SupWarehouse): ?>class="nav-red"<?php endif; ?>><i class="iconfont icon-kucun"></i><p>财务/库存</p></a></div><div class="col-xs-3"><a href="<?php echo U('SupMember/navig');?>" <?php if(MODULE_NAME == SupMember): ?>class="nav-red"<?php endif; ?>><i class="iconfont icon-shouhou"></i><p>售后</p></a></div></div><!--漂浮导航 结束--></body></html><script type="text/javascript">    mob.timePlugin();
    $(document).ready(function(){
        $('.drawer').drawer();
        $('.js-trigger').click(function(){
            $(".sort_sele2").hide();
            $(".sort_sele").hide();
            $('.drawer').drawer("open");
        });
    });

    //查找子类商品并选中
    $('.select').parent().parent().addClass('active');

    var keyword         = $('#keyword').val(),
        attr_value      = $('#attr_value').val(),
        sort            = $('#sort').val(),
        class_id        = $('#class_id').val(),
        start_time      = $('#start_time').val(),
        end_time        = $('#end_time').val();
    var dataInfo = {
        keyword:keyword,
        attr_value:attr_value,
        sort:sort,
        class_id:class_id,
        start_time:start_time,
        end_time:end_time
    };
    mob.init("<?php echo U('SupSale/ajax_get_sale_detail_goods');?>","#order_list",dataInfo);
    mob.ajaxGetAttr("<?php echo U('SupWarehouse/ajax_get_attr');?>");
    mob.ajaxGetWarehouse("<?php echo U('SupWarehouse/ajax_get_warehouse');?>");

    //筛选确定
    $('.sift-btn-ok').click(function(){
        mob.sendData.currentpage = 0;
        mob.sendData.keyword     = $('#keyword').val();
        mob.sendData.attr_value  = $('#attr_value').val();
        mob.sendData.class_id    = $('#class_id').val();
        mob.sendData.start_time  = $('#start_time').val();
        mob.sendData.end_time    = $('#end_time').val();
        mob.ajaxGetResults(mob.sendData);

    });

    //搜索商品
    $('.searchbtn button').on('click',function(){
        mob.ajaxSearch();
    });

    //属性重置
    $('#reset_attr').click(function(){
        $('#attr_value').val('');
        $('.tc_project').removeClass('tc_choose');
    })

</script><script type="text/javascript">document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script><script src="__PUBLIC__/js/iscroll.js"></script><script src="__PUBLIC__/js/jquery.drawer.min.js"></script>