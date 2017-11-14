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
<link href="http://s.17cct.com/v5/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

<style type="text/css">
html,body{margin: 0; padding: 0; height: 100%;}
.bossbg{position: relative; width: 100%; min-height: 100%; background: url(__PUBLIC__/images/bossbg.jpg) no-repeat 0 0 ; background-size: 100%;}
.sign_in_logo{width: 100px; height: 210px; margin: 0 auto;  background: url(http://www.17cct.com/statics/v5/images/erp/logo2.png) no-repeat center 110px; background-size: 95px;}

.bossbox {width: 220px;margin: 50px auto;  }

.dlbox{ width: 220px; margin: 15px auto; border-bottom: 1px solid #F1F1F1; height: 46px;position: relative;}
.dlbox span{ width: 27px; height: 30px; display:inline-block; background-image: url(__PUBLIC__/images/dlico.svg); background-repeat: no-repeat; background-size: 27px;}
.spanbg01{ background-position: 0 4px;}
.spanbg02{ background-position: 0 -31px;}
.dlbox input{ border:0; color: #fff; outline:none; background-color:transparent; vertical-align:middle; width: 170px; height: 35px; margin-top: -17px; margin-left: 10px; font-size: 16px;}
.dltab{width: 220px; margin: 15px auto; padding: 0 8px; color: #fff;}
.dltab i{font-size: 19px; margin-right: 15px; vertical-align: middle;}
.dltab span,.dltab i{cursor:pointer;}
.dltab .fa-square-o{ color: #ccc;}
.dltab .fa-check-square{color: #cd0000;}
.dlbtn{ width: 220px; height: 50px; line-height: 50px; font-size: 20px; display: block; margin:0 auto;   color: #fff;   background:#ef2626; border-radius: 6px;}
.dlbtn:hover{
    color: #fff;
}

@media (min-width: 601px){
.bossbg{width: 601px; margin:0 auto;}
}
</style>

<div class="bossbg">
    <!-- 标志 -->
    <div class="sign_in_logo"></div>

    <div class="bossbox">
        <div class="dlbox">
            <span class="spanbg01"></span>
            <input type="text" class="search" id="biz_name" name="biz_name" value="<?php if($account_name != null): echo ($account_name); else: ?>请输入账号<?php endif; ?>" dat="请输入账号" >
        </div>
        <div class="dlbox">
            <span class="spanbg02"></span>
            <input type="password"class="search" id="biz_password" name="biz_password" value="<?php if($account_pwd != null): echo ($account_pwd); else: ?>请输入密码<?php endif; ?>"  dat="请输入密码">
            
        </div>
        <div class="dltab">
            <label for="checkbox1">
                <i class="fa fa-square-o" id="effect"></i><span id="jzmm">记住密码</span>
            </label>
        </div>
        <a id="btn_submit" class="dlbtn text-center">登录</a>
        <p style="color:#fff; font-size:12px; text-align:center; height:25px; margin-top:25px;">Copyright© 2012-<?php echo date('Y');?>  ITBOSS店面管理系统v3.0</p>
    </div>
</div>


 <!--弹出提示框-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<script>
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
   $(function(){
      $(".search").focus(function(){
        if($(this).val()==$(this).attr("dat")){
          $(this).val("")
        }
      }).blur(function(){
        var _v=$(this).attr("dat")
        if($(this).val()==_v || $(this).val()==''){
          $(this).val(_v);
        }
      })

      $( ".qk" ).click(function() {
            if($(this).attr("attr")=='name'){
          $('#biz_name').val('')
        }else{
          $('#biz_password').val('')
        }
        
        });
      $( "#jzmm,#effect" ).click(function() {
          $( "#effect" ).toggleClass( "fa-check-square", 0 );
          return false;
        });
    })
$(function(){
    $("#btn_submit").click(function(){
        var username = $("#biz_name").val();
        var password = $("#biz_password").val();
        var reg=/^[a-zA-Z0-9]\w{5,17}$/;
        if (username == '') {
            MsgBox("用户名不能为空！");
            return false;
        }else{
            $("#error_username").hide();
        } 
        /*else if (reg.test(username) == false) {
            $("#error_username").text("请输入6-18位数字或字母！").show();
            return false;
        } */
         if (password == '') {
            MsgBox("密码不能为空！");
            return false;
        }else{
                $("#error_password").hide();
        } /*else if (reg.test(password) == false) {
            $("#error_password").text("请输入6-18位数字或字母！").show();
            return false;
        }*/ 
        var remember=0;
        if($('#effect').hasClass('fa-check-square')){
          remember=1
        }
        var parme = {
            "username": username,
            "password": password,
            "remember": remember
        };
        $.post("<?php echo U('Biz/ajax_login');?>", parme, function(data) {
            if (data.status) {
                location.href = data.info;
            } else {
                MsgBox(data.info);
            }
        })
        
    });
});
</script>

</body>
</html>