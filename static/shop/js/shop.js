function banner(){
    var  mn = 0;
    var sm = 0;
    $(".dot").click(function(){
        var sm = parseInt($(this).attr("data-id"));
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
        $(".viewport").animate({marginLeft:(-(sm * 100)) + '%'},500);
        mn = sm * 100;
    });
    var timer = setInterval(function(){
        if(mn < 500){
            mn = mn + 100;
            $(".viewport").animate({marginLeft:(-mn + '%')},500,function(){
                $('.dot[data-id=' + mn/100 + ']').addClass("active");
                $('.dot[data-id=' + mn/100 + ']').siblings().removeClass("active");
            });
            if(mn == 500){
                $(".viewport").animate({marginLeft:(-mn + '%')},1,function(){
                    $('.dot[data-id=' + 0 + ']').addClass("active");
                    $('.dot[data-id=' + 0 + ']').siblings().removeClass("active");
                    $(".viewport").css("marginLeft","0");
                });
            }
        }else{
            mn = 0;
            $(".viewport").animate({marginLeft:(-mn + '%')},500,function(){
                $('.dot[data-id=' + mn/100 + ']').addClass("active");
                $('.dot[data-id=' + mn/100 + ']').siblings().removeClass("active");
            });
        }
    },5000);
}
banner();

$(".left").click(function(){
    $(".vessel").animate({marginLeft: -0 + '%'}, 300);
});

$(".right").click(function(){
    $(".vessel").animate({marginLeft: -100 + '%'}, 300);
});

$(".rubric").click(function(){
    $(this).parents(".reveal").find(".rubric.active").removeClass("active");
    $(this).addClass("active");
});

$(".close-btn , .realize").click(function(){
    $(".shadow , .inform").hide();
});


