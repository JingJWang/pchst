/**
 * Created by Administrator on 2016/8/24 0024.
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

//展开回收商信息
$(document).on('click', '.deploy', function(event) {
    if($(this).parents(".explicit").find(".expand").css("display") == "none"){
        $(this).parents(".explicit").find(".expand").css("display","block");
        $(this).parents(".policy").siblings().find(".expand").css("display","none");
    }else{
        $(this).parents(".explicit").find(".expand").css("display","none");
    } 
});