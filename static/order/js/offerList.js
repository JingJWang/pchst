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

//切换排序方式
$(".choices").click(function(){
    $(this).parents(".assortment").find(".choices.active").removeClass("active");
    $(this).addClass("active");
    Screening();
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

//点击刷新显示报价列表
$(".reload").click(function(){
    // $(".offer-list").css("display","block");
    // $(".noOffer").css("display","none");
     location.reload()
});