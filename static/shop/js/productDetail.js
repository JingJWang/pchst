// header();
// footer();

 //显示全部分类
 $('.general').hover(function () {
 $(".classList").show();
 }, function () {
 $(".classList").hide();
 });

//切换图片
$(".refer .graph").hover(function(){
    $(".graph.active").removeClass("active");
    $(this).addClass("active");
    var pic = $(this).find("img").attr("src");
    $(".preview img").attr("src" , pic);
});

//查看全部图片
$(".check").click(function(){
    var sn = parseInt($(".photoShow").height());
    if(sn == 1194 ){
        $(this).addClass("active");
        $(".photoShow").css("height" , "auto");
    }else{
        $(this).removeClass("active");
        $(".photoShow").css("height" , "1194px");
    }
});
