/**
 * Created by Administrator on 2016/8/23 0023.
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

//切换状态
$(".step").click(function(){
    $(".step.active").removeClass("active");
    $(this).addClass("active");
});

//切换交易方式
$(".recover").click(function(){
    $(".recover.active").removeClass("active");
    $(this).addClass("active");
});

$(document).ready(function(){
    $("input").focus(function(){
        $(".btn").css("color","#666666");
    });
});

//选择默认
$(".install").click(function(){
    if($(this).hasClass("active")){
        $(this).removeClass("active");
    }else{
        $(this).addClass("active");
    }
});

//选中地址
$(document).on('click', '.road', function(event) {
    $(".road.active").removeClass("active");
    $(this).addClass("active");
});

//修改按钮
$(document).on('click', '.modify', function(event) {
    $(this).parents(".road").addClass("pitch");
    $(this).parents(".road").siblings(".road.pitch").removeClass("pitch");
    var mz = $(this).parents(".road").find(".name").html();
    var province = $(this).parents(".road").find(".area .province").html();
    var city = $(this).parents(".road").find(".area .city").html();
    var sarea = $(this).parents(".road").find(".area .sarea").html();
    var dq = $(this).parents(".road").find(".area").html();
    var dz = $(this).parents(".road").find(".addr").html();
    var dh = $(this).parents(".road").find(".tel").html();
    var id = $(this).parents(".road").attr("adres-id");
    $(".revise").attr("adres-id",id);
    $(".revise").css("display","block");
    $(".revise .abolish").css("display","block");
    $(".addition").css("display","none");
    $(".revise").find(".name").val(mz);
    $("#hcity").val(province);
    $("#harea").val(sarea);
    $("#hproper").val(city);
    $(".revise").find(".area").val(province+city+sarea);
    $(".revise").find(".addr").val(dz);
    $(".revise").find(".tel").val(dh);
    if($(".road.pitch").find(".tacit").hasClass("active")){
        $(".revise .install").addClass("active");
    }else{
        $(".revise .install.active").removeClass("active");
    }

    //修改地址里的关闭按钮
    $(".revise .abolish").click(function(){
        $(".road.pitch").removeClass("pitch");
        $(".revise , .revise .abolish").css("display","none");
    })
});

//添加地址
$(".append").click(function(){
    $(".conserve").find(".name").val("");
    $(".conserve").find(".area").val("");
    $(".conserve").find(".addr").val("");
    $(".conserve").find(".tel").val("");
    $(".address.addition").css("display","block");
    $(".address.addition .abolish").css("display","block");
    $(".address.revise").css("display","none");

    //添加地址里的关闭按钮
    $(".addition .abolish").click(function(){
        $(".addition , .addition .abolish").css("display","none");
    })
});


//点击输入框输入框里的文字变颜色
$(document).ready(function(){
    $("input").focus(function(){
        $(".entry").css("color","#666666");
    });
});