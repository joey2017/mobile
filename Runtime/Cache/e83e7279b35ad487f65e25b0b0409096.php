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
<!--头部-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<div class="container-fluid topbox">
    <div class="row top">
        <div class="pg-Current">
        	<a href="javascript:history.back();" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
        	<img src="__PUBLIC__/images/shang.png" width="30" height="30">
        </div>
        <div class="pgt">
        	<a>提交订单</a>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<!--订单名-->
<div class="container-fluid dd_name">
	<div class="row">
			<div class="col-xs-12"><?php echo ($d["name"]); ?></div>
	</div>
</div>
<!--订单详细-->
<div class="container-fluid" >
<?php if($d['attr_str']): ?><div class="row ddxq">
      <div class="col-xs-3">属性:</div>
      <div class="col-xs-9"><p style=" text-align:right;"><strong><?php echo ($d["attr_str"]); ?></strong></p></div>
  </div><?php endif; ?>
	<div class="row ddxq">
			<div class="col-xs-8">单价:</div>
      <div class="col-xs-4"><p style=" text-align:right;"><strong id="price"><?php echo (price($d["current_price"])); ?>元</strong></p></div>
	</div>
  <div class="row ddxq">
			<div class="col-xs-4">数量:</div>
      <div style="float:right; margin:0 10px 0 0">
      	<div class="input-group input-group-sm" style="float:left;">
              <button id="minus" class="btn btn-default bd" type="button">-</button>
          </div>
          <div class="input-group input-group-sm" style="float:left; margin: 7px 5px 0 5px;">
            	<input type="tel" id="count" class="form-control" style="text-align:center; border-radius:5px; width:55px; height:34px;" value="1">
          </div>
          <div class="input-group input-group-sm" style="float:left;">
            	<button id="plus" class="btn btn-default bd" type="button">+</button>
          </div>
      </div>
	</div>
  <input type="hidden" id="coupon_code" name="coupon_code" value="">
  <input type="hidden" id="coupon_card_id" name="coupon_card_id" value="">
  <input type="hidden" id="discount_price" name="discount_price" value="">
  <div class="row ddxq">
			<div class="col-xs-8">总价:</div>
      <div class="col-xs-4"><p style="float:right; color:#ff7302;">¥<strong id="total_price"><?php echo (price($d["current_price"])); ?></strong></p></div>
	</div>
</div>

<?php if(($signature != null) AND ($sign != '') AND ($nonceStr != '') AND ($time != '')): ?><div class="container-fluid line" style="border-top:0;"></div>
  <div class="container-fluid" >
      <div class="row ddxq">
          <div class="col-xs-7">优惠：使用微信卡券</div>
          <a href="javascript:void(0)" onclick="choosecard(0);"><div class="col-xs-5"><p style="float:right;"><span id="load_img" style="color:#c6c6c6">未使用</span><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></p></div></a>
      </div>
  </div>
  
  <script type="text/javascript">
    wx.config({
          debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
          appId: 'wx7ea1cd13c9f42d97', // 必填，公众号的唯一标识
          timestamp: '<?php echo ($time); ?>', // 必填，生成签名的时间戳
          nonceStr: '<?php echo ($nonceStr); ?>', // 必填，生成签名的随机串
          signature:'<?php echo ($sign); ?>',// 必填，签名，见附录1
          jsApiList: ['chooseCard','openCard','addCard'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
      });

    //获取卡券列表
    //p7of3jnlFRHzOKr3ks8XrZIEbZM4 100元  5649/5650
    //p7of3jszx-C2Zp0JHbAqD3cypB3k 30元 5648/2330
    function choosecard(){
        $('#orderSubmit').attr('disabled',true);
        $('#load_img').html('<img src="__PUBLIC__/images/minilodging.gif" >');
        wx.chooseCard({
          shopId: '', // 门店Id
          cardType: '', // 卡券类型
          cardId: '', // 卡券Id
          timestamp: '<?php echo ($time); ?>', // 卡券签名时间戳
          nonceStr: '<?php echo ($nonceStr); ?>', // 卡券签名随机串
          signType: 'SHA1', // 签名方式，默认'SHA1'
          cardSign: '<?php echo ($signature); ?>', // 卡券签名
          success: function (res) {
                  if(<?php echo ($d["id"]); ?>!=5649&&<?php echo ($d["id"]); ?>!=5650&&<?php echo ($d["id"]); ?>!=5648&&<?php echo ($d["id"]); ?>!=2330){ 
                     not_use_coupon_msg();
                     return false;
                  }
                 var choose_card_info = JSON.parse(res.cardList);
                 var preferential=0;
                  if (choose_card_info[0].card_id!='') {  
                      if(<?php echo ($d["id"]); ?>==5649||<?php echo ($d["id"]); ?>==5650){                    
                        if(choose_card_info[0]['card_id']!='p7of3jnlFRHzOKr3ks8XrZIEbZM4'){                      
                              not_use_coupon_msg();
                              return false;
                        }
                        preferential=100;
                      }
                      if(<?php echo ($d["id"]); ?>==5648||<?php echo ($d["id"]); ?>==2330){
                        if(choose_card_info[0]['card_id']!='p7of3jszx-C2Zp0JHbAqD3cypB3k'){                      
                             not_use_coupon_msg();
                             return false;
                        }
                        preferential=30;
                      }
                      $('#coupon_card_id').val(choose_card_info[0]['card_id']);
                      var coupon_encrypt = choose_card_info[0].encrypt_code;
                        $.ajax({ 
                            type: 'post',
                            url: '<?php echo U("Order/getCode");?>',
                            data: {
                                'encrypt_code':coupon_encrypt,
                                'card_id':choose_card_info[0]['card_id'],
                                'deal_id':<?php echo ($d["id"]); ?>
                            },
                            dataType: 'json',
                            success: function(data1) {
                                if (data1.data.errmsg == 'ok') {
                                  coupon_code = data1.data.code;
                                  //更换卡券
                                  if($('#coupon_code').val()){
                                    //使用卡券前的总价
                                    var poor=parseFloat($('#total_price').text())+parseFloat($('#discount_price').val());
                                    if(poor-preferential<=0){
                                      not_use_coupon_msg();
                                      return false;
                                    }else{
                                      use_coupon_msg(preferential,coupon_code); 
                                      $('#total_price').text((poor-parseFloat(preferential)).toFixed(2)) 
                                    } 
                                  }else{
                                    if((parseFloat($('#total_price').text())-preferential)<=0){
                                      not_use_coupon_msg();
                                      return false;
                                    } 
                                     use_coupon_msg(preferential,coupon_code);
                                     $('#total_price').text((parseFloat($('#total_price').text())-parseFloat(preferential)).toFixed(2)) 
                                  }                                  
                                }else{
                                   not_use_coupon_msg();
                                   return false;
                                }                                
                            }
                        }) 
                      
                  }else{
                       not_use_coupon_msg();
                       return false;
                  }                  
          },cancel:function(){     
           $('#load_img').css('color','#c6c6c6');
          $('#load_img').html('未使用');
          if($('#discount_price').val()){
           $('#total_price').text((parseFloat($('#total_price').text())+parseFloat($('#discount_price').val())).toFixed(2)); 
           }  
          $('#discount_price').val(0);
          $('#coupon_code').val(0);
          $('#orderSubmit').attr('disabled',false); 
          }
      });
    }
    //能使用优惠券
    function use_coupon_msg(preferential,coupon_code){
      $('#coupon_code').val(coupon_code);
      $('#discount_price').val(preferential);
      $('#load_img').html('优惠'+preferential+'元');
      $('#load_img').css('color','red');  
      $('#orderSubmit').attr('disabled',false);
    }
    //不能使用优惠券
    function not_use_coupon_msg(){
        MsgBox('本服务不能使用该券');
        $('#load_img').css('color','#c6c6c6');
        $('#load_img').html('未使用');
        if($('#discount_price').val()){
         $('#total_price').text((parseFloat($('#total_price').text())+parseFloat($('#discount_price').val())).toFixed(2)); 
         }  
        $('#discount_price').val(0);
        $('#coupon_code').val(0);
        $('#orderSubmit').attr('disabled',false);                          
    }

</script><?php endif; ?>
<!--分割线-->
<!--您绑定的手机号-->
<div class="container-fluid dd_name" style="border-top:0;">
	<div class="row">
			<div class="col-xs-11">您绑定的手机号：</div>
	</div>
</div>
<div class="container-fluid" >
    <div class="row ddxq">
        <div class="col-xs-4"><?php echo ($mobile); ?></div>
        <div class="col-xs-8"><p style="float:right;"><a href="<?php echo U('User/account');?>" style="color:#c6c6c6">绑定新手机号<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p></div>
    </div>
</div>
<!--分割线-->
<div class="container-fluid line" style="border-top:0;"></div>



<div class="container-fluid" >
    <div class="row">
        <div class="col-xs-12" style="margin-top:25px;"><center><button type="button" id="orderSubmit" class="btn btn-warning btn-lg" style="padding-left:40px;padding-right:40px;" onclick="orderSubmit(this);">提交订单</button></center></div>
    </div>
</div>
<!--下面的空格要保留-->
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
$(function() {//检查购买次数
  var numLimit = '<?php echo ($numLimit); ?>';
  if (numLimit) {
      alert('您体验次数已达到'+numLimit+'次,无法享受1元特价');
  } 
});

var dsid = parseInt('<?php echo ($d["dsid"]); ?>');
var is_shop = parseInt('<?php echo ($d["is_shop"]); ?>');

$("#plus").click(function(){  //数量递增                
  var num = Number($('#count').val());  
      counts(num,'p');      
});   
$("#minus").click(function(){//数量递减
  var num = Number($('#count').val());  
      counts(num,'m');               
});
$("#count").blur(function(){//数量输入
     var num = Number($(this).val()); 
     if (ckNums(num)) {
          counts(num+1,'m');
     }else {
         $(this).val(1);
         MsgBox('请输入1-999的整数'); 
     }
     return false;
 });   

function counts(num,type){      
    var _num = $("#count"),
        _total = $("#total_price"),
        _submit = $("#orderSubmit"),
        price = parseFloat($('#price').text()),
        discount = parseFloat($('#discount_price').val()),
        code = $('#coupon_code').val(),
        nums = Number(num);
    if(type == 'm'){
      if(nums - 1 <= 0){
        _num.val(1);
        MsgBox('购买数量不能小于1');
        return false;
      }
      nums--;
    }else{
        nums++;
    }
    if(num >= 999){  
      _num.val(1);
      MsgBox('请输入1-999的整数');
      return false;   
    }else{  
        _submit.attr('disabled',true);
        if (dsid || is_shop == 1) { //有属性 检查库存
          $.ajax({
                type:'post',
                url: '<?php echo U("Order/ajaxModifyBuy");?>',
                dataType:'json',
                data:{"id":'<?php echo ($d["id"]); ?>',"number":nums,"is_shop":is_shop},
                success:function( d ){                            
                  if(d.status == 1){ 
                    _num.val(nums); 
                    if(code){
                      if((nums*price-discount)>0){
                         _total.text((nums*price-discount).toFixed(2));
                      }else{
                         MsgBox('本服务不能享受优惠');
                      }  
                    }else{
                      _total.text((nums*price).toFixed(2));
                    }
                    _submit.attr('disabled',false);
                  }else{
                    _num.val(1);
                    if(code){
                      if(price-discount>0){
                        _total.text((price-discount).toFixed(2));
                      }else{
                         MsgBox('本服务不能享受优惠');
                      }
                      
                    }else{
                      _total.text((price).toFixed(2));
                    }   
                    _submit.attr('disabled',false);
                    MsgBox(d.info);
                  }
                }
          });
        } else {
          _num.val(nums);                     
          if(code){             
              if((nums*price-discount)>0){
                   _total.text((nums*price-discount).toFixed(2));
                }else{
                   MsgBox('本服务不能享受优惠');
                }                      
            }else{
              _total.text((nums*price).toFixed(2));
            }
          _submit.attr('disabled',false);
        }     

    }
    return false;
}  

function orderSubmit(obj) {
    var _this = $(obj),
        _num = $('#count'),
        coupon_code = $('#coupon_code').val(),
        coupon_card_id = $('#coupon_card_id').val(),
        nums = Number(_num.val());
    if (!ckNums(nums)) {
        _num.val(1);
        MsgBox('请输入1-999的整数'); 
        return false;
    }
    _this.text('订单生成中').attr('disabled',true);
    MsgBox('请稍候，订单生成中'),
    $.ajax({
         type:'post',
         url: '<?php echo U("Order/ajaxOrderSubmit");?>',
         dataType:'json',
         data:{"id":'<?php echo ($d["id"]); ?>',"number":nums,"coupon_code":coupon_code,"coupon_card_id":coupon_card_id},
         success:function( d ){  
          if(d.status == 1){                         
            MsgBox(d.info,'',d.data);
          }else{
            _this.text('提交订单').attr('disabled',false);
            MsgBox(d.info);
          }
        }
    });
    return false;
}  
function ckNums(m) {
    var num = Number(m),
        ok = true; 
    if(!/^[0-9]*[0-9][0-9]*$/g.test(num) ){
        ok = false;
   }else if(num<1 || num>999){           
        ok = false;    
   }  
   return ok;
} 
</script>
<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script>

<script type="text/javascript" src="__PUBLIC__/js/scrolltopcontrol.js"></script>
<div style="display:none"> 
	<script>
		var _hmt = _hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "//hm.baidu.com/hm.js?196428f1e872f7a662e1bdf39f9953ca";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		})();
</script>


</div>
</body>
</html>