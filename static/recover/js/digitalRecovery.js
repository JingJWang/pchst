/**
 * Created by Administrator on 2016/8/19 0019.
 */
window.onscroll = function () {
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if (t > 0) {
        $(".navigation").addClass("active");
    } else {
        $(".navigation").removeClass("active");
    }
};

$(".className").click(function(){
    $(".className.active").removeClass("active");
    $(this).addClass("active");
});

$(".total").click(function(){
    if($(".categorize").css("display") == "none"){
        $(".categorize").css("display","block");
    }else{
        $(".categorize").css("display","none");
    }
});

$(".sort-name").click(function(){
    $(".categorize").css("display","none");
    $(".total").html($(this).html());
    $(".total").attr('data',$(this).attr('data'));
    $(this).siblings(".sort-name.active").removeClass("active");
    $(this).addClass("active");
});
// $('.imports .entry').keyup(function(e){ 
//     var curkey = e.which; 
//     if(curkey == 13){ 
//         $(".search-rock .search").click(); 
//         return false; 
//     } 
// });

$(".classes").click(function(){
    $(this).siblings(".classes.active").removeClass("active");
    $(this).addClass("active");
});

$(".restrain").click(function(){
    $(".restrain.active").removeClass("active");
    $(this).addClass("active");
});

$(document).on('click', '.page', function(event) {
    $(".page.active").removeClass("active");
    $(this).addClass("active");
    /* Act on the event */
});

$(".more-brands").click(function(){
    if(parseInt($(".rebrand").css("height")) == "159"){
        $(".rebrand").css("height","auto");
        $(".more-brands .words").addClass("active");
    }else{
        $(".rebrand").css("height","159px");
        $(".more-brands .words").removeClass("active");
    }
});

$(".patch").click(function(){
    $(".patch.active").removeClass("active");
    $(this).addClass("active");
})

function hot(){
    var data = {
        hits:[
            {name:'苹果iPhone 5S'},
            {name:'苹果iPhone 6'},
            {name:'小米3'},
            {name:'三星 GALAXY 3'},
            {name:'三星GALAXY S7 Edge'},
            {name:'华为 荣耀6'},
            {name:'红米Note'},
            {name:'小米3'},
            {name:'苹果iPhone 5S'},
            {name:'苹果iPhone 6'},
            {name:'小米3'},
            {name:'三星 GALAXY 3'},
            {name:'三星GALAXY S7 Edge'},
            {name:'华为 荣耀6'},
            {name:'红米Note'},
            {name:'小米3'}
        ]
    };
    var html = "";
    isActive = false;
    for(var i = 0; i < data.hits.length; i++){
        //默认将第一个设为选中
        if( i == 0 ){
            isActive = true;
        }
        var hit = data.hits[i];
        html += '<a class="phone-name" href="javascript:;">'+
                    '<span class="' + (isActive ? ' active' : '') + '">' + hit.name +'</span>'+
                '</a>';
        isActive = false;
    }
    $(".hotlist").html(html);
}
$(".hotlist .phone-name").click(function(){
    $("span.active").removeClass("active");
    $(this).find("span").addClass("active");
});
//点击更多
$(".more").click(function(){
    if(parseInt($(".hotlist").css("height")) == "84"){
        $(".hotlist").css("height","auto");
        $(".more span").addClass("active");
    }else{
        $(".hotlist").css("height","84px");
        $(".more span").removeClass("active");
    }
})
// hot();
// $('.search-rock .search').on('click', function() {
//     var text = $('.imports .entry').val();
//     if (text=='') {
//         return ;
//     };
//     var type = $('.search-rock .total').attr('data');
//     if (type=='shouji') {
//         type='/shouji';
//     }else if(type=='pingban'){
//         type='/pingban';
//     }else{
//         alert('请选择类型');
//         return ;
//     }
//     var url = '/index.php/recover/search/'+text+type;
//     location.href = url;
// });
var Asnum = $('.river .sum').html();
var Apage = parseInt($('.exhibition').attr('pnum'));
var AurlStr = $('.exhibition').attr('purl');
page(24,Apage*24,Asnum);
/**
 * @param      int       one_pag  一页总共的页数
 * @param      int       now      当前开始数字
 * @param      int       num      总共的页数
 * @param      int       status   根据需求添加的函数 
 **/
function page(one_pag,now,num){
    var page = Math.ceil(num/one_pag);//可以分的页数
    var pages = '';
    if (num<=one_pag) {
        return ;
    }
    if (now>=one_pag) {//此处加上首页
        pages += '<a class="page sight" href="'+AurlStr+'0">首页</a><a class="page last" href="'+AurlStr+(Apage-1)+'">&nbsp</a>';
    }
    if (page<=5) {
        for (var i = 0; i < page; i++) {
            pages += '<a class="page" id="'+(i*one_pag)+'" href="'+AurlStr+i+'">'+(i+1)+'</a>';
        };
    }else{
        if ((now/one_pag)<3) {
            for (var i = 0; i <= 5; i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" href="'+AurlStr+i+'">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }else if (now/one_pag>=(page-3)) {
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (page-5); i <= page-1; i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" href="'+AurlStr+i+'">'+(i+1)+'</a>';
            };
        }else{//加首页
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (now/one_pag-2); i < (now/one_pag+3); i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" href="'+AurlStr+i+'">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }
    }
    if (now<(page-1)*one_pag) {//加尾页
        pages += '<a class="page next" href="'+AurlStr+(Apage+1)+'">&nbsp</a><a class="page sight" href="'+AurlStr+(page-1)+'">末页</a>';
    };
    $('.pagination').html(pages);
    $('#'+now+'').addClass('active');
}