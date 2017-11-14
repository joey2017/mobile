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
<script type="text/javascript" src="__PUBLIC__/js/fastclick.js"></script>

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
body{position: relative; background: #eee;}


.goodsbox{margin-bottom: 1rem; background: #fff; border-bottom: 1px solid #e7e7e7;}

/*标题信息*/
.bundlev{height:40px; line-height: 40px; }
.tickbtn{width: 40px; height: 40px;display: inline-block;}
.tickico,.storeico,.tickNull{display: inline-block; width: 20px; height: 20px;    vertical-align: middle;}
.tickico{ background: url(__PUBLIC__/images/tick.svg) no-repeat; background-size: 40px;}
.tickNull{background: url(__PUBLIC__/images/tick.svg) no-repeat -20px 0; background-size: 40px;}

.storeico{ background: url(__PUBLIC__/images/store.svg) no-repeat; background-size: 20px;}
.editbtn{width: 48px; height: 40px;}

/*商品信息*/
.goodsinfo{background:#f8f8f8;}
.productlist{ margin-top: .09rem; padding-top: 12px; padding-bottom: 12px;}
.tickbtn2{width: 40px; height: 96px;line-height: 96px; display: inline-block;}
.leftimg{width: 96px; height: 96px; margin-right: 10px;}
.leftimg img{width: 100%; height: 100%;}
.rightinfo{padding-right: 10px; position: relative;}
.rightinfo h3{ line-height: 22px; margin: 3px; height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;  font-size: 12px;  word-break: break-all;}
.price{ color: #eb5211;font-size: 16px;}
.d-main{line-height: 28px;}
.d-main .pull-right{ color: #717171;}

/*编辑内容*/
.editinfo{display: none; position: absolute; top: 0; right: 0; height: 96px;background: #f8f8f8; width: 100%;}
.setbox{width: 100px;margin: 33px 0 0 10px;}
.set_meal{padding: 0;}
.set_meal li{overflow: hidden; margin-bottom: 7px;}
.min,.add{ width: 30px; text-align: center;background-color: #E6E6E6; padding: 0; border:0;  height: 30px;  line-height: 30px;}
.min{border-radius: 3px 0 0 3px;}
.add{border-radius:0 3px 3px 0;}
.text_box{width: 40px; text-align: center; height: 30px; border: 0; margin: 0 -4px; line-height: 30px;box-shadow: none;border-radius: 0;    background: #fbfbfb;
}
.delbtn{height: 96px; width: 50px; border:0; color: #fff; background: #f60;}

/*底部按钮*/
.sift_bottom{position:fixed; bottom: 0; right: 0; width: 100%; background:#fff;}
.sift_bottom .price{padding:14px 8px 0 0; display: inline-block; }
.wholebtn{width: 40px; height: 48px; line-height: 48px; display: inline-block;}
.sift_btn{ width:120px; height: 48px;color: #fff;  line-height: 48px; float: left; text-align: center;}
.sift_btn_ok button{background: #ea413e;color: #fff;border:0;}

.no_record{ height: 160px; width: 160px; background: url(__PUBLIC__/images/purchase.svg) no-repeat 21px 28px; background-size: 120px; background-color: #ef4a4a;  border-radius: 100px;  margin: 42px auto 23px auto;}

.sift_bottom2{position:fixed; bottom: 0; right: 0; width: 100%;}
.sift_bottom2 a{background: #ea413e;color: #fff;border:0;width:100%; height: 48px;line-height: 48px;text-align: center;}
</style>
<link rel="stylesheet" type="text/css" href="http://s.17cct.com/v3/js/dialog/skins/dialog.css" />
<script src="http://s.17cct.com/v3/js/dialog/artDialog.js?v=20141216"></script>
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<script type="text/javascript">
	$(function() {
        FastClick.attach(document.body);
    });
</script>
<?php if($cart_info != ''): if(is_array($cart_info)): $i = 0; $__LIST__ = $cart_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ci): $mod = ($i % 2 );++$i;?><div class="goodsbox" id="supplier_<?php echo ($ci["supplier_id"]); ?>">
		<div class="box_flex bundlev">
			<div class="flex1">
				<a class="tickbtn text-center"><span class="tickico supplier" data-val="<?php echo ($ci["supplier_id"]); ?>" id="supplier_<?php echo ($ci["supplier_id"]); ?>"></span></a>
				<i class="storeico"></i>
				<?php echo ($key); ?>
			</div>
			<div class="editbtn text-center">
				<a href="javascript:;" class="btn-block">编辑</a>
			</div>
		</div>
		<div class="goods_list">
			<?php if(is_array($ci['item'])): $i = 0; $__LIST__ = $ci['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="goodsinfo" id="cart_item_<?php echo ($item["id"]); ?>">
					<div class="productlist box_flex">
						<a class="tickbtn2 text-center"><span class="tickico goods_item" data-val="<?php echo ($item["id"]); ?>" name="supplier_goods_<?php echo ($ci["supplier_id"]); ?>"></span></a>
				    	<div class="leftimg">
				    		<a href="<?php echo U('Purchase/detail',array('id'=>$item['goods_id']));?>"><img src="<?php echo ($item["thumbnail"]); ?>"></a>
				    	</div>
				    	<div class="rightinfo flex1">
				    		<h3><a href="<?php echo U('Purchase/detail',array('id'=>$item['goods_id']));?>"><?php echo ($item["goods_name"]); ?></a></h3>
				    		<div class="d-main">
				    			<span class="price">￥:<?php echo (price($item["price"])); ?></span> 
				    			<span class="pull-right" id="item_num_<?php echo ($item["id"]); ?>">×<?php echo ($item["number"]); ?></span>
				    		</div>

				    		<!-- 编辑内容 -->
				    		<div class="editinfo">
				    			<div class="setbox pull-left">
									<input class="min" name="" type="button" value="-" onclick="modify_cart('m',this)"/>
									<input class="text_box" name="goodnum" type="text" id="goods_num_<?php echo ($item["id"]); ?>" data-price="<?php echo ($item["price"]); ?>" data="<?php echo ($item["id"]); ?>" data-val="<?php echo ($item["number"]); ?>" value="<?php echo ($item["number"]); ?>" onblur="update_number(<?php echo ($item["change_stock"]); ?>,this)"/>
									<input class="add" name="" type="button" value="+" onclick="modify_cart('a',this)"/>
								</div>
								<button class="pull-right delbtn" onclick="del_cart(<?php echo ($item["id"]); ?>)">删除</button>
				    		</div>
				    	</div>
			    	</div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
<div id="no_cart_goods" <?php if($cart_info != '' ): ?>style="display:none"<?php endif; ?> >
	<div class="no_record"></div>
	<p class="col-sm-12 text-center" style="font-size:16px;">您的购物车还是空的，赶紧去采购吧！</p>
	<div class="sift_bottom2">
		<a href="<?php echo U('Purchase/index');?>" class="btn-block">去采购</a>
	</div>
</div>
<div style="height:48px;"></div>

<div class="sift_bottom box_flex" id="sift_bottom" style="bottom: 50px;">
	<div class="flex1">
	<?php if($cart_info != ''): ?><a class="wholebtn text-center" id="do_select_all"><span id="select_all" class="tickico"></span></a>
		全选
		<span class="pull-right">合计: <span class="price" >￥<span id="total_price"><?php echo ($total["price"]); ?></span></span></span>
	</div>

		<div class="sift_btn sift_btn_ok">
			<button class="btn-block" id="check_order">确认采购（<span id="total_count"><?php echo ($total["count"]); ?></span>）</button>
		</div><?php endif; ?>
</div>


<!--底栏-->
<!--底栏-->
<link rel="stylesheet" type="text/css" href="__PUBLIC__/font-awesome/css/font-awesome.min.css">
<div style=" height: 50px;  clear: both;"></div>
<div class="container-fluid">
    <div class="bottombtn">
        <div class="col-xs-3"><a href="<?php echo U('Biz/entrance');?>" class="b_btn"><i class="fa fa-home"></i><div>首页</div></a></div>
        <div class="col-xs-3"><a href="<?php echo U('Purchase/home');?>"><i class="fa fa-map-o"></i><div>采购</div></a></div>
        <div class="col-xs-3"><a href="<?php echo U('Purchase/cart');?>"><i class="fa fa-shopping-cart"></i><div>购物车</div></a></div>
        <div class="col-xs-3"><a href="<?php echo U('Biz/my_home');?>"><i class="fa fa-user fa-fw"></i><div>我的</div></a></div>
    </div>
</div>


<script type="text/javascript">

	$('#check_order').click(function(){
		if($('#total_count').html()==0){
			MsgBox('至少选择一个商品');
			return false;
		}		
		var ids='';
		$('.goods_item').each(function(){
			if($(this).hasClass('tickico')){
				ids+=$(this).attr('data-val')+',';
			}
		})	
		window.location.href="<?php echo U('Purchase/check_order');?>?ids="+ids;
	})

	//选择提交订单的商品
	function change_item_info() {
		var total_price=0,price=0,total_count=0,num=0,item_id=0,submit=true;
		$('.goods_item').each(function(){
			if($(this).hasClass('tickico')){
				item_id=$(this).attr('data-val');
				price=parseFloat($('#goods_num_'+item_id).attr('data-price'));
				num=parseInt($('#goods_num_'+item_id).val());
				total_price+=price*num;
				total_count+=num;
			}
		})
		$('#total_count').html(total_count);
		$('#total_price').html(total_price);		
	}

	//选择店铺
	$('.supplier').click(function(){
		if($(this).hasClass('tickico')){
			$(this).removeClass('tickico').addClass('tickNull');
			$(this).parentsUntil('.goodsbox').siblings('.goods_list').find('.goods_item').removeClass('tickico').addClass('tickNull');
		}else{
			$(this).removeClass('tickNull').addClass('tickico');
			$(this).parentsUntil('.goodsbox').siblings('.goods_list').find('.goods_item').removeClass('tickNull').addClass('tickico');
		}
		check_select_all();
		change_item_info();
	})

	//选择商品
	$('.goods_item').click(function(){
		if($(this).hasClass('tickico')){
			$(this).removeClass('tickico').addClass('tickNull');
		}else{
			$(this).removeClass('tickNull').addClass('tickico');
		}

		var item_all='tickico',remove_all='tickNull';

		$(this).parentsUntil('.productlist').find('.goods_item').each(function(){
			if(!$(this).hasClass("tickico")){
				item_all='tickNull';
				remove_all='tickico';				    
			}
		})

		$(this).parentsUntil('.goodsbox').siblings().find('.supplier').removeClass(remove_all).addClass(item_all);
		check_select_all();
		change_item_info();
	})

	//全选
	$('#do_select_all').click(function(){
		var set_val='tickico',rem_val='tickNull';
		if($('#select_all').hasClass('tickico')){
			set_val='tickNull';
			rem_val='tickico'
		}
		$(".supplier,.goods_item,#select_all").removeClass(rem_val).addClass(set_val); 
		change_item_info();
	})	

	//判断店铺是否全选
	function check_select_all(){		
			var select_all='tickico',remove_all='tickNull';
			$('.supplier').each(function(){
				if(!$(this).hasClass("tickico")){
					select_all='tickNull';
					remove_all='tickico';
					return;
				}
			})
		$('#select_all').removeClass(remove_all).addClass(select_all);	
	}

	//修改购买数量
	function update_number(stock,_this){
		
		var update_num=parseInt($(_this).val()),id=parseInt($(_this).attr('data')),price=$(_this).parentsUntil('.goodsone').find('.goods_price').html(),num=parseInt($(_this).attr('data-val'));		

		if(isNaN(update_num)){
			$(_this).val($(_this).val().replace(/[^\d]/g,''));
			return false;
		}

		if(update_num>stock||update_num<=0){
			MsgBox('请输入正确购买数量');
			$(_this).val($(_this).attr('data-val'));
			return false
		}

		if(num==update_num){
			return;
		}		

		var type='a';
		if(num>update_num){
			type='m';
		}

		$(_this).attr('data-val',update_num);

		$.ajax({
	        url:"<?php echo U('Purchase/modify_cart');?>",
	        type:"POST",
	        data:{
	          "id":id,
	          "number":update_num,
	          "type":type
	        },
	        dataType:"json",
	        success:function(data){        		
	            if(data.status){	
	            	//$(_this).parentsUntil('.goodsone').find('.goods_stock').html(stock-update_num);
	            	$(_this).val(update_num);
	            	$('#item_num_'+id).html('×'+update_num)
	            	$(_this).parentsUntil('.goodsone').find('.goods_total_price').html((price*update_num).toFixed(2))
	            	$('#total_count').html(data.number);
	            	$('#total_price').html(data.total_price);
	            }else{
	            	MsgBox(data.info);
	            }
		    }
		});
		change_item_info();
	}

	//删除购买商品
	function del_cart(id){
		art.dialog({
			    content:'确定删除该商品？',
			    icon:'warning',
			    title:'删除商品',
			    ok: function () {			
					    $.ajax({
					        url:"<?php echo U('Purchase/delete_cart');?>",
					        type:"POST",
					        data:{
					          "id":id
					        },
					        dataType:"json",
					        success:function(data){        		
					            if(data.status){	
					            	//更新统计数据	   
					            	$('#cart_item_'+id).remove();  												            	
					            	$('#total_count').html(data.number);
					            	$('#total_price').html(data.total_price);
					            	$('.goodsbox').each(function(){					         	
										if($(this).find('.goods_list').html().trim() ==""){
											$(this).remove();			    
										}
									})
									if(data.number==0){
										$('#no_cart_goods').show();
										$('#sift_bottom').hide();
									}
					            }else{
					            	MsgBox(data.info);
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

	//商品加1或减1
	function modify_cart(type,_this){
			var num=parseInt($(_this).siblings('.text_box').val()),stock=parseInt($(_this).parentsUntil('.goodsone').find('.goods_stock').html()),buy_num=parseInt($('#total_count').html()),total_price=parseFloat($('#total_price').html()),goods_price=$(_this).parentsUntil('.goodsone').find('.goods_price').html(),id=parseInt($(_this).siblings('.text_box').attr('data'));
				if(num<=0){
					MsgBox('请输入正确购买数量');
					return false
				}
				if(type=='m'){
					num=num-1;
					buy_num=buy_num-1;
					total_price=total_price-goods_price;
					//stock=stock+1;
				}else{
					num=num+1;
					buy_num=buy_num+1;
					total_price=total_price+goods_price;
					//stock=stock-1;
				}
				$(_this).siblings('.text_box').attr('data-val',num);
				$.ajax({
			        url:"<?php echo U('Purchase/modify_cart');?>",
			        type:"POST",
			        data:{
			          "id":id,
			          "number":num,
			          "type":type
			        },
			        dataType:"json",
			        success:function(data){        		
			            if(data.status){		            
			            	//$(_this).parentsUntil('.goodsone').find('.goods_stock').html(stock);
			            	$(_this).siblings('.text_box').val(num);
			            	$('#item_num_'+id).html('×'+num)
			            	$(_this).parentsUntil('.goodsone').find('.goods_total_price').html((goods_price*num).toFixed(2))
			            	$('#total_count').html(data.number);
			            	$('#total_price').html(data.total_price);
			            }else{
			            	MsgBox(data.info);
			            }
				    }
				});

		}


		$(document).ready(function(){
	        $(".editbtn").click(function(){
	        	_this=$(this).find('a');
	        	if(_this.html()=='编辑'){
	        		_this.html('完成');
	        	}else{
	        		_this.html('编辑');
	        	}
	            $(this).parent().siblings().find(".editinfo").slideToggle(1);
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