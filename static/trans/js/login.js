$(".login-btn").click(function(){
    var name = $("#username").val();
    var code = $("#psd").val();
    if(name == ""){
        alert("用户名不能为空");
    }else if(code == ""){
        alert("密码不能为空");
    }
});
