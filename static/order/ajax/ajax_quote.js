Screening();
/**
 * 获取选择的条件
 */
function Getoption(option){
		var order=$("#"+option).val();
		if(order == 1){
			$("#"+option).val('0');
		}else{
			$("#"+option).val('1');
		}
		switch (option) {
			case 'price':
				$("#distance").val('0');
				$("#evaluation").val('0');
				$("#transaction").val('0');
				break;
			case 'distance':
				$("#price").val('0');
				$("#evaluation").val('0');
				$("#transaction").val('0');
				break;
			case 'evaluation':
				$("#price").val('0');
				$("#distance").val('0');
				$("#transaction").val('0');
				break;
			case 'transaction':
				$("#price").val('0');
				$("#evaluation").val('0');
				$("#evaluation").val('0');
				break;
		}
		Screening();
}
/**
 * 获取选定的属性
 */
function Option(attr){
	var option = $("#option").val();
	if(option == 0){
		 $("#option").val(attr);
	}
	if(option != 0){
		$("#option").val(attr);
	}
	if(option == attr){
		$("#option").val('0');
	}
	Screening();
}
/**
 * 认证相关
 */
function Auto(){
	var auto=$("#auto").val();
	if(auto == 1){
		$("#auto").val('0');
	}else{
		$("#auto").val('1');
	}
	Screening();
}
/**
 *根据条件获取相关的报价信息
 */
function  Screening(){
	var option = '';
	var baseinfo = $('.reorder .baseinfo .active').attr('data');
	var howrecytl = $('.reorder .howrecytl .active').attr('data');
	var recytlsure = $('.reorder .recytlsure .active').attr('data');
	//价格
	switch(baseinfo){
		case '1':
		    option= option + 'price=1';
		    break;
		case '2':
    		option= option + '&distance=1';
		    break;
		case '3':
    		option= option + '&evaluation=1';
		    break;
		case '4':
    		option= option + '&transaction=1';
		    break;
	}
	if (howrecytl!=1) {
		option= option + '&option='+howrecytl;
	}else{
		option= option + '&option=0';
	}
	switch(recytlsure){
		case '0':
		    option= option + '&auto=0';
		    break;
		case '1':
		    option= option + '&auto=1';
		    break;
		case '2':
		    option= option + '&auto=2';
		    break;
	}
	var u = "/index.php/order/quote/GetScreening";
	var d = option;
	var f = function(res){
		response=eval(res);
		if (response['status'] == 1000) {
			var list = '';
			var consign ='';
			var content='';
			var coop='';
			var cooptitle = '';
			var distance = '';
			$('.huisnum').html(response['data'].length);
			$.each(response['data'],function(n,data){
				if(data['ctype'] == 1){
					coop='<div class="consign"></div>';
				    coopinfo='<div class="information">我们帮您卖，此价为参考价，想卖多少您说了算</div>';
				    cooptitle='点此寄售';
			    }else{
					coop='';
					coopinfo='';
					cooptitle='卖给他';
				}
				var temp='';
				$.each(data['service'],function(k,i){
				    temp = temp + '<li>'+i+'</li>';
				});
				if (data['distance']!=0) {
					distance = '<div class="distance">'
                                +'<span>'+data['distance']/1000+'km</span>'
                            +'</div>';
				}
				list = '<div class="policy">'
                        +'<div class="information">'
                            +'<div class="explicit">'
                                +'<div class="articles">'+data['cname']+'</div>'
                                +'<div class="probate">'
                                    +data['cauth']+'<div class="expand">'
                                        +'<div class="tips-out-border">'
                                            +'<div class="tips-out-bg"></div>'
                                            +'<div class="tips-out"></div>'
                                        +'</div>'
                                        +'<div class="contain">'
                                            +'<div class="name">'+data['cname']+'</div>'
                                            +'<div class="patent">'+data['cauth']+'</div>'
                                            +'<div style="width:100%;height:2px;margin-bottom: 7px;">'
                                                +'<div class="seize"></div>'
                                            +'</div>'
                                            +'<div class="asses">'
                                                +'<span>评价</span>'
                                                +'<span>'+data['cclass']+'</span>'
                                                +'<span>分</span>'
                                            +'</div>'
                                            +'<div class="asses">'
                                                +'<span>成交</span>'
                                                +'<span>'+data['csum']+'</span>'
                                                +'<span>单</span>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>'
                                +'<div class="deploy"></div>'
                            +'</div>'
                            +distance+coop
                        +'</div>'
                        +'<div class="price">￥'+data['price']+'</div>'
                        +'<div class="group">'+temp+'</div>'
                        +'<div class="press">'
                            +'<div class="embody">'
                                +'<a class="fastener" href="/index.php/order/quote/address?fid='+data['offerid']+'&oid='
                                +data['orderid']+'">'+cooptitle+'</a>'
                            +'</div>'
                        +'</div>'
                    +'</div>';
				if(data['ctype'] == 1){
				    consign=list;
				}else{						   
				    content = content +list;
				}
     		});
            $('.further .subset').html(consign+content);
		}else{
            $('.further .subset').html('');
			$(".bidNone").css('display','block');
			$('.await').css('display', 'block');
		}
	}
	AjaxRequest(u,d,f);
}
function RefreshQuote(){
	window.location.reload()
}