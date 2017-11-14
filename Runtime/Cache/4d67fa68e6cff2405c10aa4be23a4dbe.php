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

<body class="drawer drawer-right">
<link href="__PUBLIC__/css/mobiscroll_date.css" rel="stylesheet" />
<script src="__PUBLIC__/js/mobiscroll_date.js" charset="gb2312"></script>
<script src="__PUBLIC__/js/mobiscroll.js"></script>
<link rel="stylesheet" href="__PUBLIC__/css/iconfont.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/text.css"/>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/bootstrap-select.css">
<script type="text/javascript" src="__PUBLIC__/js/bootstrap-select.js"></script>
<script src="__PUBLIC__/js/sup.common.js"></script>
<style type="text/css">

/*主要数据*/
.main_data{ overflow: hidden; color: #fff; }
.box-flex{ display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox;  display: flex; }
.turnover h5{font-size: 20px; color: #ff3e3e; font-weight: bold;margin-bottom: 4px}
.turnover{padding: 7px 0;}

.data_rb{border-right:1px solid #eee;}

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

/*布局样式重置*/
a{color: #333;}
a:focus,a:active, a:hover{color: #333; text-decoration: none;}
.topsearch{height: 34px; margin:10px 0;}

/*筛选按钮*/
.screen{height: 42px; clear: both; text-align: center; border-bottom:1px solid #e2e2e2; padding: 5px 0; position: relative;}
.screen .col-xs-4 {padding-left: 0; padding-right: 0;}
.sepline{border-right:1px solid #e2e2e2;}
.searchbtn button{width: 80px; height: 33px; border:0; background: #f6a915; color: #fff; border-radius: 5px; margin-top: 10px}

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
</style>

<div class="">
    <div class="main_data text-center" style="overflow: visible;">
        <div class="topsearch box_flex" id="flag">
            <select id="id_select" class="selectpicker col-xs-12" data-live-search="true" name="location_name" style="">
                <option value="0">--请选择门店--</option>
                <?php if(is_array($location)): foreach($location as $key=>$l): ?><option value="<?php echo ($l["id"]); ?>" data-val="<?php echo ($l["location_id"]); ?>"><?php echo ($l["location_name"]); ?></option><?php endforeach; endif; ?>
            </select>
        </div>
    </div>

    <div class="screen">
        <div class="col-xs-6 sepline" style="margin-top: -7px;">
            <input class="form-control mobiscroll" readonly="true" id="start_time" name="start_time" type="text"
                   placeholder="开始时间">
        </div>
        <div class="col-xs-6" style="margin-top: -7px;">
            <input class="form-control mobiscroll" readonly="true" id="end_time" name="end_time" type="text"
                   placeholder="结束时间">
        </div>
    </div>

    <div class="container-fluid line"></div>

    <!-- 历史营业额 -->
    <div id="location_info" >
        <div class="box-flex text-center">
            <div class="flex1 turnover data_rb head_border">
                <h5><span id="total_num"></span></h5>
                <p>订单数量</p>
            </div>

            <div class="flex1 turnover head_border">
                <h5><span id="total_price"></span></h5>
                <p>订单总金额</p>
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
            <div class="topsearch col-xs-12"  style="border-top: 1px solid #e6e6e6;">
                <div class="searchbtn" style="float:right;"><button type="button" style="width:80px;" onclick="deal_record()">交易记录</button></div>
            </div>
        </div>

    </div>

    <div style="display: block;height: 50px"></div>
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

    <script>
        mob.timePlugin();

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
            var end_time = $("#end_time").val();
            var start_time = $("#start_time").val();

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

            $.post('<?php echo U("SupSale/get_sales_summary");?>', {id: id,end_time: end_time,start_time: start_time}, function(data) {
                if(data.status == 1){
                    $('#total_num').html(data.results.total_num);
                    $('#total_price').html(data.results.total_price * 1);
                }else{
                    $('#total_num').html('');
                    $('#total_price').html('');
                }
            },'json');
        }
    </script>
</div>