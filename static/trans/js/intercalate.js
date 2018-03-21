$(".operate .affirm").click(function(){
    var newpwd = $("#newpwd").val();
    var newspwd = $("#newspwd").val();
    if(newpwd !=newspwd){
    	alert("你输入的新密码不一致，请重新输入");
    }
});

