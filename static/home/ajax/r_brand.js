var host = window.location.host;
$('.group').on('click', function() {
	var did = $(this).attr('data-id');
	$(this).addClass('active');
	$(this).siblings('.group').removeClass('active');
	var u = '/index.php/home/brand/getorder';
	var d = 'type='+did;
	var f = function(res){
		var response = eval(res);
		var list = shopL = img = '';
		if (response['status'] == request_succ) {
			$.each(response['data']['brand'], function(i, v) {
				list += '<a class="classification names" data-id='+v['id']+' href="javascript:;">'
                            +'<div class="graph">'
                                +'<img src="'+v['img']+'"/>'
                            +'</div>'
                            +'<div class="plate">'+v['name']+'</div>'
							+'<div class="line"></div>'
                        +'</a>';
			});
			list+=' <a class="classification" target="_blank" href="http://'+host+'/recover/'+response['data']['where']+'"">'
                        +'<div class="graph">'
                            +'<div class="tier">'
                                +'<div class="ong first"></div>'
                                +'<div class="ong"></div>'
                                +'<div class="ong"></div>'
                            +'</div>'
                        +'</div>'
                        +'<div class="plate">全部品牌</div>'
                    +'</a>';
            $('.inquired').html(list);
            var retprice = '';
			$.each(response['data']['shops'], function(i, v) {
				retprice = v['mprice']<=0?'':'<span>回收价 :</span><span class="money">￥'+v['mprice']+'</span>';
				img = (v['img']==''?'/static/recover/images/bdefault.png':v['img']);
				shopL += '<a class="singleton" target="_blank"  href="http://'+host+'/order/digital/option?id='+v['id']+'">'
                            +'<div class="print">'
                                +'<img src="'+img+'">'
                            +'</div>'
                            +'<div class="design">'+v['name']+'</div>'
                            +'<div class="explicit">'+retprice
                            +'</div>'
                        +'</a>';
			});
            $('.tabulation').html(shopL);
			//选中品牌
			$(".classification.names").click(function(){
				$(".classification.names.active").removeClass("active");
				$(this).addClass("active");
			});

		}
	}
	AjaxRequest(u,d,f);
});
$(document).on('click','.inquired .classification', function(event) {
	var bid = $(this).attr('data-id');
	var u = '/index.php/home/brand/getshops';
	var d = 'bid='+bid;
	var f = function(res){
		var response = eval(res);
        var retprice = '';
		var shopL = img ='';
		if (response['status'] == request_succ) {
			$.each(response['data'], function(i, v) {
				retprice = v['mprice']<=0?'':'<span>回收价 :</span><span class="money"> ￥'+v['mprice']+'</span>';
				img = (v['img']==''?'/static/recover/images/bdefault.png':v['img']);
				shopL += '<a class="singleton" target="_blank" href="http://'+host+'/order/digital/option?id='+v['id']+'">'
                            +'<div class="print">'
                                +'<img src="'+img+'">'
                            +'</div>'
                            +'<div class="design">'+v['name']+'</div>'
                            +'<div class="explicit">'+retprice
                            +'</div>'
                        +'</a>';
			});
            $('.tabulation').html(shopL);
		}
	}
	AjaxRequest(u,d,f);
});
$('.search-rock .search').on('click', function() {
	var text = $('.imports .entry').val();
	if (text=='') {
		return ;
	};
	var type = $('.search-rock .total').attr('data');
	if (type=='mobile') {
		type='/mobile';
	}else if(type=='flat'){
		type='/flat';
	}else{
		alert('请选择类型');
		return ;
	}
	var url = '/index.php/recover/search/'+text+type;
	location.href = url;
});