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

<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<link href="__PUBLIC__/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
.list_top{background:#eeb416; overflow: hidden; padding:25px; }

.disimg{ width: 64px;  height: 64px; margin-right: 10px;  border-radius: 50%; overflow: hidden; border: 4px solid #fff;}
.disimg img,.disimg_no img{width: 100%; height: 100%;}

.disimg_no {width: 64px;margin-right: 10px;}

.nametitle{font-size: 22px; color: #fff; font-weight: bold;}
.fxlisttitle{margin:10px 0 0 0;  padding-bottom: 5px; border-bottom: 1px solid #dcdcdc;}
.fxlisttitle span{display: inline-block; width: 30px; height: 30px; background-image: url(__PUBLIC__/images/distribution.svg); background-size: 148px;    vertical-align: middle;}
.shouru{background-position:-1px -38px;}
</style>

<div class="list_top">
    <div class="disimg<?php if($supplier["img"] == null): ?>_no<?php endif; ?> pull-left">
        <img src="__PUBLIC__/images/fenxiao.png">
    </div>
    <h3 class="nametitle"><?php echo ($supplier['name']); ?></h3>
</div>

<div class="col-xs-12">
<div class="fxlisttitle">
    <span class="shouru"></span>
    修改密码
</div>
</div>

<div class="container-fluid">   
    <div class="row">
        <div class="col-xs-12 xgbox">
                <!-- <h3>当前密码：</h3>
                <input type="password" class="input-weak" placeholder="请输入当前密码" id="old_pwd"/> -->
                <h3>新密码：</h3>
                <input type="password" class="input-weak" placeholder="请输入新密码（密码长度在6-16个字符之间）" id="new_pwd1"/>
                <h3>确认新密码：</h3>
                <input type="password" class="input-weak" placeholder="请输入确认新密码" id="new_pwd2" />
                <button type="button" class="btn btn-primary  btn-block  btn-warning" onclick="ModifySubmit(this);">确定</button>
         </div>
    </div>
</div>
<script type="text/javascript">

function ModifySubmit(obj) {
    var _this = $(obj),
        new_pwd1 = $.trim($("#new_pwd1").val()),
        new_pwd2 = $.trim($("#new_pwd2").val());

    if (!new_pwd1) {
        MsgBox("请输入新密码");
        return false;
    }
    if (new_pwd1.length<6 || new_pwd1.length>16) {
        MsgBox("密码长度在6-16个字符之间");
        return false;
    }
    if(!isAlphaNumeric(new_pwd1)){
        MsgBox("密码必须为字母或数字");
        return false;
    }
    if (!new_pwd2) {
        MsgBox("请确认密码");
        return false;
    }
    if (new_pwd1 != new_pwd2) {
        MsgBox("两次密码不一致");
        return false;
    } 
    _this.text('数据提交中').attr("disabled", true);
    $.ajax({
        url: "<?php echo U('Supplier/ajaxModifyPassWord');?>",
        type: 'post',
        data: {'new_pwd1':new_pwd1,'new_pwd2':new_pwd2},
        dataType: 'json',
        success: function(d) {
            if (d.status == 1) { 
              MsgBox(d.info,"",d.data);
            } else {
              _this.text('确定').attr("disabled", false);
              MsgBox(d.info);
            }
        }
    });
}
function isAlphaNumeric(val) {
    return (/^[a-zA-Z0-9]+$/.test(val));
}
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script>