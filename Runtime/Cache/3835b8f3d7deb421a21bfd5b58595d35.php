<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php if($title != null): ?>诚车堂<?php else: ?>诚车堂-全心全意为车主服务<?php endif; ?></title>
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
    /*支付方式*/
.payul{padding: 14px 0 0 0;}
.payul li{ list-style: none;  position: relative; padding: 10px; text-align: left; overflow: hidden; border: 1px solid #d2d2d2; cursor: pointer;  font-size: 12px;    margin-left: 2px;}
.payul li .pay_ico{  margin-right: 4px; font-size: 16px;vertical-align: middle;}
.payul li em{display: none;}
.pay_1{color: #48D238;}
.pay_2{color: #F34949;}
.pay_3{color: #49B2FD;}

.disabled .pay_1,.disabled .pay_2,.disabled .pay_3 {color: #ccc;}

.disabled {color: #ccc;}
.disabled span{ background-color: #ccc;}

.selected_pay{padding: 9px !important; border: 2px solid #ff5200 !important;}
.selected_pay em{display: block !important; position: absolute; bottom: -11px;  right: -16px; width: 35px; text-align: center; height: 28px; background: #ff5200; color: #fff; position: absolute; transform: rotate(-45deg); -o-transform: rotate(-45deg); -webkit-transform: rotate(-45deg); -moz-transform: rotate(-45deg);} 
.selected_pay em  i{transform: rotate(45deg); -o-transform: rotate(45deg); -webkit-transform: rotate(45deg); -moz-transform: rotate(45deg); } 
</style>

<!--订单名称-->
<div class="container-fluid" >
    <div class="row ddxq" style="line-height:27px; padding-top:10px; padding-bottom:10px;">
        <div class="col-xs-12"><p>交易编号：<?php echo ($oi["order_sn"]); ?></p></div>
    </div>
     <div class="row ddxq">
        <div class="col-xs-12"><p>创建时间：<?php echo (date("Y-m-d H:i:s",$oi["create_time"])); ?></p></div>
    </div>
     <div class="row ddxq">
        <div class="col-xs-12"><p>订单总价：<?php echo (price($oi["total_price"])); ?>元</p></div>
    </div>
</div>




<style type="text/css">
.wxtxt {color: #b9b9b9;}
.play_span{ font-size: 31px; margin-right: 10px; margin-top: 7px;  width: 40px;  text-align: center; }
</style>
<link href="http://s.17cct.com/v5/css/font-awesome.min.css" rel="stylesheet">
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<!--支付方式-->
<div class="container-fluid" >
	<div class="row ddxq">
			<div class="col-xs-8">您需要支付:</div>
            <div class="col-xs-4"><p style="float:right; color:#ff7302;"><strong><?php echo (price($oi["total_price"])); ?>元</strong></p></div>
	</div>
    <?php if($oi['pay_status'] == 0 && $oi['type'] == 0): ?><div class="row ddxq">
            <div class="col-xs-10" style="margin-bottom:10px;">
            	<img src="__PUBLIC__/images/weixin.png" width="30" height="30" class="wxico">
                <h3 class="wxzf">微信支付</h3>
                <p class="wxtxt">推荐安装微信5.0及以上版本使用</p>
            </div>
            <div class="col-xs-2">
                <input type="radio" name="pay_mode" value="2" checked style="float:right; margin-top:20px;">
            </div>
        </div>
        

        <div class="row ddxq">
            <div class="col-xs-10" style="margin-bottom:10px;">
                <span class="pull-left play_span" style="color: #f9ae21;"><i class="fa fa-cny"></i></span>
                <h3 class="wxzf">现金支付</h3>
                <p class="wxtxt"></p>
            </div>
            <div class="col-xs-2">
                <input type="radio" name="pay_mode" value="3" style="float:right; margin-top:20px;">
            </div>
        </div>

        <div class="row ddxq">
            <div class="col-xs-10" style="margin-bottom:10px;">
                <span class="pull-left play_span" style="color: #77d4e4;"><i class="fa fa-credit-card"></i></span>
                <h3 class="wxzf">刷卡支付</h3>
                <p class="wxtxt"></p>
            </div>
            <div class="col-xs-2">
                <input type="radio" name="pay_mode" value="4" style="float:right; margin-top:20px;">
            </div>
        </div>

        <div class="row ddxq">
            <div class="col-xs-10" style="margin-bottom:10px;">
                <span class="pull-left play_span" style="color: #f56f6f;"><i class="fa fa-exchange"></i></span>
                <h3 class="wxzf">转账支付</h3>
                <p class="wxtxt"></p>
            </div>
            <div class="col-xs-2">
                <input type="radio" name="pay_mode" value="5" style="float:right; margin-top:20px;">
            </div>
        </div>
        <div id="line_div" style="display:none">
            <textarea class="form-control" rows="2" placeholder="填写支付备注" style="margin-top: 15px;" id="pay_remark"></textarea>
            <ul class="text-center flex payul">
                <li class="col-xs-inner  disabled" data='1'>
                    <i class="fa fa-yen pay_ico pay_1"></i>现金挂账
                    <em><i class="fa fa-check"></i></em>
                </li>
                <li class="col-xs-inner disabled" data='2'>
                    <i class="fa fa-calendar pay_ico pay_2"></i>月底挂账
                    <em><i class="fa fa-check"></i></em>
                </li>
                <li class="col-xs-inner disabled" data='3'>
                    <i class="fa fa-edit pay_ico pay_3"></i>约定挂账
                    <em><i class="fa fa-check"></i></em>
                </li>
            </ul>
        </div>
    <?php else: ?>
         <div class="row ddxq">              
            <div class="col-xs-12"><p>确认方式：<?php echo ($oi["pay_type"]); ?></p></div>                 
        </div><?php endif; ?>
</div>




<div class="container-fluid" >

    <div class="row">
        
            <div class="col-xs-12" style="margin-top:25px;"><center><button type="button" class="btn btn-danger btn-lg" <?php if($oi['pay_status'] == 0 && $oi['type'] == 0): ?>id="submit"   <?php else: ?> id="confirm"<?php endif; ?>style="padding-left:40px;padding-right:40px;">确认订单</button></center></div>
       
    </div>
</div>


<script type="text/javascript">
    $('.col-xs-inner').click(function(){
        if(!$(this).hasClass('disabled'))
        $(this).addClass('selected_pay').siblings().removeClass('selected_pay');
    })
</script>


<!--下面的空格要保留-->
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<script type="text/javascript">
    $('input:radio[name="pay_mode"]').click(function(){
       if($(this).val()==2){
            $('#line_div').hide();
            $('.col-xs-inner').removeClass('selected_pay').addClass('disabled');
       }else{
        $('#line_div').show();
        $('.col-xs-inner').removeClass('disabled');
       }
    })
    $('#submit').click(function(){
       
        var pay_mode=parseInt($('input:radio[name="pay_mode"]:checked').val()),pay_type=0,pay_remark=$('#pay_remark').val();        
        if(pay_mode==2){
            window.location.href="<?php echo U('Pay/purchase_go_pay');?>?id=<?php echo ($oi["id"]); ?>";
        }else{
             $('.col-xs-inner').each(function(){
                if($(this).hasClass('selected_pay')){
                    pay_type=$(this).attr('data');
                }
             })

             if(pay_type==0){
                MsgBox('线下支付请选择挂账方式');
                return false;
             }
             if(pay_remark==''){
                MsgBox('线下支付请填写支付备注');
                return false;
             }
            $('#submit').attr('disabled',true);
            $.ajax({
                    url:"<?php echo U('Purchase/offline_pay');?>",
                    type:"post",
                    data:{'pay_mode':pay_mode,'pay_remark':pay_remark,'pay_type':pay_type,'id':<?php echo ($oi["id"]); ?>},
                    dataType:"json",
                    success:function(data){  
                        MsgBox(data.msg)
                        if(data.status == 1){
                           window.location.href="<?php echo U('Purchase/pay_back');?>?id=<?php echo ($oi["id"]); ?>";
                        }else{
                            $('#submit').attr('disabled',false);
                        }
                }
            }); 
        }
    })

    $('#confirm').click(function(){
         $('#confirm').attr('disabled',true);
          $.ajax({
                    url:"<?php echo U('Purchase/confirm_order');?>",
                    type:"post",
                    data:{'id':<?php echo ($oi["id"]); ?>},
                    dataType:"json",
                    success:function(data){ 
                        MsgBox(data.msg)
                        if(data.status == 1){
                           window.location.href="<?php echo U('Purchase/pay_back');?>?id=<?php echo ($oi["id"]); ?>&type=confirm";
                        }else{
                            $('#confirm').attr('disabled',false);
                        }
                }
            }); 
    })
</script>
<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script>
</body>
</html>