//登录页面验证
$(document).on('click', '.login a', function() {
	var name = $('#username').val();
	var pwd = $('#psd').val();
	var u = '/index.php/trans/login/loginin';
	var d = 'name='+name+'&pwd='+pwd;
	var f=function(res){
		var response=eval(res);
		if(request_succ == response['status']){
			UrlGoto(response['url']);
		}
		if(request_fall == response['status']){
			alert(response['msg']);
		}
	}
	AjaxRequest(u, d, f);
});
//修改密码
$(document).on('click', '.operate .affirm', function() {
	var newpwd = $('#newpwd').val();
	var tag = $('#tag').val();
	var u = '/index.php/trans/login/modifyPwd';
	var d = 'newpwd='+newpwd+'&tag='+tag;
	var f=function(res){
		var response=eval(res);
		if(request_succ == response['status']){
			UrlGoto(response['url']);
			alert("修改成功");
		}
		if(request_fall == response['status']){
			alert(response['msg']);
		}
	}
	AjaxRequest(u, d, f);
});