<?php if (!defined('THINK_PATH')) exit(); if(is_array($attr_list)): $i = 0; $__LIST__ = $attr_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i;?><div class="sift_row">
		<div class="row_title">
			<?php echo ($a["attr_name"]); ?>
			<span class="fa fa-caret-down pull-right"></span>
		</div>
		<div class="row_body">
			<ul class="row li_choose">
					<!-- <li class="col-xs-4">
						<a href="javascript:;" class="tc_project attr_val tc_choose" value="0">不限</a>
					</li> -->
				<?php if(is_array($a['attr_val'])): $k = 0; $__LIST__ = $a['attr_val'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$av): $mod = ($k % 2 );++$k;?><li class="col-xs-4">
						<a href="javascript:;" class="tc_project attr_val" value="<?php echo ($a["id"]); ?>:<?php echo ($av); ?>"><?php echo ($av); ?></a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>					
			</ul>
		</div>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>

<script type="text/javascript">

	$(document).ready(function(){  

		$(".row_title").each(function(index){
			$(this).click(function(){
				$(this).find('span').toggleClass('fa-caret-down').toggleClass('fa-caret-up');
				$(this).next().toggle();
			});	
		});

	});   


	$(".li_choose a").click(function(){ 
		// $(this).addClass("tc_choose").parent().siblings().find('.tc_project').removeClass("tc_choose");
		$(this).toggleClass('tc_choose');
		var attr = [];
		$(".li_choose a").filter('.attr_val').each(function(){
			if($(this).hasClass("tc_choose") && $(this).attr('value')!=0){
				attr.push($(this).attr('value'));
			}
		});

		$('#attr_value').val(attr);

	});

</script>