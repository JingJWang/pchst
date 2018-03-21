/**
 * Created by Administrator on 2016/8/18 0018.
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


$(document).ready(function(){
    $("input").focus(function(){
        $(".press").css("color","#666666");
    });
});