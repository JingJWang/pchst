var Trans={
	//显示用户数量信息
	userData:function(){
		$(".agentNumber,.recovery,.consignment,.market,.brokerage").hide();
		$(".userNumber").show();
		var userSum = '';
		var data=$("#userChose").serialize();
		var u = '/index.php/trans/trans/userSum';
		var d = data;
		var f=function(res){
			var response=eval(res);
			if(response['status'] == request_succ){
				if(response['data']!=''){
					list=' <div class="cue">'+response['data']['name']+'推广情况统计</div>';
					$('#userSum').html(response['data']['count']);
		            $('.record .hint').html(list);
				}
			}
		}
		AjaxRequest(u, d, f);
	},
	//显示代理数据信息
	agent:function(id){
	    $(".userNumber, .recovery, .consignment, .market, .brokerage").hide();
		$(".agentNumber").show();
		var data=$("#agentChose").serialize();
		var u = '/trans/trans/agentList';
		var d = data+'&type=1&page='+id;
		var tag = '';
		var div = '';
		var list ='';
		var person = 0;
		var f=function(res){
			var response=eval(res);
			if(response['status'] == request_succ){
				if(response['data']['list'] !=null){
					$.each(response['data']['list'],function(n,k){
						tag=response['data']['tag'];
						switch(k['status']){
							case '1':
								div = '<div class="handle fl"><input class="frozen fl" id =v'+k['id']+' type="button" value="冻结" onclick="handle('+k['id']+','+tag+')"/></div>';
							break;
							case '0':
								div = '<div class="handle fl"><input class="frozen fl disable" type="button" value="已冻结"/></div>';
							break;
						}
						list +='<div class="dimension">'+
		                    '<div class="serial fl">'+k['id']+'<input type="hidden" id="tag" value='+response['data']['tag']+'></div>'+
		                    '<div class="phone fl">'+k['name']+'</div>'+
		                    '<div class="times fl">'+$.myTime.UnixToDate(k['jointime'])+'</div>'+
		                    '<div class="amount fl">'+k['pid']+'人</div>'+
		                    '<div class="price fl">'+Math.floor(k['countsum']*100)/100+'元</div>'+
		                    '<div class="settle fl"><a class="cash" href="javascript:;" onclick="Trans.comm(1,'+k['name']+','+Math.floor(k['countsum']*100)/100+')">结算详情</a></div>'+div+
		                    /*'<div class="check fl"><a  class="look" href="javascript:;" onclick="Trans.look('+k['id']+','+k['tag']+')">查看详情</a></div>'+div+*/
		                    '</div>';
					});
				}else{
					 list ='<div class="dimension" style="text-align:center">暂无数据</div>';
					 $(".agentNumber .pagination").css("display","none");
				}
				
				if(response['data']['count']!=null){
					person = response['data']['count'];
				}else{
					person = 0 ;
				}
				$(".agentNumber .sum").html(person+'人');
				$(".agentNumber .listing").html(list);
			}
			 //下面是分页
		        var page='';
		        var num = response['data']['num'];//总页数
		        if( num > 1){
		        	for(var i=1;i<=num;i++){
		        		if(id==i){
		        			page = page + '<a class="figure dig" onclick="Trans.agent('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
		        		}else{
		        			if(id>1){
		        				page = '<a class="figure" onclick="lastpage('+(i)+',1);" href="javascript:;">上一页</a>&nbsp;'+ page + '<a class="figure" onclick="Trans.agent('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
		        			}else{ 
		        				page = page + '<a class="figure" onclick="Trans.agent('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
		        			} 
						}
		        	}
		        	page = page +'<a class="figure" onclick="nextpage('+(i-1)+',1);" href="javascript:;">下一页</a>&nbsp;'+
					 '&nbsp;<a class="figure" id="total" data-val="'+num+'" href="javascript:;">共'+num+'页</a>&nbsp;';
		        }else{
					page='<a class="figure dig" onclick="Trans.agent(1)" href="javascript:;">1</a>';
				}
		        $(".agentNumber .pagination").html(page);
		}
		AjaxRequest(u, d, f);
	},
	//显示回收信息
	recover:function(id){
		$(".userNumber, .agentNumber, .consignment, .market, .brokerage").hide();
		$(".recovery").show();
		var data=$("#recoverChose").serialize();
		var u = '/trans/trans/selectList';
		var d = data+'&type=1&page='+id;
		var f = function(res){
			var response=eval(res);
			if(response['status'] == request_succ){
				var jlist='';
				//总计利润
				var count='';
				//总计单数
				var order=0;
				//推广员角色的分成比例
				var trans='';
				//推广员的分成比例
					if(response['data']['list']!=''){
						  $.each(response['data']['list'],function(n,list){
							  switch(response['data']['tag']){
								  case '1': 
									  	trans = list['csum']; 
									  	break;
								  case '2': 
									  	trans = list['csum']*list['tportion']/100;
									  	break;
								  case '3': 
									  	trans = list['csum']*list['tprotion']/100*list['pprotion']/100; 
							  }
								 jlist =jlist+'<div class="dimension">'+
			                         '<div class="serial fl">'+list['rid']+'</div>'+
			                         '<div class="orderNumber fl">'+list['oid']+'</div>'+
			                         '<div class="name fl">'+list['gname']+'</div>'+
			                         '<div class="price fl">'+Math.floor(trans*100)/100+'元</div>'+
			                         '<div class="times fl">'+$.myTime.UnixToDate(list['otime'])+'</div></div>';
						  });
					}else{
						 jlist +='<div class="dimension" style="text-align:center">暂无数据</div>';
						 $(".recovery .pagination").css("display","none");
					 }
				count = Math.floor(response['data']['count'][0]['sum']*100)/100;
				order = response['data']['count'][0]['id'];
				$("#sumMoney").html(count+'元');
				$("#sumOrder").html(order+'单');
				$(".recovery .recoverList").html(jlist);
				 //下面是分页
		        var page='';
		        var num = response['data']['num'];//总页数
		        if( num > 1){
		        	for(var i=1;i<=num;i++){
		        		if(id==i){
		        			page = page + '<a class="figure dig" onclick="Trans.recover('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
		        		}else{
							if(id>1){
		        				page = '<a class="figure" onclick="lastpage('+(i)+',2);" href="javascript:;">上一页</a>&nbsp;'+ page + '<a class="figure" onclick="Trans.agent('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
		        			}else{ 
		        				page = page + '<a class="figure" onclick="Trans.recover('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
		        			} 
						}
		        	}
		        	page = page +'<a class="figure" onclick="nextpage('+(i-1)+',2);" href="javascript:;">下一页</a>&nbsp;'+
					 '&nbsp;<a class="figure" id="total" data-val="'+num+'" href="javascript:;">共'+num+'页</a>&nbsp;';
		        }else{
					page='<a class="figure dig" onclick="Trans.recover(1)" href="javascript:;">1</a>';
				}
		        $(".recovery .pagination").html(page);
			}
		}
		AjaxRequest(u, d, f);
	},
	//显示寄售信息
	consign:function(id){
		 $(".userNumber, .recovery, .agentNumber, .market, .brokerage").hide();
		 $(".consignment").show();
		var data=$("#consignChose").serialize();
		var u = '/index.php/trans/trans/selectList';
		var d = data+'&type=3&page='+id;
		var f=function(res){
			var response=eval(res);
			if(response['status'] == request_succ){
				var jlist='';
				//总计利润
				var count='';
				//总计单数
				var order=0;
				//利润
				var trans='';
				if(response['data']['list']!=''){
					  $.each(response['data']['list'],function(n,list){
						  switch(response['data']['tag']){
						  case '1': 
							  	trans = list['csum']; 
							  	break;
						  case '2': 
							  	trans = list['csum']*list['tprotion']/10;
							  	break;
						  case '3': 
							  	trans = list['csum']*list['tprotion']/10*list['pprotion']/10; 
						  }
						 jlist +='<div class="dimension">'+
	                         '<div class="serial fl">'+list['rid']+'</div>'+
	                         '<div class="orderNumber fl">'+list['oid']+'</div>'+
	                         '<div class="name fl">'+list['gname']+'</div>'+
	                         '<div class="price fl">'+Math.floor(trans*100)/100+'元</div>'+
	                         '<div class="times fl">'+$.myTime.UnixToDate(list['otime'])+'</div></div>';
					  });				 
				}else{
						 jlist +='<div class="dimension" style="text-align:center">暂无数据</div>';
						 $(".consignment .pagination").css("display","none");
				}
				count = Math.floor(response['data']['count'][0]['sum']*100)/100;
				order = response['data']['count'][0]['id'];
				$(".consignment #sumMoney").html(count+'元');
				$(".consignment #sumOrder").html(order+'单');
				$(".consignment .consignList").html(jlist);
			}
			 //下面是分页
	        var page='';
	        var num = response['data']['num'];//总页数
	        if( num > 1){
	        	for(var i=1;i<=num;i++){
	        		if(id==i){
	        			page = page + '<a class="figure dig" onclick="Trans.consign('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
	        		}else{
						if(id>1){
	        				page = '<a class="figure" onclick="lastpage('+(i)+',3);" href="javascript:;">上一页</a>&nbsp;'+ page + '<a class="figure" onclick="Trans.agent('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
	        			}else{ 
	        				page = page + '<a class="figure" onclick="Trans.consign('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
	        			} 
					}
	        	}
	        	page = page +'<a class="figure" onclick="nextpage('+(i-1)+',3);" href="javascript:;">下一页</a>&nbsp;'+
				 '&nbsp;<a class="figure" id="total" data-val="'+num+'" href="javascript:;">共'+num+'页</a>&nbsp;';
	        }else{
				page='<a class="figure dig" onclick="Trans.consign(1)" href="javascript:;">1</a>';
			}
	        $(".consignment .pagination").html(page);
		}
		AjaxRequest(u,d,f);
	},
	//显示销售信息
	sale:function(id){
		$(".userNumber, .agentNumber, .consignment, .recovery, .brokerage").hide();
		$(".market").show();
		var data=$("#saleChose").serialize();
		var u = '/index.php/trans/trans/selectList';
		var d = data+'&type=2&page='+id;
		var f=function(res){
			var response=eval(res);
			if(response['status'] == request_succ){
				var jlist='';
				//总计利润
				var count='';
				var type = '';
				//总计单数
				var order=0;
				//角色的分成比例
				var trans='';
				if(response['data']['list']!=''){
					 $.each(response['data']['list'],function(n,list){
						 switch(response['data']['tag']){
						  case '1': 
							  	trans = list['csum']; 
							  	break;
						  case '2': 
							  	trans = list['csum']*list['tprotion']/10;
							  	break;
						  case '3': 
							  	trans = list['csum']*list['tprotion']/10*list['pprotion']/10; 
							  	break;
						  }
						 switch(list['rtype']){
						 	case '21':
						 		type ='数码产品';break;
						 	case '22':
						 		type ='奢侈品';break;
						 	case '23':
						 		type ='其他';break;							 
						 }
						 //显示寄售信息
						 jlist +='<div class="dimension">'+
	                         '<div class="digit fl">'+list['rid']+'</div>'+
	                         '<div class="number fl">'+list['oid']+'</div>'+
	                         '<div class="trade fl">'+list['gname']+'</div>'+
	                         '<div class="mode fl">'+type+'</div>'+
	                         '<div class="profit fl">'+Math.floor(trans*100)/100+'元</div>'+
	                         '<div class="deal fl">'+$.myTime.UnixToDate(list['otime'])+'</div></div>';
						 
					 });
				}else{
					 jlist +='<div class="dimension"><p style="text-align:center">暂无数据</p></div>';
					 $(".market .pagination").css("display","none");
				}
				count = Math.floor(response['data']['count'][0]['sum']*100)/100;
				order = response['data']['count'][0]['id'];
				$(".market #sumMoney").html(count+'元');
				$(".market #sumOrder").html(order+'单');
			    $(".market .salesList").html(jlist);
			}
			 //下面是分页
	        var page='';
	        var num = response['data']['num'];//总页数
	        if( num > 1){
	        	for(var i=1;i<=num;i++){
	        		if(id==i){
	        			page = page + '<a class="figure dig" onclick="Trans.sale('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
	        		}else{
						if(id>1){
	        				page = '<a class="figure" onclick="lastpage('+(i)+',4);" href="javascript:;">上一页</a>&nbsp;'+ page + '<a class="figure" onclick="Trans.agent('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
	        			}else{ 
	        				page = page + '<a class="figure" onclick="Trans.sale('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
	        			} 
					}
	        	}
	        	page = page +'<a class="figure" onclick="nextpage('+(i-1)+',4);" href="javascript:;">下一页</a>&nbsp;'+
				 '&nbsp;<a class="figure" id="total" data-val="'+num+'" href="javascript:;">共'+num+'页</a>&nbsp;';
	        }else{
				page='<a class="figure dig" onclick="Trans.sale(1)" href="javascript:;">1</a>';
			}
	        $(".market .pagination").html(page);
		}
		AjaxRequest(u, d, f);
	},
	//显示佣金
	commision:function(id,name,money){
		$(".userNumber, .recovery, .consignment, .market, .agentNumber").hide();
		$(".brokerage").show();
		var list ='';
		var u = '/index.php/trans/trans/commList';
		var d = 'page='+id+'&phone='+name;
		//已结算佣金
		var count = '';
		//判定佣金结算模块是否显示
		if(name!=0){
			$(".motif .count").css("display","block");
		}else{
			$(".motif .count").css("display","none");
		}
		//判定获取的佣金是否有值
		var f=function(res){
			var response=eval(res);
			if(response['status'] == request_succ){
				//获取佣金总额
				 if(name!=0){
					 money = money;
				 }else{
					 money = response['data']['money'];
				 }
				if(response['data']['list']!=''){
					$.each(response['data']['list'],function(n,k){
						list+= '<div class="dimension">'+
	                            '<div class="dig fl">'+k['sid']+'<input type="hidden" id="name" value="'+name+'"></div>'+
	                            '<div class="while fl">'+$.myTime.UnixToDate(k['jtime'])+'</div>'+
	                            '<div class="counts fl">￥'+k['rmoney']+'</div>'+
	                            '<div class="money fl">￥'+k['smoney']+'</div></div>';
					});
				}else{
					 list +='<div class="dimension" style="text-align:center">暂无数据<input type="hidden" id="name" value="'+name+'"></div>';
					 $(".brokerage .pagination").css("display","none");
				}
				count =Math.floor(response['data']['count'][0]['rmoney']*100)/100;
				 if(count == '' || count ==null ){
					 count = 0;
				 }
				 $("#money").html(money);
				 $("#rmoney").html(count);
				 $(".brokerage .commissionList").html(list);
			}
			 //下面是分页
		        var page='';
		        var num = response['data']['num'];//总页数
		        if( num > 1){
		        	for(var i=1;i<=num;i++){
		        		if(id==i){
		        			page = page + '<a class="figure dig" onclick="Trans.commision('+i+',0,0)" href="javascript:;">'+i+'</a>&nbsp;';
		        		}else{
							if(id>1){
		        				page = '<a class="figure" onclick="lastpage('+(i)+',5);" href="javascript:;">上一页</a>&nbsp;'+ page + '<a class="figure" onclick="Trans.agent('+i+')" href="javascript:;">'+i+'</a>&nbsp;';
		        			}else{ 
		        				page = page + '<a class="figure" onclick="Trans.commision('+i+',0,0)" href="javascript:;">'+i+'</a>&nbsp;';
		        			} 
						}
		        	}
		        	page = page +'<a class="figure" onclick="nextpage('+(i-1)+',5);" href="javascript:;">下一页</a>&nbsp;'+
					 '&nbsp;<a class="figure" id="total" data-val="'+num+'" href="javascript:;">共'+num+'页</a>&nbsp;';
		        }else{
					page='<a class="figure dig" onclick="Trans.commision(1,0,0)" href="javascript:;">1</a>';
				}
		        $(".brokerage .pagination").html(page);
		        //UrlGoto(response['url']);
		}
		AjaxRequest(u, d, f);
	},
	//代理数量的查看详情
	look:function(id,tag){
		Trans.userData();
	},
	//代理数量模块的代理详情
	comm:function(id,name,money){
		$(".palette.active").removeClass("active");
	    $("#commision").addClass("active");
		Trans.commision(id,name,money);
	},
	//佣金模块的佣金结算
	count:function(name,money,rmoney){
		 $(".shade , .settlement").show();
	    //确认
	    $(".ensure").click(function(){
	        $(".shade , .settlement").hide();
	    });
	    $(".abolish").click(function(){
	        $(".shade , .settlement").hide();
	    })
	    name = $('#name').val();
	    money = $('#money').html();
	    rmoney = $('#rmoney').html();
	    var lastMoney = $('#lastMoney').html();
	    if(money>=rmoney){
	    	lastMoney=money-rmoney;
	    }else{
	    	alert("当前剩余佣金余额不足以结算");
	    	$(".shade , .settlement").hide();
	    }
	    $('#lastMoney').html(Math.round(lastMoney*100)/100);
	},
	submit:function(){
		// $('#lastMoney').html(lastMoney);
		 var name = $('#name').val();
		 var lastMoney = $('#lastMoney').html();
		 var sums = $("#sums").val();
		 if(lastMoney<=sums){
			 alert("输入有误,请重新输入");
		 }else{
			 var countmoney=lastMoney-sums;
			 var u = '/index.php/trans/trans/checkOut';
			 var d = 'sums='+sums+'&name='+name+'&lastMoney='+lastMoney;
			 var f = function(res){
				 var response=eval(res);
					if(request_succ == response['status']){
						UrlGoto(response['url']);
						alert("添加成功");
						Trans.commision(1,name,countmoney);
					}
					if(request_fall == response['status']){
						alert(response['msg']);
					}
			 }
			 AjaxRequest(u, d, f);	
		 }
	}
};
Trans.userData();

/******分页********/
function lastpage(i,mark){
	var page=$(".dig").html();
	var total=$("#total").attr('data-val');
	if(page < total){
		alert('当前已经是第一页!');
	}else{
		switch(mark){
			case 2:Trans.recover(i);break;
			case 1:Trans.agent(i);break;
			case 5:Trans.commision(i,0,0);break;
			case 3:Trans.consign(i);break;
			case 4:Trans.sale(i);break;
		}
	}
}
//i分页mark选项卡标识
function nextpage(i,mark){
	var page=$(".dig").html();
	var total=$("#total").attr('data-val');
	if(page >= total){
		alert('当前已经是最后一页!');
	}else{
		switch(mark){
			case 2:Trans.recover(i);break;
			case 1:Trans.agent(i);break;
			case 5:Trans.commision(i,0,0);break;
			case 3:Trans.consign(i);break;
			case 4:Trans.sale(i);break;
		}
	}
}
//冻结该代理账号操作
function handle(id,tag){
	var u = '/index.php/trans/home/gethandle';
	var d = 'id='+id+'&tag='+tag;
	var f = function(res){
		var response=eval(res);
		if(request_succ == response['status']){
			UrlGoto(response['url']);
			$("#v"+id).attr("disabled", true);
		    $("#v"+id).val("已冻结");
		    $("#v"+id).addClass("disable");
		}
	}
	AjaxRequest(u, d, f);
}