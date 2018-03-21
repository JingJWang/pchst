/**
 * Created by Administrator on 2016/8/22 0022.
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
//选择同意协议
$(".checkbox").click(function(){
    if($(this).hasClass("active")){
        $(".checkbox.active").removeClass("active");
    }else{
        $(this).addClass("active");
    }
});

//回收通账号登录
$(".account").click(function(){
    $(this).addClass("active");
    $(this).siblings(".message").removeClass("active");
    $(".frame").css("display","block");
    $(".wholly").css("display","none");
});

//短信验证登录
$(".message").click(function(){
    $(this).addClass("active");
    $(this).siblings(".account").removeClass("active");
    $(".frame").css("display","none");
    $(".wholly").css("display","block");
});

$(document).ready(function(){
    $("input").focus(function(){
        $(".press").css("color","#666666");
    });
});