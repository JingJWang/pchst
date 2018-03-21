//添加地址里的保存按钮
$(document).on('click', '.addition .conserve', function(event) {
    var name = $(".addition").find(".name").val();
    // var am = $(".addition").find(".area").val();
    var nm = $(".addition").find(".addr").val();
    var phone = $(".addition").find(".tel").val();
    var pri = $("#hcity").val();
    var city = $("#hproper").val();
    var area = $("#harea").val();
    if($(".addition .install").hasClass("active")){
        var isActive = true;
        var ismo = 2;
    }else{
        var ismo = 1;
        var isActive = false;
    }
    if (name==undefined||name=='') {
        alert('名字不能为空');
        return ;
    };
    if (pri==undefined||pri=='') {
        alert('省份不能为空');
        return ;
    };
    if (city==undefined||city=='') {
        alert('城市不能为空');
        return ;
    };
    if (area==undefined||area=='') {
        alert('地区不能为空');
        return ;
    };
    if (nm==undefined||nm=='') {
        alert('详细地址不能为空');
        return ;
    };
    if (phone==undefined||phone=='') {
        alert('手机号码不能为空');
        return ;
    };
    var u = '/index.php/address/addaddress';
    var d = 'name='+name+'&phone='+phone+'&province='+pri+'&city='+city+'&area='
            +area+'&adr_detail='+nm+'&default='+ismo;
    var f = function(res){
        var response = eval(res);
        if (response['status'] == request_succ) {
            if ($('.select').length==0) {
                location.reload();
                return ;
            };
            $(".road.active").removeClass("active");
            //判断是否选择了默认
            if($(".addition .install").hasClass("active")){
                $(".road").siblings(".road").find(".tacit.active").removeClass("active");
            }else{
                $(".road.active .tacit.active").removeClass("active");
            }
            var html = '<div style="cursor:pointer;" class="road active" adres-id="'+response['data']+'">'+
                '<div class="name">'+ name + '</div>'+
                '<div class="area">'+
                    '<span class="province">'+$("#hcity").val()+'</span>'+
                    '<span class="city">'+$("#harea").val()+'</span>'+
                    '<span class="sarea">'+$("#hproper").val()+'</span>'+
                '</div>'+
                '<div class="addr">'+ nm + '</div>'+
                '<div class="tel">'+ phone + '</div>'+
                '<div class="handle">'+
                '<div class="operate">'+
                '<a class="modify" href="javascript:;">修改</a>'+
                '</div>'+
                '</div>'+
                '<div class="tacit' + (isActive ? ' active' : '') + '"></div>'+
                '</div>';
            $(".details").append(html);
            $(".addition").css("display","none");
            $(".addition .abolish").css("display","none");
        }else{
            if (response['msg']!='') {
                alert(response['msg']);
            }else{
                alert('添加失败');
            }
        }
    }
    AjaxRequest(u,d,f);
});

$(document).on('click', '.revise .conserve', function(event) {
    var name = $(".revise").find(".name").val();
    var pri = $("#hcity").val();
    var city = $("#hproper").val();
    var area = $("#harea").val();
    var nm = $(".revise").find(".addr").val();
    var phone = $(".revise").find(".tel").val();
    if($(".revise .install").hasClass("active")){
        var ismo = 2;
    }else{
        var ismo = 1;
    }
    if (name==undefined||name=='') {
        alert('名字不能为空');
        return ;
    };
    if (pri==undefined||pri=='') {
        alert('省份不能为空');
        return ;
    };
    if (city==undefined||city=='') {
        alert('城市不能为空');
        return ;
    };
    if (area==undefined||area=='') {
        alert('地区不能为空');
        return ;
    };
    if (nm==undefined||nm=='') {
        alert('详细地址不能为空');
        return ;
    };
    if (phone==undefined||phone=='') {
        alert('手机号码不能为空');
        return ;
    };
    var arid = $(".revise").attr('adres-id');
    var u = '/index.php/address/upaddress';
    var d = 'name='+name+'&phone='+phone+'&province='+pri+'&city='+city+'&area='
            +area+'&adr_detail='+nm+'&default='+ismo+'&adressid='+arid;
    var f = function(res){
        var response = eval(res);
        if (response['status'] == request_succ) {
            $(".revise").find(".area").val(pri+city+area);
            $(".road.pitch .name").html(name);
            $(".road.pitch .area .province").html(pri);
            $(".road.pitch .area .city").html(city);
            $(".road.pitch .area .sarea").html(area);
            $(".road.pitch .addr").html(nm);
            $(".road.pitch .tel").html(phone);
            //判断是否选择了默认
            if($(".revise .install").hasClass("active")){
                $(".road.pitch .tacit").addClass("active");
                $(".road.pitch").siblings(".road").find(".tacit.active").removeClass("active");
            }else{
                $(".road.pitch .tacit.active").removeClass("active");
            }
            $(".revise").css("display","none");
            $(".revise .abolish").css("display","none");
            $(".addition").css("display","none");
            $(".road.active").removeClass("active");
            $(".road.pitch").addClass("active");
            $(".road.pitch").removeClass("pitch");
        }else{
            alert('修改失败');
        }
    }
    AjaxRequest(u,d,f);

});
$(document).on('click', '.transaction', function(event) {
    if ($('.details .active').length==0) {
        alert('请选择地址');
        return ;
    };
    var fid = getUrlParam('fid');
    var oid = getUrlParam('oid');
    var name = $('.details .active .name').html();
    var pri = $('.details .active .province').html();
    var city = $('.details .active .city').html();
    var area = $('.details .active .sarea').html();
    var detail = $('.details .active .addr').html();
    var phone = $('.details .active .tel').html();
    var u = '/index.php/order/quote/ChoiceQuote';
    var d = 'name='+name+'&mobile='+phone+'&province='+pri+'&city='+city+'&area='
            +area+'&adr_detail='+detail+'&oid='+oid+'&qid='+fid;
    var f = function(res){
        var response = eval(res);
        if (response['status'] == request_succ) {
            if (response['url']!='') {
                window.location.href = response['url'];
            };
        }else{
            alert(response['msg']);
        }
    }
    AjaxRequest(u,d,f);
});
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}