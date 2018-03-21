/**
 * 
 */
function submit() {
	var id=getUrlParam('id');
	if( false != isNaN(id) ){
		return false;
	}
    var option=$("#attr").serialize();
    if(typeof(option) == "undefined"){
    	return false;
    }
    var  u='/index.php/order/digital/submit';
	var  d='id='+id+"&"+option;
	var  f=function(result){
		var response=eval(result);
		if(request_succ == response['status']){
			if(typeof(response['url']) !='undefined' && response['url'] !=''){
				UrlGoto(response['url']);
			}
		}
		if(request_fall == response['status']){
			if(typeof(response['msg']) !='undefined' && response['msg'] !=''){
				alert(response['msg']);
			}
			if(typeof(response['url']) !='undefined' && response['url'] !=''){
				UrlGoto(response['url']);
			}
		}
	}
	AjaxRequest(u,d,f);    
}