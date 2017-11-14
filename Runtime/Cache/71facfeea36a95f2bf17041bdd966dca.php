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
<link rel="stylesheet" href="__PUBLIC__/css/common_home.css">
<link rel="stylesheet" href="__PUBLIC__/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="__PUBLIC__/css/drawer.min.css">
<link href="__PUBLIC__/css/mobiscroll.css" rel="stylesheet" />
<link href="__PUBLIC__/css/mobiscroll_date.css" rel="stylesheet" />
<link rel="stylesheet" href="__PUBLIC__/css/alertPopShow.css" />
<script src="__PUBLIC__/js/mobiscroll_date.js" charset="gb2312"></script> 
<script src="__PUBLIC__/js/mobiscroll.js"></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/bootstrap-select.css">
<script type="text/javascript" src="__PUBLIC__/js/bootstrap-select.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/alertPopShow.js"></script>

<style type="text/css">

/*主要数据*/
.main_data{ overflow: hidden; color: #fff; }
.box-flex{ display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox;  display: flex; }
.turnover h5{font-size: 20px; color: #ff3e3e; font-weight: bold;margin-bottom: 4px}
.turnover{padding: 7px 0;}

.data_rb{border-right:1px solid #eee;}


.reserve_tab {
    padding: 15px;
}
.bomb_screen1{position: absolute; z-index: 5; width: 100%; min-height: 100%; background: #fff; display: none; top: 0;}

.resbox{border:1px solid #ccc; background: #fff;  margin-bottom: 15px; overflow: hidden; border-radius: 6px;}

.resimg,.resico{width: 48px; height: 48px; margin-right: 10px; display: block; float: left; overflow: hidden;border-radius: 24px;}

.reserve_tab h3{
    font-size: 14px;
    margin: 10px 0 9px 0;
    font-weight: bold;
}

.stopname p {
    margin-bottom: 5px;
    color: #a5a5a5;
    font-size: 12px;
}

.stopname{padding: 5px;}

p {
    margin: 0 0 10px;
}

.resbox, .storebox {
    border: 1px solid #ccc;
    background: #fff;
    margin-bottom: 15px;
    overflow: hidden;
    border-radius: 6px;
    position: relative;
}

.currentstop {
    border: 1px solid #cd0000;
    position: relative;
}

.currentstop .tick {
    display: block;
    right: 0;
    bottom: 0;
    position: absolute;
    background: url(__PUBLIC__/images/tick.png) no-repeat;
    background-size: 24px;
    width: 24px;
    height: 24px;
}

a:focus, a:active, a:hover {
    color: #333;
    text-decoration: none;
}

.price {
    color: #eb5211;
    font-size: 16px;
}

.topsearch {
    height: 34px;
    margin: 10px 0;
}


.flex1 {
    -webkit-box-flex: 1;
    flex: 1;
}
.box_flex {
    font-size: 14px;
    display: flex;
}
.head_border{
    border-bottom: 1px #eee solid;
}

.bundlev {
    height: 40px;
    line-height: 40px;
    padding: 0 15px;
}
.bline {
    border-bottom: 1px solid #e6e6e6;
}
.bundlev p {
    margin: 0;
}

.my_od {
    border-bottom: none;
}

.o_f {
    overflow: hidden;
}
.bundlev input{
    display: inline;
    border-style:none; 
    height:40px;
    position: absolute;
}

.bundlev .pull-left{
    width:70px;
}

/*导航*/
.sidebarbox{ height: 100%; overflow:auto; }
.metismenu,.metismenu ul{margin:0; padding: 0; list-style: none;}
.metismenu a{padding: 12px 10px; display: block; border-bottom: 1px solid rgb(218, 218, 218); }
.metismenu ul a{text-indent: 15px; background-color: #eee;}

.metismenu .arrow{float:right;line-height:1.42857}[dir=rtl] .metismenu .arrow{float:left}.metismenu .glyphicon.arrow:before{content:"\e079"}.metismenu .active>a>.glyphicon.arrow:before{content:"\e114"}.metismenu .fa.arrow:before{content:"\f104"}.metismenu .active>a>.fa.arrow:before{content:"\f107"}.metismenu .ion.arrow:before{content:"\f3d2"}.metismenu .active>a>.ion.arrow:before{content:"\f3d0"}.metismenu .plus-times{float:right}[dir=rtl] .metismenu .plus-times{float:left}.metismenu .fa.plus-times:before{content:"\f067"}.metismenu .active>a>.fa.plus-times{-webkit-transform:rotate(45deg);-ms-transform:rotate(45deg);-o-transform:rotate(45deg);transform:rotate(45deg)}.metismenu .plus-minus{float:right}[dir=rtl] .metismenu .plus-minus{float:left}.metismenu .fa.plus-minus:before{content:"\f067"}.metismenu .active>a>.fa.plus-minus:before{content:"\f068"}.metismenu .collapse{display:none}.metismenu .collapse.in{display:block}.metismenu .collapsing{position:relative;height:0;overflow:hidden;-webkit-transition-timing-function:ease;-o-transition-timing-function:ease;transition-timing-function:ease;-webkit-transition-duration:.35s;-o-transition-duration:.35s;transition-duration:.35s;-webkit-transition-property:height,visibility;-o-transition-property:height,visibility;transition-property:height,visibility}
/*布局样式重置*/
.tab_parent{padding-left: 15px;}
.tab_subset{margin:0; padding: 0 15px 0 0;}
a{color: #333;}
a:focus,a:active, a:hover{color: #333; text-decoration: none;}
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}

.drawer-overlay{overflow: hidden;}
.topsearch{height: 34px; margin:10px 0;}
/*搜索条*/
.searchtab{position: relative; width: 100%; height: 36px; border-radius: 5px; margin-right:10px; }
.searchtab span{position: absolute; width: 30px; height: 30px; display: block; top: 2px; left: 2px; background:url(__PUBLIC__/images/searchico.svg) no-repeat; background-size: 30px;}
.searchtab input{border:0; background:#efefef; text-indent: 2em;}
.searchbtn{width: 90px; height: 36px;}
.searchbtn button{width: 90px; height: 33px; border:0; background: #f6a915; color: #fff; border-radius: 5px;}

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

.min, .add {
    width: 30px;
    text-align: center;
    background-color: #E6E6E6;
    padding: 0;
    border: 0;
    height: 30px;
    line-height: 30px;
}

.text_box {
    width: 40px;
    text-align: center;
    height: 30px;
    border: 0;
    margin: 0 -4px;
    line-height: 30px;
    box-shadow: none;
    border-radius: 0;
    background: #fbfbfb;
}

.setbox{
    position: absolute;
    right: 15px;
    bottom: 10px;
}


/*采购商品信息开始*/

/*商品信息*/
.goodsinfo{background:#f8f8f8;padding-left: 5px;}
.productlist{ margin-top: .09rem; padding-top: 12px; padding-bottom: 12px;}
.tickbtn2{width: 40px; height: 70px;line-height: 70px; display: inline-block;}
.leftimg{width: 70px; height: 70px; margin-right: 10px;}
.leftimg img{width: 100%; height: 100%;}
.rightinfo{padding-right: 10px; position: relative;}
.rightinfo h3{ line-height: 22px; margin: 3px; height: 42px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;  font-size: 12px;  word-break: break-all;}
.price{ color: #eb5211;font-size: 16px;}
.d-main{ position: absolute; bottom: 0;}
.d-main input{ height: 30px;width: 75px;color:#eb5211}

/*编辑内容*/
.editinfo{position: absolute;right: 5px;top: -11px;}
.setboxs{margin: 51px 12px 0 10px;}
.set_meal{padding: 0;}
.set_meal li{overflow: hidden; margin-bottom: 7px;}
.min,.add{ width: 30px; text-align: center;background-color: #E6E6E6; padding: 0; border:0;  height: 30px;  line-height: 30px;}
.min{border-radius: 3px 0 0 3px;}
.add{border-radius:0 3px 3px 0;}
.text_box{width: 40px; text-align: center; height: 30px; border: 0; margin: 0 -4px; line-height: 30px;box-shadow: none;border-radius: 0;    background: #fbfbfb;
}
.delbtn{height: 91px; width: 45px; border:0; color: #fff; background: #f60;}


.tickNull {
    background: url(__PUBLIC__/images/tick.svg) no-repeat -20px 0;
    background-size: 40px;
}

.tickico {
    background: url(/mobile/Public/images/tick.svg) no-repeat;
    background-size: 40px;
}

.tickico, .storeico, .tickNull {
    display: inline-block;
    width: 20px;
    height: 20px;
    vertical-align: middle;
}

.wholebtn {
    width: 40px;
    height: 48px;
    line-height: 48px;
    display: inline-block;
}

.cartbottom .price {
    padding: 14px 8px 0 0;
    display: inline-block;
}

/*采购商品信息结束*/

/*交易类型*/
.project_name {
    width: 100%;
    padding: 10px 15px;
}

.payment li {
    padding: 10px;
    display: inline-block;
    overflow: hidden;
    text-align: left;
    border: 1px solid #d2d2d2;
    cursor: pointer;
    width: 182px;
    height: 52px;
    font-size: 20px;
}

.project_name i {
    font-size: 24px;
    text-align: center;
    line-height: 28px;
    color: #ffffff;
    background: #de6464;
    border-radius: 3px;
    display: block;
    margin-right: 7px;
    width: 28px;
    height: 28px;
    float: left;
}
.project_name .payment_text{
    line-height: 28px;
    font-size: 14px;
}

</style>

<script>
$(function () {
    $("#flag").on('keyup', function(e) {
         var target = $(e.target);
         if (target.is(".bs-searchbox input") || target.parents().is(".bs-searchbox input")) {
            
            var location_name =$('#flag input').val();
            //判定键入的值不为空，才调用ajax
            if(location_name != ''){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo U("SupOrder/get_location");?>',
                    data: { //传递到后台的值
                        name: location_name
                    },
                    dataType: "Json",
                    success: function (Select) {
                        //清除select标签下旧的option签，根据新获得的数据重新添加option标签
                        $("#id_select").empty();
                        if (Select != null) {
                            var html = '';               
                            $.each(Select, function (i,data) {
                                html += "<option value='" + data.id + "' data-val='"+data.location_id+"'>" + data.location_name + "</option>";
                            });
                            $("#id_select").append(html);
                        }else{
                            $("#id_select").append(" <option value=0>暂无数据</option>");
                        }
                        //必不可少的刷新
                        $("#id_select").selectpicker('refresh');
                        var id = $('#id_select').find('option').first().val();
                        ajaxGetStoreInfo(id,location);
                    }
                });
            }else{ 
                  //如果输入的字符为空，清除之前option标签
                  $("#id_select").empty();
                  //必不可少的刷新
                  $("#id_select").selectpicker('refresh');
            }  
        }
    });
    $('#id_select').on('change',function(event) {
        var id = $(this).val();
        ajaxGetStoreInfo(id);
    });
})

function ajaxGetStoreInfo(id){
    $.post('<?php echo U("SupOrder/get_store_info");?>', {id: id}, function(data) {
        if(data.status == 1){
            $('#location_name').text(data.info.location_name);
            $('#receive_user').text(data.info.contact);
            $('#receive_tel').text(data.info.mobile);
            $('#receive_address').text(data.info.address);
            $('#balance').html(data.info.balance_account);
            $('#price-box').html(data.info.price);
            $('#purchase_number').html(data.info.purchase_number);
            $('#purchase_time').html(data.info.last_purchase_time);
            $('#credit-line-box').html(data.info.credit_line);
            $('#pay-balance-account').html(data.balance_html);
        }else{
            $('#location_name').text('');
            $('#receive_user').text('');
            $('#receive_tel').text('');
            $('#receive_address').text('');
        }
    },'json');
    id == 0 ? $('#location_info').hide() : $('#location_info').show();
    update_discount_list();
}

</script>  


</head>
<body class="drawer drawer-right">

<!--弹出提示框-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<div class="drawer-main drawer-default">
    <nav role="navigation" style="height:auto;">
        <div id="attr_list">
            <?php if(is_array($attr_list)): $i = 0; $__LIST__ = $attr_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i;?><div class="sift_row">
                    <div class="row_title">
                        <?php echo ($a["attr_name"]); ?>
                        <span class="switch_btn pull-right"></span>
                    </div>
                    <div class="row_body">
                        <ul class="row" >
                                <li class="col-xs-4">
                                    <a href="javascript:;" class="tc_project tc_choose" value="0">不限</a>
                                </li>
                            <?php if(is_array($a['attr_val'])): $k = 0; $__LIST__ = $a['attr_val'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$av): $mod = ($k % 2 );++$k;?><li class="col-xs-4">
                                    <a href="javascript:;" class="tc_project" value="<?php echo ($a["id"]); ?>:<?php echo ($av); ?>"><?php echo ($av); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>                   
                        </ul>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
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
<!-- 顶部筛选 刷新 -->
<script type="text/javascript" src="__PUBLIC__/js/countUp.min.js"></script>

<div class="main_data text-center" style="overflow: visible;">
    <div class="topsearch box_flex" id="flag">
            <select id="id_select" class="selectpicker col-xs-12" data-live-search="true" name="location_name" style="">
                <option value="0">--请选择门店--</option>
                <?php if(is_array($location)): foreach($location as $key=>$l): ?><option value="<?php echo ($l["id"]); ?>" data-val="<?php echo ($l["location_id"]); ?>"><?php echo ($l["location_name"]); ?></option><?php endforeach; endif; ?>
            </select>
        <!-- <div class="searchbtn" ><button onclick="search_goods(2)" style="margin-right: -29px;width:65px;">搜索<button></div> -->
        <!-- <div class="searchbtn" ><button onclick="search_goods(2)" style="margin-right: -15px;width:65px;">新增<button></div> -->
    </div>
</div>


<div class="container-fluid line"></div>

<!-- 历史营业额 -->
<div id="location_info" style="display: none">
    <div class="box-flex text-center">
        <div class="flex1 turnover data_rb head_border">
            <h5><span id="purchase_number"></span></h5>
            <p>本月采购</p>
        </div>
       
        <div class="flex1 turnover head_border">
            <h5><span id="purchase_time"></span></h5>
            <p>上次采购</p>
        </div>
    </div>


    <!-- 历史营业额 -->
    <div class="box-flex text-center">
        <div class="flex1 turnover data_rb head_border">
            <h5><span id="price-box"></span></h5>
            <p>历史挂账</p>
        </div>
        <div class="flex1 turnover data_rb head_border">
            <h5><span id="credit-line-box"></span></h5>
            <p>授信额度</p>
        </div>
        <div class="flex1 turnover head_border">
            <h5><span id="balance"></span></h5>
            <p>预付款余额</p>
        </div>
    </div>

    <div class="bundlev bline">
        <p><span class="pull-left">门店名称：</span><span class="pull-right" id="location_name"></span></p>
    </div>
    <div class="bundlev bline">
        <p><span class="pull-left">联系人：</span><span class="pull-right" id="receive_user"></span></p>
    </div>
    <div class="bundlev bline">
        <p><span class="pull-left">联系电话：</span><span class="pull-right" id="receive_tel"></span></p>
    </div>
    <div style="padding: 10px 16px;height: 60px;">
        <p><span class="pull-left">地址：</span><span class="pull-right" id="receive_address"></span></p>
    </div>
    <div>
        <div class="topsearch col-xs-12" style="border-top: 1px solid #e6e6e6;">
            <div class="searchbtn" style="float:right;"><button type="button" style="width:90px;margin-top: 5px" onclick="deal_record()">交易记录</button></div>
            <!-- <div class="searchbtn" style="margin-right: -244px;"><button type="button" style="width:80px;" onclick="search_goods(2)">修改资料</button></div> -->
        </div>
    </div>

    <div class="container-fluid line"></div>
</div>


<div class="bundlev bline" onclick="bomb_screen(1,'goods')">
    <a class="">
        <p><span class="pull-left">采购</span></p>
        <div class="pull-right">                   
            <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
        </div>  
    </a>    
</div>


<div class="good_info_list" style="display:none">
    <div class="goods_list_goods">
    </div>

    <div class="flex1 bline">
        <div class="wholebtn text-center"></div>

        <span class="pull-right cartbottom">
            数量：<span class="price" id="total_count_goods"></span> 
            总金额: <span class="price">￥<span id="total_price_goods"></span></span>
        </span>
    </div>
    <div class="flex1 bline" style="display: none;">
        <div class="wholebtn text-center"></div>

        <span class="pull-right cartbottom">
            优惠金额: <span class="price">￥<span id="discount_price"></span></span>
            实际金额: <span class="price">￥<span id="new_total_price"></span></span>
        </span>
    </div>
   
</div>


<div class="bundlev bline" onclick="bomb_screen(1,'gift')">
    <a class="">
        <span class="navig" style="">赠品</span>
        <div class="pull-right">                   
            <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
        </div>  
    </a>    
</div>


<div class="good_info_list" style="display:none">
    <div class="goods_list_gift">
    </div>

    <div class="flex1 bline">
        <div class="wholebtn text-center"></div>
        <span class="pull-right cartbottom">数量：<span class="price" id="total_count_gift"></span> 合计: <span class="price">￥<span id="total_price_gift"></span></span></span>
    </div>
</div>


<div class="bundlev bline">
    <a class="">
        <p><span class="pull-left">参与活动</span></p>
        <div class="box_flex">
            <select id="act_list" class="col-xs-12 form-control" name="pay_method" style="margin:3px 0 3px 10px;">
                <option value="0">无</option>
            <select>
        </div>  
    </a>       
</div>


<div class="bundlev bline">
    <a class="">
        <p><span class="pull-left">使用优惠券</span></p>
        <div class="box_flex">
            <select id="coupon_list" class="col-xs-12 form-control" name="coupon_list" style="margin:3px 0 3px 10px;">
                <option value="0">无</option>
            <select>
        </div>  
    </a>       
</div>

<div class="bundlev bline">
    <a class="">
        <p><span class="pull-left">配送方式</span></p>
        <div class="box_flex">
            <select id="distribution_type" class="col-xs-12 form-control" name="distribution_type" style="margin:3px 0 3px 10px;">
                <option value="0">--请选择配送方式--</option>
                    <option value="1">物流配送</option>
                    <option value="2">公司自配</option>
                    <option value="3">摩的配送</option>
                    <option value="4">自提</option>
            <select>
        </div>  
    </a>    
</div>

<div class="bundlev bline" style="display: none" id="express-name-block">
    <a class="">
        <p><span class="pull-left">物流公司</span></p>
        <div class="box_flex">
            <select id="express" class="col-xs-12 form-control" name="express" style="margin:3px 0 3px 10px;">
                <option value="0">--请选择物流公司--</option>
                <?php if(is_array($express_list)): foreach($express_list as $key=>$e_l): ?><option value="<?php echo ($e_l["id"]); ?>"><?php echo ($e_l["name"]); ?></option><?php endforeach; endif; ?>
            <select>
        </div>  
    </a>    
</div>

<div class="bundlev"  style="padding: 0">
    <input type="text" name="distribution_remark" id="distribution_remark" placeholder="配送备注：此处填写配送备注" class="form-control">
</div>

<div class="container-fluid line"></div>

<div class="bundlev bline">
    <a class="">
        <p><span class="pull-left">支付类型</span></p>
        <div class="box_flex">
            <select id="pay_type" class="col-xs-12 form-control" name="pay_type" style="margin:3px 0 3px 10px;">
                <option value="0">--请选择支付类型--</option>
                    <option value="1">现金挂账结算</option>
                    <option value="2">月底挂账结算</option>
                    <option value="3">约定挂账结算</option>
                    <option value="4">预付款结算</option>
            <select>
        </div>  
    </a>    
</div>


<div class="bundlev bline">
    <a class="">
        <p><span class="pull-left">支付方式</span></p>
        <div class="box_flex">
            <select id="pay_method" class="col-xs-12 form-control" name="pay_method" style="margin:3px 0 3px 10px;">
                <option value="0">--请选择支付方式--</option>
            <select>
        </div>  
    </a>    
</div>

<div class="bundlev bline" style="display: none" id="account-name-block">
    <a class="">
        <p><span class="pull-left">余额支付</span></p>
        <div class="box_flex">
            <select id="account_name" class="col-xs-12 form-control" name="pay_method" style="margin:3px 0 3px 10px;">
                <option value="0">--请选择支付账号--</option>
            <select>
        </div>  
    </a>    
</div>

<div class="bundlev" style="padding: 0">
    <input type="text" name="pay_remark" id="pay_remark" placeholder="支付备注：此处填写支付备注" class="form-control">
</div>

<div class="container-fluid line"></div>

<div class="bundlev bline">
    <a class="">
        <p><span class="pull-left">制单人</span></p>
        <div class="box_flex">
            <select id="select_maker" class="col-xs-12 form-control" name="select_maker" style="margin:3px 0 3px 10px;">
                <option value="0">--请选择制单人--</option>
                    <?php if(is_array($employee_list)): foreach($employee_list as $key=>$el): ?><option value="<?php echo ($el["id"]); ?>"><?php echo ($el["name"]); ?></option><?php endforeach; endif; ?>
            <select>
        </div>  
    </a>    
</div>

<div class="bundlev" style="padding: 0">
    <input type="text" name="make_remark" id="make_remark" placeholder="制单备注：此处填写制单备注" class="form-control">
</div>

<div class="container-fluid" style="padding: 0">
    <div class="row" style="margin-top:15px;">
        <center>        
            <div class="col-xs-12">
                <button class="btn btn-lg btn-block btn-warning confirm" style="border-radius:0">确定下单</button>
            </div>
        </center>
    </div>
</div>


<!-- 选择商品 -->
<div class="bomb_screen1">
    <div class="topsearch col-xs-12 box_flex">
        <div class="flex1 searchtab">
            <span></span>
            <input type="text" class="form-control" id="keyword" value="" placeholder="请输入商品名称">
        </div>
        <div class="searchbtn">
            <button onclick="search_goods(2)">搜索</button>
        </div>
    </div>
    <div class="screen">
        <div class="col-xs-4 "><a href="javascript:;" id="comprehensive">综合排序 <span class="arrowico"></span></a></div>
        <div class="col-xs-4 sepline">
            <a href="javascript:;" id="classification"><?php echo ($class_name); ?> <span class="arrowico"></span></a>
        </div>
        <div class="col-xs-4 js-trigger">筛选 <span class="screenico"></span></div>

        <div class="sort_sele">
            <p class="ptick tick" onclick="set_sort(0,this)"><a href="javascript:;">综合排序</a><span></span></p>
            <p class="ptick" onclick="set_sort(1,this)"><a href="javascript:;">价格从低到高</a><span></span></p>
            <p class="ptick" onclick="set_sort(2,this)"><a href="javascript:;">价格从高到低</a><span></span></p>
            <p class="ptick" onclick="set_sort(3,this)"><a href="javascript:;">销量从高到低</a><span></span></p>
            <p class="ptick" onclick="set_sort(4,this)"><a href="javascript:;">销量从低到高</a><span></span></p>
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
        <button class="btn btn-lg btn-block btn-danger" style="margin-left: 15px;" id="confirm-button" data-type='' onclick="confirm(1,this)">确定</button>
    </div>

    <input type="hidden" id="class_id" value="<?php echo ($class_id); ?>">
    <input type="hidden" id="sort" value="0">
    <input type="hidden" id="attr_value" value="">
</div>

</body>
</html>

<script type="text/javascript">

$(document).ready(function(){  
    $('#comprehensive').click(function(){
        $(".sort_sele").slideToggle(200);
        $(".sort_sele2").hide();
    });

    $('#classification').click(function(){
        $(".sort_sele2").slideToggle(200);
        $(".sort_sele").hide();
    });   

    $(".row_title").click(function(){
        $(this).children().toggleClass('spanrotate');           
    });     


    $('.drawer').drawer();
    $('.js-trigger').click(function(){
        $(".sort_sele2").hide();
        $(".sort_sele").hide();
        $('.drawer').drawer("open");
    });

});


function deal_record(){
    var location_id = $('#id_select').find('option:selected').attr('data-val');
    if($.type(location_id) == 'undefined' || location_id == ''){
        MsgBox('请选择门店');
        return false;
    }
    location.href = '<?php echo U("SupOrder/deal_record");?>?location_id='+location_id;
    /*var url = '<?php echo U("SupOrder/deal_record",array("location_id"=>location-id));?>';
    url = url.replace('location-id',location_id);*/
}

//查找子类商品并选中
$('.select').parent().parent().addClass('active');

//定义全局变量
var currentpage = 0;

//加载商品
function ajax_get_goods(){
    var keyword=$('#keyword').val(),attr_value=$('#attr_value').val(),sort=$('#sort').val(),class_id=$('#class_id').val();
    $("#load").show();
    stop=false;
    $.get("<?php echo U('SupGoods/chooes_goods');?>",{"p":currentpage,"k":keyword,"attr":attr_value,"sort":sort,"class_id":class_id}
    ,function(html){
          if(html!=""||html!=0){ 
            if(currentpage==0) {
                $("#CarWash").html(html);
            }else{
                $("#CarWash").append(html);                                               
            }
            stop=true;                  
          }else{
            MsgBox('已加载全部数据');
            if(currentpage==0){
                $("#CarWash").html('<div class="no_record col-sm-12">暂无数据</div>');
            }                   
          }                
         $("#load").hide();  
    });
}

// 弹框
function bomb_screen(index,type){

    if($('#id_select').val() == 0){
        MsgBox('请先选择门店');
        return false;
    }

    var bomb='.bomb_screen'+index;
    $(bomb).slideToggle(1);
    if(type == 'goods'){
        $('#confirm-button').attr('data-type','goods');
        $('#class_id').val(2);
    }else if(type == 'gift'){
        $('#confirm-button').attr('data-type','gift');
        $('#menu').html('<li class="active">'+
                    '<a href="#">'+
                        '<i class="fa fa-circle-o"></i>'+
                        '轮胎轮毂'+
                        '<span class="fa arrow fa-fw"></span>'+
                    '</a>'+
                    '<ul aria-expanded="true" class="collapse in">'+
                        '<li onclick="set_class(2,this)">'+
                            '<a href="javascript:;" class="present">轿车轮胎 <i class="fa fa-angle-right pull-right"></i></a>'+
                        '</li>'+
                        '<li onclick="set_class(43,this)">'+
                            '<a href="javascript:;" class="present">卡客车轮胎 <i class="fa fa-angle-right pull-right"></i></a>'+
                        '</li>'+
                    '</ul>'+
                '</li>');
    }

    if($.inArray(index, [1]) >= 0){

        currentpage=0;
        ajax_get_goods();//初始化添加商品列表
        ajax_get_attr();//初始化添加属性列表

        //滚动加载
        $(window).scroll(function(){ 
            totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 
            if($(document).height() <= totalheight){ 
                if(stop==true){ 
                    MsgBox('正在加载...');
                    currentpage++;
                    ajax_get_goods();
                } 
            } 
        });
    }

}

// 确定商品
function confirm(index,_this){
    var type = $(_this).attr('data-type');
    var data = get_goods_info(type);
    var bomb = '.bomb_screen'+index;
    stop = false;

    if(type=='goods')
        var g_l = $('.goods_list_goods');
    else if(type=='gift')
        var g_l = $('.goods_list_gift');

    $.each(data,function (index,item) {
        var is_h = g_l.find("[data-goodsid='"+item.goods_id+"']").length;
        if (!is_h){
            g_l.append(item.goods_html)
        }
    })
    g_l.parent().show();
    $(bomb).slideToggle(1);

    updataprice(type);
}

//获取商品信息
function get_goods_info(type)
{
    var goods_info  = [];
    $('.currentstop').each(function(i) {
        if(Number($(this).find('.text_box').val()) > 0){
            var goods = new Object();
            goods.goods_id    = $(this).data('gid');
            goods.goods_num   = parseInt($(this).find('.text_box').val());
            goods.goods_img   = $(this).find('img').attr('src');
            goods.goods_name  = $(this).find('h3').text().trim();
            goods.goods_price = $(this).find('.price').text().trim();
            goods.goods_stock = parseInt($(this).find('.stock').text());

            goods.goods_html = '<div class="goodsinfo" data-type="'+type+'" data-goodsid = "'+goods.goods_id+'" data-stock="'+goods.goods_stock+'">'+
                '<div class="productlist box_flex">'+
                        '<div class="leftimg">'+
                            '<a href="<?php echo U("SupGoods/detail");?>?id='+goods.goods_id+'"><img src="'+goods.goods_img+'"></a>'+
                        '</div>'+
                        '<div class="rightinfo flex1">'+
                            '<h3><a href="<?php echo U("SupGoods/detail");?>?id='+goods.goods_id+'">'+goods.goods_name+'</a></h3>'+
                            '<div class="d-main">'+
                                '<input type="text" name="price" class="form-control" '+((type=='gift') ? 'disabled' : '')+' value="'+((type=='gift') ? 0 : goods.goods_price)+'" onblur="updataprice(\''+type+'\')"/>'+
                            '</div>'+

                            '<div class="editinfo">'+
                                '<div class="setboxs pull-left">'+
                                    '<input class="min" name="" type="button" value="-" onclick="modify_cart(this,\'min\')">'+
                                    '<input class="text_box" name="goodnum" type="text" value="'+goods.goods_num+'" onblur="updataprice(\''+type+'\')">'+
                                    '<input class="add" name="" type="button" value="+" onclick="modify_cart(this,\'add\')">'+
                                '</div>'+
                                '<button class="pull-right delbtn" data-type="'+type+'" onclick="del_cart(this)">删除</button>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';

            goods_info.push(goods);
        };
    });
    return goods_info;
}


//设置排序
function set_sort(val,_this){
    $('#sort').val(val);
    $('#comprehensive').html($(_this).find('a').html()+'<span class="arrowico"></span>');
    $(_this).addClass('tick').siblings().removeClass('tick');
    $(".sort_sele").slideToggle(200);
    search_goods(1);
}

//选分类
function set_class(val,_this){
    $('#classification').html(($(_this).find('a').text())+'<span class="arrowico"></span>');
    $('#class_id').val(val);
    $('#attr_value').val('');
    $('#keyword').val('');
    $(_this).addClass('tick').siblings().removeClass('tick');
    $(".sort_sele2").slideToggle(200);
    search_goods(1);
    ajax_get_attr();
}

//搜索商品
function search_goods(type) {
    if(type==2&&$('#keyword').val()==''){
        MsgBox('请输入关键词搜索');
        return false;
    }
    currentpage=0;
    ajax_get_goods();
}

//加载属性
function ajax_get_attr(){
    var class_id=$('#class_id').val();
    $.get("<?php echo U('Purchase/ajax_get_attr');?>",{"class_id":class_id}
    ,function(html){
          if(html!=""){               
                $("#attr_list").html(html);               
          }else{
            MsgBox('该分类未添加有属性');
          }
    });
}   

//属性重置
$('#reset_attr').click(function(){
    $('#attr_value').val('');
    ajax_get_attr();            
    ajax_get_goods();
})

//筛选确定
$('.sift-btn-ok').click(function(){
    currentpage=0;
    ajax_get_goods();

});


$(document).on("click", "#CarWash .storebox", function(e) {
    var target = $(e.target);

    if (target.is(".add"))
    {
        var v = parseInt(target.prev().val());
        target.prev().val(v + 1);
        $(this).addClass('currentstop');
    }
    else if (target.is(".min"))
    {
        var tt = parseInt(target.next().val());
        if (tt <= 0)
        {
            $(this).removeClass('currentstop');
            return false;
        }
        else
        {
            target.next().val(tt - 1);
        }
    }
    else if (target.is(".text_box"))
    {
        $(this).addClass('currentstop');
    }
    else {
        $(this).toggleClass('currentstop');
    }
});


//商品加1或减1
function modify_cart(obj,type) {
    var $this = $(obj);
    if (type == 'add')
    {
        var v = num = parseInt($this.prev().val()) + 1;
        $this.prev().val(v);
    }
    else if (type == 'min')
    {
        var v = num = parseInt($this.next().val() - 1);
        if ( v <= 0 )
            v = num = 0;

        $this.next().val(v);
    }
    var parent = $this.parents('.goodsinfo');
    updataprice(parent.attr('data-type'));
}

//删除购买商品
function del_cart(obj){
    var parent = $(obj).parents('.goodsinfo');
    var type = parent.attr('data-type');
    parent.remove();
    updataprice(type);
}


//动态修改价格和数量
function updataprice(type) {
    var total_price = 0, total_count = 0;

    $('.goods_list_'+type).find('.goodsinfo').each(function(){
        var price = ($(this).find("[name='price']").val() * 1).toFixed(2);
        var num = parseInt($(this).find("[name='goodnum']").val());

        total_price += price * num;
        total_count += num;
        tt = $(this);
    })

    $('#total_count_'+type).html(total_count);
    $('#total_price_'+type).html(total_price.toFixed(2));
    update_discount_list();
}

//选择支付方式
$('#pay_type').change(function(event) {
    var val = $(this).val();
    $.post('<?php echo U("SupOrder/select_pay_way");?>', {val: val}, function(data) {
        if(data){
            $('#pay_method').html('<option value="0">--请选择支付方式--</option>');
            $('#pay_method').append(data);
        }
     }); 
});

//更新活动列表和优惠券列表
function update_discount_list(){

    var goods_ids= [];
    var prices   = [];
    var nums     = [];
    var total_price = Number($('#total_price_goods').html());
    $('.goods_list_goods').find('.goodsinfo').each(function(){
        var goods_id = $(this).attr('data-goodsid');
        var price    = $(this).find('.d-main input').val();
        var num      = $(this).find('.text_box').val();
        goods_ids.push(goods_id);
        prices.push(price);
        nums.push(num);
    });

    if(goods_ids.length > 0 && prices.length > 0 && goods_ids.length == prices.length){
        get_act_list(goods_ids,prices,nums);
        get_coupon_list(goods_ids,prices,nums);
        $('#discount_price').html(0);
        $('#new_total_price').html(total_price.toFixed(2));
    }

}

//获取活动列表
function get_act_list(goods_ids,prices,nums){

    $.post('<?php echo U("SupOrder/get_act_list");?>', {goods_ids:goods_ids,prices:prices,nums:nums}, function(data) {
        if(data.status == 1){
            $('#act_list').html(data.str);
        }else{
            $('#act_list').html('<option value="0">无</option>');
        }
    },'json');

}

//获得优惠券列表
function get_coupon_list(goods_ids,prices,nums){

    var location_id = $('#id_select').find('option:selected').attr('data-val');

    if(location_id == undefined){
        MsgBox('请选择门店再获取优惠券列表');
        return false;
    }

    $.post('<?php echo U("SupOrder/get_coupon_list");?>', {
        goods_ids:goods_ids,
        prices:prices,
        nums:nums,
        location_id:location_id
    }, function(data) {
        if(data.status == 1){
            $('#coupon_list').html(data.str);
        }else{
            $('#coupon_list').html('<option value="0">无</option>');
        }
    },'json');

}

$('#act_list,#coupon_list').change(function(){
    get_discount();
    if(Number($('#discount_price').html()) > 0)
        $('#discount_price').parent().parent().parent().show();
    else
        $('#discount_price').parent().parent().parent().hide();
});

$('#distribution_type').change(function(event) {
    /* Act on the event */
    if($(this).val() == 1)
        $('#express-name-block').show();
    else
        $('#express-name-block').hide();

});

$('#pay_method').change(function(event) {
    /* Act on the event */
    if($(this).val() == 7)
        $('#account-name-block').show();
    else
        $('#account-name-block').hide();
    var location_id = $('#id_select').find('option:selected').attr('data-val');
    if(location_id == undefined)
        return false;
    else{
        $.post('<?php echo U("SupOrder/get_pay_account");?>', {location_id: location_id}, function(data) {
            /*optional stuff to do after success */
            if(data.status==1){
                var html = '';
                $.each(data.info,function(i,n){
                    html += '<option value="'+n.id+'" data-val="'+n.balance+'">'+n.account+'(余额'+n.balance+')元</option>';
                });
                $('#account_name').append(html);
            }
        });
    }
});


function get_discount(){

    var total_price = Number($('#total_price_goods').html()),
        discount_price = 0,
        act_list = $('#act_list').val(),
        coupon_list = $('#coupon_list').val();

    if(act_list != 0){
        var act = act_list.split('_');
        if(act[3] == 1){
            discount_price += Number(act[2]);
        }
        if(act[3] == 2){
            if(Number(act[2])>0 && Number(act[2])<10){
                discount_price += Number(act[1])*((10-Number(act[2]))/10);
            }
        }
    }

    if(coupon_list != 0){
        var coupon = coupon_list.split('_');

        discount_price += Number(coupon[1]);
    }

    $('#discount_price').html(discount_price.toFixed(2));
    $('#new_total_price').html((total_price-discount_price).toFixed(2));

}


//获取商品信息并提交
$('.confirm').on('click', function(){
    var btn = $(this);
    if(btn.attr('disabled'))
        return false;

    var text = btn.text(),gid = [],
        gid_gift = [],price = [],num = [],num_gift=[],stock=[],stock_gift=[],
        means_of_payment = $('#pay_method').val(),
        reg = /^[1-9]\d*$/,
        coupon_list = $('#coupon_list').val().split('_'),
        act_list = $('#act_list').val().split('_');


    var goods_list = $('.goods_list_goods .goodsinfo');
    $.each(goods_list,function(index,item){
        var good_id = $(item).attr("data-goodsid");
        gid.push(good_id);
        var prices = $(item).find('.d-main input').val();
        price.push(prices);
        var nums   = $(item).find('.text_box').val();
        num.push(nums);
        var good_stock = $(item).attr("data-stock");
        stock.push(good_stock);
    });

    var goods_list_gift = $('.goods_list_gift .goodsinfo');
    $.each(goods_list_gift,function(index,item){
        var good_id = $(item).attr("data-goodsid");
        gid_gift.push(good_id);
        var nums   = $(item).find('.text_box').val();
        num_gift.push(nums);
        var good_stock = $(item).attr("data-stock");
        stock_gift.push(good_stock);
    });

    //确保json数据格式正确
    var args = {
        location_id: $('#id_select').find('option:selected').attr('data-val'),
        location_name: $('#location_name').text().trim(),
        receive_user:$('#receive_user').text().trim(),
        receive_tel:$('#receive_tel').text().trim(),
        receive_address:$('#receive_address').text().trim(),
        gid:gid,
        price:price,
        num:num,
        gid_gift:gid_gift,
        num_gift:num_gift,
        act_id:act_list[0],
        coupon_id:coupon_list[0],
        distribution_type: $('#distribution_type').val(),
        express:$('#express').val(),
        distribution_remark:$('#distribution_remark').val(),
        pay_type: $('#pay_type').val(),
        means_of_payment:means_of_payment,
        pay_remark:$('#pay_remark').val(),
        make_user_id:$('#select_maker').val(),
        make_user_name:$('#select_maker').find('option:selected').text().trim(),
        make_remark:$('#make_remark').val(),
        account_id:$('#account_name').val()
    };

    if(args.location_id == undefined){
        MsgBox('请选择门店');
        return false;
    };

    if(args.gid.length == 0){
        MsgBox('请选择商品');
        return false;
    };

    if(args.make_user_id == 0){
        MsgBox('请选择制单人');
        return false;
    };

    var is_price = 1,is_num = 1,is_stock = 1,is_stock_gift = 1;;
    $.each(args.price, function(i, n){
        if(n == '' || Number(n)<=0 || isNaN(n)){
            is_price = 0;
        }
    });
    $.each(args.num, function(i, n){
        if(n == '' || !reg.test(n)){
            is_num = 0;
        }
    });

    $.each(stock, function(i, n){
        if(Number(n)<=0){
            is_stock = 0;
        }
    });

    $.each(stock_gift, function(i, n){
        if(Number(n)<=0){
            is_stock_gift = 0;
        }
    });
    
    if(is_num == 0){
        MsgBox('数量必须为正整数');
        return false;
    };

    
    if(means_of_payment == 7 && Number($('#new_total_price').text().trim()) > Number($('#pay-balance-account').find('option:selected').attr('data-val'))){
        MsgBox('余额不足，请先充值或选择其他支付方式');
        return false;
    };
    if(is_stock == 0 || is_stock_gift == 0){
        popTipShow.confirm('库存报警','商品库存低于0是否继续开单?',['确 定','取 消'],
            function(e){
                //callback 处理按钮事件
                var button = $(e.target).attr('class');
                if(button == 'ok'){
                    //按下确定按钮执行的操作
                    this.hide();
                    btn.attr('disabled', true).text('正在处理');

                    $.post("<?php echo U('SupOrder/store_order_add');?>",args,function(data){
                        btn.removeAttr('disabled').text(text);
                        if(data && typeof(data.status) != 'undefined'){
                            if(data.status > 0){
                                MsgBox(data.msg);
                                var nexUrl = '<?php echo U("SupOrder/index");?>';
                                setTimeout("location.href='"+nexUrl+"'", 1000);
                            }else{
                                MsgBox(data.msg);
                            }
                        }else{
                            MsgBox('服务器未响应，请稍后重试');
                        }
                    },'json');

                }

                if(button == 'cancel') {
                    //按下取消按钮执行的操作
                    this.hide();
                }
            });
    }
});

</script>

<script src="__PUBLIC__/js/iscroll.js"></script>
<script src="__PUBLIC__/js/jquery.drawer.min.js"></script>