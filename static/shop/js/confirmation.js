//显示全部分类
$('.general').hover(function () {
    $(".classList").show();
}, function () {
    $(".classList").hide();
});

//切换支付方式
$(".payment .mode").click(function(){
    $(".mode.active").removeClass("active");
    $(this).addClass("active");
});

//选择价格
$(".goodsPrice").click(function(){
    var price = $(this).html();
    $(".summation .price").html(price);
    $(".total .price").html(price);
    $(".goodsPrice.active").removeClass("active");
    $(this).addClass("active");
});

//提交订单
$(".defray .close-btn").click(function(){
    $(".shadow , .defray").hide();
})