//进入首页面获取相关信息
$(document).ready(function() {
	var ustart ='';
	var uend = '';
	var userSum = $("#userSum").html();
	 $("#ustart").change(function(){ 
		 ustart = $("#ustart").html();
	 });
	 $("#uend").on("change",function(){ 
		 uend = $("#uend").html();
	 });
	var u = '/index.php/trans/trans/userSum';
	var d = 'ustart='+ustart+'&uend='+uend;
	var f=function(res){
		var response=eval(res);
		if(response['status'] == request_succ){
			userSum === response['data'][0]['id'];
		}
	}
	AjaxRequest(u, d, f);
});
//显示回收数据
function getComm(id){
	var hstart ='';
	var hend = '';
	 $("#hstart").change(function(){ 
		 hstart = $("#hstart").html();
	 });
	 $("#hend").on("change",function(){ 
		 hend = $("#hend").html();
	 });
	var u = '/trans/trans/selectList';
	var d = 'stime='+hstart+'&etime='+hend+'&type=1&page='+id;
	var f = function(res){
		var response=eval(res);
		if(response['status'] == request_succ){
			var jlist='';
			//总计利润
			var count='';
			//总计单数
			var order=0;
				if(response['data']['list']!=''){
					  $.each(response['data']['list'],function(n,list){
							 //显示寄售信息
							 jlist =jlist+'<div class="dimension">'+
		                         '<div class="serial fl">'+list['rid']+'</div>'+
		                         '<div class="orderNumber fl">'+list['oid']+'</div>'+
		                         '<div class="name fl">'+list['gname']+'</div>'+
		                         '<div class="price fl">'+list['trans']+'元</div>'+
		                         '<div class="times fl">'+$.myTime.UnixToDate(list['otime'])+'</div></div>';
					  });
				}else{
					 jlist +='<div class="dimension">暂无数据</div>';
					 $(".recovery .pagination").css("display","none");
				 }
			count = response['data']['count'][0]['rsum'];
			order = response['data']['count'][0]['rid'];
			$("#sumMoney").html(count+'元');
			$("#sumOrder").html(order+'单');
			$(".recovery .recoverList").html(jlist);
			//$(".recovery .pagination").html(response['data']['page']);
			 //下面是分页
	        var one_pag = 10;
	        var page='';
	        var now = Number(response['data']['now']);//当前开始数字
	        var num = response['data']['num'];//总条数
	        if( num > 1){
	        	for(var i=1;i<=num;i++){
	        		if(id==i){
	        			page = page + '<a class="figure dig" onclick="getComm('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
	        		}else{
						page = page + '<a class="figure" onclick="getComm('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
					}
	        	}
	        	page = page +'<a class="figure" onclick="nextpage();" href="javascript:;">下一页</a>&nbsp;'+
				 '&nbsp;<a class="figure" id="total" data-val="'+num+'" href="javascript:;">共'+num+'页</a>&nbsp;';
	        }else{
				page='<a class="figure dig" onclick="getComm(1)" href="javascript:;">1</a>';
			}
	        $(".recovery .pagination").html(page);
		}
	}
	AjaxRequest(u, d, f);
}
/******分页********/
function nextpage(){
	var page=$(".dig").html();
	var total=$("#total").attr('data-val');
	if(page >= total){
		alert('当前已经是最后一页!');
	}else{
		page = Number(page) + 1; 
		getRecover(page);
		getRecoverMobile(page);
	}
}