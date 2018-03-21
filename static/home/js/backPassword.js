/**
 * Created by Administrator on 2016/9/2 0002.
 */
//滚动条事件，当滚动条滚动时为导航栏添加样式
window.onscroll = function () {
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if (t > 0) {
        $(".navigation").addClass("active");
    } else {
        $(".navigation").removeClass("active");
    }
};

//验证身份确认
/**
$(".identity .affirm").click(function(){
    $(".identity").hide();
    $(".change").show();
    $(".line.fir").addClass("active");
    $(".circle.sum1").addClass("active");
    //修改密码确认
    $(".change .affirm").click(function(){
        $(".change").hide();
        $(".fulfil").show();
        $(".line.send").addClass("active");
        $(".circle.sum2").addClass("active");
    });
});**/

//判断手机号码是否输入正确 获取验证码显示黄色
//表单验证--手机号
$("#b_mobile").blur(function(){
    if ($(this).val().match(/^(1[3|4|5|7|8][0-9]{9})$/)) // /^(((13[0-9]{1})|159|153)+\d{8})$/
    {
        $('.getCode').addClass("active");
        return true;
    }else
    {
        $('#error_msg').html("提示： 请输入正确的手机号码");
        $('.getCode').removeClass("active");
        return false;
    }
});
//判断验证码的位数
$("#b_check").blur(function(){
    var length = $(this).val().length;
    if(length!==6){
        $('#error_msg').html("提示： 请输入正确的验证码");
    }else{
        $('.error_msg').html("");
    }
});
//判断图形验证码
$("#b_code").blur(function(){
    var length = $(this).val().length;
    if(length!==4){
        $('#error_msg').html("提示： 请输入正确的图形验证码");
    }else{
        $('.error_msg').html("");
    }
});

