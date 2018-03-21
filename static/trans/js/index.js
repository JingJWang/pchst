//判断如果是推广员页面的样式不同
//$("body").addClass("promoter");

//var str = "";
//var date = new Date();
//var str = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() ;
//$(".time span").html(str);

$(".palette").click(function(){
    $(".palette.active").removeClass("active");
    $(this).addClass("active");
});

//切换页码
$(".page").click(function(){
    $(".page.active").removeClass("active");
    $(this).addClass("active");
});
/*
//用户数量列表
$("#user").click(function(){
    $(".agentNumber , .recovery , .consignment  , .marker , .brokerage").hide();
    $(".userNumber").show();
});

//代理数量列表
$("#agent").click(function(){
    $(".userNumber , .recovery , .consignment , .market , .brokerage").hide();
    $(".agentNumber").show();
});

//回收列表
$("#recover").click(function(){
    $(".userNumber , .agentNumber , .consignment , .market , .brokerage").hide();
    $(".recovery").show();
});

//寄售列表
$("#consign").click(function(){
    $(".userNumber , .agentNumber , .recovery , .market , .brokerage").hide();
    $(".consignment").show();
});

//销售列表
$("#sale").click(function(){
    $(".userNumber , .agentNumber , .recovery , .consignment , .brokerage").hide();
    $(".market").show();
});

//佣金列表
$("#commision").click(function(){
    $(".userNumber , .agentNumber , .recovery , .consignment , .market").hide();
    $(".brokerage").show();
});

//佣金结算
$(".count").click(function(){
    $(".shade , .settlement").show();
    //确认
    $(".ensure").click(function(){
        $(".shade , .settlement").hide();
    });
    $(".abolish").click(function(){
        $(".shade , .settlement").hide();
    })
});

//代理数量里的佣金详情
$(".cash").click(function(){
    $(".agentNumber").hide();
    $(".brokerage").show();
    $(".palette.active").removeClass("active");
    $("#commision").addClass("active");
});

//代理数量里的查看详情
$(".look").click(function(){
    $(".agentNumber").hide();
    $(".userNumber").show();
    $(".palette.active").removeClass("active");
    $("#user").addClass("active");
});
*/
