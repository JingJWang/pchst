var url = window.location.pathname;
var urlarr = Array();
var urlarr = url.split("/"); //字符分割
var types = urlarr[urlarr.length-1];//商品id
if (types=='shop') {
    shoplist();
    $('.feather').trigger('click')
}else{
    GetOrder('n');
}
var G_AllList = '';
$(document).on('click', '.feather', function(event) {
    
});
function GetOrder(status) {
    $(".goodsCon").html('');
    if(status == 'y'){
        yListOrder();
    }
    if(status == 'n'){
        nListOrder();
    }
}
function yListOrder(){      
    var u='/index.php/order/orders/getList';
    var d='status=1';
    var f=function(res){
        var response=eval(res);
        if(response['status'] == request_succ){
            G_AllList = response['data'];
            addtext(0,1);
            
            $('.order-state .overs .voer').html(response['data'].length);
        }
    }
    AjaxRequest(u,d,f);
}
function nListOrder(){  
    var u='/index.php/order/orders/getList';
    var d='status=2';
    var f=function(res){
        var content='',content_a='',content_d='',content_c='',content_b='';
        var response=eval(res);
        if(response['status'] == request_succ){
            G_AllList = response['data'];
            addtext(0,2);
            $('.order-state .estate .go').html(response['data'].length);
            $('.order-state .gos').addClass('active');
        }       
    }
    AjaxRequest(u,d,f);
}
function addtext(star,status){
    var addtexts = G_AllList.slice(star*6,star*6+6);
    $('.pagination').html('');
    if (G_AllList.length>6) {
        page(6,star*6,G_AllList.length,status);
    };
    if (status==2) {
        var content='',content_a='',content_d='',content_c='',content_b='';
        $.each(addtexts,function(k,v){
            if(v['flag'] == 'd'){
                content_d = content_d + '<div class="group">'+
                                '<div class="phoneModel">'+v['name']+'</div>'+
                                '<div class="condition">'+v['status']+'</div>'+
                                '<div class="offerState">'+
                                    '<span></span>'+
                                    '<span class="number"></span>'+
                                    '<span></span>'+
                                '</div>'+
                                '<div class="time">'+v['time']+'</div>'+
                                '<div class="operate">'+
                                    '<a class="option" href="javascript:;">继续填写</a>'+
                                '</div>'+
                            '</div>';
            }
            if(v['flag'] == 'a'){
                content_a = content_a + '<div class="group">'+
                                '<div class="time">'+v['number']+'</div>'+
                                '<div class="phoneModel">'+v['name']+'</div>'+
                                '<div class="condition">报价中</div>'+
                                '<div class="offerState">'+
                                    '<span>已报</span>'+
                                    '<span class="number">'+v['offer']+'</span>'+
                                    '<span>人</span>'+
                                '</div>'+
                                '<div class="time">'+v['time']+'</div>'+
                                '<div class="operate">'+
                                    '<a class="option" href="'+v['info']+'">订单详情</a>'+
                                    '<a class="look" href="'+v['perimit']+'">查看报价</a>'+
                                '</div>'+
                            '</div>';
            }
            if(v['flag'] == 'c'){
                content_a = content_a + '<div class="group">'+
                                '<div class="time">'+v['number']+'</div>'+
                                '<div class="phoneModel">'+v['name']+'</div>'+
                                '<div class="condition">.</div>'+
                                '<div class="offerState">'+
                                    '<span>已报</span>'+
                                    '<span class="number">'+v['offer']+'</span>'+
                                    '<span>人</span>'+
                                '</div>'+
                                '<div class="time">'+v['time']+'</div>'+
                                '<div class="operate">'+
                                    '<a class="option" href="'+v['info']+'">订单详情</a>'+
                                    '<a class="look" href="'+v['perimit']+'">查看报价</a>'+
                                '</div>'+
                            '</div>';
            }
            if(v['flag'] == 'b'){
                content_a = content_a + '<div class="group">'+
                                '<div class="time">'+v['number']+'</div>'+
                                '<div class="phoneModel">'+v['name']+'</div>'+
                                '<div class="condition">待交易</div>'+
                                '<div class="offerState">'+
                                    '<span>已报</span>'+
                                    '<span class="number">'+v['offer']+'</span>'+
                                    '<span>人</span>'+
                                '</div>'+
                                '<div class="time">'+v['time']+'</div>'+
                                '<div class="operate">'+
                                    '<a class="option" href="'+v['info']+'">订单详情</a>'+
                                '</div>'+
                            '</div>';
            }
        })
        $('.handle').css('display', 'block');
        $('.offer').html('报价状态');
        content=content_b+content_a+content_d+content_c;
        $(".quenofinish").html(content);
    }else{
        var b=10,c=-1;
        var evaluation='';
        var content='';
        $.each(addtexts,function(k,v){
            if(v['status'] == b){
                if(v['evaluation'] == ''){
                    evaluation='已评价';
                }else{
                    evaluation='<a href="'+v['evaluation']+'">去评价</a>';
                }
                content =content + '<div class="group">'+
                                '<div class="time">20160715575397491811</div>'+
                                '<div class="phoneModel">'+v['name']+'</div>'+
                                '<div class="condition">已成交</div>'+
                                '<div class="offerState">'+
                                    '<span></span>'+
                                    '<span>￥'+v['price']+'</span>'+
                                    '<span></span>'+
                                '</div>'+
                                '<div class="time">'+v['jtime']+'</div>'+
                            '</div>';
            }
            if(v['status'] == c){
                if(v['evaluation'] == ''){
                    evaluation='已评价';
                }else{
                    evaluation='<a href="'+v['evaluation']+'">去评价</a>';
                }
                content =content + '<div class="group">'+
                                '<div class="time">20160715575397491811</div>'+
                                '<div class="phoneModel">'+v['name']+'</div>'+
                                '<div class="condition">已取消</div>'+
                                '<div class="offerState">'+
                                    '<span></span>'+
                                    '<span class="number"></span>'+
                                    '<span>人</span>'+
                                '</div>'+
                                '<div class="time">'+v['time']+'</div>'+
                            '</div>';
            }
        });
        $('.handle').css('display', 'none');
        $('.offer').html('总价格');
        $('.quenofinish').html(content);
    }
}

var overorder = Array();
var doorder = Array();
function shoplist(){
    var u='/index.php/shops/shopinfo/shoplist';
    var d='';
    var f=function(res){
        var response=eval(res);
        if(response['status'] == request_succ){
            var list = '';
            $.each(response['data'], function(i, v) {
                if (v['status']==1) {
                    overorder[overorder.length] = v;
                }else{
                    doorder[doorder.length] = v;
                }
            });
            $('.mallOrder .doing').html(doorder.length);
            $('.mallOrder .end').html(overorder.length);
            $('.mallOrder .dorder').addClass('active');
            $('.shoporder').trigger('click');
            addshoplist(0,2);
        }  
    }
    AjaxRequest(u,d,f);
}
$(document).on('click', '.mallOrder .endorder', function(event) {
    addshoplist(0,1);
});
$(document).on('click', '.mallOrder .dorder', function(event) {
    addshoplist(0,2);
});
function addshoplist(star,type){
    if (type==1) {
        var goodlist = overorder.slice(star*6,star*6+6);
        var allist = overorder.length;
    }else{
        var goodlist = doorder.slice(star*6,star*6+6);
        var allist = doorder.length;
    }
    var list = '';
    $.each(goodlist, function(i, v) {
        var integral = '';
        if (v['integral']>0) {
            integral = '+'+v['integral']+'通花';
        };
        if (v['status']==1) {
            var stus = '已完成';
        }else{
            var stus = '正在配送';
        }
        list += '<div class="message">'
                    +'<div class="basic">'
                        +'<div class="order-number">'
                            +'<span>订单编号：</span>'
                            +'<span>'+v['pid']+'</span>'
                        +'</div>'
                        +'<div class="time">'
                            +'<span>下单时间：</span>'
                            +'<span>'+formatDate(v['jointime'])+'</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="reveal">'
                       +'<div class="detail">'
                            +'<div class="print">'
                                +'<img src="'+v['img']+'"/>'
                            +'</div>'
                            +'<div class="describe">'
                                +'<div class="title">'+v['name']+'</div>'
                                +'<div class="votes">正品行货  性价比高  全国包邮</div>'
                            +'</div>'
                        +'</div>'
                        // +'<div class="unitPrice" style="width:140px;">(￥'+(v['pri']/100)+integral+')×1</div>'
                        +'<div class="total">￥'+(v['pri']/100)+integral+'</div>'
                        +'<div class="state">'+stus+'</div>'
                        +'<div class="handle">'
                            +'<a class="further" target=_blank href="/index.php/shops/shopinfo/orderdetail/'+v['id']+'">订单详情</a>'
                        +'</div>'
                    +'</div>'
                +'</div>';
    });
    $('.orderDetail .orderList').html(list);
    shoppage(6,star*6,allist,type);
}
function page(one_pag,now,num,status){
    var page = Math.ceil(num/one_pag);//可以分的页数
    var pages = '';
    if (num<=one_pag) {
        return ;
    }
    if (now>=one_pag) {//此处加上首页
        pages += '<a class="page sight" onclick="addtext(0,'+status+')" href="javascript:;">首页</a><a class="page last" onclick="addtext('+(now/one_pag-1)+','+status+')" href="javascript:;">&nbsp</a>';
    }
    if (page<=5) {
        for (var i = 0; i < page; i++) {
            pages += '<a class="page" id="'+(i*one_pag)+'" onclick="addtext('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
        };
    }else{
        if ((now/one_pag)<3) {
            for (var i = 0; i <= 5; i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" onclick="addtext('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }else if (now/one_pag>=(page-3)) {
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (page-5); i <= page-1; i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" onclick="addtext('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
            };
        }else{//加首页
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (now/one_pag-2); i < (now/one_pag+3); i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" onclick="addtext('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }
    }
    if (now<(page-1)*one_pag) {//加尾页
        pages += '<a class="page next" onclick="addtext('+(now/one_pag+1)+','+status+')" href="javascript:;">&nbsp</a><a class="page sight" onclick="addtext('+(page-1)+','+status+')" href="javascript:;">末页</a>';
    };
    $('.pagination').html(pages);
    $('#'+now+'').addClass('active');
}
function shoppage(one_pag,now,num,status){
    var page = Math.ceil(num/one_pag);//可以分的页数
    var pages = '';
    if (num<=one_pag) {
        return ;
    }
    if (now>=one_pag) {//此处加上首页
        pages += '<a class="page sight" onclick="addshoplist(0,'+status+')" href="javascript:;">首页</a><a class="page last" onclick="addshoplist('+(now/one_pag-1)+','+status+')" href="javascript:;">&nbsp</a>';
    }
    if (page<=5) {
        for (var i = 0; i < page; i++) {
            pages += '<a class="page" id="p'+(i*one_pag)+'" onclick="addshoplist('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
        };
    }else{
        if ((now/one_pag)<3) {
            for (var i = 0; i <= 5; i++) {
                pages += '<a class="page" id="p'+(i*one_pag)+'" onclick="addshoplist('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }else if (now/one_pag>=(page-3)) {
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (page-5); i <= page-1; i++) {
                pages += '<a class="page" id="p'+(i*one_pag)+'" onclick="addshoplist('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
            };
        }else{//加首页
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (now/one_pag-2); i < (now/one_pag+3); i++) {
                pages += '<a class="page" id="p'+(i*one_pag)+'" onclick="addshoplist('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }
    }
    if (now<(page-1)*one_pag) {//加尾页
        pages += '<a class="page next" onclick="addshoplist('+(now/one_pag+1)+','+status+')" href="javascript:;">&nbsp</a><a class="page sight" onclick="addshoplist('+(page-1)+','+status+')" href="javascript:;">末页</a>';
    };
    $('.mallOrder .pagination').html(pages);
    var a = $('#p'+now+'').addClass('active');
}
//时间转换  
function   formatDate(now)   {  
    if (now==0) {
        return '-';
    };    
    var   now= new Date(now*1000);     
    var   year=now.getFullYear();     
    var   month=now.getMonth()+1;     
    var   date=now.getDate();     
    var   hour=now.getHours();      
    var   minute=now.getMinutes();     
    var   second=now.getSeconds();      
    return   year+"年"+fixZero(month,2)+"月"+fixZero(date,2)+"日    "+fixZero(hour,2)+":"+fixZero(minute,2)+":"+fixZero(second,2); 
}
//时间如果为单位数补0  
function fixZero(num,length){     
    var str=""+num;      
    var len=str.length;     
    var s="";      
    for(var i=length;i-->len;){         
        s+="0";     
    }      
    return s+str; 
}