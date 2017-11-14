<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>layer</title>
	<script type="text/javascript" src="__PUBLIC__/js/jquery-1.10.2.js"></script>
	<script src="__PUBLIC__/js/ajaxSelect.js"></script>
</head>
<body>
	<select id="unit">
    <?php if(is_array($location)): foreach($location as $key=>$l): ?><option value="<?php echo ($l["id"]); ?>"><?php echo ($l["location_name"]); ?></option><?php endforeach; endif; ?>
  </select>
</body>
</html>
<script type="text/javascript">
var initUrl = "<?php echo U('SupOrder/store_order');?>";
      var ajaxUrl = "<?php echo U('SupOrder/get_location');?>";
      var $select = $("#ajaxselect").ajaxselect({
          initUrl:initUrl,
          ajaxUrl:ajaxUrl,
          defkv:[['id','text'],['location_name','text']],
          selected:0,
          limit:10,
      },function(filterData,isInit){
         //filter
         console.log(filterData);
     },function(cbData,isInit){
         //callback
         console.log(cbData);
     });
     $select.on("change", function(){
         console.log(this.value);
     });

var defcfg = {
      initUrl:'',            //初始化请求地址
      ajaxUrl:'',            //异步请求地址
      defkv:[],            //返回数据 的key
      delay:200,            //ajax回调 延时
      width:200,            //input 宽度
      height:30,            //input 高度
      selected:-1,        //初始化数据 默认选中项,-1为不选中
      limit:10,            //最大显示条数,0为不限制
      maxheight:250,        //最大显示高度
      hoverbg:'#189FD9',    //悬浮背景色
      activebg:'#5FB878',    //选中项背景色
      style:''            //自定义样式
 };
</script>