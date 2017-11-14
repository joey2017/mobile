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
</head>

<style type="text/css">
	.pointab p{margin: 5px 6px 5px 0}
    .content_txt img{width: 100% !important;}
</style>
<body id="Jlazy_img">
<!--头部-->
<div class="alertBg" id="msgBox" style="display:none;">
    <h4 class="alerttitle" id="alerttitle"></h4>
    <span class="vm f20" id='alertdetail'></span>
</div>
<div class="container-fluid topbox">
    <div class="row top">
        <div class="pg-Current">
        	<a href="javascript:history.back();" ><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
        </div>
        <div class="pg-Current">
        	<img src="__PUBLIC__/images/shang.png" width="30" height="30">
        </div>
        <div class="pgt">
        	<a>服务详情</a>
        </div>
    </div>
</div>
<!--服务概况-->
<div class="container-fluid" >
	<div class="row" style="position:relative;">
			<img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($deal["img"],'large')); ?>" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');" style="width:100%; height:auto;"> 
	</div>
</div>
<!--抢购-->
<div class="container-fluid" >
    <?php if($deal['deal_attr_list']): ?><div class="row phon">
    		<div class="col-xs-12 Price">
                <b><?php echo (price($deal["current_price"])); ?></b><i>元</i>
                <del><?php echo (price($deal["origin_price"])); ?>元</del>
                <a href="javascript:void(0);" id="trigger-overlay" class="btn btn-default btn-warning" style="float:right;"  role="button">立即抢购</a>
            </div>    	
    	</div>
        <div class="row">
            <div class="overlay-slidedown" id="overlay-slidedown">
                <div class="container">
                    <div class="row">
                         <a class="btn btn-default" role="button" id="overlay-close" style="width:auto;margin:-17px 20px 17px 0;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                    </div>
                </div>
                 <div class="container-fluid" style="margin:-20px 0 10px 0;">
                    <div class="row">
                        <div class="col-xs-12" style="font-size:16px;font-weight:bold;">请选择属性</div>
                    </div>
                </div>
                <div class="container-fluid b_line">
                </div>
                <div class="container-fluid sxlist" id="sxlist">
                    <div class="row" id="xs-box">
                        <?php if(is_array($deal["deal_attr_list"])): foreach($deal["deal_attr_list"] as $key=>$dal): ?><div class="col-xs-12"><h2 style="font-size:14px" id="dalname<?php echo ($key); ?>"><?php echo ($dal["name"]); ?></h2></div>
                        <div class="col-xs-12 dal-list" id="<?php echo ($key); ?>">
                            <?php if(is_array($dal["attrs"])): foreach($dal["attrs"] as $key=>$attr): ?><a class="btn btn-sm <?php if($attr['is_first'] == 1): ?>btn-danger<?php else: ?>btn-default<?php endif; ?>" role="button" id="attrSelectDIV<?php echo ($attr["id"]); ?>" attrid="<?php echo ($attr["id"]); ?>" attrtype="attrtype<?php echo ($attr["goods_type_attr_id"]); ?>" subid="<?php echo ($attr["deal_submeter_id"]); ?>"><?php echo ($attr["attr_value"]); ?></a><?php endforeach; endif; ?>
                        </div><?php endforeach; endif; ?>
                    </div>                                              
                </div>
                <div class="gwbt" style="height:94px;border-top: 1px solid #e0e0e0;">
                    <div class="col-xs-12">
                        <center>
                            <span style="font-size:16px">单价:<span class="Price"><strong id="price"><?php echo (price($deal["current_price"])); ?></strong>元</span></span>
                            <del style="font-size:12px;color:#9b9b9b;margin-left:5px;">原价:<span id="origin_price"><?php echo (price($deal["origin_price"])); ?></span>元</del>
                        </center>
                    </div>
                    <div class="col-xs-12" style="background:#eea236;"><a id="next-spet" href="javascript:void(0);" onclick="nextSpet();">下一步</a></div>
                </div>
                <div class="load-black" id="load-black">
                    <div style="width:37px; height:37px; position:absolute; top:10px; left:50%; margin-left:-12px;"><img src="__PUBLIC__/images/kitload.gif"></div>
                </div>
            </div>
        </div>
        <div class="black" id="black" style="top:0"></div>
        <input type="hidden" value="<?php echo ($deal["deal_submeter_id"]); ?>" id="sel_sub_id">
<script type="text/javascript">
$('#xs-box').find('a[id^="attrSelectDIV"]').bind("click",function (){
    var _this  = $(this);
    var attrid = "";
    var fcid   = _this.attr('attrid');
    var subid  = _this.attr('subid');
    var cl     = "";
    var next_spet  = $('#next-spet');
    var load_black = $('#load-black');

    if (_this.hasClass("btn-default")){
        var attrtype = _this.attr("attrtype");
        $('#xs-box').find('a[attrtype="'+attrtype+'"]').each(function(){
            $(this).addClass("btn-default").removeClass("btn-danger");
        });
        _this.addClass("btn-danger").removeClass("btn-default");
        cl = 'btn-danger';
    }else {
        _this.addClass("btn-default").removeClass("btn-danger");
        cl = 'btn-default';
    }
    $('#xs-box').find('a[class="btn btn-sm btn-danger"]').each(function (){
        attrid += $(this).attr('attrid')+',';
    });

    next_spet.attr('onclick','');
    load_black.show();
    $.ajax({ 
        url: "<?php echo U('Service/ajaxGetAttrPrice');?>",
        type: "post",
        dataType:"json",
        data: {'attr_id':attrid,'fcid':fcid,'subid':subid,'deal_id':'<?php echo ($deal["did"]); ?>','cl':cl},
        success:function(d){
            var result = d.data;
            if (d.status == 1) {
                $(result.canot_sel_ids).each(function (index,data){
                $('#attrSelectDIV'+data).attr('disabled',true).css('background-color','#FFCCCC');
                $('#attrSelectDIV'+data).addClass("btn-default").removeClass("btn-danger");
                });
                $(result.can_sel_ids).each(function (index,data){
                    $('#attrSelectDIV'+data).attr('disabled',false).css('background-color','');
                });
                if(result.selectFinish=="1"){ 
                    $('#price').html((parseFloat(result.price)).toFixed(2));
                    $('#origin_price').html((parseFloat(result.origin_price)).toFixed(2));
                    $('#sel_sub_id').val(result.sub_id);
                } 
                load_black.hide();
                next_spet.attr('onclick','nextSpet();');  
            }else{
                MsgBox('请刷新后重新选择属性');
                window.location.reload();
                return false;
            } 
        },
        error:function(o){
            MsgBox('网络延迟，请稍后重试');
        }
    });
    return false;
});
function nextSpet () {
    if (!check_attr()) {
        return false;
    }
    var dsid = $('#sel_sub_id').val();
    window.location.href = "<?php echo U('Order/submit',array('id'=>$deal['did']));?>?dsid="+dsid;
}
function check_attr(){
    var flag = true,
        msg  = '请选择：';
    $('#xs-box').find('div[class="col-xs-12 dal-list"]').each(function(i,v){
        if (!$(this).find('a').hasClass('btn-danger')) {
            flag = false;
            var id = $(this).attr('id');
            msg += $('#dalname'+id).text()+" ";
        }
    });
    if (flag == false) {
        MsgBox(msg);
    }
    return flag;
}
</script>
<!--服务属性 弹窗效果-->
<script type="text/javascript">
    var w_h = $(window).height(),
        black = $("#black"),
        overlay_slidedown = $('#overlay-slidedown'),
        load_black = $('#load-black');
    $('body').css('position','relative');
    $('#sxlist').css('height',w_h*0.9-145);
    overlay_slidedown.css('height',w_h*0.9);
    load_black.css({'height':w_h*0.9-145,'bottom':94});

    $(function(){
        $("#overlay-close").click(function(){
            overlay_slidedown.slideUp(500);
            black.hide();
        });
        $("#trigger-overlay").click(function(){
            overlay_slidedown.slideDown(500);
            black.show(10);
        });
    });
</script>
    <?php else: ?>
        <div class="row phon">
            <div class="col-xs-12 Price">
                <b><?php echo (price($deal["current_price"])); ?></b><i>元</i>
                <del><?php echo (price($deal["origin_price"])); ?>元</del>
                <a href="<?php echo U('Order/submit',array('id'=>$deal['did']));?>" class="btn btn-default btn-warning" style="float:right;" role="button">立即抢购</a>
            </div>      
        </div><?php endif; ?>
</div>
<!--分割线-->
<div class="container-fluid line"></div>
<!--服务信息-->
<div class="container-fluid">
    <div class="row" >
        <div class="col-xs-12" >
            <div class="tab_t">
                <h2><?php echo ($deal["dname"]); ?></h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 ">
            <div class="row">
                <div class="tab_a tab_b_l">
                    <div class="col-xs-12" style="margin:10px 0 0 0;">
                        <p style="font-size:14px;"><?php echo ($deal["brief"]); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--分割线-->
<div class="container-fluid line"></div>
<!--商家信息-->
<div class="container">
	<div class="row" >
    	<div class="col-xs-12" >
        	<div class="tab_t">
    			<h2>商家信息</h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 ">
        	<div class="row">
            	<a href="<?php echo U('Store/view',array('id'=>$deal['sid']));?>" class="tab_a tab_b_l">
                    <div class="col-xs-12" style="margin:10px 0 0 0;">
                        <h2 style="font-size:16px; margin:10px 0;"><?php echo ($deal["lname"]); ?></h2>
                        <p><?php echo ($deal["address"]); ?></p>
                        <p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span><span id='distance'>计算距离中...</span></p>
                    </div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v2.0&ak=tEflu9uwxEGzOsVPA11HS9Yl"></script> 
<script type="text/javascript">
//计算距离
var geolocation = new BMap.Geolocation();
 $(function(){
    geolocation.getCurrentPosition(function (r) {
        if (this.getStatus() == BMAP_STATUS_SUCCESS) {
            $.post("<?php echo U('Service/getDistanceToStore');?>",{id:'<?php echo ($deal["sid"]); ?>',lng:r.point.lng,lat:r.point.lat},//lng 经度 lat 纬度
                   function(d){
                        if(d){
                            if (d.status == 1) {
                                 $('#distance').text(d.data+'km'); 
                            } else{
                                $('#distance').text(d.info); 
                            }
                        }else {
                            $('#distance').text('计算失败，请刷新后重试');
                        }
                   }, "json");
        }else if(this.geStatus()==BMAP_STATUS_SERVICE_UNAVAILABLE) {      
            MsgBox("位置结果未知");
        }
        else if(this.getStatus() == BMAP_STATUS_SERVICE_UNAVAILABLE) {      
            MsgBox("无法通过浏览器定位您的位置.您可以在我们诚车堂微信中发送您的地理位置给我们，以便获取您附近的商家");
        }else if(this.getStatus()==BMAP_STATUS_TIMEOUT) {
            MsgBox("请求超时,请刷新再试");
        }
    }); 
});
</script>                    
                </a>
            </div>
        </div>
    </div>
</div>
<!--拨打电话-->
<?php if($deal['tel']): ?><!--分割线-->
<div class="container-fluid line"></div>
<div class="container-fluid" >
    <div class="row phon">
            <div class="col-xs-8">预约电话：<?php echo ($deal["tel"]); ?></div>
            <div class="col-xs-4"><a href="tel:<?php echo ($deal["tel"]); ?>" style="float:right; color:#ff7302;"><strong>拨打电话</strong></a></div>
    </div>
</div><?php endif; ?>
<!--分割线-->
<div class="container-fluid line"></div>

<!--查看图文详情-->

<div class="container-fluid line" style="height:50px; line-height:50px;">
    <P class="text-center"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span><span style="margin-left:5px;" onclick="getImgDetail(this);">查看图文详情</span><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></P>
</div>
<!--隐藏的详情内容-->
<div class="container-fluid content_txt" id="deal-detail">
    <div class="row">
        <!--详情文字内容放这里-->
        <div class="col-xs-12 " id="deal-text-detail">
        </div>
        <!--详情图片内容放这里-->
       
    </div>
</div>

<!--分割线-->
<div class="container-fluid line"></div>

<!--交易评价-->
<div class="container">
	<div class="row" >
    	<div class="col-xs-12" >
        	<div class="tab_t">
    			<h2>交易评价</h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
<?php if($reviews): ?><div class="row">
    	<div class="col-xs-12" id="reviews-box">
            <?php if(is_array($reviews)): foreach($reviews as $key=>$re): ?><div class="row" style="border-bottom:1px solid #cbcbcb;">

                    <div class="col-xs-12 pltop" style="margin:10px 0 0 0;">
                   		<h4 style="width:98px;overflow:hidden;text-overflow:ellipsis; white-space:nowrap;">
                        	<span class="glyphicon glyphicon-user" aria-hidden="true"></span><?php echo ($re["user_name"]); ?>
                        </h4>
                        <time><?php echo (date("Y-m-d",$re["create_time"])); ?></time>                        
                    </div>

                     <div class="col-xs-12 pointab">
	                    <?php if($re['dp_point_group'] != null): if(is_array($re['dp_point_group'])): foreach($re['dp_point_group'] as $key=>$dp): ?><p class="text-left pull-left"><?php if($dp['group_id'] == 1): ?>服务评分<?php else: ?>技术评分<?php endif; ?><span class="djx" id="pf0<?php echo ($dp["point"]); ?>"></span></p><?php endforeach; endif; ?>
	                    <?php else: ?>
	                     <p class="text-left pull-left">服务评分<span class="djx" id="pf00"></span></p> 
	                        <p class="text-left pull-left">技术评分<span class="djx" id="pf00"></span></p><?php endif; ?>                         
                    </div>

                    <div class="col-xs-12" style="margin:10px 0 0 0;">
                   		<?php echo ($re["content"]); ?>
                    </div>

                    <?php if(!empty($re['imgs'])): ?><div class="col-xs-12 plimg">
                            <?php if(is_array($re["imgs"])): foreach($re["imgs"] as $key=>$rei): ?><span style="margin-right: 5px;"><img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($rei,'thumbnail')); ?>" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');" style="width: 79px;height: 79px;"></span><?php endforeach; endif; ?>
                        </div><?php endif; ?>
                    <div class="col-xs-12" style="margin:10px 0 10px 0;">
                     	<span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span><span style="margin-left:5px;"><?php echo ($re["title"]); ?></span>
                    </div>  
            </div><?php endforeach; endif; ?>
        <?php if($reviews_count_nums > 3): ?><div class="row" id="d-loading">
                <div class="col-xs-12">
                    <a href="javascript:void(0);" onclick="loadReviews('<?php echo ($deal["did"]); ?>');" class="tjbtn"><p class="text-center"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span><span style="margin-left:5px;" id='loading-tip'>查看其他<?php echo ($reviews_count_nums-3); ?>条评价</span><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></p></a>
                </div>
            </div>
<script type="text/javascript">
var r_page = 1 ;
function loadReviews(did) {
    var loadingTip  =  $('#loading-tip'),                   // 防止重复点击
        allRows     =  parseInt('<?php echo ($reviews_count_nums); ?>'), // 所有的行数
        loadingRows =  5 ,                                  // 每次加载的行数
        existRows   =   parseInt('<?php echo (count($reviews)); ?>') ;    // 页面初始已经加载的行数   
    if (loadingTip.text() == '努力加载中...') {
        MsgBox("正在加载中，请稍候");
        return false;
    }
    $.ajax({ 
        type:"post",
        url: "<?php echo U('Service/ajaxGetReviews');?>", 
        data:{
            id:did,
            page:r_page,
            arows:allRows,
            lrows:loadingRows,
            erows:existRows
        }, 
        dataType:"json",
        beforeSend:function (XMLHttpRequest) {
            loadingTip.text('努力加载中...');
        },
        success: function(d){
            if(d){
                if (d.status == 1 || d.status == 2) {
                    var reviewsList = d.data,
                        reviewsListLength = reviewsList.length,
                        html = '';
                    for (var i = 0; i < reviewsListLength; i++) {
                        html += '<div class="row" style="border-bottom:1px solid #cbcbcb;">';
                        html +=    '<div class="col-xs-12 pltop" style="margin:10px 0 0 0;">';
                        html +=      '<h4 class="my_od_f" style="width:100px;text-overflow:clip;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>'+reviewsList[i].user_name+'</h4>';
                        html +=      '<time>'+reviewsList[i].create_time+'</time></div><div class="col-xs-12 pointab">';
                         if(reviewsList[i]['dp_point_group']){
                            for( var j=0; j<2;j++){
                                if(reviewsList[i]['dp_point_group'][j]['group_id']==1){
                                    ponit_name='服务评分';
                                }else{
                                    ponit_name='技术评分';
                                }
                               html += '<p class="text-left pull-left">'+ponit_name+'<span class="djx" id="pf0'+reviewsList[i]['dp_point_group'][j]['point']+'"></span></p>'; 
                            }
                        }else{
                            html += '<p class="text-left pull-left">技术评分<span class="djx" id="pf00"></span></p><p class="text-right pull-right">服务评分<span class="djx" id="pf00"></span></p>';
                        }
                        html +=    '</div>';
                        html +=    '<div class="col-xs-12" style="margin:10px 0 0 0;">'+reviewsList[i].content+'</div>';
                        if (reviewsList[i].imgs && reviewsList[i].imgs !='') {
                            var imgsList = reviewsList[i].imgs,
                                imgsListLength = imgsList.length,
                                errorImg = "this.src='http://s.17cct.com/v3/images/errorimg.jpg';this.onerror=''";
                            html +=       '<div class="col-xs-12 plimg">';
                            for (var g = 0; g < imgsListLength; g++) {
                                html +=              '<span style="margin-right: 5px;"><img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="'+imgsList[g]+'" onerror="'+errorImg+'" style="width: 79px;height: 79px;"></span>';
                            }
                            html +=       '</div>';
                        }
                        html +=    '<div class="col-xs-12" style="margin:10px 0 10px 0;">';
                        html +=       '<span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span>';
                        html +=       '<span style="margin-left:5px;">'+reviewsList[i].title+'</span>';
                        html +=    '</div>';  
                        html +='</div>';
                    }
                    $('#d-loading').before(html);
                    var imgs_lazy = Lazy.create({
                                    lazyId: 'reviews-box',
                                    trueSrc: 'src2',
                                    offset: 0, 
                                    delay: 0, 
                                    delay_tot: 0 
                                  }); 
                        Lazy.init(imgs_lazy);

                    if (d.status == 1) {
                       loadingTip.text('查看余下'+(allRows-existRows-loadingRows*r_page)+'条评价');
                       r_page++; 
                    } else{
                        $('#d-loading').after('<div class="row" ><p style="color: #5f5f5f;text-align: center;margin-top:10px;">已加载全部评论</p></div>');   
                        $('#d-loading').remove();
                    }

                }else {
                    loadingTip.text('查看余下'+(allRows-existRows-loadingRows*(r_page-1))+'条评价');
                    MsgBox("加载失败，请稍候重试");
                }

            }else{
                loadingTip.text('查看余下'+(allRows-existRows-loadingRows*(r_page-1))+'条评价');
                MsgBox("加载失败，请稍候重试");
            } 
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            loadingTip.text('查看余下'+(allRows-existRows-loadingRows*(r_page-1))+'条评价');
            MsgBox("加载失败，请稍候重试");
        }
    });
    return false; 
}
</script><?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="row" >
        <p style="color: #5f5f5f;text-align: center;margin-top:10px;">暂无评论</p>
    </div><?php endif; ?>   
</div>
<!--分割线-->
<div class="container-fluid line"></div>
<!--看了本服务的用户还看了-->
<div class="container">
	<div class="row" >
    	<div class="col-xs-12" >
        	<div class="tab_t">
    			<h2>看了本服务的用户还看了</h2>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
<?php if($recommend_deals): ?><div class="row">
    	<div class="col-xs-12 ">
        <?php if(is_array($recommend_deals)): foreach($recommend_deals as $key=>$rs): ?><div class="row">
            	<a href="<?php echo U('Service/view',array('id'=>$rs['id']));?>" class="tab_a tab_b_l">
                    <div class="col-xs-5" style="margin:10px 0 0 0;">
                        <img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="<?php echo (getimgurl($rs["img"],'middle')); ?>" onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');" style=" width:100%; height:auto"> 
                    </div>
                    <div class="col-xs-7 txtbox" style="margin:0; padding:0;">
                        <h3><?php echo ($rs["name"]); ?></h3>
                        <p class="tcont"><?php echo ($rs["brief"]); ?></p>
                        <p><b><?php echo (price($rs["current_price"])); ?>元</b>&nbsp;&nbsp;<del><?php echo (price($rs["origin_price"])); ?>元</del> <span style="float:right;">已售<?php echo ($rs["order_count"]); ?></span></p>
                    </div>
                </a>
            </div><?php endforeach; endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="row" >
        <p style="color: #5f5f5f;text-align: center;margin-top:10px;">暂无查看</p>
    </div><?php endif; ?>
</div>

<script type="text/javascript">
function getImgDetail(obj) {
    // var windowWidth = $(window).width(),
    //     html = '',
    //     imgArr = <?php echo (json_encode($deal['img_detail'])); ?> ;
    // $.each(imgArr, function(i,val){
    //     if (val.indexOf('http://image.17cct.com') != -1) {
    //         if (windowWidth < 420) {
    //             val += '!big';
    //         }
    //     }
    //     html += '<img class="lazy_img" src="http://s.17cct.com/v3/images/space.gif" src2="'+val+'" onerror="imgError(this,"http://s.17cct.com/v3/images/errorimg.jpg");" style=" width:100%; height:auto">';
    // });
    // 
    $('#deal-text-detail').after('<?php echo ($deal["description"]); ?>');
    var deal_img_lazy = Lazy.create({
                lazyId: "deal-detail",
                trueSrc: 'src2',
                offset: 100, 
                delay: 0, 
                delay_tot: 0 
              }); 
    Lazy.init(deal_img_lazy);
    $(obj).text('收起图文详情').next(".glyphicon").removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
    $(obj).attr('onclick','showOrhide(this);');
}
function showOrhide(obj) {
    var _this = $(obj);
        text = _this.text();
    if (text == '收起图文详情') {
        $('#deal-detail').slideToggle("hide");
        _this.text('展开图文详情').next(".glyphicon").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
        
    }else{
        $('#deal-detail').slideToggle("show");
        _this.text('收起图文详情').next(".glyphicon").removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
    }
}
</script>

<script type="text/javascript">
var xx_lazy = Lazy.create({
                lazyId: "Jlazy_img",
                trueSrc: 'src2',
                offset: 300, 
                delay: 100, 
                delay_tot: 5000 
              }); 
Lazy.init(xx_lazy);
</script>
<p>&nbsp;</p>
<p>&nbsp;</p>
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

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
$(function(){
  
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'checkJsApi',
            'openLocation',
            'getLocation',
            'onMenuShareTimeline',
            'onMenuShareAppMessage'
          ]
    });
    wx.ready(function () {
        wx.onMenuShareAppMessage({
          title: '【诚车堂】<?php echo ($deal["dname"]); ?>：<?php echo ($deal["lname"]); ?>',
          desc: '<?php echo (strip_tags($deal["brief"])); ?>',
          link: 'http://m.17cct.com/index.php/Service/view/id/<?php echo ($did); ?>.html',
          imgUrl: '<?php echo (getimgurl($deal["img"],"middle")); ?>',
          trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
            // alert('用户点击发送给朋友');
          },
          success: function (res) {
            // alert('已分享');
          },
          cancel: function (res) {
            // alert('已取消');
          },
          fail: function (res) {
            // alert(JSON.stringify(res));
          }
        });

        wx.onMenuShareTimeline({
          title: '【诚车堂】<?php echo ($deal["dname"]); ?>：<?php echo ($deal["lname"]); ?>',
          link: 'http://m.17cct.com/index.php/Service/view/id/<?php echo ($did); ?>.html',
          imgUrl: '<?php echo (getimgurl($deal["img"],"middle")); ?>',
          trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
            // alert('用户点击分享到朋友圈');
          },
          success: function (res) {
            // alert('已分享');
          },
          cancel: function (res) {
            // alert('已取消');
          },
          fail: function (res) {
            // alert(JSON.stringify(res));
          }
        });
    });

    //测试接口
    // wx.checkJsApi({
    //     jsApiList: [
    //         'getLocation',
    //         'onMenuShareTimeline',
    //         'onMenuShareAppMessage'
    //     ],
    //     success: function (res) {
    //         alert(JSON.stringify(res));
    //     }
    // });

});
</script>