/**
 * 
 */
online();
function upimg() {
	$("#code").val('');
	$("#code_img").attr('src','/code/img.php?name=2&d='+Math.random());
}
function upcode(){
	$("#code_val").val('');
	$("#code_check").attr('src','/code/img.php?name=2&d='+Math.random());
}
function login(){
	$("#loginmsg").html('');
	var code=$("#code").val();	
	if( code == '' || code.length != 4){
		$("#loginmsg").html('请正确输入随机验证码!');
		return false;
	}
	var name=$("#name").val();
	if(isNaN(name) != false || name.length != 11){
		$("#loginmsg").html('请正确输入账号信息!');
		return false;
	}
	var pwd=$("#pwd").val();
	if(typeof(pwd) == 'undefined' || pwd == ''){
		$("#loginmsg").html('请正确填写密码!');
		return false;
	}
	var  u='/index.php/user/isLogin';
	var  d='name='+name+'&pwd='+pwd+'&code='+code;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){
			var returnUrl = getUrlParam('returnUrl');
			if (returnUrl!=''&&returnUrl!=null) {
				UrlGoto(returnUrl);
				return;
			};
			if(typeof(response['url']) !='undefined' && response['url'] !=''){
				UrlGoto(response['url']);
			}
		}
		if(request_fall == response['status']){
			 upimg();
			$("#login_code").css('display','block');
			$(".seat").css("display","none");
			$("#loginmsg").html(response['msg']);
		}
	};
	AjaxRequest(u,d,f);
}
function mobileLogin(){
	$("#login_error").html('');
	var code=$("#code_val").val();
	if(code == '' || code.length != 4){
		$("#login_error").html('请正确输入登录手机号码!');
		return false;
	}
	var mobile=$("#mobile").val();
	if(isNaN(mobile) != false || mobile.length != 11){
		$("#login_error").html('请正确输入登录手机号码!');
		return false;
	}
	var verify=$("#verify").val();
	if(isNaN(verify) != false || verify.length != 6){
		$("#login_error").html('请正确输入短信验证码!');
		return false;
	}
	var  u='/index.php/user/mobileLogin';
	var  d='mobile='+mobile+'&verify='+verify+'&code='+code;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){			
			var returnUrl = getUrlParam('returnUrl');
			if (returnUrl!=''&&returnUrl!=null) {
				UrlGoto(returnUrl);
				return;
			};
		}
		if(request_fall == response['status']){
			if(response['data']['code'] == 1){
				upimg();
				$("#login_code").css('display','block');
				$("#loginmsg").html(response['msg']);
			}
		}
	}
	AjaxRequest(u,d,f);
	
}
function sendCode(obj){
	$("#login_error").html('');
	var code=$("#code_val").val();
	if(code == '' || code.length != 4){
		$("#login_error").html('请正确输入随机验证码!');
		return false;
	}
	var mobile=$("#mobile").val();
	if(isNaN(mobile) != false || mobile.length != 11){
		$("#login_error").html('请正确输入手机号码!');
		return false;
	}
	var  u='/index.php/user/sendVerify';
	var  d='code='+code+'&mobile='+mobile;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){
			$(obj).val('已发送');
			upcode();
		}
		if(request_fall == response['status']){
			$("#login_error").html('');
			$("#login_error").html(response['msg']);
		}
	}
	AjaxRequest(u,d,f);
}

function registerMsg(obj) {
	$("#error_msg").html('');
	var code=$("#code").val();
	if(code == '' || code.length != 4){
		$("#error_msg").html('请正确输入随机验证码!');
		return false;
	}
	var mobile=$("#mobile").val();
	if(isNaN(mobile) != false || mobile.length != 11){
		$("#error_msg").html('请正确输入手机号码!');
		return false;
	}
	var  u='/index.php/user/registerMsg';
	var  d='code='+code+'&mobile='+mobile;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){
			$(obj).val('已发送');
			upcode();
		}
		if(request_fall == response['status']){
			$("#error_msg").html('');
			$("#error_msg").html(response['msg']);
		}
		if( request_url == response['status']){
			$("#error_msg").html('');
			$("#error_msg").html(response['msg']);
			setTimeout('regurl()',3000);
		}
	}
	AjaxRequest(u,d,f);
}
function regurl(){
	UrlGoto('/index.php/user/login');
}
function regiter(){
	$("#error_msg").html('');
	var code=$("#code").val();
	if(code == '' || code.length != 4){
		$("#error_msg").html('请正确输入随机验证码!');
		return false;
	}
	var mobile=$("#mobile").val();
	if(isNaN(mobile) != false || mobile.length != 11){
		$("#error_msg").html('请正确输入注册手机号码!');
		return false;
	}
	var verify=$("#verify").val();
	if(isNaN(verify) != false || verify.length != 6){
		$("#error_msg").html('请正确输入短信验证码!');
		return false;
	}
	var pwd=$("#pwd").val();
	if(pwd == false || pwd.length <= 6){
		$("#error_msg").html('密码不能少于6位!');
		return false;
	}
	var  u='/index.php/user/mRegister';
	var  d='mobile='+mobile+'&verify='+verify+'&code='+code+'&pwd='+pwd;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){
			if(typeof(response['url']) !='undefined' && response['url'] !=''){
				UrlGoto(response['url']);
			}
		}
		if(request_fall == response['status']){
				upimg();
				$("#error_msg").val('');
				$("#error_msg").html(response['msg']);
			
		}
	}
	AjaxRequest(u,d,f);
}
function online() {
	var  address=window.location.pathname; 
	var  u='/index.php/user/isOnline';
	var  d='address='+address;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){
			if(typeof(response['url']) !='undefined' && response['url'] !=''){
				UrlGoto(response['url']);
			}
		}
		if(request_fall == response['status']){
			if(typeof(response['url']) !='undefined' && response['url'] !=''){
				UrlGoto(response['url']);
			}
			if(response['data']['code'] == 1){
				upimg();
				$("#login_code").css('display','block');
				$(".seat").css("display","none");
				$("#loginmsg").html(response['msg']);
			}
		}
	};
	AjaxRequest(u,d,f);
}
function verifyback(obj){
	var code=$("#b_code").val();
	if(code == '' || code.length < 4){
		$("#error_msg").html('验证码不正确!');
		return false;
	}	
	var mobile=$("#b_mobile").val();
	if(isNaN(mobile) != false || mobile.length != 11){
		$("#error_msg").html('请正确输入手机号码!');
		return false;
	}	
	var  u='/index.php/user/backverify';
	var  d='code='+code+'&mobile='+mobile;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){
			 	$(obj).val('已发送');
		}
		if(request_fall == response['status']){	
			$("#error_msg").html(response['msg']);
			return  false;
		}
	};
	AjaxRequest(u,d,f);
	
}
function pwdback(){
	var code=$("#b_code").val();
	if(code == '' || code.length < 4){
		$("#error_msg").html('验证码不正确!');
		return false;
	}	
	var mobile=$("#b_mobile").val();
	if(isNaN(mobile) != false || mobile.length != 11){
		$("#error_msg").html('请正确输入注册手机号码!');
		return false;
	}	
	var verify=$("#b_check").val();
	if(isNaN(verify) != false || verify.length != 6){
		$("#error_msg").html('请正确输入短信验证码!');
		return false;
	}
	var  u='/index.php/user/upcheck';
	var  d='code='+code+'&mobile='+mobile+'&verify='+verify;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){
			 	$(".identity").hide();
			    $(".change").show();
			    $(".line.fir").addClass("active");
			    $(".circle.sum1").addClass("active");
			    $("#error_msg").html('');
		}
		if(request_fall == response['status']){	
			$("#error_msg").html(response['msg']);
			return  false;
		}
	};
	AjaxRequest(u,d,f);
}
function uppwd(){
	var pwd1=$("#pwd1").val();
	if(pwd1 == '' || pwd1.length <= 6){
		$("#error_msg").html('密码长度少于6');
		return false;
	}	
	var pwd2=$("#pwd2").val();
	if(pwd2 == '' || pwd2.length <= 6){
		$("#error_msg").html('密码长度少于6');
		return false;
	}
	if(pwd2 != pwd1){
		$("#error_msg").html('输入的密次不一致');
		return false;
	}
	var  u='/index.php/user/uppwd';
	var  d='pwd1='+pwd1+'&pwd2='+pwd2;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){
			$(".change").hide();
	        $(".fulfil").show();
	        $(".line.send").addClass("active");
	        $(".circle.sum2").addClass("active");
	        $("#error_msg").html(response['msg']);
		}
		if(request_fall == response['status']){	
			$("#error_msg").html(response['msg']);
			return  false;
		}
	};
	AjaxRequest(u,d,f);
	
}
