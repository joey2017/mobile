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
.infotab{padding: 8px 10px; background:#fbfbfb; }
.addinfo{margin: 0;height: 24px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;  font-size: 14px;  word-break: break-all;}
.addinfo span{width: 22px; height: 24px;display:inline-block; vertical-align: middle; background-size: 38px}
.men{background-position:0px -19px;}
.tel{background-position:0px 3px;}
.add{background-position:-24px 3px;}
.bline{border-bottom: 1px solid #e6e6e6;}
.right_arrow{width: 13px;}
.purchasesvg{background-image: url(__PUBLIC__/images/address_ico.svg); background-repeat: no-repeat;}
.right_arrow span{width: 15px; height: 24px;  margin-top: 25px; display: block; background-position:-22px -19px; background-size: 36px;}

/*门店名*/
.bundlev{height:40px; line-height: 40px; padding: 0 10px;}
.bundlev p{margin: 0;}
.storeico{display: inline-block; width: 20px; height: 20px; vertical-align: middle;background: url(__PUBLIC__/images/store.svg) no-repeat; background-size: 20px; margin-right: 3px;}

/*产品列表*/
.productlist{overflow: hidden; padding: 12px 10px;}
.leftimg{width: 100px; height: 100px; margin-right: 10px;}
.leftimg img{width: 100%; height: 100%;}
.rightinfo h3{ line-height: 22px; margin: 3px; height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;  font-size: 14px;  word-break: break-all;}
.price{ color: #eb5211;font-size: 20px;}
.d-main{line-height: 28px;}
.d-main .pull-right{font-size: 12px; color: #717171;}

.inline{height: 5px; background: #eee; border-top: 1px solid #d0d0d0;}

/*底部按钮*/
.sift_bottom{position:fixed; bottom: 0; right: 0; width: 100%; background:#fff;}
.sift_bottom .price{padding:10px 3px 0 0; display: inline-block; }
.sift_bottom .flex1{padding:0 10px;border-top: 1px solid #e4e4e4;}
.sift_btn{ width:88px; height: 48px;color: #fff;  line-height: 48px; float: left; text-align: center;}
.sift_btn_ok button{background: #ea413e;color: #fff;border:0;}


</style>
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<div class=" o_f bline infotab">

	<a href="<?php if($address == null): echo U('Purchase/address_add');?>?r=1<?php else: echo U('Purchase/address_list'); endif; ?>" class="box_flex">		
		<div class="flex1">
			<?php if($address != ''): ?><p class="addinfo"><span class="purchasesvg men"></span>姓名：<?php echo ($address["name"]); ?></p>
				<p class="addinfo"><span class="purchasesvg tel"></span>电话：<?php echo ($address["tel"]); ?></p>
				<p class="addinfo"><span class="purchasesvg add"></span>地址：<?php echo ($address["full_address"]); ?></p>				
				<?php else: ?>
				<p style=" text-align: center; line-height: 30px; margin: 0;">+ 点击添加地址</p><?php endif; ?>
		</div>
		<?php if($address != ''): ?><div class="right_arrow"><span class="purchasesvg"></span></div><?php endif; ?>		
	</a>

</div>


<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><div class="bundlev bline">
		<span class="storeico"></span><?php echo ($g[0]["name"]); ?>
	</div>
	<input type="hidden" name="supplier_id[]" value="<?php echo ($key); ?>">
	<?php if(is_array($g)): $i = 0; $__LIST__ = $g;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gi): $mod = ($i % 2 );++$i;?><div class="productlist box_flex  bline">
			<div class="leftimg">
				<a href="<?php echo U('Purchase/detail',array('id'=>$gi['goods_id']));?>"><img src="<?php echo ($gi["thumbnail"]); ?>"></a>
			</div>
			<div class="rightinfo flex1">
				<h3><a href="<?php echo U('Purchase/detail',array('id'=>$gi['goods_id']));?>"><?php echo ($gi["goods_name"]); ?></a></h3>
				<div class="d-main">
					<span class="price">￥:<?php echo (price($gi["price"])); ?></span> 
					<span>/<?php echo ($gi["unit"]); ?></span>
					<span class="pull-right">× <?php echo ($gi["number"]); ?></span>
				</div>
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>	
	<!-- <div class="bundlev bline">
		<p>
			<span class="pull-left">配送方式：</span>	
			<span class="pull-right">快递</span>
		</p>
	</div> -->
	<!-- <div class="bundlev bline">
		<p>
			<span class="pull-left">商品金额：</span>
			<span class="pull-right">￥:80.00</span>
		</p>
	</div> -->
	<div class="bundlev bline">
		<p>
			<span class="pull-left">店铺活动：</span>
			<span class="pull-right">
			<select class="form-control activity"style=" border: 0; box-shadow: none; height:39px; padding:6px 10px;">
					
					<?php if($g[0]['activity'] != ''): ?><option value="0">选择活动</option>
						<?php if(is_array($g[0]['activity'])): $i = 0; $__LIST__ = $g[0]['activity'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$act): $mod = ($i % 2 );++$i;?><option value='<?php echo ($act["id"]); ?>_<?php echo ($act["act_store_price"]); ?>_<?php echo ($act["discount_money"]); ?>_<?php echo ($act["act_type"]); ?>'><?php echo ($act["act_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					  	<?php else: ?>
					  	<option value="0">暂无活动</option><?php endif; ?>
				</select>
			</span>
		</p>
	</div>
	<div class="bundlev bline">
		<p class="box_flex">
			<span class="flex1">优惠券：</span>
			<span class="flex1">
				<select class="form-control coupon"style=" border: 0; box-shadow: none; height:39px; padding:6px 10px;">
					
				    <?php if($g[0]['coupon'] != ''): ?><option value="0">使用优惠券</option>			  
						<?php if(is_array($g[0]['coupon'])): $i = 0; $__LIST__ = $g[0]['coupon'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$coupon): $mod = ($i % 2 );++$i;?><option value='<?php echo ($coupon["id"]); ?>_<?php echo ($coupon["discount_money"]); ?>'><?php echo ($coupon["coupon_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					  	<?php else: ?>
					  	<option value="0">暂无优惠券</option><?php endif; ?>
				</select>
			</span>
		</p>
		
	</div>
	<div class="bundlev bline">
		<p>
			<span class="pull-left">总计：</span>
			<span class="pull-right price">￥:<?php echo (price($gi["total_price"])); ?></span>
		</p>
	</div>
	<div class="bundlev o_f">
		<p>
			<textarea class="form-control" name="remark[]"  placeholder="备注" rows="1" style="padding: 10px 0; border: 0; box-shadow: none;"></textarea>
		</p>
	</div>
	<div class="inline"></div><?php endforeach; endif; else: echo "" ;endif; ?>

<input type="hidden" id="act_rule_id">
<input type="hidden" id="coupon_ids">
<input type="hidden" id="address_id" value="<?php echo ($address["id"]); ?>">

<div style="height:48px;"></div>
<div class="sift_bottom box_flex">
	<div class="flex1">
		<span class="pull-left">合计: <span class="price">￥<span id="total_price"><?php echo (price($total["price"])); ?></span></span></span>
	</div>
	<div class="sift_btn sift_btn_ok">
		<button class="btn-block" id="submit" >提交订单（<?php echo ($total["count"]); ?>）</button>
	</div>
</div>

<script type="text/javascript">
		$('#submit').click(function(){
			var remark = [],supplier_id = [];

			$("textarea[name='remark[]']").each(function(){
				remark.push($(this).val());
			});
			$('input[name="supplier_id[]"]').each(function(){
				supplier_id.push($(this).val());
			});

			var args = {
                act_rule_id:$('#act_rule_id').val(),
                coupon_ids:$('#coupon_ids').val(),
                address_id:$('#address_id').val(),
                remark:remark,
                supplier_id:supplier_id               
            };   

            if(args.address_id==0){
            	MsgBox('请添加收货地址');
            	return false;
            }

            //$('#submit').attr('disabled',true);
            $.ajax({
                    url:"<?php echo U('Purchase/create_order');?>",
                    type:"post",
                    data:args,
                    dataType:"json",
                    success:function(data){  
                        MsgBox(data.info);
                        if(data.status == 1){                           
                            window.location.href="<?php echo U('Purchase/order');?>?id="+data.order_id+"&t=pms_merge_order";
                        }
                    }
            });


		})

		$('.activity,.coupon').change(function(){
			get_discount();
		});

		function get_discount(){

			var total_price = Number(<?php echo ($total["price"]); ?>),discount_price = 0,act_rule_id = [],coupon_ids = [];

			$('.activity').each(function(){

				if($(this).val() != 0){
					var act = $(this).val().split('_');
					if(act[3] == 1){
						discount_price += Number(act[2]);
					}
					if(act[3] == 2){
						if(Number(act[2])>0 && Number(act[2])<10){
							discount_price += Number(act[1])*((10-Number(act[2]))/10);
						}
					}
					act_rule_id.push(act[0]);
				}

			});

			$('.coupon').each(function(){
				if($(this).val() != 0){
					var coupon = $(this).val().split('_');					
					discount_price += Number(coupon[1]);
					coupon_ids.push(coupon[0]);
				}
			});

			//$('#discount_price').html(discount_price.toFixed(2));
			$('#total_price').html((total_price-discount_price).toFixed(2));
			$('#act_rule_id').val(act_rule_id);
			$('#coupon_ids').val(coupon_ids);

		}

</script>
<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
  WeixinJSBridge.call('hideToolbar');
  WeixinJSBridge.call('hideOptionMenu');
});
</script>
</body>
</html>