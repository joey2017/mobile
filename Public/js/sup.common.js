/**
 * 手机端公共js库
 */

var mob = {

    /**参数
     * [currentpage description]
     * @type {Number}
     */
    requestUrl:null,
    requesAttrtUrl:null,
    requesWarehousetUrl:null,
    jqueryString:null,
    sendData:{currentpage:0},
    stop:false,

    /**
     * 页面数据初始化
     * 
     * @DateTime 2017-11-07
     * @param    {[string]}   url        [请求的url地址]
     * @param    {[object]}   jq         [jQuery对象]
     */
    init:function(url,jq,initData = null){
        if(initData)
            this.sendData = $.extend(this.sendData,initData); 
        this.requestUrl   = url;
        this.jqueryString = jq;
        this.ajaxGetResults(this.sendData,this.requestUrl,this.jqueryString);
        this.scroll();
    },

    /**
     * 滚动加载
     *  
     * @DateTime 2017-11-07
     * @param    {[json]}     SendData       [参数json数组]
     * @return   {[void]}       
     */
    scroll:function(SendData = null){
        if(SendData)
            this.sendData = $.extend(this.sendData,SendData);
        var that = this;
        $(window).scroll(function(){ 
            totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 
            if($(document).height() <= totalheight){ 
                if(that.stop == true){ 
                    MsgBox('正在加载...');
                    that.sendData.currentpage++;
                    that.ajaxGetResults(that.sendData,that.requestUrl,that.jqueryString);
                } 
            } 
        });
    },

    /**
     * ajax搜索
     *  
     * @DateTime 2017-11-07
     * @return   {[void]}       
     */
    ajaxSearch:function(){
        var keyword    = $('#keyword').val();
        var start_time = $('#start_time').val();
        var end_time   = $('#end_time').val();
        var sort       = $('#sort').val();

        if(keyword == '' && start_time == '' && end_time == '' && sort == ''){
            MsgBox('请输入关键词搜索');
            return false;
        }
        this.sendData.keyword     = keyword;
        this.sendData.start_time  = start_time;
        this.sendData.end_time    = end_time;
        this.sendData.sort        = sort;
        this.sendData.currentpage = 0;
        this.ajaxGetResults(this.sendData,this.requestUrl,this.jqueryString);
    },

    /**
     * ajax获取数据
     *  
     * @DateTime 2017-11-07
     * @param    {[json]}     data       [参数json数组]
     * @param    {[string]}   url        [请求的url地址]
     * @param    {[object]}   jqString   [jQuery元素选择器]
     * @return   void
     */
    ajaxGetResults:function(Data,Url,jqString){
        $("#load").show();
        Url = Url ? Url : this.requestUrl;
        jqString = jqString ? jqString : this.jqueryString;
        this.stop = false;
        var that  = this;
        
    	$.get(Url,Data,function(html){
            if(html.status == 0)
                MsgBox(html.msg);
            else if(html != ""){
                if(Data.currentpage == 0) 
                    $(jqString).html(html);
                else
                    $(jqString).append(html);                                               

                that.stop=true;                  
              }else{
                MsgBox('已加载全部数据');
                if(Data.currentpage == 0)
                    $(jqString).html('<div class="no_record col-sm-12">暂无数据</div>');
              }                
             $("#load").hide();
    	});
    },

    /**
     * 时间插件
     *
     * 添加类名mobiscroll即可
     * 
     * @DateTime 2017-11-07
     *     
     */
    timePlugin:function(){
        var currYear = (new Date()).getFullYear();  
        var opt = {};
        opt.date = {preset : 'date'};
        opt.datetime = {preset : 'datetime'};
        opt.time = {preset : 'time'};
        opt.default = {
            theme: 'android-ics light', //皮肤样式
            display: 'modal', //显示方式 
            mode: 'scroller', //日期选择模式
            dateFormat: 'yy-mm-dd',
            lang: 'zh',
            showNow: true,
            nowText: "今天",
            startYear: currYear - 10, //开始年份
            endYear: currYear + 10 //结束年份
        };

        var optDateTime = $.extend(opt['date'], opt['default']);
        $(".mobiscroll").mobiscroll(optDateTime);
        $(".mobiscroll").mobiscroll(optDateTime);
    },

    /**
     * 排序
     *  
     * @DateTime 2017-11-07
     * @param    {[number]}   val        [分类数值]
     * @param    {[object]}   _this      [DOM元素]
     * @return   {[void]}       
     */
    setSort:function(val,_this){
        $('#sort').val(val);
        $('#comprehensive').html($(_this).find('a').html()+'<span class="arrowico"></span>');
        $(_this).addClass('tick').siblings().removeClass('tick');
        $(".sort_sele").slideToggle(200);
        this.ajaxSearch();
    },

    /**
     * ajax获取属性
     *  
     * @DateTime 2017-11-07
     * @param    {[number]}   class_id   [分类id]
     * @return   {[void]}       
     */
    ajaxGetAttr:function(requestAttrUrl = null){
        if(requestAttrUrl == null)
            requestAttrUrl = this.requestAttrUrl;
        else
            this.requestAttrUrl = requestAttrUrl;
        var class_id = $('#class_id').val();
        $.get(requestAttrUrl,{"class_id":class_id,"type":1},function(html){
            if(html != "")
                $("#attr_list").html(html);
            else
                MsgBox('该分类未添加有属性');
        });
    },

    /**
     * ajax获取属性
     *  
     * @DateTime 2017-11-07
     * @param    {[number]}   class_id   [分类id]
     * @return   {[void]}       
     */
    ajaxGetWarehouse:function(requestWarehouseUrl){
        if(requestWarehouseUrl == null)
            requestWarehouseUrl = this.requestWarehouseUrl;
        else
            this.requestWarehouseUrl = requestWarehouseUrl;
        $.get(requestWarehouseUrl,function(html){
            if(html!="")
                $("#common").html(html);               
        });
    },

    /**
     * 重置属性
     *  
     * @DateTime 2017-11-07
     * @return   {[void]}       
     */
    resetAttr:function(){
        $('#attr_value').val('');
        $('.tc_project').removeClass('tc_choose');
        $('.row_body').each(function(){
            $(this).find('a').first().addClass('tc_choose');
        });    
    }

};

//回车搜索
$(document).on('keydown',function(event){
    e = event ? event :(window.event ? window.event : null);   

    if(e.keyCode==13){
        if($('.enter-search').val() != ''){
            //执行的方法
            mob.ajaxSearch();  
        }    
    }   
})

$(document).ready(function(){

    //页面效果
    $('#comprehensive').click(function(){
        $(".sort_sele").slideToggle(200);
        $(".sort_sele2").hide();
    });

    $('#classification').click(function(){
        $(".sort_sele2").slideToggle(200);
        $(".sort_sele").hide();
    });   

    $(".row_title").click(function(){
        $(this).children().toggleClass('spanrotate');           
    });     

    //筛选切换
    $(".row_title").each(function(index){
        $(this).click(function(){
            $(this).find('span').toggleClass('fa-caret-down').toggleClass('fa-caret-up');
            $(this).next().toggle();
        }); 
    });

    $(".li_choose a").click(function(){ 
        $(this).addClass("tc_choose").parent().siblings().find('.tc_project').removeClass("tc_choose");
        var attr = [];
        $(".li_choose a").each(function(){
            if($(this).hasClass("tc_choose") && $(this).attr('value')!=0){
                attr.push($(this).attr('value'));
            }
        });
        $('#attr_value').val(attr);

    });     
}); 


