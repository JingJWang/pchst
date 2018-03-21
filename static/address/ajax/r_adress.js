$(document).on('click', '.revise .conserve', function(event) {

    var name = $(".revise").find(".name").val();
    var pri = $("#hcity").val();
    var city = $("#hproper").val();
    var area = $("#harea").val();
    var nm = $(".revise").find(".addr").val();
    var phone = $(".revise").find(".tel").val();
    if($(".revise .install").hasClass("active")){
    	var ismo = 2;
    }else{
    	var ismo = 1;
    }
    if (name==undefined||name=='') {
    	alert('名字不能为空');
    	return ;
    };
    if (pri==undefined||pri=='') {
    	alert('省份不能为空');
    	return ;
    };
    if (city==undefined||city=='') {
    	alert('城市不能为空');
    	return ;
    };
    if (area==undefined||area=='') {
    	alert('地区不能为空');
    	return ;
    };
    if (nm==undefined||nm=='') {
    	alert('详细地址不能为空');
    	return ;
    };
    if (phone==undefined||phone=='') {
    	alert('手机号码不能为空');
    	return ;
    };
    var arid = $(".revise").find(".message").attr('adres-id');
	var u = '/index.php/address/upaddress';
	var d = 'name='+name+'&phone='+phone+'&province='+pri+'&city='+city+'&area='
	        +area+'&adr_detail='+nm+'&default='+ismo+'&adressid='+arid;
	var f = function(res){
		var response = eval(res);
		if (response['status'] == request_succ) {
            $(".notices .tooltip").html(response['msg']);
            $(this).parents(".road").addClass("active");
            $(this).parents(".road").siblings(".road.active").removeClass("active");
            $(".shadow").css("display","block");
            $(".notices").css("display","block");
            afterupadres();
		}else{
            $(".notices .tooltip").html(response['msg']);
            $(this).parents(".road").addClass("active");
            $(this).parents(".road").siblings(".road.active").removeClass("active");
            $(".shadow").css("display","block");
            $(".notices").css("display","block");
		}
	}
	AjaxRequest(u,d,f);
});

$(document).on('click', '.addition .conserve', function(event) {
	var name = $(".addition").find(".name").val();
    var pri = $("#hcity").val();
    var city = $("#hproper").val();
    var area = $("#harea").val();
    var nm = $(".addition").find(".addr").val();
    var phone = $(".addition").find(".tel").val();
    if($(".addition .install").hasClass("active")){
    	var ismo = 2;
    }else{
    	var ismo = 1;
    }
    if($(".addition .install").hasClass("active")){
    	var ismo = 2;
    }else{
    	var ismo = 1;
    }
    if (name==undefined||name=='') {
    	alert('名字不能为空');
    	return ;
    };
    if (pri==undefined||pri=='') {
    	alert('省份不能为空');
    	return ;
    };
    if (city==undefined||city=='') {
    	alert('城市不能为空');
    	return ;
    };
    if (area==undefined||area=='') {
    	alert('地区不能为空');
    	return ;
    };
    if (nm==undefined||nm=='') {
    	alert('详细地址不能为空');
    	return ;
    };
    if (phone==undefined||phone=='') {
    	alert('手机号码不能为空');
    	return ;
    };
	var u = '/index.php/address/addaddress';
	var d = 'name='+name+'&phone='+phone+'&province='+pri+'&city='+city+'&area='
	        +area+'&adr_detail='+nm+'&default='+ismo;
	var f = function(res){
		var response = eval(res);
		if (response['status'] == request_succ) {
			location.reload();
            // $(".notices .tooltip").html(response['msg']);
            // $(this).parents(".road").addClass("active");
            // $(this).parents(".road").siblings(".road.active").removeClass("active");
            // $(".shadow").css("display","block");
            // $(".notices").css("display","block");
		}else{
            $(".notices .tooltip").html(response['msg']);
            $(this).parents(".road").addClass("active");
            $(this).parents(".road").siblings(".road.active").removeClass("active");
            $(".shadow").css("display","block");
            $(".notices").css("display","block");
		}
	}
	AjaxRequest(u,d,f);
});
$(document).on('click', '.suredel', function(event) {
	var id = $('.road.active').attr('adres-id');
	if (isNaN(id)) {
		return;
	}
	var u = '/index.php/address/deladress';
	var d = 'adressid='+id;
	var f = function(res){
		var response = eval(res);
		if (response['status'] == request_succ) {
            $(".notices .tooltip").html(response['msg']);
            $(this).parents(".road").addClass("active");
            $(this).parents(".road").siblings(".road.active").removeClass("active");
            $(".shadow").css("display","block");
            $(".notices").css("display","block");
            // $(".shadow").css("display","none");
            $(".delinfo").css("display","none");
            $(".road.active").css("display","none");
            $(".road.active").removeClass("active");
		}else{
            $(".delinfo .tooltip").html(response['msg']);
            $(this).parents(".road").addClass("active");
            $(this).parents(".road").siblings(".road.active").removeClass("active");
            $(".shadow").css("display","block");
            $(".delinfo").css("display","block");
		}
	}
	AjaxRequest(u,d,f);	
});
// function delect(id){

// }