<?php if (!defined('THINK_PATH')) exit(); if(is_array($warehouse)): $i = 0; $__LIST__ = $warehouse;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$w): $mod = ($i % 2 );++$i;?><div class="sift_row">
		<div class="row_title common_model">
			<?php echo ($w["attr_name"]); ?>
			<span class="fa fa-caret-down pull-right"></span>
		</div>
		<div class="row_body">
			<ul class="row common">
					<!-- <li class="col-xs-6">
						<a href="javascript:;" class="tc_project tc_choose" value="0">不限</a>
					</li> -->
				<?php if(is_array($w['attr_val'])): $i = 0; $__LIST__ = $w['attr_val'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$av): $mod = ($i % 2 );++$i;?><li class="col-xs-6">
						<a href="javascript:;" class="tc_project" value="<?php echo ($key); ?>"><?php echo ($av); ?></a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>					
			</ul>
		</div>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>
<script type="text/javascript">

	$(document).ready(function(){  

		$(".common_model").each(function(index){
			$(this).click(function(){
				$(this).find('span').toggleClass('fa-caret-down').toggleClass('fa-caret-up');
				$(this).next().toggle();
			});	
		});

	});   

	$(".common a").click(function(){ 
		// $(this).addClass("tc_choose").parent().siblings().find('.tc_project').removeClass("tc_choose");
		$(this).toggleClass('tc_choose');
		var warehouse = [];
		$(".common a").each(function(){
			if($(this).hasClass("tc_choose") && $(this).attr('value')!=0){
				warehouse.push($(this).attr('value'));
			}
		});

		$('#warehouse_value').val(warehouse);
		// currentpage=0;
		// ajax_get_goods();

	});


</script>