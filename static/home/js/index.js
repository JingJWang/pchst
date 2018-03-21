/**
 * Created by Administrator on 2016/8/12 0012.
 */
window.onscroll = function () {
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if (t > 0) {
        var isFirst = true;
        $(".navigation").addClass("active");
        $(".roof").css("display","block");

    } else {
        $(".navigation").removeClass("active");
        $(".roof").hide();
    }
};

$(".roof").click(function(){
    $('body,html').animate({scrollTop:0},400);
});

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
        if(mn < 600){
            mn = mn + 100;
            $(".viewport").stop().animate({marginLeft:(-mn + '%')},500,function(){
                $('.dot[data-id=' + mn/100 + ']').addClass("active");
                $('.dot[data-id=' + mn/100 + ']').siblings().removeClass("active");
            });
            if(mn == 600){
                $(".viewport").stop().animate({marginLeft:(-mn + '%')},0,function(){
                    $('.dot[data-id=' + 0 + ']').addClass("active");
                    $('.dot[data-id=' + 0 + ']').siblings().removeClass("active");
                    $(".viewport").css("marginLeft","0");
                });
            }
        }else{
            mn = 0;
            $(".viewport").stop().animate({marginLeft:(-mn + '%')},500,function(){
                $('.dot[data-id=' + mn/100 + ']').addClass("active");
                $('.dot[data-id=' + mn/100 + ']').siblings().removeClass("active");
            });
        }
    },5000);
}
banner();

//切换导航栏
$(".className").click(function(){
    $(".className.active").removeClass("active");
    $(this).addClass("active");
});

function volume(){
    var str = $("#volume").html();
    var html = "";
    for(var i = 0;i < str.length ;i++){
        if( (i + 1) % 3 == 0 ){
            html += '<span class="sum active">' + str[i] + '</span>'
        }else{
            html += '<span class="sum">' + str[i] + '</span>'
        }
    }
    html =  html + '<span class="sum unit">元</span>';
    $("#volume").html('');
    $(".turnover .amount").prepend(html);
}
volume();

function sayest(){
    var str = $("#number").html();
    var html = "";
    for(var i = 0;i < str.length;i++){
        html += '<span class="saith">' + str[i] +'</span>';
    }
    html = html + '<span class="saith unit">单</span>';
    $("#number").html('');
    $(".singular .integer").prepend(html);
}
sayest();

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
$('.imports .entry').keyup(function(e){ 
    var curkey = e.which; 
    if(curkey == 13){ 
        $(".search-rock .search").click(); 
        return false; 
    } 
});

function getMapPoint(address) {
    var maps = {
        '四川': {x: 395, y: 320},
        '北京': {x: 528, y: 182},
        '新疆': {x: 230, y: 172},
        '西藏': {x: 244, y: 305},
        '甘肃': {x: 324, y: 191},
        '青海': {x: 325, y: 247},
        '云南': {x: 371, y: 401},
        '内蒙古': {x: 464, y: 181},
        '湖南': {x: 491, y: 357},
        '江西': {x: 533, y: 360},
        '福建': {x: 566, y: 370},
        '台湾': {x: 603, y: 400},
        '宁夏': {x: 423, y: 235},
        '江苏': {x: 579, y: 286},
        '上海': {x: 609, y: 301},
        '安徽': {x: 550, y: 299},
        '浙江': {x: 585, y: 309},
        '重庆': {x: 443, y: 323},
        '广西': {x: 461, y: 411},
        '贵州': {x: 440, y: 369},
        '广东': {x: 517, y: 407},
        '海南': {x: 471, y: 468},
        '澳门': {x: 499, y: 438},
        '香港': {x: 548, y: 424},
        '黑龙江': {x: 633, y: 85},
        '吉林': {x: 615, y: 123},
        '辽宁': {x: 591, y: 159},
        '天津': {x: 545, y: 199},
        '河北': {x: 520, y: 209},
        '山东': {x: 546, y: 238},
        '山西': {x: 484, y: 231},
        '河南': {x: 507, y: 270},
        '湖北': {x: 495, y: 308}
    };
    return maps[address];
}

function getData() {
    var u = '/index.php/home/brand/comments';
    var d = '';
    var f = function(res){
        var response = eval(res);
        var data = response['com'];
        for(var i = 0; i < data.comments.length; i++) {
            var c = data.comments[i];
            var point = getMapPoint(c.address);
            var isCenter = false;
            var isLeft = false;
            if(parseInt(point.x) > 460){
                isCenter = false;
                isLeft = false;
            }else if(parseInt(point.x) < 386){
                isLeft = true;
                isCenter = false;
            }else{
                isCenter = true;
                isLeft = false;
            }
            var cell = '<div class="wholly" style="left: ' + point.x + 'px;top: ' + point.y + 'px">' +
                '<img src="' + c.face + '">' +
                '<div class="comment' + (isCenter ? ' center' : '') + '' + (isLeft ? ' left' : '') + '">' +
                '<div class="label">' + c.comment + '</div>' +
                '<div class="tail"></div>' +
                '</div>' +
                '</div>';
            (function (mCell, index) {
                setTimeout(function () {
                    $('.atlas').append(mCell);
                }, 400 * index - (index * 10));
            })(cell, i);
        }
        var datas = response['info'];
        var html = "";
        for(var i = 0; i < datas.news.length; i++){
            var sn = datas.news[i];
            if (parseInt(sn.content.length) > 46){
                sn.content = sn.content.substring(0,46) + '...';
            }
            html += '<div class="press">'+
                        '<a target="_blank" href="/index.php/notice/artical/'+sn.id+'"><div class="headline">'+ sn.title +'</div>'+
                        '<div class="covers">'+
                            '<p class="words">' + sn.content +'</p>'+
                        '</div></a>'+
                    '</div>'
        }
        $(".substance").html(html);
    }
    AjaxRequest(u,d,f);
    
}

getData();

function dataInform(){
    var datas = {
        news :[
            {title:'回收通高价、安全回收您的闲置手机数码产品',content:'2016年用户更换手机周期已经从18个月缩短到了15个月，有20%的用户一年之内就会换手机有20%的用户一年之内就会换手机'},
            {title:'回收通高价、安全回收您的闲置手机数码产品',content:'2016年用户更换手机周期已经从18个月缩短到了15个月，有20%的用户一年之内就会换手机...'},
            {title:'回收通高价、安全回收您的闲置手机数码产品',content:'2016年用户更换手机周期已经从18个月缩短到了15个月，有20%的用户一年之内就会换手机...'},
            {title:'回收通高价、安全回收您的闲置手机数码产品',content:'2016年用户更换手机周期已经从18个月缩短到了15个月，有20%的用户一年之内就会换手机...'}
        ]

    };
    var html = "";
    for(var i = 0; i < datas.news.length; i++){
        var sn = datas.news[i];
        if (parseInt(sn.content.length) > 46){
            //截取显示内容的长度
            sn.content = sn.content.substring(0,46) + '...';
        }
        html += '<div class="press">'+
                    '<div class="headline">'+ sn.title +'</div>'+
                    '<div class="covers">'+
                        '<p class="words">' + sn.content +'</p>'+
                        '<input class="more" type="button" value="更多"/>'+
                    '</div>'+
                '</div>'
    }
    $(".substance").html(html);

}

$(".abilities.phone-deal").hover(function(){
    $(".abilities.phone-deal .horn").show();
    $(".abilities.phone-deal .attention").show();
},function(){
    $(".abilities.phone-deal .horn").hide();
    $(".abilities.phone-deal .attention").hide();
});

//联系客服
$(".abilities.customService").hover(function(){
    $(".abilities.customService .horn").show();
    $(".abilities.customService .contactWay").show();
},function(){
    $(".abilities.customService .horn").hide();
    $(".abilities.customService .contactWay").hide();
});

//选中品牌
$(".classification.names").click(function(){
    $(".classification.names.active").removeClass("active");
    $(this).addClass("active");
});



function play(){
    setInterval(function(){
        var a = parseInt($(".content").css("margin-left"));
        if(a == -1350){
            $(".content").css({"margin-left": (0) + 'px'});
        }else{
            $(".content").animate({"margin-left": (a - 150) + 'px'} );
        }

    },2000)
}
play();

$(".close-btn").click(function(){
    $(".shadow , .inform").hide();
});