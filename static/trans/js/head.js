function header(){
    var html = '<div class="navigation">'+
                    '<div class="topHalf">'+
                        '<div class="navigation-bar">'+
                            '<a class="logo" href="javascript:;">分公司管理系统</a>'+
                            '<div class="menu">'+
                                '<a id="basic" class="mnav active" href="../../trans/trans">数据概况</a>'+
                                '<a id="detail" class="mnav" href="../../trans/trans">数据详情</a>'+
                                '<a id="proxy" class="mnav" href="../../trans/home/addAgent">设置新代理</a>'+
                                '<a id="set" class="mnav" href="../../trans/login/intercalate">系统设置</a>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="full-top"></div>';

    $(".container").prepend(html);
    $(".mnav").click(function(){
        $(".mnav.active").removeClass("active");
        $(this).addClass("active");
    });
    $("#detail").click(function(){
        $('body,html').animate({scrollTop:0},400);
    })
}
header();

window.onscroll = function () {
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if (t > 0) {
        $(".navigation").addClass("active");
    } else {
        $(".navigation").removeClass("active");
    }
};
