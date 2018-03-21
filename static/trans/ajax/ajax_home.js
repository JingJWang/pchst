//总代和二级代理进入系统验证
var homeenter={
		submit:function(){
			var data=$("#homeenter").serialize();
			var u = '/index.php/trans/home/loginin';
			var d = data;
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
		}
};
//添加代理
var operater={
		submit:function(){
			var data = $("#substance").serialize();
			var u = '/index.php/trans/home/saveAgent';
			var d = data;
			var f = function(res){
				var response=eval(res);
				if(request_succ == response['status']){
					UrlGoto(response['url']);
					alert("添加成功");
				}else{
					alert(response['msg']);
				}
			}
			AjaxRequest(u, d, f);
		}
}