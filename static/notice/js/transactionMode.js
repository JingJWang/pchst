/**
 * Created by Administrator on 2016/8/29 0029.
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

//切换选项
$(".palette").click(function(){
    $(".palette.active").removeClass("active");
    $(this).addClass("active");
});

$(".mode").click(function(){
    $(".mode.active").removeClass("active");
    $(this).addClass("active");
});

$(".several").click(function(){
    $(".several.active").removeClass("active");
    $(this).addClass("active");
});