<?php if (!defined('THINK_PATH')) exit();?><div class="cbp-hrsub">
    <!-- 选项卡开始 -->
    <div class="nTab">
        <!--属性二级-->
        <div class="TabTitle">
            <ul id="<?php echo ($mytab); ?>">
                <?php if(is_array($resultlist)): foreach($resultlist as $r_k=>$r): ?><li class="<?php echo ($r["class"]); ?>" onclick="nTabs(this,<?php echo ($r_k); ?>);"><?php echo ($r["name"]); ?></li><?php endforeach; endif; ?>
            </ul>
        </div>
        <!-- 属性三级 -->
        <div class="TabContent">
            <?php if(is_array($resultlist)): foreach($resultlist as $r_k=>$r): ?><div id="<?php echo ($mytab); ?>_Content<?php echo ($r_k); ?>" class="<?php echo ($r["son_class"]); ?>">
                <?php if(is_array($r["son"])): foreach($r["son"] as $key=>$s): ?><ul><a href="<?php echo ($s["url"]); ?>" <?php echo ($s["style"]); ?>><li><?php echo ($s["name"]); ?></li></a></ul><?php endforeach; endif; ?>
            </div><?php endforeach; endif; ?>
        </div>
    </div>
    <!-- 选项卡结束 --> 
</div>