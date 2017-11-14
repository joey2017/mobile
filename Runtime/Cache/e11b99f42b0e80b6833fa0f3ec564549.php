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
<style type="text/css">
  .successico {width: 95px;height: 95px;display: inline-block;background: url(http://www.17cct.com/statics/v5/images/success.svg) no-repeat 0 0;background-size: 8rem;margin-top: 60px;}
  .list_top{background:#e32424; overflow: hidden; padding:25px; }
  .shico{background:url(__PUBLIC__/images/authorize.svg) no-repeat; background-size: 100px;  width: 100px;  height: 100px; margin-bottom: 25px;}
  .msg{}
  .msg li{list-style:none;}
</style>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/font-awesome/css/font-awesome.min.css">
</head>
<body>
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<?php if($info): ?><div class="text-center">
    <div class="successico"></div>
    <h3 style="font-style: normal;font-size: 26px;color: #5e5e5e;margin-bottom: 30px;">您已授权微信消息推送</h3>
    <p class="col-xs-12" >
      <div class="col-xs-5 col-xs-offset-1 pull-left">
        <a href="<?php echo U('Supplier/index');?>" class="btn btn-lg btn-warning btn-block">返回</a>
      </div>
      <div class="col-xs-5">
        <button class="btn btn-danger btn-block btn-lg" onclick="del()" id="del-btn">取消授权</button>
      </div>
    </p>
  </div>
<?php else: ?>
  <div class="text-center">
    <div class="list_top">
      <div class="col-xs-12">
        <center>
          <div class="shico"></div>
          <h2 style="margin:0 0 15px 0; color:#fff; font-size: 18px;">授权微信推送模板消息给您？</h2>
        </center>
      </div>
    </div>
  </div>
  <div class="col-xs-12 msg" style="margin-top: 20px;margin-bottom: 20px;">
      <ul style="margin: 0; padding:0;">
        <li>
          <label style="color: #a1a1a1; font-weight: normal;">
            <input type="checkbox" checked="true" disabled="true"> 门店下单消息推送
          </label>
        </li>
      </ul>
    </div>
    <p class="col-xs-12" >
      <div class="col-xs-5 col-xs-offset-1 pull-left">
        <a href="<?php echo U('Supplier/index');?>" class="btn btn-danger btn-lg btn-warning btn-block">返回</a>
      </div>
      <div class="col-xs-5">
        <button class="btn btn-lg btn-block btn-warning" onclick="add()" id="add-btn">确认授权</button>
      </div>
    </p><?php endif; ?>

<script type="text/javascript">
  function add(){
    $.ajax({ 
        url:'<?php echo U("Supplier/authorize_add");?>',
        type:'post',
        dataType:'json',
        success: function(d){
            if(d.status == 1){
              $('#add-btn').attr('readonly',true);
            }
            MsgBox(d.info);  
            if(d.data){
              setTimeout(function() {location.href=d.data },2000);
            }
        }
    }); 
  }

  function del(){
    $.ajax({ 
        url:'<?php echo U("Supplier/authorize_del");?>',
        type:'post',
        dataType:'json',
        success: function(d){
            if(d.status == 1){
              $('#del-btn').attr('readonly',true);
            }
            MsgBox(d.info);  
            if(d.data){
              setTimeout(function() {location.href=d.data },2000);
            }
        }
    }); 
  }
</script>