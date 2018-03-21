/**
 * Created by Administrator on 2016/9/1 0001.
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

//切换导航栏
$(".className").click(function(){
    $(".className.active").removeClass("active");
    $(this).addClass("active");
});

//显示全部类型
$(".total").click(function(){
    if($(".categorize").css("display") == "none"){
        $(".categorize").css("display","block");
    }else{
        $(".categorize").css("display","none");
    }
});

//将选中的订单状态显示到上边
$(".sort-name").click(function(){
    $(".categorize").css("display","none");
    $(".total").html($(this).html());
    $(this).siblings(".sort-name.active").removeClass("active");
    $(this).addClass("active");
});

//选择我的订单里的分类
$(".classes").click(function(){
    $(this).siblings(".classes.active").removeClass("active");
    $(this).addClass("active");
});

//切换全部产品
$(".restrain").click(function(){
    $(".restrain.active").removeClass("active");
    $(this).addClass("active");
});

//让手机号中间为*号
function cut(){
    var phone = $('.phone').text();
    var mphone = phone.substr(0, 3) + '****' + phone.substr(7);
    $('.phone').text(mphone);
}
cut();

//点击手机号修改
$(".material.number .modify").click(function(){
    $(".material.active").removeClass("active");
    $(this).parents(".material").addClass("active");
    $(this).parents(".material").siblings().find(".rocky").css("display","none");
    $(".material.code .cancle").css("display","none");
    $(".material.code .modify").css("display","block");
    $(this).css("display","none");
    $(this).siblings(".cancle").css("display","block");
    $(".deviated").css("display","block");
    //点击确认
    $(".affirm").click(function(){
        var tel = $(".pardon.tel").val();
        if(tel != ""){
            //将新手机号码保存到已绑定手机号
            $(".reveal .phone").text(tel);
            $(".deviated").css("display","none");
            $(".material.number.active").removeClass("active");
            $(".material.number .cancle").css("display","none");
            $(".material.number .modify").css("display","block");
        }

    });
    //点击取消修改
    $(".material.number .cancle").click(function(){
        $(".deviated").css("display","none");
        $(".material.number.active").removeClass("active");
        $(".material.number .cancle").css("display","none");
        $(".material.number .modify").css("display","block");
    })

});

//点击密码修改
$(".material.code .modify").click(function(){
    $(".material.active").removeClass("active");
    $(this).parents(".material").addClass("active");
    $(this).parents(".material").siblings().find(".deviated").css("display","none");
    $(".material.number .cancle").css("display","none");
    $(".material.number .modify").css("display","block");
    $(this).css("display","none");
    $(this).siblings(".cancle").css("display","block");
    $(".rocky").css("display","block");
    //点击保存
    $(".conserve").click(function(){
        //省略存储数据
        $(".rocky").css("display","none");
        $(".material.code.active").removeClass("active");
        $(".material.code .cancle").css("display","none");
        $(".material.code .modify").css("display","block");
    });
    //点击取消修改
    $(".material.code .cancle").click(function(){
        $(".rocky").css("display","none");
        $(".material.code.active").removeClass("active");
        $(".material.code .cancle").css("display","none");
        $(".material.code .modify").css("display","block");
    })
});


//点击输入框输入框里的文字变颜色
$(document).ready(function(){
    $("input").focus(function(){
        $(".entry").css("color","#666666");
    });
});