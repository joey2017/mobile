<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" /><title>核销记录</title><link rel="stylesheet" href="__PUBLIC__/css/iconfont.css" /><link rel="stylesheet" href="__PUBLIC__/css/reset.css" /><link rel="stylesheet" href="__PUBLIC__/css/bootstrap.min.css" /><link rel="stylesheet" type="text/css" href="__PUBLIC__/css/materialize.min.css"/><link rel="stylesheet" type="text/css" href="__PUBLIC__/css/text.css"/><link rel="stylesheet" type="text/css" href="__PUBLIC__/css/css.css?v=20150617"><script type="text/javascript" src="__PUBLIC__/js/jquery.js" ></script><script type="text/javascript" src="__PUBLIC__/js/materialize.min.js" ></script><script type="text/javascript" src="__PUBLIC__/js/wap_v4_common.js"></script><style type="text/css">			.no_record{height: 24px;  padding-top: 205px;  text-align: center;  background: url(http://s.17cct.com/v5/images/erp/empty.png) no-repeat center 20px;  background-size: 180px 180px;}
		</style></head><body><div class="alertBg" id="msgBox" style="display:none;"><h4 class="alerttitle" id="alerttitle"></h4><span class="vm f20" id='alertdetail'></span></div><div class=""><div class="identifier">订单编号：<?php echo ($result["order_sn"]); ?><span><?php echo ($result["status_msg"]); ?></span></div><div class="container-fluid row money"><div class="col s4"><h2>¥<?php echo (price($result["total_price"])); ?></h2><p>订单金额</p></div><div class="col s4"><h2>¥<?php echo (price($result["paid_amount"])); ?></h2><p>已销金额</p></div><div class="col s4"><h2>¥<?php echo (price($result["unpay"])); ?></h2><p>未核销金额</p></div></div><div class="identifier record">核销记录</div><!--主要消息 开始--><?php if($paid != null): ?><ul class="record-all"><?php if(is_array($paid)): foreach($paid as $key=>$p): ?><li class="row container-fluid"><div class="col s6 record-left"><p>核销时间：<span><?php echo (date("Y-m-d",$p["pay_time"])); ?></span></p><p>余额支付账户：<span><?php if($p['means_of_payment'] == 7): echo ($p["recharge_account"]); else: ?>-<?php endif; ?></span></p><p>结算账户：<span><?php echo ($p["bank_name"]); ?></span></p><p>备注：<span><?php echo ($p["pay_detail"]); ?></span></p></div><div class="col s6 record-left"><p>支付方式：<span><?php echo ($p["pay_msg"]); ?></span></p><p>本次核销金额：<span><?php echo (price($p["price"])); ?></span></p><p>收款人：<span><?php echo ($p["settlement_staff_name"]); ?></span></p></div></li><?php endforeach; endif; ?></ul><?php else: ?><div class="no_record col-sm-12">暂无数据</div><?php endif; ?><div class="append"><a href="javascript:;" class="waves-effect">+添加核销</a></div><div class="popup"></div><div class="popup-all"><div class="popup-conter"><div class="row container-fluid append-top"><div class="col s6"><i class="iconfont icon-arrow-left"></i></div><div class="col s6"><p>添加核销</p></div></div><!--请选择 start--><ul class="ap-conter"><li><!-- <div style="pointer-events:none;"><i class="iconfont icon-jiantou-copy-copy"></i></div> --><select name="payment"><option value="0">-结算方式-</option><?php if(is_array($payments)): foreach($payments as $key=>$p): ?><option value="<?php echo ($key); ?>"><?php echo ($p); ?></option><?php endforeach; endif; ?></select></li><li><!-- <div style="pointer-events:none;"><i class="iconfont icon-jiantou-copy-copy"></i></div> --><select name="recharge_id"><option value="0">-余额支付账户-</option><?php if(is_array($recharge_account)): foreach($recharge_account as $key=>$ra): ?><option value="<?php echo ($ra["id"]); ?>" data-account="<?php echo ($ra["account"]); ?>"><?php echo ($ra["account"]); ?>(<?php echo ($ra["balance"]); ?>)</option><?php endforeach; endif; ?></select></li><li><!-- <div style="pointer-events:none;"><i class="iconfont icon-jiantou-copy-copy"></i></div> --><select name="account"><option value="0">-结算账户-</option><?php if(is_array($account)): foreach($account as $key=>$a): ?><option value="<?php echo ($a["id"]); ?>"><?php echo ($a["bank_name"]); ?></option><?php endforeach; endif; ?></select></li><li><strong class="jiner">本次核销金额</strong><strong class="shuru"><input type="text" placeholder="请输入金额" name="price" style="width:200px;padding-right: 20px;text-align: right;"/></strong></li><li><!-- <div style="pointer-events:none;"><i class="iconfont icon-jiantou-copy-copy"></i></div> --><select name="employee"><option value="0">-收款人-</option><?php if(is_array($employee)): foreach($employee as $key=>$e): ?><option value="<?php echo ($e["id"]); ?>"><?php echo ($e["name"]); ?></option><?php endforeach; endif; ?></select></li><li><strong class="jiner">备注</strong><strong class="shuru"><input type="text" placeholder="请输入金额" name="remark" style="width:200px;padding-right: 20px;text-align: right;"/></strong></li><li class="queren waves-effect" onclick="receipt_submitForm();">确认收款</li></ul><!--请选择 end--></div></div><div style="height:50px;"></div><script type="text/javascript">				$(function(){
					$(".append").click(function(){
						$(".popup").fadeIn(200);
						$(".popup-all").delay(100).fadeIn(500)
					});
					$(".append-top").find('i').click(function(){
						$(".popup").fadeOut();
						$(".popup-all").fadeOut()
					});
					$(".popup").click(function(){
						$(".popup").fadeOut();
						$(".popup-all").fadeOut()
					});
				});
			</script><!--主要消息 结束--></div><!--盒子 结束--></body><script type="text/javascript" src="__PUBLIC__/js/move.js" ></script></html><script type="text/javascript">// 核销订单
function receipt_submitForm(){
	var btn         = $('.queren');
	var txt         = btn.html();
	var price       = $("input[name=price]").val() * 1;
	var remark      = $("input[name=remark]").val();
	var payment     = $('select[name=payment]').val();
	var recharge_id = $('select[name=recharge_id]').val();
	var r_account   = $('select[name=recharge_id]').find('option:selected').attr('data-account');
	var account     = $('select[name=account]').val();
	var payee       = $('select[name=employee]').val();
	var employee    = $('select[name=employee]').find('option:selected').text();
	var unpay       = '<?php echo ($result["unpay"]); ?>';

	if(payee == 0)
		employee = '';

    if(price > unpay){
        MsgBox('核销金额不能大于未核销金额');
        return false;
    }
    var args = {
        token: 'receipt',
        id: '<?php echo ($result["id"]); ?>',
        remark: remark,
        payment: [payment],
        account: [account],
        price: [price],
        payee: [payee],
        employee: [employee],
        recharge_id:[recharge_id],
        recharge_account:[r_account]
    };

    if(price <= 0){
        MsgBox('请填写核销金额');
        return false;
    }

    if(payment == 7 && recharge_id <= 0){
    	MsgBox('请选择余额支付账号');
    }

    btn.attr('disabled', true).html('处理中...');

    $.post('<?php echo U("SupOrder/receipt");?>', args, function(data) {

        btn.removeAttr('disabled').html(txt);
			
		if(data && typeof(data.status) != 'undefined'){
			var msg = typeof(data.msg) != 'undefined' && data.msg != '' ? data.msg : '';
			
			if(data.status * 1 > 0){
				if(msg == '') msg = '收款成功';
				
				MsgBox(msg);
				$('.popup-all').hide();
				window.location.reload();
			}
			else{
				if(msg == '') msg = '保存失败，请稍后重试';
				MsgBox(msg);
			}
		}
		else{
			MsgBox('服务器未响应，请稍后重试');
		}
    },'json');
}
</script>