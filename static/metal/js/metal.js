var Matel={		
		purity:function(id,obj){
			$(".classify.active").removeClass("active");
			$(obj).addClass("active");
			$('#purity .choice').css('display','none');
			$('#metal_'+id).css('display','block');	
			
			Matel.price(0);
		},
		price:function(type){
			var mold=$('.category').find('.active').attr('metal-id');
			var price=$('#matelprice_'+mold).html();
			var weight=$('#weight').val();
			if(Number(weight) < 0 ){
				weight=0;
			}			
			var deal='';
			if(type > 0 ){
				weight=Number(weight)+1;
				$('#weight').val(weight);
				$('.units').html(weight/1000+'kg');
				deal=price*weight;
			}
			if(type < 0 ){
				weight=Number(weight)-1;
				$('#weight').val(weight);
				$('.units').html(weight/1000+'kg');
				deal=price*weight;
			}
			if(type == 0){
				$('#weight').val(weight);
				$('.units').html(weight/1000+'kg');
				deal=price*weight;
			}
			$('.money').html('&yen'+deal.toFixed(2));
			$('.price').html('&yen'+deal.toFixed(2));
		}
};
var submitMetal=function(res){
		if(request_fall == res['status']){
			Message.display('提示信息',res['msg']);
		}	
}
var Request={
		submit:function(){
			User.login();			
			var type=$('.category').find('.active').attr('metal-id');
			var purity=$('#purity').find('.active').attr('purity-id');
			var classify=$('#classify').find('.active').attr('classify-id');
			var grams=$("#weight").val();
			var dealtype=$('.trade').find('.active').attr('dealtype-id');
			var url='/index.php/metal/metal/submit';
			var data='type='+type+'&purity='+purity+'&classify='+classify+'&grams='+grams+'&dealtype='+dealtype;
			AjaxRequest(url,data,submitMetal);
		}
}


