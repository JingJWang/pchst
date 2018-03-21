var check;
$(document).on('click', '.contactInfo .submit', function() {
    var url = window.location.pathname;
    var urlarr = Array();
    var urlarr = url.split("/"); //字符分割
    var length = urlarr.length;
    var sid = urlarr[length-1];//商品id
    var select = $('.particular .price .active').attr('price');//选择的奖励
    var type = $('.submit').attr('type');//商品类型
    var d = 'sid='+sid+'&price='+select;
    if (type==2) {
	    if ($('.details .active').length==0) {
	        alert('请选择地址');
	        return ;
	    };
	    var name = $('.selectAddress .details .active .name').html();
	    var pri = $('.selectAddress .details .active .province').html();
	    var city = $('.selectAddress .details .active .city').html();
	    var area = $('.selectAddress .details .active .sarea').html();
	    var detail = $('.selectAddress .details .active .addr').html();
	    var phone = $('.selectAddress .details .active .tel').html();//地址信息
        var adresid = $('.selectAddress .details .road.active').attr('adres-id');//地址信息
    	d += '&name='+name+'&mobile='+phone+'&province='+pri+'&city='+city+'&area='
            +area+'&adr_detail='+detail+'&adresid='+adresid;
    }else if (type==4) {
	    var phone = $("#phonenum").val();
        if (phone=='') {
            alert('请输入手机号码');
            return ;
        };
	    d += '&mobile='+phone;
    }else if (type!=1) {
    	return ;
    }
    if ($(".summation .price .allprice").html()>16000) {
        alert("此价格属大额支付，请联系客服帮您支付：400-641-5080");
        return;
    };
    var u = '/index.php/shops/shoporder/commitorder';
    var f = function(res){
        response = eval(res);
        if (response['status']==1000) {
            if (response['data']['config']!=undefined) {
                $('.defray').after(response['data']['config']);
                return ;
            };
            var show = '';
            $('.defray .information .payPrice .money').html(response['data']['price']/100);
            $('.defray .information .picture .code').html('<img src="'+response['data']['qrimg']+'"/>');
            show += '<div class="covers">'+
                        '<div class="attribute">商品名称：</div>'+
                        '<div class="name sname">'+response['data']['name']+'</div>'+
                    '</div>';
            show += '<div class="covers">'+
                        '<div class="attribute">商品名称：</div>'+
                        '<div class="name ordernumber">'+response['data']['number']+'</div>'+
                    '</div>';
            if (response['data']['inte']>0&&response['data']['price']>0) {
                Allprice = '¥ '+(response['data']['price']/100)+'+'+response['data']['inte']+'通花';
            }else if(response['data']['price']>0){
                Allprice = '¥ '+(response['data']['price']/100);
            }else if(response['data']['inte']>0){
                Allprice = response['data']['inte']+'通花';
            }
            if (response['data']['fid']==1) {
                show += '<div class="covers">'+
                            '<div class="attribute">商品金额：</div>'+
                            '<div class="price">'+Allprice+'</div>'+
                        '</div>';
            };
            if (response['data']['fid']==2) {
                var info = response['data']['record_adress'].split(',');
                show += '<div class="covers">'+
                            '<div class="attribute">收货信息：</div>'+
                            '<div class="name">'+info['2']+'</div>'+
                        '</div>'+
                        '<div class="covers">'+
                            '<div class="attribute">收货人：</div>'+
                            '<div class="name">'+
                                '<span>'+info['0']+'</span>'+
                                '<span>'+info['1']+'</span>'+
                            '</div>'+
                        '</div>'+
                        '<div class="covers">'+
                            '<div class="attribute">商品金额：</div>'+
                            '<div class="price">'+Allprice+'</div>'+
                        '</div>';
            };
            if (response['data']['fid']==4||response['data']['tyid']==4) {
                show += '<div class="covers">'+
                            '<div class="attribute">收货信息：</div>'+
                            '<div class="name">'+response['data']['record_content']+'</div>'+
                        '</div>'+
                        '<div class="covers">'+
                            '<div class="attribute">商品金额：</div>'+
                            '<div class="price">'+Allprice+'</div>'+
                        '</div>';
            };
            $('.defray .order-detail').html(show);
            $(".shadow , .defray").show();
            check = setInterval('lunorder()',5000);
        }else{
            alert(response['msg']);
        }
    }
    AjaxRequest(u,d,f);
});
function sureoderclick(){
    var number = $('.ordernumber').html();
    var u = '/index.php/shops/shoporder/checkorder';
    var d ='number='+number;
    var f =function(res){
        var response=eval(res);
        if (response['status'] == request_succ) {
            UrlGoto('/index.php/shops/shopinfo/orderdetail/'+response['data']['id']);
            clearInterval(check);
        }else{
            alert("您的订单还未处理成功！");
        }
    }
    AjaxRequest(u,d,f);
}
function sureoder(){
    var number = $('.ordernumber').html();
    var u = '/index.php/shops/shoporder/checkorder';
    var d ='number='+number;
    var f =function(res){
        var response=eval(res);
        if (response['status'] == request_succ) {
            UrlGoto('/index.php/shops/shopinfo/orderdetail/'+response['data']['id']);
            clearInterval(check);
        }
    }
    AjaxRequest(u,d,f);
}
var turnnumber = 0;
function lunorder(){
    if (turnnumber<10) {
        sureoder();
    }else{
        clearInterval(check);
    }
    turnnumber++;
}


function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}