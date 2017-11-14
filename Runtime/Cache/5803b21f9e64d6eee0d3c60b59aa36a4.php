<?php if (!defined('THINK_PATH')) exit();?><div class="sift_row">
			<div class="row_title">
				订单状态
				<span class="fa fa-caret-down pull-right"></span>
			</div>
			<div class="row_body">
				<ul class="row" >
					<li class="col-xs-4">
						<a href="javascript:;" class="tc_project tc_choose" value="status:All">不限</a>
					</li>
					<li class="col-xs-4">
						<a href="javascript:;" class="tc_project" value="status:1">未打印</a>
					</li>
                    <li class="col-xs-4">
                        <a href="javascript:;" class="tc_project" value="status:2">未拣货</a>
                    </li>
                    <li class="col-xs-4">
                        <a href="javascript:;" class="tc_project" value="status:3">未发货</a>
                    </li>
                    <li class="col-xs-4">
                        <a href="javascript:;" class="tc_project" value="status:4">已发货</a>
                    </li>
                    <li class="col-xs-4">
                        <a href="javascript:;" class="tc_project" value="status:5">已收货</a>
                    </li>
				</ul>
			</div>
		</div>

        <div class="sift_row">
            <div class="row_title">
                支付状态
                <span class="fa fa-caret-down pull-right"></span>
            </div>
            <div class="row_body">
                <ul class="row" >
                    <li class="col-xs-4">
                        <a href="javascript:;" class="tc_project tc_choose" value="pay_status:All">不限</a>
                    </li>
                    <li class="col-xs-4">
                        <a href="javascript:;" class="tc_project" value="pay_status:0">未付款</a>
                    </li>
                    <li class="col-xs-4">
                        <a href="javascript:;" class="tc_project" value="pay_status:1">已付款</a>
                    </li>
                    <li class="col-xs-4">
                        <a href="javascript:;" class="tc_project" value="pay_status:2">已收款</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sift_row">
            <div class="row_title">
                区域经理
                <span class="fa fa-caret-down pull-right"></span>
            </div>
            <div class="row_body">
                <ul class="row">
                    <li class="col-xs-4">
                        <a href="javascript:;" class="tc_project tc_choose" value="0">不限</a>
                    </li>
                    <?php if(is_array($employee_list)): $k = 0; $__LIST__ = $employee_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$el): $mod = ($k % 2 );++$k;?><li class="col-xs-4">
                            <a href="javascript:;" class="tc_project" value="employee_id:<?php echo ($el["id"]); ?>"><?php echo ($el["name"]); ?></a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>                   
                </ul>
            </div>
        </div>


<script type="text/javascript">

	$(document).ready(function(){  

		$(".row_title").each(function(index){
			$(this).click(function(){
				$(this).find('span').toggleClass('fa-caret-down').toggleClass('fa-caret-up');
				$(this).next().toggle();
			});	
		});

	});   


	$(".row a").click(function(){ 
		$(this).addClass("tc_choose").parent().siblings().find('.tc_project').removeClass("tc_choose");
		// $(this).toggleClass('tc_choose');
		var attr = [];
		$(".row a").each(function(){
			if($(this).hasClass("tc_choose") && $(this).attr('value')!=0){
				attr.push($(this).attr('value'));
			}
		});

		$('#attr_value').val(attr);

	});

</script>