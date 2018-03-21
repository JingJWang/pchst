var  request=function(u,d,f){
	var result= '';
	$.ajax({
        url:u,
        type:"POST",
        dataType:"json",
        data:d,
        beforeSend: function(){
       	 	
        },
        success:function(res){
        	  f(res);
        },
        complete: function(){
       	},
        error:function(){
          
        }
    });
	
}
function load(sum){
	var name='';
	var response='';	
	var u='/index.php/center/login/getmodel';
	var d='';
	var f=function(res){
		response=eval(res);
		name = response['data']['name'];
		var topNavTag = $('<nav class="navTop">'+
				'<div class="navCon clearfix">'+
				'<h1 class="fl"><a href="javascript:;"></a></h1>'+
				'<a href="javascript:;" class="getOut fr" onclick="dropout();">退出</a>'+
				'<div class="mySelect fr">'+
				'<a href="javascript:;" class="selected">'+name+'</a>'+
				'<ul class="msUl"><li><a href="javascript:;"></a>'+
				'</li><li><a href="javascript:;"></a></li><li>'+
				'<a href="javascript:;"></a>'+
				'</li><li><a href="javascript:;"></a></li>'+
				'</ul></div></div></nav>');		
		$('.navRuler').before(topNavTag);	
		//左侧导航代码块
		var nav='';
		$.each(response['data']['permit'],function(key,val){
			var temp='';
			$.each(val['permit'],function(k,v){
				temp = temp + '<li><a href="'+v['url']+'">'+v['name']+'</a></li>';
			});			
			nav = nav + '<div class="divJs '+val['class']+'">' +
				'<div class="navTitle clearfix"><span class="pull-left product">'+
				'</span><h3 class="pull-left">'+val['name']+'</h3></div>' +
				'<ul>'+temp+'</ul></div>';					
		});
		var leftNavTag = '<div class="leftNav">'+nav+'</div>';
		$('.navRuler').prepend(leftNavTag);
		decide(sum);
	}	
	request(u,d,f);	
}

function decide(sum){
	if(sum == 1){
		$(".productManage").addClass("whiteBg");
		$('.productManage ul li').eq(0).addClass('borderLeft');
	}else if(sum == 2){
		$(".productManage").addClass("whiteBg");
		$('.productManage ul li').eq(1).addClass('borderLeft');
	}else if(sum == 3){
		$(".productManage").addClass("whiteBg");
		$('.productManage ul li').eq(2).addClass('borderLeft');
	}else if(sum == 4){
		$(".userMag").addClass("whiteBg");
		$('.userMag ul li').eq(0).addClass('borderLeft');
	}else if(sum == 5){
		$(".luxuryManage").addClass("whiteBg");
		$('.luxuryManage ul li').eq(0).addClass('borderLeft');
	}else if(sum == 6){
		$(".luxuryManage").addClass("whiteBg");
		$('.luxuryManage ul li').eq(1).addClass('borderLeft');
	}else if(sum == 7){
		$(".luxuryManage").addClass("whiteBg");
		$('.luxuryManage ul li').eq(2).addClass('borderLeft');
	}else if(sum == 8){
		$(".systemMag ").addClass("whiteBg");
		$('.systemMag  ul li').eq(0).addClass('borderLeft');
	}else if(sum == 9){
		$(".systemData").addClass("whiteBg");
		$('.systemData ul li').eq(0).addClass('borderLeft');
	}else if(sum == 10){
		$(".systemData").addClass("whiteBg");
		$('.systemData ul li').eq(1).addClass('borderLeft');
	}else if(sum == 11){
		$(".systemData").addClass("whiteBg");
		$('.systemData ul li').eq(2).addClass('borderLeft');
	}else if(sum == 12){
		$(".systemData").addClass("whiteBg");
		$('.systemData ul li').eq(3).addClass('borderLeft');
	}else if(sum == 13){
		$(".systemData").addClass("whiteBg");
		$('.systemData ul li').eq(4).addClass('borderLeft');
	}else if(sum == 14){
		$(".preferential").addClass("whiteBg");
		$('.preferential ul li').eq(4).addClass('borderLeft');
	}
}

$(function(){
//===  自定义下拉菜单  ===
	//点击让ul显示
	$('.selected').click(function(e) {
		$(this).next().show();
    });
	$('.mySelect .msUl a').click(function(e) {
		$(this).closest('.msUl').hide();
    });
	$('.mySelect').mouseleave(function(e) {
        $(this).children('.msUl').hide();
    });
    //获取浏览器页面的高度
	var winheight = $(window).height();
	$("#contentBox,.dataCon").height(winheight - 56);
	$("#phoneCon").height(winheight - 56 -15);
	//每日数据页面
	$(".dataConBot").height(winheight - 120);
	//$("#phoneCon .pDetails .brand .brandList").height(winheight - 265);
	$("#phoneCon .pDetails .model .modelList").height(winheight - 265);
	$("#phoneCon .rightscroll").height(winheight - 265); //手机管理界面 信息属性
	$('.properScroll').each(function(){
		$(this).height(winheight - $(this).offset().top); //报价管理界面  信息属性
	});

	$('.conHeight').height(winheight - 300);
	$('#userScroll').height(winheight - 320);

	$(window).resize(function() {
		var winheight = $(window).height();
		$("#contentBox,.dataCon").height(winheight - 56);
		$("#phoneCon").height(winheight - 56 -15);
		//每日数据页面
		$(".dataConBot").height(winheight - 120);
		//$("#phoneCon .pDetails .brandList").height(winheight - 265);
		$("#phoneCon .pDetails .model .modelList").height(winheight - 265);
		$("#phoneCon .rightscroll").height(winheight - 265); //手机管理界面 信息属性
		$('.properScroll').each(function(){
			$(this).height(winheight - $(this).offset().top); //报价管理界面  信息属性
		});
		$('.conHeight').height(winheight - 300);
		$('#userScroll').height(winheight - 320);
	});
});
var flag=true;
//移除品牌列表的点击事件
function clickNone(){
	 flag=false;
}
function clickYes(){
	 flag=true;
}
function page(one_pag,now,num,status){
    var page = Math.ceil(num/one_pag);//可以分的页数
    var pages = '';
    if (num<=one_pag) {
        return ;
    }
    if (now>=one_pag) {//此处加上首页
        pages += '<a class="page sight" onclick="addtext(0,'+status+')" href="javascript:;">首页</a><a class="page last" onclick="addtext('+(now/one_pag-1)+','+status+')" href="javascript:;">&nbsp</a>';
    }
    if (page<=5) {
        for (var i = 0; i < page; i++) {
            pages += '<a class="page" id="'+(i*one_pag)+'" onclick="addtext('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
        };
    }else{
        if ((now/one_pag)<3) {
            for (var i = 0; i <= 5; i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" onclick="addtext('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }else if (now/one_pag>=(page-3)) {
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (page-5); i <= page-1; i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" onclick="addtext('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
            };
        }else{//加首页
            pages += '<a class="page" href="javascript:;">...</a>';
            for (var i = (now/one_pag-2); i < (now/one_pag+3); i++) {
                pages += '<a class="page" id="'+(i*one_pag)+'" onclick="addtext('+(i)+','+status+')" href="javascript:;">'+(i+1)+'</a>';
            };
            pages += '<a class="page" href="javascript:;">...</a>';
        }
    }
    if (now<(page-1)*one_pag) {//加尾页
        pages += '<a class="page next" onclick="addtext('+(now/one_pag+1)+','+status+')" href="javascript:;">&nbsp</a><a class="page sight" onclick="addtext('+(page-1)+','+status+')" href="javascript:;">末页</a>';
    };
    $('.pagination').html(pages);
    $('#'+now+'').addClass('active');
}
