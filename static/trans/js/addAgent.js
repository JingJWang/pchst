$(".handle .sure").click(function(){
    var num = $(".phone").val();
    var pro = $("#proportion").val();
    if(num == ""){
        alert("手机号不能为空");
    }else if( num.match(/^(1[3|4|5|7|8][0-9]{9})$/) ){
        $(".shade , .circle").show();
        $(".text .number").html(num);
        $("#words").html(pro+'%');
        //确认添加
        $(".ensure").click(function(){
            $(".shade , .circle").hide();
        });
        //取消
        $(".abolish").click(function(){
            $(".shade , .circle").hide();
        })
    }else{
        alert("请输入正确的手机号码");
    }
});
