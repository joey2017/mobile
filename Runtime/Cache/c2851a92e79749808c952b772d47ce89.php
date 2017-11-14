<?php if (!defined('THINK_PATH')) exit(); if(is_array($results)): foreach($results as $key=>$r): ?><div class="storebox" data-gid="<?php echo ($r["id"]); ?>"> 
        <a class="btn-block box_flex stopname">
            <span class="resimg"><img src="<?php echo (getimgurl($r["thumbnail"],'large')); ?>" width="100%" height="100%"></span>
            <div class="flex1">
                <h3><?php echo ($r["goods_name"]); ?></h3>
                <p>库存:<span style="color: #eb5211;font-size: 13px;"><?php echo ($r["stock"]); ?></span></p>

                <p>￥:<span class="price"><?php echo ($r["price"]); ?></span>/<?php echo ($r["unit"]); ?></p>
            </div>
            <div class="setbox">
                <input class="min" name="" type="button" value="-">
                <input class="text_box" type="number" name="goods_num" value="1">
                <input class="add" name="" type="button" value="+">
            </div>
        </a>
        <span class="tick"></span>
    </div><?php endforeach; endif; ?>
<script type="text/javascript" >
    $(function () {
        $(".bomb_screen1").height(document.body.clientHeight + 20);
    })
</script>