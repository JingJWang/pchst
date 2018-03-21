//显示全部分类
$('.general').hover(function () {
    $(".classList").show();
}, function () {
    $(".classList").hide();
});

//切换选项
$(".choices").click(function(){
    $(this).parents(".palette").find(".choices.active").removeClass("active");
    $(this).addClass("active");
});

//选择更多
$(".palette .more").click(function(){
    var sn = parseInt($(this).parents(".palette").find(".group").height());
    if(sn == 38 ){
        $(this).addClass("active");
        $(this).parents(".palette").find(".group").css("height" , "auto");
    }else{
        $(this).removeClass("active");
        $(this).parents(".palette").find(".group").css("height" , "38px");
    }
});

//选择排序方式
$(".mode").click(function(){
    $(".mode.active").removeClass("active");
    $(this).addClass("active");
});

//切换页码
$(".page").click(function(){
    $(".page.active").removeClass("active");
    $(this).addClass("active");
});
var paid = $(".pagination").attr('paid');
var npage = parseInt($(".pagination").attr('npage'));
var sort = $(".pagination").attr('sort');
var text = $(".pagination").attr('text');
$('.search-text').val(text);
var Asnum = $(".sum").html();
var AurlStr1 = '/index.php/shops/shopinfo/searchshop/'+text+'/'+sort+'/';

page(24,(npage-1)*24,Asnum);
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
        pages += '<a class="page sight" href="'+AurlStr1+'1">首页</a><a class="page last" href="'+AurlStr1+(npage)+'">&nbsp</a>';
    }
    if (page<=5) {
        for (var i = 0; i < page; i++) {
            pages += '<a class="page" id="'+(i*one_pag)+'" href="'+AurlStr1+(i+1)+'">'+(i+1)+'</a>';
        };
    }else{
        if ((now/one_pag)<3) {
            for (var i = 0; i <= 5; i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" href="'+AurlStr1+(i+1)+'">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }else if (now/one_pag>=(page-3)) {
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (page-5); i <= page-1; i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" href="'+AurlStr1+(i+1)+'">'+(i+1)+'</a>';
            };
        }else{//加首页
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (now/one_pag-2); i < (now/one_pag+3); i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" href="'+AurlStr1+(i+1)+'">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }
    }
    if (now<(page-1)*one_pag) {//加尾页
        pages += '<a class="page next" href="'+AurlStr1+(npage+1)+'">&nbsp</a><a class="page sight" href="'+AurlStr1+(page)+'">末页</a>';
    };
    $('.pagination').html(pages);
    $('#'+now+'').addClass('active');
}