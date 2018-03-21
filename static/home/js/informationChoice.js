/**
 * Created by Administrator on 2016/8/22 0022.
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

//点击选项
$(".parameter").click(function(){
    //判断选项是否是第一个
    if($(this).parents(".assortment").hasClass("first")){
        $(".parameter.active").removeClass("active");
        $(this).siblings().find(".pitch").css("display","none");
        $(this).addClass("active");
        $(".parameter.active").find(".pitch").css("display","block");
        $(this).parents(".assortment").find(".name").val($(this).find("span").text());
        $(this).parents(".assortment").find(".option").val($(this).find("span").attr('data-id'));
        $(this).parents(".choice").hide(200);
        $(this).parents(".assortment").find(".modify").show(200);
        $(this).parents(".assortment").find(".raise").addClass("active");
        $(this).parents(".assortment").addClass("active");
    }
    //判断当前选项的上一个是否选择过
    if($(this).parents(".assortment").prev().hasClass("active")){
        $(".parameter.active").removeClass("active");
        $(this).siblings().find(".pitch").css("display","none");
        $(this).addClass("active");
        $(".parameter.active").find(".pitch").css("display","block");
        $(this).parents(".assortment").find(".name").val($(this).find("span").text());
        $(this).parents(".assortment").find(".option").val($(this).find("span").attr('data-id'));
        $(this).parents(".choice").hide(200);
        $(this).parents(".assortment").find(".modify").show(200);
        $(this).parents(".assortment").find(".raise").addClass("active");
        $(this).parents(".assortment").addClass("active");
    }else{
        return false;
    }
});
//点击修改
$(".modify").click(function(){
    $(this).parents(".assortment").find(".choice").show(200);
    $(this).hide(200);
    $(this).parents(".raise").removeClass("active");
    $(this).parents(".raise").find(".name").val("");
});
//多选
$(".select-box").click(function(){
    if($(this).hasClass("active")){
        $(this).removeClass("active");
        var id=$(this).attr('data-id');
        var content=$("#other").val();
        $("#other").val(content.replace('['+id+'],',''));        
    }else{
        $(this).addClass("active");
        var id=$(this).attr('data-id');
        var content=$("#other").val();
        if(content == ''){
        	$("#other").val('['+id+'],');
        }else{
        	content=content+'['+id+'],';
        	$("#other").val(content)
        }
    }
});
