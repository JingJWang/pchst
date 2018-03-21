header();
footer();

//显示全部分类
$('.general').hover(function () {
    $(".classList").show();
}, function () {
    $(".classList").hide();
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

