/**
 * Created by Administrator on 2016/8/28 0028.
 */
//滚动条事件，当滚动条滚动时为导航栏添加样式
window.onscroll = function () {
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if (t > 0) {
        $(".navigation").addClass("active");
    } else {
        $(".navigation").removeClass("active");
    }
};

//切换导航栏
$(".className").click(function(){
    $(".className.active").removeClass("active");
    $(this).addClass("active");
});

//显示全部类型
$(".total").click(function(){
    if($(".categorize").css("display") == "none"){
        $(".categorize").css("display","block");
    }else{
        $(".categorize").css("display","none");
    }
});

//将选中的订单状态显示到上边
$(".sort-name").click(function(){
    $(".categorize").css("display","none");
    $(".total").html($(this).html());
    $(this).siblings(".sort-name.active").removeClass("active");
    $(this).addClass("active");
});

//选择我的订单里的分类
$(".classes").click(function(){
    $(this).siblings(".classes.active").removeClass("active");
    $(this).addClass("active");
});

//切换全部产品
$(".restrain").click(function(){
    $(".restrain.active").removeClass("active");
    $(this).addClass("active");
});

//选择默认
$(".install").click(function(){
    if($(this).hasClass("active")){
        $(this).removeClass("active");
    }else{
        $(this).addClass("active");
    }
});

//修改按钮
$(".modify").click(function(){
    $(this).parents(".road").addClass("active");
    $(this).parents(".road").siblings(".road.active").removeClass("active");
    var mz = $(this).parents(".road").find(".name").html();
    var privince = $(this).parents(".road").find(".privince").html();
    var city = $(this).parents(".road").find(".city").html();
    var area = $(this).parents(".road").find(".sarea").html();
    var dz = $(this).parents(".road").find(".addr").html();
    var dh = $(this).parents(".road").find(".tel").html();
    var aid = $(this).parents('.road').attr('adres-id');
    $(".revise").css("display","block");
    $(".addition").css("display","none");
    $(".revise").find(".name").val(mz);
    $(".revise").find(".area").val(privince+city+area);
    $(".revise").find(".addr").val(dz);
    $(".revise").find(".tel").val(dh);
    $("#hcity").val(privince);
    $("#hproper").val(city);
    $("#harea").val(area);
    $(".revise").find(".message").attr('adres-id', aid);;
    if($(".road.active").find(".tacit").hasClass("active")){
        $(".revise .install").addClass("active");
    }else{
        $(".revise .install.active").removeClass("active");
    }
});

//修改地址里的保存按钮
function afterupadres(){
    var an = $(".revise").find(".name").val();
    var privince = $("#hcity").val();
    var city = $("#hproper").val();
    var area = $("#harea").val();
    // var am = $(".revise").find(".area").val();
    var nm = $(".revise").find(".addr").val();
    var mn = $(".revise").find(".tel").val();
    $(".road.active .name").html(an);
    $(".road.active .privince").html(privince);
    $(".road.active .city").html(city);
    $(".road.active .sarea").html(area);
    $(".road.active .addr").html(nm);
    $(".road.active .tel").html(mn);
    $("#hcity").val('');
    $("#hproper").val('');
    $("#harea").val('');
    //判断是否选择了默认
    if($(".revise .install").hasClass("active")){
        $(".road.active .tacit").addClass("active");
        $(".road.active").siblings(".road").find(".tacit.active").removeClass("active");
    }else{
        $(".road.active .tacit.active").removeClass("active");
    }
    $(".revise").css("display","none");
    $(".addition").css("display","block");
    $(".road.active").removeClass("active");
};

//删除
$(".delete").click(function(){
    $(".delinfo .tooltip").html('您确定要删除该地址吗？');
    $(this).parents(".road").addClass("active");
    $(this).parents(".road").siblings(".road.active").removeClass("active");
    $(".shadow").css("display","block");
    $(".delinfo").css("display","block");
});

//弹框取消，关闭按钮
$(".abolish , .close-btn").click(function(){
    $(".shadow").css("display","none");
    $(".bounced").css("display","none");
    $(".road.active").removeClass("active");
});

$(".confirm").click(function(){
    $(".shadow").css("display","none");
    $(".bounced").css("display","none");
});

//点击输入框输入框里的文字变颜色
$(document).ready(function(){
    $("input").focus(function(){
        $(".entry").css("color","#666666");
    });
});