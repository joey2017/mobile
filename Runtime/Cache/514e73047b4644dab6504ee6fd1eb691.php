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
/*布局样式重置*/
.tab_parent{padding-left: 15px;}
.tab_subset{margin:0; padding: 0 15px 0 0;}
a{color: #333;}
a:focus,a:active, a:hover{color: #333; text-decoration: none;}
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}
body{position: relative;}
.o_f{overflow: hidden;}

/*地址*/
.addinfo{padding: 10px; border-bottom: 5px solid #eee;}
.addinfo .bline p{padding: 0 0 6px 0; margin:0; line-height: 25px; }
.bline{border-bottom: 1px solid #e6e6e6;}

.infobtn p{margin: 10px 0 0 0; line-height: 33px;}

.tickbtn{display: inline-block;}
.tickico,.tickNull{display: inline-block; width: 20px; height: 20px;    vertical-align: middle;}
.tickico{ background: url(__PUBLIC__/images/tick.svg) no-repeat; background-size: 40px;}
.tickNull{background: url(__PUBLIC__/images/tick.svg) no-repeat -20px 0; background-size: 40px;}

/*底部按钮*/
.sift_bottom{position:fixed; bottom: 0; right: 0; width: 100%;}
.sift_bottom a{background: #ea413e;color: #fff;border:0;width:100%; height: 48px;line-height: 48px;text-align: center;}

.no_record{height: 24px;  padding-top: 205px;  text-align: center;  background: url(http://s.17cct.com/v5/images/erp/empty.png) no-repeat center 20px;  background-size: 180px 180px;}
</style>
<link rel="stylesheet" type="text/css" href="http://s.17cct.com/v3/js/dialog/skins/dialog.css" />
<script src="http://s.17cct.com/v3/js/dialog/artDialog.js?v=20141216"></script>

<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>

<?php if($address_list != ""): if(is_array($address_list)): $i = 0; $__LIST__ = $address_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$al): $mod = ($i % 2 );++$i;?><div class="o_f addinfo">
			<div class="bline">
				<p class="o_f ">
					<span class="pull-left"><?php echo ($al["name"]); ?></span>
					<span class="pull-right"><?php echo ($al["tel"]); ?></span>
				</p>
				<p >
					<?php echo ($al["full_address"]); ?>
				</p>
			</div>
			<div class="infobtn">
				<p>
					<span>
						<a class="tickbtn text-center"><span id="default_<?php echo ($al["id"]); ?>" onclick="set_default(<?php echo ($al["id"]); ?>,this)"  class="default <?php if($al["is_default"] == 1): ?>tickico<?php else: ?>tickNull<?php endif; ?>"></span> 设为默认</a>
					</span>
					<span class="pull-right">
						<a class="btn btn-default btn-sm" href="<?php echo U('Purchase/address_edit',array('id'=>$al['id']));?>">编辑</a>
						<button class="btn btn-default btn-sm" onclick="del_address(<?php echo ($al["id"]); ?>)" >删除</button>
					</span>
				</p>
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
<?php else: ?>
<div class="no_record col-sm-12">暂无数据</div><?php endif; ?>

<script type="text/javascript">
	function set_default(id,_this) {
		if($(_this).hasClass('tickico')){
			window.location.href="<?php echo U('Purchase/check_order');?>?ids=<?php echo ($ids); ?>";
			return;
		}
		 $.ajax({
		        url:"<?php echo U('Purchase/ajax_set_default');?>",
		        type:"POST",
		        data:{
		          "id":id
		        },
		        dataType:"json",
		        success:function(data){   
		        	MsgBox(data.msg);     		
		            if(data.status){	
		            	$('.default').removeClass('tickico').addClass('tickNull');
		            	$(_this).removeClass('tickNull').addClass('tickico');
		            	window.location.href="<?php echo U('Purchase/check_order');?>?ids=<?php echo ($ids); ?>";
		            }
			    }
		}); 
	}

	function del_address(id){
		if($('#default_'+id).hasClass('tickico')){
			MsgBox('不能删除默认地址');
			return false;
		}
		art.dialog({
			    content:'确定删除该地址？',
			    icon:'warning',
			    title:'删除地址',
			    ok: function () {			
					    $.ajax({
					        url:"<?php echo U('Purchase/ajax_address_del');?>",
					        type:"POST",
					        data:{
					          "id":id
					        },
					        dataType:"json",
					        success:function(data){   
					        	MsgBox(data.msg);     		
					            if(data.status){	
					            	setTimeout(function(){					            		
							        	window.location.reload();
					            	},2000)
					            }
						    }
					}); 
			    },
			    width:'200px',
	    		height:'80px',
			    cancelVal: '取消',
			    cancel:function(){}
			});	
	}
</script>
<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script>

<div style="height:48px;"></div>
<div class="sift_bottom">
	<a href="<?php echo U('Purchase/address_add');?>" class="btn-block">添加新地址</a>
</div>

</body>
</html>