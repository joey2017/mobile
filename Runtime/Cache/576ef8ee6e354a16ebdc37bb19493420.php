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
<link href="__PUBLIC__/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link href="__PUBLIC__/css/mobiscroll.css" rel="stylesheet" />
<link href="__PUBLIC__/css/mobiscroll_date.css" rel="stylesheet" />
<script src="__PUBLIC__/js/mobiscroll_date.js"charset="gb2312"></script> 
<script src="__PUBLIC__/js/mobiscroll.js"></script>
<style type="text/css">
.pgt{padding: 0;}
.tab_parent{padding-left: 10px;}
.tab_subset{margin:0; padding: 0 10px 0 0;}
ul{margin:0;list-style: none; padding: 0;}
a{color: #333;}
a:focus,a:active, a:hover{color: #333; text-decoration: none;}
.box_flex{font-size:14px; display: -webkit-box; display: -moz-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex;}
.flex1{ -webkit-box-flex: 1; -moz-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; flex: 1;}

body{height: 100%;background: #eee; position:relative;}
.reserve_tab{ padding: 15px;}
.resbox,.storebox{border:1px solid #ccc; background: #fff;  margin-bottom: 15px; overflow: hidden; border-radius: 6px;}
.name_a{padding: 5px 15px 5px 5px; height: 58px;}
.resimg,.resico{width: 48px; height: 48px; margin-right: 10px; display: block; float: left; overflow: hidden;border-radius: 24px;}
.resbox p{line-height: 47px; margin: 0;}

.resul li{height: 60px; border-bottom:1px solid #ccc;padding: 5px 15px 5px 5px;  }
.resul li:last-child{border:0;}
.resico{width:30px; margin-top: 8px; height:30px;background-image: url(__PUBLIC__/images/reserve2.svg); background-repeat: no-repeat; background-size: 62px; border-radius: 0;}
.re01{background-position: 3px 2px;}
.re02{background-position: 3px -47px;}
.re03{background-position: 3px -94px;}
.re04{background-position: 3px -142px;}
.re05{background-position: -36px -44px}

.nameinput{border:0; background:#fff !important; margin-top: 5px;webkit-box-shadow:none; box-shadow:none; padding: 6px 12px 6px 0;}

.reserve_btn{width: 100%; height: 100%;}
.bomb_screen1,.bomb_screen2{position: absolute; z-index: 5; width: 100%; min-height: 100%; background: #fff; display: none; top: 0;}
.project_name{width: 100%;padding: 10px 15px;}
.currentstop{border:1px solid #cd0000; position: relative;}
.tick{display:none;}
.currentstop .tick{display:block; right: 0; bottom: 0; position: absolute; background: url(__PUBLIC__/images/tick.png) no-repeat; background-size: 24px; width: 24px; height: 24px; }

.stopname{padding: 5px;}
.stopname h3{font-size: 16px; margin: 10px 0 9px 0;}
.stopname p{margin-bottom: 5px; color: #a5a5a5; font-size: 12px;}
</style>

</head>

<body>
<!--头部-->

<!--弹出提示框-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>


<div class="container-fluid topbox">
    <div class="row top"><h1 style="display:none;">诚车堂汽车网</h1>
       
        <div class="pg-Current">
        	 <a href=""><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pgt">
        	<a href="">返回</a>
        </div>
    </div>
</div>


<div class="reserve_tab">
	<div class="resbox">
		<a class="btn-block name_a" onclick="bomb_screen(1)">
			<span class="resimg"><img src="<?php echo (getimgurl($store_info[0]["preview"],'large')); ?>" sid="<?php echo ($store_info[0]["id"]); ?>" width="100%" height="100%"></span>
			<p class="pull-left"><?php echo ($store_info[0]["name"]); ?></p>
			<i class="fa fa-angle-right pull-right" style="margin-top:15px;"></i>
		</a>
	</div>
	<div class="resbox">
		<ul class="resul">
			<li>
				<a>
					<span class="resico re01"></span>
					<p class="pull-left"><input type="text" name="user" class="form-control nameinput" placeholder="用户名称" value="<?php echo ($user_info["true_name"]); ?>"></p>
				</a>
			</li>
			<li>
				<a>
					<span class="resico re02"></span>
					<p class="pull-left"><input type="text" name="mobile" class="form-control nameinput" placeholder="手机号码" value="<?php echo ($user_info["mobile"]); ?>"></p>
				</a>
			</li>
			<li>
				<a>
					<span class="resico re03"></span>
					<p class="pull-left"><input type="text" id="date_time"  name="time" class="form-control nameinput" placeholder="时间"></p>
					<i class="fa fa-angle-right pull-right" style="margin-top:15px;"></i>
				</a>
			</li>
			<li>
				<a class="reserve_btn btn-block"  onclick="bomb_screen(2)">
					<span class="resico re04"></span>
					<p class="pull-left">预约项目</p>
					<i class="fa fa-angle-right pull-right" style="margin-top:15px;"></i>
				</a>
			</li>
			<li>
				<a>
					<span class="resico re05"></span>
					<p class="pull-left"><input type="text" name="remark" class="form-control nameinput" placeholder="备注" value=""></p>
				</a>
			</li>
		</ul>
	</div>
	<div class="resbox">
		<button id="btn" class="btn btn-lg btn-block btn-danger">确认提交</button>
	</div>
</div>


<!-- 选择门店 -->
<div class="bomb_screen1">
	<div class="reserve_tab" id="CarWash">

	<?php if(is_array($store_info)): $i = 0; $__LIST__ = $store_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s_i): $mod = ($i % 2 );++$i; if($key == 0): ?><div class="storebox currentstop"> 
			<a class="btn-block box_flex stopname">
				<span class="resimg"><img src="<?php echo (getimgurl($s_i["preview"],'large')); ?>" width="100%" height="100%"></span>
				<div class="flex1">
					<h3><?php echo ($s_i["name"]); ?></h3>
					<p>地址：<?php echo ($s_i["address"]); ?></p>
				    <p>电话：<?php echo ($s_i["tel"]); ?></p>
			    </div>
			</a>
			<span class="tick"></span>
		</div>
	<?php else: ?>
		<div class="storebox"> 
			<a class="btn-block box_flex stopname">
				<span class="resimg"><img src="<?php echo (getimgurl($s_i["preview"],'large')); ?>" sid="<?php echo ($s_i["id"]); ?>" width="100%" height="100%"></span>
				<div class="flex1">
					<h3><?php echo ($s_i["name"]); ?></h3>
					<p>地址：<?php echo ($s_i["address"]); ?></p>
				    <p>电话：<?php echo ($s_i["tel"]); ?></p>
			    </div>
			</a>
			<span class="tick"></span>
		</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		<div style="height:90px; clear:both;"></div>
		<div class="col-xs-12 row" style=" position: fixed; bottom: 50px; background: #fff; padding-bottom: 10px;">
			<button class="btn btn-lg btn-block btn-danger" onclick="bomb_screen(1)">确定</button>
		</div>
	</div>
</div>


<!-- 选择项目 -->
<div class="bomb_screen2">
	<div class="reserve_tab">
		<?php if(is_array($item_info)): foreach($item_info as $key=>$i_i): ?><div class="resbox">
				<a class="btn-block">
					<label class="project_name">
				      	<input type="radio" name="inlineRadioOptions" value="<?php echo ($i_i["id"]); ?>"> <?php echo ($i_i["name"]); ?>
				    </label>
				</a>
			</div><?php endforeach; endif; ?>

		<div style="height:90px; clear:both;"></div>
		<div class="col-xs-12 row" style=" position: fixed; bottom: 50px; background: #fff; padding-bottom: 10px;">
			<button class="btn btn-lg btn-block btn-danger" onclick="bomb_screen(2)">确定</button>
		</div>
	</div>
</div>



<script type="text/javascript" src="__PUBLIC__/js/wap_v4_common.js"></script>

<script type="text/javascript">

    $(function () {
        var currYear = (new Date()).getFullYear();  
        var opt={};
        opt.date = {preset : 'date'};
        opt.datetime = {preset : 'datetime'};
        opt.time = {preset : 'time'};
        opt.default = {
            theme: 'android-ics light', //皮肤样式
            display: 'modal', //显示方式 
            mode: 'scroller', //日期选择模式
            dateFormat: 'yyyy-mm-dd',
            lang: 'zh',
            showNow: true,
            nowText: "今天",
            startYear: currYear - 10, //开始年份
            endYear: currYear + 10 //结束年份
        };
        var optDateTime = $.extend(opt['datetime'], opt['default']);
        $("#date_time").mobiscroll(optDateTime).datetime(optDateTime);
    });


    // 弹框
    function bomb_screen(index){
    	var bomb='.bomb_screen'+index;
        $(bomb).slideToggle(1);

	}

	//服务项目选择
	$("input:radio").each(function(i){
		$(this).click(function(){
			var item_name = $(".bomb_screen2 input:checked").parent().text().trim();

			$(".reserve_tab .resul li:eq(3) a p").text(item_name);
            $(".reserve_tab .resul li:eq(3) a p").attr("cid",$(".bomb_screen2 input:checked").attr("value"));

		});
	});

	//验证手机号
	function checkPhone(){ 
	    var phone = $("input[name='mobile']").val();
	    if(!(/^1[34578]\d{9}$/.test(phone))){ 
	        return false; 
	    }else{
	    	return true;
	    } 
	}

	//获取yyyy-mm-dd HH:ii格式字符串时间戳
	function getTimeStamp(time){    
		var arr = time.split(/[- :]/);
		_date = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4]);   
		timeStr = Date.parse(_date);
		return timeStr;
	}

	//获取预约信息并提交
	$("#btn").click(function(){
		var store_name = $(".resbox > a > p").text();
		var store_id = $(".resbox > a > span > img").attr('sid');
		
        var store_address = $(".currentstop p").eq(0).text().substr(3);
        var store_contact = $(".currentstop > a > div > p:last-child").text().substr(3);
		var car_owner = $("input[name='user']").val(); 
		var user_mobile = $("input[name='mobile']").val(); 
		
		var service_time = $("input[name='time']").val();
       	var timestamp = getTimeStamp(service_time);
       	var nowtimestamp = new Date().getTime();

		var item = $(".reserve_tab .resbox ul li:eq(3) a p").text();
		var remark = $(".reserve_tab .resbox ul li:last-child a p input").val();

		if(car_owner == ''){
			MsgBox("请您填写用户名称");
			return false;
		}

		if(user_mobile == ''){
			MsgBox("请您填写手机号码");
			return false;
		}else if(!checkPhone()){
			MsgBox("手机号码有误,请您重新填写");
			return false;
		}

		if(service_time == ''){
			MsgBox("您还没有选择服务时间哦！");
			return false;
		}else if(Number(timestamp) < Number(nowtimestamp)){
			MsgBox("您选择的时间已经过去啦！");
			return false;
		}

		if(item == '预约项目'){
			MsgBox("请您选择需要的预约项目");
			return false;
		}
        
		$(this).prop('disabled',true);
        
		$.post("<?php echo U('Advance/reservation_process');?>",
			{
				store_name:store_name,
				store_address:store_address,
				store_contact:store_contact,
				car_owner:car_owner,
				user_mobile:user_mobile,
				service_time:service_time,
				item:item,
				remark:remark,
				store_id:store_id
			},
			function(data){
	            if(data.status == 1){
	                MsgBox("恭喜您预约服务成功!");
	                setInterval(function(){
	                	window.location.href = "<?php echo U('Advance/reservation_success');?>"+"?rid="+data.msg
	                },1500);
	            }else if(data.status == 0){
	                MsgBox(data.msg);
	            }      
			});
		});
  
</script>



<div style="height:60px; clear:both;"></div>

<script type="text/javascript" src="__PUBLIC__/js/scrolltopcontrol.js"></script>
<div style="display:none"> 
	<script>
		var _hmt = _hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "//hm.baidu.com/hm.js?196428f1e872f7a662e1bdf39f9953ca";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		})();
</script>


</div>
</body>
</html>