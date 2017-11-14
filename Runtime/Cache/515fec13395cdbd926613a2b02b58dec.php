<?php if (!defined('THINK_PATH')) exit(); if($list != ''): if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($key % 2 );++$key;?><!--车友会-->
  <div class="container-fluid"><div class="row"><div class="col-xs-12">
    <a href="<?php echo U('Article/view',array('id'=>$l['id']));?>" class="newsabox">
      <div class="n_a_l"><h2><?php echo ($l["title"]); ?></h2><p><?php echo ($l["description"]); ?></p> 
      <p><span>
      <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;<?php echo ($l["view"]); ?></span>   
      <span>
      <span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;<?php echo ($l["inputtime"]); ?></span></p> </div>
      <div class="n_a_r"><img data-original="<?php echo ($l["thumb"]); ?>" src="http://s.17cct.com/v3/images/space.gif" class="lazyload" onerror="this.data-original='http://image.17cct.com/adv/new_login_bg.jpg';this.onerror=''" width="100" height="73"> 
      </div>
    </a>
    </div>
    </div>
  </div>
  <!--分割线-->
  <div class="container-fluid line"></div><?php endforeach; endif; else: echo "" ;endif; ?>

  <script>
  $(function(){
    $("img.lazyload").lazyload({
        effect: "fadeIn",
        threshold: 200,
        load: function() {
          $(this).removeClass("lazyload")
        }
      });
  })
  </script><?php endif; ?>