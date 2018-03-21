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

//切换订单分类
$(".feather").click(function(){
    $(".feather.active").removeClass("active");
    $(this).addClass("active");
});

//切换数码回收里订单状态
$(".estate").click(function(){
    $(".estate.active").removeClass("active");
    $(this).addClass("active");
});

//切换其他回收里订单状态
$(".orderClass .mold").click(function(){
    $(".orderClass .mold.active").removeClass("active");
    $(this).addClass("active");
});

//切换通花商城里的订单状态
$(".trance").click(function(){
    $(".trance.active").removeClass("active");
    $(this).addClass("active");
});

//其他回收里的取消交易
$(".reveal .cancleDeal").click(function(){
    $(this).parents(".exhibition").addClass("delete");
    $(".shade , .bounced").show();
    //关闭取消按钮
    $(".bounced .close-btn , .bounced .abolish").click(function(){
        $(".shade , .bounced").hide();
        $(".exhibition.delete").removeClass("delete");
    });
    //确定按钮
    $(".bounced .confirm").click(function(){
        $(".shade , .bounced").hide();
        $(".exhibition.delete").hide();
    });
});

//数码回收订单显示
$(".feather.digit").click(function(){
    $(".digital-order").show();
    $(".nobleMetal-order").hide();
    $(".mallOrder").hide();
});

//其他回收订单显示
$(".feather.metal").click(function(){
    $(".nobleMetal-order").show();
    $(".digital-order").hide();
    $(".mallOrder").hide();
});

//通花商城订单
$(".feather.shop").click(function(){
    $(".mallOrder").show();
    $(".nobleMetal-order").hide();
    $(".digital-order").hide();
});